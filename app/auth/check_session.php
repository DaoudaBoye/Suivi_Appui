<?php
session_start();



// Récupère le rôle de l'utilisateur actuel
if (isset($_SESSION['role'])) {
    $current_role = $_SESSION['role'];
    // ...
}
// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost:81/suiviAppui/app/views/login.php");
    exit();
}

// Vérifiez si l'utilisateur est connecté
if (isset($_SESSION['username'])) {
    // Mettez à jour le timestamp de la dernière activité dans la session
    $_SESSION['last_activity'] = time();
} else {
    // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: http://localhost:81/suiviAppui/app/views/login.php");
    exit();
}
// Définition des autorisations pour chaque type d'utilisateur
$permissions = [
    'admin' => [
        'pages' => [
            'http://localhost:81/suiviAppui/app/views/admin/ajouterAppui.php',
            'http://localhost:81/suiviAppui/app/views/admin/formulaire.php',
            'http://localhost:81/suiviAppui/app/views/admin/inscription.php',
            'http://localhost:81/suiviAppui/app/views/admin/liste_demande.php',
            'http://localhost:81/suiviAppui/app/views/admin/listeSFD.php',
            'http://localhost:81/suiviAppui/app/views/admin/sfdRegister.php',
            'http://localhost:81/suiviAppui/app/views/admin/validerForm.php',

        ]
    ],
    'assistant' => [
        'pages' => [
            'http://localhost:81/suiviAppui/app/views/direction/ajouterAppui.php',
            'http://localhost:81/suiviAppui/app/views/direction/formulaire.php',
            'http://localhost:81/suiviAppui/app/views/direction/liste_demande.php',
            'http://localhost:81/suiviAppui/app/views/direction/listeSFD.php',
            'http://localhost:81/suiviAppui/app/views/direction/sfdRegister.php',
        ]
    ],
    'suiviEvaluation' => [
        'pages' => [
            'http://localhost:81/suiviAppui/app/views/moderator/adminConfirmForm.php',
            'http://localhost:81/suiviAppui/app/views/moderator/ajouterAppui.php',
            'http://localhost:81/suiviAppui/app/views/moderator/liste_demande.php',
            'http://localhost:81/suiviAppui/app/views/moderator/listeSFD.php',
            'http://localhost:81/suiviAppui/app/views/moderator/sfdRegister.php',
            'http://localhost:81/suiviAppui/app/views/moderator/validerForm.php',
        ]
    ],
    'services' => [
        'pages' => [
            'http://localhost:81/suiviAppui/app/views/moderator/ajouterAppui.php',
            'http://localhost:81/suiviAppui/app/views/moderator/liste_demande.php',
            'http://localhost:81/suiviAppui/app/views/moderator/listeSFD.php',
            'http://localhost:81/suiviAppui/app/views/moderator/sfdRegister.php',
            // ... Ajoutez d'autres pages pour les services
        ]
    ],
    'directeur' => [
        'pages' => [
            'directeurPage1.php',
            'directeurPage2.php',
            // ... Ajoutez d'autres pages pour les directeurs
        ]
    ]
];

// Vérifie si la page en cours fait partie des pages autorisées pour ce rôle
$currentPage = 'http://localhost:81/suiviAppui/app/views/' . basename($_SERVER['PHP_SELF']);

if (isset($_SESSION['role'])) {
    $current_role = $_SESSION['role'];

    // Vérifie si l'utilisateur est connecté
    if (!isset($_SESSION['username'])) {
        header("Location: http://localhost:81/suiviAppui/app/views/login.php");
        exit();
    }

    // Vérifie si le rôle a des pages autorisées définies
    if (isset($permissions[$current_role]['pages'])) {
        $allowed_pages = $permissions[$current_role]['pages'];
    
        // Vérifie si la page en cours fait partie des pages autorisées pour ce rôle
        // if (!in_array($currentPage, $allowed_pages)) {
        //     // Redirection vers la page forbidden.php si l'accès est refusé
        //     header("Location: http://localhost:81/demande/app/views/forbidden.php");
        //     exit();
        // }
    }
    
}

