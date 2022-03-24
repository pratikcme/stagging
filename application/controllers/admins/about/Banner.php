
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends Admin_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('admin/about/Aboutus_model','this_model');

	}

	public function index()
	{	
		$data['page'] = 'admin/about/banner';
		$data['js'] = array('about.js');
		$data['init'] = array('ABOUT.init()');
		$data['getData'] = $this->this_model->getAboutBanner();
		// print_r($data['getData']);die;	
		if($this->input->post()){				

				$data = $this->this_model->AddAboutBanner($this->input->post());
				if($data){ 
					$this->utility->setFlashMessage($data[0],$data[1]);
					redirect(base_url().'admins/about/banner');
				}
		}
		$this->load->view('about/banner',$data);
	}
}
?>