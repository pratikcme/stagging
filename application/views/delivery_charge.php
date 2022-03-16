<?php
include('header.php');
error_reporting(0);
$id = $this->utility->decode($_GET['id']);
$vendor_id = $this->session->userdata['id'];
if ($id != '') {

    $query = $this->db->query("SELECT * FROM delivery_charge WHERE id = '$id'");
    $result = $query->row_array();
}
?>
<?php
if ($result['id'] != '') {
    $reqName = "Update";
} else {
    $reqName = "Add";
}
?>
    <style type="text/css">
        .required {
            color: red;
        }
        #delete {
            margin: 22px 0 0 -30px;
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
                        <li class="active"><a href=""><i class="fa fa-home"></i> <a
                                        href="<?php echo base_url() . 'admin/dashboard'; ?>">Home</a> / <a
                                        href="<?php echo base_url() . 'delivery_charge'; ?>">Delivery
                                    Charge</a> / <?php echo $reqName; ?></a></li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>
            <div class="row">
                <!--Left Part-->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $reqName; ?> Delivery Charge
                        </header>
                        <form role="form" method="post" action="<?php echo base_url() . 'delivery_charge/delivery_charge_add'; ?>"
                              name="city_form" id="city_form">
                                <input type="hidden" id="id" name="id" value="<?=($result['id'] != '') ? $result['id'] : ''; ?>">
                            <div class="panel-body row ">

                                <div class="col-md-4 col-sm-6 col-xs-6 padding-zero ">
                                    <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <div>
                                            <label for="start_range" class="margin_top_label">Start Range(in Km)
                                                <span class="required" aria-required="true"> * </span></label>
                                            <input type="text" class="start form-control margin_top_input commonclass"
                                                   id="start_range" onkeypress="validates(event)"
                                                   name="start_range" placeholder="Start Range"
                                                   value="<?php echo $result['start_range']; ?>">
                                            <span style="color: red;" class="err" ></span>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label for="end_range" class="margin_top_label">End Range(in Km)<span
                                                        class="required" aria-required="true"> * </span></label>
                                            <input type="text" class="end form-control margin_top_input commonclass" id="end_range"
                                                   name="end_range" placeholder="End Range" onkeypress="validates(event)"
                                                   value="<?php echo $result['end_range']; ?>">
                                            <span style="color: red;" class="error" ></span>
                                            <span style="color: red;" class="err" ></span>
                                        </div>
                                        <div class="form-group">
                                    <label for="price" class="margin_top_label">Price<span class="required">
                                            <input type="text" class="price form-control margin_top_input commonclass" id="price"
                                                   name="price" placeholder="Price" onkeypress="validates(event)"
                                                   value="<?php echo $result['price']; ?>">
                                            <span style="color: red" class="err"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <!-- <span class="panel-body padding-zero" > -->
                                    <a href="delivery_charge" style="float: right; margin-right: 10px;" id="delete_user"
                                       class="btn btn-danger">Cancel</a>
                                    <input type="submit" class="submit btn btn-info pull-right margin_top_label"
                                           value="<?php echo $reqName . ' Delivery Charge'; ?>" name="submit">
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
    <style> label.error {
            color: red;
            font-weight: 500;
        } </style>
    <script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

    <script type="text/javascript">

        $.validator.addMethod("validaterange", function(value, element) {
            var priceval = $('#start_range').val();

            priceval = parseInt(priceval);
            value = parseInt(value);


            if(priceval > value){
                return false;
            }else{
                return true;
            }
        }, "End range should be greater than start range");

        $('#city_form').validate({
            rules: {


                start_range :{
                    required: true,
                    remote: {
                        url: "<?php echo base_url().'delivery_charge/get_valid_start_range'?>",
                        type: "post",
                        data: { id: $('#id').val()},

                    }
                },
                price:{
                    required: true,
                },
                end_range :{
                    required: true,
                    remote: {
                        url: "<?php echo base_url().'delivery_charge/get_valid_end_range'?>",
                        type: "post",
                        data: { id: $('#id').val()},
                    },
                    validaterange:true

                }
            },
            messages: {
                start_range: {
                    required: "Please enter start range",
                    remote : "This range is already exist"
                },
                price:{
                    required: "Please enter price",
                },
                end_range: {
                    required: "Please enter end range",
                    remote : "This range is already exist"

                },
            },


            error: function (label) {
                $(this).addClass("error");
            },
            submitHandler: function (form) {

                error = getSkillError();
                if (error == 0) {
                    $('#submit').click(function () {
                        $(this).attr('disabled', true);
                    });
                    $('.btn').attr('disabled', 'disabled');
                    $('#city_form').submit();
                }
            }
        });
    </script>
    <script type="text/javascript">
        function validates(evt) {

            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode( key );
            var regex = /[0-9]|\./;
            if( !regex.test(key)) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
        }
    
    </script>
<?php include('footer.php'); ?>
