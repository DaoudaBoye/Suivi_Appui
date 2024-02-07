<?php
// Routeur

// Inclusion des fichiers nécessaires
require_once('app/controllers/mainController.php');
require_once('app/models/database.php');
require_once('app/models/demandeModel.php');

// Récupération de la requête
$request = isset($_GET['page']) ? $_GET['page'] : 'home';

// Switch pour router les requêtes vers les contrôleurs correspondants
switch ($request) {
    case 'confirmation':
        include('app/views/confirmation.php');
        break;
    case 'adminConfirm':
        include('app/views/adminConfirm.php');
        break;
    case 'formulaire':
        include('app/views/formulaire.php');
        break;
    case 'liste_demande':
        include('app/views/liste_demande.php');
        break;
    case 'listeSFD':
        include('app/views/listeSFD.php');
        break;
    case 'login':
        include('app/views/login.php');
        break;
    case 'sfdRegister':
        include('app/views/sfdRegister.php');
        break;
    default:
        // Gérer les pages non trouvées ou la page d'accueil
        include('app/views/login.php');
        break;
}
?>
