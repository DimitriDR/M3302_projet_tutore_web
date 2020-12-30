<?php
// On vérifie si un message flash existe
if (isset($_SESSION["flash"])):
    // On le parcours
    foreach ($_SESSION["flash"] as $type => $message):
        // Si c'est un message, on va faire un simple affichage
        if(is_string($message)):
?>
    <div class="alert alert-<?= $type ?> p-2 m-0 text-center">
        <?php if($type == "danger" || $type == "warning"): ?>
            <i class="fad fa-exclamation-triangle"></i> <?= trim($message) ?>
        <?php elseif($type == "success"): ?>
            <i class="fad fa-check-circle"></i> <?= trim($message) ?>
        <?php else: ?>
            <i class="fad fa-bell"></i> <?= trim($message) ?>
        <?php endif ?>
    </div>
<?php
// Si c'est un tableau (notamment un tableau contenant des erreurs), on le parcourt
else:
?>
    <div class="alert alert-<?= $type ?> py-4 m-0">
        <div class="container-md">
            <strong>Le formulaire comporte les erreurs suivantes :</strong><br />
            <?php foreach ($message as $single_error): ?>
                <li><?= htmlspecialchars($single_error) ?></li>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif ?>
<?php endforeach ?>
<?php endif ?>
<?php unset($_SESSION["flash"]) ?>