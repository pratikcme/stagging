<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends User_Controller {

	function __construct(){
		parent::__construct();
		$this->controller = $this->myvalues->aboutFrontEnd['controller'];
		// $this->url = SITE_URL . 'frontend/'. $this->controller;
		$this->load->model($this->myvalues->aboutFrontEnd['model'],'this_model');
		$this->session->unset_userdata('isSelfPickup');
	}


	public function index()
	{
		$data['page'] = 'frontend/about.php';
		$data['about_banner'] = $this->this_model->getAboutBanner();
		$data['about_section_one'] = $this->this_model->getAboutSectionOne();
		// echo $this->db->last_query();
		$data['about_section_two'] = $this->this_model->getAboutSectionTwo();
		$data['totalVendor'] = $this->this_model->totalVendor();
		$data['totalCustomber'] = $this->this_model->totalCustomber();
		$this->loadView(USER_LAYOUT,$data);
	}
}
