<!DOCTYPE html>
<html lang="en">
<head>
 <?php $this->load->view('frontend/include/header'); ?>
</head>
<body>
<!-- =================HEADER SECTION================= -->
<header>
  <div class="header-top-nav" style="display: none">
   <?php $this->load->view('frontend/include/top_navbar'); ?>
  </div>
  <div class="navigation-bar">
     <?php $this->load->view('frontend/include/navbar'); ?>
  </div>
</header>
<style type="text/css">
  #cart_value{
    display: none;
  }
</style>
<?php 
if($this->session->flashdata('myMessage') != ''){
    echo $this->session->flashdata('myMessage');
    // die;
}  
?>
<!-- =================Dynamic page================= -->

	<?php $this->load->view($page);?>

<!-- =================End dynamic page================= -->

<!-- =================SOCIAL SECTION================= -->
<section class="bg-light-blue social-main-wrapper">
  <?php $this->load->view('frontend/include/social_link'); ?>
</section>
<!-- =================FOOTER================= -->
<footer class="p-50" style="background: #fff;">
  <?php $this->load->view('frontend/include/footer_nav'); ?>
</footer>
<!-- =================BOTTOM FOOTER================= -->
<?php $this->load->view('frontend/include/footer'); ?>
</body>
<div id="backdrop"></div>
<div class="success-card-wrapper" id="pupup_message" style="display: none;">
	<div class="success-card">
        <div class="icon-container">
           
                <span class="bubble-1"></span>
                <span class="bubble-2"></span>
                <span class="bubble-3"></span>

                <span class="bubble-4"></span>
                <span class="bubble-5"></span>
                <span class="bubble-6"></span>
     
            <span> <i class="fas fa-check"></i></span>
        </div>
        <div class="success-msg">
            <h4>success</h4>
            <p>Your Item is added to cart successfully</p>
        </div>
</div>
</div>
</html>