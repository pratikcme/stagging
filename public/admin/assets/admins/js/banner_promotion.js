 $(document).on('change','#vendor',function (){
    var branch_id = $(this).val();
     var url = $('#url').val();
    $.ajax({
      url : url+'banner_promotion/getVendorsProduct',
      data:{branch_id:branch_id},
      method:'post',
      dataType:'json',
      success:function(output){
        $("#product_list").html(output.product_list);
      }
    })
  })