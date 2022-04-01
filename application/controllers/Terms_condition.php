
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Terms_condition extends User_Controller {
	

	function __construct(){
		parent::__construct();
		$this->load->model($this->myvalues->returnFrontEnd['model'],'this_model');
		$this->session->unset_userdata('isSelfPickup');
		$this->load->model('frontend/vendor_model');
		if(!isset($_SESSION['vendor_id'])){
		 $vendor = $this->vendor_model->ApprovedBranch();
			if(!empty($vendor)){
				$vendor = array(
					'vendor_id'=>$vendor[0]->id,
				);
				$this->session->set_userdata($vendor);
			}
			redirect(base_url().'terms_condition');
		}
	}


	public function index(){
		$data['page'] = 'frontend/account/terms_condition';
		$data['term'] = $this->this_model->getTermData();
		$this->loadView(USER_LAYOUT,$data);
	}
}
  
 ?>