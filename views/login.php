<?php
/**
 * @version 1.0 Reviewed and compliant file
 */
$page_title = "Connexion";

require_once dirname(__DIR__) . "/controllers/login.php";
require_once dirname(__DIR__) . "/views/assets/includes/header.php";
?>
<main class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="card-title">Connexion</h1>
            <p>Vous n'avez pas de compte ? <a href="/register">Inscrivez-vous</a>.</p>
            <form method="POST" action="/controllers/login.php" class="row g-3">

                <div class="col-6">
                    <label for="email_address" class="form-label">Adresse e-mail</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fad fa-at fs-xs"></i></span>
                        <input type="email" id="email_address" name="email_address" class="form-control">
                    </div>
                </div>

                <div class="col-6">
                    <label for="password" class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fad fa-key fs-xs"></i></span>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                </div>

                <div class="col-12">
                    <button id="submit" name="submit" class="btn btn-primary"><i class="fad fa-sign-in-alt fs-xs"></i> Connexion</button>
                </div>
            </form>
        </div>
    </div>
</main>
<?php require_once "assets/includes/footer.php"; ?>