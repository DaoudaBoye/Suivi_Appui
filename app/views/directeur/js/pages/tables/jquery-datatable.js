$(function () {
    $('.js-basic-example').DataTable({
        responsive: true
        
    });

    //Exportable table
    $(document).ready(function() {
        $('.js-exportable').DataTable({
            // Vos autres options de DataTables ici
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
    
    
});


