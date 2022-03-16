<?php
   include('header.php');
   //echo '1';die;
   // print_r($order_row);die;
   $vendor_id = $this->session->userdata('id');
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
    body{
        font-family: 'Roboto', sans-serif;
    }
    .quick-view {
        position: relative;
        width: 23%;
        margin: 0 5px;
        background:#fff;
    }
    .quick-view .remove_quick_list_item{
        position: absolute;
        right: 2px;
        top: 7px;
        z-index: 2;
        color: red;
        cursor: pointer;
    }
    .quick-view .remove_quick_list_item i {
        color:red !important;
    }
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
   background: #fff;
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
   .items_count {
   float: left;
   width: 100%;
   font-weight: 600;
   margin-right: 1%;
   margin-top: 0;
   color: #5b6e84;
   padding: 10px;
    border-radius: 5px;
    transition: 0.3s;
    text-transform: capitalize;
    background: transparent;
    font-size: 16px;
    text-align: center;
   }

   .items_count:hover {
    background: #5b6e84;
    color: #fff;
   }
   .items_count i {
    color: #5b6e84;
   }

   .items_count:hover i {
       color: #fff;
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
   background: #fff;
   border-radius: 5px;
   }
   .create_cutomer a {
   float: left;
   width: 100%;
   }
   .create_cutomer {
   float: left;
   width: 100%;
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
    color: #000000;
    float: left;
    width: 100%;
    font-weight: 600;
    font-size: 15px;
    margin-bottom: 0;
   }
   .add_total_digit {
    color: #000000;
   float: left;
   width: 100%;
   text-align: right;
   font-weight: 600;
    font-size: 15px;
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
   .payment_btn >div{
    padding-right:10px;
   }
   .final_btn_pay > a {
   background: #5b6e84 none repeat scroll 0 0;
   float: left;
   padding: 10px;
   width: 100%;
   border-radius: 3px;
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
   font-size: 18px;
    font-weight: 600;
   }
   .final_btn_pay span p {
   color: white;
   float: right;
   width: auto;
   margin: 0;
    font-size: 18px;
    font-weight: 600;
    margin-left:5px;

   }
   .note_of_sale li:nth-child(4) {
   border-top: 1px solid #ccc;
   margin-top: 2px;
   padding-top: 5px;
    
}
   .note_of_sale li {
   float: left;
   margin-bottom: 1%;
   width: 100%;
   border-bottom: 1px solid #e7e7e7;
   padding: 10px 0px;
   }
   .note_of_sale li:last-child{
       border-bottom: transparent !important;
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
   margin-right: 15%;
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



/* dropdown */
   
.dropbtn {
  font-size: 16px;
  cursor: pointer;
}

/* .dropbtn:hover, .dropbtn:focus {
  background-color: #2980B9;
} */

.dropdown {
  position: relative;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #fff;
  width: 320%;
  overflow: auto;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  top: 43px;
  border-radius: 5px;
  padding: 5px 20px;
  overflow-y: auto;
    padding: 5px 20px;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}

.after-pay button {
    width: 32%;
    color: #fff;
    background-color: #5b6e84;
    padding: 10px;
    text-transform: capitalize;
    font-weight: bold;
    display: none;
}

/* 
product-list-container
*/

.product-list-container {
    width: 100%;
    height: 230px;
    overflow-y: auto;
}

.product-list-wrapper {
    width: 100%;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-bottom: 10px;
    padding: 5px;
    border-bottom:1px solid #e7e5e8;

}

.product-list-wrapper > div {
    width: 43%;
}

.product-list-wrapper h5 {
    margin: 3px 0;
    font-weight: 600;
}

.product-list-wrapper h5:nth-child(1) {
    font-size: 16px;
    color: #000;
}

.product-quantity-detail label {
    color: #000000;
    text-transform: capitalize;
    font-size: 14px;
}
.product-quantity-detail label span .fa{
    color: #000000;
}

.popover-list-item{
    cursor: pointer;
}
.popover-list-item a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 15px;
    background: #efefef;
    border-radius: 5px;
}

.popover-list-item .remove-close .fa-times {
    color: #5b6e84;
}

.dropdown-content ul li:nth-child(2) {
    background-color: #f3f3f3;
}

.dropdown-content ul li {
    border-bottom: 1px solid #f1f2f7;
    margin-bottom: 10px;
    border-radius: 5px;
}

.dropdown-content ul li h5 {
    color: #000;
    font-size: 18px;
    font-weight: 600;
}

.popover-list-item i {
    color: #5b6e84;
} 

.popover-list-item a .list-items h4,
.popover-list-item a .list-items p {
    margin: 0;
}

.product-quantity-detail input {
    cursor: text;
    color: var(--vd-colour--text);
    font-family: lato,Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;
    font-weight: 400;
    font-size: 15px;
    word-break: normal;
    width: 100%;
    margin: 0;
    padding: 5px 10px;
    box-sizing: border-box;
    outline: none;
    box-shadow: none;
    background-color: #fff;
    border: 2px solid #e7e5e8;
    border-radius: 4px;
    transition: all .2s;
    text-align: right;
    transition-property: border-color,box-shadow;
}

.product-list-wrapper .fa.fa-trash {
    color: #5b6e84;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    transition: 0.3s;
    font-size: 18px;
    color: #dc3545;
    margin-left: 10px;
}

.product-list-wrapper .fa.fa-trash:hover {
    background-color: #5b6e84;
    color: #fff;
}

.product-quantity-detail-wrapper .product-quantity-detail {
    width: 32%;
    margin: 0 5px;
}
.total-wrapper{
    display: flex;
    align-items: center;
    justify-content: flex-end;
    position: relative;
    top: 10px;
    margin-left: 10px;
}

.product_name {
    position: relative;
    top: 10px;
}

.fa-times{
    color: #797979;
}

input.form-control {
    padding: 20px 10px;
}

#message {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-top: 10px;
    position: absolute;
    width: 92%;
    height: auto;
    background: #fff;
    z-index: 2;
    display: none;
    box-shadow:0px 8px 16px 0px rgb(0 0 0 / 20%);
}

