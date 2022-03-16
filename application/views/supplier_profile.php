<?php
include('header.php');
error_reporting(0);
$supplier_id = base64_decode($_GET['id']);

if($supplier_id != ''){
    // echo "SELECT * FROM supplier WHERE id = '$supplier_id'";exit;
    $query = $this->db->query("SELECT * FROM supplier WHERE id = '$supplier_id'");
    $row = $query->result();
}

$country_query = $this->db->query("SELECT * FROM country WHERE status != '9' ORDER BY id ASC ");
$country_row = $country_query->result();

?>

<div class="col-md-12 col-sm-12 col-xs-12">
<section id="main-content">

    <form role="form" method="post" action="<?php echo base_url() . 'index.php/supplier/add_supplier'; ?>" enctype="multipart/form-data" id="form_supplier">

        <input type="hidden" name="id" class="form-control" value="<?php echo ($supplier_id != '')? $row['0']->id : ''; ?>" id="id">

        <section class="wrapper wrapper1 panel">
            <header class="panel-heading"> <?php echo ($supplier_id != '' ? 'Update':'Add'); ?> Supplier Details</header>
            <p class="sub_title"></p>
            <div class="panel-body">
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">

                <div class="customer">
                    <div class="form-group">
                        <label for="name">Supplier Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Supplier Name" value="<?php echo ($supplier_id != '')? $row['0']->name : ''; ?>" id="name" >
                    </div>
                    <div class="form-group">
                        <label for="handle">Default Markup</label>
                        <input type="text" name="markup" class="form-control" placeholder="Default Markup" value="<?php echo ($supplier_id != '')? $row['0']->default_markup : ''; ?>" id="markup" >
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                <div class="customer">
                    <div class="form-group">
                        <label for="name">Description</label>
                        <textarea class="form-control" name="description" placeholder="Description" rows="5" ><?php echo ($supplier_id != '')? $row['0']->description : ''; ?></textarea>
                    </div>
                </div>
            </div>
            </div>
        </section>

        <section class="wrapper wrapper2 panel">
            <header class="panel-heading"> Contact Info</header>
            <p class="sub_title"></p>
            <div class="panel-body">
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">

                <div class="customer">
                    <div class="form-group">
                        <label for="name">First Name</label>
                        <input type="text" name="fname" class="form-control" value="<?php echo ($supplier_id != '')? $row['0']->fname : ''; ?>" id="fname"  placeholder="First Name">
                    </div>
                    <div class="form-group">
                        <label for="handle">Company</label>
                        <input type="text" name="company" class="form-control" value="<?php echo ($supplier_id != '')? $row['0']->company : ''; ?>" id="company"  placeholder="Company">
                    </div>
                    <div class="form-group">
                        <label for="handle">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo ($supplier_id != '')? $row['0']->phone : ''; ?>" id="phone"  placeholder="Phone">
                    </div>
                    <div class="form-group">
                        <label for="handle">Fax</label>
                        <input type="text" name="fax" class="form-control" value="<?php echo ($supplier_id != '')? $row['0']->fax : ''; ?>" id="fax"  placeholder="Fax">
                    </div>
                    <div class="form-group">
                        <label for="handle">Twitter</label>
                        <input type="url" name="twitter" class="form-control" value="<?php echo ($supplier_id != '')? $row['0']->twitter : ''; ?>" id="twitter"  placeholder="Twitter">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                <div class="customer">
                    <div class="form-group">
                        <label for="name">Last Name</label>
                        <input type="text" name="lname" class="form-control" value="<?php echo ($supplier_id != '')? $row['0']->lname : ''; ?>" id="lname"  placeholder="Last Name">
                    </div>
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo ($supplier_id != '')? $row['0']->email : ''; ?>" id="email"  placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="name">Mobile</label>
                        <input type="text" name="mobile" class="form-control" value="<?php echo ($supplier_id != '')? $row['0']->mobile : ''; ?>" id="mobile"  placeholder="Mobile">
                    </div>
                    <div class="form-group">
                        <label for="name">Website</label>
                        <input type="url" name="website" class="form-control" value="<?php echo ($supplier_id != '')? $row['0']->website : ''; ?>" id="website"  placeholder="Website">
                    </div>
                </div>
            </div>
            </div>
        </section>

        <section class="wrapper wrapper2 panel">
            <header class="panel-heading"> Address</header>
            <p class="sub_title"></p>
            <div class="panel-body">
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">

                <div class="customer">
                    <div class="form-group">
                        <label for="name">Street</label>
                        <input type="text" name="street1" class="form-control" value="<?php echo ($supplier_id != '')? $row['0']->street_1 : ''; ?>" id="street1"  placeholder="Street 1">
                    </div>
                    <div class="form-group">
                        <label for="handle">State</label>
                        <input type="text" name="state" class="form-control" value="<?php echo ($supplier_id != '')? $row['0']->state : ''; ?>" id="state"  placeholder="State">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                <div class="customer">
                    <div class="form-group">
                        <label for="name">Street</label>
                        <input type="text" name="street2" class="form-control" value="<?php echo ($supplier_id != '')? $row['0']->street_2 : ''; ?>" id="street2"  placeholder="Street 2">
                    </div>
                    <div class="form-group">
                        <label for="name">Country</label>
                        <select class="form-control" name="country" >
                            <option selected disabled value="">---Select Country---</option>
                            <?php foreach($country_row as $country){ ?>
                                <option value="<?php echo $country->id; ?>" <?php if($row['0']->country_id == $country->id) { ?> selected <?php } ?> ><?php echo $country->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            </div>
        </section>
</div>
        <footer class="panel-footer text-right bg-light lter" style="margin-bottom:60px;">
            <input type="submit" id = "submitBtn" class="btn btn-success btn-s-xs" value="<?php echo ($supplier_id != '' ? 'Update':'Add'); ?> Supplier">
            <a href="<?php echo base_url().'index.php/supplier/index'; ?>" data-toggle='modal' class="btn btn-success btn-s-xs" name="cancel">Cancel</a>
        </footer>
    </form>
</section>

<style> label.error { color: red; font-weight: 500; } </style>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script>

<script>
    $('#form_supplier').validate({
        rules: {
            name: {
                required: true
            },
            markup: {
                required: true
            },
            fname: {
                required: true
            },
            company: {
                required: true
            },
            lname: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            mobile: {
                required: true,
                number:true
            },
            street1: {
                required: true
            },
            street2: {
                required: true
            },
            state: {
                required: true
            },
            country: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter supplier name"
            },
            markup: {
                required: "Please enter markup"
            },
            fname: {
                required: "Please enter first name"
            },
            company: {
                required: "Please enter company"
            },
            lname: {
                required: "Please enter last name"
            },
            email: {
                required: "Please enter email",
                email: "Please enter valid email"
            },
            mobile: {
                required: "Please enter mobile number",
                number:"Please enter only digits"
            },
            street1: {
                required: "Please enter street1"
            },
            street2: {
                required: "Please enter street2"
            },
            state: {
                required: "Please enter state"
            },
            country: {
                required: "Please select country"
            }
        },
        error: function(label) {
            $(this).addClass("error");
        }
    });
    
    $(document).on('submit','#form_supplier',function(){
        
        $('#submitBtn').attr('disabled',true);
        
    });
</script>

<?php include('footer.php'); ?>