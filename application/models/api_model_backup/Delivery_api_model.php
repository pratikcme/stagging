<?php
require 'vendor/autoload.php';

class Delivery_api_model extends My_model
{
    public function __construct() {
      
        $this->url = 'https://grocery-2df35.firebaseio.com/';
        $this->token = 'azyZCdcmCXqQ0EQkzVoPL9Ir7hZHspTgnaKhgp7a';
        
    }

    public function login($postdata)
    {
        $email = $postdata['email'];
        $pass = $postdata['password'];
        $pass = md5($pass);
        $data['select'] = ['id','name','email','phone_no','image','vehicle_name','vehicle_type','vehicle_number','id_proof_number','id_proof_image','current_status','status'];
        $data['where'] = ['email' => $email, 'password' => $pass];
        $data['table'] = 'delivery_user';
        $res = $this->selectRecords($data, true);

        if ($res) {
            $res = $res[0];
            unset($data);
            $this->add_device($postdata,$res['id']);
            $res['image'] = base_url().'public/images/delivery_profile/'.$res['image'];
            $res['id_proof_image'] = base_url().'public/images/delivery_id/'.$res['id_proof_image'];

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
                'dt_created' => date('Y-m-d H:i:s')
            );
        $data['insert'] = $insert;
        $data['table'] = 'delivery_user_device';
        $re = $this->insertRecord($data);
    }


