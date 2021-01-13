<?php
/**
 * @var array $fetch Tableau contenant les résultats de la requête pour récupérer l'ensemble des commandes
 */
require_once dirname(__DIR__) . "/controllers/backoffice_list_incoming_orders.php";
require_once dirname(__DIR__) . "/views/assets/includes/backoffice_header.php";
?>
<main class="container">
    <div class="card shadow-sm p-2">
        <div class="card-body">
            <h1 class="card-title">Liste des commandes à livrer</h1>
            <table class="table table-bordered table-striped text-center">
                <thead>
                <tr>
                    <th class="col">NOM Prénom</th>
                    <th class="col">Adresse</th>
                    <th class="col">Date de création</th>
                    <th class="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($fetch as $result):
                    ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($result->last_name) ?></strong> <?= htmlspecialchars($result->first_name) ?></td>
                        <td><?= htmlspecialchars($result->street_name) ?>, <?= htmlspecialchars($result->city) ?></td>
                        <td><?= htmlspecialchars($result->date) ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="backoffice_see_order?id=<?= intval($result->id_order) ?>" class="btn btn-primary">Voir en détails</a>
                                <a href="backoffice_change_order_status?id=<?= intval($result->id_order) ?>&status=2" class="btn btn-dark">En route</a>
                                <a href="backoffice_change_order_status?id=<?= intval($result->id_order) ?>&status=3" class="btn btn-light">Conf. réception</a>
                                <a href="backoffice_change_order_status?id=<?= intval($result->id_order) ?>&status=-1" class="btn btn-danger">Annul. livraison</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php require_once dirname(__DIR__) . "/views/assets/includes/footer.php"; ?>

