<?php
$isVenditore = isset($templateParams["isVenditore"]) && $templateParams["isVenditore"];
$details = getRegistrationDetails($isVenditore); ?>
<div class="container mt-5 mb-5 p-3 border rounded bg-light">
<h2 class="text-center"><?php echo $details['titolo']; ?></h2>
    <?php if (isset($templateParams["erroreregistrazione"])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $templateParams["erroreregistrazione"]; ?>
        </div>
    <?php endif; ?>
    <p class="text-center">Compila i seguenti campi:</p>
    <?php echo $details['linkVenditore']; ?>
    <form action="#" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label d-none d-lg-block">Username:</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label d-none d-lg-block">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <label for="nome" class="form-label d-none d-lg-block">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
        </div>
        <div class="mb-3">
            <label for="cognome" class="form-label d-none d-lg-block">Cognome:</label>
            <input type="text" class="form-control" id="cognome" name="cognome" placeholder="Cognome" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label d-none d-lg-block">Password:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>
        <div class="mb-3">
            <label for="conferma_password" class="form-label d-none d-lg-block">Conferma Password:</label>
            <input type="password" class="form-control" id="conferma_password" name="conferma_password" placeholder="Conferma Password" required>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Registrati</button>
        </div>
    </form>
</div>