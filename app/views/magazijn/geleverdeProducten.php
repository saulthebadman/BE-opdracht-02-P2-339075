<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container mt-3">
    <h3><?= $data['title']; ?></h3>
    <p><strong>Naam leverancier:</strong> <?= $data['leverancierInfo']->Naam; ?></p>
    <p><strong>Contactpersoon:</strong> <?= $data['leverancierInfo']->Contactpersoon; ?></p>
    <p><strong>Leverancier NR:</strong> <?= $data['leverancierInfo']->Leveranciernummer; ?></p>
    <p><strong>Mobiel:</strong> <?= $data['leverancierInfo']->Mobiel; ?></p>

    <table class="table table-hover mt-3">
        <thead>
            <tr>
                <th>Naam product</th>
                <th>Aantal in Magazijn</th>
                <th>Verpakkingseenheid</th>
                <th>Laatste levering</th>
                <th>Nieuwe levering</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['product'] as $product): ?>
                <tr>
                    <td><?= $product->productNaam; ?></td>
                    <td><?= $product->AantalInMagazijn; ?></td>
                    <td><?= $product->Verpakkingseenheid; ?></td>
                    <td><?= $product->LaatsteLevering; ?></td>
                    <td>
                        <a href="<?= URLROOT; ?>/leveringen/nieuweLevering/<?= $product->id; ?>">
                            <i class="bi bi-plus-circle"></i> <!-- Plus icoon -->
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="<?= URLROOT; ?>/magazijn/index" class="btn btn-secondary">Terug</a>
    <a href="<?= URLROOT; ?>/homepages/index" class="btn btn-primary">Home</a>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
