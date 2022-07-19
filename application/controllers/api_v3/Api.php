<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("HTTP/1.1 200 OK");

class Api extends Apiuser_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('api_v3/api_model', 'this_model');
        $this->load->model('api_v3/common_model');
        if(!isset($_POST['vendor_id']) && isset($_POST['branch_id'])){
            $getVendor =  $this->common_model->getVendorIdFromBranch();
            $_POST['vendor_id'] = $getVendor[0]->vendor_id;
        }
    /*
    ALTER TABLE `vendor` ADD `display_price_with_gst` ENUM('0','1') NOT NULL COMMENT '0=?>with_gst; \'1\'=>without_gst' AFTER `type`;
    ALTER TABLE `product_weight` ADD `without_gst_price` FLOAT NULL AFTER `discount_price`;    
    */
    }
    public function appDetails(){   
        $post = $this->input->post();
        $req = array('vendor_id');
        $response = $this->checkRequiredField($post, $req);
        $vendor_id = $post["vendor_id"];
        if ($response['status'] == 1) {
               $query = $this->db->query("SELECT android_version,ios_isforce,android_isforce,ios_version from vendor WHERE id = '$vendor_id' LIMIT 1");
               $result = $query->result();
            if(!empty($result)){
                $data['android_version'] = $result[0]->android_version;
                $data['ios_version'] = $result[0]->ios_version;
                $data['android_isforce'] = $result[0]->android_isforce;
                $data['ios_isforce'] = $result[0]->ios_isforce;                
                $response = array('success' => '1', 'message' => 'Application Details', 'data' => $data);
            }else{
               $response = array();
               $response["success"] = 0;
               $response["message"] = " invalid";
               $output = json_encode(array('responsedata' => $response));
               echo $output;
            }
        }
        echo json_encode($response);die;
       
    }
        

    public function check_branch() {
        
       

        $result = $this->this_model->check_branch();
        $vendor_id = $result[0]->id;
        $_POST['vendor_id'] = $vendor_id ;

        $categoryCount = $this->this_model->categoryCount();
        $subcategoryCount = $this->this_model->subcategoryCount();
        $vendorCount = $this->this_model->vendorCount($vendor_id);
    
        $branch_id = 0;
        if(count($vendorCount) == '1'){
            $branch_id = $vendorCount[0]->id;
        } 
        $response = array(
            'success' => '1', 
            'message' => 'Approved Branch',
            'data' => (!empty($result)) ? 1 : 0,
            'categoryCount'=>(int)$categoryCount,
            'subcategoryCount'=>(int)$subcategoryCount,
            'vendorCount' => (int)count($vendorCount),
            'branch_id' =>  $branch_id,
            'vendor_id' => $result[0]->id
        );
        echo json_encode($response);die;
    }

    public function checkNotification() {
        $deviceToken['message'] = "Khana khaya";
        $deviceToken['type'] = 'A';
        $deviceToken['device_id'] = 'fl6I9akeR_ahC3FIw1Pauh:APA91bEt2EGkf_OynOSJI8lUrIn0WP7Nde6i4fbojQ_VsfaFHrMBk9uCJo420C_VwiNQ7fzSDBWwT2e-OCRPOWA9PvFZfO4-jBJuaI6I3cG6PyRnAye5soMjGjOw5AhxrP9RGM8_4AFu';
        $result = $this->utility->sendNotification($deviceToken, $type = "asdad", $unread = 0);
        $response = array('success' => '1', 'message' => 'Approved Branch', 'data' => $result);
        echo json_encode($response);
    }

    public function testNotification(){
        $this->load->model('api_v3/delivery_api_model');
        $this->delivery_api_model->send_notification(140);
    }

    public function userprofile_info(){
        $post = $this->input->post();
        $req = array('user_id');
        $response = $this->checkRequiredField($post, $req);
        if ($response['status'] == 1) {
            $result = $this->this_model->user_info($post);
            if($result[0]->profileimage != '' || $result[0]->profileimage != NULL){
                $result[0]->profileimage = base_url().'public/images/'.$this->folder.'user_profile/'.$result[0]->profileimage;
            }else{
                $result[0]->profileimage = "";
            }
            $result[0]->mobile_verify = $result[0]->is_verify;

            $user_id = $post['user_id'];
            $device_id = $post['device_id'];
            $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE  mc.user_id= '$user_id' AND mc.status != '9' ORDER BY mc.id DESC");

            $row_count = $result_count->result();
            // echo $this->db->last_query();die;
            $total_count = $row_count[0]->total;
            $result[0]->cart_item = $total_count;            
            if(!empty($result)){
               $response = array();
               $response["success"] = 1;
               $response["message"] = "user data";
               $response["user_data"] = $result[0];
               $output = json_encode(array('responsedata' => $response));
               echo $output;
            }else{
               $response = array();
               $response["success"] = 0;
               $response["message"] = " invalid";
               $output = json_encode(array('responsedata' => $response));
               echo $output;
            }
        } 
    }

    public function revokeFb($facebook_token_id) {
        // $facebook_token_id = $_GET['id'];
        $result = $this->this_model->revokeFb($facebook_token_id);
        if ($result) {
            $response = array('success' => '1', 'message' => 'Facebook account inactive',);
        } else {
            $response = array('success' => '0', 'message' => 'Facebook token not match',);
        }
        echo json_encode($response);
        die;
    }

    public function order_status() {
        $postdata = $this->input->post();
        if (isset($postdata['order_id'])) {
            $response = $this->this_model->order_status($postdata);
        } else {
            $response = array('success' => '0', 'message' => 'Invalid Parameter');
        }
        echo json_encode($response);
    }
    public function logout() {
        $this->this_model->logout($this->input->post());
        $response = array();
        $response["success"] = 1;
        $response["message"] = "User _logged out";
        $output = json_encode(array('responsedata' => $response));
        echo $output;
    }
    public function filter_search() {
        $this->this_model->filter($this->input->post());
    }
    public function vendor_list() {
        $return = $this->this_model->vendor_list();
        // dd($return);
        // $this->this_model->CategoryCount();
        echo json_encode($return);
        exit;
    }
    public function vendor_category_list() {
       
        if($this->input->post('branch_id')=='') {
            $response = array('success' => '0', 'message' => 'Invalid Parameter');
            echo json_encode($response);
            die;
        }
        $categoryCount = $this->this_model->categoryCount($this->input->post('branch_id'));
        $subcategoryCount = $this->this_model->subcategoryCount($this->input->post('branch_id'));

        if($categoryCount == '1' && $subcategoryCount > '1'){
            $this->vendor_subcategory_list();
            exit;    
        }
        $return = $this->this_model->category_list($this->input->post());
        $return['categoryCount'] = $categoryCount;
        $return['subcategoryCount'] = $subcategoryCount;
     
        echo json_encode($return);
        exit;
    }
    public function vendor_subcategory_list() {
        $return = $this->this_model->subcategory_list($this->input->post());
        echo json_encode($return);
        exit;
    }
    public function vendor_brand_list() {
        $return = $this->this_model->brand_list($this->input->post());
        echo json_encode($return);
        exit;
    }
    public function push_notify() {
        $result = $this->this_model->push_notify($this->input->post());
        echo json_encode($result);
    }
    ## verify_mobile ##
    public function verify_mobile() {
        $return = $this->this_model->verify_mobile($this->input->post());
        echo json_encode($return);
        exit;
    }
    public function verify_mobile_verification_code() {
        $return = $this->this_model->verify_mobile_verification_code($this->input->post());
        echo json_encode($return);
        exit;
    }
    ## City List ##
    public function city_list() {
        $limit = '5';
        $offset = $_POST['offset'];
        $result_count = $this->db->query("SELECT COUNT(*) as total FROM city WHERE status != '9'");
        $row_count = $result_count->result();
        $total_count = $row_count[0]->total;
        $cal = $limit * $offset;
        $query = $this->db->query("SELECT * FROM city WHERE status != '9' ORDER BY id DESC LIMIT $limit OFFSET $cal");
        $result = $query->result();
        if ($query->num_rows() > 0) {
            $response['success'] = "1";
            $response['message'] = "City list";
            $response["count"] = $total_count;
            $response["data"] = array();
            $counter = 0;
            foreach ($result as $row) {
                $data = array();
                $data['id'] = $row->id;
                $data['name'] = $row->name;
                $data['status'] = $row->status;
                $data['dt_added'] = $row->dt_added;
                $data['dt_updated'] = $row->dt_updated;
                array_push($response["data"], $data);
                $counter++;
            }
            echo $output = json_encode(array('responsedata' => $response));
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }
    public function set_user_cart($postdata) {
        $this->this_model->set_user_cart($postdata);
    }

    function emailTemplate_testing(){
        $this->this_model->emailTemplate(235,2,5);
    }
    ## User Register ##
   
    public function user_register() {
       
        if ($_POST['login_type'] != '3' && (!isset($_POST['email']) || $_POST['email']=='' ) ){
            $response["success"] = 0;
            $response["message"] = "Please enter email address";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
            exit();
        }

        $post = $this->input->post();
        $response = $this->this_model->user_register($post);
        $output = json_encode(array('responsedata' => $response));
        echo $output;
        die;
       
    }
    
    ## User Login ##
    public function user_login() {
        $post = $this->input->post();
        $response = $this->this_model->user_login($post);
        $output = json_encode(array('responsedata' => $response));
        echo $output;
        die;
    }
   
    function sendLoginResponse($login_check_result){
        $device_id = $_POST['device_id'];
        $login_type = $_POST['login_type'];
        $vendor_id = $_POST['vendor_id'];

        $user_id = $login_check_result['id'];

        $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE ( mc.user_id= '$user_id' OR mc.device_id= '$device_id') AND mc.status != '9' AND vendor_id = '$vendor_id' ORDER BY mc.id DESC");
        $row_count = $result_count->result();

        $total_count = $row_count[0]->total;
        $postdata = array('user_id' => $login_check_result['id'], 'device_id' => $device_id, 'vendor_id' => $vendor_id);
        $this->set_user_cart($postdata);
        $total_count = $this->this_model->get_total($postdata);
        $notification_status = $this->this_model->notification_status($login_check_result['id']);
        $data = array('id' => $login_check_result['id'], 'fname' => $login_check_result['fname'], 'lname' => $login_check_result['lname'], 'email' => $login_check_result['email'], 'phone' => $login_check_result['phone'], 'user_gst_number' => ($login_check_result['user_gst_number'] == null) ? "" : $login_check_result['user_gst_number'], 'login_type' => $login_type, 'cart_item' => $total_count[0]->cart_items, 'notification_status' => $notification_status, 'mobile_verify' => $login_check_result['is_verify']);
        $this->this_model->update_device($login_check_result, $_POST);
     
        $response = array();
        $response["success"] = 1;
        $response["message"] = "Login Successfully";
        $response["user_data"] = $data;
        $output = json_encode(array('responsedata' => $response));
        echo $output;
    }

    ## Verify Email ##
    public function verifyAccount($postData = null) {
        /* check if we are getting token or not */
        if ($postData) {
            $response = $this->this_model->verifyUserEmailByToken($postData);
            // print_r($postData);die;
            if ($response == false) {
                $this->setVerifyEmailmessage('Sorry! Invalid link');
            } else {
                $this->setVerifyEmailmessage('Thank you!  you have successfull verfied your email address');
            }
        } else {
            $this->setVerifyEmailmessage('Something went wrong');
        }
        redirect(base_url() . 'admin/verifyEmailstatus');
    }

    public function sendMailToSuperAdmin() {
        $this->this_model->sendMailToSuperAdmin($this->input->post());
    }

    ## Forgot Password ##
    public function user_forgot_password() {
        if (isset($_POST['email']) && isset($_POST['vendor_id'])) {
            $email = $_POST['email'];
            $vendor_id = $_POST['vendor_id'];


            $query = $this->db->query("SELECT COUNT(*) as total FROM user WHERE email = '$email' AND vendor_id = '$vendor_id'");
            $result = $query->row_array();
            if ($result['total'] > 0) {
                $this->load->helper('string');
                $ran_digit = random_string('alnum', 5);
                $ran_digit_md5 = md5($ran_digit);
                $where = array('email' => $email);
                $data = array('password' => $ran_digit_md5, 'dt_updated' => strtotime(DATE_TIME));
                $this->db->where($where);
                $this->db->update('user', $data);
                $this->load->library('email');

                $message = "Congrats!!! Your new login credentials :<br/>
                Your New password is : ".$ran_digit."<br/>
                To change your password : You can change your password once you login.";
                // dd($asd);

                $dataa['to'] = $email;           
                $dataa['subject'] = 'Forgot Password';
                $dataa['message'] = $message;
                $asd = sendMailSMTP($dataa);
                $response = array();
                $response["success"] = 1;
                $response["message"] = "New password has been sent on your email id";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Email is not registered with us";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Change Password ##
    public function user_change_password() {
        if (isset($_POST['email']) && isset($_POST['old_password']) && isset($_POST['new_password'])) {
            $email = $_POST['email'];
            $user_id = $_POST['user_id'];
            $old_password = md5($_POST['old_password']);
            $new_password = md5($_POST['new_password']);
            $result_login = $this->db->query("select * from user where email='$email' AND id = '$user_id'");
            $row_login = $result_login->row_array();
            if ($result_login->num_rows() > 0) {
                if ($old_password == $row_login['password']) {
                    $data_pass = array('password' => $new_password, 'dt_updated' => strtotime(DATE_TIME));
                    $this->db->where('email', $email);
                    $this->db->update('user', $data_pass);
                    $data["success"] = 1;
                    $data["message"] = "Password has been updated successfully";
                    $output = json_encode(array('responsedata' => $data));
                    echo $output;
                } else {
                    $response = array();
                    $response["success"] = 0;
                    $response["message"] = "Please enter valid old password";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Email is not registered with us.";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Update Profile ##
    public function profile_update() {
        if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['user_id']) ) {
            $user_id = $_POST['user_id'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $user_gst_number = $_POST['user_gst_number'];
            $data_user = array('fname' => $fname, 'lname' => $lname, 'phone' => $phone, 'user_gst_number' => $user_gst_number, 'dt_updated' => strtotime(DATE_TIME));
            $this->db->where('id', $user_id);
            $this->db->update('user', $data_user);
            $data["success"] = 1;
            $data["message"] = "User profile has been updated successfully";
            $output = json_encode(array('responsedata' => $data));

            echo $output;
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## User Profile ##
    public function user_details() {

        if (isset($_POST['id'])) {
            $device_id = '';
            if (isset($_POST['device_id'])) {
                $device_id = $_POST['device_id'];
            }
            $user_id = $_POST['id'];
            $query = $this->db->query("SELECT * FROM user WHERE id = '$user_id'");
            $result = $query->row_array();
            // print_r($result);exit;
            $user_id = $result['id'];
            $_POST['user_id'] = $user_id;

            $user_address_query = $this->db->query("SELECT * FROM user_address WHERE user_id = '$user_id' AND status != '9' ORDER BY id DESC");
            $user_address_result = $user_address_query->result();
            $address_array = '';


            
            $total_cart = $this->this_model->get_total($_POST);


            $my_cart_result = $this->this_model->getCart($user_id);
            $total_count = count($my_cart_result);

           
           
            $my_cart_price_result = $total_cart[0]->total;
            $cart_response["data"] = array();
            if(!empty($my_cart_result)){

                $BranchId = $my_cart_result[0]->branch_id;
                $vendor_query = $this->db->query("SELECT * FROM branch WHERE id ='$BranchId'");
                $vendor_result = $vendor_query->result();

                $payment_method = $this->db->query("SELECT * FROM payment_method WHERE branch_id ='$BranchId' AND status='1'");

                $p_method = $payment_method->result();
                
                
                
                $vendorData = [];
                $vendorData['id'] = ($vendor_result[0]->id == null) ? "" : $vendor_result[0]->id ;
                $vendorData['name'] = ($vendor_result[0]->name == null) ? "" : $vendor_result[0]->name ;
                $vendorData['address'] = ($vendor_result[0]->address == null) ? "" : $vendor_result[0]->address;
                $vendorData['currency_code'] = ($vendor_result[0]->currency_code == null) ? "" : $vendor_result[0]->currency_code; 
                $vendorData['selfPickUp'] =  ($vendor_result[0]->selfPickUp == null) ? "" : $vendor_result[0]->selfPickUp;
                $vendorData['isOnlinePayment'] = (string)$vendor_result[0]->isOnlinePayment;
                $vendorData['isCOD'] = (string)$vendor_result[0]->isCOD;
                $vendorData['store_time'] =  ($vendor_result[0]->selfPickupOpenClosingTiming == null) ? "" : $vendor_result[0]->selfPickupOpenClosingTiming;
                $publish_key ='';
                $paymentMethod ='';
                if(!empty($p_method)){
                     require_once 'vendor/autoload.php';
                    $cryptor = new \RNCryptor\RNCryptor\Encryptor;
                    $password = "BGV9UAw9wp5tT7I9wRcw%Xv!a@8aApqW";
                    if ($p_method[0]->IsTestOrLive == '0') {
                        $p_method[0]->publish_key = $p_method[0]->test_publish_key;
                    }
                   $publish_key =  ($p_method[0]->publish_key == null) ? '' : $cryptor->encrypt($p_method[0]->publish_key, $password);
                   $paymentMethod = ($p_method[0]->publish_key == null) ? '' : $p_method[0]->payment_opt;

                }

               
                $vendorData['publish_key'] = $publish_key;
                $vendorData['paymentMethod'] = $paymentMethod;

            if (!empty($my_cart_result)) {

                $cart_response['success'] = "1";
                $cart_response['message'] = "My cart item list";
                $cart_response["count"] = $total_count;
                $cart_response["total_price"] = number_format((float)$my_cart_price_result, 2, '.', '');;
                $counter = 0;
                $branch_id = $my_cart_result[0]->branch_id;
                $total_gst = 0;
                foreach ($my_cart_result as $row) {
                    $product_weight_id = $row->product_weight_id;
                    $product_id = $row->product_id;
                    $weight_id = $row->weight_id;
                    $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id'  AND product_variant_id = '$product_weight_id'  ORDER BY id DESC");
                    $product_image_result = $product_image_query->result();
                    $qnt_query = $this->db->query("SELECT quantity FROM product_weight WHERE id = '$product_weight_id'");
                    $qnt = $qnt_query->result();
                    $quant = $qnt[0]->quantity;
                    $product_weight_query = $this->db->query("SELECT pw.*, p.name as product_name, p.image as product_image, w.name as product_weight_name,p.gst FROM product_weight as pw 
                    LEFT JOIN product as p ON p.id = pw.product_id
                    LEFT JOIN weight as w ON w.id = pw.weight_id
                    WHERE pw.id = '$product_weight_id' AND pw.status != '9'");

                    $product_weight_result = $product_weight_query->row_array();
                    $package_id = $product_weight_result['package'];
                    $package_name = $this->this_model->get_package($package_id);
                    $product_unit = $product_weight_result['weight_no'];
                    $product_name = $product_weight_result['product_name'];
                    $product_image = $product_weight_result['product_image'];
                    $product_weight_name = $product_weight_result['product_weight_name'];
                    $product_actual_price = $product_weight_result['price'];
                    $product_discount_price = $product_weight_result['discount_price'];
                    $data = array();
                    $data['id'] = $row->id;
                    $data['device_id'] = $row->device_id;
                    $data['user_id'] = $row->user_id;
                    $data['product_weight_id'] = $row->product_weight_id;
                    $data['product_unit'] = $product_unit . ' ' . $product_weight_name;
                    $data['product_name'] = $product_name;
                    $data['discount_per'] = $product_weight_result['discount_per'];
                    $data['product_actual_price'] = $product_actual_price;
                    $data['product_discount_price'] = $product_discount_price;
                    if (count($product_image_result) <= 0) {
                        $image = '';
                    } else {
                        $image = base_url() . 'public/images/'.$this->folder.'product_image/' . $product_image_result[0]->image;
                    }
                    $image = str_replace(' ', '%20', $image);

                   
                    $data['product_image'] = $image;
                    $data['product_image_thumb'] = $image;
                    $data['product_id'] = $row->product_id;
                    $data['weight_id'] = $row->weight_id;
                    $data['quantity'] = $row->quantity;
                    $data['available_quantity'] = $quant;
                    $data['package_name'] = $package_name;
                    $data['status'] = $row->status;
                    $data['dt_added'] = $row->dt_added;
                    $data['dt_updated'] = $row->dt_updated;
                    array_push($cart_response["data"], $data);
                    $counter++;
                }
            }
        }

            if ($query->num_rows() > 0) {
                $address_arr = [];
                if ($user_address_result) {
                    foreach ($user_address_result as $address) {
                        $get_charge = 'N';
                        
                        if (isset($branch_id)) {
                            $get_charge = $this->this_model->get_delivery_charge($address->latitude, $address->longitude, $branch_id);
                            // print_r($get_charge);die;
                        }
                        $data = array('id' => $address->id, 'address' => $address->address, 'user_id' => $address->user_id, 'latitude' => $address->latitude, 'longitude' => $address->longitude, 'name' => $address->name, 'pincode' => $address->pincode, 'landmark' => $address->landmark, 'city' => $address->city, 'state' => $address->state, 'country' => $address->country, 'phone' => $address->phone, 'delivery_charge' => $get_charge,'status'=>$address->status);
                        $address_arr[] = $data;
                    }
                    $address_array = $address_arr;
                } else {
                    $address_array = array();
                }

                $data_user = array(
                    'id' => $result['id'], 
                    'fname' => $result['fname'], 
                    'lname' => $result['lname'], 
                    'email' => $result['email'], 
                    'phone' => $result['phone'], 
                    'status' => $result['status'], 
                    'dt_added' => $result['dt_added'], 
                    'dt_updated' => $result['dt_updated'], 
                    'user_address_data' => $address_array, 
                    'vendor_details' => $vendorData, 
                    'cart_response' => $cart_response,
                );

                $response = array();
                $response["success"] = 1;
                $response["message"] = "User Details";
                $response["user_data"] = $data_user;
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "User not found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    public function get_filter_list() {
        $result = $this->this_model->get_filter($this->input->post());
        if (count($result) > 0) {
            $return = array('success' => '1', 'message' => 'filter list', 'data' => $result);
            echo json_encode($return);
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Category List ##
    public function category_list() {
        $post = $this->input->post();
        $req = array('branch_id');
        $response = $this->checkRequiredField($post, $req);
        $branch_id = $post['branch_id'];
        $query = $this->db->query("SELECT * FROM category WHERE branch_id = $branch_id AND status != '9' ORDER BY id DESC");
        $result = $query->result();
        if ($query->num_rows() > 0) {
            $response['success'] = "1";
            $response['message'] = "Category list";
            $response["data"] = array();
            $counter = 0;
            foreach ($result as $row) {
                $data = array();
                $data['id'] = $row->id;
                $data['name'] = $row->name;
                $data['image'] = base_url() . 'public/images/'.$this->folder.'category/' . $row->image;
                $data['image_thumb'] = base_url() . 'public/images/'.$this->folder.'category_thumb/' . $row->image;
                $data['status'] = $row->status;
                $data['dt_added'] = $row->dt_added;
                $data['dt_updated'] = $row->dt_updated;
                array_push($response["data"], $data);
                $counter++;
            }
            echo $output = json_encode(array('responsedata' => $response));
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Product List ##
    public function product_list() {
            if (isset($_POST['branch_id'])) {
                $this->this_model->get_product_list($this->input->post());
            }
    }

    public function product_detail() {
        $this->load->model('api_v3/common_model','co_model');
            $isShow = $this->co_model->checkpPriceShowWithGstOrwithoutGst($_POST['vendor_id']);
     
        if (isset($_POST['product_id']) && isset($_POST['branch_id'])) {
            $product_id = $_POST['product_id'];
            $category_id = $_POST['category_id'];
            $user_id = $_POST['user_id'];
            $device_id = $_POST['device_id'];
            $branch_id = $_POST['branch_id'];
            $checkBranchIsActive = $this->this_model->isBranchActive($branch_id);

            // get branch details
            $branchRecord = $this->db->query("SELECT phone_no,whatsappFlag FROM branch where id = '$branch_id'");
            $branchDetails = $branchRecord->result();
            $whatsappFlag = $branchDetails[0]->whatsappFlag;
            $countryCode = '91';
            $mobile = '';   
            if(!empty($branchDetails) && $branchDetails[0]->phone_no != ''){
                if($_SERVER['SERVER_NAME'] == 'ugiftonline.com'){
                    $countryCode = '1';
                }
                $mobile = $countryCode.$branchDetails[0]->phone_no;
            }


            $result_count = $this->db->query("SELECT p.* FROM `product` as p 
        LEFT JOIN product_weight as w ON w.product_id = p.id
        WHERE p.branch_id = '$branch_id'  AND w.status != '9' AND p.id = '$product_id' GROUP BY p.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2))");
            $row_count_ = $result_count->result();
            $total_count = count(array_keys($row_count_));
          
            $query = $this->db->query("SELECT p.* FROM `product` as p 
                                        LEFT JOIN product_weight as w ON w.product_id = p.id
                                        WHERE  p.branch_id = '$branch_id' AND w.discount_price != '' AND w.status != '9' AND p.id = '$product_id' GROUP BY p.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2))");
            $result = $query->result();
            // echo $this->db->last_query();die;
            if ($query->num_rows() > 0) {
                $response['success'] = "1";
                $response['message'] = "Product list";
                $response["count"] = $total_count;
                // $response["data"] = array();
                $counter = 0;
                foreach ($result as $row) {
                    $product_id = $_POST['product_id'];
                    $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id'  AND branch_id = '$branch_id' GROUP BY id ORDER BY min(discount_price) * 1 ASC");
                    $product_weight_result = $product_weight_query->result();
                    $new_array_product_weight = array();

                    foreach ($product_weight_result as $pro_weight) {
                        
                        $whatsappShareUrl = base_url().'products/productDetails/'.$this->utility->safe_b64encode($pro_weight->product_id).'/'.$this->utility->safe_b64encode($pro_weight->id);

                        $package_id = $pro_weight->package;
                        $package_name = $this->this_model->get_package($package_id);
                        $product_weight_id = $pro_weight->id;

                        $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id'  AND product_variant_id = '$product_weight_id' AND branch_id = '$branch_id' ORDER BY id DESC");
                        $product_image_result = $product_image_query->result();
                        
                        $weight_id = $pro_weight->weight_id;
                        $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                        $weight_result = $weight_query->row_array();
                        $weight_name = $weight_result['name'];

                        if (isset($_POST['user_id']) && $_POST['user_id'] != '') {
                            $my_cart_query = $this->db->query("SELECT mc.quantity  FROM my_cart as mc LEFT join product_weight as pw ON pw.id=mc.product_weight_id WHERE pw.product_id = '$product_id'AND mc.product_weight_id = '$product_weight_id' AND mc.branch_id = '$branch_id' AND mc.user_id = '$user_id'");
                            $my_cart_result = $my_cart_query->row_array();
                        } else {
                            if (isset($_POST['device_id'])) {
                                $my_cart_query = $this->db->query("SELECT mc.quantity FROM my_cart as mc LEFT join product_weight as pw ON pw.id=mc.product_weight_id WHERE pw.product_id = '$product_id' AND mc.product_weight_id = '$product_weight_id' AND mc.branch_id = '$branch_id' AND (mc.user_id = '0' AND mc.device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();
                            } else {
                                $my_cart_result = array();
                            }
                        }
                        if (empty($my_cart_result)) {
                            $my_cart_quantity = '0';
                        } else {
                            $my_cart_quantity = $my_cart_result['quantity'];
                        }
                        $img = [];
                        foreach ($product_image_result as $pro_image) {
                            if(!file_exists('public/images/'.$this->folder.'product_image/'.$pro_image->image) || $pro_image->image == ''){
                                $this->load->model('common_model');
                                $default_product_image =$this->common_model->default_product_image();
                                $pro_image->image =  $default_product_image;
                            }
                            $pro_image->image = str_replace(' ', '%20', $pro_image->image);
                            $img[] = array('id' => $pro_image->id, 'product_id' => $pro_image->product_id, 'weight_id' => $pro_weight->weight_id, 'image' => base_url() . 'public/images/'.$this->folder.'product_image/' . $pro_image->image, 'thumb_image' => base_url() . 'public/images/'.$this->folder.'product_image_thumb/' . $pro_image->image,);
                        }

                        if(!empty($isShow) && $isShow[0]->display_price_with_gst == '1'){
                               $pro_weight->discount_price = $pro_weight->without_gst_price; 
                        }  
                        $data = array('id' => $pro_weight->id, 'product_id' => $pro_weight->product_id, 'weight_id' => $pro_weight->weight_id, 'unit' => ($pro_weight->weight_no) . ' ' . $weight_name, 'actual_price' => $pro_weight->price, 'avail_quantity' => $pro_weight->quantity, 'package_name' => $package_name, 'discount_per' => $pro_weight->discount_per, 'discount_price' => $pro_weight->discount_price, 'my_cart_quantity' => $my_cart_quantity, 'variant_images' => $img,'whatsappShareUrl'=>$whatsappShareUrl);
                        array_push($new_array_product_weight, $data);
                    }
                    $product_weight_array = $new_array_product_weight;
                    
                    $proimg = $product_image_result[0]->image;
                    $prothimg = $product_image_result[0]->image;
                    $product_image_array = $img;
                    $data = array();
                    if($checkBranchIsActive == 0){
                        $row->status = '9'; // branch is disable
                    }
                    $data['id'] = $row->id;
                    $data['category_id'] = $row->category_id;
                    $data['brand_id'] = $row->brand_id;
                    $data['name'] = $row->name;
                    $data['image'] = base_url() . 'public/images/'.$this->folder.'product_image/' . $proimg;
                    $data['image_thumb'] = base_url() . 'public/images/'.$this->folder.'product_image_thumb/' . $prothimg;
                    $data['about'] = ($row->about != null) ? $row->about : "";
                    $data['content'] = ($row->content != null) ? $row->content : "";
                    $data['whatsappFlag'] = $whatsappFlag;
                    $data['mobile'] = $mobile;
                    $data['status'] = $row->status;
                    $data['dt_added'] = $row->dt_added;
                    $data['dt_updated'] = $row->dt_updated;
                    $data['product_weight'] = $product_weight_array;
                    $data['product_image'] = $product_image_array;
                    $response["data"] = $data;
                    $counter++;
                }
                echo $output = json_encode(array('responsedata' => $response));
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "No record found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Check Device Token ##
    public function check_device_token() {
        if (isset($_POST['device_id']) && isset($_POST['device_type']) && isset($_POST['device_token']) && isset($_POST['device_os']) && isset($_POST['device_key'])) {
            $deviceid = $_POST['device_id'];
            $device_type = $_POST['device_type'];
            $device_token = $_POST['device_token'];
            $device_os = $_POST['device_os'];
            $device_key = $_POST['device_key'];
            $insert_push_data = array('device_id' => $deviceid, 'device_type' => $device_type, 'device_token' => $device_token, 'device_os' => $device_os, 'device_key' => $device_key,);
            $check_userid_exists = $this->db->query("select * from device_token_check where device_os='$device_os' and device_id='$deviceid'");
            if ($check_userid_exists->num_rows() > 0) {
                $check_exist = $this->db->query("select * from device_token_check where device_id='$deviceid' and device_token='$device_token'");
                $row_check_exist = $check_exist->result();
                $db_device_token = $row_check_exist['0']->device_token;
                if ($db_device_token == $device_token) {
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Device Token Already exists...!";
                    $output2 = json_encode(array('responsedata' => $response));
                    echo $output2;
                } else {
                    //update device token
                    $data_array = array('device_os' => $device_os, 'device_id' => $deviceid);
                    $this->db->where($data_array);
                    $update_data = $this->db->update('device_token_check', $insert_push_data);
                    if ($update_data) {
                        $response = array();
                        $response["success"] = 1;
                        $response["message"] = "Device Token Successfully Updated...!";
                        $output2 = json_encode(array('responsedata' => $response));
                        echo $output2;
                    } else {
                        $response = array();
                        $response["success"] = 0;
                        $response["message"] = "Error in device TOken...!";
                        $output2 = json_encode(array('responsedata' => $response));
                        echo $output2;
                    }
                }
            } else {
                $insert_data = $this->db->insert('device_token_check', $insert_push_data);
                if ($insert_data) {
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Device Token Successfully added...!";
                    $output2 = json_encode(array('responsedata' => $response));
                    echo $output2;
                } else {
                    $response = array();
                    $response["success"] = 0;
                    $response["message"] = "Error in device Tken...!";
                    $output2 = json_encode(array('responsedata' => $response));
                    echo $output2;
                }
            }
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Error...!";
            $output2 = json_encode(array('responsedata' => $response));
            echo $output2;
        }
    }

    ## Price List ##
    public function price_list() {
        $result_count = $this->db->query("SELECT COUNT(*) as total FROM price WHERE status != '9'");
        $row_count = $result_count->result();
        $total_count = $row_count[0]->total;
        $query = $this->db->query("SELECT * FROM price WHERE status != '9' ORDER BY id DESC");
        $result = $query->result();
        if ($query->num_rows() > 0) {
            $response['success'] = "1";
            $response['message'] = "Price list";
            $response["count"] = $total_count;
            $response["data"] = array();
            $counter = 0;
            foreach ($result as $row) {
                $data = array();
                $data['id'] = $row->id;
                $data['start_price'] = $row->start_price;
                $data['end_price'] = $row->end_price;
                $data['status'] = $row->status;
                $data['dt_added'] = $row->dt_added;
                $data['dt_updated'] = $row->dt_updated;
                array_push($response["data"], $data);
                $counter++;
            }
            echo $output = json_encode(array('responsedata' => $response));
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Discount List ##
    public function discount_list() {
        $result_count = $this->db->query("SELECT COUNT(*) as total FROM discount WHERE status != '9'");
        $row_count = $result_count->result();
        $total_count = $row_count[0]->total;
        $query = $this->db->query("SELECT * FROM discount WHERE status != '9' ORDER BY id DESC");
        $result = $query->result();
        if ($query->num_rows() > 0) {
            $response['success'] = "1";
            $response['message'] = "Discount list";
            $response["count"] = $total_count;
            $response["data"] = array();
            $counter = 0;
            foreach ($result as $row) {
                $data = array();
                $data['id'] = $row->id;
                $data['start_discount'] = $row->start_discount;
                $data['end_discount'] = $row->end_discount;
                $data['status'] = $row->status;
                $data['dt_added'] = $row->dt_added;
                $data['dt_updated'] = $row->dt_updated;
                array_push($response["data"], $data);
                $counter++;
            }
            echo $output = json_encode(array('responsedata' => $response));
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Weight List ##
    public function weight_list() {

        $limit = '5';
        $offset = $_POST['offset'];
        $result_count = $this->db->query("SELECT COUNT(*) as total FROM weight WHERE status != '9'");
        $row_count = $result_count->result();
        $total_count = $row_count[0]->total;
        $cal = $limit * $offset;
        $query = $this->db->query("SELECT * FROM weight WHERE status != '9' ORDER BY id DESC LIMIT $limit OFFSET $cal");
        $result = $query->result();
        if ($query->num_rows() > 0) {
            $response['success'] = "1";
            $response['message'] = "Weight list";
            $response["count"] = $total_count;
            $response["data"] = array();
            $counter = 0;
            foreach ($result as $row) {
                $data = array();
                $data['id'] = $row->id;
                $data['name'] = $row->name;
                $data['status'] = $row->status;
                $data['dt_added'] = $row->dt_added;
                $data['dt_updated'] = $row->dt_updated;
                array_push($response["data"], $data);
                $counter++;
            }
            echo $output = json_encode(array('responsedata' => $response));
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Time Slot List ##
    public function time_slot_list() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $response = $this->checkRequiredField($post, $req);
        $vendor_id = $_POST['vendor_id'];
        $result_count = $this->db->query("SELECT COUNT(*) as total FROM time_slot WHERE status != '9' AND vendor_id = '$vendor_id'");
        $row_count = $result_count->result();
        $query = $this->db->query("SELECT * FROM time_slot WHERE status != '9' AND vendor_id = '$vendor_id' ORDER BY id DESC");
        $result = $query->result();
        if ($query->num_rows() > 0) {
            $response['success'] = "1";
            $response['message'] = "Time slot list";
            $response["count"] = $row_count[0]->total;
            $response["data"] = array();
            $counter = 0;
            foreach ($result as $row) {
                $data = array();
                $data['id'] = $row->id;
                $data['start_time'] = $row->start_time;
                $data['end_time'] = $row->end_time;
                $data['status'] = $row->status;
                $data['dt_added'] = $row->dt_added;
                $data['dt_updated'] = $row->dt_updated;
                array_push($response["data"], $data);
                $counter++;
            }
            echo $output = json_encode(array('responsedata' => $response));
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Banner Promotion List ##
    public function banner_promotion_list() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $response = $this->checkRequiredField($post, $req);
        if($response['status'] = '1'){
            unset($response);
        }
        
        if ($_POST['vendor_id'] == '0') {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "No record found";
             $output = json_encode(array('responsedata' => $response));
            echo $output;die;
        }
        $vendor_id = $_POST['vendor_id'];
        if (!empty($this->input->post('vendor_id')) && $_POST['vendor_id'] != '0') {
            $query1 = $this->db->query("SELECT * FROM branch WHERE vendor_id = '$vendor_id' AND status != '1'");
            $branch = $query1->result();
            $branch_id = (!empty($branch)) ? $branch[0]->id : 0;
            $query = $this->db->query(
                "SELECT b.* ,c.name as category_name FROM banners as b 
                LEFT JOIN category as c ON c.id = b.category_id
                LEFT JOIN branch as br ON br.id = b.branch_id 
                WHERE b.vendor_id = '$vendor_id' AND br.status = '1'");  
            $result = $query->result();
            
            $offer_list = $this->this_model->get_offer($vendor_id);
        }

        if ($query->num_rows() > 0 || !empty($offer_list) ) {
            $response['success'] = "1";
            $response['message'] = "Banner promotion list";
            $response["data"] = array();
            $counter = 0;
            foreach ($result as $row) {
                $data = array();
                $data['id'] = $row->id;
                $data['branch_id'] = $row->branch_id;
                $data['type'] = $row->type;
                $data['category_id'] = $row->category_id;
                $data['category_name'] = ($row->category_name!='')?$row->category_name:'';
                $data['product_id'] = $row->product_id;
                $data['product_varient_id'] = $row->product_varient_id;
                $data['image'] = base_url() . 'public/images/'.$this->folder.'banner_promotion/' . $row->app_banner_image;
                $data['image_thumb'] = base_url() . 'public/images/'.$this->folder.'banner_promotion_thumb/' . $row->app_banner_image;
                $data['dt_added'] = $row->dt_created;
                $data['dt_updated'] = $row->dt_updated;
                array_push($response["data"], $data);
                $counter++;
            }
            // $branch_id = $result[0]->branch_id;
            unset($data);
            $response['offer_list'] = $offer_list;
            $type = '1';
            foreach ($response['offer_list'] as $key => $value) {
                $c = $this->this_model->check_branch_is_active($value->branch_id);
                
                if($c->status == 0){
                    unset($response['offer_list'][$key]);
                    continue;
                }

                $s = $this->this_model->check($value->id);
                if(count($s) > 1){
                 $type = '2';   
                }
               $value->type = $type;        
            }
           $response['offer_list'] = array_values($response['offer_list']);
            echo $output = json_encode(array('responsedata' => $response));
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Brand List ##
    public function brand_list() {
        if (isset($_POST['category_id'])) {
          
            $category_id = $_POST['category_id'];
            $result_count = $this->db->query("SELECT COUNT(*) as total FROM brand WHERE status != '9' AND category_id = '$category_id'");
            $row_count = $result_count->result();
            $total_count = $row_count[0]->total;
          
            $query = $this->db->query("SELECT * FROM brand WHERE status != '9' AND category_id = '$category_id' ORDER BY id DESC");
            $result = $query->result();
            if ($query->num_rows() > 0) {
                $response['success'] = "1";
                $response['message'] = "Brand list";
                $response["count"] = $total_count;
                $response["data"] = array();
                $counter = 0;
                foreach ($result as $row) {
                    $data = array();
                    $data['id'] = $row->id;
                    $data['name'] = $row->name;
                    $data['category_id'] = $row->category_id;
                    $data['status'] = $row->status;
                    $data['dt_added'] = $row->dt_added;
                    $data['dt_updated'] = $row->dt_updated;
                    array_push($response["data"], $data);
                    $counter++;
                }
                echo $output = json_encode(array('responsedata' => $response));
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "No record found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Add To Cart  - Single Product ##
    function check_cart($postdata) {
        $qnt = $postdata['quantity'];
        $variant_id = $postdata['product_weight_id'];
        $vendor_id = $postdata['vendor_id'];
        $result = $this->this_model->check_quantity($qnt, $variant_id);
        if($result['success']==6){
            $cartData = $this->this_model->get_cart_variant($postdata);
            $quntity = 0;
            if(!empty($cartData)){
                $quntity = $cartData[0]['quantity'];            
            }
            $result["updated_quantity"] = $quntity;
            $output = json_encode(array('responsedata' => $result));
            echo $output;
            exit;
        }
        if (isset($postdata['user_id']) && $postdata['user_id'] != '') {
            $user_id = $postdata['user_id'];
            $device_id = $postdata['device_id'];
            $check = $this->db->query("SELECT * FROM my_cart WHERE user_id = '$user_id' AND vendor_id = '$vendor_id'");
        } else {
            if (isset($postdata['device_id'])) {
                $device_id = $postdata['device_id'];
                $u = 0;
                $check = $this->db->query("SELECT * FROM my_cart WHERE device_id = '$device_id' AND user_id = '0' AND vendor_id = '$vendor_id'");
            }
        }
      
        if ($check->num_rows() > 0) {
            $check = $check->result();
            $cart_vendor = $check[0]->branch_id;
            $branch_id = $postdata['branch_id'];
            if ($cart_vendor != $branch_id) {
                $response = array();
                $response["success"] = 5;
                $response["message"] = "You can only order from one shop...Are you sure you want to clear cart?";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
                exit;
            }
        }
    }

    public function add_to_cart() {

        if (isset($_POST['product_weight_id']) && isset($_POST['quantity']) && isset($_POST['branch_id'])) {
            if($_POST['quantity']=='0'){
                return $this->delete_my_cart_item();
            }
            $this->check_cart($_POST);
            $result = $this->this_model->add_to_cart($this->input->post());
            if ($result) {
                $this->send_cart_response($this->input->post());
                exit;
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Error to add";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
                exit;
            }
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
        
    }

    public function send_cart_response($postdata) {
        $total_gst = $this->this_model->gstCalculation($postdata);
        $response["success"] = 1;
        $response["message"] = "Product has been updated in your cart";
        $gettotal = $this->this_model->get_total($postdata);

        $getactual = $this->this_model->get_actual_total($postdata);
        $cartData = $this->this_model->get_cart_variant($postdata);

        $gettotalPrice = $getactual;
        
        $my_cal = (float)$gettotal[0]->total;
        
        if ($my_cal === null || $my_cal == "<null>") {
            $my_cal = 0.0;
        }
        if ($gettotalPrice === null || $gettotalPrice == "<null>") {
            $gettotalPrice = 0.0;
        }
        $response["count"] = (int)$gettotal[0]->cart_items;
        $response["actual_price"] = $gettotalPrice;
        $response["discount_price"] = number_format((float)$gettotalPrice - $my_cal, 2, '.', '');
        $response["total_price"] = number_format((float)$my_cal, 2, '.', '');
        $response["TotalGstAmount"] = number_format((float)$total_gst, 2, '.', '');
        $response["amountWithoutGst"] = number_format((float)$my_cal - $total_gst, 2, '.', '');
        $quntity = 0;
        if(!empty($cartData)){
        $quntity = $cartData[0]['quantity'];
        
        }
        $response["updated_quantity"] = $quntity;
        $output = json_encode(array('responsedata' => $response));
        echo $output;
        exit;
    }

    public function delete_cart_item() {
        if (isset($_POST['cart_id']) && $_POST['cart_id'] != '') {
            $cart_id = $_POST['cart_id'];
            $this->db->query("DELETE FROM my_cart WHERE id = '$cart_id'");
            $response = array();
            $response["success"] = 1;
            $response["message"] = "Cart deleted";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    public function delete_cart() {
        $error = 1;
        if (isset($_POST['user_id']) && $_POST['user_id'] != '') {
            $user_id = $_POST['user_id'];
            $this->db->query("DELETE FROM my_cart WHERE user_id = '$user_id'");
         
            $response = array();
            $response["success"] = 1;
            $response["message"] = "Cart deleted";
            $output = json_encode(array('responsedata' => $response));
            $responce = $output;
            $error = 0;
        } else {
            if (isset($_POST['device_id']) && $_POST['device_id'] != '') {
                $device_id = $_POST['device_id'];
                $vendor_id = $_POST['vendor_id'];
                $this->db->query("DELETE FROM my_cart WHERE device_id = '$device_id' AND vendor_id = '$vendor_id' AND user_id = '0'");
               
                $response = array();
                $response["success"] = 1;
                $response["message"] = "Cart deleted";
                $output = json_encode(array('responsedata' => $response));
                $responce = $output;
                $error = 0;
            }
        }
        if ($error == 1) {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            $responce = $output;
        }
        echo $responce;
    }

    ## My Cart List ##
    public function my_cart() {
        $post = $this->input->post();
        $req = array('vendor_id','device_id');
        $response = $this->checkRequiredField($post, $req);
        $this->this_model->my_cart($this->input->post());
    }

    ## Delete My Cart Item ##
    public function delete_my_cart_item() {
        if (isset($_POST['product_weight_id']) && isset($_POST['branch_id'])) {
            $this->this_model->delete_cart($this->input->post());
            $this->send_cart_response($this->input->post());
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
        exit;
    }
   
    ## Checkout ##
    public function checkout() {
        $this->this_model->checkout($_POST);
    }
   	
    public function set_reserve_quantity()
    {
        if (isset($_POST['user_id'])) {
            $updatedQTY = $this->this_model->set_reserve_quantity($_POST['user_id']);
        }
        $response = array();
        
        $gettotal = $this->this_model->get_total($_POST);
        $response["cart_count"] = (int)$gettotal[0]->cart_items;
        $response["success"] = 1;
        $response["message"] = "Products Reserved!!";
        $output = json_encode(array('responsedata' => $response));
        
        echo $output;
        die;
    }

    public function unreserve_quantity()
    {
        $this->this_model->unreserve_quantity();   
    }

    function unreserve_product_userwise(){
        if (isset($_POST['user_id'])) {
 			$updatedQTY = $this->this_model->unreserve_product_userwise($_POST['user_id']);
   	    }
        $response = array();
        $response["success"] = 1;
        $response["message"] = "Products Revesed!!";
        $output = json_encode(array('responsedata' => $response));
        
        echo $output;
        die;
   	}

    function sendCustomerEmailTemplate($user_id, $branch_id, $order_id) {
        $this->this_model->emailTemplate($user_id, $branch_id, $order_id);
    }

    ## My Orders ##
    public function my_orders() {

        if (isset($_POST['user_id']) && $_POST['user_id'] != '') {
            $limit = '10';
            $offset = $_POST['offset'];
            $user_id = $_POST['user_id'];
            if (isset($_POST['order_status']) && $_POST['order_status'] != '') {
                $order_status = $_POST["order_status"];
                $result_count = $this->db->query("SELECT COUNT(*) as total FROM `order` WHERE status != '9' AND user_id = '$user_id' AND order_status = $order_status");
            } else {
                $result_count = $this->db->query("SELECT COUNT(*) as total FROM `order` WHERE status != '9' AND user_id = '$user_id'");
            }
            $row_count = $result_count->result();
            $total_count = $row_count[0]->total;
            $cal = $limit * $offset;
            if (isset($_POST['order_status']) && $_POST['order_status'] != '') {
                $order_status = $_POST["order_status"];
                $query = $this->db->query("SELECT * FROM `order` WHERE status != '9' AND user_id = '$user_id' AND order_status = '$order_status' ORDER BY dt_updated DESC LIMIT $limit OFFSET $cal");
            } else {
                $query = $this->db->query("SELECT * FROM `order` WHERE status != '9' AND user_id = '$user_id' ORDER BY dt_updated DESC LIMIT $limit OFFSET $cal");
            }
            $result = $query->result();
           
            if ($query->num_rows() > 0) {
                $response['success'] = "1";
                $response['message'] = "My order list";
                $response["count"] = $total_count;
                $response["data"] = array();
                $counter = 0;
                foreach ($result as $row) {
                    $data = array();
                    $data['order_id'] = $row->id;
                    $data['dt_added'] = date('F d, Y', $row->dt_added);
                    $data['order_no'] = $row->order_no;
                    $data['isSelfPickup'] = $row->isSelfPickup;
                    $data['order_status'] = $row->order_status;
                    $data['total'] = $row->payable_amount;
                    array_push($response["data"], $data);
                    $counter++;
                }
                echo $output = json_encode(array('responsedata' => $response));
                die;
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "No record found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
                die;

            }
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
            die;

        }
    }

    ## My Orders Details ##
    public function my_order_details() {

        if (isset($_POST['user_id']) && isset($_POST['order_id'])) {
            $this->load->model('api_v3/common_model','co_model');
            $isShow = $this->co_model->checkpPriceShowWithGstOrwithoutGst($postdata['vendor_id']);
            $limit = '10';
            $user_id = $_POST['user_id'];
            $order_id = $_POST['order_id'];
            $actual_price_total = 0;
            $discount_price_total = 0;
            $result_count = $this->db->query("SELECT COUNT(*) as total FROM `order_details` WHERE status != '9' AND user_id = '$user_id' AND order_id = '$order_id'");
            $row_count = $result_count->result();
            $query = $this->db->query("SELECT * FROM `order_details` WHERE status != '9' AND user_id = '$user_id' AND order_id = '$order_id' ORDER BY id DESC ");
            $result = $query->result();
            
            $order_query = $this->db->query("SELECT * FROM `order` WHERE status != '9' AND user_id = '$user_id' AND id = '$order_id'");
            $order_result = $order_query->row_array();
            $check_promocode_used = $order_result['promocode_used'];
            if($check_promocode_used == 1){
                $order_promocode_amount = $this->this_model->get_order_promocode_discount($_POST['order_id']);
                $instance_discount = number_format((float)$order_promocode_amount[0]->amount,'2','.','');
            }else{
                $amount = 0;
                $instance_discount = number_format((float)$amount,'2','.','');
            }

            $isSelfPickup = $order_result['isSelfPickup'];
            $total_with_charge = $order_result['payable_amount'];
            $delivery_charge = $order_result['delivery_charge'];
            // if ($isSelfPickup == 1) {
                $self_pick = $this->db->query("SELECT * FROM `selfPickup_otp` WHERE order_id = '$order_id' AND user_id = '$user_id'");
                $self_otp = $self_pick->row_array();
               
                $self_pick_otp = $self_otp['otp'];
            // }
            $my_order_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from order_details WHERE status != '9' AND order_id = '$order_id' AND user_id = '$user_id'");
            $my_order_price_result = $my_order_price_query->row_array();
            $branch_id = $result[0]->branch_id;
            $vendorDetails = $this->this_model->getVendorAddress($branch_id);
            if ($query->num_rows() > 0) {
                $counter = 0;
                $total_gst = 0;
                foreach ($result as $row) {
                    $gst_percent = $this->this_model->getProductGst($row->product_id);

                    $product_weight_id = $row->product_weight_id;
                    $product_weight_query = $this->db->query("SELECT pw.*, p.name as product_name, p.image as product_image, w.name as product_weight_name,p.gst FROM product_weight as pw 
                    LEFT JOIN product as p ON p.id = pw.product_id
                    LEFT JOIN weight as w ON w.id = pw.weight_id
                    WHERE pw.id = '$product_weight_id' AND pw.status != '9'");
                    
                    $product_weight_result = $product_weight_query->row_array();
                    $product_unit = $product_weight_result['weight_no'];

                    $product_weight_name = $product_weight_result['product_weight_name'];
                    $data['product_unit'] = $product_unit . ' ' . $product_weight_name;
                    $package_id = $product_weight_result['package'];
                    $package_name = $this->this_model->get_package($package_id);
                
                    $discount_price_total = ($row->actual_price * $row->quantity) - $row->calculation_price + $discount_price_total;
                    $data['product_discount_price'] = $row->discount_price;
                    $data['discount_per'] = $row->discount;
                    $actual_price_total = $row->actual_price * $row->quantity + $actual_price_total;

                    // Gst calculation
                    $gst_amount = ($row->discount_price * $gst_percent) / 100;
                    $gst_total_product = $gst_amount * $row->quantity;
                    $total_gst+= $gst_total_product;
                    $total_price = $actual_price_total - $discount_price_total;

                    $response["TotalGstAmount"] = number_format((float)$total_gst, '2', '.', '');
                    $response["amountWithoutGst"] = number_format((float)$total_price - $total_gst, '2', '.', '');
                    $product_id = $row->product_id;

                    $product_query = $this->db->query("SELECT name, image FROM product WHERE  id = '$product_id'");

                    $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' AND product_variant_id = '$product_weight_id'");

                    $product_image_result = $product_image_query->result();
                    
                    $proimg = str_replace(' ', '%20',$product_image_result[0]->image);
                    $prothimg = str_replace(' ', '%20',$product_image_result[0]->image);
                    $product_result = $product_query->row_array();
                    $data = array();
                    $data['name'] = $product_result['name'];
                    $data['image'] = base_url() . 'public/images/'.$this->folder.'product_image/' . $proimg;
                    $data['image_thumb'] = base_url() . 'public/images/'.$this->folder.'product_image_thumb/' . $prothimg;
                    $data['quantity'] = $row->quantity;
                    $data['package_name'] = $package_name;
                    $data['unit'] = $product_unit . ' ' . $product_weight_name;
                    $data['discount'] = $row->discount;
                    $data['actual_price'] = $row->actual_price;
                    $data['price'] = $row->calculation_price;
                    $data['product_id'] = $row->product_id;
                    $data['product_varient_id'] = $row->product_weight_id;
                    $data['branch_id'] = $row->branch_id;
                    $get_data[] = $data;
                    $counter++;
                }

                $response['success'] = "1";
                $response['message'] = "My order details";
                $response["count"] = $counter;
               
                $response["store_name"] = $vendorDetails[0]->name;
                $response["vendor_address"] = $vendorDetails[0]->location;
                $response["actual_price_total"] = $total_with_charge;
                $response["total_price"] = (string)$actual_price_total;
                $response["delivery_charge"] = $delivery_charge;
                $response["discount_price_total"] = $discount_price_total;
                $response["instance_discount"] = $instance_discount;
                $response['isSelfPickup'] = $isSelfPickup;
                $response['verify_otp'] = (isset($self_pick_otp)) ? $self_pick_otp : '1234';
                $response["data"] = $get_data;
                echo $output = json_encode(array('responsedata' => $response));
                die;

            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "No record found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
                die;

            }
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
                die;

        }
    }
    
     ## User Address Add ##
    public function user_address_add() {
        if (isset($_POST['user_id']) && isset($_POST['address']) && isset($_POST['name']) && isset($_POST['pincode']) && isset($_POST['landmark']) && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['country']) && isset($_POST['phone'])) {
            // print_r($_POST);die;
            $user_id = $this->input->post('user_id');
            $address_post = $this->input->post('address');
            $name = $this->input->post('name');
            $pincode = $this->input->post('pincode');
            $landmark = $this->input->post('landmark');
            $city = $this->input->post('city');
            $state = $this->input->post('state');
            $country = $this->input->post('country');
            $phone = $this->input->post('phone');
            $latitude = $this->input->post('latitude');
            $longitude = $this->input->post('longitude');
            
           $re = $this->this_model->AddUserAddress($_POST);
            
           if ($re) {
            $response = array();
            $response["success"] = 1;
            $response["message"] = "Address has been added.";
            $output = json_encode(array('responsedata' => $response));
            echo $output;    
           }else{
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Something went wrong";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
           }
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Please enter valid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    public function set_default_address(){
        if (isset($_POST['address_id']) && $_POST['address_id'] != '' ) {
            $this->this_model->set_default_address($this->input->post());
        }
        $response = array();
        $response["success"] = 1;
        $response["message"] = "Address change successfully";
        $output = json_encode($response);
        echo $output;
    }


    ## User Address Update ##
    public function user_address_update() {
        if (isset($_POST['id']) && isset($_POST['address']) && isset($_POST['name']) && isset($_POST['pincode']) && isset($_POST['landmark']) && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['country']) && isset($_POST['phone'])) {
            $id = $this->input->post('id');
            $address_ = $this->input->post('address');
            $name = $this->input->post('name');
            $pincode = $this->input->post('pincode');
            $landmark = $this->input->post('landmark');
            $city = $this->input->post('city');
            $state = $this->input->post('state');
            $country = $this->input->post('country');
            $phone = $this->input->post('phone');
            $latitude = $this->input->post('latitude');
            $longitude = $this->input->post('longitude');
            
            $data = array('address' => $address_, 'name' => $name, 'pincode' => $pincode, 'landmark' => $landmark, 'city' => $city, 'state' => $state, 'country' => $country, 'phone' => $phone, 'latitude' => $latitude, 'longitude' => $longitude, 'dt_updated' => strtotime(DATE_TIME),);
            $this->db->where('id', $id);
            $this->db->update('user_address', $data);
            // echo $this->db->last_query();exit;
            $response = array();
            $response["success"] = 1;
            $response["message"] = "Address has been updated.";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
                die;

        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Please enter valid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
                die;

        }
    }

    ## Filter ##
    public function cancle_order() {
        $postdata = $this->input->post();
        if (isset($postdata['order_id'])) {
            $cancle = $this->this_model->cancle_order($postdata);
            $this->load->model('api_v3/api_admin_model');
            $order_log_data = array('order_id' =>$postdata['order_id'],'status'=>'9');
            $this->api_admin_model->order_logs($order_log_data);
            if(!$cancle){
                $response["success"] = 0;
                $response["message"] = "Order can not cancle";
                $output = json_encode(array('responsedata' => $response));
                echo $output;die;
            }

           
            $this->load->model('api_v3/staff_api_model');
            $order_id = $postdata['order_id'];
            $this->staff_api_model->send_notificaion($order_id);
            $response["success"] = 1;
            $response["message"] = "Order is cancelled";
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Invalid data";
        }
        $output = json_encode(array('responsedata' => $response));
        echo $output;die;
    }

    ## Product Search ##
    public function product_search() {
        $this->load->model('api_v3/common_model','co_model');
        $isShow = $this->co_model->checkpPriceShowWithGstOrwithoutGst($_POST['vendor_id']);

        $product_name = $_POST['product_name'];
        if (isset($_POST['user_id']) && $_POST['user_id'] != '') {
            $user_id = $_POST['user_id'];
        }
        $device_id = $_POST['device_id'];   
        $branch_id = $_POST['branch_id'];
        if (isset($product_name) && $product_name != '' && (isset($branch_id))) {

            if(isset($branch_id) && $branch_id != ''){
                $result_count = $this->db->query("SELECT p.* FROM `product` as p 
                    LEFT JOIN product_weight as w ON w.product_id = p.id
                    LEFT JOIN branch as br ON br.id = p.branch_id
                    WHERE p.status != '9'  AND p.branch_id = '$branch_id' AND w.discount_price != '' AND w.status != '9' AND (p.name LIKE '%$product_name%' OR p.name LIKE '%$product_name%') GROUP BY p.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2))");
                $row_count_ = $result_count->result();
                $total_count = count(array_keys($row_count_));

                $query = $this->db->query("SELECT p.*,c.name as category_name,sb.name as subcat_name,b.name as brand_name FROM `product` as p 
                    LEFT JOIN product_weight as w ON w.product_id = p.id
                    LEFT JOIN category as c ON c.id = p.category_id
                    LEFT JOIN subcategory as sb ON sb.id = p.subcategory_id
                    LEFT JOIN brand as b ON b.id = p.brand_id
                    LEFT JOIN branch as br ON br.id = p.branch_id

                    WHERE p.status != '9' AND p.branch_id = '$branch_id' AND w.discount_price != '' AND w.status != '9' AND ( p.name LIKE '%$product_name%' OR c.name LIKE '%$product_name%' OR sb.name LIKE '%$product_name%' OR b.name LIKE '%$product_name%' OR p.name LIKE '%$product_name%')
                    GROUP BY p.id,c.id,sb.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2)) ASC ");
                $result = $query->result();
            }else            
            if (isset($_POST['vendor_id']) && $_POST['vendor_id'] != '') {
                $vendor_id = $_POST['vendor_id'];
                $result_count = $this->db->query("SELECT p.* FROM `product` as p 
                    LEFT JOIN product_weight as w ON w.product_id = p.id
                    LEFT JOIN branch as br ON br.id = p.branch_id
                    WHERE p.status != '9'  AND br.vendor_id = '$vendor_id' AND w.discount_price != '' AND w.status != '9' AND (p.name LIKE '%$product_name%' OR p.name LIKE '%$product_name%') GROUP BY p.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2))");
                $row_count_ = $result_count->result();
                $total_count = count(array_keys($row_count_));
                

                $query = $this->db->query("SELECT p.*,c.name as category_name,sb.name as subcat_name,b.name as brand_name FROM `product` as p 
                    LEFT JOIN product_weight as w ON w.product_id = p.id
                    LEFT JOIN category as c ON c.id = p.category_id
                    LEFT JOIN subcategory as sb ON sb.id = p.subcategory_id
                    LEFT JOIN brand as b ON b.id = p.brand_id
                    LEFT JOIN branch as br ON br.id = p.branch_id

                    WHERE p.status != '9' AND br.vendor_id = '$vendor_id' AND w.discount_price != '' AND w.status != '9' AND ( p.name LIKE '%$product_name%' OR c.name LIKE '%$product_name%' OR sb.name LIKE '%$product_name%' OR b.name LIKE '%$product_name%' OR p.name LIKE '%$product_name%')
                    GROUP BY p.id,c.id,sb.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2)) ASC ");
                $result = $query->result();
                
            }

            
               
            if ($query->num_rows() > 0) {
                $response['success'] = "1";
                $response['message'] = "Product list";
                $response["count"] = $total_count;
                $response["data"] = array();
                $counter = 0;
                foreach ($result as $row) {
                    $product_id = $row->id;
                    $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                    $product_weight_result = $product_weight_query->result();
                    $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                    $product_image_result = $product_image_query->result();
                    $new_array_product_weight = array();
                    foreach ($product_weight_result as $pro_weight) {
                        if(!empty($isShow) && $isShow[0]->display_price_with_gst == '1'){
                                $pro_weight->discount_price = $pro_weight->without_gst_price;
                        }

                        $package_id = $pro_weight->package;
                        $variant_id = $pro_weight->id;
                        $package_name = $this->this_model->get_package($package_id);
                       
                        $weight_id = $pro_weight->weight_id;
                        $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                        $weight_result = $weight_query->row_array();
                        $weight_name = $weight_result['name'];
                        if (isset($_POST['user_id'])) {
                            $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_weight_id = '$variant_id' AND user_id = '$user_id'");
                            $my_cart_result = $my_cart_query->row_array();
                        } elseif (isset($_POST['device_id']) && (!isset($_POST['user_id']) || $_POST['user_id'] == '')) {
                            $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_weight_id = '$variant_id' AND  device_id = '$device_id'");
                            $my_cart_result = $my_cart_query->row_array();
                        } else {
                            $my_cart_result = array();
                        }
                        if (empty($my_cart_result)) {
                            $my_cart_quantity = '0';
                        } else {
                            $my_cart_quantity = $my_cart_result['quantity'];
                        }
                        $data = array('id' => $pro_weight->id, 'product_id' => $pro_weight->product_id, 'weight_id' => $pro_weight->weight_id, 'unit' => floor($pro_weight->weight_no) . ' ' . $weight_name, 'actual_price' => $pro_weight->price, 'quantity' => $pro_weight->quantity, 'package_name' => $package_name, 'discount_per' => $pro_weight->discount_per, 'discount_price' => $pro_weight->discount_price, 'my_cart_quantity' => $my_cart_quantity);
                        array_push($new_array_product_weight, $data);
                    }
                    $product_weight_array = $new_array_product_weight;
                    $new_array_product_image = array();
                    $proimg = $product_image_result[0]->image;
                    $prothimg = $product_image_result[0]->image;
                    foreach ($product_image_result as $pro_image) {
                        $data = array('id' => $pro_image->id, 'product_id' => $pro_image->product_id, 'image' => base_url() . 'public/images/'.$this->folder.'product_image/' . $pro_image->image, 'thumb_image' => base_url() . 'public/images/'.$this->folder.'product_image_thumb/' . $pro_image->image,);
                        array_push($new_array_product_image, $data);
                    }
                    $product_image_array = $new_array_product_image;
                    $data = array();
                    $data['id'] = $row->id;
                    $data['category_id'] = $row->category_id;
                    $data['brand_id'] = $row->brand_id;
                    $data['name'] = $row->name;
                    $data['image'] = base_url() . 'public/images/'.$this->folder.'product_image/' . $proimg;
                    $data['image_thumb'] = base_url() . 'public/images/'.$this->folder.'product_image_thumb/' . $prothimg;
                    $data['about'] = $row->about;
                    $data['content'] = $row->content;
                    $data['status'] = $row->status;
                    $data['dt_added'] = $row->dt_added;
                    $data['dt_updated'] = $row->dt_updated;
                    $data['product_weight'] = $product_weight_array;
                    $data['product_image'] = $product_image_array;
                    array_push($response["data"], $data);
                 
                    $counter++;
                }
                echo $output = json_encode(array('responsedata' => $response));
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "No record found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    public function user_address_delete() {
        if (isset($_POST['id'])) {
            $id = $this->input->post('id');

            $this->db->select('*');
            $this->db->from('user_address');
            $this->db->where('id',$id);
            $result = $this->db->get()->result();
            if($result[0]->status == '1'){
                $this->db->where('id', $id);
                $this->db->delete('user_address');
                    if(isset($_POST['user_id'])){
                        $this->db->select('*');
                        $this->db->from('user_address');
                        $this->db->where('user_id',$_POST['user_id']);
                        $result = $this->db->get()->result();
                        $address_id = $result[0]->id;

                        $data = array(
                            'status' => '1','dt_updated'=>strtotime(DATE_TIME)
                        );
                        $this->db->where('id', $address_id);
                        $this->db->update('user_address', $data);
                    }
            }else{
                $this->db->where('id', $id);
                $this->db->delete('user_address');                
            }

            $response = array();
            $response["success"] = 1;
            $response["message"] = "Address has been deleted.";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "ID is require";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    public function notification_list() {
        if (isset($_POST['user_id']) && $_POST['user_id'] != '') {
            $getData = $this->this_model->notification_list($_POST);
            if (count($getData) > 0) {
                $response = array();
                $response["success"] = 1;
                $response["message"] = "Notification list";
                $response["data"] = $getData;
                $output = json_encode(array('responsedata' => $response));
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "No notification found";
                $output = json_encode(array('responsedata' => $response));
            }
            echo $output;
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "user_id is require";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    public function feedback_add() {
        $post = $this->input->post();
        $req = array('vendor_id','user_id','islike');
        $response = $this->checkRequiredField($post, $req);
      if (isset($_POST['user_id']) && $_POST['user_id'] != '' && isset($_POST['islike']) && $_POST['islike'] != '') {
            $this->this_model->insertUsersFeedback($this->input->post());
        }
        $response = array();
        $response["success"] = 0;
        $response["message"] = "user_id and isLike is require";
        $output = json_encode(array('responsedata' => $response));
        echo $output;
    }
    
    public function make_payment_new() {
        $this->this_model->make_payment_new($this->input->post());
    }
    
    /* testing purpose paytm integration */
    public function paytm_payment_new() {
        $this->this_model->paytm_payment();
    }
    public function paytm_payment_checksum_only() {
        $this->this_model->paytm_payment_checksum_only();
    }
    public function paytmStatus($orderId) {
        $data['statusMessage'] = $this->this_model->paytmStatus($orderId);
        $this->load->view('paytm_payment_status', $data);
    }
    /* testing purpose paytm integration */
    function sendmailtest() {
        $data['to'] = 'sahid.cmexpertise@gmail.com';
        $data['message'] = 'Test';
        $this->sendMailSMTP($data);
    }
    public function sendMailSMTP($data) {
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "162.241.86.206";
        $config['smtp_port'] = '587';
        $config['smtp_user'] = "test@launchestore.com";
        $config['smtp_pass'] = "HhZ~sU(@drk_";
        $config['smtp_timeout'] = 20;
        $config['priority'] = 1;
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['mailtype'] = "html";
        $CI = & get_instance();
        $message = $data["message"];
        $CI->load->library('email', $config);
        $CI->email->initialize($config);
        $CI->email->clear();
        $CI->email->from($config['smtp_user'], $this->siteTitle);
        $CI->email->to($data["to"]);
        if (isset($data["bcc"])) {
            $CI->email->bcc($data["bcc"]);
        }
        $CI->email->reply_to($config['smtp_user'], '<noreply@stagegator.com>');
        $CI->email->subject($data["subject"]);
        $CI->email->message($message);
        $response = $CI->email->send();
        return true;
    }

    public function setVerifyEmailmessage($message) {
        $CI = & get_instance();
        $template = '<h1>Thank you<br> <span>You have successfully verified your email</span></h1>';
        $CI->session->set_flashdata("myMessage", $template);
    }

    public function contactus() {
        $post = $this->input->post();
        $req = array('name', 'email', 'mobile', 'message','vendor_id');
        $response = $this->checkRequiredField($post, $req);
        if ($response['status'] == 1) {
            $this->this_model->contactus($post);
        }
    }
    
    public function about_us() {
        $result = $this->this_model->get_about_app();
        if ($result) {
            $response = array();
            $response["success"] = 1;
            $response["message"] = "About us";
            $response["data"] = $result[0];
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "No Data Found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
        
    }

    /*Developer : Shahid abdul rahman*/

    public function get_offer(){

       $result = $this->this_model->get_offer();
        if ($result) {
            $response = array();
            $response["success"] = 1;
            $response["message"] = "Offer Data";
            $response["data"] = $result;
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "No Data Found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

 // Pratik S Shah
    public function sendOtpLogin(){
        $post = $this->input->post();
        $req = array('country_code','phone','vendor_id');
        $response = $this->checkRequiredField($post, $req);
        if ($response['status'] == 1) {
            $post = $this->input->post();
            $response = $this->this_model->sendOtpLogin($post);
            // $response = array('responsedata' => $response);
        }
       $this->response($response);
    }
    
    public function VarifyOtpLogin(){
        $post = $this->input->post();
        $req = array('country_code','phone','otp','vendor_id','device_id','login_type','device_token','device_type');
        $response = $this->checkRequiredField($post, $req);
        if ($response['status'] == 1) {
            $post = $this->input->post();
            $response = $this->this_model->VarifyOtpLogin($post);
            $response = array('responsedata' => $response);
        }
       $this->response($response);
    }

    public function completeProfile(){
        $post = $this->input->post();
        $req = array('fname','lname','user_id','vendor_id');
        $response = $this->checkRequiredField($post, $req);
        if ($response['status'] == 1) {
            $post = $this->input->post();
            $response = $this->this_model->completeProfile($post);
            $response = array('responsedata' => $response);
        }
       $this->response($response);
    }

    public function validate_promocode(){
        $post = $this->input->post();
        $req = array('user_id','promocode','branch_id');
        $response = $this->checkRequiredField($post, $req);
        if ($response['status'] == 1) {
            $post = $this->input->post();
            $response = $this->this_model->validate_promocode($post);
            $response = array('responsedata' => $response);
        }
       $this->response($response);
    }


    public function delete_user(){
        $post = $this->input->post();
        $req = array('user_id','vendor_id');
        $response = $this->checkRequiredField($post, $req);
        if ($response['status'] == 1) {
            $post = $this->input->post();
            $response = $this->this_model->delete_user($post);
            $response = array('responsedata' => $response);
        }
       $this->response($response);
    }

    public function get_offer_varient_listing(){
            $post = $this->input->post();
            $req = array('offer_id');
            $response = $this->checkRequiredField($post, $req);
        if ($response['status'] == 1) {
            $post = $this->input->post();
            $response = $this->this_model->get_offer_varient_listing($post);
            $response = array('responsedata' => $response);
        }
       $this->response($response);
    }



}

?>
