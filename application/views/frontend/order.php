         <!-- Page Header Section Start Here -->
        <section class="page-header bg_img padding-tb">
            <div class="overlay"></div>
            <div class="container">
                <div class="page-header-content-area">
                    <h4 class="ph-title">My Orders</h4>
                    <ul class="lab-ul">
                        <li><a href="<?=$home_url?>">Home</a></li>
                        <li><a class="active">My Orders</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Page Header Section Ending Here -->
        
         
         <!-- Shop Cart Page Section start here -->		            

       <div class="shop-cart padding-tb pb-0">
            <div class="container">
            	<div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <!-- <th>Products</th> -->
                <th>Order Id</th>
                <th>Date</th>
                <th>Saving</th>
                <th>Total</th>
                <th>View</th>
                <th>Order status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order as $key => $value) { 
                $date =  date('M d , Y', $value->dt_added);
                ?>
            
            <tr>
            	<!-- <td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/images/product_image_thumb/<?=@$value->variant_image_image[0]->image?>" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#"><?=$value->prouduct_name[0]->name?></a>
                    </div>
                </td> -->
                <td class="">
                    <div class="p-content">
                        <a href="#"><?=$value->order_no?></a>
                    </div>
                </td>
                <td><?=$date?></td>
                <td><?=$this->de_currency?> 
                <?=$value->total_saving?>
                </td>
                <td><?=$this->de_currency?> <?=$value->total?> for <?=$value->total_item?> item</td>
                <td>
                    <a href="<?=base_url().'frontend/order/view/'.$this->utility->safe_b64encode($value->id)?>" class="mycart-box">view</a>
                </td>
                <td>
                <?php 
                if($value->order_status == '1'){
                    $status = 'Processing';
                }elseif($value->order_status == '2'){
                    $status = 'Pending';
                }elseif($value->order_status == '3'){
                    $status = 'Ready';
                }elseif($value->order_status == '4'){
                    $status = 'Pickup';
                }elseif ($value->order_status == '5') {
                    $status = 'on the way';
                }elseif ($value->order_status == '8') {
                    $status = 'Delivered';
                }else{
                    $status = 'Cancel';
                } ?>
                <a href="javascript:" class="mycart-box"><?=$status?></a>
                </td>
                <td> <?php if($value->order_status != '9'){ 
                $Cancel_link = base_url().'frontend/order/cancel/'.$this->utility->safe_b64encode($value->id);
                    ?>
                    <a href="<?=$Cancel_link?>" onclick='return confirm("Do you want to cancel order")' class="btn btn-danger">Cancel</a>
                <?php } ?></td>
            </tr>
        <?php } ?>
        <!--     <tr>
            	<td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/frontend/assets/images/product/01.png" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#">Product Text Here</a>
                    </div>
                </td>
                <td class="">
                    <div class="p-content">
                        <a href="#">#1234</a>
                    </div>
                </td>
                <td>March 15, 2020</td>
                <td>
                    Completed
                </td>
                <td>$78.00 for 1 item</td>
                <td>
                    <a href="#" class="mycart-box">view</a>
                </td>
            </tr><tr>
            	<td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/frontend/assets/images/product/01.png" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#">Product Text Here</a>
                    </div>
                </td>
                <td class="">
                    <div class="p-content">
                        <a href="#">#1234</a>
                    </div>
                </td>
                <td>March 15, 2020</td>
                <td>
                    Processing
                </td>
                <td>$78.00 for 1 item</td>
                <td>
                    <a href="#" class="mycart-box">view</a>
                </td>
            </tr><tr>
            	<td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/frontend/assets/images/product/01.png" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#">Product Text Here</a>
                    </div>
                </td>
                <td class="">
                    <div class="p-content">
                        <a href="#">#1234</a>
                    </div>
                </td>
                <td>March 15, 2020</td>
                <td>
                    Completed
                </td>
                <td>$78.00 for 1 item</td>
                <td>
                    <a href="#" class="mycart-box">view</a>
                </td>
            </tr><tr>
            	<td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/frontend/assets/images/product/01.png" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#">Product Text Here</a>
                    </div>
                </td>
                <td class="">
                    <div class="p-content">
                        <a href="#">#1234</a>
                    </div>
                </td>
                <td>March 15, 2020</td>
                <td>
                    Processing
                </td>
                <td>$78.00 for 1 item</td>
                <td>
                    <a href="#" class="mycart-box">view</a>
                </td>
            </tr>
            <tr>
            	<td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/frontend/assets/images/product/01.png" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#">Product Text Here</a>
                    </div>
                </td>
                <td class="">
                    <div class="p-content">
                        <a href="#">#1234</a>
                    </div>
                </td>
                <td>March 15, 2020</td>
                <td>
                    Completed
                </td>
                <td>$78.00 for 1 item</td>
                <td>
                    <a href="#" class="mycart-box">view</a>
                </td>
            </tr>
            <tr>
            	<td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/frontend/assets/images/product/01.png" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#">Product Text Here</a>
                    </div>
                </td>
                <td class="">
                    <div class="p-content">
                        <a href="#">#1234</a>
                    </div>
                </td>
                <td>March 15, 2020</td>
                <td>
                    Processing
                </td>
                <td>$78.00 for 1 item</td>
                <td>
                    <a href="#" class="mycart-box">view</a>
                </td>
            </tr>
            <tr>
            	<td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/frontend/assets/images/product/01.png" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#">Product Text Here</a>
                    </div>
                </td>
                <td class="">
                    <div class="p-content">
                        <a href="#">#1234</a>
                    </div>
                </td>
                <td>March 15, 2020</td>
                <td>
                    Completed
                </td>
                <td>$78.00 for 1 item</td>
                <td>
                    <a href="#" class="mycart-box">view</a>
                </td>
            </tr>

            <tr>
            	<td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/frontend/assets/images/product/01.png" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#">Product Text Here</a>
                    </div>
                </td>
                <td class="">
                    <div class="p-content">
                        <a href="#">#1234</a>
                    </div>
                </td>
                <td>March 15, 2020</td>
                <td>
                    Processing
                </td>
                <td>$78.00 for 1 item</td>
                <td>
                    <a href="#" class="mycart-box">view</a>
                </td>
            </tr>
            <tr>
            	<td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/frontend/assets/images/product/01.png" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#">Product Text Here</a>
                    </div>
                </td>
                <td class="">
                    <div class="p-content">
                        <a href="#">#1234</a>
                    </div>
                </td>
                <td>March 15, 2020</td>
                <td>
                    Processing
                </td>
                <td>$78.00 for 1 item</td>
                <td>
                    <a href="#" class="mycart-box">view</a>
                </td>
            </tr>
            <tr>
            	<td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/frontend/assets/images/product/01.png" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#">Product Text Here</a>
                    </div>
                </td>
                <td class="">
                    <div class="p-content">
                        <a href="#">#1234</a>
                    </div>
                </td>
                <td>March 15, 2020</td>
                <td>
                    Processing
                </td>
                <td>$78.00 for 1 item</td>
                <td>
                    <a href="#" class="mycart-box">view</a>
                </td>
            </tr>
            <tr>
            	<td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/frontend/assets/images/product/01.png" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#">Product Text Here</a>
                    </div>
                </td>
                <td class="">
                    <div class="p-content">
                        <a href="#">#1234</a>
                    </div>
                </td>
                <td>March 15, 2020</td>
                <td>
                    Processing
                </td>
                <td>$78.00 for 1 item</td>
                <td>
                    <a href="#" class="mycart-box">view</a>
                </td>
            </tr>
            <tr>
            	<td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/frontend/assets/images/product/01.png" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#">Product Text Here</a>
                    </div>
                </td>
                <td class="">
                    <div class="p-content">
                        <a href="#">#1234</a>
                    </div>
                </td>
                <td>March 15, 2020</td>
                <td>
                    Processing
                </td>
                <td>$78.00 for 1 item</td>
                <td>
                    <a href="#" class="mycart-box">view</a>
                </td>
            </tr>
            <tr>
            	<td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/frontend/assets/images/product/01.png" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#">Product Text Here</a>
                    </div>
                </td>
                <td class="">
                    <div class="p-content">
                        <a href="#">#1234</a>
                    </div>
                </td>
                <td>March 15, 2020</td>
                <td>
                    Processing
                </td>
                <td>$78.00 for 1 item</td>
                <td>
                    <a href="#" class="mycart-box">view</a>
                </td>
            </tr>
            <tr>
            	<td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/frontend/assets/images/product/01.png" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#">Product Text Here</a>
                    </div>
                </td>
                <td class="">
                    <div class="p-content">
                        <a href="#">#1234</a>
                    </div>
                </td>
                <td>March 15, 2020</td>
                <td>
                    Processing
                </td>
                <td>$78.00 for 1 item</td>
                <td>
                    <a href="#" class="mycart-box">view</a>
                </td>
            </tr>
            <tr>
            	<td class="product-item">
                    <div class="p-thumb">
                        <a href="#"><img src="<?=base_url()?>public/frontend/assets/images/product/01.png" alt="product"></a>
                    </div>
                    <div class="p-content">
                        <a href="#">Product Text Here</a>
                    </div>
                </td>
                <td class="">
                    <div class="p-content">
                        <a href="#">#1234</a>
                    </div>
                </td>
                <td>March 15, 2020</td>
                <td>
                    Processing
                </td>
                <td>$78.00 for 1 item</td>
                <td>
                    <a href="#" class="mycart-box">view</a>
                </td>
            </tr> -->
        </tbody>
      <!--   <tfoot>
            <tr>
                <th>Products</th>
                <th>Order Id</th>
                <th>Date</th>
                <th>Status</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </tfoot> -->
    </table>
</div>
</div>
</div>
        <!-- Shop Cart Page Section ending here -->
