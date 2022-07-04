<?php include('header.php') ;?>
<style>
 .required{
         color: red;
         }
.img_preview {
    width: 300px;
    position: relative;
    display: none;
}
img#img_preview {
    width: 100%;
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
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / Profit  <?php if($result['id']!=''){
                            echo "Update";
                        }else{
                            echo "Add";
                    } ?></a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
         <div id="msg">
            <?php if ($this->session->flashdata('msg') && $this->session->flashdata('msg') != '') { ?>
                <div class="alert alert-success fade in">
                    <strong>Success!</strong> <?php echo $this->session->flashdata('msg');; ?>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                    <?php if($result['id']!=''){
                            echo "Update Profit Percentage Value";
                        }else{
                            echo "Add Profit Percentage Value";
                    } ?>
                        
                    </header>
                    <form role="form" method="post" action="<?php echo base_url().'setting/profit_add'; ?>" name="cart_value" id="cart_value" enctype="multipart/form-data">
                        <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" id="cat" class="margin_top_label">Profit Percentage(In %) :<span class="required" aria-required="true"> * </span></label>
                                        <input type="text" class="form-control margin_top_input" id="profit" name="profit" placeholder="Profit Percentage" value="<?php echo $result['value']; ?>">
                                    </div>

                                   
                            </div>
                          
                            <div class="col-md-12 col-sm-12 col-xs-12">
                             <?php if($result['id']!=''){
                                    $btn = "Update ";
                                    }else{
                                       $btn ="Add ";
                                    } ?>

                             <a href="<?php echo base_url().'admin/dashboard'; ?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>   
                             <input type="submit" class="btn btn-info pull-right margin_top_label" value="<?php echo $btn.'Profit Percentage'; ?>" name="submit">
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
<!-- <script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script type="text/javascript">


setTimeout(function () { $('#msg').hide(); }, 4000);

    $('#cart_value').validate({
        rules: {
            profit: {
                required: true,
                number: true,
                max:99,
              
            }
        },
        messages: {
            profit: {
                required: "Please enter profit percentage",
                number: "Please enter valid profit percentage ",
                max: "Please enter valid percentage"
                
            }
        },
        error: function(label) {
          placement();
        },
        submitHandler: function (form) {
            $('.btn').attr('disabled','disabled');
            $(form).submit();   
        }
    });
    $(document).on('change','#image',function(){
        var imgpreview=DisplayImagePreview(this);
        $(".img_preview").show();


            setTimeout(function () {

                $('#cat').focus();
                $('#image').focus();

            },500)
     
    });
    function DisplayImagePreview(input){
    
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img_preview').attr('src', e.target.result);
            }
            // $("#name").trigger("focus");
             $('#image-error').remove();
             $('#loaded').show();
            reader.readAsDataURL(input.files[0]);
        }
        validateFileType();

}
function validateFileType(){

    var fileName = $("#image").val();
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
        $('#img_preview').show();
        $('#loaded').hide();
        // $("#ERR").html("");
    }else{
        $('#ERR').show();
        $('#img_preview').attr("style","display: none;");   
        $('#loaded').hide();
        // $("#ERR").html("Only image type jpg/png/jpeg/gif is allowed");
    }   
}
   $(document).click(function (event) {            
    $('#ERR:visible').hide();
});
</script>
<?php include('footer.php'); ?>