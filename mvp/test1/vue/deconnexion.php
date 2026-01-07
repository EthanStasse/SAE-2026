<?php
session_start();

// Récupère l'état de connexion depuis la session (évite les "undefined variable")
$is_admin = $_SESSION['is_admin'] ?? false;
$is_electeur = $_SESSION['is_electeur'] ?? false;
$is_connecter = $_SESSION['is_connecter'] ?? false;
$nom = $_SESSION['nom'] ?? '';
?>

<?php

    // Supprimer les variables de session liées à la connexion
    unset(
    $_SESSION['is_admin'], 
    $_SESSION['is_electeur'], 
    $_SESSION['is_connecter'],
    );
    header('Location: Index.php?page=accueil');
    exit;

?>


