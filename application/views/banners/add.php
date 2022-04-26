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
               <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'banners'; ?>">List</a> /Add </a></li>
            </ul>
            <!--breadcrumbs end -->
         </div>
      </div>
      <div class="row">
         <!--Left Part-->
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <section class="panel">
               <header class="panel-heading">
                  Add
               </header>
               <form id="frmAddEdit" method="post" enctype="multipart/form-data" action="<?=$FormAction?>">
                  <input type="hidden" id="id" name="id" value="">
                  <div class="panel-body">
                     <div class="row">
                         <div class="col-md-6 col-sm-12 col-xs-12 padding-zero">
                            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                               <div class="form-group">
                                  <label for="image" >App Banners</label>
                                  <input type = "file" name = "app_banner_image" class="form-control" onchange="app_readUploadedImage(this)" size = "20" id="app_image" />
                                  <div id='show1' class="" style="width: 150px;height: 150px; margin-top: 20px; display: none" >
                                     <img id="app_ContentImage" src="#" height="100%" width="100%">
                                  </div>
                               </div>
                               <label for="image"  style="color: red" class="error"></label>
                               
                               <div class="form-group">
                                  <label for="type">Type</label>
                                  <select class="form-control" name="type" id="type" disabled>
                                      <option value="">Select Type</option>
                                      <option value="1">Simple</option>
                                      <option value="2">Category wise</option>
                                      <option value="3">Product varient wise</option>
                                  </select>
                                 <label for="type" style="color: red" class="error"><?php echo @form_error('type'); ?></label>
                               </div>
                               <div class="form-group" style="display:none">
                                  <label for="type">Category</label>
                                  <select class="form-control" name="category_id" id="category">
                                      <option value="">Select Category</option>
                                  </select>
                               </div>
                               <div class="form-group" style="display:none">
                                  <label for="type">Product</label>
                                  <select class="form-control" name="product_id" id="product">
                                      <option value="">Select product</option>
                                  </select>
                               </div>
                               <div class="form-group" style="display:none">
                                  <label for="type">Product varient</label>
                                  <select class="form-control" name="product_varient_id" id="product_varient">
                                      <option value="">Select product varient</option>
                                  </select>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-6 col-sm-12 col-xs-12 padding-zero">
                            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                               <div class="form-group">
                                  <label for="image" >Web Banners</label>
                                  <input type = "file" name = "web_banner_image" class="form-control" onchange="web_readUploadedImage(this)" size = "20" id="web_image" />
                                  <div id='show2' class="" style="width: 150px;height: 150px; margin-top: 20px; display: none" >
                                     <img id="web_ContentImage" src="#" height="100%" width="100%">
                                  </div>
                               </div>
                               <label for="image"  style="color: red" class="error"></label>
                               <div class="form-group">
                                  <label for="branch">Branch</label>
                                  <select class="form-control" name="branch" id="branch">
                                      <option value="">Select Branch</option>
                                      <<?php foreach ($branchList as $key => $value): ?>
                                      <option value="<?=$value->id?>"><?=$value->name?></option>
                                      <?php endforeach ?>
                                  </select>
                               </div>
                               <div class="form-group">
                                  <label for="main_title">Main Title</label>
                                  <input type="text" id="main_title" name="main_title" class="form-control">
                                  <label for="main_title" style="color: red" class="error"><?php echo @form_error('main_title'); ?></label>
                               </div>
                               <div class="form-group" >
                                  <label for="sub_title">Sub Title</label>
                                  <input type="text" id="sub_title" name="sub_title" class="form-control">
                                  <label for="sub_title" style="color: red" class="error"><?php echo @form_error('sub_title'); ?></label>
                               </div>
                            </div>
                         </div>
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- <span class="panel-body padding-zero" > -->
                        <a href="<?=base_url().'admins/web_banners'?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>
                        <input type="submit" class="btn btn-info pull-right margin_top_label" value="<?php echo @$getData[0]->created_at != '' ? 'Update' : 'Add'; ?>" id="btnSubmit" name="submit">
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
   function app_readUploadedImage(input) {
     if (input.files && input.files[0]) {
         var reader = new FileReader();
         
         reader.onload = function (e) {
   
             $('#app_ContentImage').attr('src', e.target.result);
             $('#show1').css('display','');
   
         }
         
         reader.readAsDataURL(input.files[0]);
     }
     $("#app_image").change(function(){
         app_readUploadedImage(this);
     });
   }

   function web_readUploadedImage(input) {
     if (input.files && input.files[0]) {
         var reader = new FileReader();
         
         reader.onload = function (e) {
   
             $('#web_ContentImage').attr('src', e.target.result);
             $('#show2').css('display','');
   
         }
         
         reader.readAsDataURL(input.files[0]);
     }
     $("#web_image").change(function(){
         web_readUploadedImage(this);
     });
   }
   
</script>
<?php $this->load->view('footer.php')?>