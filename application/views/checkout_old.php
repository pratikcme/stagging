<?php
   include('header.php');
   //echo '1';die;
   $vendor_id = $this->session->userdata('id');
?>
<style>
   label.error {
   /*display: none !important;*/
   color:red;
   }
   .panel-heading {
   background: #5b6e84;
   font-size: 16px;
   font-weight: 300;
   color: white;
   }
   label {
   display: inline-block;
   margin-bottom: 5px;
   font-weight: 700;
   }
   .product_header {
   background: #5b6e84;
   font-size: 16px;
   font-weight: 300;
   color: white;
   width: 100%;
   padding: 1%;
   border-radius: 4px;
   margin-top: 10px;
   }
   .catg_list {
   width: 118px !important;
   border-radius: 5px;
   border-top: 5px solid;
   box-shadow: 0 2px 1px hsl(5, 100%, 69%);
   float: left;
   margin-bottom: 20px;
   margin-right: 1%;
   width: 14%;
   }
   .catg_list a {
   width: 118px !important;
   align-items: center;
   border: 1px solid;
   display: flex;
   float: left;
   height: 76px;
   justify-content: center;
   padding: 0 2px;
   text-align: center;
   width: 100%;
   overflow: auto;
   }
   .subcatg_list {
   width: 117px !important;
   border-radius: 5px;
   border-top: 5px solid;
   box-shadow: 0 2px 1px hsl(5, 100%, 69%);
   float: left;
   margin-bottom: 20px;
   margin-right: 1%;
   width: 142px;
   }
   .subcatg_list a {
   width: 117px !important;
   align-items: center;
   border: 1px solid;
   display: flex;
   float: left;
   height: 80px;
   justify-content: center;
   padding: 0 2px;
   text-align: center;
   width: 142px;
   overflow: auto;
   }
   .four_type {
   float: left;
   width: 95%;
   margin-right: 1%;
   margin-bottom: 20px;
   border-top: 5px solid;
   border-radius: 5px;
   box-shadow: 0px 2px 1px #FF6C60;
   }
   .four_type a {
   width: 100%;
   text-align: center;
   align-items: center;
   border: 1px solid;
   display: flex;
   float: left;
   height: 125px;
   justify-content: center;
   padding: 0 2px;
   }
   h4.items_count {
   float: left;
   width: auto;
   text-transform: uppercase;
   font-weight: 600;
   margin-right: 1%;
   margin-top: 0;
   }
   a.discard_sell {
   float: left;
   width: auto;
   background: #303030;
   padding: 10px 15px;
   color: white;
   }
   a.discard_sell:hover {
   background: #ff8d84;
   transition: all 0.5s ease 0s;
   }
   .park_sell {
   float: left;
   width: auto;
   background: #303030;
   padding: 10px 15px;
   color: white;
   border: unset;
   }
   .park_sell:hover {
   background: #ff8d84;
   transition: all 0.5s ease 0s;
   }
   .brder {
   border: 1px solid #ccc;
   float: left;
   margin-top: 10px;
   padding: 1%;
   width: 100%;
   }
   .create_cutomer a {
   float: left;
   width: 100%;
   }
   .create_cutomer {
   float: left;
   width: 100%;
   padding: 10px;
   background: #F3F3E7;
   margin: 0 0 10px;
   }
   .add_event_list ul {
   float: left;
   width: 100%;
   background: #F3F3E7;
   padding: 10px;
   margin: 0;
   }
   h5.event_name {
   color: black;
   float: left;
   width: 24%;
   margin-right: 1%;
   margin-bottom: 0;
   margin-top: 5px;
   }
   h5, .h5 {
   font-size: 14px;
   }
   .event_quantity input[type="text"] {
   float: left;
   width: 100%;
   margin: 0;
   }
   .add_event_list li {
   float: left;
   width: 100%;
   margin-bottom: 1%;
   }
   a.event_del {
   float: right;
   margin-left: 2%;
   width: 3%;
   text-align: center;
   background: #303030;
   }
   a.event_del:hover {
   background: #ff8d84;
   transition: all 0.5s ease 0s;
   }
   .fa {
   color: white;
   display: inline-block;
   font: normal normal normal 14px/1 FontAwesome;
   font-size: inherit;
   text-rendering: auto;
   -webkit-font-smoothing: antialiased;
   -moz-osx-font-smoothing: grayscale;
   }
   .add_total > p {
   float: left;
   width: 100%;
   }
   .add_total_digit {
   float: left;
   width: 100%;
   text-align: right;
   }
   .add_total {
   float: left;
   width: 100%;
   }
   .note_of_sale > ul {
   float: left;
   margin: 0;
   width: 100%;
   }
   .payment_btn {
   float: left;
   width: 100%;
   }
   .final_btn_pay > a {
   background: #303030 none repeat scroll 0 0;
   float: left;
   padding: 10px;
   width: 100%;
   }
   .final_btn_pay > a:hover {
   background: #ff8d84;
   transition: all 0.5s ease 0s;
   }
   .final_rs_pay {
   color: white;
   float: left;
   font-size: 16px;
   font-weight: bold;
   text-transform: uppercase;
   width: auto;
   }
   .rs_cs_totl {
   color: white;
   float: right;
   width: auto;
   }
   .final_btn_pay span p {
   color: white;
   float: right;
   width: auto;
   margin: 0;
   }
   .note_of_sale li:nth-child(3) {
   border-top: 1px solid #ccc;
   margin-top: 2px;
   padding-top: 5px;
   }
   .note_of_sale li {
   float: left;
   margin-bottom: 1%;
   width: 100%;
   }
   p.event_quantity {
   float: left;
   width: 24%;
   margin-right: 1%;
   margin-bottom: 0;
   }
   .add_total_digit {
   float: left;
   width: 100%;
   text-align: right;
   }
   .add_rupees {
   float: left;
   margin-right: 1%;
   width: 39%;
   }
   .add_rupees > input {
   float: left;
   width: 100%;
   }
   .add_event_list {
   float: left;
   width: 100%;
   height: 400px;
   overflow-y: auto;
   margin-bottom: 1%;
   }
   .park_btn {
   float: right;
   width: auto;
   margin-left: 3%;
   }
   .discard_btn {
   float: right;
   width: auto;
   }
   .overlay {
   position: absolute;
   height: 100%;
   width: 100%;
   z-index: 10101010;
   background: #ffffff9c;
   }
   .loader {
   position: absolute;
   top: 44%;
   left: 54%;
   transform: translate(-50%, -50%);
   width: 60px;
   height: 60px;
   border-radius: 50%;
   border: 4px solid #009ed2;
   border-right-color: transparent;
   transform-origin: center;
   animation: rotate 1s linear infinite;
   }
   @keyframes rotate {
   from {
   transform: rotate(0);
   }
   to {
   transform: rotate(360deg);
   }
   }
   .showid_qnt {
   width: 27%;
   }
</style>
<div class="overlay" style="display: none;">
   <div class="loader"></div>
