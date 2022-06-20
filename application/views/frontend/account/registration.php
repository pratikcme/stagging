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
          <h1>Register<br>Your Account</h1>
        </div>
      </div>
      <div class="col-md-12">
        <form id="RegisterForm" method="post" class="login-form register-form" action="<?=base_url().'register'?>">
          <div class="input-wrapper">
            <span><i class="fas fa-user"></i></span>
            <input type="text" name="fname" placeholder="First Name*" required>
          </div>
          <label for="fname" class="error"></label>

          <div class="input-wrapper">
            <span><i class="fas fa-user"></i></span>
            <input type="text" name="lname" placeholder="Last Name*" required>
          </div>
          <label for="lname" class="error"></label>
          
          <div class="">
            <select name="country_code" id="country_code" class="input-wrapper">
                <option value="">Select country code</option>
              <?php foreach(GetDialcodelist() as $key => $value){ ?>
                 <option value="<?=$key;?>"><?=$value;?></option>
               <?php } ?>             
            </select>
          </div>
          
          <div class="input-wrapper">
            <span><i class="fas fa-mobile"></i></span>
            <input type="text" name="phone"  class="mob_no" placeholder="Mobile Number*" required>
          </div>
          <label for="phone" class="error"></label>

          <div class="input-wrapper">
            <span><i class="fas fa-envelope"></i></span>
            <input type="text" name="email" placeholder="Email*" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','');" required>
          </div>
          <label for="email" class="error"></label>
          
          <div class="input-wrapper">
            <span><i class="fas fa-lock"></i></span>
            <input type="password" name="password" placeholder="password*" id="password" autocomplete=off>
            <span id="eye"><i class="far fa-eye-slash"></i></span>
          </div>
          <label for="password" class="error"></label>

           <div class="input-wrapper">
            <span><i class="fas fa-lock"></i></span>
            <input type="password" name="confirm_password" placeholder="Confirm password*" id="confirm_password" required>
            <span id="ceye"><i class="far fa-eye-slash"></i></span>
          </div>
          <label for="confirm_password" class="error"></label> 
          <label class="main">By creating an account, you agree to our <a href="<?=base_url().'terms_condition'?>"> Terms Of Conditions </a> and <a href="<?=base_url().'privacy_policy'?>"> privacy policy.</a>
          <input type="checkbox" name="term_policy">
          <span class="geekmark"></span>
        </label>
        <label for="term_policy" class="error"></label>


          <button class="btn create-btn">create Account</button>

          <div class="or-partition"   >
            <span>- or -</span>
          </div>

          <div class="social-btns"  >
              <a href="<?=base_url().'login/fb_login'?>" class="btn facebook-btn"><span><i class="fab fa-facebook-f"></i></span>continue with facebook</a>
              <a href="<?=$googleUrl?>" class="btn google-btn"><span><i class="fab fa-google-plus-g"></i></span>continue with google</a>
          </div>

          <p>Already have an account? <a href="<?=base_url().'login'?>"> Login </a></p>
        </form>
      </div>

  
    </div>
  </div>
</section>  