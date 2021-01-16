<?php
/**
 * @version 1.0 Reviewed and compliant file
 */
require_once dirname(__DIR__) . "/models/databaselink.php";
require_once dirname(__DIR__) . "/controllers/common.start.session.php";

$databaselink = new DatabaseLink();
$query = $databaselink->make_query("SELECT `last_name`, `first_name`, `street_name`, `city`, `date`, `id_order` FROM `backoffice.orders` WHERE `status` = 1");
$fetch = $query->fetchAll();