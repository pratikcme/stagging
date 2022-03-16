  var FAQ = function(){

       $(document).ready(function(){
                $('.alert').fadeOut(5000);
            });

      var url = $('#url').val();

    $('.delete').click(function(){
      var id = $(this).val();
      var that = $(this);
      var x = confirm("Are you sure you want to delete?");
                if(x){    
                    $.ajax({
                        url: url+'admin/faq/technical/removeRecord',
                        type:'post',
                        dataType:'json',
                        data:{id:id},
                        success:function(output){
                                that.parent().parent().remove();
                                counter();
                        }
                    })
                }
    })

        function counter(){
            var count = 1 ;
            $('.counter').each(function(){
            var counter = $(this).text();
               var  c = $(this).text(count++); 
            })
        }

  var HandleBannerImage = function () {

            $(document).ready(function(){
                $('.alert').fadeOut(5000);
            });
                
        $('#frmAddEditSection').validate({
             ignore: [],
             // ignore: " :hidden",
            rules: {
                image : {
                    required: {depends: function (e) {
                            return ($('#hidden_image').val() === '');
                        },
                    },
                            accept:"jpg,png,jpeg,gif"
            }},
            messages: {
                image : {required: 'please select image',
                accept:"Only image type jpg/png/jpeg/gif is allowed"},
            },
        
        });
    }

 



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
             // ignore: " :hidden",
            rules: {
                question: {required: true},
                answer: { required: true } 
                },
            messages: {
                question : {required: "Please enter question"},
                answer : {required: "Please enter Answer"},
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
                question: {required: true },
                answer: { required:  true }
                },
            messages: {
                question : {required: "Please enter question"},
                answer : {required: "Please enter answer"}
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