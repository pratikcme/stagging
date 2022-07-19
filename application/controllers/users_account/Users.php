<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends User_Controller {

	function __construct(){
		parent::__construct();
		$this->controller = $this->myvalues->usersAccount['controller'];
		$this->load->model($this->myvalues->usersAccount['model'],'this_model');
		$user_id = $this->session->userdata('user_id');
              if(!isset($user_id)){
                redirect(base_url().'login');
              }
       	$this->session->unset_userdata('isSelfPickup');
	}

	public function account(){	
		// echo '11';die;

		$data['action_name'] = $this->input->get('name');
		if(isset($_GET['name'])){
			$uri_segment = $_GET['name'];
		}
		$data['page'] = 'frontend/account/account';
		$data['js'] = array('change.js','address.js');
		$data['init'] = array('CHANGE.init()','ADDRESS.init()');
		$data['userDetails'] = $this->this_model->selectUserDetail();
		$data['get_address'] = $this->this_model->getUserAddress();
		$data['faq'] = $this->this_model->getFaq();
		$this->load->model($this->myvalues->orderFrontEnd['model'],'order_model');
		$data['order'] = $this->this_model->selectOrders();
		// dd($data['order']);
		$orderDetais = [];
		$this->load->model('api_admin_model');

		$this->load->model('api_v3/api_model','api_v3_model');
		
		$data['getVedorDetails'] = [];
		foreach ($data['order'] as $key => $value) {

			if($value->promocode_used == 1){
				$order_promocode_amount = $this->api_v3_model->get_order_promocode_discount($value->id); 
				$instance_discount = number_format((float)$order_promocode_amount[0]->amount,'2','.','');
			}else{
					$amount = 0;
					$instance_discount = number_format((float)$amount,'2','.','');
			}
			$data['order'][$key]->promocode_discount = $instance_discount;

			$getBranchDetails = $this->this_model->getBranchDetails($value->branch_id);
			$data['getVedorDetails'] = $this->this_model->getVedorDetails($value->branch_id);
			$gst_amount = $this->api_admin_model->getGstAmount($value->id);
			$data['order'][$key]->TotalGstAmount = number_format((float)$gst_amount,'2','.','') ;
			$data['order'][$key]->AmountWithoutGst =  number_format((float)($value->total - $gst_amount),'2','.','');
			$data['order'][$key]->orderDetails = $this->view($value->id);
			$data['order'][$key]->vendorName = $getBranchDetails[0]->name;
			$data['order'][$key]->vendorAddress = $getBranchDetails[0]->location;
			// if($value->isSelfPickup == '1'){
				$otp = $this->this_model->getSelfPickupOtp($value->id);
				$value->isSelfPickup_details = $otp;
			// }

		}

		if($this->input->post()){
			$validation = $this->setRulesAccount(); 
			if($validation){
				$response = $this->this_model->varifiy_password	($this->input->post());
				if($response){
					$this->utility->setFlashMessage('success','Profile updated successfully');
					redirect(base_url().'users_account/users/account?name=my_account');
				}else{
					$this->utility->setFlashMessage('danger','OTP is wrong');
					redirect(base_url().'users_account/users/account?name=my_account');
				}
			}else{
				$this->utility->setFlashMessage('danger',form_error('phone'));
				redirect(base_url().'users_account/users/account?name=my_account');
			}
		}
		$data['checkUserLoginType']	= $this->this_model->checkCurrentUserLoginType();
		$this->loadView(USER_LAYOUT,$data);
	}


	function setRulesAccount(){

		$config = array(
			array(
				'field'=> 'phone',
				'lable'=> 'phone',
				'rules' => 'trim|required|max_length[15]|min_length[6]|regex_match[/^[0-9,]+$/]',
				'errors' => [ 
					'required' => "please enter valid mobile number"
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


	public function address()
	{
		$data['page'] = 'frontend/account/address_list';
		$data['js'] = array('address.js');
		$data['get_address'] = $this->this_model->getUserAddress();			
		$this->loadView(USER_LAYOUT,$data);
	}
	public function update_password(){
		if($this->input->post()){
			$result = $this->this_model->update_password($this->input->post());
			if($result){
				$this->utility->setFlashMessage('success','Password updated successfully');
				redirect(base_url().'users_account/users/account?name=change');
			}else{
				$this->utility->setFlashMessage('danger','Please enter correct password');
				redirect(base_url().'users_account/users/account?name=change');
			}
		}
	}


	public function add_address()
	{
			if($this->input->post()){
				$response = $this->this_model->AddUserAddress($this->input->post());
				if($response){
					$this->utility->setFlashMessage('success',' Address successfully added');
					if(isset($_POST['redirect_url']) && $_POST['redirect_url'] != ''){
						$url = $_POST['redirect_url'];
						redirect($url);
						exit;
					}
					redirect(base_url().'users_account/users/account?name=my_address');
				}else{
					$this->utility->setFlashMessage('danger','Something went wrong ');
					if(isset($_POST['redirect_url']) && $_POST['redirect_url'] != ''){
						$url = $_POST['redirect_url'];
						redirect($url);
						exit;
					}
					redirect(base_url().'users_account/users/account?name=my_address');
				}
			}
	}


	public function accountdetails()
	{
		$data['page'] = 'frontend/account/account_detail_update';
		$data['js'] = array('address.js');
		$data['init'] = array('ADDRESS.accountdetail()');
		$data['user'] = $this->this_model->selectUserDetail();

			if($this->input->post()){
				$response = $this->this_model->updateUserDetail($this->input->post());
				if($response){
					$this->utility->setFlashMessage('success','Details has been changed successfully ');
					redirect(base_url().'users_account/users/accountdetails');
				}else{
					$this->utility->setFlashMessage('danger','Please enter correct password ');
					redirect(base_url().'users_account/users/accountdetails');
				}
			}
		$this->loadView(USER_LAYOUT,$data);
	}


	public function set_default(){
		if($this->input->post()){
			$address_id = $this->utility->safe_b64decode($this->input->post('id'));
			$response = $this->this_model->setDefaultAddress($address_id); 
		}
	}

	public function edit(){
		$address_id = $this->utility->safe_b64decode($this->input->post('id'));
		$get_address = $this->this_model->getEditAddress($address_id);
		echo json_encode(['result'=>$get_address]);
	}

	

	public function update_address(){
		if($this->input->post()){
				$response = $this->this_model->updateAddress($this->input->post());
				if($response){
					$this->utility->setFlashMessage('success','Address Updated successfully');
					if(isset($_POST['redirect_url']) && $_POST['redirect_url'] != ''){
						$url = $_POST['redirect_url'];
						redirect($url);
						exit;
					}
					redirect(base_url().'users_account/users/account?name=my_address');
				}else{
					$this->utility->setFlashMessage('danger','Something went wrong ');
					if(isset($_POST['redirect_url']) && $_POST['redirect_url'] != ''){
						$url = $_POST['redirect_url'];
						redirect($url);
						exit;
					}
					redirect(base_url().'users_account/users/account?name=my_address');
				}
			}
	}

	public function remove(){
		if($this->input->post()){
			$id = $this->utility->safe_b64decode($this->input->post('id'));
			$r = $this->this_model->removeRecord($id);
			$r[0]->id = $this->utility->safe_b64encode($r[0]->id);
			echo json_encode(['result'=>$r]);
		}
	}

	public function view($id){
		error_reporting(0);
		$this->load->model($this->myvalues->orderFrontEnd['model'],'order_model');
		$view_detail = $this->order_model->selectOrderDetails($id);
		// print_r($view_detail);die;
		foreach ($view_detail as $key => $value) {
			$pr = $this->order_model->selectproductname($value->product_id);
			$w = $this->this_model->getDetails($value->product_weight_id);
			$view_detail[$key]->weight_number =  $w[0]->weight_no;
			$view_detail[$key]->weight_name =  $w[0]->name;
			$view_detail[$key]->package =  $w[0]->package;
			$pr_img = $this->order_model->select_product_image($value->product_weight_id);
				$view_detail[$key]->product_name =  $pr[0]->name;
			 	$view_detail[$key]->product_image =  $pr_img[0]->image;
			}
			// print_r($view_detail);die;
		return $view_detail;
	}

	public function removeWishlistItem(){
		if($this->input->post()){
			$this->this_model->removeItemFromWishlist($this->input->post());
		}
	}

public function sendOtpAccount(){
		$this->load->model('api_v3/api_model','api_model');
     	$post = $this->input->post();
      $response = $this->this_model->sendOtpAccount($post);   
      echo json_encode($response);die;       
 	}

 	public function data_deletion(){
 		$post = $this->input->post();
 		if($this->input->post()){
    	$response = $this->this_model->delete_user($post);
    	$response = array($response);
 			echo json_encode($response);
 		}
 	}

}
