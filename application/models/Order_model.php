<?php

class Order_model extends My_model
{
    
    public function getOrderList(){
        $branch_id = $this->session->userdata['id'];
        $data['table'] = 'order as o';
        $data['select'] =  ['o.*','u.fname', 'u.lname','c.customer_name'];
        $data['join'] = [
                        'user as u'=>['u.id = o.user_id','LEFT'],
                        'customer as c'=>['c.id=o.customer_id','LEFT']
                        ];
        $data['where'] = ['o.status !='=>'9','o.branch_id'=>$branch_id];
        $data['order'] = 'o.id DESC';
        return $this->selectFromJoin($data);
    }

    public function order_detail_query($order_id){
        $data['table'] = 'order_details as od';
        $data['select'] =  ['od.*','u.id as user_id','u.fname','u.lname','u.email','w.name as weight_name','p.name as product_name','pw.weight_no','pk.package','o.delivery_date','t.start_time','t.end_time'];
        $data['join'] = [
                        'order as o'=>['o.id = od.order_id','LEFT'],
                        'user as u'=>['u.id = od.user_id','LEFT'],
                        'weight as w'=>['w.id=od.weight_id','LEFT'],
                        'product as p'=>['p.id=od.product_id','LEFT'],
                        'product_weight as pw'=>['pw.id=od.product_weight_id','LEFT'],
                        'package as pk'=>['pk.id=pw.package','LEFT'],
                        'time_slot as t'=>['t.id=o.time_slot_id','LEFT'],
                        ];
        $data['where'] = ['od.status !='=>'9','od.order_id'=>$order_id];
        $data['order'] = 'od.id DESC';
        return $this->selectFromJoin($data);    
    }

    public function userDetails($user_id){
        $data['table'] = 'user_address as ua';
        $data['where'] = ['ua.user_id'=>$user_id];
        $data['select'] = ['ua.name','ua.address','city','ua.state','ua.country','ua.phone'];
        $result = $this->selectRecords($data);
        return $result[0]; 
    }

    public function user($user_id){
        $data['table'] = 'user';
        $data['where'] = ['id'=>$user_id];
        $data['select'] = ['*'];
        $result = $this->selectRecords($data);
        return $result[0]; 
    }

    public function checkSelfPickUpOtpIsVerified($order_id){
        $data['table'] = 'selfPickup_otp';
        $data['where'] = ['order_id'=>$order_id];
        $data['select'] = ['*'];
        $result = $this->selectRecords($data);
        return $result;
        if(!empty($result)){
            return $result[0]->status;   
        }
        return 0;
    }

    public function vendorDetail($vendor_id){
        $data['table'] = 'vendor'; 
        $data['where'] = ['id'=>$vendor_id];
        $data['select'] = ['*']; 
        $result = $this->selectRecords($data);
        return $result[0];
    }

    public function orderDetails($order_id){
        $data['table'] = 'order as o';
        $data['select'] = ['o.payable_amount','o.sub_total','o.order_status','o.order_no','o.delivery_charge','op.percentage','op.amount as promocodeAmount'];
        $data['where'] = ['o.id'=>$order_id];
        $data['join'] = [TABLE_ORDER_PROMOCODE.' as op' =>['op.order_id = o.id','left']];
        $result =  $this->selectFromJoin($data);
        return $result[0];
    }

    public function queryCurrency(){
        $data['table'] = 'set_default';
        $data['select'] = 'value';
        $data['where'] = ['request_id' => '3'];
        $result = $this->selectRecords($data,true);
        return $result[0];
    }

    public function single_delete_order()
    {
        $id = $_GET['id'];
        $data = array('status' => '9', 'dt_updated' => strtotime(date('Y-m-d H:i:s')));

        $this->db->where('id', $id);
        $this->db->update('order', $data);

        $this->db->where('order_id', $id);
        $this->db->update('order_details', $data);

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status' => 1]);
        exit;
    }

    ## Setting Multi Delete ##
    public function multi_delete_order()
    {
        $id = $_GET['ids'];
        $date = strtotime(date('Y-m-d H:i:s'));

        $this->db->query("UPDATE `order` SET status = '9', dt_updated = '$date' WHERE id IN ($id)");
        $this->db->query("UPDATE order_details SET status = '9', dt_updated = '$date' WHERE order_id IN ($id)");

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status' => 1]);
        exit;
    }

    ////////////////////////////////////////////////ORDERS DETAILS//////////////////////////////////////////////////////

