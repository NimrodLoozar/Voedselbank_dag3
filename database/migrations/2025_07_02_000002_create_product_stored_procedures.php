<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Migration voor het aanmaken van stored procedures voor product functionaliteit
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Stored procedure voor het registreren van nieuwe producten
        DB::unprepared('
            DROP PROCEDURE IF EXISTS RegisterNewProduct;
            CREATE PROCEDURE RegisterNewProduct(
                IN p_product_id INT,
                IN p_product_naam VARCHAR(255),
                IN p_categorie_id INT
            )
            BEGIN
                DECLARE v_categorie_naam VARCHAR(255);
                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    ROLLBACK;
                    RESIGNAL;
                END;

                START TRANSACTION;

                -- Haal categorie naam op
                SELECT naam INTO v_categorie_naam
                FROM categories
                WHERE id = p_categorie_id;

                -- Log de registratie
                INSERT INTO product_logs (product_id, actie, datum, details)
                VALUES (p_product_id, "REGISTER", NOW(), 
                        CONCAT("Product geregistreerd in categorie: ", v_categorie_naam));

                -- Update product statistieken
                INSERT INTO product_statistics (categorie_id, total_products, last_updated)
                VALUES (p_categorie_id, 1, NOW())
                ON DUPLICATE KEY UPDATE
                    total_products = total_products + 1,
                    last_updated = NOW();

                COMMIT;
            END
        ');

        // Stored procedure voor inventory overview met joins
        DB::unprepared('
            DROP PROCEDURE IF EXISTS GetInventoryOverview;
            CREATE PROCEDURE GetInventoryOverview(
                IN p_categorie_id INT
            )
            BEGIN
                IF p_categorie_id IS NULL OR p_categorie_id = 0 THEN
                    -- Alle producten met voorraad info
                    SELECT 
                        p.id,
                        p.naam as product_naam,
                        p.barcode,
                        p.houdbaarheidsdatum,
                        p.status,
                        c.naam as categorie_naam,
                        SUM(m.aantal) as totaal_voorraad,
                        COUNT(DISTINCT pm.magazijn_id) as aantal_magazijnen,
                        GROUP_CONCAT(DISTINCT pm.locatie) as locaties,
                        MIN(m.ontvangstdatum) as eerste_ontvangst,
                        MAX(m.uitleveringsdatum) as laatste_uitlevering
                    FROM producten p
                    INNER JOIN categories c ON p.categorie_id = c.id
                    LEFT JOIN product_per_magazijn pm ON p.id = pm.product_id
                    LEFT JOIN magazijnen m ON pm.magazijn_id = m.id
                    WHERE p.deleted_at IS NULL
                    GROUP BY p.id, c.naam
                    ORDER BY p.naam;
                ELSE
                    -- Gefilterd op specifieke categorie
                    SELECT 
                        p.id,
                        p.naam as product_naam,
                        p.barcode,
                        p.houdbaarheidsdatum,
                        p.status,
                        c.naam as categorie_naam,
                        SUM(m.aantal) as totaal_voorraad,
                        COUNT(DISTINCT pm.magazijn_id) as aantal_magazijnen,
                        GROUP_CONCAT(DISTINCT pm.locatie) as locaties,
                        MIN(m.ontvangstdatum) as eerste_ontvangst,
                        MAX(m.uitleveringsdatum) as laatste_uitlevering
                    FROM producten p
                    INNER JOIN categories c ON p.categorie_id = c.id
                    LEFT JOIN product_per_magazijn pm ON p.id = pm.product_id
                    LEFT JOIN magazijnen m ON pm.magazijn_id = m.id
                    WHERE p.deleted_at IS NULL AND p.categorie_id = p_categorie_id
                    GROUP BY p.id, c.naam
                    ORDER BY p.naam;
                END IF;
            END
        ');

        // Stored procedure voor het bijwerken van product voorraad
        DB::unprepared('
            DROP PROCEDURE IF EXISTS UpdateProductInventory;
            CREATE PROCEDURE UpdateProductInventory(
                IN p_product_id INT,
                IN p_magazijn_id INT,
                IN p_aantal_uitgeleverd INT,
                IN p_nieuwe_locatie VARCHAR(255),
                IN p_uitleveringsdatum DATE
            )
            BEGIN
                DECLARE v_huidig_aantal INT DEFAULT 0;
                DECLARE v_nieuw_aantal INT DEFAULT 0;
                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    ROLLBACK;
                    RESIGNAL;
                END;

                START TRANSACTION;

                -- Haal huidige voorraad op
                SELECT aantal INTO v_huidig_aantal
                FROM magazijnen
                WHERE id = p_magazijn_id;

                -- Controleer of er genoeg voorraad is
                IF p_aantal_uitgeleverd > v_huidig_aantal THEN
                    SIGNAL SQLSTATE "45000" 
                    SET MESSAGE_TEXT = "Onvoldoende voorraad voor uitlevering";
                END IF;

                -- Bereken nieuwe voorraad
                SET v_nieuw_aantal = v_huidig_aantal - p_aantal_uitgeleverd;

                -- Update magazijn voorraad
                UPDATE magazijnen
                SET aantal = v_nieuw_aantal,
                    uitleveringsdatum = p_uitleveringsdatum,
                    updated_at = NOW()
                WHERE id = p_magazijn_id;

                -- Update locatie in pivot tabel
                UPDATE product_per_magazijn
                SET locatie = p_nieuwe_locatie
                WHERE product_id = p_product_id AND magazijn_id = p_magazijn_id;

                -- Log de uitlevering
                INSERT INTO product_logs (product_id, actie, datum, details)
                VALUES (p_product_id, "INVENTORY_UPDATE", NOW(),
                        CONCAT("Uitgeleverd: ", p_aantal_uitgeleverd, " stuks. Restant: ", v_nieuw_aantal));

                COMMIT;
            END
        ');

        // Stored procedure voor het ophalen van producten die binnenkort verlopen
        DB::unprepared('
            DROP PROCEDURE IF EXISTS GetExpiringProducts;
            CREATE PROCEDURE GetExpiringProducts(
                IN p_dagen_vooruit INT
            )
            BEGIN
                SELECT 
                    p.id,
                    p.naam,
                    p.barcode,
                    p.houdbaarheidsdatum,
                    c.naam as categorie,
                    SUM(m.aantal) as totaal_voorraad,
                    DATEDIFF(p.houdbaarheidsdatum, CURDATE()) as dagen_tot_vervaldatum
                FROM producten p
                INNER JOIN categories c ON p.categorie_id = c.id
                LEFT JOIN product_per_magazijn pm ON p.id = pm.product_id
                LEFT JOIN magazijnen m ON pm.magazijn_id = m.id
                WHERE p.houdbaarheidsdatum <= DATE_ADD(CURDATE(), INTERVAL p_dagen_vooruit DAY)
                  AND p.houdbaarheidsdatum >= CURDATE()
                  AND p.deleted_at IS NULL
                GROUP BY p.id
                HAVING totaal_voorraad > 0
                ORDER BY p.houdbaarheidsdatum ASC;
            END
        ');

        // Maak log tabel voor product acties
        DB::unprepared('
            CREATE TABLE IF NOT EXISTS product_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT,
                actie VARCHAR(50) NOT NULL,
                datum DATETIME NOT NULL,
                details TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_id) REFERENCES producten(id) ON DELETE CASCADE
            )
        ');

        // Maak statistieken tabel voor producten
        DB::unprepared('
            CREATE TABLE IF NOT EXISTS product_statistics (
                id INT AUTO_INCREMENT PRIMARY KEY,
                categorie_id INT,
                total_products INT DEFAULT 0,
                last_updated DATETIME,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                UNIQUE KEY unique_categorie (categorie_id),
                FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE CASCADE
            )
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS RegisterNewProduct');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetInventoryOverview');
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateProductInventory');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetExpiringProducts');
        DB::unprepared('DROP TABLE IF EXISTS product_logs');
        DB::unprepared('DROP TABLE IF EXISTS product_statistics');
    }
};
