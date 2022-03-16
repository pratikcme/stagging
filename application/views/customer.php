<?php
include('header.php');
$user_id = $this->session->userdata('id');
$parent_user_id = $this->session->userdata('parent_id');
?>
<div class="col-md-12 col-sm-12 col-xs-12">
<section id="main-content">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb" style="margin-top: 6%">
                <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/index'; ?>">Home</a> <a href="<?php echo base_url().'customer/customer_list'?>">/ Customer List</a>/ Add Customer</a></li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>

	<form role="form" method="post" action="<?php echo base_url().'customer/insert_customer/';  ?>" enctype="" id="customer_form" name="customer_form">
		<section style="margin-top: 0px !important;" class="wrapper wrapper1 panel">
			<header class="panel-heading"> Add Customer</header>
			<div class="panel-body">
			<p class="sub_title">Please fill the information to continue</p>
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">

				<div class="customer">
					<div class="form-group">
						<label for="">Contact Name</label>
						<input type="text" name="txtCustomerName" class="form-control" id="txtCustomerName" placeholder="Contact Name" >
					</div>
					<div class="form-group">
						<label class="">Date of Birth</label>
						<div class="">
							<input name="txtDOB" id="txtDOB" class="form-control form-control-inline input-medium default-date-picker" size="16" type="text" value=""  placeholder="Date of Birth">
						</div>
					</div>
					<div class="form-group">
						<label for="">Company</label>
						<input type="text" name="txtCompany" class="form-control" id="txtCompany" placeholder="Company" >
					</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
				<div class="customer padding_dropdown margin_btm">
					<div class="form-group">
						<label for="">Customer Code</label>
						<input type="text" name="txtCustomerCode" class="form-control" id="txtCustomerCode" placeholder="Customer Code" readonly value="<?php echo 'CC'.strtotime(date('Y-m-d H:i:s')); ?>">
					</div>
					<div class="form-group">
						<label for="">Gender</label>
						<select name="txtGender" id="txtGender" class="form-control">
							<option value="1" >Male</option>
							<option value="0" >Female</option>
						</select>
					</div>
