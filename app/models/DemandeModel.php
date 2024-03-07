<?php
require_once('Database.php');

class DemandeModel {
    private $db;

    public function __construct() {
        try {
            // Établit une connexion à la base de données en utilisant la classe Database
            $database = new Database();
            $this->db = $database->getConnection();
        } catch (Exception $e) {
            // En cas d'erreur lors de la connexion à la base de données, affiche un message d'erreur et arrête l'exécution du script
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function insertDemande($data) {
        try {
            // Récupération des données du formulaire
            $beneficiaire = $data['beneficiaire'];
            $nomBeneficiaire = ($beneficiaire === 'SFD') ? $data['sfdName'] : $data['autreBeneficiaire'];
            $typeActivite = $data['typeActivite'];
            $nature = $data['Nature'];
            $Theme = $data['Theme'];
            $NbreEluH = $data['NbreEluH'];
            $NbreEluF = $data['NbreEluF'];
            $NbrePersH= $data['NbrePersH'];
            $NbrePersF = $data['NbrePersF'];
            $date_demande = $data['date_demande'];
            $Cout_appui = $data['Cout_appui'];
            $Qt_equi_oct = $data['Qt_equi_oct'];
            $observation = $data['observation'];
    
            $agrement = null;
            $id_structure = null;
            $id_activite = null;
    
            // Récupère l'ID de l'activité à partir de la table type_activite
            $queryActivite = "SELECT id_activite FROM type_activite WHERE Nom_activite = ?";
            $stmtActivite = $this->db->prepare($queryActivite);
            $stmtActivite->bind_param("s", $typeActivite);
            if ($stmtActivite->execute()) {
                $stmtActivite->bind_result($id_activite);
                if (!$stmtActivite->fetch()) {
                    throw new Exception("Aucune information trouvée pour le type d'activité : " . $typeActivite);
                }
            } else {
                throw new Exception("Erreur lors de la récupération de l'ID de l'activité : " . $stmtActivite->error);
            }
            $stmtActivite->close();

    
            $queryAgrement = "SELECT Agrement FROM liste_sfd WHERE SigleSFD = ?";
            $stmtAgrement = $this->db->prepare($queryAgrement);
            $stmtAgrement->bind_param("s", $nomBeneficiaire); // Utilisez $nomBeneficiaire au lieu de $typeAgrement
                    // Exécution de la requête pour récupérer l'agrément
            if ($stmtAgrement->execute()) {
                // Liaison du résultat de la requête à une variable
                $stmtAgrement->bind_result($agrement);
                // Récupération du résultat de la requête
                if (!$stmtAgrement->fetch()) {
                    throw new Exception("Aucune information trouvée pour le SigleSFD : " . $nomBeneficiaire);
                }
            } else {
                throw new Exception("Erreur lors de l'exécution de la requête pour récupérer l'Agrement : " . $stmtAgrement->error);
            }
            $stmtAgrement->close();

            



            // Prépare la requête d'insertion dans la table demande_appui
            $query = "INSERT INTO demande_appui (Type_Beneficiaire, Nom_Beneficiaire, Agrement, id_structure, id_activite, Nature, Theme, Nombre_homme_elu, Nombre_femme_elu, Nombre_homme_personnel, Nombre_femme_personnel, Date_demande, Quantite, Cout_appui, Observation) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
            $stmt = $this->db->prepare($query);
    
            if (!$stmt) {
                throw new Exception("Erreur de préparation de la requête : " . $this->db->error);
            }
    
            // Crée une variable nulle pour les valeurs par défaut
            $nullValue = NULL;
    
            // Lie les variables aux paramètres de la requête SQL en fonction du type de bénéficiaire
            if ($beneficiaire === 'SFD') {
                $stmt->bind_param("ssssissiiiisiis", $beneficiaire, $nomBeneficiaire, $agrement, $nullValue, $id_activite, $nature, $Theme, $NbreEluH, $NbreEluF, $NbrePersH, $NbrePersF, $date_demande, $Cout_appui, $Qt_equi_oct, $observation);
            } else {
                $stmt->bind_param("ssssissiiiisiis", $beneficiaire, $nomBeneficiaire, $nullValue, $id_structure, $id_activite, $nature, $Theme, $NbreEluH, $NbreEluF, $NbrePersH, $NbrePersF, $date_demande, $Cout_appui, $Qt_equi_oct, $observation);
            }
    
            // Exécute la requête et retourne un message de succès ou d'erreur
            if ($stmt->execute()) {
                return "success";
            } else {
                throw new Exception("Erreur lors de l'enregistrement : " . $stmt->error);
            }
        } catch (Exception $e) {
            // Capture les exceptions et retourne un message d'erreur
            return "Erreur lors de l'enregistrement : " . $e->getMessage();
        }
    }
}