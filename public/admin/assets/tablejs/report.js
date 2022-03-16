var REPORT = function () { 

  var HandleTable = function(){   
            var url = $('#url').val();
              var dataTable = $('#example_inventory').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"report/getInventoryReport",  
	                        type:"POST",
	                   },
	                   createdRow: function ( tr ) {
       					$(tr).addClass('gradeX');
    					},
	                   "columnDefs":[  
	                        {  className:"hidden-phone", "targets":[0], },  
	                        {  className:"hidden-phone sorting_1", "targets":[1], },  
	                        {  className:"hidden-phone sorting_1", "targets":[2], },  
	                        {  className:"hidden-phone sorting_1", "targets":[3], }  
	                   ],
	            		"oLanguage": {
	            		"sEmptyTable" : "Users list Not Available",
	            		"sZeroRecords": "Users Not Available",
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