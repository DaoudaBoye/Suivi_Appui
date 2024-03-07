<?php
require_once('C:/xampp/htdocs/suiviAppui/app/auth/check_session.php');
require_once('C:/xampp/htdocs/suiviAppui/app/models/Database.php');
require_once('C:/xampp/htdocs/suiviAppui/app/models/actionModel.php');

$database = new Database();
$connexion = $database->getConnection();

if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}

$id_demande = $_GET['id_demande'];
$selSQL = "SELECT * FROM `demande_appui` WHERE id_demande = $id_demande";
$res = mysqli_query($connexion, $selSQL);
$r = mysqli_fetch_assoc($res);


// Traitement du formulaire de mise à jour après soumission
if (isset($_POST) && !empty($_POST)) {
    // Récupérez les données soumises via le formulaire
    $id_demande = $_POST['id_demande']; // Assurez-vous de récupérer l'ID de la demande à mettre à jour
    $beneficiaire = $_POST['beneficiaire'];
    $nomBeneficiaire = $_POST['nomBeneficiaire'];
    $type_appui = $_POST['type_appui'];
    $typeActivite = $_POST['typeActivite'];
    $Nature = $_POST['Nature'];
    $Theme = $_POST['Theme'];
    $NbreEluH = $_POST['NbreEluH'];
    $NbreEluF = $_POST['NbreEluF'];
    $NbrePersH = $_POST['NbrePersH'];
    $NbrePersF = $_POST['NbrePersF'];
    $date_demande = $_POST['date_demande'];
    $Cout_appui = $_POST['Cout_appui'];
    $Qt_equi_oct = $_POST['Qt_equi_oct'];
    $observation = $_POST['observation'];

    // Préparez la requête de mise à jour
    $UpdateDemande = "UPDATE demande_appui 
        SET Type_Beneficiaire = ?, 
            Nom_Beneficiaire = ?, 
            Agrement = ?, 
            id_structure = ?, 
            id_activite = ?, 
            Nature = ?, 
            Theme = ?, 
            Nombre_homme_elu = ?, 
            Nombre_femme_elu = ?, 
            Nombre_homme_personnel = ?, 
            Nombre_femme_personnel = ?, 
            Date_demande = ?, 
            Quantite = ?, 
            Cout_appui = ?, 
            Observation = ? 
        WHERE id_demande = ?";
    
    // Assurez-vous que $connexion est votre objet de connexion à la base de données

    $stmt = $connexion->prepare($UpdateDemande);
    $stmt->bind_param("ssiiisssiiisidssi", $beneficiaire, $nomBeneficiaire, $type_appui, $typeActivite, $Nature, $Theme, $NbreEluH, $NbreEluF, $NbrePersH, $NbrePersF, $date_demande, $Cout_appui, $Qt_equi_oct, $observation, $id_demande);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // La mise à jour a réussi
        header("Location: adminConfirm.php");
        exit;
    } else {
        // La mise à jour a échoué
        $erreur = "La mise à jour a échoué";
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
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
  /* Exemple de styles pour les boutons */
.btn-viser,
.btn-refuser {
  color: white; /* Couleur du texte */
  padding: 10px 20px; /* Espacement interne */
  border: none; /* Supprime le contour */
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s; /* Durée de transition pour les effets */
  cursor: pointer;
}

/* Styles pour les boutons en mode confirmation */
.btn-viser {
  background-color: #5cb85c; /* Couleur verte */
  color: white;
}

/* Styles pour les boutons en mode refus */
.btn-editer {
  background-color: #555; /* Couleur rouge */
  color: white;
}


.btn-editer:hover {
  background-color: #fff; /* Couleur de fond au survol */
  color: #000; /* Couleur du texte au survol */
  border-color: #000;
}
/* Effets au survol */
.btn-viser:hover{
  background-color: #45a049; /* Couleur de fond au survol */
  color: white; /* Couleur du texte au survol */
}

/* Styles pour les boutons désactivés */
.btn-disabled {
  opacity: 0.5; /* Réduit l'opacité pour indiquer que le bouton est désactivé */
  pointer-events: none; /* Désactive les événements pointer pour rendre le bouton non cliquable */
}


body {
        padding-top: 60px; /* Ajustez la valeur selon la hauteur de votre barre de navigation */
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
            <!-- <li class="nav-item">
              <a class="nav-link" href="#"><i class="fas fa-info-circle"></i> À propos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fas fa-envelope"></i> Contact</a>
            </li> -->
            <!-- <li class="nav-item">
              <a class="nav-link" href="#"><i class="fas fa-user"></i> Mon compte</a>
            </li> -->
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
            <a href="http://localhost:81/suiviAppui/app/views/suiviEvaluation/adminConfirm.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                <polygon points="12 2 2 7 12 12 22 7 12 2" />
                <polyline points="2 17 12 22 22 17" />
                <polyline points="2 12 12 17 22 12" />
              </svg>
              Voir la liste des demandes</a>
          </li>
     
          <li>
            <a href="http://localhost:81/suiviAppui/app/views/suiviEvaluation/sfdRegister.php">
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
              Enregistrer un Structure</a>
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
            <a href="http://localhost:81/suiviAppui/app/views/suiviEvaluation/listeSFD.php">
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
            <a href="http://localhost:81/suiviAppui/app/views/suiviEvaluation/validerForm.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square">
              <polyline points="9 11 12 14 22 4"></polyline>
              <rect x="1" y="1" width="22" height="22" stroke="none" fill="none"></rect>
            </svg>
              Demandes validées</a>
          </li>
          <li>
            <a href="http://localhost:81/suiviAppui/app/views/suiviEvaluation/dashbord.php">
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
        <input type="hidden" value="<?php echo $id_demande; ?>">
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
            

                            <!-- Boîte modale pour l'édition -->
                            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="editModalLabel">Édition de la demande</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <!-- Formulaire d'édition -->
                          <form id="editForm">
                    <div class="nice-form-group">
                      <label for="editIdDemande">Id demande</label>
                      <input type="text" id="editIdDemande" class="form-control" placeholder="Id demane" value="' + details.id_demande + '" readonly>
                    </div>
                    <div class="nice-form-group">
                      <label for="editTypeBeneficiaire">Type de bénéficiaire</label>
                      <input type="text" id="editTypeBeneficiaire" class="form-control" placeholder="Type de bénéficiaire" value="' + details.Type_Beneficiaire + '">
                    </div>
                    <!-- <div class="form-group">
                      <label for="editAgrement">Agrement</label>
                      <input type="text" id="editAgrement" class="form-control" placeholder="Agrement" value="' + details.Agrement + '">
                    </div> -->
                    <div class="nice-form-group">
                      <label for="editNomBeneficiaire">Nom du bénéficiaire</label>
                      <input type="text" id="editNomBeneficiaire" class="form-control" placeholder="Nom du bénéficiaire" value="' + details.Nom_Beneficiaire + '">
                    </div>
                    <div class="nice-form-group">
                      <label for="editTypeAppui">Type d\'appui</label>
                      <input type="text" id="editTypeAppui" class="form-control" placeholder="Type d\'appui" value="' + details.Nom_appui + '">
                    </div>
                    <div class="nice-form-group">
                      <label for="editTypeActivite">Type d\'activité</label>
                      <input type="text" id="editTypeActivite" class="form-control" placeholder="Type d\'activité" value="' + details.Nom_activite + '">
                    </div>
                    <div class="nice-form-group">
                      <label for="editNature">Nature</label>
                      <input type="text" id="editNature" class="form-control" placeholder="Nature" value="' + details.Nature + '">
                    </div>
                    <div class="nice-form-group">
                      <label for="editTheme">Theme</label>
                      <input type="text" id="editTheme" class="form-control" placeholder="Theme" value="' + details.Theme + '">
                  </div>
                  <div class="nice-form-group">
                      <label for="editDateDemande">Date de demande</label>
                      <input type="date" id="editDateDemande" class="form-control" placeholder="Date de demande" value="' + details.Date_demande + '">
                  </div>
                  <!-- <div class="form-group">
                      <label for="editRegion">Région du bénéficiaire</label>
                      <input type="text" id="editRegion" class="form-control" placeholder="Région du bénéficiaire" value="' + details.Region + '">
                  </div>
                  <div class="form-group">
                      <label for="editDepartement">Département du bénéficiaire</label>
                      <input type="text" id="editDepartement" class="form-control" placeholder="Département du bénéficiaire" value="' + details.Departement + '">
                  </div> -->
                  <div class="nice-form-group">
                      <label for="editQuantite">Quantité</label>
                      <input type="text" id="editQuantite" class="form-control" placeholder="Quantité" value="' + details.Quantite + '">
                  </div>
                  <div class="nice-form-group">
                      <label for="editCoutAppui">Cout d'appui</label>
                      <input type="text" id="editCoutAppui" class="form-control" placeholder="Cout d'appui" value="' + details.Cout_appui + '">
                  </div>
                  <div class="nice-form-group">
                      <label for="editNombreHommeElu">Nombre d'homme élu</label>
                      <input type="text" id="editNombreHommeElu" class="form-control" placeholder="Nombre d'homme élu" value="' + details.Nombre_homme_elu + '">
                  </div>
                  <div class="nice-form-group">
                      <label for="editNombreFemmeElu">Nombre de femme élu</label>
                      <input type="text" id="editNombreFemmeElu" class="form-control" placeholder="Nombre de femme élu" value="' + details.Nombre_femme_elu + '">
                  </div>
                  <div class="nice-form-group">
                      <label for="editNombreHommePersonnel">Nombre d'homme personnel</label>
                      <input type="text" id="editNombreHommePersonnel" class="form-control" placeholder="Nombre d'homme personnel" value="' + details.Nombre_homme_personnel + '">
                  </div>
                  <div class="nice-form-group">
                      <label for="editNombreFemmePersonnel">Nombre de femme personnel</label>
                      <input type="text" id="editNombreFemmePersonnel" class="form-control" placeholder="Nombre de femme personnel" value="' + details.Nombre_femme_personnel + '">
                  </div>
                  <div class="nice-form-group">
                      <label for="editObservation">Observation</label>
                      <textarea id="editObservation" class="form-control" placeholder="Observation">' + details.Observation + '</textarea>
                  </div>
                  </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Enregistrer les modifications</button>
              </div>
            </div>
          </div>
        </div>
         


         

        
        </form>
        <!-- <div id="alertMessage" style="display: <?php echo isset($_SESSION['success_message']) ? 'block' : 'none'; ?>"> -->
  

      </section>

      <footer>Made By ♥ FIMF</footer>
    </main>
  </div>
  <!-- partial -->

  

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
