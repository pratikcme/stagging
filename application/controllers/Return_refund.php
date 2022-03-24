
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Return_refund extends User_Controller {
	

	function __construct(){
		parent::__construct();
		$this->controller = $this->myvalues->returnFrontEnd['controller'];
		$this->url = SITE_URL . 'frontend/'. $this->controller;
		$this->load->model($this->myvalues->returnFrontEnd['model'],'this_model');
	}


	public function index()
	{
		
		$data['page'] = 'frontend/account/return_refund';
		$data['return_refund'] = $this->this_model->getAllData();
		// print_r($data['return_refund']);die;
		$this->loadView(USER_LAYOUT,$data);
	}
}
  
 ?>