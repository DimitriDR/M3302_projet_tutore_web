<?php
/**
 * @var array $fetch Les résultats de la requête effectuée sur le contrôleur
 * @var string $page_title Le titre de la page
 * @version 1.0 Reviewed and compliant file
 */

$page_title = "Production locale et de saison";
require_once dirname(__DIR__) . "/controllers/index.php";
require_once dirname(__DIR__) . "/views/assets/includes/header.php";
require_once dirname(__DIR__) . "/models/product.php";
?>
<main class="vh-100">
    <section id="background" class="h-50 d-flex justify-content-center align-items-center">
        <form method="GET" action="/search" class="w-75">
            <div class="input-group input-group-lg">
                <span class="input-group-text"><i class="fad fa-search fs-xs"></i></span>
                <label for="q"></label>
                <input type="search" id="q" name="q" class="form-control shadow-sm rounded-end" placeholder="Rechercher un fruit, un légume, ..." autofocus>
            </div>
        </form>
    </section>

    <section class="container my-2">
        <h1 class="text-center display-4 my-4">Produits proposés</h1>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
            foreach ($fetch as $row):
            $product = new Product();
            $product->hydrate($row->id_product);
            ?>
            <div class="col-ms-1">
                <div class="card h-100">
                    <img src="/views/assets/images/products/<?= $product->get_file() ?>" class="card-img-top" alt="Image du produit « <?= htmlspecialchars($product->get_label()); ?> »">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product->get_label()) ?></h5>
                        <p class="text-muted card-text"><?= substr(htmlspecialchars($product->get_description()), 0, 100) ?>...</p>
                        <a href="/controllers/add_product_to_cart.php?id=<?= $product->get_id_product() ?>" class="btn btn-primary"> Ajouter au panier</a>
                        <a href="/product/<?= $product->get_id_product() ?>" class="btn btn-outline-primary"> Voir le détail</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="bg-dark text-white">
        <div class="container d-flex flex-column align-items-center justify-content-around">
            <h1 class="display-4 my-4">Votre panier hebdomadaire</h1>
            <h2 class="py-4">Livré chez vous, sans frais.</h2>
            <h4 class="py-2">Profitez d'un panier fait par Willy Wonka, récemment reconverti, avec des produits de saison !</h4>
            <h2 class="py-4">Produits de qualité à prix abordable !</h2>
            <a href="/basket" class="btn btn-lg btn-primary">Découvrir le panier du moment</a>
        </div>
    </section>
</main>
<?php require_once dirname(__DIR__) . "/views/assets/includes/footer.php"; ?>