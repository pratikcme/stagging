<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends User_Controller {

	function __construct(){
		parent::__construct();
		$this->controller = $this->myvalues->homeFrontEnd['controller'];
		$this->url = SITE_URL . 'frontend/'. $this->controller;
		$this->load->model($this->myvalues->homeFrontEnd['model'],'this_model');
		if($this->session->userdata('vendor_id') == ''){
			redirect(base_url());
		}
	}


	public function index()
	{
		// echo '<pre>';
		// print_r($_SESSION);die;
		$data['page'] = 'frontend/home/home';
		$data['js'] = array('home.js');
		$data['banner'] = $this->this_model->selectbanner();
		$data['category'] = $this->this_model->selectCategory();
		
		$data['new_arrival'] = $this->this_model->selectNewArrivel();
		foreach ($data['new_arrival'] as $key => $value) {
			if($value->image == '' || !file_exists('public/images/product_image_thumb/'.$value->image)){
				$data['new_arrival'][$key]->image = 'defualt.png';
			}
		}
		$this->load->model('banner_promotion_model','banner')
		$data['banner'] = $this->banner->getBannerImage();
		// echo "<pre>";
		// print_r($data['banner']);die;
		$this->loadView(USER_LAYOUT,$data);
	}

	
}
?>
