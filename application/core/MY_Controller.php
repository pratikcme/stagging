<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// error_reporting(E_ALL);
// ini_set("display_errors", '1');
class MY_Controller extends CI_Controller
{

    public $json_response = null;
    public $user_id = null;
    
    function __construct(){

        parent::__construct();
        // $this->url = SITE_URL . 'frontend/'. $this->controller;
        $this->json_response = array('status' => 'error', 'message' => 'something went wrong!');

         if(isset($_SESSION['My_cart']) && count($_SESSION['My_cart']) == 0 ){
                $this->session->unset_userdata('My_cart');
            }

            
            if( strpos($_SERVER['REQUEST_URI'], 'api_v2')  === false && 
                strpos($_SERVER['REQUEST_URI'], '/api/')  !== false ) 
            { 

                require_once APPPATH . 'config/old_tablenames_constants.php';

                $this->load->model('common_model');
                $siteDetail = $this->common_model->getLogovone();
                $this->folder = $siteDetail['folder'];
            }else{

            require_once APPPATH . 'config/tablenames_constants.php';  
                $this->load->model('api_v2/common_model');

            $siteDetail = $this->common_model->getLogo();
            $this->siteLogo = $siteDetail['logo']; 
            $this->siteTitle = $siteDetail['webTitle'];
            $this->siteFevicon = $siteDetail['favicon_image']; 
            $this->folder = $siteDetail['folder'];
            $this->siteCurrency = $this->common_model->getDefaultCurrency();
            // echo $this->siteCurrency;die;
            $this->countCategory = $this->common_model->CountCategory();
            $this->CountSubcategory = $this->common_model->CountSubCategory();
            $this->common_keys = $this->common_model->getCommonKeysAndLink();

            }
           
            // print_r($siteDetail);die;
            

    }

    function loadView($layout,$data){
       $this->load->model('frontend/vendor_model','vendor_model');
       $data['ApprovedBranch'] = $this->vendor_model->ApprovedBranch();
       $this->load->model($this->myvalues->contactFrontEnd['model'],'contact');
       $data['getContact'] = $this->contact->getContact();
       $data['home_url'] = base_url().'home';
       $this->load->model('frontend/product_model','product_model');
       $data['CategoryHighrstProduct'] = $this->product_model->getCategoryHighrstProduct();

       return $this->load->view($layout,$data);
   }

}

class Admin_Controller extends MY_Controller
{

    public $user_data = null;   
    public $user_type = null;
    public $user_id = null;

    function __construct(){ 
        parent::__construct();
        // print_r($_SESSION);die;
        
        if($this->session->userdata('vendor_admin') != '1' ){
                redirect(base_url().'admin/dashboard');
        }
    }

}

class Vendor_Controller extends MY_Controller
{

    public $user_data = null;   
    public $user_type = null;
    public $user_id = null;

    function __construct()
    { 
        parent::__construct();
        if($this->session->userdata('branch_admin') != '1' ){
                redirect(base_url().'admin/dashboard');
        
 }   }

}
    class User_Controller extends MY_Controller
    {

        function __construct()
        { 
            parent::__construct();
            // $user_id = $this->session->userdata('user_id');
            //   if(!isset($user_id)){
            //     redirect(base_url());
            //   }

             if(isset($_SESSION['My_cart']) && count($_SESSION['My_cart']) == 0 ){
                $this->session->unset_userdata('My_cart');
            }

            if($this->session->userdata('user_id') == ''){
                if(isset($_SESSION['My_cart']) && !empty($_SESSION['My_cart'])){
                    $this->cartCount = count($_SESSION['My_cart']);
                    
                }
            }else{
                $this->load->model('frontend/product_model','product_model');
                $my_cart = $this->product_model->getMyCart();
                $this->cartCount = count($my_cart);
            }


        }

       function loadView($layout,$data){
                $this->load->model($this->myvalues->contactFrontEnd['model'],'contact');
                $this->load->model($this->myvalues->homeFrontEnd['model'],'home');
                $this->load->model($this->myvalues->usersAccount['model'],'users');
                // $ip = $this->input->ip_address(); 
                // if($ip == '223.226.208.92'){
                // }
                    if($this->session->userdata('user_id') != ''){
                        // print_r($userInfo);die();
                        $userInfo = $this->users->getUserDetails();
                            $_SESSION['user_name'] = $userInfo[0]->fname;
                            $_SESSION['user_lname'] = $userInfo[0]->lname;
                            $_SESSION['user_phone'] = $userInfo[0]->phone; 
                        }
                
                $this->load->model('frontend/vendor_model','vendor_model');
                $data['branch_nav'] = $this->vendor_model->branchList();
                $data['ApprovedBranch'] = $this->vendor_model->ApprovedBranch();
                $this->load->model('frontend/product_model','product_model');
                $data['wish_pid'] = $this->product_model->getUsersWishlist();
                $data['getContact'] = $this->contact->getContact();
                $data['home_url'] = base_url().'home';
                $data['de_currency'] = $this->home->defualtCurrency();
                $this->de_currency = $data['de_currency'][0]->value;
                $this->session->set_userdata('de_currency',$this->de_currency);
                $this->load->model('frontend/product_model','product_model');
                $data['CategoryHighrstProduct'] = $this->product_model->getCategoryHighrstProduct();
                $data['appLinks'] = $this->common_model->getCommonKeysAndLink();
                // echo '<pre>';
                // print_r($data['appLinks']);die;
                $my_cart = $this->product_model->getMyCart();
                // echo $this->db->last_query();die;
                $default_product_image = $this->common_model->default_product_image();
                foreach ($my_cart as $key => $value) {
                     $product_image = $this->product_model->GetUsersProductInCart($value->product_id,$value->product_weight_id);
                     if(!file_exists('public/images/'.$this->folder.'product_image/'.$product_image[0]->image) || $product_image[0]->image == '' ){
                        $product_image[0]->image = $default_product_image;
                  }
                  $my_cart[$key]->product_name = $product_image[0]->name;
                  $my_cart[$key]->image = $product_image[0]->image;
                }
                $data['mycart'] = $my_cart;
                // print_r($data['mycart']);die;
                return $this->load->view($layout,$data);
        }

    }


    

