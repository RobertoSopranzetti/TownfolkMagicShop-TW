<section>
    <h2>Il tuo Carrello</h2>
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
                            <div class="text-center">
                                <button class="btn btn-danger mb-2"
                                    onclick="rimuoviDalCarrello(<?php echo $prodotto['id']; ?>)">X</button>
                                <input type="number" class="form-control" value="<?php echo $prodotto["quantita"]; ?>" min="1"
                                    onchange="aggiornaQuantita(<?php echo $prodotto['id']; ?>, this.value)">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="row">
                <div class="col-12 text-right">
                    <h5>Subtotale: <?php echo number_format($templateParams["subtotale"], 2); ?> €</h5>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <h5>Riepilogo</h5>
                    <p>Numero di oggetti: <?php echo count($templateParams["prodottiCarrello"]); ?></p>
                    <p>Subtotale: <?php echo number_format($templateParams["subtotale"], 2); ?> €</p>
                    <div class="form-group">
                        <label for="spedizione">Spedizione</label>
                        <select class="form-control" id="spedizione" onchange="aggiornaTotale()">
                            <option value="0">Gratuita</option>
                            <option value="5">Espressa - 5 €</option>
                            <option value="10">Premium - 10 €</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="coupon">Inserisci coupon</label>
                        <input type="text" class="form-control" id="coupon" placeholder="Inserisci coupon">
                        <button class="btn btn-primary mt-2" onclick="applicaCoupon()">Applica</button>
                    </div>
                    <h5>Totale: <span id="totale"><?php echo number_format($templateParams["subtotale"], 2); ?> €</span>
                    </h5>
                    <a href="checkout.php" class="btn btn-success btn-block">Procedi al Checkout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>