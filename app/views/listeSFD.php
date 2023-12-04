<?php
// Inclusion du fichier de connexion à la base de données
require_once('C:/xampp/htdocs/demande-appui/app/models/Database.php');

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
  <!-- Ajoute le script de SheetJS (XLSX) depuis un CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.15/xlsx.full.min.js"></script>
  <!-- Ajoute la bibliothèque Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
  <div class="demo-page">
  <div class="demo-page-navigation mon-demo">
      <nav>
        <ul>
          <li>
            <a href="http://localhost:81/demande-appui/app/views/formulaire.php">
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
          <li>
            <a href="#input-types">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-justify">
                <line x1="21" y1="10" x2="3" y2="10" />
                <line x1="21" y1="6" x2="3" y2="6" />
                <line x1="21" y1="14" x2="3" y2="14" />
                <line x1="21" y1="18" x2="3" y2="18" />
              </svg>
              Modifier une demande</a>
          </li>
        
          <li>
            <a href="#customization">
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
            <a href="#contribute">
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
    <main class="demo-page-content col-12">
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
                          <th scope="col">Agrement</th>
                          <th scope="col">Non_SFD</th>
                          <th scope="col">Sigle_SFD</th>
                          <th scope="col">Contat</th>
                          <th scope="col">Region</th>
                          <th scope="col">departement</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          // require_once("../models/Database.php") ;
                          $sql = "SELECT liste_sfd.Agrement, liste_sfd.Nom_SFD, liste_sfd.SigleSFD, liste_sfd.Contact, region.nom_region AS Region, departement.nom_dept AS Departement
                          FROM liste_sfd
                          LEFT JOIN region ON liste_sfd.Region = region.id_region
                          LEFT JOIN departement ON liste_sfd.Departement = departement.id_dept";
                  
                          $result = $connexion->query($sql);

                          if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["Agrement"] . "</td>";
                                echo "<td>" . $row["Nom_SFD"] . "</td>";
                                echo "<td>" . $row["SigleSFD"] . "</td>";
                                echo "<td>" . $row["Contact"] . "</td>";
                                echo "<td>" . $row["Region"] . "</td>";
                                echo "<td>" . $row["Departement"] . "</td>";
                                echo "<td>
                                      <a href='javascript:void(0);' onclick='editRow(this)'><i class='fas fa-edit' style='color:#555'></i></a>
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
    const filename = 'liste_SFD_' + currentDate.toISOString().slice(0, 10) + '.csv'; // Nom du fichier CSV

    downloadCSV(csvContent, filename); // Télécharge le contenu en tant que fichier CSV
  });
</script>
</body>
</html>

