<!DOCTYPE html>
<html lang="it">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $templateParams["titolo"]; ?></title>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header class="bg-primary text-white text-center py-1">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a class="navbar-brand d-lg-none" href="index.php"><i class="bi bi-house"></i></a>
                    <a class="navbar-brand d-none d-lg-block" href="index.php">Home</a>
                    <a class="navbar-brand d-lg-none" href="dashboard.php"><i class="bi bi-dice-5"></i></a>
                    <a class="navbar-brand d-none d-lg-block" href="dashboard.php">Dashboard</a>
                </div>
                <div class="flex-grow-1 mx-3 d-flex align-items-center position-relative">
                    <div class="input-group rounded-pill">
                        <span class="input-group-text bg-white border-0 rounded-pill-start"><i
                                class="bi bi-search"></i></span>
                        <input class="form-control border-0" type="search" id="search" placeholder="Cerca"
                            aria-label="Search">
                        <span class="input-group-text bg-white border-0 rounded-pill-end"><i
                                class="bi bi-mic"></i></span>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <?php echo getUserIcon($templateParams["ruolo"]) ?>
                    <a class="navbar-brand d-lg-none" href="login.php"><i class="bi bi-person"></i></a>
                    <?php if (isUserLoggedIn()): ?>
                        <a class="navbar-brand d-none d-lg-block" href="login.php">Ciao,
                            <?php echo $_SESSION["username"]; ?>!</a>
                    <?php else: ?>
                        <a class="navbar-brand d-none d-lg-block" href="login.php">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
    <div class="container mt-5 mb-5">
        <div class="row">
            <main id="main-content" class="col-12 col-md-8 order-md-1">
                <?php
                if (isset($templateParams["nome"])) {
                    require($templateParams["nome"]);
                }
                ?>
            </main>
            <div id="search-results" class="col-12 col-md-8 order-md-1 d-none"></div>
            <aside class="col-12 col-md-4 order-md-2 mt-5 mt-md-0 p-3 border rounded bg-light">
                <?php if ($templateParams["ruolo"] == "venditore"): ?>
                    <section>
                        <h2 class="text-center">Link Utili</h2>
                        <div class="d-grid gap-2">
                            <a href="notifiche.php" class="btn btn-primary">Gestisci notifiche</a>
                            <a href="ordini.php" class="btn btn-primary">Gestisci ordini</a>
                            <a href="dashboard.php" class="btn btn-primary">Gestisci prodotti</a>
                        </div>
                    </section>
                <?php else: ?>
                    <section>
                        <h2 class="text-center">Ti potrebbe interessare anche...</h2>
                        <div class="row">
                            <?php foreach ($templateParams["prodottiCasuali"] as $prodottocasuale): ?>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="card">
                                        <img src="<?php echo UPLOAD_DIR . $prodottocasuale["immagine"]; ?>" class="card-img-top"
                                            alt="<?php echo $prodottocasuale["titolo"]; ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $prodottocasuale["titolo"]; ?></h5>
                                            <a href="prodotto.php?id=<?php echo $prodottocasuale["id"]; ?>"
                                                class="btn btn-primary">Visualizza</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
            </aside>
        </div>
    </div>
    <footer class="bg-primary text-white text-center py-1">
        <p class="footer-text"> Townfolk Magic Shop - <?php echo date("Y"); ?></p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>