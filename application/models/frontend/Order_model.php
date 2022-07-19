<?php 

Class Order_model extends My_model{

	public function selectOrders(){
        
        
		$data['table'] = TABLE_ORDER; 
		$data['select'] = ['*'];
		$data['where'] = [
						'user_id'=> $this->session->userdata('user_id'),
						'status !=' => '9',
					 ];
        $data['order'] = 'id DESC';
		return $this->selectRecords($data);
	}

    public function selectOrdersfor($id){
        
        
        $data['table'] = TABLE_ORDER; 
        $data['select'] = ['*'];
        $data['where'] = [
                        'id' => $id,
                        'status !=' => 9,
                     ];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
    }

    public function checkProductQuantityAvailabale(){
        $user_id = $this->session->userdata('user_id');
        $branch_id = $this->session->userdata('branch_id');
        $data['table'] = 'my_cart';
        $data['select'] = ['*'];
        $data['where'] = ['user_id'=>$user_id,'branch_id'=>$branch_id];
        $res = $this->selectRecords($data);
        unset($data);
        foreach ($res as $key => $value) {
            $data['table'] = 'product_weight';
            $data['select'] = ['*'];
            $data['where'] = ['status !='=>'9','id'=>$value->product_weight_id,'quantity >='=>$value->quantity];
            $r = $this->selectRecords($data);
            // echo $this->db->last_query(); die;
            if(count($r)<=0){
                return false;
            }
        }
        return true;
    }


    public function makeOrder($fromStripe = ''){
      $this->load->model('api_v3/Api_model','api_v3_model');
      $user_id = $this->session->userdata('user_id');
      $branch_id = $this->session->userdata('branch_id');
      $vendor_id = $this->session->userdata('vendor_id');
      $data['table'] = TABLE_USER;
      $data['select'] = ['*'];
      $data['where'] = ['id'=>$user_id];
      $res = $this->selectRecords($data);
      // $user_gst_number = $res[0]->user_gst_number; 
        // $device_id = $_REQUEST['device_id']; 
      $user_gst_number = '';
      $user_address_id = '';
      $paymentMethod = '';
      if(isset($_SESSION['isSelfPickup']) && $_SESSION['isSelfPickup'] == '1'){
        $address = 'self pick';
        $this->load->model('api_v3/api_model','api_v3_model');
        $user = $this->api_v3_model->getUserDetails($user_id);
    }else{
        $userDetails = $this->getAddress();
        $address = $userDetails[0]->address.' '.$userDetails[0]->city.' '.$userDetails[0]->state.' '.$userDetails[0]->country;
        $user_address_id = $userDetails[0]->id;
    }


        $payment_type = '0'; // COD
        if(isset($_REQUEST['payment_type'])){
            $payment_type = $_POST['payment_type'];
        }
        $time_slot_id = '0';
        if(isset($_REQUEST['time_slot_id'])){
            $time_slot_id = $_POST['time_slot_id'];
        }else{
            $time_slot_id = '12';
        }
        if(isset($_REQUEST['delivery_date'])){
            $delivery_date = $_POST['delivery_date'];
        }
        if(isset($_REQUEST['user_gst_number'])){
            $user_gst_number = $_POST['user_gst_number'];
        }
        if(isset($_REQUEST['user_gst_number'])){
            $user_gst_number = $_POST['user_gst_number'];
        }
        if(isset($_REQUEST['promocode'])){
            $promocode = $_POST['promocode'];
        }
        
        /*start  payment from strpe*/
        if(!empty($fromStripe['delivery_date'])){
            $delivery_date = $fromStripe['delivery_date'];
        }
        if(!empty($fromStripe['payment_type'])){
            $payment_type = $fromStripe['payment_type'];
        }
        if(!empty($fromStripe['paymentMethod']) ){
            $paymentMethod = $fromStripe['paymentMethod'];
        }
        if(!empty($fromStripe['time_slot_id']) ){
            $time_slot_id = $fromStripe['time_slot_id'];
        }
        if(!empty($fromStripe['user_gst_number']) ){
            $user_gst_number = $fromStripe['user_gst_number'];
        }
        $orderId_payment_gateway = '';
        if(!empty($fromStripe['orderId_payment_gateway']) ){
            $orderId_payment_gateway = $fromStripe['orderId_payment_gateway'];
        }
        /* End payment from strpe*/



        $branch_id = $this->session->userdata('branch_id');
        $userAddressLatLong = $this->getUserAddressLatLong();
        $delivery_charge = 0;

        if(!isset($_SESSION['isSelfPickup']) || $_SESSION['isSelfPickup'] == '0'){
            $userlat = $userAddressLatLong[0]->latitude;
            $userlong = $userAddressLatLong[0]->longitude;
            $delivery_charge = $this->getDeliveryCharge($userlat,$userlong,$branch_id);

        }

          

        $profit_per = 0;
        $get_persentage = $this->get_profit_per();
        if($get_persentage > 0){
           $profit_per = $get_persentage;
       }

       if(isset($branch_id)){
         $this->db->query('LOCK TABLES my_cart WRITE,`order` WRITE,`order_details` WRITE,product_weight WRITE,`order_reservation` WRITE,`setting` WRITE,`user` WRITE,`selfPickup_otp` WRITE,`profit` WRITE,`user_address` WRITE,`order_log` WRITE,`promocode` WRITE,`order_promocode` WRITE;');

        // sleep(0.751);

        /*$delivery_charge_query = $this->db->query("SELECT price FROM setting WHERE title = 'delivery_charge' AND vendor_id = '$vendor_id'");

        $delivery_charge_result = $delivery_charge_query->row_array();*/
        
        $this->load->model('frontend/product_model');
        $myCart = $this->product_model->getMyCartOrder();
        $sub_total = 0;
        $total_savings = 0;
        foreach ($myCart as $key => $value) {
            $sub_total += $value->discount_price * $value->quantity;
            $total_savings += ($value->actual_price - $value->discount_price) * $value->quantity ;
        }

      

        $sub_total = number_format((float)$sub_total, 2, '.', '');
        $total_savings = number_format((float)$total_savings, 2, '.', '');
        $total_item = count($myCart);
        $total_price = number_format((float)$sub_total, 2, '.', '');




        /*Generate Order Number*/
        function random_orderNo( $length = 10 ) {
            $chars = "1234567890";
            $order = substr( str_shuffle( $chars ), 0, $length );
            return $order;
        }
        $od = 'Order #';
        $on = random_orderNo(15);
        $iOrderNo = $od.$on;
        $transaction_id = '';
        if(!empty($fromStripe['balance_transaction'])){
            $transaction_id = $fromStripe['balance_transaction'];
        }

        
       

        $my_order_result = $this->product_model->getMyCartOrder();
        // echo "<pre>";
        // print_r($my_order_result);die;

        $promocode_amount = 0;

          if(isset($promocode) && $promocode !=''){
                    unset($data);
                    $data['where'] = ['branch_id'=>$branch_id,'name'=>$promocode];
                    $data['table'] = TABLE_PROMOCODE;
                    $promocodeData = $this->selectRecords($data);

                    if(!empty($promocodeData)){
                        $promocode_amount =  ($total_price / 100 ) * $promocodeData[0]->percentage;
                    }
                }
                

        if(!empty($my_order_result)){
            foreach ($my_order_result as $my_order) {
                $var_id = $my_order->product_weight_id;
                $qnt = $my_order->quantity;
                $updatedQTY = $this->check_udpate_quantity($var_id,$qnt,$user_id);
                if(!$updatedQTY){
                    continue;
                }
            }
                /*Order*/
                $data = array(
                    'order_from' => '1',
                    'user_id' => $user_id,
                    'branch_id' => $branch_id,
                    'user_address_id' => $user_address_id,
                    'time_slot_id' => $time_slot_id,
                    'payment_type' => $payment_type,
                    'total_saving' => $total_savings,
                    'total_item' => $total_item,
                    'sub_total' => $sub_total,
                    'user_gst_number'=>$user_gst_number,
                    'delivery_charge' => $delivery_charge,
                    'total' => $total_price,
                    'payable_amount' => $total_price+$delivery_charge- $promocode_amount,
                    'order_no' => $iOrderNo,
                    'isSelfPickup'=>(!isset($_SESSION['isSelfPickup']) || $_SESSION['isSelfPickup'] =='0') ? '0' :'1',
                    'delivery_date'=>$delivery_date,
                    'orderId_payment_gateway'=> $orderId_payment_gateway,
                    'payment_transaction_id'=>$transaction_id,
                    'paymentMethod'=>$paymentMethod,
                    'name'=>(isset($userDetails) && !empty($userDetails)) ? $userDetails[0]->name : $user[0]->fname,
                    'mobile'=>(isset($userDetails) && !empty($userDetails)) ? $userDetails[0]->phone : $user[0]->phone,
                    'delivered_address'=>$address,
                    'status' => '1',
                    'order_status' => '1',
                    'promocode_used'=> (isset($promocode_amount) && $promocode_amount > 0)?1:0,
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );

                $this->db->insert('order', $data);
                $last_insert_id = $this->db->insert_id();
                $otpForSelfPickup = '';
                // if(isset($_SESSION['isSelfPickup']) && $_SESSION['isSelfPickup'] == '1'){
                    $otpForSelfPickup = rand(1000,9999);
                    $this->load->model('api_v3/api_model','api_v3_model');
                    $this->api_v3_model->selfPickUp_otp($last_insert_id,$user_id,$otpForSelfPickup);
                // }

                $this->load->model('api_v3/api_admin_model','api_v3_api_admin_model');
                $order_log_data = array('order_id' => $last_insert_id,'branch_id'=>$branch_id,'status'=>'1');
                $this->api_v3_api_admin_model->order_logs($order_log_data);

            foreach ($my_order_result as $my_order){
                 
                  $var_id = $my_order->product_weight_id;
                  $qnt =  $my_order->quantity;
                  if((int)$qnt<0){
                        $qnt = 0;   
                    }

                // $qnt_query = $this->db->query("UPDATE product_weight SET quantity = quantity -  $qnt,temp_quantity = temp_quantity - $qnt WHERE status != '9' AND id = '$var_id'");
                
                $data = array(
                    'order_id' => $last_insert_id,
                    'branch_id' => $my_order->branch_id,
                    'user_id' => $my_order->user_id,
                    'product_id' => $my_order->product_id,
                    'weight_id' => $my_order->weight_id,
                    'product_weight_id' => $my_order->product_weight_id,
                    'quantity' => $my_order->quantity,
                    'actual_price' => $my_order->actual_price,
                    'discount' => $my_order->discount_per,
                    'discount_price' => $my_order->discount_price,
                    'calculation_price' => ($my_order->discount_price * $my_order->quantity),
                    'status' => '1',
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $this->db->insert('order_details', $data);
                $last_order_d_id = $this->db->insert_id();
                $total_profit = (($my_order->discount_price * $my_order->quantity) * $profit_per) / 100;
                $this->insert_profit($last_insert_id,$last_order_d_id,$my_order->branch_id,$total_profit);
            //  $this->this_model->update_quantity($my_order->product_weight_id,$my_order->quantity);
            }
             if(isset($promocode) && $promocode !=''){
                    
                    if(!empty($promocodeData)){
                        $promocode_id = $promocodeData[0]->id;
                        $promocode_name = $promocodeData[0]->name;
                        $promocode_percentage = $promocodeData[0]->percentage;
                        unset($data);
                        $data['insert'] =[
                                            'order_id'=>$last_insert_id,
                                            'promocode_id'=>$promocode_id,
                                            'promocode_name'=>$promocode_name,
                                            'percentage'=>$promocode_percentage,
                                            'amount'=>$promocode_amount,
                                            'dt_created'=>DATE_TIME,
                                            'dt_updated'=>DATE_TIME
                                        ];
                        $data['table'] = TABLE_ORDER_PROMOCODE;
                        $this->insertRecord($data);
                    }
                }

        }else{
            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Your Cart is Empty";
            $output = json_encode(array('responsedata' => $response));
            return $output; 
            exit;
        }

        /*Remove From My Cart*/
        $this->db->query('UNLOCK TABLES;');
        $this->db->query("DELETE FROM my_cart WHERE user_id = '$user_id'  AND branch_id = '$branch_id'");
        $message = 'new order '.$iOrderNo ;
        $branchNotification = array(
            'order_id'         =>  $last_insert_id,
            'branch_id'          =>  $branch_id,
            'notification_type'=> 'new_order',
            'message'          => $message,
            'status'           =>'0',
            'dt_created'       => DATE_TIME,
            'dt_updated'       => DATE_TIME
        );
        $this->api_v3_model->pushAdminNotification($branchNotification);
        $response = array();
        $response ["success"] = 1;
        $response ["message"] = "Thank you for your order";
        $response ["order_number"] = $iOrderNo;
        $output = json_encode(array('responsedata' => $response));
        
        $this->api_v3_model->send_staff_notification($branch_id,"New Order In Your store");
        $this->api_v3_model->emailTemplate($user_id,$branch_id,$last_insert_id);
        
        $this->session->unset_userdata('isSelfPickup');
        $this->session->unset_userdata('My_cart');
        return $output;

    }else{
       $response = array();
       $response["success"] = 0;
       $response["message"] = "Invalid data";
       $output = json_encode(array('responsedata' => $response));
        return $output;
    }
    
}

    function check_udpate_quantity($variant_id,$cart_qty,$user_id){

        sleep(0.951);
        // file_put_contents("/cartcheck.txt","cartIn ".$user_id);
       $user_id = $this->session->userdata('user_id');
       $this->load->model('frontend/checkout_model','checkout_model');
       $this->checkout_model->unreserve_product_userwise($user_id);
       
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$variant_id];
        $data['table'] = 'product_weight';
        $get_variant = $this->selectRecords($data);
        if(count($get_variant) >0){
            $quantity = (int)$get_variant[0]->quantity;
            $temp_quantity = (int)$get_variant[0]->quantity;
            if((int)$cart_qty>$quantity){
                $response = array();
                $postdata['user_id'] = $user_id;
                unset($_SESSION['My_cart']);
                $this->utility->setFlashMessage('danger',"Quantity is not available!!!");
                redirect(base_url().'frontend/product');
                // $response["success"] = 0;
                // $response["message"] = "Quantity is not available!!!";
                // $output = json_encode(array('responsedata' => $response));
                // return $output;
                die;
            }
            $updatedQTY = $quantity - $cart_qty;
            $updatedtmpqty = $temp_quantity - $cart_qty;
            // if($updatedQTY <= 0){
            //     unset($data);
            //     $data['where'] = ['product_weight_id'=>$variant_id,'is_reserved'=>'0'];
            //     $data['table'] = 'my_cart';
            //     $this->deleteRecords($data);
            // }
            unset($data);
            $data['update'] = ['quantity'=>$updatedQTY,'temp_quantity'=>$updatedtmpqty];
            $data['where'] = ['id'=>$variant_id];
            $data['table'] = 'product_weight';
            $this->updateRecords($data);

            return true;
        }
        return false;        
    }

	public function getAddress(){
		$data['table'] = TABLE_USER_ADDRESS;
    	$data['select'] = ['*'];
    	$data['where'] = ['user_id'=>$this->session->userdata('user_id'),'status'=>'1'];
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
        $data['where'] = ['start_range <=' => $getkm, 'end_range >=' => $getkm,'vendor_id'=>$this->session->userdata('vendor_id')];
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


     //check profit persentage %%
    function get_profit_per()
    {
        $data['select'] = ['value'];
        $data['where'] = ['request_id' => '2','vendor_id'=>$this->session->userdata('vendor_id')];
        $data['table'] = 'set_default';
        $result = $this->selectRecords($data);
        if (count($result) > 0) {
            return $result[0]->value;
        }
    }

      function insert_profit($order_id, $order_d_id, $branch_id, $total_profit)
    {
        $date = date('Y-m-d H:i:s');
        $data['insert'] = array(
            'order_id' => $order_id,
            'order_detail_id' => $order_d_id,
            'branch_id' => $branch_id,
            'total_profit' => $total_profit,
            'dt_created' => $date,
            'dt_updated' => $date
        );
        $data['table'] = 'profit';
        $this->insertRecord($data);
    }

    public function selectOrderDetails($id){
        $data['table'] = TABLE_ORDER_DETAILS; 
        $data['select'] = ['*'];
        $data['where'] = [
                        'order_id' => $id,
                        'user_id'=> $this->session->userdata('user_id'),
                        'branch_id'=>$this->session->userdata('branch_id'),
                        'status !=' => '9'
                     ];
        return $this->selectRecords($data);

    }
    public function selectproductname($id){
            $data['table'] = TABLE_PRODUCT;
            $data['select'] = ['name'];
            $data['where']['id'] = $id;
           return $this->selectRecords($data);
    }

     public function select_product_image($id){
            $data['table'] = TABLE_PRODUCT_IMAGE;
            $data['select'] = ['image'];
            $data['where'] = ['product_variant_id'=> $id,'branch_id'=>$this->session->userdata('branch_id')];
          return $return = $this->selectRecords($data);
           return $return[0]->image;
    }

    public function user_address($add_id){
        $data['table'] = TABLE_USER_ADDRESS;
        $data['select'] = ['*'];
        $data['where'] = ['id' => $add_id,'status !='=> 9];
        return $this->selectRecords($data);

    }
    public function getUserEmail(){
        $data['table'] = TABLE_USER;
        $data['select'] = ['email'];
        $data['where'] = ['id' => $this->session->userdata('user_id'),'status !=' => 9];
        return $this->selectRecords($data);

    }

    function cancle_order($postdata) {
        $order_id = $postdata['order_id'];
        $data['select'] = ['branch_id','order_status','order_no'];
        $data['where'] = ['id' => $order_id];
        $data['table'] = 'order';
        $get = $this->selectRecords($data);
        $branch_id = $get[0]->branch_id;
        $order_no = $get[0]->order_no;
        if(count($get)>0){
            if($get[0]->order_status=='8'){
                return false;
            }
            
            $send_status = 'Cancelled';
            $type = 'order_cancelled';
            $message = $order_no .' is '.$send_status;
            $branchNotification = array(
                'order_id'         =>  $order_id,
                'branch_id'          =>  $branch_id,
                'notification_type'=> $type,
                'message'          => $message,
                'status'           =>'0',
                'dt_created'       => DATE_TIME,
                'dt_updated'       => DATE_TIME
            );
            $this->load->model('api_v3/api_model','api_v3_model');
            $this->api_v3_model->pushAdminNotification($branchNotification);    
            $this->cancle_order_quntity_reset($order_id);
            unset($data);
            $date = strtotime(DATE_TIME);
            $data['update'] = ['order_status' => '9', 'dt_updated' => $date];
            $data['where'] = ['id' => $order_id];
            $data['table'] = 'order';
            $this->updateRecords($data);
            unset($data);
            $data['where'] = ['order_id' => $order_id];
            $data['table'] = 'delivery_order';
            $this->deleteRecords($data);
            $data['table'] = 'selfPickup_otp';
            $this->deleteRecords($data);
            return true;
        }else{
            return false;
        }
    }
        
    function cancle_order_quntity_reset($order_id){
        
        $data['select'] = ['*'];
        $data['where'] = ['order_id'=>$order_id];
        $data['table'] = 'order_details';
        $select = $this->selectRecords($data);
        // print_r($select);die;
        foreach ($select as $key => $value) {
            unset($data);

            $data['select'] = ['*'];
            $data['where'] = ['id'=>$value->product_weight_id];
            $data['table'] = 'product_weight';
            $get_variant = $this->selectRecords($data);
            $quantity = (int)$get_variant[0]->quantity;
            $updatedQTY = $quantity + (int)$value->quantity;
            unset($data);
            $data['update'] = ['quantity'=>$updatedQTY];
            $data['where'] = ['id'=>$value->product_weight_id];
            $data['table'] = 'product_weight';
            $this->updateRecords($data);
            unset($data);
            // $data['update'] = ['status'=>'9'];
            // $data['where'] = ['id'=>$value->id];
            // $data['table'] = 'order_details';
            // $this->updateRecords($data);

        }
        // die;
       return true;
    }

}

?>