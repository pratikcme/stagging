<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends User_Controller {

	function __construct(){	
		parent::__construct();
		$this->controller = $this->myvalues->cartFrontEnd['controller'];
		$this->url = SITE_URL . 'frontend/'. $this->controller;
		// $this->load->model($this->myvalues->cartFrontEnd['model'],'this_model');
	}


	public function index()
	{
	// if(!isset($_SESSION['My_cart']) || empty($_SESSION['My_cart'])){
	// 			redirect(base_url().'frontend/product');
	// 	}
		$data['page'] = 'frontend/cart_item';
		$data['js'] = array('cart.js');
		// if($this->session->userdata('user_id') != ''){
		// 	$result = $this->this_model->getUserAddressLatLong();
		// 	$userLat = $result[0]->latitude; 
		// 	$userLong = $result[0]->longitude; 
		// 	$data['calc_shiping'] = $this->this_model->getDeliveryCharge($userLat,$userLong,$_SESSION['vendor_id']);
		// }

 		$this->loadView(USER_LAYOUT,$data);
	}
}
  
 ?>