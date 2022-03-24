var CONFIRM = function () {
    var HandleConfirmPassword = function () {  
        
       $('#FrmchangePassword').validate({
        rules:{
            old_password:{ required:true,
                            minlength: 8,},
            password:{required:true,
            		minlength: 8
            	},
            confirm_password: {
		            required: true,
		            minlength: 8,
		            equalTo: "#password"
        }},
        messages:{
            old_password:{required : "Please enter old password",
                        minlength:   "Please enter minmum 8 digit password"},
            password:{required : "Please enter new password",
        			  minlength : "Please enter minmum 8 digit password"
        			},
            confirm_password:{ required : "Please enter confirm password",
            		       minlength : "Please enter minmum 8 digit password",
            		       equalTo : "Your password does not match"
            	 }
        }
       });
  
}
    return {
        //main function to initiate the module
        init: function () {
           HandleConfirmPassword();
        },
    };
}();