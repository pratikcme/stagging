var RETURN = function(){
         $(document).ready(function(){
                $('.alert').fadeOut(5000);
            });
         
      var url = $('#url').val(); 

    var HandleTable = function(){   

          
            var url = $('#url').val(); 
              var dataTable = $('#faq_customer_support').DataTable({  
                   "order":[],  
                   "columnDefs":[  
                        {  
                             "targets":[0,1],  
                             "orderable":false,  
                        },  
                   ],  
              });  
     }

      var HandleSectionTwoQuestion = function () {

        $('#frmAddEdit').validate({
             // ignore: [],
             //  debug: false,
             // // ignore: " :hidden",
            rules: {
                title: {required: true},
                sub_title: { required: true }
                },
            messages: {
                title : {required: "Please enter title"},
                sub_title : {required: "Please enter sub title"},
            }, 
            submitHandler: function (form) {

                $('body').attr('disabled','disabled');
                $('#btnSubmit').attr('disabled','disabled');
                $('#btnSubmit').value('please wait');
                    $(form).submit();
            }
        
        });

    }

    var HandleSectionTwoQuestionEdit = function () {

        $('#frmAddEdit').validate({
             // ignore: [],
             // ignore: " :hidden",
            rules: {
                title: {required: true},
                sub_title: { required: true }
                },
            messages: {
                title : {required: "Please enter title"},
                sub_title : {required: "Please enter sub title"}
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
        HandleBannerImage();
      },
      table:function(){
        HandleTable();
      },
      add:function(){
        HandleSectionTwoQuestion();
      },
      edit:function(){
        HandleSectionTwoQuestionEdit();
      }
    }

}();