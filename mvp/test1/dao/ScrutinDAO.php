<?php

class ScrutinDAO {

    private $db;

    public function __construct() {
        $this->db = new PDO("sqlite:database.db");
    }

    public function create($titre) {
        $stmt = $this->db->prepare("INSERT INTO scrutin(titre) VALUES(?)");
        $stmt->execute([$titre]);
        return $this->db->lastInsertId();
    }
}
