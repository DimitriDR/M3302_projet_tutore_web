<?php
if (isset($_SESSION["flash"])):
    foreach ($_SESSION["flash"] as $type => $message):
?>
        <div class="alert alert-<?= $type ?> px-2">
            <?php if (is_string($message)): ?>
                <?= $message ?>
            <?php else: ?>
                <strong>Le formulaire comporte les erreurs suivantes :</strong><br />
                <ul>
                <?php foreach ($message as $item): ?>
                    <li><?= htmlspecialchars($item) ?></li>
                <?php endforeach; ?>
                </ul>
            <?php endif ?>
        </div>
    <?php endforeach ?>
<?php endif ?>
<?php unset($_SESSION["flash"]) ?>