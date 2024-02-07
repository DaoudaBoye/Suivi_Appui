<?php
session_start();
require_once('C:/xampp/htdocs/demande/app/models/Database.php');

$database = new Database();
$connexion = $database->getConnection();

if (isset($_POST['username'], $_POST['password'])) {
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);

    if (empty($username)) {
        header("Location: http://localhost:81/demande/app/views/login.php?error=Le nom d'utilisateur est requis");
        exit();
    } elseif (empty($password)) {
        header("Location: http://localhost:81/demande/app/views/login.php?error=Le mot de passe est requis");
        exit();
    } else {
        // Utiliser des requêtes préparées pour éviter les injections SQL
        $stmt = $connexion->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            // Utilisation de password_verify() pour comparer les mots de passe hachés
            if (password_verify($password, $row['password'])) {
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['username'] = $row['username'];

                // Redirection en fonction du rôle de l'utilisateur
                if ($_SESSION['role'] === 'admin') {
                    header("Location: http://localhost:81/demande/app/views/adminConfirm.php");
                    exit();
                } elseif ($_SESSION['role'] === 'user') {
                    header("Location: http://localhost:81/demande/app/views/formulaire.php");
                    exit();
                } elseif ($_SESSION['role'] === 'moderator') {
                    header("Location: http://localhost:81/demande/app/views/validerForm.php");
                    exit();
                } elseif ($_SESSION['role'] === 'member1') {
                    header("Location: http://localhost:81/demande/app/views/member1_page.php");
                    exit();
                } elseif ($_SESSION['role'] === 'member2') {
                    header("Location: http://localhost:81/demande/app/views/member2_page.php");
                    exit();
                } else {
                    header("Location: http://localhost:81/demande/app/views/default_dashboard.php");
                    exit();
                }
            }
        }
        }
}
?>
