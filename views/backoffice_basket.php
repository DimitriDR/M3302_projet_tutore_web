<?php
/**
 * @var array $fetch Tableau contenant l'ensemble des ID des produits présents dans la base de données
 */
require_once dirname(__DIR__) . "/controllers/backoffice_basket.php";
require_once dirname(__DIR__) . "/views/assets/includes/backoffice_header.php";
require_once dirname(__DIR__) . "/models/product.php";
?>
    <main class="container">
        <div class="card shadow-sm p-2">
            <div class="card-body">
                <h1 class="card-title">Création d'un nouveau panier</h1>

                <form method="POST" action="/controllers/backoffice_basket.php">

                    <!-- Champ pour les produits -->
                    <div class="col my-2">
                        <label for="products" class="form-label">Produits à mettre dans le panier</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-list fs-xs"></i></span>
                            <select id="products" name="products[]" class="form-select" multiple size="5">
                                <option>Sélectionner un ou plusieurs produits</option>
                                <?php foreach ($fetch as $row): ?>
                                <?php $product = new Product(); ?>
                                <?php $product->hydrate($row->id_product); ?>
                                <option name="<?= htmlspecialchars($product->get_label()) ?>"><?= htmlspecialchars($product->get_label()) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Champ pour le prix -->
                    <div class="col my-2">
                        <label for="price" class="form-label">Prix</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-euro-sign fs-xs"></i></span>
                            <input type="number" id="price" name="price" min="0" step="0.01" class="form-control">
                        </div>
                    </div>

                    <!-- Bouton de validation -->
                    <div class="col-12 my-2">
                        <button id="submit" name="submit" class="btn btn-primary"><i class="far fa-plus-circle fa-xs"></i> Créer un nouveau panier</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
<?php require_once "views/assets/includes/footer.php"; ?>