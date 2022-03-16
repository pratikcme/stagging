<?php
include('header.php');
 $myhidejs = 1;
    $branch_id = $this->session->userdata['id'];
    $product_id = $this->utility->decode($_GET['product_id']);

    $query = $this->db->query("SELECT p.name as pname,b.name as bname FROM product as p LEFT JOIN brand as b on p.brand_id = b.id WHERE p.status != '9'  AND p.branch_id = '$branch_id' AND p.id = '$product_id'");
    $rows = $query->result();

    $query = $this->db->query("SELECT * FROM product_image WHERE status != '9'  AND branch_id = '$branch_id' AND product_id = '$product_id' ORDER BY image_order");
    $row = $query->result();
?>
<style type="text/css">
    .ui-sortable-handle {
    touch-action: none;
    display: inline-block;
    margin: 0;
    padding: 0;
    float: none!important;
}
</style>
<!-- <link href="<?php echo base_url(); ?>public/css/jquery-ui.css" > -->
<section id="main-content">
         <section class="wrapper">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'product/product_list' ?>">Product </a> /  Product image</a></li>
                </ul>

                <!--breadcrumbs end -->
            </div>
        </div>
        <div id="msg">
        <?php if($this->session->flashdata('msg') && $this->session->flashdata('msg') != ''){ ?>
            <div class="alert alert-success fade in">
                <strong>Success!</strong> <?php echo $this->session->flashdata('msg');; ?>
            </div>
        <?php } ?>

        <?php if($this->session->flashdata('msg_error') && $this->session->flashdata('msg_error') != ''){ ?>
            <div class="alert alert-danger fade in">
                <strong>Error!</strong> <?php echo $this->session->flashdata('msg_error');; ?>
            </div>
        <?php } ?>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
            <header class="panel-heading"> <?= $rows[0]->bname.' '.$rows[0]->pname; ?></header>

    <form role="form" method="post" action="<?php echo base_url() . 'product/product_image_add_update'; ?>" id="product_image" enctype="multipart/form-data">
        <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id; ?>">
        <section class="wrapper">
            <p class="sub_title"></p>
            <div class="col-md-6 col-lg-12 col-sm-12 col-xs-12">
                <div class="customer">
                    <div id="image-list" class="form-group" >
                        <?php  foreach($row as $image){ ?>
                            <div class="img" id="image_<?php echo $image->id; ?>"  style="float: left; margin-right: 10px; margin-bottom: 20px;">
                                <a href="javascript:;" onclick="single_delete(<?php echo $image->id; ?>)" style="float: right;" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                <img src="<?php echo base_url().'public/images/'.$this->folder.'product_image/'.$image->image; ?>" style="height: 180px; width: 200px;">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <p class="sub_title"></p>
            <!-- <div class="col-md-6 col-lg-12 col-sm-12 col-xs-12">
                <div class="customer">
                    <div class="form-group">
                        <label for="handle">Add New Images <span style="color: red;">*</span></label>
                        <input accept='image/*' onchange="validateFileType()" id="file-1" type="file" multiple class="file form-control" data-overwrite-initial="false" name="userfile[]">
                    </div>
             <div><span id="ERR" style="color: red;"></span></div>
                </div>
            </div> -->
       <!-- 
            <a href="<?php echo base_url().'product/product_list'; ?>" data-toggle='modal' class="btn btn-success btn-s-xs" name="cancel" style="float: right; margin-right: 40px;" >Cancel</a>
            <input type="submit" class="btn btn-success btn-s-xs" value="Update" name="update" style="float: right; margin-right: 13px;"  > -->
        
          <div class="asd  text-center col-lg-12"> <a href="<?php echo base_url() . 'product/product_list'; ?>" class="btn btn-primary" style="margin-top: 0px;" id="as">Back</a></div>
        </section>

    </form>
    </section>
    </div>
    </div>
</section>
</section>
<style>
    .kv-file-upload, .fileinput-remove-button, .fileinput-upload-button{ display: none; }
</style>
<script src="<?php echo base_url(); ?>public/js/jquery-3.2.1.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

<script>
    setTimeout( function(){$('#msg').hide();} , 4000);

    $('#product_image').validate({
        rules: {
            'userfile[]': {
                required: true,
                 accept: "image/jpg,image/jpeg,image/png,image/gif"
            }
        },
        messages: {
            'userfile[]': {
                required: "Please select image",
                accept: "Only image type jpg/png/jpeg/gif is allowed"
               
            }
        },
         errorPlacement: function(error, element) {
            $("#ERR").html(error);
        },
        submitHandler: function (form) {
                $(form).submit();
                    $('.btn').attr('disabled',true);
                
            }
    });


    /*Single Delete Script*/
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
    function validateFileType(){
        var fileName = $("#file-1").val();
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            $("#ERR").html("");
             $(".file-preview").show();
             $("#copy-rights").hide();
             $(".file-footer-caption").hide();
        }else{
            $("#ERR").html("Only jpg/jpeg and png files are allowed!");
            $(".file-preview").hide();
        }   
    }

    $(document).ready(function () {
        var dropIndex;
        $("#image-list").sortable({
            update: function(event, ui) { 
            dropIndex = ui.item.index();
            setimg();
            }
        });

        function setimg(e) {
            var imageIdsArray = [];
            $('.img').each(function (index) {

                // if(index <= dropIndex) {

                    var id = $(this).attr('id');
                    var split_id = id.split("_");
                    imageIdsArray.push(split_id[1]);
                // }
            });
            $.ajax({
                url: 'imagedrag',
                type: 'post',
                data: {imageIds: imageIdsArray},
                success: function (response) {
                    
                }
            });
            // e.preventDefault();
        };
    });

</script>
<?php include('footer.php'); ?>