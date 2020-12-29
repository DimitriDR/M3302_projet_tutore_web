<?php
require_once dirname(__DIR__) . "/controllers/backoffice_list_products.php";
require_once dirname(__DIR__) . "/views/assets/includes/backoffice_header.php";
?>
<main class="container">
    <div class="card shadow-sm p-2">
        <div class="card-body">
            <h1 class="card-title">Liste des produits</h1>
            <p>Envie d'ajouter des produits ? C'est <a href="backoffice_add_product.php">ici</a>.</p>
            <table class="table table-bordered table-striped text-center">
                <thead>
                <tr>
                    <th class="col">Libellé</th>
                    <th class="col">Type</th>
                    <th class="col">Saison</th>
                    <th class="col">Classification</th>
                    <th class="col">Prix</th>
                    <th class="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php display_all_products() ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php require_once dirname(__DIR__) . "/views/assets/includes/footer.php"; ?>

