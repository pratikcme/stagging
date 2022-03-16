var CUSTOMER = function () { 
  var HandleTable = function(){   
            var url = $('#url').val();
              var dataTable = $('#example_customer').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"customer/getAjaxCustomerlist",  
	                        type:"POST",
	                   },
	                   createdRow: function ( tr ) {
       					$(tr).addClass('gradeX');
    					},
	                   "columnDefs":[  
	                        {  className:"sorting_1", "targets":[0], },  
	                        {  className:"center sorting_1", "targets":[1,2,3], },  
	                        {  className:"center", "targets":[4,5,6,7], }, 
	                   ],
	            		"oLanguage": {
	            		"sEmptyTable" : "Customer list Not Available",
	            		"sZeroRecords": "Customer Not Available",
	        			}  
              });
            $( dataTable.table().body() ).attr('role','alert');
    		$( dataTable.table().body() ).attr('aria-live','polite');
    		$( dataTable.table().body() ).attr('aria-relevant','all');   
     }

     var HandleTable2 = function(){   
            var url = $('#url').val();
              var dataTable = $('#example_group_list').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"customer/getAjaxGroupTablelist",  
	                        type:"POST",
	                   },
	                   createdRow: function ( tr ) {
       					$(tr).addClass('gradeX');
    					},
	                   "columnDefs":[  
	                        // {  className:"sorting_1", "targets":[0], },  
	                        // {  className:"center sorting_1", "targets":[1], },  
	                        // {  className:"center sorting_1", "targets":[2], },  
	                        // {  className:"center sorting_1", "targets":[3], },  
	                        // {  className:"center", "targets":[4,5,6,7], },
	                        // {  className:"center", "targets":[5], } 
	                        // {  className:"center", "targets":[6], }  
	                        // {  className:"center", "targets":[7], }  
	                   ],
	            		"oLanguage": {
	            		"sEmptyTable" : "Customer list Not Available",
	            		"sZeroRecords": "Customer Not Available",
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
        grouptable: function () {
           HandleTable2();
        }
    };
}();