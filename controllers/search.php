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

// On récupère la recherche
$search_terms = trim($_GET["search"]);

$search = new Search($search_terms);
$results = $search->request_db();