<?php
$page_title = "Charles&Co. – Inscription";
require_once "includes/header.php";
if(isset($_SESSION["user"])) {
    $_SESSION["flash"]["warning"] = "Vous avez déjà un compte chez nous, car vous êtes connecté en ce moment même. <i data-feather='smile'></i>";
    header("Location: index.php");
}
?>
    <main class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title">Inscription chez Charles</h1>
                <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous</a>.</p>
                <form method="POST" action="../controller/register.php" class="row g-3">

                    <div class="col-6">
                        <label for="last_name" class="form-label">Nom</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="user"></i></span>
                            <input type="text" name="last_name" id="last_name" value="<?php isset($_POST["last_name"]) ? htmlspecialchars(trim($_POST["last_name"])) : null ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-6">
                        <label for="first_name" class="form-label">Prénom</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="user"></i></span>
                            <input type="text" name="first_name" id="first_name" value="<?php isset($_POST["first_name"]) ? htmlspecialchars(trim($_POST["first_name"])) : null ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-6">
                        <label for="email_address" class="form-label">Adresse e-mail</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="at-sign"></i></span>
                            <input type="email" name="email_address" id="email_address" value="<?php isset($_POST["email_address"]) ? htmlspecialchars(trim($_POST["email_address"])) : null ?>" class="form-control">
                        </div>
                        <span class="form-text">Un e-mail de confirmation vous sera envoyé pour valider votre compte.</span>
                    </div>

                    <div class="col-6">
                        <label for="mobile_number" class="form-label">Numéro de téléphone</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="smartphone"></i></span>
                            <input type="tel" name="mobile_number" id="mobile_number" value="<?php isset($_POST["mobile_number"]) ? htmlspecialchars(trim($_POST["mobile_number"])) : null ?>" class="form-control">
                        </div>
                        <span class="form-text">Ce numéro ne sert uniquement à vous contacter si nous avons un soucis avec votre commande.</span>
                    </div>

                    <div class="col-12">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="key"></i></span>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <span class="form-text">Le mot de passe doit faire au minimum 8 caractères et être composé d'au moins une lettre et un chiffre.</span>
                    </div>

                    <div class="col-12">
                        <label for="street_name" class="form-label">Adresse postale</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="home"></i></span>
                            <input type="text" name="street_name" id="street_name" value="<?php isset($_POST["street_name"]) ? htmlspecialchars(trim($_POST["street_name"])) : null ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-6">
                        <label for="city" class="form-label">Ville</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="map"></i></span>
                            <input type="text" name="city" id="city" value="<?php isset($_POST["city"]) ? htmlspecialchars(trim($_POST["city"])) : null ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-2">
                        <label for="zip_code" class="form-label">Code postal</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="grid"></i></span>
                            <input type="text" name="zip_code" id="zip_code" value="<?php isset($_POST["zip_code"]) ? htmlspecialchars(trim($_POST["zip_code"])) : null ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-4">
                        <label for="district" class="form-label">Nom du quartier / Arrondissement</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="map"></i></span>
                            <input type="text" name="district" id="district" value="<?php isset($_POST["district"]) ? htmlspecialchars(trim($_POST["district"])) : null ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-12">
                        <button name="submit" id="submit" class="btn btn-primary"><i data-feather="user-plus"></i> Créer un compte</button>
                    </div>

                </form>
            </div>
        </div>
    </main>
<script type="text/javascript" src="assets/js/register.js"></script>
<?php require_once "includes/footer.php"; ?>
