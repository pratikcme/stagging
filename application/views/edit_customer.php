<?php include('header.php'); ?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <section id="main-content">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb" style="margin-top: 6%">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/index'; ?>">Home</a> / Edit Customer</a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>

        <form role="form" method="post" action="<?php echo base_url() . 'customer/edit_customer_form/'; ?>" enctype="" name="customer_form" id="customer_form">

            <section class="wrapper wrapper1 panel" style="margin-top: 0px !important;">


                <header class="panel-heading"> Edit Customer</header>
                <div class="panel-body">

                    <p class="sub_title">Please fill the information to continue</p>

                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">

                        <div class="customer">

                            <div class="form-group">

                                <label for="">Contact Name</label>

                                <input type="text" name="txtCustomerName" value="<?php echo $row_result['0']->customer_name; ?>" class="form-control" id="txtCustomerName" placeholder="Enter Contact Name" >

                            </div>

                            <div class="form-group">

                                <label class="">Date of Birth</label>

                                <div class="">

                                    <input name="txtDOB" class="form-control form-control-inline input-medium default-date-picker" id="txtDOB" size="16" type="text" value="<?php echo $row_result['0']->dob; ?>" >

                                </div>

                            </div>

                            <div class="form-group">

                                <label for="">Company</label>

                                <input type="text" name="txtCompany" value="<?php echo $row_result['0']->company; ?>" class="form-control" id="txtCompany" placeholder="Company Name" >

                                <input type="hidden" name="txtCustomerid" value="<?php echo $row_result['0']->id; ?>" id="txtCustomerid" />

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">

                        <div class="customer padding_dropdown margin_btm">

                            <div class="form-group">

                                <label for="">Customer Code</label>

                                <input type="text" name="txtCustomerCode" value="<?php echo $row_result['0']->customercode; ?>" class="form-control" id="txtCustomerCode" placeholder="Enter Code" readonly>

                            </div>

                            <div class="form-group">	

                                <label for="">Gender</label>

                                <select name="txtGender" id="txtGender" class="col-md-12 form-control padding_dropdown margin_btm">

                                    <option value="1" <?php if($row_result['0']->gender == 1){echo "selected";}?>>Male</option>

                                    <option value="0" <?php if($row_result['0']->gender == 0){echo "selected";}?>>Female</option>

                                </select>

                            </div>



