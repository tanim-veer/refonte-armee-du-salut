<?php
require_once '../config/db.php';
/** @var PDO $pdo */

// On récupère les missions "Prévues" ou "En cours"
$sql = "SELECT * FROM mission WHERE statut != 'termine' ORDER BY date_debut ASC LIMIT 3";
$stmt = $pdo->query($sql);
$missions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Rejoignez l’Armée du Salut comme bénévole pour aider les plus fragiles. Découvrez nos missions d’aide alimentaire, soutien scolaire, accompagnement des personnes âgées et plus encore.">
    <meta name="keywords" content="bénévolat, Armée du Salut, aide alimentaire, soutien scolaire, personnes âgées, solidarité, insertion professionnelle, animations, dons, charité">
    <meta name="author" content="Armée du Salut">
    <title>Devenir bénévole de l’Armée du Salut</title>
    <link rel="icon" href="../img/logo.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<!-- Contenu principal -->
<main id="main-content">

    <!-- Navigation en haut de page -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- bouton burger pour mobile -->
            <a class="navbar-brand" href="https://www.armeedusalut.fr/">
                <img src="../img/logo.png" alt="Logo Armée du Salut" width="60" height="60" class="rounded">
            </a>
            <!-- Bouton burger pour menu responsive -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Liens du menu -->
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../Page d'Acceuil/index.html">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Page%20Qui%20Somme%20Nous/index.html">Qui sommes-nous</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Page%20Actions%20Sociales/index.html">Nos actions</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Page%20Actualité/index.html">Actualités</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Page%20Nos%20Contacts/index.html">Contact</a></li>
                </ul>
                <!-- Bouton pour faire un don -->
                <a href="https://donner.armeedusalut.fr/don-fondation/" class="btn btn-primary-red ms-3 fw-bold rounded-pill">Faire un don</a>
            </div>
        </div>
    </nav>

    <!-- HEADER -->
    <section class="page-header-banner">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../Page%20d'Acceuil/index.html">Accueil</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pourquoi devenir bénévole ?</li>
                </ol>
            </nav>
            <h1 class="display-5">Pourquoi devenir bénévole ?</h1>
            <p class="lead">Partagez vos compétences et engagez-vous pour la solidarité.</p>
        </div>
    </section>

    <!-- Section d'intro "Pourquoi devenir bénévole ?" -->
    <section class="section py-5">
        <div class="container">
            <div class="row g-4 align-items-center">
                <!-- Image à droite sur desktop -->
                <div class="col-md-6 order-md-2">
                    <img src="img/intro.jpeg" alt="Bénévoles au food truck" class="img-fluid rounded shadow-sm">
                </div>
                <!-- Texte à gauche -->
                <div class="col-md-6 order-md-1">
                    <p>Rejoignez la communauté des bénévoles de l’Armée du Salut et mettez vos compétences au service des plus fragiles. Que ce soit pour des missions ponctuelles ou régulières, votre engagement fait la différence. Découvrez nos missions sur <a href="https://pab.armeedusalut.fr" class="action-link fw-bold">notre plateforme du bénévolat</a>.</p>
                    <p>Avec 9 000 bénévoles en France, l’Armée du Salut agit au quotidien pour accompagner les personnes en difficulté. Rejoignez-nous et apportez votre énergie à nos actions solidaires.</p>
                    <h3>Un vivier de 9 000 bénévoles aident l’Armée du Salut en France</h3>
                    <!-- Bouton contact -->
                    <div class="text-center text-md-start mt-4">
                        <a href="https://pab.armeedusalut.fr" class="btn btn-primary-red btn-lg fw-bold rounded-pill px-4">Contactez-nous</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section des différentes missions de bénévolat -->
    <section class="section bg-light">
        <div class="container mb-5">
            <h2 class="section-title display-6 text-center mb-4" style="color: var(--rouge);">Les prochaines missions (En direct)</h2>
            <div class="row g-4">

                <?php foreach($missions as $m): ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow border-danger border-2">
                            <div class="card-header bg-danger text-white fw-bold">
                                <?= date('d/m/Y', strtotime($m['date_debut'])) ?>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?= htmlspecialchars($m['titre']) ?></h4>
                                <p class="card-text text-muted">
                                    <i class="fas fa-map-marker-alt text-danger"></i> <?= htmlspecialchars($m['lieu']) ?><br>
                                    <i class="fas fa-users text-danger"></i> Besoin : <?= $m['nb_benevoles_requis'] ?> pers.
                                </p>
                                <p><?= htmlspecialchars($m['description']) ?></p>
                                <a href="mailto:benevolat@armeedusalut.fr?subject=Candidature Mission <?= $m['id_mission'] ?>" class="btn btn-outline-danger w-100">Je participe !</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if(empty($missions)): ?>
                    <div class="col-12 text-center">
                        <div class="alert alert-light">Aucune mission planifiée pour le moment. Revenez vite !</div>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <div class="container">
            <h2 class="section-title display-5 text-center">Les différentes missions de bénévolat</h2>

            <div class="missions-grid">
                <a href="https://www.armeedusalut.fr/nous-rejoindre/benevolat/faire-du-benevolat-aupres-des-sans-abri" class="card-link">
                    <div class="card">
                        <img src="img/alimentaire.webp" alt="Bénévoles distribuant des repas">
                        <div class="card-body">
                            <h3 class="card-title">L'aide alimentaire</h3>
                            <p>Plusieurs centaines de bénévoles participent chaque année à la distribution quotidienne de repas aux personnes dans le besoin.</p>
                            <span class="action-link fw-bold">En savoir plus</span>
                        </div>
                    </div>
                </a>

                <a href="https://www.armeedusalut.fr/nous-rejoindre/benevolat/faire-du-benevolat-en-soutien-scolaire" class="card-link">
                    <div class="card">
                        <img src="img/scolaire.jpeg" alt="Bénévoles en soutien scolaire">
                        <div class="card-body">
                            <h3 class="card-title">L'accès et la transmission de savoirs</h3>
                            <p>Nos bénévoles proposent des cours d’alphabétisation, de français langue étrangère et du soutien scolaire pour enfants et adolescents.</p>
                            <span class="action-link fw-bold">En savoir plus</span>
                        </div>
                    </div>
                </a>

                <a href="https://www.armeedusalut.fr/nous-rejoindre/benevolat/faire-du-benevolat-aupres-des-personnes-agees" class="card-link">
                    <div class="card">
                        <img src="img/age.jpeg" alt="Bénévoles avec personnes âgées">
                        <div class="card-body">
                            <h3 class="card-title">L’accompagnement de personnes âgées</h3>
                            <p>Bénévoles visitent les personnes âgées dans les établissements ou à domicile pour les distraire et leur tenir compagnie.</p>
                            <span class="action-link fw-bold">En savoir plus</span>
                        </div>
                    </div>
                </a>

                <a href="https://www.armeedusalut.fr/nous-rejoindre/benevolat/soins-sans-abri" class="card-link">
                    <div class="card">
                        <img src="img/soin.jpeg" alt="Bénévoles en soins">
                        <div class="card-body">
                            <h3 class="card-title">Les soins</h3>
                            <p>Des professionnels de santé, soutenus par des bénévoles, assurent des permanences à Dunkerque et Paris.</p>
                            <span class="action-link fw-bold">En savoir plus</span>
                        </div>
                    </div>
                </a>

                <div class="card">
                    <img src="img/emploi.jpeg" alt="Bénévoles en insertion">
                    <div class="card-body">
                        <h3 class="card-title">L’accompagnement emploi/formation</h3>
                        <p>Interventions en coordination avec les référents sociaux pour l’insertion professionnelle.</p>
                    </div>
                </div>

                <div class="card">
                    <img src="img/animation.jpeg" alt="Bénévoles en animations">
                    <div class="card-body">
                        <h3 class="card-title">Les animations</h3>
                        <p>Activités culturelles, sportives, sorties ou visites, etc.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section vidéo -->
    <section class="section">
        <div class="container">
            <h2 class="section-title text-center mb-4">Découvrez nos missions en action</h2>
            <!-- Vidéo Youtube intégrée -->
            <div class="ratio ratio-16x9 mx-auto" style="max-width: 1000px;">
                <iframe src="https://www.youtube.com/embed/Bop3hMOx9jw" title="YouTube video" allowfullscreen></iframe>
            </div>
        </div>
    </section>


    <!-- Section "Pourquoi faire du bénévolat ?" -->
    <section class="section" style="padding-bottom: 5rem;">
        <div class="container">
            <h2 class="section-title display-5 text-center">Pourquoi faire du bénévolat ?</h2>
            <p class="text-center lead text-muted mb-5">Tout au long de l’année, les nouveaux bénévoles souhaitant s’engager à nos côtés sont les bienvenus, partout où l’Armée du Salut agit.</p>
            <p class="text-center">Les bénévoles de l’Armée du Salut, grâce à la richesse des missions auxquelles ils participent et aux valeurs qu'ils transmettent, développent des compétences qu’ils pourront utiliser dans tous les aspects de la vie. De plus, le bénévolat au sein d’une fondation ou d’une association est une expérience fortement valorisée dans le monde du travail.</p>
            <p class="text-center mt-4">Vous souhaitez devenir bénévole ? Renseignez-vous, contactez-nous, tout soutien dans nos actions de solidarité, ponctuel ou régulier, est utile et précieux !</p>
            <!-- Coordonnées de contact -->
            <div class="text-center mt-4">
                <ul class="list-unstyled">
                    <li class="mb-2">Appeler le service bénévolat : 01 43 62 25 42</li>
                    <li class="mb-2"><strong>Écrire au service bénévolat :</strong> <a href="mailto:benevolat@armeedusalut.fr" class="action-link fw-bold">benevolat@armeedusalut.fr</a></li>
                    <li><strong>Envoyer un courrier :</strong> Armée du Salut, Service bénévolat, 60 rue des Frères Flavien, 75976 Paris Cedex 20</li>
                </ul>
                <a href="https://pab.armeedusalut.fr" class="btn btn-primary-red btn-lg fw-bold rounded-pill">Contactez-nous</a>
            </div>
        </div>
    </section>
