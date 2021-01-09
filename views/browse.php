<?php
$page_title = "Liste des produits";
require_once dirname(__DIR__) . "/controllers/browse.php";
require_once dirname(__DIR__) . "/views/assets/includes/header.php";
?>
    <main class="container">
        <h1 class="text-center display-5 mb-5">Liste de nos produits</h1>

<!--        <section class="row">-->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
            if (!empty($products)):
                foreach ($products as $product_row):
                    $product = new Product();
                    $product->hydrate($product_row->id_product);
                    ?>
                    <div class="col-ms-1">
                        <div class="card h-100">
                            <img src="/views/assets/images/products/<?= $product->get_file_() ?>" class="card-img-top" alt="Image du produit « <?= htmlspecialchars($product->get_label()); ?> »">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product->get_label()) ?></h5>
                                <p class="text-muted card-text"><?= substr(htmlspecialchars($product->get_description()), 0, 100) ?>...</p>
                                <a href="/controllers/add_product_to_cart.php?id=<?= $product->get_id_product() ?>" class="btn btn-primary"> Ajouter au panier</a>
                                <a href="/product/<?= $product->get_id_product() ?>" class="btn btn-outline-primary"> Voir le détail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
<!--        </section>-->
    </main>
<?php require_once "views/assets/includes/footer.php"; ?>