<?php
    // controllers/MainController.php
   // require_once('app/models/DemandeModel.php');
    require_once('C:/xampp/htdocs/demande-appui/app/models/DemandeModel.php');

    class MainController {
        private $demandeModel;

        public function __construct() {
            $this->demandeModel = new DemandeModel();
        }

        public function showForm() {
            // Ici, tu pourrais inclure le fichier HTML du formulaire
           // include_once('app/views/formulaire.php');
            include_once('C:/xampp/htdocs/demande-appui/app/views/formulaire.php');

        }
        

        public function submitForm() {
            // Logique pour soumettre le formulaire
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                // Récupérer les données du formulaire
        
                $beneficiaire = $_POST['beneficiaire'];
                $nomBeneficiaire = "";
        
                // Vérifier la valeur sélectionnée et attribuer le nom correspondant
                if ($beneficiaire === 'SFD') {
                    $nomBeneficiaire = $_POST['autreInput'];
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
        
                // Mettre les données dans un tableau
                $data = [
                    'beneficiaire' => $beneficiaire,
                    'nomBeneficiaire' => $nomBeneficiaire,
                    'region' => $region,
                    'departement' => $departement,
                    'typeAppui' => $typeAppui,
                    'typeActivite' => $typeActivite,
                    'intitule' => $intitule,
                    'date' => $date,
                    'cout_appui' => $cout_appui,
                    'qt_equipements_oct' => $qt_equipements_oct,
                    'observation' => $observation
                ];
        
                // Insérer la demande en utilisant le modèle
                $result = $this->demandeModel->insertDemande($data);
        
                // Afficher un message en fonction du résultat de l'insertion
                if ($result) {
                    echo "La demande a été insérée avec succès!";
                    header("Location: http://localhost:81/demande-appui/app/views/formulaire.php");
                    exit();
                } else {
                    echo "Une erreur s'est produite lors de l'insertion de la demande.";
                }
            }
        }
        
        public function getDepartementsByRegion($selectedRegion) {
            $database = new Database();
            $connexion = $database->getConnection();
        
            // Nettoyer la variable $selectedRegion pour éviter les attaques par injection SQL
            // Utiliser des méthodes appropriées pour nettoyer la variable, par exemple :
            $selectedRegion = mysqli_real_escape_string($connexion, $selectedRegion);
        
            $query = "SELECT nom_dept FROM departement WHERE id_region = (SELECT id_region FROM region WHERE nom_region = ?)";
            
            $stmt = $connexion->prepare($query);
        
            if ($stmt) {
                $stmt->bind_param("s", $selectedRegion);
        
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    
                    $departements = [];
                    
                    while ($row = $result->fetch_assoc()) {
                        $departements[] = $row['nom_dept'];
                    }
        
                    return $departements;
                } else {
                    return "Erreur lors de l'exécution de la requête : " . $stmt->error;
                }
            } else {
                return "Erreur de préparation de la requête : " . $connexion->error;
            }
        }
        
        

        public function getTypesActivitesByTypeAppui($selectedTypeAppui) {
            $database = new Database();
            $connexion = $database->getConnection();
        
            // Nettoyer la variable $selectedTypeAppui pour éviter les attaques par injection SQL
            $selectedTypeAppui = mysqli_real_escape_string($connexion, $selectedTypeAppui);
        
            $query = "SELECT libelle FROM items WHERE id_appui = (SELECT id_appui FROM `type_appui` WHERE nom_appui = ?)";
            
            $stmt = $connexion->prepare($query);
        
            if ($stmt) {
                $stmt->bind_param("s", $selectedTypeAppui);
        
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    
                    $typesActivites = [];
                    
                    while ($row = $result->fetch_assoc()) {
                        $typesActivites[] = $row['libelle'];
                    }
        
                    return $typesActivites;
                } else {
                    return "Erreur lors de l'exécution de la requête : " . $stmt->error;
                }
            } else {
                return "Erreur de préparation de la requête : " . $connexion->error;
            }
        }
        
        
}
