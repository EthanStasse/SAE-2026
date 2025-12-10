<?php
require_once "dao/ScrutinDAO.php";

class ScrutinService {

    private $dao;

    public function __construct() {
        $this->dao = new ScrutinDAO();
    }

    public function createScrutin($titre) {
        return $this->dao->create($titre);
    }
}
