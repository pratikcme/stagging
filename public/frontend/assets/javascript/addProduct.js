 function productDetail(){  
$('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  asNavFor: '.slider-for',
  dots: true,
  infinite:true,
  centerMode: false,
  // margin:25,
  focusOnSelect: true,
  responsive:[
  {
      breakpoint: 425,
      settings:{
        slidesToShow:2
      }
  },
  {
      breakpoint: 575,
      settings:{
        slidesToShow:3
      }
  },
  {
      breakpoint: 768,
      settings:{
        slidesToShow:3
      }
  }
  ]
});
}

// //back button to refresh page
// if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
//     window.location.reload();
// }

$('.slider-for').on('afterChange', function(event, slick, currentSlide, nextSlide){
  $(".slide-img").removeClass('demo-trigger');
  setTimeout(function(){
    $(".slick-slide.slick-current.slick-active .slide-img").addClass("demo-trigger"); 
    zommFun();   
  },300);

});

function zommFun(){

  var demoTrigger = document.querySelector('.demo-trigger');
  var paneContainer = document.querySelector('.detail');
  new Drift(demoTrigger, {
    paneContainer: paneContainer,
    inlinePane: false,
  });
}



  $( ".product-slider" ).mouseenter(function() {
    $(".product-detail-wrapper .detail").removeClass("z-0");
    $(".product-detail-wrapper .detail").addClass("z-9");
  });

  
  $(".product-slider" ).mouseleave(function() {
    $(".product-detail-wrapper .detail").addClass("z-0");
    $(".product-detail-wrapper .detail").removeClass("z-9");
  }); 


