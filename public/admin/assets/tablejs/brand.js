var BRAND = function () { 
  	

  var HandleTable = function(){   
            var url = $('#url').val();
              var dataTable = $('#example_brand').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"brand/getBrandlistAjax",  
	                        type:"POST",
	                   },
	                   createdRow: function ( tr ) {
       					$(tr).addClass('gradeX');
    					},
	                   "columnDefs":[  
	                        {
	                        	'targets':[0,2],
	                        	"orderable" : false,  
	                   		},
	                        {  className:"hidden-phone", "targets":[0,1,2], },  
	                   ],
	            		"oLanguage": {
	            		"sEmptyTable" : "Brand list Not Available",
	            		"sZeroRecords": "Brand Not Available",
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