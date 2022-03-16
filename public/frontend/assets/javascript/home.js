$(document).on('click','.addcartbutton', function(){
    var that = $(this);

    // $(this).prop('disabled', true);
    var product_id = $(this).data('product_id');
    var varient_id = $(this).data('varient_id');
    var url = $('#url').val();
    var qnt = $(this).parent().next('div').find('input:text').val();

    var siteCurrency = $('#siteCurrency').val(); // currency is dynamic
    if(qnt == 0){
      alert(0);
      qnt = 1;
      $(this).next('div').find('input:text').val('1');
    //   return false;
    }
     $.ajax({
                url : url+'products/addProducToCart',
                data:{product_id:product_id,qnt:qnt,varient_id:varient_id},
                method:'post',
                dataType:'json',
                success:function(output){
                  that.removeAttr('disabled');
                  if(output.errormsg != ''){
                      swal(output.errormsg);
                      $('.cart-plus-minus-box').val('1');
                    }else if(output.itemExist != ''){
                      swal(output.itemExist);
                        // window.location.href = url+'products/cart_item';
                      // swal('Item Already Added').then((value) => {
                      //   window.open(url+'products/cart_item');
                      // });
                    }
                    // else{
                      
                      if(output.count >= 1 ){
                        that.parent().next('div').removeClass('d-none');
                        that.parent().addClass('d-none');
                        $('#itemCount').css('display','block');
                      }
                      
                      if(output.success != ''){
                        //  $("#backdrop").addClass("backdrop_bg");
                        // $('#pupup_message').css('display','block');
                        //  setTimeout(function() {
                        //       $('#pupup_message').fadeOut('fast');
                        //       $("#backdrop").removeClass("backdrop_bg");
                        //  }, 2000);
                        // swal({
                        //    title: "success",
                        //    text: "Item Added successfully",
                        //    type: "success",
                        //    timer: 2000
                        //  });
                      }
                      $('#nav_cart_dropdown').removeClass("d-none");
                      $('#itemCount').html(output.count);
                      $('#updated_list').html(output.updated_list);
                      $('#nav_subtotal').html(siteCurrency+' '+output.final_total);
                  // }
                }
            })
});