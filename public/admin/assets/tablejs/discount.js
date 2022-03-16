var DISCOUNT = function () { 
  var HandleTable = function(){   
            var url = $('#url').val();
              var dataTable = $('#example').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"admin/getAjaxDiscount",  
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
	            		"sEmptyTable" : "Discount list Not Available",
	            		"sZeroRecords": "Discount Not Available",
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