var ADDPRODUCT = function(){
  // $(document).ready(function(){
  //       $('.alert').fadeOut(5000);
  // });

  zommFun();
  
  var siteCurrency = $('#siteCurrency').val(); // global currency declare 

    $(document).on('click','#addtocart',function(){
      var siteCurrency = $('#siteCurrency').val();
        var qnt = checkNotNull('qnt');
        var url = $('#url').val();
        
        if(qnt <= 0 || qnt == '' || qnt == '-0' || qnt == '+0' || qnt == 'NaN'){
          $('#qnt').val('1');
          // swal('please select valid qnt');
          // return false;
          qnt = 1;
        }

        var varient_id =  checkNotNull('product_varient_id');
        var product_id =  checkNotNull('product_id');
      $.ajax({
          // url: url+'products/addtocart',
          url: url+'add_to_card/addProducToCart',
          method:'post',
          dataType:'json',
          data: {qnt:qnt,varient_id:varient_id,product_id:product_id},
          success:function(output){
            $('#updated_list').html(output.updated_list);
            $('#nav_subtotal').html(siteCurrency+' '+output.cartTotal);

            if(output.errormsg != ''){
                swal(output.errormsg);
                $('.cart-plus-minus-box').val('1');
            }else if(output.itemExist != ''){
              swal(output.itemExist).then((value) => {
                  // window.location.href = url+'products/cart_item';
              });
            }else{
              $('#nav_cart_dropdown').removeClass("d-none");
                window.location.href = url+'products/productDetails/'+product_id+'/'+output.enc_product_variant_id;

                // setTimeout(function() {
                //     // $("#backdrop").removeClass("backdrop_bg");
                //     // $('#pupup_message').fadeOut('fast');
                //   }, 500);
            }            
          }
        })
      })

     $(document).on('click','#order_now',function(){
        var qnt = checkNotNull('qnt');
        var url = $('#url').val();
        if(qnt <= 0 || qnt == '' || qnt == '-0' || qnt == '+0' || qnt == 'NaN'){
          $('#qnt').val('1');
          swal('please select valid qnt');
          return false;
        }
        var varient_id =  checkNotNull('product_varient_id');
        var product_id =  checkNotNull('product_id');

      $.ajax({
          url: url+'add_to_card/addProducToCart',
          method:'post',
          dataType:'json',
          data: {qnt:qnt,varient_id:varient_id,product_id:product_id},
          success:function(output){
            if(output.errormsg != ''){
              swal(output.errormsg);
              $('.cart-plus-minus-box').val('1');
            }else if(output.itemExist != ''){
              window.location.href = url+'checkout';
            }else{
              window.location.href = url+'checkout';            
            }
          }
        })
      }) 

    function checkNotNull(id_name){
       return $('#'+id_name).val();
    }

    $(document).on('change','#qnt',function (){
        var q = $(this).val();
        if(q <= 0  || q == '-0' || q == '+0' || !$.isNumeric(q) ){
          $('.btn').attr('disabled','disabled');
          $('#order_now').attr('disabled','disabled');
        }else{
          $('.btn').removeAttr('disabled','disabled');
          $('#order_now').removeAttr('disabled','disabled');
        }
    }) 
    $(document).on('click','.decqnt',function (){
        var q = $(this).next('input').val();
        if(q <= 0 || q == '+0'||  !$.isNumeric(q)){
          // $('.btn').attr('disabled','disabled');
          $('#order_now').attr('disabled','disabled');
        }
    }) 
    $(document).on('click','.incqnt',function (){
        var q = $(this).prev('input').val();
        if(q > 0 || $.isNumeric(q)){
          $('.btn').removeAttr('disabled','disabled');
           $('#order_now').removeAttr('disabled','disabled');
        }else{
            $('.btn').attr('disabled','disabled');
            $('#order_now').attr('disabled','disabled');
        }
    })

    $(document).on('click','.product_varient_id',function(){
      
      var product_varient_id = $(this).data('varient_id');
      var url = $('#url').val();
      var that = $(this);
      $('#product_varient_id').val(product_varient_id);//update hidden field
      if(product_varient_id != ''){
        $('.weight-error').html('');
        
        $.ajax({
            url: url+'products/getDataProductWeight',
            method:'post',
            data: {product_varient_id:product_varient_id},
            dataType:'json',
            success:function(output){
              // alert(output.discount_price);
              $('.product-price').html('<p>'+siteCurrency+' '+output.discount_price+'<span class="orginal-price">'+siteCurrency+' '+output.product_price+'</span></p>');
              // $('.slider-for').html(output.image_div);
              
              $('.product-slider .slider-for').slick('unslick');
              $('.product-slider .slider-nav').slick('unslick');
              $('.product-slider .slick-slide').remove();
                $('.slider-nav').html(output.image_div);
                $('.slider-for').html(output.image_div_for);
                $('.slider-for').slick("reinit");
                $('.slider-nav').slick("reinit");
                productDetail();
                zommFun();

              if(output.discount_per == '0'){
                $('#is_discounted').html('<div class=""><p></p></div> <div class="wishlist-icon" style="display:none"> <i class="far fa-heart '+output.isInWishList+'"></i> </div>');   
                $('.orginal-price').css('display','none');
              }else{
                $('#is_discounted').html('<div class="offer-wrap"><p>'+output.discount_per+' % off</p></div> <div class="wishlist-icon" style="display:none"> <i class="far fa-heart '+output.isInWishList+'"></i> </div>');
                $('.orginal-price').css('display','');
              }
              if(output.varient_quantity > 25){
                $('.in-stock').remove();
                $('<div class="in-stock"><h6>Available(Instock)</h6></div>').insertBefore('#product_detail h1');
              }else{
                 $('.in-stock').remove();
                  $style = '';
                 if(output.varient_quantity <= 0){
                    $style = 'none'; 
                 }
                 $('<div class="in-stock" style="display:'+$style+'" ><h6>Limited Stock</h6></div>').insertBefore('#product_detail h1');
              }
              if(output.cartProductQuantity == 0){
                var qnt = 1;
                that.parent().next('div').find('.quantity-wrap').addClass('d-none');
                that.parent().next('div').find('.order-btn').find('a:first').removeClass('d-none');
                that.parent().next('div').find('.quantity-wrap .decqnt').attr('data-product_weight_id',output.product_weight_id);
                that.parent().next('div').find('.quantity-wrap .incqnt').attr('data-product_weight_id',output.product_weight_id);
              }else{
                that.parent().next('div').find('.quantity-wrap').removeClass('d-none');
                that.parent().next('div').find('.order-btn').find('a:first').addClass('d-none');
                that.parent().next('div').find('.quantity-wrap .decqnt').attr('data-product_weight_id',output.product_weight_id);
                that.parent().next('div').find('.quantity-wrap .incqnt').attr('data-product_weight_id',output.product_weight_id);
                var qnt = output.cartProductQuantity;
              }
               $('#qnt').val(qnt);
              $('#product_weight_id').val(output.product_weight_id);

            }
        })
     }else{
      $('#weight_no').html('');
     }
  })

      $(document).on('change','#review',function(){
          var review = $(this).val();
          if(review != ''){
            $('.error').html('');   
          }else{
            $('.error').html('please enter product review');   
          }
      })


      $(document).on('click','#btnSubmit',function(){
        event.preventDefault();
        var that = $(this);
        var session_user_id = $(this).data('user_session_id');
        var ratting = $('#selectRetting').data('index');
        if(typeof(ratting) == 'undefined'){
            ratting = 0; 
        }else{
           ratting = ratting + 1;
        }
        
        var review_user_id =[];
        $('.revew_user_id').each(function(){
            var user_id = $(this).val();
            review_user_id.push(user_id);
        })
        var review = $('#review').val();
        var action = $('#reviewForm').attr('action');
        var product_id = $('#product_id').val();
         // console.log(review_user_id);
        // return false;
      if(review != ''){
      
       $.each(review_user_id, function(key,value){
            if(value == session_user_id){
                var base_url = $('#url').val();
                action = base_url +'products/productreviewupdate';
                $('.post_review'+session_user_id).remove();

                // swal("Sorry you can not review multiple time");
            }
       })

            $.ajax({
                    url: action,
                    type: 'post',
                    data: { product_id : product_id,review:review,ratting:ratting},
                    dataType:'json',
                    success:function(output){
                      $('.append_review').append(output.html);
                      $('#reviewForm').trigger('reset');
                      var j = 0;
                      $('.ratted'+output.user_id).each(function(){
                        if(output.ratting == j){
                          return false;
                        }else{
                          $(this).removeClass('far');
                          $(this).addClass('fa');
                        }
                        j++;
                      });
                      $('.change_title').html('Update')
                      swal('Thanks For Your Review');
                      // window.location.reload();

                    }
                }) 

        }else{
         $('.error').html('please enter product review');
        }
      })

 // 
      
    
    
        var ratedIndex = -1, uID = 0;

        $(document).ready(function () {
            resetStarColors();

            // if (localStorage.getItem('ratedIndex') != null) {
            //     setStars(parseInt(localStorage.getItem('ratedIndex')));
            //     uID = localStorage.getItem('uID');
            // }

            $('.ratting').on('click', function () {
               ratedIndex = parseInt($(this).data('index'));
               // localStorage.setItem('ratedIndex', ratedIndex);

                 var i = 0;
                  $('.ratting').each(function(){
                      if(ratedIndex == i){
                      $(this).attr('id','selectRetting');
                          
                      }else{
                        $(this).removeAttr('id','selectRetting');
                      }
                      i++;
                  })
               // saveToTheDB();
            });

            $('.ratting').mouseover(function () {
                resetStarColors();
                var currentIndex = parseInt($(this).data('index'));
                setStars(currentIndex);
            });

            $('.ratting').mouseleave(function () {
                resetStarColors();

                if (ratedIndex != -1)
                    setStars(ratedIndex);
            });
        });

  

    function setStars(max) {
            for (var i=0; i <= max; i++)
                $('.ratting:eq('+i+')').css('color', 'green');
        }

        function resetStarColors() {
            $('.ratting').css('color', 'white');
        }
  
   // var  handleAddToCartForm =  function () {

   //      $('#reviewForm').validate({
   //          rules : {
   //              review : { required : true},
   //          },
   //          messages : {
   //               review : { 
   //                       required: "Please enter product review"},
   //          },

   //      });
   // }
   //  return {
   //      //main function to initiate the module
   //      init : function () {
   //          handleAddToCartForm();
   //      }
   //  }

$(document).on('click','.addcartbutton', function(){
    var that = $(this);
    var product_id = $(this).data('product_id');
    var varient_id = $(this).data('varient_id');
    var url = $('#url').val();
    var qnt = $(this).parent().next('div').find('input:text').val();
    // alert(qnt); 
    var siteCurrency = $('#siteCurrency').val(); // currency is dynamic
    if(qnt == 0){
      $(this).next('div').find('input:text').val('1');
      return false;
    }
     $.ajax({
                url : url+'add_to_card/addProducToCart',
                data:{product_id:product_id,qnt:qnt,varient_id:varient_id},
                method:'post',
                dataType:'json',
                success:function(output){
        
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

   
}();