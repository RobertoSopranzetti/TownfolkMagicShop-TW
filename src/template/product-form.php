<?php
$prodotto = $templateParams["prodotto"];
$azione = getAction($templateParams["azione"]);
$categorie = $templateParams["categorie"];
?>
<form action="processa-prodotto.php" method="POST" enctype="multipart/form-data">
    <h2>Gestisci Prodotto</h2>
    <?php if ($prodotto == null): ?>
        <p>Prodotto non trovato</p>
    <?php else: ?>
        <div class="mb-3">
            <label for="nomeProdotto" class="form-label">Nome del Prodotto</label>
            <input type="text" class="form-control" name="nomeProdotto" id="nomeProdotto"
                value="<?php echo $prodotto['titolo']; ?>" placeholder="Nome" aria-label="Nome del Prodotto">
        </div>
        <div class="mb-3">
            <label for="descrizione" class="form-label">Descrizione</label>
            <textarea class="form-control" name="descrizione" id="descrizione"
                rows="3" aria-label="Descrizione del Prodotto"><?php echo $prodotto['descrizione']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="prezzo" class="form-label">Prezzo</label>
            <input type="number" class="form-control" name="prezzo" id="prezzo" step="0.01"
                value="<?php echo $prodotto['prezzo']; ?>" placeholder="Prezzo" aria-label="Prezzo del Prodotto">
        </div>
        <div class="mb-3">
            <label for="sconto" class="form-label">Sconto</label>
            <input type="number" class="form-control" name="sconto" id="sconto" step="0.01"
                value="<?php echo $prodotto['sconto']; ?>" placeholder="Sconto" aria-label="Sconto del Prodotto">
        </div>
        <div class="mb-3">
            <label for="quantita" class="form-label">Quantità Disponibile</label>
            <input type="number" class="form-control" name="quantita" id="quantita"
                value="<?php echo $prodotto['quantita_disponibile']; ?>" placeholder="Quantità" aria-label="Quantità Disponibile">
        </div>
        <div class="mb-3">
            <label class="form-label">Categoria</label>
            <div>
                <?php foreach ($categorie as $categoria): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="categoria"
                            id="categoria_<?php echo $categoria["id"]; ?>" value="<?php echo $categoria["id"]; ?>"
                            <?php echo $prodotto['id_categoria'] == $categoria["id"] ? 'checked' : ''; ?> aria-label="Categoria <?php echo $categoria["nome"]; ?>">
                        <label class="form-check-label" for="categoria_<?php echo $categoria["id"]; ?>">
                            <?php echo $categoria["nome"]; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="immagine" class="form-label">Immagine del Prodotto</label>
            <input type="file" class="form-control" name="immagine" id="immagine" aria-label="Immagine del Prodotto">
            <?php if ($azione == 'Modifica' && !empty($prodotto['immagine'])): ?>
                <div class="mt-3">
                    <img src="<?php echo UPLOAD_DIR . $prodotto['immagine']; ?>" alt="Immagine del Prodotto" class="img-thumbnail"
                        style="max-width: 150px;">
                </div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary"><?php echo $azione; ?> Prodotto</button>
        </div>
        <?php if ($azione == 'Modifica'): ?>
            <input type="hidden" name="id" value="<?php echo $prodotto['id']; ?>">
        <?php endif; ?>
        <input type="hidden" name="azione" value="<?php echo $azione; ?>">
    <?php endif; ?>
</form>