<?php $this->load->view('header.php')?>


      <section class="wrapper">
 <section id="main-content">
 
 <?php if($this->session->flashdata('myMessage') != '' ){
        echo $this->session->flashdata('myMessage');
 } ?>              

            <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / Add </a></li>
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
                     <form id="frmAddEdit" method="post" enctype="multipart/form-data" action="<?=base_url()?>admins/contactinfo">
                        <input type="hidden" id="id" name="id" value="">
                       <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12"> 
                              <div class="form-group">
                                <label for ="location">Location</label>
                                <textarea class="form-control" name="location" id="location"><?php echo @$getData[0]->location ? $getData[0]->location : ''; ?></textarea>
                                <label for="location" class="error"></label>
                               </div>

                                  <div class="form-group">
                                <label for ="email">Email</label>
                                <textarea class="form-control" name="email" id="email"><?php echo @$getData[0]->email ? $getData[0]->email : ''; ?></textarea>
                                <label for="email" class="error"></label>
                               </div>

                              <div class="form-group">
                                <label for ="phone_no">Phone Us</label>
                                <textarea class="form-control" name="phone_no" id="phone_no"><?php echo @$getData[0]->phone_no ? $getData[0]->phone_no : ''; ?></textarea>
                                <label for="phone_no" class="error"></label>
                              </div>
                          </div>
                      </div>
                             
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <!-- <span class="panel-body padding-zero" > -->
                                <a href="<?=base_url().'admins/about/about_section_two'?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>
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
<?php $this->load->view('footer.php')?>

