<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("HTTP/1.1 200 OK");
class Staff_api extends Staff_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('api_v3/staff_api_model', 'this_model');
    }
    public function login() {
        $postdata = $this->input->post();
        if (isset($postdata['email']) && isset($postdata['password'])) {
            $response = $this->this_model->login($postdata);
        } else {
            $response = array('status' => '0', 'message' => 'Invalid Parameter');
        }
       
        echo json_encode($response);
    }
    public function order_list() {
        $postdata = $this->input->post();
        if (isset($postdata['branch_id'])) {
            $response = $this->this_model->order_list($postdata);
        } else {
            $response = array('status' => '0', 'message' => 'Invalid Parameter');
        }
        echo json_encode($response);
    }
    public function order_detail() {
        $postdata = $this->input->post();
        if (isset($postdata['order_id'])) {
            $response = $this->this_model->order_detail($postdata);
        } else {
            $response = array('status' => '0', 'message' => 'Invalid Parameter');
        }
        echo json_encode($response);
    }
    public function product_check() {
        $postdata = $this->input->post();
        if (isset($postdata['product_weight_id']) && isset($postdata['order_id'])) {
            $response = $this->this_model->product_check($postdata);
        } else {
            $response = array('status' => '0', 'message' => 'Invalid Parameter');
        }
        echo json_encode($response);
    }
    public function delivery_status() {
        $postdata = $this->input->post();
        if (isset($postdata['order_id'])) {
            $response = $this->this_model->delivery_status($postdata);
        } else {
            $response = array('status' => '0', 'message' => 'Invalid Parameter');
        }
        echo json_encode($response);
    }
    public function verify_otp() {
        $postdata = $this->input->post();
        if (isset($postdata['order_id']) && isset($postdata['otp']) && isset($postdata['isSelfPickup'])) {
            if ($postdata['isSelfPickup'] == '1') {
                $response = $this->this_model->verify_otp_selfPickup($postdata);
            } else {
                $response = $this->this_model->verify_otp($postdata);
            }
        } else {
            $response = array('status' => '0', 'message' => 'Invalid Parameter');
        }
        echo json_encode($response);
    }
    public function status() {
        $postdata = $this->input->post();
        if (isset($postdata['branch_id'])) {
            $response = $this->this_model->status($postdata);
        } else {
            $response = array('status' => '8', 'message' => 'Invalid Parameter');
        }
        echo json_encode($response);
    }
    public function logout() {
        $post = $this->input->post();
        $req = array('staff_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->logout($this->input->post());
        }
        $this->response($responce);
    }
}
?>