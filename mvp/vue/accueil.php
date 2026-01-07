<?php
session_start();

// Récupère l'état de connexion depuis la session (évite les "undefined variable")
$is_admin = $_SESSION['is_admin'] ?? false;
$is_electeur = $_SESSION['is_electeur'] ?? false;
$is_connecter = $_SESSION['is_connecter'] ?? false;
$nom = $_SESSION['nom'] ?? '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Coup de Sifflet</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <h1>Coup de Sifflet</h1>
    <nav>
        <?php if ($is_admin == true) { ?>
        <a href="Index.php?page=AdminPanel">Données_Admin</a>
        <?php }?>
        <a href="Index.php?page=accueil">Accueil</a>
        <a href="Index.php?page=contact">Contact</a>
        <?php if ($is_connecter == true) { ?>
        <a href="Index.php?page=deconnexion">Deconnexion</a>
        <?php } else { ?>
            <a href="Index.php?page=connexion">Connexion</a>
        <?php } ?>
    </nav>
</header>

<main>
    <section class="hero">
        <h2>Votez simplement et rapidement</h2>
        <p>Plateforme de vote européenne — interface simple et intuitive.</p>
        <a class="btn" href="Index.php?page=contact">Nous contacter</a>
        <p></p>
        <?php if ($is_connecter == true) { ?>
            
        <?php } else { ?>
            <a class="btn" href="Index.php?page=connexion">Se Connecter</a>
        <?php } ?>
    </section>
</main>

<footer>
    <p>&copy; 2026 - Coup de Sifflet</p>
</footer>

</body>
</html>
