<?php
require_once('C:/xampp/htdocs/suiviAppui/app/auth/check_session.php');
require_once('C:/xampp/htdocs/suiviAppui/app/models/Database.php');
require_once('C:/xampp/htdocs/suiviAppui/app/models/actionModel.php');

// Création d'une instance de la classe Database pour obtenir la connexion à la base de données
$database = new Database();
$connexion = $database->getConnection();

// Vérification de la connexion
if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}

// Vérifier si l'identifiant de la demande est valide
if (!empty($_GET['id_demande'])) {
    // Récupérer l'identifiant de la demande depuis l'URL
    $id_demande = htmlspecialchars($_GET['id_demande']);

    // Préparez la requête SQL pour récupérer les informations de la demande et les données liées
    $sql = "SELECT 
                demande_appui.id_demande,
                demande_appui.Type_Beneficiaire,
                demande_appui.Nom_Beneficiaire,
                demande_appui.Nature,
                demande_appui.Theme,
                demande_appui.Date_demande,
                type_appui.Nom_appui AS TypeAppui,
                type_activite.Nom_activite AS TypeActivite,
                demande_appui.Quantite,
                demande_appui.Cout_appui,
                demande_appui.Nombre_homme_elu,
                demande_appui.Nombre_femme_elu,
                demande_appui.Nombre_homme_personnel,
                demande_appui.Nombre_femme_personnel,
                demande_appui.Observation
            FROM 
                demande_appui
            LEFT JOIN 
                type_activite ON demande_appui.id_activite = type_activite.id_activite
            LEFT JOIN 
                type_appui ON type_activite.id_appui = type_appui.id_appui
            WHERE 
                demande_appui.id_demande = ?";

    // Préparez et exécutez la requête
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $id_demande);
    $stmt->execute();

    // Récupérez le résultat de la requête
    $result = $stmt->get_result();

    // Vérifiez s'il y a des lignes retournées
    if ($result->num_rows > 0) {
        // Récupérez les données de la demande
        $row = $result->fetch_assoc();

      // Pré-remplissez les champs du formulaire avec les informations de la demande
        $id_demande = $row['id_demande'];
        $TypeBeneficiaire = $row['Type_Beneficiaire'];
        $NomBeneficiaire = $row['Nom_Beneficiaire'];
        $TypeAppui = $row['TypeAppui'];
        $TypeActivite = $row['TypeActivite'];

        $nature = $row['Nature'];
        $theme = $row['Theme'];
        $date_demande = $row['Date_demande'];
        $quantite = $row['Quantite'];
        $cout_appui = $row['Cout_appui'];
        $NbreHElu = $row['Nombre_homme_elu']; // Correction ici
        $NbreFElu = $row['Nombre_femme_elu']; // Correction ici
        $NbreHPers = $row['Nombre_homme_personnel']; // Correction ici
        $NbreFPers = $row['Nombre_femme_personnel']; // Correction ici
        $Observation = $row['Observation']; // Correction ici

        // Fermez la requête et la connexion à la base de données
        $stmt->close();
        $connexion->close();
    } else {
        echo "Aucune demande trouvée avec cet identifiant.";
    }
} else {
    echo "Identifiant de demande non spécifié.";
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
            <!-- <li class="nav-item active">
              <a class="nav-link" href="http://localhost:81/suiviAppui/app/views/user/formulaire.php"><i class="fas fa-home"></i> Accueil <span class="sr-only">(current)</span></a>
            </li> -->
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
    <form id="editForm">
    <div class="nice-form-group">
    <label for="editIdDemande">Id demande</label>
    <input type="text" id="editIdDemande" class="form-control" placeholder="Id demande" value="<?php echo $id_demande ?? ''; ?>" readonly>
    </div>
    <div class="nice-form-group">
        <label for="editTypeBeneficiaire">Type de bénéficiaire</label>
        <input type="text" id="editTypeBeneficiaire" class="form-control" placeholder="Type de bénéficiaire" value="<?php echo $TypeBeneficiaire ?? ''; ?>" readonly>
    </div>
    <!-- <div class="form-group">
        <label for="editAgrement">Agrement</label>
        <input type="text" id="editAgrement" class="form-control" placeholder="Agrement" value="' + details.Agrement + '">
    </div> -->
    <div class="nice-form-group">
        <label for="editNomBeneficiaire">Nom du bénéficiaire</label>
        <input type="text" id="editNomBeneficiaire" class="form-control" placeholder="Nom du bénéficiaire" value="<?php echo $NomBeneficiaire ?? ''; ?>" readonly>
    </div>
    <div class="nice-form-group">
        <label for="editTypeAppui">Type d'appui</label>
        <input type="text" id="editTypeAppui" class="form-control" placeholder="Type d'appui" value="<?php echo $TypeAppui ?? ''; ?>" readonly>
    </div>

                    <div class="nice-form-group">
                      <label for="editTypeActivite">Type d\'activité</label>
                      <input type="text" id="editTypeActivite" class="form-control" placeholder="Type d\'activité" value="<?php echo $TypeActivite ?? ''; ?>" readonly>
                    </div>
                    <div class="nice-form-group">
                      <label for="editNature">Nature</label>
                      <input type="text" id="editNature" class="form-control" placeholder="Nature" value="<?php echo $nature ?? ''; ?>">
                    </div>
                    <div class="nice-form-group">
                      <label for="editTheme">Theme</label>
                      <input type="text" id="editTheme" class="form-control" placeholder="Theme" value="<?php echo $theme ?? ''; ?>">
                  </div>
                  <div class="nice-form-group">
                      <label for="editDateDemande">Date de demande</label>
                      <input type="date" id="editDateDemande" class="form-control" placeholder="Date de demande" value="<?php echo $date_demande ?? ''; ?>">
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
                      <input type="text" id="editQuantite" class="form-control" placeholder="Quantité" value="<?php echo $quantite ?? ''; ?>">
                  </div>
                  <div class="nice-form-group">
                      <label for="editCoutAppui">Cout d'appui</label>
                      <input type="text" id="editCoutAppui" class="form-control" placeholder="Cout d'appui" value="<?php echo $cout_appui ?? ''; ?>">
                  </div>
                  <div class="nice-form-group">
                      <label for="editNombreHommeElu">Nombre d'homme élu</label>
                      <input type="text" id="editNombreHommeElu" class="form-control" placeholder="Nombre d'homme élu" value="<?php echo $NbreHElu ?? ''; ?>">
                  </div>
                  <div class="nice-form-group">
                      <label for="editNombreFemmeElu">Nombre de femme élu</label>
                      <input type="text" id="editNombreFemmeElu" class="form-control" placeholder="Nombre de femme élu" value="<?php echo $NbreFElu ?? ''; ?>">
                  </div>
                  <div class="nice-form-group">
                      <label for="editNombreHommePersonnel">Nombre d'homme personnel</label>
                      <input type="text" id="editNombreHommePersonnel" class="form-control" placeholder="Nombre d'homme personnel" value="<?php echo $NbreHPers ?? ''; ?>">
                  </div>
                  <div class="nice-form-group">
                      <label for="editNombreFemmePersonnel">Nombre de femme personnel</label>
                      <input type="text" id="editNombreFemmePersonnel" class="form-control" placeholder="Nombre de femme personnel" value="<?php echo $NbreFPers ?? ''; ?>">
                  </div>
                  
                  <div class="nice-form-group">
                      <label for="editObservation">Observation</label>
                      <textarea id="editObservation" class="form-control" placeholder="Observation"><?php echo $Observation ?? ''; ?></textarea>
                  </div>
                  <!-- Boutons -->
                  <div class="nice-form-group">
                      <button type="button" class="btn btn-success" style="background-color: green;" id="btnUpdate">Mettre à jour</button>
                      <button type="button" class="btn btn-secondary" id="btnCancel">Annuler</button>
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

   



    document.getElementById('btnUpdate').addEventListener('click', function() {
    // Collecte des données du formulaire
    var id_demande = document.getElementById('editIdDemande').value;
    var nature = document.getElementById('editNature').value;
    var theme = document.getElementById('editTheme').value;
    var date_demande = document.getElementById('editDateDemande').value;
    var quantite = document.getElementById('editQuantite').value;
    var cout_appui = document.getElementById('editCoutAppui').value;
    var NbreHElu = document.getElementById('editNombreHommeElu').value;
    var NbreFElu = document.getElementById('editNombreFemmeElu').value;
    var NbreHPers = document.getElementById('editNombreHommePersonnel').value;
    var NbreFPers = document.getElementById('editNombreFemmePersonnel').value;
    var observation = document.getElementById('editObservation').value;

    // Création d'un objet FormData pour envoyer les données au serveur
    var formData = new FormData();
    formData.append('id_demande', id_demande);
    formData.append('nature', nature);
    formData.append('theme', theme);
    formData.append('date_demande', date_demande);
    formData.append('quantite', quantite);
    formData.append('cout_appui', cout_appui);
    formData.append('NbreHElu', NbreHElu);
    formData.append('NbreFElu', NbreFElu);
    formData.append('NbreHPers', NbreHPers);
    formData.append('NbreFPers', NbreFPers);
    formData.append('observation', observation);

    // Envoi de la requête AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Succès : mettez en œuvre toute logique supplémentaire nécessaire
                console.log(xhr.responseText);
                alert("Données mises à jour avec succès !");
                // Vous pouvez rediriger l'utilisateur vers une autre page ou effectuer d'autres actions ici
                window.location.href = "../../views/suiviEvaluation/adminConfirm.php";

            } else {
                // Gérer les erreurs éventuelles
                console.error('Une erreur s\'est produite : ' + xhr.status);
                alert("Erreur lors de la mise à jour des données.");
            }
        }
    };
    xhr.open('POST', '../../models/update_row.php', true);
    xhr.send(formData);
});

document.getElementById('btnCancel').addEventListener('click', function() {
    // Redirection vers la page d'administration
    window.location.href = "../../views/suiviEvaluation/adminConfirm.php";
});


</script>
</body>
</html>
