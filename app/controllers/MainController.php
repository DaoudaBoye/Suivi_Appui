<?php
require_once('C:/xampp/htdocs/suiviAppui/app/models/DemandeModel.php');
require_once('C:/xampp/htdocs/suiviAppui/app/models/Database.php');

class MainController {
    private $demandeModel;

    public function __construct() {
        // Création de l'instance de DemandeModel dans le constructeur
        $database = new Database();
        $connexion = $database->getConnection();
        $this->demandeModel = new DemandeModel(); // Pas d'argument passé lors de l'instanciation

    }
    

    // Affichage du formulaire
    public function showForm() {
        include_once('C:/xampp/htdocs/suiviAppui/app/views/direction/formulaire.php');
    }

    // Soumission du formulaire
    public function submitForm() {
        // session_start(); // Démarrer la session si ce n'est pas déjà fait

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            // Récupération des données du formulaire
            $data = [
                'beneficiaire' => $_POST['beneficiaire'],
                'nomBeneficiaire' => ($_POST['beneficiaire'] === 'Autre') ? $_POST['autreBeneficiaire'] : $_POST['sfdName'],
                'type_appui' => $_POST['type_appui'],
                'typeActivite' => $_POST['typeActivite'],
                'Nature' => $_POST['Nature'],
                'Theme' => $_POST['Theme'],
                'NbreEluH' => $_POST['NbreEluH'],
                'NbreEluF' => $_POST['NbreEluF'],
                'NbrePersH' => $_POST['NbrePersH'],
                'NbrePersF' => $_POST['NbrePersF'],
                'date_demande' => $_POST['date_demande'],
                'Cout_appui' => $_POST['Cout_appui'],
                'Qt_equi_oct' => $_POST['Qt_equi_oct'],
                'observation' => $_POST['observation']
            ];
       
            // Insertion des données dans la base via le modèle
            $result = $this->demandeModel->insertDemande($data);

            // Gestion des messages en fonction du résultat de l'insertion
            if ($result === "success") {
                $_SESSION['success_message'] = "La demande a été insérée avec succès!";
            } else {
                $_SESSION['error_message'] = "Une erreur s'est produite lors de l'insertion de la demande: " . $result;
            }

            // Redirection vers la page du formulaire
            header("Location: http://localhost:81/suiviAppui/app/views/direction/formulaire.php?success=true");
            exit();
        }
    }
}
