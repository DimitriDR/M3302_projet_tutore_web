<?php
// Pour éviter les bugs avec les redirections
ob_start();

require_once dirname(dirname(dirname(__DIR__))) ."/controllers/common.start.session.php";

// Fichiers nécessaires
require_once dirname(dirname(dirname(__DIR__))) ."/models/cart.php";
require_once dirname(dirname(dirname(__DIR__))) ."/models/user.php";
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
                Charles Production
<!--           <img src="" alt="Logo" height="30" width="17" class="d-inline-block">-->
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
                    <a href="/browse" class="nav-link"><i class="fad fa-th-list fa-xs"></i> Parcourir les articles</a>
                </li>
            </ul>

            <!-- Liens situés tout à droite -->
            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="/cart" class="nav-link"><i class="fal fa-shopping-basket fa-xs"></i> Panier <?php if(isset($_SESSION["user_information"])): echo "(" . unserialize($_SESSION["cart"])->get_number_of_items() . ")"; endif; ?></a></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="user_dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fal fa-user fa-xs"></i></a>
                        <ul class="dropdown-menu" aria-labelledby="user_dropdown">
                            <?php if (!isset($_SESSION["user_information"])): ?>
                                <li><a href="/register" class="dropdown-item"><i class="fas fa-user-plus fa-xs"></i> Inscription</a></li>
                                <li><a href="/login" class="dropdown-item"><i class="fas fa-user fa-xs"></i> Connexion</a></li>
                            <?php else: ?>
                                <li><a href="/my_orders" class="dropdown-item"><i class="fad fa-file-invoice fa-xs"></i> Mes commandes</a></li>
                                <li><a href="/track_my_order" class="dropdown-item"><i class="fad fa-truck fa-xs"></i> Suivre ma dernière commande</a></li>
                                <li><a href="/edit_my_information" class="dropdown-item"><i class="fad fa-user fa-xs"></i> Éditer mes informations</a></li>
                                <li><a href="/edit_my_banking_information" class="dropdown-item"><i class="fad fa-credit-card fa-xs"></i> Éditer mes informations de paiement</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a href="/logout.php?token=<?= unserialize($_SESSION["user_information"])->get_token(); ?>" class="dropdown-item"><i class="fad fa-sign-out-alt fa-xs"></i> Déconnexion</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<?php require_once "common_header.php"; ?>
<!-- <?php // echo "<pre>"; print_r(unserialize($_SESSION["user_information"])); echo "</pre>"; ?> -->