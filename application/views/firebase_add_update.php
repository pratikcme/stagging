<?php $this->load->view('header.php'); ?>


 <section id="main-content">
      <section class="wrapper">
 <?php if($this->session->flashdata('myMessage') != '' ){
        echo $this->session->flashdata('myMessage');
 } ?>              
            <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / Add Edit  </li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                         Add Edit
                    </header>
                     <form id="frmAdd" method="post" enctype="multipart/form-data" action="<?=base_url().'firebase'?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                     <div class="form-group">
                                      <label for="user_firebase_key" >User Firebase Key</label>
                                        <input type="text" id="firebase_key" name="user_firebase_key" class="form-control" value="<?php echo @$getData[0]->user_firebase_key != '' ? $getData[0]->user_firebase_key : @set_value('user_firebase_key'); ?>">
                                      <label for="user_firebase_key" class="error"><?php echo @form_error('user_firebase_key'); ?></label>
                                      </div>
                                      <div class="form-group">
                                      <label for="staff_firebase_key" >Staff Firebase Key</label>
                                        <input type="text" id="staff_firebase_key" name="staff_firebase_key" class="form-control" value="<?php echo @$getData[0]->staff_firebase_key != '' ? $getData[0]->staff_firebase_key : @set_value('staff_firebase_key'); ?>">
                                      <label for="staff_firebase_key" class="error"><?php echo @form_error('staff_firebase_key'); ?></label>
                                      </div>
                                      <div class="form-group">
                                      <label for="delivery_firebase_key" >Delivery Firebase Key</label>
                                        <input type="text" id="delivery_firebase_key" name="delivery_firebase_key" class="form-control" value="<?php echo @$getData[0]->delivery_firebase_key != '' ? $getData[0]->delivery_firebase_key : @set_value('delivery_firebase_key'); ?>">
                                      <label for="delivery_firebase_key" class="error"><?php echo @form_error('delivery_firebase_key'); ?></label>
                                      </div>
                                  </div>
                                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                      <div class="form-group">
                                      <label for="key_id" >Key id</label>
                                        <input type="text" id="key_id" name="key_id" class="form-control" value="<?php echo @$getData[0]->key_id != '' ? $getData[0]->key_id : @set_value('key_id'); ?>">
                                      <label for="key_id" class="error"><?php echo @form_error('key_id'); ?></label>
                                      </div>
                                      <div class="form-group">
                                      <label for="team_id" >Team id</label>
                                        <input type="text" id="team_id" name="team_id" class="form-control" value="<?php echo @$getData[0]->team_id != '' ? $getData[0]->team_id : @set_value('team_id'); ?>">
                                      <label for="team_id" class="error"><?php echo @form_error('team_id'); ?></label>
                                      </div>
                                      <div class="form-group">
                                      <label for="user_bandle_id" >User Bandle Id</label>
                                        <input type="text" id="user_bandle_id" name="user_bandle_id" class="form-control" value="<?php echo @$getData[0]->user_bandle_id != '' ? $getData[0]->user_bandle_id : @set_value('user_bandle_id'); ?>">
                                      <label for="user_bandle_id" class="error"><?php echo @form_error('user_bandle_id'); ?></label>
                                      </div>

                                      <div class="form-group">
                                      <label for="staff_bandle_id" >Staff Bandle Id</label>
                                        <input type="text" id="staff_bandle_id" name="staff_bandle_id" class="form-control" value="<?php echo @$getData[0]->staff_bandle_id != '' ? $getData[0]->staff_bandle_id : @set_value('staff_bandle_id'); ?>">
                                      <label for="staff_bandle_id" class="error"><?php echo @form_error('staff_bandle_id'); ?></label>
                                      </div>
                                      <div class="form-group">
                                      <label for="google_plus_link" >Google+ link</label>
                                        <input type="text" id="google_plus_link" name="google_plus_link" class="form-control" value="<?php echo @$getData[0]->google_plus_link != '' ? $getData[0]->google_plus_link : @set_value('google_plus_link'); ?>">
                                      <label for="google_plus_link" class="error"><?php echo @form_error('google_plus_link'); ?></label>
                                      </div>
                                       <div class="form-group">
                                      <label for="firebase_token" >Firebase Token</label>
                                        <input type="text" id="firebase_token" name="firebase_token" class="form-control" value="<?php echo @$getData[0]->firebase_token != '' ? $getData[0]->firebase_token : @set_value('firebase_token'); ?>" <?=($getData[0]->firebase_token!='')? 'readonly': ''?>>
                                      <label for="firebase_token" class="error"><?php echo @form_error('firebase_token'); ?></label>
                                      </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                      <div class="form-group">
                                      <label for="delivery_bandle_id" >Delivery Bandle Id</label>
                                        <input type="text" id="delivery_bandle_id" name="delivery_bandle_id" class="form-control" value="<?php echo @$getData[0]->delivery_bandle_id != '' ? $getData[0]->delivery_bandle_id : @set_value('delivery_bandle_id'); ?>">
                                      <label for="delivery_bandle_id" class="error"><?php echo @form_error('delivery_bandle_id'); ?></label>
                                      </div>
                                      <div class="form-group">
                                        <label for="facebook_client_id" >Facebook Client Id</label>
                                        <input type="text" id="facebook_client_id" name="facebook_client_id" class="form-control" value="<?php echo @$getData[0]->facebook_client_id != '' ? $getData[0]->facebook_client_id : @set_value('facebook_client_id'); ?>">
                                        <label for="facebook_client_id" class="error"><?php echo @form_error('facebook_client_id'); ?></label>
                                      </div>
                                      <div class="form-group">
                                        <label for="facebook_secret_id" >Facebook Secret Id</label>
                                        <input type="text" id="facebook_secret_id" name="facebook_secret_id" class="form-control" value="<?php echo @$getData[0]->facebook_secret_id != '' ? $getData[0]->facebook_secret_id : @set_value('facebook_secret_id'); ?>">
                                        <label for="facebook_secret_id" class="error"><?php echo @form_error('facebook_secret_id'); ?></label>
                                      </div>
                                      <div class="form-group">
                                        <label for="google_client_id" >Google Client Id</label>
                                        <input type="text" id="google_client_id" name="google_client_id" class="form-control" value="<?php echo @$getData[0]->google_client_id != '' ? $getData[0]->google_client_id : @set_value('google_client_id'); ?>">
                                        <label for="google_client_id" class="error"><?php echo @form_error('google_client_id'); ?></label>
                                      </div>
                                       <div class="form-group">
                                      <label for="facebook_link" >Facebook Social media link</label>
                                        <input type="text" id="facebook_link" name="facebook_link" class="form-control" value="<?php echo @$getData[0]->facebook_link != '' ? $getData[0]->facebook_link : @set_value('facebook_link'); ?>">
                                      <label for="facebook_link" class="error"><?php echo @form_error('facebook_link'); ?></label>
                                      </div>
                                       <div class="form-group">
                                      <label for="firebase_node" >Firebase node</label>
                                        <input type="text" id="firebase_node" name="firebase_node" class="form-control" value="<?php echo @$getData[0]->firebase_node != '' ? $getData[0]->firebase_node : @set_value('firebase_node'); ?>" <?=($getData[0]->firebase_node!='')? 'readonly': ''?> >
                                      <label for="firebase_node" class="error"><?php echo @form_error('firebase_node'); ?></label>
                                      </div>
                                    </div>
                                  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> 
                                      <div class="form-group">
                                        <label for="google_secret_id" >Google Secret Id</label>
                                        <input type="text" id="google_secret_id" name="google_secret_id" class="form-control" value="<?php echo @$getData[0]->google_secret_id != '' ? $getData[0]->google_secret_id : @set_value('google_secret_id'); ?>">
                                        <label for="google_secret_id" class="error"><?php echo @form_error('google_secret_id'); ?></label>
                                      </div>
                                      <div class="form-group">
                                        <label for="android_app_link" >Android link</label>
                                        <input type="text" id="android_app_link" name="android_app_link" class="form-control" value="<?php echo @$getData[0]->android_app_link != '' ? $getData[0]->android_app_link : @set_value('android_app_link'); ?>">
                                        <label for="android_app_link" class="error"><?php echo @form_error('android_app_link'); ?></label>
                                      </div>
                                      <div class="form-group">
                                        <label for="ios_app_link" >Ios link</label>
                                        <input type="text" id="ios_app_link" name="ios_app_link" class="form-control" value="<?php echo @$getData[0]->ios_app_link != '' ? $getData[0]->ios_app_link : @set_value('ios_app_link'); ?>">
                                        <label for="ios_app_link" class="error"><?php echo @form_error('ios_app_link'); ?></label>
                                      </div>
                                      <div class="form-group">
                                        <label for="contact_number" >Contact number</label>
                                        <input type="text" id="contact_number" name="contact_number" class="form-control" value="<?php echo @$getData[0]->contact_number != '' ? $getData[0]->contact_number : @set_value('contact_number'); ?>">
                                        <label for="contact_number" class="error"><?php echo @form_error('contact_number'); ?></label>
                                      </div>
                                      <div class="form-group">
                                      <label for="instagram_link" >instagram link</label>
                                        <input type="text" id="instagram_link" name="instagram_link" class="form-control" value="<?php echo @$getData[0]->instagram_link != '' ? $getData[0]->instagram_link : @set_value('instagram_link'); ?>">
                                      <label for="instagram_link" class="error"><?php echo @form_error('instagram_link'); ?></label>
                                      </div>
                                      <div class="form-group">
                                      <label for="firebase_url" >Admin Bandle Id</label>
                                        <input type="text" id="admin_bandle_id" name="admin_bandle_id" class="form-control" value="<?php echo @$getData[0]->admin_bandle_id != '' ? $getData[0]->admin_bandle_id : @set_value('admin_bandle_id'); ?>">
                                      <label for="admin_bandle_id" class="error"><?php echo @form_error('admin_bandle_id'); ?></label>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> 
                                      <div class="form-group">
                                        <label for="contact_email" >Contact Email</label>
                                        <input type="text" id="contact_email" name="contact_email" class="form-control" value="<?php echo @$getData[0]->contact_email != '' ? $getData[0]->contact_email : @set_value('contact_email'); ?>">
                                        <label for="contact_email" class="error"><?php echo @form_error('contact_email'); ?></label>
                                      </div>
                                      <div class="form-group">
                                        <label for="contact_us_address" >Contact Us Address</label>
                                        <textarea type="text" id="contact_us_address" name="contact_us_address" class="form-control"><?php echo @$getData[0]->contact_us_address != '' ? $getData[0]->contact_us_address : @set_value('contact_us_address'); ?></textarea>
                                        <label for="contact_us_address" class="error"><?php echo @form_error('contact_us_address'); ?></label>
                                      </div>
                                      
                                      <div class="form-group">
                                      <label for="twitter_link" >Twitter link</label>
                                        <input type="text" id="twitter_link" name="twitter_link" class="form-control" value="<?php echo @$getData[0]->twitter_link != '' ? $getData[0]->twitter_link : @set_value('twitter_link'); ?>">
                                      <label for="twitter_link" class="error"><?php echo @form_error('twitter_link'); ?></label>
                                      </div>
                                      <div class="form-group">
                                      <label for="p8_file" >P8 file Name</label>
                                        <input type="text" id="p8_file" name="p8_file" class="form-control" value="<?php echo @$getData[0]->p8_file != '' ? $getData[0]->p8_file : @set_value('p8_file'); ?>">
                                      <label for="p8_file" class="error"><?php echo @form_error('p8_file'); ?></label>
                                      </div>
                                      <div class="form-group">
                                      <label for="firebase_url" >Firebase url</label>
                                        <input type="text" id="firebase_url" name="firebase_url" class="form-control" value="<?php echo @$getData[0]->firebase_url != '' ? $getData[0]->firebase_url : @set_value('firebase_url'); ?>" <?=($getData[0]->firebase_url!='')? 'readonly': ''?>>
                                      <label for="firebase_url" class="error"><?php echo @form_error('firebase_url'); ?></label>
                                      </div> 
                                </div>
                            </div>
                             
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <!-- <span class="panel-body padding-zero" > -->
                                <a href="<?=base_url().'admin/dashboard'?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>
                                 <input type="submit" class="btn btn-info pull-right margin_top_label" id="btnSubmit" value="<?php echo @$getData[0]->created_at != '' ? 'Update' : 'Add'; ?>" name="submit">
                                <!-- </span> -->
                            </div>
                        </div>
                         <input type="hidden" name="url" id="base_url" value="<?=base_url()?>">
                    </form>
                </section>
            </div>
            <!--Map Part-->
        </div>
      </section>
</section>
<script type="text/javascript">

      function readUploadedImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#ContentImage').attr('src', e.target.result);
                $('#show1').css('display','');

            }
            
            reader.readAsDataURL(input.files[0]);
        }
        $("#uploadimage").change(function(){
            readUploadedImage(this);
        });
    }
    
</script>
<?php $this->load->view('footer.php'); ?>