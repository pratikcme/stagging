<?php
include('header.php');
error_reporting(0);
@$id = $this->utility->decode($_GET['id']);

?>
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
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'category/category_list'; ?>">Category</a> /  <?php if($result['id']!=''){
                            echo "Edit";
                        }else{
                            echo "Add";
                    } ?></a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                    <?php if($result['id']!=''){
                            echo "Update Category";
                        }else{
                            echo "Add Category";
                    } ?>
                        
                    </header>
                    <form role="form" method="post" action="<?php echo base_url().'category/category_add_update'; ?>" name="category_form" id="category_form" enctype="multipart/form-data">
                        <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" id="cat" class="margin_top_label">Category Name :<span class="required" aria-required="true"> * </span></label>
                                        <input type="text" class="form-control margin_top_input" id="name" name="name" placeholder="Enter name" value="<?php echo $result['name']; ?>">
                                    </div>

                                    <div class="form-group">

                                        <label for="name" class="margin_top_label">Image :<span class="required" aria-required="true"> * </span></label>
                                        <?php if($result['image'] != ''){ ?>
                                        <input accept='image/*'  type="file" class="form-control name margin_top_input" id="image" name="image_edit" placeholder="Select Image" value="">
                                        
                                        <img id="loaded" src="<?php echo base_url().'public/images/'.$this->folder.'/category/'.$result['image']; ?>" height="150" width="200" style="margin-top: 10px;">
                                        <?php }else{ ?>
                                        <input accept='image/*' type="file" class="form-control margin_top_input" id="image" name="image" placeholder="Select Image" value="">
                                           
                                          
                                        <?php } ?>
                                         <div  class="img_preview">
                                           <br>
                                            <img src="" id="img_preview" width="200" height="150">
                                        </div>
                                        <div class="All_images"></div>
                                    </div>
                                   
                            </div>
                          
                            <div class="col-md-12 col-sm-12 col-xs-12">
                             <?php if($result['id']!=''){
                                    $btn = "Update Category";
                                    }else{
                                       $btn ="Add Category";
                                    } ?>

                             <a href="category_list" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>   
                             <input type="submit" class="btn btn-info pull-right margin_top_label" id="btnSubmit" value="<?php echo $btn; ?>" name="submit">
                            </div>
                        </div>
                    </form>
                </section>
            </div>
             <input type="hidden" id="base_url" value="<?=base_url()?>">
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


    var url = $('#base_url').val();
    $(document).ready(function(){
         // $('#name').trigger('click');
         $('#name').focus();
    });
    $('#category_form').validate({
        rules: {
            name: {
                required: true,
                remote: {
                    url: url+'category/isCategoryAvailable',
                    type: 'post',
                    data: {
                      id: function() {
                        return $("#id").val();
                        }
                    },
                },
            },
            image:{
                required: true,
                accept: "image/jpg,image/jpeg,image/png,image/gif"
            }, 
            image_edit:{
                
                accept: "image/jpg,image/jpeg,image/png,image/gif"
            }
        },
        messages: {
            name: {
                required: "Please enter category name",
                remote: "Category name already exist",
            },
            image:{
                required: "Please select image",
                accept: "Only image type jpg/png/jpeg/gif is allowed"
            },
            image_edit:{
                
                accept: "Only image type jpg/png/jpeg/gif is allowed"
            }
        },
        submitHandler: function (form) { 
           var id =  $('#id').val();
           if(id == ''){
                $('#btnSubmit').attr('disabled','disabled');  
                form.submit();
           }else{
                form.submit();
           }
        }
    });

    function check(){
        $res = '';
        $.ajax({
            url : url+'category/isCategoryAvailable',
            type : "post",
            data: {
                      id: function() {
                        return $("#id").val();
                        },
                      name : function() {
                        return $("#name").val();
                        }, 
                    },
            async:false,
            success : function (out) {
                $res = out;
            }
        })

        return $res ;
    }


    $(document).on('change','#image',function(){
        var imgpreview=DisplayImagePreview(this);
        $(".img_preview").show();


            setTimeout(function () {

                $('#cat').focus();
                $('#image').focus();

            },500)
     
    });
    setTimeout(function(){

    $("#name").trigger("click");
    },1000);
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