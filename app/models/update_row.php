<?php
// Inclure le fichier de connexion à la base de données une seule fois
require_once('Database.php');

// Vérifiez si les données du formulaire ont été envoyées via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que les données nécessaires sont présentes
    if (isset($_POST['id_demande']) && isset($_POST['nature']) && isset($_POST['theme']) && isset($_POST['date_demande']) && isset($_POST['quantite']) && isset($_POST['cout_appui']) && isset($_POST['NbreHElu']) && isset($_POST['NbreFElu']) && isset($_POST['NbreHPers']) && isset($_POST['NbreFPers']) && isset($_POST['observation'])) {
        
        // Récupérez les données du formulaire
        $id_demande = $_POST['id_demande'];
        $nature = $_POST['nature'];
        $theme = $_POST['theme'];
        $date_demande = $_POST['date_demande'];
        $quantite = $_POST['quantite'];
        $cout_appui = $_POST['cout_appui'];
        $NbreHElu = $_POST['NbreHElu'];
        $NbreFElu = $_POST['NbreFElu'];
        $NbreHPers = $_POST['NbreHPers'];
        $NbreFPers = $_POST['NbreFPers'];
        $observation = $_POST['observation'];
        
        // Créer une instance de la connexion à la base de données
        $database = new Database();
        $connexion = $database->getConnection();
        
        // Préparer la requête SQL d'UPDATE
        $sql = "UPDATE demande_appui SET Nature=?, Theme=?, Date_demande=?, Quantite=?, Cout_appui=?, Nombre_homme_elu=?, Nombre_femme_elu=?, Nombre_homme_personnel=?, Nombre_femme_personnel=?, Observation=? WHERE id_demande=?";
        
        // Préparer et exécuter la requête SQL
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("ssssssssssi", $nature, $theme, $date_demande, $quantite, $cout_appui, $NbreHElu, $NbreFElu, $NbreHPers, $NbreFPers, $observation, $id_demande);
        
        if ($stmt->execute()) {
            // La mise à jour a réussi
            echo "Les données ont été mises à jour avec succès.";
        } else {
            // La mise à jour a échoué
            echo "Erreur lors de la mise à jour des données : " . $connexion->error;
        }
        
        // Fermer la requête et la connexion à la base de données
        $stmt->close();
        $connexion->close();
    } else {
        // Données manquantes dans la requête POST
        echo "Toutes les données nécessaires n'ont pas été fournies.";
    }
} else {
    // La requête n'est pas de type POST
    echo "Cette page ne peut être accédée directement.";
}