class Staff_Controller extends MY_Controller{

  
    function __construct()
    {
        parent::__construct();
        if(strpos($_SERVER['REQUEST_URI'], 'api_v2')  !== false ) {                 
                
                 $this->load->model('api_v2/staff_api_model','this_model');              
            }else{                
                 $this->load->model('staff_api_model','this_model');   
            }
       
        ini_set('max_execution_time', '0'); // for infinite time of execution 
        ini_set("memory_limit", "-1");

         if(($this->router->fetch_method () != 'login') && ($this->router->fetch_method () != 'send_notification')&& ($this->router->fetch_method () != 'check_otp')&& ($this->router->fetch_method () != 'logout') && ($this->router->fetch_method () != 'update_userDetail')){



            $validate = $this->this_model->token_validate();

            if($validate==false){

                $response = array('status' => 5, 'message' => "Invalid Authentication");

                $this->response($response);

            }

        }

    }

    /* Require Field Validation
    ** Date : 14-05-2021
    ** Created By : cmexpertiseinfotech Ahmedabad
    ** Devloper : Maulik Nagar
    */
    protected function checkRequiredField($request_params = array(), $require = array()) {
        $error_flag = 0;
        $status = 1;
        $msg = array();
        foreach ($require as $key => $val) {
            if (!isset($_POST[$val]) || $request_params[$val] == '') {
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
        ** Date : 14-05-2021
        ** Created By : cmexpertiseinfotech Ahmedabad
        ** Devloper : Maulik Nagar
        */
        protected function response($response) {
            $response = json_encode($response);
            $response = str_replace('null', "\"\"", $response);
            echo $response;
            die;
        }

}

class Api_Controller extends MY_Controller{

  
    function __construct()
    {
        parent::__construct();

        if(strpos($_SERVER['REQUEST_URI'], 'api_v2')  !== false ) {                
                $this->load->model('api_v2/api_admin_model','this_model');   
            }else{
                $this->load->model('api_admin_model','this_model');   
            }

            
        ini_set('max_execution_time', '0'); // for infinite time of execution 
        ini_set("memory_limit", "-1");

        //  if(($this->router->fetch_method () != 'check_login') && ($this->router->fetch_method () != 'send_notification')&& ($this->router->fetch_method () != 'check_otp')&& ($this->router->fetch_method () != 'logout') && ($this->router->fetch_method () != 'verifyAccount')){



        //     $validate = $this->this_model->token_validate();
        //     if($validate==false){

        //         $response = array('status' => 5, 'message' => "Invalid Authentication");

        //         $this->response($response);

        //     }

        // }

    }

    /* Require Field Validation
    ** Date : 14-05-2021
    ** Created By : cmexpertiseinfotech Ahmedabad
    ** Devloper : Maulik Nagar
    */
    protected function checkRequiredField($request_params = array(), $require = array()) {
        $error_flag = 0;
        $status = 1;
        $msg = array();
        foreach ($require as $key => $val) {
            if (!isset($_POST[$val]) || $request_params[$val] == '') {
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
        ** Date : 14-05-2021
        ** Created By : cmexpertiseinfotech Ahmedabad
        ** Devloper : Maulik Nagar
        */
        protected function response($response) {
            $response = json_encode($response);
            $response = str_replace('null', "\"\"", $response);
            echo $response;
            die;
        }

}

class Apiuser_Controller extends MY_Controller{

  
    function __construct()
    {
        parent::__construct();
      
        // $this->load->model('api_admin_model','this_model');   
        // ini_set('max_execution_time', '0'); // for infinite time of execution 
        // ini_set("memory_limit", "-1");

        //  if(($this->router->fetch_method () != 'check_login') && ($this->router->fetch_method () != 'send_notification')&& ($this->router->fetch_method () != 'check_otp')&& ($this->router->fetch_method () != 'logout') && ($this->router->fetch_method () != 'update_userDetail')){



        //     $validate = $this->this_model->token_validate();
        //     if($validate==false){

        //         $response = array('status' => 5, 'message' => "Invalid Authentication");

        //         $this->response($response);

        //     }

        // }

    }

    /* Require Field Validation
    ** Date : 14-05-2021
    ** Created By : cmexpertiseinfotech Ahmedabad
    ** Devloper : Maulik Nagar
    */
    protected function checkRequiredField($request_params = array(), $require = array()) {
        $error_flag = 0;
        $status = 1;
        $msg = array();
        foreach ($require as $key => $val) {
            if (!isset($_POST[$val]) || $request_params[$val] == '') {
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
        ** Date : 14-05-2021
        ** Created By : cmexpertiseinfotech Ahmedabad
        ** Devloper : Maulik Nagar
        */
        protected function response($response) {
            $response = json_encode($response);
            $response = str_replace('null', "\"\"", $response);
            echo $response;
            die;
        }

}

    
?>
