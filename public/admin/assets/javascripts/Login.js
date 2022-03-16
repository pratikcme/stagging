var LOGIN = function () {
    $(document).ready(function(){
                $('.alert').fadeOut(5000);
            });
    var HandleLogin = function () {
        $('#frmAddEditSection').validate({
            rules: {
                email: {required: true,
                email: true },
                password : {
                  required: true,
                  minlength : 8,
                  maxlength : 10 
             },
            },
            messages: {
                email: {required: "Please enter email ",
                		email : "Please Enter valid email"
            				},
                password : {required: 'please enter password',
                minlength:"Please enter atleast 8 charecter",
            	maxlength:"Please enter not more than 10 charecter"	
            		},
            }
        
        });
}
    var Handleforgetpassword = function () {

            $('.alert').fadeOut(5000);

        $('#frmAddEditSection').validate({
            rules: {
                email: { required: true,
                            email: true 
                        }
            },
            messages: {
                email: { required : "Please enter email",
                        email : "Please Enter valid email"
                    },
            } 
        
        });
}

    var HandleRegisterForm = function () {

            $('#frmAddEditSection').validate({
                rules: {
                    first_name : { required : true },
                    last_name : { required : true },
                    email: { required: true,
                                email: true 
                            },
                    password:{ required : true,
                                minlength: 8,
                                maxlength: 10   
                                },
                    confirm_password: {
                                 required : true,
                                 minlength: 8,
                                 maxlength: 10,
                                 equalTo: "#password"

                    },
                },
                messages: {
                    first_name:{ required: "Please enter first name" },
                    last_name:{required: "Please enter last name"},
                    email: { required : "Please enter email",
                            email : "Please Enter valid email"
                        },
                    password:{  required: "Please enter password",
                                minlength:"Please enter at least 8 charecter",
                                maxlength:"Please select lessthen 10 charecter"
                    },
                    confirm_password:{
                                required: "Please enter password",
                                minlength:"Please enter at least 8 charecter",
                                maxlength:"Please select lessthen 10 charecter",
                                equalTo : "Your password does not match"  
                    },
                }
            });
    }
    return {
        //main function to initiate the module
        init: function () {
           HandleLogin();
        },
        forget: function () {
            Handleforgetpassword();
        },
        register: function () {
            HandleRegisterForm();
        }
    };
}();