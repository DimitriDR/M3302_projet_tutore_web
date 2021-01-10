<?php
/**
 * @var Search $search L'objet Search
 */
require_once dirname(__DIR__) . "/controllers/search.php";
require_once dirname(__DIR__) . "/views/assets/includes/header.php";
?>
<main class="container">
<h1 class="display-3 text-center my-5">Recherche de « <?= trim(htmlspecialchars($_GET["search"])) ?> »</h1>
<?php if(empty($search->get_results())): ?>
    <div class="alert alert-warning text-center">Aucun résultat n'a été trouvé pour votre recherche.</div>
<?php else: ?>
    <p class="text-muted">Nous avons trouvé <?= $search->get_number_of_results() ?> correspondant à votre recherche.</p>
    <section class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 d-flex justify-content-lg-start g-5">
    <?php
        foreach ($search->get_results() as $result):
        $product = new Product();
        $product->hydrate($result->id_product);
    ?>
        <div class="col">
            <div class="card">
                <img src="/views/assets/images/products/<?= $product->get_file() ?>" class="card-img-top" alt="Image du produit « <?= htmlspecialchars($product->get_label()); ?> »">
                <div class="card-body">
                    <h5 class="card-title"><?= trim(htmlspecialchars($product->get_label())) ?></h5>
                    <p class="text-muted card-text"><?= substr(htmlspecialchars($product->get_description()), 0, 100) ?>...</p>
                    <a href="/controllers/add_product_to_cart.php?id=<?= $product->get_id_product() ?>" class="btn btn-primary"> Ajouter au panier</a>
                    <a href="/product/<?= $product->get_id_product() ?>" class="btn btn-outline-primary"> En savoir plus</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </section>
<?php endif; ?>
</main>
<?php require_once dirname(__DIR__) . "/views/assets/includes/footer.php"; ?>