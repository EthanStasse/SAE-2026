<?php
require_once "dao/JetonDAO.php";
require_once "dao/VoteDAO.php";

class VoteService {

    private $jetonDAO;
    private $voteDAO;

    public function __construct() {
        $this->jetonDAO = new JetonDAO();
        $this->voteDAO = new VoteDAO();
    }

    public function generateToken($id_scrutin) {
        $token = bin2hex(random_bytes(10));
        $this->jetonDAO->insert($token, $id_scrutin);
        return $token;
    }

    public function submitVote($token, $choix) {
        $jeton = $this->jetonDAO->get($token);

        if (!$jeton) return "Jeton invalide";
        if ($jeton["utilise"] == 1) return "Jeton déjà utilisé";

        $this->voteDAO->insert($token, $choix);
        $this->jetonDAO->markUsed($token);

        return "Vote enregistré";
    }
}
