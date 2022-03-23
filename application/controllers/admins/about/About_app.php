<?php defined('BASEPATH') OR exit('No direct script access allowed');

class About_app extends Admin_Controller{
	// echo '1';die;
	function __construct(){
		parent::__construct();
		$this->load->model('admin/about/about_app_model','this_model');
	}

	public function index(){
		$data['js'] = array('about.js');
		$data['init'] = array('ABOUT.appUpdate()');
		$data['getData'] = $this->this_model->getAboutApp();
		// print_r($data['getData']);die;
		if($this->input->post()){				
				$data = $this->this_model->editUpdateAboutApp($this->input->post());
				if($data){ 
					$this->utility->setFlashMessage($data[0],$data[1]);
					redirect(base_url().'admins/about/about_app');
				}
		}
		$this->load->view('about/about_app',$data);
	}


}
