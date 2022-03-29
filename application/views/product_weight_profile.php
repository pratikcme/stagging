<?php
 include('header.php');

$branch_id = $this->session->userdata['id'];
$vendor_id = $this->session->userdata['branch_vendor_id'];
// $b = $this->db->query("SELECT * FROM branch WHERE id = '$branch_id'");
// $branch = $b->row_array();
// $vendor_id = $branch['vendor_id'];
if(isset($_GET['id'])){
$id = $this->utility->decode($_GET['id']);

    if($id != ''){
        $query = $this->db->query("SELECT * FROM product_weight WHERE id = '$id'");
        $result = $query->row_array();
        $weight_id = $result['weight_id'];
        // print_r($result);exit;
        $wei_query = $this->db->query("SELECT * FROM weight WHERE id = '$weight_id'");
        $wei_result = $wei_query->row_array();
   
        $imgquery = $this->db->query("SELECT * FROM product_image WHERE status != '9'  AND branch_id = '$branch_id' AND product_variant_id = '$id' ORDER BY image_order");
        $product_image = $imgquery->result();
    }
}
$product_id = $this->utility->decode($_GET['product_id']);

$weight_query = $this->db->query("SELECT * FROM weight WHERE status != '9' AND vendor_id = '$vendor_id' ");
$weight_result = $weight_query->result();

$package_query = $this->db->query("SELECT * FROM `package` WHERE  vendor_id = '$vendor_id' ORDER BY id DESC ");
$package_results = $package_query->result();


?>
<?php 
    if(isset($_GET['id']) && $_GET['id']!=''){
        $reqName = "Update";
        }else{
           $reqName ="Add";
    } 
?>
   <style type="text/css">
    .required{
         color: red;
         }
   </style>
