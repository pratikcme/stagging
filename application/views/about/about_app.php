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
                     <form id="frmAdd" method="post" enctype="multipart/form-data" action="<?=base_url()?>admins/about/about_app">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                              <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <label for ="content">About</label>
                                <textarea class="form-control" name="about" id="about"><?php echo @$getData[0]->about ? $getData[0]->about : ''; ?></textarea>
                                <label for="about" class="error"></label>
                              </div>
                              <div class="form-group">
                                <label for="website" >Website</label>
                                <input type="text" id="website" name="website" class="form-control" value="<?php echo @$getData[0]->website != '' ? $getData[0]->website : @set_value('website'); ?>">
                                <label for="website" class="error"><?php echo @form_error('website'); ?></label>
                              </div>
                              <div class="form-group">
                                <label for="contact_number" >Contact number</label>
                                <input type="text" id="contact_number" name="contact_number" class="form-control" value="<?php echo @$getData[0]->contact_number != '' ? $getData[0]->contact_number : @set_value('contact_number'); ?>">
                                <label for="contact_number" class="error"><?php echo @form_error('contact_number'); ?></label>
                              </div>
                              <div class="form-group">
                                <label for="email" >Email</label>
                                <input type="text" id="email" name="email" class="form-control" value="<?php echo @$getData[0]->email != '' ? $getData[0]->email : @set_value('email'); ?>">
                                <label for="email" class="error"><?php echo @form_error('email'); ?></label>
                              </div>
                            </div>
                          </div>
                             
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <!-- <span class="panel-body padding-zero" > -->
                                <a href="<?=base_url().'admin/dashboard'?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>
                                 
                                 <input type="submit" class="btn btn-info pull-right margin_top_label" value="<?php echo @$getData[0]->created_at != '' ? 'Update' : 'Add'; ?>" name="submit">
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