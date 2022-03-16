var SUPPLIER = function () { 
  var HandleTable = function(){   
            var url = $('#url').val();
              var dataTable = $('#example_supplier').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"supplier/supplierListAjax",  
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
	                        {  className:"hidden-phone", "targets":[0,1,2], },  
	                        {  className:"hidden-phone sorting_1", "targets":[3,4], },
	                   ],
	            		"oLanguage": {
	            		"sEmptyTable" : "Supplier list Not Available",
	            		"sZeroRecords": "Supplier Not Available",
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
        }
    };
}();