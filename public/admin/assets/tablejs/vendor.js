var VENDOR = function () { 

  var HandleVendorTable = function(){   
            var url = $('#url').val();
              var dataTable = $('#example_vendor').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"vendor/ajax_vendor_list",  
	                        type:"POST",
	                   },

	                   "columnDefs":[  
	                        {  
	                             "targets":[0,5,6],  
	                             "orderable":false,  
	                        },  
	                   ],
	                    // order: ['5', 'asc'],
	            		"oLanguage": {
	            		"sEmptyTable" : "Vendor list Not Available",
	            		"sZeroRecords": "Vendor Not Available",
	        			}  
              });  
     }

       var HandleTableAccountibng = function(){   
            var url = $('#url').val();
              var dataTable = $('#example_accounting').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"vendor/GetVendorAccounting",  
	                        type:"POST",
	                   },

	                   "columnDefs":[  
	                        {  
	                             "targets":[0,6],  
	                             "orderable":false,  
	                        },  
	                   ],
	                    // order: ['5', 'asc'],
	            		"oLanguage": {
	            		"sEmptyTable" : "Account list Not Available",
	            		"sZeroRecords": "Account Not Available",
	        			}  
              });  
     }
    return {
        //main function to initiate the module
        table: function () {
           HandleVendorTable();
        },
        table2: function () {
           HandleTableAccountibng();
        }
    };
}();