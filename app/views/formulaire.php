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

// Vérification si le formulaire a été soumis
if (isset($_POST['submit'])) {
  // Création d'une instance de la classe DemandeModel
  require_once('C:/xampp/htdocs/demande-appui/app/models/DemandeModel.php'); // Remplacez Chemin_vers_votre_classe_DemandeModel par le chemin correct de votre classe DemandeModel
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="../public/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../public/script.js"></script>
</head>
<body>
  <!-- partial:index.partial.html -->
  <div class="demo-page">
    <div class="demo-page-navigation">
      <nav>
        <ul>
          <li>
            <a href="index.php">
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
                          echo "<option value='" . $row['SigleSFD'] . "'>" . $row['SigleSFD'] . "</option>";
                      }
                  }
              ?>
            </select>
          </div>

          

          <div id="autreField" class="nice-form-group" style="display: none;">
            <label for="autreInput">Nom de l'autre bénéficiaire</label>
            <input type="text" id="autreInput" name="nomBeneficiaire">
          </div>

          <div class="nice-form-group">
            <label for="region">Région</label>
            <select id="region" name="region">
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
              <select id="departement" name="departement">
                  <option value="">Veuillez sélectionner une région d'abord</option>
              </select>
          </div>


          <div class="nice-form-group" >
            <label for="type_appui">Type d'appui</label>
            <select id="type_appui" name="type_appui">
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
              <select id="typeActivite" name="typeActivite">
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
            <input type="number" name="Qt_equi_oct" placeholder="1234" />
          </div>

          <div class="nice-form-group">
            <label>Coût appuis (F CFA)</label>
            <input type="number" name="Cout_appui" placeholder="F CFA" />
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

</body>
</html>
