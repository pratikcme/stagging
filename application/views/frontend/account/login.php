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
          <h1>Sign In<br>To Your Account</h1>
        </div>
      </div>
      <div class="col-md-6">
        <form id="LoginForm" class="login-form" method="post" action="<?=base_url().'login'?>">
          
          <div class="input-wrapper">
            <span><i class="fas fa-envelope"></i></span>
            <input type="text" name="email" placeholder="Email*" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','');" autocomplete="off">
          </div>
          <label for="email" class="error"><?=form_error('email')?></label>
          
           <div class="input-wrapper">
            <span><i class="fas fa-lock"></i></span>
            <input type="password" name="password" placeholder="password*" id="password" autocomplete="off">
            <span id="eye"><i class="far fa-eye-slash"></i></span>
          <!--   <i class="far fa-eye-slash"></i> -->
          </div>
          <label for="password" class="error"><?=form_error('password')?></label>

          <button class="btn">sign in</button>
          
          <div class="or-partition" >
            <span>- or -</span>
          </div>
          <div class="social-btns" >
            <a href="<?=base_url().'login/fb_login'?>" class="btn facebook-btn"><span><i class="fab fa-facebook-f"></i></span>continue with facebook</a>
            <a href="<?=$googleUrl?>" class="btn google-btn"><span><i class="fab fa-google-plus-g"></i></span>continue with google</a>
          </div>

          <a href="<?=base_url().'login/forget_password'?>">Forgot your password?</a>
        </form>
      </div>

      <div class="col-md-6">
        <div class="create-acc">
          <h2>Don't have an account?</h2>
        <!--   <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.
          Sit aliquid, Non distinctio vel iste.</p> -->
          <a href="<?=base_url().'register'?>" class="btn">Create Account</a>
        </div>
      </div>
    </div>
  </div>
</section>
        <!-- Faq Page Section Ending Here -->
