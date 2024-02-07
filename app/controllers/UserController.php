<?php
// require_once('C:/xampp/htdocs/demande/app/models/UserModel.php');

// class UserController {
//     private $userModel;

//     public function __construct() {
//         $this->userModel = new UserModel();
//     }

//     public function login() {
//         // Vérifier si les données POST existent
//         if ($_SERVER["REQUEST_METHOD"] == "POST") {
//             // Récupérer les données soumises du formulaire
//             $email = $_POST['email'] ?? null;
//             $password = $_POST['password'] ?? null;

//             if ($email && $password) {
//                 $user = $this->userModel->getUserByEmail($email);

//                 if ($user !== false && password_verify($password, $user['password'])) {
//                     // Authentification réussie
//                     if ($user['role'] === 'admin') {
//                         // Redirection vers la page d'administration pour les utilisateurs avec le rôle "admin"
//                         header('Location: http://localhost:81/demande/app/views/formulaire.php');
//                         exit(); // Assurez-vous de terminer le script après une redirection
//                     } else {
//                         // Redirection vers la page utilisateur pour les autres utilisateurs
//                         header('Location: http://localhost:81/demande/app/views/adminConfirm.php');
//                         exit(); // Assurez-vous de terminer le script après une redirection
//                     }
//                 } else {
//                     echo "Identifiants incorrects. Veuillez réessayer.";
//                     // Identifiants incorrects, afficher un message d'erreur
//                 }
//             } else {
//                 echo "Veuillez remplir tous les champs du formulaire.";
//             }
//         }
//     }
// }

// // Instanciation du UserController
// $userController = new UserController();
// // Appel de la méthode login pour traiter la soumission du formulaire
// $userController->login();
?>
