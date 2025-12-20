<?php
session_start();
require_once '../config/db.php';
/** @var PDO $pdo */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // On cherche l'utilisateur dans la base de données
    $sql = "SELECT * FROM admin_users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    // On vérifie le mot de passe
    if ($user && password_verify($password, $user['password'])) {
        // On connecte la personne
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // On redirige vers le tableau de bord
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Identifiants incorrects !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - Armée du Salut</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="login-page">

<div class="login-card">
    <div class="text-center mb-4">
        <img src="../img/logo.png" alt="Logo" width="80" class="mb-3">
        <h3 class="h5">Espace Administration</h3>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Identifiant</label>
            <input type="text" name="username" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-custom w-100">Se connecter</button>
    </form>
    <div class="text-center mt-3">
        <a href="../Page%20d'Acceuil/index.html" class="text-muted small text-decoration-none">Retour au site public</a>
    </div>
</div>

</body>
</html>