<div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-6 ">
        <ul>
          <h6>Categories</h6>
          <?php foreach ($CategoryHighrstProduct as $key => $value) { ?>
          <li><a href="<?=base_url().'products?cat_id='.$this->utility->safe_b64encode($value->id)?>"><?=$value->name?></a></li>
          <?php } ?>
        </ul>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-6 ">
        <ul>
          <h6>useful links</h6>
          <li><a href="<?=base_url().'about'?>">About Us</a></li>
          <!-- <li><a href="product-list.html">Featured Products</a></li>
          <li><a href="#">Offers</a></li>
          <li><a href="<?=base_url().'vendors'?>">Vendors</a></li> -->
          <li><a href="<?=base_url().'privacy_policy'?>">Privacy Policy</a></li>
          <li><a href="<?=base_url().'terms_condition'?>">Term & Conditions</a></li>
          <li><a href="<?=base_url().'return_refund'?>">Refund & Return</a></li>
          <li><a href="<?=base_url().'contact'?>">Contact Us</a></li>
          
        </ul>
      </div>

          <!-- <div class="col-lg-4 col-md-6 col-sm-6 ">
        <ul>
          <h6>top cities</h6>
          <li><a href="#">Ahmedabad</a></li>
          <li><a href="#">Bharuch</a></li>
          <li><a href="#">Vadodara</a></li>
          <li><a href="#">Surat</a></li>
          <li><a href="#">Mumbai</a></li>
          <li><a href="#">Kolkata</a></li>
          <li><a href="#">Bangaluru</a></li>
          <li><a href="#">New Delhi</a></li>
        </ul>
      </div> -->
      <div class="col-lg-4 col-md-6 col-sm-6 ">
        <div class="download-app">
          <h6>Download app</h6>
          <div class="play-store-img">
            <!-- Ios app link -->
            <a href="<?=(!empty($appLinks)  && $appLinks[0]->ios_app_link != '') ? $appLinks[0]->ios_app_link : "#" ?>">
              <img src="<?=base_url()?>public/frontend/assets/images/app-1.png">
            </a>

            <!-- android app link -->
            <a href="<?=(!empty($appLinks) && $appLinks[0]->android_app_link != '' ) ? $appLinks[0]->android_app_link : "#" ?>">
              <img src="<?=base_url()?>public/frontend/assets/images/app-2.png">
            </a>
          </div>
        </div>

        <ul class="payment-method">
          <h6>Payment Method</h6>

          <li><img src="<?=base_url()?>public/frontend/assets/images/payment-1.png"></li>
          <li><img src="<?=base_url()?>public/frontend/assets/images/payment-2.png"style="max-width: 35px"></li>
          <li><img src="<?=base_url()?>public/frontend/assets/images/payment-3.png" style="max-width: 60px"></li>
          <li><img src="<?=base_url()?>public/frontend/assets/images/payment-4.png" style="max-width: 60px"></li>
          <!-- <li><img src="<?=base_url()?>public/frontend/assets/images/payment-5.png"></li> -->
        </ul>

       <!--  <div class="subscribe-email">
           <h6>Subscribe </h6>
          <form>
            <div class="email-wrap">
              <input type="text" name="" placeholder="Email Address">
              <button><i class="fa fa-paper-plane"></i></button>
            </div>
          </form>
        </div> -->

      </div>
    </div>
  </div>