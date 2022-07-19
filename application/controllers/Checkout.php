    <?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."libraries/razorpay/razorpay-php/Razorpay.php");
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
// error_reporting(E_ALL);
// ini_set("display_errors", "1");

class Checkout extends User_Controller {

  function __construct(){
    parent::__construct();
    $this->controller = $this->myvalues->checkoutFrontEnd['controller'];
    // $this->url = SITE_URL . 'frontend/'. $this->controller;
    $this->load->model($this->myvalues->checkoutFrontEnd['model'],'this_model');
    if($this->session->userdata('user_id') == ''){
       $this->session->set_userdata('redirect_page',base_url().'checkout');
       redirect(base_url().'login');
    }
  }

  public function check(){
     echo '1';die;
     $this->load->model('api_model');
     $this->api_model->emailTemplate_testing(5,1,11);
  }

  public function unreserve_quantity(){
    $user_id = $this->session->userdata('user_id');
    $this->this_model->unreserve_product_userwise($user_id);
  }


  public function index(){
    $this->load->model('api_v3/common_model','co_model');
    $isShow = $this->co_model->checkpPriceShowWithGstOrwithoutGst($this->session->userdata('vendor_id'));
    $data['isShow'] = $isShow;


    $this->load->model('api_v3/api_model');
    if(empty($_SESSION['My_cart']) && $this->cartCount == 0){
      $this->utility->setFlashMessage('danger','Your cart is empty');
      redirect(base_url().'home');
    }
    $defaultCartValue = $this->this_model->getCartValue();
    
    $myCartValue = 0;
    $total_gst = 0;
    if($this->session->userdata('user_id') == '' ){
      foreach ($_SESSION['My_cart'] as $key => $value) {
        $myCartValue += $value['total'];
        
        $gst = $this->api_model->getProductGst($value['product_id']);
        $gst_amount = ($value['discount_price'] * $gst)/100;
        $total_gst += $gst_amount * $value['quantity'];
        
      }
    }else{
       $my_cart = $this->product_model->getMyCart(); //return value of mycart and 
       foreach ($my_cart as $key => $value) {
          $myCartValue += $value->discount_price * $value->quantity;
       
          $gst = $this->api_model->getProductGst($value->product_id);
          $gst_amount = ($value->discount_price * $gst)/100;
          $total_gst += $gst_amount * $value->quantity; 
       }
    }
    $data['TotalGstAmount'] = number_format((float)$total_gst,'2','.','');    
    $data['AmountWithoutGst'] = number_format((float)($myCartValue-$gst_amount),'2','.','');
  

    if($myCartValue < $defaultCartValue ){
      $this->utility->setFlashMessage_cartValue('danger','Minimum cart value should be greater than '.$this->session->userdata('de_currency').' '.$defaultCartValue );
      redirect(base_url().'home');
      exit(); 
    } 

    $data['page'] = 'frontend/checkout';
    $data['js'] = array('checkout.js','address.js','payment_stripe.js');
    $data['init'] = array('CHECKOUT.init()','ADDRESS.init()');
    $data['userAddress'] = $this->this_model->getUserdetail();
    $data['country'] = GetDialcodelist();
    $this->load->model($this->myvalues->productFrontEnd['model'],'product_model'); 
      $result = $this->this_model->getUserAddressLatLong();
     
      if(!isset($_SESSION['isSelfPickup']) || $_SESSION['isSelfPickup'] == '0'){
        if(empty($result)){
        //  $this->utility->setFlashMessage('danger','Please enter your address');
        //  redirect(base_url().'users_account/users/account?name=my_address');
        //  exit();
        }
      }
      if(!empty($result)){
         $userLat = $result[0]->latitude; 
         $userLong = $result[0]->longitude; 
       }

          $otpForSelfPickup = '';
          $data['calc_shiping'] = '0';
          $calc_shiping = 0;

          if(!isset($_SESSION['isSelfPickup']) || $_SESSION['isSelfPickup'] == '0'){
             $calc_shiping = $this->this_model->getDeliveryCharge($userLat,$userLong,$this->session->userdata('branch_id'));
            $data['calc_shiping'] = $calc_shiping;

     
          }

      if($data['calc_shiping'] == 'notInRange'){
        $calc_shiping = 0;
        $data['AddressNotInRange'] = '0';
      }else{
        $data['AddressNotInRange'] = '1';
      }
  
    $this->load->model($this->myvalues->usersAccount['model'],'that_model');
    $data['get_address'] = $this->that_model->getUserAddress();
    $data['time_slot'] = $this->this_model->getTimeSlot();
    $getActivePaymentMethod = $this->this_model->ActivePaymentMethod();
    $data['payment_option'] = $getActivePaymentMethod[0]->type; 

    $data['phone'] = '0';
    $data['is_verify'] = '0';
    $vendor = $this->this_model->getVendorAddress();
    $data['isOnlinePayment'] = $vendor[0]->isOnlinePayment;

    $data['isCOD'] = $vendor[0]->isCOD;
    if(isset($_SESSION['isSelfPickup']) && $_SESSION['isSelfPickup'] == '1'){
    
      $data['get_address'] = $this->this_model->getVendorAddress();
    }
      $userdata = $this->this_model->checkUserMobile();
      
      if($userdata[0]->phone != ''){
        $data['phone'] = '1'; 
      }
      if($userdata[0]->is_verify == '1'){
         $data['is_verify'] = '1';
      }
   
    $publish_key = $getActivePaymentMethod[0]->publish_key; 
    $scret_key = $getActivePaymentMethod[0]->secret_key;

    if($getActivePaymentMethod[0]->IsTestOrLive == '0'){
      $publish_key = $getActivePaymentMethod[0]->test_publish_key; 
      $scret_key = $getActivePaymentMethod[0]->test_secret_key;
    }

    $getMycartSubtotal = getMycartSubtotal();
    $data['getMycartSubtotal'] = $getMycartSubtotal;
    $data['array'] = [];
    $data['data'] = json_encode([]);

    /*Load Api Model*/
   
    $user_id = $this->session->userdata('user_id');
    $data['selfPickEnable'] = $this->this_model->checkSelfPickUpEnabled();
    $checkCurrencyCode = $this->this_model->checkCurrencyCode();
     
    $currency_code = $checkCurrencyCode[0]->currency_code;
    $data['currency_code'] = $currency_code; 

    if(isset($getActivePaymentMethod[0]->type) && $getActivePaymentMethod[0]->type == 1){ // razor payment

        $api = new Api($publish_key,$scret_key);
        $amt =  $getMycartSubtotal + $calc_shiping;
        $razorpayOrder = $api->order->create(array(
            'receipt'         => rand(),
            'amount'          => $amt * 100, // 2000 rupees in paise
            'currency'        => $currency_code,
            'payment_capture' => 1 // auto capture
          ));
          $amount = $razorpayOrder['amount'];
          $razorpayOrderId = $razorpayOrder['id'];
          $_SESSION['razorpay_order_id'] = $razorpayOrderId;
          $d = $this->prepareData($amount,$razorpayOrderId,$publish_key);
          $data['data'] = json_encode($d);
    }else
    if(isset($getActivePaymentMethod[0]->type) && $getActivePaymentMethod[0]->type == 2){ /*stripe*/
         
          $amt =  $getMycartSubtotal + $calc_shiping;
          $data['amount'] = $amt *100;
          $data['user_email'] = $this->session->userdata('user_email');
          $data['publishableKey'] = $publish_key;
          $data['payment_type'] = $getActivePaymentMethod[0]->type;
        }
    else if(isset($getActivePaymentMethod[0]->type) && $getActivePaymentMethod[0]->type == 3){ /*paytm*/

      function clean($string) {
         $string = str_replace('-', '', $string); // Replaces all spaces with hyphens.
          return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        }
         /*Generate Order Number*/
         function random_orderNo( $length = 10 ) {
            $chars = "1234567890";
            $order = substr( str_shuffle( $chars ), 0, $length );
            return $order;
          }
          $od = 'Order #'; 
          $on = time();
          $on = "PYTM_ORDR_".$on;
          $MID = trim($publish_key); 
          $MKY = trim($scret_key); 
        
          $amt =  $getMycartSubtotal + $calc_shiping;
          $amt = number_format($amt,2,'.','');  
          $custId = "CUST_".time(); 
          $callbackUrl = base_url()."checkout/paytm_checkout";
          $currency = $currency_code;
          
          $paytmParams["body"] = array(
            "requestType"  => "Payment",
            "mid"      => $MID,
            "websiteName"  => clean($this->siteTitle),
            "orderId"    => $on,
            "callbackUrl"  => $callbackUrl,
            "txnAmount"   => array(
              "value"   => $amt,
              "currency" => trim($currency),
            ),
            "userInfo"   => array(
              "custId"  => $custId,
            ),
          );
        /*
        * Generate checksum by parameters we have in body
        * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
        */
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $MKY);


        $paytmParams["head"] = array(
          "signature" => $checksum
        );

        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

        /* for Production */
        $url = 'https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid='.$MID.'&orderId='.$on.'';
        $data['Host'] = 'https://securegw.paytm.in'; // production

        if($getActivePaymentMethod[0]->IsTestOrLive == 0){
        /* for Staging */
          $url = 'https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid='.$MID.'&orderId='.$on.'';
          $data['Host'] = 'https://securegw-stage.paytm.in'; // staging
        }


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
        $response = curl_exec($ch);
        $res = json_decode($response);
        $array = ['txnToken'=>$res->body->txnToken,'amount'=>$amt,'orderId'=>$on];
        $data['paytm'] = json_encode($array); 
        $data['MID'] = $publish_key;
       
    }
      $data['GatewayType'] = $getActivePaymentMethod[0]->type;
      $data['selfPickupTimeChart'] = $this->this_model->getSelfPickupTimeChart();
      $data['country_code'] = GetDialcodelist();
      $this->loadView(USER_LAYOUT,$data);
  }

  function validate_promocode(){
      $response = $this->this_model->validate_promocode($this->input->post());
      echo json_encode($response);die;
    }

  public function paytm_checkout() {
        $user_id = $this->session->userdata('user_id');
        $this->this_model->unreserve_product_userwise($user_id);  /*unreserved when transaction done*/

       // print_r($_POST);die;
       if($_POST['STATUS'] == 'TXN_SUCCESS'){
          $transaction_id = $_POST['TXNID'];
          $order_id = $_POST['ORDERID'];
          $res_array = array(
            'balance_transaction'=>$transaction_id,
            'paymentMethod'=>'3',
            'payment_type'=>'1', 
            'delivery_date'=>$this->session->userdata('delivery_date'),
            'time_slot_id'=>$this->session->userdata('time_slot_id'),
            'user_gst_number'=>$this->session->userdata('user_gst_number'),
            'orderId_payment_gateway'=>$order_id,
          );
        $this->load->model($this->myvalues->orderFrontEnd['model'],'order_model');
          $result = $this->order_model->makeOrder($res_array);
          $message = json_decode($result);
        if($message->responsedata->success){
          $this->utility->setFlashMessage('success',$message->responsedata->message);
          $this->session->unset_userdata('delivery_date');
          $this->session->unset_userdata('time_slot_id');
          $this->session->unset_userdata('user_gst_number');
          $this->session->unset_userdata('My_cart');
          $data['page'] = 'frontend/order_success';
          $data['js'] = array('sccess_screen.js');
          $data['status'] = '1'; 
          $data['order_number'] =  $message->responsedata->order_number;
          $this->load->view(USER_LAYOUT,$data);
          // redirect(base_url().'users_account/users/account?name=my_address');
          // redirect(base_url().'success?orderno='$message->responsedata->order_number););
        }else{
          $data['page'] = 'frontend/order_success';
          $data['js'] = array('payment_failed.js');
          $data['status'] = '0';
          $this->load->view(USER_LAYOUT,$data);
          $this->utility->setFlashMessage('danger','Somthing went Wrong');
          redirect(base_url().'checkout');
        }
       }elseif($_POST['RESPCODE'] == '227'){
          $data['page'] = 'frontend/order_success';
          $data['js'] = array('payment_failed.js');
          $data['message'] =  $_POST['RESPMSG'];
          $data['status'] = '0';
          $this->load->view(USER_LAYOUT,$data);

       }else{
       	  $data['page'] = 'frontend/order_success';
          $data['js'] = array('payment_failed.js');
          $data['message'] =  $_POST['RESPMSG'];
          $data['status'] = '0';
          $this->load->view(USER_LAYOUT,$data);
       }
       
  }

  public function set_date_time_id(){
    if($this->input->post()){
      $setData = array(
        'time_slot_id'=>$this->input->post('time_slot_id'),
        'delivery_date'=>$this->input->post('delivery_date'),
        'user_gst_number'=>$this->input->post('user_gst_number')
      );
      $this->session->set_userdata($setData);
    }
  }


  private function stripepayment($amount,$stripe_publish_key){
      $data['stripe_publish_key'] = $stripe_publish_key;
      $data['page'] = 'frontend/stripe_payment';
      $data['js'] = array('payment_stripe.js');
      $data['total_payment'] =  $amount;
      $this->load->view('frontend/stripe',$data);
    }

  public function stripepost(){
    // print_r($_POST);
      $token = $this->input->post('stripeToken');  
      $user_id = $this->session->userdata('user_id');
    
      $this->this_model->unreserve_product_userwise($user_id);  /*unreserved when transaction done*/
     // print_r($token);die;
      if($token != ''){
        require_once('application/libraries/stripe/init.php');
         $getActivePaymentMethod = $this->this_model->ActivePaymentMethod();
         $type = $getActivePaymentMethod[0]->type;  
         $data['paymentOption'] = $type;
         $scret_key = $getActivePaymentMethod[0]->secret_key;

        $result = $this->this_model->getUserAddressLatLong();
        if(!empty($result)){
           $userLat = $result[0]->latitude; 
           $userLong = $result[0]->longitude; 
        }

        $calc_shiping = 0;
          if(!isset($_SESSION['isSelfPickup']) || $_SESSION['isSelfPickup'] == '0'){
             $calc_shiping = $this->this_model->getDeliveryCharge($userLat,$userLong,$this->session->userdata('branch_id'));
          }
          // this call for currency code
          $currency = $this->this_model->checkCurrencyCode();
          $currency_code = $currency[0]->currency_code;    

          $amt =  getMycartSubtotal() + $calc_shiping;

          \Stripe\Stripe::setApiKey($scret_key);

          $data=\Stripe\Charge::create ([
                      "amount" => $amt * 100,
                      "currency" => $currency_code,
                      "source" => $this->input->post('stripeToken'),
                      "description" => "<?=$this->siteTitle?>",
              ]);
          // print_r($data)


      if($data->status == 'succeeded'){
        $res_array = array(
          'orderId_payment_gateway'=>$data->id,
          'balance_transaction'=>$data->balance_transaction,
          'paymentMethod'=>$type,
          'payment_type'=>'1', 
          'delivery_date'=>$this->input->post('delivery_date'),
          'time_slot_id'=>$this->input->post('time_slot_id'),
          'user_gst_number'=>$this->input->post('user_gst_number'),
        );


        $this->load->model($this->myvalues->orderFrontEnd['model'],'order_model');
          $result = $this->order_model->makeOrder($res_array);
          $message = json_decode($result);

        if($message->responsedata->success){
          $this->utility->setFlashMessage('success',$message->responsedata->message);
          $this->session->unset_userdata('My_cart');
          $d['page'] = 'frontend/order_success';
          $d['js'] = array('sccess_screen.js?v='.js_version);
          $d['status'] = '1';
          $d['order_number'] =  $message->responsedata->order_number;

          // redirect(base_url().'users_account/users/account?name=order');
        }else{
          $d['page'] = 'frontend/order_success';
          $d['js'] = array('payment_failed.js?v='.js_version);
          $d['status'] = '0';
          $d['message'] =  $message->responsedata->message;
        }
      }else{
      	 $this->utility->setFlashMessage('danger','Somthing Went Wrong');
      	 redirect(base_url().'home');
         exit();
      }
      	$this->load->view(USER_LAYOUT,$d);
    }else{
      $this->utility->setFlashMessage('danger','Somthing Went Wrong');
         redirect(base_url().'home');
         exit();
    }

  }   



