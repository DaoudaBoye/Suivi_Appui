<?php
require_once('C:/xampp/htdocs/suiviAppui/app/auth/check_session.php');
require_once('C:/xampp/htdocs/suiviAppui/app/models/Database.php');
require_once('C:/xampp/htdocs/suiviAppui/app/models/DemandeModel.php');

// Création d'une instance de la classe Database pour obtenir la connexion à la base de données
$database = new Database();
$connexion = $database->getConnection();

// Vérification de la connexion
if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Jquery DataTable | Bootstrap Based Admin Template - Material Design</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../../plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="../../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom Css -->
    <link href="../../css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="../../css/themes/all-themes.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <style>
        /* Exemple de styles pour les boutons */
      .btn{
        color: white; /* Couleur du texte */
        padding: 10px 20px; /* Espacement interne */
        border: none; /* Supprime le contour */
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        transition-duration: 0.4s; /* Durée de transition pour les effets */
        cursor: pointer;
      }
      

      


      .btn {
        background-color: #0f6b85; /* Couleur verte */
        color: white;
        }

        .btn:hover{
        background-color: #0db9e3;
        color:#000;
        }



        /* Style pour le popup des détails de la demande */
        .modal-content {
            background-color: #fff;
            border-radius: 5px;
        }

        .modal-header {
            background-color: #007bff;
            color: #fff;
            border-bottom: 1px solid #ddd;
        }

        .modal-title {
            font-weight: bold;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            border-top: 1px solid #ddd;
            padding: 10px 20px;
        }

        .modal-footer .btn {
            margin-right: 10px;
        }

</style> 

