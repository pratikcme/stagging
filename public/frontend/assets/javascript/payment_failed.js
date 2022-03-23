$(document).ready(function(){
	$("#payment_fail").modal('show');
	var url = $('#base_url').val();
	$('#payment_fail').modal({ backdrop: 'static', keyboard: false });
	// setTimeout(function(){ 
	// 	window.location.href = url+'home';    
	// },
	// 4000);
});


$(document).on('click','.close',function () {
	var url = $('#base_url').val();
	window.location.href = url+'home';
})