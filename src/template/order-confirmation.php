<section>
    <h2>Conferma Ordine</h2>
    <div class="container">
        <?php if (!empty($templateParams["formmsg"])): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $templateParams["formmsg"]; ?>
            </div>
        <?php endif; ?>
        <div class="row mb-4 p-3 border rounded bg-light">
            <div class="col-12 text-center">
                <h5>Il tuo ordine è stato completato con successo!</h5>
                <p>Puoi visualizzare i dettagli del tuo ordine nella pagina "I miei ordini".</p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-center">
                <a href="ordini.php" class="btn btn-primary me-2">I miei ordini</a>
                <a href="index.php" class="btn btn-secondary ms-2">Torna alla Home</a>
            </div>
        </div>
    </div>
</section>