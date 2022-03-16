<div style="width:100%; margin:0px; padding: 0px;">
    <!-- main -->
    <div style="padding: 48px;">
        <div style="width: 560px; margin: 0 auto; display: block; box-shadow: 0px 0px 14px 0px rgba(142, 140, 140, 0.67); background: #fff; padding: 48px;">
            <!-- wrapper -->
             <p style=""><img src="<?=$this->siteLogo ?>" style="display: block;margin: 0 auto; text-align: center; width: 200px;padding: 10px;"></p>

            <div style="background: linear-gradient(#fff,#009688); box-shadow: 0px 0px 16px 0px rgba(0, 0, 0, 0.33); padding: 16px;">
                <!-- Contnt start -->
                <h3 style="margin-top: 10px;font-family: sans-serif;">Dear <?php echo $name; ?> </h3>
                <!-- <h3 style="margin-top: 30px;">Hello ,</h3> -->
                <p style ="font-size:16px; font-family: sans-serif; margin-top:30px;line-height: 24px;">You have successfully created account with <?=$this->siteTitle?></p>



                <p style ="font-size:16px;font-family: sans-serif;line-height: 24px;">please verify your email address with us using below link</p>

                <p style="font-size:16px; margin-top:40px;line-height: 24px;font-family: sans-serif;"><a href="<?php echo $link; ?>" style="padding: 10px 29px; border: 1px solid #f44336;text-decoration: none;color: #fff; background: #f44336; float: left;box-shadow: 2px 3px 5px 0px #7a7676;">click here</a></p>
                <br>

                <p style="font-size:16px; margin-top:60px; font-family: sans-serif; line-height: 24px;">Thank You,</p>
                <p style="font-size:16px; margin-top:0px;font-family: sans-serif; line-height: 24px;">Team <?=$this->siteTitle?> </p>
            </div>
            <!-- content over -->
        </div>
        <!-- wrapper over -->
    </div>
</div>