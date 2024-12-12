<?php

class LeverancierController extends BaseController
{
    private $leverancierModel;

    public function __construct()
    {
        $this->leverancierModel = $this->model('LeverancierModel');
    }

    public function view($leverancierId)
    {
        // Haal gegevens op uit de model
        $data['leverancier'] = $this->leverancierModel->getLeverancierById($leverancierId);
        $data['ProductPerLeverancier '] = $this->leverancierModel->getProductenByLeverancierId($leverancierId);

        // Laad de view zonder extra mapnaam, maar wel de juiste naam
        $this->view('magazijn/productDetails', $data); // Aangezien 'productDetails.php' in de magazijn-map zit
    }
}
