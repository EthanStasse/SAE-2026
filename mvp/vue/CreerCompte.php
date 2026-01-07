<?php
if (isset($_POST['btn_connexion'])) {

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
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

        // Vérifier si l'email existe déjà
        $check_sql = "SELECT * FROM electeur WHERE email = ?";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([$email]);
        
        if ($check_stmt->rowCount() > 0) {
            $error = "Cet email est déjà utilisé";
        } else {
            // Hasher le mot de passe de manière sécurisée
            $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
            
            // Utiliser des placeholders ? pour éviter l'injection SQL
            $sql = "INSERT INTO `electeur` (`id_electeur`, `nom`, `prenom`, `email`, `mot_de_passe`, `role`) VALUES (NULL, ?, ?, ?, ?, 'electeur')";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nom, $prenom, $email, $mdp_hash]);
            
            // Succès : rediriger vers connexion
            header('refresh: 1; URL=Index.php?page=connexion');
            exit();
        }



    } catch (PDOException $e) {
        die("Erreur DB : " . $e->getMessage());
    }

}
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
    </nav>
</header>

<main>
<section class="form-section">
    <h2>Contactez-nous</h2>

    <?php if (isset($error)): ?>
        <div style="color: red; margin-bottom: 20px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($success)): ?>
        <div style="color: green; margin-bottom: 20px;">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="Index.php?page=CreerCompte">
        <label>Nom</label>
        <input type="text" name="nom" placeholder="Votre nom" required>

        <label>Prenom</label>
        <input type="text" name="prenom" placeholder="Votre prenom" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="Votre email" required>

        <label>Mot de passe</label>
        <input type="password" name="mdp" placeholder="Votre mot de passe" required>
        
        <p>
        <input type="checkbox" name="accepter_conditions"required>
        <a href="Index.php?page=conditions_generales">Condition générale</a>
        </p>
           

        <button type="submit" name="btn_connexion" class="btn">Creer un compte</button>
    </form>
</section>
</main>
<footer>
    <p>&copy; 2026 - Coup de Sifflet</p>
</footer>
</body>
</html>