<?php $this->load->view('header.php'); ?>


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
                     <form id="frmAdd" method="post" enctype="multipart/form-data" action="<?=base_url()?>home_content/home_section_one">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                     <div class="form-group">
                                      <label for="main_title" >Main Title1</label>
                                        <input type="text" id="main_title1" name="main_title1" class="form-control" value="<?php echo @$getData[0]->main_title1 != '' ? $getData[0]->main_title1 : @set_value('main_title1'); ?>">
                                      <label for="main_title1" class="error"><?php echo @form_error('main_title1'); ?></label>
                                      </div>
                                       <div class="form-group">
                                          <label for ="number1">Number1</label>
                                          <input class="form-control" name="number1" value="<?php echo @$getData[0]->number1 ? $getData[0]->number1 : ''; ?>">
                                          <label for="number1" class="error"></label>
                                         </div>

                                            <div class="form-group">
                                              <label for="image1">Image1</label>
                                                 <input type = "hidden" name = "hidden_image1"  id="hidden_image1" value="<?php echo @$getData[0]->image1 ? $getData[0]->image1 : ''; ?>" size = "20" />

                                                <input type = "file" name = "image1" class="form-control" onchange="readUploadedImage(this)" size = "20" id="image1" />
                                                 <?php if(@$getData[0]->image1 != '' ){?>
                                                  <div style="width: 150px;height: 150px">
                                                    <div style="width: 100px;height: 100px; margin-top: 20px;" >
                                                        <img id="ContentImage1" src="<?=base_url()?>public/uploads/home_content/<?=$getData[0]->image1?>" height="100%" width="100%" style="background:black">
                                                    </div>
                                                  </div>
                                                <?php }else{ ?>
                                                <div id='show1' class="hide" style="width: 150px;height: 150px; margin-top: 20px; display: none" >
                                                    <img id="ContentImage1" src="" height="100%" width="100%">
                                                </div>
                                               <?php } ?>
                                           </div>
                                              <label for="image1" class="error"></label>
                                </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                     <div class="form-group">
                                      <label for="main_title2" >Main Title2</label>
                                        <input type="text" id="main_title2" name="main_title2" class="form-control" value="<?php echo @$getData[0]->main_title2 != '' ? $getData[0]->main_title2 : @set_value('main_title2'); ?>">
                                      <label for="main_title2" class="error"><?php echo @form_error('main_title2'); ?></label>
                                      </div>
                                       <div class="form-group">
                                         <label for ="number2">Number2</label>
                                          <input class="form-control" name="number2" value="<?php echo @$getData[0]->number2 ? $getData[0]->number2 : ''; ?>">
                                          <label for="number2" class="error"></label>
                                         </div>

                                            <div class="form-group">
                                              <label for="image2">Image1</label>
                                                 <input type = "hidden" name = "hidden_image2"  id="hidden_image2" value="<?php echo @$getData[0]->image2 ? $getData[0]->image2 : ''; ?>" size = "20" />

                                                <input type = "file" name = "image2" class="form-control" onchange="readUploadedImage2(this)" size = "20" id="image2" />
                                                 <?php if(@$getData[0]->image2 != '' ){?>
                                                  <div style="width: 150;height: 150 ">
                                                    <div style="width: 100px;height: 100px; margin-top: 20px;" >
                                                        <img id="ContentImage" src="<?=base_url()?>public/uploads/home_content/<?=$getData[0]->image2?>" height="100%" width="100%" style="background:black">
                                                    </div>
                                                  </div>
                                                <?php }else{ ?>
                                                <div id='show2' class="hide" style="width: 150px;height: 150px; margin-top: 20px; display: none" >
                                                    <img id="ContentImage2" src="" height="100%" width="100%">
                                                </div>
                                               <?php } ?>
                                           </div>
                                              <label for="image2" class="error"></label>
                                </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                     <div class="form-group">
                                      <label for="main_title3" >Main Title3</label>
                                        <input type="text" id="main_title3" name="main_title3" class="form-control" value="<?php echo @$getData[0]->main_title3 != '' ? $getData[0]->main_title3 : @set_value('main_title3'); ?>">
                                      <label for="main_title3" class="error"><?php echo @form_error('main_title3'); ?></label>
                                      </div>
                                       <div class="form-group">
                                          <label for ="number3">Number3</label>
                                          <input class="form-control" name="number3" value="<?php echo @$getData[0]->number3 ? $getData[0]->number3 : ''; ?>">
                                          <label for="number3" class="error"></label>
                                         </div>

                                            <div class="form-group">
                                              <label for="image3">Image3</label>
                                                 <input type = "hidden" name = "hidden_image3"  id="hidden_image3" value="<?php echo @$getData[0]->image3 ? $getData[0]->image3 : ''; ?>" size = "20" />

                                                <input type = "file" name = "image3" class="form-control" onchange="readUploadedImage3(this)" size = "20" id="image" />
                                                 <?php if(@$getData[0]->image3 != '' ){?>
                                                  <div style="width: 150;height: 150 ">
                                                    <div style="width: 100px;height: 100px; margin-top: 20px;" >
                                                        <img id="ContentImage3" src="<?=base_url()?>public/uploads/home_content/<?=$getData[0]->image3?>" height="100%" width="100%" style="background:black">
                                                    </div>
                                                  </div>
                                                <?php }else{ ?>
                                                <div id='show3' class="hide" style="width: 150px;height: 150px; margin-top: 20px; display: none" >
                                                    <img id="ContentImage3" src="" height="100%" width="100%">
                                                </div>
                                               <?php } ?>
                                           </div>
                                              <label for="image3" class="error"></label>
                                </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                     <div class="form-group">
                                      <label for="main_title4" >Main Title4</label>
                                        <input type="text" id="main_title4" name="main_title4" class="form-control" value="<?php echo @$getData[0]->main_title4 != '' ? $getData[0]->main_title4 : @set_value('main_title4'); ?>">
                                      <label for="main_title4" class="error"><?php echo @form_error('main_title4'); ?></label>
                                      </div>
                                       <div class="form-group">
                                         <label for ="number4">Number4</label>
                                          <input class="form-control" name="number4" value="<?php echo @$getData[0]->number4 ? $getData[0]->number4 : ''; ?>">
                                          <label for="number4" class="error"></label>
                                         </div>

                                            <div class="form-group">
                                              <label for="image4">Image</label>
                                                 <input type = "hidden" name = "hidden_image4"  id="hidden_image4" value="<?php echo @$getData[0]->image4 ? $getData[0]->image4 : ''; ?>" size = "20" />

                                                <input type = "file" name = "image4" class="form-control" onchange="readUploadedImage4(this)" size = "20" id="image4" />
                                                 <?php if(@$getData[0]->image4 != '' ){?>
                                                  <div style="width: 150;height: 150 ">
                                                    <div style="width: 100px;height: 100px; margin-top: 20px;" >
                                                        <img id="ContentImage4" src="<?=base_url()?>public/uploads/home_content/<?=$getData[0]->image4?>" height="100%" width="100%" style="background:black">
                                                    </div>
                                                  </div>
                                                <?php }else{ ?>
                                                <div id='show4' class="hide" style="width: 150px;height: 150px; margin-top: 20px; display: none" >
                                                    <img id="ContentImage4" src="" height="100%" width="100%">
                                                </div>
                                               <?php } ?>
                                           </div>
                                              <label for="image4" class="error"></label>
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
                $('#ContentImage1').attr('src', e.target.result);
                $('#show1').removeClass('hide');
                $('#show1').css('display','');

            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

      function readUploadedImage2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#ContentImage2').attr('src', e.target.result);
                $('#show2').removeClass('hide');
                $('#show2').css('display','');

            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
      function readUploadedImage3(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#ContentImage3').attr('src', e.target.result);
                $('#show3').removeClass('hide');
                $('#show3').css('display','');

            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

        function readUploadedImage4(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#ContentImage4').attr('src', e.target.result);
                $('#show4').removeClass('hide');
                $('#show4').css('display','');

            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
</script>
<?php $this->load->view('footer.php'); ?>