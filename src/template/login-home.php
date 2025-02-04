<section class="container mt-5">
    <div class="text-center">
        <h1 class="mb-4">Ciao <?php echo $_SESSION["username"]; ?>! Come posso aiutarti?</h1>
        <div class="d-grid gap-2 d-md-block mt-4">
            <a href="index.php" class="btn btn-primary btn-lg me-md-2 mb-2" aria-label="Torna alla Home">
                <i class="bi bi-house"></i> Torna alla Home
            </a>
            <a href="ordini.php" class="btn btn-primary btn-lg me-md-2 mb-2" aria-label="Vedi Ordini">
                <i class="bi bi-card-list"></i> Vedi Ordini
            </a>
            <a href="notifiche.php" class="btn btn-primary btn-lg me-md-2 mb-2" aria-label="Vedi Notifiche">
                <i class="bi bi-bell"></i> Vedi Notifiche
            </a>
            <form action="logout.php" method="POST" class="d-inline">
                <button type="submit" class="btn btn-primary btn-lg me-md-2 mb-2" aria-label="Logout">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>
</section>