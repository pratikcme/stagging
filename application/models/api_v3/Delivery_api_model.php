<?php
require 'vendor/autoload.php';

class Delivery_api_model extends My_model
{
    public function __construct() {
        
    }

    public function login($postdata)
    {
        $email = $postdata['email'];
        $pass = $postdata['password'];
        $pass = md5($pass);
        $data['select'] = ['s.id','s.name','s.email','s.phone_no','s.image','s.vehicle_name','s.vehicle_type','s.vehicle_number','s.id_proof_number','s.id_proof_image','s.current_status','s.status','v.multiLanguageType','s.branch_id'];
        $data['where'] = ['s.email' => $email, 's.password' => $pass];
        $data['table'] = 'delivery_user as s';
        $data['join'] = ['branch  AS v' => ['v.id = s.branch_id', 'LEFT', ]];
        $res = $this->selectFromJoin($data, true);
        
        if ($res) {
            $res[0]['multiple_lang_type'] = $res[0]['multiLanguageType'];
            $res = $res[0];
            unset($data);
            $this->add_device($postdata,$res['id']);
            $res['image'] = base_url().'public/images/'.$this->folder.'delivery_profile/'.$res['image'];
            $res['id_proof_image'] = base_url().'public/images/'.$this->folder.'delivery_id/'.$res['id_proof_image'];

        }else{
            $res = false;
        }
        return $res;
    }
    public function add_device($postdata,$user_id){
        $device_id = $postdata['device_id'];
        $type = $postdata['type'];
        $token = $postdata['token'];
        $data['table'] = 'delivery_user_device';
        $data['where'] = ['delivery_user_id'=>$user_id];
        $this->deleteRecords($data);
        unset($data);
        $data['table'] = 'delivery_user_device';
        $data['where'] = ['device_id'=>$device_id];
        $this->deleteRecords($data);
        unset($data);  
        $insert = array(
                'device_id' => $device_id,
                'type' => $type,
                'token' => $token,
                'delivery_user_id' => $user_id,
                'dt_created' => date('Y-m-d h:i:s')
            );
        $data['insert'] = $insert;
        $data['table'] = 'delivery_user_device';
        $re = $this->insertRecord($data);
    }


