<?php $this->load->view('header'); ?>


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
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/index'; ?>">Home</a> / <a href="<?php echo base_url().'admins/term'; ?>">List</a> / Edit</a></li>
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
                       <form id="frmAddEdit" method="post" enctype="multipart/form-data" action="<?=base_url()?>admins/term/update">
                          <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                          <div class="form-group">
                            <input type="hidden" name="id" value="<?=$this->utility->safe_b64encode($editRecord[0]->id)?>">
                          <label for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control" value="<?=$editRecord[0]->title?>">
                          <label for="title" class="error"><?php echo @form_error('title'); ?></label>
                       </div>
                       <div class="form-group">
                        <label for ="sub_title">Sub title</label>
                        <textarea class="form-control ckeditor" name="sub_title" id="sub_title"><?=$editRecord[0]->sub_title?></textarea>
                        <label for="sub_title" class="error"></label>
                       </div>
                         
                       </div>
                         <div class="col-md-12 col-sm-12 col-xs-12">
                                <!-- <span class="panel-body padding-zero" > -->
                                <a href="<?=base_url().'admins/term'?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>
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

<?php $this->load->view('footer'); ?>
