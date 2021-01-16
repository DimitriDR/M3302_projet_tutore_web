<?php
require_once dirname(__DIR__) . "/controllers/common.forwarding.php";
require_once dirname(__DIR__) . "/controllers/common.start.session.php";
require_once dirname(__DIR__) . "/models/product.php";
require_once dirname(__DIR__) . "/models/search.php";

// On vérifie qu'une recherche a été saisie
if (!isset($_GET["q"]) || empty($_GET["q"])) {
    $_SESSION["flash"]["warning"] = "L'URL de recherche n'est pas valide";
    header("Location: /");
    exit;
}

// Si tout est bon, on lance une nouvelle recherche
$search = new Search(trim($_GET["q"]));
$search->request_db();