<?php
session_start();
session_unset(); // Efface les données de session actuelles

// Démarre une nouvelle session pour le nouvel utilisateur
session_regenerate_id(true); // Génère un nouvel identifiant de session pour éviter les attaques de fixation de session

require_once('C:/xampp/htdocs/suiviAppui/app/models/Database.php');

$database = new Database();
$connexion = $database->getConnection();

$error = "";



if (isset($_POST['username'], $_POST['password'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password']; 

    if (empty($username) || empty($password)) {
        $error = "Le nom d'utilisateur et le mot de passe sont requis.";
    } else {
        $stmt = $connexion->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['username'] = $row['username'];

                $token = bin2hex(random_bytes(32));
                $_SESSION['token'] = $token;
                setcookie("token_name", password_hash($token, PASSWORD_DEFAULT), time() + (86400 * 30), "/", "", true, true);

                // Redirection en fonction du rôle de l'utilisateur
                if ($_SESSION['role'] === 'admin') {
                    header("Location: http://localhost:81/suiviAppui/app/views/admin/dashbord.php");
                    exit();
                } elseif ($_SESSION['role'] === 'direction') {
                    header("Location: http://localhost:81/suiviAppui/app/views/direction/formulaire.php");
                    exit();
                } elseif ($_SESSION['role'] === 'suiviEvaluation') {
                    header("Location: http://localhost:81/suiviAppui/app/views/suiviEvaluation/dashbord.php");
                    exit();
                } elseif ($_SESSION['role'] === 'services') {
                    header("Location: http://localhost:81/suiviAppui/app/views/service/dashbord.php");
                    exit();
                } elseif ($_SESSION['role'] === 'directeur') {
                    header("Location: http://localhost:81/suiviAppui/app/views/directeur/dashbord.php");
                    exit();
                } elseif ($_SESSION['role'] === 'dashbord') {
                    header("Location: http://localhost:81/suiviAppui/app/views/dashbord.php");
                    exit();
                } else {
                    $error = "Rôle non reconnu.";
                    header("Location: http://localhost:81/suiviAppui/app/views/login.php?error=" . urlencode($error));
                    exit();
                }
            } else {
                $error = "Authentification échouée.";
            }
        } else {
            $error = "Utilisateur non trouvé.";
        }
    }
}

// Redirection en cas d'erreur ou de données manquantes
header("Location: http://localhost:81/suiviAppui/app/views/login.php?error=" . urlencode($error));
exit();

