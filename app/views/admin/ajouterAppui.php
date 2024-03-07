<?php
// session_start();

require_once('C:/xampp/htdocs/suiviAppui/app/auth/check_session.php');

require_once('C:/xampp/htdocs/suiviAppui/app/models/Database.php');
require_once('C:/xampp/htdocs/suiviAppui/app/models/DemandeModel.php');


// Dans votre fichier de routeur ou d'initialisation
require_once('C:/xampp/htdocs/suiviAppui/app/models/sfdModel.php');



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $appName = $_POST['appName'];
    $typeActivite = $_POST['typeActivite'];
    // Récupérer les champs de texte et les stocker dans un tableau associatif
    $textFields = $_POST; // Assurez-vous que les champs de texte sont correctement nommés dans le formulaire

    $controller = new sfdModel();
    $result = $controller->enregistrerAppui($appName, $typeActivite, $textFields);
    // Traitez ici le résultat en fonction de vos besoins (par exemple, redirection, affichage, etc.)

    if ($result === "success") {
      $_SESSION['success_message'] = "L'appui' a été insérée avec succès!";
      $_SESSION['show_popup'] = true; // Ajout d'une variable de session pour afficher la boîte de dialogue modale
  } else {
      $_SESSION['error_message'] = $result;
  }
  }

?>


<!DOCTYPE html>
<html lang="fr" >
<head>
  <meta charset="UTF-8">
  <title>Suivi demandes appuis</title>
  <!-- Vos liens de feuilles de style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <!-- <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="./table.css"> -->
  <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
  <link href="./plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="../../public/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../../public/script.js"></script>
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

/* Exemple de style pour l'icône de profil et le nom de l'utilisateur */
.profile {
    display: flex;
    align-items: center;
    color: #fff;
}

.profile img {
    width: 40px; /* Ajustez la taille de votre icône */
    height: 40px;
    border-radius: 50%; /* Pour un style de cercle */
    margin-right: 10px; /* Espace entre l'icône et le texte */
}

.profile span {
    font-weight: bold;
    font-size: 16px;
}
    
</style>

</head>
<body>
   <!-- Barre de navigation -->
     <!-- Barre de navigation -->
     <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="#">
        <img src="../Logo_FIMF.png" alt="Logo" height="40">
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
              <a class="nav-link" href="http://localhost:81/suiviAppui/app/views/user/formulaire.php"><i class="fas fa-home"></i> Accueil <span class="sr-only">(current)</span></a>
            </li>
            <div class="profile">
            <img src="../user.png" alt="Icône de profil">
            <span><?php echo $_SESSION['name']; ?></span>
        </div>
          </ul>
        </div>
    </nav>
  <div class="demo-page">
  <div class="demo-page-navigation mon-demo">
  <nav>
        <ul>
        <li>
            <a href="inscription.php">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
            <path d="M12 2c3.31 0 6 2.69 6 6 0 2.09-1.91 4.49-5.34 7.34-1.41 1.1-2.83 1.92-3.66 2.46a.5.5 0 0 1-.61 0c-.83-.54-2.25-1.36-3.66-2.46C3.91 12.49 2 10.09 2 8c0-3.31 2.69-6 6-6zm0 2c-2.21 0-4 1.79-4 4 0 1.65 1.19 3.51 4 5.75 2.81-2.24 4-4.1 4-5.75 0-2.21-1.79-4-4-4zm5 8h-2v2h-2v-2H7v-2h2V8h2v2h2v2z"/>
          </svg>

             Créer un utilisateur</a>
          </li>
        <li>
            <a href="formulaire.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
            </svg>
              Insérer une demande</a>
          </li>
          <li>
            <a href="http://localhost:81/suiviAppui/app/views/admin/adminConfirm.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                <polygon points="12 2 2 7 12 12 22 7 12 2" />
                <polyline points="2 17 12 22 22 17" />
                <polyline points="2 12 12 17 22 12" />
              </svg>
              Voir la liste des demandes</a>
          </li>
     
          <li>
            <a href="http://localhost:81/suiviAppui/app/views/admin/sfdRegister.php">
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
            <a href="ajouterAppui.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-life-buoy">
              <circle cx="12" cy="12" r="10"></circle>
              <circle cx="12" cy="12" r="4"></circle>
              <line x1="4.93" y1="4.93" x2="9.17" y2="9.17"></line>
              <line x1="14.83" y1="14.83" x2="19.07" y2="19.07"></line>
              <line x1="14.83" y1="9.17" x2="19.07" y2="4.93"></line>
              <line x1="14.83" y1="9.17" x2="18.36" y2="5.64"></line>
              <line x1="4.93" y1="19.07" x2="9.17" y2="14.83"></line>
            </svg>
              Ajouter un appui</a>
          </li>
          <li>
            <a href="http://localhost:81/suiviAppui/app/views/admin/listeSFD.php">
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
            <a href="http://localhost:81/suiviAppui/app/views/admin/validerForm.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square">
              <polyline points="9 11 12 14 22 4"></polyline>
              <rect x="1" y="1" width="22" height="22" stroke="none" fill="none"></rect>
            </svg>
              Demandes validées</a>
          </li>
          <li>
            <a href="http://localhost:81/suiviAppui/app/views/admin/dashbord.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2">
              <line x1="18" y1="20" x2="18" y2="10" />
              <line x1="12" y1="20" x2="12" y2="4" />
              <line x1="6" y1="20" x2="6" y2="14" />
            </svg>


              Dashbord</a>
          </li>
          <li>
            <a href="../../auth/deconnexion.php">
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
            Ajouter un appui
          </h1>
          <!-- Insérez le bloc PHP pour afficher l'alerte ici -->
          <?php if (isset($_SESSION['success_message'])) : ?>
            <div class="alert alert-success" role="alert">
              <?php echo $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])) : ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $_SESSION['error_message']; ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

          <p>Veuillez renseignez tous les champs svp !</p>

        <div class="nice-form-group">
            <label for="appName">Nom de l'appui</label>
            <input type="text" id="appName" name="appName" placeholder="Nom de l'appui" required>
        </div>
        
        <div class="nice-form-group">
            <label for="typeActivite">Choisissez le nombre de type d'activité</label>
            <select id="typeActivite" name="typeActivite">
            <option value="1">Choisissez le nombre de type d'activité</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            </select>

        </div>
        
        <div id="textFields"></div>
        
        <button type="submit" name="submit">Enregistrer</button>
        </form>
       

<script>
// Écouteur pour détecter les changements dans la liste déroulante
document.getElementById('typeActivite').addEventListener('change', function() {
  const selectedValue = parseInt(this.value); // Convertir la valeur sélectionnée en nombre entier

  const textFieldsContainer = document.getElementById('textFields');
  textFieldsContainer.innerHTML = ''; // Effacer le contenu précédent

  // Générer le nombre de champs de texte basé sur la valeur sélectionnée
  for (let i = 1; i <= selectedValue; i++) {
    const textField = document.createElement('div');
    textField.classList.add('nice-form-group');

    const label = document.createElement('label');
    label.textContent = `Champ de texte ${i}`;

    const input = document.createElement('input');
    input.type = 'text';
    input.name = `textField${i}`;
    input.placeholder = `Champ de texte ${i}`;
    input.required = true; // Rendre le champ obligatoire

    textField.appendChild(label);
    textField.appendChild(input);
    textFieldsContainer.appendChild(textField);
  }
});

</script>

</body>
</html>