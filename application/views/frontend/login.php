<!-- Page Header Section Start Here -->
        <section class="page-header bg_img padding-tb">
            <div class="overlay"></div>
            <div class="container">
                <div class="page-header-content-area">
                    <h4 class="ph-title">Sign In</h4>
                    <ul class="lab-ul">
                        <li><a href="">Home</a></li>
                        <li><a class="active">Sign In</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Page Header Section Ending Here -->
        
        <!-- Faq Page Section Start Here -->
        <div class="faq-section padding-tb bg-ash">
        	<div class="shape-images">
				<img src="<?=base_url().'public/frontend/'?>assets/images/shape-images/01.png" alt="shape-images">
			</div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                         <div class="order-detail-box">

                <div class="order-summary addnewaddress-area wow fadeInDown left-blog-img" data-wow-duration="2s" data-wow-delay="0s"  href="#">
                	<h3>Sign In</h3>
                    <form id="LoginForm" method="post" action="<?=base_url() .'login'?>">
                       <div class="form-group">
                          <label>email id</label>
                          <input type="email" name="email" class="form-control" id=""  placeholder="Enter Email" >
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">password</label>
                          <input type="password" name= "password" class="form-control" id="" placeholder="Enter Password">
                        </div> 
                        <div class="form-group box-d1">
                        	<label class="container1">Remember me
                                          <input type="checkbox" checked="checked">
                                          <span class="checkmark"></span>
                                        </label>
                          <a href="forgotepassword.html" class="forgotpassword">forgot password?</a>
                        </div>  
                        <div class="register-box">              
                          <button type="submit" class="btn btn-primary">Log In Now</button>
                         
                        </div>
                        <div class="connect-area">
                            <h2>OR CONNECT WITH</h2>
                            <div class="register-box">              
                             <a href="" class="btn register-btn red-btn">google</a>
                             <a href="" class="btn register-btn blue-btn">facebook</a>
                        </div>
                        </div>
                        <div class="">
                        	 <p> Don't Have an Account? <a href="<?=base_url().'login/register'?>" class="">Sign Up Now</a></p>
                        </div>
                    </form>
                 </div> 
               </div>
                    </div>
                </div>
            </div>
        </div>
