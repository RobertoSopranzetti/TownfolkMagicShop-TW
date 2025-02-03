<section class="container my-4">
    <div class="row">
        <?php if ($templateParams["ruolo"] == "cliente"): ?>
            <div class="col-12 col-md-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="me-3">Filtri</h2>
                    <a href="dashboard.php" class="text-danger">Rimuovi tutto</a>
                </div>
                <div class="mb-3">
                    <?php if ($templateParams["selectedCategory"]): ?>
                        <button class="btn btn-outline-primary me-2 mb-2">
                            Categoria: <?php echo $templateParams["selectedCategory"]; ?> <a
                                href="<?php echo buildQuery('dashboard.php', updateQueryParams(['categoria' => ''])); ?>"
                                class="ms-1">&times;</a>
                        </button>
                    <?php endif; ?>
                    <?php if ($templateParams["selectedMaxPrice"] != $templateParams["prezzoMax"]): ?>
                        <button class="btn btn-outline-primary me-2 mb-2">
                            Prezzo: <?php echo $templateParams["prezzoMin"]; ?> -
                            <?php echo $templateParams["selectedMaxPrice"]; ?> € <a
                                href="<?php echo buildQuery('dashboard.php', updateQueryParams(['prezzoMin' => $templateParams["prezzoMin"], 'prezzoMax' => $templateParams["prezzoMax"]])); ?>"
                                class="ms-1">&times;</a>
                        </button>
                    <?php endif; ?>
                    <?php if ($templateParams["limitedEdition"]): ?>
                        <button class="btn btn-outline-primary me-2 mb-2">
                            Edizione Limitata <a
                                href="<?php echo buildQuery('dashboard.php', updateQueryParams(['edizioneLimitata' => ''])); ?>"
                                class="ms-1">&times;</a>
                        </button>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <select class="form-select w-100" style="min-width: 200px;" onchange="location = this.value;">
                        <option value="dashboard.php" <?php echo !$templateParams["selectedCategory"] ? 'selected' : ''; ?>>
                            Seleziona Categoria</option>
                        <?php foreach ($templateParams["categorie"] as $categoria): ?>
                            <option
                                value="<?php echo buildQuery('dashboard.php', updateQueryParams(['categoria' => $categoria["id"]])); ?>"
                                <?php echo $templateParams["selectedCategory"] == $categoria["id"] ? 'selected' : ''; ?>>
                                <?php echo $categoria["nome"]; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="priceRange" class="form-label">Fascia di Prezzo</label>
                    <input type="range" class="form-range" min="<?php echo $templateParams["prezzoMin"]; ?>"
                        max="<?php echo $templateParams["prezzoMax"]; ?>"
                        value="<?php echo $templateParams["selectedMaxPrice"]; ?>" id="priceRange"
                        onchange="location = '<?php echo buildQuery('dashboard.php', updateQueryParams(['prezzoMin' => $templateParams["prezzoMin"], 'prezzoMax' => ''])); ?>&prezzoMax=' + this.value;">
                    <div class="d-flex justify-content-between">
                        <span><?php echo $templateParams["prezzoMin"]; ?> €</span>
                        <span><?php echo $templateParams["prezzoMax"]; ?> €</span>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="limitedEdition" <?php echo $templateParams["limitedEdition"] ? 'checked' : ''; ?>
                        onchange="location = '<?php echo buildQuery('dashboard.php', updateQueryParams(['edizioneLimitata' => $templateParams["limitedEdition"] ? '' : '1'])); ?>';">
                    <label class="form-check-label" for="limitedEdition">Edizione Limitata</label>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-12 <?php echo $templateParams["ruolo"] == "cliente" ? 'col-md-9' : ''; ?>">
            <div class="row">
                <?php foreach ($templateParams["prodotti"] as $prodotto): ?>
                    <div class="col-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo UPLOAD_DIR . $prodotto["immagine"]; ?>"
                                alt="<?php echo $prodotto["nome"]; ?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $prodotto["nome"]; ?></h5>
                                <p class="card-text"><?php echo number_format($prodotto["prezzo"], 2); ?> €</p>
                                <?php if ($templateParams["ruolo"] == "venditore"): ?>
                                    <?php if ($prodotto["edizione_limitata"] != 1): ?>
                                        <a href="gestisci-prodotti.php?action=2&id=<?php echo $prodotto["id"]; ?>"
                                            class="btn btn-primary">Modifica</a>
                                    <?php endif; ?>
                                    <a href="gestisci-prodotti.php?action=3&id=<?php echo $prodotto["id"]; ?>"
                                        class="btn btn-danger">Elimina</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>