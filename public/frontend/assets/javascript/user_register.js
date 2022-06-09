 var url = $('#url').val();
  
   $("#completeProfile").hide();
   $("#completeOTP").hide();
$('#Register_Form').validate({
    rules: {
        fname: { required: true,},
        otp: { required: true,},
        lname: { required: true,},
        phone: { required: true,
                 number: true,
                 minlength: 6,
                 maxlength: 15,
              
              },
      
    },
    messages: {
        otp: { required: "Please enter otp"},
       
        fname : {required : "Please enter first name"},
        lname : {required : "Please enter last name"},
        phone : {
            required : "Please enter valid mobile number",
            number: "Please enter valid mobile number",
            minlength: 'Please enter minimum 6 digits',
            maxlength: "Please enter maximum 15 digits",
        },
       
    }
});
$("#resend").click(function(){
  var country_code = $('#country_code').val();
    var phone     = $('#phone').val();  
    i = 60; 
    $.ajax({
        url:url+'login/sendOtpLogin',
        data:{country_code:country_code,phone:phone},
        type:'post',
        dataType:'json',
        success:function(res){
          if(res.success==1){
               // $("#country_code").attr('disabled',true);
              //  $("#phone").attr('disabled',true);
             
          }
        }
    })
})
$("#frmBtn").click(function(){
    if($('#Register_Form').valid()){
        var that     = $(this);   

        that.html("Please wait...");
        
        if($(this).hasClass("send")){
            var country_code = $('#country_code').val();
            var phone     = $('#phone').val();   
            $.ajax({
                url:url+'login/sendOtpLogin',
                data:{country_code:country_code,phone:phone},
                type:'post',
                dataType:'json',
                success:function(res){
                  if(res.success==1){
                        //$("#country_code").attr('disabled',true);
                        //$("#phone").attr('disabled',true);
                        that.removeClass("send");
                        that.addClass("varify");
                        that.html("varify otp");
                        $("#completeOTP").show();
                      
                  }
                }
            })
        }else if($(this).hasClass('varify')){
            var country_code = $('#country_code').val();
            var phone     = $('#phone').val();   
            var otp     = $('#otp').val();   
             $.ajax({
                url:url+'login/varifyOtpLogin',
                data:{country_code:country_code,phone:phone,otp:otp},
                type:'post',
                dataType:'json',
                success:function(res){
                  if(res.success==1){
                   
                    $("#resend").hide();
                    $("#resetcounter").hide();

                    if(res.fname!=''){
                        window.location.href = window.location.href; 
                        return true;
                    }
                    $("#otp").attr('disabled',true);
                    $("#completeProfile").show();
                    $('.varify-error').html('');
                    $('.varify-error').hide();
                    $("#user_id").val(res.user_id);
                    that.removeClass("varify");
                    that.addClass("complete");
                    that.html("Complete Profile");


                  }else{
                    $('.varify-error').show();
                    $('.varify-error').html('Invalid OTP');
                     that.html("varify otp");
                  }
                }
            })
        }else if($(this).hasClass('complete')){
            var user_id = $('#user_id').val();
            var fname = $("#fname").val();
            var lname = $("#lname").val();
            var email = $("#email").val();
             
             $.ajax({
                url:url+'login/completeProfile',
                data:{user_id:user_id,fname:fname,lname:lname,email:email},
                type:'post',
                dataType:'json',
                success:function(res){
                  if(res.success==1){
                   window.location.href = window.location.href; 


                  }
                }
            })
        }
    }
})

