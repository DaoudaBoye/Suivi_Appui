<?php
require_once('Database.php');

// Section DemandeModel
class actionModel {
    private $db;

    public function __construct($connexion) {
        try {
            // Initialisation de la connexion à la base de données
            $this->db = $connexion;
        } catch (Exception $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

       // Méthode pour viser une demande
       public function viserDemande($id_demande) {
        $sql = "UPDATE demande_appui SET Viser = 1 WHERE id_demande = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_demande);

        if ($stmt->execute()) {
            return array("message" => "La demande a été visée avec succès !");
        } else {
            return array("message" => "Erreur lors de la validation de la demande : " . $this->db->error);
        }
    }  

       
    // Méthode pour viser une demande
    public function validerDemande($id_demande) {
        $sql = "UPDATE demande_appui SET Valider = 1, Date_validation = CURDATE() WHERE id_demande = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_demande);

        if ($stmt->execute()) {
            return array("message" => "La demande a été validée avec succès !");
        } else {
            return array("message" => "Erreur lors de la validation de la demande : " . $this->db->error);
        }
    }



    // public function renvoyerDemande($id_demande) {
    //     $sql = "UPDATE demande_appui SET Viser = 0 AND Valider = 1  WHERE id_demande = ?";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->bind_param("i", $id_demande);
        
    //     if ($stmt->execute()) {
    //         return array("message" => "La demande a été renvoyer avec succès !");
    //     } else {
    //         return array("message" => "Erreur lors du renvoie de la demande : " . $stmt->error);
    //     }
    // }




    // Méthode pour récupérer les données d'action par ID
    public function getActionById($id_demande) {
        // Préparez votre requête SQL pour sélectionner les données d'action en fonction de l'ID
        $query = "SELECT * FROM demande_appui WHERE id_demande = ?";

        // Utilisez une requête préparée pour éviter les injections SQL
        $statement = $this->db->prepare($query);

        // Liez le paramètre ID à la requête préparée
        $statement->bind_param("i", $id_demande);

        // Exécutez la requête
        $statement->execute();

        // Obtenez le résultat de la requête
        $result = $statement->get_result();

        // Vérifiez s'il y a des résultats
        if ($result->num_rows > 0) {
            // Récupérez les données d'action et retournez-les
            $actionData = $result->fetch_assoc();
            return $actionData;
        } else {
            // Aucune donnée trouvée pour l'ID donné
            return null;
        }
    }

    
    
    
}