public function prepareData($amount,$razorpayOrderId,$publish_key){
    $data = array(
      "key" => $publish_key,
      "amount" => $amount,
      "name" => $this->siteLogo,
      "description" => $this->siteTitle,
      "image" => $this->siteLogo,
      "prefill" => array(
        "name"  => 'user_name',
        "email"  => $this->session->userdata('user_email'),
        "contact" => 'user_contact',
      ),
      "notes"  => array(
        "address"  => "Hello World",
        "merchant_order_id" => rand(),
      ),
      "theme"  => array(
        "color"  => "#F37254"
      ),
      "order_id" => $razorpayOrderId,
    );
    return $data;
  }


  public function rzp_payment(){
       $user_id = $this->session->userdata('user_id');
      $this->this_model->unreserve_product_userwise($user_id);  /*unreserved when transaction done*/


      if (empty($_POST['razorpay_payment_id']) === false) {

          $this->load->model('frontend/order_model','order_model'); 
            $res_array = array(
              'balance_transaction'=>$_POST['razorpay_payment_id'],
              'paymentMethod'=>'1',
              'payment_type'=>'1', 
              'delivery_date'=>$_POST['delivery_date'],
              'time_slot_id'=>$_POST['time_slot_id'],
              'user_gst_number'=>$_POST['user_gst_number'],
            );
            $this->load->model($this->myvalues->orderFrontEnd['model'],'order_model');
            $result = $this->order_model->makeOrder($res_array);
            $message = json_decode($result);
          if($message->responsedata->success){
            $this->utility->setFlashMessage('success',$message->responsedata->message);
            $this->session->unset_userdata('My_cart');
            $status = $message->responsedata->success;
            $order_number = $message->responsedata->order_number;
            $redirect = base_url().'home';

          }else{
            $this->utility->setFlashMessage('danger','Somthing went Wrong');
            $redirect = base_url().'checkout';
            $status = 0;
            $order_number = '';
          }
          echo json_encode(['status'=>$status,'url'=>$redirect,'order_number'=>$order_number]);
    }
  }

  public function set_reserve_quantity(){
        $user_id = $this->session->userdata('user_id');
        $this->this_model->set_reserve_quantity($user_id); 
  }

  public function checkSelfPickUp(){
        $res = $this->this_model->getSelfPickupTimeChart();
        $check = $res[0]->selfPickUp;
        if($check == '0'){
            if( $this->session->userdata('isSelfPickup') == '1'){
              $this->session->unset_userdata('isSelfPickup');
              $this->utility->setFlashMessage('danger','Self PickUp Service not Available'); 
              $status = '0';
            }else{
              $status = '1';
            }
        }else{
        	$status = '1';
        }

       echo json_encode(['response'=>$status]);
  }

    public function updateMobileNumber(){
    if($this->input->post()){
      $res = $this->this_model->updatePhoneNumber($this->input->post());
      if($res){
        $response = '1';
      }else{
        $response = '0';
      }
      echo json_encode(['success'=>$response]);

    }

  }


  public function OtpVerification(){
    if($this->input->post()){
      $res = $this->this_model->OtpVerification($this->input->post());
      if($res > 0){
        $this->utility->setFlashMessage('success','Otp verified successfully');
        $response = '1';
      }else{
        $this->utility->setFlashMessage('success','Something went Wrong');
        $response = '0';
      }
      echo json_encode(['success'=>$response]);

    }

  }


  function paymentSetup(){
    $promoDiscount = 0;
    $getMycartSubtotal = getMycartSubtotal();
    if($this->input->post('promocode') && $this->input->post('promocode')!=''){
      $promo = $this->this_model->valicate_promocode($this->input->post());
      if($promo['success']=='1'){
        $promoDiscount = $promo['data'];
        $getMycartSubtotal = $promo['orderAmount'] - $promoDiscount;
      }else{
          echo json_encode(['response'=>'0']);die;
      }
    }
    
    $data['response']='1';
    $getActivePaymentMethod = $this->this_model->ActivePaymentMethod();
    $data['payment_option'] = $getActivePaymentMethod[0]->type; 

    $publish_key = $getActivePaymentMethod[0]->publish_key; 
    $scret_key = $getActivePaymentMethod[0]->secret_key;

    if($getActivePaymentMethod[0]->IsTestOrLive == '0'){
      $publish_key = $getActivePaymentMethod[0]->test_publish_key; 
      $scret_key = $getActivePaymentMethod[0]->test_secret_key;
    }

    
    $data['getMycartSubtotal'] = $getMycartSubtotal;
    $data['array'] = [];
    $data['data'] = json_encode([]);

    /*Load Api Model*/
   
    $user_id = $this->session->userdata('user_id');
    
    $checkCurrencyCode = $this->this_model->checkCurrencyCode();
     
    $currency_code = $checkCurrencyCode[0]->currency_code;
    $data['currency_code'] = $currency_code; 


      $result = $this->this_model->getUserAddressLatLong();
      if(!empty($result)){
         $userLat = $result[0]->latitude; 
         $userLong = $result[0]->longitude; 
       }

        $otpForSelfPickup = '';
        $calc_shiping =  '0';
        if(!isset($_SESSION['isSelfPickup']) || $_SESSION['isSelfPickup'] == '0'){
           $calc_shiping = $this->this_model->getDeliveryCharge($userLat,$userLong,$this->session->userdata('branch_id'));
   
        }

        if($calc_shiping == 'notInRange'){
          $calc_shiping = 0;
        }

    if(isset($getActivePaymentMethod[0]->type) && $getActivePaymentMethod[0]->type == 1){ // razor payment

        $api = new Api($publish_key,$scret_key);
        $amt =  $getMycartSubtotal + $calc_shiping;
        $razorpayOrder = $api->order->create(array(
            'receipt'         => rand(),
            'amount'          => $amt * 100, // 2000 rupees in paise
            'currency'        => $currency_code,
            'payment_capture' => 1 // auto capture
          ));
          $amount = $razorpayOrder['amount'];
          $razorpayOrderId = $razorpayOrder['id'];
          $_SESSION['razorpay_order_id'] = $razorpayOrderId;
          $d = $this->prepareData($amount,$razorpayOrderId,$publish_key);
          $data['data'] = json_encode($d);
    }else
    if(isset($getActivePaymentMethod[0]->type) && $getActivePaymentMethod[0]->type == 2){ /*stripe*/
         
          $amt =  $getMycartSubtotal + $calc_shiping;
          $data['amount'] = $amt *100;
          $data['user_email'] = $this->session->userdata('user_email');
          $data['publishableKey'] = $publish_key;
          $data['payment_type'] = $getActivePaymentMethod[0]->type;
        }
    else if(isset($getActivePaymentMethod[0]->type) && $getActivePaymentMethod[0]->type == 3){ /*paytm*/

      function clean($string) {
         $string = str_replace('-', '', $string); // Replaces all spaces with hyphens.
          return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        }
         /*Generate Order Number*/
         function random_orderNo( $length = 10 ) {
            $chars = "1234567890";
            $order = substr( str_shuffle( $chars ), 0, $length );
            return $order;
          }
          $od = 'Order #'; 
          $on = time();
          $on = "PYTM_ORDR_".$on;
          $MID = trim($publish_key); 
          $MKY = trim($scret_key); 
        
          $amt =  $getMycartSubtotal + $calc_shiping;
          $amt = number_format($amt,2,'.','');  
          $custId = "CUST_".time(); 
          $callbackUrl = base_url()."checkout/paytm_checkout";
          $currency = $currency_code;
          
          $paytmParams["body"] = array(
            "requestType"  => "Payment",
            "mid"      => $MID,
            "websiteName"  => clean($this->siteTitle),
            "orderId"    => $on,
            "callbackUrl"  => $callbackUrl,
            "txnAmount"   => array(
              "value"   => $amt,
              "currency" => trim($currency),
            ),
            "userInfo"   => array(
              "custId"  => $custId,
            ),
          );
        /*
        * Generate checksum by parameters we have in body
        * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
        */
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $MKY);


        $paytmParams["head"] = array(
          "signature" => $checksum
        );

        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

        /* for Production */
        $url = 'https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid='.$MID.'&orderId='.$on.'';
        $data['Host'] = 'https://securegw.paytm.in'; // production

        if($getActivePaymentMethod[0]->IsTestOrLive == 0){
        /* for Staging */
          $url = 'https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid='.$MID.'&orderId='.$on.'';
          $data['Host'] = 'https://securegw-stage.paytm.in'; // staging
        }


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
        $response = curl_exec($ch);
        $res = json_decode($response);
        $array = ['txnToken'=>$res->body->txnToken,'amount'=>$amt,'orderId'=>$on];
        $data['paytm'] = json_encode($array); 
       
    }
      $data['GatewayType'] = $getActivePaymentMethod[0]->type;

      echo  json_encode($data);
      
  }

}

