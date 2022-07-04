<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends User_Controller {

	function __construct(){
		parent::__construct();
		$this->controller = $this->myvalues->contactFrontEnd['controller'];
		// $this->url = SITE_URL . 'frontend/'. $this->controller;
		$this->load->model($this->myvalues->contactFrontEnd['model'],'this_model');
		$this->session->unset_userdata('isSelfPickup');
	}


	public function index()
	{
		// echo '1';die;
		// print_r($_SESSION);die;
		$data['page'] = 'frontend/contact';
		$data['js'] = array('contactus.js');
		$data['init'] = array('CONTACT.init()');
		$data['contact_us'] = $this->this_model->getContact();
			if($this->input->post()){
				$validation = $this->setRules();
				if($validation){
				// print_r($this->input->post());die;
					$postdata = $this->input->post();
					$re = $this->this_model->insertContactUs($postdata);
						if($re){
							$this->utility->setFlashMessage('success','Successfully sent your detail to admin');
							redirect(base_url().'contact');
						}else{
							$this->utility->setFlashMessage('danger','Somthing Went Wrong');
							redirect(base_url().'contact');
						}
				}
			}
		
		$this->loadView(USER_LAYOUT,$data);
	}

	public function setRules(){
		$config = array(
					array(
						'field'=> 'fname',
						'lable'=> 'fname',
						'rules' => 'trim|required',
						'errors' => [ 
								'required' => "please enter your first name"
							]
					),
					array(
						'field'=> 'email',
						'lable'=> 'email',
						'rules' => 'trim|required|valid_email',
						'errors' => [ 
								'required' => "please enter your email"
							]
					),
					array(
						'field'=> 'mobile_no',
						'lable'=> 'mobile_no',
						'rules' => 'trim|required',
						'errors' => [ 
								'required' => "please enter your mobile number"
							]
					),
					array(
						'field'=> 'message',
						'lable'=> 'message',
						'rules' => 'trim|required',
						'errors' => [ 
								'required' => "please enter your message"
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

}
