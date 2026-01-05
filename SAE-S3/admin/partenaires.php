<?php
session_start();
/** @var PDO $pdo */

if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit(); }
require_once '../config/db.php';

if (isset($_GET['supprimer'])) {
    $pdo->prepare("DELETE FROM partenaire WHERE id_partenaire = ?")->execute([$_GET['supprimer']]);
    header('Location: partenaires.php'); exit();
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO partenaire (nom, type, contact, email, type_soutien) VALUES (?, ?, ?, ?, ?)";
    $pdo->prepare($sql)->execute([$_POST['nom'], $_POST['type'], $_POST['contact'], $_POST['email'], $_POST['soutien']]);
    $message = "<div class='alert alert-success'>Partenaire ajouté !</div>";
}
$partenaires = $pdo->query("SELECT * FROM partenaire ORDER BY nom ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Partenaires - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="admin-container">
    <nav class="sidebar">
        <div class="sidebar-header">
            <img src="../img/logo.png" alt="Logo Armée du Salut" class="sidebar-logo">
        </div>

        <div class="sidebar-menu">
            <a href="dashboard.php" class="sidebar-link"><i class="fas fa-home"></i> Tableau de bord</a>
            <a href="benevoles.php" class="sidebar-link"><i class="fas fa-users"></i> Bénévoles</a>
            <a href="missions.php" class="sidebar-link"><i class="fas fa-calendar-alt"></i> Missions</a>
            <a href="partenaires.php" class="sidebar-link active"><i class="fas fa-handshake"></i> Partenaires</a>
            <a href="documents.php" class="sidebar-link"><i class="fas fa-folder-open"></i> Documents</a>
        </div>

        <div class="sidebar-footer">
            <a href="logout.php" class="btn-logout">
                <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
            </a>
        </div>
    </nav>

    <main class="admin-content">
        <h2 class="page-title">Nos Partenaires</h2>
        <?= $message ?>

        <div class="mb-4">
            <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#formPart"><i class="fas fa-plus"></i> Ajouter</button>
        </div>

        <div id="formPart" class="collapse mb-4">
            <div class="card-admin p-4">
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6"><label>Nom</label><input type="text" name="nom" class="form-control" required></div>
                        <div class="col-md-6"><label>Type</label><select name="type" class="form-select"><option>Entreprise</option><option>Institution</option><option>Fondation</option></select></div>
                        <div class="col-md-6"><label>Contact</label><input type="text" name="contact" class="form-control"></div>
                        <div class="col-md-6"><label>Email</label><input type="email" name="email" class="form-control"></div>
                        <div class="col-12"><label>Soutien</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="soutien" id="s1" value="Financier" checked><label class="btn btn-outline-danger" for="s1">Financier</label>
                                <input type="radio" class="btn-check" name="soutien" id="s2" value="Matériel"><label class="btn btn-outline-danger" for="s2">Matériel</label>
                            </div>
                        </div>
                        <div class="col-12"><button type="submit" class="btn btn-danger">Enregistrer</button></div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <?php foreach ($partenaires as $p): ?>
                <div class="col-md-4">
                    <div class="card-admin p-3 h-100 position-relative">
                        <h5 class="fw-bold text-danger"><?= htmlspecialchars($p['nom']) ?></h5>
                        <div class="text-muted small mb-2"><?= htmlspecialchars($p['type']) ?></div>
                        <p class="mb-0"><strong>Contact:</strong> <?= htmlspecialchars($p['contact']) ?></p>
                        <span class="badge bg-light text-dark border mt-2"><?= htmlspecialchars($p['type_soutien']) ?></span>
                        <a href="partenaires.php?supprimer=<?= $p['id_partenaire'] ?>" class="position-absolute top-0 end-0 m-3 text-secondary" onclick="return confirm('Supprimer ?')"><i class="fas fa-times"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>