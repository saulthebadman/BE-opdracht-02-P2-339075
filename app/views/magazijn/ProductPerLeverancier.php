<?php require_once APPROOT . '/views/includes/header.php'; ?>

<!-- Voor het centreren van de container gebruiken we het boodstrap grid -->
<div class="container">

    <div class="row mt-3 text-center" style="display:<?= $data['messageVisibility']; ?>">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="alert alert-<?= $data['messageColor']; ?>" role="alert">
                <?= $data['message']; ?>
            </div>
        </div>
        <div class="col-2"></div>
    </div>


    <div class="row mt-3">
        <div class="col-2"></div>
        <div class="col-8">
            <h3><?php echo $data['title']; ?></h3>
        </div>
        <div class="col-2"></div>
    </div>

    <div class="row mt-3">
        <div class="col-2"></div>
        <div class="col-8">
            <?php var_dump($data['dataRows']); ?>

            <table>
                <tbody>
                    <tr>
                        <td>Naam Leverancier:</td>
                        <td><?= $data['dataRows'][0]->LeverancierNaam; ?></td>
                    </tr>
                    <tr>
                        <td>Contactpersoon Leverancier:</td>
                        <td><?= $data['dataRows'][0]->Contactpersoon; ?></td>
                    </tr>
                    <tr>
                        <td>LeverancierNummer:</td>
                        <td><?= $data['dataRows'][0]->Leveranciernummer; ?></td>
                    </tr>
                    <tr>
                        <td>Mobiel:</td>
                        <td><?= $data['dataRows'][0]->Mobiel; ?></td>
                    </tr>

                </tbody>
            </table>

            <table>
                <thead>
                    <th>Naam Product</th>
                    <th>Datum Laatste Levering</th>
                    <th>Aantal</th>
                    <th>Eerstvolgende levering</th>
                </thead>
                <tbody>
                    <?php foreach( $data['dataRows'] as $info) { ?>
                        <tr>
                            <td><?= $info->ProductNaam ?></td>
                            <td><?= $info->DatumLevering ?></td>
                            <td><?= $info->Aantal ?></td>
                            <td><?= $info->DatumEerstVolgendeLevering ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
           
            <a href="<?= URLROOT; ?>/homepages/index">Homepage</a>
        </div>
        <div class="col-2"></div>
    </div>

</div>




<?php require_once APPROOT . '/views/includes/footer.php'; ?>