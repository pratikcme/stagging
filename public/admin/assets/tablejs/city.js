var CITY = function () { 
  var HandleCityTable = function(){   
            var url = $('#url').val();
              var dataTable = $('#example_city').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"city/getCityDataTable",  
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
	                        {  className:"hidden-phone sorting_1", "targets":[1], },  
	                        {  className:"hidden-phone sorting_1", "targets":[2], },  
	                   ],
	            		"oLanguage": {
	            		"sEmptyTable" : "City list Not Available",
	            		"sZeroRecords": "CIty Not Available",
	        			}  
              });  
    		$( dataTable.table().body() ).attr('role','alert');
    		$( dataTable.table().body() ).attr('aria-live','polite');
    		$( dataTable.table().body() ).attr('aria-relevant','all');

    	}

    return {
        //main function to initiate the module
        table: function () {
           HandleCityTable();
        }
    };
}();