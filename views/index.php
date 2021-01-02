<?php
$page_title = "Production locale et de saison";
require_once dirname(__DIR__) . "/controllers/index.php";
require_once dirname(__DIR__) . "/views/assets/includes/header.php";
?>
<main class="vh-100">
    <section id="background" class="h-50 d-flex justify-content-center align-items-center">
        <form method="GET" action="/search" class="w-75">
            <div class="input-group input-group-lg">
                <span class="input-group-text"><i class="fad fa-search fs-xs"></i></span>
                <label for="search"></label>
                <input type="search" id="search" name="search" class="form-control shadow-sm rounded-end" list="data_list_options" placeholder="Rechercher un fruit, un légume, ..." autofocus>
                <datalist id="data_list_options">
                    <option value="Carottes">
                </datalist>
            </div>
        </form>
    </section>

    <section class="container">
        <h1 class="text-center display-4 my-4">Produits proposés</h1>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <div class="col-ms-1">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Lorem </h2>
                    </div>
                </div>
            </div>

            <div class="col-ms-1">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Lorem </h2>
                    </div>
                </div>
            </div>

            <div class="col-ms-1">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Lorem </h2>
                    </div>
                </div>
            </div>

            </div>
    </section>
</main>
<?php
require_once dirname(__DIR__) . "/views/assets/includes/footer.php";
?>