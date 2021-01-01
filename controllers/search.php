<?php
require_once "common.start.session.php";
require_once "common.forwarding.php";

require_once dirname(__DIR__) . "/models/search.php";
require_once dirname(__DIR__) . "/models/product.php";

// On vérifie qu'une recherche a été saisie
if (!isset($_GET["search"]) || empty($_GET["search"])) {
    $_SESSION["flash"]["warning"] = "L'URL de recherche n'est pas valide";
    header("Location: /");
    exit;
}

$search = new Search(trim($_GET["search"]));
$search->request_db();