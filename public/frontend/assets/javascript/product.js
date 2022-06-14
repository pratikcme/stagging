$(document).on("click",".sub_cat_link",function(){
  $(".sub_cat_link").removeClass("active_sub");
  $(this).addClass("active_sub");
 });


// $(document).on('click',".cart-qty-plus",function() {
//   quantityField = $(this).prev().val();
//   quantity = $(this).prev();
//   quantity.val(parseInt(quantityField) + 1);
//   quantityField = $(this).prev().val();
//    if(quantityField == 0){
//     $(this).parent().prev('div').css('pointer-events','auto');
//    }  
// });
 
//  $(document).on('click',".cart-qty-minus",function() {
//   quantityField = $(this).next().val();
//   quantity = $(this).next();
//   if (quantityField >= 1) {
//         quantity.val(parseInt(quantityField) - 1);
//   }
//     quantityField = $(this).next().val();
//    if(quantityField < 0 || quantityField == -0){
//     $(this).parent().prev('div').css('pointer-events','none');
//    }  
// });
urlCategory_id();
function urlCategory_id(){
    var cat_id =  $('#getBycatID').val();
    $('.category_id').each(function(){
        var selected_cat = $(this).attr('data-cat_id');
        if(cat_id == selected_cat){
            var catname = $(this).text();
            $('#dropDownBtn').html(catname+'<span><i class="fas fa-angle-down"></i></span>');
        }
    })
}

    function get_filter(class_name){
       var  rangeArray = []; 
         $('.'+class_name).each( function(){
            if( $(this).is(':checked') ){
                rangeArray.push( $(this).val() );
            }
         })
            return rangeArray;
    }


    $(document).ready(function(){
      onload(1);
        function onload(page,sub_id='',cat_id='',sort = '',search='',start_price='',end_price=''){
            
            // var search =  $('#search').attr('data-search_val');
            //               $('.search').val('');

            var url = $('#url').val();
            var rangeArray = [];
            // var getCatByURL = "";
            var for_cat_subcat_count = '';
               var check =  $('#getBycatID').val();
              if(check != ''){
                for_cat_subcat_count = '1';
              }
            if(cat_id == ''){
              var cat_id = $('#getBycatID').val();
              if(cat_id == ''){
                cat_id = $('#cat_id').val();
              }
            }
            // alert(cat_id);
            // var rangeArray = get_filter('range');
            // var rangeArray = $('#start_range').val();
            var discountArray = get_filter('discount');
            var brandArray = get_filter('brand');
            $.ajax({
                url : url+'products/subcategory/'+page,
                data:{
                  search:search,sort:sort,
                  sub_id:sub_id,cat_id:cat_id,
                  brandArray:brandArray,
                  rangeArray:rangeArray,
                  start_price:start_price,
                  end_price:end_price,
                  discountArray:discountArray,
                  page:page,/*for_cat_subcat_count:for_cat_subcat_count*/
                },
                method:'post',
                dataType:'json',
                success:function(output){
                    // console.log(output);
                    $('#ajaxProduct').html(output.result);

                    
                    if(cat_id != ''){
                      $('#sd').css('display','block');
                      $('#short').html(output.short_li);
                      $('#long').html(output.long_li);
                    }else{
                      $('#sd').css('display','none');
                    }
                    $('.cate_id').each(function(){
                         var value = $(this).data('cate_id');
                          if(cat_id == value){
                              $(this).addClass('active');
                          }else{
                              $(this).removeClass('active');
                          }
                    });
                    $('.sub_cat_link').removeClass('active_sub');
                    $('.sub_cat_link').each(function(){
                         var val = $(this).data('sub_id');
                          if(sub_id == val){
                              $(this).addClass('active_sub');
                          }
                    });
                }
             })
         }


    $(document).on('click','.sorting',function(){
        var sort = $(this).data('value');
        var selected_text = $(this).text(); 
        $('#selected').attr('data-sorting',sort);
        $('#selected').html('');
        $('#selected').html(selected_text);
         if(sort != ''){
            var cat_id = $('#cat_id').val();
            var sub_id = $('#sub_cat_id').val();   
        }else{
             var cat_id = '';
            var sub_id = '';
        }
        page = 1;
        onload(page, sub_id = sub_id ,cat_id = cat_id ,sort);
    });

      $(document).on('click','#load_more',function(){
        $(this).html('<i class="fa fa-spinner fa-spin"></i>Loading'); //loader when click on this

        var page = $(this).val();
        // var page = $(this).data("ci-pagination-page");
        var url = $('#base_url').val();
        // var page = $(this).data('page');
        var ids = $(this).attr('data-ids');
        var id = $.parseJSON(ids);  
        if(typeof(id.rangeArray) != "undefined" && id.rangeArray !== null) {
               rangeArray = [id.rangeArray[0]];
            }else{
                rangeArray = [];
            }
        if(typeof(id.discountArray) != "undefined" && id.discountArray !== null) {
               discountArray = [id.discountArray[0]];
            }else{
                discountArray = [];
            }
        if(typeof(id.sort) != "undefined" && id.sort !== null) {
               sort = id.sort;
            }else{
                sort = '';
            }
        if(typeof(id.search) != "undefined" && id.sort !== null) {
               search = id.search;
            }else{
                search = '';
            }
          if(typeof(id.start_price) != "undefined" && id.start_price !== null) {
               start_price = id.start_price;
            }else{
                start_price = '';
            }
          if(typeof(id.end_price) != "undefined" && id.end_price !== null) {
               end_price = id.end_price;
            }else{
                end_price = '';
            }

        if(id.sub_id != '' ){
            var sub_id =  id.sub_id;
        }
        if(id.cat_id != '' ){
             var cat_id =  id.cat_id;
        }
        onload(page,sub_id,cat_id,sort,search,start_price,end_price);
      })

    $(document).on('change','.range',function(){
        onload(1);
    });

    $(document).on('change','.discount',function(){
       var cat_id = $('#cat_id').val();
       var sub_id = $('#sub_cat_id').val();   
       onload(1,sub_id,cat_id,sort = '',search='',start_price=st_price,end_price=en_price);
    });

    $(document).on('change','.brand',function(){
        var cat_id = $('#cat_id').val();
        var sub_id = $('#sub_cat_id').val();   
        onload(1,sub_id,cat_id,sort = '',search='',start_price=st_price,end_price=en_price);
    });

    $(document).on('click','.category_id',function () {
        var cat_id = $(this).attr('data-cat_id');
        var url = $('#url').val();

        sub_id = '';
        $('#cat_id').val(cat_id);
        if(cat_id == 'All'){
          $('#cat_id').val('');
          $('#sub_cat_id').val('');
          $('#getBycatID').val('');
          cat_id = '';
        $('#dropDownBtn').html("All Categories");
        }else{
          $.ajax({
            url : url+'products/getCategoryName',
            data:{ cat_id : cat_id },
            method:'post',
            dataType:'json',
            async : false,
            success:function(res){
              $('#dropDownBtn').html(res.name);
            }
          });
        }

        $('#search').attr('data-search_val','');
       $('.search').val('');
          page = 1;
         onload(page,sub_id,cat_id);
    })

    $(document).on('keyup','.search',function(){
        var search_key = $(this).val();
        var that = $(this);
        if(search_key != ''){
            $('#search').attr('data-search_val',search_key);
            var cat_id = $('#cat_id').val();
            var sub_id = $('#sub_cat_id').val();   
        
        }else{
          $('#search').attr('data-search_val',"");
            var cat_id = $('#cat_id').val();
            var sub_id = $('#sub_cat_id').val(); 
            // var sub_id = '';
        }
        page = 1;
         onload(page,sub_id = sub_id, cat_id = cat_id, sort='',search_key);
    });


     $(document).on('click','.sucategory_id',function(){
       var sub_id = $(this).attr('data-sub_id');
        // var cat_id = $(this).parent().parent().parent().attr('data-cat_id');
        var cat_id = $(this).parent().prev('a').find('.category_id').attr('data-cat_id');
        if(typeof(cat_id) !== 'undefined'){
            $('#cat_id').val(cat_id);
        }
        if(typeof(cat_id) !== 'undefined'){
            cat_id = $('#cat_id').val();
        }
      
        $('#sub_cat_id').val(sub_id);

        //  when url having category
        var cateByUrl =  $('#getBycatID').val(); //from url cat id
        var hidden =  $('#cat_id').val(); //change category from products page
        if(cateByUrl !== hidden && hidden != ''){
          $('#getBycatID').val('');
        }
        // end when url having category
     
        page = 1;
        var url = $('#url').val();
         $.ajax({
            url : url+'products/getCategoryName',
            data:{ cat_id : cat_id },
            method:'post',
            dataType:'json',
            // async : false,
            success:function(res){
              $('#dropDownBtn').html(res.name+'<span><i class="fas fa-angle-down"></i></span>');
            }
          });
        onload(page,sub_id,cat_id);
    });

     $(document).on('click','.cate_id',function(){
       var cat_id = $(this).attr('data-cate_id');


       $('.cate_id').removeClass('active');
       $(this).addClass('active');
        $('#cat_id').val(cat_id);
        page = 1;
        sub_id ='';
        $('#search').attr('data-search_val','');
        $('.search').val('');
       $('.category_id').each(function () {
            var selected_cat = $(this).attr('data-cat_id');
            if(selected_cat == cat_id){
                var catName  = $(this).text();
                // alert(catName);
                $('#dropDownBtn').html(catName+' <span><i class="fas fa-angle-down"></i></span>');
            }

       })
        // $('#dropDownBtn').html('Categories <span><i class="fas fa-angle-down"></i></span>');
        onload(page,sub_id,cat_id);
    });

});

