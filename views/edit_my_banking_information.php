<?php
$page_title = "Modification de mes informations de paiement";
require_once "controllers/edit_my_banking_information.php";
require_once "views/assets/includes/header.php";
?>
<main class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="card-title">Modification de mes informations de paiement</h1>

            <form method="POST" action="/controllers/edit_my_banking_information.php" class="row g-3">
                <div class="col-6 g-3">
                    <label for="credit_card_name" class="form-label">Nom sur la carte</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fad fa-user fs-xs"></i></span>
                        <input type="text" id="credit_card_name" name="credit_card_name" class="form-control" placeholder="DUPONT Jean" value="<?= htmlspecialchars(unserialize($_SESSION["user_information"])->get_credit_card_name()); ?>">
                    </div>
                </div>

                <div class="col-6 g-3">
                    <label for="credit_card_number" class="form-label">Numéro de carte</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fad fa-credit-card fs-xs"></i></span>
                        <input type="text" id="credit_card_number" name="credit_card_number" class="form-control" placeholder="0123-4567-8901-2345" value="<?= htmlspecialchars(unserialize($_SESSION["user_information"])->get_credit_card_number()); ?>">
                    </div>
                </div>

                <div class="col-6 g-3">
                    <label for="credit_card_security_number" class="form-label">CCV</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fad fa-lock fs-xs"></i></span>
                        <input type="text" id="credit_card_security_number" name="credit_card_security_number" class="form-control" placeholder="123">
                    </div>
                    <p class="text-muted">Pour des raisons de sécurité, votre CCV n'est pas affiché, mais vous pouvez toujours le mettre à jour si vous vous êtes trompé lors de votre dernière saisie</p>
                </div>

                <div class="col-6 g-3">
                    <label for="credit_card_expiration_date" class="form-label">Date d'expiration</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fad fa-calendar-times fs-xs"></i></span>
                        <input type="month" id="credit_card_expiration_date" name="credit_card_expiration_date" min="2020-12" max="2027-01" class="form-control" value="<?= htmlspecialchars(unserialize($_SESSION["user_information"])->get_credit_card_expiration_date()); ?>">
                    </div>
                </div>

                <div class="col-12">
                    <button name="submit" id="submit" class="btn btn-primary"><i class="fal fa-credit-card fs-xs"></i> Modifier mes coordonnées bancaires</button>
                </div>

            </form>
        </div>
    </div>
</main>
<?php require_once "assets/includes/footer.php"; ?>