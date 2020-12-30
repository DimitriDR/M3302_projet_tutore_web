<?php
// Pour éviter les bugs avec les redirections
ob_start();

// Démarrage de la session sur toutes les pages
// On vérifie qu'une session soit ouverte
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Accès uniqueent aux administrateurs connectés
if(!isset($_SESSION["administrator"]) || !$_SESSION["administrator"]) {
    $_SESSION["flash"]["warning"] = "Vous devez être connecté en tant qu'administrateur pour accéder à cet espace.";
    header("Location: ../");
    exit;
}
require_once "models/user.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Encodage en UTF-8 pour éviter les problèmes d'accents -->
    <meta charset="UTF-8">
    <!-- Titre de la page -->
    <title>Charles Productions — Administration — <?= isset($page_title) ? htmlspecialchars(trim($page_title)) : "Page sans nom" ?></title>
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
            Administration
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
                <li class="nav-item"><a href="backoffice_add_product" class="nav-link"><i class="fad fa-plus fa-xs"></i> Ajouter un produit</a></li>
                <li class="nav-item"><a href="backoffice_list_products" class="nav-link"><i class="fad fa-list-ul fa-xs"></i> Liste des produits</a></li>
                <li class="nav-item"><a href="backoffice_list_orders" class="nav-link"><i class="fad fa-truck fa-xs"></i> Liste des commandes</a></li>
                <li class="nav-item"><a href="backoffice_manage_inventory" class="nav-link"><i class="fad fa-warehouse fa-xs"></i> Gestion du stock</a></li>
            </ul>

            <!-- Liens situés tout à droite -->
            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="/logout?token=<?= unserialize($_SESSION["user_information"])->get_token(); ?>" class="nav-link"><i class="fad fa-sign-out-alt fa-xs"></i> Déconnexion</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<?php require_once "common_header.php"; ?>