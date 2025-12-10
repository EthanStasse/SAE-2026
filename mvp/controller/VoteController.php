<?php
require_once "service/VoteService.php";

class VoteController {

    public function generateToken() {
        $id_scrutin = $_POST["id_scrutin"];
        $token = (new VoteService())->generateToken($id_scrutin);
        echo "Votre jeton : $token";
    }

    public function submitVote() {
        $token = $_POST["token"];
        $choix = $_POST["choix"];

        $result = (new VoteService())->submitVote($token, $choix);
        echo $result;
    }
}
