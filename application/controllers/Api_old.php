<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

class Api extends CI_Controller
{
    ## City List ##
    public function city_list()
    {
        $limit = '5';
        $offset= $_REQUEST['offset'];

        $result_count = $this->db->query("SELECT COUNT(*) as total FROM city WHERE status != '9'");
        $row_count = $result_count->result();

        $total_count = $row_count[0]->total;
        $cal = $limit  * $offset;

        $query = $this->db->query("SELECT * FROM city WHERE status != '9' ORDER BY id DESC LIMIT $limit OFFSET $cal");
        $result = $query->result();

        if($query -> num_rows > 0){

            $response['success'] = "1";
            $response['message'] = "City list";
            $response["count"] = $total_count;
            $response["data"] = array();
            $counter = 0;

            foreach($result as $row)
            {
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
        }else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## User Register ##
    public  function user_register(){

        if(isset($_REQUEST['fname']) && isset($_REQUEST['login_type'])){

            $fname = $_REQUEST['fname'];
            $lname = $_REQUEST['lname'];
            $email = $_REQUEST['email'];
            $phone = $_REQUEST['phone'];
            $login_type = $_REQUEST['login_type'];
            $password = $_REQUEST['password'];
            $facebook_token_id = $_REQUEST['facebook_token_id'];
            $gmail_token_id = $_REQUEST['gmail_token_id'];

            /* Normal */
            if($login_type == '0'){
                if(isset($_REQUEST['email']) && isset($_REQUEST['phone']) && isset($_REQUEST['lname']) ){
                    $email_query = $this->db->query("SELECT * FROM user WHERE email = '$email'");
                    $email_result = $email_query->row_array();

                    if ($email_query->num_rows > 0) {

                        $response ["success"] = 0;
                        $response ["message"] = "Email is already registered";
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                        exit();
                    } else {

                        $data = array(
                            'fname' => $fname,
                            'lname' => $lname,
                            'email' => $email,
                            'password' => md5($password),
                            'login_type' => $login_type,
                            'phone' => $phone,
                            'status' => '1',
                            'dt_added' => strtotime(date('Y-m-d H:i:s')),
                            'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                        );
                        $this->db->insert('user', $data);

                        $response ["success"] = 1;
                        $response ["message"] = "User registration successful";
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                        exit();
                    }
                }else{
                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "Invalid data";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
                
            }
            /* Facebook */
            elseif($login_type == '1'){

//                $email_query = $this->db->query("SELECT facebook_token_id FROM user WHERE facebook_token_id = '$facebook_token_id'");
//                $email_result = $email_query->row_array();
//
//                if($email_result['facebook_token_id'] != ''){
//
//                    $response ["success"] = 0;
//                    $response ["message"] = "Already registered";
//                    $output = json_encode(array('responsedata' => $response));
//                    echo $output;
//                }else{

                    $facebook_query = $this->db->query("SELECT * FROM user WHERE facebook_token_id = '$facebook_token_id'");

                    if($facebook_query-> num_rows > 0){
                        $facebook_query = $facebook_query->result()[0];
                        
                        $response = array();
                        $response ["success"] = 1;
                        $response ["message"] = "User Login Successfully";
                        $data = array(
                            'id' => $facebook_query->id,
                            'fname' => $facebook_query->fname,
                            'lname' => $facebook_query->lname,
                            'email' => $facebook_query->email,
                            'phone' => $facebook_query->phone,
                            'login_type' => $facebook_query->login_type
                        );
                        $response ["user_data"] = $data;
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;

                    }else{

                        $data = array(
                            'fname' => $fname,
                            'lname' => $lname,
                            'email' => $email,
                            'phone' => $phone,
                            'login_type' => $login_type,
                            'facebook_token_id' => $facebook_token_id,
                            'status' => '1',
                            'dt_added' => strtotime(date('Y-m-d H:i:s')),
                            'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                        );
                        
                        $this->db->insert('user', $data);
                        $lastId = $this->db->insert_id();
                        
                        $data1 = array(
                            'id' => $lastId,
                            'fname' => $fname,
                            'lname' => $lname,
                            'email' => $email,
                            'phone' => $phone,
                            'login_type' => $login_type
                        );
                        
                        $response ["success"] = 1;
                        $response ["message"] = "User registration successful";
                        $response ["user_data"] = $data1;
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                    }
//                }
            }
            /* Gmail */
            else{

//                $email_query = $this->db->query("SELECT gmail_token_id FROM user WHERE email = '$email'");
//                $email_result = $email_query->row_array();
//
//                if($email_result['gmail_token_id'] != ''){
//
//                    $response ["success"] = 0;
//                    $response ["message"] = "Already registered";
//                    $output = json_encode(array('responsedata' => $response));
//                    echo $output;
//                    exit();
//                }else{

                    $gmail_query = $this->db->query("SELECT * FROM user WHERE gmail_token_id = '$gmail_token_id'");

                    if($gmail_query-> num_rows > 0){
                        $gmail_query = $gmail_query->result()[0];
                        $data = array(
                            'id' => $gmail_query->id,
                            'fname' => $gmail_query->fname,
                            'lname' => $gmail_query->lname,
                            'email' => $gmail_query->email,
                            'phone' => $gmail_query->phone,
                            'login_type' => $gmail_query->login_type
                        );
                        
                        $response = array();
                        $response ["success"] = 1;
                        $response ["message"] = "User Login Successfully";
                        $response ["user_data"] = $data;
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;

                    }else{

                        $data = array(
                            'fname' => $fname,
                            'lname' => $lname,
                            'email' => $email,
                            'phone' => $phone,
                            'login_type' => $login_type,
                            'gmail_token_id' => $gmail_token_id,
                            'status' => '1',
                            'dt_added' => strtotime(date('Y-m-d H:i:s')),
                            'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                        );
                       $this->db->insert('user', $data);
                       $lastId = $this->db->insert_id();
                       $data1 = array(
                            'id' => $lastId,
                            'fname' => $fname,
                            'lname' => $lname,
                            'email' => $email,
                            'phone' => $phone,
                            'login_type' => $login_type
                        );

                        $response ["success"] = 1;
                        $response ["message"] = "User registration successful";
                        $response ["user_data"] = $data1;
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                    }
//                }
            }
            
        }else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## User Login ##
    public  function user_login(){

        if(isset($_REQUEST['login_type'])){

            $email = $_REQUEST['email'];
            $password = md5($_REQUEST['password']);
            $login_type = $_REQUEST['login_type'];
            $facebook_token_id = $_REQUEST['facebook_token_id'];
            $gmail_token_id = $_REQUEST['gmail_token_id'];

            /* Normal User */
            if($login_type == '0'){

                $login_check_query = $this->db->query("SELECT * FROM user WHERE email = '$email' AND password = '$password' AND login_type = '0' ");
                $login_check_result = $login_check_query->row_array();

                if($login_check_query -> num_rows > 0){

                    $data = array(
                        'id' => $login_check_result['id'],
                        'fname' => $login_check_result['fname'],
                        'lname' => $login_check_result['lname'],
                        'email' => $login_check_result['email'],
                        'phone' => $login_check_result['phone'],
                        'login_type' => $login_check_result['login_type']
                    );

                    $response = array();
                    $response ["success"] = 1;
                    $response ["message"] = "Login Successfully";
                    $response ["user_data"] = $data;

                    $output = json_encode(array('responsedata' => $response));
                    echo $output;

                }else{

                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "Invalid email or password";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }
            /* Facebook */
            elseif($login_type == '1'){

                $stream_options = array('http' => array('method'  => 'GET'));
                $context  = stream_context_create($stream_options);

                $token_id = $_REQUEST['facebook_token_id'];
                $access_token = '917047018437389|d26f7aa135cadffaf26dd30282a7236d';

                $url = 'https://graph.facebook.com/debug_token?input_token='.$token_id.'&access_token='.$access_token;

                $response = file_get_contents($url, null, $context);

                $facebook_json = json_decode($response);
                $app_id = $facebook_json->data->user_id;

                $facebook_query = $this->db->query("SELECT * FROM user WHERE facebook_token_id = '$app_id' AND login_type = '1' ");
                $facebook_result = $facebook_query->row_array();

                if($facebook_result['login_type'] == $login_type){
                    if($facebook_result['facebook_token_id'] == $app_id){

                        $data = array(
                            'id' => $facebook_result['id'],
                            'fname' => $facebook_result['fname'],
                            'lname' => $facebook_result['lname'],
                            'email' => $facebook_result['email'],
                            'phone' => $facebook_result['phone'],
                            'login_type' => $facebook_result['login_type']
                        );

                        $response = array();
                        $response ["success"] = 1;
                        $response ["message"] = "Login Successfully";
                        $response ["user_data"] = $data;

                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                    }else{

                        $response = array();
                        $response ["success"] = 101;
                        $response ["message"] = "Facebook login failed";
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                    }
                }else{

                    $response = array();
                    $response ["success"] = 101;
                    $response ["message"] = "Facebook login failed";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }
            /* Gmail */
            else{

                $stream_options = array( 'http' => array( 'method'  => 'GET',),);
                $context  = stream_context_create($stream_options);

                $token_id = $_REQUEST['gmail_token_id'];
                $url = 'https://www.googleapis.com/plus/v1/people/me?access_token='.$token_id;

                $response = file_get_contents($url, null, $context);
                $facebook_json = json_decode($response);
                $app_id = $facebook_json->id;

                $gmail_query = $this->db->query("SELECT * FROM user WHERE gmail_token_id = '$app_id' AND login_type = '2'");
                $gmail_result = $gmail_query->row_array();

                if($gmail_result['login_type'] == '2'){

                    if($gmail_result['gmail_token_id'] == $app_id){

                        $data = array(
                            'id' => $gmail_result['id'],
                            'fname' => $gmail_result['fname'],
                            'lname' => $gmail_result['lname'],
                            'email' => $gmail_result['email'],
                            'phone' => $gmail_result['phone'],
                            'login_type' => $gmail_result['login_type']
                        );

                        $response = array();
                        $response ["success"] = 1;
                        $response ["message"] = "Login Successfully";
                        $response ["user_data"] = $data;

                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                    }else{

                        $response = array();
                        $response ["success"] = 100;
                        $response ["message"] = "Google+ login failed";
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                    }
                }else{

                    $response = array();
                    $response ["success"] = 100;
                    $response ["message"] = "Google+ login failed";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }
        }else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Please enter valid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Forgot Password ##
    public function user_forgot_password(){

        if(isset($_REQUEST['email'])) {

            $email = $_REQUEST['email'];

            $query = $this->db->query("SELECT COUNT(*) as total FROM user WHERE email = '$email' AND login_type = '0'");
            $result = $query->row_array();

            if($result['total'] > 0){

                $this->load->helper('string');
                $ran_digit = random_string('alnum',5);
                $ran_digit_md5 = md5($ran_digit);

                $where = array('email' => $email);
                $data = array(
                    'password' => $ran_digit_md5,
                    'dt_updated' => strtotime(date('Y-m-d H:i:s'))
                );
                $this->db->where($where);
                $this->db->update('user', $data);

                $this->load->library('email');
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.gmail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'neel.cmexpertise@gmail.com',
                    'smtp_pass' => 'neel@1255',
                    'mailtype'  => 'text',
                    'charset'   => 'utf-8'
                );
                //Mail Send
                $from_email = 'neel.cmexpertise@gmail.com';
                $subject = 'Forgot Password';

                $message = 'Your New Password is : '.$ran_digit;

                $this->email->initialize($config);
                $this->email->set_newline("\r\n");

                $this->email->from($from_email);
                $this->email->to($email);
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->send();

                $response = array();
                $response ["success"] = 1;
                $response ["message"] = "New password has been sent on your email id";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }else{

                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "Email is not registered with us";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }
        else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Change Password ##
    public  function user_change_password(){

        if (isset($_REQUEST['email']) && isset($_REQUEST['old_password']) && isset($_REQUEST['new_password'])) {

            $email = $_REQUEST['email'];
            $old_password = md5($_REQUEST['old_password']);
            $new_password = md5($_REQUEST['new_password']);

            $result_login = $this->db->query("select * from user where email='$email' AND login_type = '0'");
            $row_login = $result_login->row_array();

            if($result_login ->num_rows > 0)
            {

                if($old_password == $row_login['password']){

                    $data_pass = array(
                        'password' => $new_password,
                        'dt_updated' => strtotime(date('Y-m-d H:i:s'))
                    );
                    $this->db->where('email', $email);
                    $this->db->update('user',$data_pass);

                    $data["success"] = 1;
                    $data["message"] = "Password has been updated successfully";
                    $output = json_encode(array('responsedata' => $data));
                    echo $output;


                }else{

                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "Please enter valid old password";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }else{

                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "Email is not registered with us.";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }
        else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Update Profile ##
    public  function profile_update(){

        if(isset($_REQUEST['fname']) && isset($_REQUEST['lname']) && isset($_REQUEST['email']) && isset($_REQUEST['phone'])){

            $fname = $_REQUEST['fname'];
            $lname = $_REQUEST['lname'];
            $email = $_REQUEST['email'];
            $phone = $_REQUEST['phone'];

            $data_user = array(
                'fname' => $fname,
                'lname' => $lname,
                'phone' => $phone,
                'dt_updated' => strtotime(date('Y-m-d H:i:s'))
            );
            $this->db->where('email', $email);
            $this->db->update('user', $data_user);

            $data["success"] = 1;
            $data["message"] = "User profile has been updated successfully";
            $output = json_encode(array('responsedata' => $data));
            echo $output;
        }else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## User Profile ##
    public  function user_details(){

        if(isset($_REQUEST['id'])){

            $user_id = $_REQUEST['id'];

            $query = $this->db->query("SELECT * FROM user WHERE id = '$user_id'");
            $result = $query->row_array();
            $user_id = $result['id'];

            $user_address_query = $this->db->query("SELECT * FROM user_address WHERE user_id = '$user_id' AND status != '9' ORDER BY id DESC");
            $user_address_result = $user_address_query->result();

            if($query -> num_rows > 0){
                foreach ($user_address_result as $address){
                    $data = array(
                        'id' => $address->id,
                        'address' => $address->address,
                        'user_id' => $address->user_id,
                        'latitude' => $address->latitude,
                        'longitude' => $address->longitude,
                        'name' => $address->name,
                        'pincode' => $address->pincode,
                        'landmark' => $address->landmark,
                        'city' => $address->city,
                        'state' => $address->state,
                        'country' => $address->country,
                        'phone' => $address->phone,
                    );
                    $address_arr[] = $data;
                }
                $address_array = $address_arr;

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
                );

                $response = array();
                $response ["success"] = 1;
                $response ["message"] = "User Details";
                $response ["user_data"] = $data_user;

                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }else{

                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "User not found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;

            }
        }else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Category List ##
    public function category_list()
    {
        $query = $this->db->query("SELECT * FROM category WHERE status != '9' ORDER BY id DESC");
        $result = $query->result();

        if($query -> num_rows > 0){

            $response['success'] = "1";
            $response['message'] = "Category list";
            $response["data"] = array();
            $counter = 0;

            foreach($result as $row)
            {
                $data = array();
                $data['id'] = $row->id;
                $data['name'] = $row->name;
                $data['image'] = base_url().'public/images/category/'.$row->image;
                $data['image_thumb'] = base_url().'public/images/category_thumb/'.$row->image;
                $data['status'] = $row->status;
                $data['dt_added'] = $row->dt_added;
                $data['dt_updated'] = $row->dt_updated;
                array_push($response["data"], $data);
                $counter++;
            }
            echo $output = json_encode(array('responsedata' => $response));
        }else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }
    
    ## Product List ##
    public function product_list()
    {
        if(isset($_REQUEST['category_id'])){

            $limit = '5';
            $offset= $_REQUEST['offset'];
            $category_id = $_REQUEST['category_id'];
            $user_id = $_REQUEST['user_id'];
            $device_id = $_REQUEST['device_id'];

            $result_count = $this->db->query("SELECT p.* FROM `product` as p 
                                                LEFT JOIN product_weight as w ON w.product_id = p.id
                                                WHERE p.status != '9' AND w.discount_price != '' AND w.status != '9' AND p.category_id = '$category_id' GROUP BY p.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2))");
            $row_count_ = $result_count->result();
            $total_count = count(array_keys($row_count_));

            $cal = $limit  * $offset;

            $query = $this->db->query("SELECT p.* FROM `product` as p 
                                        LEFT JOIN product_weight as w ON w.product_id = p.id
                                        WHERE p.status != '9' AND w.discount_price != '' AND w.status != '9' AND p.category_id = '$category_id' GROUP BY p.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2)) ASC LIMIT $limit OFFSET $cal");
            $result = $query->result();

            if($query -> num_rows > 0){

                $response['success'] = "1";
                $response['message'] = "Product list";
                $response["count"] = $total_count;
                $response["data"] = array();
                $counter = 0;

                foreach($result as $row)
                {

                    $product_id = $row->id;
                    $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                    $product_weight_result = $product_weight_query->result();

                    $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                    $product_image_result = $product_image_query->result();

                    $new_array_product_weight = array();
                    foreach ($product_weight_result as $pro_weight) {

                        $weight_id = $pro_weight->weight_id;
                        $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                        $weight_result = $weight_query->row_array();
                        $weight_name = $weight_result['name'];

                        if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                            $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                            $my_cart_result = $my_cart_query->row_array();

                        }elseif(isset($_REQUEST['device_id']) && $_REQUEST['user_id'] == ''){

                            $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                            $my_cart_result = $my_cart_query->row_array();

                        }
                        elseif(isset($_REQUEST['user_id']) && $_REQUEST['device_id'] == ''){

                            $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                            $my_cart_result = $my_cart_query->row_array();

                        }else{
                            $my_cart_result = array();
                        }

                        if(empty($my_cart_result)){
                            $my_cart_quantity = '0';
                        }else{
                            $my_cart_quantity = $my_cart_result['quantity'];
                        }

                        $data = array(
                            'id' => $pro_weight->id,
                            'product_id' => $pro_weight->product_id,
                            'weight_id' => $pro_weight->weight_id,
                            'unit' => floor($pro_weight->weight_no).' '.$weight_name,
                            'actual_price' => $pro_weight->price,
                            'quantity' => $pro_weight->quantity,
                            'discount_per' => $pro_weight->discount_per,
                            'discount_price' => $pro_weight->discount_price,
                            'my_cart_quantity' => $my_cart_quantity
                        );
                        array_push($new_array_product_weight,$data);
                    }
                    $product_weight_array = $new_array_product_weight;

                    $new_array_product_image = array();
                    foreach ($product_image_result as $pro_image) {
                        $data = array(
                            'id' => $pro_image->id,
                            'product_id' => $pro_image->product_id,
                            'image' => base_url().'public/images/product_image/'.$pro_image->image,
                            'thumb_image' => base_url().'public/images/product_image_thumb/'.$pro_image->image,
                        );
                        array_push($new_array_product_image,$data);
                    }
                    $product_image_array = $new_array_product_image;

                    $data = array();
                    $data['id'] = $row->id;
                    $data['category_id'] = $row->category_id;
                    $data['brand_id'] = $row->brand_id;
                    $data['name'] = $row->name;
                    $data['image'] = base_url().'public/images/product/'.$row->image;
                    $data['image_thumb'] = base_url().'public/images/product_thumb/'.$row->image;
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
            }else{

                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "No record found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }
        else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Check Device Token ##
    public function check_device_token()
    {
        if(isset($_REQUEST['device_id']) && isset($_REQUEST['device_type']) && isset($_REQUEST['device_token']) && isset($_REQUEST['device_os']) && isset($_REQUEST['device_key']))
        {
            $deviceid = $_REQUEST['device_id'];
            $device_type = $_REQUEST['device_type'];
            $device_token = $_REQUEST['device_token'];
            $device_os = $_REQUEST['device_os'];
            $device_key = $_REQUEST['device_key'];

            $insert_push_data = array(
                'device_id' => $deviceid,
                'device_type' => $device_type,
                'device_token' => $device_token,
                'device_os' => $device_os,
                'device_key' => $device_key,
            );
            $check_userid_exists  = $this->db->query("select * from device_token_check where device_os='$device_os' and device_id='$deviceid'");
            if($check_userid_exists -> num_rows > 0)
            {
                $check_exist = $this->db->query("select * from device_token_check where device_id='$deviceid' and device_token='$device_token'");
                $row_check_exist = $check_exist->result();
                $db_device_token = $row_check_exist['0']->device_token;
                if($db_device_token == $device_token)
                {
                    $response = array();
                    $response ["success"] = 1;
                    $response ["message"] = "Device Token Already exists...!";
                    $output2 = json_encode(array('responsedata' => $response));
                    echo $output2;
                }
                else
                {
                    //update device token
                    $data_array = array('device_os' => $device_os, 'device_id' => $deviceid);
                    $this->db->where($data_array);
                    $update_data = $this->db->update('device_token_check',$insert_push_data);

                    if($update_data)
                    {
                        $response = array();
                        $response ["success"] = 1;
                        $response ["message"] = "Device Token Successfully Updated...!";
                        $output2 = json_encode(array('responsedata' => $response));
                        echo $output2;
                    }
                    else
                    {
                        $response = array();
                        $response ["success"] = 0;
                        $response ["message"] = "Error in device TOken...!";
                        $output2 = json_encode(array('responsedata' => $response));
                        echo $output2;
                    }
                }
            }
            else
            {
                $insert_data = $this->db->insert('device_token_check',$insert_push_data);
                if($insert_data)
                {
                    $response = array();
                    $response ["success"] = 1;
                    $response ["message"] = "Device Token Successfully added...!";
                    $output2 = json_encode(array('responsedata' => $response));
                    echo $output2;
                }
                else
                {
                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "Error in device Tken...!";
                    $output2 = json_encode(array('responsedata' => $response));
                    echo $output2;
                }
            }
        }
        else
        {
            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Error...!";
            $output2 = json_encode(array('responsedata' => $response));
            echo $output2;
        }
    }

    ## Price List ##
    public function price_list()
    {
        $limit = '5';
        $offset= $_REQUEST['offset'];

        $result_count = $this->db->query("SELECT COUNT(*) as total FROM price WHERE status != '9'");
        $row_count = $result_count->result();

        $total_count = $row_count[0]->total;
        $cal = $limit  * $offset;

        $query = $this->db->query("SELECT * FROM price WHERE status != '9' ORDER BY id DESC LIMIT $limit OFFSET $cal");
        $result = $query->result();

        if($query -> num_rows > 0){

            $response['success'] = "1";
            $response['message'] = "Price list";
            $response["count"] = $total_count;
            $response["data"] = array();
            $counter = 0;

            foreach($result as $row)
            {
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
        }else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Discount List ##
    public function discount_list()
    {
        $limit = '5';
        $offset= $_REQUEST['offset'];

        $result_count = $this->db->query("SELECT COUNT(*) as total FROM discount WHERE status != '9'");
        $row_count = $result_count->result();

        $total_count = $row_count[0]->total;
        $cal = $limit  * $offset;

        $query = $this->db->query("SELECT * FROM discount WHERE status != '9' ORDER BY id DESC LIMIT $limit OFFSET $cal");
        $result = $query->result();

        if($query -> num_rows > 0){

            $response['success'] = "1";
            $response['message'] = "Discount list";
            $response["count"] = $total_count;
            $response["data"] = array();
            $counter = 0;

            foreach($result as $row)
            {
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
        }else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Weight List ##
    public function weight_list()
    {
        $limit = '5';
        $offset= $_REQUEST['offset'];

        $result_count = $this->db->query("SELECT COUNT(*) as total FROM weight WHERE status != '9'");
        $row_count = $result_count->result();

        $total_count = $row_count[0]->total;
        $cal = $limit  * $offset;

        $query = $this->db->query("SELECT * FROM weight WHERE status != '9' ORDER BY id DESC LIMIT $limit OFFSET $cal");
        $result = $query->result();

        if($query -> num_rows > 0){

            $response['success'] = "1";
            $response['message'] = "Weight list";
            $response["count"] = $total_count;
            $response["data"] = array();
            $counter = 0;

            foreach($result as $row)
            {
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
        }else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Time Slot List ##
    public function time_slot_list()
    {
        $limit = '5';
        $offset= $_REQUEST['offset'];

        $result_count = $this->db->query("SELECT COUNT(*) as total FROM time_slot WHERE status != '9'");
        $row_count = $result_count->result();

        $total_count = $row_count[0]->total;
        $cal = $limit  * $offset;

        $query = $this->db->query("SELECT * FROM time_slot WHERE status != '9' ORDER BY id DESC LIMIT $limit OFFSET $cal");
        $result = $query->result();

        if($query -> num_rows > 0){

            $response['success'] = "1";
            $response['message'] = "Time slot list";
            $response["count"] = $total_count;
            $response["data"] = array();
            $counter = 0;

            foreach($result as $row)
            {
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
        }else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Banner Promotion List ##
    public function banner_promotion_list()
    {
        $query = $this->db->query("SELECT * FROM banner_promotion WHERE status != '9' ORDER BY id DESC");
        $result = $query->result();

        if($query -> num_rows > 0){

            $response['success'] = "1";
            $response['message'] = "Banner promotion list";
            $response["data"] = array();
            $counter = 0;

            foreach($result as $row)
            {
                $data = array();
                $data['id'] = $row->id;
                $data['image'] = base_url().'public/images/banner_promotion/'.$row->image;
                $data['image_thumb'] = base_url().'public/images/banner_promotion_thumb/'.$row->image;
                $data['status'] = $row->status;
                $data['dt_added'] = $row->dt_added;
                $data['dt_updated'] = $row->dt_updated;
                array_push($response["data"], $data);
                $counter++;
            }
            echo $output = json_encode(array('responsedata' => $response));
        }else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Brand List ##
    public function brand_list()
    {
        if(isset($_REQUEST['category_id'])){

            $limit = '5';
            $offset= $_REQUEST['offset'];
            $category_id = $_REQUEST['category_id'];

            $result_count = $this->db->query("SELECT COUNT(*) as total FROM brand WHERE status != '9' AND category_id = '$category_id'");
            $row_count = $result_count->result();

            $total_count = $row_count[0]->total;
            $cal = $limit  * $offset;

            $query = $this->db->query("SELECT * FROM brand WHERE status != '9' AND category_id = '$category_id' ORDER BY id DESC LIMIT $limit OFFSET $cal");
            $result = $query->result();

            if($query -> num_rows > 0){

                $response['success'] = "1";
                $response['message'] = "Brand list";
                $response["count"] = $total_count;
                $response["data"] = array();
                $counter = 0;

                foreach($result as $row)
                {
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
            }else{

                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "No record found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }
        else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Add To Cart  - Single Product ##
    public function add_to_cart_old(){

        if(isset($_REQUEST['product_id']) && isset($_REQUEST['weight_id']) && isset($_REQUEST['quantity'])){

            $device_id = $_REQUEST['device_id'];
            $user_id = $_REQUEST['user_id'];
            $product_id = $_REQUEST['product_id'];
            $weight_id = $_REQUEST['weight_id'];
            $quantity = $_REQUEST['quantity'];

            if($device_id && $device_id != ''){

                $pro_available_query = $this->db->query("SELECT * FROM my_cart WHERE device_id = '$device_id' AND product_id = '$product_id' AND weight_id = '$weight_id'");

                $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND status != '9'");
                $product_weight_result = $product_weight_query->row_array();
                $actual_price = $product_weight_result['price'];
                $actual_quantity = $product_weight_result['quantity'];
                $discount_per = $product_weight_result['discount_per'];
                $discount_price = $product_weight_result['discount_price'];

                $calculation_price_ = $quantity * $discount_price;
                $calculation_price = number_format((float)$calculation_price_, 2, '.', '');

                if($pro_available_query -> num_rows > 0){

                    $where_cart = array('product_id' => $product_id, 'weight_id' => $weight_id, 'device_id' => $device_id);

                    $data = array(
                        'device_id' => $device_id,
                        'product_id' => $product_id,
                        'weight_id' => $weight_id,
                        'quantity' => $quantity,
                        'calculation_price' => $calculation_price,
                        'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                    );
                    $this->db->where($where_cart);
                    $this->db->update('my_cart', $data);

                    $response = array();
                    $response ["success"] = 1;
                    $response ["message"] = "Product has been updated in your cart";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
                else{

                    $data = array(
                        'device_id' => $device_id,
                        'product_id' => $product_id,
                        'weight_id' => $weight_id,
                        'quantity' => $quantity,
                        'actual_price' => $actual_price,
                        'actual_quantity' => $actual_quantity,
                        'discount_per' => $discount_per,
                        'discount_price' => $discount_price,
                        'calculation_price' => $calculation_price,
                        'status' => '1',
                        'dt_added' => strtotime(date('Y-m-d H:i:s')),
                        'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                    );
                    $this->db->insert('my_cart', $data);

                    $response = array();
                    $response ["success"] = 1;
                    $response ["message"] = "Product has been added to your cart";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }
            elseif ($user_id && $user_id != ''){

                $pro_available_query = $this->db->query("SELECT * FROM my_cart WHERE user_id = '$user_id' AND product_id = '$product_id' AND weight_id = '$weight_id'");

                $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND status != '9'");
                $product_weight_result = $product_weight_query->row_array();
                $actual_price = $product_weight_result['price'];
                $actual_quantity = $product_weight_result['quantity'];
                $discount_per = $product_weight_result['discount_per'];
                $discount_price = $product_weight_result['discount_price'];

                $calculation_price_ = $quantity * $discount_price;
                $calculation_price = number_format((float)$calculation_price_, 2, '.', '');

                if($pro_available_query -> num_rows > 0){

                    $where_cart = array('product_id' => $product_id, 'weight_id' => $weight_id, 'user_id' => $user_id);

                    $data = array(
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'weight_id' => $weight_id,
                        'quantity' => $quantity,
                        'calculation_price' => $calculation_price,
                        'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                    );
                    $this->db->where($where_cart);
                    $this->db->update('my_cart', $data);

                    $response = array();
                    $response ["success"] = 1;
                    $response ["message"] = "Product has been updated in your cart";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
                else{

                    $data = array(
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'weight_id' => $weight_id,
                        'quantity' => $quantity,
                        'actual_price' => $actual_price,
                        'actual_quantity' => $actual_quantity,
                        'discount_per' => $discount_per,
                        'discount_price' => $discount_price,
                        'calculation_price' => $calculation_price,
                        'status' => '1',
                        'dt_added' => strtotime(date('Y-m-d H:i:s')),
                        'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                    );
                    $this->db->insert('my_cart', $data);

                    $response = array();
                    $response ["success"] = 1;
                    $response ["message"] = "Product has been added to your cart";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }
            else{

                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "Invalid data";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }
        else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Add To Cart  - Single Product ##
    public function add_to_cart(){

        if(isset($_REQUEST['product_id']) && isset($_REQUEST['weight_id']) && isset($_REQUEST['quantity'])){

            $device_id = $_REQUEST['device_id'];
            $user_id = $_REQUEST['user_id'];
            $product_id = $_REQUEST['product_id'];
            $weight_id = $_REQUEST['weight_id'];
            $quantity = $_REQUEST['quantity'];


            if(isset($user_id) && isset($device_id)){

                $pro_available_query = $this->db->query("SELECT * FROM my_cart WHERE (device_id = '$device_id' OR user_id = '$user_id') AND product_id = '$product_id' AND weight_id = '$weight_id'");

                $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND status != '9'");
                $product_weight_result = $product_weight_query->row_array();
                $actual_price = $product_weight_result['price'];
                $actual_quantity = $product_weight_result['quantity'];
                $discount_per = $product_weight_result['discount_per'];
                $discount_price = $product_weight_result['discount_price'];

                $calculation_price_ = $quantity * $discount_price;
                $calculation_price = number_format((float)$calculation_price_, 2, '.', '');

/*                $where_cart1 = array('product_id' => $product_id, 'weight_id' => $weight_id, 'device_id' => $device_id, 'user_id' => $user_id);
                $data1 = array(
                    'device_id' => $device_id,
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'weight_id' => $weight_id,
                    'quantity' => $quantity,
                    'calculation_price' => $calculation_price,
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $this->db->where($where_cart1);
                $this->db->update('my_cart', $data1);*/

                $dt_updated = strtotime(date('Y-m-d H:i:s'));
                $this->db->query("UPDATE my_cart SET device_id = '$device_id', user_id = '$user_id', product_id = '$product_id', weight_id = '$weight_id', quantity = '$quantity', calculation_price = '$calculation_price',  dt_updated = '$dt_updated' WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (device_id = '$device_id' OR user_id = '$user_id') ");

                $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE (mc.device_id= '$device_id' OR mc.user_id= '$user_id') AND mc.status != '9' ORDER BY mc.id DESC");
                $row_count = $result_count->result();
                $total_count = $row_count[0]->total;

                $my_cart_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND (device_id = '$device_id' OR user_id = '$user_id')");
                $my_cart_price_result = $my_cart_price_query->row_array();

                if($pro_available_query -> num_rows > 0){

                    $where_cart = array('product_id' => $product_id, 'weight_id' => $weight_id, 'device_id' => $device_id, 'user_id' => $user_id);

/*                    $data = array(
                        'device_id' => $device_id,
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'weight_id' => $weight_id,
                        'quantity' => $quantity,
                        'calculation_price' => $calculation_price,
                        'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                    );
                    $this->db->where($where_cart);
                    $this->db->update('my_cart', $data);*/

                    $this->db->query("UPDATE my_cart SET device_id = '$device_id', user_id = '$user_id', product_id = '$product_id', weight_id = '$weight_id', quantity = '$quantity', calculation_price = '$calculation_price',  dt_updated = '$dt_updated' WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (device_id = '$device_id' OR user_id = '$user_id') ");

                    $response = array();
                    $response ["success"] = 1;
                    $response ["message"] = "Product has been updated in your cart";
                    $response["count"] = $total_count;
                    $response["total_price"] = number_format((float)$my_cart_price_result['total_price'], 2, '.', '');;
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
                else{

                    $data = array(
                        'device_id' => $device_id,
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'weight_id' => $weight_id,
                        'quantity' => $quantity,
                        'actual_price' => $actual_price,
                        'actual_quantity' => $actual_quantity,
                        'discount_per' => $discount_per,
                        'discount_price' => $discount_price,
                        'calculation_price' => $calculation_price,
                        'status' => '1',
                        'dt_added' => strtotime(date('Y-m-d H:i:s')),
                        'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                    );
                    $this->db->insert('my_cart', $data);

                    $my_cart_price_query1 = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND (device_id = '$device_id' OR user_id = '$user_id')");
                    $my_cart_price_result1 = $my_cart_price_query1->row_array();

                    $result_count1 = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE (mc.device_id= '$device_id' OR mc.user_id= '$user_id') AND mc.status != '9' ORDER BY mc.id DESC");
                    $row_count1 = $result_count1->result();
                    $total_count1 = $row_count1[0]->total;

                    $response = array();
                    $response ["success"] = 1;
                    $response ["message"] = "Product has been added to your cart";
                    $response["count"] = $total_count1;
                    $response["total_price"] = number_format((float)$my_cart_price_result1['total_price'], 2, '.', '');;
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }

            elseif($device_id && $device_id != ''){

                $pro_available_query = $this->db->query("SELECT * FROM my_cart WHERE device_id = '$device_id' AND product_id = '$product_id' AND weight_id = '$weight_id'");

                $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND status != '9'");
                $product_weight_result = $product_weight_query->row_array();
                $actual_price = $product_weight_result['price'];
                $actual_quantity = $product_weight_result['quantity'];
                $discount_per = $product_weight_result['discount_per'];
                $discount_price = $product_weight_result['discount_price'];

                $calculation_price_ = $quantity * $discount_price;
                $calculation_price = number_format((float)$calculation_price_, 2, '.', '');

                $where_cart1 = array('product_id' => $product_id, 'weight_id' => $weight_id, 'device_id' => $device_id);
                $data1 = array(
                    'device_id' => $device_id,
                    'product_id' => $product_id,
                    'weight_id' => $weight_id,
                    'quantity' => $quantity,
                    'calculation_price' => $calculation_price,
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $this->db->where($where_cart1);
                $this->db->update('my_cart', $data1);

                $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE mc.device_id= '$device_id' AND mc.status != '9' ORDER BY mc.id DESC");
                $row_count = $result_count->result();
                $total_count = $row_count[0]->total;

                $my_cart_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND device_id = '$device_id'");
                $my_cart_price_result = $my_cart_price_query->row_array();

                if($pro_available_query -> num_rows > 0){

                    $where_cart = array('product_id' => $product_id, 'weight_id' => $weight_id, 'device_id' => $device_id);

                    $data = array(
                        'device_id' => $device_id,
                        'product_id' => $product_id,
                        'weight_id' => $weight_id,
                        'quantity' => $quantity,
                        'calculation_price' => $calculation_price,
                        'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                    );
                    $this->db->where($where_cart);
                    $this->db->update('my_cart', $data);

                    $response = array();
                    $response ["success"] = 1;
                    $response ["message"] = "Product has been updated in your cart";
                    $response["count"] = $total_count;
                    $response["total_price"] = number_format((float)$my_cart_price_result['total_price'], 2, '.', '');;
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
                else{

                    $data = array(
                        'device_id' => $device_id,
                        'product_id' => $product_id,
                        'weight_id' => $weight_id,
                        'quantity' => $quantity,
                        'actual_price' => $actual_price,
                        'actual_quantity' => $actual_quantity,
                        'discount_per' => $discount_per,
                        'discount_price' => $discount_price,
                        'calculation_price' => $calculation_price,
                        'status' => '1',
                        'dt_added' => strtotime(date('Y-m-d H:i:s')),
                        'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                    );
                    $this->db->insert('my_cart', $data);

                    $result_count1 = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE mc.device_id= '$device_id' AND mc.status != '9' ORDER BY mc.id DESC");
                    $row_count1 = $result_count1->result();
                    $total_count1 = $row_count1[0]->total;

                    $my_cart_price_query1 = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND device_id = '$device_id'");
                    $my_cart_price_result1 = $my_cart_price_query1->row_array();

                    $response = array();
                    $response ["success"] = 1;
                    $response ["message"] = "Product has been added to your cart";
                    $response["count"] = $total_count1;
                    $response["total_price"] = number_format((float)$my_cart_price_result1['total_price'], 2, '.', '');;
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }

            elseif ($user_id && $user_id != ''){

                $pro_available_query = $this->db->query("SELECT * FROM my_cart WHERE user_id = '$user_id' AND product_id = '$product_id' AND weight_id = '$weight_id'");

                $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND status != '9'");
                $product_weight_result = $product_weight_query->row_array();
                $actual_price = $product_weight_result['price'];
                $actual_quantity = $product_weight_result['quantity'];
                $discount_per = $product_weight_result['discount_per'];
                $discount_price = $product_weight_result['discount_price'];

                $calculation_price_ = $quantity * $discount_price;
                $calculation_price = number_format((float)$calculation_price_, 2, '.', '');

                $where_cart1 = array('product_id' => $product_id, 'weight_id' => $weight_id, 'user_id' => $user_id);
                $data1 = array(
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'weight_id' => $weight_id,
                    'quantity' => $quantity,
                    'calculation_price' => $calculation_price,
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $this->db->where($where_cart1);
                $this->db->update('my_cart', $data1);

                $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE mc.user_id= '$user_id' AND mc.status != '9' ORDER BY mc.id DESC");
                $row_count = $result_count->result();
                $total_count = $row_count[0]->total;

                $my_cart_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND user_id = '$user_id'");
                $my_cart_price_result = $my_cart_price_query->row_array();

                if($pro_available_query -> num_rows > 0){

                    $where_cart = array('product_id' => $product_id, 'weight_id' => $weight_id, 'user_id' => $user_id);

                    $data = array(
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'weight_id' => $weight_id,
                        'quantity' => $quantity,
                        'calculation_price' => $calculation_price,
                        'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                    );
                    $this->db->where($where_cart);
                    $this->db->update('my_cart', $data);

                    $response = array();
                    $response ["success"] = 1;
                    $response ["message"] = "Product has been updated in your cart";
                    $response["count"] = $total_count;
                    $response["total_price"] = number_format((float)$my_cart_price_result['total_price'], 2, '.', '');;
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
                else{

                    $data = array(
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'weight_id' => $weight_id,
                        'quantity' => $quantity,
                        'actual_price' => $actual_price,
                        'actual_quantity' => $actual_quantity,
                        'discount_per' => $discount_per,
                        'discount_price' => $discount_price,
                        'calculation_price' => $calculation_price,
                        'status' => '1',
                        'dt_added' => strtotime(date('Y-m-d H:i:s')),
                        'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                    );
                    $this->db->insert('my_cart', $data);

                    $result_count1 = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE mc.user_id= '$user_id' AND mc.status != '9' ORDER BY mc.id DESC");
                    $row_count1 = $result_count1->result();
                    $total_count1 = $row_count1[0]->total;

                    $my_cart_price_query1 = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND user_id = '$user_id'");
                    $my_cart_price_result1 = $my_cart_price_query1->row_array();

                    $response = array();
                    $response ["success"] = 1;
                    $response ["message"] = "Product has been added to your cart";
                    $response["count"] = $total_count1;
                    $response["total_price"] = number_format((float)$my_cart_price_result1['total_price'], 2, '.', '');;
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }

            else{

                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "Invalid data";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }
        else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## My Cart List ##
    public function my_cart(){

        $device_id = $_REQUEST['device_id'];
        $user_id = $_REQUEST['user_id'];

        if($device_id && $device_id != '' && $user_id && $user_id != ''){

            $limit = '5';
            $offset= $_REQUEST['offset'];

            $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE mc.status != '9' AND (mc.device_id = '$device_id' OR mc.user_id = '$user_id') ORDER BY mc.id DESC");
            $row_count = $result_count->result();

            $total_count = $row_count[0]->total;
            $cal = $limit  * $offset;

            $my_cart_query = $this->db->query("SELECT mc.*  FROM my_cart as mc WHERE mc.status != '9' AND (mc.device_id = '$device_id' OR mc.user_id = '$user_id') ORDER BY mc.id DESC LIMIT $limit OFFSET $cal");
            $my_cart_result = $my_cart_query->result();

            $my_cart_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND (device_id = '$device_id' OR user_id = '$user_id')");
            $my_cart_price_result = $my_cart_price_query->row_array();

            if($my_cart_query -> num_rows > 0){

                $response['success'] = "1";
                $response['message'] = "My cart item list";
                $response["count"] = $total_count;
                $response["total_price"] = number_format((float)$my_cart_price_result['total_price'], 2, '.', '');;
                $response["data"] = array();
                $counter = 0;

                foreach($my_cart_result as $row)
                {

                    $product_id = $row->product_id;
                    $weight_id = $row->weight_id;

                    $product_weight_query = $this->db->query("SELECT pw.*, p.name as product_name, p.image as product_image, w.name as product_weight_name FROM product_weight as pw 
                                                                LEFT JOIN product as p ON p.id = pw.product_id
                                                                LEFT JOIN weight as w ON w.id = pw.weight_id
                                                                WHERE pw.product_id = '$product_id' AND pw.weight_id = '$weight_id' AND pw.status != '9'");
                    $product_weight_result = $product_weight_query->row_array();

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
                    $data['product_unit'] = $product_unit.' '.$product_weight_name;
                    $data['product_name'] = $product_name;
                    $data['product_actual_price'] = $product_actual_price;
                    $data['product_discount_price'] = $product_discount_price;
                    $data['product_image'] = base_url().'public/images/product/'.$product_image;
                    $data['product_image_thumb'] = base_url().'public/images/product_thumb/'.$product_image;
                    $data['product_id'] = $row->product_id;
                    $data['weight_id'] = $row->weight_id;
                    $data['quantity'] = $row->quantity;
                    $data['status'] = $row->status;
                    $data['dt_added'] = $row->dt_added;
                    $data['dt_updated'] = $row->dt_updated;
                    array_push($response["data"], $data);
                    $counter++;
                }
                echo $output = json_encode(array('responsedata' => $response));
            }

            else{

                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "No record found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }

        elseif($device_id && $device_id != ''){

            $limit = '5';
            $offset= $_REQUEST['offset'];

            $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE mc.device_id = '$device_id' AND mc.status != '9' ORDER BY mc.id DESC");
            $row_count = $result_count->result();

            $total_count = $row_count[0]->total;
            $cal = $limit  * $offset;

            $my_cart_query = $this->db->query("SELECT mc.*  FROM my_cart as mc WHERE mc.device_id = '$device_id' AND mc.status != '9' ORDER BY mc.id DESC LIMIT $limit OFFSET $cal");
            $my_cart_result = $my_cart_query->result();

            $my_cart_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND device_id = '$device_id'");
            $my_cart_price_result = $my_cart_price_query->row_array();

            if($my_cart_query -> num_rows > 0){

                $response['success'] = "1";
                $response['message'] = "My cart item list";
                $response["count"] = $total_count;
                $response["total_price"] = number_format((float)$my_cart_price_result['total_price'], 2, '.', '');;
                $response["data"] = array();
                $counter = 0;

                foreach($my_cart_result as $row)
                {

                    $product_id = $row->product_id;
                    $weight_id = $row->weight_id;

                    $product_weight_query = $this->db->query("SELECT pw.*, p.name as product_name, p.image as product_image, w.name as product_weight_name FROM product_weight as pw 
                                                                LEFT JOIN product as p ON p.id = pw.product_id
                                                                LEFT JOIN weight as w ON w.id = pw.weight_id
                                                                WHERE pw.product_id = '$product_id' AND pw.weight_id = '$weight_id' AND pw.status != '9'");
                    $product_weight_result = $product_weight_query->row_array();

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
                    $data['product_unit'] = $product_unit.' '.$product_weight_name;
                    $data['product_name'] = $product_name;
                    $data['product_actual_price'] = $product_actual_price;
                    $data['product_discount_price'] = $product_discount_price;
                    $data['product_image'] = base_url().'public/images/product/'.$product_image;
                    $data['product_image_thumb'] = base_url().'public/images/product_thumb/'.$product_image;
                    $data['product_id'] = $row->product_id;
                    $data['weight_id'] = $row->weight_id;
                    $data['quantity'] = $row->quantity;
                    $data['status'] = $row->status;
                    $data['dt_added'] = $row->dt_added;
                    $data['dt_updated'] = $row->dt_updated;
                    array_push($response["data"], $data);
                    $counter++;
                }
                echo $output = json_encode(array('responsedata' => $response));
            }else{

                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "No record found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }

        elseif ($user_id && $user_id != ''){

            $limit = '5';
            $offset= $_REQUEST['offset'];

            $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE mc.user_id = '$user_id' AND mc.status != '9' ORDER BY mc.id DESC");
            $row_count = $result_count->result();

            $total_count = $row_count[0]->total;
            $cal = $limit  * $offset;

            $my_cart_query = $this->db->query("SELECT mc.*  FROM my_cart as mc WHERE mc.user_id = '$user_id' AND mc.status != '9' ORDER BY mc.id DESC LIMIT $limit OFFSET $cal");
            $my_cart_result = $my_cart_query->result();

            $my_cart_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND user_id = '$user_id'");
            $my_cart_price_result = $my_cart_price_query->row_array();

            if($my_cart_query -> num_rows > 0){

                $response['success'] = "1";
                $response['message'] = "My cart item list";
                $response["count"] = $total_count;
                $response["total_price"] = number_format((float)$my_cart_price_result['total_price'], 2, '.', '');;
                $response["data"] = array();
                $counter = 0;

                foreach($my_cart_result as $row)
                {

                    $product_id = $row->product_id;
                    $weight_id = $row->weight_id;

                    $product_weight_query = $this->db->query("SELECT pw.*, p.name as product_name, p.image as product_image, w.name as product_weight_name FROM product_weight as pw 
                                                                LEFT JOIN product as p ON p.id = pw.product_id
                                                                LEFT JOIN weight as w ON w.id = pw.weight_id
                                                                WHERE pw.product_id = '$product_id' AND pw.weight_id = '$weight_id' AND pw.status != '9'");
                    $product_weight_result = $product_weight_query->row_array();

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
                    $data['product_unit'] = $product_unit.' '.$product_weight_name;
                    $data['product_name'] = $product_name;
                    $data['product_actual_price'] = $product_actual_price;
                    $data['product_discount_price'] = $product_discount_price;
                    $data['product_image'] = base_url().'public/images/product/'.$product_image;
                    $data['product_image_thumb'] = base_url().'public/images/product_thumb/'.$product_image;
                    $data['product_id'] = $row->product_id;
                    $data['weight_id'] = $row->weight_id;
                    $data['quantity'] = $row->quantity;
                    $data['status'] = $row->status;
                    $data['dt_added'] = $row->dt_added;
                    $data['dt_updated'] = $row->dt_updated;
                    array_push($response["data"], $data);
                    $counter++;
                }
                echo $output = json_encode(array('responsedata' => $response));
            }else{

                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "No record found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }

        else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Delete My Cart Item ##
    public function delete_my_cart_item(){

        if(isset($_REQUEST['product_id']) && isset($_REQUEST['weight_id'])){

            $weight_id = $_REQUEST['weight_id'];
            $product_id = $_REQUEST['product_id'];
            $user_id = $_REQUEST['user_id'];
            $device_id = $_REQUEST['device_id'];

            if(isset($user_id) && isset($device_id)){

                $this->db->query("DELETE FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (device_id IN ('$device_id') OR user_id IN ('$user_id'))");

                $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE (mc.device_id IN ('$device_id') OR mc.user_id IN ('$user_id')) AND mc.status != '9' ORDER BY mc.id DESC");
                $row_count = $result_count->result();
                $total_count = $row_count[0]->total;

                $my_cart_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND (device_id IN ('$device_id') OR user_id IN ('$user_id'))");
                $my_cart_price_result = $my_cart_price_query->row_array();

                $response = array();
                $response ["success"] = 1;
                $response ["message"] = "Item has been deleted successfully from your cart";
                $response["count"] = $total_count;
                $response["total_price"] = number_format((float)$my_cart_price_result['total_price'], 2, '.', '');;
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
            elseif($device_id && $device_id != ''){

                /*$where = array( 'product_id' => $product_id, 'weight_id' => $weight_id, 'device_id' => $device_id );
                $this->db->where($where);
                $this->db->delete('my_cart');*/

                $this->db->query("DELETE FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (device_id IN ('$device_id') OR user_id IN ('$user_id'))");

                $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE (mc.device_id IN ('$device_id') OR mc.user_id IN ('$user_id')) AND mc.status != '9' ORDER BY mc.id DESC");
                $row_count = $result_count->result();
                $total_count = $row_count[0]->total;

                $my_cart_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND (device_id IN ('$device_id') OR user_id IN ('$user_id'))");
                $my_cart_price_result = $my_cart_price_query->row_array();

                $response = array();
                $response ["success"] = 1;
                $response ["message"] = "Item has been deleted successfully from your cart";
                $response["count"] = $total_count;
                $response["total_price"] = number_format((float)$my_cart_price_result['total_price'], 2, '.', '');;
                $output = json_encode(array('responsedata' => $response));
                echo $output;

            }elseif($user_id && $user_id != ''){

                /*$where = array( 'product_id' => $product_id, 'weight_id' => $weight_id, 'user_id' => $user_id );
                $this->db->where($where);
                $this->db->delete('my_cart');*/

                $this->db->query("DELETE FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (device_id IN ('$device_id') OR user_id IN ('$user_id'))");

                $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE mc.user_id = '$user_id' AND mc.status != '9' ORDER BY mc.id DESC");
                $row_count = $result_count->result();
                $total_count = $row_count[0]->total;

                $my_cart_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND user_id = '$user_id'");
                $my_cart_price_result = $my_cart_price_query->row_array();

                $response = array();
                $response ["success"] = 1;
                $response ["message"] = "Item has been deleted successfully from your cart";
                $response["count"] = $total_count;
                $response["total_price"] = number_format((float)$my_cart_price_result['total_price'], 2, '.', '');;
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }else{

                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "Invalid data";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Checkout ##
    public function checkout(){

        $user_id = $_REQUEST['user_id'];
        $device_id = $_REQUEST['device_id'];
        $user_address_id = $_REQUEST['user_address_id'];
        $payment_type = $_REQUEST['payment_type'];
        $time_slot_id = $_REQUEST['time_slot_id'];

        if(isset($_REQUEST['user_address_id']) && isset($_REQUEST['payment_type']) && isset($_REQUEST['time_slot_id'])){

            if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                $delivery_charge_query = $this->db->query("SELECT price FROM setting WHERE title = 'delivery_charge'");
                $delivery_charge_result = $delivery_charge_query->row_array();
                
                
                $my_cart_query = $this->db->query("SELECT SUM(calculation_price) as sub_total, SUM(actual_price - discount_price) as total_savings, COUNT(*) as total_item FROM my_cart WHERE status != '9' AND (user_id = '$user_id' OR device_id = '$device_id')");
                $my_cart_result =  $my_cart_query->row_array();
                
                $sub_total = number_format((float)$my_cart_result['sub_total'], 2, '.', '');
                $total_savings = number_format((float)$my_cart_result['total_savings'], 2, '.', '');
                $total_item = $my_cart_result['total_item'];
                 
                if($sub_total >= 500){
                    $delivery_charge_price = '0.00';
                    $total_price = number_format((float)$sub_total, 2, '.', '');
                }
                else
                {
                    if(!empty($delivery_charge_result)){
                        $delivery_charge_price = $delivery_charge_result['price'];
                        $total_price = number_format((float)$sub_total + $delivery_charge_price, 2, '.', '');
                    }else{
                        $delivery_charge_price = '0.00';
                        $total_price = number_format((float)$sub_total + $delivery_charge_price, 2, '.', '');
                    }
                    
                }

                /*Generate Order Number*/
                function random_orderNo( $length = 10 ) {
                    $chars = "1234567890";
                    $order = substr( str_shuffle( $chars ), 0, $length );
                    return $order;
                }
                $od = 'Order #';
                $on = random_orderNo(15);
                $iOrderNo = $od.$on;

                /*Order*/
                $data = array(
                    'user_id' => $user_id,
                    'user_address_id' => $user_address_id,
                    'time_slot_id' => $time_slot_id,
                    'payment_type' => $payment_type,
                    'total_saving' => $total_savings,
                    'total_item' => $total_item,
                    'sub_total' => $sub_total,
                    'delivery_charge' => $delivery_charge_price,
                    'total' => $total_price,
                    'payable_amount' => $total_price,
                    'order_no' => $iOrderNo,
                    'status' => '1',
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $this->db->insert('order', $data);
                $last_insert_id = $this->db->insert_id();

                /*Order Details*/
                $my_order_query = $this->db->query("SELECT * FROM my_cart WHERE status != '9' AND (user_id = '$user_id' OR device_id = '$device_id') ");
                $my_order_result = $my_order_query->result();

                foreach ($my_order_result as $my_order){

                    $data = array(
                        'order_id' => $last_insert_id,
                        'user_id' => $my_order->user_id,
                        'product_id' => $my_order->product_id,
                        'weight_id' => $my_order->weight_id,
                        'quantity' => $my_order->quantity,
                        'actual_price' => $my_order->actual_price,
                        'actual_quantity' => $my_order->actual_quantity,
                        'discount_per' => $my_order->discount_per,
                        'discount_price' => $my_order->discount_price,
                        'calculation_price' => $my_order->calculation_price,
                        'status' => '1',
                        'dt_added' => strtotime(date('Y-m-d H:i:s')),
                        'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                    );
                    $this->db->insert('order_details', $data);
                }

                /*Remove From My Cart*/
                //$this->db->where('user_id', $user_id);
                //$this->db->delete('my_cart');
                $this->db->query("DELETE FROM my_cart WHERE (user_id = '$user_id' OR device_id = '$device_id')");

                $response = array();
                $response ["success"] = 1;
                $response ["message"] = "Thank you for your order";
                $output = json_encode(array('responsedata' => $response));
                echo $output;

            }
            elseif(isset($_REQUEST['user_id'])){

                $delivery_charge_query = $this->db->query("SELECT price FROM setting WHERE title = 'delivery_charge'");
                $delivery_charge_result = $delivery_charge_query->row_array();

                $my_cart_query = $this->db->query("SELECT SUM(calculation_price) as sub_total, SUM(actual_price - discount_price) as total_savings, COUNT(*) as total_item FROM my_cart WHERE status != '9' AND user_id = '$user_id'");
                $my_cart_result =  $my_cart_query->row_array();

                $sub_total = number_format((float)$my_cart_result['sub_total'], 2, '.', '');
                $total_savings = number_format((float)$my_cart_result['total_savings'], 2, '.', '');
                $total_item = $my_cart_result['total_item'];

                if($sub_total >= 500){
                    $delivery_charge_price = '0.00';
                    $total_price = number_format((float)$sub_total, 2, '.', '');
                }
                else
                {
                    $delivery_charge_price = $delivery_charge_result['price'];
                    $total_price = number_format((float)$sub_total + $delivery_charge_price, 2, '.', '');
                }

                /*Generate Order Number*/
                function random_orderNo( $length = 10 ) {
                    $chars = "1234567890";
                    $order = substr( str_shuffle( $chars ), 0, $length );
                    return $order;
                }
                $od = 'Order #';
                $on = random_orderNo(15);
                $iOrderNo = $od.$on;

                /*Order*/
                $data = array(
                    'user_id' => $user_id,
                    'user_address_id' => $user_address_id,
                    'time_slot_id' => $time_slot_id,
                    'payment_type' => $payment_type,
                    'total_saving' => $total_savings,
                    'total_item' => $total_item,
                    'sub_total' => $sub_total,
                    'delivery_charge' => $delivery_charge_price,
                    'total' => $total_price,
                    'payable_amount' => $total_price,
                    'order_no' => $iOrderNo,
                    'status' => '1',
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $this->db->insert('order', $data);
                $last_insert_id = $this->db->insert_id();

                /*Order Details*/
                $my_order_query = $this->db->query("SELECT * FROM my_cart WHERE status != '9' AND user_id = '$user_id' ");
                $my_order_result = $my_order_query->result();

                foreach ($my_order_result as $my_order){

                    $data = array(
                        'order_id' => $last_insert_id,
                        'user_id' => $my_order->user_id,
                        'product_id' => $my_order->product_id,
                        'weight_id' => $my_order->weight_id,
                        'quantity' => $my_order->quantity,
                        'actual_price' => $my_order->actual_price,
                        'actual_quantity' => $my_order->actual_quantity,
                        'discount_per' => $my_order->discount_per,
                        'discount_price' => $my_order->discount_price,
                        'calculation_price' => $my_order->calculation_price,
                        'status' => '1',
                        'dt_added' => strtotime(date('Y-m-d H:i:s')),
                        'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                    );
                    $this->db->insert('order_details', $data);
                }

                /*Remove From My Cart*/
                $this->db->where('user_id', $user_id);
                $this->db->delete('my_cart');

                $response = array();
                $response ["success"] = 1;
                $response ["message"] = "Thank you for your order";
                $output = json_encode(array('responsedata' => $response));
                echo $output;

            }

            else
            {
                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "Invalid data";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }
        else
        {
            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## My Orders ##
    public function my_orders(){

        if(isset($_REQUEST['user_id'])){

            $limit = '10';
            $offset= $_REQUEST['offset'];
            $user_id = $_REQUEST['user_id'];

            $result_count = $this->db->query("SELECT COUNT(*) as total FROM `order` WHERE status != '9' AND user_id = '$user_id'");
            $row_count = $result_count->result();

            $total_count = $row_count[0]->total;
            $cal = $limit  * $offset;

            $query = $this->db->query("SELECT * FROM `order` WHERE status != '9' AND user_id = '$user_id' ORDER BY id DESC LIMIT $limit OFFSET $cal");
            $result = $query->result();

            if($query -> num_rows > 0){

                $response['success'] = "1";
                $response['message'] = "My order list";
                $response["count"] = $total_count;
                $response["data"] = array();
                $counter = 0;

                foreach($result as $row)
                {
                    $data = array();
                    $data['order_id'] = $row->id;
                    $data['dt_added'] = date('F d, Y', $row->dt_added);
                    $data['order_no'] = $row->order_no;
                    $data['total'] = 'Rs '.$row->total;
                    array_push($response["data"], $data);
                    $counter++;
                }
                echo $output = json_encode(array('responsedata' => $response));
            }else{

                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "No record found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }
        else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## My Orders Details ##
    public function my_order_details(){

        if(isset($_REQUEST['user_id']) && isset($_REQUEST['order_id'])){

            $limit = '10';
            $offset= $_REQUEST['offset'];
            $user_id = $_REQUEST['user_id'];
            $order_id = $_REQUEST['order_id'];

            $result_count = $this->db->query("SELECT COUNT(*) as total FROM `order_details` WHERE status != '9' AND user_id = '$user_id' AND order_id = '$order_id'");
            $row_count = $result_count->result();

            $total_count = $row_count[0]->total;
            $cal = $limit  * $offset;

            $query = $this->db->query("SELECT * FROM `order_details` WHERE status != '9' AND user_id = '$user_id' AND order_id = '$order_id' ORDER BY id DESC LIMIT $limit OFFSET $cal");
            $result = $query->result();

            $my_order_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from order_details WHERE status != '9' AND user_id = '$user_id'");
            $my_order_price_result = $my_order_price_query->row_array();

            if($query -> num_rows > 0){

                $response['success'] = "1";
                $response['message'] = "My order details";
                $response["count"] = $total_count;
                $response["total_price"] = number_format((float)$my_order_price_result['total_price'], 2, '.', '');;
                $response["data"] = array();
                $counter = 0;

                foreach($result as $row)
                {

                    $product_id = $row->product_id;

                    $product_query = $this->db->query("SELECT name, image FROM product WHERE status != '9' AND id = '$product_id'");
                    $product_result = $product_query->row_array();

                    $data = array();
                    $data['name'] = $product_result['name'];
                    $data['image'] = base_url().'public/images/product/'.$product_result['image'];
                    $data['image_thumb'] = base_url().'public/images/product_thumb/'.$product_result['image'];
                    $data['quantity'] = $row->quantity;
                    $data['price'] = 'Rs '.$row->calculation_price;
                    array_push($response["data"], $data);
                    $counter++;
                }
                echo $output = json_encode(array('responsedata' => $response));
            }else{

                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "No record found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }
        else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## User Address Add ##
    public function user_address_add(){

        if(isset($_REQUEST['user_id']) && isset($_REQUEST['address']) && isset($_REQUEST['name']) && isset($_REQUEST['pincode']) && isset($_REQUEST['landmark']) && isset($_REQUEST['city']) && isset($_REQUEST['state']) && isset($_REQUEST['country']) && isset($_REQUEST['phone'])  ){

            $user_id = $_REQUEST['user_id'];
            $address_post = $_REQUEST['address'];
            $name = $_REQUEST['name'];
            $pincode = $_REQUEST['pincode'];
            $landmark = $_REQUEST['landmark'];
            $city = $_REQUEST['city'];
            $state = $_REQUEST['state'];
            $country = $_REQUEST['country'];
            $phone = $_REQUEST['phone'];

            /*$address_lat_lng = $address_.', '.$city.', '.$state;
            $address = str_replace(" ", "+", $address_lat_lng);
            $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
            $json_decode = json_decode($json);

            $lat = $json_decode->results[0]->geometry->location->lat;
            $long = $json_decode->results[0]->geometry->location->lng;*/

            $data = array(
                'user_id' => $user_id,
                'address' => $address_post,
                'name' => $name,
                'pincode' => $pincode,
                'landmark' => $landmark,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'phone' => $phone,
                /*'latitude' => $lat,
                'longitude' => $long,*/
                'status' => '1',
                'dt_added' => strtotime(date('Y-m-d H:i:s')),
                'dt_updated' => strtotime(date('Y-m-d H:i:s'))
            );
            $this->db->insert('user_address', $data);

            $response = array();
            $response ["success"] = 1;
            $response ["message"] = "Address has been added.";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Please enter valid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## User Address Update ##
    public function user_address_update(){

        if(isset($_REQUEST['id']) && isset($_REQUEST['address']) && isset($_REQUEST['name']) && isset($_REQUEST['pincode']) && isset($_REQUEST['landmark']) && isset($_REQUEST['city']) && isset($_REQUEST['state']) && isset($_REQUEST['country']) && isset($_REQUEST['phone'])  ){

            $id = $_REQUEST['id'];
            $address_ = $_REQUEST['address'];
            $name = $_REQUEST['name'];
            $pincode = $_REQUEST['pincode'];
            $landmark = $_REQUEST['landmark'];
            $city = $_REQUEST['city'];
            $state = $_REQUEST['state'];
            $country = $_REQUEST['country'];
            $phone = $_REQUEST['phone'];

            /*$address_lat_lng = $address_.', '.$city.', '.$state;
            $address = str_replace(" ", "+", $address_lat_lng);
            $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
            $json_decode = json_decode($json);

            $lat = $json_decode->results[0]->geometry->location->lat;
            $long = $json_decode->results[0]->geometry->location->lng;*/

            $data = array(
                'address' => $address_,
                'name' => $name,
                'pincode' => $pincode,
                'landmark' => $landmark,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'phone' => $phone,
                /*'latitude' => $lat,
                'longitude' => $long,*/
                'status' => '1',
                'dt_updated' => strtotime(date('Y-m-d H:i:s')),
            );
            $this->db->where('id', $id);
            $this->db->update('user_address', $data);

            $response = array();
            $response ["success"] = 1;
            $response ["message"] = "Address has been updated.";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "Please enter valid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }

    ## Filter ##
    public function filter_search(){

        if(isset($_REQUEST['filter_search'])){

            $limit = '5';
            $offset= $_REQUEST['offset'];
            $user_id = $_REQUEST['user_id'];
            $device_id = $_REQUEST['device_id'];
            $category_id = $_REQUEST['category_id'];

            if($_REQUEST['filter_search'] == 'popularity'){

                $result_count = $this->db->query("SELECT p.* FROM `product` as p 
                                                LEFT JOIN product_weight as w ON w.product_id = p.id
                                                WHERE p.status != '9' AND w.discount_price != '' AND w.status != '9' AND p.category_id = '$category_id' GROUP BY p.id");
                $row_count_ = $result_count->result();
                $total_count = count(array_keys($row_count_));

                $cal = $limit  * $offset;

                $query = $this->db->query("SELECT p.* FROM `product` as p 
                                        LEFT JOIN product_weight as w ON w.product_id = p.id
                                        WHERE p.status != '9' AND w.discount_price != '' AND w.status != '9' AND p.category_id = '$category_id' GROUP BY p.id ORDER BY p.id DESC LIMIT $limit OFFSET $cal");
                $result = $query->result();

                if($query -> num_rows > 0){

                    $response['success'] = "1";
                    $response['message'] = "Product list";
                    $response["count"] = $total_count;
                    $response["data"] = array();
                    $counter = 0;

                    foreach($result as $row)
                    {
                        $product_id = $row->id;

                        $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_weight_result = $product_weight_query->result();

                        $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_image_result = $product_image_query->result();

                        $new_array_product_weight = array();
                        foreach ($product_weight_result as $pro_weight) {

                            $weight_id = $pro_weight->weight_id;

                            $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                            $weight_result = $weight_query->row_array();
                            $weight_name = $weight_result['name'];

                            if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }elseif(isset($_REQUEST['device_id']) && $_REQUEST['user_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }
                            elseif(isset($_REQUEST['user_id']) && $_REQUEST['device_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }else{
                                $my_cart_result = array();
                            }

                            if(empty($my_cart_result)){
                                $my_cart_quantity = '0';
                            }else{
                                $my_cart_quantity = $my_cart_result['quantity'];
                            }

                            $data = array(
                                'id' => $pro_weight->id,
                                'product_id' => $pro_weight->product_id,
                                'weight_id' => $pro_weight->weight_id,
                                'unit' => $pro_weight->weight_no.' '.$weight_name,
                                'actual_price' => $pro_weight->price,
                                'quantity' => $pro_weight->quantity,
                                'discount_per' => $pro_weight->discount_per,
                                'discount_price' => $pro_weight->discount_price,
                                'my_cart_quantity' => $my_cart_quantity
                            );
                            array_push($new_array_product_weight,$data);
                        }
                        $product_weight_array = $new_array_product_weight;

                        $new_array_product_image = array();
                        foreach ($product_image_result as $pro_image) {
                            $data = array(
                                'id' => $pro_image->id,
                                'product_id' => $pro_image->product_id,
                                'image' => base_url().'public/images/product_image/'.$pro_image->image,
                                'thumb_image' => base_url().'public/images/product_image_thumb/'.$pro_image->image,
                            );
                            array_push($new_array_product_image,$data);
                        }
                        $product_image_array = $new_array_product_image;

                        $data = array();
                        $data['id'] = $row->id;
                        $data['category_id'] = $row->category_id;
                        $data['brand_id'] = $row->brand_id;
                        $data['name'] = $row->name;
                        $data['image'] = base_url().'public/images/product/'.$row->image;
                        $data['image_thumb'] = base_url().'public/images/product_thumb/'.$row->image;
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
                }

                else{

                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "No record found";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }

            elseif($_REQUEST['filter_search'] == 'low_high'){

                $result_count = $this->db->query("SELECT p.* FROM `product` as p 
                                                LEFT JOIN product_weight as w ON w.product_id = p.id
                                                WHERE p.status != '9' AND w.discount_price != '' AND w.status != '9' AND p.category_id = '$category_id' GROUP BY p.id");
                $row_count_ = $result_count->result();
                $total_count = count(array_keys($row_count_));

                $cal = $limit  * $offset;

                $query = $this->db->query("SELECT p.* FROM `product` as p 
                                                LEFT JOIN product_weight as w ON w.product_id = p.id
                                                WHERE p.status != '9' AND w.discount_price != '' AND w.status != '9' AND p.category_id = '$category_id' GROUP BY p.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2)) ASC LIMIT $limit OFFSET $cal");
                $result = $query->result();

                if($query -> num_rows > 0){

                    $response['success'] = "1";
                    $response['message'] = "Product list";
                    $response["count"] = $total_count;
                    $response["data"] = array();
                    $counter = 0;

                    foreach($result as $row)
                    {
                        $product_id = $row->id;

                        $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_weight_result = $product_weight_query->result();

                        $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_image_result = $product_image_query->result();

                        $new_array_product_weight = array();
                        foreach ($product_weight_result as $pro_weight) {

                            $weight_id = $pro_weight->weight_id;

                            $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                            $weight_result = $weight_query->row_array();
                            $weight_name = $weight_result['name'];

                            if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }elseif(isset($_REQUEST['device_id']) && $_REQUEST['user_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }
                            elseif(isset($_REQUEST['user_id']) && $_REQUEST['device_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }else{
                                $my_cart_result = array();
                            }

                            if(empty($my_cart_result)){
                                $my_cart_quantity = '0';
                            }else{
                                $my_cart_quantity = $my_cart_result['quantity'];
                            }

                            $data = array(
                                'id' => $pro_weight->id,
                                'product_id' => $pro_weight->product_id,
                                'weight_id' => $pro_weight->weight_id,
                                'unit' => $pro_weight->weight_no.' '.$weight_name,
                                'actual_price' => $pro_weight->price,
                                'quantity' => $pro_weight->quantity,
                                'discount_per' => $pro_weight->discount_per,
                                'discount_price' => $pro_weight->discount_price,
                                'my_cart_quantity' => $my_cart_quantity
                            );
                            array_push($new_array_product_weight,$data);
                        }
                        $product_weight_array = $new_array_product_weight;

                        $new_array_product_image = array();
                        foreach ($product_image_result as $pro_image) {
                            $data = array(
                                'id' => $pro_image->id,
                                'product_id' => $pro_image->product_id,
                                'image' => base_url().'public/images/product_image/'.$pro_image->image,
                                'thumb_image' => base_url().'public/images/product_image_thumb/'.$pro_image->image,
                            );
                            array_push($new_array_product_image,$data);
                        }
                        $product_image_array = $new_array_product_image;

                        $data = array();
                        $data['id'] = $row->id;
                        $data['category_id'] = $row->category_id;
                        $data['brand_id'] = $row->brand_id;
                        $data['name'] = $row->name;
                        $data['image'] = base_url().'public/images/product/'.$row->image;
                        $data['image_thumb'] = base_url().'public/images/product_thumb/'.$row->image;
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
                }

                else{

                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "No record found";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }

            elseif($_REQUEST['filter_search'] == 'high_low'){

                $result_count = $this->db->query("SELECT p.* FROM `product` as p 
                                                LEFT JOIN product_weight as w ON w.product_id = p.id
                                                WHERE p.status != '9' AND w.discount_price != '' AND w.status != '9' AND p.category_id = '$category_id' GROUP BY p.id");
                $row_count_ = $result_count->result();
                $total_count = count(array_keys($row_count_));

                $cal = $limit  * $offset;

                $query = $this->db->query("SELECT p.* FROM `product` as p 
                                        LEFT JOIN product_weight as w ON w.product_id = p.id
                                        WHERE p.status != '9' AND w.discount_price != '' AND w.status != '9' AND p.category_id = '$category_id' GROUP BY p.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2)) DESC LIMIT $limit OFFSET $cal");
                $result = $query->result();

                if($query -> num_rows > 0){

                    $response['success'] = "1";
                    $response['message'] = "Product list";
                    $response["count"] = $total_count;
                    $response["data"] = array();
                    $counter = 0;

                    foreach($result as $row)
                    {
                        $product_id = $row->id;

                        $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_weight_result = $product_weight_query->result();

                        $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_image_result = $product_image_query->result();

                        $new_array_product_weight = array();
                        foreach ($product_weight_result as $pro_weight) {

                            $weight_id = $pro_weight->weight_id;

                            $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                            $weight_result = $weight_query->row_array();
                            $weight_name = $weight_result['name'];

                            if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }elseif(isset($_REQUEST['device_id']) && $_REQUEST['user_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }
                            elseif(isset($_REQUEST['user_id']) && $_REQUEST['device_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }else{
                                $my_cart_result = array();
                            }

                            if(empty($my_cart_result)){
                                $my_cart_quantity = '0';
                            }else{
                                $my_cart_quantity = $my_cart_result['quantity'];
                            }

                            $data = array(
                                'id' => $pro_weight->id,
                                'product_id' => $pro_weight->product_id,
                                'weight_id' => $pro_weight->weight_id,
                                'unit' => $pro_weight->weight_no.' '.$weight_name,
                                'actual_price' => $pro_weight->price,
                                'quantity' => $pro_weight->quantity,
                                'discount_per' => $pro_weight->discount_per,
                                'discount_price' => $pro_weight->discount_price,
                                'my_cart_quantity' => $my_cart_quantity
                            );
                            array_push($new_array_product_weight,$data);
                        }
                        $product_weight_array = $new_array_product_weight;

                        $new_array_product_image = array();
                        foreach ($product_image_result as $pro_image) {
                            $data = array(
                                'id' => $pro_image->id,
                                'product_id' => $pro_image->product_id,
                                'image' => base_url().'public/images/product_image/'.$pro_image->image,
                                'thumb_image' => base_url().'public/images/product_image_thumb/'.$pro_image->image,
                            );
                            array_push($new_array_product_image,$data);
                        }
                        $product_image_array = $new_array_product_image;

                        $data = array();
                        $data['id'] = $row->id;
                        $data['category_id'] = $row->category_id;
                        $data['brand_id'] = $row->brand_id;
                        $data['name'] = $row->name;
                        $data['image'] = base_url().'public/images/product/'.$row->image;
                        $data['image_thumb'] = base_url().'public/images/product_thumb/'.$row->image;
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
                }

                else{

                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "No record found";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }

            elseif($_REQUEST['filter_search'] == 'alphabetic'){

                $result_count = $this->db->query("SELECT p.* FROM `product` as p 
                                                LEFT JOIN product_weight as w ON w.product_id = p.id
                                                WHERE p.status != '9' AND w.discount_price != '' AND w.status != '9' AND p.category_id = '$category_id' GROUP BY p.id ORDER BY p.name ASC");
                $row_count_ = $result_count->result();
                $total_count = count(array_keys($row_count_));

                $cal = $limit  * $offset;

                $query = $this->db->query("SELECT p.* FROM `product` as p 
                                        LEFT JOIN product_weight as w ON w.product_id = p.id
                                        WHERE p.status != '9' AND w.discount_price != '' AND w.status != '9' AND p.category_id = '$category_id' GROUP BY p.id ORDER BY p.name ASC LIMIT $limit OFFSET $cal");
                $result = $query->result();

                if($query -> num_rows > 0){

                    $response['success'] = "1";
                    $response['message'] = "Product list";
                    $response["count"] = $total_count;
                    $response["data"] = array();
                    $counter = 0;

                    foreach($result as $row)
                    {
                        $product_id = $row->id;

                        $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_weight_result = $product_weight_query->result();

                        $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_image_result = $product_image_query->result();

                        $new_array_product_weight = array();
                        foreach ($product_weight_result as $pro_weight) {

                            $weight_id = $pro_weight->weight_id;

                            $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                            $weight_result = $weight_query->row_array();
                            $weight_name = $weight_result['name'];

                            if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }elseif(isset($_REQUEST['device_id']) && $_REQUEST['user_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }
                            elseif(isset($_REQUEST['user_id']) && $_REQUEST['device_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }else{
                                $my_cart_result = array();
                            }

                            if(empty($my_cart_result)){
                                $my_cart_quantity = '0';
                            }else{
                                $my_cart_quantity = $my_cart_result['quantity'];
                            }

                            $data = array(
                                'id' => $pro_weight->id,
                                'product_id' => $pro_weight->product_id,
                                'weight_id' => $pro_weight->weight_id,
                                'unit' => $pro_weight->weight_no.' '.$weight_name,
                                'actual_price' => $pro_weight->price,
                                'quantity' => $pro_weight->quantity,
                                'discount_per' => $pro_weight->discount_per,
                                'discount_price' => $pro_weight->discount_price,
                                'my_cart_quantity' => $my_cart_quantity
                            );
                            array_push($new_array_product_weight,$data);
                        }
                        $product_weight_array = $new_array_product_weight;

                        $new_array_product_image = array();
                        foreach ($product_image_result as $pro_image) {
                            $data = array(
                                'id' => $pro_image->id,
                                'product_id' => $pro_image->product_id,
                                'image' => base_url().'public/images/product_image/'.$pro_image->image,
                                'thumb_image' => base_url().'public/images/product_image_thumb/'.$pro_image->image,
                            );
                            array_push($new_array_product_image,$data);
                        }
                        $product_image_array = $new_array_product_image;

                        $data = array();
                        $data['id'] = $row->id;
                        $data['category_id'] = $row->category_id;
                        $data['brand_id'] = $row->brand_id;
                        $data['name'] = $row->name;
                        $data['image'] = base_url().'public/images/product/'.$row->image;
                        $data['image_thumb'] = base_url().'public/images/product_thumb/'.$row->image;
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
                }

                else{

                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "No record found";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }

            elseif($_REQUEST['filter_search'] == 'discount_off_high_low'){

                $result_count = $this->db->query("SELECT p.* FROM `product` as p 
                                                LEFT JOIN product_weight as w ON w.product_id = p.id
                                                WHERE p.status != '9' AND w.discount_price != '' AND w.status != '9' AND p.category_id = '$category_id' GROUP BY p.id ORDER BY p.name ASC");
                $row_count_ = $result_count->result();
                $total_count = count(array_keys($row_count_));

                $cal = $limit  * $offset;

                $query = $this->db->query("SELECT p.* FROM `product` as p 
                                        LEFT JOIN product_weight as w ON w.product_id = p.id
                                        WHERE p.status != '9' AND w.discount_price != '' AND w.status != '9' AND p.category_id = '$category_id' GROUP BY p.id ORDER BY CAST(w.discount_per AS DECIMAL(10)) DESC LIMIT $limit OFFSET $cal");
                $result = $query->result();

                if($query -> num_rows > 0){

                    $response['success'] = "1";
                    $response['message'] = "Product list";
                    $response["count"] = $total_count;
                    $response["data"] = array();
                    $counter = 0;

                    foreach($result as $row)
                    {
                        $product_id = $row->id;

                        $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_weight_result = $product_weight_query->result();

                        $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_image_result = $product_image_query->result();

                        $new_array_product_weight = array();
                        foreach ($product_weight_result as $pro_weight) {

                            $weight_id = $pro_weight->weight_id;

                            $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                            $weight_result = $weight_query->row_array();
                            $weight_name = $weight_result['name'];

                            if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }elseif(isset($_REQUEST['device_id']) && $_REQUEST['user_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }
                            elseif(isset($_REQUEST['user_id']) && $_REQUEST['device_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }else{
                                $my_cart_result = array();
                            }

                            if(empty($my_cart_result)){
                                $my_cart_quantity = '0';
                            }else{
                                $my_cart_quantity = $my_cart_result['quantity'];
                            }

                            $data = array(
                                'id' => $pro_weight->id,
                                'product_id' => $pro_weight->product_id,
                                'weight_id' => $pro_weight->weight_id,
                                'unit' => $pro_weight->weight_no.' '.$weight_name,
                                'actual_price' => $pro_weight->price,
                                'quantity' => $pro_weight->quantity,
                                'discount_per' => $pro_weight->discount_per,
                                'discount_price' => $pro_weight->discount_price,
                                'my_cart_quantity' => $my_cart_quantity
                            );
                            array_push($new_array_product_weight,$data);
                        }
                        $product_weight_array = $new_array_product_weight;

                        $new_array_product_image = array();
                        foreach ($product_image_result as $pro_image) {
                            $data = array(
                                'id' => $pro_image->id,
                                'product_id' => $pro_image->product_id,
                                'image' => base_url().'public/images/product_image/'.$pro_image->image,
                                'thumb_image' => base_url().'public/images/product_image_thumb/'.$pro_image->image,
                            );
                            array_push($new_array_product_image,$data);
                        }
                        $product_image_array = $new_array_product_image;

                        $data = array();
                        $data['id'] = $row->id;
                        $data['category_id'] = $row->category_id;
                        $data['brand_id'] = $row->brand_id;
                        $data['name'] = $row->name;
                        $data['image'] = base_url().'public/images/product/'.$row->image;
                        $data['image_thumb'] = base_url().'public/images/product_thumb/'.$row->image;
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
                }

                else{

                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "No record found";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }

            else{

                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "Invalid data";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }

        else{

            $limit = '5';
            $offset= $_REQUEST['offset'];
            $price_id = $_REQUEST['price_id'];
            $brand_id = $_REQUEST['brand_id'];
            $discount_id = $_REQUEST['discount_id'];
            $user_id = $_REQUEST['user_id'];
            $device_id = $_REQUEST['device_id'];
            $category_id = $_REQUEST['category_id'];

            if(isset($price_id) && $price_id != '' && isset($brand_id) && $brand_id != '' && isset($discount_id) && $discount_id != ''){

                $price_query = $this->db->query("SELECT * FROM price WHERE id IN ($price_id) AND status != '9'");
                $price_result = $price_query->result();




                $start_price = current($price_result)->start_price;
                $end_price = end($price_result)->end_price;

                $discount_query = $this->db->query("SELECT * FROM discount WHERE id IN ($discount_id) AND status != '9'");
                $discount_result = $discount_query->result();
                
                
                $start_discount = current($discount_result)->start_discount;
                $end_discount = end($discount_result)->end_discount;

                $result_count = $this->db->query("SELECT p.*, w.discount_price FROM `product` as p 
                                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                                    WHERE p.status != '9' AND w.status != '9' AND w.discount_price != '' AND p.category_id = '$category_id' AND (w.discount_price >= $start_price AND w.discount_price <= $end_price) AND p.brand_id IN ($brand_id) AND (w.discount_per >= $start_discount AND w.discount_per <= $end_discount) GROUP BY p.id");

                
                $row_count_ = $result_count->result();
                $total_count = count(array_keys($row_count_));

                $cal = $limit * $offset;

                $query = $this->db->query("SELECT p.*, w.discount_price FROM `product` as p 
                                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                                    WHERE p.status != '9' AND w.status != '9' AND w.discount_price != '' AND p.category_id = '$category_id' AND (w.discount_price >= $start_price AND w.discount_price <= $end_price) AND p.brand_id IN ($brand_id) AND (w.discount_per >= $start_discount AND w.discount_per <= $end_discount) GROUP BY p.id ORDER BY p.id DESC LIMIT $limit OFFSET $cal");
                $result = $query->result();

                if($query -> num_rows > 0){

                    $response['success'] = "1";
                    $response['message'] = "Product list";
                    $response["count"] = $total_count;
                    $response["data"] = array();
                    $counter = 0;

                    foreach($result as $row)
                    {
                        $product_id = $row->id;

                        $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_weight_result = $product_weight_query->result();

                        $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_image_result = $product_image_query->result();

                        $new_array_product_weight = array();
                        foreach ($product_weight_result as $pro_weight) {

                            $weight_id = $pro_weight->weight_id;

                            $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                            $weight_result = $weight_query->row_array();
                            $weight_name = $weight_result['name'];

                            if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }elseif(isset($_REQUEST['device_id']) && $_REQUEST['user_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }
                            elseif(isset($_REQUEST['user_id']) && $_REQUEST['device_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }else{
                                $my_cart_result = array();
                            }

                            if(empty($my_cart_result)){
                                $my_cart_quantity = '0';
                            }else{
                                $my_cart_quantity = $my_cart_result['quantity'];
                            }

                            $data = array(
                                'id' => $pro_weight->id,
                                'product_id' => $pro_weight->product_id,
                                'weight_id' => $pro_weight->weight_id,
                                'unit' => $pro_weight->weight_no.' '.$weight_name,
                                'actual_price' => $pro_weight->price,
                                'quantity' => $pro_weight->quantity,
                                'discount_per' => $pro_weight->discount_per,
                                'discount_price' => $pro_weight->discount_price,
                                'my_cart_quantity' => $my_cart_quantity
                            );
                            array_push($new_array_product_weight,$data);
                        }
                        $product_weight_array = $new_array_product_weight;

                        $new_array_product_image = array();
                        foreach ($product_image_result as $pro_image) {
                            $data = array(
                                'id' => $pro_image->id,
                                'product_id' => $pro_image->product_id,
                                'image' => base_url().'public/images/product_image/'.$pro_image->image,
                                'thumb_image' => base_url().'public/images/product_image_thumb/'.$pro_image->image,
                            );
                            array_push($new_array_product_image,$data);
                        }
                        $product_image_array = $new_array_product_image;

                        $data = array();
                        $data['id'] = $row->id;
                        $data['category_id'] = $row->category_id;
                        $data['brand_id'] = $row->brand_id;
                        $data['name'] = $row->name;
                        $data['image'] = base_url().'public/images/product/'.$row->image;
                        $data['image_thumb'] = base_url().'public/images/product_thumb/'.$row->image;
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
                }

                else{

                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "No record found";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }

            elseif(isset($price_id) && $price_id != '' && isset($brand_id) && $brand_id != ''){

                $price_query = $this->db->query("SELECT * FROM price WHERE id IN ($price_id) AND status != '9'");
                $price_result = $price_query->result();

                $start_price = current($price_result)->start_price;
                $end_price = end($price_result)->end_price;

                $result_count = $this->db->query("SELECT p.*, w.discount_price FROM `product` as p 
                                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                                    WHERE p.status != '9' AND w.status != '9' AND w.discount_price != '' AND p.category_id = '$category_id' AND (w.discount_price >= $start_price AND w.discount_price <= $end_price) AND p.brand_id IN ($brand_id) GROUP BY p.id");
                $row_count_ = $result_count->result();
                $total_count = count(array_keys($row_count_));

                $cal = $limit  * $offset;

                $query = $this->db->query("SELECT p.*, w.discount_price FROM `product` as p 
                                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                                    WHERE p.status != '9' AND w.status != '9' AND w.discount_price != '' AND p.category_id = '$category_id' AND (w.discount_price >= $start_price AND w.discount_price <= $end_price) AND p.brand_id IN ($brand_id) GROUP BY p.id ORDER BY p.id DESC LIMIT $limit OFFSET $cal");
                $result = $query->result();

                if($query -> num_rows > 0){

                    $response['success'] = "1";
                    $response['message'] = "Product list";
                    $response["count"] = $total_count;
                    $response["data"] = array();
                    $counter = 0;

                    foreach($result as $row)
                    {
                        $product_id = $row->id;

                        $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_weight_result = $product_weight_query->result();

                        $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_image_result = $product_image_query->result();

                        $new_array_product_weight = array();
                        foreach ($product_weight_result as $pro_weight) {

                            $weight_id = $pro_weight->weight_id;

                            $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                            $weight_result = $weight_query->row_array();
                            $weight_name = $weight_result['name'];

                            if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }elseif(isset($_REQUEST['device_id']) && $_REQUEST['user_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }
                            elseif(isset($_REQUEST['user_id']) && $_REQUEST['device_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }else{
                                $my_cart_result = array();
                            }

                            if(empty($my_cart_result)){
                                $my_cart_quantity = '0';
                            }else{
                                $my_cart_quantity = $my_cart_result['quantity'];
                            }

                            $data = array(
                                'id' => $pro_weight->id,
                                'product_id' => $pro_weight->product_id,
                                'weight_id' => $pro_weight->weight_id,
                                'unit' => $pro_weight->weight_no.' '.$weight_name,
                                'actual_price' => $pro_weight->price,
                                'quantity' => $pro_weight->quantity,
                                'discount_per' => $pro_weight->discount_per,
                                'discount_price' => $pro_weight->discount_price,
                                'my_cart_quantity' => $my_cart_quantity
                            );
                            array_push($new_array_product_weight,$data);
                        }
                        $product_weight_array = $new_array_product_weight;

                        $new_array_product_image = array();
                        foreach ($product_image_result as $pro_image) {
                            $data = array(
                                'id' => $pro_image->id,
                                'product_id' => $pro_image->product_id,
                                'image' => base_url().'public/images/product_image/'.$pro_image->image,
                                'thumb_image' => base_url().'public/images/product_image_thumb/'.$pro_image->image,
                            );
                            array_push($new_array_product_image,$data);
                        }
                        $product_image_array = $new_array_product_image;

                        $data = array();
                        $data['id'] = $row->id;
                        $data['category_id'] = $row->category_id;
                        $data['brand_id'] = $row->brand_id;
                        $data['name'] = $row->name;
                        $data['image'] = base_url().'public/images/product/'.$row->image;
                        $data['image_thumb'] = base_url().'public/images/product_thumb/'.$row->image;
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
                }

                else{

                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "No record found";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }

            elseif(isset($price_id) && $price_id != '' && isset($discount_id) && $discount_id != ''){

                $price_query = $this->db->query("SELECT * FROM price WHERE id IN ($price_id) AND status != '9'");
                $price_result = $price_query->result();

                $start_price = current($price_result)->start_price;
                $end_price = end($price_result)->end_price;

                $discount_query = $this->db->query("SELECT * FROM discount WHERE id IN ($discount_id) AND status != '9'");
                $discount_result = $discount_query->result();

                $start_discount = current($discount_result)->start_discount;
                $end_discount = end($discount_result)->end_discount;

                $result_count = $this->db->query("SELECT p.*, w.discount_price FROM `product` as p 
                                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                                    WHERE p.status != '9' AND w.status != '9' AND w.discount_price != '' AND p.category_id = '$category_id' AND (w.discount_price >= $start_price AND w.discount_price <= $end_price) AND (w.discount_per >= $start_discount AND w.discount_per <= $end_discount) GROUP BY p.id");
                $row_count_ = $result_count->result();
                $total_count = count(array_keys($row_count_));

                $cal = $limit  * $offset;

                $query = $this->db->query("SELECT p.*, w.discount_price FROM `product` as p 
                                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                                    WHERE p.status != '9' AND w.status != '9' AND w.discount_price != '' AND p.category_id = '$category_id' AND (w.discount_price >= $start_price AND w.discount_price <= $end_price) AND (w.discount_per >= $start_discount AND w.discount_per <= $end_discount) GROUP BY p.id ORDER BY p.id DESC LIMIT $limit OFFSET $cal");
                $result = $query->result();

                if($query -> num_rows > 0){

                    $response['success'] = "1";
                    $response['message'] = "Product list";
                    $response["count"] = $total_count;
                    $response["data"] = array();
                    $counter = 0;

                    foreach($result as $row)
                    {
                        $product_id = $row->id;

                        $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_weight_result = $product_weight_query->result();

                        $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_image_result = $product_image_query->result();

                        $new_array_product_weight = array();
                        foreach ($product_weight_result as $pro_weight) {

                            $weight_id = $pro_weight->weight_id;

                            $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                            $weight_result = $weight_query->row_array();
                            $weight_name = $weight_result['name'];

                            if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }elseif(isset($_REQUEST['device_id']) && $_REQUEST['user_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }
                            elseif(isset($_REQUEST['user_id']) && $_REQUEST['device_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }else{
                                $my_cart_result = array();
                            }

                            if(empty($my_cart_result)){
                                $my_cart_quantity = '0';
                            }else{
                                $my_cart_quantity = $my_cart_result['quantity'];
                            }

                            $data = array(
                                'id' => $pro_weight->id,
                                'product_id' => $pro_weight->product_id,
                                'weight_id' => $pro_weight->weight_id,
                                'unit' => $pro_weight->weight_no.' '.$weight_name,
                                'actual_price' => $pro_weight->price,
                                'quantity' => $pro_weight->quantity,
                                'discount_per' => $pro_weight->discount_per,
                                'discount_price' => $pro_weight->discount_price,
                                'my_cart_quantity' => $my_cart_quantity
                            );
                            array_push($new_array_product_weight,$data);
                        }
                        $product_weight_array = $new_array_product_weight;

                        $new_array_product_image = array();
                        foreach ($product_image_result as $pro_image) {
                            $data = array(
                                'id' => $pro_image->id,
                                'product_id' => $pro_image->product_id,
                                'image' => base_url().'public/images/product_image/'.$pro_image->image,
                                'thumb_image' => base_url().'public/images/product_image_thumb/'.$pro_image->image,
                            );
                            array_push($new_array_product_image,$data);
                        }
                        $product_image_array = $new_array_product_image;

                        $data = array();
                        $data['id'] = $row->id;
                        $data['category_id'] = $row->category_id;
                        $data['brand_id'] = $row->brand_id;
                        $data['name'] = $row->name;
                        $data['image'] = base_url().'public/images/product/'.$row->image;
                        $data['image_thumb'] = base_url().'public/images/product_thumb/'.$row->image;
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
                }

                else{

                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "No record found";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }

            elseif(isset($brand_id) && $brand_id != '' && isset($discount_id) && $discount_id != ''){

                $discount_query = $this->db->query("SELECT * FROM discount WHERE id IN ($discount_id) AND status != '9'");
                $discount_result = $discount_query->result();

                $start_discount = current($discount_result)->start_discount;
                $end_discount = end($discount_result)->end_discount;

                $result_count = $this->db->query("SELECT p.*, w.discount_price, w.discount_per FROM `product` as p 
                                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                                    WHERE p.status != '9' AND w.status != '9' AND w.discount_price != '' AND p.category_id = '$category_id' AND p.brand_id IN ($brand_id) AND (w.discount_per >= $start_discount AND w.discount_per <= $end_discount) GROUP BY p.id");
                $row_count_ = $result_count->result();
                $total_count = count(array_keys($row_count_));

                $cal = $limit  * $offset;

                $query = $this->db->query("SELECT p.*, w.discount_price, w.discount_per FROM `product` as p 
                                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                                    WHERE p.status != '9' AND w.status != '9' AND w.discount_price != '' AND p.category_id = '$category_id' AND p.brand_id IN ($brand_id) AND (w.discount_per >= $start_discount AND w.discount_per <= $end_discount) GROUP BY p.id DESC LIMIT $limit OFFSET $cal");
                $result = $query->result();

                if($query -> num_rows > 0){

                    $response['success'] = "1";
                    $response['message'] = "Product list";
                    $response["count"] = $total_count;
                    $response["data"] = array();
                    $counter = 0;

                    foreach($result as $row)
                    {
                        $product_id = $row->id;

                        $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_weight_result = $product_weight_query->result();

                        $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_image_result = $product_image_query->result();

                        $new_array_product_weight = array();
                        foreach ($product_weight_result as $pro_weight) {

                            $weight_id = $pro_weight->weight_id;

                            $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                            $weight_result = $weight_query->row_array();
                            $weight_name = $weight_result['name'];

                            if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }elseif(isset($_REQUEST['device_id']) && $_REQUEST['user_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }
                            elseif(isset($_REQUEST['user_id']) && $_REQUEST['device_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }else{
                                $my_cart_result = array();
                            }

                            if(empty($my_cart_result)){
                                $my_cart_quantity = '0';
                            }else{
                                $my_cart_quantity = $my_cart_result['quantity'];
                            }

                            $data = array(
                                'id' => $pro_weight->id,
                                'product_id' => $pro_weight->product_id,
                                'weight_id' => $pro_weight->weight_id,
                                'unit' => $pro_weight->weight_no.' '.$weight_name,
                                'actual_price' => $pro_weight->price,
                                'quantity' => $pro_weight->quantity,
                                'discount_per' => $pro_weight->discount_per,
                                'discount_price' => $pro_weight->discount_price,
                                'my_cart_quantity' => $my_cart_quantity
                            );
                            array_push($new_array_product_weight,$data);
                        }
                        $product_weight_array = $new_array_product_weight;

                        $new_array_product_image = array();
                        foreach ($product_image_result as $pro_image) {
                            $data = array(
                                'id' => $pro_image->id,
                                'product_id' => $pro_image->product_id,
                                'image' => base_url().'public/images/product_image/'.$pro_image->image,
                                'thumb_image' => base_url().'public/images/product_image_thumb/'.$pro_image->image,
                            );
                            array_push($new_array_product_image,$data);
                        }
                        $product_image_array = $new_array_product_image;

                        $data = array();
                        $data['id'] = $row->id;
                        $data['category_id'] = $row->category_id;
                        $data['brand_id'] = $row->brand_id;
                        $data['name'] = $row->name;
                        $data['image'] = base_url().'public/images/product/'.$row->image;
                        $data['image_thumb'] = base_url().'public/images/product_thumb/'.$row->image;
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
                }

                else{

                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "No record found";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }

            elseif(isset($price_id) && $price_id != ''){

                $price_query = $this->db->query("SELECT * FROM price WHERE id IN ($price_id) AND status != '9'");
                $price_result = $price_query->result();

                $start_price = current($price_result)->start_price;
                $end_price = end($price_result)->end_price;

                $result_count = $this->db->query("SELECT p.*, w.discount_price FROM `product` as p 
                                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                                    WHERE p.status != '9' AND w.status != '9' AND w.discount_price != '' AND p.category_id = '$category_id' AND (w.discount_price >= $start_price AND w.discount_price <= $end_price) GROUP BY p.id");
                $row_count_ = $result_count->result();
                $total_count = count(array_keys($row_count_));

                $cal = $limit  * $offset;

                $query = $this->db->query("SELECT p.*, w.discount_price FROM `product` as p 
                                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                                    WHERE p.status != '9' AND w.status != '9' AND w.discount_price != '' AND p.category_id = '$category_id' AND (w.discount_price >= $start_price AND w.discount_price <= $end_price) GROUP BY p.id ORDER BY p.id DESC LIMIT $limit OFFSET $cal");
                $result = $query->result();

                if($query -> num_rows > 0){

                    $response['success'] = "1";
                    $response['message'] = "Product list";
                    $response["count"] = $total_count;
                    $response["data"] = array();
                    $counter = 0;

                    foreach($result as $row)
                    {
                        $product_id = $row->id;

                        $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_weight_result = $product_weight_query->result();

                        $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_image_result = $product_image_query->result();

                        $new_array_product_weight = array();
                        foreach ($product_weight_result as $pro_weight) {

                            $weight_id = $pro_weight->weight_id;

                            $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                            $weight_result = $weight_query->row_array();
                            $weight_name = $weight_result['name'];

                            if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }elseif(isset($_REQUEST['device_id']) && $_REQUEST['user_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }
                            elseif(isset($_REQUEST['user_id']) && $_REQUEST['device_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }else{
                                $my_cart_result = array();
                            }

                            if(empty($my_cart_result)){
                                $my_cart_quantity = '0';
                            }else{
                                $my_cart_quantity = $my_cart_result['quantity'];
                            }

                            $data = array(
                                'id' => $pro_weight->id,
                                'product_id' => $pro_weight->product_id,
                                'weight_id' => $pro_weight->weight_id,
                                'unit' => $pro_weight->weight_no.' '.$weight_name,
                                'actual_price' => $pro_weight->price,
                                'quantity' => $pro_weight->quantity,
                                'discount_per' => $pro_weight->discount_per,
                                'discount_price' => $pro_weight->discount_price,
                                'my_cart_quantity' => $my_cart_quantity
                            );
                            array_push($new_array_product_weight,$data);
                        }
                        $product_weight_array = $new_array_product_weight;

                        $new_array_product_image = array();
                        foreach ($product_image_result as $pro_image) {
                            $data = array(
                                'id' => $pro_image->id,
                                'product_id' => $pro_image->product_id,
                                'image' => base_url().'public/images/product_image/'.$pro_image->image,
                                'thumb_image' => base_url().'public/images/product_image_thumb/'.$pro_image->image,
                            );
                            array_push($new_array_product_image,$data);
                        }
                        $product_image_array = $new_array_product_image;

                        $data = array();
                        $data['id'] = $row->id;
                        $data['category_id'] = $row->category_id;
                        $data['brand_id'] = $row->brand_id;
                        $data['name'] = $row->name;
                        $data['image'] = base_url().'public/images/product/'.$row->image;
                        $data['image_thumb'] = base_url().'public/images/product_thumb/'.$row->image;
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
                }

                else{

                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "No record found";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }

            elseif(isset($brand_id) && $brand_id != ''){

                $result_count = $this->db->query("SELECT p.*, w.discount_price FROM `product` as p 
                                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                                    WHERE p.status != '9' AND w.status != '9' AND w.discount_price != '' AND p.category_id = '$category_id' AND p.brand_id IN ($brand_id) GROUP BY p.id");
                $row_count_ = $result_count->result();
                $total_count = count(array_keys($row_count_));

                $cal = $limit  * $offset;

                $query = $this->db->query("SELECT p.*, w.discount_price FROM `product` as p 
                                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                                    WHERE p.status != '9' AND w.status != '9' AND w.discount_price != '' AND p.category_id = '$category_id' AND p.brand_id IN ($brand_id) GROUP BY p.id LIMIT $limit OFFSET $cal");
                $result = $query->result();

                if($query -> num_rows > 0){

                    $response['success'] = "1";
                    $response['message'] = "Product list";
                    $response["count"] = $total_count;
                    $response["data"] = array();
                    $counter = 0;

                    foreach($result as $row)
                    {
                        $product_id = $row->id;

                        $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_weight_result = $product_weight_query->result();

                        $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_image_result = $product_image_query->result();

                        $new_array_product_weight = array();
                        foreach ($product_weight_result as $pro_weight) {

                            $weight_id = $pro_weight->weight_id;

                            $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                            $weight_result = $weight_query->row_array();
                            $weight_name = $weight_result['name'];

                            if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }elseif(isset($_REQUEST['device_id']) && $_REQUEST['user_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }
                            elseif(isset($_REQUEST['user_id']) && $_REQUEST['device_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }else{
                                $my_cart_result = array();
                            }

                            if(empty($my_cart_result)){
                                $my_cart_quantity = '0';
                            }else{
                                $my_cart_quantity = $my_cart_result['quantity'];
                            }

                            $data = array(
                                'id' => $pro_weight->id,
                                'product_id' => $pro_weight->product_id,
                                'weight_id' => $pro_weight->weight_id,
                                'unit' => $pro_weight->weight_no.' '.$weight_name,
                                'actual_price' => $pro_weight->price,
                                'quantity' => $pro_weight->quantity,
                                'discount_per' => $pro_weight->discount_per,
                                'discount_price' => $pro_weight->discount_price,
                                'my_cart_quantity' => $my_cart_quantity
                            );
                            array_push($new_array_product_weight,$data);
                        }
                        $product_weight_array = $new_array_product_weight;

                        $new_array_product_image = array();
                        foreach ($product_image_result as $pro_image) {
                            $data = array(
                                'id' => $pro_image->id,
                                'product_id' => $pro_image->product_id,
                                'image' => base_url().'public/images/product_image/'.$pro_image->image,
                                'thumb_image' => base_url().'public/images/product_image_thumb/'.$pro_image->image,
                            );
                            array_push($new_array_product_image,$data);
                        }
                        $product_image_array = $new_array_product_image;

                        $data = array();
                        $data['id'] = $row->id;
                        $data['category_id'] = $row->category_id;
                        $data['brand_id'] = $row->brand_id;
                        $data['name'] = $row->name;
                        $data['image'] = base_url().'public/images/product/'.$row->image;
                        $data['image_thumb'] = base_url().'public/images/product_thumb/'.$row->image;
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
                }

                else{

                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "No record found";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }

            elseif(isset($discount_id) && $discount_id != ''){

                $price_query = $this->db->query("SELECT * FROM discount WHERE id IN ($discount_id) AND status != '9'");
                $price_result = $price_query->result();

                $start_discount = current($price_result)->start_discount;
                $end_discount = end($price_result)->end_discount;

                $result_count = $this->db->query("SELECT p.*, w.discount_price FROM `product` as p 
                                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                                    WHERE p.status != '9' AND w.status != '9' AND w.discount_price != '' AND p.category_id = '$category_id' AND (w.discount_per >= $start_discount AND w.discount_per <= $end_discount) GROUP BY p.id");
                $row_count_ = $result_count->result();
                $total_count = count(array_keys($row_count_));

                $cal = $limit  * $offset;

                $query = $this->db->query("SELECT p.*, w.discount_price FROM `product` as p 
                                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                                    WHERE p.status != '9' AND w.status != '9' AND w.discount_price != '' AND p.category_id = '$category_id' AND (w.discount_per >= $start_discount AND w.discount_per <= $end_discount) GROUP BY p.id ORDER BY p.id DESC LIMIT $limit OFFSET $cal");
                $result = $query->result();

                if($query -> num_rows > 0){

                    $response['success'] = "1";
                    $response['message'] = "Product list";
                    $response["count"] = $total_count;
                    $response["data"] = array();
                    $counter = 0;

                    foreach($result as $row)
                    {
                        $product_id = $row->id;

                        $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_weight_result = $product_weight_query->result();

                        $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_image_result = $product_image_query->result();

                        $new_array_product_weight = array();
                        foreach ($product_weight_result as $pro_weight) {

                            $weight_id = $pro_weight->weight_id;

                            $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                            $weight_result = $weight_query->row_array();
                            $weight_name = $weight_result['name'];

                            if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }elseif(isset($_REQUEST['device_id']) && $_REQUEST['user_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }
                            elseif(isset($_REQUEST['user_id']) && $_REQUEST['device_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }else{
                                $my_cart_result = array();
                            }

                            if(empty($my_cart_result)){
                                $my_cart_quantity = '0';
                            }else{
                                $my_cart_quantity = $my_cart_result['quantity'];
                            }

                            $data = array(
                                'id' => $pro_weight->id,
                                'product_id' => $pro_weight->product_id,
                                'weight_id' => $pro_weight->weight_id,
                                'unit' => $pro_weight->weight_no.' '.$weight_name,
                                'actual_price' => $pro_weight->price,
                                'quantity' => $pro_weight->quantity,
                                'discount_per' => $pro_weight->discount_per,
                                'discount_price' => $pro_weight->discount_price,
                                'my_cart_quantity' => $my_cart_quantity
                            );
                            array_push($new_array_product_weight,$data);
                        }
                        $product_weight_array = $new_array_product_weight;

                        $new_array_product_image = array();
                        foreach ($product_image_result as $pro_image) {
                            $data = array(
                                'id' => $pro_image->id,
                                'product_id' => $pro_image->product_id,
                                'image' => base_url().'public/images/product_image/'.$pro_image->image,
                                'thumb_image' => base_url().'public/images/product_image_thumb/'.$pro_image->image,
                            );
                            array_push($new_array_product_image,$data);
                        }
                        $product_image_array = $new_array_product_image;

                        $data = array();
                        $data['id'] = $row->id;
                        $data['category_id'] = $row->category_id;
                        $data['brand_id'] = $row->brand_id;
                        $data['name'] = $row->name;
                        $data['image'] = base_url().'public/images/product/'.$row->image;
                        $data['image_thumb'] = base_url().'public/images/product_thumb/'.$row->image;
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
                }

                else{

                    $response = array();
                    $response ["success"] = 0;
                    $response ["message"] = "No record found";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }

            else{
                if(isset($_POST['category_id']) && isset($_POST['user_id'])){

        $query = $this->db->query("SELECT p.*, w.discount_price FROM `product` as p 
                                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                                    WHERE p.status != '9' AND w.status != '9' AND w.discount_price != '' AND p.category_id = '$category_id' GROUP BY p.id ORDER BY p.id DESC");
            $result = $query->result();

                if($query -> num_rows > 0){

                    $response['success'] = "1";
                    $response['message'] = "Product list";
                    $response["count"] = $total_count;
                    $response["data"] = array();
                    $counter = 0;

                    foreach($result as $row)
                    {
                        $product_id = $row->id;

                        $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_weight_result = $product_weight_query->result();

                        $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                        $product_image_result = $product_image_query->result();

                        $new_array_product_weight = array();
                        foreach ($product_weight_result as $pro_weight) {

                            $weight_id = $pro_weight->weight_id;

                            $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                            $weight_result = $weight_query->row_array();
                            $weight_name = $weight_result['name'];

                            if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }elseif(isset($_REQUEST['device_id']) && $_REQUEST['user_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }
                            elseif(isset($_REQUEST['user_id']) && $_REQUEST['device_id'] == ''){

                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                                $my_cart_result = $my_cart_query->row_array();

                            }else{
                                $my_cart_result = array();
                            }

                            if(empty($my_cart_result)){
                                $my_cart_quantity = '0';
                            }else{
                                $my_cart_quantity = $my_cart_result['quantity'];
                            }

                            $data = array(
                                'id' => $pro_weight->id,
                                'product_id' => $pro_weight->product_id,
                                'weight_id' => $pro_weight->weight_id,
                                'unit' => $pro_weight->weight_no.' '.$weight_name,
                                'actual_price' => $pro_weight->price,
                                'quantity' => $pro_weight->quantity,
                                'discount_per' => $pro_weight->discount_per,
                                'discount_price' => $pro_weight->discount_price,
                                'my_cart_quantity' => $my_cart_quantity
                            );
                            array_push($new_array_product_weight,$data);
                        }
                        $product_weight_array = $new_array_product_weight;

                        $new_array_product_image = array();
                        foreach ($product_image_result as $pro_image) {
                            $data = array(
                                'id' => $pro_image->id,
                                'product_id' => $pro_image->product_id,
                                'image' => base_url().'public/images/product_image/'.$pro_image->image,
                                'thumb_image' => base_url().'public/images/product_image_thumb/'.$pro_image->image,
                            );
                            array_push($new_array_product_image,$data);
                        }
                        $product_image_array = $new_array_product_image;

                        $data = array();
                        $data['id'] = $row->id;
                        $data['category_id'] = $row->category_id;
                        $data['brand_id'] = $row->brand_id;
                        $data['name'] = $row->name;
                        $data['image'] = base_url().'public/images/product/'.$row->image;
                        $data['image_thumb'] = base_url().'public/images/product_thumb/'.$row->image;
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
                    die;
                }

                
                }else{
                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "Invalid data";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
                }
              
            }
        }
    }

    ## Product Search ##
    public function product_search()
    {
        $limit = '5';
        $offset= $_REQUEST['offset'];
        $product_name = $_REQUEST['product_name'];
        $user_id = $_REQUEST['user_id'];
        $device_id = $_REQUEST['device_id'];

        if(isset($product_name) && $product_name != ''){

            $result_count = $this->db->query("SELECT p.* FROM `product` as p 
                                            LEFT JOIN product_weight as w ON w.product_id = p.id
                                            WHERE p.status != '9' AND w.discount_price != '' AND w.status != '9' AND p.name LIKE '%$product_name%' GROUP BY p.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2))");
            $row_count_ = $result_count->result();
            $total_count = count(array_keys($row_count_));

            $cal = $limit  * $offset;

            $query = $this->db->query("SELECT p.* FROM `product` as p 
                                    LEFT JOIN product_weight as w ON w.product_id = p.id
                                    WHERE p.status != '9' AND w.discount_price != '' AND w.status != '9' AND p.name LIKE '%$product_name%' GROUP BY p.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2)) ASC LIMIT $limit OFFSET $cal");
            $result = $query->result();

            if($query -> num_rows > 0){

                $response['success'] = "1";
                $response['message'] = "Product list";
                $response["count"] = $total_count;
                $response["data"] = array();
                $counter = 0;

                foreach($result as $row)
                {

                    $product_id = $row->id;
                    $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                    $product_weight_result = $product_weight_query->result();

                    $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id' ORDER BY id DESC");
                    $product_image_result = $product_image_query->result();

                    $new_array_product_weight = array();
                    foreach ($product_weight_result as $pro_weight) {

                        $weight_id = $pro_weight->weight_id;
                        $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                        $weight_result = $weight_query->row_array();
                        $weight_name = $weight_result['name'];

                        if(isset($_REQUEST['user_id']) && isset($_REQUEST['device_id'])){

                            $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                            $my_cart_result = $my_cart_query->row_array();

                        }elseif(isset($_REQUEST['device_id']) && $_REQUEST['user_id'] == ''){

                            $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                            $my_cart_result = $my_cart_query->row_array();

                        }
                        elseif(isset($_REQUEST['user_id']) && $_REQUEST['device_id'] == ''){

                            $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND (user_id = '$user_id' OR device_id = '$device_id')");
                            $my_cart_result = $my_cart_query->row_array();

                        }else{
                            $my_cart_result = array();
                        }

                        if(empty($my_cart_result)){
                            $my_cart_quantity = '0';
                        }else{
                            $my_cart_quantity = $my_cart_result['quantity'];
                        }

                        $data = array(
                            'id' => $pro_weight->id,
                            'product_id' => $pro_weight->product_id,
                            'weight_id' => $pro_weight->weight_id,
                            'unit' => floor($pro_weight->weight_no).' '.$weight_name,
                            'actual_price' => $pro_weight->price,
                            'quantity' => $pro_weight->quantity,
                            'discount_per' => $pro_weight->discount_per,
                            'discount_price' => $pro_weight->discount_price,
                            'my_cart_quantity' => $my_cart_quantity
                        );
                        array_push($new_array_product_weight,$data);
                    }
                    $product_weight_array = $new_array_product_weight;

                    $new_array_product_image = array();
                    foreach ($product_image_result as $pro_image) {
                        $data = array(
                            'id' => $pro_image->id,
                            'product_id' => $pro_image->product_id,
                            'image' => base_url().'public/images/product_image/'.$pro_image->image,
                            'thumb_image' => base_url().'public/images/product_image_thumb/'.$pro_image->image,
                        );
                        array_push($new_array_product_image,$data);
                    }
                    $product_image_array = $new_array_product_image;

                    $data = array();
                    $data['id'] = $row->id;
                    $data['category_id'] = $row->category_id;
                    $data['brand_id'] = $row->brand_id;
                    $data['name'] = $row->name;
                    $data['image'] = base_url().'public/images/product/'.$row->image;
                    $data['image_thumb'] = base_url().'public/images/product_thumb/'.$row->image;
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
            }else{

                $response = array();
                $response ["success"] = 0;
                $response ["message"] = "No record found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }
        else{

            $response = array();
            $response ["success"] = 0;
            $response ["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }
}