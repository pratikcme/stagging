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
          <h1>Login<br>Your Account</h1>
        </div>
      </div>
      <div class="col-md-12">
        <form id="Register_Form" method="post" class="login-form register-form" action="<?=base_url().'register'?>">
          <input type="hidden" id="user_id">
          <div class="">
            <select name="country_code" id="country_code" class="input-wrapper">
              <?php foreach($country_code as $key => $value){ ?>
                 <option value="<?=$key;?>"><?=$value;?></option>
               <?php } ?>             
            </select>
          </div>
        <div class="input-wrapper">
          <span><i class="fas fa-mobile"></i></span>
          <input type="text" name="phone" id="phone"  class="mob_no" placeholder="Mobile Number*" required>
        </div>

          <label for="phone" class="error"></label>

          <div id="completeOTP">

          <div class="input-wrapper">
            <span><i class="fas fa-key"></i></span>
            <input type="text" name="otp" id="otp"  class="OTP" placeholder="OTP" required>
          </div>

          <label for="otp" class="varify-error error"></label>
          <label id="resetcounter">Didn't get the code? </label>
          <button type="button" id="resend" >Resend OTP</button>
          </div>
          <div id="completeProfile" style="display:none">
            <div class="input-wrapper">
              <span><i class="fas fa-user"></i></span>
              <input type="text" id="fname" placeholder="First Name*" required>
            </div>
            <label for="fname" class="error"></label>

            <div class="input-wrapper">
              <span><i class="fas fa-user"></i></span>
              <input type="text" id="lname" placeholder="Last Name*" required>
            </div>
            <label for="lname" class="error"></label>


          <div class="input-wrapper">
            <span><i class="fas fa-envelope"></i></span>
            <input type="text" id="email" placeholder="Email">
          </div>
         
        </div>



          <button type="button" class="btn create-btn send" id="frmBtn">Send Code</button>

          
        </form>
      </div>

  
    </div>
  </div>
</section>  