var HISTORY = function(){

	var url = $('#url').val();
	var dataTable = $('#sales_history').DataTable({  
		"processing":true,  
		"serverSide":true,  
		"order":[],  
		"ajax":{  
			url: url+"sell_development/getSalesHistory",  
			type:"POST",
		},
		// createdRow: function ( tr ) {
		// 	$(tr).addClass('gradeX');
		// },
		// "columnDefs":[  
		// {
		// 	'targets':[0,2],
		// 	"orderable" : false,  
		// },
		// {  className:"hidden-phone", "targets":[0,1,2], },  
		// ],
		"oLanguage": {
		 		"sEmptyTable" : "Sell History Not Available",
               "sZeroRecords": "Sell History Not Available",
		} 
	});

	 $(document).on('click','.orderDetails',function(){
      var order_id = $(this).data('order_id');
      var name = $(this).data('cust_name');
       $.ajax({
           type: "post",
           dataType : "JSON",
           url: url +'sell_development/viewOrderDetails',
           data: {order_id : order_id,name:name},
           success: function (out) {
           		$('#dynamic_tr').html(out.o_detail);
           		$('#dynamic_li').html(out.o_info);
           		$('#dynamic_date').html(out.date);
           }
       })
  });

   $(document).on('click','.remove',function(){
            var order_id = $(this).data('order_id');
            var that = $(this);
	         bootbox.confirm("Are you sure. You want to delete?", function (e) {
	            if(e == true){
	            	$.ajax({
	            		type: "post",
	            		url: url +'sell_development/removeSaleRecord',
	            		data: {order_id : order_id},
	            		success: function () {
	            			that.parent().parent().remove();
	            			dataTable.draw();
	            		}
	            	})
	            } 
	        });
  		});

}();