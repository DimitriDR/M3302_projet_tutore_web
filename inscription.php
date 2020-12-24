<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription – simple et sans obligation d'achats</title>
    <link rel="stylesheet" type="text/css" href="css/bulma.css">
</head>
<body>
<main class="container">
    <form method="POST" action="inscription_v.php" class="">

        <?php
        if (isset($_SESSION["register_errors"])) {

            echo "<section class=\"tile content notification is-danger\">";
            echo "Le formulaire comporte les erreurs suivantes :";
            echo "<ul>";

            // On affiche les erreurs sous forme de liste
            foreach ($_SESSION["register_errors"] as $error) {
                echo "<li>" . $error . "</li>";
            }

            echo "</ul>";
            echo "</section>";
            // On retire le tableau des erreurs de la session
            unset($_SESSION["register_errors"]);
        }
        ?>

        <div class="columns">
            <div class="column field">
                <label for="last_name">Nom</label>
                <div class="control">
                    <input type="text" class="input" name="last_name" id="last_name">
                </div>
                <p class="help">Le nom de famille doit être exact afin de bien vous livrer votre panier.</p>
            </div>

            <div class="column field">
                <label for="first_name">Prénom</label>
                <div class="control">
                    <input type="text" class="input" name="first_name" id="first_name">
                </div>
            </div>
        </div>

        <div class="field">
            <label for="email_address">Adresse e-mail</label>
            <div class="control">
                <input type="email" class="input" name="email_address" id="email_address">
            </div>
            <p class="help">Un e-mail de confirmation vous sera envoyé pour confirmer votre compte.</p>
        </div>

        <div class="field">
            <label for="password">Mot de passe</label>
            <div class="control">
                <input type="password" class="input" name="password" id="password"
                       placeholder="Mot de passe d'au moins 8 caractères, ayant au moins une lettre et un chiffre">
            </div>
            <p class="help">Un e-mail de confirmation vous sera envoyé pour confirmer votre compte.</p>
        </div>

        <label for="street_number">Adresse postale</label>
        <div class="field has-addons">
            <div class="control">
                <input type="text" name="street_number" id="street_number" placeholder="Numéro" class="input">
            </div>
            <div class="control is-expanded">
                <input type="text" name="street_name" id="street_name" placeholder="Nom de la rue" class="input">
            </div>
        </div>

        <div class="field has-addons">
            <div class="control is-expanded">
                <input type="text" name="city" id="city" placeholder="Ville" class="input">
            </div>
            <div class="control">
                <input type="number" name="zip_code" id="zip_code" placeholder="Code postal" maxlength="5" minlength="5"
                       class="input">
            </div>
        </div>

        <div class="field">
            <label for="district">Arrondissement / Quartier</label>
            <div class="control">
                <input type="text" id="district" name="district" class="input">
            </div>
        </div>

        <div class="field">
            <label for="mobile_number">Numéro de téléphone</label>
            <div class="control">
                <input type="number" id="mobile_number" name="mobile_number" maxlength="10" class="input"
                       placeholder="0612345678">
            </div>
        </div>

        <button name="submit" id="submit" class="button is-dark">Envoyer</button>
    </form>
</main>

<script type="text/javascript" src="inscription.js"></script>
</body>
</html>