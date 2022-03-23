<?php
include('header.php');
error_reporting(0);

?>
<?php 
    if($result['id']!=''){
        $reqName = "Update";
        }else{
           $reqName ="Add";
    } 
?>
<style type="text/css">
    .required{
         color: red;
         }
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'weight/weight_list'; ?>">Unit</a> / <?php echo $reqName; ?></a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $reqName; ?> Unit
                    </header>
                    <form role="form" method="post" action="<?php echo base_url().'weight/weight_add_update'; ?>" name="weight_form" id="weight_form">
                        <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Unit Name<span class="required" aria-required="true"> * </span></label>
                                        <input type="text" class="form-control margin_top_input" id="name" name="name" placeholder="Unit name" value="<?php echo $result['name']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <a href="weight_list" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a> 
                               <input type="submit" class="btn btn-info pull-right margin_top_label" value="<?php echo $reqName.' Unit'; ?>" name="submit">
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
<style> label.error { color: red; font-weight: 500; } </style>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script><script type="text/javascript">

    $('#weight_form').validate({
        rules: {
            name: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter unit name"
            }
        },
        error: function(label) {
            $(this).addClass("error");
        },
        submitHandler: function (form) {
            $('.btn').attr('disabled','disabled');
                $(form).submit();
                
            }
    });
</script>
<script type="text/javascript">
	
function testInput(event) {
   var value = String.fromCharCode(event.which);
   var pattern = new RegExp(/[a-zåäö ]/i);
   return pattern.test(value);
}

$('#name').bind('keypress', testInput);

</script>
<?php include('footer.php'); ?>