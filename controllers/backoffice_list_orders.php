<?php
/**
 * @version 1.0 Reviewed and compliant file
 */
require_once dirname(__DIR__) . "/controllers/common.start.session.php";
require_once dirname(__DIR__) . "/models/databaselink.php";

$databaselink = new DatabaseLink();
$query = $databaselink->make_query("SELECT `id_order`, `last_name`, `first_name`, `street_name`, `city` FROM `backoffice.orders`");
$fetch = $query->fetchAll();