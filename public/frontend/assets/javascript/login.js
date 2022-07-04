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
var LOGIN = function(){
    $('label.error').css('display','none');
    var url = $('#url').val();
    // $(document).ready(function(){
    //   $('.alert').fadeOut(5000);
    // });

     $(".mob_no").inputFilter(function(value) {
        return /^-?\d*$/.test(value) && (value.length <= "15"); 
    });

    //  $(".pincode").inputFilter(function(value) {
    //     return /^-?\d*$/.test(value) && (value.length <= "6"); 
    // });

    // $(".name").inputFilter(function(value) {
    //     return /^[a-zA-Z\s]*$/.test(value) && (value.length <= "25"); 
    // });

    // $(".state").inputFilter(function(value) {
    //     return /^[a-zA-Z]*$/.test(value) && (value.length <= "10"); 
    // });

    // $(".city").inputFilter(function(value) {
    //     return /^[a-zA-Z]*$/.test(value) && (value.length <= "15"); 
    // });

    // // last name for sign up
    // $(".lname").inputFilter(function(value) {
    //     return /^[a-zA-Z\s]*$/.test(value) && (value.length <= "15"); 
    // });

	var HandleRegisterForm = function () {
        $('#RegisterForm').attr('autocomplete', 'off');
            $('#RegisterForm').validate({
                rules: {
                    fname: { required: true,},
                    lname: { required: true,},
                    country_code : { required : true },
                    phone: { required: true,
                             number: true,
                             minlength: 6,
                             maxlength: 15,
                             remote:{ 
                              url: url+"login/verify_mobile",
                              type: "POST",
                              data: {
                                  country_code : function() {
                                    return $( "#country_code" ).val();
                                },
                            },
                          },
                      },
                    email: { required: true,
                             email: true,
                             remote:{ 
                              url: url+"login/verify_email",
                              type: "POST",
                            }
                          },
                    password:{ required : true,
                                minlength: 6,
                                maxlength: 20   
                                },
                    confirm_password: {
                                 required : true,
                                 minlength: 6,
                                 maxlength: 20,
                                 equalTo: "#password"

                    },
                    term_policy : {required : true}
                },
                messages: {
                    email: { 
                            required : "Please enter email",
                            email : "Please Enter valid email",
                            remote: "This email is already exist"
                        },
                    fname : {required : "Please enter first name"},
                    lname : {required : "Please enter last name"},
                    phone : {
                        required : "Please enter valid mobile number",
                        number: "Please enter valid mobile number",
                        minlength: 'Please enter minimum 6 digits',
                        maxlength: "Please enter maximum 15 digits",
                        remote: "This mobile number is already exist"
                    },
                    country_code : { required : 'Please select country code'},
                    password:{  required: "Please enter password",
                                minlength:"Please enter at least 6 character",
                                maxlength:"Please select less-than 10 character"
                    },
                    confirm_password:{
                                required: "Please enter confirm password",
                                minlength:"Please enter at least 6 character",
                                maxlength:"Please select less-than 10 character",
                                equalTo : "Your password does not match"  
                    },
                    term_policy : { required :"Please accept Terms of conditions and Privacy Policy" }
                }
            });
    }
    
    var handleLoginForm = function () {

        $('#LoginForm').validate({
            rules : {
                email : { required : true,
                          email: true
                         },
                password : { required : true,
                        },
            },
            messages : {
                 email : { required : "Please enter email",
                           email : "Please  enter valid email"
                         },
                password : { required : 'Please enter password',
                        },
            }
        });
    }
   var  handleForgetPass =  function () {
    
        $('#ForgetForm').validate({
            rules : {
                email : { required : true,
                          email: true
                         },
            },
            messages : {
                 email : { required : "Please enter email",
                           email : "Please  enter valid email"
                         },
            }
        });
   }
    return {
        //main function to initiate the module
        init : function () {
            HandleRegisterForm();
        },
        login : function () {
            handleLoginForm();
        },
        forget: function () {
            handleForgetPass();
        }
    }
}();