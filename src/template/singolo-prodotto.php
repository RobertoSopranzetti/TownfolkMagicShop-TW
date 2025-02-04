<?php if ($templateParams["prodotto"] == null): ?>
    <article>
        <p>Prodotto non presente</p>
    </article>
<?php else:
    $prodotto = $templateParams["prodotto"];
    ?>
    <div class="container mt-5">
        <div class="text-center">
            <h1><?php echo $prodotto["titolo"]; ?></h1>
        </div>
        <div class="row mt-4">
            <div class="col-12 col-md-6 mb-3">
                <img src="<?php echo UPLOAD_DIR . $prodotto["immagine"]; ?>" alt="<?php echo $prodotto["titolo"]; ?>"
                    class="img-fluid">
            </div>
            <div class="col-12 col-md-6 mb-3">
                <div class="d-flex align-items-center mb-3">
                    <label for="colorPicker" class="form-label me-2">Scegli il colore:</label>
                    <input type="color" id="colorPicker" name="colorPicker" class="form-control form-control-color me-4">
                    <label for="quantity" class="form-label me-2">Quantità:</label>
                    <input type="number" id="quantity" name="quantity" class="form-control quantity-input" min="1"
                        max="<?php echo $prodotto["quantita_disponibile"]; ?>" value="1">
                </div>
                <div class="d-flex align-items-center mb-3">
                    <p class="mb-0"><strong>Prezzo:</strong></p>
                    <p class="mb-0 ms-2"><?php echo number_format($prodotto["prezzo"], 2); ?> €</p>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary w-100">Aggiungi al Carrello</button>
                </div>
                <div class="mt-4">
                    <p><?php echo $prodotto["descrizione"]; ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>