#message > a {
    display: inline-block;
    margin-top: 10px;
    text-align: left;
}

#message > a i {
    color: #000;
}

#prod-list {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-top: 10px;
    position: absolute;
    width: 97%;
    height: auto;
    background: #fff;
    z-index: 2;
    display: none;
    box-shadow:0px 8px 16px 0px rgb(0 0 0 / 20%);
}
#prod-list ul {
    margin-bottom:0px;
}
#prod-list .popover-list-item:last-child .product-list-wrapper{
    border-bottom:0px;
    margin-bottom:0px;
    cursor: pointer;
}
.profile-avatar {
    width: 40px;
    height: 40px;
    background: #5b6e84;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    color: #fff;
    font-weight: 600;
}

.customer-wrap {
    display: flex;
    align-items: center;
}

.customer-wrap .list-items {
    margin-left: 15px;
}

.customer-wrap .list-items h4,
.customer-wrap .list-items p {
    margin: 0;
}

/*#add_cust .form-control {
    text-transform: capitalize;
}*/

.search-wrapper {
    background: #fff;
    border: 1px solid #e2e2e4;
    border-radius: 4px;
    margin-bottom: 25px;
}

.search-wrapper input {
    border: 0;
}

.search-wrapper input:focus {
    border: 0;
}

.search-bar {
    display: flex;
    align-items: center;
    padding: 0 10px;
}

#add_cust .modal-header {
    background-color: #fff;
    /* box-shadow: 0px 9px 10px -7px rgba(0, 0, 0, 0.1); */
}

#add_cust .modal-header h4.modal-title {
    color: #000;
    font-weight: 600;
    font-size: 24px;
}

#add_cust .modal-body label {
    color: #000;
    font-weight: 600;
    font-size: 15px;
}

#add_cust .modal-dialog {
    width: 100%;
    max-width: 750px !important;
}

.create_new_cust {
    padding: 10px 25px;
    margin-top: 20px;
}

.product-quantity-detail-wrapper {
    display: flex;
    justify-content: flex-end;
}

#prod-list .product-list-wrapper > div {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
} 