</div>
<section id="main-content">
   <section class="wrapper site-min-height">
      <div id="msg">
         <?php if ($this->session->flashdata('msg') && $this->session->flashdata('msg') != '') { ?>
         <div class="alert alert-success fade in">
            <strong>Success!</strong> <?php echo $this->session->flashdata('msg');; ?>
         </div>
         <?php }
            unset($this->session->flashdata); ?>
      </div>
      <div class="row">
         <div class="col-lg-12">
            <section class="panel">
               <header class="panel-heading">Sell</header>
               <p class="sub_title"></p>
               <?php if (!empty($register_result)) { ?>
               <?php if ($register_result[0]->type == '1') { ?>
               <div class="panel-body">
                  <div class="">
                     <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <div class="customer">
                           <div class="form-group">
                              <label for="name">Select Customers</label>
                              <select class="form-control" name="customer" id="customer_id">
                                 <option selected value="">-----Select Customer-----</option>
                                 <?php foreach ($cust_row as $customer) { ?>
                                 <option value="<?php echo $customer->id; ?>"> <?php echo $customer->customer_name; ?> </option>
                                 <?php } ?>
                              </select>
                              <label for="customer_id" class="error"
                                 style="color: red; display: none;">Please select
                              customer</label>
                           </div>
                        </div>
                        <!--<div class="customer">
                           <div class="form-group">
                               <label for="name">Select Product</label>
                               <select class="form-control" name="product_type" id="select_product">
                                   <option selected disabled>-----Select Product-----</option>
                                   <?php /*foreach ($product_row as $product) { */ ?>
                                       <option value="<?php /*echo $product->id; */ ?>"> <?php /*echo $product->name; */ ?> </option>
                                   <?php /*} */ ?>
                               </select>
                           </div>
                           </div>-->
                        <div class="LoaderBalls">
                           <div class="LoaderBalls__item"></div>
                           <div class="LoaderBalls__item"></div>
                           <div class="LoaderBalls__item"></div>
                        </div>
                        <div class="customer">
                           <div class="form-group">
                              <label for="name">Search Product</label>
                              <input type="text" class="form-control" name="product_search"
                                 id="product_search">
                              <div id="search_result"></div>
                           </div>
                        </div>
                        <div class="customer">
                           <div class="form-group">
                              <label for="name" id="sel_cat"
                                 class="product_header">Category</label>
                           </div>
                        </div>
                        <div class="sel_catagory_itm">
                           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no_padd click_box">
                              <?php foreach ($category as $type) { ?>
                              <div class="catg_list" id="catg_list"
                                 onclick="return select_subcategory('<?php echo $type->id; ?>','<?php echo $type->name; ?>');">
                                 <a href="javascript:;"><span><?php echo $type->name; ?></span></a>
                              </div>
                              <?php } ?>
                           </div>
                        </div>
                        <!-- <div class="customer" id="sel_sub">
                           <div class="form-group">
                              <label for="name" class="product_header">Subcategory</label>
                           </div>
                           </div>
                           <div id="subcategory"></div>
                           <div class="customer">
                           <div class="form-group">
                              <label for="name" class="product_header">Product</label>
                           </div>
                           </div>
                           <div id="product_data"></div>
                           <div class="customer">
                           <div class="form-group">
                              <label for="name" class="product_header">Variants</label>
                           </div>
                           </div> -->
                        <div id="type_array"></div>
                     </div>
                     <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <form method="post"
                           action="<?php echo base_url() . 'sell/order_checkout/'; ?>"
                           id="paypal_form"
                           class="paypal" name="checkout_sell" novalidate>
                           <input type="hidden" name="vendor_id" id="user_id"
                              value="<?php echo $vendor_id; ?>">
                           <input type="hidden" name="customer" id="set_customer" value="">
                           <input type="hidden" name="hidden_subtotal" id="hidden_subtotal"
                              value="0.00">
                           <input type="hidden" name="hidden_discount_total"
                              id="hidden_discount_total" value="0.00">
                           <input type="hidden" name="hidden_total" id="hidden_total" value="0.00">
                           <input type="hidden" name="hidden_total_pay" id="hidden_total_pay"
                              value="0.00">
                           <input type="hidden" name="paypal_amount" id="paypal_amount"
                              value="0.00">
                           <input type="hidden" name="cmd" value="_xclick"/>
                           <input type="hidden" name="no_note" value="1">
                           <input type="hidden" name="lc" value="UK"/>
                           <input type="hidden" name="currency_code" value="USD">
                           <input type="hidden" name="bn"
                              value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest"/>
                           <input type="hidden" name="user_name"
                              value="<?php echo $user_row[0]->name; ?>"/>
                           <input type="hidden" name="first_name"
                              value="<?php echo $user_row[0]->name; ?>"/>
                           <input type="hidden" name="payer_email"
                              value="<?php echo $user_row[0]->email; ?>"/>
                           <input type="hidden" name="register_id"
                              value="<?php if (!empty($register_result)) {
                                 echo $register_result[0]->id;
                                 } ?>"/>
                           <div class="check_out">
                              <div class="col-md-5 col-lg-5 col-sm-5 col-xs-12 padd_lft_0">
                                 <div class="check_items">
                                    <h4 class="items_count">Checkout</h4>
                                    <span></span>
                                 </div>
                              </div>
                              <?php
                                 if (isset($parked_order_id) && !empty($parked_order_id)) {
                                     ?>
                              <div class="col-md-7 col-lg-7 col-sm-7 col-xs-12 padd_rght_0">
                                 <div class="discard_btn">
                                    <a class="discard_sell" id="discard_parked_sell"
                                    <!--href="--><?php /*echo base_url().'sell/index' */ ?>
                                    ">Discard sale</a>
                                 </div>
                              </div>
                              <?php } else { ?>
                              <div class="col-md-7 col-lg-7 col-sm-7 col-xs-12 padd_rght_0">
                                 <div class="park_btn">
                                    <!--<a class="park_sell" href="#">Park sale</a>-->
                                    <input type="submit" class="park_sell" value="Park Sale"
                                       name="parked_sell">
                                 </div>
                                 <div class="discard_btn">
                                    <a class="discard_sell" id="discard_sell"
                                    <!--href="--><?php /*echo base_url().'sell/index' */ ?>
                                    ">Discard sale</a>
                                 </div>
                              </div>
                              <?php } ?>
                              <div class="brder">
                                 <div class="create_cutomer">
                                    <a href="<?php echo base_url() . 'customer/customer1'; ?>">Create
                                    New Customer</a>
                                 </div>
                                 <div class="add_event_list">
                                    <ul id="temp_product_list" style="">
                                       <?php if (count($order_temp_result) >= 1) { ?>
                                       <!--Order Temp Data Saved-->
                                       <?php foreach ($order_temp_result as $temp) { ?>
                                       <ul id="temp_product_list"
                                          class="temp_product_list<?php echo $temp->id; ?>">
                                          <li>
                                             <h5 class="event_name"> <?php echo $temp->product_name; ?> </h5>
                                             <p class="event_quantity">
                                                <input type="number"
                                                   data-table=''
                                                   style="margin-left: -9%;"
                                                   max="1" width="27%"
                                                   class="showid_qnt"
                                                   name="qnt<?php echo $temp->id; ?>"
                                                   id="qnt<?php echo $temp->id; ?>"
                                                   value="<?php echo $temp->quantity; ?>"
                                                   data-price="<?php echo $temp->product_price; ?>"
                                                   data-val="<?php echo $temp->product_weight_id; ?>"
                                                   onkeyup="showId(<?php echo $temp->id; ?>, <?php echo $temp->product_price; ?>, <?php echo $temp->id; ?>,<?php echo $temp->product_weight_id; ?>,<?php echo $temp->product_discount; ?>,<?php if (isset($parked_order_id) && !empty($parked_order_id)) {
                                                      echo "1";
                                                      } else {
                                                      echo "0";
                                                      }
                                                      ?>)"
                                                   onchange="change_qty(<?php echo $temp->id; ?>, <?php echo $temp->product_price; ?>, <?php echo $temp->id; ?>)"
                                                   data-input="">Quantity
                                                <script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
                                                <script type="text/javascript">
                                                   //var change_temp = "";
                                                   //$('#qnt' +<?php //echo $temp->id; ?>//).bind('keydown', function (e) {
                                                   //
                                                   //    var id = <?php //echo $temp->id; ?>//;
                                                   //    var qnt_val = $("#qnt" + id).val();
                                                   //
                                                   //    if (qnt_val == '0' || qnt_val == '') {
                                                   //        var qty = '1';
                                                   //        $("#qnt" + id).val(qty);
                                                   //
                                                   //        var final_price = qty * price; //final price
                                                   //        $(".tmp_price" + id).html(parseFloat(final_price).toFixed(2));
                                                   //    }
                                                   //
                                                   //});
                                                </script>
                                             </p>
                                             <p class="event_quantity">
                                                <input type="number" min="0"
                                                   max="<?php echo $temp->product_discount; ?>"
                                                   name="discount<?php echo $temp->id; ?>"
                                                   id="discount<?php echo $temp->id; ?>"
                                                   placeholder="Discount (%)"
                                                   class="disc"
                                                   value="<?php if ($temp->discount == '0.00') {
                                                      echo '';
                                                      } else {
                                                      echo $temp->discount;
                                                      } ?>"
                                                   onkeyup="discount_temp_order('<?php echo $temp->id; ?>', '<?php echo $temp->price; ?>', '<?php echo $temp->id; ?>', '<?php echo $temp->product_price; ?>', '<?php echo $temp->product_discount; ?>', '<?php echo $temp->actual_price; ?>')"
                                                   style="width: 100%;">In(%)
                                                <label style="color: red"
                                                   id="error<?= $temp->id; ?>"></label>
                                             </p>
                                             <?php
                                                if (isset($parked_order_id) && !empty($parked_order_id)) {
                                                    ?>
                                             <a href="javascript:;"
                                                onclick="delete_parked_order('<?php echo $temp->id; ?>', '<?php echo $temp->product_weight_id; ?>')"
                                                class="event_del"><i
                                                class="fa fa-trash-o "></i></a>
                                             <?php
                                                } else {
                                                    ?>
                                             <a href="javascript:;"
                                                onclick="delete_tmp_order('<?php echo $temp->id; ?>', '<?php echo $temp->product_weight_id; ?>')"
                                                class="event_del"><i
                                                class="fa fa-trash-o "></i></a>
                                             <?php } ?>
                                             <div class="ruppers_txt">
                                                <span><?= $currency; ?></span>
                                                <div class="event_rupee tmp_price<?php echo $temp->id; ?>"><?php echo $temp->price; ?></div>
                                             </div>
                                          </li>
                                          <div style="margin:0 0 0 183px; color: red; display: none;"
                                             id="discount_message<?php echo $temp->id; ?>">
                                             Discount is not more than product buy
                                             discount
                                          </div>
                                       </ul>
                                       <?php } ?>
                                       <?php } ?>
                                    </ul>
                                 </div>
                                 <div class="note_of_sale">
                                    <ul>
                                       <li>
                                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                             <div class="add_total">
                                                <p>Sub-total</p>
                                             </div>
                                          </div>
                                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                             <div class="add_total_digit">
                                                <?= $currency . ' '; ?><span id="subtotal">00.00</span>
                                             </div>
                                          </div>
                                       </li>
                                       <li>
                                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                             <div class="add_total">
                                                <p>Discount</p>
                                             </div>
                                          </div>
                                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                             <div class="add_total_digit">
                                                <div class="add_percent">
                                                </div>
                                                <div class="add_rupees"><input type="number"
                                                   min="0"
                                                   max="1"
                                                   name="disc_percentage"
                                                   placeholder="%"
                                                   onkeyup="calculate_percentage();"
                                                   id="disc_percentage"
                                                   value="<?php if(isset($parked_order_id)){echo $order_temp_result[0]->order_discount;} ?>">
                                                   <label id="error"
                                                      style="color:red;"></label>
                                                </div>
                                                <?= $currency . ' '; ?><span
                                                   id="discount_total">00.00</span>
                                             </div>
                                          </div>
                                       </li>
                                       <li>
                                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                             <div class="add_total">
                                                <p>Total</p>
                                             </div>
                                          </div>
                                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                             <div class="add_total_digit">
                                                <?= $currency . ' '; ?><span id="total">00.00</span>
                                             </div>
                                          </div>
                                       </li>
                                       <div class="payment_btn">
                                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 no_padd pull-right">
                                             <div class="final_btn_pay">
                                                <!--<a href="#myModal" data-toggle="modal" id="span_pay" onclick="check_selected()"><span class="final_rs_pay">Pay</span>-->
                                                <a href="#myModal" data-toggle="modal"
                                                   id="span_pay"
                                                   onclick="">
                                                   <span
                                                      class="final_rs_pay">Pay</span>
                                                   <span class="rs_cs_totl">
                                                      <?= $currency . ' '; ?>
                                                      <p
                                                         id="total_pay">00.00</p>
                                                   </span>
                                                </a>
                                             </div>
                                          </div>
                                          <?php   if (isset($parked_order_id) && !empty($parked_order_id)) {
                                             ?>
                                          <input type="hidden" name="parked_order" value="park">
                                          <?php } ?>
                                          <!-- Add Brand : Modal -->
                                          <div class="modal fade " id="myModal" tabindex="-1"
                                             role="dialog" aria-labelledby="myModalLabel"
                                             aria-hidden="true" style="display: none;">
                                             <div class="modal-dialog">
                                                <div class="modal-content"
                                                   id="modal_div_id">
                                                   <div class="modal-header">
                                                      <button type="button" class="close"
                                                         data-dismiss="modal"
                                                         aria-hidden="true">×
                                                      </button>
                                                      <h4 class="modal-title">Pay</h4>
                                                   </div>
                                                   <!--<div class="modal-body">
                                                      <div class="form-group">
                                                          <label for="email">Email</label>
                                                          <input type="text" name="rec_email" class="form-control" value="" placeholder="Email" required>
                                                      </div>
                                                      <div class="form-group">
                                                          <label for="description">Sale Note</label>
                                                          <textarea rows="4" cols="50" class="form-control" name="sale_note" placeholder="Type to add a sale note" required></textarea>
                                                      </div>
                                                      </div>-->
                                                   <div class="modal-footer pull-center"
                                                      style="border:none;">
                                                      <center>
                                                         <input type="submit"
                                                            class="btn btn-primary btn-lg"
                                                            value="Cash"
                                                            name="cash"/>
                                                         <input type="submit"
                                                            class="btn btn-primary btn-lg"
                                                            value="Credit Card"
                                                            name="credit_card"/>
                                                      </center>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                     </div>
                  </div>
               </div>
               <?php } else { ?>
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
               <div class="checkout_closed_register">
               <img src="<?php echo base_url() . 'public/images/sorry.png' ?>"/>
               <h3>Register closed</h3>
               <p>To make a sale, please open the register</p>
               <button class="btn btn-warning" type="button" href="#myModal"
                  data-toggle="modal">Open Register
               </button>
               </div>
               </div>
               <?php } ?>
               <?php } else { ?>
               <div>
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
               <div class="checkout_closed_register">
               <img src="<?php echo base_url() . 'public/images/sorry.png' ?>"/>
               <h3>Register closed</h3>
               <p>To make a sale, please open the register</p>
               <button class="btn btn-warning" type="button" href="#myModal"
                  data-toggle="modal">Open Register
               </button>
               </div>
               </div>
               </div>
               <?php } ?>
            </section>
         </div>
         </form>
      </div>
   </section>
