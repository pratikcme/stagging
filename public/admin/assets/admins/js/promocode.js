
var url = $('#url').val();
$(document).ready(function(){
    $('.alert').fadeOut(5000);
});



$('#frmAddEdit').validate({
    rules: {
       
        name:{required:true},
        percentage:{required:true},
        max_use:{required:true},
        min_cart:{required:true},
        start_date:{required:true},
        end_date:{required:true},
    },
    messages : {
      
        name:{required:"Please enter name"},
        percentage:{required:"Please enter percentage"},
        max_use:{required:"Please enter max use"},
        min_cart:{required:"Please enter minimum cart"},
        start_date:{required:"Please enter start date"},
        end_date:{required:"Please enter end date"},
    }, 
    submitHandler: function (form) {
        $('body').attr('disabled','disabled');
        $('#btnSubmit').attr('disabled','disabled');
        $('#btnSubmit').value('please wait');
        $(form).submit();
    }

});


    
$(document).on('click','.delete',function(){
    var id = $(this).val();
    var that = $(this);
    var x = confirm("Are you sure you want to delete?");
        if(x){    
            $.ajax({
                url: url+'admin/about/about_section_two/removeRecord',
                type:'post',
                data:{id:id},
                success:function(output){
                        that.parent().parent().remove();
                }
            })
        }
});
     
    