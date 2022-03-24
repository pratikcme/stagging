<?php
   include('header.php');
   error_reporting(0);
   $id = $this->utility->decode($_GET['id']);
   // echo $id;exit;


   // $vendor_id = $this->session->userdata['id'];
   if($id != ''){
       $query = $this->db->query("SELECT * FROM delivery_user WHERE id = '$id' ");
       $result = $query->row_array();

       
   }
   ?>
<?php 
   if($result['id']!=''){
       $reqName = "Update";
       }else{
          $reqName ="Add";
   } 
   ?>
    <style type="text/css">
       #myMap{
            height: 300px;
    width: 44%;
    top: -9em !important;
    left: 3% !important;
     }

    </style>
    <style>
       .btn.btn-info.pull-right {
        margin-right: 10px;
         }
         .panel-body .form-group {
              margin-bottom: 26px;
          }
        .img_preview {
            width: 300px;
                position: inherit;
            display: none;
        }
        img#img_preview {
            width: 300px;
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
        .required{
         color: red;
         }
         .abcd{
            opacity: 0;
         }
         .myMap{
            margin: 0 !important;
         }
       .id_img_preview {
           width: 300px;
           position: inherit;
           display: none;
       }
       img#id_img_preview {
           width: 300px;
       }
       /*.col-md-12.col-sm-12.col-xs-12.below {*/
       /*    margin-top: 16%;*/
       /*}*/

    </style>
