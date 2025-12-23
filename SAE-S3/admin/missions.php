<?php
session_start();
/** @var PDO $pdo */

if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit(); }
require_once '../config/db.php';

if (isset($_GET['supprimer'])) {
    $pdo->prepare("DELETE FROM mission WHERE id_mission = ?")->execute([$_GET['supprimer']]);
    header('Location: missions.php'); exit();
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO mission (titre, description, date_debut, date_fin, lieu, nb_benevoles_requis, statut) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $pdo->prepare($sql)->execute([$_POST['titre'], $_POST['description'], $_POST['date_debut'], $_POST['date_fin'], $_POST['lieu'], $_POST['nb_requis'], $_POST['statut']]);
    $message = "<div class='alert alert-success'>Mission créée !</div>";
}
$missions = $pdo->query("SELECT * FROM mission ORDER BY date_debut ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Missions - Admin</title>
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
            <a href="missions.php" class="sidebar-link active"><i class="fas fa-calendar-alt"></i> Missions</a>
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
        <h2 class="page-title">Gestion des Missions</h2>
        <?= $message ?>

        <div class="mb-3 text-end">
            <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#formMission"><i class="fas fa-plus"></i> Créer une mission</button>
        </div>

        <div id="formMission" class="collapse mb-4">
            <div class="card-admin p-4">
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6"><label>Titre</label><input type="text" name="titre" class="form-control" required></div>
                        <div class="col-md-3"><label>Début</label><input type="datetime-local" name="date_debut" class="form-control" required></div>
                        <div class="col-md-3"><label>Fin</label><input type="datetime-local" name="date_fin" class="form-control"></div>
                        <div class="col-md-6"><label>Lieu</label><input type="text" name="lieu" class="form-control"></div>
                        <div class="col-md-3"><label>Besoin (Pers.)</label><input type="number" name="nb_requis" class="form-control" value="5"></div>
                        <div class="col-md-3"><label>Statut</label>
                            <select name="statut" class="form-select">
                                <option value="prevu">Prévu</option><option value="en_cours">En cours</option><option value="termine">Terminé</option>
                            </select>
                        </div>
                        <div class="col-12"><label>Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                        <div class="col-12"><button type="submit" class="btn btn-success">Créer</button></div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-admin p-0 overflow-hidden">
            <table class="table table-admin table-hover m-0">
                <thead><tr><th>Date</th><th>Mission</th><th>Lieu</th><th>Besoin</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                <?php foreach ($missions as $m): ?>
                    <tr>
                        <td class="fw-bold"><?= date('d/m/Y H:i', strtotime($m['date_debut'])) ?></td>
                        <td><strong><?= htmlspecialchars($m['titre']) ?></strong></td>
                        <td><?= htmlspecialchars($m['lieu']) ?></td>
                        <td><span class="badge bg-secondary"><?= $m['nb_benevoles_requis'] ?></span></td>
                        <td>
                            <?php
                            $cls = match($m['statut']) { 'prevu'=>'primary', 'en_cours'=>'success', 'termine'=>'dark' };
                            echo "<span class='badge bg-$cls'>".$m['statut']."</span>";
                            ?>
                        </td>
                        <td>
                            <a href="mission_participants.php?id_mission=<?= $m['id_mission'] ?>" class="btn btn-sm btn-outline-primary me-1" title="Participants"><i class="fas fa-user-plus"></i></a>
                            <a href="missions.php?supprimer=<?= $m['id_mission'] ?>" class="btn btn-sm btn-outline-secondary" onclick="return confirm('Supprimer ?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>