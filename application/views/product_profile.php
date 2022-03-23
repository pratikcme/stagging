<?php

include('header.php');
$id = $this->utility->decode($_GET['id']);
$branch_id = $this->session->userdata['id'];
$category_query = $this->db->query("SELECT * FROM category WHERE status != '9' AND branch_id = '$branch_id'");
$category_result = $category_query->result();

$brand_query = $this->db->query("SELECT * FROM brand WHERE status != '9' AND branch_id = '$branch_id'");
$brand_results = $brand_query->result();

$subcategory_query = $this->db->query("SELECT * FROM subcategory WHERE status != '9' AND branch_id = '$branch_id'");
$subcategory_result = $subcategory_query->result();

$supply_query = $this->db->query("SELECT * FROM `supplier` WHERE branch_id = '$branch_id' AND status != '9'");
$supply_result = $supply_query->result();


 if($id != ''){
    $query = $this->db->query("SELECT * FROM product WHERE id = '$id' AND branch_id = '$branch_id'");
    $result = $query->row_array();
    $category_id = $result['category_id'];
    // print_r($category_id);die;
    $brand_id = $result['brand_id'];
    $subid = $result['subcategory_id'];
    $supid = $result['supplier_id'];

    $cat_query = $this->db->query("SELECT * FROM category WHERE id = '$category_id' AND branch_id = '$branch_id'");
    $cat_result = $cat_query->row_array();

    $bra_query = $this->db->query("SELECT * FROM brand WHERE id = '$brand_id' AND branch_id = '$branch_id'");
    $bra_result = $bra_query->row_array();

    $brand_query = $this->db->query("SELECT * FROM brand WHERE category_id = '$category_id' AND branch_id = '$branch_id'");
    $brand_result = $brand_query->result();
    $supplier_query = $this->db->query("SELECT * FROM `supplier` WHERE branch_id = '$branch_id' AND status != '9'");
    $supplier_result = $supplier_query->result();

    $subcategory_query = $this->db->query("SELECT * FROM   subcategory WHERE id = '$subid' AND branch_id = '$branch_id' AND status != '9'");
    $subcate_result = $subcategory_query->row_array();

    $category_query = $this->db->query("SELECT * FROM category WHERE  status != '9' AND branch_id = '$branch_id'");
    $categ_result = $category_query->row_array();

    $brand_query = $this->db->query("SELECT * FROM brand WHERE   category_id LIKE '%$category_id%' AND branch_id = '$branch_id'");
    $brand_results = $brand_query->result();
    $subcategory_query = $this->db->query("SELECT * FROM subcategory WHERE status != '9' AND category_id = '$category_id' AND branch_id = '$branch_id'");
    $subcategory_result = $subcategory_query->result();
// print_r($subcategory_result);
}
?>
<?php 
    if($result['id']!=''){
        $reqName = "Update";
        }else{
           $reqName ="Add";
    } 
    // echo $subcate_result['id'];exit;    
