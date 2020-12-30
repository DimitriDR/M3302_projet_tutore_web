<?php
$page_title = "Modification de mes informations";

require_once "controllers/edit_my_information.php";
require_once "views/assets/includes/header.php";
?>
<main class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="card-title">Modification de mes informations</h1>
            <form method="POST" action="/controllers/edit_my_information.php" class="row g-3">

                <div class="col-6">
                    <label for="last_name" class="form-label">Nom</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="far fa-user fs-xs"></i></span>
                        <input type="text" id="last_name" name="last_name" class="form-control" value="<?= htmlspecialchars(unserialize($_SESSION["user_information"])->get_last_name()); ?>">
                    </div>
                </div>

                <div class="col-6">
                    <label for="first_name" class="form-label">Prénom</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="far fa-user fs-xs"></i></span>
                        <input type="text" id="first_name" name="first_name" class="form-control" value="<?= htmlspecialchars(unserialize($_SESSION["user_information"])->get_first_name()); ?>">
                    </div>
                </div>

                <div class="col-6">
                    <label for="email_address" class="form-label">Adresse e-mail</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="far fa-at fs-xs"></i></span>
                        <input type="email" id="email_address" name="email_address" class="form-control" value="<?= htmlspecialchars(unserialize($_SESSION["user_information"])->get_email_address()); ?>">
                    </div>
                </div>

                <div class="col-6">
                    <label for="mobile_number" class="form-label">Numéro de téléphone</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="far fa-mobile-alt fs-xs"></i></span>
                        <input type="tel" id="mobile_number" name="mobile_number" class="form-control" value="<?= htmlspecialchars(unserialize($_SESSION["user_information"])->get_mobile_number()); ?>">
                    </div>
                </div>

                <div class="col-12">
                    <label for="street_name" class="form-label">Adresse postale</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="far fa-home fs-xs"></i></span>
                        <input type="text" id="street_name" name="street_name" class="form-control" value="<?= htmlspecialchars(unserialize($_SESSION["user_information"])->get_street_name()); ?>">
                    </div>
                </div>

                <div class="col-6">
                    <label for="city" class="form-label">Ville</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="far fa-globe-europe fs-xs"></i></span>
                        <input type="text" id="city" name="city" class="form-control" value="<?= htmlspecialchars(unserialize($_SESSION["user_information"])->get_city()); ?>">
                    </div>
                </div>

                <div class="col-2">
                    <label for="zip_code" class="form-label">Code postal</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="far fa-map-pin fs-xs"></i></span>
                        <input type="text" id="zip_code" name="zip_code" class="form-control" value="<?= htmlspecialchars(unserialize($_SESSION["user_information"])->get_zip_code()); ?>">
                    </div>
                </div>

                <div class="col-4">
                    <label for="district" class="form-label">Nom du quartier / Arrondissement</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="far fa-city fs-xs"></i></span>
                        <input type="text" id="district" name="district" class="form-control" value="<?= htmlspecialchars(unserialize($_SESSION["user_information"])->get_district()); ?>">
                    </div>
                </div>

                <div class="col-12">
                    <button name="submit" id="submit" class="btn btn-primary"><i class="fal fa-user-edit fs-xs"></i> Modifier mes informations</button>
                </div>

            </form>
        </div>
    </div>
</main>
<?php require_once "assets/includes/footer.php"; ?>