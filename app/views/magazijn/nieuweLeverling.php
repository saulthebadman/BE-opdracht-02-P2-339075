<?php require_once APPROOT . '/views/includes/header.php'; ?>

<div class="container mt-3">
    <h3><?= $data['title']; ?></h3>

    <form action="<?= URLROOT; ?>/leveringen/submitNieuweLevering" method="POST">
        <input type="hidden" name="productId" value="<?= $data['product']->id; ?>">

        <div class="form-group">
            <label for="aantal">Aantal in Magazijn</label>
            <input type="number" class="form-control" id="aantal" name="aantal" required>
        </div>

        <div class="form-group">
            <label for="leverdatum">Datum Levering</label>
            <input type="date" class="form-control" id="leverdatum" name="leverdatum" required>
        </div>

        <div class="form-group">
            <label for="volgendleverdatum">Volgende Levering</label>
            <input type="date" class="form-control" id="volgendleverdatum" name="volgendleverdatum" required>
        </div>

        <button type="submit" class="btn btn-primary">Levering Toevoegen</button>
    </form>

    <a href="<?= URLROOT; ?>/leveringen/showProductDetails/<?= $data['product']->id; ?>" class="btn btn-secondary mt-3">Terug naar Product</a>
</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
