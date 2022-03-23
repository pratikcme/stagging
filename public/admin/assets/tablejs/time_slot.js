var TIMESLOT = function () { 
  var HandleTable = function(){   
            var url = $('#url').val();
              var dataTable = $('#example').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"time_slot/getAjaxTimeSlot",  
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
	            		"sEmptyTable" : "Time Slot list Not Available",
	            		"sZeroRecords": "Time Slot Not Available",
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