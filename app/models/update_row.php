<?php
// Récupérez les données envoyées par la requête AJAX
$data = $_POST;

// Vérifiez si les données nécessaires sont présentes
if (isset($data['id_demande']) && isset($data['nomBeneficiaire'])) {
    require_once('Database.php');

    // Créez une instance de la classe Database pour obtenir la connexion à la base de données
    $database = new Database();
    $conn = $database->getConnection();

    // Vérifiez la connexion
    if ($conn->connect_error) {
        $response = array('success' => false, 'message' => 'Erreur de connexion à la base de données');
        echo json_encode($response);
        exit();
    }

    // Utilisez des requêtes préparées pour éviter les injections SQL
    $id_demande = $conn->real_escape_string($data['id_demande']);
    $newValue = $conn->real_escape_string($data['nomBeneficiaire']);
    $sql = "UPDATE liste_demande_appui SET nomBeneficiaire = ? WHERE id_demande = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("si", $newValue, $id_demande);
        if ($stmt->execute()) {
            $response = array('success' => true, 'message' => 'Mise à jour réussie');
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Échec de la mise à jour : ' . $stmt->error);
            echo json_encode($response);
        }
        $stmt->close();
    } else {
        $response = array('success' => false, 'message' => 'Échec de préparation de la requête : ' . $conn->error);
        echo json_encode($response);
    }

    // Fermez la connexion à la base de données
    $conn->close();
} else {
    $response = array('success' => false, 'message' => 'Données manquantes pour la mise à jour');
    echo json_encode($response);
}
?>
