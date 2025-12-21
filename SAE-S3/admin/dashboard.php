<?php
session_start();
/** @var PDO $pdo */

if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit(); }
require_once '../config/db.php';

// Requêtes stats
$nbBenevoles = $pdo->query("SELECT COUNT(*) FROM benevole")->fetchColumn();
$nbMissionsFutur = $pdo->query("SELECT COUNT(*) FROM mission WHERE date_debut > NOW()")->fetchColumn();
$nbParticipations = $pdo->query("SELECT COUNT(*) FROM participation")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord - Admin</title>
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
            <a href="dashboard.php" class="sidebar-link active"><i class="fas fa-home"></i> Tableau de bord</a>
            <a href="benevoles.php" class="sidebar-link"><i class="fas fa-users"></i> Bénévoles</a>
            <a href="missions.php" class="sidebar-link"><i class="fas fa-calendar-alt"></i> Missions</a>
            <a href="partenaires.php" class="sidebar-link"><i class="fas fa-handshake"></i> Partenaires</a>
            <a href="documents.php" class="sidebar-link"><i class="fas fa-folder-open"></i> Documents</a>
        </div>

        <div class="sidebar-footer">
            <a href="logout.php" class="btn-logout">
                <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
            </a>
        </div>
    </nav>

    <main class="admin-content">
        <h2 class="page-title">Tableau de bord</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card-admin stat-card p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="stat-label">Bénévoles</span>
                        <i class="fas fa-users fa-2x text-danger opacity-25"></i>
                    </div>
                    <div class="stat-value"><?= $nbBenevoles ?></div>
                    <a href="benevoles.php" class="btn btn-sm btn-outline-danger mt-3 rounded-pill">Gérer l'équipe</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-admin stat-card p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="stat-label">Missions à venir</span>
                        <i class="fas fa-calendar-check fa-2x text-danger opacity-25"></i>
                    </div>
                    <div class="stat-value"><?= $nbMissionsFutur ?></div>
                    <a href="missions.php" class="btn btn-sm btn-outline-danger mt-3 rounded-pill">Voir le planning</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-admin stat-card p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="stat-label">Participations</span>
                        <i class="fas fa-hands-helping fa-2x text-danger opacity-25"></i>
                    </div>
                    <div class="stat-value"><?= $nbParticipations ?></div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>