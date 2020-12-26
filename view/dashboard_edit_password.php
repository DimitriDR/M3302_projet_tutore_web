<?php
$page_title = "Charles&Co. – Modification du mot de passe";

require_once "includes/header.php";

if (!isset($_SESSION["user"])) {
    $_SESSION["flash"]["warning"] = "<i data-feather='alert-triangle'></i> Vous devez être connecté pour accéder à cet espace.</i>";
    header("Location: index.php");
}
?>
<main class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="card-title">Modification du mot de passe</h1>
            <form method="POST" action="../controller/edit_password.php" class="row g-3">

                <div class="col-6">
                    <label for="new_password" class="form-label">Nouveau mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i data-feather="key"></i></span>
                        <input type="password" name="new_password" id="new_password" value="<?php isset($_POST["new_password"]) ? htmlspecialchars(trim($_POST["new_password"])) : null ?>" class="form-control">
                    </div>
                </div>

                <div class="col-6">
                    <label for="new_password_confirmation" class="form-label">Confirmation du nouveau mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i data-feather="key"></i></span>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" value="<?php isset($_POST["new_password_confirmation"]) ? htmlspecialchars(trim($_POST["new_password_confirmation"])) : null ?>" class="form-control">
                    </div>
                </div>

                <div class="col-12">
                    <label for="old_password" class="form-label">Ancien mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i data-feather="key"></i></span>
                        <input type="password" name="old_password" id="old_password" value="<?php isset($_POST["old_password"]) ? htmlspecialchars(trim($_POST["old_password"])) : null ?>" class="form-control">
                    </div>
                </div>

                <div class="col-12">
                    <button name="submit" id="submit" class="btn btn-primary"><i data-feather="edit-3"></i> Modifier le mot de passe</button>
                </div>

            </form>
        </div>
    </div>
</main>
<script type="text/javascript" src="assets/js/dashboard_edit_password.js"></script>
<?php require_once "includes/footer.php"; ?>