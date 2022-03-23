<?php
include('header.php');
$vendor_id = $this->session->userdata['id'];
$email = $this->session->userdata('email');
if($email != ''){
    if($vendor_id==0){
        $app_query = $this->db->query("SELECT * FROM vendor WHERE email = '$email'"); 
    }else{
        $base_url = base_url();
        $app_query = $this->db->query("SELECT * FROM branch WHERE email = '$email' AND domain_name = '$base_url'");
    }
    $app_result = $app_query->row_array();
}

?>
<style type="text/css">
    .required{
         color: red;
         }
    .btns {
        background-color: #58c9f3;
        border-color:#58c9f3;
    } 
  .btns:hover {
        background-color: #58c9f3;
        border-color:#58c9f3;
  }
</style>
<section id="main-content">
    <form role="form" method="post" action="<?php echo base_url().'admin/change_password';  ?>" name="forgot_pass_form" id="forgot_pass_form">
        <input type="hidden" name="app_id" id="app_id" value="<?php echo $app_result['id']; ?>">
        <section class="wrapper site-min-height">

            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">

                <div id="message1" class="alert alert-danger fade in" style="display:none">
                    <strong>Oops something went wrong!</strong>
                </div> 
                <div id="message4" class="alert alert-danger fade in" style="display:none">
                    <strong>New password and conform password does not match.</strong>
                </div>
                 <div id="message3" class="alert alert-danger fade in" style="display:none">
                    <strong>Your old password was entered incorrectly. Please enter it again.</strong>
                </div>
                <div id="message2" class="alert alert-success fade in" style="display:none">
                    <strong>Successfully updated!</strong>
                </div>
                <div id="message5" class="alert alert-danger fade in" style="display:none">
                    <strong>Old password and new password can not be same. </strong>
                </div>
                    <section class="panel">
                        <header class="panel-heading"> Change Password </header>
                        <p class="sub_title"></p>
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <div class="customer">
                                <div class="form-group">
                                    <label for="">Old Password :<span class="required" aria-required="true"> * </span></label>
                                    <input type="password" name="old_pass" class="form-control" id="old_pass" placeholder="Old Password" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <div class="customer padding_dropdown margin_btm">
                                <div class="form-group">
                                    <label for="">New Password :<span class="required" aria-required="true"> * </span></label>
                                    <input type="password" name="new_pass" class="form-control" id="new_pass" placeholder="New Password" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Confirm Password :<span class="required" aria-required="true"> * </span></label>
                                    <input type="password" name="confirm_pass" class="form-control" id="confirm_pass" placeholder="Confirm Password" value="" required>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!-- page end-->
        </section>
        <footer class="panel-footer text-right bg-light lter">
          <!-- <a href="javascript:;" class="btn btn-info btn-xs"> -->
          <a href="javascript:;" class="">
            <input type="submit" name="submit" value="Update" class="btn btn-info btn-s-xs">
          </a>
            <a href="<?php echo base_url().'admin/dashboard'; ?>" data-toggle='modal' class="btn btn-danger btn-s-xs" name="cancel">Cancel</a>
        </footer>
    </form>

</section>
<!--main content end-->
<style> label.error { color: red; font-weight: 500; } </style>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script>
<script>
    setTimeout(function () { $('#msg').hide(); }, 6000);
    
    $('#forgot_pass_form').validate({
        rules: {
            old_pass: {
                required: true
            },
            new_pass: {
                required: true,
                 minlength:6,
            },
            confirm_pass: {
                required: true,               
                equalTo : "#new_pass",               
            }
        },
        messages: {
            old_pass: {
                required: "Please enter old password"
            },
            new_pass: {
                required: "Please enter new password",
                minlength:"Please enter 6 character valid password",
            },
            confirm_pass: {
                required: "Please enter confirm password",
               
                equalTo: "New password and confirm password does not match.",
            }
        },
        // error: function(label) {
        //     $(this).addClass("error");
        // }
        submitHandler: function (form) {
           err = changepass();
           if(err){
                $('#forgot_pass_form').submit();
           }
            return false;
        }

    });

    function changepass() {
        // bootbox.confirm("Are you sure you want to change password ?" , function (confirmed) {
        //     if (confirmed == true) {
                var old_pass =$('#old_pass').val();
                var new_pass =$('#new_pass').val();
                var confirm_pass =$('#confirm_pass').val();
                var appid = $('#app_id').val();
                $.ajax({
                    url: '<?php echo base_url().'admin/change_password'; ?>' ,
                    type : "POST",
                    data: {old_pass:old_pass , new_pass:new_pass , confirm_pass:confirm_pass , appid:appid},
                    success: function (responce) {
                        if (responce==1) {



				                   bootbox.confirm("Are you sure you want to change password ?" , function (confirmed) {
       										   if (confirmed == true) {
				                $.ajax({
				                    url: '<?php echo base_url().'admin/changed_password'; ?>' ,
				                    type : "POST",
				                    data: {old_pass:old_pass , new_pass:new_pass , confirm_pass:confirm_pass , appid:appid},
				                    success: function (responce) {


       										   	   $('#message2').attr('style','display:block');
						                           $('#old_pass').val(""); 
						                           $('#new_pass').val("");
						                           $('#confirm_pass').val("");


                                setTimeout(function () {
                                    // location.href = "admin/dashborad";
                                },3000);

       										   }
       									})




       								 }
       							})


                         
                        }else if (responce==2)
                        {                            
                           $('#message3').attr('style','display:block');
                        }
                        else if( responce == 3){
                            
                           $('#message4').attr('style','display:block');
                        }else if( responce == 4){
                            
                           $('#message5').attr('style','display:block');
                        }
                        else{
                            $('#message1').attr('style','display:block');
                        }  
                          setTimeout(function(){
                            $('#message1').hide();
                            $('#message2').hide();
                            $('#message3').hide();
                            $('#message4').hide();
                            $('#message5').hide();

                        },3000);
                    },
                    error: function () {
                        alert('Failed to chnage password.');
                    }
            
        });
    }
       

   

</script>
<?php include('footer.php'); ?>