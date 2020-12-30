<?php
session_start();

$page_title = "Connexion à l'interface d'administration";

// Il faut d'abord être connecté globalement avant de s'authentifier en tant qu'administrateur
if (!isset($_SESSION["user_information"])) {
    $_SESSION["flash"]["info"] = "Vous devez d'abord vous connecter globalement avant d'effectuer cette action";
    header("Location: ../login");
    exit;
} else if (isset($_SESSION["administrator"]) && $_SESSION["administrator"] === true) {
    // Par contre, si au contraire, on est déjà connecté en tant qu'administrateur, on le redirige directement vers l'accueil de l'administration
    $_SESSION["flash"]["info"] = "Vous êtes déjà connecté à l'interface d'administration.";
    header("Location: ../backoffice_index");
    exit;
}

$page_title = "Connexion à l'espace administratif";
require_once "views/assets/includes/header.php";
?>
    <main class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title">Connexion à l'espace administratif</h1>
                <form method="POST" action="/controllers/backoffice_login.php" class="row">

                    <div class="col-12 g-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-key fs-xs"></i></span>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                    </div>

                    <div class="col-12 g-3">
                        <button name="submit" id="submit" class="btn btn-primary"><i class="fas fa-user-shield fs-xs"></i> Connexion</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
<?php require_once "assets/includes/footer.php"; ?>