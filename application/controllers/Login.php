<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends User_Controller {

	function __construct(){
		parent::__construct();
		$this->controller = $this->myvalues->loginFrontEnd['controller'];
		$this->load->model($this->myvalues->loginFrontEnd['model'],'this_model');
		$user_id = $this->session->userdata('user_id');
		$this->user_id = $this->session->userdata('user_id');
		include_once APPPATH . "libraries/vendor/autoload.php";
		
		if($this->session->userdata('user_id') == ''){
			if(isset($_SESSION['My_cart']) && !empty($_SESSION['My_cart'])){
				$this->cartCount = count($_SESSION['My_cart']);

			}
		}else{
			$this->load->model('frontend/product_model','product_model');
			$my_cart = $this->product_model->getMyCart();
			$this->cartCount = count($my_cart);
		}
		$this->load->model('frontend/product_model');
		$this->load->model('common_model','common_model');
		$my_cart = $this->product_model->getMyCart();
		
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
	}


	public function index(){
		$login_type = $this->this_model->checkLoginType();
		if($login_type == '1'){
			redirect(base_url().'login/user_register');
			die;
		}

		if(isset($this->user_id) && $this->user_id != ''){
			redirect(base_url());
		}

		$data['appLinks'] = $this->common_keys;
		$data['page'] = 'frontend/account/login';
		$data['js'] = array('login.js');
		$data['init'] = array('LOGIN.login()');	
	    $path = $this->uri->segment(1);

		if(!isset($_SESSION['redirect_page']) && @$_SERVER['HTTP_REFERER'] != base_url().$path){
			$this->session->set_userdata('redirect_page',@$_SERVER['HTTP_REFERER']);
		}
		if($this->input->post()){
			$validation = $this->setRulesLogin();	
				if($validation){
					$result = $this->this_model->login_chek($this->input->post());
					// lq();
					 if(!empty($result)){
					 	if($result[0]->email_verify == '1'){
					 		$login_data = array(
					 			'user_id' => $result[0]->id,
                        'user_name' => $result[0]->fname,
                        'user_lname' => $result[0]->lname,
					 			'user_email' => $result[0]->email,
                        'user_phone' => $result[0]->phone,
					 			'logged_in' => TRUE
					 		); 

					 		$this->session->set_userdata($login_data);
					 		if($this->session->userdata('user_id') != ''){
					 			// $MycartData = $this->this_model->MycartData();
					 			$this->this_model->manageCartItem();	

					 			if(isset($_SESSION['My_cart'][0]['branch_id'])){
					 				$branch_id = $_SESSION['My_cart'][0]['branch_id'];
					 				$this->load->model('frontend/vendor_model','vendor');
					 				$branch = $this->vendor->getVendorName($branch_id);
					 				$branch_name = $branch[0]->name;
					 				$vendor = array(
					 					'branch_id'=>$branch_id,
					 					'vendor_name'=>$branch_name,
					 				);
					 				$this->session->set_userdata($vendor);
					 			}
					 			unset($_SESSION['My_cart']);
					 		}
					 		if($this->session->userdata('redirect_page') != ''){
					 			$p = $this->session->userdata('redirect_page');
					 			redirect($p);
					 		}else{
					 			redirect(base_url().'home');
					 		}

					 	}else{
					 		$token = md5($this->utility->encode($result['email']));
					 		$this->db->set('email_token', $token);
					 		$this->db->where('id', $result['id']);
					 		$this->db->update('user');
					 		$userDetail = ['id' => $result['id'], 'token' => $token];
					 		$finalUserdetail = $this->utility->encode(json_encode($userDetail));
					 		$datas['name'] = $result['name'];
					 		$datas['link'] = base_url() . "api/verifyAccount/" . $finalUserdetail;
					 		$datas['message'] = $this->load->view('emailTemplate/registration_mail', $datas, true);
					 		$datas['subject'] = 'Verify user email address';
					 		$datas["to"] = $email;
					 		$res = sendMailSMTP($datas);
					 		$this->utility->setFlashMessage('danger','Please verify your email');
					 		redirect(base_url().'login');
					 	}
					 }else{
					 	$this->utility->setFlashMessage('danger','Invalid email and password');
					 		redirect(base_url().'login');
					 }
				}
			}
			$common = $this->common_keys;
			// dd($common);
			$google_client_id = '';
				$google_secret_id = '';
			if(!empty($common)){
				$google_client_id = $common[0]->google_client_id;
				$google_secret_id = $common[0]->google_secret_id;
				}
			if(!isset($_SESSION['oauth']) && $google_client_id != '' && $google_secret_id != ''){
				
				include_once APPPATH . "libraries/vendor/autoload.php";
					 $google_client = new Google_Client();
					 $google_client->setClientId($google_client_id); 
		          $google_client->setClientSecret($google_secret_id); //Define your Client Secret Key
		          $google_client->setRedirectUri(base_url().'users_account/google_login'); //Define your Redirect Uri
		          $google_client->addScope('email');
		          $google_client->addScope('profile');
		          $GoogleUrl = $google_client->createAuthUrl();
				// print_r($GoogleUrl);die;
		      }else{	
		      	$GoogleUrl = base_url().'login';
		      }
		      $data['googleUrl'] = $GoogleUrl;
		      // print_r('1');die;
			$this->loadView(USER_LAYOUT,$data);
		}

	public function loginFromlink($postData){

			$userData =  $this->utility->decode(json_encode($postData));

			$final_userData = json_decode($userData);
		if(!empty($final_userData)){
			
					$result = $this->this_model->loginchekFromEmail($final_userData);
					
					 if($result){
					 	// print_r( get_cookie('loginemail'));die;
					 	 $login_data = array(
                            'user_id' => $result[0]->id,
                            'user_name' => $result[0]->fname,
                            'user_lname' => $result[0]->lname,
                            'user_email' => $result[0]->email,
                            'user_phone' => $result[0]->phone,
                            'logged_in' => TRUE
                        ); 

					 		$this->session->set_userdata($login_data);
					 		if($this->session->userdata('user_id') != ''){
					 			$this->this_model->manageCartItem();
					 			
					 			if(isset($_SESSION['My_cart'][0]['vender_id'])){
					 				$vendor_id = $_SESSION['My_cart'][0]['vender_id'];
									$this->load->model('frontend/vendor_model','vendor');
									$vendor_name = $this->vendor->getVendorName($vendor_id);
									$vendor_name = $vendor_name[0]->name;
									$vendor = array(
											'vendor_id'=>$vendor_id,
											'vendor_name'=>$vendor_name,
											);
									$this->session->set_userdata($vendor);
					 			}
					 		}
					 		if($this->session->userdata('redirect_page') != ''){
					 			$p = $this->session->userdata('redirect_page');
					 			redirect($p);
					 		}else{
					 			redirect(base_url().'frontend/home');
					 		}
					 }else{
							$this->utility->setFlashMessage('danger','Invalid email and password');
					 		// redirect(base_url().'login');
					 }
				
			}
	}

	public function register(){
		$data['appLinks'] = $this->common_keys;
		if(isset($this->user_id) && $this->user_id != ''){
			redirect(base_url());
		}
		$data['page'] = 'frontend/account/registration';
		$data['js'] = array('login.js');
		$data['init'] = array('LOGIN.init()');

			if($this->input->post()){
				$validation = $this->setRules();
				if($validation){
					$result = $this->this_model->register_user($this->input->post());
					
					 if($result){
					 	$this->utility->setFlashMessage('success','Congratulation, your account has been successfully created.');
					 		redirect(base_url().'login');
					 		exit;
					 }else{
						$this->utility->setFlashMessage('danger','Somthing Went Wrong');
					 		redirect(base_url().'login');
					 		exit;
					 }
				}
			}
			$common = $this->common_keys;
			$google_client_id = $common[0]->google_client_id;
			$google_secret_id = $common[0]->google_secret_id;
			if(!isset($_SESSION['oauth']) && $google_client_id != '' && $google_secret_id != ''){
				include_once APPPATH . "libraries/vendor/autoload.php";
				$google_client = new Google_Client();
				  $google_client->setClientId($google_client_id); 
		          $google_client->setClientSecret($google_secret_id); //Define your Client Secret Key
		          $google_client->setRedirectUri(base_url().'users_account/google_login'); //Define your Redirect Uri
		          $google_client->addScope('email');
		          $google_client->addScope('profile');
		          $GoogleUrl = $google_client->createAuthUrl();
		      }else{
      			// $GoogleUrl = base_url().'users_account/google_login/login';
      			// $this->utility->setFlashMessage('danger','Social credential not found');
      			$GoogleUrl = base_url().'register';
    		  }
      		$data['googleUrl'] = $GoogleUrl;
		$this->loadView(USER_LAYOUT,$data);	
	}

	public function user_register(){

		$login_type = $this->this_model->checkLoginType();
		if($login_type == '0'){
			redirect(base_url().'login');
			die;
		}

		$data['appLinks'] = $this->common_keys;
		if(isset($this->user_id) && $this->user_id != ''){
			redirect(base_url());
		}
		$data['page'] = 'frontend/account/user_registration';
		$data['js'] = array('user_register.js');
		$data['country_code'] = GetDialcodelist();

			if($this->input->post()){
				$validation = $this->setRules();
				if($validation){
					$result = $this->this_model->register_user($this->input->post());
					
					 if($result){
					 	$this->utility->setFlashMessage('success','Congratulation, your account has been successfully created.');
					 		redirect(base_url().'login');
					 		exit;
					 }else{
						$this->utility->setFlashMessage('danger','Somthing Went Wrong');
					 		redirect(base_url().'login');
					 		exit;
					 }
				}
			}
		
		$this->loadView(USER_LAYOUT,$data);	
	}
	public function sendOtpLogin(){
		$this->load->model('api_v3/api_model','api_model');
     	$post = $this->input->post();
      $response = $this->this_model->sendOtpLogin($post);   
      echo json_encode($response);die;       
    }
	public function varifyOtpLogin(){	
     	$post = $this->input->post();
      $response = $this->this_model->varifyOtpLogin($post);   
      echo json_encode($response);die;       
    }
    public function completeProfile(){	
     	$post = $this->input->post();
      $response = $this->this_model->completeProfile($post);   
      echo json_encode($response);die;       
    }

	public function fb_login(){
		// Call Facebook API
		$common = $this->common_keys;
		$facebook_client_id = '';
		$facebook_secret_id = '';
		if(!empty($common)){
			$facebook_client_id = $common[0]->facebook_client_id;
			$facebook_secret_id = $common[0]->facebook_secret_id;
		}
		if($facebook_client_id != '' && $facebook_secret_id != ''){
			$facebook = new \Facebook\Facebook([
				'app_id'      => $facebook_client_id,
				'app_secret'     => $facebook_secret_id,
				'redirect' =>  base_url().'login/oauth/',
			]);
			$facebook_helper = $facebook->getRedirectLoginHelper();
			$facebook_permissions = ['email']; // Optional permissions
   		$facebook_login_url = $facebook_helper->getLoginUrl(base_url().'login/oauth/', $facebook_permissions);
   		redirect($facebook_login_url);
		
		}else{
			// echo '2';die;
			$this->utility->setFlashMessage('danger','Social credential not found');
			redirect(base_url().'login');
		}
	}

	public function oauth(){
			$common = $this->common_keys;
			$facebook_client_id = $common[0]->facebook_client_id;
			$facebook_secret_id = $common[0]->facebook_secret_id;
			if(isset($_GET['code'])){
			$facebook = new \Facebook\Facebook([
				'app_id'      => $facebook_client_id,
				'app_secret'     => $facebook_secret_id,
				'redirect' =>  base_url().'login/oauth/',
				// 'locale' => 'en_UK'
			])
			;
			$facebook_helper = $facebook->getRedirectLoginHelper();
			$access_token = $facebook_helper->getAccessToken();
			
			$facebook->setDefaultAccessToken($_GET['code']);
			$graph_response = $facebook->get("/me?locale=en_US&fields=id,name,email,first_name,last_name,picture", $access_token);

			$facebook_user_info = $graph_response->getGraphUser();
			
			$this->load->model('account/google_login_model','google_login_model');
			if(!empty($facebook_user_info['id'])){

				$re = $this->google_login_model->Is_already_register($facebook_user_info['email']);
				if($re){
					$user_data = array(
						// 'fname' => $facebook_user_info['first_name'],
						// 'vendor_id'=>$this->session->userdata('vendor_id'),
						// 'lname'  => $facebook_user_info['last_name'],
						'facebook_token_id'=>$facebook_user_info['id'],
						'login_type'=>'1',
						'dt_updated' => strtotime(DATE_TIME)
					); 
					$this->google_login_model->Update_user_data($user_data, $facebook_user_info['email']);

				}else{

    			 //insert data
					$user_data = array(  
						'facebook_token_id'=>$facebook_user_info['id'],
						'vendor_id'=>$this->session->userdata('vendor_id'),
						'fname' => $facebook_user_info['first_name'],
						'lname'  => $facebook_user_info['last_name'],
						'login_type'=>'1',
						'dt_added' => strtotime(DATE_TIME),
						'dt_updated' => strtotime(DATE_TIME)
					);
					$res = $this->google_login_model->Insert_user_data($user_data);
					$re = $this->google_login_model->getUserDetails($facebook_user_info['id']);
				} 

				$login_data = array(
					'user_id' => $re[0]->id,
					'user_name' => $facebook_user_info['first_name'],
					'user_lname' => $re[0]->lname,
					'user_email' => $re[0]->email,
					'user_phone' => $result[0]->phone,
					'logged_in' => TRUE
				);

				$login_logs = [
                    'user_id' => $re[0]->id,
                    'vendor_id' => $re[0]->vendor_id,
                    'status' => 'google login',
                    'type' => 'user',
                    'dt_created' => DATE_TIME
                ];
                $this->load->model('api_v3/common_model','v2_common_model');
                $this->v2_common_model->user_login_logout_logs($login_logs);

				$this->session->set_userdata($login_data);
				if($this->session->userdata('user_id') != ''){
					$this->load->model($this->myvalues->loginFrontEnd['model'],'that_model');
					$this->that_model->manageCartItem();
					if(isset($_SESSION['My_cart'][0]['branch_id'])){
						$branch_id = $_SESSION['My_cart'][0]['branch_id'];
						$this->load->model('frontend/vendor_model','vendor');
						$branch = $this->vendor->getVendorName($branch_id);
						$branch_name = $branch[0]->name;
						$vendor = array(
							'branch_id'=>$branch_id,
							'vendor_name'=>$branch_name,
						);
						$this->session->set_userdata($vendor);
					}
				}
				redirect(base_url());
			}
		}else if($_GET['error']){
			redirect(base_url());
		}

	}

	public function setRules(){

		$config = array(
				array(
					'field'=> 'email',
					'lable'=> 'email',
					'rules' => 'trim|required',
					'errors' => [ 
							'required' => "please enter valid email",
							'is_unique' => "This email address is already taken",
						]
				),
				array(
					'field' => 'password', 
                  	'label' => 'password', 
                  	'rules' => 'trim|required',
                   	"errors" => [
                    	    'required' => "please enter your password"
                    ]
                ),
           	array(
					'field' => 'confirm_password', 
                  	'label' => 'confirm_password', 
                  	'rules' => 'trim|required|matches[password]',
                   	"errors" => [
                    	    'required' => "please enter your password"
                    ]
                )
		);


        $this->form_validation->set_rules($config);
         if($this->form_validation->run() == FALSE){
            // echo validation_errors(); exit();
         }
         else{
            return true;
        }
	}

	function setRulesLogin(){

		$config = array(
					array(
					'field'=> 'email',
					'lable'=> 'email',
					'rules' => 'trim|required',
					'errors' => [ 
							'required' => "please enter Email"
						]
					),
					array(
					'field'=> 'password',
					'lable'=> 'password',
					'rules' => 'trim|required',
					'errors' => [ 
							'required' => "please enter password"
						]
					)
				);
		$this->form_validation->set_rules($config);
			if($this->form_validation->run() == FALSE){
				// echo validation_errors(); exit;
			}else{
				return true;
			}
	}

	public function forget_password(){
		// print_r($_SESSION);die();
		$data['appLinks'] = $this->common_keys;
		if(isset($this->user_id) && $this->user_id != ''){
			redirect(base_url());
		}
		
		$data['page'] = 'frontend/account/forgetpassword';
		$data['js'] = array('login.js');
		$data['init'] = array('LOGIN.forget()');
			if($this->input->post()){
				// $checkIsUserExist = $this->this_model->checkIsUserExist($this->input->post());
				// if($checkIsUserExist > 0){

					$re = $this->this_model->ForgetPassword($this->input->post());
					if($re){
						$this->utility->setFlashMessage('success',"Your login password has been sent to your registered mail address");
					}else{
						$this->utility->setFlashMessage('danger',"Something Went Wrong");
					}
			
				// }
				// else{
				// 	$this->utility->setFlashMessage('danger',"You are registered with social account");
				// }
					redirect(base_url().'login/forget_password');

			}

		$this->loadView(USER_LAYOUT,$data);

	}

	public function verify_email(){
		// print_r($_SESSION);die;
		$email = $this->input->post('email');
		echo $result = $this->this_model->emailVerification($email);
		die;
	}

	public function verify_mobile(){
		// print_r($_POST);die;
		// $email = $this->input->post('email');
		echo $result = $this->this_model->mobileVerification_register($this->input->post());
		die;
	}


}
  
 ?>