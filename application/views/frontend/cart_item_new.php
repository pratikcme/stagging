<section class="breadcrumb-menu breadcrumb-cart">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">cart</li>
      </ol>
    </nav>
  </div>
</section>
<!-- =================CART SECTION================= -->
<?php if($this->session->userdata('user_id') == ''){?> 
<section class="p-100 bg-cream">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-12">
        <div class="cart-table-wrapper">
          <table class="table cart-table table-reponsive">
            <thead>
              <tr>
                <th class="w-45">Product</th>
                <th class="w-20 text-center">Quantity</th>
                <th class="w-20 text-center">price</th>
                <th class="w-5 text-center">Total</th>
                <th class="w-10 text-center">Action</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              if(isset($_SESSION['My_cart']) && $_SESSION['My_cart'] != ''){

                foreach ($_SESSION['My_cart'] as $key => $value) { 
                  if(empty($value['image']) || !file_exists('public/images/'.$this->folder.'product_image/'.$value['image']))
                    {
                        $value['image'] = 'defualt.png';
                    }
            ?>
              <tr id="<?=$value['product_id'].'_'.$value['product_weight_id']?>">
                <td>
                  <div class="cart-item">
                    <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value["product_id"])?>">
                      <div class="cart-img-wrap"> <img src="<?=base_url().'public/images/'.$this->folder.'product_image/'.$value['image']?>"> </div>
                    </a>
                    <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value["product_id"])?>">
                      <div class="cart-detail-wrap">
                        <h6><?=$value['product_name']?></h6>
                        <p><span><?=$value['quantity']?></span>X<?=$value['discount_price'] ?></p>
                      </div>
                    </a>
                  </div>
                </td>
                <td class="text-center">
                  <div class="quantity-wrap">
                    <button class="dec cart-qty-minus_c" data-product_weight_id="<?=$value['product_weight_id']?>">
                      <span class="minus"><i class="fa fa-minus"></i></span>
                    </button>
                    <input class="qty" type="text" name="" value="<?=$value['quantity']?>" data-product_id="<?=$value['product_id']?>" data-weight_id="<?=$value['weight_id']?>" readonly>
                    <button class="inc cart-qty-plus_c" data-product_weight_id="<?=$value['product_weight_id']?>">
                      <span><i class="fa fa-plus"></i></span>
                    </button>
                  </div>
                </td>
                <td class="text-center">
                  <?php if ($value['discount_per'] > 0): ?>
                  <p class="discount-on"><span><?=$this->siteCurrency?></span><?=$value['product_price']?></p>
                  <?php endif ?>
                  <p><span><?=$this->siteCurrency?></span><?=$value['discount_price']?></p>
                </td>
                <td class="text-center">
                  <p>
                    <span><?=$this->siteCurrency?></span><span class="total"><?=number_format((float)$value['total'],2,'.','')?></span>
                 </p>
                </td>
                <td class="text-center"> 
                  <span class="delete-item removeCartItem" data-product_id="<?=$value['product_id']?>"
                  data-product_weight_id="<?=$value['product_weight_id']?>" data-weight_id="<?=$value['weight_id']?>">
                    <i class="fas fa-trash-alt"></i>
                  </span>
                </td>
              </tr>
              <?php } ?>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-lg-4 col-md-12">
        <div class="cart-total-wrap">
          <div class="cart-total-heading">
            <h6> <span><i class="fas fa-shopping-basket"></i> </span> Cart Total</h6> </div>
          <div class="cart-total-innerbox">
            <div class="total-count">
              <h6>Sub total</h6>
              <div class="price-seperator"> <span class="seperator">:</span>
                <p>
                  <span><?=$this->siteCurrency?>
                  </span> <span id="final_subtotal"><?=getMycartSubtotal()?></span></p>
              </div>
            </div>
            <div class="total-count">
              <h6>Delivery Charges</h6>
              <div class="price-seperator"> <span class="seperator">:</span>
                <p id="delivery_charge"><span><?=$this->siteCurrency?></span> <?=(isset($calc_shiping) && $calc_shiping != 'NotInRange') ? $calc_shiping : '0.00' ?></p>
              </div>
            </div>
            <div class="total-count">
              <h6>Total</h6>
              <div class="price-seperator"> <span class="seperator">:</span>
                <p id="total"><span><?=$this->siteCurrency?></span> <?=(isset($calc_shiping) && $calc_shiping != 'NotInRange') ?  number_format(getMycartSubtotal()+$calc_shiping,2,'.','') : getMycartSubtotal();?></p>
              </div>
            </div>
            
            <p class="instruc" style="display: none"> In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. </p> 
            <a href="<?=base_url().'checkout'?>" class="btn">
              proceed to checkout
            </a> </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="" id="shipingCharge" value="<?=($calc_shiping != 'NotInRange') ? $calc_shiping : '0.00' ?>">
  </div>
