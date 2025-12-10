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
    <title>Contact - Coup de Sifflet</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <h1>Coup de Sifflet</h1>
    <nav>
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
<section class="form-section">
    <h2>Contactez-nous</h2>

    <form>
        <label>Nom</label>
        <input type="text" placeholder="Votre nom">

        <label>Email</label>
        <input type="email" placeholder="Votre email">

        <label>Message</label>
        <textarea placeholder="Votre message"></textarea>

        <button class="btn">Envoyer</button>
    </form>
</section>
</main>

<footer>
    <p>&copy; 2025 - Coup de Sifflet</p>
</footer>

</body>
</html>
