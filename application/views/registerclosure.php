<?php
include('header.php');
session_start();
date_default_timezone_set('Asia/Calcutta');
$user_id = $this->session->userdata['id'];
$user_query = $this->db->query("SELECT name FROM vendor WHERE id = $user_id");
$user_result = $user_query->row_array();

if(!empty($register_result)){

	$register_id = $register_result[0]->id;
	$order_row = $this->db->query("SELECT SUM(`total`) as total FROM `order` WHERE id = '$register_id' AND payment_type = '0'");
	$order_result = $order_row->row_array();
}
?>


<script type="text/javascript">

	function printDiv(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}
</script>
<style>
    .cash_payemnt_rcvd {
        float: left;
        width: 100%;
    }
    .payment_recived {
        float: left;
        padding: 5px 0;
        width: 100%;
    }
    .panel-heading {
        background: #5b6e84;
        font-size: 16px;
        font-weight: 300;
        color: white;
    }
    .add_register_closed h2 {
        margin-bottom: 5px;
    }
    .clouser_register h2 {
        float: left;
        font-size: 28px;
        font-weight: bold;
        margin-top: 0;
        width: 100%;
        margin-bottom: 30px;
    }
    .register_closed .btn.btn-warning {
        background: #2a3542;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        border: unset;
        padding: 10px 20px;
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
    .register_details {
        float: left;
        width: 100%;
    }
    .outlet_clouser span {
        color: #444;
        float: left;
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
    .part_2_deatils {
        float: left;
        margin-top: 9px;
        width: 100%;
    }
    .summary_cash p {
        float: left;
        margin-top: 8px;
        width: 100%;
        word-wrap: break-word;
    }
    .movement_day h4 {
        float: left;
        font-size: 13px;
        font-weight: bold;
        margin: 5px 0 15px;
        width: 100%;
    }
    .opt_cash_day {
        border-bottom: 1px solid #ccc;
        float: left;
        margin-bottom: 10px;
        padding-bottom: 5px;
        width: 100%;
    }
    .cash_movement span {
        float: left;
        font-size: 13px;
        font-weight: bold;
        text-align: center;
        width: 100%;
    }
    .cash_movement p {
        float: left;
        text-align: center;
        width: 100%;
    }
    .cash_recieved {
        float: left;
        width: 100%;
    }
    .cash_recieved p {
        float: left;
        font-size: 13px;
        font-weight: bold;
        width: 100%;
    }
    .cash_summary {
        float: left;
        width: 100%;
        margin-bottom: 20px;
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
    }
    .close_register {
        float: right;
        margin-top: 30px;
        width: auto;
    }
    .close_register .btn.btn-warning {
        background:  #2a3542;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        border: unset;
        padding: 10px 20px;
    }

</style>
<section id="main-content">
    <section class="wrapper site-min-height">
            <!-- page start-->
			<div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
							Register Close
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <div class="clouser_register add_register_closed" id="printableArea">
									<h2>Register closed</h2>
									<p>To make a sale, please open the register</p>
									
									<div class="register_closed padd_rght_0">
										<button class="btn btn-warning" type="button" href="#myModal" data-toggle="modal">Open Register</button>
									</div>
									
									<div class="register_details">
										<h3>Last Register Closure Summary</h3>
										
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
													<p><?php if(!empty($register_result)){  echo $register_result[0]->id; } else {  }  ?></p>
												</div>
											</div>
											
											<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
												<div class="outlet_clouser">
													<span>Opening time</span>
													<p><?php if(!empty($register_result)){  echo date('l, jS F, Y, g:ia', $register_result[0]->opening_time); } else {  }  ?></p>
												</div>
											</div>
											
											<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
												<div class="outlet_clouser">
													<span>Closing time</span>
													<p><?php if(!empty($register_result)){ echo date('l, jS F, Y, g:ia', $register_result[0]->closing_time); } else {}  ?></p>
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
												<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
													<span class="part_2_deatils">Cash in cash drawer</span>
												</div>
												
												<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
													<div class="drawer_cash">
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
															<div class="summary_cash">
																<p><?php if(!empty($register_result)){ echo $register_result[0]->cash_amount_expected; } else {  } ?></p>
															</div>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
															<div class="summary_cash">
																<p><?php if(!empty($register_result)){ echo $register_result[0]->counted; } else {  }  ?></p>
															</div>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
															<div class="summary_cash">
																<p><?php if(!empty($register_result)){ echo $register_result[0]->difference; } else {  }  ?></p>
															</div>
														</div>
													</div>
												</div>
												
												<div class="movement_day">
													<div class="col-md-12"><h4>Cash movements for the day</h4></div>
													
													<div class="opt_cash_day">
														<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
															<div class="cash_movement">
																<span>Time</span>
															</div>
														</div>
														
														<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
															<div class="cash_movement">
																<span>User</span>
															</div>
														</div>
														
														<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
															<div class="cash_movement">
																<span>Reasons</span>
															</div>
														</div>
														
														<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
															<div class="cash_movement">
																<span>Transaction ($)</span>
															</div>
														</div>
													</div>
													
													<div class="opt_cash_time">
														<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
															<div class="cash_movement">
																<p><?php if(!empty($register_result)){  echo date('l, jS F, Y, g:ia', $register_result[0]->opening_time); } else {  }  ?></p>
															</div>
														</div>
														
														<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
															<div class="cash_movement">
																<p><?php echo $user_result['name']; ?></p>
															</div>
														</div>
														
														<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
															<div class="cash_movement">
																<p>Opening float</p>
															</div>
														</div>
														
														<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
															<div class="cash_movement">
																<p class="dark_clr"><?php if(!empty($register_result)){ echo $register_result[0]->transaction; } else { echo '0.00'; }  ?></p>
															</div>
														</div>
													</div>
												</div>
											</div>
											
											<div class="payment_recived">
												<div class="cash_payemnt_rcvd">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="cash_recieved">
															<p>Cash payments received</p>
														</div>
													</div>
													
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
														<div class="cash_recieved">
															<p><?php if(!empty($order_result)){ echo $order_result['total']; } else { echo '0.00'; }  ?></p>
														</div>
													</div>
												</div>
												
												<div class="cash_payemnt_rcvd">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="cash_recieved">
															<p>Cash to bank</p>
														</div>
													</div>
													
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
														<div class="cash_recieved">
															<p>0.00</p>
														</div>
													</div>
												</div>
											</div>
										</div>
									
									</div>
									
									
									<div class="cash_summary payment_summary">
										<h3>Other Payments Summary </h3>
										
										<div class="summary_details">
											<div class="closer_cash">
												<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
													<div class="summary_cash">
														<h4>Payment Types</h4>
													</div>
												</div>
												
												<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
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
												<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
													<span class="part_2_deatils">Credit Card</span>
												</div>
												
												<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
													<div class="drawer_cash">
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
															<div class="summary_cash">
																<p><?php if(!empty($register_result)) { echo $register_result[0]->credit_card_expected; } else { echo '0.00'; } ?></p>
															</div>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
															<div class="summary_cash">
																<p><?php if(!empty($register_result)){ echo $register_result[0]->credit_card_counted; } else { echo '0.00'; }  ?></p>
															</div>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
															<div class="summary_cash">
																<p><?php if(!empty($register_result)){ echo $register_result[0]->credit_card_differences; } else { echo '0.00'; }  ?></p>
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
																<p><?php /*if(!empty($register_result)){ echo $register_result[0]->store_credit_expected; } else { echo '0.00'; }  */?></p>
															</div>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
															<div class="summary_cash">
																<p><?php /*if(!empty($register_result)){ echo $register_result[0]->store_credit_counted; } else { echo '0.00'; }  */?></p>
															</div>
														</div>
														<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
															<div class="summary_cash">
																<p><?php /*if(!empty($register_result)){ echo $register_result[0]->store_credit_differences; } else { echo '0.00'; }  */?></p>
															</div>
														</div>
													</div>
												</div>
											</div>-->
										</div>
									
									</div>
									
									<div class="close_register pull-right">
										<button class="btn btn-warning" type="button" onclick="printDiv('printableArea')">Print Summary</button>
										<?php if(!empty($register_result)){ ?>
											<a href="<?php echo base_url().'index.php/register/closure_summary?id='.$register_result[0]->id; ?>" class="btn btn-warning" type="button">View Register Clouser Sales</a>
										<?php } else { ?>
											<a class="btn btn-warning" type="button" disabled="">View Register Clouser Sales</a>
										<?php } ?>
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

<!-- Add Type : Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Set opening cash drawer amount</h4>
            </div>
            <form method="post" action="<?php echo base_url() . 'index.php/register/opening_cash'; ?>" id = "cashRegister">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Cash Amount</label>
                        <input type="text" name="amount" class="form-control" value="" required>
                        <label for="amount" class="error" style = "color:red;"></label>
                    </div>
					<div class="form-group">
                        <label for="name">Type to add note</label>
                        <input type="text" name="note" class="form-control" value="">
                        <label for="note" class="error" style = "color:red;"></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Save Amount" name="save_amount"/>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script>
    <script>
    
    $('#cashRegister').validate({
			rules: {
				amount: {
                                    
					required: true,
                                        number:true
				},
                                note:{
                                    
                                    required: true
                                    
                                }
			},
			messages: {
				amount: {
                                            required: "Please enter cash amount",
                                            number:"Cash amount must be in number format"
				},
                                note:{
                                    required:"Please enter note"
                                }
			},
			error: function(label) {
				$(this).addClass("error");
			}
		});


    </script>
<?php include('footer.php'); ?>