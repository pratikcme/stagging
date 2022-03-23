$(document).ready(function(){
	var base_url = $('#base_url').val();
	 $("#order_success").modal('show');
	    // $('#order_success').modal({ backdrop: 'static', keyboard: false});
	 // setTimeout(function(){ 
	 // 	window.location.href = base_url+'home';    
	 // },
	 // 3000);
 });
 // alert(0);

 
 $(document).on('click','.close',function () {
	var url = $('#base_url').val();
 	window.location.href = url+'home';
 })