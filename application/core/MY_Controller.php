<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public $json_response = null;
    public $user_id = null;
    
    function __construct(){

        parent::__construct();
       
        $this->json_response = array('status' => 'error', 'message' => 'something went wrong!');
        // print_r($_SESSION);
         if(isset($_SESSION['My_cart']) && count($_SESSION['My_cart']) == 0 ){
                $this->session->unset_userdata('My_cart');
            }

            
           if( strpos($_SERVER['REQUEST_URI'], 'api_v2')  === TRUE )  
            { 

                require_once APPPATH . 'config/tablenames_constants.php';  
                $this->load->model('api_v2/common_model','common_model');

                $siteDetail = $this->common_model->getLogo();
                
                if(isset($siteDetail['id'])){
                    $this->session->set_userdata('vendor_id',$siteDetail['id']);
                }
                $this->siteLogo = $siteDetail['logo']; 
                $this->siteTitle = $siteDetail['webTitle'];
                $this->siteFevicon = $siteDetail['favicon_image']; 
                $this->folder = $siteDetail['folder'];
                $this->siteCurrency = $this->common_model->getDefaultCurrency();
            
                $this->countCategory = $this->common_model->CountCategory();
                $this->CountSubcategory = $this->common_model->CountSubCategory();
                $common_keys = $this->common_model->getCommonKeysAndLink();
                if(!empty($common_keys)){
                    $this->common_keys = $common_keys;
                }
                $this->adminNotification = $this->common_model->getAdminNotification();



            }else{

                require_once APPPATH . 'config/tablenames_constants.php';  
                    $this->load->model('api_v3/common_model','common_model');

                $siteDetail = $this->common_model->getLogo();
                
                if(isset($siteDetail['id'])){
                    $this->session->set_userdata('vendor_id',$siteDetail['id']);
                }
                $this->siteLogo = $siteDetail['logo']; 
                $this->siteTitle = $siteDetail['webTitle'];
                $this->siteFevicon = $siteDetail['favicon_image']; 
                $this->folder = $siteDetail['folder'];
                $this->siteCurrency = $this->common_model->getDefaultCurrency();
            
                $this->countCategory = $this->common_model->CountCategory();
                $this->CountSubcategory = $this->common_model->CountSubCategory();
                $common_keys = $this->common_model->getCommonKeysAndLink();
                if(!empty($common_keys)){
                    $this->common_keys = $common_keys;
                }
                $this->adminNotification = $this->common_model->getAdminNotification();
            }
           
          
            

    }

    function loadView($layout,$data){
       $this->load->model('frontend/vendor_model','vendor_model');
       $data['ApprovedBranch'] = $this->vendor_model->ApprovedVendor();
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
        
        }   
    }

}
    class User_Controller extends MY_Controller
    {

        function __construct()
        { 
            parent::__construct();
           
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

            if($this->session->userdata('vendor_id')=='' ||$this->session->userdata('vendor_id')==NULL){

                $this->load->model($this->myvalues->vendorFrontEnd['model'],'vendor_model');
                $data['branch'] = $this->vendor_model->branchList();
    
                $branch_id = count($data['branch']);
                foreach ($data['branch'] as $key => $value) {
                    $data['branch'][$key]->product_count = $this->vendor_model->branchProductCount($value->id);
                };
                $Approved = $this->vendor_model->ApprovedVendor();
                // dd($Approved);
                if($Approved[0]->approved_branch == '1'){
                    $branch_id = $data['branch'][0]->id;
                    $branch_name = $data['branch'][0]->name;
                    $this->load->model('vendor_model','vendor');

                    $branch = array('branch_id'=>$branch_id,
                                    'branch_name' => $branch_name,
                                    'vendor_id'=>$data['branch'][0]->vendor_id
                                    );

                    $this->session->set_userdata($branch);
            
                    if($this->session->userdata('branch_id') !== $branch_id){
                        $result = $this->this_model->MyCartRemove();    
                        $this->session->unset_userdata('My_cart');
                    }
            
                   
                }else{
                     $branch = array('vendor_id'=>$data['branch'][0]->vendor_id);
                     $this->session->set_userdata($branch);
                }
            }
        }

       function loadView($layout,$data){
                $this->load->model($this->myvalues->contactFrontEnd['model'],'contact');
                $this->load->model($this->myvalues->homeFrontEnd['model'],'home');
                // $this->load->model($this->myvalues->usersAccount['model'],'users');
                $this->load->model('users_account/users_model','users');
                
                if($this->session->userdata('user_id') != ''){
                     
                        $userInfo = $this->users->getUserDetails();
                            $_SESSION['user_name'] = $userInfo[0]->fname;
                            $_SESSION['user_lname'] = $userInfo[0]->lname;
                            $_SESSION['user_phone'] = $userInfo[0]->phone; 
                
                }
                $this->load->model('frontend/vendor_model','vendor_model');
                $data['branch_nav'] = $this->vendor_model->branchList();
                $data['ApprovedBranch'] = $this->vendor_model->ApprovedVendor();
                // dd($data['ApprovedBranch']);die;
                $this->load->model('frontend/product_model','product_model');
                $data['wish_pid'] = $this->product_model->getUsersWishlist();
                $data['getContact'] = $this->contact->getContact();
                $data['home_url'] = base_url().'home';
                $data['de_currency'] = $this->home->defualtCurrency();
                if(!empty($data['de_currency'])){
                    $this->de_currency = $data['de_currency'][0]->value; 
                    $this->session->set_userdata('de_currency',$this->de_currency);
                }
                $this->load->model('frontend/product_model','product_model');
                $data['CategoryHighrstProduct'] = $this->product_model->getCategoryHighrstProduct();
                $data['appLinks'] = $this->common_model->getCommonKeysAndLink();
                
             
                
                $my_cart = $this->product_model->getMyCart();
                $default_product_image = $this->common_model->default_product_image();

                $this->load->model('api_v3/common_model','co_model');
                $isShow = $this->co_model->checkpPriceShowWithGstOrwithoutGst($this->session->userdata('vendor_id'));

                foreach ($my_cart as $key => $value) {

                    if(!empty($isShow) && $isShow[0]->display_price_with_gst == '1'){
                        $value->discount_price = $value->without_gst_price;
                    }

                    $product_image = $this->product_model->GetUsersProductInCart($value->product_weight_id);
                    
                     if(!file_exists('public/images/'.$this->folder.'product_image/'.$product_image[0]->image) || $product_image[0]->image == '' ){
                        if(strpos($product_image[0]->image, '%20') === true || $product_image[0]->image == ''){
                            $product_image[0]->image = $default_product_image;
                        }else{
                            $product_image[0]->image = $default_product_image;
                        }
                     }

                  $my_cart[$key]->product_name = $product_image[0]->name;
                  $my_cart[$key]->image = $product_image[0]->image;
                }
                $data['mycart'] = $my_cart;
                $data['notification'] = $this->common_model->userNotify();
                $data['userInformation'] = $this->users->getUserDetails();
                // dd($data['userInformation']);die;
                return $this->load->view($layout,$data);
        }

    }


    

class Staff_Controller extends MY_Controller{

  
    function __construct()
    {
        parent::__construct();


          if( strpos($_SERVER['REQUEST_URI'], 'api_v2')  === TRUE )  
            { 
                $this->load->model('api_v2/staff_api_model','this_model');   

            } else{                
                 $this->load->model('api_v3/staff_api_model','this_model');              
                    
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
        if( strpos($_SERVER['REQUEST_URI'], 'api_v2')  === TRUE )  
        {
            $this->load->model('api_v2/api_admin_model','this_model');   
        }else{
            $this->load->model('api_v3/api_admin_model','this_model');   

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
