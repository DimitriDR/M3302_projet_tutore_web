<?php
$page_title = "Panier";
require_once dirname(__DIR__) . "/controllers/cart.php";
require_once dirname(__DIR__) . "/views/assets/includes/header.php";

$user_info = unserialize($_SESSION["user_information"]);

?>
<main class="container">
    <h1 class="text-center mb-5">Votre panier <?= htmlspecialchars(display_number_of_items()) ?></h1>

    <article class="row mt-5">
        <!-- La partie située à gauche -->
        <section class="row col-8">
            <h2><i class="fad fa-shopping-bag fa-xs"></i> Vos informations</h2>
            <hr>
            <!-- Le début de l'accordéon -->
            <div class="accordion" id="accordion">
                <!-- Première partie affichant les informations -->
                <div class="accordion-item">
                    <!-- Titre de la première partie -->
                    <h3 class="accordion-header" id="first_heading">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#first_part" aria-expanded="true" aria-controls="first_part">
                            Vos informations de livraison et de facturation
                        </button>
                    </h3>
                    <!-- Corps de la première partie -->
                    <div id="first_part" class="accordion-collapse collapse show" aria-labelledby="first_heading" data-bs-parent="#accordion">
                        <div class="accordion-body">
                            <p class="text-muted">Pour modifier ces informations, veuillez vous rendre sur <a href="/edit_my_information">cette page</a>.</p>

                            <!-- Champ pour le nom -->
                            <div class="row">
                                <div class="col-6 g-3">
                                    <label for="last_name" class="form-label">Nom</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="far fa-user fs-xs"></i></span>
                                        <input type="text" id="last_name" class="form-control"
                                               value="<?= htmlspecialchars(trim($user_info->get_last_name())) ?>" disabled>
                                    </div>
                                </div>

                                <!-- Champ pour le prénom -->
                                <div class="col-6 g-3">
                                    <label for="first_name" class="form-label">Prénom</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="far fa-user fs-xs"></i></span>
                                        <input type="text" id="first_name" class="form-control"
                                               value="<?= htmlspecialchars(trim($user_info->get_first_name())) ?>" disabled>
                                    </div>
                                </div>

                                <!-- Champ pour l'adresse e-mail -->
                                <div class="col-6 g-3">
                                    <label for="email_address" class="form-label">Adresse e-mail</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="far fa-at fs-xs"></i></span>
                                        <input type="email" id="email_address" name="email_address" class="form-control"
                                               value="<?= htmlspecialchars(trim($user_info->get_email_address())) ?>" disabled>
                                    </div>
                                </div>

                                <!-- Champ pour le numéro de téléphone -->
                                <div class="col-6 g-3">
                                    <label for="mobile_number" class="form-label">Numéro de téléphone</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="far fa-mobile-alt fs-xs"></i></span>
                                        <input type="tel" id="mobile_number" name="mobile_number" class="form-control"
                                               value="<?= htmlspecialchars(trim($user_info->get_mobile_number())) ?>" disabled>
                                    </div>
                                </div>

                                <!-- Champ pour l'adresse postale -->
                                <div class="col-12 g-3">
                                    <label for="street_name" class="form-label">Adresse postale</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="far fa-home fs-xs"></i></span>
                                        <input type="text" id="street_name" name="street_name" class="form-control"
                                               value="<?= htmlspecialchars(trim($user_info->get_street_name())) ?>" disabled>
                                    </div>
                                </div>

                                <!-- Champ pour la ville -->
                                <div class="col-6 g-3">
                                    <label for="city" class="form-label">Ville</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="far fa-globe-europe fs-xs"></i></span>
                                        <input type="text" id="city" name="city" class="form-control"
                                               value="<?= htmlspecialchars(trim($user_info->get_city())) ?>" disabled>
                                    </div>
                                </div>

                                <!-- Champ pour le code postal -->
                                <div class="col-2 g-3">
                                    <label for="zip_code" class="form-label">Code postal</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="far fa-map-pin fs-xs"></i></span>
                                        <input type="text" id="zip_code" name="zip_code" class="form-control" value="<?= htmlspecialchars(trim($user_info->get_zip_code())) ?>" disabled>
                                    </div>
                                </div>

                                <!-- Champ pour le quartier -->
                                <div class="col-4 g-3">
                                    <label for="district" class="form-label">Nom du quartier / Arrondissement</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="far fa-city fs-xs"></i></span>
                                        <input type="text" id="district" name="district" class="form-control" value="<?= htmlspecialchars(trim($user_info->get_district())) ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Deuxième partie affichant les informations bancaires -->
                <div class="accordion-item">
                    <h3 class="accordion-header" id="second_heading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#second_part" aria-expanded="false" aria-controls="second_part">
                            Vos informations de paiement
                        </button>
                    </h3>
                    <div id="second_part" class="accordion-collapse collapse" aria-labelledby="second_heading" data-bs-parent="#accordion">
                        <div class="accordion-body">
                            <p class="text-muted">Pour modifier ces informations, veuillez vous rendre sur <a href="/edit_my_banking_information">cette page</a>.</p>

                            <div class="row">


                                <div class="col-6 g-3">
                                    <label for="credit_card_name" class="form-label">Nom sur la carte</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fad fa-user fs-xs"></i></span>
                                        <input type="text" id="credit_card_name" name="credit_card_name" class="form-control" placeholder="DUPONT Jean" value="<?php if (!is_null($user_info->get_credit_card_name())): echo htmlspecialchars(trim($user_info->get_credit_card_name())); else: echo "Non renseigné"; endif; ?>" disabled>
                                    </div>
                                </div>

                                <div class=" col-6 g-3">
                                    <label for="credit_card_number" class="form-label">Numéro de carte</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fad fa-credit-card fs-xs"></i></span>
                                        <input type="text" id="credit_card_number" name="credit_card_number" class="form-control" placeholder="0123-4567-8901-2345" value="<?php if (!is_null($user_info->get_credit_card_number())): echo htmlspecialchars(trim($user_info->get_credit_card_number())); else: echo "Non renseigné"; endif; ?>" disabled>
                                    </div>
                                </div>

                                <div class="col-6 g-3">
                                    <label for="credit_card_security_number" class="form-label">CVV</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fad fa-lock fs-xs"></i></span>
                                        <input type="text" id="credit_card_security_number" name="credit_card_security_number" class="form-control" placeholder="123" value="<?php if (!is_null($user_info->get_credit_card_security_number())): echo "Caché"; else: echo "Non renseigné"; endif; ?>" disabled>
                                    </div>
                                </div>

                                <div class="col-6 g-3">
                                    <label for="credit_card_expiration_date" class="form-label">Date d'expiration</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fad fa-calendar-times fs-xs"></i></span>
                                        <input type="month" id="credit_card_expiration_date" name="credit_card_expiration_date" min="2020-12" max="2027-01" class="form-control" value="<?php if (!is_null($user_info->get_credit_card_expiration_date())): echo htmlspecialchars(trim($user_info->get_credit_card_expiration_date())); endif; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 my-3">
                <form method="POST" action="/controllers/cart.php">
                    <button name="submit" id="submit" class="btn btn-primary w-100 d-block mx-auto"><i class="fad fa-shopping-basket fs-xs"></i> Passer commande</button>
                </form>
            </div>

        </section>

        <section class="col">
            <h2><i class="fad fa-wallet fa-xs"></i> Total</h2>
            <p>Frais de livraison gratuits si le montant des articles est supérieur à 29 €. Pensez donc à la livraison groupée. <i class="far fa-smile-wink"></i></p>

            <!-- Le résumé de la commande -->
            <ul class="list-group">
                <?php display_all_items() ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Total des articles</strong>
                    <span><?= unserialize($_SESSION["cart"])->get_total_cost_of_items(); ?> €</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Frais de livraison</strong>
                    <span><?= unserialize($_SESSION["cart"])->get_delivery_fees(); ?> €</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>TVA</strong>
                    <span><?= unserialize($_SESSION["cart"])->get_vat(); ?> €</span>
                </li>
                <li class="list-group-item active d-flex justify-content-between align-items-center">
                    <strong><i class="fad fa-money-bill-wave fa-xs"></i> Prix total</strong>
                    <span class="d-flex justify-content-between"><?= unserialize($_SESSION["cart"])->get_final_amount(); ?> €</span>
                </li>
            </ul>

            <!-- Action sur le panier -->
            <a href="/controllers/serve_cart.php" class="btn btn-danger mt-3"><i class="far fa-trash-alt fa-xs"></i> Vider mon panier</a>
        </section>
    </article>
</main>
<?php require_once "views/assets/includes/footer.php"; ?>