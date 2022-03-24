<style type="text/css">
  label.error {
    color: red;
    position: relative;
    top: -17px;
}
</style>
<section class="p-100 bg-cream">
<div class="container">
    <div class="row align-items-center">
      <div class="col-md-12">
        <div class="page-title">
          <h1>forgotten<br>Your password</h1>
        </div>
      </div>
      <div class="col-md-12">
        <form id="ForgetForm" class="login-form register-form" method="post" action="<?=base_url().'login/forget_password'?>">
          
          <div class="input-wrapper">
            <span><i class="fas fa-envelope"></i></span>
            <input type="text" name="email" placeholder="Enter Email*">
          </div>
          <label for="email" class="error"><?=@form_error('email')?></label>
          
<!--            <div class="input-wrapper">
            <span><i class="fas fa-lock"></i></span>
            <input type="password" name="" placeholder="Enter old password*" id="password">
            <span id="eye"><i class="far fa-eye-slash"></i></span>
            <i class="far fa-eye-slash"></i>
          </div> -->
<!-- 
           <div class="input-wrapper">
            <span><i class="fas fa-lock"></i></span>
            <input type="password" name="" placeholder="Enter New password*" id="cpassword">
            <span id="ceye"><i class="far fa-eye-slash"></i></span>
            <i class="far fa-eye-slash"></i>
          </div> -->


          <button type="submit" id="btnSubmit" class="btn create-btn">Reset Password</button>

          <p>Go Back: <a href="<?=base_url().'login'?>"> Login </a></p>
        </form>
      </div>

  
    </div>
  </div>
</section>  