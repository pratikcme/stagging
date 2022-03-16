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

var PRIVACY = function(){
   $(document).ready(function(){
    $('.alert').fadeOut(5000);
  });
   var url = $('#url').val();  

   $(document).on('keyup','#search_prod',function (){
      var keyValue = $(this).val();
      // setTimeout(function () {
        if(!$.isNumeric(keyValue) || ($.isNumeric(keyValue) && keyValue.length == 13)){
        	$.ajax({
        		url : url +'sell_development/findProductBykey',
        		type : "POST",
        		dataType : "JSON",
        		data : {
        			keyValue:keyValue,
        		},
        		success:function (output){

        		if(keyValue == ''){
               $('#prod-list').html(" ");
               $('#prod-list').css('display','none');
             }else{
               $('#prod-list').css('display','block');
        			 $('#prod-list').html(output.res);
             }
              // if($.isNumeric(keyValue) && keyValue.length == 13){
              //    $( ".add_product" ).click();
              // }
        		}
        	})
        }
      // },1000);
   });

   $(document).on('change','#search_prod',function () {
        var keyValue = $(this).val();
         if($.isNumeric(keyValue) && keyValue.length == 13){
            $.ajax({
            url : url +'sell_development/findProductBykey',
            type : "POST",
            dataType : "JSON",
            data : {
              keyValue:keyValue,
            },
            success:function (output){
              if(keyValue == ''){
                $('#prod-list').html(' ');
                $('#prod-list').css('display','none');
              }else{
                $('#prod-list').html(output.res);
                $('#prod-list').css('display','block');
              }
              if($.isNumeric(keyValue) && keyValue.length == 13){
                 $( ".add_product" ).click();
                 $('#prod-list').css('display','none');
                 $('#search_prod').val('');
                 $('#prod-list').html('');
              }
            }
          })
        }
   })


    $(document).on('click','.add_product',function (){
      $('.overlay').css('display', 'block');
      var product_id = $(this).data('product_id');
      var pw_id = $(this).data('pw_id');
      var isParked = $('#isParked').val();
      // setTimeout(function () {
      	$.ajax({
      		url : url +'sell_development/addProducttoTempOrder',
      		type : "POST",
      		dataType : "JSON",
      		data : {
      			product_id:product_id,
      			pw_id:pw_id,
            isParked : isParked

      		},
      		success:function (output){
               // $('#search_prod').val('');
               $('.overlay').css('display', 'none');
                if(output.status == 0){               
                   bootbox.alert("Product is not available", function () {
                     // window.location.reload(true);
                  });
                }
               if(output.status == 1){
                  // $(output.result).insertAfter('#selected_customber');
                  $('.old_list').remove();
                  $('#selected_customber').after(output.result);
                  $('#subtotal').html(output.subtotal);
                  // $('#discount_total').html(output.total_discount);
                  $('#total_gst').html(output.total_gst);
                  calculate_disc_percentage();
               }
              displayBlock(output.count);
               $('#prod-list').css('display','none');
                 $('#search_prod').val('');
                 $('#prod-list').html('');
      		}
      	})
      // },1000);
   });

    $(document).on('click','.add_quick_product',function (){
      $('.overlay').css('display', 'block');
      var product_id = $(this).data('product_id');
      var pw_id = $(this).data('pw_id');
      var isParked = $('#isParked').val();
      // setTimeout(function () {
        $.ajax({
          url : url +'sell_development/addProducttoTempOrder',
          type : "POST",
          dataType : "JSON",
          data : {
            product_id:product_id,
            pw_id:pw_id,
            isParked : isParked

          },
          success:function (output){
               // $('#search_prod').val('');
               $('.overlay').css('display', 'none');
                if(output.status == 0){               
                   bootbox.alert("Product is not available", function () {
                     // window.location.reload(true);
                  });
                }
               if(output.status == 1){
                  // $(output.result).insertAfter('#selected_customber');
                  $('.old_list').remove();
                  $('#selected_customber').after(output.result);
                  $('#subtotal').html(output.subtotal);
                  // $('#discount_total').html(output.total_discount);
                  $('#total_gst').html(output.total_gst);
                  calculate_disc_percentage();
               }
              displayBlock(output.count);
          }
        })
      // },1000);
   });

    function displayBlock(parm){
      if(parm > 0){
        var css = 'block';
      }else{
       var css = 'none';
     }
     $('#parked_sell').parent().css('display',css);
     $('#discard_sell').parent().css('display',css);
   }

    $(document).on('keyup','#add_customer',function (){
      var customber = $(this).val(); 
         if(customber ==''){
             $('#set_customer').val('');
             $('.select_customer').html('');
         }
      // setTimeout(function () {
      	$.ajax({
      		url : url +'sell_development/searchCustomber',
      		type : "POST",
      		dataType : "JSON",
      		data : {
      			customber:customber
      		},
      		success:function (output){
      			// $('#insertBefore').before(output.result);
      			$('#message').html(output.result);
      		}
      	})
      // },1000);
   });

   $(document).on('click','.select_customer',function (){
      var customber_id = $(this).data('customer_id'); 
      var customber_name = $(this).find('a 	div.list-items h4').html();
      $('#add_customer').val(customber_name);
      // setTimeout(function () {
      	$.ajax({
      		url : url +'sell_development/searchforAdd',
      		type : "POST",
      		dataType : "JSON",
      		data : {
      			customber_id:customber_id
      		},
      		success:function (output){
      			$('#selected_customber').html(output.result);
               $('#set_customer').val(customber_id);
      		}
      	})
      // },1000);
   });

   $(document).on('click','.revomeRecord',function (){
        var order_tempId =  $(this).data('order_tempid');
        var isParked = $(this).data('isparked');
        var that = $(this);
         $.ajax({
            url : url +'sell_development/removeRecord',
            type : "POST",
            dataType : "JSON",
            data : {
               order_tempId:order_tempId,
               isParked:isParked
            },
            success:function (output){
               if(output.status == '1'){
                  that.parent().parent().parent().remove();
                  var final_subtotal = calculateSubtotal();
                  $('#subtotal').html(final_subtotal);
                  $('#discount_total').html(output.total_discount);
                  $('#total_gst').html(output.total_gst);
                  calculate_disc_percentage();
               }
              displayBlock(output.count);
            }
         })
   })

    // $(".qunt").inputFilter(function(value) {
    //     return /^[+]?([0-9]+(?:[\.][0-9]*)?|\.[0-9]+)$/.test(value); 
    // });

   $(document).on('change','.qunt',function (){
      var qunt = $(this).val();
      var product_weight_id = $(this).data('product_weight_id');
      var isParked = $(this).data('isparked');
      var temp_id = $(this).data('temp_id');
      var check = Math.sign(qunt);
      var actual_discount_price = $(this).data('actual_discount_price');
      // alert(actual_discount_price);
      if(qunt == '0' || check == -1 || qunt == ''){
        qunt = 1;
      }
      var that = $(this);
      var current_price = $(this).parent().next().next().find('.sub_total').text();
       if (qunt == '0' || check == -1) {
           var qunt = '1';
           that.val(qunt);
           var change_price = qunt * current_price;
           $(this).parent().next().next().find('.sub_total').html(change_price.toFixed(2));
       }else{
           $.ajax({
            url : url +'sell_development/add_quantity',
            type : "POST",
            dataType : "JSON",
            data : {
              product_weight_id:product_weight_id,
              temp_id:temp_id,qunt:qunt,
              actual_discount_price : actual_discount_price,
              isParked:isParked

            },
            success:function (output){
              if(output.status == 0){
               bootbox.alert("Product is not available", function () {});
             }
             that.val(output.exist_quantity);
             that.parent().next().next().find('.sub_total').html(output.exist_price);
             that.parent().parent().prev().find('.this_quantity').html(output.exist_quantity);
             var final_subtotal = calculateSubtotal();
             $('#subtotal').html(final_subtotal);
             $('#total_gst').html(output.total_gst);
             calculate_disc_percentage();
           }
         })
       }
   });


   $(document).on('keyup','.disc',function (){
        var discount = $(this).val();
        var temp_id = $(this).data('temp_id');
        var isParked = $(this).data('isparked');
        var product_weight_id = $(this).data('product_weight_id');
        var quantity = $(this).parent().prev().find('.qunt').val();
        var actual_discount_price = $(this).data('actual_discount_price');
        var that = $(this);
        if(discount >= 100){
            $(this).next('span').html("discount must be less than 100%");
            return false;
        }else if(Math.sign(discount) == -1){
          $(this).next('span').html("discount value not be minus");
            return false;
        }else{
          if(discount != ''){
          $(this).next('span').html("");
            $.ajax({
              url : url +'sell_development/update_quantity',
              type : "POST",
              dataType : "JSON",
              data : {
                product_weight_id:product_weight_id,
                discount:discount,temp_id:temp_id,
                quantity:quantity,actual_discount_price:actual_discount_price,
                isParked:isParked
              },
              success:function (output){
                if(output.status==1){
                  that.parent().next().find('.sub_total').html(output.updated_price);
                  calculate_disc_percentage();
                }
               // that.val(output.exist_quantity);
               // that.parent().parent().prev().find('.this_quantity').html(output.exist_quantity);
               // var final_subtotal = calculateSubtotal();
               // $('#subtotal').html(final_subtotal);
               // $('#total_gst').html(output.total_gst);
             }
           })
          }
        }
   })

   //  $('#disc_percentage').keyup(function () {
   //     var disc = $(this).val();
   //     if (disc > 99) {
   //         $(this).val("");
   //         $(this).next('label').html("Discount must be less than 100%");
   //         // $('#span_pay').css("display","none");
   //     }else if(Math.sign(disc) == -1){
   //          $(this).val("");
   //         $(this).next('label').html("Discount value not be minus");
   //     } else {
   //         $(this).next().html("");
   
   //     }
   // })

   $(document).on('keyup','#add_search_prod',function () {
        var keyValue = $(this).val();
        var from = 'quick_keys';
        if(!$.isNumeric(keyValue) || ($.isNumeric(keyValue) && keyValue.length == 13)){
          $.ajax({
            url : url +'sell_development/findProductBykey',
            type : "POST",
            dataType : "JSON",
            data : {
              keyValue:keyValue,
              from : from
            },
            success:function (output){
              if(keyValue == ''){
                $('#add-prod-list').css('display','none');
              }else{
                $('#add-prod-list').css('display','block');
              }
              $('#add-prod-list').html(output.res);
            }
          })
        }
   })

   $(document).on('click','#quick_keys',function () {
        $('#add_search_prod').val('');
        $('#add-prod-list').html('');
        $('#product_quick_list').html('');
   })

    $('#discard_sell').click(function () {
       $.ajax({
           method: "post",
           url: url+'sell_development/update_same_as_qnt',
           success: function () {
               window.location.reload();
           }
       });
   });

    $(document).on('click','.quick',function () {
          var product_id = $(this).data('product_id');
          var pw_id = $(this).data('pw_id');

         $.ajax({
             type: "post",
             dataType : 'JSON',
             url: url +'sell_development/quickList',
             data : { product_id:product_id, pw_id:pw_id },
             success: function (output) {
                $('#product_quick_list').append(output.list);
                $('#add-prod-list').css('display','none');
                $('#add_search_prod').val('');
             }
         });
   });

   $('.remove_quick_list_item').click(function() {
      var pw_id = $(this).data('pw_id');
      var that = $(this);
        $.ajax({
             type: "post",
             dataType : 'JSON',
             url: url +'sell_development/RemoveQuickListItem',
             data : {pw_id:pw_id },
             success: function (output) {
                  if(output.status){
                      that.parent().remove();
                  }else{
                     bootbox.alert("Something Went Wrong", function () {});
                  }
             }
         });
   }) 

    $('#SubmitQuickList').click(function (){
        var varientList = [];
        $('.product_quick_list').each(function () {
          var product_weight_id = $(this).data('product_weight_id');
          if($.inArray(product_weight_id, varientList)== -1 ) {
              varientList.push(product_weight_id);
          }
        })
        $('#quick-keys').css('display','none');
         $.ajax({
             type: "post",
             dataType : 'JSON',
             url: url +'sell_development/MakeQuickList',
             data : { varientList:varientList },
             success: function (output) {
                window.location.reload();
             }
         });

    })
  
    $('#discard_parked_sell').click(function () {
   
       var id = $('#parked_id').val();
       $.ajax({
           type: "post",
           url: url +'sell_development/discard_parked_order',
           data: {'id': id},
           success: function () {
               location.href = url+'sell_development';
           }
       });
   });

   $(document).on('keyup','#disc_percentage',function(){
         var disc = $(this).val();
       if (disc > 99) {
           $(this).val("");
           $(this).next('label').html("Discount must be less than 100%");
           // $('#span_pay').css("display","none");
       }else if(Math.sign(disc) == -1){
            $(this).val("");
           $(this).next('label').html("Discount value not be minus");
       } else {
           $(this).next().html("");
          var extra_discount = calculate_disc_percentage();
          // $('#hidden_discount_total').val(extra_discount.toFixed(2));
          // var subtotal = calculateSubtotal();
          // var pay_total = subtotal - extra_discount;           
          // $('#hidden_total_pay').val(pay_total.toFixed(2));
          // $('#paypal_amount').val(pay_total.toFixed(2));
       }

   })

    calculate_disc_percentage();
   function calculate_disc_percentage(){
        var sub_total = calculateSubtotal();
        if(sub_total == 0){
          $('#span_pay').addClass('hide');
        }else{
          $('#span_pay').removeClass('hide');
        }
        var disc_percentage = $('#disc_percentage').val();
        if(disc_percentage == ''){
          disc_percentage = 0;
        }

        var  extra_discount = (sub_total * disc_percentage) / 100;

        $('#discount_total').html(extra_discount.toFixed(2));
        var pay_total = sub_total-extra_discount;
        $('#total_pay').html(pay_total.toFixed(2));
        $('#hidden_subtotal').val(sub_total);
        $('#hidden_total').val(sub_total);


        $('#hidden_discount_total').val(extra_discount.toFixed(2));
        $('#hidden_total_pay').val(pay_total.toFixed(2));
        $('#paypal_amount').val(pay_total.toFixed(2));
        return extra_discount;
        
   }  
   function calculateSubtotal(){
      var sub_total = 0;
      $('.sub_total').each(function (){
           sub_total += parseFloat($(this).text());
      })
      var final_subtotal =  sub_total.toFixed(2);
      $('#subtotal').html(final_subtotal);
      return final_subtotal;

   }
   // calculateSubtotal();

   $(".mobile").inputFilter(function(value) {
        return /^-?\d*$/.test(value) && (value.length <= "15"); 
    });
   $(document).on('click','#btn_add_cust',function (){
      $('.form-control').each(function (){
          $(this).next().html('');        
      })
      $('#customer_form')[0].reset();
   })

   $('#customer_form').validate({
       rules: {
           customer_name:{required:true},
           customercode:{required:true},
           email:{
            required:true,
            email:true,
            remote: {
                url: url+'sell_development/isAvailable',
                type: 'post',
           }
         },
           mobile:{
            required: true,
            minlength : 7,
            maxlength : 15,
             remote: {
                url: url+'sell_development/isAvailable',
                type: 'post',
            }
           }
      },
       messages: {
         customer_name:{required:"Please enter name"},
         customercode:{required:'customercode can not be empty'},
         email:{
          required:"Please enter email",
          email:"Please ener valid email",
          remote : "Email already exist"
        },
        mobile:{
          required: "Please enter your mobile number",
          remote : "Mobile number already exist"
        } 
       },
       submitHandler:function(form){
        $('body').attr('disabled','disabled');
        $('#btnSubmit').attr('disabled','disabled');
        $('#btnSubmit').value('please wait');
        form.submit();
       }
       
   });

}();