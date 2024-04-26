<?php
// session_start();
require_once('C:/xampp/htdocs/suiviAppui/app/auth/check_session.php');

// Inclusion du fichier de connexion à la base de données
require_once('C:/xampp/htdocs/suiviAppui/app/models/Database.php');

// Création d'une instance de la classe Database pour obtenir la connexion à la base de données
$database = new Database();
$connexion = $database->getConnection();

// Vérification de la connexion
if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
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
    body {
        padding-top: 60px; /* Ajustez la valeur selon la hauteur de votre barre de navigation */
    }

      /* Styles pour le mode sombre */

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
              <a class="nav-link" href="http://localhost:81/suiviAppui/app/views/suiviEvaluation/adminConfirm.php"><i class="fas fa-home"></i> Accueil <span class="sr-only">(current)</span></a>
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
            <a href="adminConfirm.php"">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                <polygon points="12 2 2 7 12 12 22 7 12 2" />
                <polyline points="2 17 12 22 22 17" />
                <polyline points="2 12 12 17 22 12" />
              </svg>
              Voir la liste des demandes</a>
          </li>
    
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
            <a href="listeSFD.php">
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
      <h1 class="card-title" style="text-align: center;">Liste des demandes</h1>
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
                 
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">id_demande</th>
                          <th scope="col">Beneficiaire</th>
                          <th scope="col">nomBeneficiaire</th>
                          <th scope="col">Type_appui</th>
                          <th scope="col">Type_activite</th>
                          <th scope="col">Nature</th>
                          <th scope="col">Date_demande</th>
                          <th scope="col">Region_beneficiaire</th>
                          <th scope="col">Departement_beneficiaire</th>
                          <th scope="col">Quantite(nombre)</th>
                          <th scope="col">Cout_appui</th>
                          <th scope="col">Observation</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          // require_once("../models/Database.php") ;
                      
                          $sql = "SELECT * FROM demande_appui WHERE Viser = 0";
                          $result = $connexion->query($sql);

                          if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $row["id_demande"] . "</th>";
                                echo "<td>" . $row["Type_Beneficiaire"] . "</td>";
                                echo "<td>" . $row["Nom_Beneficiaire"] . "</td>";
                                echo "<td>" . $row["Nom_appui"] . "</td>";
                                echo "<td>" . $row["Nom_activite"] . "</td>";
                                echo "<td>" . $row["Nature"] . "</td>";
                                echo "<td>" . $row["Date_demande"] . "</td>";
                                echo "<td>" . $row["Date_validation"] . "</td>";
                                echo "<td>" . $row["Region"] . "</td>";
                                echo "<td>" . $row["Departement"] . "</td>";
                                echo "<td>" . $row["Quantite"] . "</td>";
                                echo "<td>" . $row["Cout_appui"] . "</td>";
                                echo "<td>" . $row["Observation"] . "</td>";
                             echo "<td>
                                      <a href='javascript:void(0);' onclick='editRow(this)'><i class='fas fa-edit' style='color:#555'></i></a>
                                      <a href='supprimer_demande.php?id=" . $row["id_demande"] . "'><i class='fas fa-trash' style='color: red;'></i></a>
                                    </td>";
                                echo "</tr>";
                               
                            }
                        } else {
                            echo "<tr><td colspan='13'>Aucun résultat</td></tr>";
                        }
                        
                          $connexion->close();
                        ?>

                      </tbody>
                      
                    </table>
                    <!-- Ajoute un élément div pour les boutons de pagination -->
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
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Vos scripts JS -->

<script>
 const UPDATE_URL = "update_row.php";

 function handleSuccess(response) {
    console.log("Mise à jour réussie : " + response);
    window.location.href = "success_page.php"; // Redirection vers une page de réussite
}


function handleError(xhr, status, error) {
    console.error("Erreur lors de la mise à jour : " + error);
    restoreInitialState(); // Rétablissement de l'état initial de la page
}


