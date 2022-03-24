var CONTACT = function(){
	   
	// $(document).ready(function(){
 //        $('.alert').fadeOut(5000);
 //    });
   var  handleContactForm =  function () {
    
        $('#form').validate({
            rules : {
            	fname : { required : true },
                lname : { required : true },
                mobile_no : { required : true,
                            digits:true,
                            minlength : 6,
                            maxlength : 15,
                            },
                email : { required : true,
                          email: true
                         },
                message : { required : true }
            },
            messages : {
            	 fname : { required: "Please enter first name " },
                 lname : { required: "Please enter last name " },
                 mobile_no : { required: "Please enter your phone number",
                               minlength : "Please enter 6 digits mobile number",
                               maxlength : "Please enter 15 digits mobile number",
                            },
                 email : { required : "Please enter email",
                           email : "Please  enter valid email"
                         },
                 message : { required : "Please enter your message" }
            },
            submitHandler: function (form) {
                $('body').attr('disabled','disabled');
                $('#btnSubmit').attr('disabled','disabled');
                $('#btnSubmit').value('please wait');
                    $(form).submit();
            }
        });
   }
    return {
        //main function to initiate the module
        init : function () {
            handleContactForm();
        }
    }
}();