
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terms_condition extends User_Controller {
	

	function __construct(){
		parent::__construct();
		$this->load->model($this->myvalues->returnFrontEnd['model'],'this_model');
		$this->session->unset_userdata('isSelfPickup');
	}


	public function index(){
		$data['page'] = 'frontend/account/terms_condition';
		$data['term'] = $this->this_model->getTermData();
		$this->loadView(USER_LAYOUT,$data);
	}
}
  
 ?>