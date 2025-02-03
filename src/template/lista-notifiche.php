<section>
    <h2>Centro notifiche</h2>
    <div class="container">
        <?php if (!empty($templateParams["formmsg"])): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $templateParams["formmsg"]; ?>
            </div>
        <?php endif; ?>
        <?php if (count($templateParams["notifiche"]) > 0): ?>
            <ul class="list-group">
                <?php foreach ($templateParams["notifiche"] as $notifica): ?>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-1"><?php echo $notifica["messaggio"]; ?></p>
                                <small class="text-muted"><?php echo $notifica["data_creazione"]; ?></small>
                            </div>
                            <div>
                                <?php if ($notifica["id_stato_notifica"] == 1): // non letta ?>
                                    <a href="notifiche.php?action=1&id=<?php echo $notifica["id"]; ?>"
                                        class="btn btn-sm btn-outline-primary me-2">
                                        <i class="bi bi-check-circle"></i> Segna come letto
                                    </a>
                                <?php else: // letta ?>
                                    <a href="notifiche.php?action=2&id=<?php echo $notifica["id"]; ?>"
                                        class="btn btn-sm btn-outline-secondary me-2">
                                        <i class="bi bi-x-circle"></i> Segna come non letto
                                    </a>
                                <?php endif; ?>
                                <a href="notifiche.php?action=3&id=<?php echo $notifica["id"]; ?>"
                                    class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Elimina
                                </a>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                Non hai notifiche.
            </div>
        <?php endif; ?>
    </div>
</section>