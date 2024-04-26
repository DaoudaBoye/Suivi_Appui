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
if (isset($_POST['register'])) {
  // Création d'une instance de la classe DemandeModel
  require_once('C:/xampp/htdocs/suiviAppui/app/models/sfdModel.php'); // Remplacez Chemin_vers_votre_classe_DemandeModel par le chemin correct de votre classe DemandeModel
  $sfdModel = new sfdModel();

  // Appel de la méthode insertDemande avec les données du formulaire
  $result = $sfdModel->enregistrerSFD($_POST);

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
    

#themeToggle {
    background-color: transparent; /* Fond transparent */
    border: none; /* Pas de bord */
    cursor: pointer; /* Curseur de souris en pointeur */
    outline: none; /* Pas de contour de focus */
}

#themeIcon {
    font-size: 24px; /* Taille de l'icône */
    color: #FFFF00; /* Couleur de l'icône (jaune) */
    transition: color 0.3s ease; /* Animation de transition de couleur */
}


#themeToggle:hover #themeIcon {
    color: #666; /* Changement de couleur au survol */
}

/* Styles pour le mode sombre */
.dark-mode {
    background-color: #1a1a1a; /* Couleur de fond sombre */
    color: #fff; /* Couleur du texte en mode sombre */
}

/* Styles pour le mode clair */
.light-mode {
    background-color: #fff; /* Couleur de fond claire */
    color: #000; /* Couleur du texte en mode clair */
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
      <button id="themeToggle">
    <i id="themeIcon" class="fas fa-moon"></i> <!-- icône de lune par défaut -->
</button>

</div>

      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <!-- <li class="nav-item active">
              <a class="nav-link" href="http://localhost:81/suiviAppui/app/views/dashbord.php"><i class="fas fa-home"></i> Accueil <span class="sr-only">(current)</span></a>
            </li> -->
           

           
    
        <li>
        <a class="nav-link" href="../auth/deconnexion.php">
            <i class="fas fa-sign-out-alt"></i> Déconnexion <span class="sr-only">(current)</span>
        </a>
        </div>
    </nav>
  <div class="demo-page my-demo">
  
    <main class="demo-page-content col-12 centered-form" >
    <section style="width: 95vw;">
      <h1 class="card-title" style="text-align: center;">Dashobord</h1>
      <div class="row mb-3">
      
  </div>


      <div class="container-fluid">
          <div class="row">
            
          <iframe  title="TestsuiviAppui" width="1100" height="541.25" src="https://app.powerbi.com/reportEmbed?reportId=9dfb3093-caa9-4dfd-a33f-1f4e89e13362&autoAuth=true&ctid=b3e36c19-f28c-4d0d-b496-8827fe568a51" frameborder="0" allowFullScreen="true"></iframe>  

          </div>
        </div>
      </section>
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
    const filename = 'demande_appui_' + currentDate.toISOString().slice(0, 10) + '.csv'; // Nom du fichier CSV

    downloadCSV(csvContent, filename); // Télécharge le contenu en tant que fichier CSV
  });


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

</script>
<script>
    function confirmViser(id_demande) {
        if (confirm("Êtes-vous sûr de vouloir viser cette demande ?")) {
            // Si l'utilisateur confirme, appelez la fonction pour valider la demande
            viserDemande(id_demande);
        } else {
            // Si l'utilisateur annule, ne faites rien
        }
    }



    const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');

themeToggle.addEventListener('click', function() {
    // Basculer entre le mode sombre et le mode clair
    document.body.classList.toggle('dark-mode');

    // Basculer entre les icônes de lune et de soleil
    if (themeIcon.classList.contains('fa-moon')) {
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun'); // Ajoute l'icône de soleil
    } else {
        themeIcon.classList.remove('fa-sun');
        themeIcon.classList.add('fa-moon'); // Ajoute l'icône de lune
    }
});



</script>



<script src="../public/auto_logout.js"></script>
</body>
</html>

