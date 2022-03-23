$(document).ready(function(){
	// window.onload = function() {
		
// $(document).ready(function(){
		  // var startPos;
		  var geoSuccess = function(position) {
		    startPos = position;
		    // document.getElementById('startLat').value = startPos.coords.latitude;
		    // document.getElementById('startLon').value = startPos.coords.longitude;
			
		  };
		  var is_set =  $('#is_set_location').val();
		  if(is_set == '0'){
			navigator.geolocation.getCurrentPosition(gSuccess);
		  }

		 function gSuccess(position){
		 	var base_url = $('#url').val();
			var lat = position.coords.latitude;
			var long = position.coords.longitude;
			$.ajax({
				url : base_url + 'vendors/setCurrentlatLong',
				method : 'post',
				data : {currentlat : lat , currentlong : long },
				success:function(out){
					window.location.reload();
				} 
			})
		}

$(document).on('click','.vendor',function(){
	event.preventDefault();
	var url = $('#url').val();

	var vendor_id = $(this).data('ven_id');
	var session_vendor_id = $('#session_vendor_id').val(); 
	var pagelink = url+'vendors/set';
	var sess_my_count = $('#session_my_cart').val();
	if(session_vendor_id != ''){
	if(vendor_id != session_vendor_id){
			if(sess_my_count == 1 ){
					 // var X = confirm('You can only order from one shop.. Are you sure you want to clear cart');

			 swal({
					  title: "Are you sure?",
					  text: "'You can only order from one shop.. Are you sure you want to clear cart'",
					  icon: "warning",
					  buttons: true,
					  dangerMode: true,
					})
					.then((willDelete) => {
					  if (willDelete) {
					    $.ajax({
						            url : pagelink,
						            data:{vendor_id:vendor_id},
						            method: 'post',
						            success:function(output){
						                window.location.href = output;
						            }
			        })			
					  } else {
					    swal("Your Cart Item is safe!");
					  }
					});

				// 	 	if(X){
				// 	 		// pagelink = url+'vendor/set';
				// 	 		 $.ajax({
				// 		            url : pagelink,
				// 		            data:{vendor_id:vendor_id},
				// 		            method: 'post',
				// 		            success:function(output){
				// 		                window.location.href = output;
				// 		            }
			 //        })			
				// }



			}else{
				$.ajax({
						url : pagelink,
						data:{vendor_id:vendor_id},
						method: 'post',
						success:function(output){
						 window.location.href = output;
						}
			        })			
			}
		}else{

			$.ajax({
		            url : pagelink,
		            data:{vendor_id:vendor_id},
		            method: 'post',
		            success:function(output){
		                window.location.href = output;
		            }
		        })	
		}
	}else{
		$.ajax({
		            url : pagelink,
		            data:{vendor_id:vendor_id},
		            method: 'post',
		            success:function(output){
		                window.location.href = output;
		            }
		        })		
	}
       
})
	
	$(document).on('keyup','.search_vendor',function(){
		var vendor_name = $(this).val();
		var base_url = $('#url').val();
		var page = $(this).attr('data-page');
		// alert(page);
		$.ajax({
		        url : base_url+'vendors/serchByVendorName',
		        data:{page:page,vendor_name:vendor_name},
		        method: 'post',
		        dataType:'JSON',
		        success:function(output){ 
		        	if(vendor_name != ''){
		        		$('#view_more').css('display','none');
		        	}else{
		        		$('#view_more').css('display','block');
		        	}
		           		$('#vendor_html').html(output.vendor_html);
		           }
		        })	
	})



});