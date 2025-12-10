<?php

class PageController {

    public function accueil() {
        include "vue/accueil.php";
    }

    public function contact() {
        include "vue/contact.php";
    }

    public function connexion() {
        include "vue/connexion.php";
    }

    public function deconnexion() {
        include "vue/deconnexion.php";
    }   

}