    public function update_status($postdata){

        $id = $postdata['id'];
        $status = $postdata['status'];
        $data['update']['dt_updated'] = date('Y-m-d h:i:s');
        $data['update']['current_status'] = $status;
        $data['where'] = ['id'=> $id];
        $data['table'] = 'delivery_user';
        $res = $this->updateRecords($data);

        if($res){
            return true;
        }
        else{
            return false;
        }
    }
    public function send_notification($order_id){

        $data['select'] = ['o.order_no','v.name','ua.address as b_address','ua.latitude as b_lat','ua.longitude as b_long','v.location as s_address','v.latitude as s_lat','v.longitude as s_long','o.isSelfPickup','o.branch_id','v.vendor_id'];
        $data['join'] = [
            'user_address as ua' => ['ua.id = o.user_address_id','LEFT'],
            'branch as v' => ['v.id = o.branch_id','LEFT']
            ];
        $data['where'] = ['o.id'=>$order_id];
        $data['table'] = 'order as o';
        $res = $this->selectFromjoin($data,true);

        $branch_id = $res[0]['branch_id']; 
        $vendor_id = $res[0]['vendor_id']; 

        unset($data);
        $data['table'] = 'firebase as f';
        $data['join'] = ['branch as b'=>['b.vendor_id=f.vendor_id','INNER']];
        $data['select'] = ['f.*'];
        $data['where'] = ['b.id'=>$branch_id]; 
        $firebase =  $this->selectFromJoin($data);

        $this->url =$firebase[0]->firebase_url; 
        $this->token = $firebase[0]->firebase_token;
        $this->key = $firebase[0]->delivery_firebase_key;
        $this->firebaseNode = $firebase[0]->firebase_node;


        $path = '/'.$this->firebaseNode.'/';
       
        $firebase = new \Firebase\FirebaseLib($this->url, $this->token);
        $result = $firebase->get($path);
        // print_r($result);
        // exit;
        $decodeRe = json_decode($result);
        
        // echo "<pre/>"; print_r($decodeRe); exit();
        // echo count($decodeRe);die;

        // print_r($res);die;

        if($res[0]['isSelfPickup'] == '1'){
            return true;
        }

        $res = $res[0];

        $b_add = explode(',',$res['b_address']);
        $b_add =  $b_add[0];

        $s_add = explode(',',$res['s_address']);
        $s_add = $s_add[0];


            $res['b_address'] = $b_add;
            $res['s_address'] = $s_add;
            $s_lat = $res['s_lat'];
            $s_long = $res['s_long'];
            $i = 0;
            unset($data);

            $message = "New Order In Your Area";
            $notification_type = 'new_notification';
            $data['select'] = ['dd.*'];
            $data['where'] = ['d.branch_id'=>$branch_id];
            $data['table'] = 'delivery_user_device as dd';
            $data['join'] = ['delivery_user as d'=>['d.id = dd.delivery_user_id','left']];
            $result = $this->selectFromJoin($data);
            foreach($result as $key =>$val){
                $this->insert_notification($order_id,$val->delivery_user_id,$message,$branch_id);
            }



        foreach ($decodeRe as $value) {
          
            if(empty($value)){
                continue;
            }
            $distance = $this->distanceCalculation($s_lat,$s_long,$value->userLat,$value->userLng);
            // if($value->currentStatus=='1' && $distance <=5000){
            if($value->currentStatus=='1' && $distance <=50000000000000000000000000000){
                unset($data);
                $data['select'] = ['dd.*'];
                $data['where'] = ['d.id'=>$value->userId,'d.branch_id'=>$branch_id];
                $data['table'] = 'delivery_user_device as dd';
                $data['join'] = ['delivery_user as d'=>['d.id = dd.delivery_user_id','left']];
                $result = $this->selectFromJoin($data);
                // print_r($result);die;
                
                if(count($result)>0){                    
                    $dataArray = array(
                        'device_id' => $result[0]->token,
                        'type' => $result[0]->type,
                        'message' => $message,
                        'delivery_notification'=>true
                    );

               

                    $key = "AAAAIhCnTt0:APA91bEAjiw53KeCGPM4Ns6lfvvBlihTd5FTrWo3_yW9ozu0iM8vs1MBErm1g0hOel4UXdk9zCtsX2l0YCa99XCystgrOsjyQ2lvZWcimH0FcNgNqBsKWWPEiniN9M2z5dBIhwaIizPH";
                
                
                    $this->load->model('api_v3/api_model');
                    $result = $this->api_model->getNotificationKey($branch_id);
                    // dd($result);
                    $this->utility_apiv2->sendNotification($dataArray, $notification_type,$result,NULL,$this->key);
                
                    
                }
                
            }
            
        }
        return true;

    }
    public function insert_notification($order_id,$user_id,$message,$branch_id=0){
        $data['insert'] = ['order_id'=>$order_id,'delivery_user_id'=>$user_id,'branch_id'=>$branch_id,'notification'=>$message,'pickup_status'=>'0','dt_created'=>date('Y-m-d h:i:s'),'dt_updated'=>date('Y-m-d h:i:s')];
        $data['table'] = 'delivery_notification';
        $this->insertRecord($data);
        return true;
    }

