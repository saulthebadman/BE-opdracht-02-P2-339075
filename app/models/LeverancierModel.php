<?php

class LeverancierModel
{
    private $db;

    public function __construct()
    {
        // Initialiseer de databaseverbinding via de BaseController
        $this->db = new Database;
    }

    // Haal een leverancier op via hun ID
    public function getLeverancierById($leverancierId)
{
    // Query om gegevens van leverancier inclusief contactpersoon op te halen
    $this->db->query('SELECT * FROM leverancier WHERE id = :leverancierId');
    $this->db->bind(':leverancierId', $leverancierId);
    
    // Retourneer het resultaat als object
    return $this->db->single();
}


    // Haal alle producten op die bij een specifieke leverancier horen
    public function getProductenByLeverancierId($leverancierId)
    {
        // De juiste query met JOIN om de producten van een leverancier te krijgen
        $this->db->query('
            SELECT p.* 
            FROM product p
            INNER JOIN productperleverancier ppl ON p.id = ppl.productid
            WHERE ppl.leverancierid = :leverancierId
        ');
    
        // Bind de leverancierId parameter aan de query
        $this->db->bind(':leverancierId', $leverancierId);
    
        // Voer de query uit en haal de resultaten op
        return $this->db->resultSet();  // Retourneert een array van producten
    }
    
    // Voeg een nieuwe levering toe voor een product
    public function addLevering($productId, $aantal, $leverdatum, $volgendleverdatum)
    {
        // Voeg een nieuwe levering toe in de database
        $this->db->query('INSERT INTO leveringen (product_id, aantal, leverdatum, volgendleverdatum) VALUES (:productId, :aantal, :leverdatum, :volgendleverdatum)');

        // Bind de parameters
        $this->db->bind(':productId', $productId);
        $this->db->bind(':aantal', $aantal);
        $this->db->bind(':leverdatum', $leverdatum);
        $this->db->bind(':volgendleverdatum', $volgendleverdatum);

        // Voer de query uit en retourneer true als de insert succesvol was
        return $this->db->execute();
    }

    public function getProductById($id)
    {
        $this->db->query('SELECT * FROM product WHERE Id = :id');
        $this->db->bind(':id', $id);

        return $this->db->single();  // Retourneert één resultaat
    }
}
