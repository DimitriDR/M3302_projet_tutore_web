<?php
/**
 * @var Order $order La commande que l'on récupère grâce à l'ID donné dans l'URL.
 * @var User $customer Le client lié à la commande.
 * @var array $all_products Contient un tableau contenant l'ID de tous les produits présents dans la commande
 */
require_once dirname(__DIR__) . "/controllers/backoffice_see_order.php";
require_once dirname(__DIR__) . "/models/product.php";
require_once dirname(__DIR__) . "/views/assets/includes/backoffice_header.php";
?>
    <main class="container">
                <h1 class="card-title">Détails de la commande n°<?= $order->get_id_order(); ?></h1>
                <h2><?= $order->get_status(); ?></h2>

        <section class="row mb-2">
            <div class="col-9">
            <div class="card shadow-sm">
                <div class="card-body pb-1">
                    <h2>Informations sur le client</h2>
                    <ul>
                        <li><strong>Nom du client</strong> : <?= htmlspecialchars(trim($customer->get_last_name())) ?></li>
                        <li><strong>Prénom du client</strong> : <?= htmlspecialchars(trim($customer->get_first_name())) ?></li>
                        <li><strong>Adresse du client</strong> : <?= htmlspecialchars(trim($customer->get_street_name())) ?>, <?= htmlspecialchars(trim($customer->get_zip_code())) ?> <?= htmlspecialchars(trim($customer->get_city())) ?></li>
                        <li><strong>Date de commande</strong> : <?= htmlspecialchars(trim($order->get_date())) ?></li>
                    </ul>
                </div>
            </div>
            </div>
            <div class="col-3">
                <a href="" class="btn btn-success d-inline-block w-100 mb-2"><i class="fal fa-check fa-xs"></i> Confirmer la bonne réception</a>
                <a href="" class="btn btn-primary d-inline-block w-100 mb-2"><i class="fal fa-truck fa-xs"></i> Je suis en train de livrer</a>
                <a href="" class="btn btn-secondary d-inline-block w-100 mb-2"><i class="fal fa-truck fa-xs"></i> Confirmer la commande</a>
                <a href="" class="btn btn-danger d-inline-block w-100"><i class="fal fa-truck fa-xs"></i> Annuler la commande</a>
            </div>
        </section>

        <section>
            <h2>Liste des produits</h2>
                <ul class="list-group">
                <?php foreach ($all_products as $product_row): ?>
                    <?php $product = new Product(); ?>
                        <?php $product->hydrate($product_row->id_product); ?>
                            <li class="list-group-item"><?= $product->get_label() ?> (<strong>quantité :</strong> <?= $product_row->quantity ?>)</li>
                <?php endforeach; ?>
                    <li class="list-group-item active">Total de la commande : <?= round($order->get_amount() / 1.20, 2) ?> € HT</li>
                </ul>
        </section>
    </main>
<?php require_once dirname(__DIR__) . "/views/assets/includes/backoffice_footer.php" ?>