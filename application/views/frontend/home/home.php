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
.alert{
  display: none;
}

</style>
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
    <div class="carousel-item <?=($key == 0) ? "active" : ""?> <?=$calss[$key]?>" data-id="<?=$value->web_banner_image?>">
    <img data-src="<?php echo base_url().'public/images/'.$this->folder.'web_banners/'.$value->web_banner_image?>" class="banner-image lazy" alt="">
      <div class="container h-100 ">
        <div class="row align-items-center h-100">
          <div class="col-12 col-md-12 col-lg-12 col-xl-12">
            <div class="caption animated fadeIn">
              <!-- <h2 class="animated fadeInLeft">Hurry! <span style="color:red;">Fresh offer </span> </h2> -->
              <h2 class="animated fadeInLeft"> <?=$value->main_title?> </h2>
              <p class="animated fadeInRight"><?=$value->sub_title?></p> 
              <?php if($value->type == '1'){ ?>
               <a class="btn animated fadeInUp" href="<?=base_url().'products'?>">Shop Now</a> </div>
              <?php }else if($value->type == '2'){ ?>
                  <a class="btn animated fadeInUp" href="<?=base_url().'products?cat_id='.$this->utility->safe_b64encode($value->category_id)?>">Shop Now</a> </div>
              <?php }else{ ?>
                  <a class="btn animated fadeInUp" href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value->product_id).'/'.$this->utility->safe_b64encode($value->product_varient_id)?>">Shop Now</a> </div>
              <?php } ?>
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
<!-- =================CATEGORY SECTION================= -->
<?php if(count($category) > 5){ ?> 
<section class="p-100 bg-light-blue">
  <div class="container">
    <div class="section-title-wrapper">
      <div class="row align-items-center">
        <div class="col-md-8 col-sm-8 col-12">
          <div class="section-title">
            <h1>shop by categories</h1> </div>
        </div>
        <div class="col-md-4 col-sm-4 col-12">
          <div class="see-all-wrap"> <a href="<?=base_url().'products'?>">see all</a> </div>
        </div>
      </div>
    </div>
    <div id="category_slider" class="owl-carousel category-slider">
      <?php foreach ($category as $key => $value): ?>

        <div class="item">
          <a href="<?=base_url().'products?cat_id='.$this->utility->safe_b64encode($value->id)?>">
            <div class="category-wrapper">
              <div class="category-img"><img class="lazy" data-src="<?=base_url().'public/images/'.$this->folder.'category/'.$value->image?>"> </div>
              <div class="category-name">
                <h6><?=$value->name?></h6> </div>
            </div>
          </a>
        </div>
        <?php endforeach ?>
         </div>
    <div class="mobile-see-all"> <a href="<?=base_url().'products'?>">see all</a> </div>
  </div>
</section>
<?php }else{ ?>
<!-- =================For Shukan SECTION================= -->
  <section class="shukan_slider bg-cream p-100">
    <div class="container">
      <div class="row">
           <div class="col-md-8 col-sm-8 col-12">
          <div class="section-title mb-5">
            <h1>shop by categories</h1> </div>
        </div>
        <div class="col-lg-12">
          <div class="slider_box categoty_shukan">
          <?php foreach ($category as $key => $value): ?>
            <div class="shukan_product">
             <a href="<?=base_url().'products?cat_id='.$this->utility->safe_b64encode($value->id)?>">
                <div class="category-wrapper">
                  <div class="category-img"> <img class="lazy" data-src="<?=base_url().'public/images/'.$folder.$value->image?>"> </div>
                  <div class="category-name">
                    <h6><?=$value->name?></h6> </div>
                </div>
              </a>
            </div>
          <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>
</section>
 <?php } ?>




