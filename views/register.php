<?php
$page_title = "Inscription";
require_once "views/assets/includes/header.php";
?>
<main class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="card-title">Inscription chez Charles</h1>
            <p>Vous avez déjà un compte ? <a href="login">Connectez-vous</a>.</p>
            <form method="POST" action="/controllers/register.php" class="row g-3">

                <div class="col-6">
                    <label for="last_name" class="form-label">Nom</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user fs-xs"></i></span>
                        <input type="text" id="last_name" name="last_name" class="form-control">
                    </div>
                </div>

                <div class="col-6">
                    <label for="first_name" class="form-label">Prénom</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user fs-xs"></i></span>
                        <input type="text" id="first_name" name="first_name" class="form-control">
                    </div>
                </div>

                <div class="col-6">
                    <label for="email_address" class="form-label">Adresse e-mail</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-at fs-xs"></i></span>
                        <input type="email" id="email_address" name="email_address" class="form-control">
                    </div>
                    <span class="form-text">Un e-mail de confirmation vous sera envoyé pour valider votre compte.</span>
                </div>

                <div class="col-6">
                    <label for="mobile_number" class="form-label">Numéro de téléphone</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-mobile-alt fs-xs"></i></span>
                        <input type="tel" id="mobile_number" name="mobile_number" class="form-control">
                    </div>
                    <span class="form-text">Ce numéro ne sert uniquement à vous contacter si nous avons un soucis avec votre commande.</span>
                </div>

                <div class="col-12">
                    <label for="password" class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key fs-xs"></i></span>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <span class="form-text">Le mot de passe doit faire au minimum 8 caractères et être composé d'au moins une lettre et un chiffre.</span>
                </div>

                <div class="col-12">
                    <label for="street_name" class="form-label">Adresse postale</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-home fs-xs"></i></span>
                        <input type="text" id="street_name" name="street_name" class="form-control">
                    </div>
                </div>

                <div class="col-6">
                    <label for="city" class="form-label">Ville</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-globe-europe fs-xs"></i></span>
                        <input type="text" id="city" name="city" class="form-control">
                    </div>
                </div>

                <div class="col-2">
                    <label for="zip_code" class="form-label">Code postal</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-pin fs-xs"></i></span>
                        <input type="text" id="zip_code" name="zip_code" class="form-control">
                    </div>
                </div>

                <div class="col-4">
                    <label for="district" class="form-label">Nom du quartier / Arrondissement</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-city fs-xs"></i></span>
                        <input type="text" id="district" name="district" class="form-control">
                    </div>
                </div>

                <div class="col-12">
                    <button name="submit" id="submit" class="btn btn-primary"><i class="fas fa-user-plus fs-xs"></i> Créer un compte</button>
                </div>

            </form>
        </div>
    </div>
</main>
<?php require_once "assets/includes/footer.php"; ?>