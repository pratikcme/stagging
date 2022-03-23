<?php
include('header.php');
error_reporting(0);
$id = $this->utility->decode($_GET['id']);
$vendor_id = $this->session->userdata['id'];
$subscription_query = $this->db->query("SELECT * FROM subscription WHERE id = '$id'");
$subscription_result = $subscription_query->result();

$vendor_query = $this->db->query("SELECT * FROM vendor WHERE status ='1'");
$vendor_result = $vendor_query->result();

$subs_query = $this->db->query("SELECT value FROM set_default WHERE request_id = '4'");
$subs_charge = $subs_query->result();
$count = count($subs_charge);

//if($count <= 0){
//echo 1;
//    $this->session->set_flashdata('msg', 'Subcategory has been updated successfully');
//}
$charge = $subs_charge[0]->value;

//if($id != ''){
//    $query = $this->db->query("SELECT * FROM subcategory WHERE id = '$id' AND vendor_id = '$vendor_id'");
//    $result = $query->row_array();
//    $category_id = $result['category_id'];
//
//    $cat_query = $this->db->query("SELECT * FROM category WHERE id = '$category_id' AND vendor_id = '$vendor_id'");
//    $cat_result = $cat_query->row_array();
//}
?>
<?php
if ($id != '') {
    $reqName = "Update";
} else {
    $reqName = "Add";
}
?>

    <style type="text/css">
        .required {
            color: red;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href="<?php echo base_url() . 'public/css/jquery-ui.css' ?>">
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li class="active"><a href=""><i class="fa fa-home"></i> <a
                                        href="<?php echo base_url() . 'admin/dashboard'; ?>">Home</a> / <a
                                        href="<?php echo base_url() . 'subscription'; ?>">Subscription</a>
                                / Add</a></li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>
            <div id="msg" style="display: none">
                <?php if ($count <= 0) { ?>
                    <div class="alert alert-danger fade in">
                        <strong>Warning!</strong> <?php echo "Please enter the month charge of subscription"; ?>
                    </div>
                <?php } ?>
            </div>
            <div class="row">
                <!--Left Part-->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Add Subscription
                        </header>
                        <form role="form" method="post"
                              action="<?php echo base_url() . 'subscription/subscription_add_update'; ?>"
                              name="subscription_form" id="subscription_form">
                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                            <div class="panel-body">
                                <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="margin_top_label">Select Vendor <span
                                                        class="required" aria-required="true"> * </span></label>
                                            <select id="vendor" name="vendor" class="form-control">
                                                <option value="">Select vendor</option>

                                                <?php foreach ($vendor_result as $result) { ?>
                                                    <option <?php if (!empty($id)) {
                                                        if ($subscription_result[0]->vendor_id == $result->id) {
                                                            echo "selected";
                                                        }
                                                    } ?> value="<?php echo $result->id; ?>"> <?php echo $result->name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <label id="vendor-error" class="error" for="vendor"></label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="margin_top_label">Subscription Start Date <span
                                                        class="required" aria-required="true"> * </span></label>
                                            <input readonly class="form-control" value="<?php if (!empty($id)) {
                                                echo $subscription_result[0]->start_date;
                                            } ?>" type="text" id="date" name="date" placeholder="Select date">
                                            <span id="er" style="color: red;"></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="margin_top_label">Month : <span
                                                        class="required" aria-required="true"> * </span></label>
                                            <select id="month" name="month" class="form-control">
                                                <option value="">Select month</option>
                                                <?php for ($i = 1; $i < 13; $i++) { ?>
                                                    <option value="<?php echo $i; ?>"> <?php echo $i; ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="margin_top_label">Total Amount<span
                                                        class="required" aria-required="true"> * </span></label>
                                            <input class="form-control" value="<?php if (!empty($id)) {
                                                echo $subscription_result[0]->total_ammount;
                                            } ?>" type="text" id="total" name="total"
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <a href="<?=base_url().'subscription'?>" style="float: right; margin-right: 10px;" id="delete_user"
                                       class="btn btn-danger">Cancel</a>
                                    <input type="submit" class="btn btn-info pull-right margin_top_label"
                                           value="Add Subscription" name="submit">
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
    <style> label.error {
            color: red;
            font-weight: 500;
        } </style>
    <script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- <script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script> -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

    <script type="text/javascript">

        $('#msg').hide();


        $('#vendor').change(function () {

            var id = $(this).val();

            $.ajax({

                type: 'POST',
                url: 'get_date',
                data: {'id': id},
                success: function (result) {

                    $('#date').val(result);
                }
            })
        });
        // $("#date").datepicker({
        //     changeMonth: true,
        //     changeYear: true,
        //     dateFormat: 'yy-mm-dd',
        //     minDate: 0, // 0 days offset = today
        //     onSelect: function(date, instance) {
        //
        //         var vendor = $('#vendor').val();
        //         var date = date;
        //         $.ajax({
        //
        //             type:'POST',
        //             url:'checkvendor',
        //             data:{'vendor':vendor,'date':date},
        //             success:function (result) {
        //
        //                 if(result == 0){
        //                     $('#er').html("Vendor have already subscribed");
        //                     $('.btn-info').attr('disabled','disabled');
        //                 }
        //                 else{
        //                     $('#er').html("");
        //                     $('.btn-info').removeAttr('disabled');
        //                 }
        //
        //             }
        //
        //         })
        //
        //
        //     }
        // });
        $('#vendor').select2();
        $('#subscription_form').validate({
            rules: {
                // date: {
                //     required: true
                // },
                vendor: {
                    required: true
                },
                month: {
                    required: true
                },
                total: {
                    required: true,
                    number: true
                }

            },
            messages: {
                // date: {
                //     required: "Please enter select date"
                // },
                vendor: {
                    required: "Please select vendor"
                },
                month: {
                    required: "Please select month"
                },
                total: {
                    required: "Please enter amount",
                    number: "Please enter valid amount"
                }
            },
            error: function (label) {
                $(this).addClass("error");
            },
            submitHandler: function (form) {
                $('.btn-info').attr('disabled', 'disabled');
                $(form).submit();
            }
        });

        $('#month').change(function () {
            var charge = "<?php echo $charge; ?>"

            if (charge == 0) {

                $('#msg').show();
                $('.btn-info').attr('disabled', 'disabled');
            } else {
                $('#msg').hide();
                var month = $(this).val();
                var total = charge * month;
                $('#total').val(total);


            }
        })

        $('#date').blur(function () {
            $('#date-error').hide();
        })
        $('#vendor').change(function () {
            $('#vendor-error').hide();
        })
        $('#month').change(function () {
            $('#vendor-error').hide();
        })


    </script>
<?php include('footer.php'); ?>