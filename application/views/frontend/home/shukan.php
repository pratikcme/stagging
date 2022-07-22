<style type="text/css">
.shukan_slider .slider_box {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}
.shukan_slider .slider_box.categoty_shukan{
  display: flex;
    justify-content: center;
    flex-wrap: wrap;
}
.shukan_slider .slider_box.categoty_shukan .shukan_product {
  flex-basis: 18%;
    margin: 0 5px;
}
.shukan_product {
    flex-basis: 23%;
    margin: 0 10px;
}
</style>
<?php 
// error_reporting(E_ALL);
// ini_set("display_errors", '1');  
 ?>
<!-- =================BANNER SLIDER================= -->
<div id="carousel" class="carousel slide hero-slides" data-ride="carousel">
  <ol class="carousel-indicators">
   <?php for($b=0;$b< count($banner);$b++){ ?>
      <li class="active" data-target="#carousel" data-slide-to="<?= $b;?>"></li>
    <!-- <li data-target="#carousel" data-slide-to="1"></li>
    <li data-target="#carousel" data-slide-to="2"></li> -->
    <?php } ?>
  </ol>
  <div class="carousel-inner" role="listbox">
    <?php $calss = array('boat','sea','river','boat','sea','river','boat','sea','river'); ?>
    <?php foreach ($banner as $key => $value){ ?>

    <div class="carousel-item <?=($key == 0) ? "active" : ""?> <?=$calss[$key]?>">
    <img src="<?php echo base_url().'public/images/'.$this->folder.'web_banners/'.$value->web_banner_image?>" class="banner-image" alt="">
      <div class="container h-100 ">
        <div class="row align-items-center h-100">
          <div class="col-12 col-md-12 col-lg-12 col-xl-12">
            <div class="caption animated fadeIn">
              <!-- <h2 class="animated fadeInLeft">Hurry! <span style="color:red;">Fresh offer </span> </h2> -->
              <h2 class="animated fadeInLeft"> <?=$value->main_title?> </h2>
              <p class="animated fadeInRight"><?=$value->sub_title?></p> 
              <a class="btn animated fadeInUp" href="<?=base_url().'products'?>">Shop Now</a> </div>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>

  </div>
</div>
<?php if(!empty($offer_list)){ ?>

 <section class="p-100 bg-light-blue">
  <div class="container">
    <div class="section-title-wrapper">
      <div class="row align-items-center">
        <div class="col-md-8 col-sm-8 col-12">
          <div class="section-title">
            <h1>shop by offers</h1> </div>
        </div>
       
        <div class="col-md-4 col-sm-4 col-12">
          <div class="see-all-wrap"> <a href="<?=base_url().'products'?>">see all</a> </div>
        </div>

     
      </div>
       
    </div>
     <div class="row offer-wrapper">

      <?php  foreach ($offer_list as $key => $value): ?>
        
        <div class="col-lg-4 col-md-6">
          <div class="offers">
          <a href="<?=base_url().'home/get_offer_product_listing/'.$this->utility->safe_b64encode($value->id)?>">
            <h6>Up to <?=$value->offer_percent?>% off | <?=$value->offer_title?></h6>
            <div class="offer-img">
              <img src="<?=$value->image?>">
            </div>
          </a>
          </div>
        </div>
      <?php   endforeach ?>
      </div>
    <div class="mobile-see-all"> <a href="<?=base_url().'products'?>">see all</a> </div>
  </div>
</section> 
<?php } ?>
<!-- =================ABOUT SECTION================= -->
<?php foreach ($home_content as $key => $value): ?>
  <?php if($key%2 == 0){ ?>  
<section class="p-100 pb-0 abt_section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="abt_content">
          <h2><?=$value->main_title?></h2>
          <p class="mt-4"><?=$value->sub_title?></p>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="abt_image abt_one">
          <!-- <img src="<?=base_url().'public/frontend/assets/images/pngwing.png' ?>" class="pngwing_img"> -->
          <img src="<?php echo base_url().'public/uploads/home_content/'.$value->image ?>" class="about_img" alt="">
        </div>
      </div>
    </div>
  </div>
</section>
  <?php }else{ ?> 
<section class="p-100 abt_section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 col-md-6 col-sm-12 order-lg-1 order-md-1 order-2">
        <div class="abt_image">
          <img src="<?php echo base_url().'public/uploads/home_content/'.$value->image ?>" class="about_img1" alt="">
        </div>
        <!-- <img src="<?=base_url().'public/frontend/assets/images/pngwing.png'?>" class="pngwing_img"> -->
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 order-lg-2 order-md-2 order-1">
        <div class="abt_content">
          <h2><?=$value->main_title?></h2>
          <p class="mt-4"><?=$value->sub_title?></p>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } ?>

<?php endforeach ?>
<!-- =================NEW PRODUCTS SECTION================= -->
<?php if(count($new_arrival) > 5){ ?>  
<section class="p-50 bg-cream">
  <div class="container">
    <div class="section-title-wrapper">
      <div class="row align-items-center">
        <div class="col-md-8 col-sm-8 col-12">
          <div class="section-title">
            <h1>new products</h1> </div>
        </div>
        <div class="col-md-4 col-sm-4 col-12">
          <div class="see-all-wrap"> <a href="<?=base_url().'products'?>">see all</a> </div>
        </div>
      </div>
    </div>
    <div id="new_product_1" class="owl-carousel top-feature-slider new_product_1">
    <?php 
    foreach ($new_arrival as $key => $value): 
      $class = '';
        if(in_array($value->id, $wish_pid)){
          $class = 'fas .fa-heart';
        }

      ?>
      <?php $value->name = character_limiter($value->name,30); ?>
    <?php if($key < 25){ ?>
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
            <div class="feat-img"> <img src="<?=base_url().'public/images/'.$this->folder.'product_image/'.$value->image ?>"> </div>
          </a>
          <div class="feature-detail">
            <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value->id).'/'.$this->utility->safe_b64encode($value->pw_id)?>">
              <h5><?=$value->name?></h5> </a>
            <h6><span><?=$this->siteCurrency?></span> <?=number_format((float)$value->discount_price, 2, '.', '')?></h6>
            <p><?=($value->quantity > 25 ) ? 'Available (in stock)' : 'limited stock' ?></p>
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
              <button class="dec cart-qty-minus" data-product_weight_id="<?=$value->pw_id?>"><span class="minus"><i class="fa fa-minus"></i></span></button>
              <input class="qty" type="text" name="" value="<?=(!empty($value->addQuantity)) ? $value->addQuantity : 1 ?>" data-product_id="<?=$value->id?>" data-weight_id="<?=$value->weight_id?>" readonly>
              <button class="inc cart-qty-plus" data-product_weight_id="<?=$value->pw_id?>"><span><i class="fa fa-plus"></i></span></button>
            </div>
          </div>
          <!-- <div class="feature-bottom-wrap">
            <div class="cart addcartbutton" data-product_id="<?=$this->utility->safe_b64encode($value->id)?>"> <i class="fas fa-shopping-basket"></i>
            </div>
            <div class="quantity-wrap">
              <button class="cart-qty-minus"><span class="minus"><i class="fa fa-minus"></i></span></button>
              <input class="qty" type="text" name="" value="1">
              <button class="cart-qty-plus"><span><i class="fa fa-plus"></i></span></button>
            </div>
          </div> -->
        </div>
      </div>
  <?php } ?>
  <?php endforeach ?>
    </div>
  <?php $slide_cnt ="";	?>

    <div id="new_product_2" class="owl-carousel top-feature-slider new_product_2 <?=($slide_cnt < 25) ? 'd-none' : ''?> ">
  <?php foreach ($new_arrival as $key => $value) 
  		: $slide_cnt = $key ?>
    <?php $value->name = character_limiter($value->name,30); ?>
    <?php if($key >= 25){ ?>
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
            <div class="feat-img"> <img src="<?=base_url().'public/images/'.$this->folder.'product_image/'.$value->image ?>"> </div>
          </a>
          <div class="feature-detail">
            <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value->id).'/'.$this->utility->safe_b64encode($value->pw_id)?>">
              <h5><?=$value->name?></h5> </a>
            <h6><span><?=$this->siteCurrency?></span><?=number_format((float)$value->discount_price, 2, '.', '')?></h6>
            <p><?=($value->quantity > 25 ) ? 'Available (in stock)' : 'limited stock' ?></p>
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
              <button class="dec cart-qty-minus" data-product_weight_id="<?=$value->pw_id?>"><span class="minus"><i class="fa fa-minus"></i></span></button>
              <input class="qty" type="text" name="" value="<?=(!empty($value->addQuantity)) ? $value->addQuantity : 1 ?>" data-product_id="<?=$value->id?>" data-weight_id="<?=$value->weight_id?>" readonly>
              <button class="inc cart-qty-plus" data-product_weight_id="<?=$value->pw_id?>"><span><i class="fa fa-plus"></i></span></button>
            </div>
          </div>
         <!--  <div class="feature-bottom-wrap">
            <div class="cart addcartbutton" data-product_id="<?=$this->utility->safe_b64encode($value->id)?>"> <i class="fas fa-shopping-basket"></i> </div>
            <div class="quantity-wrap">
              <button class="cart-qty-minus"><span class="minus"><i class="fa fa-minus"></i></span></button>
              <input class="qty" type="text" name="" value="1">
              <button class="cart-qty-plus"><span><i class="fa fa-plus"></i></span></button>
            </div>
          </div> -->
        </div>
      </div>
  <?php } ?>
  <?php endforeach ?>
    </div>
    <div class="mobile-see-all"> <a href="<?=base_url().'products'?>">see all</a> </div>
  </div>
