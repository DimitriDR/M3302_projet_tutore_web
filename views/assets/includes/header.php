<?php
// Pour éviter les bugs avec les redirections
ob_start();

// Démarrage de la session sur toutes les pages
// On vérifie qu'une session soit ouverte
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fichiers nécessaires
require_once "models/cart.php";
require_once "models/user.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Encodage en UTF-8 pour éviter les problèmes d'accents -->
    <meta charset="UTF-8">
    <!-- Titre de la page -->
    <title>Charles Productions — <?= isset($page_title) ? htmlspecialchars(trim($page_title)) : "Page sans nom" ?></title>
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" type="text/css" href="/views/assets/css/bootstrap.css">
    <!-- CSS personnalisée -->
    <link rel="stylesheet" type="text/css" href="/views/assets/css/common.css">
</head>
<body class="bg-light">
<!-- Barre de navigation -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
    <div class="container-md">
        <!-- Logo -->
        <a class="navbar-brand" href="/">
            <!-- test <img src="" alt="Logo" height="30" width="17" class="d-inline-block"> -->
        </a>

        <!-- Le bouton pour activer le menu sur mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="topbar"
                aria-expanded="false" aria-label="Afficher le menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Liens situés à gauche (à côté du logo) -->
        <div class="collapse navbar-collapse" id="topbar">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a href="browse.php" class="nav-link">Parcourir les articles</a>
                </li>
            </ul>

            <!-- Liens situés tout à droite -->
            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="/cart" class="nav-link"><i class="fas fa-shopping-basket fa-xs"></i> Panier <?php if(isset($_SESSION["user_information"])): echo "(" . unserialize($_SESSION["cart"])->get_number_of_items() . ")"; endif; ?></a></li>
                    <?php if (!isset($_SESSION["user_information"])): ?>
                        <li class="nav-item"><a href="/register" class="nav-link"><i class="fas fa-user-plus fa-xs"></i> Inscription</a></li>
                        <li class="nav-item"><a href="/login" class="nav-link"><i class="fas fa-user fa-xs"></i> Connexion</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a href="/dashboard" class="nav-link"><i class="fas fa-columns fa-xs"></i> Tableau de bord</a></li>
                        <li class="nav-item"><a href="/logout?token=<?= unserialize($_SESSION["user_information"])->get_token(); ?>" class="nav-link"><i class="fas fa-sign-out-alt fa-xs"></i> Déconnexion</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</nav>
<?php if (isset($_SESSION["flash"])): ?>
    <?php foreach ($_SESSION["flash"] as $type => $message): ?>
            <div class="alert alert-<?= $type ?> px-2">
                <?php
                if (is_string($message)) {
                    echo $message;
                } else {
                    echo "<strong>Le formulaire comporte les erreurs suivantes :</strong><br />";
                    echo "<ul>";
                    foreach ($message as $item) {
                        echo "<li>" . htmlspecialchars($item) . "</li>";
                    }
                    echo "</ul>";
                }
                ?>
            </div>
    <?php endforeach; ?>
    <?php unset($_SESSION["flash"]); ?>
<?php endif; ?>
