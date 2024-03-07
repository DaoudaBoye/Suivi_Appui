<?php
class AuthController {
    public function login($username, $password) {
        // ... logique de validation des identifiants de l'utilisateur ...

        // Vérification des identifiants de l'utilisateur (exemple simplifié)
        if ($username === "utilisateur" && $password === "motdepasse") {
            // Générer et stocker le token après une connexion réussie
            $token = $this->generateToken();
            // Stocker le token dans la session
            $_SESSION['token'] = $token;
            // Création d'un cookie avec une version chiffrée du token (côté client)
            $tokenEncrypted = password_hash($token, PASSWORD_DEFAULT);
            setcookie("token_name", $tokenEncrypted, time() + (86400 * 30), "/");
            // Redirection vers une page sécurisée
            header("Location: page_protegee.php");
            exit;
        } else {
            // Gestion de l'échec de la connexion
            // ...
        }
    }

    private function generateToken() {
        // Générer un token aléatoire
        return bin2hex(random_bytes(32)); // Génère un token de 32 octets (256 bits)
    }
}

