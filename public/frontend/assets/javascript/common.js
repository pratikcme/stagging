//back button to refresh page
// if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
//     window.location.reload();
// }
$(document).ready(function(){
    $('.alert').show();
    $('.alert').fadeOut(10000);
});

//Logout 
var siteCurrency = $('#siteCurrency').val();

if($('#cart_value').length){
	var msg = $('#cart_value').data('msg');
	swal({
		title: "Message",
		text: msg,
		type: "danger",
		timer: 15000
	});  
}

setInterval(get_note, 30000);
function get_note(){
	var url = $('#url').val();
	$.ajax({
		url : url +'home/get_notification',
		method: 'post',
		dataType: 'json',
		success:function(output){
			if(output.count > 0){
				$('#notify-dot').addClass('btn__badge');
				$('#notification').removeClass('ishave');
			}
			if(output.count == 0){
				$('#notification').addClass('ishave');
			}
			$('#notification').html(output.notify);
		}
	});
}

$(document).on('click','#clear_all',function(){
	var url = $('#url').val();
		$.ajax({
		url : url +'home/haveRead',
		method: 'post',
		dataType: 'JSON',
		success:function(output){
			if(output.count == '0'){
				$('#notification').addClass('ishave');
			}
			$('#notification').html(output.notify);
			$('#notify-dot').removeClass('btn__badge');
		}
	});
})

$(document).on('click','#logout',function() {
	var url = $('#url').val();
	swal({
		title: "Are you sure?",
		text: "You want to logout",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.ajax({
				url : url +'logout/user_logout',
				method: 'post',
				success:function(output){
					window.location.href = url+'home';
				}
			})			
		}
	});


})

$(document).on('click','#delete_account',function() {
	var url = $('#url').val();
	swal({
		title: "Are you sure?",
		text: "All the data associated with it (including your profile, photos, orders) will be permanently deleted now. This information can't be recovered once the account is deleted.",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.ajax({
				url : url +'users_account/users/data_deletion',
				method: 'post',
				dataType : "json",
				data : {hello : '1' },
				success:function(output){
					if(output[0].success == '1'){
						var title = 'Removed'; 
					}else{
						var title = 'Not Removed';
					}
					var message = output[0].message;
					swal({
						title: title,
						text: message,
						type: "success",
						timer: 5000
					}).then(function() {
							window.location.href = url+'home';
					});

				}
			})			
		}
	});


})



$(document).on('click',".cart-qty-plus",function() {
  quantityField = $(this).prev().val();
  quantity = $(this).prev();
  quantity.val(parseInt(quantityField) + 1);
  quantityField = $(this).prev().val();
   if(quantityField == 0){
    $(this).parent().prev('div').css('pointer-events','auto');
   }  
});
 
 $(document).on('click',".cart-qty-minus",function() {
  quantityField = $(this).next().val();
  quantity = $(this).next();
  if (quantityField >= 1) {
        quantity.val(parseInt(quantityField) - 1);
  }
    quantityField = $(this).next().val();
   if(quantityField < 0 || quantityField == -0){
    // $(this).parent().prev('div').css('pointer-events','none');
   }  
});

 $(document).on('click',".cart-qty-plus_c",function() {
  quantityField = $(this).prev().val();
  quantity = $(this).prev();
  quantity.val(parseInt(quantityField) + 1);
  quantityField = $(this).prev().val();
   if(quantityField == 0){
    $(this).parent().prev('div').css('pointer-events','auto');
   }  
});
 
 $(document).on('click',".cart-qty-minus_c",function() {
  quantityField = $(this).next().val();
  quantity = $(this).next();
  if (quantityField >= 1) {
        quantity.val(parseInt(quantityField) - 1);
  }
    quantityField = $(this).next().val();
   if(quantityField < 0 || quantityField == -0){
    $(this).parent().prev('div').css('pointer-events','none');
   }  
});

