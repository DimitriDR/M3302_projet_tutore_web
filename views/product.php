<?php
require_once dirname(__DIR__) . "/controllers/product.php";
require_once dirname(__DIR__) . "/controllers/common.forwarding.php";
require_once dirname(__DIR__) . "/views/assets/includes/header.php";

if (!isset($product) || empty($product)) {
    $_SESSION["flash"]["danger"] = "Une erreur s'est produite lors de la génération de la fiche produit";
    header("Location: " . $GLOBALS["forwarding"]);
    exit;
} else {
    $page_title = "Produit : " . $product->get_label();
}
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
            <article class="col-lg-9 card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title"><?= htmlspecialchars($product->get_label()); ?> <span class="text-muted">(<?= (float)$product->get_price(); ?> € <?= $product->get_unit() ?>)</span></h1>
                    <p><?= htmlspecialchars($product->get_description()); ?></p>

                    <h2 class="py-2">Autres informations</h2>
                    <ul>
                        <li><strong>Peut-être consommé de préférence en</strong> : <?= htmlspecialchars($product->get_season()); ?></li>
                        <li><strong>Classification</strong> : <?= htmlspecialchars($product->get_classification()); ?></li>
                    </ul>
                </div>
            </article>
            
            <aside class="col-lg-3">
                <div class="card h-100 shadow-sm mx-2 d-flex flex-column justify-content-center align-items-center">
                    <div class="card-img-top">
                        <img src="/views/assets/images/products/<?= $product->get_file() ?>"  alt="Image du produit « <?= $product->get_label() ?> »" style="width: 100%"/>
                    </div>
                    <div class="card-body p-4">
                    <form method="POST" action="../controllers/add_product_to_cart.php" class="d-flex flex-column justify-content-center align-items-center">
                        <input type="hidden" id="id" name="id" value="<?= $_GET['id'] ?>">
                        <label for="quantity" class="form-label">Saisir la quantité souhaitée</label><input type="number" id="quantity" min="0" step="1" name="quantity" placeholder="1" class="form-control">
                        <button id="add" name="add" class="btn btn-large btn-primary w-100 my-2"><i class="fad fa-cart-plus fa-xs"></i> Ajouter au panier</button>
                    </form>
                    </div>
                </div>
            </aside>
        </div>
    </main>
<?php require_once "views/assets/includes/footer.php"; ?>