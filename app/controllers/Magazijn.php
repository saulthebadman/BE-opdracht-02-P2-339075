<?php

class Magazijn extends BaseController
{
    private $magazijnModel;
    private $leverancierModel;


    public function __construct()
    {
        $this->magazijnModel = $this->model('MagazijnModel');
        $this->leverancierModel = $this->model('LeverancierModel');
    }
    // Helperfunctie om standaarddata op te bouwen
    private function initializeData($title)
    {
        return [
            'title' => $title,
            'message' => NULL,
            'messageColor' => NULL,
            'messageVisibility' => 'none',
            'dataRows' => []
        ];
    }

    public function index()
    {
        $data = $this->initializeData('Overzicht Leveranciers');

        // Ophalen van gegevens via het model
        $result = $this->magazijnModel->getAllMagazijnProducts();

        if (is_null($result)) {
            $data['message'] = "Er is een fout opgetreden in de database";
            $data['messageColor'] = "danger";
            $data['messageVisibility'] = "flex";
        } else {
            $data['dataRows'] = $result;
        }

        $this->view('magazijn/index', $data);
    }

    public function readProductPerLeverancierById($productId)
    {
        $data = $this->initializeData('LeveringsInformatie');

        // Controleer of productId geldig is
        if (!is_numeric($productId) || $productId <= 0) {
            $data['message'] = "Ongeldig product-ID opgegeven";
            $data['messageColor'] = "warning";
            $data['messageVisibility'] = "flex";
            $this->view('magazijn/readProductPerLeverancierById', $data);
            return;
        }

        // Ophalen van productgegevens via het model
        $result = $this->magazijnModel->getProductPerLeverancierById($productId);

        if (is_null($result)) {
            $data['message'] = "Er is een fout opgetreden in de database";
            $data['messageColor'] = "danger";
            $data['messageVisibility'] = "flex";
        } elseif (empty($result)) {
            $data['message'] = "Geen gegevens gevonden voor het opgegeven product-ID";
            $data['messageColor'] = "warning";
            $data['messageVisibility'] = "flex";
        } else {
            $data['dataRows'] = $result;
        }

        $this->view('magazijn/readProductPerLeverancierById', $data);
    }

    public function getLeverancierById($leverancierId)
    {
        // Haal gegevens van de leverancier op
        $this->db->query('SELECT * FROM ProductPerLeverancier WHERE id = :leverancierId');
        $this->db->bind(':leverancierId', $leverancierId);
        return $this->db->single();
    }

    // Controller: Magazijn.php
public function showProductDetails($id)
{
    // Haal de productinformatie op
    $product = $this->magazijnModel->getProductById($id);

    // Haal de leverancierinformatie op
    $leverancierInfo = $this->leverancierModel->getLeverancierById($product->LeverancierId);

    // Haal de producten van de leverancier op, geef de leverancierId en eventueel productId door
    $producten = $this->magazijnModel->getProductenByLeverancierId($leverancierInfo->Id, $product->Id);

    // Geef de gegevens door naar de view
    $data = [
        'title' => 'Product Details',
        'product' => $product,
        'leverancierInfo' => $leverancierInfo,
        'producten' => $producten,
    ];
    

    $this->view('magazijn/productDetails', $data);
}

    



public function geleverdeProducten($leverancierId)
{
    // Haal de leveranciergegevens op
    $leverancierInfo = $this->magazijnModel->getLeverancierInfoById($leverancierId);

    // Haal een lijst van producten op
    $producten = $this->magazijnModel->getGeleverdeProductenByLeverancier($leverancierId);

    // Controleer of data is opgehaald
    if (!$leverancierInfo || !$producten) {
        $data = [
            'title' => 'Fout',
            'message' => 'Kan geen gegevens ophalen',
            'messageColor' => 'danger',
            'messageVisibility' => 'flex'
        ];
        $this->view('error/index', $data);
        return;
    }

    // Stuur data naar de view
    $data = [
        'title' => 'Geleverde Producten',
        'leverancierInfo' => $leverancierInfo,
        'product' => $producten
    ];

    $this->view('magazijn/geleverdeProducten', $data);
}



public function getProductenByLeverancierId($leverancierId)
{
    try {
        $this->db->query('SELECT Id, Naam, Barcode, AantalAanwezig FROM product WHERE LeverancierId = :leverancierId AND IsActief = 1');

        $this->db->bind(':leverancierId', $leverancierId);
        $result = $this->db->resultSet();
        
        // Check of er resultaten zijn
        if ($result) {
            return $result;  // Return de array van objecten
        } else {
            throw new Exception('Geen producten gevonden voor deze leverancier.');
        }
    } catch (Exception $e) {
        // Error afhandelen
        echo "Fout: " . $e->getMessage();
        return [];
    }
}



public function nieuweLevering($productId)
{
    // Haal de productgegevens op
    $product = $this->productModel->getProductById($productId);

    // Toon een formulier voor het toevoegen van een nieuwe levering
    $data = [
        'title' => 'Nieuwe Levering Toevoegen',
        'product' => $product
    ];

    $this->view('leveringen/nieuweLevering', $data);
}


public function submitNieuweLevering()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Verkrijg de gegevens van het formulier
        $aantal = $_POST['aantal'];
        $leverdatum = $_POST['leverdatum'];
        $volgendleverdatum = $_POST['volgendleverdatum'];
        $productId = $_POST['productId'];

        // Voeg de nieuwe levering toe aan de database
        $this->leveringenModel->addLevering($productId, $aantal, $leverdatum, $volgendleverdatum);

        // Redirect naar de productdetails pagina
        redirect("/leveringen/showProductDetails/$productId");
    }
}


}
