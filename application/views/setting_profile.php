<?php
include('header.php');
error_reporting(0);
$id =  $this->utility->decode($_REQUEST['id']);
if($id != ''){

    $query = $this->db->query("SELECT * FROM setting WHERE id = '$id'");
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
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'index.php/admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'index.php/admin/setting_list'; ?>">Setting</a> / Add</a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                        Add Setting
                    </header>
                    <form role="form" method="post" action="<?php echo base_url().'index.php/admin/setting_add_update'; ?>" name="setting_form" id="setting_form">
                        <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Title</label>
                                        <?php if($result['title'] != ''){ ?>
                                            <input type="text" class="form-control margin_top_input" id="title" name="title" placeholder="Enter title" value="<?php echo $result['title']; ?>" readonly>
                                        <?php } else { ?>
                                            <input type="text" class="form-control margin_top_input" id="title" name="title" placeholder="Enter title">
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Price</label>
                                        <input type="text" class="form-control margin_top_input" id="price" name="price" placeholder="Enter price" value="<?php echo $result['price']; ?>">
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

    $('#setting_form').validate({
        rules: {
            title: {
                required: true
            },
            price: {
                required: true,
                number: true
            }
        },
        messages: {
            title: {
                required: "Please enter title"
            },
            price: {
                required: "Please enter price",
                digits: "Please enter valid price"
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
</script>
<?php include('footer.php'); ?>