</section>
<?php }else{ ?> 
  <section class="p-100 bg-cream">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-12">
        <div class="cart-table-wrapper">
          <table class="table cart-table table-reponsive">
            <thead>
              <tr>
                <th class="w-45">Product</th>
                <th class="w-20 text-center">Quantity</th>
                <th class="w-20 text-center">price</th>
                <th class="w-5 text-center">Total</th>
                <th class="w-10 text-center">Action</th>
              </tr>
            </thead>
            <tbody>
            <?php 

                foreach ($my_cart as $key => $value) { 
                  if(empty($value->image) || !file_exists('public/images/'.$this->folder.'product_image/'.$value->image))
                    {
                        $value->image = 'defualt.png';
                    }
            ?>
              <tr id="<?=$value->product_id.'_'.$value->product_weight_id?>">
                <td>
                  <div class="cart-item">
                    <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value->product_id)?>">
                      <div class="cart-img-wrap"> <img src="<?=base_url().'public/images/'.$this->folder.'product_image/'.$value->image?>"> </div>
                    </a>
                    <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($value->product_id)?>">
                      <div class="cart-detail-wrap">
                        <h6><?=$value->product_name?></h6>
                        <p><span><?=$value->quantity?></span>X<?=$value->discount_price ?></p>
                      </div>
                    </a>
                  </div>
                </td>
                <td class="text-center">
                  <div class="quantity-wrap">
                    <button class="dec cart-qty-minus_c" data-product_weight_id="<?=$value->product_weight_id?>">
                      <span class="minus"><i class="fa fa-minus"></i></span>
                    </button>
                    <input class="qty" type="text" name="" value="<?=$value->quantity?>" data-product_id="<?=$value->product_id?>" data-weight_id="<?=$value->weight_id?>" readonly>
                    <button class="inc cart-qty-plus_c" data-product_weight_id="<?=$value->product_weight_id?>">
                      <span><i class="fa fa-plus"></i></span>
                    </button>
                  </div>
                </td>
                <td class="text-center">
                  <?php if ($value->discount_per > 0): ?>
                  <p class="discount-on"><span><?=$this->siteCurrency?></span><?=$value->product_price?></p>
                  <?php endif ?>
                  <p><span><?=$this->siteCurrency?></span><?=$value->discount_price?></p>
                </td>
                <td class="text-center">
                  <p>
                    <span><?=$this->siteCurrency?></span><span class="total"><?=number_format((float)$value->calculation_price,2,'.','')?></span>
                 </p>
                </td>
                <td class="text-center"> 
                  <span class="delete-item removeCartItem" data-product_id="<?=$value->product_id?>"
                  data-product_weight_id="<?=$value->product_weight_id?>" data-weight_id="<?=$value->weight_id?>">
                    <i class="fas fa-trash-alt"></i>
                  </span>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-lg-4 col-md-12">
        <div class="cart-total-wrap">
          <div class="cart-total-heading">
            <h6> <span><i class="fas fa-shopping-basket"></i> </span> Cart Total</h6> </div>
          <div class="cart-total-innerbox">
            <div class="total-count">
              <h6>Sub total</h6>
              <div class="price-seperator"> <span class="seperator">:</span>
                <p>
                  <span><?=$this->siteCurrency?>
                  </span> <span id="final_subtotal"><?=getMycartSubtotal()?></span></p>
              </div>
            </div>
            <div class="total-count">
              <h6>Delivery Charges</h6>
              <div class="price-seperator"> <span class="seperator">:</span>
                <p id="delivery_charge"><span><?=$this->siteCurrency?></span> <?=(isset($calc_shiping) && $calc_shiping != 'NotInRange') ? $calc_shiping : '0.00' ?></p>
              </div>
            </div>
            <div class="total-count">
              <h6>Total</h6>
              <div class="price-seperator"> <span class="seperator">:</span>
                <p id="total"><span><?=$this->siteCurrency?></span> <?=(isset($calc_shiping) && $calc_shiping != 'NotInRange') ?  number_format(getMycartSubtotal()+$calc_shiping,2,'.','') : getMycartSubtotal();?></p>
              </div>
            </div>
            
            <p class="instruc" style="display: none"> In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. </p> 
            <a href="<?=base_url().'checkout'?>" class="btn">
              proceed to checkout
            </a> </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="" id="shipingCharge" value="<?=($calc_shiping != 'NotInRange') ? $calc_shiping : '0.00' ?>">
  </div>
</section>
<?php } ?>