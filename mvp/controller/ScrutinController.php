<?php
require_once "service/ScrutinService.php";

class ScrutinController {

    public function create() {
        $titre = $_POST["titre"];
        $id = (new ScrutinService())->createScrutin($titre);
        echo "Scrutin créé : ID = $id";
    }
}