    public function distanceCalculation($latitude1, $longitude1, $latitude2, $longitude2) {
        
        $p1 = deg2rad($latitude1);
        $p2 = deg2rad($latitude2);
        $dp = deg2rad($latitude2 - $latitude1);
        $dl = deg2rad($longitude2 - $longitude1);
        $a = (sin($dp/2) * sin($dp/2)) + (cos($p1) * cos($p2) * sin($dl/2) * sin($dl/2));
        $c = 2 * atan2(sqrt($a),sqrt(1-$a));
        $r = 6371008; // Earth's average radius, in meters
        $d = $r * $c;
            return ($d/1000);
    }
    public function dashboard_data($postdata){
        $user_id = $postdata['user_id'];
        $data['select'] = ['*'];
        $data['where'] = ['delivery_user_id'=>$user_id];
        $data['table'] = 'delivery_notification';
        $data['order'] = 'id desc';
        $data['groupBy'] = 'order_id';

        $get = $this->selectRecords($data,true);
        unset($data);


        $res = array();

        foreach ($get as $value) { 
          
            $order['order_id'] = $value['order_id'];

            unset($data);
            $data['select'] = ['order_status'];
            $data['where'] = ['id'=>$order['order_id']];
            $data['table'] = 'order';
            $data['order'] = 'dt_updated desc';
            $result = $this->selectRecords($data,true);
            if(count($result)>0){
                
            $status = $result[0]['order_status'];

            if($status == 8){

                unset($value);
            }

            }

            $notification_detail = $this->notification_detail($order);
            if(!empty($notification_detail)){
                $res[] = $notification_detail;
            }
            
        }
        return $res;

    }
    public function notification_detail($postdata){

        $order_id = $postdata['order_id'];

        $data['select'] = [ 'o.id as order_id',
                            'o.order_no',
                            'o.delivery_charge',
                            'o.total_item',
                            'o.payable_amount as total_bill',
                            'v.name as shop_name',
                            'v.owner_name as shopkeepername',
                            'u.fname as username',
                            'ua.address as user_address',
                            'v.location as s_address',
                            'u.phone as Customer_Contact',
                            'v.phone_no as shop_contact',
                            'u.email as user_mail',
                            'v.email as shop_mail',
                            'ua.latitude as user_lat',
                            'ua.longitude as user_long',
                            'v.latitude as s_lat',
                            'v.longitude as s_long',
                            'do.delivery_user_id',
                            'dn.pickup_status',
                            'do.otp_verify',
                            'do.otp',
                            'o.delivered_address',
                            'o.name as delivered_name',
                            'o.mobile as delivered_phone',
                            'o.payment_type'
                        ];
        $data['join'] = [
                        'delivery_notification as dn' => 
                                                ['o.id = dn.order_id','LEFT'],
                        'delivery_order as do' => 
                                                ['o.id = do.order_id','LEFT'],
                        'user as u' => 
                                        ['u.id = o.user_id','LEFT'],
                        'user_address as ua' => 
                                ['ua.id = o.user_address_id','LEFT'],
                        'branch as v' => 
                                ['v.id = o.branch_id','LEFT']
            ];
        $data['where'] = ['o.id'=>$order_id,'o.order_status !=' => '9'];
        $data['order'] = "o.order_status DESC";
        $data['table'] = 'order as o';
        $data['groupBy'] = 'o.id';
        $res = $this->selectFromjoin($data,true);
       
        if(count($res)>0 || !empty($res)){
        
            $res = $res[0];
        }


        return$res;
    }
    public function accept_reject($postdata){
        $this->load->model('api_v3/api_model');
        $user_id = $postdata['user_id'];
        $order_id = $postdata['order_id'];
        $status = $postdata['status'];
        $data['select'] = ['branch_id'];
        $data['where'] = ['id'=>$postdata['order_id']];
        $data['table'] = 'order';
        $order_data = $this->selectRecords($data);
        $branch_id = $order_data[0]->branch_id;
        
        unset($data);
        $data['update'] = ['pickup_status'=>$status,'dt_updated'=>date('Y-m-d h:i:s')];
        $data['where'] = ['order_id' => $order_id,'delivery_user_id'=>$user_id];
        $data['table'] = 'delivery_notification';
        $updated = $this->updateRecords($data);

        if($status==1 && $updated){
            $data['where'] = ['order_id' =>$order_id,'pickup_status' =>'0'];
            $data['table'] = 'delivery_notification';
            $this->deleteRecords($data);
            
            unset($data);
            $otp = rand(1000,9999);

            $data['insert'] = ['order_id'=>$order_id,'branch_id'=>$branch_id,'delivery_user_id'=>$user_id,'otp'=>$otp,'dt_created'=>date('Y-m-d h:i:s'),'dt_updated'=>date('Y-m-d h:i:s')];
            $data['table'] = 'delivery_order';
            $this->insertRecord($data);
            $this->api_model->send_staff_notification($branch_id,"Delivery boy accepted");
            
            unset($data);
            $data['update'] = ['order_status'=>'4','dt_updated'=>strtotime(DATE_TIME)];
            $data['where'] = ['id' => $order_id];
            $data['table'] = 'order';
            $this->updateRecords($data);
            unset($data);
            
            return $otp;
        }else{
            unset($data);
            $data['where'] = ['order_id' => $order_id,'delivery_user_id'=>$user_id];
            $data['table'] = 'delivery_notification';
            $this->deleteRecords($data);
            return "Rejected";
        }
    }
    public function pickup($postdata){

        $user_id = $postdata['user_id'];
        $order_id = $postdata['order_id'];
        $data['select'] = ['*'];
        $data['where'] = ['order_id'=>$order_id,'delivery_user_id'=>$user_id];
        $data['table'] = 'delivery_order';
        $result =  $this->selectRecords($data);
        if($result[0]->otp_verify=='1'){
            return true;
        }else{
            return false;
        }
    }

