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

          
        
        
        <label for="term_policy" class="error"></label>


          <button class="btn create-btn">create Account</button>

          
        </form>
      </div>

  
    </div>
  </div>
</section>  