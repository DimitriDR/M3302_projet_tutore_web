<?php
$page_title = "Panier";
require_once dirname(__DIR__) . "/controllers/cart.php";
require_once dirname(__DIR__) . "/views/assets/includes/header.php";
?>
    <main class="container">
        <h1 class="text-center">Résumé de votre commande <?php display_number_of_items() ?></h1>

        <section class="g-3">
            <h2><i class="fad fa-shopping-bag fa-xs"></i> Vos articles</h2>
            <ul class="list-group">
                <?php display_all_items() ?>
                <li class="list-group-item active"><strong><i class="fad fa-money-bill-wave fa-xs"></i> Prix total</strong><span
                            class="d-flex justify-content-between"><?= unserialize($_SESSION["cart"])->get_total_price(); ?> €</span></li>
            </ul>
        </section>

        <section class="row py-3 my-3">
            <h2><i class="fad fa-info-circle fa-xs"></i> Vos informations</h2>
            <h3>Informations de livraison et de facturation</h3>
            <p class="text-muted">Pour modifier ces informations, veuillez vous rendre sur cette page <a href="">LIEN</a>.</p>

            <div class="col-6 g-3">
                <label for="last_name" class="form-label">Nom</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fad fa-user fs-xs"></i></span>
                    <input type="text" id="last_name" class="form-control"
                           value="<?= htmlspecialchars(trim(unserialize($_SESSION["user_information"])->get_last_name())) ?>" disabled>
                </div>
            </div>

            <div class="col-6 g-3">
                <label for="first_name" class="form-label">Prénom</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fad fa-user fs-xs"></i></span>
                    <input type="text" id="first_name" class="form-control"
                           value="<?= htmlspecialchars(trim(unserialize($_SESSION["user_information"])->get_first_name())) ?>" disabled>
                </div>
            </div>

            <div class="col-6 g-3">
                <label for="email_address" class="form-label">Adresse e-mail</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fad fa-at fs-xs"></i></span>
                    <input type="email" id="email_address" name="email_address" class="form-control"
                           value="<?= htmlspecialchars(trim(unserialize($_SESSION["user_information"])->get_email_address())) ?>" disabled>
                </div>
            </div>

            <div class="col-6 g-3">
                <label for="mobile_number" class="form-label">Numéro de téléphone</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fad fa-mobile-alt fs-xs"></i></span>
                    <input type="tel" id="mobile_number" name="mobile_number" class="form-control"
                           value="<?= htmlspecialchars(trim(unserialize($_SESSION["user_information"])->get_mobile_number())) ?>" disabled>
                </div>
            </div>

            <div class="col-12 g-3">
                <label for="street_name" class="form-label">Adresse postale</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fad fa-home fs-xs"></i></span>
                    <input type="text" id="street_name" name="street_name" class="form-control"
                           value="<?= htmlspecialchars(trim(unserialize($_SESSION["user_information"])->get_street_name())) ?>" disabled>
                </div>
            </div>

            <div class="col-6 g-3">
                <label for="city" class="form-label">Ville</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fad fa-globe-europe fs-xs"></i></span>
                    <input type="text" id="city" name="city" class="form-control"
                           value="<?= htmlspecialchars(trim(unserialize($_SESSION["user_information"])->get_city())) ?>" disabled>
                </div>
            </div>

            <div class="col-2 g-3">
                <label for="zip_code" class="form-label">Code postal</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fad fa-map-pin fs-xs"></i></span>
                    <input type="text" id="zip_code" name="zip_code" class="form-control"
                           value="<?= htmlspecialchars(trim(unserialize($_SESSION["user_information"])->get_zip_code())) ?>" disabled>
                </div>
            </div>

            <div class="col-4 g-3">
                <label for="district" class="form-label">Nom du quartier / Arrondissement</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fad fa-city fs-xs"></i></span>
                    <input type="text" id="district" name="district" class="form-control"
                           value="<?= htmlspecialchars(trim(unserialize($_SESSION["user_information"])->get_district())) ?>" disabled>
                </div>
            </div>

            <h3 class="g-3">Informations de paiement</h3>
            <form method="POST" action="/controllers/cart.php" class="row">
                <div class="col-6 g-3">
                    <label for="credit_card_name" class="form-label">Nom sur la carte</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fad fa-user fs-xs"></i></span>
                        <input type="text" id="credit_card_name" name="credit_card_name" class="form-control" placeholder="DUPONT Jean">
                    </div>
                </div>

                <div class="col-6 g-3">
                    <label for="credit_card_number" class="form-label">Numéro de carte</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fad fa-credit-card fs-xs"></i></span>
                        <input type="text" id="credit_card_number" name="credit_card_number" class="form-control" placeholder="0123-4567-8901-2345">
                    </div>
                </div>

                <div class="col-6 g-3">
                    <label for="credit_card_security_number" class="form-label">CCV</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fad fa-lock fs-xs"></i></span>
                        <input type="text" id="credit_card_security_number" name="credit_card_security_number" class="form-control" placeholder="123">
                    </div>
                </div>

                <div class="col-6 g-3">
                    <label for="credit_card_expiration_date" class="form-label">Date d'expiration</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fad fa-calendar-times fs-xs"></i></span>
                        <input type="month" id="credit_card_expiration_date" name="credit_card_expiration_date" min="2020-12" max="2027-01"
                               class="form-control">
                    </div>
                </div>

                <div class="col-12 my-3">
                    <button name="submit" id="submit" class="btn btn-primary w-50 d-block mx-auto"><i class="fad fa-shopping-basket fs-xs"></i> Passer commande </button>
                </div>
            </form>
        </section>
    </main>
<?php require_once "views/assets/includes/footer.php"; ?>