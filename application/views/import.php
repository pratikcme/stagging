<?php
include('header.php');
// error_reporting(E_ALL);
?>
<style>
    .error{
        color: red;
    }
</style>
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
               <div id="msg">
                <?php if ($this->session->flashdata('myMessage') != '') { 
                        echo $this->session->flashdata('myMessage') ;
                 } ?>
            </div>
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> /  Make Excel </li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>
            <div class="row">
                <!--Left Part-->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <section class="panel">

                        <form role="form" method="post" action="<?php echo base_url().'import/generate'; ?>" name="price_form" id="price_form">

                            <div class="panel-body">
                                  <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="margin_top_label">Select Type<span class="required" > * </span></label>
                                            <select name="type" class="form-control margin_top_input type">
                                                <option value="">Select For</option>
                                                    <option value="1">Insert Product</option>
                                                    <option value="2">Update Product Quantity</option>
                                            </select>
                                            <!-- <span id="err1" style="color: red;"></span> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="hidden" name="catgory_name" class="catgory_name">
                                            <label for="name" class="margin_top_label">Select Category<span class="required" > * </span></label>
                                            <select name="catgeory" class="form-control margin_top_input catgorySelct">
                                                <option value="">Select Category</option>
                                                <?php  foreach ($catgeory as $cat){ ?>
                                                    <option value="<?php echo $cat->id; ?>"><?php echo $cat->name?></option>
                                                <?php } ?>
                                            </select>
                                            <span id="err1" style="color: red;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
<!--                                    <a href="price_list" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>-->
                                    <input type="submit" class="btn btn-info pull-right margin_top_label" value="Download demo Excel" name="submit">
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
                <!--Map Part-->
            </div>
            <!-- page end-->
        </section>
    </section>
    <!--main content end-->
    <script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script>
        $('.catgorySelct').on('change',function(){
            var category = $(".catgorySelct option:selected").text();
            $('.catgory_name').val(category);
        })
        $('#price_form').validate({
            rules: {
                catgeory: {
                    required: true
                },
                type: {
                    required : true 
                }
            },
            messages: {
                catgeory: {
                    required: "Please select category"
                },
                type: {
                    required : "Please select type"
                }
            },
            error: function(label) {
                $(this).addClass("error");
            },
            submitHandler: function (form) {
                $(form).submit();
                $('.btn').attr('disabled','disabled');
            }
        });
    </script>
<?php include('footer.php'); ?>