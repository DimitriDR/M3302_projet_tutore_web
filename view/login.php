<?php
$page_title = "Inscription – Simple";
require_once "includes/header.php";
?>
    <main class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title">Connexion</h1>
                <p>Vous n'avez pas de compte ? <a href="register.php">Inscrivez-vous</a>.</p>
                <form method="POST" action="../controller/login.php" class="row g-3">

                    <div class="col-6">
                        <label for="email_address" class="form-label">Adresse e-mail</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="at-sign"></i></span>
                            <input type="text" name="email_address" id="email_address" value="<?php isset($_POST["email_address"]) ? htmlspecialchars(trim($_POST["email_address"])) : null ?>" class="form-control">
                        </div>
                    </div>

                    <div class="col-6">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text"><i data-feather="key"></i></span>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                    </div>

                    <div class="col-12">
                        <button name="submit" id="submit" class="btn btn-primary"><i data-feather="log-in"></i> Connexion</button>
                    </div>

                </form>
            </div>
        </div>
    </main>
<script type="text/javascript" src="assets/js/login.js"></script>
<?php require_once "includes/footer.php"; ?>