    # Setting Single Delete ##
    public function single_delete_order_detail()
    {
        $id = $_GET['id'];
        $data = array('status' => '9', 'dt_updated' => strtotime(date('Y-m-d H:i:s')));

        $this->db->where('id', $id);
        $this->db->update('order_details', $data);

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status' => 1]);
        exit;
    }

    ## Setting Multi Delete ##
    public function multi_delete_order_detail()
    {
        $id = $_GET['ids'];
        $date = strtotime(date('Y-m-d H:i:s'));

        $this->db->query("UPDATE order_details SET status = '9', dt_updated = '$date' WHERE id IN ($id)");

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status' => 1]);
        exit;
    }

    public function change_order_status()
    {
        $order_id = $_POST['order_id'];
        $data['select'] = ['branch_id','order_status','payment_type','paymentMethod','order_no'];
        $data['where'] = ['id' => $order_id];
        $data['table'] = 'order';
        $results = $this->selectRecords($data);
        $branch_id = $results[0]->branch_id; 
        $order_no = $results[0]->order_no; 
         $this->order_logs($_POST); // insert Order logs;

        if (count($results) > 0) {
            if ($results[0]->order_status == '9') {
                ob_get_clean();
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');
                echo json_encode(['status' => 9]);
                exit;
            }
        }


        $status = $_POST['status'];

        if($status=='9' && $results[0]->payment_type == '1'){
            
            if($results[0]->paymentMethod == 3){
             // paytm
                $respons = $this->refundPaymentPaytm($order_id);
            }else
            if($results[0]->paymentMethod == 1){
             // razar
                $respons = $this->refundPaymentRazar($order_id);
            }else
            if($results[0]->paymentMethod == 2){
                $respons = $this->refundPaymentStripe($order_id);   
            } 
        }
        if($status=='9' || $status=='8'){
            if ($status == '8') {
                $send_status = 'Delivered';
                $type = 'order_delivered';
            }
            if ($status == '9') {
                $send_status = 'Cancelled';
                $type = 'order_cancelled';
            }
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
       }



        $date = strtotime(DATE_TIME);

         $this->db->query("UPDATE `order` SET order_status = '$status',dt_updated = '$date' WHERE id = '$order_id'");

        // echo $this->db->last_query();die;
        if ($status == '4') {
            $this->db->query("UPDATE `order_details` SET delevery_status = '1',dt_updated = '$date' WHERE order_id = '$order_id'");
        }

       
        $this->send_notificaion($order_id);

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status' => 1]);
        exit;
    }

     public function order_logs($postData){
       
        $data['table'] = 'order_log';
        $insertData = array(
            'order_id' => $postData['order_id'],
            'order_status'=> $postData['status'],
            'branch_id'=> $this->session->userdata('id'),
            'dt_created'=>DATE_TIME
        );
        // print_r($insertData);die;       
        $data['insert'] = $insertData;
        $this->insertRecord($data);
        return true; 
    }

    public function send_notificaion($order_id)
    {
           
        $data['select'] = ['o.user_id', 'd.token', 'd.type', 'd.device_id', 'u.notification_status', 'o.order_status', 'o.order_no','o.branch_id'];
        $data['where'] = ['o.id' => $order_id];
        $data['table'] = 'order AS o';
        $data['join'] = [
            'device AS d' => [
                'd.user_id = o.user_id',
                'LEFT'
            ],
            'user AS u' => [
                'u.id = o.user_id',
                'LEFT'
            ],
        ];
        $send = $this->selectFromJoin($data);
        $order_status = $send[0]->order_status;
        $branch_id = $send[0]->branch_id;
        if ($order_status == '1') {
            $send_status = 'New Order';
        }
        if ($order_status == '2') {
            $send_status = 'Pending for Ready';
        }
        if ($order_status == '3') {
            
            $send_status = 'Ready For Deliver';
            $this->load->model('api_v3/delivery_api_model','api_v3_delivery');
            $this->api_v3_delivery->send_notification($order_id);
        }
        if ($order_status == '4') {
            $send_status = 'Pick Up';
        }
        if ($order_status == '5') {
            $send_status = 'On the way';
        }
        if ($order_status == '8') {
            $send_status = 'Delivered';
        }
        if ($order_status == '9') {
            $send_status = 'Cancelled';
        }

        $message = 'Your ' . $send[0]->order_no . ' is ' . $send_status;
        $notification_type = 'order_status';

        $user_id = $send[0]->user_id;

        // echo $this->db->last_query();exit();
        $this->insert_notification($user_id, $message, $notification_type, $order_id);
        unset($data);
        if ($send) {
            if ($send[0]->notification_status == '1') {
                $dataArray = array(
                    'device_id' => $send[0]->token,
                    'type' => $send[0]->type,
                    'message' => $message,
                );

                  $this->load->model('api_v3/api_model','api_v3_model');
                $result = $this->api_v3_model->getNotificationKey($branch_id);
                $this->utility->sendNotification($dataArray, $notification_type,$result);
            }
        }

    }

