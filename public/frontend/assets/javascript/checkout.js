var CHECKOUT = function(){
   
    var url = $('#url').val();
    var address_checked = false;
    $('.default_check').each(function( index, element ) {
                if($(this).is(":checked")){
                    address_checked = true;
                }
            })
    $(document).on('click','#nextButton',function(){
        if($('.default_check').length){
            $('.default_check').each(function( index, element ) {
                if($(this).is(":checked")){
                    address_checked = true;
                }
            })
        }

        if(address_checked){
            $(this).parent().parent().parent().prev().removeClass('active');
            if($(this).parent().parent().parent().hasClass('full_height')){
                $(this).parent().parent().parent().removeClass('full_height');
            }

            $(this).parent().parent().parent().removeAttr('style');
            $(this).parent().parent().parent().next().next().addClass('active');
            $(this).parent().parent().parent().next().next().next().css('max-height','662px');
            // $('.panel').css("max-height","191px");
        }
    })

    // if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
    //     window.location.reload();
    // }
    
    var is_checked = false;
        var time_slot_id = '';  
     $('.time_slot_checked').each(function(){
            if($(this).is(':checked')){
                time_slot_id = $(this).val();
                is_checked = true;
            }
        })
   

     $(document).on('click','.time_slot_checked',function(){
         $('.time_slot_checked').each(function(){
            if($(this).is(':checked')){
                time_slot_id = $(this).val();
                $('#payBtn').removeAttr('disabled');
                is_checked = true;
            }else{
                $(this).removeAttr('checked');
            }
        })   
     })

    $(document).on('click','#btnCheckSlot',function(){
        $('.time_slot_checked').each(function(){
            if($(this).is(':checked')){
                time_slot_id = $(this).val();
                is_checked = true;
            }
        })
        if(is_checked){
            $(this).parent().parent().removeAttr('style');
            $(this).parent().parent().prev().removeClass('active');


            $(this).parent().parent().next('button').addClass('active');
            $(this).parent().parent().next('button').next().css('max-height','192px');
        }
    })

    $(document).ready(function () {
      $('.stripe-button-el').css('display','none');
    })


    function timeSlotChecked(){
        $('.time_slot_checked').each(function(){
            if($(this).is(':checked')){
                $('#payBtn').removeAttr('disabled');
            }else{
                $('#payBtn').attr('disabled','disabled');
            }
        }) 
    }

    $(document).on('click','#user_gst_number',function(){
        if($(this).is(":checked")){
            $('#gst_number').css('display','');
        }else{
            $('#gst_number').css('display','none');
        }
    });


        var paymentOption = '-1';
    $(document).on('click','#payBtn',function(){
        

        if($('#credit').checked = true){

            $('#paytm-checkoutjs').addClass('test');
            $('.ptm-own-element').css('display', 'block !important');
        }

        $('.pay-chk').each(function(){
            if($(this).is(":checked")){
                paymentOption = $(this).val();
            }
        })
        
        if(paymentOption == '-1'){
            $('#payBtn_error').html('please select Payment method');
            return false; 
        }
        if(paymentOption == ''){
            $('#payBtn_error').html('please select Payment method');
            return false; 
        }
        // if(address_checked == false){
        //     alert('please select address');
        //     return false;   
        // }
         var delivery_date = $('#datepicker').val();
         var AddressNotInRange = $('#AddressNotInRange').val();
         var checkAddress = $('#checkAddress').val();
         var isSelfPickup = $('#CheckisSelfPickup').val();

         
         if(checkAddress == '0' && isSelfPickup =='0'){
            // alert("Please enter your Address");
            $('#payBtn_error').html("Please enter your Address");
            return false;
         }
          if(AddressNotInRange == '0'){
            // alert("We are not deliver to your selected Address");
            $('#payBtn_error').html("We do not deliver to your selected Address");
            return false;
         }

         if(!is_checked && isSelfPickup =='0'){
          $('#payBtn_error').html("Please select time slot");
            return false;  
         }

         var user_gst_number = '';
         if($('#user_gst_number').length){
            if($('#user_gst_number').is(":checked")){
                
                var user_gst_number = $('#user_gst_number').val();
            }
         }

       var promocode = $("#applied_promo").val();

             // alert('All services are disabled');
             // return false;
        if(paymentOption == 0){ 
            $('.loader-main').removeClass('d-none'); 
            CheckSelfPickUpEnable();
            $.ajax({
                url: url+'orders/makeorder',
                data:{
                    time_slot_id : time_slot_id, 
                    promocode :promocode,
                    paymentOption: paymentOption,
                    delivery_date:delivery_date,
                    user_gst_number : user_gst_number
                },
                method:"post",
                dataType:"JSON",
                success:function(output){
                    if(output.status == 1){
                        $('.loader-main').addClass('d-none');
                        $('#orderId').html("Your Order No : "+output.order_number);
                        $("#order_success").modal('show');
                        $('#order_success').modal({ backdrop: 'static', keyboard: false }); //make outside not clickable 
                        // setTimeout(function(){ 
                        //     window.location.href = url+'home';    
                        //  },
                        //  5000);
                    }else if(output.status == 0){
                        // console.log(output);
                        window.location.href = url+'checkout';
                    }else{
                        window.location.href = url+'home';
                    }
                }
            })
        }else if(paymentOption == 1){ 
        updatePaymentSetup();
        checkProductAvailability();
        reserve_quantity();
        CheckSelfPickUpEnable();  // this function check current status of selfpickup enable or not
        /* Razar payment gateway */
        var options = $('#razerData').attr('data-json');
        var options = $.parseJSON(options); 
        console.log(options);
        // return false;
                        /**
             * The entire list of Checkout fields is available at
             * https://docs.razorpay.com/docs/checkout-form#checkout-fields
             */
        options.handler = function (response){
            var razorpay_payment_id = response.razorpay_payment_id;
            var razorpay_order_id = response.razorpay_order_id;
            var razorpay_signature = response.razorpay_signature;
            var payment_type = '1';
            $.ajax({
                url:url+'checkout/rzp_payment',
                method:'POST',
                dataType:'json',
                data: {
                    razorpay_payment_id:razorpay_payment_id,
                    promocode:promocode,
                    razorpay_order_id:razorpay_order_id,
                    razorpay_signature : razorpay_signature,
                    payment_type : payment_type,
                    delivery_date : delivery_date,
                    time_slot_id : time_slot_id,
                    user_gst_number : user_gst_number
                },
                success:function(output){
                      if(output.status == 1){
                        $('#orderId').html("Your Order No : "+output.order_number);
                        $("#order_success").modal('show');
                        // setTimeout(function(){ 
                        //     window.location.href = url+'home';    
                        //  },
                        //  5000);
                    }else{
                        window.location.href = url+'home';
                    }
                }
            })
            // document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            // document.getElementById('razorpay_signature').value = response.razorpay_signature;
            // document.razorpayform.submit();
        };
            // Boolean whether to show image inside a white frame. (default: true)
            // options.theme.image_padding = false;
            options.modal = {
                ondismiss: function() {
                    close();
                    console.log("This code runs when the popup is closed");
                 },
            // Boolean indicating whether pressing escape key 
            // should close the checkout form. (default: true)
            escape: true,
            // Boolean indicating whether clicking translucent blank
            // space outside checkout form should close the form. (default: false)
            backdropclose: false
    };
               var rzp = new Razorpay(options);
                 rzp.open();
                 // e.preventDefault();
        }else if(paymentOption == 2){ 
            updatePaymentSetup();
            checkProductAvailability();

            CheckSelfPickUpEnable();
         /*Stripe Payment Gateway*/
            reserve_quantity();
             $('.loader-main').removeClass('d-none');
            $('#stipeForm').append('<input type="hidden" name="delivery_date" value="'+delivery_date+'" />');
            $('#stipeForm').append('<input type="hidden" name="time_slot_id" value="'+time_slot_id+'" />');
            $('#stipeForm').append('<input type="hidden" name="user_gst_number" value="'+user_gst_number+'" />');
            $('#stipeForm').append('<input type="hidden" name="promocode" value="'+promocode+'" />');
            $('.stripe-button-el').trigger('click');
        
        }else if(paymentOption == 3){
            /*Paytm gateway*/
             // $('.loader-main').removeClass('d-none');
             updatePaymentSetup();
             if(checkProductAvailability() == true){
                setTimeout(function(){

                    CheckSelfPickUpEnable();            
                    reserve_quantity();
                    var paytm = $('#paytm').attr('data-json');
                    var details = $.parseJSON(paytm);
                    $.ajax({
                        url:url+'checkout/set_date_time_id',
                        method:'POST',
                        dataType:'json',
                        data: {
                            time_slot_id  : time_slot_id,
                            promocode  : promocode,
                            delivery_date : delivery_date,
                            user_gst_number : user_gst_number
                        },
                        success:function(output){
                            
                        }
                    })
                    onScriptLoad(details.txnToken,details.orderId,details.amount);
                },1000)
             }

        }else{
            alert('No Payment Gateway is available');

        }
    })

  function updatePaymentSetup(){
     var promocode = $("#applied_promo").val();
     if(promocode==''){
        return true;
     }
    $.ajax({
            url: url+'checkout/paymentSetup',
            method:"post", 
            dataType:"JSON",
            data: {promocode:promocode},
            async : false,
            success:function(output){
                if(output.response == 0){
                   window.location.reload();
                }

                $('#razerData').attr('data-json',output.data);
                $('#paytm').attr('data-json',output.paytm);
                $('.stripe-amount').attr('data-json',output.amount);
            }
        })
  }

    function CheckSelfPickUpEnable(){
           $.ajax({
            url: url+'checkout/checkSelfPickUp',
            method:"post", 
            dataType:"JSON",
            async : false,
            success:function(output){
                if(output.response == 0){
                    window.location.reload();
                }
            }
        })
    }

    function checkProductAvailability(){
           $.ajax({
            url: url+'orders/check',
            method:"post", 
            dataType:"JSON",
            async : false,
            success:function(output){
                if(output.status == 0){
                    window.location.href = url+'checkout';
                }
            }
        })
           return true;
    }

    $(document).on("click","#app-close-btn", close);
    $(document).on("DOMNodeRemoved",".stripe_checkout_app", close);
    function close(){
    	$('.loader-main').addClass('d-none');
         $.ajax({
            url:url+'checkout/unreserve_quantity',
            method:'POST',
            success:function(output){
                // window.location.reload();
            }
        });
    }


    function reserve_quantity(){
         $.ajax({
            url:url+'checkout/set_reserve_quantity',
            method:'POST',
            success:function(output){
                // window.location.reload();
            }
        });
    }

    $(document).on('click','.close',function () {
        window.location.href = url+'home';
    })

    $(document).on('click','#isSelfPickup',function(){
         $('.loader-main').removeClass('d-none');
        var isSelfPickup = 0;
        if($(this).is(':checked')){
            isSelfPickup = 1;
        }
        var url = $('#url').val();
        $.ajax({
            url : url +'products/setSelfPick',
            type: 'post',
            data : {isSelfPickup:isSelfPickup},
            success:function(output){
                window.location.href = url+'checkout';
            }
        })

    })


    $(document).on('click','#verify',function () {
            $('.mobile_verfication').html('');
            $('#mobileModal').modal('show');
            $('#mobileModal').modal({ backdrop: 'static', keyboard: false });
    })


    $("#checkPromocode").click(function(){
        
        var siteCurrency = $('#siteCurrency').val();
        var promocode = $("#promocode").val();
        $("#applied_promo").val('');
        $('#promoAmount').html('0');                        
        $('.promocode-applied').hide();
        $('#promo_err').html('');
        if(promocode==''){
            $('#promo_err').html('Please enter promocode');
        }
        var shipping_charge = $('#shipping_charge').val();
        console.log(shipping_charge,shipping_charge);
        if(shipping_charge=='notInRange' || shipping_charge==''){
            shipping_charge = 0;
        }
      
      $.ajax({
            url: base_url+'checkout/validate_promocode',
            type: 'post',
            data: {promocode:promocode},
            dataType : "json",
            success: function(response) {
               
                $('#promo_err').html(response.message);
                if(response.success == '1'){
                    var orderAmount = parseFloat(response.orderAmount);
                    // finalAmount = (orderAmount + parseFloat(shipping_charge) - parseFloat(response.data)).toFixed(2)
                    finalAmount = (orderAmount + ( shipping_charge === "" ?  0  : parseFloat(shipping_charge) )- parseFloat(response.data)).toFixed(2)
                    // console.log("orderAmount ====" ,orderAmount ,  parseFloat(shipping_charge) ,  parseFloat(response.data))
                    if( $('#totalSaving').length ){
                        var amount = response.data;
                        var promocodeDiscount = parseFloat(response.withoutPromo) + parseFloat(amount);   
                        $('#totalSaving').html(siteCurrency +' '+ promocodeDiscount.toFixed(2));
                    }
                    $('#promoAmount').html((response.data).toFixed(2));

                    $('#checkout_final').html(finalAmount)                        
                    
                    $('.promocode-applied').show();
                    
                    $("#applied_promo").val(promocode);

                }else{
                    $("#applied_promo").val('');
                    $('#checkout_final').html((parseFloat(response.orderAmount)+parseFloat(shipping_charge)).toFixed(2))
                    var promocodeDiscount = parseFloat(response.withoutPromo);
                    $('#totalSaving').html(siteCurrency +' '+ promocodeDiscount.toFixed(2));
                }
            }            
        });

    })
      $('#mobileNumber').validate({
            rules : {
                phoneNumber : { 
                    required : true,
                    number : true,
                    minlength : 6,
                    maxlength : 15,
                },
                country_code : {
                    required : true 
                }
            },
            messages : {
                 phoneNumber : { required : "Please enter valid mobile number",                         
             },
            country_code : {
                required : "Please selecte country code " 
             }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    dataType : "json",
                    success: function(response) {
                        if(response.success == '1'){
                            $('#mobileModal').modal('hide');
                            $('#Otp').modal('show');
                            $('#Otp').modal({ backdrop: 'static', keyboard: false });
                        }else{
                            $('.mobile_verfication').html('This mobile number is linked with another account');
                            $('.mobile_verfication').css('display','block');
                        }
                    }            
                });
            }
        });

        $('#OtpVerification').validate({
            rules : {
                otp : { required : true,
                           number : true,
                           minlength : 4,
                           maxlength : 4,
                },
            },
            messages : {
                 otp : { required : "Please enter 4 digits otp",                         
             },
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    dataType : "json",
                    success: function(response) {
                        if(response.success == '1'){
                            window.location.reload();
                        }else{
                            $('#invalid').css('display','block');
                            setTimeout(function(){
                                $('#invalid').css('display','none');
                            },3000);
                        }
                    }            
                });
            }
        });


// $('#stipeForm').append('<input type="hidden" name="delivery_date" value="df" />');

    var checkOutForm = function () {

        $('#orderPlace').validate({
            rules : {
                paymentOption : { required : true},
                termcondition: { required : true }
            },
            messages : {
                 paymentOption : { required : "Please Select at least one Payment mode",
                         },
                termcondition : { required : 'Please select the term and condition'},
            }
        });
    }

    return {
        //main function to initiate the module
        init : function () {
            checkOutForm();
        },
        
    }
}();