<?php
require_once dirname(__DIR__) . "/controllers/backoffice_edit_product_inventory.php";
require_once dirname(__DIR__) . "/controllers/common.forwarding.php";
require_once dirname(__DIR__) . "/views/assets/includes/backoffice_header.php";

if(!isset($product) || empty($product)) {
    $_SESSION["flash"]["warning"] = "Une erreur s'est produite lors de la récupération du produit.";
    header("Location: ". $GLOBALS["forwarding"]);
    exit;
}
?>
    <main class="container">
        <div class="card shadow-sm p-2">
            <div class="card-body">
                <h1 class="card-title">Gestion des stocks du produit : <?= $product->get_label() ?></h1>
                <p class="text-muted">Pour modifier les champs grisés, veuillez vous rendre sur <a href="backoffice_edit_product?id=<?= $_GET["id"]; ?>">cette page</a>.</p>

                <form method="POST" action="/controllers/backoffice_edit_product_inventory.php?id=<?= $_GET["id"]; ?>" class="row">

                    <!-- Champ pour le libellé -->
                    <div class="col-12 col-md-6 col-lg-4 my-2">
                        <label for="label" class="form-label">Libellé</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-heading fs-xs"></i></span>
                            <input type="text" id="label" name="label" class="form-control" value="<?= htmlspecialchars($product->get_label()) ?>" disabled>
                        </div>
                    </div>

                    <!-- Champ pour l'image -->
                    <div class="col-12 col-md-6 col-lg-4 my-2">
                        <label for="image" class="form-label">Image d'illustration</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-image fs-xs"></i></span>
                            <input type="file" id="image" name="image" class="form-control" disabled>
                        </div>
                        <p class="text-muted">Seulement en .webp, .jpg, .jpeg, ou .png</p>
                    </div>

                    <div class="col-12 col-md-12 col-lg-3 col-lg-4 my-2">
                        <label for="price" class="form-label">Prix</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-euro-sign fs-xs"></i></span>
                            <input type="number" id="price" name="price" min="0" step="0.01" class="form-control" value="<?= htmlspecialchars($product->get_price()) ?>" disabled>
                        </div>
                    </div>

                    <!-- Champ pour l'unité -->
                    <div class="col-12 col-md-6 col-lg-3 col-xl-3 my-2">
                        <label for="unit" class="form-label">Unité</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-weight-hanging fs-xs"></i></span>
                            <select id="unit" name="unit" class="form-select" disabled>
                                <option value="Le kilo" <?php if($product->get_unit() == "Le kilo"): echo "selected"; endif; ?>>Au kilogr.</option>
                                <option value="À la pièce" <?php if($product->get_unit() == ""): echo "selected"; endif; ?>>À la pièce</option>
                            </select>
                        </div>
                    </div>

                    <!-- Champ pour la saison -->
                    <div class="col-12 col-md-6 col-lg-3 col-xl-3 my-2">
                        <label for="season" class="form-label">Saison</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-cloud-sun-rain fs-xs"></i></span>
                            <select id="season" name="season" class="form-select" disabled>
                                <option value="Hiver" <?php if($product->get_season() == "Hiver"): echo "selected"; endif; ?>>Hiver</option>
                                <option value="Printemps" <?php if($product->get_season() == "Printemps"): echo "selected"; endif; ?>>Printemps</option>
                                <option value="Été" <?php if($product->get_season() == "Été"): echo "selected"; endif; ?>>Été</option>
                                <option value="Automne" <?php if($product->get_season() == "Automne"): echo "selected"; endif; ?>>Automne</option>
                            </select>
                        </div>
                    </div>

                    <!-- Champ pour la classification -->
                    <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                        <label for="classification" class="form-label">Classification</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-tags fs-xs"></i></span>
                            <select id="classification" name="classification" class="form-select" disabled>
                                <option value="Composées" <?php if($product->get_classification() == "Composées"): echo "selected"; endif; ?>>Composées</option>
                                <option value="Ombellifères" <?php if($product->get_classification() == "Ombellifères"): echo "selected"; endif; ?>>Ombellifères</option>
                                <option value="Liliacées" <?php if($product->get_classification() == "Liliacées"): echo "selected"; endif; ?>>Liliacées</option>
                                <option value="Légumineuses" <?php if($product->get_classification() == "Légumineuses"): echo "selected"; endif; ?>>Légumineuses</option>
                                <option value="Chénopodiacées" <?php if($product->get_classification() == "Chénopodiacées"): echo "selected"; endif; ?>>Chénopodiacées</option>
                                <option value="Cucurbitacées" <?php if($product->get_classification() == "Cucurbitacées"): echo "selected"; endif; ?>>Cucurbitacées</option>
                                <option value="Solanacées" <?php if($product->get_classification() == "Solanacées"): echo "selected"; endif; ?>>Solanacées</option>
                                <option value="Labiées" <?php if($product->get_classification() == "Labiées"): echo "selected"; endif; ?>>Labiées</option>
                                <option value="Crucifères" <?php if($product->get_classification() == "Crucifères"): echo "selected"; endif; ?>>Crucifères</option>
                                <option value="Autres" <?php if($product->get_classification() == "Autres"): echo "selected"; endif; ?>>Autres</option>
                            </select>
                        </div>
                    </div>

                    <!-- Champ pour le type -->
                    <div class="col-12 col-md-6 col-lg-3 col-xl-3 my-2">
                        <label for="type" class="form-label">Type</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-leaf fs-xs"></i></span>
                            <select id="type" name="type" class="form-select" disabled>
                                <option value="Légumes" <?php if($product->get_type() == "Légumes"): echo "selected"; endif; ?>>Légumes</option>
                                <option value="Fruits" <?php if($product->get_type() == "Fruits"): echo "selected"; endif; ?>>Fruits</option>
                            </select>
                        </div>
                    </div>

                    <!-- Champ pour la description -->
                    <div class="col-12 my-2">
                        <label for="description" class="form-label">Description</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-newspaper fs-xs"></i></span>
                            <textarea id="description" name="description" rows="5" class="form-control" disabled><?= htmlspecialchars($product->get_description()) ?></textarea>
                        </div>
                    </div>

                    <!-- Champ pour la quantité disponible -->
                    <div class="col-12 col-md-6 my-2">
                        <label for="quantity" class="form-label">Quantité disponible immédiatement</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-boxes fs-xs"></i></span>
                            <input type="number" id="quantity" name="quantity" min="0" step="1" class="form-control" value="<?= htmlspecialchars($product->get_number_in_inventory()) ?>">
                        </div>
                    </div>

                    <!-- Champ pour la promotion -->
                    <div class="col-12 col-md-6 my-2">
                        <label for="discount_rate" class="form-label">Promotion</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-percent fs-xs"></i></span>
                            <input type="number" id="discount_rate" name="discount_rate" min="0" class="form-control" value="<?= htmlspecialchars($product->get_discount_rate()) ?>">
                        </div>
                    </div>

                    <!-- Bouton de validation -->
                    <div class="col-12 my-2">
                        <button id="submit" name="submit" class="btn btn-primary"><i class="fas fa-truck-loading fa-xs"></i> Modifier l'inventaire</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
<?php require_once "views/assets/includes/footer.php"; ?>