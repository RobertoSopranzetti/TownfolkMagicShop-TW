<section>
    <h2><?php echo $templateParams["ruolo"] == "cliente" ? "I tuoi Ordini" : "Gestisci Ordini"; ?></h2>
    <div class="container">
        <?php foreach ($templateParams["ordini"] as $ordine): ?>
            <div class="row mb-4 p-3 border rounded bg-light">
                <div class="col-12">
                    <p><strong>Data Ordine:</strong> <?php echo $ordine["data_ordine"]; ?></p>
                    <p><strong>Status:</strong> <?php echo $ordine["status"]; ?></p>
                    <p><strong>Consegna Prevista:</strong> <?php echo $ordine["consegna_prevista"]; ?></p>
                    <p><strong>Spesa Complessiva:</strong> <?php echo number_format($ordine["spesa_complessiva"], 2); ?> €
                    </p>
                    <?php if ($templateParams["ruolo"] == "venditore"): ?>
                        <p><strong>Cliente:</strong> <?php echo $ordine["cliente"]; ?></p>
                        <a href="gestisci-ordine.php?id=<?php echo $ordine["id"]; ?>" class="btn btn-primary">Gestisci
                            Ordine</a>
                    <?php endif; ?>
                </div>
                <div class="col-12 col-md-3 text-center">
                    <img src="<?php echo UPLOAD_DIR . $ordine["prodotto_immagine"]; ?>" alt="Immagine del Prodotto"
                        class="img-fluid mb-2">
                    <a href="prodotto.php?id=<?php echo $ordine["prodotto_id"]; ?>" class="btn btn-link">Dettagli
                        Prodotto</a>
                </div>
                <div class="col-12 col-md-9">
                    <p><strong>Nome Prodotto:</strong> <?php echo $ordine["prodotto_nome"]; ?></p>
                    <p><strong>Quantità:</strong> <?php echo $ordine["quantita"]; ?></p>
                    <p><strong>Prezzo:</strong> <?php echo number_format($ordine["prezzo"], 2); ?> €</p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>