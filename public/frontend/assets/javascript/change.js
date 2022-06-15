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
var CHANGE = function(){

	// $(document).ready(function(){
 //        $('.alert').fadeOut(5000);
 //    });

     $('#ChangeUserPass').validate({
            rules : {
                old_pass : { required : true},
                new_pass : {
                     required : true,
                     // minlength: 6,
                     maxlength: 20   
                },
                confirm_pass: {
                                 required : true,
                                 // minlength: 6,
                                 maxlength: 20,
                                 equalTo: "#password_new"
                    },
            },
            messages : {
                 old_pass : { 
                            required: "Please enter your old password"},
                 new_pass : {
                            required:  "Please enter  your new password",
                            minlength: "Please enter at least 6 charecter",
                            maxlength: "Please select lessthen 20 charecter"
                        },
                 confirm_pass : {
                            required: "Please enter confirm password",
                            minlength: "Please enter at least 6 charecter",
                            maxlength: "Please select less then 20 charecter",
                            equalTo : "Your password does not match" 
                        },

            },
            submitHandler: function (form) {
                $('body').attr('disabled','disabled');
                $('#btnSubmit').attr('disabled','disabled');
                $('#btnSubmit').value('please wait');
                $(form).submit();
            }
        });




    $(".phone").inputFilter(function(value) {
        return /^-?\d*$/.test(value) && (value.length <= "15"); 
    });

   var  handleChangePass =  function () {

        $('#ChangePass').validate({
            rules : {
                profileimage:{
                    accept:"jpg,png,jpeg,gif"
                },
                fname : {required : true },
                lname : {required : true },
                // old_pass : { required : true},
                new_pass : {
                     // required : true,
                     // minlength: 6,
                     maxlength: 20   
                },
                confirm_pass: {
                                 // required : true,
                                 // minlength: 6,
                                 maxlength: 20,
                                 equalTo: "#password"
                    },
                phone : {
                    required : true,
                    minlength : 6,
                    maxlength : 15,
                }
            },
            messages : {
                profileimage:{
                    accept:"Only image type jpg/png/jpeg/gif is allowed",
                },
                fname : { required : "Please enter first name"},
                lname : {required : "Please enter last name" },
                 old_pass : { 
                 		   	required: "Please enter your old password"},
                 new_pass : {
                 			required:  "Please enter  your new password",
                           	minlength: "Please enter at least 6 charecter",
                           	maxlength: "Please select lessthen 20 charecter"
                 		},
                 confirm_pass : {
                 		    required: "Please enter confirm password",
                           	minlength: "Please enter at least 6 charecter",
                           	maxlength: "Please select less then 20 charecter",
                           	equalTo : "Your password does not match" 
                		},
                phone : {
                            required : "Please enter mobile number",
                            minlength: "Please enter at least 6 charecter",
                            maxlength: "Please select less then 15 charecter",
                }

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
            handleChangePass();
        }
    }
}();