<!--					<div class="form-group">-->
<!--						<label for="">Password:</label>-->
<!--						<input type="password" autocomplete="new-password" class="form-control" id="password_cust" placeholder="Password"  name="password_cust">-->
<!--					</div>-->
					<div class="form-group">
						<label for="">Group:</label>
						<select name="customer_group" id="customer_group" class="form-control">
							<option value="" selected disabled>Select Group</option>
							<?php foreach ($group_result as $result){ ?>
								<option value="<?php echo $result->id; ?>" ><?php echo $result->name; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			</div>
		</section>
		<section class="wrapper2 panel">
			<header class="panel-heading"><i class="fa fa-user"></i> Contact Information</header>
			<p class="sub_title"></p>
			<div class="panel-body">
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
				<div class="customer">
					<div class="form-group">
						<label for="">Email:</label>
						<input type="email" name="txtEmail" class="form-control" id="txtEmail" placeholder="Email" >
					</div>
					<div class="form-group">
						<label for="">Phone Number</label>
						<input type="text" name="txtPhoneNumber" class="form-control" id="txtPhoneNumber" placeholder="Phone Number" >
					</div>
					<div class="form-group">
						<label for="">Mobile</label>
						<input type="text" name="txtMobile" class="form-control" id="txtMobile" placeholder="Mobile Number" >
					</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
				<div class="customer padding_dropdown margin_btm">
					<div class="form-group">
						<label for="">Fax</label>
						<input type="text" name="txtFax" class="form-control" id="txtFax" placeholder="Fax" >
					</div>
					<div class="form-group">
						<label for="">Website</label>
						<input type="url" name="txtWebsite" class="form-control" id="txtWebsite" placeholder="Website" >
					</div>
					<div class="form-group">
						<label for="">Twitter</label>
						<input type="url" name="txtTwitter" class="form-control" id="txtTwitter" placeholder="Twitter" >
					</div>
				</div>
			</div>
			</div>
		</section>
		<section class="wrapper2 panel">
			<header class="panel-heading">Address </header>
			<p class="sub_title"></p>
			<div class="panel-body">
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
				<div class="customer">
					<div class="form-group">
						<label for="">Street1</label>
						<input type="text" name="txtStreet1" class="form-control" value="" id="txtStreet1" placeholder="Street1" >
					</div>
					<div class="form-group" >
						<label for="" >Street2</label>
						<input type="text" name="txtStreet2" class="form-control" value="" id="txtStreet2" placeholder="Street2" >
					</div>
					<div class="form-group">
						<label for=""> City </label>
						<input type="text" name="txtCity" class="form-control" value="" id="txtCity" placeholder="City" >
					</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
				<div class="customer">
					<div class="form-group">
						<label for="">State</label>
						<input type="text" name="txtState" class="form-control" value="" id="txtState" placeholder="State" >
					</div>
					<div class="form-group">
						<label for="">Country</label>
						<input type="text" name="txtCountry"  class="form-control" value="" id="txtCountry" placeholder="Country" >
					</div>
					<div class="form-group">
						<label for="">Postal Code</label>
						<input type="text" name="txtPostalCode" class="form-control" value="" id="txtPostalCode" placeholder="Postal Code" >
					</div>
				</div>
			</div>
			</div>
			  <div style=" margin-bottom:  5%;" class="col-md-12 col-sm-12 col-xs-12">
                <a style="float: right; margin-right: 10px; " href="<?php echo base_url() . 'customer/customer_list'; ?>" data-toggle='modal' class="btn btn-success btn-s-xs" name="cancel">Cancel</a>
                  <button style="float: right; margin-right: 10px;" type="submit" class="btn btn-success btn-s-xs">Add</button>

</div>
		</section>
           
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="mycancel" class="modal fade bs-example-modal-sm">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-building-o"></i> Plan Insert Master Alert </h4>
                            </div>
                            <div class="modal-body">
                                <i class="fa fa-question-circle"></i> Are You Sure To Go Back!
                            </div>
                            <div class="modal-footer">
                                <input type='button' value='Yes' class="btn btn-success btn-shadow" onclick=""/>
                                <button data-dismiss="modal" class="btn btn-danger btn-shadow" type="button">No</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Code for Cancle Alert-->
                

	</form>
</section>


<style> label.error { color: red; font-weight: 500; } </style>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script>
<script>

	$('#customer_form').validate({
		rules: {
			txtCustomerName: {
				required: true
			},
			txtGender: {
				required: true
			},
            txtPhoneNumber:{
			    required:true,
                number:true,
                minlength:10,
                maxlength:15
            },
			customer_group: {
				required: true
			},
			txtEmail: {
				required: true,
				email: true
			},
			txtMobile: {
				required: true,
                number:true,
                minlength:10,
                maxlength:15
			},
			txtStreet1: {
				required: true
			},
			txtStreet2: {
				required: true
			},
			txtCity: {
				required: true
			},
			txtState: {
				required: true
			},
			txtCountry: {
				required: true
			},
			txtPostalCode: {
				required: true,
                digits :true
			}
		},
		messages: {
			txtCustomerName: {
				required: "Please enter customer name"
			},
			txtDOB: {
				required: "Please select DOB"
			},
			txtGender: {
				required: "Please select gender"
			},
            txtPhoneNumber:{
                required: "Please enter phone number",
                number:"phone number accept only digits",
                minlength:"Minimum 10 digits required",
                maxlength:"Maximum 15 digits required"
            },
			customer_group: {
				required: "Please select group"
			},
			txtEmail: {
				required: "Please enter email",
				email: "Please enter valid email"
			},
			txtMobile: {
				required: "Please enter mobile number",
                number:"mobile number accept only digits",
                minlength:"Minimum 10 digits required",
                maxlength:"Maximum 15 digits required"
			},
			txtStreet1: {
				required: "Please enter street1"
			},
			txtStreet2: {
				required: "Please enter street2"
			},
			txtCity: {
				required: "Please enter city"
			},
			txtState: {
				required: "Please enter state"
			},
			txtCountry: {
				required: "Please enter country"
			},
			txtPostalCode: {
				required: "Please enter postal code",
                digits: "Please enter valid postal code"
			}
		},
		error: function(label) {
			$(this).addClass("error");
		}
	});

</script>


<?php  include('footer.php'); ?>