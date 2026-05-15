//[Data Table Javascript]

//Project:  Bonito Admin - Responsive Admin Template
//Version:  1.1.0
//Last change:  10/09/2017
//Primary use:   Used only for the Data Table

$(function () {
    "use strict";

    $('#example1').DataTable();
    $('#example2').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
    });

    //Date picker
    $('#date_start').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    //Date picker
    $('#date_end').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });


    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'print'
        ]
    });
    $('#example3').DataTable({
        dom: 'Bfrtip',
        'bSort': false,
        buttons: [
            'copy', 'csv', 'excel', 'print'
        ]
    });

}); // End of use strict