    public function insert_notification($user_id, $message, $notification_type = NULL, $type_id = NULL)
    {
        $insertion = array(
            'user_id' => $user_id,
            'notification_for' => $notification_type,
            'for_id' => $type_id,
            'notification' => $message,
            'dt_created' => date('Y-m-d h:i:s'),
            'dt_updated' => date('Y-m-d h:i:s'),
        );
        $data['insert'] = $insertion;
        $data['table'] = 'notification';
        $this->insertRecord($data);
        return true;
    }

    public function checkLatestOrderStaus($postData){
        $id = $postData['id'];
        $data['table'] = TABLE_ORDER;
        $data['where'] = ['id'=>$id];
        $data['select'] = ['*'];
        $result = $this->selectRecords($data);
        return $result;
    }

    public function verify_otp()
    {

        $id = $this->input->post('id');
        $otp = $this->input->post('otp');


        $data['update']['otp_verify'] = '1';
        $data['where'] = ['order_id' => $id, 'otp' => $otp];
        $data['table'] = 'delivery_order';

        $res = $this->updateRecords($data);
        // echo $this->db->last_query();die;

        if ($res) {
            unset($data);
            $data['update']['order_status'] = '5';
            $data['where'] = ['id'=>$id];
            $data['table'] = 'order';
            $re = $this->updateRecords($data);

            $this->load->model('api_v3/api_admin_model');
            $order_log_data = array('order_id' => $id, 'status'=> '5');
            $this->api_admin_model->order_logs($order_log_data);
            // return 1
            echo "1";
            exit;
        } else {
            return 0;
            echo "0";
            exit;
        }
    }

