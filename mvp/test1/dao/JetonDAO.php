<?php

class JetonDAO {

    private $db;

    public function __construct() {
        $this->db = new PDO("sqlite:database.db");
    }

    public function insert($token, $id_scrutin) {
        $stmt = $this->db->prepare("INSERT INTO jeton(token, id_scrutin, utilise) VALUES(?,?,0)");
        $stmt->execute([$token, $id_scrutin]);
    }

    public function get($token) {
        $stmt = $this->db->prepare("SELECT * FROM jeton WHERE token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function markUsed($token) {
        $stmt = $this->db->prepare("UPDATE jeton SET utilise = 1 WHERE token = ?");
        $stmt->execute([$token]);
    }
}
