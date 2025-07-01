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
        // Create stored procedure for updating customer information
        DB::unprepared('
            DROP PROCEDURE IF EXISTS UpdateCustomerInfo;
        ');
        
        DB::unprepared('
            CREATE PROCEDURE UpdateCustomerInfo(
                IN p_gezin_id INT,
                IN p_voornaam VARCHAR(255),
                IN p_tussenvoegsel VARCHAR(255),
                IN p_achternaam VARCHAR(255),
                IN p_email VARCHAR(255),
                IN p_mobiel VARCHAR(20),
                IN p_straat VARCHAR(255),
                IN p_huisnummer VARCHAR(10),
                IN p_toevoeging VARCHAR(10),
                IN p_postcode VARCHAR(10),
                IN p_woonplaats VARCHAR(255),
                OUT p_success BOOLEAN,
                OUT p_message VARCHAR(500)
            )
            proc_label: BEGIN
                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    ROLLBACK;
                    SET p_success = FALSE;
                    SET p_message = "Er is een fout opgetreden bij het bijwerken van de klantgegevens";
                END;

                -- Start transaction
                START TRANSACTION;

                -- Validate postcode (must start with 5271 for Maaskantje)
                IF p_postcode IS NOT NULL AND p_postcode != "" THEN
                    IF p_postcode NOT REGEXP "^5271[A-Z]{2}$" THEN
                        SET p_success = FALSE;
                        SET p_message = "De postcode komt niet uit de regio Maaskantje";
                        ROLLBACK;
                        LEAVE proc_label;
                    END IF;
                END IF;

                -- Validate Dutch mobile number
                IF p_mobiel IS NOT NULL AND p_mobiel != "" THEN
                    IF p_mobiel NOT REGEXP "^(06[0-9]{8}|\\\\+31\\\\s6[0-9]{8}|0031\\\\s6[0-9]{8})$" THEN
                        SET p_success = FALSE;
                        SET p_message = "Het mobiele nummer moet een geldig Nederlands mobiel nummer zijn";
                        ROLLBACK;
                        LEAVE proc_label;
                    END IF;
                END IF;

                -- Update vertegenwoordiger in personen table
                UPDATE personen 
                SET 
                    voornaam = p_voornaam,
                    tussenvoegsel = p_tussenvoegsel,
                    achternaam = p_achternaam,
                    updated_at = NOW()
                WHERE gezin_id = p_gezin_id 
                AND is_vertegenwoordiger = TRUE;

                -- Check if vertegenwoordiger was updated
                IF ROW_COUNT() = 0 THEN
                    SET p_success = FALSE;
                    SET p_message = "Geen vertegenwoordiger gevonden voor dit gezin";
                    ROLLBACK;
                    LEAVE proc_label;
                END IF;

                -- Update contact information
                UPDATE contacts c
                INNER JOIN contact_per_gezin cpg ON c.id = cpg.contact_id
                SET 
                    c.email = p_email,
                    c.mobiel = p_mobiel,
                    c.straat = p_straat,
                    c.huisnummer = p_huisnummer,
                    c.toevoeging = p_toevoeging,
                    c.postcode = p_postcode,
                    c.woonplaats = p_woonplaats,
                    c.updated_at = NOW()
                WHERE cpg.gezin_id = p_gezin_id;

                -- Commit transaction
                COMMIT;
                
                SET p_success = TRUE;
                SET p_message = "De klantgegevens zijn gewijzigd";
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateCustomerInfo');
    }
};
