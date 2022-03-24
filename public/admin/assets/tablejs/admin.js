$('#queryForm').validate({
	  rules: {
            subject: {
                required: true,
            },
            message: {
                required: true,
                maxlength : 600,
            }
        },
        messages : {
        	subject: {
                required: "Please enter subject",
            },
            message: {
                required: "Please enter your message",
            }
        },
        submitHandler: function (form) {
        	$('body').attr('disabled','disabled');
        	$('#btnSubmit').attr('disabled','disabled');
        	$('#btnSubmit').value('please wait');
        	$(form).submit();
        }
})