<style>
.img_preview {
    width: 300px;
    position: relative;
    display: none;
}
.gallery img {
    width: 20%;
    margin-right: 20px;
}
.overlay{
    position: absolute;
    width: 100%;
    height: 100%;   
}
.im_progress {
    position: absolute;
    width: 100%;
    opacity: 0.5;
}
.loader_img{
    position: absolute;
    top: 50%;
    left: 50%;  
}
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'product/product_list' ?>">Product </a> / <a href="<?php echo base_url().'product/product_weight_list?product_id='.$this->utility->encode($product_id)?>"> Product Variant </a>/ <?php echo $reqName; ?> </a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $reqName; ?> Product Variant
                    </header>
                    <form role="form" method="post" action="<?php echo base_url().'product/product_weight_add_update'; ?>" name="product_weight_form"  enctype="multipart/form-data" id="product_weight_form">
                        <input type="hidden" id="id" name="id" value="<?php if(isset($_GET['id'])){echo $result['id']; } ?>">
                        <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id; ?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Variant :<span class="required" aria-required="true"> * </span></label>
                                        <input type="text" class="form-control margin_top_input" id="unit" name="unit" placeholder="Variant" value="<?php echo $result['weight_no']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="weight_id" class="margin_top_label">Unit :<span class="required" aria-required="true"> * </span></label>
                                        <select class="form-control margin_top_input" id="weight_id" name="weight_id">
                                            <option value="" selected disabled>Select Unit</option>
                                            <?php foreach ($weight_result as $weight){ ?>
                                                <option value="<?php echo $weight->id; ?>" <?php if($wei_result['id'] == $weight->id){ ?> selected <?php } ?>><?php echo $weight->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div> 
                                    <div class="form-group">
                                        <label for="package" class="margin_top_label">Package :</label>
                                        <select class="form-control margin_top_input" id="package" 
                                        name="package">
                                            <option value="" selected disabled>Select Package</option>
                                            <?php foreach ($package_results as $package){ ?>
                                                <option value="<?php echo $package->id; ?>" <?php if($result['package'] == $package->id){ ?> selected <?php } ?>><?php echo $package->package; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Quantity :<span class="required" aria-required="true"> * </span></label>
                                        <input type="number" class="form-control margin_top_input" id="quantity" name="quantity" placeholder="Quantity" value="<?php echo $result['quantity']; ?>" min="1">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                    <div class="form-group">
                                        <label for="purchase_price" class="margin_top_label">Purchase Price :<span class="required" aria-required="true"> * </span></label>
                                        <input type="text" class="form-control margin_top_input" id="purchase_price" name="purchase_price" placeholder="Purchase Price" value="<?php echo $result['purchase_price']; ?>" onchange="validate(event)">
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Maximum Retail Price (MRP) :<span class="required" aria-required="true"> * </span></label>
                                        <input type="text" class="form-control margin_top_input" id="price" name="price" placeholder="Price" value="<?php echo $result['price']; ?>" onchange="validate(event)">
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Discount(%) :</label>
                                        <input type="number" class="form-control margin_top_input" id="discount_per" name="discount_per" placeholder="Discount" value="<?php echo $result['discount_per']; ?>" min="0" max="100">
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Max Order Quantity :</label>
                                        <input type="number" class="form-control margin_top_input" id="max_order_qty" name="max_order_qty" placeholder="max order quamtity" value="<?php echo (isset($result['max_order_qty']))?$result['max_order_qty']:''; ?>" min="0" max="100">
                                    </div>
                                    
                                    <div class="form-group variantimg">
                                        <label for="name" class="margin_top_label">Image :<span class="required" aria-required="true"> * </span></label>
                                        <input type="file" accept="image/x-png,image/gif,image/jpeg"  multiple="multiple" class="form-control margin_top_input" id="image" name="userfile[]" placeholder="Select image" >
                                    <span id="imgerr" style="color: red;"></span>
                                    <label id="image-error" class="error" for="image" style="display: inline-block;"></label>
                                    </div>
                                    <div class="gallery" style="margin-bottom: 15px;"></div>
                                </div>
                            </div> 
                            <div class="col-md-12 col-sm-12 col-xs-12">
                             <?php foreach ($product_image as $key => $value) {  ?>
                                <div class="img" id="image_<?php echo $value->id; ?>"  style="float: left; margin-right: 10px; margin-bottom: 20px;">
                                    <a href="javascript:;" onclick="single_delete(<?php echo $value->id; ?>)" style="float: right;" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                    <img src="<?php echo base_url().'public/images/'.$this->folder.'product_image/'.$value->image; ?>" style="height: 180px; width: 200px;">
                                </div>  
                                <?php  } ?>
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <a href="<?php echo 'product_weight_list?product_id='.$_GET['product_id']; ?>" style="float: right; margin-right: 10px;" class="btn btn-danger">Cancel</a>   
                                <input type="submit" class="btn btn-info pull-right margin_top_label" value="<?php echo $reqName.' Product Variant'; ?>" name="submit_frm">
                            </div>
                        </div>
                    </form>
                </section>
            </div>
            <!--Map Part-->
        </div>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<style> label.error { color: red; font-weight: 500; } </style>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script type="text/javascript">

    $(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {
        $('.gallery').html('');  
        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img height = "150" width = "200">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
        validateFileType();

    };
    $('.variantimg').on('click',function(){
        var imageerr = checkimage();               
        if(imageerr==true){
            $('#imgerr').html('');
        }else{
            $('#imgerr').html('Please select image');
        }
    });
    $('#image').on('change', function() {
                // $('.img').hide();
        imagesPreview(this, 'div.gallery');
        
    });
    function validateFileType(){

        var fileName = $("#image").val();
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            $('.gallery').show();
            $('#image-error').hide();
            $('#imgerr').hide();
           
        }else{
            
            $('#image-error').html('Only image type jpg/png/jpeg/gif is allowed');
            $('.gallery').attr("style","display: none;");   
            setTimeout(function(){
                $('#quantity').focus();
            },1000);
            
        }   
    }
});
    
       $.validator.addMethod("validatemrp", function(value, element) {
            var priceval = $('#purchase_price').val();

           priceval = parseInt(priceval);
           value = parseInt(value);


            if(priceval > value){
                return false;
            }else{
                return true;
            }
       }, "MRP should be greater than Purchase price");
    // $.validator.addMethod("validatepur", function(value, element) {
    //     var priceval = $('#price').val();
    //
    //     // alert(value);
    //     // alert(priceval);
    //
    //     if(priceval < value){
    //         return false;
    //     }else{
    //         return true;
    //     }
    // }, "Please enter purchase price less than MRP");
    jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[\w.]+$/i.test(value);
    }, "Letters, numbers only please");

    $('#product_weight_form').validate({
        rules: {
            unit: {
                required: true,
                alphanumeric: true
            },
            weight_id: {
                required: true
            },
            'userfile[]': {
                // required: true,
                 accept: "image/jpg,image/jpeg,image/png,image/gif"
            },
            price: {
                required: true,
                number: true,
                validatemrp : true,
                min:1,
            },
            purchase_price: {
                required: true,
                number: true,
                min:1
            },
            quantity: {
                required: true
            },
            discount_per: {
                number: true
            }
        },
        messages: {
            unit: {
                required: "Please enter variant",
                number: "Please enter only digits"
            },
            weight_id: {
                required: "Please select unit"
            },
            'userfile[]': {
                // required: "Please select image",
                accept: "Only image type jpg/png/jpeg/gif is allowed"
            },
            price: {
                required: "Please enter price",
                  number: "Please enter valid price"
            }, 
            purchase_price: {
                required: "Please enter purchase price",
                  number: "Please enter valid purchase price"
            },
            quantity: {
                required: "Please enter quantity"
            },
            discount_per: {
                // required: "Please enter discount",
                number: "Please enter only digits"
            }
        },
        invalidHandler: function(form) {
            var imageerr = checkimage();
               
                if(imageerr==true){
                                        
                }else{
                    $('#imgerr').html('Please select image');
                    return false;
                }

        },
      
         submitHandler: function (form,event) {
               event.preventDefault();               
                var imageerr = checkimage();
               
                if(imageerr==true){
                    $(form).submit();
                    $('.btn').attr('disabled','disabled');                    
                }else{
                    $('#imgerr').html('Please select image');
                    return false;
                }

                
        }
    });
    function checkimage(){
        // alert(1);
        var get = $('.img').attr('id');
        if(typeof(get) != "undefined" && get !== null){
            var res = get.split("_");
            if(res[1]!=''){
                return true;
            }else{
                return false;
            }
        }else{
           var files = $('input[type=file]').val();
            if(typeof(files) != "undefined" && files !== null && files !== ''){
               console.log(files);  
                return true;
            }else{
                return false;
            }
        }
        
    }
    function single_delete(value) {

        bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
            if (confirmed == true) {
                
                var id = value;
                // alert(id);
                $.ajax({
                    url: '<?php echo base_url().'product/single_delete_product_image/'; ?>' ,
                    data: {
                        ids: id,
                       
                    },
                    success: function (data) {
                        if (data.status == 1) {
                            bootbox.alert("Product image has been deleted successfully.", function() {
                                window.location.reload(true);
                            });
                        }
                        else {
                            alert('Failed to delete selected image.');
                        }
                    },
                    error: function () {
                        alert('Failed to delete selected image.');
                    }
                });
            }
            else
            {
                window.location.reload(true);
            }
        });
    }
</script>

<script type="text/javascript">
     function validate(evt) {
          var theEvent = evt || window.event;
          var key = theEvent.keyCode || theEvent.which;
          key = String.fromCharCode( key );
          var regex = /[0-9]|\./;
          if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
          }
        }
</script>
<?php include('footer.php'); ?>