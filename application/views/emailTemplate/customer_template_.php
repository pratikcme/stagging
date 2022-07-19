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
        <h6 style="color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-transform: capitalize;"> GST Number : <span><?=$user_gst_number?></span></h6>
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
    
<div style="display: flex;justify-content: space-between;border: 1px solid #d8d8d8;
     padding: 10px 10px;margin-top: 10px;">
    <h6 style="color: #000;font-weight: bold;font-size: 16px;margin: 0px;width:100%;"> Item</h6>
    <h6 style="color: #000;font-weight: bold;font-size: 16px;margin: 0px;display:flex;justify-content:flex-end">Total</h6>
</div>
<?php foreach ($order_details[0]->order_details as $key => $value): ?>
<div style="display: flex;justify-content: space-between; align-items: center;padding: 10px 10px;border: 1px solid #d8d8d8; border-top: 0px;">
    <div style="text-align:left;width:50%;">
        <h6 style="color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-align:left"><?=$value->name?></h6>
        <p style="color: #a2a2a2;font-size: 14px;margin: 0px;text-align:left"><?=$value->quantity?> X <?=$this->siteCurrency?><?=$value->discount_price?></p>    
    </div>
    <div style="width:50%;text-align: right;">
        <h6 style="color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-align:right"><?=$this->siteCurrency?><?=number_format((float)$value->calculation_price, 2, '.', '')?></h6>
    </div>
</div>
    <?php endforeach ?>




<div style=" padding: 10px 10px;border: 1px solid #d8d8d8; border-top: 0px;">
  <div style="display: flex;align-items: center;justify-content: space-between;width: 100%">
           <h6 style="width:50%;color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-transform: capitalize;">Total Amount :</h6>
            <span style="width:50%;font-weight: normal;text-align: right;display:block;width: 50%;color: black">
              <?=$this->siteCurrency?>
            <?=number_format((float)$order_details[0]->total + $order_details[0]->total_saving,2,'.',''); ?></span>
    </div>  
</div>

<div style=" padding: 10px 10px;border: 1px solid #d8d8d8; border-top: 0px;">
  <div style="display: flex;align-items: center;justify-content: space-between;width: 100%">
           <h6 style="width:50%;color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-transform: capitalize;">Product Discount :</h6>
            <span style="width:50%;font-weight: normal;text-align: right;display:block;width: 50%;color: black"><?=$this->siteCurrency?><?=$order_details[0]->total_saving?></span>
    </div>  
</div>

<div style=" padding: 10px 10px;border: 1px solid #d8d8d8; border-top: 0px;">
  <div style="display: flex;align-items: center;justify-content: space-between;width: 100%">
           <h6 style="width:50%;color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-transform: capitalize;">Total Amount Before Tax :</h6>
            <span style="width:50%;font-weight: normal;text-align: right;display:block;width: 50%;color: black"><?=$this->siteCurrency?>
              <?=number_format((float)$order_details[0]->total - $order_details[0]->TotalGstAmount,2,'.','') ?></span>
    </div>  
</div>

<div style=" padding: 10px 10px;border: 1px solid #d8d8d8; border-top: 0px;">
  <div style="display: flex;align-items: center;justify-content: space-between;width: 100%">
           <h6 style="width:50%;color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-transform: capitalize;">Total Tax Amount:</h6>
            <span style="width:50%;font-weight: normal;text-align: right;display:block;width: 50%;color: black"><?=$this->siteCurrency?><?=number_format((float)$order_details[0]->TotalGstAmount,2,'.','')?></span>
    </div>  
</div>

<div style=" padding: 10px 10px;border: 1px solid #d8d8d8; border-top: 0px;">
  <div style="display: flex;align-items: center;justify-content: space-between;width: 100%">
           <h6 style="width:50%;color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-transform: capitalize;">Delivery Charges:</h6>
            <span style="width:50%;font-weight: normal;text-align: right;display:block;width: 50%;color: black"><?=$this->siteCurrency?> <?= number_format((float)$order_details[0]->delivery_charge,2,'.','')?></span>
    </div>  
</div>



<div style=" padding: 10px 10px;border: 1px solid #d8d8d8; border-top: 0px;">
  <div style="display: flex;align-items: center;justify-content: space-between;width: 100%">
           <h6 style="width:50%;color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-transform: capitalize;">Total Item:</h6>
            <span style="width:50%;font-weight: normal;text-align: right;display:block;width: 50%;color: black"> <?=$order_details[0]->total_item?></span>
    </div>  
</div>

<div style=" padding: 10px 10px;border: 1px solid #d8d8d8; border-top: 0px;">
  <div style="display: flex;align-items: center;justify-content: space-between;width: 100%">
           <h6 style="width:50%;color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-transform: capitalize;">Promocode Discount :</h6>
            <span style="width:50%;font-weight: normal;text-align: right;display:block;width: 50%;color: black"><?=$this->siteCurrency?> <?=$order_details[0]->promocode_discount?></span>
    </div>  
</div>

<div style=" padding: 10px 10px;border: 1px solid #d8d8d8; border-top: 0px;">
  <div style="display: flex;align-items: center;justify-content: space-between;width: 100%">
           <h6 style="width:50%;color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-transform: capitalize;">Final Total:</h6>
            <span style="width:50%;font-weight: normal;text-align: right;display:block;width: 50%;color: black"><?=$this->siteCurrency?> <?=number_format((float)$order_details[0]->payable_amount,2,'.','')?></span>
    </div>  
</div>



  <div style="margin-top: 10px;">
     <h6 style="color: #000;font-weight: bold;font-size: 16px;margin: 0px;text-transform: capitalize;">Thank You </h6>
     <img src="<?=$this->siteLogo?>" style="max-width: 100px;margin: 0 auto;">
  </div> 

</div>
</body>
</html>