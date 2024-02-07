<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["nickname"], $_POST["email"], $_POST["password"])
        && !empty($_POST["nickname"]) && !empty($_POST["email"]) &&
        !empty($_POST["password"]) && !empty($_POST["role"])
    ) {
        $pseudo = strip_tags($_POST["nickname"]);
        $role = $_POST["role"];
        
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            die("L'adresse email est incorrecte");
        }
        
        // On va hacher le mot de passe
        $password = password_hash($_POST["password"], PASSWORD_ARGON2ID);

        require_once('C:/xampp/htdocs/demande/app/models/Database.php');

        // Connexion à la base de données MySQLi
        $db = new mysqli("localhost", "root", "", "demande_appui");

        // Vérification de la connexion
        if ($db->connect_error) {
            die("Échec de la connexion : " . $db->connect_error);
        }

        // Préparation de la requête
        $sql = "INSERT INTO utilisateurs (nom, email, password, role) VALUES (?, ?, ?, ?)";
        $query = $db->prepare($sql);
        
        // Liaison des valeurs et exécution de la requête
        $query->bind_param("ssss", $pseudo, $_POST["email"], $password, $role);
        $query->execute();
        
        $id = $db->insert_id;

        session_start();

        $_SESSION["user"] = [
          "id" => $id,
          "pseudo" => $pseudo,
          "email" => ["ROLE_USER"],
          "roles" => json_decode($user["role"], true) // Assurez-vous que $user["role"] contient les rôles sous forme de chaîne JSON
      ];

     
            header("Location: http://localhost:81/demande/app/views/formulaire.php");
       
            // Vérification de l'insertion
        // if ($query->affected_rows > 0) {
        //     echo "Utilisateur ajouté avec succès.";
        // } else {
        //     echo "Erreur lors de l'ajout de l'utilisateur : " . $db->error;
        // }

        // Fermeture de la connexion
    //     $query->close();
    //     $db->close();
    } else {
        die("Le formulaire est incomplet");
    }
}
?>


<!DOCTYPE html>
<html lang="fr" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - nice-forms.css</title>
  <!-- Vos liens de feuilles de style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
  <link href="./plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="../public/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../public/script.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    body {
        padding-top: 60px; /* Ajustez la valeur selon la hauteur de votre barre de navigation */
    }

    
    /* Styles pour le mode sombre */
body.dark-theme {
    background-color: #222;
    color: #fff; /* Couleur de texte en mode sombre */
} */
    /* Styles spécifiques pour le bouton en mode sombre */
body.dark-theme #themeToggle {
    background-color: #ffcc00; /* Couleur de fond pour le bouton en mode sombre */
    color: #222; /* Couleur de texte pour le bouton en mode sombre */
    border: 1px solid #ffcc00; /* Bordure pour le bouton en mode sombre */
    /* Autres styles selon votre préférence */
}

/* Hover styles pour le bouton en mode sombre */
body.dark-theme #themeToggle:hover {
    background-color: #ffdd44; /* Couleur de fond au survol en mode sombre */
    color: #333; /* Couleur de texte au survol en mode sombre */
    border-color: #fff; /* Couleur de bordure au survol en mode sombre */
    /* Autres styles au survol selon votre préférence */
}

body.dark-theme .navbar {
    background-color: #fff; /* Couleur de fond pour le bouton en mode sombre */
    color: #222; /* Couleur de texte pour le bouton en mode sombre */
    border: 1px solid #fff; /* Bordure pour le bouton en mode sombre */
    /* Autres styles selon votre préférence */
}

    
</style>

</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="#">
    <img src="Logo_FIMF.png" alt="Logo" height="40">
  </a>
  <!-- Bouton pour afficher le menu sur mobile -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="button-group">
    <button id="themeToggle">Mode sombre</button>
  </div>
  <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="http://localhost:81/demande/app/views/formulaire.php"><i class="fas fa-home"></i> Accueil <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fas fa-info-circle"></i> À propos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fas fa-envelope"></i> Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fas fa-user"></i> Mon compte</a>
        </li>
      </ul>
    </div>