</section>
<?php }else{ ?>
   <section class="shukan_slider bg-light-blue p-100">
  <div class="container">
    <div class="row">
       <div class="col-md-8 col-sm-8 col-12">
          <div class="section-title mb-5">
            <h1>new products</h1>  
          </div>
        </div>
      <div class="col-lg-12">
        <div class="slider_box">
         <?php foreach ($new_arrival as $key => $value) 
      : $slide_cnt = $key ?>
      <?php $value->name = character_limiter($value->name,30); ?>  
          <div class="shukan_product">
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
            <div class="feat-img"> <img src="<?=base_url().'public/images/'.$this->folder.'product_image/'.$value->image ?>"> </div>
          </a>
          <div class="feature-detail">
            <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value->id).'/'.$this->utility->safe_b64encode($value->pw_id)?>">
              <h5><?=$value->name?></h5> </a>
            <h6><span><?=$this->siteCurrency?></span><?=number_format((float)$value->discount_price, 2, '.', '')?></h6>
            <p><?=($value->quantity > 25 ) ? 'Available (in stock)' : 'limited stock' ?></p>
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
              <button class="dec cart-qty-minus" data-product_weight_id="<?=$value->pw_id?>"><span class="minus"><i class="fa fa-minus"></i></span></button>
              <input class="qty" type="text" name="" value="<?=(!empty($value->addQuantity)) ? $value->addQuantity : 1 ?>" data-product_id="<?=$value->id?>" data-weight_id="<?=$value->weight_id?>" readonly>
              <button class="inc cart-qty-plus" data-product_weight_id="<?=$value->pw_id?>"><span><i class="fa fa-plus"></i></span></button>
            </div>
          </div>
         <!--  <div class="feature-bottom-wrap">
            <div class="cart addcartbutton" data-product_id="<?=$this->utility->safe_b64encode($value->id)?>"> <i class="fas fa-shopping-basket"></i> </div>
            <div class="quantity-wrap">
              <button class="cart-qty-minus"><span class="minus"><i class="fa fa-minus"></i></span></button>
              <input class="qty" type="text" name="" value="1">
              <button class="cart-qty-plus"><span><i class="fa fa-plus"></i></span></button>
            </div>
          </div> -->
        </div>
          
          </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php } ?>

