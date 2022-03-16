<?php $this->load->view('header'); ?>


  <section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/index'; ?>">Home</a> / list</a></li>
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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading"> Add</header>
                       <form id="frmAddEdit" method="post" enctype="multipart/form-data" action="<?=base_url()?>admins/team/team/add">
                          <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label for="image" >Choose Image</label>
                      
                         <input type = "file" name = "image" class="form-control" onchange="readUploadedImage(this)" size = "20" id="image" />

                    <div id='show1' class="" style="width: 150px;height: 150px; margin-top: 20px; display: none" >
                        <img id="ContentImage" src="" height="100%" width="100%">
                    </div>

                     </div>
                     <label for="image" class="error"></label>
                      <div class="form-group">
                          <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control">
                          <label for="name" class="error"><?php echo @form_error('name'); ?></label>
                       </div>
                        <div class="form-group">
                          <label for="designation">Designation</label>
                            <input type="text" id="designation" name="designation" class="form-control">
                          <label for="designation" class="error"><?php echo @form_error('designation'); ?></label>
                       </div>
                          <div class="form-group">
                          <label for="facebook">Facebook</label>
                            <input type="text" id="facebook" name="facebook" class="form-control">
                          <label for="facebook" class="error"><?php echo @form_error('facebook'); ?></label>
                       </div>
                         <div class="form-group">
                          <label for="twitter">Twitter</label>
                            <input type="text" id="twitter" name="twitter" class="form-control">
                          <label for="twitter" class="error"><?php echo @form_error('twitter'); ?></label>
                       </div>
                         <div class="form-group">
                          <label for="instagram">Instagram</label>
                            <input type="text" id="instagram" name="instagram" class="form-control">
                          <label for="instagram" class="error"><?php echo @form_error('instagram'); ?></label>
                       </div>
                         <div class="form-group">
                          <label for="vemeo">Vemeo</label>
                            <input type="text" id="vemeo" name="vemeo" class="form-control">
                          <label for="vemeo" class="error"><?php echo @form_error('vemeo'); ?></label>
                       </div>
                         <div class="form-group">
                          <label for="linkedin">LinkedIn</label>
                            <input type="text" id="linkedin" name="linkedin"class="form-control">
                          <label for="linkedin" class="error"><?php echo @form_error('linkedin'); ?></label>
                       </div>
                         <div class="col-md-12 col-sm-12 col-xs-12">
                                <!-- <span class="panel-body padding-zero" > -->
                                <a href="<?=base_url().'admins/team/team'?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>
                                 <input type="submit" class="btn btn-info pull-right margin_top_label" id="btnSubmit" name="submit" value="Add">
                                <!-- </span> -->
                            </div>
                     </div>
                   </div>
                 </div>
                       </form>
                </section>
            </div>
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
<?php $this->load->view('footer'); ?>