    public function update_status($postdata){

        $id = $postdata['id'];
        $status = $postdata['status'];
        $data['update']['dt_updated'] = date('Y-m-d H:i:s');
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

        $path = '/data/';
        // echo $this->token;exit;
        $firebase = new \Firebase\FirebaseLib($this->url, $this->token);
        // print_r($firebase);exit;
        $result = $firebase->get($path);
        $decodeRe = json_decode($result);
        
        // echo "<pre/>"; print_r($result); exit();
        //  echo count($decodeRe);die;
        

        $data['select'] = ['o.order_no','v.name','ua.address as b_address','ua.latitude as b_lat','ua.longitude as b_long','v.location as s_address','v.latitude as s_lat','v.longitude as s_long'];
        $data['join'] = [
            'user_address as ua' => ['ua.id = o.user_address_id','LEFT'],
            'vendor as v' => ['v.id = o.vendor_id','LEFT']
            ];
        $data['where'] = ['o.id'=>$order_id];
        $data['table'] = 'order as o';
        $res = $this->selectFromjoin($data,true);
        // print_r($res);die;
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
        foreach ($decodeRe as $value) {
            // print_r($decodeRe);exit;
            if(empty($value)){
                continue;
            }
            $distance = $this->distanceCalculation($s_lat,$s_long,$value->userLat,$value->userLng);
            if($value->currentStatus=='1' && $distance <=50){
                unset($data);
                $data['select'] = ['*'];
                $data['where'] = ['delivery_user_id'=>$value->userId];
                $data['table'] = 'delivery_user_device';
                $result = $this->selectRecords($data);
                // print_r($result);die;
                $message = "New Order In Your Area";
                $notification_type = 'new_notification';
                if(count($result)>0){                    
                    $dataArray = array(
                        'device_id' => $result[0]->token,
                        'type' => $result[0]->type,
                        'message' => $message,
                    );
                $key = "AAAAiEVdA8M:APA91bHLObncewgHcuCHN1vlK8KON4pyixZ3MpBXG0PRfr6Fh3qMUe7ZF66t7TGv5Bzfz-zr4MGP93SBwELaDFtFDfSnMxmtKcU2lrGth6TVGfrVodrp-WOLgAeRGMf0ESD1pJc0e_En";

                $this->utility->sendNotification($dataArray, $notification_type,NULL,$key);
                // echo 1; exit;

                $this->insert_notification($order_id,$value->userId,$message);
                }
                
            }
            
        }
        return true;

    }
    public function insert_notification($order_id,$user_id,$message){
        $data['insert'] = ['order_id'=>$order_id,'delivery_user_id'=>$user_id,'notification'=>$message,'pickup_status'=>'0','dt_created'=>date('Y-m-d h:i:s'),'dt_updated'=>date('Y-m-d h:i:s')];
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

        // print_r($get);exit;
        foreach ($get as $value) { 
          
            $order['order_id'] = $value['order_id'];

            unset($data);
            $data['select'] = ['order_status'];
            $data['where'] = ['id'=>$order['order_id']];
            $data['table'] = 'order';
            $data['order'] = 'id desc';
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
                            'o.mobile as delivered_phone'
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
                        'vendor as v' => 
                                ['v.id = o.vendor_id','LEFT']
            ];
        $data['where'] = ['o.id'=>$order_id,'o.order_status !=' => '9'];
        $data['order'] = "o.order_status DESC";
        $data['table'] = 'order as o';
        $data['groupBy'] = 'o.id';
        $res = $this->selectFromjoin($data,true);
        // echo $this->db->last_query();die;
        if(count($res)>0 || !empty($res)){
        
            $res = $res[0];
        }


        return$res;
    }
    public function accept_reject($postdata){
        $this->load->model('api_model');
        $user_id = $postdata['user_id'];
        $order_id = $postdata['order_id'];
        $status = $postdata['status'];
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

            $data['insert'] = ['order_id'=>$order_id,'delivery_user_id'=>$user_id,'otp'=>$otp,'dt_created'=>date('Y-m-d h:i:s'),'dt_updated'=>date('Y-m-d h:i:s')];
            $data['table'] = 'delivery_order';
            $this->insertRecord($data);
            unset($data);
            $data['select'] = ['vendor_id'];
            $data['where'] = ['id'=>$postdata['order_id']];
            $data['table'] = 'order';
            $order_data = $this->selectRecords($data);
             $this->api_model->send_staff_notification($order_data[0]->vendor_id,"Delivery boy accepted");
            unset($data);
            $data['update'] = ['order_status'=>'4','dt_updated'=>strtotime(date('Y-m-d h:i:s'))];
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
        

        $data['update']= ['order_status'=> '8','dt_updated'=> strtotime(date('Y-m-d h:i:s'))];
        $data['where'] = ['id'=>$order_id];
        $data['table'] = 'order';
        $res = $this->updateRecords($data);
        unset($data);
        $this->load->model('staff_api_model');
        $this->load->model('api_model');
        $this->staff_api_model->send_notificaion($order_id);
        unset($data);
         $data['select'] = ['vendor_id'];
            $data['where'] = ['id'=>$postdata['order_id']];
            $data['table'] = 'order';
            $order_data = $this->selectRecords($data);
        $this->api_model->send_staff_notification($order_data[0]->vendor_id,"Order is delivered");
        $data['update']=['dt_updated'=> date('Y-m-d h:i:s')];
        $data['where'] = ['order_id'=>$order_id,'delivery_user_id'=>$user_id];
        $data['table'] = 'delivery_order';

        $this->updateRecords($data);
        unset($data);
        $data['where'] = ['order_id' =>$order_id];
            $data['table'] = 'delivery_notification';
            $this->deleteRecords($data);
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

        // print_r($arr);die;
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
                $path = "./public/images/delivery_profile";
                $url = $path.$old_image;
                @unlink($url);
               
                $profile_upload_path = $path;
                // print_r($_FILES);
                $uploadResponse = upload_single_image_ByName($_FILES,'image',$profile_upload_path);
                
                // print_r($uploadResponse);exit;
                $profile_image = $uploadResponse['data']['file_name'];  
                $data['update'] = ['image'=>$profile_image];
                $data['update'] = ['dt_updated'=>date('Y-m-d h:i:s')];
                $data['where'] = ['id'=>$postdata['user_id']];
                $data['table'] = 'delivery_user';
                $this->updateRecords($data);

            }
            return base_url().'public/images/delivery_profile/'.$profile_image;
    }

    public function logout($user_id){
        $data['table'] = 'delivery_user_device';
        $data['where'] = ['delivery_user_id'=>$user_id];
        return  $this->deleteRecords($data);
      
    }

}

?>