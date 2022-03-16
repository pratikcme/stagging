<head>
     <link href="<?php echo base_url(); ?>public/css/bootstrap.min.css" rel="stylesheet">
</head>
<div style="width:100%; margin:0px; padding: 0px;">
    <!-- main -->
    <div style="padding: 48px;">
        <div style="width: 560px; margin: 0 auto; display: block; box-shadow: 0px 0px 14px 0px rgba(142, 140, 140, 0.67); background: #fff; padding: 48px;">
            <!-- wrapper -->
             <div>
                 <p style=""><img src="<?=$this->siteLogo?> " style="display: block;margin: 0 auto; text-align: center; width: 200px;padding: 10px;"></p>
             </div>
            <div>
                    <table class="table table-border">
                        <tr>
                            <th>name</th>
                            <td><?php echo $name; ?></td>
                        </tr><tr>
                            <th>Email</th>
                            <td><?php echo $email; ?></td>
                        </tr><tr>
                            <th>Mobile</th>
                            <td><?php echo $mobile_no; ?></td>
                        </tr><tr>
                            <th>Message</th>
                            <td><?php echo $messages; ?></td>
                        </tr>
                    </table>
                <br>
                <p style="font-size:16px; margin-top:60px; font-family: sans-serif; line-height: 24px;">Thank You,</p>
                <p style="font-size:16px; margin-top:0px;font-family: sans-serif; line-height: 24px;">Team <?php echo  $this->siteTitle; ?> </p>
            </div>
            <!-- content over -->
        </div>
        <!-- wrapper over -->
    </div>
</div>