#prod-list .product-list-wrapper .total-wrapper {
    position: static;
}

.category-list {
    background-color: #fff;
    width: 100%; 
    max-width: 130px;
    height: 90px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin: 4px;
    border: 1px dotted #5b6e84;
    border-top: 0px;
    position: relative;
    z-index: 1;
}

.category-list span {
    position: absolute;
    right: 0;
    top: -24px;
    z-index: 3;
    transition: 0.5s;
}

.category-list span i {
    color: #5b6e84;
}

.category-list:hover span i{  
    color: red;
    display: block;
}


.category-list::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 6px;
    background: #5b6e84;
    top: 0;
    left: 0;
    right: 0;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}

.select_category_item {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
    flex-wrap: wrap;
}

.quick-layout-wrapper .category-list {
    border: 1px dotted #5b6e84;
}

.quick-layout-wrapper .category-list::before{
    display: none;
}

.quick-layout-wrapper .select_category_item .add_product p {
    margin: 5px 0;
}

.quick-layout-wrapper .select_category_item .add_product h4 {
    font-size: 15px;
}

#quick-keys .modal-header h4.modal-title {
    font-size: 25px;
    font-weight: 600;
    text-transform: capitalize;
    color: #fff;
}

#quick-keys .modal-header p {
    font-weight: 500;
    color: #fff;
    font-size: 12px;
}

#quick-keys .modal-header {
    background: #2e3742;
    border-bottom: 1px solid #5b6e8414;
    padding: 5px 15px;
}

#quick-keys .modal-header .close {
    margin-top: 0;
    color: #fff;
    text-shadow: none;
    opacity: 1;
}

.quick-btn {
    text-align: center;
    margin-top: 30px;
}

.quick-btn button{
    background-color: #5b6e84;
    color: #fff;
    text-transform: capitalize;
    padding: 10px 20px;
    font-size: 15px;
}
.quick-layout-wrapper{
    margin-top:50px;
}
.quick-layout-wrapper.no-quick-keys .select_category_item{
    transform:scale(0.9);
}

.quick-layout-wrapper.no-quick-keys .category-list{
    border:0px;
    padding: 5px;
    max-width: 100%;
}
.quick-layout-wrapper h2{
    font-size: 25px;
    color: #000;
    font-weight: bold;
    text-align: center;
    text-transform: capitalize;
    margin-top:25px;
    margin-bottom:20px;
}
.quick-layout-wrapper p{
    text-align: center;
    width: 100%;
    max-width: 380px;
    margin: 25px auto;
    text-transform: capitalize;
    font-size: 14px;
    color: #292929;
    font-weight: 600;
}

.add_total_digit{
    display: flex;
    align-items: center;
    justify-content: flex-end;
    
}
.add_total_digit input {
    cursor: text;
    color: var(--vd-colour--text);
    font-family: lato,Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;
    font-weight: 400;
    font-size: 15px;
    word-break: normal;
    width: 100%;
    margin: 0;
    padding: 5px 10px;
    box-sizing: border-box;
    outline: none;
    box-shadow: none;
    background-color: #fff;
    border: 2px solid #e7e5e8;
    border-radius: 4px;
    transition: all .2s;
    text-align: right;
    transition-property: border-color,box-shadow;
    margin-right: 5px;
}


#add-prod-list {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-top: 10px;
    position: absolute;
    width: 97%;
    height: auto;
    background: #fff;
    z-index: 2;
    display: none;
    box-shadow:0px 8px 16px 0px rgb(0 0 0 / 20%);
}
#add-prod-list ul {
    margin-bottom:0px;
}
#add-prod-list .popover-list-item:last-child .product-list-wrapper{
    border-bottom:0px;
    margin-bottom:0px;
    cursor: pointer;
}

#add-prod-list .product-list-wrapper > div {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
} 

#add-prod-list .product-list-wrapper .total-wrapper {
    position: static;
}

label.error{
  position: absolute;
}
</style>
<div class="overlay" style="display: none;">
   <div class="loader"></div>
