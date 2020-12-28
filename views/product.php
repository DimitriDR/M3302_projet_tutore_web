<?php
include_once "controllers/product.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Encodage en UTF-8 pour éviter les problèmes d'accents -->
    <meta charset="UTF-8">
    <!-- Titre de la page -->
    <title>Charles Productions — </title>
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <!-- CSS personnalisée -->
    <link rel="stylesheet" type="text/css" href="assets/css/common.css">
</head>
<body class="bg-light">
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="/">
                <img src="" alt="Logo" height="30" width="17" class="d-inline-block">
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
                        <li class="nav-item"><a href="cart.php" class="nav-link"><i data-feather="shopping-cart"></i> Panier (n)</a></li>
                        <?php if (!isset($_SESSION["user"])): ?>
                            <li class="nav-item"><a href="register.php" class="nav-link"><i data-feather="user-plus"></i> Inscription</a></li>
                            <li class="nav-item"><a href="login.php" class="nav-link"><i data-feather="unlock"></i> Connexion</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a href="dashboard.php" class="nav-link"><i data-feather="trello"></i> Tableau de bord</a></li>
                            <li class="nav-item"><a href="logout.php?token=<?= $_SESSION["user_token"] ?>" class="nav-link"><i data-feather="unlock"></i>
                                    Déconnexion</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <main class="container">
        <div class="row">
            <article class="col-10 card shadow-sm m-2">
                <div class="card-body">
                    <h1 class="card-title"><?= htmlspecialchars($product->get_label()); ?></h1>
                    <h2 class="py-2">Description de notre produit</h2>
                    <p><?= htmlspecialchars($product->get_description()); ?></p>
                    <h2 class="py-2">Autres informations</h2>
                    <ul>
                        <li><strong>Peut-être consommé de préférence en</strong> : <?= htmlspecialchars($product->get_season()); ?></li>
                        <li><strong>Classification</strong> : <?= htmlspecialchars($product->get_classification()); ?></li>
                    </ul>
                </div>
            </article>
            <aside class="col-auto card card-body shadow-sm m-2">
                <h2 class="text-muted"><?= (float) $product->get_price(); ?> / kg</h2>
                <button class="btn btn-primary w-100">Ajouter au panier</button>
            </aside>
        </div>
    </main>
</body>
</html>
