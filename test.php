
<?php
session_start();

require_once('C:/xampp/htdocs/demande/app/models/Database.php');
// Inclusion des fichiers nécessaires


$database = new Database();
$connexion = $database->getConnection();

$error = "";

if (isset($_POST['username'], $_POST['password'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password']; // Pas besoin de nettoyer le mot de passe, nous l'utiliserons tel quel pour la vérification

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

                // Génération et stockage du token
                $token = bin2hex(random_bytes(32));
                $_SESSION['token'] = $token;
                setcookie("token_name", password_hash($token, PASSWORD_DEFAULT), time() + (86400 * 30), "/", "", true, true);

                // Redirection en fonction du rôle de l'utilisateur
                $redirectURL = "";
                switch ($_SESSION['role']) {
                    case 'admin':
                        $redirectURL = "http://localhost:81/demande/app/views/admin/inscription.php";
                        break;
                    case 'assistant':
                        $redirectURL = "http://localhost:81/demande/app/views/direction/formulaire.php";
                        break;
                    case 'suiviEvaluation':
                        $redirectURL = "http://localhost:81/demande/app/views/suiviEvaluation/validerForm.php";
                        break;
                    case 'services':
                        $redirectURL = "http://localhost:81/demande/app/views/member/sfdRegister.php";
                        break;
                    case 'directeur':
                        $redirectURL = "http://localhost:81/demande/app/views/directeur/dashbord.php";
                        break;
                    // Ajoutez les autres rôles ici
                    default:
                        // Gestion pour les rôles non spécifiés
                        break;
                }
                if (!empty($redirectURL)) {
                    header("Location: http://localhost:81/demande/app/views/$redirectURL");
                    exit();
                }
            } else {
                $error = "Authentification échouée.";
            }
        } else {
            $error = "Nom d'utilisateur incorrect.";
        }
    }
}
// En cas d'erreurs, rediriger vers la page de connexion avec un message d'erreur
header("Location: http://localhost:81/demande/app/views/login.php?error=" . urlencode($error));
exit();

?>
