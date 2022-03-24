<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("HTTP/1.1 200 OK");
class Api_admin extends Api_Controller {
    function __construct() {
   
        parent::__construct();
        $this->load->model('api_admin_model', 'this_model');
        date_default_timezone_set('Asia/Kolkata');
    }
    protected function checkRequiredField($request_params = array(), $require = array()) {
        $error_flag = 0;
        $status = 1;
        $msg = array();
        foreach ($require as $key => $val) {
            if (!isset($_POST[$val]) || trim($request_params[$val]) == '') {
                $error_flag++;
                $msg[] = "$val is required!";
                $status = 0;
            }
        }
        if ($status == 0) {
            $response = array('status' => $status, 'msg' => $msg);
            $this->response($response);
        } else {
            return array('status' => $status, 'errors' => $error_flag);
        }
    }
    /* Send API response
     ** Date : 01-12-2019
     ** Created By : cmexpertiseinfotech Ahmedabad
     ** Devloper : Pratik Shah
    */
    protected function response($response) {
        if (!$response) {
            $CI = & get_instance();
            $response['status'] = 0;
            $response['message'] = 'something_went_wrong';
        }
        ob_get_clean();
        $response = json_encode($response);
        $response = str_replace('null', "\"\"", $response);
        echo $response;
        die;
    }
    public function check_login() {
        $post = $this->input->post();
        $req = array('email', 'password');
        $required = $this->checkRequiredField($post, $req);
        // print_r($post);die;
        if ($required['status'] == 1) {
            $responce = $this->this_model->check_login($this->input->post());
        }
        // print_r($responce);die;
        $this->response($responce);
    }
    public function profile_update() {
        
        $post = $this->input->post();
        $req = array('vendor_id', 'name', 'email', 'shopName', 'selfPickUp', 'phone');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->profile_update($this->input->post());
        }
        // print_r($responce);die;
        $this->response($responce);
    }

     public function is_authenticate() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->is_authenticate($this->input->post());
        }
        $this->response($responce);
    }

    public function payment_method() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->payment_method($this->input->post());
        }
        // print_r($responce);die;
        $this->response($responce);
    }
    public function change_status() {
        $post = $this->input->post();
        $req = array('vendor_id', 'payment_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->payment_method_change_status($this->input->post());
        }
        // print_r($responce);die;
        $this->response($responce);
    }
    public function get_code() {
        $responce = $this->this_model->get_code();
        $this->response($responce);
    }
    public function get_customer() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->get_customer($this->input->post());
        }
        $this->response($responce);
    }
    public function get_group() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->get_group($this->input->post());
        }
        $this->response($responce);
    }
    public function add_customer() {
        $post = $this->input->post();
        $req = array('CustomerName', 'Company', 'customercode', 'gender', 'phonenumber', 'mobile', 'email', 'fax', 'dob', 'website', 'twitter', 'street1', 'street2', 'city', 'state', 'country', 'postalcode', 'vendor_id', 'group_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->add_edit_Customer($this->input->post());
        }
        $this->response($responce);
    }
    public function update_customer() {
        $post = $this->input->post();
        $req = array('customer_id', 'CustomerName', 'Company', 'customercode', 'gender', 'phonenumber', 'mobile', 'email', 'fax', 'dob', 'website', 'twitter', 'street1', 'street2', 'city', 'state', 'country', 'postalcode', 'vendor_id', 'group_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->add_edit_Customer($this->input->post());
        }
        $this->response($responce);
    }
    public function delete_customer() {
        $post = $this->input->post();
        $req = array('customer_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->delete_customer($this->input->post());
        }
        $this->response($responce);
    }
    public function add_group() {
        $post = $this->input->post();
        $req = array('vendor_id', 'name');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->add_group($this->input->post());
        }
        $this->response($responce);
    }
    public function update_group() {
        $post = $this->input->post();
        $req = array('vendor_id', 'group_id', 'name');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->update_group($this->input->post());
        }
        $this->response($responce);
    }
    public function delete_group() {
        $post = $this->input->post();
        $req = array('vendor_id', 'group_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->delete_group($this->input->post());
        }
        $this->response($responce);
    }
    public function get_group_customer() {
        $post = $this->input->post();
        $req = array('group_id', 'vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->get_group_customer($this->input->post());
        }
        $this->response($responce);
    }
    public function get_staff() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->get_staff($this->input->post());
        }
        $this->response($responce);
    }
    public function staff_change_status() {
        $post = $this->input->post();
        $req = array('staff_id', 'status');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->staff_change_status($this->input->post());
        }
        $this->response($responce);
    }
    public function staff_add() {
        $post = $this->input->post();
        $req = array('vendor_id', 'name', 'email', 'password', 'mobile');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->staff_add_update($this->input->post());
        }
        $this->response($responce);
    }
    public function staff_update() {
        $post = $this->input->post();
        $req = array('staff_id', 'vendor_id', 'name', 'mobile');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->staff_add_update($this->input->post());
        }
        $this->response($responce);
    }
    public function get_category() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->get_category($this->input->post());
        }
        $this->response($responce);
    }
    public function category_add() {
        $post = $this->input->post();
        $req = array('vendor_id', 'name');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->category_add_update($this->input->post());
        }
        $this->response($responce);
    }
    public function category_update() {
        $post = $this->input->post();
        $req = array('vendor_id', 'category_id', 'name');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->category_add_update($this->input->post());
        }
        $this->response($responce);
    }
    public function delete_category() {
        $post = $this->input->post();
        $req = array('vendor_id', 'category_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->delete_category($this->input->post());
        }
        $this->response($responce);
    }
    public function subCategory_add() {
        $post = $this->input->post();
        $req = array('vendor_id', 'name', 'category_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->subCategory_add_update($this->input->post());
        }
        $this->response($responce);
    }
    public function subCategory_update() {
        $post = $this->input->post();
        $req = array('vendor_id', 'name', 'subCategory_id', 'category_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->subCategory_add_update($this->input->post());
        }
        $this->response($responce);
    }
    public function delete_subcategory() {
        $post = $this->input->post();
        $req = array('vendor_id', 'subCategoryid');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->delete_subcategory($this->input->post());
        }
        $this->response($responce);
    }
    public function get_subcategory() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->get_subcategory($this->input->post());
        }
        $this->response($responce);
    }
    public function get_brand() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->get_brand($this->input->post());
        }
        $this->response($responce);
    }
    public function delete_brand() {
        $post = $this->input->post();
        $req = array('vendor_id', "brand_id");
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->delete_brand($this->input->post());
        }
        $this->response($responce);
    }
    public function brand_add() {
        $post = $this->input->post();
        $req = array('name', 'category_id', 'vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->brand_add_update($this->input->post());
        }
        $this->response($responce);
    }
    public function brand_update() {
        $post = $this->input->post();
        $req = array('name', 'category_id', 'vendor_id', 'brand_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->brand_add_update($this->input->post());
        }
        $this->response($responce);
    }
    public function get_product() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->get_product($this->input->post());
        }
        $this->response($responce);
    }
    public function get_weight() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->get_weight($this->input->post());
        }
        $this->response($responce);
    }
    public function get_variant() {
        $post = $this->input->post();
        $req = array('product_id', 'vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->get_product_weight($this->input->post());
        }
        $this->response($responce);
    }
    public function get_package() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->get_package($this->input->post());
        }
        $this->response($responce);
    }
    public function get_supplier() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->get_supplier($this->input->post());
        }
        $this->response($responce);
    }
    public function product_add() {
        $post = $this->input->post();
        $req = array('vendor_id', 'name', 'category_id', 'brand_id', 'subcategory_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->product_add_update($this->input->post());
        }
        $this->response($responce);
    }
    public function product_update() {
        $post = $this->input->post();
        $req = array('vendor_id', 'name', 'category_id', 'brand_id', 'subcategory_id','product_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->product_add_update($this->input->post());
        }
        $this->response($responce);
    }
    public function delete_product() {
        $post = $this->input->post();
        $req = array('vendor_id', "product_id");
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->delete_product($this->input->post());
        }
        $this->response($responce);
    }
    public function delete_variant_image() {
        $post = $this->input->post();
        $req = array('vendor_id', "image_id");
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->delete_variant_image($this->input->post());
        }
        $this->response($responce);
    }
    public function delete_product_variant() {
        $post = $this->input->post();
        $req = array('vendor_id', "variant_id");
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->delete_product_variant($this->input->post());
        }
        $this->response($responce);
    }
    public function variant_add() {
        $post = $this->input->post();
        $req = array('vendor_id', 'product_id', 'weight_id', 'unit', 'price', 'quantity', 'discount_per', 'purchase_price', 'package');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->product_weight_add_update($this->input->post());
        }
        $this->response($responce);
    }
    public function variant_update() {
        $post = $this->input->post();
        $req = array('vendor_id', 'product_id', 'weight_id', 'unit', 'price', 'quantity', 'discount_per', 'purchase_price', 'package', 'variant_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->product_weight_add_update($this->input->post());
        }
        $this->response($responce);
    }
    public function getImages() {
        $post = $this->input->post();
        $req = array('vendor_id', 'product_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->getImages($this->input->post());
        }
        $this->response($responce);
    }
    public function getOrders() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->getOrders($this->input->post());
        }
        $this->response($responce);
    }
    public function change_order_status() {
        $post = $this->input->post();
        $req = array('vendor_id', 'order_id', 'status');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->change_order_status($this->input->post());
        }
        $this->response($responce);
    }
    public function verify_otp() {
        $post = $this->input->post();
        $req = array('vendor_id', 'order_id', 'otp', 'isSelfPickup');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            if ($post['isSelfPickup'] == '1') {
                $this->load->model('staff_api_model', 'staff_model');
                $response = $this->staff_model->verify_otp_selfPickup($this->input->post());
            } else {
                $response = $this->this_model->verify_otp($this->input->post());
            }
            // $responce =  $this->this_model->verify_otp($this->input->post());
            
        }
        $this->response($response);
    }
    public function order_detail() {
        $post = $this->input->post();
        $req = array('vendor_id', 'order_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->order_detail($this->input->post());
        }
        $this->response($responce);
    }
    public function dashboard() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->dashboard($this->input->post());
        }
        $this->response($responce);
    }

     public function QueryMessageToSuperAdmin(){
            $post = $this->input->post();
            $req = array('vendor_id','subject','message');
            $required = $this->checkRequiredField($post, $req);
            $data['vendor'] = $this->this_model->EmailMessage($post);
            $data['subject'] = $post['subject'];
            $data['vendor_message'] = $post['message'];
            $mail['message'] = $this->load->view('emailTemplate/queryMessageTemplate',$data,true);
            $mail['subject'] = $this->input->post('subject');
            $mail['to'] = 'cmexpertise@gmail.com';
            $status = sendMail($mail);
            if ($status) {
                $return = ['status' => 1, 'message' => 'Your email successfully send to admin'];
            } else {
                $return = ['status' => 0, 'message' => 'Something went Wrong'];
            }
            $this->response($return);       
    }


    public function subscription() {
        $post = $this->input->post();
        $req = array('vendor_id');
        $required = $this->checkRequiredField($post, $req);
        if ($required['status'] == 1) {
            $responce = $this->this_model->subscription($this->input->post());
        }
        $this->response($responce);
    }
    public function verifyAccount($postData = null) {
        /* check if we are getting token or not */
        if ($postData) {
            $response = $this->this_model->verifyUserByToken($postData);
          
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
    public function setVerifyEmailmessage($message) {
        $CI = & get_instance();
        $template = '<h1>Thank you<br> <span>You have successfully verified your email</span></h1>';
        $CI->session->set_flashdata("myMessage", $template);
    }
}
?>