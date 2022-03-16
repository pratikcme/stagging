var FOOTER = function(){


            $(document).ready(function(){
                $('.alert').fadeOut(5000);
            });
            
        var HandleFooterAdd = function () {
         $('#frmAddEdit').validate({
             ignore: [],
              debug: false,
             // ignore: " :hidden",
            rules: {
                content: {required: true},
                facebook : {required: true},
                twitter : {required: true},
                instagram : {required: true},
                youtube : {required: true}
            },
            messages: {
                content: {required: "Please enter main title"},
                facebook: {required: "Please enter facebook link"},
                twitter: {required: "Please enter twitter link"},
                instagram: {required: "Please enter instagram link"},
                youtube: {required: "Please enter youtube link"},
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
    	init:function(){
    		HandleFooterAdd();
    	}
    }

}();