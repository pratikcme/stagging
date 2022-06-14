<!DOCTYPE html>
<html><head><title>Order Invoice</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  
</head>
<body style="font-family: 'Roboto', sans-serif;background: aliceblue;max-width: 600px;margin: 0 auto;width: 100%;padding: 5px;">
<div style="padding:5px 5px 15px 5px;">
<div style="text-align: center;">
    <img id="logo" src="<?=$this->siteLogo?>" style="max-width: 150px;margin: 0 auto;">
</div>
<p style="text-align: right;color: black"><?=date('F d Y')?></p>


<div style="margin-top: 25px;">
    <h6 style="margin: 0px;font-size: 18px;color: #1cbcb7;text-transform: capitalize;">Hello <?=$email_to?> ,</h6>
    <?php if($for_vendor == 'vendor'){ ?>  
    <p style="margin: 0px;font-size: 16px;margin-top: 5px;color: black">You have new order in your store</p>
    <?php }else{ ?>
      <p style="margin: 0px;font-size: 16px;margin-top: 5px;color: black">Thank you for shopping with us. We'd like to let you know that your order has received and is preparing it for shipment. Your estimated delivery date is indicated below.</p>
    <?php } ?>

</div>

<div style="margin-top: 25px;">
     <h6 style="color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-transform: capitalize;"> Arrving on</h6>
     <p style="margin: 0px;font-size: 16px;margin-top: 5px;text-transform: capitalize;color: black"><?=date('F d Y',strtotime($order_details[0]->delivery_date))?></p>
</div>

<div style="margin-top: 25px;">
     <h6 style="color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-transform: capitalize;"> <?=($order_details[0]->isSelfPickup =='1') ? "Pickup Address" : "Delivery To" ?></h6>
       <h6 style="color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-transform: capitalize;"> <?=$user_address[0]->name;?></h6>
       
       <?php if($for_vendor == 'user' && $user_gst_number != ''){ ?>  
        <h6 style="color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-transform: capitalize;"> GST No. <span><?=$user_gst_number?></span></h6>
       <?php } ?>
       
  <?php if($order_details[0]->isSelfPickup =='1'){ ?>
      <!-- <p style="margin: 0px;font-size: 16px;margin-top: 5px;">Order Type : Self Pick up</p> -->
      <p style="margin: 0px;font-size: 16px;margin-top: 5px;color: black"><?=$user_address[0]->address?></p>
  <?php }else{ ?>
     <p style="margin: 0px;font-size: 16px;margin-top: 5px;color: black">
      <?=$user_address[0]->address.' '.$user_address[0]->city.' '.$user_address[0]->state.' '.$user_address[0]->country.' '.$user_address[0]->pincode?>
      </p>
  <?php } ?>
</div>

  <h6 style="color: #000;font-weight: bold;font-size: 20px;margin: 0px;text-transform: capitalize; margin-top: 40px;">Order Summary</h6>


