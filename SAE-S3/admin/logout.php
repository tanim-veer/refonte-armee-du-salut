<?php
session_start();       // On récupère la session en cours
session_destroy();     // On la détruit (oubli de l'identité)
header('Location: index.php'); // On renvoie vers la page de connexion
exit();