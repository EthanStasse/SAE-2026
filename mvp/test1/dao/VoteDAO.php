<?php

class VoteDAO {

    private $db;

    public function __construct() {
        $this->db = new PDO("sqlite:database.db");
    }

    public function insert($token, $choix) {
        $stmt = $this->db->prepare("INSERT INTO vote(token, choix) VALUES(?, ?)");
        $stmt->execute([$token, $choix]);
    }
}
