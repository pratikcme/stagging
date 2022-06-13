(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };
}(jQuery));
$(document).ready(function(){
    $('form').attr('autocomplete', 'off');
});

$(document).on('click','.details',function () {
    $('.details').each(function () {
        if(!$(this).hasClass('abc')){
            $(this).find('span').removeClass('rotate-open');
        }
    })
})

$('#country_code').on('change',function() {
    checkNumber();
})
$('#phone').on('blur',function() {

    checkNumber();
})


function checkNumber(){

   var exiting_country = $('#exiting_country').val()
   var exiting_phone =  $('#exiting_phone').val();
   
   var country_code = $('#country_code').val();
   var phone = $('#phone').val()
   if( (country_code != exiting_country)  || (exiting_phone != phone) ){ 
        $("#btnAccSubmit").html('Send OTP');
        $("#btnAccSubmit").addClass('otp');
        $("#btnAccSubmit").attr('type','button');
        console.log('yes')
    }else{
        $("#btnAccSubmit").html('Save');
        $("#btnAccSubmit").removeClass('otp');
        $("#btnAccSubmit").attr('type','submit');
    }
   
}
$(document).on('click','#btnAccSubmit',function(){
     var url = $('#url').val();
    if($(this).hasClass('otp')){
        $('#country_code').prop('readonly',true);
        $('#phone').prop('readonly',true);
        var country_code = $('#country_code').val();
        var phone     = $('#phone').val();  
       
        $.ajax({
            url:url+'users_account/users/sendOtpAccount',
            data:{country_code:country_code,phone:phone},
            type:'post',
            dataType:'json',
            success:function(res){
                if(res.success==1){
                    alert(res.data);
                    $('.varification').show();
            
                    $("#frmBtn").html('varify otp');

                    $("#btnAccSubmit").html('Save');
                    $("#btnAccSubmit").removeClass('otp');
                    $("#btnAccSubmit").attr('type','submit');
                }else{
                    $('#mobileErr').show()
                    $('#mobileErr').html(res.message)
                    $('#country_code').prop('readonly',false);
                    $('#phone').prop('readonly',false);
                    
                }

                
            }
        })
    }

});