<table  style="width: 100%;border:1px solid black;padding:25px;border-collapse: collapse; text-transform: capitalize;max-width:650px:margin:0 auto;">
  <thead>
    <tr>
      <th style="width: 50%;border: 1px solid #dddddd;border-right:0px;text-align: left;  padding: 20px 15px;">Item</th>
      <th style="width: 50%;border: 1px solid #dddddd;border-left:0px;text-align: right;  padding: 20px 15px">Total</th>
    </tr>
  </thead>
  <tbody>
      <?php foreach ($order_details[0]->order_details as $key => $value){ ?>
    <tr>  
      <th style=" border: 1px solid #dddddd;border-right:0px; text-align: left;  padding: 20px 15px;width: 50%;">
        <h6 style=" text-align: left;  padding: 8px;color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-align:left;text-transform: capitalize"><?=$value->name?></h6>
        <p style=" text-align: left;  padding: 8px;color: #a2a2a2;font-size: 14px;margin: 0px;text-align:left;"><?=$value->quantity?> X <?=$this->siteCurrency?><?=$value->discount_price?></p> 
      </th>
      <th style=" border: 1px solid #dddddd;border-left:0px;text-align: right;  padding: 8px;width: 50%;"><?=$this->siteCurrency?><?=number_format((float)$value->calculation_price, 2, '.', '')?></th>
    </tr>
    <?php } ?>

    <tr>  
      <th style=" border: 1px solid #dddddd;border-right:0px;text-align: left;  padding: 20px 15px;width: 50%;">Total Amount :</th>
      <td style=" border: 1px solid #dddddd;border-left:0px;text-align: right;  padding: 20px 15px;width: 50%;"><?=$this->siteCurrency?>
            <?=number_format((float)$order_details[0]->total + $order_details[0]->total_saving,2,'.',''); ?></td>
    </tr>
    <tr>  
      <th style=" border: 1px solid #dddddd;border-right:0px;text-align: left;  padding: 20px 15px;width: 50%;">Product Discount :</th>
      <td style=" border: 1px solid #dddddd;border-left:0px;text-align: right;  padding: 20px 15px;width: 50%;"><?=$this->siteCurrency?><?=$order_details[0]->total_saving?></td>
    </tr>
    <tr>  
      <th style=" border: 1px solid #dddddd;border-right:0px;text-align: left;  padding: 20px 15px;width: 50%;">Total Amount Before Tax :</th>
      <td style=" border: 1px solid #dddddd;border-left:0px;text-align: right;  padding: 20px 15px;width: 50%;"><?=$this->siteCurrency?>
              <?=number_format((float)$order_details[0]->total - $order_details[0]->TotalGstAmount,2,'.','') ?></td>
    </tr>
    <tr>  
      <th style=" border: 1px solid #dddddd;border-right:0px;text-align: left;  padding: 20px 15px;width: 50%;">Total Tax Amount:</th>
      <td style=" border: 1px solid #dddddd;border-left:0px;text-align: right;  padding: 20px 15px;width: 50%;"><?=$this->siteCurrency?><?=number_format((float)$order_details[0]->TotalGstAmount,2,'.','')?></td>
    </tr>
    <tr>  
      <th style=" border: 1px solid #dddddd;border-right:0px;text-align: left;  padding: 20px 15px;width: 50%;">Delivery Charges:</th>
      <td style=" border: 1px solid #dddddd;border-left:0px;text-align: right;  padding: 20px 15px;width: 50%;"><?=$this->siteCurrency?> <?= number_format((float)$order_details[0]->delivery_charge,2,'.','')?></td>
    </tr>
    <tr>  
      <th style=" border: 1px solid #dddddd;border-right:0px;text-align: left;  padding: 20px 15px;width: 50%;">Total Item:</th>
      <td style=" border: 1px solid #dddddd;border-left:0px;text-align: right;  padding: 20px 15px;width: 50%;"><?=$order_details[0]->total_item?></td>
    </tr>
    <tr>  
      <th style=" border: 1px solid #dddddd;border-right:0px;text-align: left;  padding: 20px 15px;width: 50%;">Promocode Discount:</th>
      <td style=" border: 1px solid #dddddd;border-left:0px;text-align: right;  padding: 20px 15px;width: 50%;"><?=$this->siteCurrency?> <?=$order_details[0]->promocode_discount?></td>
    </tr>
    <tr>  
      <th style=" border: 1px solid #dddddd;border-right:0px;text-align: left;  padding: 20px 15px;width: 50%;">Final Total:</th>
      <td style=" border: 1px solid #dddddd;border-left:0px;text-align: right;  padding: 20px 15px;width: 50%;"><?=$this->siteCurrency?> <?=number_format((float)$order_details[0]->payable_amount,2,'.','')?></td>
    </tr>
  </tbody>
</table>


<div style="margin-top: 10px;">
     <h6 style="color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-transform: capitalize;">Thank You </h6>
     <img src="<?=$this->siteLogo?>" style="max-width: 100px;margin: 0 auto;">
  </div> 

</body>
</html>