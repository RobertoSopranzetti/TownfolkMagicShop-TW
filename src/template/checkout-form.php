<section>
    <h2>Checkout</h2>
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="d-inline">Dettagli Cliente</h5>
            </div>
        </div>
        <form method="post" action="processa-checkout.php">
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="col-12 col-md-6">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <label for="cognome" class="form-label">Cognome</label>
                    <input type="text" class="form-control" id="cognome" name="cognome" placeholder="Cognome" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="indirizzo" class="form-label">Indirizzo</label>
                    <input type="text" class="form-control" id="indirizzo" name="indirizzo"
                        value="Via dell'Università, 50, 47521 Cesena FC" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-4">
                    <label for="cap" class="form-label">CAP</label>
                    <input type="text" class="form-control" id="cap" name="cap" value="47521" readonly>
                </div>
                <div class="col-12 col-md-4">
                    <label for="stato" class="form-label">Stato</label>
                    <input type="text" class="form-control" id="stato" name="stato" value="Italia" readonly>
                </div>
                <div class="col-12 col-md-4">
                    <label for="provincia" class="form-label">Provincia</label>
                    <input type="text" class="form-control" id="provincia" name="provincia" value="FC" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="numero_carta" class="form-label">Numero della Carta</label>
                    <input type="text" class="form-control" id="numero_carta" name="numero_carta"
                        placeholder="Numero della Carta" required>
                </div>
            </div>
            <div class="row mb-4 p-3 border rounded bg-light">
                <div class="col-12">
                    <h5>Riepilogo Ordine</h5>
                    <ul class="list-group mb-3">
                        <?php foreach ($templateParams["prodottiCarrello"] as $prodotto): ?>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0"><?php echo $prodotto["titolo"]; ?></h6>
                                    <small class="text-muted">Quantità: <?php echo $prodotto["quantita"]; ?></small>
                                </div>
                                <span
                                    class="text-muted"><?php echo number_format($prodotto["prezzo"] * $prodotto["quantita"], 2); ?>
                                    €</span>
                            </li>
                        <?php endforeach; ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Subtotale</span>
                            <strong><?php echo number_format($templateParams["subtotale"], 2); ?> €</strong>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <a href="carrello.php" class="btn btn-secondary w-100">Torna al Carrello</a>
                </div>
                <div class="col-12 col-md-6">
                    <button type="submit" class="btn btn-success w-100">Conferma Acquisto</button>
                </div>
            </div>
        </form>
    </div>
</section>