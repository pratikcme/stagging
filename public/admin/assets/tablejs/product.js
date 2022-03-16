var PRODUCT = function () { 



	
  var HandleTable = function(){  
  	$(document).on('click','.status_deleted',function () {
			var url = $('#url').val();
			var status = $(this).data('status');
			   $('#example_product').DataTable({ 
                   "destroy": true, 
                   "processing":true,  
                   "serverSide":true,  
                   "order":[],  
                   "ajax":{  
                        url: url+"product/getProductListAjax",  
                        type:"POST",
                        data : { status : status }
                   },  
                   createdRow: function ( tr ) {
       					$(tr).addClass('gradeX');
    					},
	                   "columnDefs":[  
	                        {
	                        	'targets':[0],
	                        	"orderable" : false,  
	                   		},
	                        {  className:"hidden-phone", "targets":[0,1,2,3,4]},
	                   ],
	            		"oLanguage": {
	            		"sEmptyTable" : "Product list Not Available",
	            		"sZeroRecords": "Product Not Available",
	        			}  
                   // bFilter: false,  
              });
			
		});
		 
            var url = $('#url').val();
              var dataTable = $('#example_product').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"product/getProductListAjax",  
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
	                        {  className:"hidden-phone", "targets":[0,1,2,3,4]},
	                   ],
	            		"oLanguage": {
	            		"sEmptyTable" : "Product list Not Available",
	            		"sZeroRecords": "Product Not Available",
	        			}  
              });
            $( dataTable.table().body() ).attr('role','alert');
    		$( dataTable.table().body() ).attr('aria-live','polite');
    		$( dataTable.table().body() ).attr('aria-relevant','all'); 
     }

     var HandleTable2 = function(){   
            var url = $('#url').val();
            var supplier_id = $('#supplier_id').val();
              var dataTable = $('#example_product').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"product/getProductListAjax",  
	                        type:"POST",
	                        data:{supplier_id:supplier_id}
	                   },
	                   createdRow: function ( tr ) {
       					$(tr).addClass('gradeX');
    					},
	                   "columnDefs":[  
	                        {
	                        	'targets':[0],
	                        	"orderable" : false,  
	                   		},
	                        {  className:"hidden-phone", "targets":[0,1,2,3,4]},
	                   ],
	            		"oLanguage": {
	            		"sEmptyTable" : "Product list Not Available",
	            		"sZeroRecords": "Product Not Available",
	        			}  
              });
            $( dataTable.table().body() ).attr('role','alert');
    		$( dataTable.table().body() ).attr('aria-live','polite');
    		$( dataTable.table().body() ).attr('aria-relevant','all'); 
     }

     var HandleTable3 = function(){   
       	var url = $('#url').val();
       	var product_id = $('#product_id').val();
        var dataTable = $('#example_product_weight_id').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"product/getProductWeightListAjax",  
	                        type:"POST",
	                        data:{product_id:product_id}
	                   },
	                   createdRow: function ( tr ) {
       					$(tr).addClass('gradeX');
    					},
	                   "columnDefs":[  
	                        {
	                        	'targets':[0],
	                        	"orderable" : false,  
	                   		},
	                        {  className:"hidden-phone", "targets":[0,1,2,3,4,5,6]},
	                   ],
	            		"oLanguage": {
	            		"sEmptyTable" : "Product weight list Not Available",
	            		"sZeroRecords": "Product weight list Not found",
	        			}  
              });
            $( dataTable.table().body() ).attr('role','alert');
    		$( dataTable.table().body() ).attr('aria-live','polite');
    		$( dataTable.table().body() ).attr('aria-relevant','all'); 
     }

    return {
        //main function to initiate the module
        table: function () {
           HandleTable();
        },
        table2: function () {
           HandleTable2();
        },
        table3: function () {
           HandleTable3();
        }
    };
}();