<?php
require_once dirname(__DIR__) . "/controllers/backoffice_add_product.php";
require_once dirname(__DIR__) . "/views/assets/includes/backoffice_header.php";
?>
    <main class="container">
        <div class="card shadow-sm p-2">
            <div class="card-body">
                <h1 class="card-title">Ajout d'un produit</h1>

                <form method="POST" action="/controllers/backoffice_add_product.php" enctype="multipart/form-data" class="row">

                    <!-- Champ pour le libellé -->
                    <div class="col-4 my-2">
                        <label for="label" class="form-label">Libellé</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-heading fs-xs"></i></span>
                            <input type="text" id="label" name="label" class="form-control">
                        </div>
                    </div>

                    <!-- Champ pour l'image -->
                    <div class="col-4 my-2">
                        <label for="image" class="form-label">Image d'illustration</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-image fs-xs"></i></span>
                            <input type="file" id="image" name="image" class="form-control">
                        </div>
                        <p class="text-muted">Seulement en .webp, .jpg, .jpeg, ou .png</p>
                    </div>

                    <!-- Champ pour le prix -->
                    <div class="col-2 my-2">
                        <label for="price" class="form-label">Prix</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-euro-sign fs-xs"></i></span>
                            <input type="number" id="price" name="price" min="0" step="0.01" class="form-control">
                        </div>
                    </div>

                    <!-- Champ pour l'unité -->
                    <div class="col-2 my-2">
                        <label for="unit" class="form-label">Unité</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-weight-hanging fs-xs"></i></span>
                            <select id="unit" name="unit" class="form-select">
                                <option value="/ kg">Au kilogr.</option>
                                <option value="la pièce">À la pièce</option>
                            </select>
                        </div>
                    </div>

                    <!-- Champ pour la saison -->
                    <div class="col-4 my-2">
                        <label for="season" class="form-label">Saison</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-cloud-sun-rain fs-xs"></i></span>
                            <select id="season" name="season" class="form-select">
                                <option value="Toute l'année">Toute l'année</option>
                                <option value="Hiver">Hiver</option>
                                <option value="Printemps">Printemps</option>
                                <option value="Été">Été</option>
                                <option value="Automne">Automne</option>
                            </select>
                        </div>
                    </div>

                    <!-- Champ pour la classification -->
                    <div class="col-4 my-2">
                        <label for="classification" class="form-label">Classification</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-tags fs-xs"></i></span>
                            <select id="classification" name="classification" class="form-select">
                                <option value="Composées">Composées</option>
                                <option value="Ombellifères">Ombellifères</option>
                                <option value="Liliacées">Liliacées</option>
                                <option value="Légumineuses">Légumineuses</option>
                                <option value="Chénopodiacées">Chénopodiacées</option>
                                <option value="Cucurbitacées">Cucurbitacées</option>
                                <option value="Solanacées">Solanacées</option>
                                <option value="Labiées">Labiées</option>
                                <option value="Crucifères">Crucifères</option>
                                <option value="Autres">Autres</option>
                            </select>
                        </div>
                    </div>

                    <!-- Champ pour le type -->
                    <div class="col-4 my-2">
                        <label for="type" class="form-label">Type</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-leaf fs-xs"></i></span>
                            <select id="type" name="type" class="form-select">
                                <option value="Légumes">Légumes</option>
                                <option value="Fruits">Fruits</option>
                            </select>
                        </div>
                    </div>

                    <!-- Champ pour la description -->
                    <div class="col-12 my-2">
                        <label for="description" class="form-label">Description</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-newspaper fs-xs"></i></span>
                            <textarea id="description" name="description" rows="5" class="form-control"></textarea>
                        </div>
                    </div>

                    <!-- Bouton de validation -->
                    <div class="col-12 my-2">
                        <button id="submit" name="submit" class="btn btn-primary"><i class="far fa-plus-circle fa-xs"></i> Ajouter un produit</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
<?php require_once "views/assets/includes/footer.php"; ?>