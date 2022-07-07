var ORDER_SUMMARY = function () {
	
	$(document).on('click','#download',function(){
		var url = $('#url').val();
		var from_date = $('#from_date').val() ;
		var to_date = $('#to_date').val();
		var order_status = $('#order_status').val();	
		$.ajax({
			type : 'POST',
			url  : url+"order/generate_order_summary_report",
			data : {from_date : from_date, to_date : to_date ,order_status : order_status},
			dataType : 'json'
		}).done(function(data){

			var $a = $("<a>");
			$a.attr("href",data.file);
			$("body").append($a);
			$a.attr("download", data.filename);
			$a[0].click();
			$a.remove();
		});
	})



	var HandleTable = function(){ 
		$(document).on('click','#reload',function () {
			var url = $('#url').val();
				$('#from_date').val('') ;
				$('#to_date').val('');
				$('#order_status').val('');
			   $('#example_order').DataTable({ 
                   "destroy": true, 
                   "processing":true,  
                   "serverSide":true,  
                   "order":[],  
                   "ajax":{  
                        url: url+"order/getOrderSummaryListAjax",  
                        type:"POST",
                   },  
                   createdRow: function ( tr ) {
       					$(tr).addClass('gradeX');
    					},
	                   "columnDefs":[  
				  		{
				  			'targets':[0],
				  			"orderable" : false,  
				  		},
				  		{  className:"hidden-phone", "targets":[0], },  
				  		{  className:"hidden-phone ", "targets":[1], },  
				  		{  className:"hidden-phone ", "targets":[2], },
				  		],
				  		"oLanguage": {
				  			"sEmptyTable" : "order list Not Available",
				  			"sZeroRecords": "order Not Available",
				  		}  
                   // bFilter: false,  
              });
			
		});

		$(document).on('click','#Search',function () {
			var url = $('#url').val();
			var from_date = $('#from_date').val() ;
			var to_date = $('#to_date').val();
			var order_status = $('#order_status').val();
			   $('#example_order').DataTable({ 
                   "destroy": true, 
                   "processing":true,  
                   "serverSide":true,  
                   "order":[],  
                   "ajax":{  
                        url: url+"order/getOrderSummaryListAjax",  
                        type:"POST",
                        data : { from_date : from_date , to_date : to_date , order_status : order_status}
                   },  
                   createdRow: function ( tr ) {
       					$(tr).addClass('gradeX');
    					},
	                   "columnDefs":[  
				  		{
				  			'targets':[0],
				  			"orderable" : false,  
				  		},
				  		{  className:"hidden-phone", "targets":[0], },  
				  		{  className:"hidden-phone ", "targets":[1], },  
				  		{  className:"hidden-phone ", "targets":[2], },
				  		],
				  		"oLanguage": {
				  			"sEmptyTable" : "order list Not Available",
				  			"sZeroRecords": "order Not Available",
				  		}  
                   // bFilter: false,  
              });
			
		});

		  	var url = $('#url').val();
		  	var dataTable = $('#example_order').DataTable({  
		  		"processing":true,  
		  		"serverSide":true,  
		  		"order":[],  
		  		"ajax":{  
		  			url: url+"order/getOrderSummaryListAjax",  
		  			type:"POST",
		  		},
		  		createdRow: function ( tr ) {
		  			$(tr).addClass('gradeX');
		  		},
		  		"columnDefs":[  
		  		{
		  			'targets':[0],
		  			"orderable" : false,  
		  		},
		  		{  className:"hidden-phone", "targets":[0], },  
		  		{  className:"hidden-phone ", "targets":[1], },  
		  		{  className:"hidden-phone ", "targets":[2], },
		  		],
		  		"oLanguage": {
		  			"sEmptyTable" : "order list Not Available",
		  			"sZeroRecords": "order Not Available",
		  		}  
		  	});  
		  }

		  return {
        //main function to initiate the module
        table: function () {
        	HandleTable();
        }
    };
}();