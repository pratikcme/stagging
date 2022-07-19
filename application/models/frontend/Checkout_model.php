<?php 

Class Checkout_model extends My_model{

    function __construct(){
         $this->branch_id = $this->session->userdata('branch_id');
         $this->vendor_id = $this->session->userdata('vendor_id');
    }

	public function getUserdetail(){
		$data['table'] = TABLE_USER. ' as u';
		$data['select'] = ['*'];
		$data['join'] = [TABLE_USER_ADDRESS . ' as ua'=>['u.id = ua.user_id','LEFT']];
		$data['where'] = ['u.id'=>$this->session->userdata('user_id'),'ua.status'=>'1'];
		return $this->selectFromJoin($data);
	}

	public function getAddress(){
		$data['table'] = TABLE_USER_ADDRESS;
    	$data['select'] = ['id as address_id'];
    	$data['where'] = ['user_id'=>$this->session->userdata('user_id'),'status'=>'1'];
    	return $this->selectRecords($data);
	}

    public function checkSelfPickUpEnabled(){
        $data['table'] = TABLE_BRANCH;
        $data['where'] = ['id'=>$this->branch_id];
        $data['select'] = ['selfPickUp'];
        $res = $this->selectRecords($data);
        return $res[0]->selfPickUp; 
    }

    public function getTimeSlot(){
        $data['table'] = TABLE_TIME_SLOT;
        $data['select'] = ['*'];
        $data['where'] = ['status'=>'1','vendor_id'=>$this->vendor_id];
        return $this->selectRecords($data);
    }

    public function getVendorAddress(){
        
        $data['table'] = TABLE_BRANCH;
        $data['select'] = ['*'];
        $data['where'] = ['status'=>'1','id'=>$this->branch_id];
        return $this->selectRecords($data);
    }


	public function getUserAddressLatLong(){
    	$data['table'] = TABLE_USER_ADDRESS;
    	$data['select'] = ['latitude','longitude'];
    	$data['where'] = ['user_id'=>$this->session->userdata('user_id'),'status'=>'1'];
    	return $this->selectRecords($data);
    }

     public function getDeliveryCharge($lat,$long,$branch_id){
    		  	$data['select'] = ['latitude', 'longitude'];
		        $data['table'] = TABLE_BRANCH;
		        $data['where'] = ['id' => $branch_id];
		        $get_vandor_address = $this->selectRecords($data);
                $getkm = $this->circle_distance($lat, $long, $get_vandor_address[0]->latitude, $get_vandor_address[0]->longitude);
		        $getkm = round($getkm);
                // print_r($getkm);die;
		 unset($data);
        $data['select'] = ['price'];
        $data['table'] = 'delivery_charge';
        $data['where'] = ['start_range <=' => $getkm, 'end_range >=' => $getkm,'vendor_id'=>$this->vendor_id];
        $get_range = $this->selectRecords($data);
        // print_r($get_range);die;
		// echo $this->db->last_query();die;
      
        if (count($get_range)) {
            return $get_range[0]->price;
        } else {
            $r = 'notInRange';
            return $r;
        }
    }

    function circle_distance($lat1, $lon1, $lat2, $lon2)
    {
        $rad = 3.14 / 180;

        return acos(sin($lat2 * ($rad)) * sin($lat1 * $rad) + cos($lat2 * $rad) * cos($lat1 * $rad) * cos($lon2 * $rad - $lon1 * $rad)) * 6371;
    }

    public function getCartValue(){
        $data['select'] = ['value'];
        $data['where'] = ['request_id' => '1','vendor_id'=>$this->vendor_id];
        $data['table'] = 'set_default';
        $result = $this->selectRecords($data);
        if(!empty($result)){
            return $result[0]->value;
        }else{
            unset($data);
            $data['table'] = 'set_default';
            $data['insert'] = ['vendor_id'=>$this->vendor_id,'request_id' => '1','value'=>'200'];
            $this->insertRecord($data);
        }
        return '200';
    }

    public function ActivePaymentMethod(){
        
        $data['table'] = 'payment_method as pm';
        $data['select'] = ['pm.*','pg.name','pg.type'];
        $data['join'] = ['payment_getway as pg'=>['pg.type=pm.payment_opt','LEFT']];
        $data['where'] = ['pm.branch_id'=> $this->branch_id,'pm.status'=>'1'];
        return $this->selectFromJoin($data);
    }

    function set_reserve_quantity($user_id){
        $this->db->query('LOCK TABLES `my_cart` WRITE,`order` WRITE,`order_details` WRITE,`product_weight` WRITE,`order_reservation` WRITE,`setting` WRITE,`user` WRITE,`selfPickup_otp` WRITE,`profit` WRITE,`user_address` WRITE;');
        $postdata['user_id'] = $user_id;
        $this->unreserve_product_userwise($user_id);
        sleep(0.751);
        $data['select'] = ['*'];
        $data['where'] = ['status !=' => '9','user_id'=>$user_id];
        $data['table'] = 'my_cart';
        $my_order_result = $this->selectRecords($data);
        if(empty($my_order_result)){
            $response = array();
            $gettotal = $this->get_total($postdata);
            $response["cart_count"] = (int)$gettotal[0]->cart_items;
            unset($_SESSION['My_cart']);
            $this->utility->setFlashMessage('danger',"Product is out of stock Or your cart is empty!");
            redirect(base_url().'products');
            // $response["success"] = 0;
            // $response["message"] = "Product is out of stock Or your cart is empty!";
            // $output = json_encode(array('responsedata' => $response));
            // echo $output;
            die;
        }
        foreach ($my_order_result as $my_order) {
            $variant_id = $my_order->product_weight_id;
            $cart_qty = $my_order->quantity;
            unset($data);
            $data['select'] = ['*'];
            $data['where'] = ['id'=>$variant_id];
            $data['table'] = 'product_weight';
            $get_variant = $this->selectRecords($data);           
            if(count($get_variant) > 0){
                $quantity = (int)$get_variant[0]->quantity;
                $my_order->avail_quantity = (int)$get_variant[0]->quantity;
                if((int)$cart_qty>$quantity){
                    $response = array();
                    $gettotal = $this->get_total($postdata);
                    $response["cart_count"] = (int)$gettotal[0]->cart_items;
                    unset($_SESSION['My_cart']);
                    $this->utility->setFlashMessage('danger',"Quantity is not available!!!");
                    redirect(base_url().'products');
                    // $response["success"] = 0;
                    // $response["message"] = "Quantity is not available!!!";
                    // $output = json_encode(array('responsedata' => $response));
                    // echo $output;
                    die;
                }
            }

        }

        foreach ($my_order_result as $my_order) {
            $variant_id = $my_order->product_weight_id;
            $cart_qty = $my_order->quantity;
            $quantity = (int)$my_order->avail_quantity;

                
            $updatedQTY = $quantity - $cart_qty;

            unset($data);
            $data['update'] = ['quantity'=>$updatedQTY,'dt_updated' => strtotime(date('Y-m-d H:i:s'))];
            $data['where'] = ['id'=>$variant_id];
            $data['table'] = 'product_weight';
            $this->updateRecords($data);

            unset($data);
            $data['update'] = ['is_reserved'=>'1','dt_updated' => strtotime(date('Y-m-d H:i:s'))];
            $data['where'] = ['id'=>$my_order->id];
            $data['table'] = 'my_cart';
            $this->updateRecords($data);

            if($updatedQTY <= 0){
                // unset($data);
                // $data['where'] = ['product_weight_id'=>$variant_id,'user_id !='=>$user_id,'is_reserved'=>'0'];
                // $data['table'] = 'my_cart';
                // $this->deleteRecords($data);
            }
            unset($data);
            $data['where'] = [                             
                                'user_id'=>$user_id,
                                'product_variant_id'=>$variant_id
                            ];
            $data['table'] = 'order_reservation';
            $this->deleteRecords($data);
            unset($data);
            $data['insert'] = [
                                'quantity'=>$cart_qty,
                                'user_id'=>$user_id,
                                'product_variant_id'=>$variant_id,
                                'dt_created'=>date('Y-m-d h:i:s')
                            ];
            $data['table'] = 'order_reservation';
            $this->insertRecord($data);

         
            $this->db->query('UNLOCK TABLES;');
           
          
        }
            return true;
    }

    function unreserve_product_userwise($user_id){
        sleep(0.751);
        $data['select'] = ['*'];
        $data['where'] = ['user_id'=>$user_id];
        $data['table'] = 'order_reservation';
        $select = $this->selectRecords($data);
        // print_r($select);die;
        foreach ($select as $key => $value) {
            unset($data);

            $data['select'] = ['*'];
            $data['where'] = ['id'=>$value->product_variant_id];
            $data['table'] = 'product_weight';
            $get_variant = $this->selectRecords($data);
            $quantity = (int)$get_variant[0]->quantity;
            $updatedQTY = $quantity + $value->quantity;
            unset($data);
            $data['update'] = ['quantity'=>$updatedQTY];
            $data['where'] = ['id'=>$value->product_variant_id];
            $data['table'] = 'product_weight';
            $this->updateRecords($data);
            unset($data);
            $data['where'] = ['id'=>$value->id];
            $data['table'] = 'order_reservation';
            $this->deleteRecords($data);


            unset($data);
            $data['update'] = ['is_reserved'=>'0'];
            $data['where'] = ['product_weight_id'=>$value->product_variant_id,'user_id'=>$value->user_id];
            $data['table'] = 'my_cart';
            $this->updateRecords($data);
        }
       // return true;
    }

    function get_total($postdata) {
        if (isset($postdata['user_id']) && $postdata['user_id'] != '') {
            $user_id = $postdata['user_id'];
        } else {
            if (isset($postdata['device_id'])) {
                $device_id = $postdata['device_id'];
            }
        }
        $data['select'] = ['sum(calculation_price) AS total', 'count(id) AS cart_items'];
        if (isset($user_id) && $user_id != 0 && $user_id != '') {
            $data['where'] = ['user_id' => $user_id];
        } else {
            if (isset($device_id)) {
                $data['where'] = ['device_id' => $device_id, 'user_id' => 0];
            }
        }
        $data['table'] = 'my_cart';
        $result = $this->selectRecords($data);
        return $result;
    }

    public function getSelfPickupTimeChart(){
        
        $data['table'] = TABLE_BRANCH;
        $data['select'] = ['selfPickUp','selfPickupOpenClosingTiming','currency_code'];
        $data['where'] = ['id'=>$this->branch_id,'status'=>'1'];
        return $this->selectRecords($data);
    }

    
    public function checkUserMobile(){
        $user_id = $this->session->userdata('user_id');
        $data['table'] = 'user';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$user_id];
        return $this->selectRecords($data);   

    }

    public function updatePhoneNumber($postdata){
        $user_id = $this->session->userdata('user_id');
        $mobile = $postdata['phoneNumber'];
        $country_code = $postdata['country_code'];
        $mobile_number = $country_code.''.$mobile;
        // $otp = $this->sendOtp($mobile_number);
        $otp = rand(1111,9999);

        $userData['select'] = ['*'];
        $userData['table'] = 'user';
        $userData['where'] = ['country_code' => $country_code,'phone'=>$mobile,'id !=' => $user_id,'status !=' =>'9','vendor_id'=>$this->vendor_id];
        $checkUniq = $this->selectRecords($userData);
        if(!empty($checkUniq)){
            return false;
         
        }
        unset($userData);
        $userData['select'] = ['*'];
        $userData['table'] = 'user';
        $userData['where'] = ['country_code' => $country_code,'phone'=>$mobile,'id' => $user_id,'status !=' =>'9','vendor_id'=>$this->vendor_id];
        $userDetail = $this->selectRecords($userData);

        // dd($userDetail);
        if($userDetail[0]->is_verify != '1'){

            if($_SERVER['SERVER_NAME'] == 'ori.launchestore.com' || $_SERVER['SERVER_NAME'] == 'ugiftonline.com' || $_SERVER['SERVER_NAME'] == 'www.ugiftonline.com'){
                $this->load->model('api_v3/api_model');
                $this->api_model->send_otp_int($mobile_number,$otp);
            }else{
                // echo '1';die;
                $this->sendOtp($mobile_number,$otp);
            }

            $data['table'] = 'user';
            $data['update'] = ['phone'=>$mobile,'otp'=>$otp,'country_code'=>$country_code];
           // print_r($data['update']);die;
            $data['where'] = ['id'=>$user_id,'status'=>'1'];
            $this->updateRecords($data);   
            return true; 
        }
        // else{
        //     $response["success"] = 0;
        //     $response["message"] = "This mobile number is linked with another account";
        //     return false;
        // }
    }

     public function OtpVerification($postdata){
        $user_id = $this->session->userdata('user_id');
        $otp = $postdata['otp'];
        $data['table'] = 'user';
        $data['where'] = ['id'=>$user_id,'status'=>'1','otp'=>$otp];
        $return =  $this->countRecords($data);   
        if($return > 0) {
            unset($data);
            $data['table'] = 'user';
            $data['update'] = ['is_verify'=>'1'];
            $data['where'] = ['id'=>$user_id,'status'=>'1'];
            $this->updateRecords($data);   
        }
        return $return;
    }


    private function sendOtp($mobile_number,$otp){
        // $mobile_number = '+91'.$mobile;
        $ch = curl_init();
        $sms = urlencode("Thank you for registration. Your OTP is ".$otp." CMEXPE");

        $url = "http://nimbusit.info/api/pushsms.php?user=104803&key=010UQmX0MjVAhakszP25&sender=CMEXPE&mobile=".$mobile_number."&text=".$sms."&entityid=1701163101500457392&templateid=1707163213124829525";

        // print_r($url);die;
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);
        return  true;
    }

      public function checkCurrencyCode(){
        $data['table'] = TABLE_BRANCH;
        $data['where'] = ['id'=>$this->branch_id,'status!='=>'9'];
        $data['select'] = ['*'];
        $res = $this->selectRecords($data);
        return  $res; 
    }

    public function send_otp_int($mobile_number){

        $accountSid = 'AC7feb595d1a3d1f813b0348c0aec36718'; //its testing
        $accountSid = TWILO_ACCOUNT_SID;
        $token = TWILO_TOKEN;
        $url = 'https://api.twilio.com/2010-04-01/Accounts/'.TWILO_ACCOUNT_SID.'/Messages.json';

        $otp = mt_rand('1000','9999');
        $data = [
         'From' => TWILO_PHONE_NUMBER,
         'To' => $mobile_number,
         'Body' => "Your Verification code is ".$otp,

        ];
        $post =  http_build_query($data);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_USERPWD, "$accountSid:$token");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);


        $response = curl_exec($curl);
        $response = json_decode($response);
        // print_r($response->message);exit;
        return $otp;
    }

    function validate_promocode($postData){
        $user_id = $this->session->userdata('user_id');
        $promocode = $postData['promocode'];
        $branch_id = $this->session->userdata('branch_id');
        $date = date('Y-m-d'); 
        $data['where'] = ['branch_id'=>$branch_id,'name'=>$promocode];
        $data['table'] = TABLE_PROMOCODE;
        $promocode = $this->selectRecords($data);
        $getMycartSubtotal = getMycartSubtotal();
        $sub_total = number_format((float)$getMycartSubtotal, 2, '.', '');
        $total_price = number_format((float)$sub_total, 2, '.', '');


        if(empty($promocode)){
            $response["success"] = 0;
            $response["message"] = "No Promocode Found"; 
            $response["orderAmount"] = $total_price;
            $response["withoutPromo"] = totalSaving();
            return $response;
        }

        if($date < $promocode[0]->start_date){
            $response["success"] = 0;
            $response["message"] = "Promocode is not started yet";  
            $response["orderAmount"] = $total_price;  
            $response["withoutPromo"] = totalSaving();
            return $response;
        }

        if($date > $promocode[0]->end_date){
            $response["success"] = 0;
            $response["message"] = "Promocode is expiered"; 
            $response["orderAmount"] = $total_price;  
            $response["withoutPromo"] = totalSaving(); 
            return $response;
        }

        unset($data);
      
       
       

        if($total_price < $promocode[0]->min_cart){
            $response["success"] = 0;
            $response["message"] = "Minimum ".$promocode[0]->min_cart.' amount is required';
            $response["orderAmount"] = $total_price; 
            $response["withoutPromo"] = totalSaving();     
            return $response;
        }

        if($total_price > $promocode[0]->max_cart){
            $response["success"] = 0;
            $response["message"] = "Maximum ".$promocode[0]->max_cart.' Cart amount is required'; 
            $response["orderAmount"] = $total_price;   
            $response["withoutPromo"] = totalSaving();
            return $response;
        }

        unset($data);
        $data['select'] = ['count(*) as count'];
        $data['where'] = ['promocode_id' => $promocode[0]->id];
        $data['table'] = TABLE_ORDER_PROMOCODE;
        $order_promocode = $this->selectRecords($data); 

        if($order_promocode[0]->count >= $promocode[0]->max_use){
            $response["success"] = 0;
            $response["message"] = "Promocode is reached limit";   
            $response["orderAmount"] = $total_price;  
            $response["withoutPromo"] = totalSaving(); 
            return $response;
        }

        $calculate = ($total_price / 100 ) * $promocode[0]->percentage;

        $response["success"] = 1;
        $response["message"] = "Promocode applied";   
        $response["data"] = $calculate;   
        $response["orderAmount"] = floatval($total_price);   
        $response["withoutPromo"] = totalSaving();
        return $response;

    }


}

?>