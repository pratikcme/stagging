<?php
error_reporting(0);
   include('header.php');
    $myhidejs = 1;
   
   ?>
<style type="text/css">
   .ui-sortable-handle {
   touch-action: none;
   display: inline-block;
   margin: 0;
   padding: 0;
   float: none!important;
   }
   .alert {
        margin-top: -68px;
    width: 50%;
    /* float: right; */
    margin-left: 50%;
   }
   .ui-sortable-handle input[type=checkbox], input[type=radio] {position: relative; left: 93%; top: -50px; width: 18px; height: 18px;}
   .ui-sortable-handle a.btn {
       margin-left: 8px;
   }
</style>
<section id="main-content">
   <section class="wrapper">
      <!-- page start-->
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb">
               <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / Banner Promotion  <?php echo $reqName; ?></li>
            </ul>
            <!--breadcrumbs end -->
         </div>
      </div>
      <div class="row">
         <!--Left Part-->
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <section class="panel">
               <header class="panel-heading">
                  <?php echo $reqName; ?> Banner Promotion
               </header>
               <form role="form" method="post" id="form" action="<?php echo base_url() . 'banner_promotion/banner_promotion_add_update'; ?>" enctype="multipart/form-data">
                  <p class="sub_title"></p>
                  <div class="panel-body">
                      <div class="col-md-6 col-lg-12 col-sm-12 col-xs-12">
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
                         <div class="customer">
                           <div class="form-group">
                              <input type="checkbox" class="checkboxMain" style="height: 18px; width: 18px;">
                              <a href="#" id="delete_image" class="btn btn-success btn-s-xs">Delete Images</a>
                           </div>
                            <div id="image-list" class="form-group">
                               <?php  foreach($row as $image){ ?>
                               <div class="img" id="image_<?php echo $image->id; ?>" style="float: left; margin-right: 10px; margin-bottom: 20px;">
                                  <a href="javascript:;" onclick="single_delete(<?php echo $image->id; ?>)" style="float: right;" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                   <input type="checkbox" name="delete[]" id='iId' class="checkbox_user ui-sortable-handle" value="<?php echo $image->id; ?>">
                                  <img src="<?php echo base_url().'public/images/'.$this->folder.'banner_promotion/'.$image->image; ?>" style="height: 180px; width: 200px;">
                               </div>
                               <?php } ?>
                            </div>
                         </div>
                      </div>
                      <p class="sub_title"></p>
                      <div class="col-md-6 col-lg-12 col-sm-12 col-xs-12">
                        <div class="col-md-6 col-lg-6">
                          <div class="customer">
                            <label for="handle">Select Vendor</label>
                            <div class="form-group">
                              <select class="form-control" name="vendor_id" id="vendor">
                                <option value="">Select Branch</option>
                                <?php foreach ($vendor_list as $key => $value): ?>
                                  <option value="<?=$value->id?>"><?=$value->name?></option>
                                <?php endforeach ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                          <div class="customer">
                            <label for="handle">product list</label>
                            <div class="form-group">
                              <select class="form-control" name="product_id" id="product_list">
                                <option value="">Select product</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-12 col-sm-12 col-xs-12">
                         <div class="customer">
                            <div class="form-group">
                               <label for="handle">Add New Images</label>
                               <input accept='image/*' id="file-1" type="file" multiple class="file form-control" data-overwrite-initial="false" name="userfile[]" onchange="validateFileType()">
                            </div>
                         </div>
                         <div><span id="ERR" style="color: red;"></span></div>
                      </div>
                      <a href="<?php echo base_url().'banner_promotion/banner_promotion_list'; ?>" data-toggle='modal' class="btn btn-success btn-s-xs " style="float: right; margin-right: 14px;" name="cancel">Cancel</a>
                      <input type="submit" class="btn btn-success btn-s-xs" style="float: right; margin-right: 13px;" value="Update" name="update">
                   </form>
                   </div>
             </section>
            </div>
            <!--Map Part-->
        </div>
        <!-- page end-->
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
   $("#divid").hide();
   $('#form').validate({
           rules: {   
               vendor_id : { required : true },
                product_id : { required : true },
               'userfile[]':{
                   required: true,
                  accept: "image/jpg,image/jpeg,image/png,image/gif"
               }
           },
           messages: {
               vendor_id : { required : "Please select vendor id" },

               product_id : { required : "Please selectproduct id" },
               
               'userfile[]':{
                       required: "Please select Image",
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
   
       setTimeout( function(){$('#msg').hide();} , 4000);
       /*Single Delete Script*/
       function single_delete(value) {
   
           bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
               if (confirmed == true) {
                   
                   var id = value;
                   $.ajax({
                       url: '<?php echo base_url().'banner_promotion/single_delete_banner_promotion/'; ?>' ,
                       data: {
                           ids: id.toString(),
                           url: '<?php echo base_url().'banner_promotion/single_delete_banner_promotion/'; ?>' ,
                       },
                       success: function (data) {
   
                           if (data.status == 1) {
                               bootbox.alert("Banner has been deleted successfully.", function() {
                                   window.location.reload(true);
                               });
                           }
                           else {
                               alert('Failed to delete selected banner.');
                           }
                       },
                       error: function () {
                           alert('Failed to delete selected banner.');
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
               $('#image-list div').each(function (index) {
   
                   // if(index <= dropIndex) {
   
                       var id = $(this).attr('id');
                       var split_id = id.split("_");
                       imageIdsArray.push(split_id[1]);
                   // }
               });
   
               $.ajax({
                   url: '<?php echo base_url() . 'banner_promotion/bannerimage_drag'; ?>',
                   type: 'post',
                   data: {imageIds: imageIdsArray},
                   success: function (response) {
                      
                   }
               });
               // e.preventDefault();
           };
       });

        /*Multi Delete Script*/
    $('#delete_image').click(function() {

        if($('.checkbox_user:checked').length == 0) {
            //alert("Select one record"); return false;
            bootbox.alert('Please select at least one record to delete');
            return;
        }
        bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
            if (confirmed == true) {
                var ids = [];
                $('.checkbox_user:checked').each(function() {
                    ids.push($(this).val());
                });
                $.ajax({
                    url: '<?php echo base_url().'banner_promotion/multi_delete_banner'; ?>',
                    data: { ids: ids.toString() },
                    success: function(data) {
                        if(data.status == 1) {

                            bootbox.alert("Banner image have been deleted successfully.", function() {
                                window.location.reload(true);
                            });
                        }
                        else {
                            bootbox.alert('Failed to delete the selected records.');
                        }
                    },
                    error: function() {
                        bootbox.alert('Failed to delete the selected records.');
                    }
                });
            }
            else
            {
                window.location.reload(true);
            }
        });
    });

    $(document).ready(function(){
        $('.checkboxMain').on('click',function(){
            if(this.checked){
                $('.checkbox_user').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox_user').each(function(){
                    this.checked = false;
                });
            }
        });

        $('.checkbox_user').on('click',function(){
            if($('.checkbox_user:checked').length == $('.checkbox_user').length){
                $('.checkboxMain').prop('checked',true);
            }else{
                $('.checkboxMain').prop('checked',false);
            }
        });
    });
</script>
<?php include('footer.php'); ?>