<?php
include('header.php');
error_reporting(0);

$user_id = $_REQUEST['user_id'];
$id = $_REQUEST['id'];

$user_id = $this->utility->decode($_REQUEST['user_id']);
if($id != ''){
    $query = $this->db->query("SELECT * FROM user_address WHERE id = '$id'");
    $result = $query->row_array();
}
?>

<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'index.php/admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'index.php/admin/user_address_list?user_id='.$user_id; ?>">User Address</a> / Add</a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                        Add User Address
                    </header>
                    <form role="form" method="post" action="<?php echo base_url().'index.php/admin/user_address_add_update'; ?>" name="user_address_form" id="user_address_form">
                        <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Address</label>
                                        <input type="text" class="form-control margin_top_input" id="address" name="address" placeholder="Enter address" value="<?php echo $result['address']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="submit" class="btn btn-info pull-right margin_top_label" value="Submit" name="submit">
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
<script type="text/javascript">

    $('#user_address_form').validate({
        rules: {
            address: {
                required: true
            }
        },
        messages: {
            address: {
                required: "Please enter address"
            }
        },
        error: function(label) {
            $(this).addClass("error");
        },
        submitHandler: function (form) {
                $(form).submit();
                    $('.btn').attr('disabled',true);
                
            }
    });

    google.maps.event.addDomListener(window, 'load', function () {
        var places = new google.maps.places.Autocomplete(document.getElementById('address'));
        google.maps.event.addListener(places, 'place_changed', function () {});
    });
</script>
<?php include('footer.php'); ?>