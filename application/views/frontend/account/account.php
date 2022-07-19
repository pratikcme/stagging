<style type="text/css">
   label.error{
      position: relative;
      top: -17px;
   }
    .order-cancle-btn{
      display: flex;
      align-items: center;
      justify-content: flex-end;
      padding: 10px 0px;
   }
.input-wrapper.country-code select{
    padding:0px;
    border:0px;
    background:transparent;
    margin-bottom:0px !important;
    width: 100%;
    -moz-appearance: none;
    -webkit-appearance: none;
}
</style>
<!--=================BREADCRUMB SECTION=================  -->
<section class="breadcrumb-menu p-100">
   <div class="container">
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url().'home'?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">my account</li>
         </ol>
      </nav>
   </div>
</section>
<!--=================MY ACCOUNT SECTION=================  -->
<section class="p-100 bg-cream">
   <div class="container">
      <div class="row">
         <div class="col-lg-3 col-md-4">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
               <div class="tab-header">
                  <h6><span><i class="far fa-user-circle"></i></span>My account</h6>
               </div>
               <a class="nav-link <?=($action_name == 'my_account') ? 'active' : ''?> " id="v-pills-myaccount-tab" data-toggle="pill" href="#v-pills-myaccount" role="tab" aria-controls="v-pills-myaccount" aria-selected="<?=($action_name == 'my_account') ? 'true' : 'false'?> ">
               <span><i class="fas fa-user"></i></span> My account
               </a>
               <a class="nav-link <?=($action_name == 'order') ? 'active' : ''?>" id="v-pills-orders-tab" data-toggle="pill" href="#v-pills-orders" role="tab" aria-controls="v-pills-orders" aria-selected="<?=($action_name == 'order') ? 'true' : 'false'?>">
               <span><i class="fas fa-shopping-bag"></i></span>My order</a>
               <a class="nav-link <?=($action_name == 'wishlist') ? 'active' : ''?> " id="v-pills-whislist-tab" data-toggle="pill" href="#v-pills-whislist" role="tab" aria-controls="v-pills-whislist" aria-selected="<?=($action_name == 'wishlist') ? 'true' : 'false'?>" style="display: none;"> <span><i class="fas fa-heart"></i></span>My Wishlist</a>
               <a class="nav-link <?=($action_name == 'my_address') ? 'active' : ''?> " id="v-pills-address-tab" data-toggle="pill" href="#v-pills-address" role="tab" aria-controls="v-pills-address" aria-selected="<?=($action_name == 'my_address') ? 'true' : 'Your Wishlist'?>"><span><i class="fas fa-address-book"></i></span>My address</a>
               <?php if(!empty($getVedorDetails) && $getVedorDetails[0]->login_type == '0') { ?>
               <a class="nav-link <?=($action_name == 'change') ? 'active' : ''?> " id="v-pills-change-tab" data-toggle="pill" href="#v-pills-change" role="tab" aria-controls="v-pills-change" aria-selected="<?=($action_name == 'change') ? 'true' : 'false'?>"><span><i class="fas fa-lock"></i></span>Change Password</a>
               <?php } ?>
               <a style="display: none;" class="nav-link <?=($action_name == 'faq') ? 'active' : ''?> " id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="<?=($action_name == 'faq') ? 'true' : 'false'?>"><span><i class="fas fa-info-circle"></i></span>FAQ</a>
               <a class="nav-link"  role="tab" id="logout" ><span><i class="fas fa-power-off"></i></span>logout</a>

               <a class="nav-link"  role="tab" id="delete_account" ><span><i class="fas fa-minus"></i></span>Delete Account</a>
            </div>
         </div>
         <div class="col-lg-9 col-md-8">
            <div class="tab-content" id="v-pills-tabContent">
               <div class="tab-pane fade <?=($action_name == 'my_account') ? 'active show' : '' ?> " id="v-pills-myaccount" role="tabpanel" aria-labelledby="v-pills-myaccount-tab">
                  <div class="wihslist-wrapper address-wrapper bg-white">
                    <!--  <div class="page-title">
                        <h1>Account Detailssss</h1>
                     </div> -->
                     <div class="your-order-header address-header" id="address-header">
                        <h4><span><i class="fas fa-user"></i></span>Account Details </h4>
                     
                     </div>
                     <form id='ChangePass' action="<?=base_url().'users_account/users/account'?>" method="post" class="account-form" enctype="multipart/form-data">
                          <input type="hidden" name="hidden_image" value="<?=$userDetails[0]->profileimage?>">
                        <div class="text-center">
                        <div class="group-image">
                           <div class="circle">
                              <img class="profile-pic" src="<?=($userDetails[0]->profileimage !='' ) ? base_url().'public/images/'.$this->folder.'user_profile/'.$userDetails[0]->profileimage : 'https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg' ?>" >
                           </div>
                           <div class="p-image">
                              <i class="fa fa-camera upload-button"></i>
                              <input class="file-upload" type="file" name="profileimage" accept="image/*">
                           </div>
                        </div>
                        </div>
                         <label for="profileimage" class="error profileimage"></label>
                        <div class="row">
                           <div class="col-lg-6 col-md-12">
                              <div class="input-wrapper">
                                 <span><i class="far fa-user-circle"></i></span>
                                 <input type="text" name="fname" placeholder="First Name" value="<?=$userDetails[0]->fname?>">
                              </div>
                              <label for="fname" class="error"></label>
                           </div>
                           <div class="col-lg-6 col-md-12">
                              <div class="input-wrapper">
                                 <span><i class="far fa-user-circle"></i></span>
                                 <input type="text" name="lname" placeholder="last Name" value="<?=$userDetails[0]->lname?>">
                              </div>
                              <label for="lname" class="error"></label>
                           </div>
                           <div class="col-md-12">
                              <div class="input-wrapper">
                                 <span><i class="far fa-envelope"></i></span>
                                 <input type="text" name="email" placeholder="Email" value="<?=$userDetails[0]->email?>" readonly>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="input-wrapper">
                                 <span><i class="far fa-file"></i></span>
                                 <input type="text" name="user_gst_number" placeholder="Gst number" value="<?=$userDetails[0]->user_gst_number?>" readonly onfocus="this.removeAttribute('readonly');" onblur="this.setAttribute('readonly','')">
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="input-wrapper country-code">
                                 <span><i class="fas fa-globe"></i></span>
                               <select name="country_code" id="country_code" class="input-wrapper">
                                  <?php foreach(GetDialcodelist() as $key => $value){ ?>
                                       <option <?=($key==$userDetails[0]->country_code)?'selected':'';?> value="<?=$key;?>"><?=$value;?></option>
                                 <?php } ?>             
                              </select>
                              </div>
                                
                           </div>
                           <input type="hidden" id="exiting_country" value="<?=$userDetails[0]->country_code?>">
                           <input type="hidden" id="exiting_phone" value="<?=$userDetails[0]->phone?>">
                           <div class="col-lg-6">
                              <div class="input-wrapper">
                                 <span><i class="fas fa-mobile-alt"></i></span>
                                 <input type="text" name="phone" placeholder=" Mobile Number" class="phone" id="phone" value="<?=$userDetails[0]->phone?>" >
                              </div>
                              <label for="phone" id="mobileErr" class="error"><?=form_error('phone')?></label>
                           </div>
                            <div class="col-md-12 varification" style="display: none;">
                              <div class="input-wrapper">
                                 <span><i class="far fa-envelope"></i></span>
                                 <input type="text" id="otp" name="otp" placeholder="otp">
                              </div>
                           </div>
                           <div class="col-md-12 mt-4 ">
                              <button type="submit" id="btnAccSubmit" class="btn">Save</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               
               
               <div class="tab-pane fade <?=($action_name == 'order') ? 'active show' : '' ?>" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                 
                  <?php foreach ($order as $key => $value):
                     date_default_timezone_set('Asia/Kolkata');
                     $date =  date('d M Y, h:i A', $value->dt_updated); 
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
                      }
                  ?>
                  
                     <div class="your-order-wrapper bg-white">
                        <div class="your-order-header">
                        <div>   
                           <h4><span><i class="fas fa-clock"></i></span><?=$status?>  <?=$date?></h4>
                           <h5 class="your-order-header_address"><?=$value->vendorName?>, <span><?=$value->vendorAddress?></span></h5>
                           <h6 class="your-order-header_number"><span> order No. </span> <?=str_replace('Order','', $value->order_no);?></h6>
                        </div>
                           <p class="details">details <span><i class="fas fa-chevron-down"></i></span></p>
                        </div>
                        <ul>
                           <?php 
                              // if(empty($orderDetails[$key])){
                              //    unset($orderDetails[$key]);
                              // }
                              foreach ($value->orderDetails as $k => $v){ 
                                 if($v->prouduct_image == '' || !file_exists('/public/images/product_image/'.$v->prouduct_image)){
                                    $v->prouduct_image = 'defualt.png';
                                 }
                              ?> 
                           <li>
                              <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($v->product_id).'/'.$this->utility->safe_b64encode($v->product_weight_id)?>">
                                 <div class="your-order-img-wrap">
                                    <img src="<?=base_url().'public/images/'.$this->folder.'product_image/'.$v->product_image?>">
                                 </div>
                              </a>
                              <a href="<?=base_url().'products/productDetails/'.$this->utility->safe_b64encode($v->product_id).'/'.$this->utility->safe_b64encode($v->product_weight_id)?>">
                                 <div class="your-order-detail-wrap">
                                    <h6><?=$v->product_name?></h6>
                                    <p> <?=$v->quantity?> X <span><!-- <i class="fas fa-rupee-sign"> --><?=$this->siteCurrency?></i></span> <?=$v->discount_price?> <del style="margin-left: 10px;color: #999; display :<?=($v->actual_price == $v->discount_price) ? 'none' : ''?>"> <i class="fas fa-rupee-sign"></i><?=$v->actual_price?></del> </p>
                                    <p style="color:#999"><?=$v->weight_number .' '.$v->weight_name.' - '.$v->package?></p>
                                 </div>
                              </a>
                           </li>
                           <?php } ?>
                          <li class="total-wrap">
                              <div class="total-count">
                                 <h6>Total Amount</h6>
                                 <div class="price-seperator">
                                    <span class="seperator">:</span>
                                    <p><span><!-- <i class="fas fa-rupee-sign"> --> <?=$this->siteCurrency?></i></span>  <?=number_format((float)$order[$key]->sub_total + $order[$key]->total_saving,2,'.','')?></p>
                                 </div>
                              </div>
                           </li>
                            <li class="total-wrap">
                              <div class="total-count">
                                 <h6>Product Discount</h6>
                                 <div class="price-seperator">
                                    <span class="seperator">:</span>
                                    <p> - <span><!-- <i class="fas fa-rupee-sign"></i> --><?=$this->siteCurrency?></span>  <?=$value->total_saving?></p>
                                 </div>
                              </div>
                           </li>
                           <li class="total-wrap">
                              <div class="total-count">
                                 <h6>Total Amount Before Tax</h6>
                                 <div class="price-seperator">
                                    <span class="seperator">:</span>
                                    <p><span><!-- <i class="fas fa-rupee-sign"></i> --> <?=$this->siteCurrency?></span>  <?=number_format((float)$value->sub_total - $value->TotalGstAmount,2,'.','')?></p>
                                 </div>
                              </div>
                           </li>
                           <li class="total-wrap">
                              <div class="total-count">
                                 <h6>Total Tax Amount</h6>
                                 <div class="price-seperator">
                                    <span class="seperator">:</span>
                                    <p><span><!-- <i class="fas fa-rupee-sign"></i> --><?=$this->siteCurrency?></span>  <?=$order[$key]->TotalGstAmount?></p>
                                 </div>
                              </div>
                           </li>
                           <li class="total-wrap">
                              <div class="total-count">
                                 <h6>Delivery Charges</h6>
                                 <div class="price-seperator">
                                    <span class="seperator">:</span>
                                    <?php 
                                    if($value->delivery_charge != '0'){ ?>
                                    <p><span><!-- <i class="fas fa-rupee-sign"></i> --> <?=$this->siteCurrency?></span>  <?=number_format($value->delivery_charge,2,'.','')?></p>
                                    <?php }else{ ?>
                                       <p>Free</p>
                                    <?php } ?>
                                 </div>
                              </div>
                           </li>
                           <li class="total-wrap">
                              <div class="total-count">
                                 <h6>Total Item</h6>
                                 <div class="price-seperator">
                                    <span class="seperator">:</span>
                                    <p><?=$value->total_item?></p>
                                 </div>
                              </div>
                           </li>
                           <li class="total-wrap">
                              <div class="total-count">
                                 <h6>Promocode Discount</h6>
                                 <div class="price-seperator">
                                    <span class="seperator">:</span>
                                    <p><span><!-- <i class="fas fa-rupee-sign"></i> --> - <?=$this->siteCurrency?></span><?=$value->promocode_discount?></p>
                                 </div>
                              </div>
                           </li>
                           <li class="total-wrap">
                              <div class="total-count">
                                 <h6>Final Total</h6>
                                 <div class="price-seperator">
                                    <span class="seperator">:</span>
                                    <p><span><!-- <i class="fas fa-rupee-sign"></i> --><?=$this->siteCurrency?></span><?=number_format((float)$value->payable_amount,2,'.','')?></p>
                                 </div>
                              </div>
                           </li>
                           <!-- <?php if ($value->isSelfPickup == '1' && $value->order_status != '9'){ ?> -->
                           <!-- <?php } ?> -->  
                              <li class="total-wrap">
                                 <div class="total-count">
                                    <h6><span><i class="fas fa-mobile"></i></span><?=($value->isSelfPickup == '1') ? "SelfPickUp OTP" : "OTP"?></h6>
                                    <div class="price-seperator">
                                       <span class="seperator">:</span>
                                       <p><?=$value->isSelfPickup_details[0]->otp?></p>
                                    </div>
                                 </div>
                              </li>
                           <div class="order-cancle-btn">
                           <?php if($value->order_status <= '5'){ ?> 
                            <a href="javescript:;" data-href="<?=base_url().'orders/cancle_order/'.$this->utility->safe_b64encode($value->id)?>" class="cncOrder btn btn-orange">Cancel Order</a>
                            <?php } ?>
                             <!-- <a href="#?>" class="btn btn-orange">Cancel Order</a> -->
                           </div>
                        </ul>
                     </div>
                  <?php endforeach ?>
               </div>
              

               <div class="tab-pane fade <?=($action_name == 'wishlist') ? 'active show' : '' ?>" id="v-pills-whislist" role="tabpanel" aria-labelledby="v-pills-whislist-tab" style="display: none">
                  <div class="wihslist-wrapper bg-white">
                     <div class="your-order-header">
                        <h4><span><i class="fas fa-heart"></i></span>your wishlist </h4>
                     </div>
                     <ul>
                     <?php foreach ($wishlist as $key => $value): ?>      
                        <li>
                           <div class="img-con-cart">
                           <a href="<?=base_url().'producta/productDetails/'.$this->utility->safe_b64encode($value->product_id)?>">
                              <div class="your-order-img-wrap">
                                 <img src="<?=base_url().'public/images/product_image/'.$value->product_image?>">
                              </div>
                           </a>
                           <a href="<?=base_url().'producta/productDetails/'.$this->utility->safe_b64encode($value->product_id)?>">
                              <div class="your-order-detail-wrap">
                                 <h6><?=$value->product_name?></h6>
                                 <p>1 X <span><i class="fas fa-rupee-sign"></i></span> <?=$value->product_discount_price?></p>
                              </div>
                           </a>
                           </div>
                           <span class="delete-item removeWishlistItem" data-product_id="<?=$this->utility->safe_b64encode($value->product_id)?>">
                           <i class="fas fa-trash-alt"></i>
                           </span>
                        </li>
                        <?php endforeach ?>
                       
                     </ul>
                  </div>
               </div>

               <div class="tab-pane fade <?=($action_name == 'my_address') ? 'active show' : '' ?>" id="v-pills-address" role="tabpanel" aria-labelledby="v-pills-address-tab">
                  <div class="wihslist-wrapper  address-wrapper bg-white new-address-wrap" id="new-address-wrap">
                     <div class="your-order-header address-header new-add-header">
                        <h4><span><i class="fas fa-address-book"></i></span>Add New address </h4>
                        <!-- <button class="btn"><span style="margin-right: 5px;"> <i class="fas fa-crosshairs"></i> </span> use my current location</button> -->
                     </div>
                     <form  method="post" id="RegisterForm" action="<?=base_url().'users_account/users/add_address'?>" class="address-form">
                        <div class="row">
                           <div class="col-lg-12 col-md-12">
                              <div class="input-wrapper">
                                 <span><i class="far fa-user-circle"></i></span>
                                 <input type="text" class="fname" name="fname" placeholder="Full Name">
                              </div>
                              <label for="fname" class="error"></label>
                           </div>

                           <div class="col-md-12">
                              <div class="input-wrapper">
                                 <span><i class="fas fa-phone"></i></span>
                                 <input type="text" class="mob_no" name="phone" placeholder="Mobile number">
                              </div>
                              <label for="phone" class="error"><?=@form_error('phone')?></label>
                           </div>
                           <div class="col-md-12">
                              <div class="input-wrapper">
                                 <span><i class="fas fa-home"></i></span>
                                 <input type="text" id="departure_address" onFocus="initAutocomplete('departure_address')" class="form-control" placeholder="Enter Location" name="location" maxlength="255" value="<?php echo set_value('location'); ?>" autocomplete="off">
                                 <?php echo form_error('location'); ?>
                              </div>
                              <label for="departure_address" class="error"></label>
                              <input type="hidden" id="departure_latitude" name="latitude" placeholder="Latitude" value="<?php echo set_value('latitude'); ?>"/>
                              <input type="hidden" id="departure_longitude" name="longitude" placeholder="Longitude" value="<?php echo set_value('longitude'); ?>"/> 
                           </div>

                           <div class="col-lg-6">
                              <div class="input-wrapper">
                                 <span><i class="fas fa-landmark"></i></span>
                                 <input type="text" class="landmark" name="landmark" placeholder="Landmark">
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="input-wrapper">
                                 <span><i class="fas fa-globe-americas"></i></span> <input type="text" name="city" class="form-control" id="city" placeholder="city" autocomplete="off">
                              </div>
                              <label for="city" class="error"><?=@form_error('city')?></label>
                           </div>
                           <div class="col-lg-6">
                              <div class="input-wrapper">
                                 <span><i class="fas fa-globe-americas"></i></span>
                                 <input type="text" name="state" class="form-control" id="state" placeholder="State" autocomplete="off">
                              </div>
                              <label for="state" class="error"><?=@form_error('state')?></label>
                           </div>
                           <div class="col-lg-6">
                              <div class="input-wrapper">
                                 <span><i class="fas fa-globe-americas"></i></span>
                                 <input type="text" name="country" class="form-control" placeholder="country" id="country">
                              </div>
                              <label for="country" class="error"><?=@form_error('country')?></label>
                           </div>
                           <div class="col-lg-6">
                              <div class="input-wrapper">
                                 <span><i class="fas fa-hashtag"></i></span>
                                 <input type="text" name="pincode" class="form-control pincode" id="pincode" placeholder="Pincode" autocomplete="off">
                              </div>
                              <label for="pincode" class="error"></label>
                           </div>
                           <div class="col-lg-12">
                              <div class="input-wrapper add-text">
                                 <span><i class="fas fa-list-alt"></i></span>
                                 <textarea name="address"  placeholder="Enter Address" id="address" class="form-control add-textarea" autocomplete="off"></textarea>
                              </div>
                              <label for="address" class="error"></label>
                           </div>
                       
                           <div class="col-md-6 col-sm-6">
                              <button type="submit" id="addAddress"  class="btn save-btn">save</button>
                           </div>
                           <div class="col-md-6 col-sm-6">
                              <button class="btn cancel-btn">cancel</button>
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="wihslist-wrapper  address-wrapper bg-white">
                     <div class="your-order-header address-header" id="address-header">
                        <h4><span><i class="fas fa-address-book"></i></span>My address </h4>
                        <button class="btn add-new-address add_form_action"><span style="margin-right: 5px;"> <i class="fas fa-plus"></i> </span> Add New address</button>
                     </div>
                     <ul>
                        <?php foreach ($get_address as $key => $value):
                           $status = ($value->status == '0') ? 'is_default ' : '';
                         ?>
                        <li>
                           <div class="address-list">
                              <div class="address-title">
                                 <span><i class="fas fa-home"></i> </span> 
                                 <h6>Address</h6>
                              </div>
                              <div class="address-operation">
                                 <div class="address-chk-box <?=$status?>" data-id='<?=$this->utility->safe_b64encode($value->id)?>'>
                                    <label > Default
                                    <input type="checkbox"
                                       <?=($value->status == '1') ? 'checked' : '' ?>>
                                    <span class="blue"></span>
                                    </label>
                                 </div>
                                 <span class="edit_address" data-id='<?=$this->utility->safe_b64encode($value->id)?>'>
                                 <i class="fas fa-pencil-alt"></i>
                                 </span>
                                 <span class="remove_address" data-id='<?=$this->utility->safe_b64encode($value->id)?>'>
                                 <i class="fas fa-trash-alt"></i>
                                 </span>
                              </div>
                           </div>
                           <div class="user-detail">
                              <h6><?=$value->name?></h6>
                              <span></span>
                              <h6><?=$value->phone?></h6>
                           </div>
                           <p><?=$value->address .'<br>'.$value->city.','.$value->state.' '.$value->country ?></p>
                           <?=($value->landmark != '') ? '<p>Landmark :- '.$value->landmark.'</p>' : ''; ?>
                           <p>pincode :- <?=$value->pincode?></p>
                           <!-- <p>Ground Floor, Express Tower, L.t Road, Opp. Diamond Talkies,
                              Borivli (w), Mumbai, Maharashtra, INDIA-400092.</p> -->
                        </li>
                        <?php endforeach ?>
                     </ul>
                  </div>
               </div>

               <div class="tab-pane fade <?=($action_name == 'faq') ? 'active show' : '' ?>" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-whislist-tab">
                  <div class="wihslist-wrapper bg-white faq-accordion-tab">
                     <div class="your-order-header">
                        <h4><span><i class="fas fa-heart"></i></span>FAQ</h4>
                     </div>
                     <?php foreach ($faq as $key => $value): ?>
                     
                     <button class="accordion mt-4 <?=($key == '0') ? 'active' : '' ?>"> <?=$value->question?></button>
                     <div class="panel"  style="<?=($key == '0') ? 'max-height:100%' : '' ?>">
                        <p> <?=$value->answer?></p>
                     </div>
                     <?php endforeach ?>
                  </div>
               </div>

               <div class="tab-pane fade <?=($action_name == 'change') ? 'active show' : '' ?> " id="v-pills-change" role="tabpanel" aria-labelledby="v-pills-change-tab">
                  <div class="wihslist-wrapper address-wrapper bg-white">
                                          <div class="your-order-header address-header" id="address-header">
                        <h4><span><i class="fas fa-lock"></i></span>Change Password </h4>
                     
                     </div>                     <form id='ChangeUserPass' action="<?=base_url().'users_account/users/update_password'?>" method="post" class="account-form">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="input-wrapper">
                                 <span><i class="fas fa-lock"></i></span>
                                 <input type="password" name="old_pass" placeholder="current password" required="">
                              </div>
                              <label for="old_pass" class="error"></label>
                           </div>
                           <div class="col-lg-6 col-md-12">
                              <div class="input-wrapper">
                                 <span><i class="fas fa-lock"></i></span>
                                 <input type="password" name="new_pass" id="password_new" placeholder="new password">
                              </div>
                              <label for="password_new" class="error"></label>
                           </div>
                           <div class="col-lg-6 col-md-12">
                              <div class="input-wrapper">
                                 <span><i class="fas fa-lock"></i></span>
                                 <input type="password" name="confirm_pass" placeholder="Confirm password">
                              </div>
                              <label for="confirm_pass" class="error"></label>
                           </div>

                           <div class="col-md-12 mt-4 ">
                              <button type="submit" id="btnChangeUserPass" class="btn">Save</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
         </div>
      </div>
   </div>
   </div>
   </div>
</section>