<?php
include('header.php');
$vendor_id = $this->session->userdata('id');
?>

<div class="col-md-12 col-sm-12 col-xs-12">
<section id="main-content">

<form role="form" method="post" action="<?php echo base_url().'stock_control/add_order/';  ?>" enctype="" name="order_form" id="order_form">

          <section class="wrapper wrapper1 panel">

          		<header class="panel-heading"> Add Order</header>
          		<div class="panel-body">

          		<p class="sub_title">Please fill the information to continue</p>

          		<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">

	          		<div class="customer">
						    <div class="form-group">
						      <label for="">Order Name</label>
						      <input type="text" name="txtOrderName" class="form-control" id="" placeholder="Order Name" required>
						    </div>
		                     <div class="form-group">
		                    		<label for="name">Order From</label>
			                        <select class="form-control" name="supplier" required>
			                            <option selected disabled value="">-----Select Supplier-----</option>
			                            <?php $result = $this->db->query("select * from supplier where vendor_id='$vendor_id' and status!=9");
			                            $row_supplier = $result ->result();
			                            ?>
			                            <?php foreach($row_supplier as $supply){ ?>
			                                <option value="<?php echo $supply->id; ?>" > <?php echo $supply->name; ?> </option>
			                            <?php } ?>
			                        </select>
	                    	 </div>

                    <!-- <div class="form-group">
                       		 <label for="name">Deliver To</label>
	                        <select class="form-control" name="deliver_to" required>
	                            <option selected disabled value="">-----Select Outlet-----</option>
	                            <?php //$result = $this->db->query("select * from outlet where status != '9'");
	                           // $row_outlet = $result ->result();
	                            ?>
	                            <?php// foreach($row_outlet as $supply){ ?>
	                                <option value="<?php //echo $supply->id; ?>" > <?php// echo $supply->name; ?> </option>
	                            <?php //} ?>
	                        </select>
                    </div> -->

	          		</div>

          		</div>
          		<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">

	          		<div class="customer">

						    <div class="form-group">

                              <label class="">Delivery Due Date</label>

                              <div class="">

                                  <input name="txtDeliveryDueDate" class="form-control form-control-inline input-medium default-date-picker" size="16" type="text" value="" required placeholder="Delivery Due Date">

                              </div>

                              </div>

						     <div class="form-group">

						      <label for="">Order Number</label>

						      <input type="text" name="txtOrderNumber" class="form-control" id="" placeholder="Order Number" required>

						    </div>

                              <div class="form-group">

							      <label for="">Supplier Invoice</label>

							      <input type="text" name="txtSupplierInvoice" class="form-control" id="" placeholder="Supplier Invoice" required>

						    </div>

	          		</div>

	          		</div>
	          		</div>
          
	        
	          		  <div class="col-md-12 col-sm-12 col-xs-12">
				  <a style="float: right; margin-right: 10px;" href="<?php echo base_url().'stock_control/view_stock_control_list'; ?>" data-toggle='modal' class="btn btn-success btn-s-xs" name="cancel">Cancel</a>
				  <button type="submit" style="float: right; margin-right: 10px;"  class="btn btn-success btn-s-xs">Submit</button>
				  </div>
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

	$('#order_form').validate({
		rules: {
			txtOrderName: {
				required: true
			},
			supplier: {
				required: true
			},
			deliver_to: {
				required: true
			},
			txtDeliveryDueDate: {
				required: true
			},
			txtOrderNumber: {
				required: true
			},
			txtSupplierInvoice: {
				required: true
			}
		},
		messages: {
			txtOrderName: {
				required: "Please enter order name"
			},
			supplier: {
				required: "Please select supplier"
			},
			deliver_to: {
				required: "Please select outlet"
			},
			txtDeliveryDueDate: {
				required: "Please select date"
			},
			txtOrderNumber: {
				required: "Please enter order number"
			},
			txtSupplierInvoice: {
				required: "Please enter supplier invoice"
			}
		},
		error: function(label) {
			$(this).addClass("error");
		}
	});

</script>

<?php  include('footer.php'); ?>