    public function order_delivered($postdata){
        $order_id = $postdata['order_id'];
        $user_id = $postdata['user_id'];
        if(isset($postdata['verify_otp'])){
            $otp = $postdata['verify_otp'];    
        }else{
             $otp = $postdata['otp'];
        }
        $data['select'] = ['branch_id','order_no','user_id'];
        $data['where'] = ['id'=>$postdata['order_id']];
        $data['table'] = 'order';
        $orderdetails = $this->selectRecords($data);
        unset($data);
        $data['select'] = ['*'];
        $data['where'] = ['order_id'=>$order_id,'user_id'=>$orderdetails[0]->user_id,'otp'=>$otp];
        $data['table'] = 'selfPickup_otp';
        $verification = $this->selectRecords($data);
        unset($data);
        if(!empty($verification)){
            $id = $verification[0]->id;
            $data['update']=['status'=>'1','dt_updated'=> date('Y-m-d h:i:s')];
            $data['where'] = ['id'=>$id];
            $data['table'] = 'selfPickup_otp';
            $this->updateRecords($data);
        }else{
            return false;
        }
        unset($data);
        $data['update']= ['order_status'=> '8','dt_updated'=> strtotime(date('Y-m-d h:i:s'))];
        $data['where'] = ['id'=>$order_id];
        $data['table'] = 'order';
        $res = $this->updateRecords($data);
        unset($data);
        $this->load->model('api_v3/staff_api_model');
        $this->load->model('api_v3/api_model');
        $this->staff_api_model->send_notificaion($order_id);
        unset($data);
            $data['select'] = ['branch_id','order_no'];
            $data['where'] = ['id'=>$postdata['order_id']];
            $data['table'] = 'order';
            $order_data = $this->selectRecords($data);
        $this->api_model->send_staff_notification($order_data[0]->branch_id,"Order is delivered");
        $data['update']=['dt_updated'=> date('Y-m-d h:i:s')];
        $data['where'] = ['order_id'=>$order_id,'delivery_user_id'=>$user_id];
        $data['table'] = 'delivery_order';

        $this->updateRecords($data);
        unset($data);
        $data['where'] = ['order_id' =>$order_id];
        $data['table'] = 'delivery_notification';
        $this->deleteRecords($data);

        $iOrderNo = $order_data[0]->order_no;
        $message = $iOrderNo .' is Delivered' ;
        $branchNotification = array(
            'order_id'         =>  $order_id,
            'branch_id'          =>  $order_data[0]->branch_id,
            'notification_type'=> 'order_delivered',
            'message'          => $message,
            'status'           =>'0',
            'dt_created'       => DATE_TIME,
            'dt_updated'       => DATE_TIME
        );
        /*order_delieverd logs*/
        $logs = ['branch_id'=>$order_data[0]->branch_id,'order_id'=>$order_id,'status'=>'Order is delivered','dt_created'=>DATE_TIME];
        $this->order_logs($logs);
        /*end order_delieverd logs*/
        $this->load->model('api_v3/api_model','api_v3_model');
        $this->api_v3_model->pushAdminNotification($branchNotification);

        return true;

    }

