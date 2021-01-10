<?php
require_once dirname(__DIR__) . "/controllers/track_my_order.php";
require_once dirname(__DIR__) . "/controllers/common.forwarding.php";
require_once dirname(__DIR__) . "/views/assets/includes/header.php";

if (!isset($order)) {
    $_SESSION["flash"]["warning"] = "Une erreur s'est produite lors de la récupération de la dernière commande";
    header("Location: " . $GLOBALS["forwarding"]);
    exit;
}
?>
    <main class="container">
        <h1>Suivi de ma commande </h1>
        <h2>Informations</h2>
        <div class="card shadow-sm py-2 my-3">
            <div class="card-body">
                <ul>
                    <li><strong>Date de commande</strong> : <?= $order->get_raw_date() ?></li>
                    <li><strong>Statut</strong> : <?= $order->get_status(); ?></li>
                </ul>
            </div>
        </div>

        <h2>Produits</h2>
        <div class="card shadow-sm">
            <div class="card-body">
                <ul>
                    <?php display_all_products();  ?>
                </ul>
            </div>
        </div>
    </main>
<?php require_once dirname(__DIR__) . "/views/assets/includes/footer.php"; ?>