<?php
/**
 * @var string $page_title Titre de la page (traitée par la page header.php)
 * @var Basket $basket Panier du moment
 * @version 1.0 Reviewed and compliant file
 */

$page_title = "Panier du moment";

require_once dirname(__DIR__) . "/controllers/basket.php";
require_once dirname(__DIR__) . "/models/basket.php";
require_once dirname(__DIR__) . "/views/assets/includes/header.php";
?>
<main class="container">
    <h1 class="text-center display-5 mt-5">Panier du moment (à <?= intval($basket->get_price()) ?> €)</h1>
    <h2 class="text-center display-6">Voici les produits proposés dans le panier</h2>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 g-3">
        <?php foreach ($basket->get_list_of_products() as $product): ?>
            <div class="col-ms-1">
                <div class="card h-100">
                    <img src="/views/assets/images/products/<?= $product->get_file() ?>" class="card-img-top" alt="Image du produit « <?= htmlspecialchars($product->get_label()); ?> »">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product->get_label()) ?></h5>
                        <p class="text-muted card-text"><?= substr(htmlspecialchars($product->get_description()), 0, 100) ?>...</p>
                        <a href="/product/<?= $product->get_id_product() ?>" class="btn btn-outline-primary"> Voir le détail</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <a href="#" class="btn btn-lg btn-primary">Ajouter le panier</a>
    </div>
</main>
<?php require_once "views/assets/includes/footer.php"; ?>