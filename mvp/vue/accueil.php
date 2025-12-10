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
    <title>Coup de Sifflet - Accueil</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <h1>Coup de Sifflet</h1>
    <nav>
        <a href="Index.php?page=accueil">Accueil</a>
        <a href="Index.php?page=contact">Contact</a>
        <?php if ($is_connecter == true) { ?>
            <form method="POST" action="Index.php?page=connexion" style="display:inline">
                <button type="submit" name="btn_deconnexion">deconnexion</button>
            </form>
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
    </section>
</main>

<footer>
    <p>&copy; 2025 - Coup de Sifflet</p>
</footer>

</body>
</html>
