/*
Name: 			Tables / Ajax - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.3.0
*/

(function( $ ) {

	'use strict';

	var datatableInit = function() {
		// var datasource = null;
        // $.ajax({
            // url: serviceUrl,
            // type: "post",
            // data: {'request':'GetOrders'},
            // dataType: 'json',
            // success: function(result){
                // datasource = result;
            // },
            // error: function(xhr, status, error) {
                // alert(xhr.responseText);
            // }
        // });
		//var $table = $('#datatable-ajax');
		//$table.dataTable({
		//	bProcessing: true,
		//	sAjaxSource: $table.data('url')
		//});

        var table = $('#datatable-ajax').DataTable( {
            "ajax": "http://localhost/oregano/WebService.php",
            "columns": [
                { "data": "id" },
                { "data": "contact_name" },
                { "data": "date_schedule" },
                { "data": "status" },
                {
                    "className": 'details-control center',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                }
            ],
            "order": [[1, 'asc']]
        } );

        // Add event listener for opening and closing details
        $('#datatable-ajax tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
        } );

	};

	$(function() {
		datatableInit();
	});

    function format ( d ) {
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
            '<tr>'+
            '<td>Staff Id:</td>'+
            '<td>'+d.staff_id+'</td>'+
            '</tr>'+
            '<tr>'+
            '<td>Message:</td>'+
            '<td>'+d.message+'</td>'+
            '</tr>'+
            '<tr>'+
            '<td>Extra info:</td>'+
            '<td>And any further details here (images etc)...</td>'+
            '</tr>'+
            '</table>';
    }
}).apply( this, [ jQuery ]);