<?php
require_once dirname(__DIR__) . "/controllers/common.forwarding.php";
require_once dirname(__DIR__) . "/controllers/see_order.php";
require_once dirname(__DIR__) . "/views/assets/includes/header.php";

if (!isset($order)) {
    $_SESSION["flash"]["warning"] = "Une erreur s'est produite lors de la récupération de la dernière commande";
    header("Location: " . $GLOBALS["forwarding"]);
    exit;
}
?>
    <main class="container">
        <h1>Voir ma commande</h1>
        <div class="row">

            <div class="col">
                <div class="bg-dark text-white text-center p-4 rounded shadow-sm">
                    <h2><?= $order->get_amount() ?> €</h2>
                </div>
            </div>

            <div class="col">
                <div class="bg-<?= $order->status_color() ?> text-white text-center p-4 rounded shadow-sm">
                    <h2><?= $order->get_status() ?></h2>
                </div>
            </div>

            <div class="col">
                <div class="bg-white text-center p-4 rounded shadow-sm">
                    <h2><?= $order->get_date() ?></h2>
                </div>
            </div>

        </div>

        <section class="my-4">
            <div class="d-flex">

                <?php
                foreach ($order->list_of_products() as $id_product):
                $product = new Product();
                $product->hydrate($id_product->id_product);
                ?>
                <div class="card mx-1 shadow-sm">
                    <div class="d-flex align-items-center">
                        <img src="/views/assets/images/products/<?= $product->get_file() ?>" class="rounded-start" style="height: 100px; width: 100px; object-fit: cover" alt="Image de <?= htmlspecialchars($product->get_label()) ?>">
                        <h3 class="m-lg-3"><?= $product->get_label() ?> (x<?= $product->get_quantity_in_order($_GET["id"]) ?>)</h3>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

    </main>
<?php require_once dirname(__DIR__) . "/views/assets/includes/footer.php"; ?>