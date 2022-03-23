<?php $this->load->view('header'); ?>


  <section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/index'; ?>">Home</a> / <a href="<?php echo base_url().'admins/team/team'; ?>">List</a> / Edit</a></li>
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
                    <header class="panel-heading"> Edit</header>
                       <form id="frmAddEdit" method="post" enctype="multipart/form-data" action="<?=base_url()?>admins/team/team/edit">
                          <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                            <input type="hidden" name="id" value="<?=@$getTeamSection[0]->id?>">
                          <label for="image" >Banner Image</label>
                             <input type = "hidden" name = "hidden_image"  id="hidden_image" value="<?php echo @$getTeamSection[0]->image ? $getTeamSection[0]->image : ''; ?>" size = "20" />

                            <input type = "file" name = "image" class="form-control" onchange="readUploadedImage(this)" size = "20" id="image" />
                             <?php if(@$getTeamSection[0]->image != '' ){?>
                              <div style="width: 500px;height: 300px ">
                                <div style="width: 100%;height: 100%; margin-top: 20px;" >
                                    <img id="ContentImage" src="<?=base_url()?>public/uploads/team/<?=$getTeamSection[0]->image?>" height="100%" width="100%">
                                </div>
                              </div>
                            <?php }else{ ?>
                            <div id='show1' class="hide" style="width: 150px;height: 150px; margin-top: 20px; display: none" >
                                <img id="ContentImage" src="" height="100%" width="100%">
                            </div>
                           <?php } ?>
                       </div>
                          <label for="image" class="error"></label>
                        <div class="form-group">
                          <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="<?=$getTeamSection[0]->name?>" class="form-control"/>
                          <label for="name" class="error"><?php echo @form_error('name'); ?></label>
                       </div>
                      <div class="form-group">
                          <label for="designation">Designation</label>
                            <input type="text" id="designation" name="designation" value="<?=$getTeamSection[0]->designation?>" class="form-control">
                          <label for="designation" class="error"><?php echo @form_error('designation'); ?></label>
                       </div>
                          <div class="form-group">
                          <label for="facebook">Facebook</label>
                            <input type="text" id="facebook" name="facebook" value="<?=$getTeamSection[0]->facebook?>" class="form-control">
                          <label for="facebook" class="error"><?php echo @form_error('facebook'); ?></label>
                       </div>
                           <div class="form-group">
                          <label for="twitter">Twitter</label>
                            <input type="text" id="twitter" name="twitter" class="form-control" value="<?=$getTeamSection[0]->twitter?>">
                          <label for="twitter" class="error"><?php echo @form_error('twitter'); ?></label>
                       </div>
                          <div class="form-group">
                          <label for="instagram">Instagram</label>
                            <input type="text" id="instagram" name="instagram" value="<?=$getTeamSection[0]->instagram ?>" class="form-control">
                          <label for="instagram" class="error"><?php echo @form_error('instagram'); ?></label>
                       </div>
                          <div class="form-group">
                          <label for="vemeo">Vemeo</label>
                            <input type="text" id="vemeo" name="vemeo" value="<?=$getTeamSection[0]->vemeo?>" class="form-control">
                          <label for="vemeo" class="error"><?php echo @form_error('vemeo'); ?></label>
                            <div class="form-group">
                          <label for="linkedin">LinkedIn</label>
                            <input type="text" id="linkedin" name="linkedin" value="<?=$getTeamSection[0]->linkedin?>" class="form-control">
                          <label for="linkedin" class="error"><?php echo @form_error('linkedin'); ?></label>
                       </div>
                       </div>
                         <div class="col-md-12 col-sm-12 col-xs-12">
                                <!-- <span class="panel-body padding-zero" > -->
                                <a href="<?=base_url().'admins/team/team'?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>
                                 <input type="submit" class="btn btn-info pull-right margin_top_label" id="btnSubmit" name="submit" value="Update">
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
