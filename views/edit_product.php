<?php
require_once dirname(__DIR__) . "/controllers/edit_product.php";
require_once dirname(__DIR__) . "/views/assets/includes/header.php";
?>
    <main class="container">
        <div class="card shadow-sm p-2">
            <div class="card-body">
                <h1 class="card-title">Édition d'un produit</h1>

                <form method="POST" action="controllers/edit_product.php?id=<?= $_GET["id"]; ?>" class="row">

                    <!-- Champ pour le libellé -->
                    <div class="col-10 my-2">
                        <label for="label" class="form-label">Libellé</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-heading fs-xs"></i></span>
                            <input type="text" id="label" name="label" class="form-control" value="<?php if(isset($product)): echo htmlspecialchars(trim($product->get_label())); endif;?>">
                        </div>
                    </div>

                    <div class="col-2 my-2">
                        <label for="price" class="form-label">Prix au kg</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-euro-sign fs-xs"></i></span>
                            <input type="number" id="price" name="price" min="0" step="0.01" class="form-control" value="<?php if(isset($product)): echo htmlspecialchars(trim($product->get_price())); endif;?>">
                        </div>
                    </div>

                    <!-- Champ pour la saison -->
                    <div class="col-6 my-2">
                        <label for="season" class="form-label">Saison</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-cloud-sun-rain fs-xs"></i></span>
                            <select id="season" name="season" class="form-select">
                                <option value="Hiver" <?php if(isset($product) && $product->get_season() == "Hiver"): echo "selected"; endif; ?>>Hiver</option>
                                <option value="Printemps" <?php if(isset($product) && $product->get_season() == "Printemps"): echo "selected"; endif; ?>>Printemps</option>
                                <option value="Été" <?php if(isset($product) && $product->get_season() == "Été"): echo "selected"; endif; ?>>Été</option>
                                <option value="Automne" <?php if(isset($product) && $product->get_season() == "Automne"): echo "selected"; endif; ?>>Automne</option>
                            </select>
                        </div>
                    </div>

                    <!-- Champ pour la classification -->
                    <div class="col-6 my-2">
                        <label for="classification" class="form-label">Classification</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-tags fs-xs"></i></span>
                            <select id="classification" name="classification" class="form-select">
                                <option value="Composées" <?php if(isset($product) && $product->get_classification() == "Composées"): echo "selected"; endif; ?>>Composées</option>
                                <option value="Ombellifères" <?php if(isset($product) && $product->get_classification() == "Ombellifères"): echo "selected"; endif; ?>>Ombellifères</option>
                                <option value="Liliacées" <?php if(isset($product) && $product->get_classification() == "Liliacées"): echo "selected"; endif; ?>>Liliacées</option>
                                <option value="Légumineuses" <?php if(isset($product) && $product->get_classification() == "Légumineuses"): echo "selected"; endif; ?>>Légumineuses</option>
                                <option value="Chénopodiacées" <?php if(isset($product) && $product->get_classification() == "Chénopodiacées"): echo "selected"; endif; ?>>Chénopodiacées</option>
                                <option value="Cucurbitacées" <?php if(isset($product) && $product->get_classification() == "Cucurbitacées"): echo "selected"; endif; ?>>Cucurbitacées</option>
                                <option value="Solanacées" <?php if(isset($product) && $product->get_classification() == "Solanacées"): echo "selected"; endif; ?>>Solanacées</option>
                                <option value="Labiées" <?php if(isset($product) && $product->get_classification() == "Labiées"): echo "selected"; endif; ?>>Labiées</option>
                                <option value="Crucifères" <?php if(isset($product) && $product->get_classification() == "Crucifères"): echo "selected"; endif; ?>>Crucifères</option>
                                <option value="Autres" <?php if(isset($product) && $product->get_classification() == "Autres"): echo "selected"; endif; ?>>Autres</option>
                            </select>
                        </div>
                    </div>

                    <!-- Champ pour la description -->
                    <div class="col-12 my-2">
                        <label for="description" class="form-label">Description</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-newspaper fs-xs"></i></span>
                            <textarea id="description" name="description" rows="5" class="form-control"><?php if(isset($product)): echo htmlspecialchars(trim($product->get_description())); endif;?></textarea>
                        </div>
                    </div>

                    <!-- Bouton de validation -->
                    <div class="col-12 my-2">
                        <button id="submit" name="submit" class="btn btn-primary"><i class="fas fa-pen-alt fa-xs"></i> Éditer un produit</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
<?php require_once "views/assets/includes/footer.php"; ?>