</div>
<section id="main-content">
   <section class="wrapper site-min-height">
      <div id="msg">
          <?php if($this->session->flashdata('myMessage') !=''){ 
              echo $this->session->flashdata('myMessage');
           } ?>
         <?php if ($this->session->flashdata('msg') && $this->session->flashdata('msg') != '') { ?>
         <div class="alert alert-success fade in">
            <strong>Success!</strong> <?php echo $this->session->flashdata('msg');; ?>
         </div>
         <?php }
            unset($this->session->flashdata); ?>
      </div>
      <div class="row">
         <div class="col-lg-12">
            <section>
               <!-- <header class="panel-heading">Sell</header> -->
               <p class="sub_title"></p>
               <?php if (!empty($register_result)) { ?>
               <?php if ($register_result[0]->type == '1') { ?>
               <div class="panel-body">
                  <div class="">
                     <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <!-- <div class="customer">
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
                        </div> -->

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
                
                        <div class="search-wrapper">
                            <div class="search-bar">
                                <span><i class="fas fa-search"></i></span>    
                                <input type="text" class="form-control" id="search_prod" placeholder="Start typing or scanning...">
                                <span><i class="fas fa-qrcode"></i></span>
                            </div>
                                <div id="prod-list">
                                    <!-- <ul>
                                        <li class="popover-list-item">
                                            <div class="product-list-wrapper">
                                                <div>
                                                    <div>
                                                        <h5>Kitkat</h5>
                                                        <h5>15 gm</h5>
                                                    </div>
                                                    <div class="total-wrapper">
                                                        <h5>35.00</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="popover-list-item">
                                            <div class="product-list-wrapper">
                                                <div>
                                                    <div>
                                                        <h5>Kitkat</h5>
                                                        <h5>15 gm</h5>
                                                    </div>
                                                    <div class="total-wrapper">
                                                        <h5>35.00</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="popover-list-item">
                                            <div class="product-list-wrapper">
                                                <div>
                                                    <div>
                                                        <h5>Kitkat</h5>
                                                        <h5>15 gm</h5>
                                                    </div>
                                                    <div class="total-wrapper">
                                                        <h5>35.00</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul> -->
                                        
                                </div>                    
                        </div>
                        <!-- <div class="customer">
                           <div class="form-group">
                              <label for="name" id="sel_cat"
                                 class="product_header">Category</label>
                           </div>
                        </div> -->
                        <!-- <div class="sel_catagory_itm">
                           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no_padd click_box">
                                <?php foreach ($category as $type) { ?>
                                <div class="catg_list" id="catg_list"
                                        onclick="return select_subcategory('<?php echo $type->id; ?>','<?php echo $type->name; ?>');">
                                        <a href="javascript:;"><span><?php echo $type->name; ?></span></a>
                                </div>
                              <?php } ?>
                           </div>
                        </div> -->
                        <div class="quick-layout-wrapper no-quick-keys">
                        <h2>Quick keys</h2>
                        <div class="select_category_item">
                          
                          <?php foreach ($IsPosMostLike as $key => $value): ?>
                            <div class="quick-view">
                                <span class='remove_quick_list_item' data-pw_id="<?=$value->id?>"><i class="fa fa-trash" aria-hidden="true"></i></span>
                                <div class="category-list add_quick_product" data-product_id="<?=$value->product_id?>" data-pw_id="<?=$value->id?>">
                                    <a href="javascript:">
                                        
                                        <div>
                                            <h4><?=$value->name?></h4>
                                            <p><?=$value->weight_no.' '.$value->weight_name?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                          <?php endforeach ?>
                            <!-- <div class="category-list">
                                <a href="#">
                                    <span><i class="fa fa-trash" aria-hidden="true"></i></span>
                                    <div>
                                        <h4>Kitkat</h4>
                                    </div>
                                </a>
                            </div>
                            <div class="category-list">
                                <a href="#">
                                    <span><i class="fa fa-trash" aria-hidden="true"></i></span>
                                    <div>
                                        <h4>Kitkat</h4>
                                    </div>
                                </a>
                            </div>
                            <div class="category-list">
                                <a href="#">
                                    <span><i class="fa fa-trash" aria-hidden="true"></i></span>
                                    <div>
                                        <h4>Kitkat</h4>
                                    </div>
                                </a>
                            </div> -->
                        </div>
                        <p>create your custom quicks keys for most popular,product and speed up checkout  </p>
                        <div style="text-align:center;margin-top: 15px;">
                            <button type="button" class="btn btn-info" id="quick_keys" data-toggle="modal" data-target="#quick-keys">Set Up Quick Keys</button>
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
                           action="<?php echo base_url() . 'sell_development/order_checkout/'; ?>"
                           id="paypal_form"
                           class="paypal" name="checkout_sell" novalidate>
                           <input type="hidden" name="vendor_id" id="user_id"
                              value="<?php echo $vendor_id; ?>">
                           <input type="hidden" name="customer" id="set_customer" value="<?=(isset($order_temp_result[0]->customer_id)) ? $order_temp_result[0]->customer_id : 0 ?>">
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
                           <input type="hidden" name="currency_code" value="<?=$currency_code?>">
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
                               <div class="row">
                                 <?php if (!isset($parked_order_id) && empty($parked_order_id)) {
                                     ?>
                                    <div class="col-lg-4 col-md-4 col-sm-4 padd_lft_0">
                                        <div class="check_items dropdown">
                                            <h4 class="btn items_count dropbtn" onclick="myFunction()"><i class="fa fa-share vd-mr1"></i> Retrieve sale</h4>
                                            <span></span>
                                            <div id="myDropdown" class="dropdown-content">
                                                <ul>
                                                    <li>
                                                        <h5>Parked Sale</h5>
                                                    </li>
                                                    <?php foreach ($order_row as $key => $value) { ?>
                                                    <li class="popover-list-item">
                                                        <a href="<?=base_url().'sell_development/index?parkedId='.base64_encode($value->id); ?>">
                                                            <div class="">
                                                                <!-- <div class="list-item-img">
                                                                    <img src="https://vendimageuploadcdn.global.ssl.fastly.net/1…-4-finger-wafer-chocolate-bar-34-g-0-20210406.jpg" alt="">
                                                                </div> -->
                                                                <div class="list-items">
                                                                   <!-- <h4>1 × Kitkat</h4>  -->
                                                                   <h4>Parked By <?=$value->vendor_name?></h4> 
                                                                   <p>Parked <?=time_ago($value->dt_added,DATE_TIME) ?> ago</p>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <i class="fa fa-share" aria-hidden="true"></i>
                                                            </div>
                                                        </a>
                                                    </li>
                                                   <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                  <?php } ?>
                                   <?php
                                   if (isset($parked_order_id) && !empty($parked_order_id)) {
                                     ?>
                                   <div class="col-lg-4 col-md-4 col-sm-4">
                                      <button type="button" class="btn items_count" id='discard_parked_sell'>discard sale</button>
                                   </div>
                                 <?php }else{ ?>
                                   <div class="col-lg-4 col-md-4 col-sm-4" style="<?=(empty($order_temp_result)) ? 'display:none' : 'display:block' ?>" >
                                        <button type="submit" class="btn items_count" id="parked_sell" name="parked_sell" value="Park Sale">park sale</button>
                                   </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4" style="<?=(empty($order_temp_result)) ? 'display:none' : 'display:block' ?>"   >
                                      <button type="button" class="btn items_count" id='discard_sell'>discard sale</button>
                                   </div>
                                 <?php } ?>
                               </div>
                              
                              <?php
                                 if (isset($parked_order_id) && !empty($parked_order_id)) {
                                     ?>
                              <!-- <div class="col-md-7 col-lg-7 col-sm-7 col-xs-12 padd_rght_0">
                                 <div class="discard_btn">
                                    <a class="discard_sell" id="discard_parked_sell"
                                    href="<?php /*echo base_url().'sell/index' */ ?>
                                    ">Discard sale</a>
                                 </div>
                              </div> -->
                              <?php } else { ?>
                              <!-- <div class="col-md-7 col-lg-7 col-sm-7 col-xs-12 padd_rght_0">
                                 <div class="park_btn">
                                    <a class="park_sell" href="#">Park sale</a>
                                    <input type="submit" class="park_sell" value="Park Sale"
                                       name="parked_sell">
                                 </div>
                                 <div class="discard_btn">
                                    <a class="discard_sell" id="discard_sell"
                                    href="<?php /*echo base_url().'sell/index' */ ?>
                                    ">Discard sale</a>
                                 </div>
                              </div> -->
                              <?php } ?>
                              <div class="brder">
                                 <div class="create_cutomer">
                                    <!-- <a href="<?php echo base_url() . 'customer/customer1'; ?>">Create
                                    New Customer</a> -->
                                    <input type="text" class="form-control" name="add_customer" id="add_customer" placeholder="Add a customer">
                                    <div id="message">
                                        <!-- <ul>
                                            <li class="popover-list-item" id="display_customer">
                                                <a href="#">
                                                    <div class="customer-wrap">
                                                        <div class="profile-avatar">
                                                            H
                                                        </div>
                                                        <div class="list-items">
                                                            <h4>Hinal</h4> 
                                                            <p>hinal-H2Yk | IN</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                        <a href="#" type="button" class="btn" data-toggle="modal" data-target="#add_cust">
                                            <p><i class="fa fa-plus-circle" aria-hidden="true"></i> Add '<span></span>' as a customer</p>
                                        </a> -->
                                         
                                    </div> 
                                </div>
                                <div class="product-list-container">
                                    <ul id='selected_customber'>
                                      <?php if(!empty($order_temp_result) && $order_temp_result[0]->customer_id != 0){ ?> 
                                      <ul>
                                        <li class="popover-list-item" id="display_customer">
                                          <a href="javascript:">
                                            <div class="customer-wrap">
                                              <div class="profile-avatar">
                                                <?=$order_temp_result[0]->customer_name[0]?> 
                                              </div>
                                              <div class="list-items">
                                                <h4><?=$order_temp_result[0]->customer_name?></h4> 
                                                <p><?=$order_temp_result[0]->customercode?></p>
                                              </div>
                                            </div>
                                          </a>
                                        </li>
                                      </ul>
                                      <?php } ?>
                                         <!-- selected customer hear -->
                                    </ul>
                                    <?php 
                                    $sub_total = 0;
                                    $total_discount = 0;
                                    $total_gst = 0;
                                    foreach ($order_temp_result as $key => $value) { 
                                      $gst_amount = ($value->product_price * $value->gst) / 100;
                                      $total_gst += $gst_amount * $value->quantity;

                                      $sub_total += $value->price; 

                                      // $total_discount += $value->discount_per_product;

                                      ?>
                                    <div class="product-list-wrapper old_list">
                                        <div class="product_name">
                                            <h5><?=$value->product_name?></h5>
                                            <h5><span class="this_quantity"><?=$value->quantity?></span> 
                                            <i class="fa fa-times" aria-hidden="true"></i> <?=$value->product_price?> </h5>
                                        </div>
                                        <div class="product-quantity-detail-wrapper">
                                            <div class="product-quantity-detail">
                                                <label for="">Qty</label>
                                                <input type="number" name="qnt<?=$value->id?>" class="qunt" data-actual_discount_price="<?=number_format((float)$value->product_price,2,'.','')?>" data-product_weight_id="<?=$value->product_weight_id?>" data-temp_id="<?=$value->id?>" value="<?=$value->quantity?>" data-isParked ="<?=(isset($parked_order_id) ? $parked_order_id : '0') ?>" inputmode="decimal">
                                                <span style="color: red" id="error"></span>
                                            </div>
                                            <div class="product-quantity-detail">
                                                <label for="">dis</label>
                                                <input type="number" name="discount<?=$value->id?>" class="disc" data-product_weight_id="<?=$value->product_weight_id?>" data-temp_id="<?=$value->id?>" value="<?=$value->discount?>" data-actual_discount_price="<?=number_format((float)$value->product_price,2,'.','')?>" data-isParked ="<?=(isset($parked_order_id) ? $parked_order_id : '0') ?>">
                                                <span style="color: red" id="error"></span>
                                            </div>
                                            <div class="total-wrapper">
                                                <h5 class="sub_total"><?=$value->price?></h5>
                                                <i class="fa fa-trash revomeRecord" aria-hidden="true" data-order_tempId="<?=$value->id?>" data-isParked ="<?=(isset($parked_order_id) ? $parked_order_id : '0') ?>"></i>
                                            </div>
                                        </div>   
                                    </div>
                                    <?php } ?>
                                 </div>
                                 <div class="note_of_sale">
                                    <ul>
                                       <li>
                                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                             <div class="add_total">
                                                <p>Subtotal</p>
                                             </div>
                                          </div>
                                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                             <div class="add_total_digit">
                                                <?= $currency . ' '; ?> <span id="subtotal"><?=number_format((float)$sub_total,2,'.','')?></span>
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
                                                   max="99"
                                                   name="disc_percentage"
                                                   placeholder="%"
                                                   id="disc_percentage"
                                                   value="<?php if(isset($parked_order_id)){echo $order_temp_result[0]->order_discount;} ?>">
                                                   <label id="error"
                                                      style="color:red;"></label>
                                                </div>
                                                <span style="color: red" id="error"></span>
                                                <?= $currency . ' '; ?> <span
                                                   id="discount_total"><?=number_format((float)$total_discount,2,'.','')?></span>
                                             </div>
                                          </div>
                                       </li>
                                       <li>
                                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                             <div class="add_total">
                                                <p>Tax <span>GST (included)</span></p>
                                             </div>
                                          </div>
                                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                             <div class="add_total_digit">
                                                <div class="add_percent">
                                                </div>
                                                <!-- <div class="add_rupees"><input type="number"
                                                   min="0"
                                                   max="1"
                                                   name="disc_percentage"
                                                   placeholder="%"
                                                   onkeyup="calculate_percentage();"
                                                   id="disc_percentage"
                                                   value="<?php if(isset($parked_order_id)){echo $order_temp_result[0]->order_discount;} ?>">
                                                   <label id="error"
                                                      style="color:red;"></label>
                                                </div> -->
                                                <?= $currency . ' '; ?><span
                                                   id="total_gst"><?=number_format((float)$total_gst,2,'.','')?></span>
                                             </div>
                                          </div>
                                       </li>
                                       <!-- <li>
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
                                       </li> -->
                                       <div class="payment_btn">
                                          <div>
                                             <div class="final_btn_pay">
                                                <!--<a href="#myModal" data-toggle="modal" id="span_pay" onclick="check_selected()"><span class="final_rs_pay">Pay</span>-->
                                                
                                                <!-- <a href="#myModal" data-toggle="modal" -->
                                                <a href="javascript:" class="pay-btn"
                                                   id="span_pay"
                                                   onclick="">
                                                   <span
                                                      class="final_rs_pay">Pay</span>
                                                   <span class="rs_cs_totl">
                                                      <?= $currency . ' '; ?>
                                                      <p
                                                         id="total_pay"><?=number_format((float)$sub_total,2,'.','')?></p>
                                                   </span>
                                                </a>
                                                <div class="after-pay">
                                                    <button class="submit" value="Cash" name="case">cash</button>
                                                    <button class="submit" value="Credit Card" name="credit_card">credit card</button>
                                                    <button class="btn">online payment</button>
                                                </div>
                                             </div>
                                          </div>
                                          <?php   if (isset($parked_order_id) && !empty($parked_order_id)) {
                                             ?>
                                          <input type="hidden" name="parked_order" value="park">
                                          <?php } ?>
                                          <!-- Add Brand : Modal -->
                                          <!-- <div class="modal fade " id="myModal" tabindex="-1"
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
                                                   </div>
                                                   <div class="modal-body">
                                                       <div>
                                                            <h4 class="modal-title">Amount to Pay</h4>
                                                            <input type="text">
                                                       </div>
                                                   </div> 
                                                   <div class="modal-body">
                                                      <div class="form-group">
                                                          <label for="email">Email</label>
                                                          <input type="text" name="rec_email" class="form-control" value="" placeholder="Email" required>
                                                      </div>
                                                      <div class="form-group">
                                                          <label for="description">Sale Note</label>
                                                          <textarea rows="4" cols="50" class="form-control" name="sale_note" placeholder="Type to add a sale note" required></textarea>
                                                      </div>
                                                      </div>
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
                                          </div> -->
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
<input type="hidden" id="isParked" value="<?=(isset($parked_order_id) && !empty($parked_order_id)) ? $parked_order_id : '0'?>">
<?php
   if (isset($parked_order_id) && !empty($parked_order_id)) {?>
        <input type="hidden" name="parked_id" id="parked_id" value="<?= $parked_order_id; ?>">
<?php } ?>


 <!-- Modal -->
 <div class="modal fade" id="add_cust" role="dialog">
    <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Customer</h4>
        </div>
        <div class="modal-body">
        <form id="customer_form" method="post" action="<?=base_url().'sell_development/customer_add' ?>">
            <div class="row">
                <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Customer Name</label>
                    <input type="text" name="customer_name" class="form-control" placeholder="Name">
                    <label for="customer_name" class="error" style="color: red"></label>
                </div>
                </div>
                <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Customer Code</label>
                    <input type="text" name="customercode" class="form-control" value="<?='CC'.strtotime(DATE_TIME); ?>" readonly>
                </div>
                </div>
                <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control" style="color: red" placeholder="email">
                    <label for="email" class="error" style="color: red"></label>
                </div>
                </div>
                <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Mobile Number</label>
                    <input type="text" name="mobile" class="form-control mobile" placeholder="mobile number">
                    <label for="mobile" class="mobile" class="error" style="color: red"></label>
                </div>
                </div>
                <!-- <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Customer Group</label>
                        <select name="" id="" class="form-control">
                        <option value="">customer group</option>
                        <option value="">all customer</option>
                        </select>
                    </div>
                </div> -->
                <div class="col-lg-12">
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary create_new_cust" id="btnSubmit">Create New Customer</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
    
    </div>
</div>

<div class="modal fade" id="quick-keys" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add products</h4>
            <p>Search for products to add to your Quick Key layout.</p>
            </div>
            <div class="modal-body">
                <div class="search-wrapper">
                    <div class="search-bar">
                        <span><i class="fas fa-search"></i></span>    
                        <input type="text" class="form-control" id="add_search_prod" placeholder="Start typing or scanning...">
                        <span><i class="fas fa-qrcode"></i></span>
                    </div>
                    <div id="add-prod-list">
                      
                    </div> 
                </div>       
                <div class="select_category_item -quic-layout-wrapper" id="product_quick_list">
                    
                   
                </div>
                <div class="quick-btn">
                    <button type="button" id="SubmitQuickList" class="btn">create quick keys</button>
                </div>
            </div>
            
        </div>
    </div>
</div>
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
   
   
   setTimeout(function () {
       $('#msg').hide();
   }, 30000);
   

   $('#customer_id').change(function () {
       setTimeout(function () {
           $('#product_search').trigger('focus');
       }, 300);
   });
   


   
// dropdown

function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}



// after pay open payment options
$(document).ready(function() {
    $('.pay-btn').click(function(){
    $('.after-pay button').fadeIn();
    $(this).css('display','none');
});
});


// type text open modal
$('#add_customer').on('keydown, keyup', function () {
  var texInputValue = $(this).val();

    if($(this).val() == ''){
        $('#message').css('display','none');
    }
    else{
        $('#message').css('display','block');
    }
  $('#message p span').html(texInputValue);
});


$("#search_prod").on('keydown, keyup', function () {
  var texInputValue = $(this).val();
    if($(this).val() == ''){
        // $('#prod-list').css('display','none');
    }
    else{
        // $('#prod-list').css('display','block');
    }
});

$("#add_search_prod").on('keydown, keyup', function () {
  var texInputValue = $(this).val();
    if($(this).val() == ''){
        $('#add-prod-list').css('display','none');
    }
    else{
        $('#add-prod-list').css('display','block');
    }
});




$('body').click(function(){
    $('#message').css('display','none');
    // $('#prod-list').css('display','none');
});
   
</script>
<?php include('footer.php'); ?>