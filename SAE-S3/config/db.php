<?php

// Paramètres de connexion : par défaut ceux d'un serveur local (XAMPP/WAMP).
// En ligne, copier db.local.example.php en db.local.php (ignoré par git) et y mettre les vrais identifiants.
$host = 'localhost';
$dbname = 'armee_du_salut';
$username = 'root';
$password = '';

if (file_exists(__DIR__ . '/db.local.php')) {
    require __DIR__ . '/db.local.php';
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log($e->getMessage());
    die("Erreur de connexion à la base de données.");
}
