var PRICE = function () { 
  var HandlePriceTable = function(){   
            var url = $('#url').val();
              var dataTable = $('#example_price').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"price_list/geAjaxPriceList",  
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
	            		"sEmptyTable" : "Price list Not Available",
	            		"sZeroRecords": "Price Not Available",
	        			}  
              });  
     }

    return {
        //main function to initiate the module
        table: function () {
           HandlePriceTable();
        }
    };
}();