<!DOCTYPE html>
<html>
<head>
  <title>Vendor Message</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    
</head>
<body style="font-family: 'Roboto', sans-serif;background: aliceblue;max-width: 900px;margin: 0 auto;width: 100%;padding: 10px;">
  <section style="width:100%;max-width: 700px;margin:0 auto;">
        <div class="logo" style="text-align: center;">
            <img src="<?=$this->siteLogo?>" style="width: 100%;max-width: 150px;margin: 0 auto;">
        </div>
        <p class="date" style="text-align:right;margin-top:25px;">Date: <?=date('d/m/y')?></p>
        <div>
            <h5 style="font-weight: bolder;color:#000;font-size:18px;" class="mb-4">Subject : <?=$subject?></h5>
            <h6 style="margin: 0px;font-size: 18px;color: #1cbcb7;">Hello Cmexpertise</h6>
            <p style="margin: 0px;font-size: 16px;margin-top: 5px;color:#000;"><?=$vendor_message?></p>
        </div>
        
        <div style="margin-top: 50px;">
          <h6 style="margin:0px;margin-bottom: 10px;margin-top:15px;text-transform:capitalize;font-size: 25px; ">Vendor Detail</h6>
          <p style="margin-bottom: 0px ;margin-top:3px;" ><span style="font-weight: bold;color:#000;font-size: 16px">Name :</span> <?=$vendor[0]->owner_name?></p>
          <p style="margin-bottom: 0px ;margin-top:3px"><span style="font-weight: bold;color:#000;font-size: 16px">Store Name :</span> <?=$vendor[0]->storeName?></p>
          <p style="margin-bottom: 0px ;margin-top:3px"><span style="font-weight: bold;color:#000;font-size: 16px">Email :</span> <?=$vendor[0]->email?></p>
          <p style="margin-bottom: 0px ;margin-top:3px"><span style="font-weight: bold;color:#000;font-size: 16px">Phone :</span> <?=$vendor[0]->phone_no?></p>
        </div>

        <div class="thanks" style="margin-top:35px;">
            <h6 style="margin: 0; text-transform: capitalize;font-weight: bolder;color:#000;font-size:16px;">Thank you</h6>
            <p style="margin: 0; text-transform: capitalize;color:#000;font-size:18px;"><?=$vendor[0]->owner_name?></p> 
            <p style="margin: 0; text-transform: capitalize;color:#000;font-size:16px;">Vendor</p>
        </div>
    </section>

</body>
</html>