</section>
<!-- Add Type : Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
   style="display: none;">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Set opening cash drawer amount</h4>
         </div>
         <form method="post" id="model" action="<?php echo base_url() . 'register/opening_cash'; ?>">
            <div class="modal-body">
               <div class="form-group">
                  <label for="name">Cash Amount</label>
                  <input type="text" name="amount" class="form-control" value="" >
                  <label for="amount" class="error" ></label>
               </div>
               <div class="form-group">
                  <label for="name">Type to add note</label>
                  <input type="text" name="note" class="form-control" value="">
                  <label for="note" class="error" ></label>
               </div>
            </div>
            <div class="modal-footer">
               <input type="submit" class="btn btn-primary" value="Save Amount" name="save_amount"/>
            </div>
         </form>
      </div>
   </div>
</div>
<input type="hidden" id="cal_val">
<input type="hidden" id="cat_val">
<input type="hidden" id="subcal_val">
<input type="hidden" id="subcat_val">
<?php
   if (isset($parked_order_id) && !empty($parked_order_id)) {
       ?>
<input type="hidden" name="parked_id" value="<?= $parked_order_id; ?>">
<?php
   }
   ?>
<style>
   .ms-container {
   width: 98%;
   }
   #printableArea {
   display: none;
   }
   /*.sel_catagory_itm{
   z-index: 2000;
   }*/
   #search_result {
   z-index: 1;
   }
   input::-webkit-outer-spin-button,
   input::-webkit-inner-spin-button {
   -webkit-appearance: none;
   }
