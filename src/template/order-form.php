<section>
    <h2>Gestisci Ordine</h2>
    <div class="container">
        <?php if (isset($templateParams["formmsg"])): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $templateParams["formmsg"]; ?>
            </div>
        <?php endif; ?>
        <div class="row mb-4 p-3 border rounded bg-light">
            <div class="col-12">
                <p><strong>Data Ordine:</strong> <?php echo $templateParams["ordine"]["data_ordine"]; ?></p>
                <p><strong>Status:</strong> <?php echo $templateParams["ordine"]["status"]; ?></p>
                <p><strong>Consegna Prevista:</strong> <?php echo $templateParams["ordine"]["consegna_prevista"]; ?></p>
                <p><strong>Spesa Complessiva:</strong>
                    <?php echo number_format($templateParams["ordine"]["spesa_complessiva"], 2); ?> €</p>
                <p><strong>Cliente:</strong> <?php echo $templateParams["ordine"]["cliente"]; ?></p>
            </div>
            <div class="col-12 col-md-3 text-center">
                <img src="<?php echo UPLOAD_DIR . $templateParams["ordine"]["prodotto_immagine"]; ?>"
                    alt="Immagine del Prodotto" class="img-fluid mb-2">
                <a href="prodotto.php?id=<?php echo $templateParams["ordine"]["prodotto_id"]; ?>"
                    class="btn btn-link">Dettagli Prodotto</a>
            </div>
            <div class="col-12 col-md-9">
                <p><strong>Nome Prodotto:</strong> <?php echo $templateParams["ordine"]["prodotto_nome"]; ?></p>
                <p><strong>Quantità:</strong> <?php echo $templateParams["ordine"]["quantita"]; ?></p>
                <p><strong>Prezzo:</strong> <?php echo number_format($templateParams["ordine"]["prezzo"], 2); ?> €</p>
            </div>
        </div>
        <form method="post" action="processa-ordine.php">
            <input type="hidden" name="id" value="<?php echo $templateParams["ordine"]["id"]; ?>">
            <div class="mb-3">
                <label for="stato_ordine" class="form-label">Stato Ordine</label>
                <select class="form-select" id="stato_ordine" name="stato_ordine"
                    aria-label="Seleziona stato dell'ordine">
                    <option value="In elaborazione" <?php echo $templateParams["ordine"]["status"] == "In elaborazione" ? "selected" : ""; ?>>In elaborazione</option>
                    <option value="Spedito" <?php echo $templateParams["ordine"]["status"] == "Spedito" ? "selected" : ""; ?>>Spedito</option>
                    <option value="Consegnato" <?php echo $templateParams["ordine"]["status"] == "Consegnato" ? "selected" : ""; ?>>Consegnato</option>
                    <option value="Annullato" <?php echo $templateParams["ordine"]["status"] == "Annullato" ? "selected" : ""; ?>>Annullato</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Aggiorna Stato</button>
        </form>
    </div>
</section>