<!--main content start-->
<section id="main-content">
   <section class="wrapper">
      <!-- page start-->
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb">
               <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'delivery/delivery_list'; ?>">Delivery</a> / <?php echo $reqName; ?></a></li>
            </ul>
            <!--breadcrumbs end -->
         </div>
      </div>
      <div class="row">
         <!--Left Part-->
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <section class="panel">
               <header class="panel-heading">
                  <?php echo $reqName; ?> Delivery
               </header>
               <form  enctype="multipart/form-data"  role="form" method="post" action="<?php echo base_url().'delivery/delivery_user'; ?>" name="vendor_form" id="vendor_form">
                  <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                  <input type="hidden" id="web" name="web" value="1">
                  <div class="panel-body">
                     <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                              <label for="" class="margin_top_label">Enter User Name :<span class="required" aria-required="true"> * </span>
                              </label>                            
                              <input type="text"  name="name" placeholder="User Name" autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($result['name'])){ echo $result['name']; }else{ echo set_value('name'); } ?>">
                               <span style="color: red;"><?php echo form_error('name'); ?></span>
                           </div>


                       
                            
                           <div class="form-group">                            
                              <label class="margin_top_label">Enter Email Address :<span class="required" aria-required="true"> * </span>
                              </label> 
                              <input type="hidden" name="hidden_email" value="<?php if(isset($result['email'])){ echo $result['email']; }?>">
                              <input type="email" id="email"  <?php if(!empty($id)){echo "disabled";} ?>  name="email" placeholder="Email Address" autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($result['email'])){ echo $result['email']; }else{ echo set_value('email'); } ?>">
                              <span style="color: red;"><?php echo form_error('email'); ?></span>
                           </div>

                         

                           <div class="form-group">
                              <label for="" class="margin_top_label">Enter Vehicle Name :<span class="required" aria-required="true"> * </span>
                              </label>                            
                              <input type="text" id="vehicle_name" name="vehicle_name" placeholder="EX:HONDA ACTIVA" autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($result['vehicle_name'])){ echo $result['vehicle_name']; }else{ echo set_value('vehicle_name'); } ?>">
                               <span style="color: red;"><?php echo form_error('vehicle_name'); ?></span>
                           </div>

                            <div class="form-group">
                              <label for="" class="margin_top_label">Enter Id Proof Number :<span class="required" aria-required="true"> * </span>
                              </label>                            
                              <input type="text" id="id_proof_number" name="id_proof_number" placeholder="Enter Id Proof Number " autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($result['id_proof_number'])){ echo $result['id_proof_number']; }else{ echo set_value('id_proof_number'); } ?>">
                               <span style="color: red;"><?php echo form_error('id_proof_number'); ?></span>
                           </div>

                           <div class="form-group">
                                <label for="name" class="margin_top_label">Id Proof Image<span class="required" aria-required="true"> * </span></label>
                                <?php if($result['id'] != ''){ ?>

                                <input accept='image/*'  type="file" class="check form-control name margin_top_input" id="id_image" name="id_image_edit" placeholder="Select Image" value="">

                                <img id="id_loaded" src="<?php echo base_url().'public/images/delivery_id/'.$result['id_proof_image']; ?>" width="200" height="150" style="margin-top: 10px;position: absolute;">
                                <?php }else{ ?>

                                <input accept='image/*' type="file" class="check form-control margin_top_input" id="id_image" name="id_image" placeholder="Select Image" value="">
                                <?php } ?>


                                <div class="id_img_preview">
                                   <br>
                                      <img src="" id="id_img_preview"  width="200" height="150">
                                  </div>
                                <div class="All_images" id="click"></div>
                            </div>
                     
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                         
                           <div class="form-group">                            
                              <label class="margin_top_label">Enter Mobile :<span class="required" aria-required="true"> * </span>
                              </label> 
                              <input type="hidden"  name="hidden_m" id="mb" value="<?php if(isset($result['id'])){ echo $result['id']; } ?>" >
                              <input type="hidden"  name="hidden_mobile"  value="<?php if(isset($result['phone_no'])){ echo $result['phone_no']; } ?>" >
                              <input type="text"   name="mobile" placeholder="Mobile" autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($result['phone_no'])){ echo $result['phone_no']; }else{ echo set_value('mobile'); } ?>" maxlength="15"  onkeypress="validate(event)" >
                           </div>

                           <div class="form-group">                            
                              <label class="margin_top_label">Enter Password :<span class="required" aria-required="true"> * </span>
                              </label> 
                              <input type="password"  <?php if(!empty($id)){echo "disabled";} ?> name="password" placeholder="Password" autocomplete="new-password" class="dis form-control margin_top_input" value="<?php if(isset($result['password'])){ echo $result['password']; }else{ echo set_value('password'); } ?>">
                               <span style="color: red;"><?php echo form_error('password'); ?></span>
                           </div>
                          
                             <div class="form-group">
                              <label for="" class="margin_top_label">Enter Vehicle type :<span class="required" aria-required="true"> * </span>
                              </label>                            
                              <input type="text" id="vahicle_type" name="vehicle_type" placeholder="EX:Bike/Car/Truck.." autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($result['vehicle_type'])){ echo $result['vehicle_type']; }else{ echo set_value('vehicle_type'); } ?>">
                               <span style="color: red;"><?php echo form_error('vehicle_type'); ?></span>
                           </div>

                            <div class="form-group">
                              <label for="" class="margin_top_label">Enter Vehicle number :<span class="required" aria-required="true"> * </span>
                              </label>                            
                              <input type="text" id="vahicle_number" name="vehicle_number" placeholder="EX:GJ01AE8080" autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($result['vehicle_number'])){ echo $result['vehicle_type']; }else{ echo set_value('vehicle_number'); } ?>">
                               <span style="color: red;"><?php echo form_error('vehicle_number'); ?></span>
                           </div>

                            <div class="form-group">
                                <label for="name" class="margin_top_label">Profile Picture<span class="required" aria-required="true"> * </span></label>
                                <?php if($result['id'] != ''){ ?>
                                <input accept='image/*'  type="file" class="check form-control name margin_top_input" id="image" name="image_edit" placeholder="Select Image" value="">
                                <img id="loaded" src="<?php echo base_url().'public/images/delivery_profile/'.$result['image']; ?>" width="200" height="150" style="margin-top: 10px;position: absolute;">
                                <?php }else{ ?>
                                <input accept='image/*' type="file" class="check form-control margin_top_input" id="image" name="image" placeholder="Select Image" value="">
                                <?php } ?>
                                 <label id="image-error" class="error" for="image"></label>

                                <div class="img_preview">
                                   <br>
                                      <img src="" id="img_preview"  width="200" height="150">
                                  </div>
                                <div class="All_images" id="click"></div>
                            </div>

                          
                        </div>
                     </div>

                  </div>

                   <div class="col-md-12 col-sm-12 col-xs-12">
                       <!-- <span class="panel-body padding-zero" > -->
                       <a href="<?php echo base_url().'delivery/delivery_list'; ?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>
                       <input type="submit" class="btn btn-info pull-right margin_top_label" value="<?php echo $reqName; ?>" name="submit1">
                       <!-- </span> -->
                   </div>
               </form>
                 <div id="myMap" class="myMap"> </div>
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
 <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeCDbEPFYP5aVlxPzE8ZDE2O3I_pelYOM&v=3.exp&libraries=places"></script> -->
   </body>
