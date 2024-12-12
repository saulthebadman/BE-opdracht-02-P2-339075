/************************************************
-- Doel: Opvragen alle records uit de tabel
--       Magazijn, Product en aanvullende velden.
************************************************
-- Versie: 02
-- Datum:  12-12-2024
-- Auteur: Arjan de Ruijter
-- Details: Uitgebreide stored procedure voor index model method
************************************************/

-- Noem de database voor de stored procedure
USE `BE-Opdracht02`;

-- Verwijder de bestaande stored procedure
DROP PROCEDURE IF EXISTS spReadMagazijnProduct;

DELIMITER //

CREATE PROCEDURE spReadMagazijnProduct()
BEGIN
    SELECT 
          MAGA.Id                            AS MagazijnId
        , MAGA.ProductId                     AS MagazijnProductId
        , MAGA.Verpakkingseenheid
        , MAGA.AantalAanwezig
        , PROD.Id                            AS ProductId
        , PROD.Naam
        , PROD.Barcode
        , LEV.ContactPersoon                 AS Contactpersoon
        , LEV.LeverancierNummer              AS Leveranciernummer
        , LEV.Mobiel
        , COUNT(DISTINCT MAGA.ProductId)     AS AantalVerschillendeProducten
        , CASE 
              WHEN MAGA.AantalAanwezig > 0 THEN 'Beschikbaar'
              ELSE 'Niet beschikbaar'
          END                                AS ToonProducten
    FROM Magazijn AS MAGA

    INNER JOIN Product AS PROD
        ON PROD.Id = MAGA.ProductId

    LEFT JOIN ProductPerLeverancier AS PPL
        ON PPL.ProductId = PROD.Id

    LEFT JOIN Leverancier AS LEV
        ON LEV.Id = PPL.LeverancierId

    GROUP BY 
          MAGA.Id
        , MAGA.ProductId
        , MAGA.Verpakkingseenheid
        , MAGA.AantalAanwezig
        , PROD.Id
        , PROD.Naam
        , PROD.Barcode
        , LEV.ContactPersoon
        , LEV.LeverancierNummer
        , LEV.Mobiel

    ORDER BY PROD.Barcode ASC;

END //
DELIMITER ;

/********** Debug code stored procedure ***************
CALL spReadMagazijnProduct();
****************************************************/
