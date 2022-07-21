<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        require_once APPPATH . 'config/tablenames_constants.php';
        $this->load->model('vendor_model','vendor_model');
        $this->load->model('common_model');
        $siteDetail = $this->common_model->getLogo();
      
        $this->siteLogo = $siteDetail['logo'];
        $this->siteTitle = $siteDetail['webTitle'];
        $this->siteFevicon = $siteDetail['favicon_image'];
        $this->folder = $siteDetail['folder'];
        $this->countCategory = $this->common_model->CountCategory();
        $this->adminNotification = $this->common_model->getAdminNotification();

    }
    
    public function not_found()
    {        
        $this->load->view('page_not_found');
    }
    
    public function verifyEmailstatus(){
    $this->load->view('verifyEmailstatus');
    }

    public function QueryMesageToSuperAdmin(){
        if($this->input->post()){
            $data['vendor'] = $this->vendor_model->sendEmailMessage();
            $data['subject'] = $this->input->post('subject');
            $data['vendor_message'] = $this->input->post('message');
            $mail['message'] = $this->load->view('emailTemplate/queryMessageTemplate',$data,true);
            // $data['to'] = 'cmexpertise@gmail.com';
            $mail['subject'] = $this->input->post('subject');
            $mail['to'] = 'cmexpertise@gmail.com';
            sendMail($mail);
            $this->utility->setFlashMessage('success','Your email suucesfully send to admin');
            redirect(base_url().'admin/dashboard');
        }
    }

    public function AccessVendor(){
      
        if($this->input->post()){
            $vendor = $this->input->post('vendor_id');
            if($vendor != 'vendor_admin'){
                $res = $this->vendor_model->getAllVendor($this->input->post());
            
                $this->session->unset_userdata('vendor_admin');
                $this->session->unset_userdata('super_id');
                $this->session->unset_userdata('branch_admin');
                $this->session->unset_userdata('vendor_admin_id');
                $this->session->unset_userdata('branch_vendor_id');
                $this->session->unset_userdata('id');
                $this->session->unset_userdata('name');
                $this->session->unset_userdata('email');
                $this->session->unset_userdata('phone');
                $this->session->unset_userdata('logged_in');

                $login_data = array(
                    'branch_admin'=>TRUE,
                    'id' => $res[0]->id,
                    'branch_vendor_id'=> $res[0]->vendor_id,
                    'name' => $res[0]->owner_name,
                    'email' => $res[0]->email,
                    'phone' => $res[0]->phone_no,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($login_data);
                
            }else{

            $flag = $this->session->userdata('flag');
            $result_login = $this->db->query("SELECT * FROM `vendor` WHERE id='$flag'");
            $row_login = $result_login->row_array();
                $this->session->unset_userdata('branch_admin');
                $this->session->unset_userdata('id');
                $this->session->unset_userdata('branch_vendor_id');
                $this->session->unset_userdata('name');
                $this->session->unset_userdata('phone');
                $this->session->unset_userdata('email');
                $this->session->unset_userdata('logged_in');
          
            if ($result_login->num_rows() > 0) {
                if($row_login['type']=='1'){

                    $login_data = array(
                        'vendor_admin' => TRUE,
                        'super_id' => $row_login['id'],
                        'id' => '0',
                        'vendor_admin_id'=>$row_login['id'],
                        'name' => $row_login['name'],
                        'email' => $row_login['email'],
                        'phone' => $row_login['phone_no'],
                        'logged_in' => TRUE,
                        'flag' => $row_login['id'],
                        'type' => $row_login['type']
                    );
                }
                    $this->session->set_userdata($login_data);
            }
        }
    }
}
    public function index(){
      
        $this->load->model('vendor_model');
        $data['grap'] = json_encode($this->vendor_model->getChartData());

        $this->load->view('dashboard',$data);
    }
    public function change_delivery_type(){

        $this->load->model('vendor_model');
        $this->vendor_model->change_delivery_type();

    }

    public function login(){  
          
        if(isset($_SESSION['super_admin']) || isset($_SESSION['vendor_admin'])){
            redirect(base_url().'admin/dashboard');
        }  
        $this->load->view('login');
    }

    public function dashboard()
    { 
        // dd($_SESSION);
        $this->load->model('dashboard_model','this_model');
        $data['total_order_monthly'] = $this->this_model->total_order_month();
        $data['total_order'] = $this->this_model->total_order_today();
        $data['total_order_delt'] = $this->this_model->total_order();

        // $data['total_product_result'] = $this->this_model->total_product_query();
        // $data['total_category_result'] = $this->this_model->total_category_query();
        // $data['total_brand_result'] = $this->this_model->total_brand_query();
       
        $data['total_registered_user'] = $this->this_model->total_registered_user_query();
        $data['total_delivered'] = $this->this_model->total_delivered_query();
        $data['total_sales'] = $this->this_model->total_sales_query();
        $data['total_sales']['sales'] = number_format($data['total_sales']['sales'],2,'.','');
        $data['total_pending_order'] = $this->this_model->total_pending_order_query();
        $data['total_pending_payment'] = $this->this_model->total_pending_payment_query();
        $data['total_return_order'] = $this->this_model->total_return_order_query();
        // print_r($data['total_return_order']);die;
        $data['total_return_payment'] = $this->this_model->total_return_payment_query();
        $data['daily_order_Status'] = $this->this_model->daily_order_Status_query(); 
        $data['daily_order_Status_user_name'] = $this->this_model->daily_order_Status_user_name_query(); 
      
       
        $data['table_js'] = array('admin.js');
         
        $this->load->view('dashboard',$data);
    }

    public function profile(){
        $this->load->model('vendor_model');
        $email = $this->session->userdata('email');
        $vendor_id = $this->session->userdata['vendor_admin_id'];
        $data['currency'] = $this->vendor_model->getCurrency();
        $data['app_result'] = $this->vendor_model->vendorByIdEmail($email); 
        $this->load->view('profile',$data);
    }

     public function update_password(){
        $this->load->view('update_password');
    }

    public function user_list()
    { 
        if($this->session->userdata('vendor_admin') != '1' ){
                redirect(base_url().'admin/dashboard');
        }

        $this->load->model('Vendor_model','vendor_model');
        $data['user_result'] = $this->vendor_model->userList();
        $data['table_js'] = array('user.js');
        $data['start'] = array('USER.table()');
        $this->load->view('user_list',$data);
    }

    public function getAjaxTableUsers(){
        if($this->input->post()){
           echo getUsersList($this->input->post());
        }
    }
    
    public function genrate_excel()
    {
        $listInfo = $this->vendor_model->userList();
        //print_r($items);
        
        $filename = "userData-".date('d-m-Y').".xls";

        $this->load->library('excel');
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'First Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Last Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Phone Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Register Date');       
        // set Row
        $rowCount = 2;
        foreach ($listInfo as $list) {
          
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $list->fname);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list->lname);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list->email);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list->phone);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, date('Y-m-d H:i',$list->dt_added));
            $rowCount++;
        }
        $filename = "userList". date("Y-m-d-H-i-s").".csv";
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output'); 

    }

    public function user_address_list()
    {
        $this->load->view('user_address_list');
    }

    public function user_address_profile()
    {
        $this->load->view('user_address_profile');
    }

    public function setting_list()
    {
        $this->load->view('setting_list');
    }

    public function setting_profile()
    {
        $this->load->view('setting_profile');
    }

    
    public function discount_list()
    {
        // echo '<pre>';
        // print_r($_SESSION);die;
        if($this->session->userdata('vendor_admin') != '1' ){
                redirect(base_url().'admin/dashboard');
        }
        $this->load->model('Vendor_model','vendor_model');
        $data['discount_result'] = $this->vendor_model->getDicount();
        $data['table_js'] = array('discount.js');
        $data['start'] = array('DISCOUNT.table()');
        $this->load->view('discount_list',$data);
    }

    public function getAjaxDiscount(){
        if($this->input->post()){
            echo getAjaxDiscountList($this->input->post());
        }
    }

    public function discount_profile(){
        if($this->session->userdata('vendor_admin') != '1' ){
                redirect(base_url().'admin/dashboard
                    ');
        }
        $this->load->model('Vendor_model','vendor_model');
        if(isset($_GET['id'])){
            $id = $this->utility->decode($_GET['id']);
        }else{
            $id = '';
        }
        if($id != ''){
            $data['result'] = $this->vendor_model->getDiscount($id);
        }else{
            $data = [];
        }

        $this->load->view('discount_profile',$data);
    }
    public function add_vendor()
    {
        $this->load->view("add_vendor");
    }

    
 
    /////////////////////////////ADMIN/////////////////////////////////////////////////////////////

    ## Check Login  ##
    public function check_login(){   
        $base_url = base_url();
        $email = $_POST['loginemail'];
        $password = md5($_POST['loginpassword']);
        // $domain_name = 
        $result_login = $this->db->query("SELECT * FROM " .TABLE_BRANCH. " WHERE email='$email' AND password ='$password' AND domain_name = '$base_url'"); 
        $row_login = $result_login->row_array();
        if ($result_login->num_rows() > 0) {
            $status = $row_login['status'];
            if($status=='1'){
                $login_data = array(
                    'branch_admin'=>TRUE,
                    'id' => $row_login['id'],
                    'branch_vendor_id'=> $row_login['vendor_id'],
                    'name' => $row_login['owner_name'],
                    'email' => $row_login['email'],
                    'phone' => $row_login['phone_no'],
                    'logged_in' => TRUE
                );
                $this->load->library('session');

                $login_logs = [
                    'user_id' => $row_login['id'],
                    'vendor_id' => $row_login['vendor_id'],
                    'status' => 'login',
                    'type' => 'branch',
                    'dt_created' => DATE_TIME
                ];
                $this->load->model('api_v3/common_model','v2_common_model');
                $this->v2_common_model->user_login_logout_logs($login_logs);

                $this->session->set_userdata($login_data);
                $remember = $_POST['remember'];
                if ($remember!='') {
                    delete_cookie("loginemail");
                    delete_cookie("loginpassword");
          
                    $set_email = array(
                        'name' => 'loginemail',
                        'value' => $_POST['loginemail'],
                        'expire' => '86500',
                        'prefix' => '',
                        'secure' => FALSE
                    );
                    $this->input->set_cookie($set_email);

                    $set_password = array(
                        'name' => 'loginpassword',
                        'value' => $_POST['loginpassword'],
                        'expire' => '86500',
                        'prefix' => '',
                        'secure' => FALSE
                    );
                    $this->input->set_cookie($set_password);
                }
                redirect('admin/dashboard');
            }else{
                $this->session->set_flashdata('msg', 'You are not authorised,Please connect support team.');
                redirect(base_url().'admin/login');
            }
        } else {
           $server_name = $_SERVER["SERVER_NAME"];
           $result_login = $this->db->query("SELECT * FROM `vendor` WHERE email='$email' AND password='$password' AND server_name='$server_name'"); 
            $row_login = $result_login->row_array();
        if ($result_login->num_rows() > 0) {
           
                $login_data = array(
                    'vendor_admin' => TRUE,
                    'super_id' => $row_login['id'],
                    'id' => '0',
                    'vendor_admin_id'=> $row_login['id'],
                    'name' => $row_login['name'],
                    'email' => $row_login['email'],
                    'phone' => $row_login['phone_no'],
                    'logged_in' => TRUE,
                    'flag' => $row_login['id'], // flag is using fo super admin acess to all vendor access
                    'type' => $row_login['type'],
                );
           
             
                $this->load->library('session');
                $login_logs = [
                    'user_id' => $row_login['id'],
                    'vendor_id' => $row_login['id'],
                    'status' => 'login',
                    'type' => 'vendorimage',
                    'dt_created' => DATE_TIME
                ];
                $this->load->model('api_v3/common_model','v2_common_model');
                $this->v2_common_model->user_login_logout_logs($login_logs);

                $this->session->set_userdata($login_data);

                $remember = $_POST['remember'];
                if ($remember!='') {

                    delete_cookie("loginemail");
                    delete_cookie("loginpassword");
          
                    $set_email = array(
                        'name' => 'loginemail',
                        'value' => $_POST['loginemail'],
                        'expire' => '86500',
                        'prefix' => '',
                        'secure' => FALSE
                    );
                    $this->input->set_cookie($set_email);

                    $set_password = array(
                        'name' => 'loginpassword',
                        'value' => $_POST['loginpassword'],
                        'expire' => '86500',
                        'prefix' => '',
                        'secure' => FALSE
                    );
                    $this->input->set_cookie($set_password);
                }

                redirect('admin/dashboard');
                exit;
            }else{
                $result_login = $this->db->query("SELECT * from staff where email='$email' and password='$password'");
                $row_login = $result_login->row_array();
                $ven_id = $row_login['vendor_id'];
                $staff = $this->db->query("SELECT * from vendor where id='$ven_id'");
                $staff_vendor = $staff->row_array();
                // print_r($staff_vendor['status']);die;
                if($staff_vendor['status'] == '0'){
                $this->session->set_flashdata('msg', 'Vendor are Not Activated. Please contact to Head Branch.');
                redirect(base_url().'admin/login');
                exit;
                }


                if ($result_login->num_rows() > 0) {
                    $status = $row_login['status'];
                    if($status=='1'){
                        $login_data = array(
                            
                            'staff_id' => $row_login['id'],
                            'id' => $row_login['branch_id'],
                            'name' => $row_login['name'],
                            'email' => $row_login['email'],
                            'phone' => $row_login['phone'],
                            'logged_in' => TRUE
                        );
                        $this->load->library('session');
                        $this->session->set_userdata($login_data);

                          $remember = $_POST['remember'];
                if ($remember!='') {

                    delete_cookie("loginemail");
                    delete_cookie("loginpassword");
          
                    $set_email = array(
                        'name' => 'loginemail',
                        'value' => $_POST['loginemail'],
                        'expire' => '86500',
                        'prefix' => '',
                        'secure' => FALSE
                    );
                    $this->input->set_cookie($set_email);

                    $set_password = array(
                        'name' => 'loginpassword',
                        'value' => $_POST['loginpassword'],
                        'expire' => '86500',
                        'prefix' => '',
                        'secure' => FALSE
                    );
                    $this->input->set_cookie($set_password);
                }
                        
                        redirect('admin/dashboard');
                    }else{
                        $this->session->set_flashdata('msg', 'You are Not Activated. Please contact to vendor.');
                        redirect(base_url().'admin/login');
                    }
                }else{
                    $this->session->set_flashdata('msg', 'Invalid email or password');
                    redirect(base_url().'admin/login');
                }   
            }
        }
    }

    ## Super Admin - Logout  ##
    public function logout(){

        if(isset($_SESSION['vendor_admin']) && $_SESSION['vendor_admin'] == '1' ){
            $user_id = $this->session->userdata('vendor_admin_id');
            $type = 'vendor';
            $vendor_id = $this->session->userdata('vendor_admin_id');
        }elseif(isset($_SESSION['branch_admin']) && $_SESSION['branch_admin'] == '1' ){
            $user_id = $this->session->userdata('id');
            $type = 'branch';
            $vendor_id = $this->session->userdata('branch_vendor_id');
        }

        $login_logs = [
            'user_id' => $user_id,
            'vendor_id' =>  $vendor_id,
            'status' => 'logout',
            'type' => $type,
            'dt_created' => DATE_TIME
        ];
        $this->load->model('api_v3/common_model','v2_common_model');
        $this->v2_common_model->user_login_logout_logs($login_logs);


        $this->session->unset_userdata('type');
        $this->session->unset_userdata('flag');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('vendor_id');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('phone');
        $this->session->unset_userdata('super_admin');
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('super_id');
        $this->session->unset_userdata('staff_id');
        $this->session->unset_userdata('delivery_admin');
        $this->session->unset_userdata('delivery_id');
        $this->session->unset_userdata('vendor_admin_id');
        $this->session->unset_userdata('My_cart'); //frontend
        $this->session->unset_userdata('vendor_admin'); //frontend
        $this->session->unset_userdata('branch_admin'); //frontend
        $this->session->unset_userdata('redirect_page'); //frontend


        // $this->session->sess_destroy();
        redirect('admin/login');
    }

    ## Profile Update  ##
    public function update_profile()
    {   
        // error_reporting(E_ALL);
       // dd($_POST);
        if(isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Update'){

            $branch_id = $this->session->userdata['id'];
            $id = $this->input->post('app_id');
            $name = $this->input->post('fname');
            $phone = $this->input->post('phone');
            $selfPickUp = $this->input->post('selfPickUp');
            $selfPickupOpenClosingTiming = $this->input->post('selfPickupOpenClosingTiming');
            $currency_code = trim($this->input->post('currency_code'));
            $branch_id = $this->session->userdata['id']; 

            if($branch_id != 0){ 
                $ownername = $this->input->post('ownername');
                if(isset($_FILES) && ($_FILES['vendorimage']['name'] != '')){
                $path = 'public/images/'.$this->folder.'vendor_shop';
                $result = upload_single_image_Byname($_FILES,'image',$path);
                   $vendorimage = $result['data']['file_name'];
                   
                }else{
                    $vendorimage =  $this->input->post('old_file');
                } 

                if(isset($_FILES) && ($_FILES['default_image']['name'] != '')){
                    $path = 'public/images/'.$this->folder.'product_image';
                    $result = upload_single_image_Byname($_FILES['default_image'],'default_image',$path);
                    $default_image = $result['data']['file_name'];
                    
                    $default_old_file =  $this->input->post('default_old_file');
                    if(file_exists($path.'/'.$default_old_file));{
                        delete_single_image($path,$default_old_file);
                    }

                }else{
                    $default_image =  $this->input->post('default_old_file');
                } 

                $address = $this->input->post('address');
                $location = $this->input->post('location');
                $latitude = $this->input->post('latitude');
                $longitude = $this->input->post('longitude');
                $isOnlinePayment = $this->input->post('isOnlinePayment');
                $isCOD = $this->input->post('isCOD');
                $whatsappFlag = $this->input->post('whatsapp_share');
                $data = array(
                    'name' => $ownername,
                    'phone_no' => $phone,
                    'owner_name' => $name,
                    'currency_code'=>$currency_code,
                    'address' => $address,
                    'location' => $location,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'image' => $vendorimage,
                    'selfPickUp'=>$selfPickUp,
                    'isCOD'=>$isCOD,
                    'whatsappFlag' =>$whatsappFlag,
                    'product_default_image'=>$default_image,
                    'isOnlinePayment'=>$isOnlinePayment,
                    'selfPickupOpenClosingTiming'=>$selfPickupOpenClosingTiming,
                    'gst_number'=>(!isset($_POST['gst_number']) ? '' : $_POST['gst_number']),
                    'dt_updated' => date('Y-m-d H:i:s')
                );  
              
            }else{
                $folder_name = $this->input->post('folder_name');
                $path = "./public/images/".$folder_name;
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);        
                }
                $folder_array = ['banner_promotion','banner_promotion_thumb','category','category_thumb','delivery_profile','product','product_image','product_image_thumb','product_thumb','vendor_logo_image','vendor_shop','web_banners','web_banners_thumb'];

                foreach ($folder_array as $key => $value) {
                    $new_path = $path.'/'.$value;
                    if (!file_exists($new_path)) {
                        mkdir($new_path, 0777, true);        
                    }  
                }

                if($_FILES['webLogo']['name'] != '' && $_FILES['webLogo']['error'] == 0){
                    $path = 'public/client_logo';
                    $files = $_FILES;
                    $result = upload_single_image_ByName($_FILES,'webLogo',$path);
                    $webLogo = $result['data']['file_name'];
                    if(file_exists($path.'/'.$this->input->post('old_webLogo')));{
                        delete_single_image($path,$this->input->post('old_webLogo'));
                    }
                }else{
                    $webLogo =  $this->input->post('old_webLogo');
                }

                if($_FILES['favicon_image']['name'] != '' && $_FILES['favicon_image']['error'] == 0 ){
                    $path = 'public/client_logo'; 
                    $result = upload_single_image_ByName($_FILES,'favicon_image',$path);
                    $favicon_image = $result['data']['file_name'];
                    if(file_exists($path.'/'.$this->input->post('old_favicon')));{
                        delete_single_image($path,$this->input->post('old_favicon'));
                    }
                }else{
                    $favicon_image =  $this->input->post('old_favicon');
                }
    
                $data = array(
                    'name' => $name,
                    'phone_no' => $phone,
                    'webLogo'=> $webLogo,
                    'favicon_image'=>$favicon_image,
                    'img_folder'=>$this->input->post('folder_name'),
                    'android_version'=>$this->input->post('android_version'),
                    'android_isforce'=>$this->input->post('android_isforce'),
                    'ios_version'=>$this->input->post('ios_version'),
                    'ios_isforce'=>$this->input->post('ios_isforce'),
                    'display_price_with_gst' =>$this->input->post('display_price_with_gst'),
                    'dt_updated' => date('Y-m-d H:i:s')
                );
            }

            
          
            $branch_id = $this->session->userdata['id'];
            if($branch_id == 0){

            $this->db->where('id', $id);
            $this->db->update('vendor', $data);
            }else{
                
            $this->db->where('id',$branch_id);
            $this->db->update('branch', $data);
            // echo $this->db->last_query();die;

            }

             $login_data = array(
               
                'name' => $name,
                
                'logged_in' => TRUE
            );
            $this->load->library('session');
            $this->session->set_userdata($login_data);

           

            $this->session->set_flashdata('msg', 'Profile has been updated successfully.');
            redirect(base_url().'admin/profile');
        }
        else{

            $this->session->set_flashdata('msg', 'Profile has not been updated.');
            redirect(base_url().'admin/profile');
        }
    }

    ## Forgot Password ##
   public function forgot_password(){

        if(isset($_REQUEST['submit']) ){

            $email = $_REQUEST['email_forgot'];
            $query = $this->db->query("SELECT COUNT(*) as total FROM vendor WHERE email = '$email'");
            $result = $query->row_array();
            // echo $this->db->last_query();
            // print_r($result);die;
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
                $this->db->update('vendor', $data);
            }else{
                $query = $this->db->query("SELECT COUNT(*) as total FROM branch WHERE email = '$email'");
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
                    $this->db->update('branch', $data);
                }else{
                    $query = $this->db->query("SELECT COUNT(*) as total FROM staff WHERE email = '$email'");
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
                        $this->db->update('staff', $data);
                    }else{
                        $this->session->set_flashdata('not_registered', 'Your email is not registered with us.');
                        redirect(base_url().'admin/login');
                        exit;       
                    }
                }
            }

                $subject = 'Forgot Password';
                $message = 'Your Password is : '.$ran_digit;

                $this->load->library('email');
                $config['protocol'] = "smtp";
                $config['smtp_host'] = "162.241.86.206";
                $config['smtp_port'] = '587';
                $config['smtp_user'] = "test@launchestore.com";
                // $config ['smtp_user'] = "sahid.cmexpertise@gmail.com";
                $config['smtp_pass'] = "HhZ~sU(@drk_";
                $config['smtp_timeout'] = 20;
                $config['priority'] = 1;
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = TRUE;
                $config['crlf'] = "\r\n";
                $config['newline'] = "\r\n";
                $config['mailtype'] = "html";
                $CI = & get_instance();
               
                $CI->load->library('email', $config);
                $CI->email->initialize($config);
                $CI->email->clear();
                $CI->email->from($config['smtp_user'], $this->siteTitle);
                $CI->email->to($email);
                
                $CI->email->reply_to($config['smtp_user'], '<noreply@stagegator.com>');
                $CI->email->subject($subject);

                $CI->email->message($message);
                $response = $CI->email->send();
                $this->utility->setFlashMessage('success','New password has been sent successfully on your email id.');
                redirect(base_url().'admin/login');
            
        }

    }

    ## Change Password  ##
    public function change_password(){

        // print_r($_POST);exit;
        if(isset($_POST)){

            $id = $_POST['appid'];

            $old_pass = md5($_POST['old_pass']);
            $new_pass = $_POST['new_pass'];
            $confirm_pass = $_POST['confirm_pass'];
            $np = md5($new_pass);
            $vendor_id = $this->session->userdata['id'];
            
            if($vendor_id==0){
                $tablename= "vendor";
            }else{
                $tablename= "branch";
            }
            $old_password_query = $this->db->query("SELECT password FROM $tablename WHERE id = '$id'");
            $old_password_result = $old_password_query->row_array();
            $old_password = $old_password_result['password'];
          
                if($old_pass == $old_password){
            if($old_password != $np){


                    if($new_pass == $confirm_pass){

                       
                        echo 1;
                        exit();
                    }else{

                       
                        echo 3;
                        exit();
                    }
                }else{

                  
                echo 4;
                    exit();
                }
            }else{
                // echo $old_pass.','.md5($new_pass);
                    echo 2;
                    exit();
            }
        }
    }

    public function changed_password(){

        if(isset($_POST)){

            $id = $_POST['appid'];

            $old_pass = md5($_POST['old_pass']);
            $new_pass = $_POST['new_pass'];
            $confirm_pass = $_POST['confirm_pass'];
            $np = md5($new_pass);
            $vendor_id = $this->session->userdata['id'];

             if($vendor_id==0){
                $tablename= "vendor";
             }else{
                $tablename= "branch";
             }
         
            

            $data = array( 'password' => md5($new_pass), 'dt_updated' => date('Y-m-d H:i:s'));           
            $this->db->where('id', $id);               
            $this->db->update($tablename, $data);
   
            $this->session->set_flashdata('msg', 'Password has been updated successfully.');
            echo 1;
            exit();


        }
    }

    ///////////////////////////////////////////////////USER/////////////////////////////////////////////////////////////

    # Single Delete User ##
    public function single_delete_user()
    {
        $id = $_REQUEST['id'];
        $dt_updated = strtotime(date('Y-m-d H:i:s'));
        $data = array( 'status' => '9','dt_updated' => strtotime(date('Y-m-d H:i:s')));

        $this->db->where('id', $id);
        $this->db->update('user', $data);

        /*Delete User Address*/
        $this->db->query("UPDATE user_address SET status = '9', dt_updated = '$dt_updated' WHERE user_id = '$id'");

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    ## Multi Delete User ##
    public function multi_delete_user()
    {
        $id = $_REQUEST['ids'];
        $date = strtotime(date('Y-m-d H:i:s'));

        $this->db->query("UPDATE user SET status = '9', dt_updated = '$date' WHERE id IN ($id)");

        /*Delete User Address*/
        $this->db->query("UPDATE user_address SET status = '9', dt_updated = '$date' WHERE user_id IN ($id)");

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

   

    ## User Address Add | Update ##
    public function user_address_add_update(){

        if(isset($_REQUEST['submit']) ){

            $id = $_REQUEST['id'];
            $user_id = $_REQUEST['user_id'];
            $address = $_REQUEST['address'];
          
            
                 $geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&key=AIzaSyBW43KgTNs_Kusuvbian6KYGi_QzXOLS4w'.'&sensor=false');
            // $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');
            $output= json_decode($geocode);

            $lat = $output->results[0]->geometry->location->lat;
            $long = $output->results[0]->geometry->location->lng;

            /*Update User Address*/
            if($id != ''){

                $data = array(
                    'user_id' => $user_id,
                    'address' => $address,
                    'latitude' => $lat,
                    'longitude' => $long,
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $this->db->where('id', $id);
                $this->db->update('user_address', $data);
                $this->session->set_flashdata('msg', 'Address has been updated successfully');
                redirect(base_url() . 'admin/user_address_list?user_id='.$this->utility->encode($user_id));
                exit();
            }
            /*Add User Address*/
            else{

                $data = array(
                    'user_id' => $user_id,
                    'address' => $address,
                    'latitude' => $lat,
                    'longitude' => $long,
                    'status' => '1',
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $this->db->insert('user_address', $data);
                $this->session->set_flashdata('msg', 'Address has been added successfully');
                redirect(base_url() . 'admin/user_address_list?user_id='.$this->utility->encode($user_id));
                exit();
            }
        }
    }

    # USer Address Single Delete ##
    public function single_delete_user_address()
    {
        $id = $_REQUEST['id'];
        $data = array( 'status' => '9','dt_updated' => strtotime(date('Y-m-d H:i:s')));

        $this->db->where('id', $id);
        $this->db->update('user_address', $data);

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    ## User Address Multi Delete ##
    public function multi_delete_user_address()
    {
        $id = $_REQUEST['ids'];
        $date = strtotime(date('Y-m-d H:i:s'));

        $this->db->query("UPDATE user_address SET status = '9', dt_updated = '$date' WHERE id IN ($id)");

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

   

    ## Setting Add Update ##
    public function setting_add_update(){

        $id = $_REQUEST['id'];
        $title = $_REQUEST['title'];
        $price = number_format((float)$_REQUEST['price'], 2, '.', '');

        if(isset($_REQUEST['submit'])) {

            /* Price Update */
            if ($id != '') {

                $data = array(
                    'title' => $title,
                    'price' => $price,
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $this->db->where('id', $id);
                $this->db->update('setting', $data);
                $this->session->set_flashdata('msg', 'Setting has been updated successfully');
                redirect(base_url() . 'admin/setting_list');
                exit();
            }
            /* Price Add */
            else {

                $data = array(
                    'title' => $title,
                    'price' => $price,
                    'status' => '1',
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $this->db->insert('setting', $data);
                $this->session->set_flashdata('msg', 'Setting has been added successfully');
                redirect(base_url() . 'admin/setting_list');
                exit();
            }
        }
    }

    # Setting Single Delete ##
    public function single_delete_setting()
    {
        $id = $_REQUEST['id'];
        $data = array( 'status' => '9','dt_updated' => strtotime(date('Y-m-d H:i:s')));

        $this->db->where('id', $id);
        $this->db->update('setting', $data);

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    ## Setting Multi Delete ##
    public function multi_delete_setting()
    {
        $id = $_REQUEST['ids'];
        $date = strtotime(date('Y-m-d H:i:s'));

        $this->db->query("UPDATE setting SET status = '9', dt_updated = '$date' WHERE id IN ($id)");

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    ///////////////////////////////////////////////////ORDERS///////////////////////////////////////////////////////////

    # Setting Single Delete ##
  
    //////////////////////////////////////////////////PRICE/////////////////////////////////////////////////////////////

    ## Discount Add Update ##
    public function discount_add_update(){
        $this->load->model('vendor_model','vendor_model');
        if($this->input->post()){
            $this->vendor_model->discount_add_update($this->input->post());
        }
    }

    # Discount Single Delete ##
    public function single_delete_discount()
    {
       if($this->input->get()){
            $this->vendor_model->single_delete_discount($this->input->get());
       }
    }

    ## Discount Multi Delete ##
    public function multi_delete_discount()
    {
        $id = $_REQUEST['ids'];
        $date = strtotime(date('Y-m-d H:i:s'));

        $this->db->query("UPDATE discount SET status = '9', dt_updated = '$date' WHERE id IN ($id)");

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    public function admin_notification(){
        $this->load->model('common_model');
        $res = $this->common_model->adminNotify();
        $html = '';
        foreach ($res as $key => $value) {
            $html .= '<li>'.$value->message.'</li>';
        }
        if(count($res) == '0'){
            $html .= '<li>No Notification</li>';
        }else{
            $html .='<li id="clear_all">Clear All</li>';
        }
        echo json_encode(['notify'=>$html,'count'=>count($res)]);
    }

    public function read_all(){
            $this->load->model('common_model');
            $res = $this->common_model->read_all();
            $html = '';
            foreach ($res as $key => $value) {
                $html .= '<li>'.$value->message.'</li>';
            }
            if(count($res) == '0'){
                $html .= '<li>No Notification</li>';
            }else{
                $html .='<li id="clear_all">Clear All</li>';
            }
        echo json_encode(['notify'=>$html,'count'=>count($res)]);
    }  
}
?>