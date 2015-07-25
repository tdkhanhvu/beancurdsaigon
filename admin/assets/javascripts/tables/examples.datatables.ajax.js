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
		var $table = $('#datatable-ajax');
		$table.dataTable({
			bProcessing: true,
			sAjaxSource: $table.data('url')
		});

	};

	$(function() {
		datatableInit();
	});

}).apply( this, [ jQuery ]);