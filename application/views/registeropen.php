<?php
include('header.php');
// session_start();
date_default_timezone_set('Asia/Calcutta');

//echo date("d-m-y",strtotime(1553073257));
//exit;
if($register_result[0]->type == '0'){
	redirect(base_url() . 'index.php/register/close_register');
}else {
?>
<style>
    .panel-heading {
        background: #5b6e84;
        font-size: 16px;
        font-weight: 300;
        color: white;
    }
    .add_register_closed h2 {
        margin-bottom: 5px;
    }
    .register_closed {
        float: left;
        width: 100%;
    }
    .padd_rght_0 {
        padding-right: 0;
    }
    .register_details h3 {
        border-bottom: 1px solid #ccc;
        float: left;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 10px;
        padding-bottom: 10px;
        width: 100%;
    }
    .outlet_clouser p {
        color: #000;
        float: left;
        font-weight: 600;
        width: 100%;
    }
    .cash_summary h3 {
        float: left;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 10px;
        width: 100%;
    }
    .closer_cash {
        background: #FFF1E8 none repeat scroll 0 0;
        float: left;
        padding: 5px;
        width: 100%;
    }
    .closer_cash_part2 {
        float: left;
        padding: 5px;
        width: 100%;
        border-bottom: 1px solid #ccc;
        border-top: 1px solid #ccc;
    }
    .summary_cash {
        float: left;
        width: 100%;
    }
    .summary_cash h4 {
        float: left;
        font-size: 14px;
        text-transform: uppercase;
        width: 100%;
        color: #777777;
    }
    .clouser_register {
        float: left;
        width: 100%;
    }.close_register .btn.btn-warning {
         background-color: #2a3542;
         font-size: 16px;
         font-weight: 600;
         text-transform: uppercase;
         border: unset;
         padding: 10px 20px;
     }
    .close_register {
        float: right;
        margin-top: 30px;
        width: auto;
    }
</style>
<section id="main-content">
	<section class="wrapper site-min-height">
		<!-- page start-->
		<div id="msg">
			<?php if($this->session->flashdata('msg') && $this->session->flashdata('msg') != ''){ ?>
				<div class="alert alert-success fade in">
					<strong>Success!</strong> <?php echo $this->session->flashdata('msg');; ?>
				</div>
			<?php } unset($this->session->flashdata); ?>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading">
						Register Open
					</header>
					<div class="panel-body">
						<div class="adv-table">
							<div class="clouser_register">
								<h2>Close Register </h2>

								<div class="register_details">
									<h3>Register details</h3>

									<div class="detail_info_of_clouser">
										<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
											<div class="outlet_clouser">
												<span>Outlet</span>
												<p>Main Outlet</p>
											</div>
										</div>

										<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
											<div class="outlet_clouser">
												<span>Register</span>
												<p>Main Register</p>
											</div>
										</div>

										<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
											<div class="outlet_clouser">
												<span>Closure #</span>
												<p><?php echo $register_result[0]->id - 1; ?></p>
											</div>
										</div>

										<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
											<div class="outlet_clouser">
												<span>Opening time</span>
												<p> <?php if($register_result[0]->opening_time != ''){echo date('l, jS F, Y, g:ia', $register_result[0]->opening_time);  } else { echo ''; }  ?></p>
											</div>
										</div>
									</div>
								</div>

								<div class="cash_summary">
									<h3>Cash Summary</h3>

									<div class="summary_details">
										<div class="closer_cash">
											<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">

											</div>

											<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
												<div class="drawer_cash">
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 res_no_padd">
														<div class="summary_cash">
															<h4>Expected ($)</h4>
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 res_no_padd">
														<div class="summary_cash">
															<h4>Counted ($)</h4>
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 res_no_padd">
														<div class="summary_cash">
															<h4>Differences ($) </h4>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="closer_cash_part2">
											<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12 res_no_padd">
												<span class="part_2_deatils">Cash in cash drawer</span>
											</div>

											<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 res_no_padd">
												<div class="drawer_cash">
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
														<div class="summary_cash">
															<p id="expected"><?php echo $register_result[0]->cash_amount_expected; ?></p>
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
														<div class="summary_cash">
															<input type="text" id="counted_cash" class="form-control" placeholder="Enter Amount" value="<?php echo $register_result[0]->counted; ?>" onkeyup="cash_summary(this.value, <?php echo $register_result[0]->id; ?>)">
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
														<div class="summary_cash">
															<p id="cash_differences" style="<?php if($register_result[0]->difference >= 0){ ?> color: green; <?php } else { ?> color: red; <?php } ?> " ><?php echo $register_result[0]->difference; ?></p>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>


								<div class="cash_summary payment_summary">
									<h3>Other Payments Summary</h3>

									<div class="summary_details">
										<div class="closer_cash">
											<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12 res_no_padd">
												<div class="summary_cash">
													<h4>Payment Types</h4>
												</div>
											</div>

											<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 res_no_padd">
												<div class="drawer_cash">
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
														<div class="summary_cash">
															<h4>Expected ($)</h4>
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
														<div class="summary_cash">
															<h4>Counted ($)</h4>
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
														<div class="summary_cash">
															<h4>Differences ($) </h4>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="closer_cash_part2">
											<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12 res_no_padd">
												<span class="part_2_deatils">Online Payment</span>
											</div>

											<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 res_no_padd">
												<div class="drawer_cash">
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
														<div class="summary_cash">
															<p id="credit_card_expected"><?php echo $register_result[0]->credit_card_expected; ?></p>
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
														<div class="summary_cash">
															<input type="text" class="form-control" value="<?php echo $register_result[0]->credit_card_counted; ?>" placeholder="0.00" id="credit_card_counted" onkeyup="credit_card_summary(this.value, <?php echo $register_result[0]->id; ?>)">
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="credit_card_differences">
														<div class="summary_cash">
															<p id="credit_card_differences" style="<?php if($register_result[0]->credit_card_differences >= 0){ ?> color: green; <?php } else { ?> color: red; <?php } ?> "><?php echo $register_result[0]->credit_card_differences; ?></p>
														</div>
													</div>
												</div>
											</div>
										</div>

										<!--<div class="closer_cash_part3">
											<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
												<span class="part_2_deatils">Store Credit</span>
											</div>

											<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
												<div class="drawer_cash">
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
														<div class="summary_cash">
															<p id="store_credit_expected"><?php /*echo $register_result[0]->store_credit_expected; */?></p>
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
														<div class="summary_cash">
															<input type="text" id="store_credit_counted" class="form-control" placeholder="0.00" value="<?php /*echo $register_result[0]->store_credit_counted; */?>" onkeyup="store_credit_summary(this.value, <?php /*echo $register_result[0]->id; */?>)">
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
														<div class="summary_cash">
															<p id="store_credit_differences"><?php /*echo $register_result[0]->store_credit_differences; */?></p>
														</div>
													</div>
												</div>
											</div>
										</div>-->
									</div>

								</div>

								<div class="clouser_note_type">
									<div class="note_create">
										<textarea class="form-control" id="closure_note" placeholder="Type to add a register closure note"></textarea>
									</div>
								</div>

								<div class="close_register pull-right">
									<button class="btn btn-warning" type="button" id="close_register">Close Register</button>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
		<!-- page end-->
	</section>
</section>

<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">

	$('#close_register').click(function () {

		var counted_cash = $('#counted_cash').val();
		if(counted_cash == '' || counted_cash == 0 ){

			bootbox.alert("Please enter counted cash", function() {
				window.location.reload(false);
			});

		}else{
			var closure_note = $('#closure_note').val();

			$.ajax({
				url: '<?php echo base_url().'index.php/register/close_register_button/'; ?>',
				data: {
					id: '<?php echo $register_result[0]->id; ?>',
					closure_note: closure_note,
					url: '<?php echo base_url().'index.php/register/close_register_button/'; ?>'
				},
				success: function() {
					window.location.href = '<?php echo base_url() . "index.php/register/close_register"; ?>';
				}
			});
		}
	});

    function cash_summary(value, id) {

		var register_id = id; //register id
		var counted = value; //counted value
		var expected_value = $('#expected').html(); //expected value
		var difference_cash = parseFloat(counted - expected_value).toFixed(2);

		var differences = $('#cash_differences').html(difference_cash);
		var dif_val = $('#cash_differences').html();

		if(dif_val >= 0){
			$('#cash_differences').css('color', 'green');
		}else{
			$('#cash_differences').css('color', 'red');
		}

		$.ajax({
			url: '<?php echo base_url().'index.php/register/update_cash_summary/'; ?>',
			data: {
				id: register_id,
				expected_value: expected_value,
				counted: counted,
				cash_dif: difference_cash,
				url: '<?php echo base_url().'index.php/register/update_cash_summary/'; ?>'
			},
			success: function(data) {
				var json = JSON.parse(data);
				$("#cash_differences").html(json.cash_difference);
			}
		});
	}

	function  credit_card_summary(value, id) {

		var counted_value = value;
		var registered_id = id;
		var credit_card_expected = $('#credit_card_expected').html();
		var final_value = parseFloat(counted_value - credit_card_expected).toFixed(2);

		var dif_val = $('#credit_card_differences').html();

		if(dif_val >= 0){
			$('#credit_card_differences').css('color', 'green');
		}else{
			$('#credit_card_differences').css('color', 'red');
		}

		$.ajax({
			url: '<?php echo base_url().'index.php/register/update_cc_summary/'; ?>',
			data: {
				id: registered_id,
				expected_value: credit_card_expected,
				counted: counted_value,
				cash_dif: final_value,
				url: '<?php echo base_url().'index.php/register/update_cc_summary/'; ?>'
			},
			success: function(data) {

				var json = JSON.parse(data);

				$('#credit_card_differences').html(json.credit_card_differences);
			}
		});

	}

	function  store_credit_summary(value, id) {

		var counted_value = value;
		var registered_id = id;
		var expected = $('#credit_card_expected').html();
		var final_value = parseFloat(counted_value - expected).toFixed(2);

		$.ajax({
			url: '<?php echo base_url().'index.php/register/update_sc_summary/'; ?>',
			data: {
				id: registered_id,
				expected_value: expected,
				counted: counted_value,
				cash_dif: final_value,
				url: '<?php echo base_url().'index.php/register/update_sc_summary/'; ?>'
			},
			success: function(data) {
				var json = JSON.parse(data);
				$('#store_credit_differences').html(json.store_credit_differences);
			}
		});

	}
</script>

<?php } include('footer.php'); ?>
	