var ADDRESS = function(){
	// $(document).ready(function(){
 //    $('.alert').fadeOut(5000);
 //  });
    var url = $('#url').val();

    $(document).on('click','.remove_address',function(){
        var id = $(this).attr('data-id');
        var that = $(this);
        // var x = confirm('Do you really wants to delete this address');
        swal({
          title: "Are you sure ?",
          text: "Do you really wants to delete this address ? Press Ok to delete !",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
              $.ajax({
                      url: url + '/users_account/users/remove',
                      method:'post',
                      data:{id: id },
                      dataType : "json",
                      success:function (output){
                        console.log(output);
                        $('.is_default').each(function(){
                          var add_id =  $(this).attr('data-id');
                            if(add_id == output.result[0].id){
                                $(this).find('input').prop('checked',true);
                            }
                        })
                        that.parent().parent().parent().remove();
                        $('#RegisterForm')[0].reset();  
                    }
              })

          }
        })
    });

    $(document).on('click','.add_form_action',function(){
         $("#departure_address").rules("add", "required");
        $('#RegisterForm').attr('action',url+'users_account/users/add_address');
    })

    $(document).on('keyup','#departure_address',function(){
         $('#departure_latitude').val('');
        $('#departure_longitude').val('');
    })

     $(document).on('change','.is_default',function(){
        var id = $(this).attr('data-id');
        var that = $(this);
        // var x = confirm('would you like to change address');
        // if(x){
              $.ajax({
                      url: url + '/users_account/users/set_default',
                      method:'post',
                      data:{id: id },
                      success:function (output){
                        window.location.reload();
                    }
              })
            // }
            // else{
            //   window.location.reload();
            //   if($(this).find('label .default_check').is(':checked')){
            //     $(this).find('label .default_check').prop('checked',false);
            //   }else{
            //     $(this).find('label .default_check').prop('checked',true);
            //   }
            // }
    });
      errorNone();
     function errorNone(){
       $('label.error').css('display','none');
        // $('.error ').each(function () {
        //     $(this).css('display','none');
        // })
     }

     $(document).on('click','.edit_address',function(){
        var id = $(this).attr('data-id');
        var that = $(this);
        if($('#billing-new-add').length){
          $('#billing-new-add').css('display','block');
          $('#billing-add').css('display','none');
        }else{
          $('#new-address-wrap').css('display','block');
        }
            $.ajax({
                url: url + '/users_account/users/edit',
                method:'post',
                data:{id: id },
                dataType:'json',
                success:function (output){
                    $("#departure_address").rules("remove", "required");
                    $('.fname').val(output.result[0].name);
                    $('.mob_no').val(output.result[0].phone);
                    $('.landmark').val(output.result[0].landmark);
                    $('#city').val(output.result[0].city);
                    $('#state').val(output.result[0].state);
                    $('#country').val(output.result[0].country);
                    $('#pincode').val(output.result[0].pincode);
                    $('#address').val(output.result[0].address);
                    $('#RegisterForm').attr('action',url+'users_account/users/update_address');
                    $('#RegisterForm').append('<input type="hidden" name="update_id" value="'+output.result[0].id+'">');
                
                    $('#departure_address').val(output.result[0].google_location);
                    $('#departure_latitude').val(output.result[0].latitude);
                    $('#departure_longitude').val(output.result[0].longitude);
                }
        })
    });

    $(".mob_no").inputFilter(function(value) {
        return /^-?\d*$/.test(value) && (value.length <= "15"); 
    });

    //  $(".pincode").inputFilter(function(value) {
    //     return /^-?\d*$/.test(value) && (value.length <= "6"); 
    // });

    // $(".fname").inputFilter(function(value) {
    //     return /^[a-zA-Z\s]*$/.test(value) && (value.length <= "25"); 
    // });

    $(document).on('click','.cancel-btn',function (){
        $('#RegisterForm')[0].reset();
        $('#departure_latitude').val('');
        $('#departure_longitude').val('');
          $('.error').each(function () {
              $(this).html("");
          })
        errorNone();
    })
     $(document).on('click','.add_form_action',function (){
        $('#RegisterForm')[0].reset();
        $('#departure_latitude').val('');
        $('#departure_longitude').val('');

    })
   var  handleAddressForm =  function () {
            $('#RegisterForm').validate({
                rules: {
                    fname : { required : true,
                             minlength : 3,
                             maxlength : 25 
                         },
                    phone: { required: true,
                                digits : true,
                                minlength: 7,
                                maxlength: 15
                            },
                    country: { required : true },
                    state : { required : true },
                    city : { required : true },
                    pincode: { required : true
                               // digits: : true,
                             },
                    address : { required : true},
                    location : { required : true},
                },
                messages: {
                    fname:{ required: "Please enter full name" },
                    phone: { required: 'Please enter mobile number',
                             digits: 'Please enter number only',
                             minlength: 'Please enter 6 digit mobile number',
                             maxlength: 'Please enter 15 digit mobile number'
                           },
                    country: { required : "Please enter country" },
                    state : { required : " Please enter state" },
                    city : { required : " Please enter city" },
                    pincode: { required : 'Please enter pincode',
                                // digits : "Please enter digits only",
                            },
                    address : { required : "Please enter your address"},
                    location : { required : "Please select your location"},
                },
                submitHandler :function (form) {
                  var latitude = $('#departure_latitude').val();
                    var longitude = $('#departure_latitude').val();
                    if(latitude == '' && longitude == '' ){
                        swal('Please choose location');
                        return false;
                    }
                  setTimeout(function(){
                      form.submit();
                      $('body').attr('disabled','disabled');
                      $('#addAddress').attr('disabled','disabled');
                      $('#addAddress').value('please wait');
                  },1000);
                }
            });
   }

   $(document).on('keydown',function(e){
    // console.log(e.target.tagName);
     if (e.keyCode == 13 && e.target.tagName != 'BUTTON') {
      e.preventDefault();
      return false;
    }
   })

   //  var  handleEditAddressForm =  function () {

   //          $('#editAddressForm').validate({
   //              rules: {
   //                  fname : { required : true,
   //                           minlength : 3,
   //                           maxlength : 25 
   //                       },
   //                  phone: { required: true,
   //                              digits : true,
   //                              minlength: 10,
   //                              maxlength: 10
   //                          },
   //                  country: { required : true },
   //                  state : { required : true },
   //                  city : { required : true },
   //                  pincode: { required : true,
   //                             minlength: 6,
   //                             maxlength : 6,
   //                             // digits: : true,
   //                           },
   //                  address : { required : true},
   //              },
   //              messages: {
   //                  fname:{ required: "Please enter full name" },
   //                  phone: { required: 'Please enter mobile number',
   //                           digits: 'Please enter number only',
   //                           minlength: 'Please enter 10 digit mobile number',
   //                           maxlength: 'Please enter 10 digit mobile number'
   //                         },
   //                  country: { required : "Please select country" },
   //                  state : { required : " Please enter state" },
   //                  city : { required : " Please enter city" },
   //                  pincode: { required : 'Please enter pincode',
   //                             minlength: "Please enter 6 digit pincode",
   //                             maxlength : "No more than 6 digit pincode",
   //                              // digits : "Please enter digits only",
   //                          },
   //                  address : { required : "Please enter your address"},
   //              }
   //          });
   // }

    var  handleAccountDetail=  function () {
    $(document).ready(function () {

        $('#accountDetail').validate({
            rules : {
                fname : { required : true,
                             minlength: 3,
                             maxlength : 25
                          },
                email : { required : true,
                              email : true
                           },
                phone: {
                                 required : true,
                                 minlength: 10,
                                 maxlength: 10,
                    },
            },
            messages : {
                 fname : { 
                        required: "Please enter your full name ",
                         },
                 email : {
                            required:  "Please enter  your new password",
                            email: "Please enter Your valid email",
                    },
                 phone : {
                            required: "Please enter phone number",
                            minlength: "Please enter at least 10 charecter",
                            maxlength: "Please select less then 10 charecter",
                    },

            },
        });
    })
   }
    return {
        //main function to initiate the module
        init : function () {
            handleAddressForm();
        },
        edit :function () {
            handleEditAddressForm();
        },
        accountdetail : function () {
            handleAccountDetail();
        }
    }
}();