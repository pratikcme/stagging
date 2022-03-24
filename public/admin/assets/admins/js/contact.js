var CONTACT = function(){


            $(document).ready(function(){
                $('.alert').fadeOut(5000);
            });
            
      var HandleContactInfo = function () {

         $('#frmAddEdit').validate({
             ignore: [],
              debug: false,
             // ignore: " :hidden",
            rules: {
                    image : {
                    required: {depends: function (e) {
                            return ($('#hidden_image').val() === '');
                        },
                    },
                            accept:"jpg,png,jpeg,gif"
                },

                location: { required: function() 
                        {
                         CKEDITOR.instances.location.updateElement();
                        }},
                email: { required: function() 
                        {
                         CKEDITOR.instances.email.updateElement();
                        },
                    },
                phone_no : { required: function() 
                        {
                         CKEDITOR.instances.phone_no.updateElement();
                        }},
               
            },
            messages: {
                image : {required: 'please select image',
                accept:"Only image type jpg/png/jpeg/gif is allowed"},
                location: {required: "Please enter main title"},
                timing: {required: "Please enter about author"},
                phone_no: {required: "Please enter facebook"},
                
            }, 
            submitHandler: function (form) {

                $('body').attr('disabled','disabled');
                $('#btnSubmit').attr('disabled','disabled');
                $('#btnSubmit').value('please wait');
                    $(form).submit();
            }
        
        });

    }

    var HandleUsersMessageList = function(){   

            var url = $('#url').val(); 
              var dataTable = $('#usersMessageList').DataTable({  
                   // "processing":true,  
                   // "serverSide":true,
                   // "order":[],  
                   "columnDefs":[  
                        {  
                             "targets":[0],  
                             "orderable":false,  
                        },  
                   ],  
              }); 
     }

    
    return {
    	init:function(){
    		HandleContactInfo();
    	},
        messagelist:function(){
            HandleUsersMessageList();
        },
    }

}();