<script type="text/javascript">
// setTimeout(function(){
//   $('.dis').removeAttr('disabled');
// },700);
  


    $('#vendor_form').validate({

              rules: {
                  name: {
                      required: true,
                    },
                  vehicle_name:{
                      required: true,
                    },
                  vehicle_type:{
                      required: true,
                    },
                  vehicle_number:{
                      required: true,
                    },
                  email: {
                      required: true,
                      email: true,
                      remote: {
                          url: "<?php echo base_url().'delivery/get_valid_email' ?>",
                          type: "post",                         
                       }
                    },
                  password: {
                      required: true,
                      minlength:6,
                    },
                  mobile: {
                        required: true,
                        digits: true,
                        minlength:10,
                        maxlength:15,
                        remote: {
                          url: "<?php echo base_url().'delivery/get_valid_mobile' ?>",
                          type: "post",
                          data: {
                             hidden_m: function() {
                             return $("#mb").val();
                              }                         
                          }
                        }
                    },
                  id_proof_number:{
                    required : true,
                  },
                   
                  image:{
                    required: true,
                    accept: "image/jpg,image/jpeg,image/png,image/gif"
                  }, 
                  image_edit:{
                      accept: "image/jpg,image/jpeg,image/png,image/gif"
                  },
                  id_image:{
                    required: true,
                    accept: "image/jpg,image/jpeg,image/png,image/gif"
                  }, 
                  id_image_edit:{
                      accept: "image/jpg,image/jpeg,image/png,image/gif"
                  }
              },
              messages: {
                  name: {
                      required: "Please enter user name",
                     
                  },
                  vehicle_name:{
                      required: "Please enter vehicle name",
                  },
                  vehicle_type:{
                      required: "Please enter vehicle type",
                  },
                  id_proof_number:{
                      required: "Please enter id proof number",
                  },
                  vehicle_number:{
                      required: "Please enter vehicle number",
                  },
                  email: {
                      required: "Please enter email",
                      email: "Please enter valid email",
                      remote : "This email is already exist"
                  },password: {
                      required: "Please enter password",
                      minlength: "Please enter minimum 6 digit valid password"
                  },mobile: {
                      required: "Please enter mobile number",
                      digits: "Please enter valid mobile number",
                      minlength:"Please enter valid mobile number",
                      maxlength:"Please enter 15 digit valid number",
                      remote:"This mobile is already exist"
                  },
                   address:{
                    required : "Please enter address",
                    maxlength : "Please enter address less than 500 characters"
                  },
                  location: {
                      required: "Please Select location",
                  },
                  image:{
                      required: "Please select image",
                      accept: "Only image type jpg/png/jpeg/gif is allowed"
                  },
                  image_edit:{                      
                      accept: "Only image type jpg/png/jpeg/gif is allowed"
                  },
                  id_image:{
                      required: "Please select image",
                      accept: "Only image type jpg/png/jpeg/gif is allowed"
                  },
                  id_image_edit:{                      
                      accept: "Only image type jpg/png/jpeg/gif is allowed"
                  }
              },
             
          });


   
    $(document).on('change','#image',function(){

        var imgpreview=DisplayImagePreview(this);
        $(".img_preview").css("display","block");
        
        setTimeout(function () {
                      $('#shop').focus();
                      $('#image').focus();
        
        },500);

     
    });
    function DisplayImagePreview(input){
    
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img_preview').attr('src', e.target.result);
            }
            // $("#name").trigger("focus");
             $('#image-error').remove();
             $('#loaded').hide();
            reader.readAsDataURL(input.files[0]);
        }
        validateFileType();

}
$(document).on('change','#id_image',function(){

        var imgpreview=DisplayImagePreviewID(this);
        $(".id_img_preview").css("display","block");
        
        setTimeout(function () {
                      $('#shop').focus();
                      $('#id_image').focus();
        
        },500);

     
    });
    function DisplayImagePreviewID(input){
    
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#id_img_preview').attr('src', e.target.result);
            }
            // $("#name").trigger("focus");
             $('#id_image-error').remove();
             $('#id_loaded').hide();
            reader.readAsDataURL(input.files[0]);
        }
        validateIdFileType();

}

function validateIdFileType(){

    var fileName = $("#id_image").val();
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
        $('#id_img_preview').show();
      
     
       
    }else{

     $('#id_image-error').html('Only image type jpg/png/jpeg/gif is allowed');
      
        $('#id_img_preview').attr("style","display: none;");   
       
    }   
}

function validateFileType(){

    var fileName = $("#image").val();
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
        $('#img_preview').show();
      
     
       
    }else{

     $('#image-error').html('Only image type jpg/png/jpeg/gif is allowed');
      
        $('#img_preview').attr("style","display: none;");   
       
    }   
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