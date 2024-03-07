<?php
require_once('Database.php');


// Section sfdModel
class structureModel {

    private $db;

    public function __construct() {
        try {
            $database = new Database();
            $this->db = $database->getConnection();
        } catch (Exception $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }


//    Méthode pour enregistrer un SFD
public function enregistrerStructure($data) {
    try {
        // Vérification de la connexion à la base de données
        if (!$this->db) {
            throw new Exception("Connexion à la base de données non établie.");
        }

        // Récupération des données du formulaire avec les clés correctes
        $nomStructure = $data['nomStructure'];
        $typeStructure = $data['typeStructure'];
        $contactStructure = $data['contactStructure']; // Utilisez $data pour la cohérence
        $region = $data['region'];
        $departement = $data['departement'];

        // Obtenir l'ID de la région sélectionnée
        $queryGetRegionId = "SELECT id_region FROM region WHERE nom_region = ?";
        $stmtGetRegionId = $this->db->prepare($queryGetRegionId);
        $stmtGetRegionId->bind_param("s", $region);
        $stmtGetRegionId->execute();
        $resultRegionId = $stmtGetRegionId->get_result();
        
        if ($resultRegionId && $resultRegionId->num_rows > 0) {
            $rowRegionId = $resultRegionId->fetch_assoc();
            $idRegion = $rowRegionId['id_region'];
        } else {
            throw new Exception("ID de région introuvable pour : " . $region);
        }

        // Récupération des départements associés à la région sélectionnée
        $requeteDepartements = "SELECT id_dept, nom_dept FROM departement JOIN region ON departement.id_region = region.id_region WHERE region.nom_region = ?";
        $stmtGetDeptId = $this->db->prepare($requeteDepartements);
        $stmtGetDeptId->bind_param("s", $region);
        $stmtGetDeptId->execute();
        $resultDeptId = $stmtGetDeptId->get_result();

        if ($resultDeptId && $resultDeptId->num_rows > 0) {
            $rowDeptId = $resultDeptId->fetch_assoc();
            $idDept = $rowDeptId['id_dept'];
        } else {
            throw new Exception("ID de département introuvable pour : " . $region);
        }

        // Préparation de la requête SQL pour l'insertion d'une demande
        $query = "INSERT INTO autre_structure (Nom_structure, Type_structure, Contact_structure, id_dept) 
        VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête : " . $this->db->error);
        }

        // Assurer la sécurité des données en utilisant des variables de liaison pour la requête
        $stmt->bind_param("sssi", $nomStructure, $typeStructure, $contactStructure, $idDept);

        // Exécution de la requête SQL
        if ($stmt->execute()) {
            // Si l'insertion est réussie, retourner un message de succès
            return "success";
        } else {
            throw new Exception("Erreur lors de l'enregistrement : " . $stmt->error);
        }
    } catch (Exception $e) {
        // En cas d'erreur, retourner le message d'erreur
        return $e->getMessage();
    }
}

    

// Fonction pour obtenir l'ID de la région
private function getRegionId($region) {
    $queryGetRegionId = "SELECT id_region FROM region WHERE nom_region = ?";
    $stmtGetRegionId = $this->db->prepare($queryGetRegionId);
    $stmtGetRegionId->bind_param("s", $region);
    $stmtGetRegionId->execute();
    $resultRegionId = $stmtGetRegionId->get_result();

    if ($resultRegionId && $resultRegionId->num_rows > 0) {
        $rowRegionId = $resultRegionId->fetch_assoc();
        return $rowRegionId['id_region'];
    } else {
        throw new Exception("ID de région introuvable pour : " . $region);
    }
}

// Fonction pour obtenir l'ID du département
private function getDepartementId($region) {
    $queryGetDeptId = "SELECT id_dept FROM departement JOIN region ON departement.id_region = region.id_region WHERE region.nom_region = ?";
    $stmtGetDeptId = $this->db->prepare($queryGetDeptId);
    $stmtGetDeptId->bind_param("s", $region);
    $stmtGetDeptId->execute();
    $resultDeptId = $stmtGetDeptId->get_result();

    if ($resultDeptId && $resultDeptId->num_rows > 0) {
        $rowDeptId = $resultDeptId->fetch_assoc();
        return $rowDeptId['id_dept'];
    } else {
        throw new Exception("ID de département introuvable pour : " . $region);
    }
}





    // Méthode pour enregistrer un appui
    // public function enregistrerAppui($appName, $typeActivite, $textFields) {
    //     try {
    //         $database = new Database();
    //         $connexion = $database->getConnection();
    
    //         if ($connexion->connect_error) {
    //             throw new Exception("Échec de la connexion : " . $connexion->connect_error);
    //         }
    
    //         $insertTypeAppuiQuery = "INSERT INTO type_appui (nom_appui) VALUES (?)";
    //         $stmtTypeAppui = $connexion->prepare($insertTypeAppuiQuery);
    //         $stmtTypeAppui->bind_param("s", $appName);
    
    //         if ($stmtTypeAppui->execute()) {
    //             $lastInsertedId = $connexion->insert_id;
    
    //             $insertItemsQuery = "INSERT INTO type_activite (Nom_activite, id_appui) VALUES (?, ?)";
    //             $stmtItems = $connexion->prepare($insertItemsQuery);
    //             $stmtItems->bind_param("si", $Nom_activite, $lastInsertedId);
    
    //             for ($i = 1; $i <= $typeActivite; $i++) {
    //                 $Nom_activite = $textFields['textField' . $i];
    //                 // Préparation de la requête à l'intérieur de la boucle
    //                 $stmtItems->execute();
    
    //                 if ($stmtItems->errno) {
    //                     throw new Exception("Erreur lors de l'enregistrement du type d'activité : " . $stmtItems->error);
    //                 }
    //             }
    //             return "Enregistrement réussi !";
    //         } else {
    //             throw new Exception("Erreur lors de l'enregistrement du type d'appui : " . $connexion->error);
    //         }
    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }
    
}

