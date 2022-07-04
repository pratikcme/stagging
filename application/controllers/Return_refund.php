
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Return_refund extends User_Controller {
	

	function __construct(){
		parent::__construct();
		$this->controller = $this->myvalues->returnFrontEnd['controller'];
		$this->load->model($this->myvalues->returnFrontEnd['model'],'this_model');
		$this->load->model('frontend/vendor_model');
		if(!isset($_SESSION['vendor_id'])){
		 $vendor = $this->vendor_model->ApprovedBranch();
			if(!empty($vendor)){
				$vendor = array(
					'vendor_id'=>$vendor[0]->id,
				);
				$this->session->set_userdata($vendor);
			}
			redirect(base_url().'return_refund');
		}
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