<?php $this->load->view('header.php')?>
<section id="main-content">
 <?php if($this->session->flashdata('myMessage') != '' ){
        echo $this->session->flashdata('myMessage');
 } ?>              
      <section class="wrapper">
            <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'home_content'; ?>">List</a> / Edit </a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                         Edit
                    </header>
                     <form id="frmAddEdit" method="post" enctype="multipart/form-data" action="<?=base_url()?>home_content/edit">
                      <input type="hidden" name="update_id" value="<?=$this->utility->safe_b64encode($getAboutSectionTwo[0]->id)?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                          <div class="form-group">
                          <label for="image" >Image</label>
                             <input type = "hidden" name = "hidden_image"  id="hidden_image" value="<?php echo @$getAboutSectionTwo[0]->image ? $getAboutSectionTwo[0]->image : ''; ?>" size = "20" />

                            <input type = "file" name="image" class="form-control" onchange="readUploadedImage(this)" size = "20" id="image" />

                             <?php if(@$getAboutSectionTwo[0]->image != '' ){ ?>
                              <div style="width: 500px;height: 300px ">
                                <div style="width: 100%;height: 100%; margin-top: 20px;" >
                                    <img id="ContentImage" src="<?=base_url()?>public/uploads/home_content/<?=$getAboutSectionTwo[0]->image?>" height="100%" width="100%">
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
                          <label for="main_title">Main Title</label>
                            <input type="text" id="main_title" name="main_title" class="form-control" value="<?=$getAboutSectionTwo[0]->main_title?>">
                          <label for="name"  class="error"><?php echo @form_error('main_title'); ?></label>
                       </div>

                        <div class="form-group">
                        <label for ="sub_title"></label>
                        <textarea class="form-control " name="sub_title" id="sub_title"><?=$getAboutSectionTwo[0]->sub_title?></textarea>
                        <label for="sub_title" class="error"><?php echo @form_error('sub_title'); ?></label>
                       </div>
                                </div>
                            </div>
                             
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <!-- <span class="panel-body padding-zero" > -->
                                <a href="<?=base_url().'admins/about/about_section_two'?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>
                                 <input type="submit" class="btn btn-info pull-right margin_top_label" name="submit" value="Update">
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
<?php $this->load->view('footer.php')?>