?>
<style type="text/css">
 .required{
         color: red;
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
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'product/product_list'; ?>">Product</a> / <?php echo $reqName; ?></a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $reqName; ?> Product
                    </header>
                    <form role="form" method="post" action="<?php echo base_url().'product/product_add_update'; ?>" name="product_form" id="product_form" enctype="multipart/form-data">
                        <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Product Name<span class="required" aria-required="true"> * </span></label>
                                        <input type="text" class="form-control margin_top_input" id="name" name="name" placeholder="Product name" value="<?php echo $result['name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="category_id" class="margin_top_label">Category<span class="required" aria-required="true"> * </span></label>
                                        <select class="form-control margin_top_input" id="category_id" name="category_id">
                                            <option value="" selected disabled>Select Category</option>
                                            <?php foreach ($category_result as $cat){ ?>
                                                <option value="<?php echo $cat->id; ?>" <?php if($category_id == $cat->id){ ?> selected <?php } ?>><?php echo $cat->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    
                                 
                                        <div class="form-group" id="get_brand">
                                            <label for="brand_id" class="margin_top_label">Brand<span class="required" aria-required="true"> * </span></label>
                                            <select class="form-control margin_top_input" id="brand_id" name="brand_id">
                                                <option value="" selected disabled>Select Brand</option>
                                                <?php foreach ($brand_results as $bra){ ?>
                                                    <option value="<?php echo $bra->id; ?>" 
                                                    <?php if($id != '' && $bra_result['id'] == $bra->id){ ?> selected <?php } ?>><?php echo $bra->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group" id="get_subCategory">
                                            <label for="brand_id" class="margin_top_label">Subcateory<span class="required" aria-required="true"> * </span></label>
                                            <select class="form-control margin_top_input" id="subcategory_id" name="subcategory_id">
                                                <option value="" selected disabled>Select Subcateory</option>
                                                <?php 
                                                foreach ($subcategory_result as $subcate){ ?>
                                                    <option value="<?php echo $subcate->id; ?>" 
                                                    <?php if($id != '' && $subcate_result['id'] == $subcate->id){ echo  "selected";  } ?>
                                                    ><?php echo $subcate->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <?php //print_r($supplier_result); ?>
                                      <div class="form-group" id="get_subCategory" style="display: none;">
                                            <label for="brand_id" class="margin_top_label">Supplier<span class="required" aria-required="true"> * </span></label>
                                            <select class="form-control margin_top_input" id="supplier_id" name="supplier_id">
                                                <option value="" selected disabled>Select Supplier</option>
                                                <?php 
                                                foreach ($supply_result as $supplier){ ?>
                                                    <option value="<?php echo $supplier->id; ?>" 
                                                    <?php if($id != '' && $supid == $supplier->id){ echo  "selected";  } ?>
                                                    ><?php echo $supplier->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    
                                       
                                  
                                   <!--  <div class="form-group">
                                        <label for="name" class="margin_top_label">Image</label>
                                         <?php //if($result['image'] != ''){ ?>
                                        <input type="file" class="form-control margin_top_input" id="image" name="image_edit" placeholder="Select Image" value="">

                                       
                                            <img src="<?php //echo base_url().'public/images/product/'.$result['image']; ?>" height="100" width="100" style="margin-top: 10px;">
                                        <?php// }else{ ?>
                                             <input type="file" class="form-control margin_top_input" id="image" name="image" placeholder="Select Image" value="">
                                        <?php// } ?>

                                    </div> -->
                                </div>
                               
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">About<span class="required" aria-required="true"> * </span></label>
                                        <textarea class="form-control margin_top_input ckeditor" id="about" placeholder="About" name="about" rows="5"><?php echo $result['about']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Content<span class="required" aria-required="true"> * </span></label>
                                        <textarea class="form-control margin_top_input ckeditor" id="content" placeholder="Content" name="content" rows="5"><?php echo $result['content']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="gst" class="margin_top_label">GST<span class="required" aria-required="true"> * </span></label>
                                       <input type="text" class="form-control margin_top_input" id="gst" name="gst" placeholder="Product gst" value="<?=($result['gst'] != '0') ? $result['gst'] : '' ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                  <a href="product_list" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>   
                                  <input type="submit" class="btn btn-info pull-right margin_top_label" value="<?php echo $reqName.' Product'; ?>" name="submit">
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
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<style> label.error { color: red; font-weight: 500; } </style>
<!-- <script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.min.js"></script> -->
<script type="text/javascript">
//$("#divid").hide();
 $("#image").on('change',function(){ 
    $('#about').trigger('focus');
 });
    /*Get Brand From Store*/
    $(function (){
        $("#category_id").change(function (){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'product/get_brand'; ?>",
                data: { category_id:  $("#category_id option:selected").val()}
            }).done(function( msg ) {
                $("#get_brand").html(msg);
            });
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'product/get_subCategory'; ?>",
                data: { category_id:  $("#category_id option:selected").val()}
            }).done(function( msg ) {
                $("#get_subCategory").html(msg);
            });
        });
    });

    $('#product_form').validate({
        
        rules: {
            name: {
                required: true,
                maxlength: 100
            },
            category_id: {
                required: true
            },
            supplier_id: {
                required: true
            },
            brand_id: {
                required: true
            },
            subcategory_id: {
                required: true
            },
            // about: {
            //     required: true,
            //     maxlength: 500
            // },
            image:{
                required: true,
                accept: "image/jpg,image/jpeg,image/png,image/gif"
            }, 
            image_edit:{
               accept: "image/jpg,image/jpeg,image/png,image/gif"
            },  
            // content: {
            //     required: true,
            //     maxlength: 500
            // },
            // gst: {
            //     required: true,
            //     maxlength: 2,
            //     number : true,
            // }
        },
        messages: {
            name: {
                required: "Please enter product name",
                maxlength: "Please enter maximum 100 character product name"
            },
            category_id: {
                required: "Please select category"
            },
            supplier_id: {
                required: "Please select supplier"
            },
            brand_id: {
                required: "Please select brand"
            }, 
            subcategory_id: {
                required: "Please select subcategory"
            },
            // about: {
            //     required: "Please enter about",
            //     maxlength: "Please enter maximum 500 character about"
            // },
            image:{
                    required: "Select Image",
                    accept: "Only image type jpg/png/jpeg/gif is allowed"
                }, 
            image_edit:{
                    
                    accept: "Only image type jpg/png/jpeg/gif is allowed"
                }, 
            // content: {
            //     required: "Please enter content",
            //     maxlength: "Please enter maximum 500 character content"
            // },
            // gst: {
            //     required: "Please enter gst percent",
            //     maxlength: "please enter in two digits",
            //     number : "Please enter number only",
            // }
        },
        error: function(label) {
            $(this).addClass("error");
        },
        
        submitHandler: function (form) {
                
                $('.btn').attr('disabled','disabled');
                $(form).submit();
                
            }
    });
</script>
<?php include('footer.php'); ?>