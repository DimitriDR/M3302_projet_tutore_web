<?php
require_once dirname(__DIR__) . "/controllers/product.php";

if (!isset($product) || empty($product)) {
    $_SESSION["flash"]["danger"] = "Une erreur s'est produite lors de la génération de la fiche produit";
    header("Location: ". $_SERVER["HTTP_REFERER"]);
    exit;
} else {
    $page_title = "Produit : ". $product->get_label();
}

require_once "views/assets/includes/header.php";
?>
    <main class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                <li class="breadcrumb-item"><a href="/browse">Produits</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($product->get_label()) ?></li>
            </ol>
        </nav>
        <div class="row">
            <article class="col-10 card shadow-sm">
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