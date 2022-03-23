<?php
include('header.php');
error_reporting(0);
$id = $this->utility->decode($_GET['id']);
$vendor_id = $this->session->userdata['id'];
if($id != ''){

    $query = $this->db->query("SELECT * FROM payment_method WHERE id = '$id'");
    $result = $query->row_array();
}
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
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'payment_method'; ?>">Payment method</a> / <?php echo $reqName; ?></a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $reqName; ?> Payment method
                    </header>
                    <form role="form" method="post" action="<?php echo base_url().'payment_method/add_update_payment_method'; ?>" name="payment_method_form" id="payment_method_form">
                        <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Payment Option<span class="required" aria-required="true"> * </span></label>
                                       <select class="form-control" id="payment_opt" name="payment_opt" <?=($result['id'] !='') ? "readonly" : "";?>>
                                            <option value="">Select- Payment Getway</option>
                                            <?php 
                                            foreach ($paymentGetwayData as $paymentGetwayVal) {
                                            ?>
                                            <option <?=($paymentGetwayVal->type == $result['payment_opt'])?'selected':''?> value="<?= $paymentGetwayVal->type?>"><?= $paymentGetwayVal->name?></option>
                                            <?php
                                            }
                                            ?>

                                       </select>
                                    </div>
                                </div>
                            </div>

                             <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Publish key Or Marchant Id for live<span class="required" aria-required="true"> * </span></label>
                                        <input type="text" class="form-control margin_top_input" id="publish_key" name="publish_key" placeholder="Publish Key Or Marchant Id" value="<?php echo $result['publish_key']; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Publish key Or Marchant Id For Test<span class="required" aria-required="true"> * </span></label>
                                        <input type="text" class="form-control margin_top_input" id="test_publish_key" name="test_publish_key" placeholder="Publish Key Or Marchant Id for Test" value="<?php echo $result['test_publish_key']; ?>">
                                    </div>
                                </div>
                            </div>

                             
                             <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Secret Key Or Marchant Key For Live<span class="required" aria-required="true"> * </span></label>
                                        <input type="text" class="form-control margin_top_input" id="secret_key" name="secret_key" placeholder="Secret Key Or Marchant Key for Live" value="<?php echo $result['secret_key']; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Secret Key Or Marchant Key for Test<span class="required" aria-required="true"> * </span></label>
                                        <input type="text" class="form-control margin_top_input" id="test_secret_key" name="test_secret_key" placeholder="Secret Key Or Marchant Key For Test" value="<?php echo $result['test_secret_key']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <!-- <span class="panel-body padding-zero" > -->
                                <a href="<?=base_url().'payment_method'?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>
                                 <input type="submit" class="btn btn-info pull-right margin_top_label" id="method_btn" value="<?php echo $reqName.' Method'; ?>" name="submit">
                                <!-- </span> -->
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script> -->
<script type="text/javascript">
    
    $('#payment_method_form').validate({
        rules: {
            payment_opt: {
                required: true,
                  
            },
            publish_key:{required:true,
                //  remote:{
                //     url : "<?php echo base_url().'payment_method/check_publish_key'; ?>",
                //     type: "post",
                //     data:{payment_methodId:$('#id').val()}
                // }
            },
            secret_key:{required:true,
                //  remote:{
                //     url : "<?php echo base_url().'payment_method/check_secret_key'; ?>",
                //     type: "post",
                //      data:{payment_methodId:$('#id').val()}
                // }
            },  
        },
        messages: {
                payment_opt: {
                    required: "Please enter payment option",
            },
             publish_key:{required:"Please enter publish key OR marchant Id ",
               remote : "publish key already registered"
         },
            secret_key:{required:"Please enter secret key OR marchant key ", remote : "secret key already registered"},  
        },
        error: function(label) {
            $(this).addClass("error");
        },
        submitHandler: function (form) {
             $('.method_btn').attr('disabled','disabled');
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