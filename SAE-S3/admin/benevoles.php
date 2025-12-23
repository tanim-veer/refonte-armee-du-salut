<?php
session_start();
/** @var PDO $pdo */

if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit(); }
require_once '../config/db.php';

// Suppression
if (isset($_GET['supprimer'])) {
    $pdo->prepare("DELETE FROM benevole WHERE id_benevole = ?")->execute([$_GET['supprimer']]);
    header('Location: benevoles.php'); exit();
}

// Ajout
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    try {
        $sql = "INSERT INTO benevole (nom, prenom, email, telephone, ville, profession, regime_alimentaire, limitation_physique) VALUES (?,?,?,?,?,?,?,?)";
        $pdo->prepare($sql)->execute([$_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['telephone'], $_POST['ville'], $_POST['profession'], $_POST['regime'], $_POST['limitations']]);
        $message = "<div class='alert alert-success'>Bénévole ajouté !</div>";
    } catch (Exception $e) { $message = "<div class='alert alert-warning'>Erreur (Email déjà pris ?)</div>"; }
}

// Recherche
$recherche = isset($_GET['q']) ? trim($_GET['q']) : "";
$filtre_ville = isset($_GET['ville']) ? trim($_GET['ville']) : "";
$sql = "SELECT * FROM benevole WHERE 1=1";
$params = [];

if (!empty($recherche)) {
    $sql .= " AND (nom LIKE ? OR prenom LIKE ? OR profession LIKE ?)";
    $params[] = "%$recherche%";
    $params[] = "%$recherche%";
    $params[] = "%$recherche%";
}
if (!empty($filtre_ville)) {
    $sql .= " AND ville = ?";
    $params[] = $filtre_ville;
}
$sql .= " ORDER BY date_creation DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$benevoles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bénévoles - Admin</title>
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
            <a href="benevoles.php" class="sidebar-link active"><i class="fas fa-users"></i> Bénévoles</a>
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
        <h2 class="page-title">Annuaire Bénévoles</h2>
        <?= $message ?>

        <div class="card-admin p-3">
            <form method="GET" class="row g-2">
                <div class="col-md-5"><input type="text" name="q" class="form-control" placeholder="Rechercher..." value="<?= htmlspecialchars($recherche) ?>"></div>
                <div class="col-md-3">
                    <select name="ville" class="form-select">
                        <option value="">Toutes les villes</option>
                        <?php
                        $villes = $pdo->query("SELECT DISTINCT ville FROM benevole WHERE ville != '' ORDER BY ville")->fetchAll();
                        foreach($villes as $v) {
                            $sel = ($filtre_ville == $v['ville']) ? 'selected' : '';
                            echo "<option value='".htmlspecialchars($v['ville'])."' $sel>".htmlspecialchars($v['ville'])."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2"><button type="submit" class="btn btn-danger w-100">Filtrer</button></div>
                <div class="col-md-2"><button type="button" class="btn btn-success w-100" data-bs-toggle="collapse" data-bs-target="#formAjout"><i class="fas fa-plus"></i> Nouveau</button></div>
            </form>
        </div>

        <div id="formAjout" class="collapse mb-4">
            <div class="card-admin p-4">
                <form method="POST">
                    <input type="hidden" name="ajouter" value="1">
                    <div class="row g-3">
                        <div class="col-md-6"><input type="text" name="nom" class="form-control" placeholder="Nom" required></div>
                        <div class="col-md-6"><input type="text" name="prenom" class="form-control" placeholder="Prénom" required></div>
                        <div class="col-md-6"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
                        <div class="col-md-6"><input type="text" name="telephone" class="form-control" placeholder="Téléphone"></div>
                        <div class="col-md-6"><input type="text" name="ville" class="form-control" placeholder="Ville"></div>
                        <div class="col-md-6"><input type="text" name="profession" class="form-control" placeholder="Profession"></div>
                        <div class="col-md-6">
                            <select name="regime" class="form-select"><option value="">Régime Alimentaire...</option><option>Végétarien</option><option>Halal</option><option>Sans Gluten</option></select>
                        </div>
                        <div class="col-md-6"><input type="text" name="limitations" class="form-control" placeholder="Limitations physiques"></div>
                        <div class="col-12"><button type="submit" class="btn btn-success">Enregistrer</button></div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-admin p-0 overflow-hidden">
            <table class="table table-admin table-hover m-0">
                <thead><tr><th>Identité</th><th>Contact</th><th>Ville</th><th>Profession</th><th>Infos</th><th>Action</th></tr></thead>
                <tbody>
                <?php foreach ($benevoles as $b): ?>
                    <tr>
                        <td class="fw-bold"><?= htmlspecialchars($b['nom'] . ' ' . $b['prenom']) ?></td>
                        <td><?= htmlspecialchars($b['email']) ?></td>
                        <td><?= htmlspecialchars($b['ville']) ?></td>
                        <td><?= htmlspecialchars($b['profession']) ?></td>
                        <td>
                            <?php if($b['regime_alimentaire']) echo "<span class='badge bg-info text-dark me-1'>".$b['regime_alimentaire']."</span>"; ?>
                            <?php if($b['limitation_physique']) echo "<span class='badge bg-warning text-dark'>Santé</span>"; ?>
                        </td>
                        <td>
                            <a href="benevoles.php?supprimer=<?= $b['id_benevole'] ?>" onclick="return confirm('Supprimer ?')" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
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