function editRow(element) {
    var row = element.closest('tr');

    // Récupérer toutes les cellules de la ligne sauf la dernière (celle des actions)
    var cells = row.querySelectorAll('td:not(:last-child)');

    cells.forEach(function(cell) {
        var currentValue = cell.textContent.trim(); // Récupérer la valeur actuelle
        var inputField = document.createElement('input'); // Créer un champ input
        inputField.type = 'text';
        inputField.value = currentValue; // Pré-remplir avec la valeur actuelle
        cell.textContent = ''; // Vider la cellule
        cell.appendChild(inputField); // Ajouter le champ input à la cellule
    });

    var editButton = row.querySelector('.fa-edit');
    editButton.parentNode.innerHTML = '<a href="javascript:void(0);" onclick="saveRow(this)"><i class="fas fa-check"></i></a>';
}


function saveRow(element) {
    var row = element.closest('tr');
    var inputs = row.querySelectorAll('input[type="text"]');
    var data = {};

    inputs.forEach(function(input) {
        var columnName = input.parentNode.cellIndex;
        var columnValue = input.value;
        data[columnName] = columnValue;
    });

    fetch(UPDATE_URL, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Data received:', data); // Ajout d'un log pour vérifier les données reçues
        handleSuccess(data);
    })
    .catch(error => {
        console.error('Error:', error); // Log d'erreur en cas de problème
        handleError(error);
    });
}


// Sélectionne l'élément de champ de recherche
const searchInput = document.getElementById('searchInput');

// Écoute les changements dans le champ de recherche
searchInput.addEventListener('input', function() {
    const filter = searchInput.value.toUpperCase(); // Récupère la valeur du champ en majuscules pour la recherche insensible à la casse

    const table = document.querySelector('.table'); // Sélectionne la table
    const rows = table.getElementsByTagName('tr'); // Récupère toutes les lignes de la table, sauf l'en-tête

    // Parcourt toutes les lignes et affiche seulement celles qui correspondent à la recherche
    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td'); // Récupère les cellules de chaque ligne

        let shouldDisplay = false;
        for (let j = 0; j < cells.length; j++) {
            const cell = cells[j];
            if (cell) {
                const textValue = cell.textContent || cell.innerText; // Récupère le contenu de la cellule
                if (textValue.toUpperCase().indexOf(filter) > -1) {
                    shouldDisplay = true;
                    break;
                }
            }
        }

        // Affiche ou cache la ligne en fonction du résultat de la recherche
        if (shouldDisplay) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
});

const rowsPerPage = 10; // Nombre de demandes par page
    let currentPage = 0; // Page actuelle

    // Sélectionne l'élément de la table
    const table = document.querySelector('.table');

    // Sélectionne les boutons de pagination
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    // Sépare les demandes en pages et cache toutes les pages sauf la première
    const rows = table.getElementsByTagName('tr');
    for (let i = 1; i < rows.length; i++) {
        if (i > rowsPerPage) {
            rows[i].style.display = 'none';
        }
    }
    // Gère le clic sur le bouton "Suivant"
    nextBtn.addEventListener('click', function() {
        const totalPages = Math.ceil(rows.length / rowsPerPage);

        if (currentPage < totalPages - 1) {
            const startIndex = (currentPage + 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;

            for (let i = 1; i < rows.length; i++) {
                if (i >= startIndex && i < endIndex) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }

            currentPage++;
        }
    });

    // Gère le clic sur le bouton "Précédent"
    prevBtn.addEventListener('click', function() {
        if (currentPage > 0) {
            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;

            for (let i = 1; i < rows.length; i++) {
                if (i >= startIndex && i < endIndex) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }

            currentPage--;
        }
    });


</script>

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
    const filename = 'liste_demande_appui_' + currentDate.toISOString().slice(0, 10) + '.csv'; // Nom du fichier CSV

    downloadCSV(csvContent, filename); // Télécharge le contenu en tant que fichier CSV
  });
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


<script src="../public/auto_logout.js"></script>
</body>
</html>

