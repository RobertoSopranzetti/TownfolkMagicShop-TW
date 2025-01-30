<?php if(count($templateParams["prodotto"])==0): ?>
    <article>
        <p>Prodotto non presente</p>
    </article>
<?php else: 
    $prodotto = $templateParams["prodotto"][0];
?>
    <div class="container mt-5">
        <div class="text-center">
            <h1><?php echo $prodotto["titolo"]; ?></h1>
        </div>
        <div class="row mt-4">
            <div class="col-12 col-md-6 mb-3">
                <label for="colorPicker" class="form-label">Scegli il colore:</label>
                <input type="color" id="colorPicker" name="colorPicker" class="form-control form-control-color">
            </div>
            <div class="col-12 col-md-6 mb-3">
                <label for="quantity" class="form-label">Quantità:</label>
                <input type="number" id="quantity" name="quantity" class="form-control" min="1" value="1">
            </div>
            <div class="col-12 col-md-6 mb-3">
                <p><strong>Prezzo:</strong> <?php echo number_format($prodotto["prezzo"], 2); ?> €</p>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <button class="btn btn-primary w-100">Aggiungi al Carrello</button>
            </div>
        </div>
        <div class="text-center mt-4">
            <img src="<?php echo UPLOAD_DIR.$prodotto["immagine"]; ?>" alt="<?php echo $prodotto["titolo"]; ?>" class="img-fluid">
        </div>
        <div class="mt-4">
            <p><?php echo $prodotto["descrizione"]; ?></p>
        </div>
    </div>
<?php endif; ?>