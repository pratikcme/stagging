<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("HTTP/1.1 200 OK");

class Delivery_api extends CI_Controller
{
    function __construct()
    {
        // ini_set("display_errors", "1");
        // error_reporting(E_ALL);

        parent::__construct();


        $this->load->model('delivery_api_model', 'this_model');
    }

    public function login()
    {
       // echo 1;exit;

        $postdata = $this->input->post();

        if (isset($postdata['email']) && isset($postdata['password']) && isset($postdata['device_id']) && isset($postdata['type']) && isset($postdata['token'])) {

            $result = $this->this_model->login($postdata);
            // print_r($result);exit;
            if ($result != 0) {

                if ($result['status'] == '0') {
                    $response['success'] = 0;
                    $response['message'] = "Your account is inactive";
                } else {
                    $response['success'] = 1;
                    $response['message'] = "Login successfully";
                    $response['data'] = $result;
                }


            } else {
                $response['success'] = 0;
                $response['message'] = "Wrong password or email";
            }
        } else {
            $response['success'] = 0;
            $response['message'] = "invalid input";
        }

        echo json_encode($response);

    }
   

    public function update_status()
    {
        // $this->demo("",80);exit;
        $postdata = $this->input->post();

        if (isset($postdata['status']) && isset($postdata['id'])) {


            $result = $this->this_model->update_status($postdata);


            $response['success'] = 1;
            $response['message'] = "Updated successfully";

        } else {
            $response['success'] = 0;
            $response['message'] = "invalid input";
        }

        echo json_encode($response);
    }

    public function notification_detail()
    {
        // print_r($_GET['order_id']);exit;
        $postdata = $this->input->post();
        if (isset($postdata['order_id'])) {
            $result = $this->this_model->notification_detail($postdata);
            if ($result) {

                $response['success'] = 1;
                $response['message'] = "Order Data";
                $response['data'] = $result;
            } else {
                $response['success'] = 0;
                $response['message'] = "Invalid order id";
            }
        } else {
            $response['success'] = 0;
            $response['message'] = "invalid input";
        }
        echo json_encode($response);

    }

    public function pickup()
    {
        $postdata = $this->input->post();
        if (isset($postdata['order_id']) && isset($postdata['user_id'])) {
            $result = $this->this_model->pickup($postdata);
            if ($result) {

                $response['success'] = 1;
                $response['message'] = "Order is on the way";
            } else {
                $response['success'] = 0;
                $response['message'] = "Please verify otp";
            }
        } else {
            $response['success'] = 0;
            $response['message'] = "invalid input";
        }
        echo json_encode($response);

    }

    public function dashboard_data()
    {
        $postdata = $this->input->post();
        if (isset($postdata['user_id'])) {
            $result = $this->this_model->dashboard_data($postdata);
            if ($result) {

                $response['success'] = 1;
                $response['message'] = "Dashboard data";
                $response['data'] = $result;
            } else {
                $response['success'] = 0;
                $response['message'] = "No data Found";
            }
        } else {
            $response['success'] = 0;
            $response['message'] = "invalid input";
        }
        echo json_encode($response);

    }

    public function accept_reject()
    {
        $postdata = $this->input->post();
        if (isset($postdata['order_id']) && isset($postdata['user_id']) && isset($postdata['status'])) {
            $result = $this->this_model->accept_reject($postdata);
            if ($result == 'Rejected') {

                $response['success'] = 6;
                $response['message'] = "Rejected";
            } else {
                $response['success'] = 1;
                $response['message'] = "Your OTP is";
                $response['otp'] = $result;
                $response['order_id'] = $postdata['order_id'];
            }
        } else {
            $response['success'] = 0;
            $response['message'] = "invalid input";
        }
        echo json_encode($response);

    }

    public function order_delivered()
    {
        $postdata = $this->input->post();
        if (isset($postdata['order_id'])) {

            $result = $this->this_model->order_delivered($postdata);

            if($result){

                $response['success'] = 1;
                $response['message'] = "Order delivered";
            }
        }
        else {
            $response['success'] = 0;
            $response['message'] = "invalid input";
        }
        echo json_encode($response);
    }


    public function delivered_order_list(){


        $postdata = $this->input->post();
        if (isset($postdata['user_id'])) {

            $result = $this->this_model->delivered_order_list($postdata);
            if ($result) {
                $response['success'] = 1;
                $response['message'] = "Dashboard data";
                $response['data'] = $result;
            } else {
                $response['success'] = 0;
                $response['message'] = "No data Found";
            }
        }
        else {
            $response['success'] = 0;
            $response['message'] = "invalid input";
        }
        echo json_encode($response);
    }

     public function update_profile(){


        $postdata = $this->input->post();
        if (isset($postdata['user_id'])) {

            $result = $this->this_model->update_profile($postdata);
           
                $response['success'] = 1;
                $response['message'] = "Data Updated";
                $response['data'] = $result;
            
        }
        else {
            $response['success'] = 0;
            $response['message'] = "invalid input";
        }
        echo json_encode($response);
    }

    public function checkNotification(){
        
        ini_set('display_errors', 'On');
        error_reporting(E_ALL);

        $data = $this->db->get_where('device',array('type' => "a"))->result();
        $url = 'https://fcm.googleapis.com/fcm/send';
        $tokenId = array();

        for($i=0; $i<count($data); $i++){
            if(strlen($data[$i]->token) >= '64'){
                $tokenId [] = $data[$i]->token;    
            }
        }

        

        $fields = array(
            "registration_ids" => $tokenId,
            "data" => array(
                "body"  => "This is a test",
                "title" => 'Grocery Pos',
                "type"  => 'Grocery Pos',
                "priority" =>'high'
            )
        );

        $fields_json = json_encode($fields);
        $headers = array(
            'Authorization: key=AAAAiEVdA8M:APA91bHLObncewgHcuCHN1vlK8KON4pyixZ3MpBXG0PRfr6Fh3qMUe7ZF66t7TGv5Bzfz-zr4MGP93SBwELaDFtFDfSnMxmtKcU2lrGth6TVGfrVodrp-WOLgAeRGMf0ESD1pJc0e_En',
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_json);
        $result = curl_exec($ch);
        curl_close($ch);
        echo "<pre/>"; print_r($result); exit();
    }

    public function logout(){
        $postdata = $this->input->post(); 
        if (isset($postdata['user_id']) && $postdata['user_id'] != '' ) { 
            $user_id = $postdata['user_id'];
            $result = $this->this_model->logout($user_id);
           
            $response['success'] = 1;
            $response['message'] = "Logout successfully";
           
            
        }
        else {
            $response['success'] = 0;
            $response['message'] = "invalid input";
        }
        echo json_encode($response);
    }

}