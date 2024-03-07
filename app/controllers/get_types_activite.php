<?php

// Inclusion du fichier de connexion à la base de données et création d'une connexion
require_once('C:/xampp/htdocs/suiviAppui/app/models/Database.php');
$database = new Database();
$connexion = $database->getConnection();


if (isset($_GET['type_appui'])) {
    $selectedTypeAppui = $_GET['type_appui'];

    // Échapper les entrées utilisateur pour éviter les attaques par injection SQL
    $selectedTypeAppui = $connexion->real_escape_string($selectedTypeAppui);

    $requeteTypesActivite = "SELECT id_activite, Nom_activite FROM type_activite JOIN type_appui ON type_activite.id_appui = type_appui.id_appui WHERE type_appui.nom_appui = '$selectedTypeAppui'";
    // $requeteDepartements = "SELECT id_dept, nom_dept FROM departement JOIN region ON departement.id_region = region.id_region WHERE region.nom_region = '$selectedRegion'";

    
    $resultatTypesActivite = $connexion->query($requeteTypesActivite);

    if ($resultatTypesActivite->num_rows > 0) {
        while ($row = $resultatTypesActivite->fetch_assoc()) {
            echo "<option value='" . $row['Nom_activite'] . "'>" . $row['Nom_activite'] . "</option>";
        }
    } else {
        echo "<option value=''>Aucun type d'activité trouvé pour cet appui</option>";
    }
} else {
    echo "<option value=''>Veuillez sélectionner un appui</option>";
}

