
$(document).ready(function(){
    var url = $('#base_url').val();
    $('.sucategory_id').click(function(){

        var rangeArray = get_filter("range");
        var discountArray = get_filter("discount");

        var sub_id = $(this).attr('data-sub_id');
        var cat_id = $(this).parent().parent().prev().attr('data-cat_id');
           $.ajax({
            url : url+'frontend/product/subcategory',
            data:{sub_id:sub_id,cat_id:cat_id,vendor_id:vendor_id,rangeArray:rangeArray,discountArray:discountArray},
            method:'post',
            dataType:'json',
            success:function(output){
                $('#ajaxProduct').html(output.result);
                $('#pagination ul').html(output.link);
            }
        })
    })
     function onload(page){

            var url = $('#base_url').val();
            var rangeArray = get_filter('range');
            var discountArray = get_filter('discount');
            $.ajax({
                url : url+'frontend/product/subcategory',
                data:{rangeArray:rangeArray,discountArray:discountArray,page:page},
                method:'post',
                dataType:'json',
                success:function(output){
                    // console.log(output);
                    $('#ajaxProduct').html(output.result);
                    $('#pagination ul').html(output.link);
                    $('#display_count').html(output.record_display);
                }
             })
         }

         onload(1);
});

    function get_filter(class_name){
       var  rangeArray = []; 
         $('.'+class_name).each( function(){
            if( $(this).is(':checked') ){
                rangeArray.push( $(this).val() );
            }
         })
            return rangeArray;
    }

    $(document).on('change','#productbyrange',function(){
        var url = $('#base_url').val();
        var rangeArray = []; 
        var selectType = $(this).val();

        var range = $('.range').each(function(){
            if($(this).is(':checked')){
                rangeArray.push($(this).val());
            }
        });
        
        $.ajax({
            url : url+'frontend/product/subcategory',
            data:{sub_id:sub_id,cat_id:cat_id,rangeArray:rangeArray,selectType:selectType},
            method:'post',
            success:function(output){
                $('#ajaxProduct').html(output);
                $('#display_count').html(output.record_display);
            }
        })
    });



       


    /*$(document).on('change','.vendor_list',function(){
        var url = $('#base_url').val();
        var vendor_id = $(this).val();
        if(vendor_id != ''){
            $('.vendor-error').html('');
        }else{
            $('.vendor-error').html('');
        }

        var rangeArray = get_filter('range');
        var discountArray = get_filter('discount');
        $.ajax({
            url : url+'frontend/product/subcategory',
            data:{vendor_id:vendor_id,rangeArray:rangeArray,discountArray:discountArray},
            method:'post',
            dataType:'json',
            success:function(output){
                console.log(output.category);
                $('#ajaxProduct').html(output.result);
                $('#pagination ul').html(output.link);
                $('#display_count').html(output.record_display);
                $('#append_catagory').html(output.category);
            }
        })
    });*/

    $(document).on('click','.paginate',function(){
        var url = $('#base_url').val();
        var page = $(this).data('page');
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
        if(id.vendor_id != '' ){
            var vendor_id =  id.vendor_id; 
        }
        if(id.sub_id != '' ){
            var sub_id =  id.sub_id;
        }
        if(id.cat_id != '' ){
             var cat_id =  id.cat_id;
        }

          $.ajax({
            url : url+'frontend/product/subcategory',
            data:{vendor_id:vendor_id,sub_id:sub_id,cat_id:cat_id,page:page,rangeArray:rangeArray,discountArray:discountArray},
            method:'post',
            dataType:'json',
            success:function(output){
                // console.log(output);
                $('#ajaxProduct').html(output.result);
                $('#pagination ul').html(output.link);
                $('#display_count').html(output.record_display);
            }
        })
       
    });

    $(document).on('change','.range',function(){
        var url = $('#base_url').val();
        var vendor_id =  $('.vendor_list').val();
        var page = $('.paginate').data('page');
        var rangeArray = get_filter("range");
        var discountArray = get_filter('discount');
        // alert(rangeArray);
          $.ajax({
            url : url+'frontend/product/subcategory',
            data:{vendor_id:vendor_id,rangeArray:rangeArray,discountArray:discountArray},
            method:'post',
            dataType:'json',
            success:function(output){
                // console.log(output);
                $('#ajaxProduct').html(output.result);
                $('#pagination ul').html(output.link);
                $('#display_count').html(output.record_display);
            }
        })
       
    });

      $(document).on('change','.discount',function(){
        var url = $('#base_url').val();
        var discountArray = get_filter('discount');
        var rangeArray = get_filter('range');
        var vendor_id =  $('.vendor_list').val();
        var page = $('.paginate').data('page');
         var rangeArray = get_filter("range");

        if(vendor_id ==''){
            $('.vendor-error').html('Plese Select Shop');
            return false;
        }else{
            $('.vendor-error').html('');
        }
        var ids = $(this).val( );
          $.ajax({
            url : url+'frontend/product/subcategory',
            data:{vendor_id:vendor_id,rangeArray:rangeArray,discountArray:discountArray},
            method:'post',
            dataType:'json',
            success:function(output){
                $('#ajaxProduct').html(output.result);
                $('#pagination ul').html(output.link);
                $('#display_count').html(output.record_display);
            }
        })
       
    });




