<?php
session_start();

$is_admin = $_SESSION['is_admin'] ?? false;
$is_electeur = $_SESSION['is_electeur'] ?? false;
$is_connecter = $_SESSION['is_connecter'] ?? false;
?>

<?php
// Si on clique sur "Connexion"
if (isset($_POST['btn_connexion'])) {

    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    // Connexion MySQL
    $host = "localhost";
    $dbname = "coup_de_sifflet";
    $user = "root"; // ou ton utilisateur MySQL
    $pass = "";     // ton mdp MySQL

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifie si administrateur
        $sql = "SELECT * FROM administrateur WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($mdp, $admin['mot_de_passe'])) {
            // Enregistrer l'état dans la session
            $_SESSION['is_admin'] = true;
            $_SESSION['is_connecter'] = true;
            header('Location: Index.php?page=accueil');
            exit;
        }

        // Vérifie si electeur
        $sql = "SELECT * FROM electeur WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($mdp, $user['mot_de_passe'])) {
            // Enregistrer l'état dans la session
            $_SESSION['is_electeur'] = true;
            $_SESSION['is_connecter'] = true;
            header('Location: Index.php?page=accueil');
            exit;
        }

        echo "Nom ou mot de passe incorrect";

    } catch (PDOException $e) {
        die("Erreur DB : " . $e->getMessage());
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Coup de Sifflet</title>
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
    <h2>Connectez-vous</h2>

<form method="POST" action="Index.php?page=connexion">
    <label>Email</label>
    <input type="text" name="email" placeholder="Votre email">

    <label>Mot de passe</label>
    <input type="password" name="mdp" placeholder="Votre mot de passe">

    <button type="submit" name="btn_connexion" class="btn">Connexion</button>
    <a href="Index.php?page=CreerCompte">Creer un compte</a>
</form>

</section>
</main>

<footer>
    <p>&copy; 2026 - Coup de Sifflet</p>
</footer>

</body>
</html>
