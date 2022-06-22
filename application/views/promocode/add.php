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
                                  <label for="name">Name</label>
                                  <input type="text" id="name" name="name" class="form-control">
                                  <label for="name" style="color: red" class="error"><?php echo @form_error('name'); ?></label>
                               </div>
                              <div class="form-group">
                                  <label for="max_cart">Maximum Cart Amount</label>
                                  <input type="text" id="max_cart" name="max_cart" class="form-control">
                                  <label for="max_cart" style="color: red" class="error"><?php echo @form_error('max_cart'); ?></label>
                               </div>

                              <div class="form-group">
                                  <label for="percentage">Percentage</label>
                                  <input type="number" id="percentage" name="percentage" class="form-control">
                                  <label for="percentage" style="color: red" class="error"><?php echo @form_error('percentage'); ?></label>
                              </div>
                              <div class="form-group">
                                  <label for="max_use">Max Allowed</label>
                                  <input type="text" id="max_use" name="max_use" class="form-control">
                                  <label for="max_use" style="color: red" class="error"><?php echo @form_error('max_use'); ?></label>
                              </div>


                            
                               
                              
                            </div>
                         </div>
                         <div class="col-md-6 col-sm-12 col-xs-12 padding-zero">
                            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                             
                               <div class="form-group">
                                  <label for="min_cart">Minimum Cart Amount</label>
                                  <input type="text" id="min_cart" name="min_cart" class="form-control">
                                  <label for="min_cart" style="color: red" class="error"><?php echo @form_error('min_cart'); ?></label>
                               </div>

                              <div class="form-group">
                                  <label for="start_date">Start Date</label>
                                  <input type="date" id="start_date" name="start_date" class="form-control">
                                  <label for="start_date" style="color: red" class="error"><?php echo @form_error('start_date'); ?></label>
                              </div>
                              <div class="form-group">
                                  <label for="end_date">End Date</label>
                                  <input type="date" id="end_date" name="end_date" class="form-control">
                                  <label for="end_date" style="color: red" class="error"><?php echo @form_error('end_date'); ?></label>
                              </div>

                            </div>
                         </div>
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- <span class="panel-body padding-zero" > -->
                        <a href="<?=base_url().'promocode_manage'?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>
                        <input type="submit" class="btn btn-info pull-right margin_top_label" value="Add" id="btnSubmit" name="submit">
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
<?php $this->load->view('footer.php')?>