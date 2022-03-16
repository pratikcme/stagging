var CAT_SUBCAT = function () {
  var HandleTable = function(){   
            var url = $('#url').val();
              var dataTable = $('#example_category').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"category/getAjaxCategoryList",  
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
	                   ],
	            		"oLanguage": {
	            		"sEmptyTable" : "Category list Not Available",
	            		"sZeroRecords": "Category Not Available",
	        			}  
              });
            $( dataTable.table().body() ).attr('role','alert');
    		$( dataTable.table().body() ).attr('aria-live','polite');
    		$( dataTable.table().body() ).attr('aria-relevant','all');  
     }

     var HandleTable2 = function(){   
            var url = $('#url').val();
              var dataTable = $('#example_subcategory').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"subCategory/getAjaxSubCategory",  
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
	                   ],
	            		"oLanguage": {
	            		"sEmptyTable" : "Subcategory list Not Available",
	            		"sZeroRecords": "Subcategory Not Available",
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
        }
    };
}();