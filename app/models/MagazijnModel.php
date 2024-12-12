<?php

class MagazijnModel
{
    private $db;

    public function __construct()
    {
        /**
         * Maak een nieuw database object die verbinding maakt met de 
         * MySQL server
         */
        $this->db = new Database();
    }

    public function getAllMagazijnProducts()
{
    $this->db->query("
        SELECT 
            MAGA.Id AS MagazijnId,
            MAGA.ProductId AS MagazijnProductId,
            MAGA.Verpakkingseenheid,
            MAGA.AantalAanwezig,
            PROD.Id AS ProductId,
            PROD.Naam,
            PROD.Barcode,
            LEV.ContactPersoon AS Contactpersoon,
            LEV.LeverancierNummer AS Leveranciernummer,
            LEV.Mobiel AS Mobiel,
            (
                SELECT COUNT(DISTINCT PPL.ProductId) 
                FROM ProductPerLeverancier AS PPL 
                WHERE PPL.LeverancierId = LEV.Id
            ) AS AantalVerschillendeProducten,
            CASE 
                WHEN MAGA.AantalAanwezig > 0 THEN 'Beschikbaar'
                ELSE 'Niet Beschikbaar'
            END AS ToonProducten
        FROM 
            Magazijn AS MAGA
        INNER JOIN 
            Product AS PROD ON PROD.Id = MAGA.ProductId
        LEFT JOIN 
            ProductPerLeverancier AS PPL ON PPL.ProductId = PROD.Id
        LEFT JOIN 
            Leverancier AS LEV ON LEV.Id = PPL.LeverancierId
        WHERE 
            PROD.IsActief = 1 AND MAGA.IsActief = 1
        GROUP BY 
            MAGA.Id, MAGA.ProductId, MAGA.Verpakkingseenheid, MAGA.AantalAanwezig, 
            PROD.Id, PROD.Naam, PROD.Barcode, LEV.ContactPersoon, LEV.LeverancierNummer, LEV.Mobiel
        ORDER BY 
            PROD.Barcode ASC;
    ");

    return $this->db->resultSet();
}


public function getProductDetails($productId)
{
    $this->db->query("
        SELECT 
            P.Naam AS ProductNaam,
            L.Naam AS LeverancierNaam,
            L.ContactPersoon,
            L.LeverancierNummer,
            PPL.Aantal,
            M.AantalAanwezig,
            PPL.DatumLevering,
            PPL.DatumEerstVolgendeLevering
        FROM 
            Product P
        INNER JOIN 
            Magazijn M ON P.Id = M.ProductId
        INNER JOIN 
            ProductPerLeverancier PPL ON P.Id = PPL.ProductId
        INNER JOIN 
            Leverancier L ON PPL.LeverancierId = L.Id
        WHERE 
            P.Id = :productId
        ORDER BY 
            M.AantalAanwezig DESC
    ");
    $this->db->bind(':productId', $productId);
    return $this->db->resultSet();
}

    


public function getLeverancierInfoById($leverancierId)
{
    $this->db->query("SELECT Naam, ContactPersoon, LeverancierNummer, Mobiel FROM Leverancier WHERE id = :leverancierId");
    $this->db->bind(':leverancierId', $leverancierId);
    $leverancier = $this->db->single();

    // Controleer of de leverancier bestaat
    if ($leverancier) {
        return $leverancier;
    } else {
        return null; // Leverancier bestaat niet
    }
}

public function getGeleverdeProductenByLeverancier($leverancierId)
{
    $this->query("
        SELECT p.Naam AS productNaam, p.AantalInMagazijn, p.Verpakkingseenheid, l.LaatsteLevering
        FROM product p
        JOIN leveringen l ON p.id = l.productId
        WHERE p.leverancierId = :leverancierId
        ORDER BY p.AantalInMagazijn DESC
    ");
    $this->bind(':leverancierId', $leverancierId);
    return $this->resultSet();
}


public function addLevering($productId, $aantal, $leverdatum, $volgendleverdatum)
{
    // Voeg de nieuwe levering toe aan de database
    $this->db->query('INSERT INTO leveringen (product_id, aantal, leverdatum, volgendleverdatum) VALUES (:productId, :aantal, :leverdatum, :volgendleverdatum)');

    // Bind de waarden
    $this->db->bind(':productId', $productId);
    $this->db->bind(':aantal', $aantal);
    $this->db->bind(':leverdatum', $leverdatum);
    $this->db->bind(':volgendleverdatum', $volgendleverdatum);

    // Voer de query uit
    return $this->db->execute();
}

public function getProductById($id)
{
    $this->db->query('SELECT p.*, pl.LeverancierId 
                      FROM Product p
                      LEFT JOIN ProductPerLeverancier pl ON p.Id = pl.ProductId
                      WHERE p.Id = :id');
    $this->db->bind(':id', $id);
    return $this->db->single();
}


public function getProductenByLeverancierId($leverancierId)
{
    $this->db->query('
        SELECT p.Id, p.Naam, p.Barcode, p.IsActief, p.Opmerking, m.AantalAanwezig
        FROM Product p
        INNER JOIN Magazijn m ON p.Id = m.ProductId
        WHERE p.LeverancierId = :leverancierId
        AND p.IsActief = 1
    ');
    $this->db->bind(':leverancierId', $leverancierId);
    return $this->db->resultSet();  // Dit retourneert een array van product-objecten
}




}