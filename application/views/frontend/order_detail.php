        <!-- Shop Cart Page Section start here -->                  
        <div class="shop-cart padding-tb pb-0 order-complete">
            <div class="container">
                <div class="section-wrapper">
                    <div class="cart-top">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Dicount(%)</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                         <?php foreach ($view_detail as $key => $value) { 
            if(empty($value->prouduct_image) || !file_exists('public/images/product_image_thumb/'.$value->prouduct_image) ){
                    $value->prouduct_image = 'defualt.png';
                }
                            ?>
                                <tr>
                                    <td class="product-item">
                                        <div class="p-thumb">
                                            <a href="#"><img src="<?=base_url()?>public/images/product_image_thumb/<?=$value->prouduct_image?>" alt="product"></a>
                                        </div>
                                        <div class="p-content">
                                            <a href="#"><?=$value->prouduct_name?></a>
                                        </div>
                                    </td>
                                    <td><?=$this->de_currency?> <?=$value->actual_price?></td>
                                    <td><?=$value->discount?></td>
                                    <td>
                                        <div class="cart-plus-minus">
                                           <span><?=$value->quantity?></span>
                                        </div>
                                    </td>
                                    <td><?=$this->de_currency?> <?=$value->calculation_price?></td>
                                    
                                </tr>
                        <?php } ?> 
                                <!-- <tr>
                                    <td class="product-item">
                                        <div class="p-thumb">
                                            <a href="#"><img src="assets/images/product/02.png" alt="product"></a>
                                        </div>
                                        <div class="p-content">
                                            <a href="#">Product Text Here</a>
                                        </div>
                                    </td>
                                    <td>$250</td>
                                    <td>
                                        <div class="cart-plus-minus">
                                           <span>2</span>
                                        </div>
                                    </td>
                                    <td>$500</td>
                                   
                                </tr>
                                <tr>
                                    <td class="product-item">
                                        <div class="p-thumb">
                                            <a href="#"><img src="assets/images/product/03.png" alt="product"></a>
                                        </div>
                                        <div class="p-content">
                                            <a href="#">Product Text Here</a>
                                        </div>
                                    </td>
                                    <td>$50</td>
                                    <td>
                                        <div class="cart-plus-minus">
                                            <span>3</span>
                                        </div>
                                    </td>
                                    <td>$100</td>
                                    
                                </tr>
                                <tr>
                                    <td class="product-item">
                                        <div class="p-thumb">
                                            <a href="#"><img src="assets/images/product/04.png" alt="product"></a>
                                        </div>
                                        <div class="p-content">
                                            <a href="#">Product Text Here</a>
                                        </div>
                                    </td>
                                    <td>$100</td>
                                    <td>
                                        <div class="cart-plus-minus">
                                            <span>4</span>
                                        </div>
                                    </td>
                                    <td>$200</td>
                                    
                                </tr>
                                <tr>
                                    <td class="product-item">
                                        <div class="p-thumb">
                                            <a href="#"><img src="assets/images/product/01.png" alt="product"></a>
                                        </div>
                                        <div class="p-content">
                                            <a href="#">Product Text Here</a>
                                        </div>
                                    </td>
                                    <td>$200</td>
                                    <td>
                                        <div class="cart-plus-minus">
                                           <span>5</span>
                                        </div>
                                    </td>
                                    <td>$400</td>
                                   
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                    <div class="cart-bottom">
                        <div class="shiping-box">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="calculate-shiping">
                                        <h4>Shipping Address</h4>
                                        <div class="billing-address-area">
                                            <ul>
                                                <li><b>Your Name:</b> <?=$user_address[0]->name?></li>
                                                <li><b>Email Address:</b> <?=$user_address[0]->email ?></li>
                                                <li><b>Phone Number:</b> <?=$user_address[0]->phone?></li>
                                                <li><b>Your Address:</b><?=$user_address[0]->address?> </li>
                                            </ul>
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="cart-overview">
                                        <h4>Payment Information</h4>
                                        <ul>
                                        
                                                <li><b>Paid Amount:</b> <?=$order[0]->sub_total?> <?=$this->de_currency?></li>
                                                <li><b>Shiping Charge : </b> <?=$order[0]->delivery_charge?> <?=$this->de_currency?></li>
                                                <li><b>Final Amount : </b> <?=$order[0]->sub_total+$order[0]->delivery_charge ?> <?=$this->de_currency?></li>
                                                <li><b>Payment Method:</b> 
                                                    <?php if($order[0]->payment_type == 0){
                                                            echo 'Cash on Delivery';
                                                        }else{
                                                            echo 'Card Payment';
                                                        }
                                                    ?>

                                            </li>
                                                <li><b>Order Id:</b> <?=$order[0]->order_no?></li>
                                                <li><b>Order Date:</b> <?= date('d-F-Y ',$order[0]->dt_added);?></li>                    
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Shop Cart Page Section ending here -->