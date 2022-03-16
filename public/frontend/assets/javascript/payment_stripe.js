$(document).ready(function(){

	$(document).on('change','.paymentOption',function(){
		var paymentOption = $(this).val();
		var payment = $(this).data('payment');
		var url = $('#url').val();
		if(paymentOption == 3){
			window.location.href = url+"order/stripepayment";
		}
	})
})

$(document).ready(function(){

	$(document).on('change','.paymentOption',function(){
		var paymentOption = $(this).val();
		var payment = $(this).data('payment');
		var url = $('#url').val();
		if(paymentOption == 2){
			window.location.href = url+"checkout/buy";
		}
	})
})

