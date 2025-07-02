<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Migration voor het aanmaken van stored procedures voor magazijn functionaliteit
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Stored procedure voor magazijn data validatie
        DB::unprepared('
            DROP PROCEDURE IF EXISTS ValidateMagazijnData;
            CREATE PROCEDURE ValidateMagazijnData(
                IN p_magazijn_id INT,
                IN p_aantal INT,
                IN p_ontvangstdatum DATE
            )
            BEGIN
                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    ROLLBACK;
                    RESIGNAL;
                END;

                START TRANSACTION;

                -- Controleer of het aantal positief is
                IF p_aantal <= 0 THEN
                    SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Aantal moet groter zijn dan 0";
                END IF;

                -- Controleer of ontvangstdatum niet in de toekomst ligt
                IF p_ontvangstdatum > CURDATE() THEN
                    SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Ontvangstdatum kan niet in de toekomst liggen";
                END IF;

                -- Log de validatie
                INSERT INTO magazijn_logs (magazijn_id, actie, datum, details)
                VALUES (p_magazijn_id, "VALIDATE", NOW(), CONCAT("Validatie uitgevoerd - Aantal: ", p_aantal));

                COMMIT;
            END
        ');

        // Stored procedure voor het bijwerken van magazijn voorraad
        DB::unprepared('
            DROP PROCEDURE IF EXISTS UpdateMagazijnStock;
            CREATE PROCEDURE UpdateMagazijnStock(
                IN p_magazijn_id INT,
                IN p_nieuw_aantal INT,
                IN p_uitleveringsdatum DATE
            )
            BEGIN
                DECLARE v_oud_aantal INT DEFAULT 0;
                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    ROLLBACK;
                    RESIGNAL;
                END;

                START TRANSACTION;

                -- Haal huidige aantal op
                SELECT aantal INTO v_oud_aantal 
                FROM magazijnen 
                WHERE id = p_magazijn_id;

                -- Update de voorraad
                UPDATE magazijnen 
                SET aantal = p_nieuw_aantal,
                    uitleveringsdatum = p_uitleveringsdatum,
                    updated_at = NOW()
                WHERE id = p_magazijn_id;

                -- Log de wijziging
                INSERT INTO magazijn_logs (magazijn_id, actie, datum, details)
                VALUES (p_magazijn_id, "UPDATE_STOCK", NOW(), 
                        CONCAT("Voorraad gewijzigd van ", v_oud_aantal, " naar ", p_nieuw_aantal));

                COMMIT;
            END
        ');

        // Stored procedure voor veilig verwijderen van magazijn
        DB::unprepared('
            DROP PROCEDURE IF EXISTS SafeDeleteMagazijn;
            CREATE PROCEDURE SafeDeleteMagazijn(
                IN p_magazijn_id INT
            )
            BEGIN
                DECLARE v_product_count INT DEFAULT 0;
                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    ROLLBACK;
                    RESIGNAL;
                END;

                START TRANSACTION;

                -- Controleer of er nog producten gekoppeld zijn
                SELECT COUNT(*) INTO v_product_count
                FROM product_per_magazijn
                WHERE magazijn_id = p_magazijn_id;

                IF v_product_count > 0 THEN
                    SIGNAL SQLSTATE "45000" 
                    SET MESSAGE_TEXT = "Kan magazijn niet verwijderen: er zijn nog producten gekoppeld";
                END IF;

                -- Log de verwijdering
                INSERT INTO magazijn_logs (magazijn_id, actie, datum, details)
                VALUES (p_magazijn_id, "DELETE", NOW(), "Magazijn gemarkeerd voor verwijdering");

                COMMIT;
            END
        ');

        // Stored procedure voor magazijn statistieken
        DB::unprepared('
            DROP PROCEDURE IF EXISTS GetMagazijnStatistics;
            CREATE PROCEDURE GetMagazijnStatistics()
            BEGIN
                SELECT 
                    COUNT(*) as totaal_magazijnen,
                    SUM(aantal) as totaal_items,
                    AVG(aantal) as gemiddeld_per_magazijn,
                    COUNT(CASE WHEN uitleveringsdatum IS NOT NULL THEN 1 END) as uitgeleverd,
                    COUNT(CASE WHEN uitleveringsdatum IS NULL THEN 1 END) as nog_in_voorraad,
                    MIN(ontvangstdatum) as eerste_ontvangst,
                    MAX(ontvangstdatum) as laatste_ontvangst
                FROM magazijnen
                WHERE deleted_at IS NULL;
            END
        ');

        // Maak een logs tabel voor magazijn acties
        DB::unprepared('
            CREATE TABLE IF NOT EXISTS magazijn_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                magazijn_id INT,
                actie VARCHAR(50) NOT NULL,
                datum DATETIME NOT NULL,
                details TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (magazijn_id) REFERENCES magazijnen(id) ON DELETE CASCADE
            )
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS ValidateMagazijnData');
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateMagazijnStock');
        DB::unprepared('DROP PROCEDURE IF EXISTS SafeDeleteMagazijn');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetMagazijnStatistics');
        DB::unprepared('DROP TABLE IF EXISTS magazijn_logs');
    }
};
