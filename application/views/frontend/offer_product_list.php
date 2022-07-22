<!-- =================PRODUCT LIST SECTION================= -->
<section class="p-100 bg-cream product-list">
  <div class="container">
    <div class="section-title-wrapper">
      <div class="row align-items-center">
      <div class="col-md-6 col-sm-6 col-12">
        <div class="section-title">
          <h1>Offer Product listing</h1>
        </div>
      </div>
    </div>  
    </div> 

    <div class="row" id="ajaxProduct">
    	<?php foreach ($offer_varient_list as $key => $value) { ?>
    	<div class="col-lg-3 col-md-6 col-sm-6">
    		<div class="product-wrapper">
          <?php if($value->available_quantity == '0'){ ?>
            <div class="out-stock"><span class="out-heading">out of stock</span></div>
           <?php } ?>
          <div class="wishlist-wrapper">
            <?php if($value->new_percentage > '0'){ ?>
            <div class="offer-wrap">
              <p><?=$value->new_percentage.' % off'?></p>
            </div>
          <?php }else{ ?>
            <div class="">
            </div>
          <?php } ?>
            <div class="wishlist-icon" style="display: none" data-product_id="<?=$this->utility->safe_b64encode($value->product_id)?>"> <i class="far fa-heart"></i> </div>
          </div>
          <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value->product_id).'/'.$this->utility->safe_b64encode($value->product_varient_id)?>">
            <div class="feat-img"> <img class="lazy" data-src="<?=$value->image?>"> </div>
          </a>
          <div class="feature-detail">
            <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value->product_id).'/'.$this->utility->safe_b64encode($value->product_varient_id)?>">
              <h5><?=$value->name?></h5> </a>
            <h6><span><?=$this->siteCurrency?></span> <?=number_format((float)$value->discount_price, 2, '.', '')?></h6>
            <p><?=($value->available_quantity >= 25 ) ? 'Available (in stock)' : 'limited stock' ?></p>
          </div>
          <?php 
            $d_none = '';
            $d_show = 'd-none';
            if(!empty($item_weight_id)){
              if(in_array($value->product_varient_id,$item_weight_id)){
                $d_show = '';
                $d_none = 'd-none';
              }
            }

          ?>
          <div class="feature-bottom-wrap ">
            <div class="cart addcartbutton d-none" data-product_id="<?=$this->utility->safe_b64encode($value->product_id)?>"> <i class="fas fa-shopping-basket"></i>
            </div>
            <div class="new_add_to_cart  <?=$d_none?>" >
                  <button class="btn addcartbutton " data-product_id="<?=$this->utility->safe_b64encode($value->product_id)?>" data-varient_id="<?=$this->utility->safe_b64encode($value->product_varient_id)?>">Add To Cart</button>
            </div>
            <div class="quantity-wrap <?=$d_show?>">
              <button class="dec cart-qty-minus" data-product_weight_id="<?=$value->product_varient_id?>"><span class="minus"><i class="fa fa-minus"></i></span></button>
              <input class="qty" type="text" name="" value="<?=($value->my_cart_quantity != '0') ? $value->my_cart_quantity : 1 ?>" data-product_id="<?=$value->product_id?>" data-weight_id="<?=$value->weight_id?>" readonly>
              <button class="inc cart-qty-plus" data-product_weight_id="<?=$value->product_varient_id?>"><span><i class="fa fa-plus"></i></span></button>
            </div>
          </div>
        </div>
    	</div>
    	<?php } ?>
    </div>
   </div>
</section> 