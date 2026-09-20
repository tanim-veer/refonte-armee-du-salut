<?php
session_start();
/** @var PDO $pdo */

if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit(); }
require_once '../config/db.php';

if (isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];
    $stmt = $pdo->prepare("SELECT nom_fichier FROM media WHERE id_media = ?");
    $stmt->execute([$id]);
    $fichier = $stmt->fetchColumn();
    if ($fichier && file_exists("uploads/" . $fichier)) { unlink("uploads/" . $fichier); }
    $pdo->prepare("DELETE FROM media WHERE id_media = ?")->execute([$id]);
    header('Location: documents.php'); exit();
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fichier'])) {
    $titre = $_POST['titre'];
    $nomOrigine = $_FILES['fichier']['name'];
    $tmpName = $_FILES['fichier']['tmp_name'];

    $extension = strtolower(pathinfo($nomOrigine, PATHINFO_EXTENSION));
    $extensionsAutorisees = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'];

    if (!in_array($extension, $extensionsAutorisees, true)) {
        $message = "<div class='alert alert-danger'>Type de fichier non autorisé (jpg, png, gif, webp, pdf).</div>";
    } elseif ($_FILES['fichier']['size'] > 0 && $_FILES['fichier']['size'] < 5000000) {
        $nouveauNom = "doc_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $extension;
        if (move_uploaded_file($tmpName, "uploads/" . $nouveauNom)) {
            $sql = "INSERT INTO media (nom_fichier, titre, type) VALUES (?, ?, ?)";
            $pdo->prepare($sql)->execute([$nouveauNom, $titre, $_FILES['fichier']['type']]);
            $message = "<div class='alert alert-success'>Fichier importé !</div>";
        } else { $message = "<div class='alert alert-danger'>Erreur upload. Dossier 'uploads' existe ?</div>"; }
    }
}
$medias = $pdo->query("SELECT * FROM media ORDER BY date_ajout DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Documents - Admin</title>
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
            <a href="partenaires.php" class="sidebar-link"><i class="fas fa-handshake"></i> Partenaires</a>
            <a href="documents.php" class="sidebar-link active"><i class="fas fa-folder-open"></i> Documents</a>
        </div>

        <div class="sidebar-footer">
            <a href="logout.php" class="btn-logout">
                <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
            </a>
        </div>
    </nav>
    <main class="admin-content">
        <h2 class="page-title">Espace Documentaire</h2>
        <?= $message ?>

        <div class="card-admin p-4 mb-4">
            <h5 class="mb-3">Importer un document</h5>
            <form method="POST" enctype="multipart/form-data" class="row g-3 align-items-end">
                <div class="col-md-5"><label>Titre</label><input type="text" name="titre" class="form-control" required></div>
                <div class="col-md-5"><label>Fichier</label><input type="file" name="fichier" class="form-control" required></div>
                <div class="col-md-2"><button type="submit" class="btn btn-danger w-100">Importer</button></div>
            </form>
        </div>

        <div class="row g-4">
            <?php foreach ($medias as $m): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card-admin p-3 h-100 text-center position-relative">
                        <div class="mb-3">
                            <?php if (strpos($m['type'], 'image') !== false): ?>
                                <img src="uploads/<?= htmlspecialchars($m["nom_fichier"]) ?>" class="img-fluid" style="max-height: 100px;">
                            <?php else: ?>
                                <i class="fas fa-file-alt fa-3x text-secondary"></i>
                            <?php endif; ?>
                        </div>
                        <h6 class="text-truncate"><?= htmlspecialchars($m['titre']) ?></h6>
                        <div class="mt-3">
                            <a href="uploads/<?= htmlspecialchars($m["nom_fichier"]) ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                            <a href="documents.php?supprimer=<?= $m['id_media'] ?>" onclick="return confirm('Supprimer ?')" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
