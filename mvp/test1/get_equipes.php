<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION['is_connecter'])) {
    http_response_code(401);
    echo json_encode(["error" => "Not connected"]);
    exit;
}

$country = strtoupper($_GET['country'] ?? '');
if (!preg_match('/^[A-Z]{2}$/', $country)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid country"]);
    exit;
}

/* 🔧 Change these to your DB config */
$host = "127.0.0.1";
$db   = "coup_de_sifflet";
$user = "root";
$pass = "";
$port = 3306;

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // ✅ Using your table: equipe (nom, pays)
    $stmt = $pdo->prepare("SELECT nom FROM equipe WHERE pays = ? ORDER BY nom");
    $stmt->execute([$country]);

    echo json_encode([
        "country" => $country,
        "equipes" => $stmt->fetchAll(PDO::FETCH_COLUMN)
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(["error" => "DB error"]);
}
