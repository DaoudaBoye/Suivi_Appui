<?php
require_once('Database.php');

// Assurez-vous que les données POST ont été reçues correctement
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données éditées du formulaire
    $id_demande = $_POST['id_demande'];
    $nature = $_POST['Nature'];
    $theme = $_POST['Theme'];
    $date_demande = $_POST['Date_demande'];
    $quantite = $_POST['Quantite'];
    $cout_appui = $_POST['Cout_appui'];
    $nombre_homme_elu = $_POST['Nombre_homme_elu'];
    $nombre_femme_elu = $_POST['Nombre_femme_elu'];
    $nombre_homme_personnel = $_POST['Nombre_homme_personnel'];
    $nombre_femme_personnel = $_POST['Nombre_femme_personnel'];
    $observation = $_POST['Observation'];


    // Préparez votre requête SQL pour mettre à jour la demande
    $sql = "UPDATE demande_appui SET 
                        Nature = ?,
                        Theme = ?,
                        Date_demande = ?,
                        /* Region = ?, */
                        /* Departement = ?, */
                        Quantite = ?,
                        Cout_appui = ?,
                        Nombre_homme_elu = ?,
                        Nombre_femme_elu = ?,
                        Nombre_homme_personnel = ?,
                        Nombre_femme_personnel = ?,
                        Observation = ?
                    WHERE id_demande = ?";
;

    // Préparez et exécutez la déclaration
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("sssssiddiii", 
        $nature, $theme, $date_demande, 
        $quantite, $cout_appui, $nombre_homme_elu, $nombre_femme_elu, 
        $nombre_homme_personnel, $nombre_femme_personnel, $observation, $id_demande
    );

    // Assurez-vous que les valeurs sont correctement liées et exécutez la requête
    if ($stmt->execute()) {
        // La demande a été mise à jour avec succès
        echo "success";
    } else {
        // Il y a eu une erreur lors de la mise à jour de la demande
        echo "error: " . $stmt->error;
    }

    // Fermez la déclaration et la connexion à la base de données
    $stmt->close();
    $connexion->close();
}
