<style type="text/css">
  
  .quantity-wrap {
    margin: 30px 0px;
  }

  .quantity-wrap button{
    width: 60px;
    height: 50px;

  }

  .quantity-wrap input{
    width: 60px;
    height: 50px;
  }

  .whatsapp-help-btn i {
    color: #25D366;
    font-size: 20px;
    margin-right: 10px;
}
</style>
<!--=================BREADCRUMB SECTION=================  -->
<section class="breadcrumb-menu p-100">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">products</li>
      </ol>
    </nav>
  </div>
</section>
<!-- =================PRODUCT SECTION================= -->
<section class="p-100 bg-cream">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="product-slider" id="detail">
          <div class="wishlist-wrapper" id='is_discounted'>
            <?php if ($varientDetails[0]->discount_per != 0){ ?>
              <div class="offer-wrap">
                <p>
                  <?=$varientDetails[0]->discount_per?> % off</p>
              </div>
              <?php }else{ ?>
                <div class="">
                  <p></p>
                </div>
                <?php } ?>
                  <div class="wishlist-icon" style="display: none" data-product_id ="<?=$product_id?>"> <i class="far fa-heart <?=(in_array($this->utility->safe_b64decode($product_id), $wish_pid)) ? "fas .fa-heart" : "" ?>"></i> </div>
          </div>
          <div class="slider slider-for">
            <?php
              if(count($product_image) > 0){ 
              foreach ($product_image as $key => $value){ ?>
              <div class="main-img-wrapper xzoom-container"> <img class="slide-img demo-trigger"
               src="<?=base_url().'public/images/'.$this->folder.'product_image/'.$value->image?>"  data-zoom="<?=base_url().'public/images/'.$this->folder.'product_image/'.$value->image?>"> </div>
              <?php }
               }else{ ?>
                 <div class="main-img-wrapper xzoom-container"> <img class="slide-img demo-trigger"
               src="<?=base_url().'public/images/'.$this->folder.'product_image/'.$image[0]?>"  data-zoom="<?=base_url().'public/images/'.$this->folder.'product_image/'.$image[0]?>"> </div>

              <?php } ?>
          </div>
          <div class="slider slider-nav">
            <?php foreach ($product_image as $key => $value){ ?>
              <div class="thumnail"> <img src="<?=base_url().'public/images/'.$this->folder.'product_image/'.$value->image?>"> </div>
              <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="product-detail-wrapper" id="product_detail">
          <div class="detail"></div>
          <?php if($varientDetails[0]->quantity > '25'){ ?>
            <div class="in-stock">
              <h6>Available(Instock)</h6>
            </div>
          <?php }else{ ?>
            <div class="in-stock">
              <h6>Limited Stock</h6>
            </div>
          <?php } ?>
          <h1><?=$productDetail[0]->name?></h1>
          <div class="product-price">
            <p><?=$this->siteCurrency?>
              <?=number_format((float)$varientDetails[0]->discount_price, 2, '.', '')?>
              <span class="orginal-price" style="<?=($varientDetails[0]->discount_per== 0) ? 'display:none' : '' ?>">
                <?=$this->siteCurrency?>
                <?=number_format((float)$varientDetails[0]->price, 2, '.', '')?>
            </span>
          </p>
          </div>
          <div class="product-vairant">
            <?php foreach ($varient as $key => $value) { ?> 
              <span class="variant product_varient_id <?=($varientDetails[0]->id == $value) ? 'active' : '' ?>" data-varient_id="<?=$this->utility->safe_b64encode($value)?>">
              <?=$weight_no[$key].' '.$weight_name[$key]?>
            </span>
              <?php } ?>
          </div>
          <?php 
            $d_none = '';
            $d_show = 'd-none';
            if(!empty($item_weight_id)){
              if(in_array($varientDetails[0]->id,$item_weight_id)){
                $d_show = '';
                $d_none = 'd-none';
              }
            }

          ?>
          <div class="d-flex align-items-center add-after-wrapper">
            <div class="quantity-wrap <?=$d_show?>">
              <button class="dec cart-qty-minus decqnt" data-product_weight_id="<?=$varientDetails[0]->id?>"><span class="minus"><i class="fa fa-minus"></i></span></button>
              <input class="qty" id="qnt" type="" name="" data-product_id = "<?= $this->utility->safe_b64decode($product_id)?>" value="<?=($cartQuantityForVarient != '') ? $cartQuantityForVarient : 1 ?>" readonly>
              <button class="inc cart-qty-plus incqnt" data-product_weight_id="<?=$varientDetails[0]->id?>"><span><i class="fa fa-plus"></i></span></button>
            </div>
            <?php if($isAvailable != '0'){ ?>
            <div class="order-btn ">
              <a href="javascript:" class="<?=$d_none?>">
                <button class="btn " id="addtocart"><span><i class="fas fa-shopping-basket"></i></span> add to cart
                </button>
              </a>
              <a href="javascript:">
                <button class="btn hover" id="order_now">order now</button>
              </a>
            <?php } ?>
               <?php 
              $product_id = $this->uri->segment(3);
              $varient_id = $this->uri->segment(4);
              $url = base_url().'products/productDetails/'.$product_id.'/'.$varient_id;
              ?>
              <?php
              if(!empty($BranchDetails) && $BranchDetails[0]->whatsappFlag  != '0' && $BranchDetails[0]->phone_no != ''){
                  $mobile = '91'.$BranchDetails[0]->phone_no; ?>
                <a target="_black" id='whatsapp_link' href="https://wa.me/<?=$mobile?>/?text=<?=$url?>">
                  <button class="btn hover whatsapp-help-btn" id=""><i class="fab fa-whatsapp"></i> Help!</button>
                </a>
              <?php } ?>
            </div>
          </div>
         <!--  <div class="quantity-wrap">
              <button class="cart-qty-minus decqnt"><span class="minus"><i class="fa fa-minus"></i></span></button>
              <input class="qty" id="qnt" type="text" name="" value="<?=($cartQuantityForVarient != '') ? $cartQuantityForVarient : 1 ?>">
              <button class="cart-qty-plus incqnt"><span><i class="fa fa-plus"></i></span></button>
            </div>
          <div class="order-btn">
            <a href="javascript:">
              <button class="btn" id="addtocart"><span><i class="fas fa-shopping-basket"></i></span> add to cart
              </button>
            </a>
            <a href="javascript:">
              <button class="btn hover" id="order_now">order now</button>
            </a>
          </div> -->
          <div class="product-description">
            <h6>Description :</h6>
            <p>
              <?=$productDetail[0]->about?>
            </p>
            <h6>Content :</h6>
            <p>
              <?=$productDetail[0]->content?>
            </p>
            <h6>Category: <span><?=$productDetail[0]->category_name?></span>
              Brand: <span><?=$productDetail[0]->brand_name?></span>
            </h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- =================RELATED PRODUCTS SECTION================= -->

<?php  if(count($related_product) > 4){ ?>
<section class="p-100 bg-cream">
  <div class="container">
    <div class="section-title-wrapper">
      <div class="row align-items-center">
        <div class="col-md-8 col-sm-8 col-12">
          <div class="section-title">
            <h1>related products</h1> </div>
        </div>
        <div class="col-md-4 col-sm-4 col-12">
          <div class="see-all-wrap"> <a href="<?=base_url().'products'?>">see all</a> </div>
        </div>
      </div>
    </div>
    <div id="top_feat_slider" class="owl-carousel top-feature-slider">
      
      
      <?php foreach ($related_product as $key => $value): 
        $value->name = character_limiter($value->name,30);
        if(($value->product_image == '') || !file_exists('public/images/'.$this->folder.'product_image/'.$value->product_image)){
            $CI = &get_instance();
            $CI->load->model('common_model'); 
            $value->product_image = $default_product_image;
        }
        $class = '';
        if(in_array($value->id, $wish_pid)){
          $class = 'fas .fa-heart';
        }
      ?> 
      <div class="item">
        <div class="product-wrapper">
          <?php if($value->varientQuantity == '0'){ ?>
            <div class="out-stock"><span class="out-heading">out of stock</span></div>
           <?php } ?>
          <div class="wishlist-wrapper">
            <?php if($value->discount_per > '0'){ ?>
            <div class="offer-wrap">
              <p><?=$value->discount_per.' % off'?></p>
            </div>
          <?php }else{ ?>
            <div class="">
            </div>
          <?php } ?>
            <div class="wishlist-icon" style="display: none" data-product_id="<?=$this->utility->safe_b64encode($value->id)?>"> <i class="far fa-heart <?=$class?>"></i> </div>
          </div>
          <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value->id).'/'.$this->utility->safe_b64encode($value->pw_id)?>">
            <div class="feat-img"> <img src="<?=base_url().'public/images/'.$this->folder.'product_image/'.$value->product_image ?>"> </div>
          </a>
          <div class="feature-detail">
            <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value->id).'/'.$this->utility->safe_b64encode($value->pw_id)?>">
              <h5><?=$value->name?></h5> </a>
            <h6><span><?=$this->siteCurrency?></i></span> <?=number_format((float)$value->discount_price, 2, '.', '')?></h6>
            <?php if($value->quantity >= 25){ ?> 
            <p>Available (in stock)</p>
            <?php }elseif($value->quantity <= 0){ ?>
              <p>limited stock</p>
            <?php } ?> 
          </div>
          <?php 
            $d_none = '';
            $d_show = 'd-none';
            if(!empty($item_weight_id)){
              if(in_array($value->pw_id,$item_weight_id)){
                $d_show = '';
                $d_none = 'd-none';
              }
            }

          ?>
          <div class="feature-bottom-wrap ">
            <div class="cart addcartbutton d-none" data-product_id="<?=$this->utility->safe_b64encode($value->id)?>"> <i class="fas fa-shopping-basket"></i>
            </div>
            <div class="new_add_to_cart <?=$d_none?>" >
                  <button class="btn addcartbutton" data-product_id="<?=$this->utility->safe_b64encode($value->id)?>" data-varient_id="<?=$this->utility->safe_b64encode($value->pw_id)?>">Add To Cart</button>
            </div>
            <div class="quantity-wrap <?=$d_show?>">
              <button class="dec cart-qty-minus related_cat" data-product_weight_id="<?=$value->pw_id?>"><span class="minus"><i class="fa fa-minus"></i></span></button>
              <input class="qty" type="text" name="" value="1" data-product_id="<?=$value->id?>" data-weight_id="<?=$value->weight_id?>" readonly>
              <button class="inc cart-qty-plus" data-product_weight_id="<?=$value->pw_id?>"><span><i class="fa fa-plus"></i></span></button>
            </div>
          </div>
          <!-- <div class="feature-bottom-wrap">
            <div class="cart addcartbutton" data-product_id="<?=$this->utility->safe_b64encode($value->id)?>"> <i class="fas fa-shopping-basket"></i>
            </div>
            <div class="quantity-wrap">
              <button class="cart-qty-minus"><span class="minus"><i class="fa fa-minus"></i></span></button>
              <input class="qty" type="text" name="" value="1" min="1" disabled="disabled">
              <button class="cart-qty-plus"><span><i class="fa fa-plus"></i></span></button>
            </div>
          </div> -->
        </div>
      </div>
      <?php endforeach ?>
    <!-- <div class="mobile-see-all"> <a href="<?=base_url().'producta'?>">see all</a> </div> -->
  </div>
<?php } ?>
<input type="hidden" name="product_id" id="product_id" value='<?=$product_id?>'>
<input type="hidden" name="product_varient_id" id="product_varient_id" value='<?=(isset($varientDetails[0]->id) && $varientDetails[0]->id != '' ) ? $this->utility->safe_b64encode($varientDetails[0]->id) : $this->utility->safe_b64encode($productDetail[0]->variant_id) ?>'>
</section>