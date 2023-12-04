<?php
    require_once('C:/xampp/htdocs/demande-appui/app/controllers/MainController.php');



    $controller = new MainController();

    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        // Gérer les différentes actions ici
        switch ($action) {
            case 'showForm':
                $controller->showForm();
                break;
            case 'submitForm':
                $controller->submitForm();
                break;
            case 'getDepartementsByRegion':
                $controller->getDepartementsByRegion($selectRegion);
                break;
            case 'getTypesActivitesByTypeAppui':
                $controller->getTypesActivitesByTypeAppui($selectAppui);
                break;
            default:
                 // Gérer un cas par défaut ou une action non reconnue
                 // Par exemple, afficher une page d'erreur ou rediriger vers une autre page
                include('./views/error.php');
                break;
        }
    } else {
        header('http://localhost:81/demande-appui/app/views/formulaire.php'); // Redirige vers une autre page par défaut
        exit();
    }
?>
