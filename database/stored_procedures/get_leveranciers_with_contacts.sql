-- Stored Procedure: Get leveranciers with their contact information
-- Dit stored procedure haalt alle leveranciers op met hun bijbehorende contactgegevens
-- 
-- Gebruik voorbeelden:
-- CALL GetLeveranciersWithContacts(NULL, NULL);                    -- Alle leveranciers
-- CALL GetLeveranciersWithContacts('Bedrijf', NULL);               -- Alleen leveranciers van type 'Bedrijf'  
-- CALL GetLeveranciersWithContacts(NULL, 1);                       -- Specifieke leverancier met ID 1
-- CALL GetLeveranciersWithContacts('Particulier', 5);              -- Leverancier met ID 5 als deze van type 'Particulier' is

DELIMITER $$

CREATE PROCEDURE GetLeveranciersWithContacts(
    IN p_leverancier_type VARCHAR(50) DEFAULT NULL,
    IN p_leverancier_id INT DEFAULT NULL
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    -- Start transaction
    START TRANSACTION;

    -- Main query to get leveranciers with contacts
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
        CONCAT(c.straat, ' ', c.huisnummer, 
               CASE WHEN c.toevoeging IS NOT NULL THEN CONCAT(' ', c.toevoeging) ELSE '' END, 
               ', ', c.postcode, ' ', c.woonplaats) as volledig_adres
    FROM leveranciers l
    LEFT JOIN contact_per_leverancier cpl ON l.id = cpl.leverancier_id
    LEFT JOIN contacts c ON cpl.contact_id = c.id
    WHERE 
        (p_leverancier_type IS NULL OR l.leverancier_type = p_leverancier_type)
        AND (p_leverancier_id IS NULL OR l.id = p_leverancier_id)
    ORDER BY l.naam ASC, c.id ASC;

    -- Commit transaction
    COMMIT;

END$$

DELIMITER ;
