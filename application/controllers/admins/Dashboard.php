<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller{

	function __construct(){
		parent::__construct();
		// $this->load->model('admin/dashboard_model','this_model');
	}

	public function index()
	{
		$data['page'] = 'admin/dashboard';
		$data['FormAction'] = base_url() .'admin/dashboard/getData';
		// $data['blog_image'] = $this->this_model->GetblogImage();
		
		$this->load->view(ADMIN_LAYOUT,$data);
	}

	public function getData()
	{
		if(!empty($this->input->post('heading'))){
			$result = $this->this_model->blogData($this->input->post());
			if($result){
			// $this->load->view('welcome_message',$data);

			}
		}else{
			echo 'please fill ';
		}

	}

	public function getblogdata(){
		$data['blogData'] = $this->this_model->GetblogData($this->input->post());

				$this->load->view('frontend/blog',$data);
		
	}


}
