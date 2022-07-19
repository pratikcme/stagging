<?php
class staff_api_model extends my_model {
    function login($postdata) {
        $email = $postdata['email'];
        $password = md5($postdata['password']);
        $data['select'] = ['s.id', 's.branch_id', 's.name', 's.email', 's.email_verify', 's.email_token', 's.phone_no', 'v.name AS shopname', 'v.location', 's.status', 'v.delivery_by','v.status as vendor_status','v.multiLanguageType'];
        $data['where'] = ['s.email' => $email, 's.password' => $password];
        $data['table'] = 'staff AS s';
        $data['join'] = ['branch  AS v' => ['v.id = s.branch_id', 'LEFT', ]];
        $result = $this->selectFromJoin($data);
        $result[0]->multiple_lang_type  = $result[0]->multiLanguageType;
        if($result[0]->vendor_status != '0'){

            if (count($result) > 0) {
                if ($result[0]->email_verify == '1') {
                    // print_r($result[0]->email_verify);die;
                    if ($result[0]->status == '0') {
                        $response = array('status' => '0', 'message' => 'Your account is inactive ',);
                    } else {
                        $token = $this->update_device($result, $postdata);
                        $result[0]->token = $token;
                        $response = array('status' => '1', 'message' => 'success', 'data' => $result[0],);
                        $login_check_result = array('id' => $result[0]->id);
                    }
                } else {
                    $staffDetail = ['id' => $result[0]->id, 'token' => $result[0]->email_token];
                    $finalStaffdetail = $this->utility_apiv2->encode(json_encode($staffDetail));
                    $datas['name'] = $result[0]->name;
                    $datas['link'] = base_url() . "api_admin/verifyAccount/" . $finalStaffdetail;
                    $datas['message'] = $this->load->view('emailTemplate/registration_mail', $datas, true);
                    $datas['subject'] = 'Verify user email address';
                    $datas["to"] = $result[0]->email;
                    $this->load->model('api_v3/api_admin_model');
                    $this->api_admin_model->sendMailSMTP($datas);
                    $response = array('status' => '0', 'message' => 'Please verify your registered email',);
                }
            } else {
                $response = array('status' => '0', 'message' => 'Invalid email or password');
            }
        }else{
            $response = array('status' => '0', 'message' => 'Vendor is Inactive');
        }
        return $response;
    }
    function update_device($userdata, $postData) {
        $user_id = $userdata[0]->id;
        // print_r($user_id);die;
        $this->delete_token($user_id, $postData['device_token']);
        // $tokenData = $this->tokenGenrate($userdata, $postData['login_type']);
        $chekcDevice = $this->checkDevice($postData['device_id']);
        if (!empty($chekcDevice)) {
            $data['update']['user_id'] = $user_id;
            $data['update']['device_id'] = $postData['device_id'];
            $data['update']['token'] = $postData['device_token'];
            $data['update']['type'] = $postData['device_type'];
            $data['update']['dt_updated'] = DATE_TIME;
            $data['where'] = ['device_id' => $postData['device_id']];
            $data['table'] = "staff_device";
            $re = $this->updateRecords($data);
        } else {
            $data['insert']['user_id'] = $user_id;
            $data['insert']['device_id'] = $postData['device_id'];
            $data['insert']['token'] = $postData['device_token'];
            $data['insert']['type'] = $postData['device_type'];
            $data['update']['dt_updated'] = DATE_TIME;
            $data['insert']['dt_created'] = DATE_TIME;
            $data['table'] = "staff_device";
            $re = $this->insertRecord($data);
        }
        unset($data);
        $token = md5('user_' . time());
        $data['update']['token'] = $token;
        $data['update']['dt_updated'] = DATE_TIME;

        $data['where'] = ['id' => $user_id];
        $data['table'] = 'staff';
        $updateRecord = $this->updateRecords($data);
        return $token;
    }
    function checkDevice($postData) {
        $data['select'] = ['id'];
        $data['where'] = ['device_id' => $postData];
        $data['table'] = "staff_device";
        $result = $this->countRecords($data);
        return $result;
    }
    function delete_token($user_id, $device_id = null) {
        $data['where']['user_id'] = $user_id;
        $data['table'] = "staff_device";
        $this->deleteRecords($data);
        unset($data);
        $data['where']['device_id'] = $device_id;
        $data['table'] = "staff_device";
        $this->deleteRecords($data);
        return true;
    }
    function order_list($postdata) {
        $currecy = $this->get_currency();
        $branch_id = $postdata['branch_id'];
        $data['select'] = ['o.id as orderid', 'o.order_no', 'o.dt_added', 'pi.image', 'o.order_status', 'o.total_item', 'o.payable_amount', 'p.package', 'o.user_id', 'o.isSelfPickup', 'o.delivery_charge'];
        $data['where'] = ['o.branch_id' => $branch_id, 'o.status !=' => '9'];
        $data['table'] = 'order AS o';
        
        $data['join'] = ['order_details  AS d' => ['o.id = d.order_id', 'LEFT', ], 'product_image  AS pi' => ['pi.product_variant_id = d.product_weight_id', 'LEFT', ], 'product_weight  AS p' => ['p.id =  d.product_weight_id', 'LEFT', ], ];
        
        $data['groupBy'] = ['o.id'];
        $data['order'] = 'o.dt_updated DESC';
        $result = $this->selectFromJoin($data);

        // echo $this->db->last_query();die;
        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $package_id = $value->package;
                $user_id = $value->user_id;
                $userName = $this->get_username($user_id);
                $value->customername = $userName[0]->fname . ' ' . $userName[0]->lname;
                $package_name = $this->get_package($package_id);
                $value->package_name = $package_name;
                $value->dt_added = date('d-M-Y', $value->dt_added);
                $value->image = base_url() . 'public/images/'.$this->folder.'product_image/' . $value->image;
                $value->payable_amount = $currecy . ' ' . $value->payable_amount;
            }
            $response = array('status' => '1', 'message' => 'success', 'data' => $result,);
        } else {
            $response = array('status' => '0', 'message' => 'No data found',);
        }
        return $response;
    }
    public function get_username($id) {
        $data['table'] = 'user';
        $data['select'] = ['fname', 'lname'];
        $data['where'] = ['status !=' => '9', 'id' => $id];
        return $this->selectRecords($data);
    }
    function order_detail($postdata) {
        $currecy = $this->get_currency();
        $order_id = $postdata['order_id'];
        $data['select'] = ['o.id as orderid', 'o.order_no', 'd.product_id', 'p.name', 'pi.image', 'd.product_weight_id', 'd.quantity', 'd.discount', 'd.calculation_price', 'd.delevery_status', 'd.actual_price', 'w.name as weightname', 'pw.weight_no', 'pw.package', 'o.delivery_charge', 'o.dt_added'];
        $data['where'] = ['o.id' => $order_id, 'o.status !=' => '9'];
        $data['table'] = 'order AS o';
        $data['join'] = ['order_details  AS d' => ['o.id = d.order_id', 'LEFT', ], 'product  AS p' => ['p.id = d.product_id', 'LEFT', ], 'product_image  AS pi' => ['pi.product_variant_id = d.product_weight_id', 'LEFT', ], 'weight  AS w' => ['w.id = d.weight_id', 'LEFT', ], 'product_weight  AS pw' => ['pw.id = d.product_weight_id', 'LEFT', ]];
        $data['groupBy'] = 'd.product_weight_id';
        $result = $this->selectFromJoin($data);
        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                $package_id = $value->package;
                $package_name = $this->get_package($package_id);
                $value->package_name = $package_name;
                $value->dt_added = date('d-M-Y', $value->dt_added);
                $value->image = base_url() . 'public/images/'.$this->folder.'product_image/' . $value->image;
                $value->weight = floor($value->weight_no) . ' ' . $value->weightname;
                $value->actual_price = $currecy . ' ' . $value->actual_price;
                $value->calculation_price = $currecy . ' ' . $value->calculation_price;
                unset($value->weight_no);
                unset($value->weightname);
            }
            $response = array('status' => '1', 'message' => 'success', 'data' => $result,);
        } else {
            $response = array('status' => '0', 'message' => 'No data Found',);
        }
        return $response;
    }
    function get_package($id) {
        $package_name = "";
        if ($id > 0) {
            $data['select'] = ['*'];
            $data['where'] = ['id' => $id];
            $data['table'] = 'package';
            $package = $this->selectRecords($data);
            if (count($package) > 0) {
                $package_name = $package[0]->package;
            }
        }
        return $package_name;
    }
    function product_check($postdata) {
        //   error_reporting(E_ALL);
        // ini_set("display_errors",1);
        $product_weight_id = explode(',', $postdata['product_weight_id']);
        $order_id = $postdata['order_id'];
        $staff_id = $postdata['staff_id'];
        $data['select'] = ['order_status'];
        $data['where'] = ['id' => $order_id];
        $data['table'] = 'order';
        $results = $this->selectRecords($data);
        if (count($results) > 0) {
            if ($results[0]->order_status == '9') {
                $response = array('status' => '0', 'message' => 'order has been cancelled',);
                return $response;
            }
        }
        // print_r($results);die;
        // echo 1;exit;
        $data['update'] = ['delevery_status' => '0','dt_updated'=>strtotime(DATE_TIME)];
        $data['where'] = ['order_id' => $order_id];
        $data['table'] = 'order_details';
        $this->updateRecords($data);
        unset($data);
        $data['update'] = ['delevery_status' => '1','dt_updated'=>strtotime(DATE_TIME)];
        $data['where'] = ['order_id' => $order_id];
        $data['where_in'] = ['product_weight_id' => $product_weight_id];
        $data['table'] = 'order_details';
        $result = $this->updateRecords($data);
        // print_r($result);die;
        unset($data);
        $data['select'] = ['count(order_id) as value','dt_updated'=>strtotime(DATE_TIME)];
        $data['where'] = ['order_id' => $order_id];
        $data['table'] = 'order_details';
        $res = $this->selectRecords($data);
        $res = $res[0]->value;
        unset($data);
        $data['select'] = ['count(delevery_status) as value','dt_updated'=>strtotime(DATE_TIME)];
        $data['where'] = ['delevery_status' => '1', 'order_id' => $order_id];
        $data['table'] = 'order_details';
        $res2 = $this->selectRecords($data);
        $res2 = $res2[0]->value;
        unset($data);
        if ($res == $res2) {
            $date = strtotime(DATE_TIME);
            $data['update'] = ['staff_id' => $staff_id, 'order_status' => '3', 'dt_updated' => $date];
            $data['where'] = ['id' => $order_id];
            $data['table'] = 'order';
            $this->updateRecords($data);
            unset($data);
            
            $this->load->model('api_v3/api_admin_model');
            $order_log_data = array('order_id' => $order_id ,'status'=>'3');
            $this->api_admin_model->order_logs($order_log_data);

            $data['select'] = ['v.delivery_by', 'o.isSelfPickup'];
            $data['join'] = ['branch as v' => ['o.branch_id = v.id', 'LEFT'], ];
            $data['where'] = ['o.id' => $order_id];
            $data['table'] = 'order as o';
            $del = $this->selectFromJoin($data, true);
            $isSelfPickup = $del[0]['isSelfPickup'];
            $del = $del[0]['delivery_by'];
            $this->send_notificaion($order_id);
            if ($del == '1') {
                $this->load->model('api_v3/delivery_api_model');
                unset($data);
                $data['select'] = ['*'];
                $data['where'] = ['order_id' => $order_id];
                $data['table'] = 'delivery_notification';
                $get = $this->selectRecords($data, true);
                if (count($get) <= 0) {
                    if ($isSelfPickup == "0") {
                        $this->delivery_api_model->send_notification($order_id);
                    }
                }
            }


        } elseif ($res > $res2) {
            $date = strtotime(DATE_TIME);
            $data['update'] = ['staff_id' => $staff_id, 'order_status' => '2', 'dt_updated' => $date];
            $data['where'] = ['id' => $order_id];
            $data['table'] = 'order';
            $this->updateRecords($data);
            
            $this->load->model('api_v3/api_admin_model');
            $order_log_data = array('order_id' => $order_id ,'status'=>'2');
            $this->api_admin_model->order_logs($order_log_data);


        }
        if ($result) {
            $response = array('status' => '1', 'message' => 'success',);
        } else {
            $response = array('status' => '0', 'message' => 'No data updated',);
        }
        return $response;
    }
    function delivery_status($postdata) {
        $order_id = $postdata['order_id'];
        $date = strtotime(DATE_TIME);
        $data['update'] = ['order_status' => '8', 'dt_updated' => $date];
        $data['where'] = ['id' => $order_id];
        $data['table'] = 'order';
        $result = $this->updateRecords($data);
        
        unset($data);
        
        $data['select'] = ['order_no','branch_id'];
        $data['where'] = ['id' => $order_id];
        $data['table'] = 'order';
        $res = $this->selectRecords($data);
        
        $branch_id = $res[0]->branch_id;
        $order_no = $res[0]->order_no;
        
        $send_status = 'Delivered';
        $type = 'order_delivered';
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

        $this->load->model('api_v3/api_admin_model');
        $order_log_data = array('order_id' => $order_id , 'status'=> '8');
        $this->api_admin_model->order_logs($order_log_data);


        $this->send_notificaion($order_id);
        if (count($result)) {
            $response = array('status' => '1', 'message' => 'order has been delivered',);
        } else {
            $response = array('status' => '0', 'message' => 'No data updated',);
        }
        return $response;
    }
    public function send_notificaion($order_id) {
        $data['select'] = ['o.user_id', 'd.token', 'd.type', 'd.device_id', 'u.notification_status', 'o.order_status', 'o.order_no','o.branch_id'];
        $data['where'] = ['o.id' => $order_id];
        $data['table'] = 'order AS o';
        $data['join'] = ['device AS d' => ['d.user_id = o.user_id', 'LEFT'], 'user AS u' => ['u.id = o.user_id', 'LEFT'], ];
        $send = $this->selectFromJoin($data);
        $branch_id = $send[0]->branch_id;
        // echo $this->db->last_query();exit;
        $order_status = $send[0]->order_status;
        if ($order_status == '1') {
            $send_status = 'New Order';
        }
        if ($order_status == '2') {
            $send_status = 'Pending for Ready';
        }
        if ($order_status == '3') {
            $send_status = 'Ready For Deliver';
        }
        if ($order_status == '4') {
            $send_status = 'Pick up';
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
        // print_r($send);exit;
        $message = 'Your ' . $send[0]->order_no . ' is ' . $send_status;
        $notification_type = 'order_status';
        $user_id = $send[0]->user_id;
        // echo $this->db->last_query();exit();
        $this->insert_notification($user_id, $message, $notification_type, $order_id);
        unset($data);
        if ($send) {
            if ($send[0]->notification_status == '1') {
                $this->load->model('api_v3/api_model');
                $result = $this->api_model->getNotificationKey($branch_id);
                // print_r($result);die;
                $dataArray = array('device_id' => $send[0]->token, 'type' => $send[0]->type, 'message' => $message,);
                $this->utility_apiv2->sendNotification($dataArray, $notification_type,$result);
            }
        }
    }
    public function insert_notification($user_id, $message, $notification_type = NULL, $type_id = NULL) {
        $insertion = array('user_id' => $user_id, 'notification_for' => $notification_type, 'for_id' => $type_id, 'notification' => $message, 'dt_created' => DATE_TIME, 'dt_updated' => DATE_TIME,);
        $data['insert'] = $insertion;
        $data['table'] = 'notification';
        $this->insertRecord($data);
    }
    public function get_currency() {
        $data['select'] = ['value'];
        $data['where'] = ['request_id' => '3'];
        $data['table'] = 'set_default';
        $result = $this->selectRecords($data);
        if (isset($result[0]->value)) {
            return $result[0]->value;
        } else {
            $return = "";
            return $return;
        }
    }
    public function verify_otp($postdata) {
        // $id = $postdata['user_id'];
        $otp = $postdata['otp'];
        $order_id = $postdata['order_id'];

        $data['select'] =['order_status'];
        $data['where'] = ['id' => $order_id];
        $data['table'] = 'order';
        $getOrderStatus = $this->selectRecords($data);
        if(empty($getOrderStatus)){
            $response = array('status' => '0', 'message' => 'Wrong Order');
            return $response;
        }elseif($getOrderStatus[0]->order_status=='9'){
            $response = array('status' => '0', 'message' => 'Order is cancelled');
            return $response;
        }
        unset($data);
        $data['select'] = ['*'];
        $data['where'] = ['order_id' => $order_id, 'otp' => $otp];
        $data['table'] = 'delivery_order';
        $res = $this->selectRecords($data, true);
        if ($res) {
            unset($data);
            $date = strtotime(DATE_TIME);
            $data['update']['order_status'] = '5';
            $data['update']['dt_updated'] = $date;
            $data['where'] = ['id' => $order_id];
            $data['table'] = 'order';
            $this->updateRecords($data);
            unset($data);
            $data['update']['dt_updated'] = DATE_TIME;
            $data['update']['otp_verify'] = '1';
            $data['where'] = ['order_id' => $order_id];
            $data['table'] = 'delivery_order';
            $this->updateRecords($data);
            $this->send_notificaion($order_id);
            $response = array('status' => '1', 'message' => 'Otp verified',);
        } else {
            $response = array('status' => '0', 'message' => 'Wrong otp',);
        }
        return $response;
    }
    public function verify_otp_selfPickup($postdata) {
        $otp = $postdata['otp'];
        $order_id = $postdata['order_id'];
        $isSelfPickup = $postdata['isSelfPickup'];
        $data['select'] =['order_status'];
        $data['where'] = ['id' => $order_id];
        $data['table'] = 'order';
        $getOrderStatus = $this->selectRecords($data);
        if(empty($getOrderStatus)){
            $response = array('status' => '0', 'message' => 'Wrong Order');
            return $response;
        }elseif($getOrderStatus[0]->order_status=='9'){
            $response = array('status' => '0', 'message' => 'Order is cancelled');
            return $response;
        }
        unset($data);
        $data['select'] = ['*'];
        $data['where'] = ['order_id' => $order_id, 'otp' => $otp];
        $data['table'] = 'selfPickup_otp';
        $res = $this->selectRecords($data, true);
        if ($res) {
            unset($data);
            $date = strtotime(DATE_TIME);
            $data['update']['order_status'] = '8';
            $data['update']['dt_updated'] = $date;
            $data['where'] = ['id' => $order_id];
            $data['table'] = 'order';
            $this->updateRecords($data);
            unset($data);
            $data['update']['dt_updated'] = $date;            
            $data['update']['status'] = '1';
            $data['where'] = ['order_id' => $order_id];
            $data['table'] = 'selfPickup_otp';
            $this->updateRecords($data);
            $this->send_notificaion($order_id);
            $response = array('status' => '1', 'message' => 'Otp verified',);
        } else {
            $response = array('status' => '0', 'message' => 'Wrong otp',);
        }
        return $response;
    }
    public function status($postdata) {
        $id = $postdata['branch_id'];
        $data['select'] = ['delivery_by'];
        $data['where'] = ['id' => $id];
        $data['table'] = 'branch';
        $res = $this->selectRecords($data, true);
        $status = $res[0]['delivery_by'];
        if ($res) {
            $response = array('status' => $status, 'message' => 'success', 'success' => '1');
        } else {
            $response = array('status' => '9', 'message' => 'Vendor not valid', 'success' => '0');
        }
        return $response;
    }
    function token_validate() {
        // print_r($_SERVER);die;
        if ((!isset($_SERVER['HTTP_X_API_TOKEN'])) || (empty($_SERVER['HTTP_X_API_TOKEN']))) {
            return false;
        } else {
            $data['select'] = ['count(0) as count'];
            $data['where'] = ['token' => $_SERVER['HTTP_X_API_TOKEN']];
            $data['table'] = 'staff';
            $response = $this->selectRecords($data);
            if (@$response[0]->count == 0) {
                return false;
            } else {
                return true;
            }
        }
    }
    function logout($postData) {
        $data['where'] = ['user_id' => $postData['staff_id']];
        $data['table'] = 'staff_device';
        $result = $this->deleteRecords($data);
        $response['status'] = 1;
        $response['message'] = 'staff is logged out';
        unset($data);

        $data['table'] = TABLE_BRANCH;
        $data['where'] = ['id' => $postData['branch_id']];
        $data['select'] = ['vendor_id']; 
        $branch = $this->deleteRecords($data);

        $login_logs = [
            'user_id' => $postData['staff_id'],
            'vendor_id' =>  $branch[0]->vendor_id,
            'status' => 'logout',
            'type' => 'staff',
            'dt_created' => DATE_TIME
        ];
        $this->load->model('api_v3/common_model','v2_common_model');
        $this->v2_common_model->user_login_logout_logs($login_logs);

        return $response;
    }
}
?>