$(document).on('click','.remove_item',function(){
		var product_weight_id = $(this).data('product_weight_id');
		var product_id = $(this).data('product_id');
		var weight_id = $(this).data('weight_id');
		var that = $(this);
		var url = $('#url').val();
			 swal({
				  title: "Are you sure?",
				  text: "Press Ok to delete cart item !",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
				  $.ajax({
					url : url +'products/remove_cart',
					method: 'post',
					dataType: 'json',
					data : {product_id:product_id,weight_id:weight_id,product_weight_id:product_weight_id},
					success:function(output){
						window.location.reload();

						var currnt  = window.location.href;
						var segments = currnt.split( '/' );
						// if(segments[4] == 'checkout'){
						// 	window.location.href = url+'home';
						// 	return false;
						// }
						var currntPath = window.location.pathname;
						if(currntPath == '/checkout'){
							if(output.count == 0){
								$('#itemCount').css('display','none');
								 window.location.href = url+"home";
								 return false;
							}else{
								window.location.reload();
							}
						}else{
							if(output.count == 0){
									$('#itemCount').css('display','none');
									 window.location.href = url+"home";
									 return false;
								}
						}
						if(output.result == 'true'){
							 swal({
	                           title: "Removed",
	                           text: "Item removed successfully",
	                           type: "success",
	                           timer: 1500
                         	});
							$('#itemCount').html(output.count);
							$('#updated_list').html(output.updated_list);
							$('#nav_subtotal').html(output.final_total);
							if($('#'+product_id+'_'+product_weight_id).length){
								$('#'+product_id+'_'+product_weight_id).remove();
							}
						}
						
						if($('#final_subtotal').length){
							var subtot = subtotal();
						}else{
							var subtot = output.cartTotal;
						}
						$('#final_subtotal').html(subtot);
						$('#nav_subtotal').html(siteCurrency+' '+output.cartTotal);
						if($('#checkout_subtotal').length){
							var shipping = $('#shipping_charge').val();
							$('#checkout_subtotal').html(output.cartTotal);
							var checkout_final = parseFloat(output.cartTotal) + parseFloat(shipping);
							$('#checkout_final').html(checkout_final);
							$('#totalSaving').html('<i class="fas fa-rupee-sign"></i>'+output.totalSaving);

						}
					}
				})
			  }

			});


		// if(confirm('Press Ok to delete cart item')){	
			
		// }
	});

	function subtotal(){
		var subtot = 0;
		$('.total').each(function(){
			var total = $(this).html();
			// var  total = total.substring(3, total.length);
			subtot += parseFloat(total);	
		})
		return subtot.toFixed(2); 			
	}

	$(document).on('change','.vendor_nav',function(){
	// event.preventDefault();
	var url = $('#url').val();
	var vendor_id = $(this).val();
	var session_vendor_id = $('#session_vendor_id').val(); 
	var pagelink = url+'vendors/set';
	var sess_my_count = $('#itemCount').text();
	if(session_vendor_id != ''){
	if(vendor_id != session_vendor_id){
			if(sess_my_count > 0 ){
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
       
});

// //=========== ADD TO WHISLIST ACTIVE =====
// $(document).on("click",".wishlist-icon",function(){
// })


	$(document).on('click','.wishlist-icon',function(){
		let heart = $(this).children();
    	// heart.toggleClass("fas .fa-heart");
		var product_id = $(this).data('product_id');
		// var product_weight_id = $(this).data('product_weight_id');
		var currntPath = window.location.href;
		var base_url = $('#url').val();
		$.ajax({
		    url : base_url + 'products/setWishlist',
			data:{
				product_id:product_id,
				// product_weight_id:product_weight_id
			},
			method: 'post',
			dataType:"json",
			success:function(output){
				if(output.status == '0'){
					window.location.href = base_url+'login';
				}else if(output.status == 'inserted'){
					heart.toggleClass("fas .fa-heart");
				}else if(output.status == 'deleted'){
					heart.toggleClass("fas .fa-heart");
				}
			}
		})		
	})

	$(document).on('click','.removeWishlistItem',function(){
		var product_id = $(this).data('product_id');
		var base_url = $('#url').val();
		var that = $(this);
		swal("Do you want to remove this item form wishlist?", {
  			dangerMode: true,
  			buttons: true,
		}).then((willDelete) => {
		if(willDelete) {
		// var X = confirm('Do you want to remove this item form wishlist');	
				$.ajax({
				    url : base_url + '/users_account/users/removeWishlistItem',
					data:{
						product_id:product_id,
					},
					method: 'post',
					success:function(output){
						that.parent().remove();
					}
				})		
			}
		})
	})

	var base_url = $('#url').val();
	$( ".myInput" ).autocomplete({
		source: base_url+'products/backend_script',
		minLength:2,
		focus: function (event, ui) {
			$(event.target).val(ui.item.label);
			return false;
		},
		select: function (event, ui) {
			$(event.target).val(ui.item.label);
			window.location = ui.item.value;
			return false;
		}
	});

	// $(document).on('keyup','.myInput',function(){
	// })

$(document).on('click','.dec',function(){
		$(this).prop('disabled', true);
		var that = $(this);
		
		$(this).parent().addClass('transparent-wrap');
		var product_weight_id = $(this).data('product_weight_id');
		var quantity =  $(this).next('input').val();
		// alert(quantity); 
		var product_id = $(this).next().data('product_id');
		var weight_id = $(this).next().data('weight_id');
		var action = 'decrease';
		var url = $('#url').val();
		var shipping_charge = $('#shipingCharge').val();		
		shipping_charge = parseFloat(shipping_charge);
		var that = $(this);
		if(quantity == 0){
			$(this).next('input').val(1);

				swal({
					  title: "Are you sure?",
					  text: "Press Ok to delete cart item !",
					  icon: "warning",
					  buttons: true,
					  dangerMode: true,
					})
					.then((willDelete) => {
					  if (willDelete) {
					  	$.ajax({
							url : url +'products/remove_cart',
							method: 'post',
							dataType: 'json',
							async : false,
							data : {product_id:product_id,weight_id:weight_id,product_weight_id:product_weight_id},
							success:function(output){
								if(output.result == 'true'){
									swal('Cart item successfully deleted');
									that.parent().removeClass('transparent-wrap');
									var currntPath  = window.location.href;
									var segments = currntPath.split( '/' );
									if(output.count == 0){
										$('#itemCount').css('display','none');
											// window.location.reload();
									}

									// segments[4] when live
									if(segments[5] == 'productDetails' && !that.hasClass('related_cat')){
										that.parent().addClass('d-none');
										that.parent().next('div.order-btn').find('a:first').removeClass('d-none');
									}else{					
										that.parent().addClass('d-none');
										// that.parent().next('div.order-btn').find('a:first').removeClass('d-none');
										that.parent().prev('div').removeClass('d-none');										
									}

									$('#itemCount').html(output.count);


									$('#updated_list').html(output.updated_list);
									$('#nav_subtotal').html(output.final_total);
								}
							}
						})
				} else {
					that.parent().removeClass('transparent-wrap');
					that.next('input').val(1);
				}
	});
		}else{
			$.ajax({
				url : url +'add_to_card/cartIncDec',
				method: 'post',
				dataType: 'json',
				async : false,
				data : {product_id:product_id,weight_id:weight_id,product_weight_id:product_weight_id,action:action},
				success:function(output){
					that.val(quantity);
					that.parent().removeClass('transparent-wrap');
					
					$('#updated_list').html(output.updated_list);
					// window.location.reload();
					if(output.errormsg == ''){
						$('#nav_subtotal').html(output.final_total);
						// $('.total'+product_id+'_'+product_weight_id).html(output.new_total);
						// $('#order_total').html(currency+' '+(subtot+parseInt(shipping_charge)));
					}else{
						that.next('input').val(output.max_qun);
						swal(output.errormsg);
					}
				}
			})
		}
		setTimeout(function(){
				that.removeAttr('disabled');
			},1000);
	})


	$(document).on('click','.inc',function(){
		$(this).prop('disabled', true);
		$(this).parent().addClass('transparent-wrap');
		var that = $(this);
		var product_weight_id = $(this).data('product_weight_id');
		var quantity =  $(this).prev('input').val();

		var product_id = $(this).prev('input').data('product_id');
		var weight_id = $(this).prev('input').data('weight_id');
		var action = 'increase';
		var url = $('#url').val();
		var shipping_charge = $('#shipingCharge').val();
		if(quantity < 0  || typeof(quantity) == 'undefined'){
			swal('Somthing Went Wrong');
			window.location.reload();
			return false;
		}		
		// shipping_charge = parseFloat(shipping_charge);
		if(quantity == 0){
			swal('Are you want to delete this product');
		}else{
			$.ajax({
				url : url +'add_to_card/cartIncDec',
				method: 'post',
				dataType: 'json',
				async : false,
				data : {product_id:product_id,weight_id:weight_id,product_weight_id:product_weight_id, action:action},
				success:function(output){
					// window.location.reload();
					$('#updated_list').html(output.updated_list);
					setTimeout(function(){
						that.removeAttr('disabled');
					},1000);
					that.parent().removeClass('transparent-wrap');
					if(output.errormsg == ''){
						$('#nav_subtotal').html(output.final_total);
					}else{
						// that.prev('input').val(quantity - 1);
						that.prev('input').val(output.max_qun);
						swal(output.errormsg);
					}
				}
			})
		}
	});

$('.cncOrder').click(function () {
	var href = $(this).data('href');
   swal({
				  title: "Are you sure?",
				  text: "Press ok to cancle order !",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {
			  	location.href = href;
			  }
			})

});