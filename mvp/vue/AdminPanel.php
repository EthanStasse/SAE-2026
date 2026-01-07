<?php
session_start();

$is_admin = $_SESSION['is_admin'] ?? false;
$is_electeur = $_SESSION['is_electeur'] ?? false;
$is_connecter = $_SESSION['is_connecter'] ?? false;
// Initialisation par défaut pour éviter les notices quand aucun POST n'est envoyé
$tab = [];
?>

<?php

if (!$is_admin) {
    // Rediriger vers la page d'accueil si l'utilisateur n'est pas admin
    header('Location: Index.php?page=accueil');
    exit;
}

if (isset($_POST['btn_Admin'])) {

       // Connexion MySQL
    $host = "localhost";
    $dbname = "coup_de_sifflet";
    $user = "root"; // ou ton utilisateur MySQL
    $pass = "";     // ton mdp MySQL

    try {

        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT nom, email FROM administrateur";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        // Récupérer tous les administrateurs
        $tab = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("Erreur DB : " . $e->getMessage());
    }
}

if (isset($_POST['btn_electeur'])) {

       // Connexion MySQL
    $host = "localhost";
    $dbname = "coup_de_sifflet";
    $user = "root"; // ou ton utilisateur MySQL
    $pass = "";     // ton mdp MySQL

    try {

        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT nom,prenom,email FROM electeur";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        // Récupérer tous les electeurs
        $tab = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("Erreur DB : " . $e->getMessage());
    }
}

if (isset($_POST['btn_equipes'])) {

       // Connexion MySQL
    $host = "localhost";
    $dbname = "coup_de_sifflet";
    $user = "root"; // ou ton utilisateur MySQL
    $pass = "";     // ton mdp MySQL

    try {

        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT nom,pays,ligue FROM equipe";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        // Récupérer tous les administrateurs
        $tab = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur DB : " . $e->getMessage());
    }
}

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Coup de Sifflet</title>
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
    <h2>Admin Panel</h2>
    <?php if (!empty($_SESSION['flash'])): ?>
        <p style="color:green"><?= htmlspecialchars($_SESSION['flash']) ?></p>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    <p>Bienvenue dans le panneau d'administration. Ici, vous pouvez gérer les données de l'application.</p>
    <form method="post">
        <button type="submit" name="btn_Admin" class="btn">Admins</button>
        <button type="submit" name="btn_electeur" class="btn">Elécteurs</button>
        <button type="submit" name="btn_equipes" class="btn">Equipes</button>
    </form>

    <?php if (isset($_POST['btn_Admin'])) { ?>
        <h3>Administrateurs</h3>
        <ul>
            <?php if (!empty($tab)) { ?>
                <?php foreach ($tab as $admin) : ?>
                    <li>Nom : <?=  htmlspecialchars($admin['nom'] ?? '') ?> - Email : <?= htmlspecialchars($admin['email'] ?? '') ?></li>
                <?php endforeach; ?>
            <?php } else { ?>
                <li>Aucun administrateur trouvé.</li>
            <?php }?>
        </ul>
    <?php } ?>

    <?php if (isset($_POST['btn_electeur'])) { ?>
        <h3>Électeurs</h3>
        <ul>
            <?php if (!empty($tab)) { ?>
                <?php foreach ($tab as $electeur) : ?>
                    <li>Nom : <?=  htmlspecialchars($electeur['nom'] ?? '') ?> - Prénom : <?= htmlspecialchars($electeur['prenom'] ?? '') ?> - Email : <?= htmlspecialchars($electeur['email'] ?? '') ?>  <a href="Index.php?page=supprimer&email=<?= rawurlencode($electeur['email'] ?? '') ?>">Supprimer</a></li>
                <?php endforeach; ?>
            <?php } else { ?>
                <li>Aucun électeur trouvé.</li>
            <?php }?>
        </ul>
    <?php } ?>

    <?php if (isset($_POST['btn_equipes'])) { ?>
        <h3>Équipes</h3>
        <ul>
            <?php if (!empty($tab)) { ?>
                <?php foreach ($tab as $equipe) : ?>
                    <li>Nom : <?=  htmlspecialchars($equipe['nom'] ?? '') ?> - Pays : <?= htmlspecialchars($equipe['pays'] ?? '') ?> - Ligue : <?= htmlspecialchars($equipe['ligue'] ?? '') ?></li>
                <?php endforeach; ?>
            <?php } else { ?>
                <li>Aucune équipe trouvée.</li>
            <?php }?>
        </ul>
    <?php } ?>


</main>

<footer>
    <p>&copy; 2026 - Coup de Sifflet</p>
</footer>
</body>

</html>