      public function order_logs($postData){

            $branch_id = '';
            if (isset($postData['branch_id'])) {
                $branch_id = $postData['branch_id'];
            }
            $data['table'] = 'order_log';
            $insertData = array(
                'order_id' => $postData['order_id'],
                'branch_id'=> $branch_id,
                'order_status'=> $postData['status'],
                'dt_created'=>DATE_TIME
            );
            $data['insert'] = $insertData;
            $this->insertRecord($data);
            return true; 
    }

    public function delivered_order_list($postdata){
        $user_id = $postdata['user_id'];
        $data['select'] = ['do.order_id','do.dt_updated',"DATE_FORMAT(do.dt_updated, '%Y-%m-%d') as delivery_datetime"];
        $data['join'] = ['order as o' => ['o.id = do.order_id','LEFT']];
        $data['where'] = ['do.delivery_user_id'=>$user_id,'o.order_status' => '8'];
        $data['table'] = 'delivery_order as do';
        $data['order'] = 'o.dt_updated DESC';

        $res = $this->selectFromjoin($data,true);
        // echo $this->db->last_query();exit;
        $arr = array();
        $i = 0;
        foreach ($res as $value){
            $arr['date'][$value['delivery_datetime']][] = $this->notification_detail($value);
        }

      
        return $arr;

    }

    public function update_profile($postdata){
          if($_FILES['image']['name'] != ''){
                $data['select'] = ['*'];
                $data['where'] = ['id'=>$postdata['user_id']];
                $data['table'] = 'delivery_user';
                $result = $this->selectRecords($data,true);
                $result = $result[0];
                $old_image = $result['image'];
                $path = "./public/images/".$this->folder."delivery_profile";
                $url = $path.$old_image;
                @unlink($url);
               
                $profile_upload_path = $path;
               
                $uploadResponse = upload_single_image_ByName($_FILES,'image',$profile_upload_path);
                
               
                $profile_image = $uploadResponse['data']['file_name'];  
                $data['update'] = ['image'=>$profile_image];
                $data['update'] = ['dt_updated'=>date('Y-m-d h:i:s')];
                $data['where'] = ['id'=>$postdata['user_id']];
                $data['table'] = 'delivery_user';
                $this->updateRecords($data);

            }
            return base_url().'public/images/'.$this->folder.'delivery_profile/'.$profile_image;
    }

    public function logout($user_id){
        $data['table'] = 'delivery_user_device';
        $data['where'] = ['delivery_user_id'=>$user_id];
        $this->deleteRecords($data);

        unset($data);
        $data['table'] = TABLE_BRANCH;
        $data['where'] = ['id' => $_POST['branch_id']];
        $data['select'] = ['vendor_id']; 
        $branch = $this->deleteRecords($data);

        $login_logs = [
            'user_id' => $user_id,
            'vendor_id' =>  $branch[0]->vendor_id,
            'status' => 'logout',
            'type' => 'delivery',
            'dt_created' => DATE_TIME
        ];
        $this->load->model('api_v3/common_model','v2_common_model');
        $this->v2_common_model->user_login_logout_logs($login_logs);
        
        return true;
    }

}

?>