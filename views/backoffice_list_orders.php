<?php
require_once dirname(__DIR__) . "/controllers/backoffice_list_orders.php";
require_once dirname(__DIR__) . "/views/assets/includes/backoffice_header.php";
?>
<main class="container">
    <div class="card shadow-sm p-2">
        <div class="card-body">
            <h1 class="card-title">Liste des commandes</h1>
            <table class="table table-bordered table-striped text-center">
                <thead>
                <tr>
                    <th class="col">ID</th>
                    <th class="col">NOM Prénom</th>
                    <th class="col">Adresse</th>
                    <th class="col">Date</th>
                    <th class="col">Statut</th>
                    <th class="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php display_all_orders() ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php require_once dirname(__DIR__) . "/views/assets/includes/footer.php"; ?>

