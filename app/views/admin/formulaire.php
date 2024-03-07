<?php
require_once('C:/xampp/htdocs/suiviAppui/app/auth/check_session.php');
require_once('C:/xampp/htdocs/suiviAppui/app/models/Database.php');
require_once('C:/xampp/htdocs/suiviAppui/app/models/DemandeModel.php');

$database = new Database();
$connexion = $database->getConnection();

if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}

if (isset($_POST['submit'])) {
    $demandeModel = new DemandeModel();

    // Appel de la méthode insertDemande avec les données du formulaire
    $result = $demandeModel->insertDemande($_POST);

    // Gestion des messages en fonction du résultat de l'insertion
    if ($result === "success") {
        $_SESSION['success_message'] = "La demande a été insérée avec succès!";
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
  <!-- <script src="../../public/script.js"></script> -->
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


   .profile {
    position: relative;
    display: inline-block;
    cursor: pointer;
}

.options {
    display: none;
    position: absolute;
    top: calc(100% + 5px); /* Positionne les options juste en dessous du menu */
    left: 0;
    background-color: #f9f9f9;
    min-width: 120px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.options a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.options a:hover {
    background-color: #f1f1f1;
}
.profile {
    position: relative;
    display: inline-block;
    cursor: pointer;
}

.options {
    display: none;
    position: absolute;
    top: calc(100% + 5px); /* Positionne les options juste en dessous du menu */
    left: -40px; /* Déplacement vers la gauche de 50px (ajustez selon vos besoins) */
    background-color: #f9f9f9;
    min-width: 120px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.options a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.options a:hover {
    background-color: #f1f1f1;
}

</style>

</head>
<body>
  
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
              <a class="nav-link" href="http://localhost:81/suiviAppui/app/views/admin/formulaire.php"><i class="fas fa-home"></i> Accueil <span class="sr-only">(current)</span></a>
            </li>
            
            <div class="profile" style="display: flex; align-items: center;">
              <img src="../user.png" alt="Icône de profil" onclick="toggleOptions()">
              <?php if (isset($_SESSION['name'])) : ?>
                  <span><?php echo $_SESSION['name']; ?></span>
              <?php else : ?>
                  <!-- <span>Utilisateur</span> -->
              <?php endif; ?>
              <div class="options" id="profileOptions">
                  <?php if (isset($_SESSION['name'])) : ?>
                      <a href="../profil.php">Profil</a>
                      <a href="../deconnexion.php">Déconnexion</a>
                  <?php else : ?>
                      <a href="connexion.php">Connexion</a>
                      <a href="inscription.php">Inscription</a>
                  <?php endif; ?>
              </div>
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
            <label for="beneficiaire">Bénéficiaire</label>
            <select id="beneficiaire" name="beneficiaire" onchange="toggleFields()">
              <option value="">Veuillez sélectionner un bénéficiaire</option>
              <option value="SFD">SFD</option>
              <option value="Autre">Autre</option>
            </select>
          </div>


          <div id="sfdField" class="nice-form-group" style="display: none;">
            <label for="sfdName">Nom du SFD</label>
            <select id="sfdName" name="sfdName">
            <option value="">Please select a value</option>
              <?php
                 
                  // Vérification de la connexion
                  if ($connexion->connect_error) {
                      die("Échec de la connexion : " . $connexion->connect_error);
                  }

                  // Récupération des des sfd  depuis la base de données

                  $requeteSfd = "SELECT SigleSFD FROM liste_sfd ORDER BY SUBSTRING(SigleSFD, 5)"; // Remplacez 'table_regions' par le nom réel de votre table
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
            <label for="autreBeneficiaire">Nom de l'autre bénéficiaire</label>
            <select id="autreBeneficiaire" name="autreBeneficiaire">
            <option value="">Please select a value</option>
              <?php
                 
                  // Vérification de la connexion
                  if ($connexion->connect_error) {
                      die("Échec de la connexion : " . $connexion->connect_error);
                  }

                  // Récupération des des sfd  depuis la base de données

                  $requeteSfd = "SELECT Nom_structure FROM autre_structure ORDER BY SUBSTRING(Nom_structure, 1)"; // Remplacez 'table_regions' par le nom réel de votre table
                  $resultatsfd = $connexion->query($requeteSfd);

                  // Génération des options de la liste déroulante
                  if ($resultatsfd->num_rows > 0) {
                      while ($row = $resultatsfd->fetch_assoc()) {
                          echo "<option value='" . $row['Nom_structure'] . "'>" . $row['Nom_structure'] . "</option>";                      }
                    
                  }
              ?>
            </select>
          </div>

          <div class="nice-form-group">
            <label for="type_appui">Type d'appui</label>
            <select id="type_appui" name="type_appui">
                <option value="">Please select a value</option>
                <?php
                    // Récupération des types d'appui depuis la base de données
                    $requeteAppui = "SELECT  nom_appui FROM type_appui"; 
                    $resultatAppui = $connexion->query($requeteAppui);

                    // Génération des options de la liste déroulante
                    if ($resultatAppui->num_rows > 0) {
                        while ($row = $resultatAppui->fetch_assoc()) {
                            echo "<option value='" . $row['nom_appui'] . "'>" . $row['nom_appui'] . "</option>";
                        }
                    }
                ?>
            </select>
          </div>

          <div class="nice-form-group" id="typesActivitesField" style="display: none;">
              <label for="typeActivite">Type d'activité</label>
              <select id="typeActivite" name="typeActivite">
                  <!-- Options du "Type d'activité" chargées dynamiquement -->
              </select>
          </div>

         


          <div id="NatureField" class="nice-form-group" style="display: none;">
              <label for="Nature">Nature</label>
              <input type="text" id="Nature" name="Nature">
          </div>
          <div id="ThemeField" class="nice-form-group" style="display: none;">
              <label for="Nature">Thème</label>
              <input type="text" id="Theme" name="Theme">
          </div>

          <div id="NbreHEluField" class="nice-form-group" style="display: none;">
            <label>Nombre d'homme élu</label>
            <input type="number" name="NbreEluH" placeholder="1234"/>
          </div>
          <div id="NbreFEluField" class="nice-form-group" style="display: none;">
            <label>Nombre de Femme élu</label>
            <input type="number" name="NbreEluF" placeholder="1234"/>
          </div>

          <div id="NbreHPersField" class="nice-form-group" style="display: none;">
            <label>Nombre d'homme personnel</label>
            <input type="number" name="NbrePersH" placeholder="1234"/>
          </div>
          <div id="NbreFPersField" class="nice-form-group" style="display: none;">
            <label>Nombre de Femme personnel</label>
            <input type="number" name="NbrePersF" placeholder="1234"/>
          </div>

          <div class="nice-form-group">
              <label>Date</label>
              <input type="date" name="date_demande" value="<?php echo date('Y-m-d'); ?>" />
          </div>

          <div id="quantite" class="nice-form-group">
              <label class="quantite-label">Quantité (nombre)</label>
              <input type="number" name="Qt_equi_oct" placeholder="1234"/>
          </div>

          <div class="nice-form-group">
            <label>Coût appuis (F CFA)</label>
            <input type="number" name="Cout_appui" placeholder="F CFA"/>
          </div>
        
          <div class="nice-form-group">
            <label>Observation</label>
            <textarea rows="5" id="observation" name="observation" placeholder="Your message"></textarea>
          </div>
        
          <button type="submit" name="submit">Submit</button>
          <button type="button" class="form-btn" onclick="resetForm()">Annuler</button>
        
        </form>
        <!-- <div id="alertMessage" style="display: <?php echo isset($_SESSION['success_message']) ? 'block' : 'none'; ?>"> -->
  

      </section>

      <footer>Made By ♥ FIMF</footer>
    </main>
  </div>
  <!-- partial -->

  <script>
    
    // Fonction pour afficher un élément HTML
    function showElement(element) {
        element.style.display = 'block';
    }

    // Fonction pour masquer un élément HTML
    function hideElement(element) {
        element.style.display = 'none';
    }

    // Gestionnaire d'événement pour le changement de type d'appui
    document.getElementById('type_appui').addEventListener('change', function() {
        var selectedOption = this.value;
        var natureField = document.getElementById('NatureField');
        // var quantiteField = document.getElementById('quantite');
        // var quantiteLabel = document.querySelector('.quantite-label');
        var Theme = document.getElementById('ThemeField');
        var nbreHFieldElu = document.getElementById('NbreHEluField');
        var nbreFFieldElu = document.getElementById('NbreFEluField');
        var nbreHFieldPers = document.getElementById('NbreHPersField');
        var nbreFFieldPers = document.getElementById('NbreFPersField');
        
        var showNatureFor = ["Equipements", "Dotation SIG", "Digitalisation"];

        if (showNatureFor.includes(selectedOption)) {
            showElement(natureField);
        } else {
            hideElement(natureField);
        }

       
        
    });

    // Gestionnaire d'événement pour le changement de type d'activité
    document.getElementById('typeActivite').addEventListener('change', function() {
        var selectedOption = this.value;
        var Theme = document.getElementById('ThemeField');
        var nbreHFieldElu = document.getElementById('NbreHEluField');
        var nbreFFieldElu = document.getElementById('NbreFEluField');
        var nbreHFieldPers = document.getElementById('NbreHPersField');
        var nbreFFieldPers = document.getElementById('NbreFPersField');

        hideElement(Theme);
        hideElement(nbreHFieldElu);
        hideElement(nbreFFieldElu);
        hideElement(nbreHFieldPers);
        hideElement(nbreFFieldPers);

        switch (selectedOption) {
            case "Formation pour les élus des SFD":
                showElement(Theme);
                showElement(nbreHFieldElu);
                showElement(nbreFFieldElu);
                break;
            case "Formation pour le personnel technique des SFD":
                showElement(Theme);
                showElement(nbreHFieldPers);
                showElement(nbreFFieldPers);
                break;
            case "Formation élu et personnels technique des SFD":
                showElement(Theme);
                showElement(nbreHFieldElu);
                showElement(nbreFFieldElu);
                showElement(nbreHFieldPers);
                showElement(nbreFFieldPers);
                break;
            default:
                break;
        }
    });



</script>


  <script>
      document.getElementById('type_appui').addEventListener('change', function() {
        var selectedTypeAppui = this.value;
        var typeActiviteSelect = document.getElementById('typeActivite');

        // Effectuer une requête AJAX pour obtenir les types d'activité associés au type d'appui sélectionné
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Mettre à jour la liste déroulante des types d'activité
                    typeActiviteSelect.innerHTML = xhr.responseText;
                    // Afficher le champ "Type d'activité" une fois les données chargées
                    document.getElementById('typesActivitesField').style.display = 'block';
                } else {
                    // Gérer les erreurs éventuelles
                    console.error('Une erreur s\'est produite : ' + xhr.status);
                }
            }
        };

        // Envoyer la requête au serveur pour obtenir les types d'activité du type d'appui sélectionné
        xhr.open('GET', '../../controllers/get_types_activite.php?type_appui=' + encodeURIComponent(selectedTypeAppui), true);
        xhr.send();
    });

  </script>

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



  <script>
  // Affiche/masque les champs en fonction de la valeur sélectionnée pour le bénéficiaire

    function toggleFields() {
        var beneficiaireValue = document.getElementById("beneficiaire").value;
        var sfdField = document.getElementById("sfdField");
        var autreField = document.getElementById("autreField");

        if (beneficiaireValue === "SFD") {
            sfdField.style.display = "block";
            autreField.style.display = "none";
        } else if (beneficiaireValue === "Autre") {
            sfdField.style.display = "none";
            autreField.style.display = "block";
        } else {
            sfdField.style.display = "none";
            autreField.style.display = "none";
        }
    }


  </script>

  <script>
    function toggleOptions() {
        var options = document.getElementById("profileOptions");
        if (options.style.display === "block") {
            options.style.display = "none";
        } else {
            options.style.display = "block";
        }
    }

    // Fermer les options si on clique en dehors de la zone du profil
    window.addEventListener('click', function(event) {
        var options = document.getElementById("profileOptions");
        var profile = document.querySelector('.profile');

        if (event.target !== profile && !profile.contains(event.target)) {
            options.style.display = 'none';
        }
    });


</script>
</body>
</html>
