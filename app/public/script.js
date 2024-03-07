// Charge les types d'activités en fonction du type d'appui sélectionné
$(document).ready(function() {
    function chargerTypesActivite(selectedType) {
        if (selectedType !== '') {
            $('#typeActivite, #intitule').parent('.nice-form-group').show();
    
            $.ajax({
                url: 'http://localhost:81/nice-forms-css/dist/index.php', // Assurez-vous que c'est le bon chemin vers votre script PHP
                method: 'POST',
                data: { typeAppui: selectedType },
                success: function(data) {
                    $('#typeActivite').html(data);
                },
                error: function(_xhr, status, error) {
                    console.error("Erreur lors de l'appel AJAX : " + status + " - " + error);
                }
            });
        } else {
            $('#typeActivite, #intitule').parent('.nice-form-group').hide();
            $('#typeActivite').empty();
        }
    }


    // Charge les départements en fonction de la région sélectionnée

    function chargerDepartements(selectedRegion) {
        $.ajax({
            url: 'http://localhost:81/nice-forms-css/dist/index.php', // Assurez-vous que c'est le bon chemin vers votre script PHP
            method: 'POST',
            data: { region: selectedRegion },
            success: function(data) {
                $('#departement').html(data);
            }
        });
    }

    // Événement déclenché lors du changement de région

    $('#region').change(function() {
        var selectedRegion = $(this).val();
        chargerDepartements(selectedRegion);
    });
    // Événement déclenché lors du changement de type d'appui

    $('#type_appui').change(function() {
        var selectedType = $(this).val();
        chargerTypesActivite(selectedType);
    });
});



// Affiche/masque les champs en fonction de la valeur sélectionnée pour le bénéficiaire

function toggleFields() {
    var beneficiaireValue = document.getElementById("beneficiaire").value;
    var sfdField = document.getElementById("sfdField");
    var autreField = document.getElementById("autreField");

    if (beneficiaireValue === "SFD") {
        sfdField.style.display = "block";
        autreField.style.display = "none";
    } else if (beneficiaireValue === "Autre") {
        sfdField.style.display = "none";
        autreField.style.display = "block";
    } else {
        sfdField.style.display = "none";
        autreField.style.display = "none";
    }
}


$(document).ready(function() {
    $('#searchInput').on('keyup', function() {
      var searchText = $(this).val().toLowerCase();

      $('tbody tr').each(function() {
        var lineText = $(this).text().toLowerCase();
        if (lineText.indexOf(searchText) === -1) {
          $(this).hide();
        } else {
          $(this).show();
        }
      });
    });
  });

 
     

  