<!-- =================TOP FEATURE SECTION================= -->
<?php if(count($top_sell) > 4){ ?> 
<section class="p-100 bg-cream pb-5" >
  <div class="container">
    <div class="section-title-wrapper">
      <div class="row align-items-center">
        <div class="col-md-8 col-sm-8 col-12">
          <div class="section-title">
            <h1>Top featured products</h1> </div>
        </div>
        <div class="col-md-4 col-sm-4 col-12">
          <div class="see-all-wrap"> <a href="<?=base_url().'products'?>">see all</a> </div>
        </div>
      </div>
    </div>
    <div id="top_feat_slider" class="owl-carousel top-feature-slider">

    <?php  

    // $item_weight_id = array_column($_SESSION["My_cart"], "product_weight_id");
  
    foreach ($top_sell as $key => $value): 
      $class = '';
        if(in_array($value->id, $wish_pid)){
          $class = 'fas .fa-heart';
        }
      ?>  
     <?php $value->name = character_limiter($value->name,30);
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
            <div class="feat-img"> <img class="lazy" data-src="<?=base_url().'public/images/'.$this->folder.'product_image/'.$value->image ?>"> </div>
          </a>
          <div class="feature-detail">
            <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value->id).'/'.$this->utility->safe_b64encode($value->pw_id)?>">
              <h5><?=$value->name?></h5> </a>
            <h6><span><?=$this->siteCurrency?></span> <?=number_format((float)$value->discount_price, 2, '.', '')?></h6>
            <p><?=($value->quantity >= 25 ) ? 'Available (in stock)' : 'limited stock' ?></p>
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
        </div>
      </div>
      <?php endforeach ?>
    </div>
    <div class="mobile-see-all"> <a href="<?=base_url().'products'?>">see all</a> </div>
  </div>
</section>
<?php }else{ ?>
  <section class="shukan_slider bg-light-blue p-100" style="display: <?=(count($top_sell) === 0 ) ? 'none' : '' ?>">
  <div class="container">
    <div class="row">
   <div class="section-title-wrapper">
      <div class="row align-items-center">
        <div class="col-md-12 col-sm-12 col-12">
          <div class="section-title">
            <h1>Top featured products</h1> </div>
        </div>
        <!-- <div class="col-md-4 col-sm-4 col-12">
          <div class="see-all-wrap"> <a href="https://mehtaenterpriseonline.com/products">see all</a> </div>
        </div> -->
      </div>
    </div>
      <div class="col-lg-12">
        <div class="slider_box">
           <?php  foreach ($top_sell as $key => $value): 
          $class = '';
            if(in_array($value->id, $wish_pid)){
              $class = 'fas .fa-heart';
            }
          ?>  
          <div class="shukan_product">
        <?php $value->name = character_limiter($value->name,30); ?>
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
            <div class="feat-img"> <img class="lazy" data-src="<?=base_url().'public/images/'.$this->folder.'product_image/'.$value->image ?>"> </div>
          </a>
          <div class="feature-detail">
            <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value->id).'/'.$this->utility->safe_b64encode($value->pw_id)?>">
              <h5><?=$value->name?></h5> </a>
            <h6><span><?=$this->siteCurrency?></span> <?=number_format((float)$value->discount_price, 2, '.', '')?></h6>
            <p><?=($value->quantity >= 25 ) ? 'Available (in stock)' : 'limited stock' ?></p>
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
        </div>
          </div>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } ?>
<!-- =================BEST OFFERS SECTION================= -->

<!-- =================NEW PRODUCTS SECTION================= -->
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
            <div class="feat-img"> <img class="lazy" data-src="<?=base_url().'public/images/'.$this->folder.'product_image/'.$value->image ?>"> </div>
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
         <!--  <div class="feature-bottom-wrap">
            <div class="cart addcartbutton" data-product_id="<?=$this->utility->safe_b64encode($value->id)?>"> <i class="fas fa-shopping-basket"></i>
            </div>
            <div class="quantity-wrap">
              <button class="cart-qty-minus"><span class="minus"><i class="fa fa-minus"></i></span></button>
              <input class="qty" type="text" name="" value="<?=$value->addQuantity?>">
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
            <div class="feat-img"> <img class="lazy" data-src="<?=base_url().'public/images/'.$this->folder.'product_image/'.$value->image ?>"> </div>
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
              <input class="qty" type="text" name="" value="<?=(!empty($value->addQuantity)) ? $value->addQuantity : '1' ?>" data-product_id="<?=$value->id?>" data-weight_id="<?=$value->weight_id?>" readonly>
              <button class="inc cart-qty-plus" data-product_weight_id="<?=$value->pw_id?>"><span><i class="fa fa-plus"></i></span></button>
            </div>
          </div> 
          <!-- <div class="feature-bottom-wrap">
            <div class="cart addcartbutton" data-product_id="<?=$this->utility->safe_b64encode($value->id)?>"> <i class="fas fa-shopping-basket"></i> </div>
            <div class="quantity-wrap">
              <button class="cart-qty-minus"><span class="minus"><i class="fa fa-minus"></i></span></button>
              <input class="qty" type="text" name="" value="<?=$value->addQuantity?>">
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