<form action="#" method="POST" class="container mt-5">
    <h2 class="text-center">Login</h2>
    <?php if (isset($templateParams["errorelogin"])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $templateParams["errorelogin"]; ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="identifier" class="form-label">Username o Email:</label>
        <input type="text" class="form-control" id="identifier" name="identifier" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Invia</button>
    </div>
    <p class="text-center mt-3">Non hai un account? <a href="registra-cliente.php">Registrati</a></p>
</form>