<!--                            <div class="form-group">-->
<!---->
<!--                                <label for="">Password:</label>-->
<!---->
<!--                                <input type="password" name="txtPassword" value="--><?php //echo $row_result['0']->password; ?><!--" class="form-control" id="txtPassword" placeholder="Enter password" >-->
<!---->
<!--                            </div>-->

                            <div class="form-group">

                                <label for="" style="margin-top: 4%">Group:</label>

                                <select name="group" id="group" class="form-control">
                                    <option value="" selected disabled>Select Group</option>
                                    <?php foreach ($group_result as $result) { ?>
                                        <option value="<?php echo $result->id; ?>" <?php if ($row_result[0]->group_id == $result->id) { ?> selected <?php } ?> ><?php echo $result->name; ?></option>
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

                                <input type="email" name="txtEmail" value="<?php echo $row_result['0']->email; ?>" class="form-control" id="email" placeholder="Enter email" >

                            </div>

                            <div class="form-group">

                                <label for="">Phone Number</label>

                                <input type="text" name="txtPhoneNumber" value="<?php echo $row_result['0']->phone; ?>" class="form-control" id="txtPhoneNumber" placeholder="Enter Phone Number" >

                            </div>

                            <div class="form-group">

                                <label for="">Mobile</label>

                                <input type="text" name="txtMobile" value="<?php echo $row_result['0']->mobile; ?>" class="form-control" id="txtMobile" placeholder="Enter Mobile Number" >

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">

                        <div class="customer padding_dropdown margin_btm">

                            <div class="form-group">

                                <label for="">Fax</label>

                                <input type="text" name="txtFax" value="<?php echo $row_result['0']->fax; ?>" class="form-control" id="txtFax" placeholder="Enter Fax" >

                            </div>

                            <div class="form-group">

                                <label for="">Website</label>

                                <input type="url" name="txtWebsite" value="<?php echo $row_result['0']->website; ?>" class="form-control" id="txtWebsite" placeholder="Enter email" >

                            </div>

                            <div class="form-group">

                                <label for="">Twitter</label>

                                <input type="url" name="txtTwitter" value="<?php echo $row_result['0']->twitter; ?>" class="form-control" id="txtTwitter" placeholder="Enter Twitter" >

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

                                <input type="text" name="txtStreet1" value="<?php echo $row_result['0']->street1; ?>" class="form-control" id="txtStreet1" placeholder="Street1" >

                            </div>

                            <div class="form-group" >	

                                <label for="" >Street2</label>

                                <input type="text" name="txtStreet2" value="<?php echo $row_result['0']->street2; ?>" class="form-control" id="txtStreet2" placeholder="Street2" >

                            </div>

                            <div class="form-group">

                                <label for=""> City </label>

                                <input type="text" name="txtCity" value="<?php echo $row_result['0']->city; ?>" class="form-control" id="txtCity" placeholder="Enter City" >

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">

                        <div class="customer">

                            <div class="form-group">

                                <label for="">State</label>

                                <input type="text" name="txtState" value="<?php echo $row_result['0']->state; ?>" class="form-control" id="txtState" placeholder="Enter State" >

                            </div>

                            <div class="form-group">

                                <label for="">Country</label>

                                <input type="text" name="txtCountry" value="<?php echo $row_result['0']->country; ?>" class="form-control" id="txtCountry" placeholder="Enter Country" >

                            </div>

                            <div class="form-group">

                                <label for="">Postal Code</label>

                                <input type="text" name="txtPostalCode" value="<?php echo $row_result['0']->postcode; ?>"  class="form-control" id="txtPostalCode" placeholder="Enter Email" >

                            </div>

                        </div>

                    </div>

                </div>
                <div style=" margin-bottom:  5%;" class="col-md-12 col-sm-12 col-xs-12">
                 <a style="float: right; margin-right: 10px;" href="<?php echo base_url() . 'customer/customer_list'; ?>" data-toggle='modal' class="btn btn-success btn-s-xs" name="cancel">Cancel</a>
                <button style="float: right; margin-right: 10px;" type="submit" class="btn btn-success btn-s-xs">Update</button>
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
</div>


<style> label.error { color: red; font-weight: 500; } </style>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script>
<script>

    $('#customer_form').validate({
        rules: {
            txtCustomerName: {
                required: true
            },
//				txtCompany: {
//					required: true
//				},
//				txtCustomerCode: {
//					required: true
//				},
            txtGender: {
                required: true
            },
            // txtPassword: {
            //     required: true
            // },
            customer_group: {
                required: true
            },
            txtEmail: {
                required: true,
                email: true
            },
//				txtPhoneNumber: {
//					required: true
//				},
            txtPhoneNumber:{
                required: true,
                number:true,
                minlength:10,
                maxlength:15
            },
            txtMobile: {
                required: true,
                number:true,
                minlength:10,
                maxlength:15
            },
//				txtFax: {
//					required: true
//				},
//				txtWebsite: {
//					required: true
//				},
//				txtTwitter: {
//					required: true
//				},
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
//				txtCompany: {
//					required: "Please enter company"
//				},
//				txtCustomerCode: {
//					required: "Please enter code"
//				},
            txtGender: {
                required: "Please select gender"
            },
            // txtPassword: {
            //     required: "Please enter password"
            // },
            customer_group: {
                required: "Please select group"
            },

            txtEmail: {
                required: "Please enter email",
                email: "Please enter valid email"
            },
//				txtPhoneNumber: {
//					required: "Please enter phone number"
//				},
            txtPhoneNumber:{
                required: "Please enter phone number",
                number : "Please enter valid phone number",
                minlength:"Minimum 10 digits required",
                maxlength:"Maximum 15 digits required"

            },
            txtMobile: {
                required: "Please enter mobile number",
                number : "Please enter valid mobile number",
                minlength:"Minimum 10 digits required",
                maxlength:"Maximum 15 digits required"
            },

//				txtFax: {
//					required: "Please enter fax"
//				},
//				txtWebsite: {
//					required: "Please enter website"
//				},
//				txtTwitter: {
//					required: "Please enter twitter"
//				},
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
                digits :"Please enter valid postal code"
            }
        },
        error: function (label) {
            $(this).addClass("error");
        }
    });

</script>
<div class="col-md-12 col-sm-12 col-xs-12">
<?php include('footer.php'); ?>
</div>