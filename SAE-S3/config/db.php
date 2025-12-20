<?php

// Paramètres de connexion
$host = 'localhost';
$dbname = 'armee_du_salut';
$username = 'root';
$password = '';

try {
    // On essaie de se connecter
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // On configure pour voir les erreurs s'il y en a
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}