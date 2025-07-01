<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop procedures if they exist
        DB::unprepared('DROP PROCEDURE IF EXISTS GetLeveranciersWithContacts');
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateLeverancierWithContact');

        // Create GetLeveranciersWithContacts stored procedure
        DB::unprepared('
            CREATE PROCEDURE GetLeveranciersWithContacts(
                IN p_leverancier_type VARCHAR(50),
                IN p_leverancier_id INT
            )
            BEGIN
                SELECT 
                    l.id as leverancier_id,
                    l.naam as leverancier_naam,
                    l.contact_persoon,
                    l.leverancier_nummer,
                    l.leverancier_type,
                    l.created_at as leverancier_created_at,
                    l.updated_at as leverancier_updated_at,
                    c.id as contact_id,
                    c.straat,
                    c.huisnummer,
                    c.toevoeging,
                    c.postcode,
                    c.woonplaats,
                    c.email,
                    c.mobiel,
                    c.created_at as contact_created_at,
                    c.updated_at as contact_updated_at,
                    p.id as product_id,
                    p.naam as product_naam,
                    p.barcode,
                    p.status as product_status,
                    ppl.datum_aangeleverd,
                    ppl.datum_eerst_volgende_levering,
                    CONCAT(c.straat, " ", c.huisnummer, 
                           CASE WHEN c.toevoeging IS NOT NULL THEN CONCAT(" ", c.toevoeging) ELSE "" END, 
                           ", ", c.postcode, " ", c.woonplaats) as volledig_adres
                FROM leveranciers l
                INNER JOIN product_per_leverancier ppl ON l.id = ppl.leverancier_id
                LEFT JOIN producten p ON ppl.product_id = p.id
                LEFT JOIN contact_per_leverancier cpl ON l.id = cpl.leverancier_id
                LEFT JOIN contacts c ON cpl.contact_id = c.id
                WHERE 
                    (p_leverancier_type IS NULL OR BINARY l.leverancier_type = BINARY p_leverancier_type)
                    AND (p_leverancier_id IS NULL OR l.id = p_leverancier_id)
                ORDER BY l.naam ASC, p.naam ASC, c.id ASC;
            END
        ');

        // Create UpdateLeverancierWithContact stored procedure
        DB::unprepared('
            CREATE PROCEDURE UpdateLeverancierWithContact(
                IN p_leverancier_id INT,
                IN p_naam VARCHAR(255),
                IN p_contact_persoon VARCHAR(255),
                IN p_leverancier_nummer VARCHAR(10),
                IN p_leverancier_type VARCHAR(50),
                IN p_contact_id INT,
                IN p_straat VARCHAR(255),
                IN p_huisnummer VARCHAR(10),
                IN p_toevoeging VARCHAR(10),
                IN p_postcode VARCHAR(10),
                IN p_woonplaats VARCHAR(255),
                IN p_email VARCHAR(255),
                IN p_mobiel VARCHAR(20),
                OUT p_success BOOLEAN,
                OUT p_message VARCHAR(500)
            )
            BEGIN
                DECLARE v_leverancier_exists INT DEFAULT 0;
                DECLARE v_contact_exists INT DEFAULT 0;
                DECLARE v_leverancier_nummer_exists INT DEFAULT 0;
                
                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    SET p_success = FALSE;
                    SET p_message = "Er is een fout opgetreden bij het bijwerken van de leverancier.";
                    ROLLBACK;
                END;

                START TRANSACTION;

                SET p_success = TRUE;
                SET p_message = "";

                SELECT COUNT(*) INTO v_leverancier_exists 
                FROM leveranciers 
                WHERE id = p_leverancier_id;

                IF v_leverancier_exists = 0 THEN
                    SET p_success = FALSE;
                    SET p_message = CONCAT("Leverancier met ID ", p_leverancier_id, " bestaat niet.");
                    ROLLBACK;
                ELSE
                    SELECT COUNT(*) INTO v_leverancier_nummer_exists 
                    FROM leveranciers 
                    WHERE BINARY leverancier_nummer = BINARY p_leverancier_nummer
                    AND id != p_leverancier_id;

                    IF v_leverancier_nummer_exists > 0 THEN
                        SET p_success = FALSE;
                        SET p_message = CONCAT("Leverancier nummer ", p_leverancier_nummer, " wordt al gebruikt door een andere leverancier.");
                        ROLLBACK;
                    ELSE
                        SELECT COUNT(*) INTO v_contact_exists 
                        FROM contacts 
                        WHERE id = p_contact_id;

                        IF v_contact_exists = 0 THEN
                            SET p_success = FALSE;
                            SET p_message = CONCAT("Contact met ID ", p_contact_id, " bestaat niet.");
                            ROLLBACK;
                        ELSE
                            UPDATE leveranciers 
                            SET 
                                naam = p_naam,
                                contact_persoon = p_contact_persoon,
                                leverancier_nummer = p_leverancier_nummer,
                                leverancier_type = p_leverancier_type,
                                updated_at = NOW()
                            WHERE id = p_leverancier_id;

                            UPDATE contacts 
                            SET 
                                straat = p_straat,
                                huisnummer = p_huisnummer,
                                toevoeging = p_toevoeging,
                                postcode = p_postcode,
                                woonplaats = p_woonplaats,
                                email = p_email,
                                mobiel = p_mobiel,
                                updated_at = NOW()
                            WHERE id = p_contact_id;

                            SET p_message = CONCAT("Leverancier \"", p_naam, "\" succesvol bijgewerkt.");
                            
                            COMMIT;
                        END IF;
                    END IF;
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GetLeveranciersWithContacts');
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateLeverancierWithContact');
    }
};
