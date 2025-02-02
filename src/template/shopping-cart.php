<section>
    <h2 class="text-center my-4">Il tuo Carrello</h2>
    <div class="container">
        <?php if (empty($templateParams["prodottiCarrello"])): ?>
            <p>Il tuo carrello è vuoto.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($templateParams["prodottiCarrello"] as $prodotto): ?>
                    <div class="col-12 mb-4">
                        <div class="d-flex align-items-center border rounded p-3 bg-light">
                            <img src="<?php echo UPLOAD_DIR . $prodotto["immagine"]; ?>"
                                alt="<?php echo $prodotto["titolo"]; ?>" class="img-fluid" style="max-width: 100px;">
                            <div class="flex-grow-1 mx-3">
                                <h5 class="mb-1"><?php echo $prodotto["titolo"]; ?></h5>
                                <p class="mb-1">Colore: <?php echo $prodotto["colore"]; ?></p>
                                <p class="mb-1"><?php echo number_format($prodotto["prezzo"], 2); ?> €</p>
                            </div>
                            <div class="d-flex flex-column align-items-end">
                                <button class="btn btn-danger mb-2" aria-label="Rimuovi prodotto"
                                    onclick="rimuoviDalCarrello(<?php echo $prodotto['id']; ?>)">X</button>
                                <input type="number" class="form-control" value="<?php echo $prodotto["quantita"]; ?>" min="1"
                                    style="width: 60px;" aria-label="Quantità"
                                    onchange="aggiornaQuantita(<?php echo $prodotto['id']; ?>, this.value)">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="row">
                <div class="col-12 text-end">
                    <h5>Subtotale: <?php echo number_format($templateParams["subtotale"], 2); ?> €</h5>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-lg-6">
                    <div class="d-flex justify-content-between">
                        <h5>Riepilogo</h5>
                        <p>Numero di oggetti: <?php echo count($templateParams["prodottiCarrello"]); ?></p>
                    </div>
                    <p>Subtotale: <?php echo number_format($templateParams["subtotale"], 2); ?> €</p>
                    <div class="mb-3">
                        <label for="spedizione" class="form-label">Spedizione</label>
                        <select class="form-select" id="spedizione" aria-label="Seleziona metodo di spedizione"
                            onchange="aggiornaTotale()">
                            <option value="0">Gratuita</option>
                            <option value="5">Espressa - 5 €</option>
                            <option value="10">Premium - 10 €</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="coupon" placeholder="Inserisci coupon"
                            aria-label="Inserisci coupon">
                        <button class="btn btn-primary mt-2" onclick="applicaCoupon()">Applica</button>
                    </div>
                    <h5>Totale: <span id="totale"><?php echo number_format($templateParams["subtotale"], 2); ?> €</span>
                    </h5>
                    <a href="checkout.php" class="btn btn-success w-100">Procedi al Checkout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>