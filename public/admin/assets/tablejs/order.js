var ORDER = function () {
	
	$(document).on('click','.order_log',function(){
		var order_id = $(this).data('order_id');
		var base_url = $('#url').val();
		$.ajax({
			url : base_url+'order/getOrderlog',
			type : "POST",
			data : {order_id : order_id},
			dataType : "json",
			async : false,
			success : function (out) {
				$('#tr').html(out.order_log);
			}
		})
	})

	$(document).on('click','.otp',function(){
		$('#otp').val('');
		$('#error	').html('');
	});

	$(document).on('click','.refund',function (){
		var base_url = $('#url').val();
		var X  = confirm('Are you sure you want to refund amount ?');
		if(X){
			var id = $(this).data('id'); 
			var paymentMethod = $(this).data('payment_method'); 
			$.ajax({
				url : base_url + 'order/refundpayment',
				type:"post",
				data : {id:id,paymentMethod:paymentMethod},
				dataType: "JSON",
				success:function (out){
					if(out.success == 1){
						window.location.reload();	
					}
				}
			})
		}

	})

	

  var HandleTable = function(){   

		  	// $.extend( $.fn.dataTable.defaults, {
		  	// 	language: {
		  	// 		"processing": "Loading. Please wait..."
		  	// 	},
		  	// });

            var url = $('#url').val();
              var dataTable = $('#example_order').DataTable({  
	                   "processing":true,  
	                   "serverSide":true,  
	                   "order":[],  
	                   "ajax":{  
	                        url: url+"order/getOrderListAjax",  
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
	            		"sEmptyTable" : "order list Not Available",
	            		"sZeroRecords": "order Not Available",
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