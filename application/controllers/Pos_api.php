<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


//echo 1;exit;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("HTTP/1.1 200 OK");

class Pos_api extends CI_Controller
{
    function __construct(){
        // ini_set("display_errors", "1");
            error_reporting(E_ALL);
            
        parent::__construct();      
        $this->load->model('posapi_model','this_model');
    }
    public function login(){
        $postdata = $this->input->post();
        if(isset($postdata['email']) && isset($postdata['password'])){
            $response = $this->this_model->login($postdata);
        }else{
            $response = array(
                        'status'=>'0',
                        'message'=>'Please input valid data',
                    );

        }
        echo json_encode($response);
    }
    public function category_list(){
        $postdata = $this->input->post();
        if(isset($postdata['vendor_id'])){
            $response = $this->this_model->category_list($postdata);
        }else{
            $response = array(
                        'status'=>'0',
                        'message'=>'Please input valid data',
                    );

        }
        echo json_encode($response);
    }
    public function subcategory_list(){
        $postdata = $this->input->post();
        if(isset($postdata['vendor_id'])){
            $response = $this->this_model->subcategory_list($postdata);
        }else{
            $response = array(
                        'status'=>'0',
                        'message'=>'Please input valid data',
                    );

        }
        echo json_encode($response);
    }
    public function product_list(){
        $postdata = $this->input->post();
        if(isset($postdata['vendor_id'])){
            $response = $this->this_model->product_list($postdata);
        }else{
            $response = array(
                        'status'=>'0',
                        'message'=>'Please input valid data',
                    );

        }
        echo json_encode($response);
    }
    public function product_variant_list(){
        $postdata = $this->input->post();
        if(isset($postdata['vendor_id'])){
            $response = $this->this_model->product_variant_list($postdata);
        }else{
            $response = array(
                        'status'=>'0',
                        'message'=>'Please input valid data',
                    );

        }
        echo json_encode($response);
    }
    public function checkout(){
        $postdata = $this->input->post();
        if(isset($postdata['order_data'])){
            $response = $this->this_model->checkout($postdata);
        }else{
            $response = array(
                        'status'=>'0',
                        'message'=>'Please input valid data',
                    );

        }
        echo json_encode($response);
        exit;
    } 
    public function getCustomerGroupSync(){
        $postdata = $this->input->post();
        if(isset($postdata['vendor_id'])){
            $response = $this->this_model->getCustomerGroupSync($postdata);
        }else{
            $response = array(
                        'status'=>'0',
                        'message'=>'Please input valid data',
                    );

        }
        echo json_encode($response);
    }
    public function getCustomerSync(){
        $postdata = $this->input->post();
        if(isset($postdata['vendor_id'])){
            $response = $this->this_model->getCustomerSync($postdata);
        }else{
            $response = array(
                        'status'=>'0',
                        'message'=>'Please input valid data',
                    );

        }
        echo json_encode($response);
    }

    public function last_register(){
        $postdata = $this->input->post();
        if(isset($postdata['vendor_id'])){
            $response = $this->this_model->last_register($postdata);
        }else{
            $response = array(
                        'status'=>'0',
                        'message'=>'Please input valid data',
                    );

        }
        echo json_encode($response);
    }

    public function open_register(){
        $postdata = $this->input->post();
        if(isset($postdata['vendor_id'])){
            $response = $this->this_model->open_register($postdata);
        }else{
            $response = array(
                        'status'=>'0',
                        'message'=>'Please input valid data',
                    );

        }
        echo json_encode($response);
    } 

    public function close_register(){
        $postdata = $this->input->post();
        if(isset($postdata['vendor_id']) &&isset($postdata['id']) &&isset($postdata['counted']) &&isset($postdata['difference']) &&isset($postdata['credit_card_expected']) &&isset($postdata['credit_card_counted']) &&isset($postdata['credit_card_differences']) ){
            $response = $this->this_model->close_register($postdata);
        }else{
            $response = array(
                        'status'=>'0',
                        'message'=>'Please input valid data',
                    );

        }
        echo json_encode($response);
    }

    public function customer_add(){
        $postdata = $this->input->post();
     
        if(isset($postdata['group_id']) && isset($postdata['vendor_id']) && isset($postdata['customer_name']) && isset($postdata['company']) && isset($postdata['dob']) && isset($postdata['gender']) && isset($postdata['phone']) && isset($postdata['mobile']) && isset($postdata['email']) && isset($postdata['street1']) && isset($postdata['street2']) && isset($postdata['city']) && isset($postdata['state'])&& isset($postdata['country'])&& isset($postdata['postcode'])&& isset($postdata['password'])&& isset($postdata['customercode'])&& isset($postdata['fax'])&& isset($postdata['twitter']) ){
            
            $response = $this->this_model->customer_add($postdata);
        }else{
            $response = array(
                        'status'=>'0',
                        'message'=>'Please input valid data',
                    );

        }
        echo json_encode($response);
    }

}
?>