// $(document).on('click','.cate_id',function(){
//   var url = $('#url').val();
//   var cate_id = $(this).data('cate_id');
//    $.ajax({
//     url : url+'products/getSubcategoryOfCategory',
//     data:{cat_id:cat_id},
//     method:'post',
//     dataType:'json',
//     success:function(output){
      
//     }
//   })
// })

// $(document).on('click','.addcartbutton_old',function(){
//     var product_id = $(this).data('product_id');
//     var qnt = $(this).next('div').find('input:text').val();
//     var url = $('#url').val();
//     if(qnt <= 0 || qnt == -0 ){
//        swal({
//               title: "Failed",
//               text: "Please select valid quantity",
//               type: "success",
//               timer: 1000
//             });
//       return false;
//     }
//      $.ajax({
//                 url : url+'products/addProducToCart',
//                 data:{product_id:product_id,qnt:qnt},
//                 method:'post',
//                 dataType:'json',
//                 success:function(output){
//                     if(output.errormsg != ''){
//                       swal(output.errormsg);
//                       $('.cart-plus-minus-box').val('1');
//                     }else if(output.itemExist != ''){
//                        swal(output.itemExist);
//                         // window.location.href = url+'/products/cart_item';
//                       // swal('Item Already Added').then((value) => {
//                       //   window.open(url+'/products/cart_item');
//                       // });
//                     }
//                       if(output.count == 1 ){
//                         $('#itemCount').css('display','block');
//                         $('#nav_cart_dropdown').removeClass("d-none");
//                       }
//                       if(output.success != ''){
//                         $("#backdrop").addClass("backdrop_bg");
//                         $('#pupup_message').css('display','block');
//                           setTimeout(function() {
//                               $("#backdrop").removeClass("backdrop_bg");
//                               $('#pupup_message').fadeOut('fast');
//                             }, 1000);
//                         // swal({
//                         //    title: "success",
//                         //    text: "Item Added successfully",
//                         //    type: "success",
//                         //    timer: 2000
//                         //  });
//                       }

