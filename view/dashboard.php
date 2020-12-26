<?php
$page_title = "Charles&Co. – Tableau de bord";

require_once "includes/header.php";

if (!isset($_SESSION["user"])) {
    $_SESSION["flash"]["warning"] = "<i data-feather='alert-triangle'></i> Vous devez être connecté pour accéder à cet espace.</i>";
    header("Location: index.php");
}
?>
    <main class="container">
        <div class="card">
            <div class="card-body shadow-sm">
                <h1 class="card-title">Mes informations</h1>
                <div class="row g-3">
                    <div class="col-12">
                        <ul>
                            <li><a href="dashboard_edit_information.php">Modifier mes informations</a></li>
                            <li><a href="dashboard_edit_password.php" class="link">Modifier mon mot de passe</a></li>
                            <li><a href="dashboard_edit_payment_information.php">Modifier mes informations de paiement</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php require_once "includes/footer.php"; ?>