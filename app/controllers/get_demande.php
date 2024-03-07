<?php

    // Inclusion du fichier de connexion à la base de données et création d'une connexion
    require_once('C:/xampp/htdocs/suiviAppui/app/models/Database.php');
    $database = new Database();
    $connexion = $database->getConnection();
    // Assurez-vous d'avoir les bonnes connexions, etc., ici

    if (isset($_GET['id_demande'])) {
        $id_demande = $_GET['id_demande'];

        // Effectuer la requête SQL pour récupérer les données de la demande spécifique
        $sql = "SELECT Beneficiaire, nomBeneficiaire, Type_appui, Type_activite, intitule, date_demande, Region_beneficiaire, Departement_beneficiaire, Quantite_equipement_octroyes, Cout_appuis, Observation FROM liste_demande_appui WHERE id_demande = $id_demande";
        $result = $connexion->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Envoie les données récupérées au format JSON
            echo json_encode($row);
        } else {
            echo json_encode(array('error' => 'Aucune donnée trouvée pour cet ID de demande'));
        }
    } else {
        echo json_encode(array('error' => 'ID de demande non spécifié'));
    }

