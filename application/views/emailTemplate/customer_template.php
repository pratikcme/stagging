<!DOCTYPE html>
<html>
<head>
	<title>Customer Template</title>
	<!--  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no"> -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Roboto', sans-serif;background: aliceblue;max-width: 900px;margin: 0 auto;
padding: 50px 100px;overflow:hidden">

<table style="width: 100%;">
	<thead>
		<th style="text-align: center;" colspan="2"><img style="max-width: 150px;" src="<?=$this->siteLogo?>"></th>
	</thead>
	<tbody>
		<tr>
			
			<td colspan="2">
				<p style="text-align: right;"><?=date('F d Y')?></p>
			</td>
		</tr>
		<tr>
			<td style="height: 25px"></td>
		</tr>
		<tr>
			<td colspan="2">
				<h6 style="margin: 0px;font-size: 18px;color: #1cbcb7;">Hello <?=$email_to?></h6>
			<?php if($for_vendor == 'vendor'){ ?>		
				<p style="margin: 0px;font-size: 16px;margin-top: 5px;">You Have New Order In Your Store</p>
			<?php }else{ ?>
				<p style="margin: 0px;font-size: 16px;margin-top: 5px;">Thank you for shopping with us. We'd like to let you know that your order has received and is preparing it for shipment. Your estimated delivery date is indicated below.</p>
			<?php } ?>
			</td>
			
		</tr>
		<tr>
			<td style="height: 25px"></td>
		</tr>
		<?php if($for_vendor == 'user'){ ?>

		<tr style="margin-top: 25px;">
			<td>
				<h6 style="margin: 0px;font-size: 18px">Arriving on</h6>
				<p style="margin: 0px;font-size: 18px"><?=$order_details[0]->delivery_date?></p>
			</td>
			<td>
				<?php if($order_details[0]->isSelfPickup =='1'){ ?>
					<h6 style="margin: 0px;font-size: 18px;text-align: right;">Order Type</h6>
					<p style="margin: 0px;font-size: 18px;text-align: right;">Self Pick up</p>
					<h6 style="margin: 0px;font-size: 18px;text-align: right;">PickUp Address</h6>
					<?php if(isset($user_address)){ ?>
						<p style="margin: 0px;font-size: 18px;text-align: right;"><?=$user_address[0]->name;?></p>
						<p style="margin: 0px;font-size: 16px;text-align: right;padding-left: 150px;"><?=$user_address[0]->address?></p>
					<?php } ?>
				<?php }else{ ?>
					<h6 style="margin: 0px;font-size: 18px;text-align: right;">Delivery Address</h6>
					<?php if(isset($user_address)){ ?>
						<p style="margin: 0px;font-size: 18px;text-align: right;"><?=$user_address[0]->name;?></p>
						<p style="margin: 0px;font-size: 16px;text-align: right;padding-left: 150px;">
							<?=$user_address[0]->address.' '.$user_address[0]->city.' '.$user_address[0]->state.' '.$user_address[0]->country.' '.$user_address[0]->pincode?></p>
						<?php } ?>
					<?php } ?>
				</td>
			</tr>
		<?php } ?>
			<tr >
				<td  style="border-bottom:1px solid #adadad;height: 5px" colspan="2"></td>
			</tr>
		</tbody>
	</table>
	<table style="width: 100%;margin-top: 25px;">
	<!-- 	<div style="display: flex;justify-content: space-between;">
			<h4 style="text-transform: uppercase;margin-bottom: 30px;border-bottom: 1px solid #adadad;padding-bottom: 5px;margin-bottom: 5px;position: relative;">order summary
			</h4>    
			<span style="position: absolute;right: 0px;"><?=$order_details[0]->order_no?></span>

		</div> -->


		<tr style="margin-top: 25px;margin-bottom: 30px;border-bottom: 1px solid #adadad;padding-bottom: 5px;margin-bottom: 5px;">
			<td colspan="2">
				<h6 style="margin: 0px;font-size: 18px">order summary</h6>

			</td>
			<td colspan="3">
				<h6 style="margin: 0px;font-size: 18px;text-align: right;"><?=$order_details[0]->order_no?></h6>

			</td>
		</tr>
		<tr>
			<td colspan="5">
				<hr>
			</td>



			<tr style="border-bottom: 1px solid #000;text-transform: uppercase;padding: 10px 0;text-align: left;">
				<th>item</th>
				<th></th>
				<th>price</th>
				<th>qty</th>
				<th>total</th>
			</tr>
			<tr>
				<td colspan="5">
					<hr>
				</td>
			</tr>
			<?php foreach ($order_details[0]->order_details as $key => $value): ?>

				<tr style="vertical-align: top;border-bottom: 1px solid #adadad;">
					<td><?=$value->name?></td>
					<td></td>
					<td rowspan="2">Rs.<?=$value->discount_price?></td>
					<td rowspan="2"><?=$value->quantity?></td>
					<td rowspan="2">Rs.<?=number_format((float)$value->calculation_price, 2, '.', '')?></td>
				</tr>
				<tr>
					<td colspan="5">
						<hr>
					</td>
				</tr>
                    <!-- <tr style="border-bottom: 1px solid #eee;">
                        <td>S/2 Knox yellow sconces</td>
                        <td>Standered shipping</td>
                    </tr>
                       <tr>
                    	<td colspan="5">
                    		<hr>
                    	</td>
                    </tr> -->
                <?php endforeach ?>
                <tr>
                	<td></td>
                	<td></td>
                	<td></td>
                	<td style="border-bottom:1px solid #adadad;padding: 5px;">Total merchansise</td>

                	<td style="border-bottom:1px solid #adadad;padding: 5px;">Rs.<?=$order_details[0]->total?></td>
                </tr>
                <tr>
                	<td></td>
                	<td></td>
                	<td></td>
                	<td  style="border-bottom:1px solid #adadad;padding: 5px;" >Total shipping & Handling</td>

                	<td  style="border-bottom:1px solid #adadad;padding: 5px;" >Rs.<?=number_format((float)$order_details[0]->delivery_charge, 2, '.', '')?></td>
                </tr>

                <tr>
                	<td></td>
                	<td></td>
                	<td></td>
                	<td  style="border-bottom:1px solid #adadad;padding: 5px;" >Total tax(Gst)</td>

                	<td  style="border-bottom:1px solid #adadad;padding: 5px;" >Rs. <?=$order_details[0]->TotalGstAmount?></td>
                </tr>

                <tr style="border-bottom: 3px solid #eee;font-weight: bold;">
                	<td></td>
                	<td></td>
                	<td></td>
                	<td  style="border-bottom:1px solid #adadad;padding: 5px;text-transform: capitalize;">order total</td>

                	<td style="border-bottom:1px solid #adadad;padding: 5px;text-transform: capitalize;">Rs.<?=$order_details[0]->total + $order_details[0]->delivery_charge ?></td>
                </tr>
            </table>    

        </body>
        </html>