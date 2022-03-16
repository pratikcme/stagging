var USER = function () { 

  var HandleUserTable = function(){   
            var url = $('#url').val();
              var dataTable = $('#users_table').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"admin/getAjaxTableUsers",  
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
           HandleUserTable();
        }
    };
}();