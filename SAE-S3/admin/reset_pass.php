<?php
/** @var PDO $pdo */
require_once '../config/db.php';

$nouveau_mdp = "admin123";

// On le hache proprement avec la méthode officielle de PHP
$hash = password_hash($nouveau_mdp, PASSWORD_DEFAULT);

// On met à jour l'utilisateur 'admin' dans la base
try {
    $sql = "UPDATE admin_users SET password = :pwd WHERE username = 'admin'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['pwd' => $hash]);

    echo "SUCCÈS ! <br>";
    echo "Le mot de passe de l'utilisateur <b>admin</b> est maintenant : <b>admin123</b><br>";
    echo "Le nouveau hash enregistré est : " . $hash . "<br><br>";
    echo "<a href='index.php'>Retourner à la page de connexion</a>";
} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
}