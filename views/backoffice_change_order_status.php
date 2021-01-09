<?php
require_once dirname(__DIR__) . "/controllers/common.start.session.php";
require_once dirname(__DIR__) . "/controllers/common.forwarding.php";
require_once dirname(__DIR__) . "/views/assets/includes/backoffice_header.php";

// On s'assure d'avoir ce qu'il faut dans les paramètres
if (empty($_GET["id"]) || empty($_GET["status"]) || !is_numeric($_GET["id"]) || !is_numeric($_GET["status"])) {
    $_SESSION["flash"]["warning"] = "Un ou plusieurs paramètres sont manquants.";
    header("Location: " . $GLOBALS["forwarding"]);
    exit;
}
?>
<main class="container">
    <h1>Confirmation</h1>
    <div class="card">
        <div class="card-body">
            <p>Êtes-vous sûr de vouloir effectuer cette action ?</p>
            <form method="POST" action="/controllers/backoffice_change_order_status?id=<?= intval($_GET["id"]) ?>&status=<?= intval($_GET["status"]) ?>">
                <button type="submit" id="submit" name="submit" class="btn btn-primary">Confirmer</button>
            </form>
        </div>
    </div>
</main>