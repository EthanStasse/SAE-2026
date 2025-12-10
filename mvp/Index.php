<?php

require_once "controller/PageController.php";

$page = $_GET["page"] ?? "accueil";

$controller = new PageController();

switch ($page) {

    case "accueil":
        $controller->accueil();
        break;

    case "contact":
        $controller->contact();
        break;

    default:
        echo "Page inconnue";
}
