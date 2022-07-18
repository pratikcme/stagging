<div class="container">
      <div class="row align-items-center">
        <div class="col-md-3 col-sm-4 col-12">
          <div class="navbrand">
            <a href="<?=base_url()?>">
            <img src="<?=$this->siteLogo?>">
            </a>
          </div>
        </div>
        <div class="col-md-9 col-sm-8 col-12">
          <div class="menu-bar onlyLogin">

            <div class="sec_navbar">
              <ul class="">
                <li> <a href="<?=base_url().'about'?>">about us</a> </li>
                <li> <a href="<?=base_url().'contact'?>">contact us</a> </li>
              </ul>
            </div>
            <?php if($this->uri->segment(1) == ''){ ?>
            <div class="search-wrap">
             <input type="text" name="search" id='search' data-search_val= "" class="form-control" placeholder="Search vendor..">
             <span><i class="fas fa-search"></i></span>
            </div>
            <?php } ?>
            <?php if($this->uri->segment(1)!='login' && $this->uri->segment(1) != '') { ?>
            <?php if($ApprovedBranch[0]->approved_branch > '1'){ ?>
            <div class="location-wrap">
              <select class="form-control vendor_nav location-wrap">
                <option value=""> All store</option>
                <?php foreach ($branch_nav as $key => $v): ?>
                <option value="<?=$v->id?>" <?=(isset($_SESSION['branch_id']) && $v->id == $_SESSION['branch_id']) ? 'selected' : '' ?>><?=$v->name?></option>
                <?php endforeach ?>
            </select>
            </div>
            <?php } ?>
        <?php } ?>
              <?php 
              if($this->uri->segment(1) != ''){ 
                  $placeholder = 'Search product..';
              }
              '/'.$segment3 = $this->uri->segment(3);
              $segment2 = $this->uri->segment(2);
              $segment1 = $this->uri->segment(1);
            if($segment1 != '') { ?>
            <div class="search-wrap autocomplete">
               <input type="text" name="myCountry" id='myInput' data-search_val= "" class="form-control search web myInput" placeholder="<?=$placeholder?>">
               <!-- <span><i class="fas fa-search"></i></span> -->

               <div class="searchBar">
                 
               </div>
            </div> 
          <?php } ?> 

            <div class="d-flex">
            <div class="cart_outter_wrap">
            <div class="cart-wrap">
                <i class="fas fa-shopping-basket"></i>
               <span class="qnty-num" id="itemCount" <?=(isset($this->cartCount) && $this->cartCount != 0 ) ? 'style="display:block"' : 'style="display:none"' ?> ><?=(isset($this->cartCount)) ? $this->cartCount : '' ?></span>
            </div>
               <div class="cart-view-wrap <?=(!isset($this->cartCount) || $this->cartCount == 0) ? 'd-none' : '' ?>" id="nav_cart_dropdown">
                 <div class="cart-view-header">
                   <h6><span class="title-cart"><i class="fas fa-shopping-basket"></i></span>Cart</h6>
                   <span class="closing"><i class="fas fa-times-circle"></i></span>
                 </div>
                 <div class="cart-view-content ">
                  <?php if ($this->session->userdata('user_id') == ''){ ?> 
                   <ul id='updated_list'>
                    <?php if(isset($this->cartCount)){ 
                       $CI = &get_instance();
                       $CI->load->model('common_model');
                       $default_product_image =$CI->common_model->default_product_image(); ?>

                     <?php foreach ($this->session->userdata('My_cart') as $key => $value) {
                        $product = $CI->product_model->GetUsersProductInCart($value['product_weight_id']);
                        // dd($product);
                        $product[0]->image = preg_replace('/\s+/', '%20', $product[0]->image);

                        if(!file_exists('public/images/'.$CI->folder.'product_image/'.$product[0]->image) || $product[0]->image == '' ){
                          if(strpos($product[0]->image, '%20') === true || $product[0]->image == ''){
                            $product[0]->image = $default_product_image;
                          }else{
                            $product[0]->image = $default_product_image;
                          }
                        }
                    ?>
                     <li>
                          <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value['product_id']).'/'.$this->utility->safe_b64encode($value['product_weight_id'])?>">
                        <div class="cart-img-wrap">
                          <img src="<?=base_url()?>public/images/<?=$this->folder?>product_image/<?=$product[0]->image?>">
                        </div>
                      </a>
                        <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value['product_id']).'/'.$this->utility->safe_b64encode($value['product_weight_id'])?>">
                        <div class="cart-detail-wrap">
                          <h6><?=$value['product_name']?></h6>
                          <p><span><?=$value['quantity']?></span> X <?=number_format((float)$product[0]->discount_price, 2, '.', '')?></p>
                        </div>
                      </a>
                        <a href="javascript:" class="remove_item" data-product_id="<?=$value['product_id']?>" data-product_weight_id="<?=$value['product_weight_id']?>" >
                        <div class="cart-delete">
                          <i class="fas fa-times-circle"></i>
                        </div>
                      </a>
                      </li>
                    <?php } } ?>
                   </ul>
                 <?php }else{ ?>
                  <ul id='updated_list'>
                    <?php if(isset($this->cartCount)){ ?>
                     <?php foreach ($mycart as $key => $value) { ?>
                     <li>
                          <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value->product_id).'/'.$this->utility->safe_b64encode($value->product_weight_id)?>">
                        <div class="cart-img-wrap">
                          <img src="<?=base_url()?>public/images/<?=$this->folder?>product_image/<?=($value->image != '') ? $value->image : 'defualt.png' ?>">
                        </div>
                      </a>
                        <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value->product_id).'/'.$this->utility->safe_b64encode($value->product_weight_id)?>">
                        <div class="cart-detail-wrap">
                          <h6><?=$value->product_name?></h6>
                          <p><span><?=$value->quantity?></span> X <?=number_format((float)$value->discount_price, 2, '.', '')?></p>
                        </div>
                      </a>
                        <a href="javascript:" class="remove_item" data-product_id="<?=$value->product_id?>" data-product_weight_id="<?=$value->product_weight_id?>" >
                        <div class="cart-delete">
                          <i class="fas fa-times-circle"></i>
                        </div>
                      </a>
                      </li>
                    <?php } } ?>
                   </ul>
                 <?php } ?>
                  
                   <div class="subtotal-wrap">
                        <h6>Subtotal:</h6> 
                        <p id="nav_subtotal">
                          <?=$this->siteCurrency .' '. getMycartSubtotal()?>
                          </p>
                        </div>
                   <div class="view-cart-btn-wrapper">
                     <a href="<?=base_url().'products/cart_item'?>" class="btn">view cart</a>
                     <a href="<?=base_url().'checkout'?>" class="btn">checkout</a>
                   </div>
                   <!-- <p>Free shipping on all orders over 2000!</p> -->
                 </div>
             </div>
             </div>
             <?php if($this->session->userdata('user_id') != ''){ ?> 
             <div class="notif">
              <div class="<?=(count($notification) > 0) ? "btn__badge" : "" ?> pulse-button"  id="notify-dot"></div>
              <i class="fas fa-bell dropdown-toggle notify-dropdown"></i>   
              <ul class="dropdown notify-drop <?=(count($notification) == '0' ) ? "ishave" : "" ?>"  id="notification">
                <?php foreach ($notification as $key => $value): ?>
                 <li><?=$value->notification?></li>
               <?php endforeach ?>
               <?php 
               if(count($notification) == "0"){ ?> 
                <li>No Notification</li>
              <?php }else{?> 
               <li id="clear_all">Clear All</li>
             <?php } ?>
           </ul>

         </div>
         <?php } ?>
            <div class="mobile-login">
              <?php if($this->session->userdata('user_id') == ''){ ?>    
                 <div class="mobile-login-user_without_login" >
                  <a href="<?=base_url().'login'?>">
                  <i class="fas fa-user"></i>
                  </a>
                </div>
              <?php }else{ ?>
              <div class="mobile-login-user" >

                   <i class="fas fa-user"></i>
              </div>
              <?php } ?>
              <div class="user-profile" >
                 <div class="user-profile-header">
                   <h6><span class="title-cart"><i class="fas fa-user-circle"></i></span><?=$this->session->userdata('user_name')?></h6>
                   <span class="closing"><i class="fas fa-times-circle"></i></span>
                 </div>
                 <div class="user-profile-content">
                   <ul>
                     <li>
                      <a href="<?=base_url().'users_account/users/account?name=my_account'?>">
                        <span><i class="fas fa-user"></i></span>
                        My account
                      </a>   
                     </li>
                      <li>
                      <a href="<?=base_url().'users_account/users/account?name=order'?>">
                        <span><i class="fas fa-shopping-bag"></i></span>
                        My Orders
                      </a>   
                     </li>

                      <li  style="display: none">
                      <a href="<?=base_url().'users_account/users/account?name=wishlist'?>">
                        <span><i class="fas fa-heart"></i></span>
                        My Wishlist
                      </a>   
                     </li>

                      <li>
                      <a href="<?=base_url().'users_account/users/account?name=my_address'?>">
                        <span><i class="fas fa-address-book"></i></span>
                        My Address
                      </a>   
                     </li>
                      <?php if($userInformation[0]->login_type == '0'){ ?>
                      <li>
                      <a href="<?=base_url().'users_account/users/account?name=change'?>">
                        <span><i class="fas fa-lock"></i></span>
                        Change Password
                      </a>   
                     </li>
                    <?php } ?>
                      <li style="display: none">
                      <a href="<?=base_url().'users_account/users/account?name=faq'?>">
                        <span><i class="fas fa-info-circle"></i></span>
                       FAQ
                      </a>   
                     </li>
                    <li>
                      <a  id="logout">
                        <span><i class="fas fa-power-off"></i></span>
                       logout
                      </a>   
                     </li>
                      <li>
                      <a  id="delete_account">
                        <span><i class="fas fa-minus"></i></span>
                       Delete Account
                      </a>   
                     </li>
                     
                   </ul>
                 </div>
               </div>
         
            </div>
            </div>
          <!--   <div class="login-btn-wrap">
              <a href="login.html">Login</a>
            </div> -->
          <?php if($this->session->userdata('user_id') == null){ ?>
            <div class="login-btn-wrap">
              <a href="<?=base_url().'login'?>">Login</a>
            </div>
          <?php }else{ ?>
            <div class="user-logged dropdown">
            <button type="button" >
              <!-- <span class="profile"><img src="<?=base_url()?>public/assets/images/profile.png"></span> -->
              <?=$this->session->userdata('user_name')?>
              <span class="down-arrow"><i class="fas fa-chevron-down"></i></span>
            </button>

            <div class="user-profile" >
                 <div class="user-profile-header">
                   <h6><span class="title-cart"><i class="fas fa-user-circle"></i></span><?=$this->session->userdata('user_name')?></h6>
                   <span class="closing"><i class="fas fa-times-circle"></i></span>
                 </div>
                 <div class="user-profile-content">
                   <ul>
                     <li>
                      <a href="<?=base_url().'users_account/users/account?name=my_account'?>">
                        <span><i class="fas fa-user"></i></span>
                        My account
                      </a>   
                     </li>
                      <li>
                      <a href="<?=base_url().'users_account/users/account?name=order'?>">
                        <span><i class="fas fa-shopping-bag"></i></span>
                        My Orders
                      </a>   
                     </li>

                      <li style="display: none">
                      <a href="<?=base_url().'users_account/users/account?name=wishlist'?>">
                        <span><i class="fas fa-heart"></i></span>
                        My Wishlist
                      </a>   
                     </li>

                      <li>
                      <a href="<?=base_url().'users_account/users/account?name=my_address'?>">
                        <span><i class="fas fa-address-book"></i></span>
                        My Address
                      </a>   
                     </li>
                     <?php if($userInformation[0]->login_type == '0'){ ?>
                     <li>
                      <a href="<?=base_url().'users_account/users/account?name=change'?>">
                        <span><i class="fas fa-lock"></i></span>
                        Change Password
                      </a>   
                     </li>
                   <?php } ?>
                      <li style="display: none">
                      <a href="<?=base_url().'users_account/users/account?name=faq'?>">
                        <span><i class="fas fa-info-circle"></i></span>
                       FAQ
                      </a>   
                     </li>
                     
                       <li>
                      <a  id="logout">
                        <span><i class="fas fa-power-off"></i></span>
                       logout
                      </a>   
                     </li>
                      <li>
                      <a  id="delete_account">
                        <span><i class="fas fa-minus"></i></span>
                       Delete Account
                      </a>   
                     </li>
                     
                   </ul>
                 </div>
               </div>
          </div>
          <?php } ?>
         <!--  <div class="lang-wrapper">
            <div class="lang-flag">
              <img src="<?=base_url()?>public/frontend/assets/images/flag.png">
            </div>
            <select>
              <option>ENG</option>
              <option>PAK</option>
              <option>SA</option>
            </select>  
          </div> -->
          </div>
        </div>
         
         <div class="col-md-12">
          <div class="mobile-location">
             <?php if($this->uri->segment(1)!='login' && $ApprovedBranch[0]->approved_branch > '1') { ?>
            <?php if($ApprovedBranch[0]->approved_branch > '1'){ ?>
              <div class="location-wrap-2">
                <select class="form-control vendor_nav">
                <option value=""> All store</option>
                <?php foreach ($branch_nav as $key => $v): ?>
                <option value="<?=$v->id?>" <?=(isset($_SESSION['vendor_id']) && $v->id == $_SESSION['vendor_id']) ? 'selected' : '' ?>><?=$v->name?></option>
                <?php endforeach ?>
            </select>
            </div>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-12">
           <div class="mobile-search">
           <?php 
             
              if($this->uri->segment(1) != ''){ 
                  $placeholder = 'Search product..';
              }
              '/'.$segment3 = $this->uri->segment(3);
              $segment2 = $this->uri->segment(2);
              $segment1 = $this->uri->segment(1); 
            if($segment1 != '' ) { ?>
            <div class="search-wrap-2">
              <input type="text" name="search" attr-v="mob" class="form-control search myInput" placeholder="<?=$placeholder?>">
             <span><i class="fas fa-search"></i></span>
            </div>
         <?php } ?> 
        <?php } ?>
            </div>
        </div>
      </div>
    </div>