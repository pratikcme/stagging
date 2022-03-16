<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	function __construct(){
		parent::__construct();

		$this->controller = $this->myvalues->loginFrontEnd['controller'];
		// $this->url = SITE_URL . $this->controller;
		$this->load->model($this->myvalues->loginFrontEnd['model'],'this_model');
		$user_id = $this->session->userdata('user_id');
		$this->user_id = $this->session->userdata('user_id');
		// print_r($this->user_id);die;
		include_once APPPATH . "libraries/vendor/autoload.php";
		
	}


	public function index()
	{

		// print_r($_SESSION);die;
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
					// echo '1';die;
					$result = $this->this_model->login_chek($this->input->post());

					 if(!empty($result)){
					 	if($result[0]->email_verify == '1'){
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
					 			// $this->session->session_destroy('My_cart');
					 			$MycartData = $this->this_model->MycartData();
					 			$this->this_model->manageCartItem();	
					 			
					 			// if( !empty($MycartData) && !empty($_SESSION["My_cart"]) ){

						 		// 	$branch_ids = array_column($_SESSION["My_cart"], "branch_id");

						 		// 	foreach ($MycartData as $key => $value) {
						 		// 		if(!in_array($value->branch_id, $branch_ids)){
						 		// 			// $this->utility->setFlashMessage('danger','Your cart is already have product of '.$value->name.' Please Remove your cart and login again');
						 		// 			$this->session->unset_userdata('My_cart');
						 		// 			// exit();
						 		// 		}
						 		// 	}

					 			// }

					 			// print_r($MycartData);die;
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
					 		// echo '1';die;
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
                        // print_r($datas);die;
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
			if(!isset($_SESSION['oauth']))
			{
				// print_r($common);die;
				$common = $this->common_keys;
				$google_client_id = $common[0]->google_client_id;
				$google_secret_id = $common[0]->google_secret_id;
				
				include_once APPPATH . "libraries/vendor/autoload.php";
				$google_client = new Google_Client();
				$google_client->setClientId($google_client_id); 
/*		          $google_client->setClientId('69869714880-vm8nti4f6qg4r14smabnggrej6579m6j.apps.googleusercontent.com'); *///Define your ClientID
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
		// print_r($_SESSION);die;
		$data['appLinks'] = $this->common_keys;
		if(isset($this->user_id) && $this->user_id != ''){
			redirect(base_url());
		}
		$data['page'] = 'frontend/account/registration';
		$data['js'] = array('login.js');
		$data['init'] = array('LOGIN.init()');

			if($this->input->post()){
				// print_r($this->input->post());exit;
				$validation = $this->setRules();
				if($validation){
					$result = $this->this_model->register_user($this->input->post());
					
					 if($result){
					 	// $this->utility->setFlashMessage('success','Please check your email to login');
					 	$this->utility->setFlashMessage('success','Congratulation, your account has been successfully created.');
					 		// $this->session->unset_userdata('redirect_page');	
					 		redirect(base_url().'login');
					 		exit;
					 }else{
						$this->utility->setFlashMessage('danger','Somthing Went Wrong');
					 		redirect(base_url().'login');
					 		exit;
					 }
				}
			}
			if(!isset($_SESSION['oauth']))
			{
				include_once APPPATH . "libraries/vendor/autoload.php";
				$google_client = new Google_Client();
				  $google_client->setClientId('146308288221-esvr5vagpqnhbjge4n5i72idjp7r2cgi.apps.googleusercontent.com'); 
/*		          $google_client->setClientId('69869714880-vm8nti4f6qg4r14smabnggrej6579m6j.apps.googleusercontent.com'); *///Define your ClientID
		          $google_client->setClientSecret('MpGvzh064GVROoie7M0p8nuF'); //Define your Client Secret Key
		          $google_client->setRedirectUri(base_url().'users_account/google_login'); //Define your Redirect Uri
		          $google_client->addScope('email');
		          $google_client->addScope('profile');
		          $GoogleUrl = $google_client->createAuthUrl();
		      }else{
      			$GoogleUrl = base_url().'users_account/google_login/login';
    		  }
      		$data['googleUrl'] = $GoogleUrl;
		$this->loadView(USER_LAYOUT,$data);	
	}

	public function fb_login(){
			// Call Facebook API
		// echo base_url().'login/oauth/';
		// die;
		$common = $this->common_keys;

		$facebook_client_id = $common[0]->facebook_client_id;
		$facebook_secret_id = $common[0]->facebook_secret_id;
		// echo '<pre>';
		// echo $this->db->last_query();
		// print_r($common);die;
		$facebook = new \Facebook\Facebook([
			'app_id'      => $facebook_client_id,
			'app_secret'     => $facebook_secret_id,
			'redirect' =>  base_url().'login/oauth/',
		]);
		$facebook_helper = $facebook->getRedirectLoginHelper();
		$facebook_permissions = ['email']; // Optional permissions

   		$facebook_login_url = $facebook_helper->getLoginUrl(base_url().'login/oauth/', $facebook_permissions);	
		// print_r($facebook_login_url);die;
   		redirect($facebook_login_url);
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
			// echo "<pre>";
			// print_r($facebook_user_info);die;
			$this->load->model('account/google_login_model','google_login_model');
			if(!empty($facebook_user_info['id'])){

				$re = $this->google_login_model->Is_already_register($facebook_user_info['email']);
    // print_r($re);die;
				if($re){
     //update data
					$user_data = array(
						'fname' => $facebook_user_info['first_name'],
						'vendor_id'=>$this->session->userdata('vendor_id'),
						'lname'  => $facebook_user_info['last_name'],
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
				// print_r($login_data);die;
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


}
  
 ?>