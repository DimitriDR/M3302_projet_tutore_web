<?php
$page_title = "Liste de mes commandes";
require_once dirname(__DIR__) . "/controllers/my_orders.php";
require_once dirname(__DIR__) . "/views/assets/includes/header.php";
?>
    <main class="container">
        <div class="card shadow-sm p-2">
            <div class="card-body">
                <h1 class="card-title">Liste de mes commandes</h1>

                <?php if (!are_orders()): ?>
                    <span class="text-danger">Aucun commande n'a été trouvée. Vous pouvez constituer un panier avec les articles présentés <a href="browse">ici</a>.</span>
                <?php else: ?>
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                        <tr>
                            <th class="col">Date</th>
                            <th class="col">Statut</th>
                            <th class="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php display_all_orders() ?>
                        </tbody>
                    </table>
                <?php endif; ?>

            </div>
        </div>
    </main>
<?php require_once "views/assets/includes/footer.php"; ?>