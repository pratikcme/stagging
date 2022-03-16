<?php include('header.php');
   error_reporting(0);
   $id = $this->utility->decode($_GET['id']);
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
            top: -4em !important;
            left: 4% !important;
     }
   </style>
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
               <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a>/<a href="<?php echo base_url().'staff'; ?>">Staff</a> /<?php echo $reqName.' Staff'; ?></a></li>
            </ul>
            <!--breadcrumbs end -->
         </div>
      </div>
      <div class="row">
         <!--Left Part-->
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <section class="panel">
               <header class="panel-heading">
                  <?php echo $reqName; ?> Staff
               </header>
               <form role="form" method="post" action="<?php echo base_url().'staff/staff_add_update'; ?>" name="vendor_form" id="vendor_form">
                  <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                  <input type="hidden" id="web" name="web" value="1">
                  <div class="panel-body">
                     <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                              <label for="" class="margin_top_label">Enter  Name :<span class="required" aria-required="true"> * </span>
                              </label>                            
                              <input type="text" name="name"  id="name" placeholder="Enter Name" autocomplete="off" class="form-control margin_top_input" value="<?php if(isset($result['name'])){ echo $result['name']; }else{ echo set_value('name'); } ?>">
                               <span style="color: red;"><?php echo form_error('name'); ?></span>
                           </div>


                           <div class="form-group">                            
                              <label class="margin_top_label">Enter Email Address :<span class="required" aria-required="true"> * </span>
                              </label> 
                              <input type="hidden" name="hidden_email" value="<?php if(isset($result['email'])){ echo $result['email']; }?>">
                              <input type="email"  id="email"  <?php if(!empty($id)){echo "disabled";} ?> name="email" placeholder="Email Address" autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($result['email'])){ echo $result['email']; }else{ echo set_value('email'); } ?>" <?php if(isset($result['email'])){ ?> readonly <?php } ?>>
                              <span style="color: red;"><?php echo form_error('email'); ?></span>
                           </div>
                         
                          <div class="form-group">                            
                              <label class="margin_top_label">Enter Vehicle Number :<span class="required" aria-required="true"> * </span>
                              </label> 
                              <input type="text"  id="vehicle_number" name="vehicle_number" placeholder="Enter vehicle number"  class="form-control margin_top_input" value="<?php if(isset($result['vehicle_number'])){ echo $result['vehicle_number']; }else{ echo set_value('vehicle_number'); } ?>">
                               <span style="color: red;"><?php echo form_error('vehicle_number'); ?></span>
                           </div>

                           
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">                            
                              <label class="margin_top_label">Enter Mobile :<span class="required" aria-required="true"> * </span>
                              </label> 
                               <input type="hidden"  name="hidden_m" id="mb" value="<?php if(isset($result['id'])){ echo $result['id']; } ?>" >
                              <input type="hidden"  name="hidden_mobile" value="<?php if(isset($result['phone_no'])){ echo $result['phone_no']; } ?>" >
                              <input type="text"  name="mobile" id="mobile" placeholder="Mobile" autocomplete="off" class="form-control margin_top_input" value="<?php if(isset($result['phone_no'])){ echo $result['phone_no']; }else{ echo set_value('mobile'); } ?>" maxlength="15" onkeypress="validatestaff(event)">
                                <span style="color: red;"><?php echo form_error('mobile'); ?></span> 
                           </div>


                           <div class="form-group">                            
                              <label class="margin_top_label">Enter Password :<span class="required" aria-required="true"> * </span>
                              </label> 
                              <input type="password"  id="password" name="password" placeholder="Password" autocomplete="new-password" class="form-control margin_top_input" value="<?php if(isset($result['password'])){ echo $result['password']; }else{ echo set_value('password'); } ?>" <?php if(isset($result['password'])){ ?> readonly <?php } ?> >
                               <span style="color: red;"><?php echo form_error('password'); ?></span>
                           </div>

                           <div class="form-group">                            
                              <label class="margin_top_label">Enter Vehicle Name :<span class="required" aria-required="true"> * </span>
                              </label> 
                              <input type="text"  id="vehicle_name" name="vehicle_name" placeholder="Enter vehicle name"  class="form-control margin_top_input" value="<?php if(isset($result['vehicle_name'])){ echo $result['vehicle_name']; }else{ echo set_value('vehicle_name'); } ?>">
                               <span style="color: red;"><?php echo form_error('vehicle_name'); ?></span>
                           </div>


                        </div>
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- <span class="panel-body padding-zero" > -->
                        <a href="<?=base_url().'staff'?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>
                       <input type="submit" class="btn btn-info pull-right margin_top_label" value="<?php echo $reqName.' Staff'; ?>" name="submit1">
                        <!-- </span> -->
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
 <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeCDbEPFYP5aVlxPzE8ZDE2O3I_pelYOM&v=3.exp&libraries=places"></script> -->
       <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
   </body>
<script type="text/javascript">

    $('#vendor_form').validate({
              rules: {
                  name: {
                      required: true,
                    
                  },email: {
                      required: true,
                      email: true,
                      remote: {
                          url: "<?php echo base_url().'staff/get_valid_emails' ?>",
                          type: "post",                         
                       }
                  },password: {
                      required: true,
                       minlength:6,
                  },mobile: {
                      required: true,
                      digits: true,
                      minlength:10,
                      maxlength:15,
                      remote: {
                          url: "<?php echo base_url().'staff/get_valid_mobiles' ?>",
                          type: "post", 
                          data: {
                             hidden_m: function() {
                             return $("#mb").val();
                          }                             
                       }
                   }
                  },
                  location: {
                      required: true,
                     
                  },
                  // vehicle_number: {
                  //     required: true,
                     
                  // },
                  // vehicle_name: {
                  //     required: true,
                     
                  // },
              },
              messages: {
                  name: {
                      required: "Please enter name",
                     
                  },email: {
                      required: "Please enter email address",
                      email: "Please enter valid email",
                      remote : "This email is already exist in system"
                  },password: {
                      required: "Please enter password",
                      minlength: "Please enter minimum 6 digit valid password"
                  },mobile: {
                      required: "Please enter mobile number",
                      digits: "Please enter valid mobile number",
                      minlength:"Please enter valid mobile number",
                      maxlength:"Please enter valid 15 digit valid number",
                      remote:"This mobile number is already exist in system"
                  },
                  location: {
                      required: "Please Select location",
                     
                  },
                  // vehicle_number: {
                  //     required: "Please Select vehicle number",
                     
                  // },
                  // vehicle_name: {
                  //     required: "Please Select vehicle name",
                     
                  // },
              },
             
          });

            // setTimeout(function () { $('#registered').hide(); }, 6000);
            // setTimeout(function () { $('#name').removeAttr('disabled');
			// $('#email').removeAttr('disabled');
			// $('#mobile').removeAttr('disabled');

</script>
<script type="text/javascript">
     function validatestaff(evt) {
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