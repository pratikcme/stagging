<?php
   include('header.php');
   
   //echo $order_id;
   $vendor_id = $this->session->userdata('id');
   $parked_order_id = base64_decode($_GET['parkedId']);
   
   
   $cust_query = $this->db->query("SELECT * FROM customer WHERE status != '9' AND  vendor_id = '$vendor_id' ORDER BY id DESC ");
   $cust_row = $cust_query->result();
   
   /*$product_query = $this->db->query("SELECT * FROM product WHERE status != '9' AND user_id = '$user_id' ORDER BY id DESC  ");
   $product_row = $product_query->result();*/
   
   $user_query = $this->db->query("SELECT * FROM customer WHERE vendor_id = '$vendor_id'");
   $user_row = $user_query->result();
   
   $order_query = $this->db->query("SELECT o.*,total_price AS subtotal,calculation_price  AS total FROM `pos_order` as o WHERE o.id = '$parked_order_id'");
   $order_row = $order_query->row_array();

   $order_detail_query = $this->db->query("SELECT od.id, od.quantity, od.calculation_price as price, p.name as product_name, ot.id as order_temp_id FROM pos_order_detail as od
                                             LEFT JOIN order_temp as ot ON ot.id = od.product_id
                                             LEFT JOIN product_weight as pw ON pw.id = ot.Product_id  
                                             LEFT JOIN product as p ON p.id = pw.product_id    
                                             WHERE od.pos_order_id = '$parked_order_id'");
   $order_detail_row = $order_detail_query->result();
   
   
   $od_det_query = $this->db->query("SELECT id, order_temp_id as product_temp_id, product_id as product_id FROM pos_order_detail WHERE pos_order_id = '$parked_order_id'");
   $od_det_row = $od_det_query->result();
   
   // $product_box_query = $this->db->query("SELECT * FROM `product` WHERE status != '9' AND vendor_id='$vendor_id' order BY final_price DESC LIMIT 4");
   // $product_box_row = $product_box_query->result();
   
   $register_query = $this->db->query("SELECT * FROM `register` WHERE vendor_id = '$vendor_id' GROUP BY id DESC LIMIT 1");
   $register_result = $register_query-> result();
   
   $query_type = $this->db->query("SELECT * FROM category WHERE status != '9'  AND vendor_id = '$vendor_id' ORDER BY id DESC ");
   $result_type = $query_type->result();


$query_category = $this->db->query("SELECT * FROM category WHERE status != '9'  AND vendor_id = '$vendor_id' ORDER BY id DESC ");
$category = $query_category->result();
   ?>
<style>
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
   border-radius: 5px;
   border-top: 5px solid;
   box-shadow: 0 2px 1px hsl(5, 100%, 69%);
   float: left;
   margin-bottom: 20px;
   margin-right: 1%;
   width: 14%;
   }
   .catg_list a {
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
   border-radius: 5px;
   border-top: 5px solid;
   box-shadow: 0 2px 1px hsl(5, 100%, 69%);
   float: left;
   margin-bottom: 20px;
   margin-right: 1%;
   width: 142px;
   }
   .subcatg_list a {
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
</style>
<section id="main-content">
   <section class="wrapper site-min-height">
      <div id="msg">
         <?php if($this->session->flashdata('msg') && $this->session->flashdata('msg') != ''){ ?>
         <div class="alert alert-success fade in">
            <strong>Success!</strong> <?php echo $this->session->flashdata('msg');; ?>
         </div>
         <?php } unset($this->session->flashdata); ?>
      </div>
      <div class="row">
         <form method="post" action="<?php echo base_url().'index.php/parked_sell/order_checkout/'; ?>" id="paypal_form" class="paypal">
            <input type="hidden" name="old_order_id" id="old_order_id" value="<?php echo $parked_order_id; ?>">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="hidden_subtotal" id="hidden_subtotal" value="<?php echo $order_row['subtotal']; ?>">
            <input type="hidden" name="hidden_discount_total" id="hidden_discount_total" value="<?php echo $order_row['total_discount']; ?>">
            <input type="hidden" name="hidden_total" id="hidden_total" value="<?php echo $order_row['total']; ?>">
            <input type="hidden" name="hidden_total_pay" id="hidden_total_pay" value="<?php echo $order_row['total']; ?>">
            <input type="hidden" name="paypal_amount" id="paypal_amount" value="<?php echo $order_row['total']; ?>">
            <input type="hidden" name="cmd" value="_xclick" />
            <input type="hidden" name="no_note" value="1" />
            <input type="hidden" name="lc" value="UK" />
            <input type="hidden" name="currency_code" value="USD" />
            <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
            <input type="hidden" name="user_name" value="<?php echo $user_row[0]->name; ?>"  />
            <input type="hidden" name="first_name" value="<?php echo $user_row[0]->name; ?>"  />
            <input type="hidden" name="payer_email" value="<?php echo $user_row[0]->email; ?>"  />
            <input type="hidden" name="register_id" value="<?php if(!empty($register_result)){ echo $register_result[0]->id; } ?>" />
            <div class="col-lg-12">
               <section class="panel">
                  <header class="panel-heading">Parked Sell</header>
                  <p class="sub_title"></p>
                  <?php if(!empty($register_result)){ ?>
                  <?php if($register_result[0]->type == '1'){ ?>
                  <div class="panel-body">
                     <div class="">
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                           <div class="customer">
                              <div class="form-group">
                                 <label for="name">Select Customers</label>
                                 <select class="form-control" name="customer" id="customer_id">
                                    <option selected value="0">-----Select Customer-----</option>
                                    <?php foreach ($cust_row as $customer) { ?>
                                    <option value="<?php echo $customer->id; ?>" <?php if($customer->id == $cust_order[0]->id){ ?> selected <?php } ?>> <?php echo $customer->customer_name; ?> </option>
                                    <?php } ?>
                                 </select>
                              </div>
                           </div>
                           <!--<div class="customer">
                              <div class="form-group">
                                  <label for="name">Select Product</label>
                                  <select class="form-control" name="product_type" id="select_product">
                                      <option selected disabled value="">-----Select Product-----</option>
                                      <?php /*foreach ($product_row as $product) { */?>
                                          <option value="<?php /*echo $product->id; */?>"> <?php /*echo $product->name; */?> </option>
                                      <?php /*} */?>
                                  </select>
                              </div>
                              </div>-->
                           <div class="customer">
                              <div class="form-group">
                                 <label for="name">Search Product</label>
                                 <input type="text" class="form-control" name="product_search" id="product_search">
                                 <div id="search_result"></div>
                              </div>
                           </div>
                           <div class="customer">
                              <div class="form-group">
                                 <label for="name" class="product_header">Category</label>
                              </div>
                           </div>
                           <div class="sel_catagory_itm">
                              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no_padd click_box">
                                 <?php foreach ($category as $type) { ?>
                                 <div class="catg_list" id="catg_list"
                                    onclick="return select_subcategory('<?php echo $type->id; ?>');">
                                    <a href="javascript:;"><span><?php echo $type->name; ?></span></a>
                                 </div>
                                 <?php } ?>
                              </div>
                           </div>
                           <div class="customer">
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
                           </div>
                           <div id="type_array"></div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                           <div class="check_out">
                              <div class="col-md-5 col-lg-5 col-sm-5 col-xs-12 padd_lft_0">
                                 <div class="check_items">
                                    <h4 class="items_count">Checkout</h4>
                                    <span></span>
                                 </div>
                              </div>
                              <div class="col-md-7 col-lg-7 col-sm-7 col-xs-12">
                                 <div class="park_btn">
                                    <!--<a class="park_sell" href="#">Park sale</a>-->
                                 </div>
                                 <div class="discard_btn">
                                    <!--<a class="discard_sell" href="<?php /*echo base_url().'index.php/parked_sell/index' */?>">Discard sale</a>-->
                                 </div>
                              </div>
                              <div class="brder">
                                 <div class="create_cutomer">
                                    <a href="<?php echo base_url().'index.php/customer/customer1'; ?>">Create New Customer</a>
                                 </div>
                                 <div class="add_event_list">
                                    <ul id="temp_product_list_append">
                                    </ul>
                                    <?php
                                       foreach($od_det_row as $order_detail){
                                       
                                           $product_id = $order_detail->product_id;
                                           $od_temp_id = $order_detail->product_temp_id;
                                           $od_temp_row = $this->db->query(
                                            "SELECT ot.*, p.name, pw.discount_price as final_price 
                                            FROM order_temp as ot 
                                            LEFT JOIN product_weight as pw ON pw.id = ot.Product_id 
                                            LEFT JOIN product as p ON p.id = pw.product_id 
                                            WHERE ot.id = '$od_temp_id' AND ot.park = '1'");
                                           $od_temp_query = $od_temp_row->row_array();
                                        // echo $this->db->last_query();
                                           // $product_query = $this->db->query("SELECT markup, discount_allow FROM product WHERE id = '$product_id'");
                                           // $product_result = $product_query->row_array();
                                       
                                           // $product_discount = $product_result['markup'];
                                           $product_discount_allow = '1';
                                           ?>
                                    <ul id="temp_product_list" class="temp_product_list<?php echo $od_temp_query['id']; ?>">
                                       <li>
                                          <h5 class="event_name"><?php echo $od_temp_query['name']; ?></h5>
                                          <p class="event_quantity">
                                             <input type="text" class="showid_qnt" name="qnt<?php echo $od_temp_query['id']; ?>" id="qnt<?php echo $od_temp_query['id']; ?>" value="<?php echo $od_temp_query['quantity']; ?>" onkeyup="showId('<?php echo $od_temp_query['id']; ?>', '<?php echo $od_temp_query['final_price']; ?>', '<?php echo $od_temp_query['id']; ?>')" onchange="change_qty('<?php echo $od_temp_query['id']; ?>', '<?php echo $od_temp_query['final_price']; ?>', '<?php echo $od_temp_query['id']; ?>')"/>
                                             <script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
                                             <script type="text/javascript">
                                                var change_temp = "";
                                                $('#qnt'+<?php echo $temp->id; ?>).bind('keydown',function(e){
                                                
                                                    var id = <?php echo $temp->id; ?>;
                                                    var qnt_val = $("#qnt"+id).val();
                                                
                                                    if(qnt_val == '0' || qnt_val == ''){
                                                        var qty = '1';
                                                        $("#qnt"+id).val(qty);
                                                
                                                        var final_price = qty * price; //final price
                                                        $(".tmp_price"+id).html(parseFloat(final_price).toFixed(2));
                                                    }
                                                
                                                });
                                             </script>
                                          </p>
                                          <p class="event_quantity">
                                             <input type="text" name="discount<?php echo $od_temp_query['id']; ?>" id="discount<?php echo $od_temp_query['id']; ?>" value="<?php echo $od_temp_query['discount']; ?>" onkeyup="discount_temp_order('<?php echo $od_temp_query['id']; ?>', '<?php echo $od_temp_query['final_price']; ?>', '<?php echo $od_temp_query['id']; ?>', '<?php echo $product_discount; ?>', '<?php echo $product_discount_allow; ?>')"/>
                                          </p>
                                          <a href="javascript:;" onclick="delete_tmp_order('<?php echo $od_temp_query['id']; ?>', '<?php echo $product_id; ?>')" class="event_del"><i class="fa fa-trash-o "></i></a>
                                          <div class="ruppers_txt">
                                             <span>$</span>
                                             <div class="event_rupee tmp_price<?php echo $od_temp_query['id']; ?>"><?php echo $od_temp_query['price']; ?></div>
                                          </div>
                                       </li>
                                       <div style="margin:0 0 0 183px; color: red; display: none;" id="discount_message<?php echo $od_temp_query['id']; ?>">
                                          Discount is not more than product buy discount
                                       </div>
                                    </ul>
                                    <?php } ?>
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
                                                $<span id="subtotal"><?php echo $order_row['subtotal']; ?></span>
                                             </div>
                                          </div>
                                       </li>
                                       <li>
                                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                             <div class="add_total">
                                                <p>Discountdiscount_total</p>
                                             </div>
                                          </div>
                                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                             <div class="add_total_digit">
                                                <div class="add_percent">
                                                   <!--<input type="text" name="" placeholder="$." id="disc_rs" value="">-->
                                                </div>
                                                <div class="add_rupees"><input type="text" name="disc_percentage" placeholder="%" onkeyup="calculate_percentage();" id="disc_percentage" value="<?php echo $order_row['total_discount']; ?>"></div>
                                                 $<span id="discount_total"><?php echo $tot = $order_row['subtotal'] * $order_row['total_discount'] / 100; ?> </span>
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
                                                $<span id="total"><?php echo $order_row['total']; ?></span>
                                             </div>
                                          </div>
                                       </li>
                                       <div class="payment_btn">
                                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 no_padd pull-right">
                                             <div class="final_btn_pay">
                                                <!--<a href="#myModal" data-toggle="modal" id="span_pay" onclick="check_selected()"><span class="final_rs_pay">Pay</span>-->
                                                <a href="#myModal" data-toggle="modal" id="span_pay" onclick="">
                                                   <span class="final_rs_pay">Pay</span>
                                                   <span class="rs_cs_totl">
                                                      $
                                                      <p id="total_pay"><?php echo $order_row['total']; ?></p>
                                                   </span>
                                                </a>
                                             </div>
                                          </div>
                                          <!-- Add Brand : Modal -->
                                          <div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                             <div class="modal-dialog">
                                                <div class="modal-content" id="modal_div_id">
                                                   <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                      <h4 class="modal-title">Pay</h4>
                                                   </div>
                                                   <!--<div class="modal-body">
                                                      <div class="form-group">
                                                          <label for="email">Email</label>
                                                          <input type="email" name="rec_email" class="form-control" value="" placeholder="Email">
                                                      </div>
                                                      <div class="form-group">
                                                          <label for="description">Sale Note</label>
                                                          <textarea rows="4" cols="50" class="form-control" name="sale_note" placeholder="Type to add a sale note"></textarea>
                                                      </div>
                                                      </div>-->
                                                   <div class="modal-footer">
                                                      <input type="submit" class="btn btn-primary btn-lg" value="Cash" name="cash"/>
                                                      <input type="submit" class="btn btn-primary btn-lg" value="Credit Card" name="credit_card"/>
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
                  <?php } else {?>
                  <div>
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <div class="checkout_closed_register">
                           <img src="<?php echo  base_url().'public/images/sorry.png'?>" />
                           <h3>Register closed</h3>
                           <p>To make a sale, please open the register</p>
                           <button class="btn btn-warning" type="button" href="#myModal" data-toggle="modal">Open Register</button>
                        </div>
                     </div>
                  </div>
                  <?php } ?>
                  <?php } else { ?>
                  <div>
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <div class="checkout_closed_register">
                           <img src="<?php echo  base_url().'public/images/sorry.png'?>" />
                           <h3>Register closed</h3>
                           <p>To make a sale, please open the register</p>
                           <button class="btn btn-warning" type="button" href="#myModal" data-toggle="modal">Open Register</button>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Set opening cash drawer amount</h4>
         </div>
         <form method="post" action="<?php echo base_url() . 'index.php/register/opening_cash'; ?>">
            <div class="modal-body">
               <div class="form-group">
                  <label for="name">Cash Amount</label>
                  <input type="text" name="amount" class="form-control" value="" required>
               </div>
               <div class="form-group">
                  <label for="name">Type to add note</label>
                  <input type="text" name="note" class="form-control" value="">
               </div>
            </div>
            <div class="modal-footer">
               <input type="submit" class="btn btn-primary" value="Save Amount" name="save_amount"/>
            </div>
         </form>
      </div>
   </div>
</div>
<style>
   .ms-container {
   width: 98%;
   }
   .sel_catagory_itm{
   z-index: 2000;
   }
   .active_bg {
   background-color: #e8e8e8;
   }
   #search_result{
   z-index: 1;
   }
</style>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
   function check_selected() {
       var customer_id = $('#customer_id').val();
       if(customer_id == 0){
           $('#modal_div_id').css('display','none');
           bootbox.alert("Please select customer", function() {
               window.location.reload(true);
           });
       }else{
   
       }
   }
   
   $(".click_box  .catg_list").click(function() {
       $(this).addClass('active_bg').siblings().removeClass('active_bg');
   });
   
   setTimeout( function(){$('#msg').hide();} , 4000);
   
   /*Update Product Temp Qnt - On refresh page*/
   $(document).ready(function(){
       $.ajax({
           method: "post",
           url: '<?php echo site_url('parked_sell/update_same_as_qnt'); ?>',
           success: function() {}
       });
   });
   
   /*Search product from textbox*/
   $(document).ready(function () {
       $('#product_search').keyup(function () {
   
           $('.sell_four_box').css({'display' : 'none'});
           $('.sel_catagory_itm').css({'display' : 'none'});
   
           $('#search_result').css({'z-index' : '1'});
   
           var txt = $(this).val();
           if(txt == '' || txt == null){
   
               $('.sell_four_box').css({'display' : ''});
               $('.sel_catagory_itm').css({'display' : ''});
   
               /*$('.sell_four_box').css({'float' : 'left','width' : '100%', 'position' : 'unset', 'display' : 'block'});
                $('.sel_catagory_itm').css({'float' : 'left','width' : '100%', 'position' : 'unset', 'display' : 'block'});*/
               /*$('.sel_catagory_itm').css('margin', '0 0 0 0');
                $('.sell_four_box').css('margin', '0 0 0 0');*/
           }
           if (txt != '') {
               $.ajax({
                   method: "post",
                   url: '<?php echo site_url('parked_sell/ajax_search_product'); ?>',
                   data: {search: txt},
                   success: function (data) {
   
                       $('.sell_four_box').css({'display' : 'none'});
                       $('.sel_catagory_itm').css({'display' : 'none'});
   
                       /*$('.sel_catagory_itm').css('margin', '-136px 0 0 0');
                        $('.sell_four_box').css('margin', '-133px 0 0 0');*/
   
                       /*$('.sell_four_box').css({'display' : 'none'});
                        $('.sel_catagory_itm').css({'display' : 'none'});*/
   
                       $('#search_result').html(data);
                   }
               });
           }
           else {
               $('#search_result').html('');
           }
       });
   });
   
   /*Display alert, if not selected any product*/
   $('.park_sell').on('click',function () {
       var pro_select = $('#select_product').val();
       if(pro_select == null){
           alert('Please select product');
           return false;
       }
   });
   
   function change_qty(obj, price, tmp_price) {
   
       var id=obj; //product_id
       var qty_fetch = $("#qnt"+id).val(); //product quantity
   
       if(qty_fetch == '0' || qty_fetch == ''){
           var qty = '1';
           $("#qnt"+id).val(qty)
   
           var final_price = qty * price; //final price
           $(".tmp_price"+id).html(parseFloat(final_price).toFixed(2));
       }
   }
   
   /* On Change Quantity - Calculate price and sum of sub-total */
   function showId(obj, price, tmp_price) {
   
       var id=obj; //product_id
       var qty_fetch = $("#qnt"+id).val(); //product quantity
   
       if(qty_fetch == '0'){
           var qty = '1';
           $("#qnt"+id).val(qty);
   
           var final_price = qty * price; //final price
           $(".tmp_price"+id).html(parseFloat(final_price).toFixed(2));
       }else{
           var qty = $("#qnt"+id).val();
   
           var final_price = qty * price; //final price
           $(".tmp_price"+id).html(parseFloat(final_price).toFixed(2));
       }
   
       var final_price = qty * price; //final price
   
       $(".tmp_price"+id).html(parseFloat(final_price).toFixed(2));
   
       /*08-07-2016*/
       /*var discount = +$("#discount"+id).val(); //product discount
   
        var cal_price = ((parseFloat(final_price).toFixed(2) * parseFloat(discount).toFixed(2)) / 100);
        var new_final_price = (parseFloat(final_price).toFixed(2) - parseFloat(cal_price).toFixed(2));
   
        $(".tmp_price"+id).html(parseFloat(new_final_price).toFixed(2));*/
       /*08-07-2016*/
   
       var sum = 0;
       $('.event_rupee').each(function() {
           sum += +$(this).text()||0;
       });
   
       var qnt_sum = 0;
       $(".showid_qnt").each(function() {
           qnt_sum += parseFloat(this.value);
       });
   
       $("#subtotal").text(parseFloat(sum).toFixed(2));
       $("#total").text(parseFloat(sum).toFixed(2));
       $("#total_pay").text(parseFloat(sum).toFixed(2));
   
       $("#hidden_subtotal").val(parseFloat(sum).toFixed(2));
       $("#hidden_total").val(parseFloat(sum).toFixed(2));
       $("#hidden_total_pay").val(parseFloat(sum).toFixed(2));
       $("#paypal_amount").val(parseFloat(sum).toFixed(2));
   
       var sub_total = $("#subtotal").text();
       var disc_percentage = $("#disc_percentage").val();
       var discount_total = $("#discount_total").text();
       var total = $("#total").text();
   
       //On change update order tamp
       $.ajax({
           url: '<?php echo base_url().'index.php/parked_sell/update_order_temp/'; ?>',
           data: {
               product_id: id,
               quantity: qnt_sum,
               qty: qty,
               price: final_price,
               sub_total: sub_total,
               disc_percentage: disc_percentage,
               discount_total: discount_total,
               total: total,
               order_id: '<?php echo $order_id; ?>',
               url: '<?php echo base_url().'index.php/parked_sell/update_order_temp/'; ?>'
           },
           success: function (data) {
   
               if(data == 0){
                   $('#qnt'+id).val('1');
                   ajaxCall_update(obj, price, tmp_price);
                   /*alert('Not Exist');*/
                   return false;
               }
           }
       });
   }
   
   /*Inside showId function*/
   function ajaxCall_update(obj, price, tmp_price){
   
       var id=obj; //product_id
       var qty = '1'; //product quantity
       var final_price = qty * price; //final price
   
       $(".tmp_price"+id).html(parseFloat(final_price).toFixed(2));
   
       /*08-07-2016*/
       var discount = +$("#discount"+id).val(); //product discount
   
       var cal_price = ((parseFloat(final_price).toFixed(2) * parseFloat(discount).toFixed(2)) / 100);
       var new_final_price = (parseFloat(final_price).toFixed(2) - parseFloat(cal_price).toFixed(2));
   
       $(".tmp_price"+id).html(parseFloat(new_final_price).toFixed(2));
       /*08-07-2016*/
   
       var sum = 0;
       $('.event_rupee').each(function() {
           sum += +$(this).text()||0;
       });
   
       var qnt_sum = 0;
       $(".showid_qnt").each(function() {
           qnt_sum += parseFloat(this.value);
       });
   
       $("#subtotal").text(parseFloat(sum).toFixed(2));
       $("#total").text(parseFloat(sum).toFixed(2));
       $("#total_pay").text(parseFloat(sum).toFixed(2));
   
       $("#hidden_subtotal").val(parseFloat(sum).toFixed(2));
       $("#hidden_total").val(parseFloat(sum).toFixed(2));
       $("#hidden_total_pay").val(parseFloat(sum).toFixed(2));
       $("#paypal_amount").val(parseFloat(sum).toFixed(2));
   
       var sub_total = $("#subtotal").text();
       var disc_percentage = $("#disc_percentage").val();
       var discount_total = $("#discount_total").text();
       var total = $("#total").text();
   
       $.ajax({
           url: '<?php echo base_url().'index.php/parked_sell/update_order_temp/'; ?>',
           data: {
               product_id: id,
               quantity: qnt_sum,
               qty: qty,
               price: final_price,
               sub_total: sub_total,
               disc_percentage: disc_percentage,
               discount_total: discount_total,
               total: total,
               discount: discount,
               discount_price: cal_price,
               order_id: '<?php echo $order_id; ?>',
               url: '<?php echo base_url().'index.php/parked_sell/update_order_temp/'; ?>'
           },
           success: function (data) {
           }
       });
   }
   
   /* Onchange Discount Temp Order - Calculate price and sum of sub-total From Temp Product Discount */
   function discount_temp_order(obj, price, tmp_price, p_price, discount_pro, product_discount_allow) {
   
       var id=obj; //product_id
       var qty = +$("#qnt"+id).val(); //product quantity
       var final_price = qty * price; //final price
   
       $(".tmp_price"+id).html(parseFloat(final_price).toFixed(2));
   
       var discount = +$("#discount"+id).val(); //product discount
       var product_descount = discount_pro;
   
       if(product_discount_allow == '0')
       {
           if(discount > product_descount){
               $('#discount'+id).val('');
               $('#discount_message'+id).css('display', 'block');
   
               var discount = '0'; //product discount
               return false;
           }else{
   
               $('#discount_message'+id).css('display', 'none');
               var discount = +$("#discount"+id).val(); //product discount
   
               var cal_price = ((parseFloat(final_price).toFixed(2) * parseFloat(discount).toFixed(2)) / 100);
               var new_final_price = (parseFloat(final_price).toFixed(2) - parseFloat(cal_price).toFixed(2));
   
               $(".tmp_price"+id).html(parseFloat(new_final_price).toFixed(2));
   
               var sum = 0;
               $('.event_rupee').each(function() {
                   sum += +$(this).text()||0;
               });
   
               $("#subtotal").text(parseFloat(sum).toFixed(2));
               $("#total").text(parseFloat(sum).toFixed(2));
               $("#total_pay").text(parseFloat(sum).toFixed(2));
   
               $("#hidden_subtotal").val(parseFloat(sum).toFixed(2));
               $("#hidden_total").val(parseFloat(sum).toFixed(2));
               $("#hidden_total_pay").val(parseFloat(sum).toFixed(2));
               $("#paypal_amount").val(parseFloat(sum).toFixed(2));
   
               var sub_total = $("#subtotal").text();
               var disc_percentage = $("#disc_percentage").val();
   
               var new_disc_per = ((parseFloat(sub_total).toFixed(2) * parseFloat(disc_percentage).toFixed(2)) / 100);
               var new_discount_total = $('#discount_total').text(parseFloat(new_disc_per).toFixed(2));
   
               var total = $("#total").text();
   
               //On change update order tamp
               $.ajax({
                   url: '<?php echo base_url().'index.php/parked_sell/update_order_temp/'; ?>',
                   data: {
                       product_id: id,
                       quantity: qty,
                       price: new_final_price,
                       discount: discount,
                       discount_price: cal_price,
   
                       sub_total: sub_total,
                       disc_percentage: disc_percentage,
                       discount_total: new_discount_total,
                       total: total,
   
                       order_id: '<?php echo $order_id; ?>',
                       url: '<?php echo base_url().'index.php/parked_sell/update_order_temp/'; ?>' ,
                   },
                   success: function (data) {
                   }
               });
           }
       }
       else
       {
   
           $('#discount_message'+id).css('display', 'none');
   
           var cal_price1 = ((parseFloat(final_price).toFixed(2) * parseFloat(discount).toFixed(2)) / 100);
           var new_final_price1 = (parseFloat(final_price).toFixed(2) - parseFloat(cal_price1).toFixed(2));
   
           $(".tmp_price"+id).html(parseFloat(new_final_price1).toFixed(2));
   
           var sum = 0;
           $('.event_rupee').each(function() {
               sum += +$(this).text()||0;
           });
   
           $("#subtotal").text(parseFloat(sum).toFixed(2));
           $("#total").text(parseFloat(sum).toFixed(2));
           $("#total_pay").text(parseFloat(sum).toFixed(2));
   
           $("#hidden_subtotal").val(parseFloat(sum).toFixed(2));
           $("#hidden_total").val(parseFloat(sum).toFixed(2));
           $("#hidden_total_pay").val(parseFloat(sum).toFixed(2));
           $("#paypal_amount").val(parseFloat(sum).toFixed(2));
   
           var sub_total1 = $("#subtotal").text();
           var disc_percentage1 = $("#disc_percentage").val();
   
           var new_disc_per1 = ((parseFloat(sub_total1).toFixed(2) * parseFloat(disc_percentage1).toFixed(2)) / 100);
           var new_discount_total_pro = $('#discount_total').text(parseFloat(new_disc_per).toFixed(2));
           var new_discount_total1 = $('#discount_total').val();
   
           var total1 = $("#total").text();
   
           $.ajax({
               url: '<?php echo base_url().'index.php/sell/update_order_temp/'; ?>',
               data: {
                   product_id: id,
                   quantity: qty,
                   price: new_final_price1,
                   discount: discount,
                   discount_price: cal_price1,
                   sub_total: sub_total1,
                   disc_percentage: disc_percentage1,
                   discount_total: new_discount_total1,
                   total: total1,
                   order_id: '<?php echo $order_id; ?>',
   
                   url: '<?php echo base_url().'index.php/sell/update_order_temp/'; ?>'
               },
               success: function (data) {
               }
           });
   
           //On change update order tamp
           /*$.ajax({
               url: 'index.php/parked_sell/update_order_temp',
               data: {
                   product_id: id,
                   quantity: qty,
                   price: new_final_price,
                   discount: discount,
                   discount_price: cal_price,
   
                   sub_total: sub_total,
                   disc_percentage: disc_percentage,
                   discount_total: new_discount_total,
                   total: total,
   
                   order_id: ' echo $order_id;',
                   url: 'echo base_url().'index.php/parked_sell/update_order_temp/'; ?>' ,
               },
               success: function (data) {
               }
           });*/
       }
   }
   
   /* Calculate price and sum of sub-total */
   function calculate_percentage() {
   
       var percentage = +$('#disc_percentage').val();
       var sub_total = +$('#subtotal').text();
   
       var per_result = ((parseFloat(sub_total).toFixed(2) * parseFloat(percentage).toFixed(2)) / 100);
       var result = (parseFloat(sub_total).toFixed(2) - parseFloat(per_result).toFixed(2));
   
       $("#total").text(parseFloat(result).toFixed(2));
       $("#total_pay").text(parseFloat(result).toFixed(2));
       $("#discount_total").text(parseFloat(per_result).toFixed(2));
   
       $("#hidden_total").val(parseFloat(result).toFixed(2));
       $("#hidden_total_pay").val(parseFloat(result).toFixed(2));
       $("#hidden_discount_total").val(parseFloat(per_result).toFixed(2));
       $("#paypal_amount").val(parseFloat(result).toFixed(2));
   }
   
   
   
   function select_subcategory(value) {
       var customer_id = $('#customer_id').val();
       if(customer_id == ""){
           bootbox.alert("Please select custmer", function () {
               $('#customer_id').focus();
           });
           return false;
       }
       var type_id = value;
       $.ajax({
   
           url: '<?php echo base_url() . 'sell/select_subcategory'; ?>',
           // type:'post',
           data: {
               type_id: type_id,
               url: '<?php echo base_url() . 'sell/select_subcategory'; ?>',
           },
           success: function (data) {
               $('#subcategory').html(data);
               $('#product_data').html("");
           }
       });
   }
   
   function select_product_data(value) {
   
       var type_id = value;
   
       $.ajax({
   
           url: '<?php echo base_url() . 'sell/select_product_data'; ?>',
           data: {
               type_id: type_id,
               url: '<?php echo base_url() . 'sell/select_product_data'; ?>',
           },
           success: function (data) {
               $('#product_data').html(data);
               $('#type_array').html("");
           }
       });
   }
   function select_product_variant(value) {
   
       var type_id = value;
   
       $.ajax({
   
           url: '<?php echo base_url() . 'sell/select_product_variant'; ?>',
           data: {
               type_id: type_id,
               url: '<?php echo base_url() . 'sell/select_product_variant'; ?>',
           },
           success: function (data) {
               $('#type_array').html(data);
           }
       });
   }
   
   
   
   
   /* Add product on change */
   /*$('#select_product').on('change', function() {*/
   function select_product(value) {
   
       // $('#temp_product_list').css('display', '');
       $('#product_search').val('');
   
       $('#search_result').empty();
   
       var product_id = value;
       // alert(product_id);
       var customer_id = $('#customer_id').val();
       if(customer_id == ""){
           bootbox.alert("Please select custmer", function () {
               $('#customer_id').focus();
           });
           return false;
       }
   
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
                   } else {
                       $('#span_pay').attr('style', 'display:block');
                       $('.park_btn').attr('style', 'display:block');
                       $('.discard_btn').attr('style', 'display:block');
                   }
               }
           }
       });
   }
   
   function add_product_update(old_order_id, subtotal, disc_percentage_new, per_result, result){
   
       $.ajax({
           url: '<?php echo base_url().'index.php/parked_sell/add_product_update/'; ?>',
           data: {
   
               old_order_id: old_order_id,
               subtotal: subtotal,
               disc_percentage_new: disc_percentage_new,
               per_result: per_result,
               result: result,
   
               url: '<?php echo base_url().'index.php/parked_sell/add_product_update/'; ?>'
           },
           success: function (data) {
           }
       });
   }
   
   /*Delete Temp Products*/
   function delete_tmp_order(value, true_product_id) {
   
   
       var order_temp_id = value;
       var tmp_price =  $(".tmp_price"+order_temp_id).text();
   
       var true_product_id = true_product_id;
       var pro_temp_qnt = $('#qnt'+value).val();
   
       var subtotal =  $("#subtotal").text();
       var disc_percentage = $("#disc_percentage").val();
       var discount_total = $("#discount_total").text();
       var total = $("#total").text();
   
       if(tmp_price){
           $.ajax({
   
               url: '<?php echo base_url().'index.php/parked_sell/delete_tmp_order/'; ?>',
               data: {
                   order_temp_id: order_temp_id,
                   subtotal: subtotal,
                   disc_percentage: disc_percentage,
                   discount_total: discount_total,
                   total: total,
                   tmp_price: tmp_price,
                   true_product_id: true_product_id,
                   pro_temp_qnt: pro_temp_qnt,
                   url: '<?php echo base_url().'index.php/parked_sell/delete_tmp_order/'; ?>'
               },
               success: function(data){
   
                   var json = JSON.parse(data);
                   var new_subtotal = subtotal - tmp_price;
                   var new_discount_total = (new_subtotal * disc_percentage) / 100;
                   var new_total = new_subtotal - new_discount_total;
   
                   if(new_total == 0){
                       $('.final_btn_pay').hide();
                   }
   
                   $("#subtotal").text(parseFloat(new_subtotal).toFixed(2));
                   $("#total").text(parseFloat(new_total).toFixed(2));
   
   
   
                   $("#total_pay").text(parseFloat(new_total).toFixed(2));
                   $("#discount_total").text(parseFloat(new_discount_total).toFixed(2));
   
   
   
                   $("#hidden_subtotal").val(parseFloat(new_subtotal).toFixed(2));
                   $("#hidden_total").val(parseFloat(new_total).toFixed(2));
                   $("#hidden_total_pay").val(parseFloat(new_total).toFixed(2));
                   $("#paypal_amount").val(parseFloat(new_total).toFixed(2));
   
   
   
                   $('.add_event_list .temp_product_list'+value).remove();
                   $(".temp_product_list" + order_temp_id).load(location.href + " .temp_product_list");
                   //$(".temp_product_list" + order_temp_id).css('display', 'none');
               }
           });
       }
   }
   
   function select_type_product (value) {
   
       var type_id = value;
       $.ajax({
   
           url: '<?php echo base_url() . 'index.php/sell/select_type_product/'; ?>',
           data: {
               type_id: type_id,
               url: '<?php echo base_url() . 'index.php/sell/select_type_product/'; ?>'
           },
           success: function (data) {
               $('#type_array').html(data);
           }
       });
   }
   
</script>
<?php include('footer.php'); ?>