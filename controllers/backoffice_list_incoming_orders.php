<?php
require_once "common.start.session.php";
require_once dirname(__DIR__) . "/models/databaselink.php";

$databaselink = new DatabaseLink();
$query = $databaselink->make_query("SELECT * FROM `backoffice.orders` WHERE status = 1");
$fetch = $query->fetchAll();