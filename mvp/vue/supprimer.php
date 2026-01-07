<?php
session_start();

// Supprime un électeur si un email est fourni en GET ou POST.
$email = $_GET['email'] ?? $_POST['email'] ?? null;

if (empty($email)) {
    // Rien à faire, rediriger vers l'admin
    header('Location: Index.php?page=AdminPanel');
    exit;
}

// Connexion DB et suppression simple
$host = "localhost";
$dbname = "coup_de_sifflet";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('DELETE FROM electeur WHERE email = :email');
    $stmt->execute([':email' => $email]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['flash'] = 'Électeur supprimé.';
    } else {
        $_SESSION['flash'] = 'Aucun électeur trouvé pour cet email.';
    }
} catch (PDOException $e) {
    $_SESSION['flash'] = 'Erreur DB : ' . $e->getMessage();
}

header('Location: Index.php?page=AdminPanel');
exit;
?>
