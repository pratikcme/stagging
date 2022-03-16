<div id="app">
    <section class="section">
      <div class="container mt-5">
      <?php if($this->session->flashdata('danger') != ''){
          echo $this->session->flashdata('danger');
        }else{
          echo $this->session->flashdata('success');
        } ?>
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <div class="card-body">
                <form id="frmAddEditSection" method="POST" action="<?=$FormAction?>" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    <label id="email-error" class="error" style="color: red" for="email"><?php echo @form_error('email') ?></label>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="javascript:" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <label id="password-error" class="error" style="color: red" for="password"><?php echo @form_error('passsword') ?></label>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" name="btnSubmit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
                <div class="text-center mt-4 mb-3">
                  <div class="text-job text-muted">Login With Social</div>
                </div>
                <div class="row sm-gutters">
                  <div class="col-6">
                    <a class="btn btn-block btn-social btn-facebook">
                      <span class="fab fa-facebook"></span> Facebook
                    </a>
                  </div>
                  <div class="col-6">
                    <a class="btn btn-block btn-social btn-twitter">
                      <span class="fab fa-twitter"></span> Twitter
                    </a>
                  </div>
                </div>
                <div class="mt-5 text-muted text-center">
              Don't have an account? <a href="javascript:">Create One</a>
                </div>
            <!--   <div class="text-muted text-center"  >
              Reset your password <a href="<?=base_url()?>account/resetpass">Reset Paasword</a>
              </div> -->
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </section>
  </div>
 