</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.html">
                <img src="../../../Logo_FIMF.png" alt="Votre Logo" style="max-width: 100px; height: auto;">
            </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                   
                                 <!-- #END# Tasks -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="../../images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span><?php echo $_SESSION['name']; ?></span></div>
                    <div class="email"><span><?php echo $_SESSION['username']; ?></span></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                            <!-- <li role="separator" class="divider"></li>
                             <li role="separator" class="divider"></li> -->
                             <li><a href="../../../../auth/deconnexion.php"><i class="material-icons">input</i>Déconnexion</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li>
                        <a href="../../dashbord.php">
                            <i class="material-icons">home</i>
                            <span>Dashbord</span>
                        </a>
                    </li>
                  
                    <li class="active">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">view_list</i>
                            <span>Liste des demandes</span>
                        </a>
                        <ul class="ml-menu">
                        <li>
                                <a href="Nouvelle_demande.php">Nouvelle demandes</a>
                            </li>
                            <li>
                            <a href="Demande_en_attente_validation.php">Demandes en attente de validation</a>
                            </li>
                            <li class="active">
                                <a href="DemandeValidee.php">Demandes Validées</a>
                            </li>
                            
                         
                        </ul>
                   
                    </li>
                    
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">pie_chart</i>
                            <span>Charts</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="pages/charts/morris.html">Morris</a>
                            </li>
                            <li>
                                <a href="pages/charts/flot.html">Flot</a>
                            </li>
                            <li>
                                <a href="pages/charts/chartjs.html">ChartJS</a>
                            </li>
                            <li>
                                <a href="pages/charts/sparkline.html">Sparkline</a>
                            </li>
                            <li>
                                <a href="pages/charts/jquery-knob.html">Jquery Knob</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">content_copy</i>
                            <span>Example Pages</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="pages/examples/profile.html">Profile</a>
                            </li>
                            <li>
                                <a href="pages/examples/sign-in.html">Sign In</a>
                            </li>
                            <li>
                                <a href="pages/examples/sign-up.html">Sign Up</a>
                            </li>
                            <li>
                                <a href="pages/examples/forgot-password.html">Forgot Password</a>
                            </li>
                            <li>
                                <a href="pages/examples/blank.html">Blank Page</a>
                            </li>
                            <li>
                                <a href="pages/examples/404.html">404 - Not Found</a>
                            </li>
                            <li>
                                <a href="pages/examples/500.html">500 - Server Error</a>
                            </li>
                        </ul>
                    </li>
                    
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2023 - 2024 <a href="javascript:void(0);">FIMF-Fond d'impulsion de la microfianance</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
     <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                     
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    DEMANDES VALIDEES
                </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                       
               
            <!-- #END# Basic Examples -->
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                EXPORTABLE TABLE
                                <div class="export-buttons">
                                    <button class="export-button" onclick="exportToCSV('Demandes_validees.csv')">Export CSV</button>
                                    <button class="export-button" onclick="exportToExcel('Demandes_validees.xlsx')">Export Excel</button>
                                </div>
                            </h2>

                        <div class="body">
                        <div class="table-responsive">
                        <table id="ma-table" class="table table-striped table-bordered">
                      <thead class="thead-dark">
                      <tr>
                        <th scope="col">Valide</th>
                        <!-- <th scope="col">Beneficiaire</th> -->
                          <!-- <th scope="col">id_demande</th> -->
                          <!-- <th scope="col">Beneficiaire</th> -->
                          <th scope="col">nomBeneficiaire</th>
                          <th scope="col">Type_appui</th>
                          <th scope="col">Type_activite</th>
                          <!-- <th scope="col">Nature</th> -->
                          <th scope="col">date_demande</th>
                          <!-- <th scope="col">date_validation</th> -->
                          <!-- <th scope="col">Region_beneficiaire</th> -->
                          <th scope="col">Departements</th>
                          <th scope="col">Détails</th>

                          <!-- <th scope="col">Quantite(nombre)</th>
                          <th scope="col">Cout_appui</th>
                          <th scope="col">Observation</th> -->
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                                // require_once("../models/Database.php") ;

                                 // require_once("../models/Database.php") ;

                                 $sql = "SELECT 
                                  demande_appui.Type_Beneficiaire,
                                  demande_appui.Nom_Beneficiaire,
                                  demande_appui.Agrement,
                                  demande_appui.Nature,
                                  demande_appui.Theme,
                                  demande_appui.Date_demande,
                                  demande_appui.Date_validation,
                                  region.nom_region AS Region,
                                  departement.nom_dept AS Departement,
                                  demande_appui.Quantite,
                                  demande_appui.Cout_appui,
                                  demande_appui.Observation,
                                  demande_appui.id_demande,
                                  Type_appui.Nom_appui,
                                  Type_activite.Nom_activite,
                                  demande_appui.Nombre_homme_elu,
                                  demande_appui.Nombre_femme_elu,
                                  demande_appui.Nombre_homme_personnel,
                                  demande_appui.Nombre_femme_personnel
                             FROM 
                                 demande_appui
                             LEFT JOIN 
                                 liste_sfd ON demande_appui.Agrement = liste_sfd.Agrement
                             LEFT JOIN 
                                 departement ON liste_sfd.id_dept = departement.id_dept
                             LEFT JOIN 
                                 region ON departement.id_region = region.id_region
                             LEFT JOIN 
                                 Type_activite ON demande_appui.id_activite = Type_activite.id_activite
                             LEFT JOIN 
                                 Type_appui ON Type_activite.id_appui = Type_appui.id_appui
                             WHERE
                                 Valider = 1 AND Viser = 1
                                ORDER BY 
                                 demande_appui.Date_demande DESC";
                     
                     
           
                                 $result = $connexion->query($sql);
       
                                 if ($result->num_rows > 0) {
                                   while($row = $result->fetch_assoc()) {
                            
                                echo "<tr>";
                                echo "<td><i class='fas fa-check' style='color: green;'></i></td>";
                                
                                // echo "<th scope='row'>" . $row["id_demande"] . "</th>";
                                // echo "<td>" . $row["Type_Beneficiaire"] . "</td>";
                                echo "<td>" . $row["Nom_Beneficiaire"] . "</td>";
                                echo "<td>" . $row["Nom_appui"] . "</td>";
                                echo "<td>" . $row["Nom_activite"] . "</td>";
                                // echo "<td>" . $row["Nature"] . "</td>";
                                echo "<td>" . $row["Date_demande"] . "</td>";
                                // echo "<td>" . $row["Date_validation"] . "</td>";
                                // echo "<td>" . $row["Region"] . "</td>";
                                echo "<td>" . $row["Departement"] . "</td>";
                                // echo "<td>" . $row["Quantite"] . "</td>";
                                // echo "<td>" . $row["Cout_appui"] . "</td>";
                                // echo "<td>" . $row["Observation"] . "</td>";
                                echo "<td><button id='btn-viser' class='btn btn-afficher' data-details='" . htmlspecialchars(json_encode($row)) . "'>Détail</button></td>";

                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='13'>Aucun résultat</td></tr>";
                        }
                        
                          $connexion->close();
                        ?>

                      </tbody>
                      
                   
                    <!-- Section pour afficher les détails de la demande -->
                  <div class="modal fade" id="demandeDetailsModal" tabindex="-1" role="dialog" aria-labelledby="demandeDetailsModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="demandeDetailsModalLabel">Détails de la demande</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" id="demandeDetailsBody">
                          <!-- Les détails de la demande seront affichés ici -->
                          <div class="container">
                            <!-- Contenu des détails de la demande -->
                          </div>
                        </div>
                        <div class="modal-footer">
                          <!-- Boutons "Viser" et "Éditer" -->
           
                        </div>
                      </div>
                    </div>
                  </div>



                  <!-- Boîte modale pour l'édition -->
                  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="editModalLabel">Édition de la demande</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <!-- Formulaire d'édition -->
                          <form id="editForm">
                    <div class="nice-form-group">
                      <label for="editIdDemande">Id demande</label>
                      <input type="text" id="editIdDemande" class="form-control" placeholder="Id demane" value="' + details.id_demande + '" readonly>
                    </div>
                    <div class="nice-form-group">
                      <label for="editTypeBeneficiaire">Type de bénéficiaire</label>
                      <input type="text" id="editTypeBeneficiaire" class="form-control" placeholder="Type de bénéficiaire" value="' + details.Type_Beneficiaire + '">
                    </div>
                    <!-- <div class="form-group">
                      <label for="editAgrement">Agrement</label>
                      <input type="text" id="editAgrement" class="form-control" placeholder="Agrement" value="' + details.Agrement + '">
                    </div> -->
                    <div class="nice-form-group">
                      <label for="editNomBeneficiaire">Nom du bénéficiaire</label>
                      <input type="text" id="editNomBeneficiaire" class="form-control" placeholder="Nom du bénéficiaire" value="' + details.Nom_Beneficiaire + '">
                    </div>
                    <div class="nice-form-group">
                      <label for="editTypeAppui">Type d\'appui</label>
                      <input type="text" id="editTypeAppui" class="form-control" placeholder="Type d\'appui" value="' + details.Nom_appui + '">
                    </div>
                    <div class="nice-form-group">
                      <label for="editTypeActivite">Type d\'activité</label>
                      <input type="text" id="editTypeActivite" class="form-control" placeholder="Type d\'activité" value="' + details.Nom_activite + '">
                    </div>
                    <div class="nice-form-group">
                      <label for="editNature">Nature</label>
                      <input type="text" id="editNature" class="form-control" placeholder="Nature" value="' + details.Nature + '">
                    </div>
                    <div class="nice-form-group">
                      <label for="editTheme">Theme</label>
                      <input type="text" id="editTheme" class="form-control" placeholder="Theme" value="' + details.Theme + '">
                  </div>
                  <div class="nice-form-group">
                      <label for="editDateDemande">Date de demande</label>
                      <input type="date" id="editDateDemande" class="form-control" placeholder="Date de demande" value="' + details.Date_demande + '">
                  </div>
                  <!-- <div class="form-group">
                      <label for="editRegion">Région du bénéficiaire</label>
                      <input type="text" id="editRegion" class="form-control" placeholder="Région du bénéficiaire" value="' + details.Region + '">
                  </div>
                  <div class="form-group">
                      <label for="editDepartement">Département du bénéficiaire</label>
                      <input type="text" id="editDepartement" class="form-control" placeholder="Département du bénéficiaire" value="' + details.Departement + '">
                  </div> -->
                  <div class="nice-form-group">
                      <label for="editQuantite">Quantité</label>
                      <input type="text" id="editQuantite" class="form-control" placeholder="Quantité" value="' + details.Quantite + '">
                  </div>
                  <div class="nice-form-group">
                      <label for="editCoutAppui">Cout d'appui</label>
                      <input type="text" id="editCoutAppui" class="form-control" placeholder="Cout d'appui" value="' + details.Cout_appui + '">
                  </div>
                  <div class="nice-form-group">
                      <label for="editNombreHommeElu">Nombre d'homme élu</label>
                      <input type="text" id="editNombreHommeElu" class="form-control" placeholder="Nombre d'homme élu" value="' + details.Nombre_homme_elu + '">
                  </div>
                  <div class="nice-form-group">
                      <label for="editNombreFemmeElu">Nombre de femme élu</label>
                      <input type="text" id="editNombreFemmeElu" class="form-control" placeholder="Nombre de femme élu" value="' + details.Nombre_femme_elu + '">
                  </div>
                  <div class="nice-form-group">
                      <label for="editNombreHommePersonnel">Nombre d'homme personnel</label>
                      <input type="text" id="editNombreHommePersonnel" class="form-control" placeholder="Nombre d'homme personnel" value="' + details.Nombre_homme_personnel + '">
                  </div>
                  <div class="nice-form-group">
                      <label for="editNombreFemmePersonnel">Nombre de femme personnel</label>
                      <input type="text" id="editNombreFemmePersonnel" class="form-control" placeholder="Nombre de femme personnel" value="' + details.Nombre_femme_personnel + '">
                  </div>
                  <div class="nice-form-group">
                      <label for="editObservation">Observation</label>
                      <textarea id="editObservation" class="form-control" placeholder="Observation">' + details.Observation + '</textarea>
                  </div>
                  </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Enregistrer les modifications</button>
              </div>
            </div>
          </div>
        </div>



                  
                    </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="../../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="../../plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../../plugins/node-waves/waves.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="../../plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="../../plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <script src="../../js/admin.js"></script>
    <script src="../../js/pages/tables/jquery-datatable.js"></script>

    <!-- Demo Js -->
    <script src="../../js/demo.js"></script>
    <script>

        function exportToCSV(filename) {
            const rows = document.querySelectorAll("table tr");

            let csvContent = "data:text/csv;charset=utf-8,";

            rows.forEach((row) => {
                const rowData = [];
                row.querySelectorAll("th, td").forEach((cell) => {
                    rowData.push(cell.textContent);
                });
                csvContent += rowData.join(",") + "\r\n";
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", filename);
            document.body.appendChild(link);
            link.click();
        }

        function exportToExcel(filename) {
    const table = document.querySelector("table");

    // Cloner la table pour manipuler le clone sans affecter l'originale
    const tableClone = table.cloneNode(true);

    // Supprimer la dernière colonne (celle des actions)
    const rows = tableClone.querySelectorAll("tbody tr"); // Sélectionne seulement les lignes du corps
    rows.forEach(row => {
        row.removeChild(row.lastElementChild);
    });

    const wb = XLSX.utils.table_to_book(tableClone, { sheet: "Sheet JS" });
    XLSX.writeFile(wb, filename);
}

    </script>

    
<script>
             $(document).ready(function() {
        $('#ma-table').DataTable({
        "paging": true, // Activation de la pagination
        "pageLength": 10, // Nombre de lignes par page
        // Vous pouvez ajouter d'autres options ici selon vos besoins
             });
        });



        function displayDemandeDetails(details) {
        const modalBody = document.getElementById('demandeDetailsBody');
        let html = '';

        // Générez le contenu HTML pour afficher les détails de la demande
        html += '<p><strong>Type de bénéficiaire:</strong> ' + details.Type_Beneficiaire + '</p>';
        html += '<p><strong>Agrement:</strong> ' + details.Agrement + '</p>';
        html += '<p><strong>Nom du bénéficiaire:</strong> ' + details.Nom_Beneficiaire + '</p>';
        html += '<p><strong>Type d\'appui:</strong> ' + details.Nom_appui + '</p>';
        html += '<p><strong>Type d\'activité:</strong> ' + details.Nom_activite + '</p>';
        html += '<p><strong>Nature:</strong> ' + details.Nature + '</p>';
        html += '<p><strong>Theme:</strong> ' + details.Theme + '</p>';
        html += '<p><strong>Date de demande:</strong> ' + details.Date_demande + '</p>';
        html += '<p><strong>Région du bénéficiaire:</strong> ' + details.Region + '</p>';
        html += '<p><strong>Département du bénéficiaire:</strong> ' + details.Departement + '</p>';
        html += '<p><strong>Quantité:</strong> ' + details.Quantite + '</p>';
        html += '<p><strong>Cout d\'appui:</strong> ' + details.Cout_appui + '</p>';
        html += '<p><strong>Nombre d\'homme élu :</strong> ' + details.Nombre_homme_elu + '</p>';
        html += '<p><strong>Nombre de femme élu :</strong> ' + details.Nombre_femme_elu + '</p>';
        html += '<p><strong>Nombre d\'homme personnel  :</strong> ' + details.Nombre_homme_personnel  + '</p>';
        html += '<p><strong>Nombre de femme personnel :</strong> ' + details.Nombre_femme_personnel  + '</p>';
        html += '<p><strong>Observation:</strong> ' + details.Observation + '</p>';

        // Mettez à jour le contenu de la boîte modale avec les détails de la demande
        modalBody.innerHTML = html;

        // Afficher la boîte modale
        $('#demandeDetailsModal').modal('show');
    }


    // jQuery pour attacher un gestionnaire d'événements au bouton "Détail"
$(document).ready(function() {
    $(document).on('click', '.btn-afficher', function() {
        // Récupérer les détails de la demande à partir de l'attribut data-details du bouton
        const details = $(this).data('details');
        // Appeler la fonction pour afficher les détails de la demande
        displayDemandeDetails(details);
    });
});

    </script>


</body>

</html>