</nav>
  <div class="demo-page my-demo">
    <div class="demo-page-navigation">
      <nav>
        <ul>
          <li>
            <a href="http://localhost:81/demande/app/views/formulaire.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
            </svg>
              Insérer une demande</a>
          </li>
          <li>
            <a href="liste_demande.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                <polygon points="12 2 2 7 12 12 22 7 12 2" />
                <polyline points="2 17 12 22 22 17" />
                <polyline points="2 12 12 17 22 12" />
              </svg>
              Voir la liste des demandes</a>
          </li>
          <!-- <li>
            <a href="#input-types">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-justify">
                <line x1="21" y1="10" x2="3" y2="10" />
                <line x1="21" y1="6" x2="3" y2="6" />
                <line x1="21" y1="14" x2="3" y2="14" />
                <line x1="21" y1="18" x2="3" y2="18" />
              </svg>
              Modifier une demande</a>
          </li> -->
        
          <li>
            <a href="sfdRegister.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders">
                <line x1="4" y1="21" x2="4" y2="14" />
                <line x1="4" y1="10" x2="4" y2="3" />
                <line x1="12" y1="21" x2="12" y2="12" />
                <line x1="12" y1="8" x2="12" y2="3" />
                <line x1="20" y1="21" x2="20" y2="16" />
                <line x1="20" y1="12" x2="20" y2="3" />
                <line x1="1" y1="14" x2="7" y2="14" />
                <line x1="9" y1="8" x2="15" y2="8" />
                <line x1="17" y1="16" x2="23" y2="16" />
              </svg>
              Enregistrer un SFD</a>
          </li>
          <li>
            <a href="http://localhost:81/demande/app/views/listeSFD.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list">
                <line x1="8" y1="6" x2="21" y2="6" />
                <line x1="8" y1="12" x2="21" y2="12" />
                <line x1="8" y1="18" x2="21" y2="18" />
                <line x1="3" y1="6" x2="3.01" y2="6" />
                <line x1="3" y1="12" x2="3.01" y2="12" />
                <line x1="3" y1="18" x2="3.01" y2="18" />
              </svg>
              Voir la liste des SFD</a>
          </li>
          <li>
            <a href="#reset">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-power">
                <path d="M18.36 6.64a9 9 0 1 1-12.73 0" />
                <line x1="12" y1="2" x2="12" y2="12" />
              </svg>
              Déconnexion</a>
          </li>
        </ul>
      </nav>
    </div>
    <main class="demo-page-content">

      <section>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validateForm()">
          <div class="href-target" id="input-types"></div>
          <h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-justify">
              <line x1="21" y1="10" x2="3" y2="10" />
              <line x1="21" y1="6" x2="3" y2="6" />
              <line x1="21" y1="14" x2="3" y2="14" />
              <line x1="21" y1="18" x2="3" y2="18" />
            </svg>
            Créer un utilisateur
          </h1>
          <p>Veuillez renseignez tous les champs svp !</p>
          <div class="nice-form-group">
          <label for="role">Rôle</label>
          <select id="role" name="role" required>
            <option value="user">Utilisateur</option>
            <option value="admin">Administrateur</option>
            <option value="superadmin">Super Administrateur</option>
          </select>
</div>


          <div class="nice-form-group">
            <label for="pseudo">Pseudo</label>
            <input type="text" id="speudo" name="nickname" required>
          </div>

          <div class="nice-form-group">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="exemple@gmail.com" name="email" required/>
          </div>

          <div class="nice-form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" required />
          </div>
        
        
         
          <button type="submit" name="register">
              <i class="fas fa-save"></i> M'inscrire
          </button>
        </form>
      </section>

      <footer>Made By ♥ FIMF</footer>
    </main>
  </div>
</body>
</html>