<?php
// Démarrage de la session


// Inclusion du fichier de connexion à la base de données et création d'une connexion
require_once('C:/xampp/htdocs/suiviAppui/app/models/Database.php');
$database = new Database();
$connexion = $database->getConnection();

if (isset($_GET['region'])) {
    $selectedRegion = $_GET['region'];

    // Échapper les entrées utilisateur pour éviter les attaques par injection SQL
    $selectedRegion = $connexion->real_escape_string($selectedRegion);

    // Requête SQL pour récupérer les départements associés à la région sélectionnée
    $requeteDepartements = "SELECT id_dept, nom_dept FROM departement JOIN region ON departement.id_region = region.id_region WHERE region.nom_region = '$selectedRegion'";
    $resultatDepartements = $connexion->query($requeteDepartements);

    // Générer les options de la liste déroulante des départements
    if ($resultatDepartements->num_rows > 0) {
        while ($row = $resultatDepartements->fetch_assoc()) {
            echo "<option value='" . $row['nom_dept'] . "'>" . $row['nom_dept'] . "</option>";
        }
    } else {
        echo "<option value=''>Aucun département trouvé pour cette région</option>";
    }

}


?>