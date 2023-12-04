<?php
require_once('Database.php');

class DemandeModel {
    private $db;

    public function __construct() {
        try {
            // Crée une instance de la classe Database pour obtenir la connexion à la base de données
            $database = new Database();
            $this->db = $database->getConnection();
        } catch (Exception $e) {
            // Gérer l'erreur de connexion à la base de données
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public function insertDemande($data) {
        try {
            // Préparation de la requête SQL pour l'insertion d'une demande
            $query = "INSERT INTO liste_demande_appui (Beneficiaire, nomBeneficiaire, Region_beneficiaire, Departement_beneficiaire, Type_appui, Type_activite, Intitule, date_demande, Cout_appuis, Quantite_equipement_octroyes, Observation) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Préparation de la requête
            $stmt = $this->db->prepare($query);

            // Vérification si la préparation a réussi
            if (!$stmt) {
                throw new Exception("Erreur de préparation de la requête : " . $this->db->error);
            }

            $beneficiaire = $_POST['beneficiaire'];
            $nomBeneficiaire = "";
    
            // Vérifier la valeur sélectionnée et attribuer le nom correspondant
            if ($beneficiaire === 'SFD') {
                $nomBeneficiaire = $_POST['sfdName'];
            } elseif ($beneficiaire === 'Autre') {
                $nomBeneficiaire = $_POST['nomBeneficiaire'];
            }
    
            // Récupérer les autres données du formulaire
            $region = $_POST['region'];
            $departement = $_POST['departement'];
            $typeAppui = $_POST['type_appui'];
            $typeActivite = $_POST['typeActivite'];
            $intitule = $_POST['intitule'];
            $date = $_POST['date_demande'];
            $cout_appui = $_POST['Cout_appui'];
            $qt_equipements_oct = $_POST['Qt_equi_oct'];
            $observation = $_POST['observation'];

            // Assurer la sécurité des données en utilisant des variables de liaison pour la requête
            $stmt->bind_param("sssssssssss", $beneficiaire, $nomBeneficiaire, $region, $departement, $typeAppui, $typeActivite, $intitule, $date, $cout_appui, $qt_equipements_oct, $observation);

            if ($stmt->execute()) {
                session_start();
                $_SESSION['success_message'] = "La demande a été insérée avec succès!";
                header("Location: ../public/confirmation.php"); // Redirige vers une page de confirmation
                exit(); // Assurez-vous de terminer le script après la redirection
                
            } else {
                throw new Exception("Erreur lors de l'enregistrement : " . $stmt->error);
            }
        } catch (Exception $e) {
            session_start();
            $_SESSION['error_message'] = $e->getMessage();
            header("Location: ../public/confirmation.php"); // Redirige vers une page d'erreur
            exit(); // Assurez-vous de terminer le script après la redirection
        }
    }



    public function enregistrerSFD($data) {
        try {
            // Vérifiez la connexion à la base de données avant d'utiliser prepare()
            if (!$this->db) {
                throw new Exception("Connexion à la base de données non établie.");
            }
    
            // Préparation de la requête SQL pour l'insertion d'une demande
            $query = "INSERT INTO liste_sfd (Agrement, Nom_SFD, SigleSFD, Contact, Region, Departement) 
            VALUES (?, ?, ?, ?, (SELECT id_region FROM region WHERE nom_region = ?), (SELECT id_dept FROM departement WHERE nom_dept = ?))";
  
            // Préparation de la requête
            $stmt = $this->db->prepare($query);
    
            // Vérification si la préparation a réussi
            if (!$stmt) {
                throw new Exception("Erreur de préparation de la requête : " . $this->db->error);
            }
    
            // Récupérer les données du formulaire avec les clés correctes
            $agrementSFD = $data['agrementSFD'];
            $nomSFD = $data['nameSFD'];
            $sigleSFD = $data['sigleSFD'];
            $contactSFD = $_POST['contactSFD'];
            // Assurez-vous que le champ 'contactSFD' existe dans le formulaire pour récupérer sa valeur
            // $contactSFD = $data['contactSFD']; // Décommentez cette ligne si le champ est présent dans le formulaire
            $region = $data['region'];
            $departement = $data['departement'];
    
            // Assurer la sécurité des données en utilisant des variables de liaison pour la requête
            $stmt->bind_param("ssssss", $agrementSFD, $nomSFD, $sigleSFD, $contactSFD, $region, $departement);
    
            if ($stmt->execute()) {
                session_start();
                $_SESSION['success_message'] = "Le SFD a été enregistré avec succès!";
                header("Location: ../public/confirmation.php"); // Redirige vers une page de confirmation
                exit(); // Assurez-vous de terminer le script après la redirection
            } else {
                throw new Exception("Erreur lors de l'enregistrement : " . $stmt->error);
            }
        } catch (Exception $e) {
            session_start();
            $_SESSION['error_message'] = $e->getMessage();
            header("Location: ../public/confirmation.php"); // Redirige vers une page d'erreur
            exit(); // Assurez-vous de terminer le script après la redirection
        }
    }
}
?>
