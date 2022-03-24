<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacy_policy extends User_Controller {

	function __construct(){
		parent::__construct();
		$this->controller = $this->myvalues->privacyFrontEnd['controller'];
		// $this->url = SITE_URL . 'frontend/'. $this->controller;
		$this->load->model($this->myvalues->privacyFrontEnd['model'],'this_model');
		$this->session->unset_userdata('isSelfPickup');
	}


	public function index()
	{
		$data['page'] = 'frontend/account/privacy_policy';
		$data['privacy'] = $this->this_model->getData();
		// echo '<pre>';
		// print_r($data['privacy']);
		// exit;
		$this->loadView(USER_LAYOUT,$data);
	}
}
  
 ?>