</main>

<!-- Newsletter -->
<section class="section-newsletter py-4">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center text-md-start">
            <div class="col-md-6 mb-3 mb-md-0">
                <h4 class="mb-0">Je m'inscris à la Newsletter de la Fondation de l'Armée du Salut</h4>
            </div>
            <div class="col-md-6 col-lg-5">
                <form class="d-flex">
                    <input class="form-control me-2" type="email" placeholder="Votre adresse mail" aria-label="Adresse mail">
                    <button class="btn btn-light" type="submit">OK</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="footer-main">
        <div class="footer-block">
            <!-- Infos sur l'Armée du Salut -->
            <h3 class="h5">Armée du Salut</h3>
            <p>Ensemble, transformons des vies depuis 1881</p>
            <!-- Réseaux sociaux -->
            <div class="socials">
                <a href="https://www.facebook.com/people/Fondation-de-lArmée-du-Salut-France/100064903023958/" target="_blank">
                    <img src="../img/facebook.png" alt="Facebook" width="20" height="20">
                </a>
                <a href="https://www.linkedin.com/company/fondation-de-l-arm-e-du-salut/?viewAsMember=true" target="_blank">
                    <img src="../img/linkedin.webp" alt="LinkedIn" width="20" height="20">
                </a>
                <a href="https://www.instagram.com/armeedusalutfrance/?hl=fr" target="_blank">
                    <img src="../img/insta.png" alt="Instagram" width="20" height="20">
                </a>
            </div>
        </div>

        <!-- Liens importants -->
        <div class="footer-block">
            <h3 class="h5">Liens utiles</h3>
            <ul>
                <li><a href="index.php">Devenir bénévole</a></li>
                <li><a href="../Page%20Devenir%20Salarié/index.html">Nous rejoindre</a></li>
                <li><a href="https://donner.armeedusalut.fr/don-fondation/">Faire un don</a></li>
                <li><a href="../Page%20Nos%20Contacts/index.html">Nous contacter</a></li>
                <li><a href="../admin/index.php">Espace Bureau</a></li>
            </ul>
        </div>

        <!-- Adresse -->
        <div class="footer-block">
            <h3 class="h5">Contact</h3>
            <address>
                60 rue des Frères Flavien<br>
                75976 Paris Cedex 20<br>
                Tél : 01 43 62 25 42<br>
                Email : <a href="mailto:contact@armeedusalut.fr">contact@armeedusalut.fr</a>
            </address>
        </div>
    </div>

    <!-- Copyright -->
    <div class="footer-bottom">
        <p>© 2025 Armée du Salut. Tous droits réservés.</p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>