    public function  verify_otp_selfPickup($postdata){
        // error_reporting(E_ALL);
        // ini_set("display_errors", "1");
        // dd($postdata);die;
        $otp = $postdata['otp'];
        $order_id = $postdata['id'];
        $isSelfPickup = $postdata['isSelfPickup'];

        $status = '8';

        $data['select'] = ['*'];
        $data['where'] = ['order_id' => $order_id, 'otp' => $otp];
        $data['table'] = 'selfPickup_otp';
        $res = $this->selectRecords($data, true);
          if($res) {
            unset($data);
            $date = strtotime(DATE_TIME);
            $data['update']['order_status'] = $status;
            $data['update']['dt_updated'] = $date;
            $data['where'] = ['id' => $order_id];
            $data['table'] = 'order';
            $this->updateRecords($data);

            unset($data);

            if($status == '8'){
                $this->load->model('api_v3/api_admin_model','api_v3_api_admin_model');
                $order_log_data = array('order_id' => $order_id, 'status'=> $status);
                $this->api_v3_api_admin_model->order_logs($order_log_data);
            }
            $data['update']['status'] = '1';
            $data['where'] = ['order_id' => $order_id];
            $data['table'] = 'selfPickup_otp';
            $this->updateRecords($data);

            $this->send_notificaion($order_id);
            echo "1";
            exit;
            // print_r($res);die;
        } else {
            echo "0";
            exit;
        }
    }

public  $order_column_order = array("o.order_no","o.dt_added","u.fname","u.lname","c.name","o.payable_amount");  
    function make_query_order($postData){
        $branch_id = $this->session->userdata('id');
        $where = [
            'o.branch_id'=>$branch_id,
            'o.status !='=>'9',
        ];
         $this->db->select('o.*,u.fname,u.lname,c.customer_name');  
         $this->db->from('order as o');
         $this->db->join('user as u','u.id = o.user_id','LEFT');
         $this->db->join('customer as c','c.id=o.customer_id','LEFT');
         $this->db->where($where);
        $this->db->order_by('dt_updated DESC');
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
        $this->db->group_start();
            $this->db->like("u.fname", $postData["search"]["value"]);
            $this->db->or_like("u.lname", $postData["search"]["value"]);
            $this->db->or_like("c.customer_name", $postData["search"]["value"]);
            $this->db->or_like("o.order_no", $postData["search"]["value"]);
            $this->db->or_like("o.dt_added", $postData["search"]["value"]);
            $this->db->or_like("o.payable_amount", $postData["search"]["value"]);
        $this->db->group_end(); 
        }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('o.id', 'DESC');  
           } 
    }


    function make_datatables_order($postData){ 
        $this->make_query_order($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            // echo $this->db->last_query();
        }

    function get_filtered_data_order($postData = false){  
        $this->make_query_order($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }    

    function get_all_data_order($postData = array()){
        $branch_id = $this->session->userdata('id');
            $where = [
                'o.branch_id'=>$branch_id,
                'o.status !='=>'9',
            ];
         $this->db->select('o.*,u.fname,u.lname,c.customer_name');  
         $this->db->from('order as o');
         $this->db->join('user as u','u.id = o.user_id','LEFT');
         $this->db->join('customer as c','c.id=o.customer_id','LEFT');
         $this->db->where($where);
        return $this->db->count_all_results(); 
           // echo $this->db->last_query();
    }

    
    public function getOrderLog($postdata){
        $order_id = $postdata['order_id'];
        $data['select'] = ['*'];
        $data['where'] = ['order_id' => $order_id];
        $data['table'] = 'order_log';
        $res = $this->selectRecords($data);
        return $res;
    }

     public function getOrderReportForDate($original_date = ''){
            

            if($original_date == ''){
                $original_date = date('m-d-Y');
            }

            $parts_from = explode('/', $original_date);
            $date_ = $parts_from[1] . '-' . $parts_from[0] . '-' . $parts_from[2];
            $date = strtotime(date("Y-m-d 00:00:00",strtotime($date_)));
            $data['select'] = ['id','name'];
            $data['where']['branch_id'] = $this->session->userdata('id');
            $data['table'] = 'product';
            $res = $this->selectRecords($data);
            unset($data);
            if($date != strtotime(date("Y-m-d 00:00:00"))){
                $endDate = strtotime(date('Y-m-d', strtotime($date_ .' +1 day')));
                $data['where']['o.dt_added <='] = $endDate;
            }


            foreach ($res as $key => $value) {
                $data['table'] = 'order as o';
                $data['select'] =  ['od.*','w.name as weight_name','p.name as product_name'];
                $data['join'] = [
                    'order_details as od'=>['od.order_id=o.id','INNER'],
                    'weight as w'=>['w.id=od.weight_id','INNER'],
                    'product as p'=>['p.id=od.product_id','INNER'],
                ];

                $data['where']['o.branch_id'] = $this->session->userdata('id');
                $data['where']['o.dt_added >='] = $date;
                $data['where']['od.product_id'] = $value->id;
                // $data['where']['o.order_status !='] = '9';
                $return =  $this->selectFromJoin($data);
                if(!empty($return)){
                    foreach ($return as $k => $value) {
                        $weight_no = $this->getvarient($value->product_weight_id);
                        $return[$k]->weight_no = $weight_no;

                    }
                    $res[$key]->productDetails = $return;
                }else{
                    unset($res[$key]);
                }

            }
            // echo '<pre>';
            // print_r($res);die;
            return $res;
         // $date = date('Y-m-d 00:00:00',$date); 
    }

    public function getvarient($id){
        $data['select'] = ['*'];
        $data['table'] = 'product_weight';
        $data['where'] = ['id' =>$id,'status!='=>'9'];
        $res = $this->selectRecords($data);
        return $res[0]->weight_no;
    }

      function getPaymentCredential($order_id){
        // $order_id = $postdata['id'];
        $data['select'] = ['*'];
        $data['table'] = TABLE_ORDER;
        $data['where'] = ['id' =>$order_id];
        $res = $this->selectRecords($data); 
        if($res[0]->paymentMethod != 0){
            $paymentMethod = $res[0]->paymentMethod;
            $payment_transaction_id = $res[0]->payment_transaction_id;
            $orderId_payment_gateway = $res[0]->orderId_payment_gateway;
            $refund_amount = $res[0]->total;
            $paymentOpt = $this->getPaymentMethodCredential($paymentMethod);
            $mid_or_publishKey = $paymentOpt[0]->publish_key;
            $secret_key = $paymentOpt[0]->secret_key;
           
            $config =  array(
                'payment_transaction_id' => $payment_transaction_id,
                'orderId_payment_gateway' => $orderId_payment_gateway,
                'mid_or_publishKey' => $mid_or_publishKey,
                'secret_key' => $secret_key,
                'refund_amount'=>$refund_amount
             );
        }

        return $config;
    }

     public function refundPaymentPaytm($order_id){

        $config = $this->getPaymentCredential($order_id);
        // print_r($config);die;
        $this->load->model('api_v3/api_model','api_v3_model');
        $response = $this->api_v3_model->refundPaytm($config);
        $response = json_decode($response);
        // print_r($response);die;
        $response_code = $response->body->resultInfo->resultCode; 
        $status = $response->body->resultInfo->resultStatus;
        $resultMsg = $response->body->resultInfo->resultMsg;
        // print_r($response);die;
        // $response_code =='10' for Refund is Successful.
        // $response_code =='601' for system errror.
        if($status == 'PENDING' || $status == 'TXN_SUCCESS' || $response_code == '601' || $response_code == '10'){ 
            $refundID = $response->body->refundId;
            $amount = $response->body->refundAmount;
             $payment_refund_data = array(
                    'order_id'=>$order_id,
                    'refundID'=>$refundID,
                    'amount'=>$amount,
                    'dt_created'=>DATE_TIME,
                    'dt_updated'=>DATE_TIME
                );

            $returnvalue = $this->refundResponse($payment_refund_data);
            if($returnvalue){
                    $this->updateOrderIsRefunded($order_id);
            }
            $this->utility->setFlashMessage('success',$resultMsg);
            $resp['success'] = '1';

        }
        // $response_code =='617' for Refund Already Raised
        // $response_code =='629' for Refund is already Successful.
        if($response_code =='617' || $response_code =='629'){ //
            $this->updateOrderIsRefunded($order_id);
            $this->utility->setFlashMessage('success',$resultMsg );
            $resp['success'] = '1';
        }
        if($status == 'TXN_FAILURE' ||  $response_code =='617'){
            $this->utility->setFlashMessage('danger',$resultMsg );
            $resp['success'] = '1';
        }
            return $resp;  
    }

     public function refundPaymentRazar($order_id){
         // error_reporting(E_ALL);    
         //    ini_set('display_errors', 1);
        $config = $this->getPaymentCredential($order_id);
           $this->load->model('api_v3/api_model','api_v3_model');
            $response = $this->api_v3_model->refundPaymentRazar($config);
            $response = json_decode($response);
            // dd($response);die;
            // $status = $response->status;
            if(isset($response->status) && $response->status == 'processed'){
                // $resultMsg = $response->resultInfo->resultMsg;
                $refundID = $response->id;
                $amount = ($response->amount/100);
                $payment_refund_data = array(
                    'order_id'=>$order_id,
                    'refundID'=>$refundID,
                    'amount'=>$amount,
                    'dt_created'=>DATE_TIME,
                    'dt_updated'=>DATE_TIME
                ); 
                $returnvalue = $this->refundResponse($payment_refund_data);
                if($returnvalue){
                    $this->updateOrderIsRefunded($order_id);
                }
            $this->utility->setFlashMessage('success','Refund Request is processed');
             $resp['success'] = '1';
        }
        if(isset($response->error)){
            $this->utility->setFlashMessage('success',$response->error->description);
             $resp['success'] = '1';
        }

        return $resp;
    }

    public function refundPaymentStripe($order_id){

            $config = $this->getPaymentCredential($order_id);
           $this->load->model('api_v3/api_model','api_v3_model');
            $response = $this->api_v3_model->refundPaymentStripe($config);
            // $response = json_decode($response);
            // dd($response);die;
            // $status = $response->status;
            if(isset($response->status) && $response->status == 'succeeded'){
                // $resultMsg = $response->resultInfo->resultMsg;

                $refundID = $response->id;
                $amount = $response->amount;
                $amount = $amount/100;
                $payment_refund_data = array(
                    'order_id'=>$order_id,
                    'refundID'=>$refundID,
                    'amount'=> number_format((float)$amount,2,'.',''),
                    'dt_created'=>DATE_TIME,
                    'dt_updated'=>DATE_TIME
                ); 
                $returnvalue = $this->refundResponse($payment_refund_data);
                if($returnvalue){
                    $this->updateOrderIsRefunded($order_id);
                }
            $this->utility->setFlashMessage('success','Refund Request is processed');
             $resp['success'] = '1';
        }else{
            $resp['success'] = '1'; 
        }

        // $this->utility->setFlashMessage('success',$response->code);

        return $resp;
    }

    public function refundResponse($refundData){
       $data['table'] = 'payment_refund';
       $data['insert']= $refundData;
       return $this->insertRecord($data);
   }

    public function updateOrderIsRefunded($order_id){
        $data['table'] = TABLE_ORDER;
        $data['update']['isRefunded'] = '1';
        $data['where']['id'] = $order_id;
        $this->updateRecords($data);
    }

    public function getPaymentMethodCredential($payment_opt){
        $data['select'] = ['*'];
        $data['table'] = 'payment_method';
        $data['where'] = ['payment_opt' =>$payment_opt];
        return $this->selectRecords($data);
         
    }

    public function checkOtpVerified($orderid){
        $data['select'] = ['*'];
        $data['table'] = 'delivery_order';
        $data['where'] = ['order_id' =>$orderid];
        return $this->selectRecords($data);

        
    }

        public  $order_column_order_summary = array("o.order_no","o.dt_added","u.fname","u.lname","o.payable_amount",'o.dt_added','ua.address');  
    function make_query_order_summary($postData){
        $branch_id = $this->session->userdata('id');
        if(isset($postData['from_date']) && $postData['from_date'] != ''){
            $fr_date = $postData['from_date'];
            $parts_from = explode('-', $fr_date);
            $fr_date_ = $parts_from[1] . '-' . $parts_from[0] . '-' . $parts_from[2];
            $fr_date = strtotime(date("Y-m-d 00:00:00",strtotime($fr_date_)));

            $this->db->where('o.dt_added >=',$fr_date);
        }
        if(isset($postData['to_date']) && $postData['to_date'] != ''){
            $to_date = $postData['to_date'];
            $parts_from = explode('-', $to_date);
            $to_date_ = $parts_from[1] . '-' . $parts_from[0] . '-' . $parts_from[2];
            $to_date = strtotime(date("Y-m-d 00:00:00",strtotime($to_date_."+1 day")));

            $this->db->where('o.dt_added <=',$to_date);
        }
        if(isset($postData['order_status']) && $postData['order_status'] != ''){
            $this->db->where('o.order_status',$postData['order_status']);
        }
            // $where = [
            //     'o.branch_id'=>$branch_id,
            //     'o.status !='=>'9',

            // ];
         $this->db->select('o.*,u.fname,u.lname,ua.address');  
         $this->db->from('order as o');
         $this->db->join('order_details as od','o.id = od.order_id','LEFT');
         $this->db->join('user as u','u.id = o.user_id','LEFT');

         $this->db->join('user_address as ua','ua.id = o.user_address_id','LEFT');
         
         $this->db->where('o.branch_id',$branch_id);
         $this->db->order_by('o.dt_updated DESC');
         $this->db->group_by('o.id');

         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
        $this->db->group_start();
            $this->db->like("u.fname", $postData["search"]["value"]);
            $this->db->or_like("u.lname", $postData["search"]["value"]);
            $this->db->or_like("o.order_no", $postData["search"]["value"]);
            $this->db->or_like("o.dt_added", $postData["search"]["value"]);
            $this->db->or_like("ua.user_address", $postData["search"]["value"]);
            $this->db->or_like("o.payable_amount", $postData["search"]["value"]);
        $this->db->group_end(); 
        }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_order_summary[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('o.id', 'DESC');  
           } 
    }


    function make_datatables_order_summary($postData){ 
        $this->make_query_order_summary($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            echo $this->db->last_query();
        }

    function get_filtered_data_order_summary($postData = false){  
        $this->make_query_order_summary($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }    

    function get_all_data_order_summary($postData = array()){
        $branch_id = $this->session->userdata('id');
         $this->db->select('o.*,u.fname,u.lname','ua.address');  
         $this->db->from('order as o');
         $this->db->join('order_details as od','o.id = od.order_id','LEFT');
         $this->db->join('user as u','u.id = o.user_id','LEFT');
         $this->db->join('user_address as ua','ua.id = o.user_address_id','LEFT');
         $this->db->where('o.branch_id',$branch_id);
         $this->db->order_by('o.dt_updated DESC');
         $this->db->group_by('o.id');
         // $this->db->group_by('o.id');
         return $this->db->count_all_results(); 
         echo $this->db->last_query();
    }
}

?>