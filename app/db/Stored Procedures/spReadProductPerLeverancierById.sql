/************************************************
-- Doel: Opvragen van records uit de tabel
-- countries.
************************************************
-- Versie: 01
-- Datum:  14-11-2024
-- Auteur: Arjan de Ruijter
-- Stored procedure voor select method
************************************************/

-- Noem de database voor de stored procedure
use `be-opdracht02`;

-- Verwijder de bestaande stored procedure
DROP PROCEDURE IF EXISTS spReadProductPerLeverancierById;

DELIMITER //

CREATE PROCEDURE spReadProductPerLeverancierById
(
    IN ProductId INT UNSIGNED 
)
BEGIN

   SELECT    PPL.DatumLevering
            ,PPL.DatumEerstVolgendeLevering
            ,PPL.Aantal
            ,PROD.Naam                          AS ProductNaam
            ,LEVE.Naam                          AS LeverancierNaam
            ,LEVE.Contactpersoon
            ,LEVE.Leveranciernummer
            ,LEVE.Mobiel

   FROM     ProductPerLeverancier AS PPL

   INNER JOIN Product AS PROD
   ON         PPL.ProductId = PROD.Id

   INNER JOIN Leverancier AS LEVE
   ON         PPL.LeverancierId = Leve.Id

   WHERE      PPL.ProductId = ProductId;


END //
DELIMITER ;

/**********debug code stored procedure***************
CALL spReadProductPerLeverancierById(1);
****************************************************/

