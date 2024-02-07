<?php
// Démarrez la session si ce n'est pas déjà fait
session_start();

// Détruire toutes les données de session
session_destroy();

// Rediriger vers la page de connexion ou une autre page après la déconnexion
header("Location: http://localhost:81/demande/app/views/login.php"); // Remplacez login.php par la page de connexion actuelle ou toute autre page souhaitée après la déconnexion
exit;
?>
