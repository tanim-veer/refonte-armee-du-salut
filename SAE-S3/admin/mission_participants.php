<?php
session_start();
/** @var PDO $pdo */

if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit(); }
require_once '../config/db.php';
if (!isset($_GET['id_mission'])) { header('Location: missions.php'); exit(); }

$id = $_GET['id_mission'];
$mission = $pdo->query("SELECT * FROM mission WHERE id_mission=$id")->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->prepare("INSERT INTO participation (id_mission, id_benevole) VALUES (?,?)")->execute([$id, $_POST['id_benevole']]);
    } catch (Exception $e) {}
}
if (isset($_GET['retirer'])) {
    $pdo->prepare("DELETE FROM participation WHERE id_mission=? AND id_benevole=?")->execute([$id, $_GET['retirer']]);
    header("Location: mission_participants.php?id_mission=$id"); exit();
}

$parts = $pdo->query("SELECT b.* FROM benevole b JOIN participation p ON b.id_benevole=p.id_benevole WHERE p.id_mission=$id")->fetchAll();
$dispo = $pdo->query("SELECT * FROM benevole WHERE id_benevole NOT IN (SELECT id_benevole FROM participation WHERE id_mission=$id)")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Participants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="admin-container">
    <main class="admin-content">
        <a href="missions.php" class="btn btn-outline-secondary mb-4"><i class="fas fa-arrow-left"></i> Retour</a>

        <div class="card-admin p-4 border-start border-danger border-5">
            <h2 class="text-danger"><?= htmlspecialchars($mission['titre']) ?></h2>
            <p class="mb-0 text-muted"><?= date('d/m/Y', strtotime($mission['date_debut'])) ?> | <?= htmlspecialchars($mission['lieu']) ?></p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card-admin p-4">
                    <h5 class="mb-3">Ajouter un bénévole</h5>
                    <form method="POST">
                        <select name="id_benevole" class="form-select mb-3">
                            <?php foreach($dispo as $d): ?>
                                <option value="<?= $d['id_benevole'] ?>"><?= htmlspecialchars($d['nom'].' '.$d['prenom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-danger w-100" <?= empty($dispo)?'disabled':'' ?>>Inscrire</button>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card-admin p-0 overflow-hidden">
                    <table class="table table-admin m-0">
                        <thead><tr><th>Nom</th><th>Ville</th><th>Action</th></tr></thead>
                        <tbody>
                        <?php foreach($parts as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['nom'].' '.$p['prenom']) ?></td>
                                <td><?= htmlspecialchars($p['ville']) ?></td>
                                <td><a href="mission_participants.php?id_mission=<?= $id ?>&retirer=<?= $p['id_benevole'] ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>