</style>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script>
<script>
   // $('#paypal_form').validate({
   //     rules: {
   //         disc_percentage: {
   //             number: true,
   //             max : 99
   //         }
   //     },
   //     messages: {
   //         disc_percentage: {
   //             number: "Please select customer",
   //             max : "Please enterdfdf"
   //         },
   //     },
   //     error: function (label) {
   //         $(this).addClass("error");
   //     }
   // });
   
</script>
<!--code added by bhavin starts here-->
<script type="text/javascript">
   $('#model').validate({
       rules: {
           amount:{required:true,
                   min:0,
               digits:true,
               number:true,
           },
           note:{required: true}
       },
       messages: {
           amount:{required:"Please enter amount",
               min:"Please enter only numeric value",
               digits:"Please enter only numeric value",
               number:"Please enter valid numeric value",
           },
           note:{required:"Please enter note"}
   
       },
       
   });
   
   
   $('#customer_id').change(function () {
       var cus = $(this).val();
       $('#set_customer').val(cus);
   });
   
   $('#disc_percentage').keyup(function () {
       var disc = $(this).val();
       if (disc > 99) {
           $(this).val("");
           $('#error').html("Discount must be less than 100%");
           // $('#span_pay').css("display","none");
       }else if(Math.sign(disc) == -1){
            $(this).val("");
           $('#error').html("Discount value not be minus");
       } else {
           $('#error').html("");
   
       }
   })
   // function check_selected() {
   //     var customer_id = $('#customer_id').val();
   //     if (customer_id == 0) {
   //         $('#modal_div_id').css('display', 'none');
   //         bootbox.alert("Please select customer", function () {
   //             window.location.reload(true);
   //         });
   //     } else {
   //
   //     }
   // }
   
   
   $(".click_box  .catg_list").click(function () {
       $(this).addClass('active_bg').siblings().removeClass('active_bg');
   });
   
   $(function () {
       var sum = 0;
       $('.event_rupee').each(function () {
           sum += +$(this).text() || 0;
       });
   
       var disc_percentage = $("#disc_percentage").val();
       if (disc_percentage == '' && disc_percentage == null) {
           var disc_percentage_new = $("#disc_percentage").val('00.00');
       } else {
           var disc_percentage_new = $("#disc_percentage").val();
       }
   
       var per_result = ((sum * disc_percentage_new) / 100);
       var result = (sum - parseFloat(per_result).toFixed(2));
   
       $("#subtotal").text(parseFloat(sum).toFixed(2));
       $("#discount_total").text(parseFloat(per_result).toFixed(2));
       $("#total").text(parseFloat(result).toFixed(2));
       $("#total_pay").text(parseFloat(result).toFixed(2));
   
       $("#hidden_subtotal").val(parseFloat(sum).toFixed(2));
       $("#hidden_discount_total").val(parseFloat(per_result).toFixed(2));
       $("#hidden_total").val(parseFloat(result).toFixed(2));
       $("#hidden_total_pay").val(parseFloat(result).toFixed(2));
       $("#paypal_amount").val(parseFloat(result).toFixed(2));
   
       if (parseFloat(result) <= 0) {
           $('#span_pay').attr('style', 'display:none');
           $('.park_btn').attr('style', 'display:none');
           $('.discard_btn').attr('style', 'display:none');
       } else {
           $('#span_pay').attr('style', 'display:block');
           $('.park_btn').attr('style', 'display:block');
           $('.discard_btn').attr('style', 'display:block');
       }
   });
   
   setTimeout(function () {
       $('#msg').hide();
   }, 30000);
   
   /*Update Product Temp Qnt - On click discard*/
   $('#discard_sell').click(function () {
       $.ajax({
           method: "post",
           url: '<?php echo site_url('sell/update_same_as_qnt'); ?>',
           success: function () {
               location.reload();
           }
       });
   });
   $('#discard_parked_sell').click(function () {
   
   
       var id = '<?= $parked_order_id; ?>';
       $.ajax({
           type: "post",
           url: '<?php echo site_url('sell/discard_parked_order'); ?>',
           data: {'id': id},
           success: function () {
               location.href = 'sell/index.php';
           }
       });
   });
   
   
   /*Search Product And Tag*/
   $(document).ready(function () {
   
       table = "<?php echo $var; ?>";
   
       //
       //        var hiden_total = $('#hidden_total_pay').val();
       //
       //        if(parseFloat(hiden_total) <= 0 ){
       //            $('#span_pay').attr('style','display:none');
       //        }
   
       $('#product_search').keyup(function () {
   
           $('.sell_four_box').css({'display': 'none'});
           // $('.sel_catagory_itm').css({'display': 'none'});
   
           $('#search_result').css({'z-index': '1'});
   
   
           var txt = $(this).val();
           if (txt == '' || txt == null) {
               // window.location.href = window.location.href;
               $('.sell_four_box').css({'display': ''});
               $('.sel_catagory_itm').css({'display': ''});
               $('#sel_cat').html("Product");
               category();
           }
           if (txt != '') {
               $.ajax({
                   method: "post",
                   url: '<?php echo site_url('sell/ajax_search_product'); ?>',
                   data: {search: txt},
                   success: function (data) {
   
                       $('.sell_four_box').css({'display': 'none'});
                       // $('.sel_catagory_itm').css({'display': 'none'});
                       $('#sel_cat').html("product");
                       // $('#search_result').html(data);
                       // $('#product_data').html(data);
                       $('.sel_catagory_itm').html(data);
                   }
               });
           }
       });
   });
   
   function change_qty(obj, price, tmp_price) {
       var id = obj; //product_id
       var qty_fetch = $("#qnt" + id).val(); //product quantity
       var  check = Math.sign(qty_fetch);
       // if(check == -1){
       //  var qty = '1';
       //  $("#qnt" + id).val(qty);
       //  return false;
       // }
       if (qty_fetch == '0' || qty_fetch == '' || check == -1) {
           var qty = '1';
           $("#qnt" + id).val(qty);
   
           var final_price = qty * price; //final price
           $(".tmp_price" + id).html(parseFloat(final_price).toFixed(2));
           var quantity = "1";
           ajaxCall_update(obj, price, tmp_price, quantity);
       }
   
   };
   
   /* Calculate price and sum of sub-total */
   function showId(obj, price, tmp_price, var_id, disc, type) {
   
   
       var variant_id = var_id;
       var old_price = price;
   
       var park = table;
   
       var id = obj; //product_id
       var qty_fetch = $("#qnt" + id).val(); //product quantity
       var check = Math.sign(qty_fetch); 
       $('#discount' + id).val(disc);
       if (qty_fetch != "" && check != -1) {
   
           $.ajax({
               type: 'post',
               url: '<?php echo site_url('sell/check_quantity_val'); ?>',
               dataType: 'json',
               data: {variant_id: variant_id, quantity: qty_fetch, order_temp_id: id,park:park},
               success: function (data) {
                   console.log(data);
                   // return false;
                   var quantity = data.quantity;
                   if (data.status == 0) {
   
                       bootbox.alert("You have only    " + quantity + "    quantity", function () {
                           set_qnt(variant_id);
                           $('#qnt' + id).val('1');
                           var quantity = '1';
                           ajaxCall_update(obj, old_price, tmp_price, quantity);
                           // return false;
                       });
   
                       return false;
   
                   }
                   else{
                       $('#disc_percentage').val(0);
                       $('#discount_total').html(0);
                   }
   
               }
           });
       }
   
   
       var qty = $("#qnt" + id).val();
   
       var final_price = qty * price; //final price
       $(".tmp_price" + id).html(parseFloat(final_price).toFixed(2));
       // }
   
       var final_price = qty * price; //final price
   
       $(".tmp_price" + id).html(parseFloat(final_price).toFixed(2));
   
       var discount = +$("#discount" + id).val(); //product discount
   
       var cal_price = ((parseFloat(final_price).toFixed(2) * parseFloat(discount).toFixed(2)) / 100);
       // var new_final_price = (parseFloat(final_price).toFixed(2) - parseFloat(cal_price).toFixed(2));
   
       $(".tmp_price" + id).html(parseFloat(final_price).toFixed(2));
   
       var sum = 0;
       $('.event_rupee').each(function () {
           sum += +$(this).text() || 0;
       });
   
       $("#subtotal").text(parseFloat(sum).toFixed(2));
       $("#total").text(parseFloat(sum).toFixed(2));
       $("#total_pay").text(parseFloat(sum).toFixed(2));
   
       $("#hidden_subtotal").val(parseFloat(sum).toFixed(2));
       $("#hidden_total").val(parseFloat(sum).toFixed(2));
       $("#hidden_total_pay").val(parseFloat(sum).toFixed(2));
       $("#paypal_amount").val(parseFloat(sum).toFixed(2));
       if (parseFloat(sum) <= 0) {
           $('#span_pay').attr('style', 'display:none');
           $('.park_btn').attr('style', 'display:none');
           $('.discard_btn').attr('style', 'display:none');
       } else {
           $('#span_pay').attr('style', 'display:block');
           $('.park_btn').attr('style', 'display:block');
           $('.discard_btn').attr('style', 'display:block');
       }
       //On change update order tamp
   
   
       if (qty_fetch != "" && check != -1) {
   
   
           if (table == "park") {
   
               $.ajax({
                   url: '<?php echo base_url() . 'sell/update_parked_order/'; ?>',
                   type:'post',
                   data: {
                       product_id: id,
                       quantity: qty,
                       price: final_price,
                       discount: discount,
                       discount_price: cal_price,
                   },
                   success: function (data) {
   
   
                       $('#disc_percentage').val(0);
                       $('#discount_total').html(0);
                       var json = JSON.parse(data);
                       if (json == 1) {
   
                       } else {
                           return false;
                       }
                   }
               });
   
           } else {
               $.ajax({
                   url: '<?php echo base_url() . 'sell/update_order_temp/'; ?>',
                   data: {
                       product_id: id,
                       quantity: qty,
                       price: final_price,
                       discount: discount,
                       discount_price: cal_price,
                   },
                   success: function (data) {
   
                       console.log(data);
                       var json = JSON.parse(data);
                       if (json == 1) {
   
                       } else {
                           return false;
                       }
                   }
               });
           }
       }
   }
   
   
   function set_qnt(obj) {
   
       var id = obj;
       $.ajax({
           url: '<?php echo base_url() . 'sell/set_qnt/'; ?>',
           type: 'post',
           data: {
               product_id: id,park:table,
           },
           success: function (data) {
           }
       });
   
   }
   
   
   /*Inside showId function*/
   function ajaxCall_update(obj, price, tmp_price, quantity) {
   
       var id = obj; //product_id
       var qty = quantity; //product quantity
       var final_price = qty * price; //final price
   
       $(".tmp_price" + id).html(parseFloat(final_price).toFixed(2));
   
       var discount = +$("#discount" + id).val(); //product discount
   
       var cal_price = ((parseFloat(final_price).toFixed(2) * parseFloat(discount).toFixed(2)) / 100);
       // var new_final_price = (parseFloat(final_price).toFixed(2) - parseFloat(cal_price).toFixed(2));
       //
       $(".tmp_price" + id).html(parseFloat(final_price).toFixed(2));
   
       var sum = 0;
       $('.event_rupee').each(function () {
           sum += +$(this).text() || 0;
       });
   
       $("#subtotal").text(parseFloat(sum).toFixed(2));
       $("#total").text(parseFloat(sum).toFixed(2));
       $("#total_pay").text(parseFloat(sum).toFixed(2));
   
       $("#hidden_subtotal").val(parseFloat(sum).toFixed(2));
       $("#hidden_total").val(parseFloat(sum).toFixed(2));
       $("#hidden_total_pay").val(parseFloat(sum).toFixed(2));
       $("#paypal_amount").val(parseFloat(sum).toFixed(2));
       if (parseFloat(sum) <= 0) {
           $('#span_pay').attr('style', 'display:none');
           $('.park_btn').attr('style', 'display:none');
           $('.discard_btn').attr('style', 'display:none');
       } else {
           $('#span_pay').attr('style', 'display:block');
           $('.park_btn').attr('style', 'display:block');
           $('.discard_btn').attr('style', 'display:block');
       }
   
   
   
           $.ajax({
               url: '<?php echo base_url() . 'sell/update_order_temp/'; ?>',
               data: {
                   product_id: id,
                   quantity: '1',
                   price: final_price,
                   discount: discount,
                   discount_price: cal_price,
                   park:table,
                   url: '<?php echo base_url() . 'sell/update_order_temp/'; ?>',
               },
               success: function (data) {
               }
           });
   }
   
   /* Calculate price and sum of sub-total From Temp Product Discount */
   function discount_temp_order(obj, price, tmp_price, p_price, discount_pro, actual_price) {
   
       var id = obj; //product_id
       var qty = +$("#qnt" + id).val(); //product quantity
       var final_price = qty * p_price; //final price
       var act_price = qty * actual_price;
       // $(".tmp_price" + id).html(parseFloat(final_price).toFixed(2));
   
       var discount = +$("#discount" + id).val(); //product discount
       var product_descount = discount_pro;
   
       // var final_price = $('.tmp_price'+id).val();
       if (discount >= 100) {
   
           $('#error' + id).html("discount must be less than 100%");
   
           $('#discount' + id).val(discount_pro);
           $(".tmp_price" + id).html(parseFloat(final_price).toFixed(2));
           var sum = 0;
           $('.event_rupee').each(function () {
               sum += +$(this).text() || 0;
           });
   
           $("#subtotal").text(parseFloat(sum).toFixed(2));
           $("#total").text(parseFloat(sum).toFixed(2));
           $("#total_pay").text(parseFloat(sum).toFixed(2));
           return false;
       }else if(Math.sign(discount) == -1){
            $('#error' + id).html("discount value not be minus");

           $('#discount' + id).val(discount_pro);
           $(".tmp_price" + id).html(parseFloat(final_price).toFixed(2));
           var sum = 0;
           $('.event_rupee').each(function () {
               sum += +$(this).text() || 0;
           });
   
           $("#subtotal").text(parseFloat(sum).toFixed(2));
           $("#total").text(parseFloat(sum).toFixed(2));
           $("#total_pay").text(parseFloat(sum).toFixed(2));
           return false;
       } else {
   
           $('#error' + id).html("");
   
           $('#discount_message' + id).css('display', 'none');
           var discount = +$("#discount" + id).val(); //product discount
           // var b_price = ((parseFloat(final_price).toFixed(2) * parseFloat(discount_pro).toFixed(2)) / 100);
           // var bs_price =  (parseFloat(final_price).toFixed(2) + parseFloat(b_price).toFixed(2));
           // // alert(bs_price);
           var cal_price = ((parseFloat(act_price).toFixed(2) * parseFloat(discount).toFixed(2)) / 100);
           var new_final_price = (parseFloat(act_price).toFixed(2) - parseFloat(cal_price).toFixed(2));
   
           $(".tmp_price" + id).html(parseFloat(new_final_price).toFixed(2));
   
           var sum = 0;
           $('.event_rupee').each(function () {
               sum += +$(this).text() || 0;
           });
   
           $("#subtotal").text(parseFloat(sum).toFixed(2));
           $("#total").text(parseFloat(sum).toFixed(2));
           $("#total_pay").text(parseFloat(sum).toFixed(2));
   
           $("#hidden_subtotal").val(parseFloat(sum).toFixed(2));
           $("#hidden_total").val(parseFloat(sum).toFixed(2));
           $("#hidden_total_pay").val(parseFloat(sum).toFixed(2));
           $("#paypal_amount").val(parseFloat(sum).toFixed(2));
   
           if (parseFloat(sum) <= 0) {
               $('#span_pay').attr('style', 'display:none');
               $('.park_btn').attr('style', 'display:none');
               $('.discard_btn').attr('style', 'display:none');
           } else {
               $('#span_pay').attr('style', 'display:block');
               $('.park_btn').attr('style', 'display:block');
               $('.discard_btn').attr('style', 'display:block');
           }
           //On change update order tamp
   
   
           if (table == "park") {
               $.ajax({
                   url: '<?php echo base_url() . 'sell/update_discount_parked_order/'; ?>',
                   type:'post',
                   data: {
                       product_id: id,
                       quantity: qty,
                       price: final_price,
                       discount: discount,
                       discount_price: cal_price,
                   },
                   success: function (data) {
   
   
                       $('#disc_percentage').val(0);
                       $('#discount_total').html(0);
   
   
                       var json = JSON.parse(data);
                       if (json == 1) {
   
                       } else {
                           return false;
                       }
                   }
               });
   
           }
           else {
               $.ajax({
                   url: '<?php echo base_url() . 'sell/update_order_temp/'; ?>',
                   data: {
                       product_id: id,
                       quantity: qty,
                       price: new_final_price,
                       discount: discount,
                       discount_price: cal_price,
                       product_descount: product_descount,
                       url: '<?php echo base_url() . 'sell/update_order_temp/'; ?>'
                   },
                   success: function (data) {
                       console.log(data);
                   }
               });
           }
       }
   
   }
   
   
   /* Calculate price and sum of sub-total */
   function calculate_percentage() {
   
       var percentage = +$('#disc_percentage').val();
       var sub_total = +$('#subtotal').text();
        
        if(Math.sign(percentage) == -1){
       var per_result = ((parseFloat(sub_total).toFixed(2) * parseFloat(0).toFixed(2)) / 100);
       var result = (parseFloat(sub_total).toFixed(2) - parseFloat(per_result).toFixed(2));
            // return false;
        } else{
        var per_result = ((parseFloat(sub_total).toFixed(2) * parseFloat(percentage).toFixed(2)) / 100);
       var result = (parseFloat(sub_total).toFixed(2) - parseFloat(per_result).toFixed(2));

        }
        
   
   
       $("#total").text(parseFloat(result).toFixed(2));
       $("#total_pay").text(parseFloat(result).toFixed(2));
       $("#discount_total").text(parseFloat(per_result).toFixed(2));
   
       $("#hidden_total").val(parseFloat(result).toFixed(2));
       $("#hidden_total_pay").val(parseFloat(result).toFixed(2));
       $("#hidden_discount_total").val(parseFloat(per_result).toFixed(2));
       $("#paypal_amount").val(parseFloat(result).toFixed(2));
       if (parseFloat(result) <= 0) {
           $('#span_pay').attr('style', 'display:none');
           $('.park_btn').attr('style', 'display:none');
           $('.discard_btn').attr('style', 'display:none');
       } else {
           $('#span_pay').attr('style', 'display:block');
           $('.park_btn').attr('style', 'display:block');
           $('.discard_btn').attr('style', 'display:block');
       }
   }
   
   $(document).on('click', '.selectcat', function () {
       var id = $('#cal_val').val();
       var name = $('#cat_val').val();
       category();
   
   });
   
   function category() {
   
       $.ajax({
   
           url: '<?php echo base_url() . 'sell/select_category'; ?>',
           type: 'post',
           data: {},
           success: function (data) {
               $('.sel_catagory_itm').html(data);
               $('#sel_cat').html("category");
   
           }
       });
   
   }
   
   function select_subcategory(value, catname) {
       var customer_id = $('#customer_id').val();
       // if(customer_id == ""){
       //     bootbox.alert("Please select custmer", function () {
       //        $('#customer_id').focus();
       //     });
       //     return false;
       // }
       var type_id = value;
       $('#cal_val').val(value);
       $('#cat_val').val(catname);
       $.ajax({
   
           url: '<?php echo base_url() . 'sell/select_subcategory'; ?>',
           // type:'post',
           data: {
               type_id: type_id,
               url: '<?php echo base_url() . 'sell/select_subcategory'; ?>',
           },
           success: function (data) {
               var sethtml = "<span class='selectcat'>" + catname + "</span>";
               $('#sel_cat').html(sethtml);
               // $('#subcategory').html(data);
               $('.sel_catagory_itm').html("");
               $('.sel_catagory_itm').html(data);
               // $('#product_data').html("");
           }
       });
   }
   
   $(document).on('click', '.selectsubcat', function () {
       var id = $('#cal_val').val();
       var name = $('#cat_val').val();
       select_subcategory(id, name);
   });
   
   function select_product_data(value, proname) {
   
       var type_id = value;
       $('#subcal_val').val(value);
       $('#subcat_val').val(proname);
   
       $.ajax({
   
           url: '<?php echo base_url() . 'sell/select_product_data'; ?>',
           data: {
               type_id: type_id,
               url: '<?php echo base_url() . 'sell/select_product_data'; ?>',
           },
           success: function (data) {
   
               var sethtml = "<span class='selectsubcat'>" + proname + "</span>";
               $('#sel_cat').append('/' + sethtml);
               // $('#product_data').html(data);
               $('.sel_catagory_itm').html(data);
               $('#type_array').html("");
           }
       });
   }
   
   function select_product_variant(value, provname) {
   
       var type_id = value;
   
       $.ajax({
   
           url: '<?php echo base_url() . 'sell/select_product_variant'; ?>',
           data: {
               type_id: type_id,
               url: '<?php echo base_url() . 'sell/select_product_variant'; ?>',
           },
           success: function (data) {
   
               if (provname == 0) {
                   $('#sel_cat').html("Product variants");
   
               } else {
                   $('#sel_cat').append('/' + provname);
               }
               $('.sel_catagory_itm').html(data);
               // $('#type_array').html(data);
           }
       });
   }
   
   
   /* Add product on change */
   function select_product(value) {
       $('.overlay').css('display', 'block');
       var customer_id = $('#customer_id').val();
       var variant_id = value;
   
       $.ajax({
   
           url: '<?php echo base_url() . 'sell/check_quantity'; ?>',
           type: "post",
           data: {
               product_w_id: variant_id,
               customer_id: customer_id,
               url: '<?php echo base_url() . 'sell/check_quantity'; ?>',
           },
           success: function (data) {
   
   
               $('.sel_catagory_itm').css('display', '');
               $('.sell_four_box').css('display', '');
               var loop = 0;
               if (data == 0) {
                   $('.overlay').css('display', 'none');
                   bootbox.alert("Product is not available", function () {
                   });
   
                   return false;
               } else {
   
                   $('.overlay').css('display', 'block');
   
                   $('.showid_qnt').each(function () {
   
                       var abc = $(this);
                       var price = $(this).attr('data-price');
                       var baseprice = parseFloat(price);
                       var id = $(this).attr('data-val');
                       var qnt = $(this).val();
                       qnt = parseInt(qnt);
                       if (id == value) {
                           loop++;
                           qnt = qnt + 1;
                           $(this).val(qnt);
                           price = baseprice * qnt;
                           var dt_price = baseprice * qnt;

                           $(this).parent().next().next().next().find('.event_rupee').html(price);

                           var subtotal = $('#subtotal').html();
                           subtotal = parseFloat(subtotal);
                           var total = $('#total').html();
                           total = parseFloat(total);
                           var total_pay = $('#total_pay').html();
                           total_pay = parseFloat(total_pay);
                           subtotal = subtotal + baseprice;
                           total = total + baseprice;
                           total_pay = total_pay + baseprice;
   
   
                           // // $('#subtotal').html(subtotal);
                           // $('#total').html(total);
                           // $('#total_pay').html(total_pay);
                           //
                           // // $("#hidden_subtotal").val(parseFloat(subtotal).toFixed(2));
                           //
                           // $("#hidden_total").val(parseFloat(total).toFixed(2));
                           // $("#hidden_total_pay").val(parseFloat(total_pay).toFixed(2));
                           // $("#paypal_amount").val(parseFloat().toFixed(2));
   
   
   
   
   
                           var sum = 0;
                           $('.event_rupee').each(function () {
                               sum += +$(this).text() || 0;
                           });
   
                           $("#subtotal").text(parseFloat(sum).toFixed(2));
                           $("#hidden_subtotal").val(parseFloat(sum).toFixed(2));
   
                           var subtotal = $("#subtotal").text();
                           var disc_percentage = $("#disc_percentage").val();
   
                           if (disc_percentage == '' && disc_percentage == null) {
                               var disc_percentage_new = $("#disc_percentage").val('00.00');
                           } else {
                               var disc_percentage_new = $("#disc_percentage").val();
                           }
   
                           var per_result = ((subtotal * disc_percentage_new) / 100);
                           var result = (subtotal - parseFloat(per_result).toFixed(2));
   
                           $("#discount_total").text(parseFloat(per_result).toFixed(2));
                           $("#total").text(parseFloat(result).toFixed(2));
                           $("#total_pay").text(parseFloat(result).toFixed(2));
   
                           $("#hidden_total").val(parseFloat(result).toFixed(2));
                           $("#hidden_total_pay").val(parseFloat(result).toFixed(2));
                           $("#paypal_amount").val(parseFloat(result).toFixed(2));
   
   
   
   
   
   
   
   
   
   
   
                           var customer_id = $('#customer_id').val();
                           var variant_id = value;
   
                           if (table == "park") {
   
                               var park_order_id = "<?php echo $parked_order_id; ?>";
   
                               $.ajax({
                                   url: '<?php echo base_url() . 'sell/update_same_product/'; ?>',
                                   type: 'post',
                                   data: {
                                       variant_id: variant_id,
                                       customer_id: customer_id,
                                       order_id: park_order_id,
                                       qnt: qnt,
                                       dt_price: price,
                                   },
                                   success: function (data) {
   
                                       var dis = data;
                                       dis = parseInt(dis);
                                       abc.parent().next().find('.disc').val(dis);
   
   
                                       $('.overlay').css('display', 'none');
   
                                   }
                               });
                           }
                               else
                               {
   
                                   $.ajax({
   
                                       url: '<?php echo base_url() . 'sell/update_temp_order'; ?>',
                                       type: "post",
                                       data: {
                                           variant_id: variant_id,
                                           customer_id: customer_id,
                                           qnt: qnt,
                                           dt_price: price,
                                       },
                                       success: function (data) {
   
                                           $('.overlay').css('display', 'none');
   
                                       }
                                   });
                               }
                       }
                   });
                   if (loop == 0) {
   
                       $('#product_search').val('');
                       $('#search_result').empty();
   
                       var product_id = value;
                       // alert(product_id);
                       var customer_id = $('#customer_id').val();
   
                       $.ajax({
   
                           url: '<?php echo base_url() . 'sell/temp_order'; ?>',
                           type: "post",
                           data: {
                               product_w_id: product_id,
                               customer_id: customer_id,
                               url: '<?php echo base_url() . 'sell/temp_order'; ?>',
                           },
                           success: function (data) {
   
                               $('.sel_catagory_itm').css('display', '');
                               $('.sell_four_box').css('display', '');
   
                               if (data == 0) {
   
                                   bootbox.alert("Product is not available", function () {
                                       // window.location.reload(true);
                                   });
   
                                   return false;
                               } else {
   
                                   $('#temp_product_list').append(data);
   
                                   $('#sel_catagory_itm').css('display', '');
                                   $('#sell_four_box').css('display', '');
   
                                   var sum = 0;
                                   $('.event_rupee').each(function () {
                                       sum += +$(this).text() || 0;
                                   });
   
                                   $("#subtotal").text(parseFloat(sum).toFixed(2));
                                   $("#hidden_subtotal").val(parseFloat(sum).toFixed(2));
   
                                   var subtotal = $("#subtotal").text();
                                   var disc_percentage = $("#disc_percentage").val();
   
                                   if (disc_percentage == '' && disc_percentage == null) {
                                       var disc_percentage_new = $("#disc_percentage").val('00.00');
                                   } else {
                                       var disc_percentage_new = $("#disc_percentage").val();
                                   }
   
                                   var per_result = ((subtotal * disc_percentage_new) / 100);
                                   var result = (subtotal - parseFloat(per_result).toFixed(2));
   
                                   $("#discount_total").text(parseFloat(per_result).toFixed(2));
                                   $("#total").text(parseFloat(result).toFixed(2));
                                   $("#total_pay").text(parseFloat(result).toFixed(2));
   
                                   $("#hidden_total").val(parseFloat(result).toFixed(2));
                                   $("#hidden_total_pay").val(parseFloat(result).toFixed(2));
                                   $("#paypal_amount").val(parseFloat(result).toFixed(2));
   
                                   if (parseFloat(result) <= 0) {
                                       $('#span_pay').attr('style', 'display:none');
                                       $('.park_btn').attr('style', 'display:none');
                                       $('.discard_btn').attr('style', 'display:none');
                                       $('.overlay').css('display', 'none');
                                   } else {
                                       $('#span_pay').attr('style', 'display:block');
                                       $('.park_btn').attr('style', 'display:block');
                                       $('.discard_btn').attr('style', 'display:block');
                                       $('.overlay').css('display', 'none');
                                   }
                               }
                           }
                       });
                   }
   
               }
           }
       })
   }
   
   /*Delete Temp Products*/
   function delete_tmp_order(value, true_product_id) {
   
       var temp_product_price = $('.tmp_price' + value).text();
   
       var product_id = value;
       var true_product_id = true_product_id;
   
       var pro_temp_qnt = $('#qnt' + value).val();
   
       var subtotal = $("#subtotal").text();
       var disc_percentage = $("#disc_percentage").val();
       var discount_total = $("#discount_total").text();
       var total = $("#total").text();
   
       if (temp_product_price) {
           $.ajax({
   
               url: '<?php echo base_url() . 'sell/delete_tmp_order/'; ?>',
               data: {
                   type: 'post',
                   product_id: product_id,
                   subtotal: subtotal,
                   disc_percentage: disc_percentage,
                   discount_total: discount_total,
                   total: total,
                   true_product_id: true_product_id,
                   pro_temp_qnt: pro_temp_qnt,
               },
               success: function (data) {
   
                   var json = JSON.parse(data);
   
                   var new_subtotal = subtotal - temp_product_price;
                   var new_discount_total = (new_subtotal * disc_percentage) / 100;
                   var new_total = new_subtotal - new_discount_total;
   
                   $("#subtotal").text(parseFloat(new_subtotal).toFixed(2));
                   $("#total").text(parseFloat(new_total).toFixed(2));
                   $("#total_pay").text(parseFloat(new_total).toFixed(2));
                   $("#discount_total").text(parseFloat(new_discount_total).toFixed(2));
   
                   $("#hidden_subtotal").val(parseFloat(new_subtotal).toFixed(2));
                   $("#hidden_total").val(parseFloat(new_total).toFixed(2));
                   $("#hidden_total_pay").val(parseFloat(new_total).toFixed(2));
                   $("#paypal_amount").val(parseFloat(new_total).toFixed(2));
   
                   $('.add_event_list .temp_product_list' + value).remove();
                   $(".temp_product_list" + product_id).load(location.href + " .temp_product_list");
   
                   if (parseFloat(new_total) <= 0) {
                       $('#span_pay').attr('style', 'display:none');
                       $('.park_btn').attr('style', 'display:none');
                       $('.discard_btn').attr('style', 'display:none');
                   } else {
                       $('#span_pay').attr('style', 'display:block');
                       $('.park_btn').attr('style', 'display:block');
                       $('.discard_btn').attr('style', 'display:block');
                   }
               }
           });
       }
   }
   
   function delete_parked_order(value, true_product_id) {
   
       var temp_product_price = $('.tmp_price' + value).text();
   
       var product_id = value;
       var true_product_id = true_product_id;
   
       var pro_temp_qnt = $('#qnt' + value).val();
   
       var subtotal = $("#subtotal").text();
       var disc_percentage = $("#disc_percentage").val();
       var discount_total = $("#discount_total").text();
       var total = $("#total").text();
   
       if (temp_product_price) {
           $.ajax({
   
               url: '<?php echo base_url() . 'sell/delete_parked_order/'; ?>',
               type:'post',
               data: {
                   product_id: product_id,
                   subtotal: subtotal,
                   disc_percentage: disc_percentage,
                   discount_total: discount_total,
                   total: total,
                   true_product_id: true_product_id,
                   pro_temp_qnt: pro_temp_qnt,
                   url: '<?php echo base_url() . 'sell/delete_parked_order/'; ?>',
               },
               success: function (data) {
   
                   var json = JSON.parse(data);
   
                   var new_subtotal = subtotal - temp_product_price;
                   var new_discount_total = (new_subtotal * disc_percentage) / 100;
                   var new_total = new_subtotal - new_discount_total;
   
                   $("#subtotal").text(parseFloat(new_subtotal).toFixed(2));
                   $("#total").text(parseFloat(new_total).toFixed(2));
                   $("#total_pay").text(parseFloat(new_total).toFixed(2));
                   $("#discount_total").text(parseFloat(new_discount_total).toFixed(2));
   
                   $("#hidden_subtotal").val(parseFloat(new_subtotal).toFixed(2));
                   $("#hidden_total").val(parseFloat(new_total).toFixed(2));
                   $("#hidden_total_pay").val(parseFloat(new_total).toFixed(2));
                   $("#paypal_amount").val(parseFloat(new_total).toFixed(2));
   
                   $('.add_event_list .temp_product_list' + value).remove();
                   $(".temp_product_list" + product_id).load(location.href + " .temp_product_list");
   
                   if (parseFloat(new_total) <= 0) {
                       $('#span_pay').attr('style', 'display:none');
                       $('.park_btn').attr('style', 'display:none');
                       $('.discard_btn').attr('style', 'display:none');
                   } else {
                       $('#span_pay').attr('style', 'display:block');
                       $('.park_btn').attr('style', 'display:block');
                       $('.discard_btn').attr('style', 'display:block');
                   }
               }
           });
       }
   }
   
   
   $('#customer_id').change(function () {
       setTimeout(function () {
           $('#product_search').trigger('focus');
       }, 300);
   });
   
   
</script>
<?php include('footer.php'); ?>