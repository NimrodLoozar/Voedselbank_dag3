-- Stored Procedure: Update leverancier with contact information
-- Dit stored procedure werkt een bestaande leverancier bij met nieuwe contactgegevens
-- Gebruik: CALL UpdateLeverancierWithContact(leverancier_id, naam, contact_persoon, ...);

DELIMITER $$

CREATE PROCEDURE UpdateLeverancierWithContact(
    IN p_leverancier_id INT,
    IN p_naam VARCHAR(255),
    IN p_contact_persoon VARCHAR(255),
    IN p_leverancier_nummer VARCHAR(10),
    IN p_leverancier_type ENUM('Bedrijf', 'Instelling', 'Overheid', 'Particulier', 'Donor'),
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
        SET p_message = 'Er is een fout opgetreden bij het bijwerken van de leverancier.';
        ROLLBACK;
    END;

    -- Start transaction
    START TRANSACTION;

    -- Initialize output parameters
    SET p_success = TRUE;
    SET p_message = '';

    -- Check if leverancier exists
    SELECT COUNT(*) INTO v_leverancier_exists 
    FROM leveranciers 
    WHERE id = p_leverancier_id;

    IF v_leverancier_exists = 0 THEN
        SET p_success = FALSE;
        SET p_message = CONCAT('Leverancier met ID ', p_leverancier_id, ' bestaat niet.');
        ROLLBACK;
    ELSE
        -- Check if leverancier nummer already exists for different leverancier
        SELECT COUNT(*) INTO v_leverancier_nummer_exists 
        FROM leveranciers 
        WHERE leverancier_nummer = p_leverancier_nummer 
        AND id != p_leverancier_id;

        IF v_leverancier_nummer_exists > 0 THEN
            SET p_success = FALSE;
            SET p_message = CONCAT('Leverancier nummer ', p_leverancier_nummer, ' wordt al gebruikt door een andere leverancier.');
            ROLLBACK;
        ELSE
            -- Check if contact exists
            SELECT COUNT(*) INTO v_contact_exists 
            FROM contacts 
            WHERE id = p_contact_id;

            IF v_contact_exists = 0 THEN
                SET p_success = FALSE;
                SET p_message = CONCAT('Contact met ID ', p_contact_id, ' bestaat niet.');
                ROLLBACK;
            ELSE
                -- Update leverancier
                UPDATE leveranciers 
                SET 
                    naam = p_naam,
                    contact_persoon = p_contact_persoon,
                    leverancier_nummer = p_leverancier_nummer,
                    leverancier_type = p_leverancier_type,
                    updated_at = NOW()
                WHERE id = p_leverancier_id;

                -- Update contact
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

                SET p_message = CONCAT('Leverancier "', p_naam, '" succesvol bijgewerkt.');
                
                -- Commit transaction
                COMMIT;
            END IF;
        END IF;
    END IF;

END$$

DELIMITER ;