//                       $('#itemCount').html(output.count);
//                       $('#updated_list').html(output.updated_list);
//                       $('#nav_subtotal').html('<i class="fas fa-rupee-sign"></i>'+output.final_total);
//               // }
//         }
//     })
// })


// brand search code

  $(document).on('keyup','#search_brand',function (){
    var search_key = $(this).val();
     var url = $('#url').val();
    $.ajax({
      url : url+'products/searchBrand',
      data:{search_key:search_key},
      method:'post',
      dataType:'json',
      success:function(output){
        $("#brand_list").html(output.brand_list);
      }
    })
  })


// $(document).on('click','.addcartbutton', function(){
//   // alert(0);
//     var that = $(this);
//     var product_id = $(this).data('product_id');
//     var varient_id = $(this).data('varient_id');
//     var url = $('#url').val();
//     var qnt = $(this).parent().next('div').find('input:text').val();
//     // alert(qnt); 
//     var siteCurrency = $('#siteCurrency').val(); // currency is dynamic
//     if(qnt == 0){
//       $(this).next('div').find('input:text').val('1');
//       return false;
//     }
//      $.ajax({
//                 url : url+'add_to_card/addProducToCart',
//                 data:{product_id:product_id,qnt:qnt,varient_id:varient_id},
//                 method:'post',
//                 dataType:'json',
//                 success:function(output){
                  
//                   if(output.errormsg != ''){
//                       swal(output.errormsg);
//                       $('.cart-plus-minus-box').val('1');
//                     }else if(output.itemExist != ''){
//                       swal(output.itemExist);
//                     }
                      
//                       if(output.count >= 1 ){
//                         that.parent().next('div').removeClass('d-none');
//                         that.parent().addClass('d-none');
//                         $('#itemCount').css('display','block');
//                       }
                      
//                       if(output.success != ''){
//                         // $("#backdrop").addClass("backdrop_bg");
//                         // $('#pupup_message').css('display','block');
//                          setTimeout(function() {
//                               // $('#pupup_message').fadeOut('fast');
//                               // $("#backdrop").removeClass("backdrop_bg");
//                          }, 2000);
//                         // swal({
//                         //    title: "success",
//                         //    text: "Item Added successfully",
//                         //    type: "success",
//                         //    timer: 2000
//                         //  });
//                       }
//                       $('#nav_cart_dropdown').removeClass("d-none");
//                       $('#itemCount').html(output.count);
//                       $('#updated_list').html(output.updated_list);
//                       $('#nav_subtotal').html(siteCurrency+' '+output.final_total);
//                 }
//             })
// });