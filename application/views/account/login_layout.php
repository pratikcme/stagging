<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title> Admin Panel</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?=base_url()?>public/admin/assets/css/app.min.css">
  <link rel="stylesheet" href="<?=base_url()?>public/admin/assets/bundles/bootstrap-social/bootstrap-social.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?=base_url()?>public/admin/assets/css/style.css">
  <link rel="stylesheet" href="<?=base_url()?>public/admin/assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?=base_url()?>public/admin/assets/css/custom.css">
  
</head>
<body>

    <?php $this->load->view($page) ?>

     <!-- General JS Scripts -->
  <script src="<?=base_url()?>public/admin/assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="<?=base_url()?>public/admin/assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="<?=base_url()?>public/admin/assets/js/custom.js"></script>

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
</script>
<?php

if (!empty($js)) {
    foreach ($js as $value) {
        ?>
        <script src="<?php echo base_url(); ?>public/admin/assets/javascripts/<?php echo $value ?>"
        type="text/javascript"></script>
        <?php
    }
}
?>
<script>
    jQuery(document).ready(function () {
<?php
if (!empty($init)) {
    foreach ($init as $value) {
        echo $value . ';';
    }
}
?>
    });
</script>
</body>
</html>