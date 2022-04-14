<?php 
	// $CI=&get_instance();
	// $CI->load->model('common_model');
	// $faviconIcon = $CI->common_model->getLogo();
	$favicon = ($this->siteFevicon != '') ? $this->siteFevicon : $this->siteLogo;
?>
<title><?=$this->siteTitle?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
  <meta property="og:title" content="<?=(isset($productDetail) && isset($productDetail[0]) && $productDetail[0]->name !='' ) ? $productDetail[0]->name : $this->siteTitle?>" />
    <meta property="og:image" content="<?=(isset($productDetail) && isset($productDetail[0]) && $productDetail[0]->name !=' ' ) ? base_url().'public/images/'.$this->folder.'product_image/'.$product_image[0]->image : ''?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:image" content="<?=(isset($productDetail) && isset($productDetail[0]) && $productDetail[0]->name !=' ' ) ? base_url().'public/images/'.$this->folder.'product_image/'.$product_image[0]->image : ''?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="jetpack-boost-ready" content="true" />
    <meta name="msapplication-TileImage" content="<?=(isset($productDetail) && isset($productDetail[0]) && $productDetail[0]->name !=' ' ) ? base_url().'public/images/'.$this->folder.'product_image/'.$product_image[0]->image : ''?>" />
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet">
  <!-- BOOTSRAP CSS -->
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/frontend/assets/css/bootstrap.min.css">
  <!-- FONT AWESOME CSS -->
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/frontend/assets/fonts/fontawesome5/css/all.css">
  <!--ANIMATE CSS -->
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/frontend/assets/css/animate.css">
  <link rel="icon" href="<?=$favicon;?>" type="image/gif" sizes="8x8">

  <!-- OWL CAROUSEL CSS -->
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/frontend/assets/css/owl.carousel.min.css">

  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/frontend/assets/css/owl.theme.default.min.css">
  
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/frontend/assets/css/jquery.rtResponsiveTables.css">
  

  <link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>

  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/frontend/assets/css/slick.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/frontend/assets/css/popup.css">


  <link rel='stylesheet' href='https://unpkg.com/xzoom/dist/xzoom.css'>
  <link rel='stylesheet' href='https://s3-us-west-2.amazonaws.com/s.cdpn.io/164071/drift-basic.css'>
  
  <!-- STYLE AND RESPONSIVE Css -->
  <?php $this->load->view('frontend/css/style.php'); ?>
  <?php $this->load->view('frontend/css/new_style.php'); ?>
  <?php $this->load->view('frontend/css/responsive.php'); ?>

    


  <!-- <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/frontend/assets/css/style.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/frontend/assets/css/new_style.css"> -->
 <!--  <link rel="stylesheet" type="text/css" href="<?=base_url()?>public/frontend/assets/css/responsive.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<style type="text/css">
	label.error{
		color: red;
	}
	label.error p{
		color: red;
	}
.control-label{
    font-weight: 700;
    width: 100% !important; 
}
textarea.form-control {
    -webkit-border-radius: 5px;
    border: 1px solid #eaeaea;
    box-shadow: none;
    font-size: 16px!important;
  }
         .required{
         color: red;
         }
         .btn{
         }
         #myMap{
         /*margin-top: 10px;*/
         height: 300px;
         width: 300px;
         /*float: right;*/
         top: -24em !important;
         left: 110% !important;
         }
         .display_map{
         position: absolute;
         top: 63%;
         right: 35.6%;
         }
         .form-signin {
         max-width: 425px;
         }
         .form-signin p {
         color: #f50000;
         font-size: 12px;
         text-align: left;
         }
         .login-wrap {
         padding: 2em 20px 3em 20px;
         }
         .login-wrap input {
         margin-bottom: 0!important;
         }
         .login-wrap label.error {
         margin-top: 10px;
         margin-left: 5px;
         margin-bottom: 0;
         }
         .login-wrap label {
         padding-left: 0;
         }

         .abcd{
            opacity: 0;
         }
         .alert{
      position: absolute;
        left: 0;
        right: 0;
        opacity: 1;
        margin: 0 auto;
        z-index: 22;
        /*max-width: 1300px;*/
    }   
         /*.login-wrap{
         height: 600px !important;
         }*/
.feature-bottom-wrap{
  justify-content: center;
}
.feature-bottom-wrap .quantity-wrap{
display: flex;
align-items: center;
justify-content: center;
height: 20px;
}

.feature-bottom-wrap .quantity-wrap button{  
    width: 50px;
    height: 40px;
    
}

.feature-bottom-wrap .quantity-wrap input{
    height: 40px;
    width: 50px;
  
}
</style>
<input type="hidden" id="siteCurrency" value="<?=$this->siteCurrency?>">