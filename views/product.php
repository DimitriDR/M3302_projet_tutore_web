<?php
require_once dirname(__DIR__) . "/controllers/product.php";
$page_title = "Connexion";
require_once "views/assets/includes/header.php";
?>
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
                <form method="POST" action="../controllers/add_product_to_cart.php">
                    <input type="hidden" id="id" name="id" value="<?= $_GET['id'] ?>">
                    <button id="add" name="add" class="btn btn-primary"><i class="fad fa-cart-plus fa-xs"></i> Ajouter au panier</button>
                </form>
            </aside>
        </div>
    </main>
<?php require_once "views/assets/includes/footer.php"; ?>