<section class="numbered-section p-100" style="background: url(<?=(!empty($background_image) && $background_image != '' ) ? base_url()."public/uploads/home_content/".$background_image[0]->image : base_url()."public/frontend/assets/images/online_shopping.jpg"?>) no-repeat;background-size: cover;position: relative;">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <ul id="counter">
          <li class="text-center">
            <div class="abt_icon">
              <img src="<?=base_url().'public/uploads/home_content/'.$home_section_one[0]->image1?>" alt="">
            </div>
            <div class="num_text">
              <span class="count percent" data-count="<?=$home_section_one[0]->number1?>">0</span>+
            </div>
            <h5><?=$home_section_one[0]->main_title1?></h5>
          </li>
          <li class="text-center">
            <div class="abt_icon">
              <img src="<?=base_url().'public/uploads/home_content/'.$home_section_one[0]->image2?>" alt="">
            </div>
            <div class="num_text">
              <span class="count percent" data-count="<?=$home_section_one[0]->number2?>">0</span>+
            </div>
            <h5><?=$home_section_one[0]->main_title1?></h5>
          </li>
          <li class="text-center">
            <div class="abt_icon">
              <img src="<?=base_url().'public/uploads/home_content/'.$home_section_one[0]->image3 ?>" alt="">
            </div>
            <div class="num_text">
              <span class="count percent" data-count="<?=$home_section_one[0]->number3?>">0</span>+
            </div>
            <h5><?=$home_section_one[0]->main_title3?></h5>
          </li>
          <li class="text-center">
            <div class="abt_icon">
              <img src="<?=base_url().'public/uploads/home_content/'.$home_section_one[0]->image4 ?>" alt="">
            </div>
            <div class="num_text">
              <span class="count percent" data-count="<?=$home_section_one[0]->number4?>">0</span>+
            </div>
            <h5><?=$home_section_one[0]->main_title4?></h5>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>
