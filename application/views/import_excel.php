<?php
include('header.php');
?>
    <style>
       label.error{
            color: red;
        }
    </style>
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!-- page start-->
            <div id="msg">
                <?php if ($this->session->flashdata('myMessage') != '') { 
                        echo $this->session->flashdata('myMessage') ;
                 } ?>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> /Import Excel </li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>
            <div class="row">
                <!--Left Part-->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <section class="panel">

                        <form role="form" method="post" action="<?php echo base_url().'import/importExcelFile'; ?>" id="import_excel" enctype="multipart/form-data">

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
                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label for="name" class="margin_top_label">Select Category<span class="required"> * </span></label>
                                        <select name="catgeory" class="form-control margin_top_input catgorySelct">
                                            <option value="">Select Category</option>
                                            <<?php foreach ($category as $key => $value): ?>
                                                <option value="<?=$value->id?>"><?=$value->name?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 padding-zero" style="margin-top: 25px">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="margin_top_label">Select File<span class="required" aria-required="true"> * </span></label>
                                            <input type="file" name="file" id="file" required/>
                                            <span id="err1" style="color: red;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
<!--                                    <a href="price_list" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>-->
                                    <input type="submit" id="submit" class="btn btn-info pull-right margin_top_label" value="Import Excel" name="submit">
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.js"></script>

    <script>

        $('#file').change(function () {
            var filename = $(this).val();
            var ext = /^.+\.([^.]+)$/.exec(filename);
            var extension = ext == null ? "" : ext[1];

            $('#file-error').hide();

            if(extension != "xls" && extension != "xlsx"){
                $('#err1').html("Please select excel file");
                $('#submit').attr('disabled','disabled')
            }
            else{
                $('#err1').html("");
                $('#submit').removeAttr('disabled');
            }


        });

        $('#import_excel').validate({
            rules: {
                file: {
                    required: true,
                },
                type : {
                    required : true,
                },
                catgeory : {
                    required : true,
                }
            },
            messages: {
                file: {
                    required: "Please select file",
                },
                type : {
                    required : "Please select type",
                },
                catgeory : {
                    required : "Please select category",
                }
            },
        });
    </script>
<?php include('footer.php'); ?>