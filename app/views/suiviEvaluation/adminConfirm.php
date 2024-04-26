<?php
// session_start();
require_once('C:/xampp/htdocs/suiviAppui/app/auth/check_session.php');
// Inclusion du fichier de connexion à la base de données
require_once('C:/xampp/htdocs/suiviAppui/app/models/Database.php');
require_once('C:/xampp/htdocs/suiviAppui/app/models/actionModel.php'); // Remplacez Chemin_vers_votre_classe_DemandeModel par le chemin correct de votre classe DemandeModel

// Création d'une instance de la classe Database pour obtenir la connexion à la base de données
$database = new Database();
$connexion = $database->getConnection();

// Vérification de la connexion
if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}

// Vérifiez si l'ID est passé via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  $id_demande = $_POST['id'];


  $actionModel = new actionModel($connexion); // Passer la connexion à DemandeModel
  $result = $actionModel->viserDemande($id_demande);

  echo json_encode($result);
}


// Calculer le total des nouvelles demandes
$sql_total = "SELECT COUNT(*) AS total_demandes FROM demande_appui WHERE Viser = 0";
$result_total = $connexion->query($sql_total);
$total_demandes = 0;

if ($result_total->num_rows > 0) {
    $row_total = $result_total->fetch_assoc();
    $total_demandes = $row_total['total_demandes'];
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
.btn-refuser, .btn {
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

.btn {
  background-color: #0f6b85; /* Couleur verte */
  color: white;
}

.btn:hover{
  background-color: #0db9e3;
  color:#000;
}
/* Styles pour les boutons en mode refus */
.btn-editer {
  background-color: #555; /* Couleur rouge */
  color: white;
}


.btn-editer:hover {
  background-color: #000; /* Couleur de fond au survol */
  color: #fff; /* Couleur du texte au survol */
  border-color: #000;
}
/* Effets au survol */
.btn-viser:hover{
  background-color: #acfab7; /* Couleur de fond au survol */
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


/* Style pour le popup des détails de la demande */
.modal-content {
    background-color: #fff;
    border-radius: 5px;
}

.modal-header {
    background-color: #007bff;
    color: #fff;
    border-bottom: 1px solid #ddd;
}

.modal-title {
    font-weight: bold;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    border-top: 1px solid #ddd;
    padding: 10px 20px;
}

.modal-footer .btn {
    margin-right: 10px;
}


       /* Style pour le total des nouvelles demandes */
       .total-demandes {
    text-align: center;
    font-size: 24px;
    color: #333; /* Couleur du texte */
    margin-bottom: 20px; /* Marge en bas pour l'espacement */
    padding: 10px; /* Espacement intérieur */
    background-color: #f0f0f0; /* Couleur de fond */
    border-radius: 5px; /* Coins arrondis */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Ombre légère */
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
              <a class="nav-link" href="http://localhost:81/suiviAppui/app/views//formulaire.php"><i class="fas fa-home"></i> Accueil <span class="sr-only">(current)</span></a>
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
    <main class="demo-page-content col-12 centered-form">
      <section>
      <h1 class="card-title" style="text-align: center;">Liste des nouvelles demandes</h1>
      <div class="row mb-3">
      <div class="col-md-9 mx-auto">
        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher une demande">
    </div>
</div>

<div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <!-- Ajoutez le total ici -->
                  <h2 class="total-demandes">Total des Nouvelles Demandes : <?php echo $total_demandes; ?></h2>
               
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">nomBeneficiaire</th>
                          <th scope="col">Type_appui</th>
                          <th scope="col">Type_activite</th>
                          <th scope="col">date_demande</th>
                          <th scope="col">Departement_beneficiaire</th>
                          <th scope="col">Détails</th>
                          <th scope="col">Action1</th>
                          <th scope="col">Action2</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $sql = "SELECT 
                          demande_appui.id_demande,
                          demande_appui.Type_Beneficiaire,
                          demande_appui.Nom_Beneficiaire,
                          demande_appui.Agrement,
                          demande_appui.Nature,
                          demande_appui.Theme,
                          demande_appui.Date_demande,
                          region.nom_region AS Region,
                          departement.nom_dept AS Departement,
                          demande_appui.Quantite,
                          demande_appui.Cout_appui,
                          demande_appui.Observation,
                          demande_appui.id_demande,
                          Type_appui.Nom_appui,
                          Type_activite.Nom_activite,
                          demande_appui.Nombre_homme_elu,
                          demande_appui.Nombre_femme_elu,
                          demande_appui.Nombre_homme_personnel,
                          demande_appui.Nombre_femme_personnel
                      FROM 
                          demande_appui
                      LEFT JOIN 
                          liste_sfd ON demande_appui.Agrement = liste_sfd.Agrement
                      LEFT JOIN 
                          departement ON liste_sfd.id_dept = departement.id_dept
                      LEFT JOIN 
                          region ON departement.id_region = region.id_region
                      LEFT JOIN 
                          Type_activite ON demande_appui.id_activite = Type_activite.id_activite
                      LEFT JOIN 
                          Type_appui ON Type_activite.id_appui = Type_appui.id_appui
                          WHERE 
                          Viser = 0
                      ORDER BY 
                          demande_appui.Date_demande DESC;";
                              
                          $result = $connexion->query($sql);

                          if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["Nom_Beneficiaire"] . "</td>";
                                echo "<td>" . $row["Nom_appui"] . "</td>";
                                echo "<td>" . $row["Nom_activite"] . "</td>";
                                echo "<td>" . $row["Date_demande"] . "</td>";
                                echo "<td>" . $row["Departement"] . "</td>";
                             // Ajoutez cette condition autour de l'affichage des boutons dans votre boucle while
                                echo "<td><button id='btn-viser' class='btn btn-afficher' data-details='" . htmlspecialchars(json_encode($row)) . "'>Détail</button></td>";

                              if ($_SESSION['username'] === 'mamadou.sow@fimf.sn') {
                                echo "<td><button id='btn-viser-" . $row["id_demande"] . "' class='btn-viser' onclick='confirmViser(" . $row["id_demande"] . ")'>Viser</button></td>";
                                echo "<td><button type='button' class='btn btn-warning btn-editer' data-id='" . $row["id_demande"] . "'>Éditer</button></td>";
                              }
                          
                                echo "</tr>";
                               
                                }
                            } else {
                                echo "<tr><td colspan='13'>Aucun résultat</td></tr>";
                            }
                        
                          $connexion->close();
                        ?>

                      </tbody>
                  

                    <!-- Section pour afficher les détails de la demande -->
                  <div class="modal fade" id="demandeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="demandeDetailsModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="demandeDetailsModalLabel">Détails de la demande</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" id="demandeDetailsBody">
                          <!-- Les détails de la demande seront affichés ici -->
                          <div class="container">
                            <!-- Contenu des détails de la demande -->
                          </div>
                        </div>
                        <div class="modal-footer">
                          <!-- Boutons "Viser" et "Éditer" -->
           
                        </div>
                      </div>
                    </div>
                  </div>
     
                    </table>
                    <!-- Ajoute un élément div pour les boutons de pagination -->

                  </div>
                  <div class="text-center mb-3">
                        <button class="btn btn-primary mr-2" id="prevBtn">
                            <i class="fas fa-chevron-left"></i> Précédent
                        </button>
                        <button class="btn btn-primary" id="nextBtn">
                            Suivant <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                </div>
              </div>
            </div>
            <button id="downloadCSV">
              <i class="fas fa-download"></i> Télécharger la liste des SFD (CSV)
              </button>                          
            </div>
          </div>
        </div>
      </section>
      <footer>Made By ♥ FIMF</footer>
    </main>
  </div>

  <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

    <script src="./plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="./plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="./plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
 <!-- Inclure les fichiers JavaScript de Bootstrap (jQuery inclus) -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Vos scripts JS -->

  <script>
    // Fonction pour télécharger le contenu en tant que fichier CSV
    function downloadCSV(content, filename) {
        const csvContent = 'data:text/csv;charset=utf-8,' + content;
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Écoute le clic sur le bouton de téléchargement
    document.getElementById('downloadCSV').addEventListener('click', function() {
        const table = document.querySelector('.table'); // Sélectionne la table
        const rows = table.getElementsByTagName('tr'); // Récupère toutes les lignes de la table

        let csvContent = '';

        // Parcourt toutes les lignes pour récupérer les données
        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td'); // Récupère les cellules de chaque ligne

            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                csvContent += cell.textContent.trim() + ','; // Ajoute le contenu de la cellule au fichier CSV
            }

            csvContent += '\n'; // Ajoute une nouvelle ligne pour chaque nouvelle ligne de la table
        }

        const currentDate = new Date();
        const filename = 'demande_appui_' + currentDate.toISOString().slice(0, 10) + '.csv'; // Nom du fichier CSV

        downloadCSV(csvContent, filename); // Télécharge le contenu en tant que fichier CSV
    });

    // Fonction pour viser une demande
    function viserDemande(idDemande) {
        var formData = new FormData();
        formData.append('id', idDemande);

        var btnValider = document.getElementById('btn-viser-' + idDemande);
        btnValider.innerHTML = '✓'; // Change le contenu du bouton en "✓" (vérification)
        btnValider.classList.add('btn-confirmation'); // Ajoute une classe pour changer le style

        fetch(window.location.href, { // Le fichier lui-même pour le traitement PHP
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                // La requête a réussi (statut HTTP 200-299)
                console.log("La demande a été validée avec succès !");
                // Mettre à jour l'interface utilisateur si nécessaire
            } else {
                // La requête a échoué avec un statut autre que 2xx
                throw new Error('Erreur lors de la validation de la demande');
            }
        })
        .catch(error => {
            // Attrape les erreurs lors de l'envoi de la requête
            console.error('Erreur:', error);
        });
    }

    // Fonction pour confirmer la visée d'une demande
    function confirmViser(id_demande) {
        if (confirm("Veuillez-vous assurer que tous les champs sont bien renseignés ?")) {
            // Si l'utilisateur confirme, appelez la fonction pour valider la demande
            viserDemande(id_demande);
        } else {
            // Si l'utilisateur annule, ne faites rien
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const btnsAfficher = document.querySelectorAll('.btn-afficher');

        btnsAfficher.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const details = JSON.parse(btn.getAttribute('data-details'));
                displayDemandeDetails(details);
            });
        });
    });

    $(document).ready(function() {
        // Gérer le clic sur le bouton "Éditer"
        $('.btn-editer').click(function() {
            // Récupérer les détails de la demande associée
            var details = JSON.parse($(this).closest('tr').find('.btn-afficher').attr('data-details'));

            
            // Pré-remplir le formulaire avec les détails récupérés
            $('#editIdDemande').val(details.id_demande);
            $('#editNomBeneficiaire').val(details.Nom_Beneficiaire);
            $('#editTypeBeneficiaire').val(details.Type_Beneficiaire);
            $('#editAgrement').val(details.Agrement);
            $('#editTypeAppui').val(details.Nom_appui); 
            $('#editTypeActivite').val(details.Nom_activite); 
            $('#editNature').val(details.Nature);
            $('#editTheme').val(details.Theme);
            $('#editDateDemande').val(details.Date_demande);
            // $('#editRegion').val(details.Region);
            // $('#editDepartement').val(details.Departement);
            $('#editQuantite').val(details.Quantite);
            $('#editCoutAppui').val(details.Cout_appui);
            $('#editNombreHommeElu').val(details.Nombre_homme_elu);
            $('#editNombreFemmeElu').val(details.Nombre_femme_elu);
            $('#editNombreHommePersonnel').val(details.Nombre_homme_personnel);
            $('#editNombreFemmePersonnel').val(details.Nombre_femme_personnel);
            $('#editObservation').val(details.Observation);

            // Afficher la boîte modale d'édition
            $('#editModal').modal('show');
        });


        



          $(document).ready(function() {
            // Gérer le clic sur le bouton "Enregistrer les modifications"
            $('#saveChangesBtn').click(function() {
                // Capturer les données éditées du formulaire
                var editedData = {
                    id_demande: $('#editIdDemande').val(),
                   
                    Nature: $('#editNature').val(),
                    Theme: $('#editTheme').val(),
                    Date_demande: $('#editDateDemande').val(),
                    // Region: $('#editRegion').val(),
                    // Departement: $('#editDepartement').val(),
                    Quantite: $('#editQuantite').val(),
                    Cout_appui: $('#editCoutAppui').val(),
                    Nombre_homme_elu: $('#editNombreHommeElu').val(),
                    Nombre_femme_elu: $('#editNombreFemmeElu').val(),
                    Nombre_homme_personnel: $('#editNombreHommePersonnel').val(),
                    Nombre_femme_personnel: $('#editNombreFemmePersonnel').val(),
                    Observation: $('#editObservation').val()
                };

                console.log("Données éditées:", editedData); // Vérifiez si les données sont correctes

            });

            // Gérer le clic sur le bouton "Détail"
            $('.btn-afficher').click(function() {
                // Récupérer les détails de la demande
                var details = JSON.parse($(this).attr('data-details'));
                displayDemandeDetails(details);
            });
        });






        // Fonction pour afficher les détails de la demande dans la boîte modale
        function displayDemandeDetails(details) {
            const modalBody = document.getElementById('demandeDetailsBody');
            let html = '';

           // Générer le contenu HTML pour afficher les détails de la demande
            html += '<p><strong>Type de bénéficiaire:</strong> ' + details.Type_Beneficiaire + '</p>';
            html += '<p><strong>Agrement:</strong> ' + details.Agrement + '</p>';
            html += '<p><strong>Nom du bénéficiaire:</strong> ' + details.Nom_Beneficiaire + '</p>';
            html += '<p><strong>Type d\'appui:</strong> ' + details.Nom_appui + '</p>';
            html += '<p><strong>Type d\'activité:</strong> ' + details.Nom_activite + '</p>';
            html += '<p><strong>Nature:</strong> ' + details.Nature + '</p>';
            html += '<p><strong>Theme:</strong> ' + details.Theme + '</p>';
            html += '<p><strong>Date de demande:</strong> ' + details.Date_demande + '</p>';
            html += '<p><strong>Région du bénéficiaire:</strong> ' + details.Region + '</p>';
            html += '<p><strong>Département du bénéficiaire:</strong> ' + details.Departement + '</p>';
            html += '<p><strong>Quantité:</strong> ' + details.Quantite + '</p>';
            html += '<p><strong>Cout d\'appui:</strong> ' + details.Cout_appui + '</p>';
            html += '<p><strong>Nombre d\'homme élu :</strong> ' + details.Nombre_homme_elu + '</p>';
            html += '<p><strong>Nombre de femme élu :</strong> ' + details.Nombre_femme_elu + '</p>';
            html += '<p><strong>Nombre d\'homme personnel  :</strong> ' + details.Nombre_homme_personnel  + '</p>';
            html += '<p><strong>Nombre de femme personnel :</strong> ' + details.Nombre_femme_personnel  + '</p>';
            html += '<p><strong>Observation:</strong> ' + details.Observation + '</p>';

            // Mettre à jour le contenu de la boîte modale avec les détails de la demande
            modalBody.innerHTML = html;

            // Afficher la boîte modale
            $('#demandeDetailsModal').modal('show');

        }
    });


    $(document).ready(function() {
    $('.btn-editer').click(function() {
        var id_demande = $(this).data('id');
        window.location.href = 'editer.php?id_demande=' + id_demande;
    });
});


</script>

<script src="../public/auto_logout.js"></script>
</body>
</html>

