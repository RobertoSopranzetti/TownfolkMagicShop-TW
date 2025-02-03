<div class="container mt-5">
    <div class="text-center">
        <h1><strong>Bentrovato Commerciante!</strong></h1>
        <p>Gestisci i tuoi ordini, prodotti e altro dal tuo hub personale.</p>
    </div>
    <div class="row mt-4">
        <div class="col-12 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Ordini in Sospeso</h5>
                    <p class="card-text">Hai <?php echo $templateParams["ordiniInSospeso"] ?> ordini in sospeso da elaborare.</p>
                    <a href="ordini.php" class="btn btn-danger">Vai agli Ordini</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Notifiche Recenti</h5>
                    <p class="card-text">Hai <?php echo $templateParams["notificheNuove"] ?> nuove notifiche.</p>
                    <a href="notifiche.php" class="btn btn-danger">Visualizza Notifiche</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Prodotti in Esaurimento</h5>
                    <p class="card-text"><?php echo $templateParams["prodottiInEsaurimento"] ?> prodotti stanno per esaurirsi.</p>
                    <a href="dashboard.php?shortage=1" class="btn btn-danger">Visualizza Prodotti Esauriti</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Aggiungi Prodotto</h5>
                    <p class="card-text">Aggiungi nuovi prodotti al tuo inventario.</p>
                    <a href="gestisci-prodotti.php?action=1" class="btn btn-danger">Aggiungi Prodotto</a>
                </div>
            </div>
        </div>
    </div>
</div>