 <!-- banner -->
    <section class="sub-banner gift-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="sub-banner-title text-center">
                        <h1 class="title">Your <span>Cart</span></h1>
                    </div>
                  
                </div>
            </div>
        </div>
    </section>

    
    <section class="p-100 cart-wrap">
        <div class="container">
            <div class="alert alert-danger alert-dismissible text-center" role="alert" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
              </button>Quantity not available</div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table cart-table" id="cart-table"> 
                        <thead>
                            <th>Product</th>
                            <th class="ds-detail"></th>
                            <th>sub total</th>
                            <th>Quantity</th>
                            <th>action</th>
                        </thead>
                      <tbody>
                        <?php 
                        $total = 0;
                        foreach ($cartData as $key => $value){ 
                            $total += $value->calculation_price; 
                          ?>
                              
                          <tr>
                            <td>
                              <div class="product-img">
                                <img src="<?=base_url().'public/uploads/product_image/'.$value->image?>"  alt="">
                                <div class="product_cart_detail mb-det">
                                  <a href="<?=base_url().'gift/productdetails/'.$this->utility->safe_b64encode($value->id)?>">
                                    <h6><?=$value->name?></h6>
                                    <p>$<?= number_format((float)$value->price, 2, '.', '')?></p>
                                  </a>
                                </div>
                              </div>
                            </td>
                            <td class="ds-detail">
                              <div class="product_cart_detail ds-detail ">
                                <a href="<?=base_url().'gift/productdetails/'.$this->utility->safe_b64encode($value->id)?>">
                                  <!-- <h6><?=$value->name?></h6> -->
                                  <p>$<?= number_format((float)$value->actual_price, 2, '.', '')?></p>
                                </a>
                              </div>
                            </td>
                            <td>
                              <div class="product_cart_detail">
                                <h6>$<?= number_format((float)$value->calculation_price, 2, '.', '')?></h6>
                              </div>
                            </td>
                            <td>
                              <div class="quantity-wrap">
                                <button class="cart-qty-minus" data-actual_price="<?=$value->actual_price?>" ><span class="minus"><i class="fa fa-minus"></i></span></button>
                                <input type="text" name="" value="<?=$value->quantity?>" min="1" readonly />
                                <button class="cart-qty-plus" data-actual_price="<?=$value->actual_price?>"><span><i class="fa fa-plus"></i></span></button>
                              </div>
                            </td>
                            <td>
                              <span class="action_delete delete" data-cart_id="<?=$this->utility->safe_b64encode($value->cart_id)?>">
                                <i class="far fa-trash-alt"></i>
                              </span>
                            </td>
                          </tr>
                          <?php } ?>
                         <!--  <tr>
                            <td>
                              <div class="product-img">
                                  <img src="./assets/images/gifts/1.png"  alt="">
                                  <div class="product_cart_detail mb-det">
                                    <a href="product-detail.html">
                                      <h6>Round Neck T-shirt</h6>
                                      <p>$25.00</p>
                                    </a>
                                </div>
                              </div>
                            </td>
                            <td class="ds-detail">
                                <div class="product_cart_detail ds-detail ">
                                  <a href="product-detail.html">
                                    <h6>Round Neck T-shirt</h6>
                                    <p>$25.00</p>
                                  </a>
                              </div>
                              </td>
                            <td>
                              <div class="product_cart_detail">
                                  <h6>$100.00</h6>
                              </div>
                            </td>
                            <td>
                              <div class="quantity-wrap">
                                <button class="cart-qty-minus"><span class="minus"><i class="fa fa-minus"></i></span></button>
                                <input type="text" name="" value="0" />
                                <button class="cart-qty-plus"><span><i class="fa fa-plus"></i></span></button>
                                </div>
                            </td>
                            <td>
                                <span class="action_delete">
                                  <i class="far fa-trash-alt"></i>
                                </span>
                            </td>

                        </tr>
                        <tr>
                          <td>
                            <div class="product-img">
                                <img src="./assets/images/gifts/1.png"  alt="">
                                <div class="product_cart_detail mb-det">
                                  <a href="product-detail.html">
                                    <h6>Round Neck T-shirt</h6>
                                    <p>$25.00</p>
                                  </a>
                              </div>
                            </div>
                          </td>
                          <td class="ds-detail">
                              <div class="product_cart_detail ds-detail ">
                                <a href="product-detail.html">
                                  <h6>Round Neck T-shirt</h6>
                                  <p>$25.00</p>
                                </a>
                            </div>
                            </td>
                          <td>
                            <div class="product_cart_detail">
                                <h6>$100.00</h6>
                            </div>
                          </td>
                          <td>
                            <div class="quantity-wrap">
                              <button class="cart-qty-minus"><span class="minus"><i class="fa fa-minus"></i></span></button>
                              <input type="text" name="" value="0" />
                              <button class="cart-qty-plus"><span><i class="fa fa-plus"></i></span></button>
                              </div>
                          </td>
                          <td>
                              <span class="action_delete">
                                <i class="far fa-trash-alt"></i>
                              </span>
                          </td>

                      </tr> -->

                    
                      </tbody>
                    </table>
                    <div class="sub-total-wrap">
                        <div class="sub-total">
                            <p  id="total"><span>Total :</span>  $<?= number_format((float)$total, 2, '.', '')?></p>
                        </div>
                        <a class="s-btn" href="<?=base_url().'gift/order_summary'?>">Continue To Shipping</a>
                    </div>
                </div>
            </div>
        </div>
    </section>