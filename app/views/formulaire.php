<?php

session_start();

// Inclusion du fichier de connexion à la base de données
require_once('C:/xampp/htdocs/demande/app/models/Database.php');

// Création d'une instance de la classe Database pour obtenir la connexion à la base de données
$database = new Database();
$connexion = $database->getConnection();

// Vérification de la connexion
if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}

// Vérification si le formulaire a été soumis
if (isset($_POST['submit'])) {
  // Création d'une instance de la classe DemandeModel
  require_once('C:/xampp/htdocs/demande/app/models/DemandeModel.php'); // Remplacez Chemin_vers_votre_classe_DemandeModel par le chemin correct de votre classe DemandeModel
  $demandeModel = new DemandeModel();

  // Appel de la méthode insertDemande avec les données du formulaire
  $result = $demandeModel->insertDemande($_POST);

  // Affichage du résultat ou message de réussite ou d'erreur
  echo $result;
}

?>

<!DOCTYPE html>
<html lang="fr" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - nice-forms.css</title>
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
  <link rel="stylesheet" href="../public/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../public/script.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    body {
        padding-top: 60px; /* Ajustez la valeur selon la hauteur de votre barre de navigation */
    }
/* 
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
<script>
      $(function(){
          $("#navigation").load("navbar.php");
      });
</script>
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
            <div class="profile">
            <span>Bienvenue, <?php echo $_SESSION['name']; ?>!</span>
            <img src="user.png" alt="Icône de profil">
        </div>
          </ul>
        </div>
    </nav>
  <div class="demo-page my-demo">
    
    <div class="demo-page-navigation">
        <!-- Inclure la barre de navigation à partir du fichier séparé -->
    <div id="navigation">

  </div>
    </div>
    <main class="demo-page-content">

      <section>
        <form id="myForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validateForm()">
          <div class="href-target" id="input-types"></div>
          <h1>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-justify">
              <line x1="21" y1="10" x2="3" y2="10" />
              <line x1="21" y1="6" x2="3" y2="6" />
              <line x1="21" y1="14" x2="3" y2="14" />
              <line x1="21" y1="18" x2="3" y2="18" />
            </svg>
            Enregistrer votre demande
          </h1>
          <p>Veuillez renseignez tous les champs svp !</p>
          <div class="nice-form-group">
            <label for="beneficiaire">Bénéficiaire</label>
            <select id="beneficiaire" name="beneficiaire" onchange="toggleFields()" required>
              <option value="">Veuillez sélectionner un bénéficiaire</option>
              <option value="SFD">SFD</option>
              <option value="Autre">Autre</option>
            </select>
          </div>
      
<!--       
          <div id="sfdField" class="nice-form-group" style="display: none;">
          <label for="sfdName">Nom du SFD</label>
          <input class="form-control" list="datalistOptions" id="sfdName" placeholder="Type to search...">
            <datalist id="datalistOptions">
              <select id="sfdName" name="sfdName" required>
            
              </select>
            </datalist>
          </div>
           -->


          <div id="sfdField" class="nice-form-group" style="display: none;">
            <label for="sfdName">Nom du SFD</label>
            <select id="sfdName" name="sfdName" required>
            <option value="">Please select a value</option>
              <?php
                  // Connexion à la base de données
                  //$connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

                  // Vérification de la connexion
                  if ($connexion->connect_error) {
                      die("Échec de la connexion : " . $connexion->connect_error);
                  }

                  // Récupération des des sfd  depuis la base de données

                  $requeteSfd = "SELECT SigleSFD FROM liste_sfd"; // Remplacez 'table_regions' par le nom réel de votre table
                  $resultatsfd = $connexion->query($requeteSfd);

                  // Génération des options de la liste déroulante
                  if ($resultatsfd->num_rows > 0) {
                      while ($row = $resultatsfd->fetch_assoc()) {
                          echo "<option value='" . $row['SigleSFD'] . "'>" . $row['SigleSFD'] . "</option>";                      }
                    
                  }
              ?>
            </select>
          </div>

          

          <div id="autreField" class="nice-form-group" style="display: none;">
            <label for="autreInput">Nom de l'autre bénéficiaire</label>
            <input type="text" id="nomBeneficiaire" name="nomBeneficiaire">
          </div>

          <div class="nice-form-group">
            <label for="region">Région</label>
            <select id="region" name="region" required>
              <option value="">Please select a value</option>
              <?php
            
                  // Vérification de la connexion
                  if ($connexion->connect_error) {
                      die("Échec de la connexion : " . $connexion->connect_error);
                  }

                  // Récupération des régions depuis la base de données
                  $requeteRegions = "SELECT nom_region FROM region"; // Remplacez 'table_regions' par le nom réel de votre table
                  $resultatRegions = $connexion->query($requeteRegions);

                  // Génération des options de la liste déroulante
                  if ($resultatRegions->num_rows > 0) {
                      while ($row = $resultatRegions->fetch_assoc()) {
                          echo "<option value='" . $row['nom_region'] . "'>" . $row['nom_region'] . "</option>";
                      }
                  }
              ?>
            </select>
          </div>
        
          <div class="nice-form-group">
              <label for="departement">Département</label>
              <select id="departement" name="departement" required>
                  <option value="">Veuillez sélectionner une région d'abord</option>
              </select>
          </div>


          <div class="nice-form-group" >
            <label for="type_appui">Type d'appui</label>
            <select id="type_appui" name="type_appui" required>
              <option value="">Please select a value</option>
              <?php

                  // Récupération des régions depuis la base de données
                  $requeteRegions = "SELECT nom_appui FROM type_appui"; // Remplacez 'table_regions' par le nom réel de votre table
                  $resultatRegions = $connexion->query($requeteRegions);

                  // Génération des options de la liste déroulante
                  if ($resultatRegions->num_rows > 0) {
                      while ($row = $resultatRegions->fetch_assoc()) {
                          echo "<option value='" . $row['nom_appui'] . "'>" . $row['nom_appui'] . "</option>";
                      }
                  }
              ?>
            </select>
          </div>

          <div class="nice-form-group" id="typesActivitesField" style="display: none;">
              <label for="typeActivite">Type d'activité</label>
              <select id="typeActivite" name="typeActivite" required>
              <!--<option value="">Sélectionner le type d'activité</option>-->
              </select>
          </div>


          <div class="nice-form-group" style="display: none;">
            <label>Intitulé</label>
            <textarea rows="5" id="intitule" name="intitule" placeholder="Your message"></textarea>
          </div>


          <div class="nice-form-group">
            <label>Date</label>
            <input type="date" name="date_demande" value="2018-07-22" />
          </div>


          <div class="nice-form-group">
            <label>Quantité d'équipements octroyés</label>
            <input type="number" name="Qt_equi_oct" placeholder="1234"/>
          </div>

          <div class="nice-form-group">
            <label>Coût appuis (F CFA)</label>
            <input type="number" name="Cout_appui" placeholder="F CFA" required/>
          </div>
        
          <div class="nice-form-group">
            <label>Observation</label>
            <textarea rows="5" id="observation" name="observation" placeholder="Your message"></textarea>
          </div>
        
          <button type="submit" name="submit">Submit</button>
          <button type="button" class="form-btn" onclick="resetForm()">Annuler</button>
        
        </form>
      </section>

      <footer>Made By ♥ FIMF</footer>
    </main>
  </div>
  <!-- partial -->

  <script>
  function resetForm() {
    document.getElementById("myForm").reset();
  }
</script>

<script>
  const themeToggle = document.getElementById('themeToggle');

  themeToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark-theme');
      if (document.body.classList.contains('dark-theme')) {
          themeToggle.textContent = 'Mode clair';
      } else {
          themeToggle.textContent = 'Mode sombre';
      }
  });
</script>

</body>
</html>
