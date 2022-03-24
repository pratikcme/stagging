<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends User_Controller {

	function __construct(){
		parent::__construct();
		$this->controller = $this->myvalues->faqFrontEnd['controller'];
		$this->url = SITE_URL . 'frontend/'. $this->controller;
		$this->load->model($this->myvalues->faqFrontEnd['model'],'this_model');
	}


	public function index()
	{
		$data['page'] = 'frontend/faq';
		$this->loadView(USER_LAYOUT,$data);
	}
}
  
 ?>