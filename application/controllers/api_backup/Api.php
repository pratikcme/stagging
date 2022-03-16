<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("HTTP/1.1 200 OK");
class Api extends Apiuser_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('api_model', 'this_model');
        if (!isset($_POST['vendor_id']) || $_POST['vendor_id'] == "" || $_POST['vendor_id'] == '""') {
            $_POST['vendor_id'] = '1';
        }
        if (!isset($_GET['vendor_id']) || $_GET['vendor_id'] == "" || $_GET['vendor_id'] == '""') {
            $_GET['vendor_id'] = '1';
        }
    }
    public function appDetails(){
        $data['android_version'] = '1.0.1';
        $data['ios_version'] = '1.0.0';
        $data['android_isforce'] = '0';
        $data['ios_isforce'] = '0';
        
        $response = array('success' => '1', 'message' => 'Application Details', 'data' => $data);
        echo json_encode($response);die;
        
    }
    public function check_branch() {
        $result = $this->this_model->check_branch();
        $response = array('success' => '1', 'message' => 'Approved Branch', 'data' => $result);
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
        echo json_encode($return);
        exit;
    }
    public function vendor_category_list() {
        $return = $this->this_model->category_list($this->input->post());
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
    ## User Register ##
    public function user_register() {
        if (isset($_POST['fname']) && isset($_POST['login_type'])) {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            if (isset($_POST['device_id'])) {
                $device_id = $_POST['device_id'];
            }
            $login_type = $_POST['login_type'];
            $password = $_POST['password'];
            if (isset($_POST['facebook_token_id'])) {
                $facebook_token_id = $_POST['facebook_token_id'];
            }
            if (isset($_POST['gmail_token_id'])) {
                $gmail_token_id = $_POST['gmail_token_id'];
            }
            if (isset($_POST['apple_token_id'])) {
                $apple_token_id = $_POST['apple_token_id'];
            }
            /* Normal */
            if ($login_type == '0') {
                if (isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['lname'])) {
                    $email_query = $this->db->query("SELECT * FROM user WHERE email = '$email'");
                    $email_result = $email_query->row_array();
                    if ($email_query->num_rows() > 0) {
                        $response["success"] = 0;
                        $response["message"] = "Email is already registered";
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                        exit();
                    } else {
                        $token = md5($this->utility->encode($postData['email']));
                        $data = array('fname' => $fname, 'lname' => $lname, 'email' => $email, 'password' => md5($password), 'login_type' => $login_type, 'phone' => $phone, 'status' => '1', 'email_token' => $token, 'dt_added' => strtotime(date('Y-m-d H:i:s')), 'dt_updated' => strtotime(date('Y-m-d H:i:s')),);
                        $this->db->insert('user', $data);
                        $userId = $this->db->insert_id();
                        $userDetail = ['id' => $userId, 'token' => $token];
                        $finalUserdetail = $this->utility->encode(json_encode($userDetail));
                        $datas['name'] = $postData['name'];
                        $datas['link'] = base_url() . "api/verifyAccount/" . $finalUserdetail;
                        $datas['message'] = $this->load->view('emailTemplate/registration_mail', $datas, true);
                        $datas['subject'] = 'Verify user email address';
                        $datas["to"] = $email;
                        // print_r($datas);die;
                        $res = $this->sendMailSMTP($datas);
                        if ($res) {
                            $response["success"] = 1;
                            $response["message"] = "Please verify your email";
                        } else {
                            $response["success"] = 0;
                            $response["message"] = "Please enter valid email address";
                        }
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                        exit();
                    }
                } else {
                    $response = array();
                    $response["success"] = 0;
                    $response["message"] = "Invalid data";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }
            /* Facebook */
            elseif ($login_type == '1') {
                $facebook_query = $this->db->query("SELECT * FROM user WHERE facebook_token_id = '$facebook_token_id'");
                if ($facebook_query->num_rows() > 0) {
                    $facebook_query = $facebook_query->result() [0];
                    $user_id = $facebook_query->id;
                    $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE ( mc.user_id= '$user_id' OR mc.device_id= '$device_id') AND mc.status != '9' ORDER BY mc.id DESC");
                    $row_count = $result_count->result();
                    $total_count = $row_count[0]->total;
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "User Login Successfully";
                    $postdata = array('user_id' => $user_id, 'device_id' => $device_id,);
                    $this->set_user_cart($postdata);
                    $total_count = $this->this_model->get_total($postdata);
                    $data = array('id' => $facebook_query->id, 'fname' => $facebook_query->fname, 'lname' => $facebook_query->lname, 'email' => $facebook_query->email, 'phone' => $facebook_query->phone, 'login_type' => $facebook_query->login_type, 'cart_item' => $total_count[0]->cart_items,);
                    $login_check_result = array('id' => $facebook_query->id);
                    $this->this_model->update_device($login_check_result, $_POST);
                    $response["user_data"] = $data;
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                } else {
                    $data = array('fname' => $fname, 'lname' => $lname, 'email' => $email, 'phone' => $phone, 'login_type' => $login_type, 'facebook_token_id' => $facebook_token_id, 'status' => '1', 'dt_added' => strtotime(date('Y-m-d H:i:s')), 'dt_updated' => strtotime(date('Y-m-d H:i:s')),);
                    $checkuser = $this->this_model->check_register($email);
                    if ($checkuser == 1) {
                        $this->db->where('email', $email);
                        $this->db->update('user', $data);
                    } else {
                        $this->db->insert('user', $data);
                    }
                    $email_query = $this->db->query("SELECT * FROM user WHERE email = '$email'");
                    $lastId = $email_query->row_array();
                    $user_id = $lastId['id'];
                    $postdata = array('user_id' => $user_id, 'device_id' => $device_id,);
                    $notification_status = $this->this_model->notification_status($user_id);
                    $this->set_user_cart($postdata);
                    $total_count = $this->this_model->get_total($postdata);
                    $data1 = array('id' => $lastId['id'], 'fname' => $fname, 'lname' => $lname, 'email' => $email, 'phone' => $phone, 'login_type' => $login_type, 'cart_item' => $total_count[0]->cart_items, 'notification_status' => $notification_status);
                    $login_check_result = array('id' => $lastId['id']);
                    $this->this_model->update_device($login_check_result, $_POST);
                    $response["success"] = 1;
                    $response["message"] = "User registration successful";
                    $response["user_data"] = $data1;
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
                //                }
                
            }
            /* Gmail */
            elseif ($login_type == '2') {
                $gmail_query = $this->db->query("SELECT * FROM user WHERE gmail_token_id = '$gmail_token_id'");
                if ($gmail_query->num_rows() > 0) {
                    $gmail_query = $gmail_query->result() [0];
                    $user_id = $gmail_query->id;
                    $postdata = array('user_id' => $user_id, 'device_id' => $device_id,);
                    $this->set_user_cart($postdata);
                    $total_count = $this->this_model->get_total($postdata);
                    $notification_status = $this->this_model->notification_status($user_id);
                    $data = array('id' => $gmail_query->id, 'fname' => $gmail_query->fname, 'lname' => $gmail_query->lname, 'email' => $gmail_query->email, 'phone' => $gmail_query->phone, 'login_type' => $gmail_query->login_type, 'cart_item' => $total_count[0]->cart_items, 'notification_status' => $notification_status,);
                    $login_check_result = array('id' => $gmail_query->id);
                    $this->this_model->update_device($login_check_result, $_POST);
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "User Login Successfully";
                    $response["user_data"] = $data;
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                } else {
                    $data = array('fname' => $fname, 'lname' => $lname, 'email' => $email, 'phone' => $phone, 'login_type' => $login_type, 'gmail_token_id' => $gmail_token_id, 'status' => '1', 'dt_added' => strtotime(date('Y-m-d H:i:s')), 'dt_updated' => strtotime(date('Y-m-d H:i:s')),);
                    $checkuser = $this->this_model->check_register($email);
                    if ($checkuser == 1) {
                        $this->db->where('email', $email);
                        $this->db->update('user', $data);
                    } else {
                        $this->db->insert('user', $data);
                    }
                    $email_query = $this->db->query("SELECT * FROM user WHERE email = '$email'");
                    $lastId = $email_query->row_array();
                    $user_id = $lastId['id'];
                    $postdata = array('user_id' => $user_id, 'device_id' => $device_id,);
                    $notification_status = $this->this_model->notification_status($user_id);
                    $this->set_user_cart($postdata);
                    $total_count = $this->this_model->get_total($postdata);
                    $data1 = array('id' => (string)$lastId['id'], 'fname' => $fname, 'lname' => $lname, 'email' => $email, 'phone' => $phone, 'login_type' => $login_type, 'cart_item' => $total_count[0]->cart_items, 'notification_status' => $notification_status);
                    $login_check_result = array('id' => $lastId['id']);
                    $this->this_model->update_device($login_check_result, $_POST);
                    $response["success"] = 1;
                    $response["message"] = "User registration successful";
                    $response["user_data"] = $data1;
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
                //                }
                
            }
            /* apple */
            elseif ($login_type == '3') {
                $apple_query = $this->db->query("SELECT * FROM user WHERE apple_token_id = '$apple_token_id'");
                if ($apple_query->num_rows() > 0) {
                    $apple_query = $apple_query->result() [0];
                    $user_id = $apple_query->id;
                    $postdata = array('user_id' => $user_id, 'device_id' => $device_id,);
                    $this->set_user_cart($postdata);
                    $total_count = $this->this_model->get_total($postdata);
                    $notification_status = $this->this_model->notification_status($user_id);
                    $data = array('id' => $apple_query->id, 'fname' => $apple_query->fname, 'lname' => $apple_query->lname, 'email' => $apple_query->email, 'phone' => $apple_query->phone, 'login_type' => $apple_query->login_type, 'cart_item' => $total_count[0]->cart_items, 'notification_status' => $notification_status,);
                    $login_check_result = array('id' => $apple_query->id);
                    $this->this_model->update_device($login_check_result, $_POST);
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "User Login Successfully";
                    $response["user_data"] = $data;
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                } else {
                    $data = array('fname' => $fname, 'lname' => $lname, 'email' => $email, 'phone' => $phone, 'login_type' => $login_type, 'apple_token_id' => $apple_token_id, 'status' => '1', 'dt_added' => strtotime(date('Y-m-d H:i:s')), 'dt_updated' => strtotime(date('Y-m-d H:i:s')),);
                    $checkuser = $this->this_model->check_register($email);
                    if ($checkuser == 1) {
                        $this->db->where('email', $email);
                        $this->db->update('user', $data);
                    } else {
                        $this->db->insert('user', $data);
                    }
                    $email_query = $this->db->query("SELECT * FROM user WHERE email = '$email'");
                    $lastId = $email_query->row_array();
                    $user_id = $lastId['id'];
                    $postdata = array('user_id' => $user_id, 'device_id' => $device_id,);
                    $notification_status = $this->this_model->notification_status($user_id);
                    $this->set_user_cart($postdata);
                    $total_count = $this->this_model->get_total($postdata);
                    $data1 = array('id' => (string)$lastId['id'], 'fname' => $fname, 'lname' => $lname, 'email' => $email, 'phone' => $phone, 'login_type' => $login_type, 'cart_item' => $total_count[0]->cart_items, 'notification_status' => $notification_status);
                    $login_check_result = array('id' => $lastId['id']);
                    $this->this_model->update_device($login_check_result, $_POST);
                    $response["success"] = 1;
                    $response["message"] = "User registration successful";
                    $response["user_data"] = $data1;
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }
    ## User Login ##
    public function user_login() {
        if (isset($_POST['login_type'])) {
            $email = $_POST['email'];
            $device_id = $_POST['device_id'];
            $password = md5($_POST['password']);
            $login_type = $_POST['login_type'];
            if (isset($_POST['facebook_token_id'])) {
                $facebook_token_id = $_POST['facebook_token_id'];
            }
            if (isset($_POST['gmail_token_id'])) {
                $gmail_token_id = $_POST['gmail_token_id'];
            }
            if (isset($_POST['apple_token_id'])) {
                $apple_token_id = $_POST['apple_token_id'];
            }
            /* Normal User */
            if ($login_type == '0') {
                $login_check_query = $this->db->query("SELECT * FROM user WHERE email = '$email' AND password = '$password' ");
                $login_check_result = $login_check_query->row_array();
                if ($login_check_query->num_rows() > 0) {
                    if ($login_check_result['email_verify'] == '1') {
                        $user_id = $login_check_result['id'];
                        $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE ( mc.user_id= '$user_id' OR mc.device_id= '$device_id') AND mc.status != '9' ORDER BY mc.id DESC");
                        $row_count = $result_count->result();
                        $total_count = $row_count[0]->total;
                        $postdata = array('user_id' => $login_check_result['id'], 'device_id' => $device_id,);
                        $this->set_user_cart($postdata);
                        $total_count = $this->this_model->get_total($postdata);
                        $notification_status = $this->this_model->notification_status($login_check_result['id']);
                        $data = array('id' => $login_check_result['id'], 'fname' => $login_check_result['fname'], 'lname' => $login_check_result['lname'], 'email' => $login_check_result['email'], 'phone' => $login_check_result['phone'], 'user_gst_number' => ($login_check_result['user_gst_number'] == null) ? "" : $login_check_result['user_gst_number'], 'login_type' => $login_type, 'cart_item' => $total_count[0]->cart_items, 'notification_status' => $notification_status, 'mobile_verify' => $login_check_result['is_verify']);
                        $this->this_model->update_device($login_check_result, $_POST);
                        // print_r($data);die;
                        $response = array();
                        $response["success"] = 1;
                        $response["message"] = "Login Successfully";
                        $response["user_data"] = $data;
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                    } else {
                        $token = md5($this->utility->encode($login_check_result['email']));
                        $this->db->set('email_token', $token);
                        $this->db->where('id', $login_check_result['id']);
                        $this->db->update('user');
                        $userDetail = ['id' => $login_check_result['id'], 'token' => $token];
                        $finalUserdetail = $this->utility->encode(json_encode($userDetail));
                        $datas['name'] = $login_check_result['name'];
                        $datas['link'] = base_url() . "api/verifyAccount/" . $finalUserdetail;
                        $datas['message'] = $this->load->view('emailTemplate/registration_mail', $datas, true);
                        $datas['subject'] = 'Verify user email address';
                        $datas["to"] = $email;
                        // print_r($datas);die;
                        $res = $this->sendMailSMTP($datas);
                        $response = array();
                        $response["success"] = 0;
                        $response["message"] = "Please check your email for your account verification";
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                    }
                } else {
                    $response = array();
                    $response["success"] = 0;
                    $response["message"] = "Invalid email or password";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }
            /* Facebook */
            elseif ($login_type == '1') {
                $stream_options = array('http' => array('method' => 'GET'));
                $context = stream_context_create($stream_options);
                $token_id = $_POST['facebook_token_id'];
                $access_token = '917047018437389|d26f7aa135cadffaf26dd30282a7236d';
                $url = 'https://graph.facebook.com/debug_token?input_token=' . $token_id . '&access_token=' . $access_token;
                $response = file_get_contents($url, null, $context);
                $facebook_json = json_decode($response);
                $app_id = $facebook_json->data->user_id;
                $facebook_query = $this->db->query("SELECT * FROM user WHERE facebook_token_id = '$app_id' AND login_type = '1' ");
                $facebook_result = $facebook_query->row_array();
                if ($facebook_result['login_type'] == $login_type) {
                    if ($facebook_result['facebook_token_id'] == $app_id) {
                        $data = array('id' => $facebook_result['id'], 'fname' => $facebook_result['fname'], 'lname' => $facebook_result['lname'], 'email' => $facebook_result['email'], 'phone' => $facebook_result['phone'], 'user_gst_number' => ($login_check_result['user_gst_number'] == null) ? "" : $login_check_result['user_gst_number'], 'login_type' => $facebook_result['login_type']);
                        $this->this_model->update_device($facebook_result, $_POST);
                        $response = array();
                        $response["success"] = 1;
                        $response["message"] = "Login Successfully";
                        $response["user_data"] = $data;
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                    } else {
                        $response = array();
                        $response["success"] = 101;
                        $response["message"] = "Facebook login failed";
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                    }
                } else {
                    $response = array();
                    $response["success"] = 101;
                    $response["message"] = "Facebook login failed";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }
            /* Gmail */
            elseif ($login_type == '2') {
                $stream_options = array('http' => array('method' => 'GET',),);
                $context = stream_context_create($stream_options);
                $token_id = $_POST['gmail_token_id'];
                $url = 'https://www.googleapis.com/plus/v1/people/me?access_token=' . $token_id;
                $response = file_get_contents($url, null, $context);
                $facebook_json = json_decode($response);
                $app_id = $facebook_json->id;
                $gmail_query = $this->db->query("SELECT * FROM user WHERE gmail_token_id = '$app_id' AND login_type = '2'");
                $gmail_result = $gmail_query->row_array();
                if ($gmail_result['login_type'] == '2') {
                    if ($gmail_result['gmail_token_id'] == $app_id) {
                        $data = array('id' => $gmail_result['id'], 'fname' => $gmail_result['fname'], 'lname' => $gmail_result['lname'], 'email' => $gmail_result['email'], 'phone' => $gmail_result['phone'], 'user_gst_number' => ($login_check_result['user_gst_number'] == null) ? "" : $login_check_result['user_gst_number'], 'login_type' => $gmail_result['login_type']);
                        $this->this_model->update_device($gmail_result, $_POST);
                        $response = array();
                        $response["success"] = 1;
                        $response["message"] = "Login Successfully";
                        $response["user_data"] = $data;
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                    } else {
                        $response = array();
                        $response["success"] = 100;
                        $response["message"] = "Google+ login failed";
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                    }
                } else {
                    $response = array();
                    $response["success"] = 100;
                    $response["message"] = "Google+ login failed";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            } elseif ($login_type == '3') {
                $apple_query = $this->db->query("SELECT * FROM user WHERE apple_token_id = '$app_id' AND login_type = '3'");
                $apple_result = $apple_query->row_array();
                if ($apple_result['login_type'] == '3') {
                    if ($apple_result['apple_token_id'] == $app_id) {
                        $data = array('id' => $apple_result['id'], 'fname' => $apple_result['fname'], 'lname' => $apple_result['lname'], 'email' => $apple_result['email'], 'phone' => $apple_result['phone'], 'user_gst_number' => ($login_check_result['user_gst_number'] == null) ? "" : $login_check_result['user_gst_number'], 'login_type' => $apple_result['login_type']);
                        $this->this_model->update_device($apple_result, $_POST);
                        $response = array();
                        $response["success"] = 1;
                        $response["message"] = "Login Successfully";
                        $response["user_data"] = $data;
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                    } else {
                        $response = array();
                        $response["success"] = 100;
                        $response["message"] = "Apple login failed";
                        $output = json_encode(array('responsedata' => $response));
                        echo $output;
                    }
                } else {
                    $response = array();
                    $response["success"] = 100;
                    $response["message"] = "Apple login failed";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            }
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Please enter valid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
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
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $query = $this->db->query("SELECT COUNT(*) as total FROM user WHERE email = '$email'");
            $result = $query->row_array();
            if ($result['total'] > 0) {
                $this->load->helper('string');
                $ran_digit = random_string('alnum', 5);
                $ran_digit_md5 = md5($ran_digit);
                $where = array('email' => $email);
                $data = array('password' => $ran_digit_md5, 'dt_updated' => strtotime(date('Y-m-d H:i:s')));
                $this->db->where($where);
                $this->db->update('user', $data);
                $this->load->library('email');
                $config = Array('protocol' => 'smtp', 'smtp_host' => '162.241.86.206', 'smtp_port' => '587', 'smtp_user' => 'test@launchestore.com', 'smtp_pass' => 'HhZ~sU(@drk_', 'mailtype' => 'text', 'charset' => 'utf-8');
                //Mail Send
                $from_email = 'test@launchestore.com';
                $subject = 'Forgot Password';
                $message = 'Your New Password is : ' . $ran_digit;
                $this->email->initialize($config);
                $this->email->set_newline("\r\n");
                $this->email->from($from_email);
                $this->email->to($email);
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->send();
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
            $old_password = md5($_POST['old_password']);
            $new_password = md5($_POST['new_password']);
            $result_login = $this->db->query("select * from user where email='$email' ");
            $row_login = $result_login->row_array();
            if ($result_login->num_rows() > 0) {
                if ($old_password == $row_login['password']) {
                    $data_pass = array('password' => $new_password, 'dt_updated' => strtotime(date('Y-m-d H:i:s')));
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
        if (isset($_GET['fname']) && isset($_GET['lname']) && isset($_GET['email']) && isset($_GET['phone'])) {
            $fname = $_GET['fname'];
            $lname = $_GET['lname'];
            $email = $_GET['email'];
            $phone = $_GET['phone'];
            $user_gst_number = $_GET['user_gst_number'];
            $data_user = array('fname' => $fname, 'lname' => $lname, 'phone' => $phone, 'user_gst_number' => $user_gst_number, 'dt_updated' => strtotime(date('Y-m-d H:i:s')));
            $this->db->where('email', $email);
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
        // print_r(expression)
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
            $user_address_query = $this->db->query("SELECT * FROM user_address WHERE user_id = '$user_id' AND status != '9' ORDER BY id DESC");
            $user_address_result = $user_address_query->result();
            $address_array = '';
            $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE mc.status != '9' AND mc.user_id = '$user_id' ORDER BY mc.id DESC");
            $row_count = $result_count->result();
            $total_count = $row_count[0]->total;
            $my_cart_query = $this->db->query("SELECT mc.*  FROM my_cart as mc WHERE mc.status != '9' AND (mc.user_id = '$user_id' ) ORDER BY mc.id DESC");
            $my_cart_result = $my_cart_query->result();
            $my_cart_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND user_id = '$user_id'");
            $my_cart_price_result = $my_cart_price_query->row_array();
            $vendorId = $my_cart_result[0]->vendor_id;
            $vendor_query = $this->db->query("SELECT * FROM vendor WHERE id ='$vendorId'");
            $vendor_result = $vendor_query->result();
            $payment_method = $this->db->query("SELECT * FROM payment_method WHERE vendor_id ='$vendorId' AND status='1'");
            $p_method = $payment_method->result();
            // print_r($p_method);die;
            if ($p_method[0]->IsTestOrLive == '0') {
                $p_method[0]->publish_key = $p_method[0]->test_publish_key;
            }
            $vendorData = [];
            $vendorData['id'] = $vendor_result[0]->id;
            $vendorData['name'] = $vendor_result[0]->name;
            $vendorData['address'] = $vendor_result[0]->address;
            $vendorData['currency_code'] = $vendor_result[0]->currency_code;
            $vendorData['selfPickUp'] = $vendor_result[0]->selfPickUp;
            $vendorData['selfPickUp'] = $vendor_result[0]->selfPickUp;
            require_once 'vendor/autoload.php';
            $cryptor = new \RNCryptor\RNCryptor\Encryptor;
            $password = "BGV9UAw9wp5tT7I9wRcw%Xv!a@8aApqW";
            $vendorData['publish_key'] = ($p_method[0]->publish_key == null) ? '' : $cryptor->encrypt($p_method[0]->publish_key, $password);
            $vendorData['paymentMethod'] = ($p_method[0]->publish_key == null) ? '' : $p_method[0]->payment_opt;
            $cart_response["data"] = array();
            if ($my_cart_query->num_rows() > 0) {
                $cart_response['success'] = "1";
                $cart_response['message'] = "My cart item list";
                $cart_response["count"] = $total_count;
                $cart_response["total_price"] = number_format((float)$my_cart_price_result['total_price'], 2, '.', '');;
                $counter = 0;
                $vendor_id = $my_cart_result[0]->vendor_id;
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
                    $data['product_image'] = base_url() . 'public/images/product_image/' . $product_image_result[0]->image;
                    $data['product_image_thumb'] = base_url() . 'public/images/product_image_thumb/' . $product_image_result[0]->image;
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
            if ($query->num_rows() > 0) {
                $address_arr = [];
                if ($user_address_result) {
                    foreach ($user_address_result as $address) {
                        $get_charge = 'N';
                        if (isset($vendor_id)) {
                            $get_charge = $this->this_model->get_delivery_charge($address->latitude, $address->longitude, $vendor_id);
                        }
                        $data = array('id' => $address->id, 'address' => $address->address, 'user_id' => $address->user_id, 'latitude' => $address->latitude, 'longitude' => $address->longitude, 'name' => $address->name, 'pincode' => $address->pincode, 'landmark' => $address->landmark, 'city' => $address->city, 'state' => $address->state, 'country' => $address->country, 'phone' => $address->phone, 'delivery_charge' => $get_charge);
                        $address_arr[] = $data;
                    }
                    $address_array = $address_arr;
                } else {
                    $address_array = array();
                }
                // print_r($my_cart_price_result);die;
                $data_user = array('id' => $result['id'], 'fname' => $result['fname'], 'lname' => $result['lname'], 'email' => $result['email'], 'phone' => $result['phone'], 'status' => $result['status'], 'dt_added' => $result['dt_added'], 'dt_updated' => $result['dt_updated'], 'user_address_data' => $address_array, 'vendor_details' => $vendorData, 'cart_response' => $cart_response,);
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
        $query = $this->db->query("SELECT * FROM category WHERE status != '9' ORDER BY id DESC");
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
                $data['image'] = base_url() . 'public/images/category/' . $row->image;
                $data['image_thumb'] = base_url() . 'public/images/category_thumb/' . $row->image;
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
        if (isset($_POST['category_id']) && isset($_POST['vendor_id'])) {
            $this->this_model->get_product_list($this->input->post());
        }
    }
    public function product_detail() {
        // print_r($_POST);die;
        if (isset($_POST['product_id']) && isset($_POST['vendor_id'])) {
            $product_id = $_POST['product_id'];
            $category_id = $_POST['category_id'];
            $user_id = $_POST['user_id'];
            $device_id = $_POST['device_id'];
            $vendor_id = $_POST['vendor_id'];
            $result_count = $this->db->query("SELECT p.* FROM `product` as p 
        LEFT JOIN product_weight as w ON w.product_id = p.id
        WHERE p.status != '9' AND p.vendor_id = '$vendor_id'  AND w.status != '9' AND p.id = '$product_id' GROUP BY p.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2))");
            $row_count_ = $result_count->result();
            $total_count = count(array_keys($row_count_));
            // print_r($row_count_);die;
            $query = $this->db->query("SELECT p.* FROM `product` as p 
        LEFT JOIN product_weight as w ON w.product_id = p.id
        WHERE p.status != '9' AND p.vendor_id = '$vendor_id' AND w.discount_price != '' AND w.status != '9' AND p.id = '$product_id' GROUP BY p.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2))");
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
                    $product_weight_query = $this->db->query("SELECT * FROM product_weight WHERE status != '9' AND product_id = '$product_id'  AND vendor_id = '$vendor_id' ORDER BY id DESC");
                    $product_weight_result = $product_weight_query->result();
                    $new_array_product_weight = array();
                    foreach ($product_weight_result as $pro_weight) {
                        $package_id = $pro_weight->package;
                        $package_name = $this->this_model->get_package($package_id);
                        $product_weight_id = $pro_weight->id;
                        $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id'  AND product_variant_id = '$product_weight_id' AND vendor_id = '$vendor_id' ORDER BY id DESC");
                        $product_image_result = $product_image_query->result();
                        $weight_id = $pro_weight->weight_id;
                        $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                        $weight_result = $weight_query->row_array();
                        $weight_name = $weight_result['name'];
                        if (isset($_POST['user_id']) && $_POST['user_id'] != '') {
                            $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id'AND product_weight_id = '$product_weight_id' AND vendor_id = '$vendor_id' AND user_id = '$user_id'");
                            $my_cart_result = $my_cart_query->row_array();
                        } else {
                            if (isset($_POST['device_id'])) {
                                $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND product_weight_id = '$product_weight_id' AND vendor_id = '$vendor_id' AND (user_id = '0' AND device_id = '$device_id')");
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
                            $img[] = array('id' => $pro_image->id, 'product_id' => $pro_image->product_id, 'weight_id' => $pro_weight->weight_id, 'image' => base_url() . 'public/images/product_image/' . $pro_image->image, 'thumb_image' => base_url() . 'public/images/product_image_thumb/' . $pro_image->image,);
                        }
                        $data = array('id' => $pro_weight->id, 'product_id' => $pro_weight->product_id, 'weight_id' => $pro_weight->weight_id, 'unit' => ($pro_weight->weight_no) . ' ' . $weight_name, 'actual_price' => $pro_weight->price, 'quantity' => $pro_weight->quantity, 'package_name' => $package_name, 'discount_per' => $pro_weight->discount_per, 'discount_price' => $pro_weight->discount_price, 'my_cart_quantity' => $my_cart_quantity, 'variant_images' => $img,);
                        array_push($new_array_product_weight, $data);
                    }
                    $product_weight_array = $new_array_product_weight;
                    $new_array_product_image = array();
                    $proimg = $product_image_result[0]->image;
                    $prothimg = $product_image_result[0]->image;
                    $product_image_array = $new_array_product_image;
                    $data = array();
                    $data['id'] = $row->id;
                    $data['category_id'] = $row->category_id;
                    $data['brand_id'] = $row->brand_id;
                    $data['name'] = $row->name;
                    $data['image'] = base_url() . 'public/images/product_image/' . $proimg;
                    $data['image_thumb'] = base_url() . 'public/images/product_image_thumb/' . $prothimg;
                    $data['about'] = $row->about;
                    $data['content'] = $row->content;
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
        $result_count = $this->db->query("SELECT COUNT(*) as total FROM time_slot WHERE status != '9'");
        $row_count = $result_count->result();
        $query = $this->db->query("SELECT * FROM time_slot WHERE status != '9' ORDER BY id DESC");
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
        if (!empty($this->input->post('vendor_id'))) {
            $vendor_id = $this->input->post('vendor_id');
            $query = $this->db->query("SELECT * FROM banner_promotion WHERE vendor_id = '$vendor_id' AND status != '9' ORDER BY image_order ");
        } else {
            $query = $this->db->query("SELECT * FROM banner_promotion WHERE  status != '9' ORDER BY image_order ");
        }
        $result = $query->result();
        if ($query->num_rows() > 0) {
            $response['success'] = "1";
            $response['message'] = "Banner promotion list";
            $response["data"] = array();
            $counter = 0;
            foreach ($result as $row) {
                $data = array();
                $data['id'] = $row->id;
                $data['vendor_id'] = $row->vendor_id;
                $data['product_id'] = $row->product_id;
                $data['image'] = base_url() . 'public/images/banner_promotion/' . $row->image;
                $data['image_thumb'] = base_url() . 'public/images/banner_promotion_thumb/' . $row->image;
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
    ## Brand List ##
    public function brand_list() {
        if (isset($_POST['category_id'])) {
            // $limit = '5';
            // $offset= $_POST['offset'];
            $category_id = $_POST['category_id'];
            $result_count = $this->db->query("SELECT COUNT(*) as total FROM brand WHERE status != '9' AND category_id = '$category_id'");
            $row_count = $result_count->result();
            $total_count = $row_count[0]->total;
            // $cal = $limit  * $offset;
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
    public function add_to_cart_old() {}
    ## Add To Cart  - Single Product ##
    function check_cart($postdata) {
        // print_r($postdata);
        $qnt = $postdata['quantity'];
        $variant_id = $postdata['product_weight_id'];
        $result = $this->this_model->check_quantity($qnt, $variant_id);
        if (isset($postdata['user_id']) && $postdata['user_id'] != '') {
            $user_id = $postdata['user_id'];
            $device_id = $postdata['device_id'];
            $check = $this->db->query("SELECT * FROM my_cart WHERE user_id = '$user_id'");
        } else {
            if (isset($postdata['device_id'])) {
                $device_id = $postdata['device_id'];
                $u = 0;
                $check = $this->db->query("SELECT * FROM my_cart WHERE device_id = '$device_id' AND user_id = '0'");
            }
        }
        // echo $this->db->last_query();exit;
        if ($check->num_rows() > 0) {
            $check = $check->result();
            $cart_vendor = $check[0]->vendor_id;
            $vendor_id = $postdata['vendor_id'];
            if ($cart_vendor != $vendor_id) {
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
        if (isset($_POST['product_id']) && isset($_POST['weight_id']) && isset($_POST['product_weight_id']) && isset($_POST['quantity']) && isset($_POST['vendor_id'])) {
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
        $my_cal = (float)$gettotal[0]->total;
        if ($my_cal === null || $my_cal == "<null>") {
            $my_cal = 0.0;
        }
        if ($getactual === null || $getactual == "<null>") {
            $getactual = 0.0;
        }
        $response["count"] = (int)$gettotal[0]->cart_items;
        $response["actual_price"] = $getactual;
        $response["discount_price"] = number_format((float)$getactual - $my_cal, 2, '.', '');
        $response["total_price"] = number_format((float)$my_cal, 2, '.', '');
        $response["TotalGstAmount"] = number_format((float)$total_gst, 2, '.', '');
        $response["amountWithoutGst"] = number_format((float)$my_cal - $total_gst, 2, '.', '');;
        $output = json_encode(array('responsedata' => $response));
        echo $output;
        exit;
    }
    public function add_to_cart_devlop() {}
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
            // echo $this->db->last_query();exit;
            $response = array();
            $response["success"] = 1;
            $response["message"] = "Cart deleted";
            $output = json_encode(array('responsedata' => $response));
            $responce = $output;
            $error = 0;
        } else {
            if (isset($_POST['device_id']) && $_POST['device_id'] != '') {
                $device_id = $_POST['device_id'];
                $this->db->query("DELETE FROM my_cart WHERE device_id = '$device_id' AND user_id = '0'");
                // echo $this->db->last_query();exit;
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
        $this->this_model->my_cart($this->input->post());
    }
    public function my_cart_old() {}
    ## Delete My Cart Item ##
    public function delete_my_cart_item() {
        if (isset($_POST['product_id']) && isset($_POST['product_weight_id']) && isset($_POST['vendor_id'])) {
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
    public function delete_my_cart_item_old() {
        if (isset($_POST['product_id']) && isset($_POST['product_weight_id']) && isset($_POST['vendor_id'])) {
            $weight_id = $_POST['weight_id'];
            $product_id = $_POST['product_id'];
            $user_id = $_POST['user_id'];
            $device_id = $_POST['device_id'];
            $product_weight_id = $_POST['product_weight_id'];
            $vendor_id = $_POST['vendor_id'];
            $product_actual_price = 0;
            $discount_price_total = 0;
            $product_discount_price = 0;
            $my_cal = 0;
            $product_calculation_price = 0;
            if (isset($user_id) && $user_id != '') {
                $this->db->query("DELETE FROM my_cart WHERE product_id = '$product_id'  AND vendor_id = '$vendor_id' AND product_weight_id = '$product_weight_id' AND user_id IN ('$user_id'))");
                $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE mc.user_id IN ('$user_id')) AND mc.vendor_id = '$vendor_id' AND mc.status != '9' ORDER BY mc.id DESC");
                $row_count = $result_count->result();
                $total_count = $row_count[0]->total;
                $my_cart_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND vendor_id = '$vendor_id' AND user_id = '$user_id'");
                $my_cart_price_result = $my_cart_price_query->row_array();
                // $setresponce = $this->db->query("SELECT * FROM my_cart WHERE (device_id IN ('$device_id') OR user_id IN ('$user_id')) AND status !='9'");
                // $setresponce = $setresponce->result();
                // $cart_count = 0;
                // foreach ($setresponce as $key => $value) {
                //     $cart_count ++;
                //     $product_actual_price = $value->actual_price*$value->quantity+$product_actual_price;
                //     $product_calculation_price = $value->calculation_price*$value->quantity+$product_calculation_price;
                //     $discount_price_total = ($product_actual_price*$value->quantity)-$value->calculation_price+$discount_price_total;
                // }
                // $product_discount_price = $product_calculation_price-$product_actual_price;
                // $dp = $product_actual_price - $product_discount_price;
                $setresponce = $this->db->query("SELECT * FROM my_cart WHERE (device_id IN ('$device_id') OR user_id IN ('$user_id')) AND vendor_id = '$vendor_id' AND status !='9'");
                $setresponce = $setresponce->result();
                $cart_count = 0;
                foreach ($setresponce as $key => $value) {
                    $cart_count++;
                    $product_actual_price = $value->actual_price * $value->quantity + $product_actual_price;
                    $my_cal = $value->calculation_price + $my_cal;
                    $product_calculation_price = $value->calculation_price * $value->quantity + $product_calculation_price;
                    // $discount_price_total = ($product_actual_price*$value->quantity)-$value->calculation_price+$discount_price_total;
                    $discount_price_total = ($product_actual_price * $value->quantity) + $discount_price_total;
                }
                // echo $product_actual_price.','.$product_calculation_price;exit;
                $product_discount_price = $my_cal - $product_actual_price;
                $dis = $product_actual_price - $my_cal;
                $dp = $product_actual_price - $product_discount_price;
                // $response = array();
                // $response ["success"] = 1;
                // $response ["message"] = "Product has been updated in your cart";
                $response = array();
                $response["success"] = 1;
                $response["message"] = "Item has been deleted successfully from your cart";
                $gettotal = $this->this_model->get_total($_POST);
                $my_cal = (float)$gettotal[0]->total;
                if ($my_cal === null || $my_cal == "<null>") {
                    $my_cal = 0.0;
                }
                if ($product_actual_price === null || $product_actual_price == "<null>") {
                    $product_actual_price = 0.0;
                }
                $response["count"] = (int)$gettotal[0]->cart_items;
                $getactual = $this->this_model->get_actual_total($_POST);
                $response["actual_price"] = $getactual;
                $response["discount_price"] = $getactual - $my_cal;
                $response["total_price"] = $my_cal;
                // $response["total_price"] = number_format((float)$my_cart_price_result['total_price'], 2, '.', '');;
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            } else {
                if ($device_id && $device_id != '') {
                    /*$where = array( 'product_id' => $product_id, 'weight_id' => $weight_id, 'device_id' => $device_id );
                    $this->db->where($where);
                    $this->db->delete('my_cart');*/
                    $this->db->query("DELETE FROM my_cart WHERE product_id = '$product_id' AND vendor_id = '$vendor_id' AND product_weight_id = '$product_weight_id' AND (device_id IN ('$device_id') AND user_id = '0' )");
                    $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE (mc.device_id IN ('$device_id') OR mc.user_id IN ('$user_id')) AND mc.vendor_id = '$vendor_id' AND mc.status != '9' ORDER BY mc.id DESC");
                    $row_count = $result_count->result();
                    $total_count = $row_count[0]->total;
                    $my_cart_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND vendor_id = '$vendor_id' AND (device_id IN ('$device_id') OR user_id IN ('$user_id'))");
                    $my_cart_price_result = $my_cart_price_query->row_array();
                    $setresponce = $this->db->query("SELECT * FROM my_cart WHERE (device_id IN ('$device_id') OR user_id IN ('$user_id')) AND vendor_id = '$vendor_id' AND status !='9'");
                    $setresponce = $setresponce->result();
                    $cart_count = 0;
                    foreach ($setresponce as $key => $value) {
                        $cart_count++;
                        $product_actual_price = $value->actual_price * $value->quantity + $product_actual_price;
                        $my_cal = $value->calculation_price + $my_cal;
                        $product_calculation_price = $value->calculation_price * $value->quantity + $product_calculation_price;
                        // $discount_price_total = ($product_actual_price*$value->quantity)-$value->calculation_price+$discount_price_total;
                        $discount_price_total = ($product_actual_price * $value->quantity) + $discount_price_total;
                    }
                    // echo $product_actual_price.','.$product_calculation_price;exit;
                    $product_discount_price = $my_cal - $product_actual_price;
                    $dis = $product_actual_price - $my_cal;
                    $dp = $product_actual_price - $product_discount_price;
                    // $response = array();
                    // $response ["success"] = 1;
                    // $response ["message"] = "Product has been updated in your cart";
                    $gettotal = $this->this_model->get_total($_POST);
                    $my_cal = (float)$gettotal[0]->total;
                    if ($my_cal === null || $my_cal == "<null>") {
                        $my_cal = 0.0;
                    }
                    if ($product_actual_price === null || $product_actual_price == "<null>") {
                        $product_actual_price = 0.0;
                    }
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Item has been deleted successfully from your cart";
                    $gettotal = $this->this_model->get_total($_POST);
                    $my_cal = (float)$gettotal[0]->total;
                    if ($my_cal === null || $my_cal == "<null>") {
                        $my_cal = 0.0;
                    }
                    if ($product_actual_price === null || $product_actual_price == "<null>") {
                        $product_actual_price = 0.0;
                    }
                    $response["count"] = (int)$gettotal[0]->cart_items;
                    $getactual = $this->this_model->get_actual_total($_POST);
                    $response["actual_price"] = $getactual;
                    $response["discount_price"] = $getactual - $my_cal;
                    $response["total_price"] = $my_cal;
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                } elseif ($user_id && $user_id != '') {
                    /*$where = array( 'product_id' => $product_id, 'weight_id' => $weight_id, 'user_id' => $user_id );
                    $this->db->where($where);
                    $this->db->delete('my_cart');*/
                    $this->db->query("DELETE FROM my_cart WHERE product_id = '$product_id' AND product_weight_id = '$product_weight_id' AND vendor_id = '$vendor_id' AND (device_id IN ('$device_id') OR user_id IN ('$user_id'))");
                    $result_count = $this->db->query("SELECT COUNT(*) as total  FROM my_cart as mc WHERE mc.user_id = '$user_id' AND mc.vendor_id = '$vendor_id' AND mc.status != '9' ORDER BY mc.id DESC");
                    $row_count = $result_count->result();
                    $total_count = $row_count[0]->total;
                    $my_cart_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from my_cart WHERE status != '9' AND vendor_id = '$vendor_id' AND user_id = '$user_id'");
                    $my_cart_price_result = $my_cart_price_query->row_array();
                    $setresponce = $this->db->query("SELECT * FROM my_cart WHERE (device_id IN ('$device_id') OR user_id IN ('$user_id')) AND vendor_id = '$vendor_id' AND status !='9'");
                    $setresponce = $setresponce->result();
                    $cart_count = 0;
                    foreach ($setresponce as $key => $value) {
                        $cart_count++;
                        $product_actual_price = $value->actual_price * $value->quantity + $product_actual_price;
                        $my_cal = $value->calculation_price + $my_cal;
                        $product_calculation_price = $value->calculation_price * $value->quantity + $product_calculation_price;
                        // $discount_price_total = ($product_actual_price*$value->quantity)-$value->calculation_price+$discount_price_total;
                        $discount_price_total = ($product_actual_price * $value->quantity) + $discount_price_total;
                    }
                    // echo $product_actual_price.','.$product_calculation_price;exit;
                    $product_discount_price = $my_cal - $product_actual_price;
                    $dis = $product_actual_price - $my_cal;
                    $dp = $product_actual_price - $product_discount_price;
                    // $response = array();
                    // $response ["success"] = 1;
                    // $response ["message"] = "Product has been updated in your cart";
                    $gettotal = $this->this_model->get_total($_POST);
                    $my_cal = (float)$gettotal[0]->total;
                    if ($my_cal === null || $my_cal == "<null>") {
                        $my_cal = 0.0;
                    }
                    if ($product_actual_price === null || $product_actual_price == "<null>") {
                        $product_actual_price = 0.0;
                    }
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Item has been deleted successfully from your cart";
                    $gettotal = $this->this_model->get_total($_POST);
                    $my_cal = (float)$gettotal[0]->total;
                    if ($my_cal === null || $my_cal == "<null>") {
                        $my_cal = 0.0;
                    }
                    if ($product_actual_price === null || $product_actual_price == "<null>") {
                        $product_actual_price = 0.0;
                    }
                    $response["count"] = (int)$gettotal[0]->cart_items;
                    $getactual = $this->this_model->get_actual_total($_POST);
                    $response["actual_price"] = $getactual;
                    $response["discount_price"] = $getactual - $my_cal;
                    $response["total_price"] = $my_cal;
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
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Invalid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }
    ## Checkout ##
    public function checkout() {
        // date_default_timezone_set('Asia/Kolkata');
        // print_r($_POST);die;
        $user_id = $_POST['user_id'];
        if (isset($_POST['user_address_id'])) {
            $user_address_id = $_POST['user_address_id'];
        }
        $payment_type = $_POST['payment_type'];
        $user_gst_number = $_POST['user_gst_number'];
        $time_slot_id = $_POST['time_slot_id'];
        $vendor_id = $_POST['vendor_id'];
        $delivery_charge = $_POST['delivery_charge'];
        $paymentMethod = $_POST['paymentMethod'];
        $transaction_id = $_POST['payment_transaction_id'];
        $isSelfPickup = $_POST['isSelfPickup'];
        $delivery_date = $_POST['delivery_date'];
        // print_r($_POST);die;
        $profit_per = 0;
        if ($time_slot_id == - 1) {
            $time_slot_id = $this->this_model->getRandomTimeSlot();
        }
        $get_persentage = $this->this_model->get_profit_per();
        if ($get_persentage > 0) {
            $profit_per = $get_persentage;
        }
        if (isset($_POST['payment_type']) && isset($_POST['vendor_id']) && isset($_POST['time_slot_id'])) {
            if (isset($_POST['user_id'])) {
                $delivery_charge_query = $this->db->query("SELECT price FROM setting WHERE title = 'delivery_charge'");
                $delivery_charge_result = $delivery_charge_query->row_array();
                $my_cart_query = $this->db->query("SELECT SUM(calculation_price) as sub_total, SUM((actual_price - discount_price) * quantity) as total_savings, COUNT(*) as total_item FROM my_cart WHERE status != '9' AND user_id = '$user_id' ");
                $my_cart_result = $my_cart_query->row_array();
                $sub_total = number_format((float)$my_cart_result['sub_total'], 2, '.', '');
                $total_savings = number_format((float)$my_cart_result['total_savings'], 2, '.', '');
                $total_item = $my_cart_result['total_item'];
                $total_price = number_format((float)$sub_total, 2, '.', '');
                if (isset($_POST['user_address_id']) && $_POST['user_address_id'] != '') {
                    $userDetails = $this->this_model->getUserAddressDetails($_POST['user_address_id']);
                    $address = $userDetails[0]->address . ' ' . $userDetails[0]->city . ' ' . $userDetails[0]->state . ' ' . $userDetails[0]->country;
                }
                if (isset($_POST['isSelfPickup']) && $_POST['isSelfPickup'] == '1') {
                    $address = 'self pick';
                    $user = $this->this_model->getUserDetails($_POST['user_id']);
                }
                // print_r($userDetails);die;
                /*Generate Order Number*/
                function random_orderNo($length = 10) {
                    $chars = "1234567890";
                    $order = substr(str_shuffle($chars), 0, $length);
                    return $order;
                }
                $od = 'Order #';
                $on = random_orderNo(15);
                $iOrderNo = $od . $on;
                /*Order Details*/
                $my_order_query = $this->db->query("SELECT * FROM my_cart WHERE status != '9' AND user_id = '$user_id'");
                $my_order_result = $my_order_query->result();
                if (!empty($my_order_result)) {
                    /*Order*/
                    $data = array('order_from' => '1', 'user_id' => $user_id, 'vendor_id' => $vendor_id, 'user_address_id' => $user_address_id, 'time_slot_id' => $time_slot_id, 'payment_type' => $payment_type, 'total_saving' => $total_savings, 'total_item' => $total_item, 'sub_total' => $sub_total, 'delivery_charge' => $delivery_charge, 'total' => $total_price, 'payable_amount' => $total_price + $delivery_charge, 'order_no' => $iOrderNo, 'user_gst_number' => $user_gst_number, 'status' => '1', 'isSelfPickup' => $isSelfPickup, 'delivery_date' => $delivery_date, 'payment_transaction_id' => $transaction_id, 'paymentMethod' => $paymentMethod, 'name' => (isset($userDetails) && !empty($userDetails)) ? $userDetails[0]->name : $user[0]->fname, 'mobile' => (isset($userDetails) && !empty($userDetails)) ? $userDetails[0]->phone : $user[0]->phone, 'delivered_address' => $address, 'dt_added' => strtotime(date('Y-m-d H:i:s')), 'dt_updated' => strtotime(date('Y-m-d H:i:s')),);
                    // print_r($data);die;
                    $this->db->insert('order', $data);
                    $last_insert_id = $this->db->insert_id();
                    $otpForSelfPickup = '';
                    if (isset($_POST['isSelfPickup']) && $_POST['isSelfPickup'] == '1') {
                        $otpForSelfPickup = rand(1000, 9999);
                        $this->this_model->selfPickUp_otp($last_insert_id, $user_id, $otpForSelfPickup);
                    }
                    foreach ($my_order_result as $my_order) {
                        $var_id = $my_order->product_weight_id;
                        $qnt = $my_order->quantity;
                        $updatedQTY = $this->this_model->check_udpate_quantity($var_id,$qnt);
                        if(!$updatedQTY){
                            continue;
                        }
                        $qnt_query = $this->db->query("UPDATE product_weight SET quantity = $updatedQTY,temp_quantity = temp_quantity - $qnt WHERE status != '9' AND id = '$var_id'");
                   
                   
                        $data = array('order_id' => $last_insert_id, 'vendor_id' => $my_order->vendor_id, 'user_id' => $my_order->user_id, 'product_id' => $my_order->product_id, 'weight_id' => $my_order->weight_id, 'product_weight_id' => $my_order->product_weight_id, 'quantity' => $my_order->quantity, 'actual_price' => $my_order->actual_price,
                        //                        'actual_quantity' => $my_order->actual_quantity,
                        'discount' => $my_order->discount_per, 'discount_price' => $my_order->discount_price, 'calculation_price' => $my_order->calculation_price, 'status' => '1', 'dt_added' => strtotime(date('Y-m-d H:i:s')), 'dt_updated' => strtotime(date('Y-m-d H:i:s')),);
                        $this->db->insert('order_details', $data);
                        $last_order_d_id = $this->db->insert_id();
                        $total_profit = ($my_order->calculation_price * $profit_per) / 100;
                        $this->this_model->insert_profit($last_insert_id, $last_order_d_id, $my_order->vendor_id, $total_profit);
                        //                    $this->this_model->update_quantity($my_order->product_weight_id,$my_order->quantity);
                        
                    }
                    /*Remove From My Cart*/
                    //$this->db->where('user_id', $user_id);
                    //$this->db->delete('my_cart');
                    $this->db->query("DELETE FROM my_cart WHERE user_id = '$user_id'  AND vendor_id = '$vendor_id'");
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Thank you for your order";
                    $response["order_number"] = $iOrderNo;
                    $output = json_encode(array('responsedata' => $response));
                    $this->sendCustomerEmailTemplate($user_id, $vendor_id, $last_insert_id);
                    $this->this_model->send_staff_notification($vendor_id, "New Order In Your store");
                    echo $output;
                } else {
                    $response = array();
                    $response["success"] = 0;
                    $response["message"] = "Your Cart is Empty";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "User is not found";
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
    // public function emailTemplate(){ //test email temp
    //     $o_id = 57;
    //     $this->this_model->emailTemplate(   $o_id);
    //     // $data['order_details'] = $this->this_model->emailTemplate($o_id);
    //     // $user_address_id = $data['order_details'][0]->user_address_id;
    //     // if($user_address_id != 0){
    //     //   $data['user_address'] =  $this->this_model->getUserAddress($user_address_id);
    //     // }
    //     // // print_r($data['user_address']);die;
    //     // $this->load->view('customer_template',$data);
    // }
    public function sendCustomerEmailTemplate($user_id, $vendor_id, $order_id) {
        // $order_id = 57;
        $this->this_model->emailTemplate($user_id, $vendor_id, $order_id);
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
            // print_r($result);die;
            // echo $this->db->last_query();die;
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
            $limit = '10';
            // $offset= $_POST['offset'];
            $user_id = $_POST['user_id'];
            $order_id = $_POST['order_id'];
            $actual_price_total = 0;
            $discount_price_total = 0;
            $result_count = $this->db->query("SELECT COUNT(*) as total FROM `order_details` WHERE status != '9' AND user_id = '$user_id' AND order_id = '$order_id'");
            $row_count = $result_count->result();
            $query = $this->db->query("SELECT * FROM `order_details` WHERE status != '9' AND user_id = '$user_id' AND order_id = '$order_id' ORDER BY id DESC ");
            $result = $query->result();
            // print_r($result);die;
            $order_query = $this->db->query("SELECT * FROM `order` WHERE status != '9' AND user_id = '$user_id' AND id = '$order_id'");
            $order_result = $order_query->row_array();
            $isSelfPickup = $order_result['isSelfPickup'];
            $total_with_charge = $order_result['payable_amount'];
            $delivery_charge = $order_result['delivery_charge'];
            if ($isSelfPickup == 1) {
                $self_pick = $this->db->query("SELECT * FROM `selfPickup_otp` WHERE order_id = '$order_id' AND user_id = '$user_id'");
                $self_otp = $self_pick->row_array();
                // print_r($self_otp);die;
                $self_pick_otp = $self_otp['otp'];
            }
            $my_order_price_query = $this->db->query("SELECT SUM(calculation_price) as total_price from order_details WHERE status != '9' AND order_id = '$order_id' AND user_id = '$user_id'");
            $my_order_price_result = $my_order_price_query->row_array();
            $userOrder_vendor_id = $result[0]->vendor_id;
            $vendorDetails = $this->this_model->getVendorAddress($userOrder_vendor_id);
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
                    // echo $this->db->last_query();exit;
                    $product_weight_result = $product_weight_query->row_array();
                    $product_unit = $product_weight_result['weight_no'];
                    $product_weight_name = $product_weight_result['product_weight_name'];
                    $data['product_unit'] = $product_unit . ' ' . $product_weight_name;
                    $package_id = $product_weight_result['package'];
                    $package_name = $this->this_model->get_package($package_id);
                    // 'package_name' => $package_name,
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
                    $product_query = $this->db->query("SELECT name, image FROM product WHERE status != '9' AND id = '$product_id'");
                    $product_image_query = $this->db->query("SELECT * FROM product_image WHERE status != '9' AND product_id = '$product_id'");
                    $product_image_result = $product_image_query->result();
                    $proimg = $product_image_result[0]->image;
                    $prothimg = $product_image_result[0]->image;
                    $product_result = $product_query->row_array();
                    $data = array();
                    $data['name'] = $product_result['name'];
                    $data['image'] = base_url() . 'public/images/product_image/' . $proimg;
                    $data['image_thumb'] = base_url() . 'public/images/product_image_thumb/' . $prothimg;
                    $data['quantity'] = $row->quantity;
                    $data['package_name'] = $package_name;
                    $data['unit'] = $product_unit . ' ' . $product_weight_name;
                    $data['discount'] = $row->discount;
                    $data['actual_price'] = $row->actual_price;
                    $data['price'] = $row->calculation_price;
                    $data['product_id'] = $row->product_id;
                    $data['product_varient_id'] = $row->product_weight_id;
                    $data['vendor_id'] = $row->vendor_id;
                    $get_data[] = $data;
                    $counter++;
                }
                $response['success'] = "1";
                $response['message'] = "My order details";
                $response["count"] = $counter;
                // $response["total_price"] = number_format((float)$my_order_price_result['actual_price_total'], 2, '.', '');
                $response["store_name"] = $vendorDetails[0]->name;
                $response["vendor_address"] = $vendorDetails[0]->location;
                $response["actual_price_total"] = $total_with_charge;
                $response["total_price"] = (string)$actual_price_total;
                $response["delivery_charge"] = $delivery_charge;
                $response["discount_price_total"] = $discount_price_total;
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
          
            $data = array('user_id' => $user_id, 'address' => $address_post, 'name' => $name, 'pincode' => $pincode, 'landmark' => $landmark, 'city' => $city, 'state' => $state, 'country' => $country, 'phone' => $phone, 'latitude' => $latitude, 'longitude' => $longitude, 'status' => '1', 'dt_added' => strtotime(date('Y-m-d H:i:s')), 'dt_updated' => strtotime(date('Y-m-d H:i:s')));
            $this->db->insert('user_address', $data);
            $response = array();
            $response["success"] = 1;
            $response["message"] = "Address has been added.";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "Please enter valid data";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
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
            
            $data = array('address' => $address_, 'name' => $name, 'pincode' => $pincode, 'landmark' => $landmark, 'city' => $city, 'state' => $state, 'country' => $country, 'phone' => $phone, 'latitude' => $latitude, 'longitude' => $longitude, 'status' => '1', 'dt_updated' => strtotime(date('Y-m-d H:i:s')),);
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
            if(!$cancle){
                $response["success"] = 0;
                $response["message"] = "Order can not cancle";
                $output = json_encode(array('responsedata' => $response));
                echo $output;die;
            }
            $this->load->model('staff_api_model');
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
        // $limit = '5';
        // $offset= $_POST['offset'];
        $product_name = $_GET['product_name'];
        if (isset($_GET['user_id']) && $_GET['user_id'] != '') {
            $user_id = $_GET['user_id'];
        }
        $device_id = $_GET['device_id'];
        $vendor_id = $_GET['vendor_id'];
        if (isset($product_name) && $product_name != '' && isset($vendor_id) && $vendor_id != '') {
            $result_count = $this->db->query("SELECT p.* FROM `product` as p 
                LEFT JOIN product_weight as w ON w.product_id = p.id
                WHERE p.status != '9'  AND p.vendor_id = '$vendor_id' AND w.discount_price != '' AND w.status != '9' AND p.name LIKE '%$product_name%' GROUP BY p.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2))");
            $row_count_ = $result_count->result();
            $total_count = count(array_keys($row_count_));
            $query = $this->db->query("SELECT p.*,c.name as category_name,sb.name as subcat_name,b.name as brand_name FROM `product` as p 
                LEFT JOIN product_weight as w ON w.product_id = p.id
                LEFT JOIN category as c ON c.id = p.category_id
                LEFT JOIN subcategory as sb ON sb.id = p.subcategory_id
                LEFT JOIN brand as b ON b.id = p.brand_id
                WHERE p.status != '9' AND p.vendor_id = '$vendor_id' AND w.discount_price != '' AND w.status != '9' AND ( p.name LIKE '%$product_name%' OR c.name LIKE '%$product_name%' OR sb.name LIKE '%$product_name%' OR b.name LIKE '%$product_name%')
                GROUP BY p.id,c.id,sb.id ORDER BY CAST(w.discount_price AS DECIMAL(10,2)) ASC ");
            $result = $query->result();
            // print_r($result);die;
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
                        $package_id = $pro_weight->package;
                        $package_name = $this->this_model->get_package($package_id);
                        // 'package_name' => $package_name,
                        $weight_id = $pro_weight->weight_id;
                        $weight_query = $this->db->query("SELECT name FROM weight WHERE id = '$weight_id'");
                        $weight_result = $weight_query->row_array();
                        $weight_name = $weight_result['name'];
                        if (isset($_POST['user_id'])) {
                            $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND user_id = '$user_id'");
                            $my_cart_result = $my_cart_query->row_array();
                        } elseif (isset($_POST['device_id']) && (!isset($_POST['user_id']) || $_POST['user_id'] == '')) {
                            $my_cart_query = $this->db->query("SELECT quantity FROM my_cart WHERE product_id = '$product_id' AND weight_id = '$weight_id' AND  device_id = '$device_id'");
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
                        $data = array('id' => $pro_image->id, 'product_id' => $pro_image->product_id, 'image' => base_url() . 'public/images/product_image/' . $pro_image->image, 'thumb_image' => base_url() . 'public/images/product_image_thumb/' . $pro_image->image,);
                        array_push($new_array_product_image, $data);
                    }
                    $product_image_array = $new_array_product_image;
                    $data = array();
                    $data['id'] = $row->id;
                    $data['category_id'] = $row->category_id;
                    $data['brand_id'] = $row->brand_id;
                    $data['name'] = $row->name;
                    $data['image'] = base_url() . 'public/images/product_image/' . $proimg;
                    $data['image_thumb'] = base_url() . 'public/images/product_image_thumb/' . $prothimg;
                    $data['about'] = $row->about;
                    $data['content'] = $row->content;
                    $data['status'] = $row->status;
                    $data['dt_added'] = $row->dt_added;
                    $data['dt_updated'] = $row->dt_updated;
                    $data['product_weight'] = $product_weight_array;
                    $data['product_image'] = $product_image_array;
                    array_push($response["data"], $data);
                    // print_r($response["data"]);
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
            $this->db->where('id', $id);
            $this->db->delete('user_address');
            // echo $this->db->last_query();exit;
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
        $req = array('name', 'email', 'mobile', 'message');
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
}

?>
