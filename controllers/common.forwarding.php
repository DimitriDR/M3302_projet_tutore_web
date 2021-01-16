<?php
// On vérifie qu'on puisse rediriger vers la page précédente
if (isset($_SERVER["HTTP_REFERER"])) {
    $GLOBALS["forwarding"] = $_SERVER["HTTP_REFERER"];
} else {
    $GLOBALS["forwarding"] = "/";
}