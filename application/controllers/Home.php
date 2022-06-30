<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends User_Controller {

	function __construct(){
		parent::__construct();
		$this->controller = $this->myvalues->homeFrontEnd['controller'];
		$this->load->model($this->myvalues->homeFrontEnd['model'],'this_model');
		if($this->session->userdata('branch_id') == ''){
			redirect(base_url());
		}
		$this->session->unset_userdata('isSelfPickup');
	}

	public function index(){
		$data['page'] = 'frontend/home/home';
		$subcategory = $this->this_model->countSubcategory();
		$data['subcategory'] = count($subcategory);

		if($this->countCategory == 1 && count($subcategory) == '1'){
			$data['page'] = 'frontend/home/shukan';
			$this->load->model('home_content_model');
			$data['home_content'] = $this->home_content_model->getAboutSectionTwo(); 
			$data['home_section_one'] = $this->home_content_model->getHomeSection_one();
			$data['background_image'] = $this->home_content_model->getSectionOneBackground();
		}
		
		$data['js'] = array('add_to_cart.js');
		
		$data['category'] = $this->this_model->selectCategory();
		
		$data['new_arrival'] = $this->this_model->selectNewArrivel();
		$data['folder'] = $this->folder.'category/';
		if($this->countCategory == 1 && count($subcategory) > 1){
			$data['category'] = $this->this_model->subcategory_list();
			$data['folder'] = $this->folder.'product_image/';
		}
		
		$product_ids = [];
		$default_product_image = $this->common_model->default_product_image(); 
		$default_product_image = '';
		foreach ($data['new_arrival'] as $key => $value) {
			$varientQuantity = $this->this_model->checkVarientQuantity($value->id);

			$product_ids[] = $value->id;
			$this->load->model('frontend/product_model');

			if($value->image == '' || !file_exists('public/images/'.$this->folder.'product_image/'.$value->image)){
				$this->load->model('common_model');
				// $data['new_arrival'][$key]->image = 'defualt.png';
				dd($default_product_image);
				$data['new_arrival'][$key]->image = $default_product_image; 
			}

			$addQuantity = $this->product_model->findProductAddQuantity($value->id,$value->pw_id);
  			$value->addQuantity = $addQuantity;

			$data['new_arrival'][$key]->varientQuantity = ($varientQuantity == '0') ? "0" : $varientQuantity[0]->quantity;
		}
		

		$data['top_sell_core'] = $this->this_model->selectTopSelling($product_ids);
		
		$top_selling_core = array();
		foreach ($data['top_sell_core'] as $key => $value) {  
			$selling_core = $this->this_model->top_selling_product($value->product_id);

			if(!empty( $selling_core)){
				$re = array_push($top_selling_core, $selling_core[0]);
			}
		}
			$quantity = array_column($top_selling_core, 'quantity');
			array_multisort($quantity, SORT_DESC, $top_selling_core);
			
		foreach ($top_selling_core as $key => $value) {

			$addQuantity = $this->product_model->findProductAddQuantity($value->id,$value->pw_id);
  			$value->addQuantity = $addQuantity;
			
			$varientQuantity = $this->this_model->checkVarientQuantity($value->id);
			
			$top_selling_core[$key]->varientQuantity = ($varientQuantity == '0' ) ? "0" : $varientQuantity[0]->quantity;

		}

		$data['top_sell'] = $top_selling_core;
		
		@$data['banner'] = $this->this_model->getWebBannerImage();
		// dd($data['banner']);die;

		$item_weight_id = [];
		if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != '' ){
			$this->load->model('frontend/product_model');
			$res = $this->product_model->UsersCartData();
			foreach ($res as $key => $value) {
				array_push($item_weight_id, $value->product_weight_id);
			}
			// print_r($item_weight_id);die;
		}else{
			if(isset($_SESSION["My_cart"])){
			 	$item_weight_id = array_column($_SESSION["My_cart"], "product_weight_id");
			}

		}

		
		$data['item_weight_id'] = $item_weight_id ;
		$this->loadView(USER_LAYOUT,$data);
	
	}

	public function get_notification(){
		$this->load->model('common_model');
		$res = $this->common_model->userNotify();
		$html = '';
		foreach ($res as $key => $value) {
			$html .= '<li>'.$value->notification.'</li>';
		}
		if(count($res) == '0'){
			$html .= '<li>No Notification</li>';
		}else{
			$html .='<li id="clear_all">Clear All</li>';
		}
		echo json_encode(['notify'=>$html,'count'=>count($res)]);
	}

	public function haveRead(){
			$this->load->model('common_model');
			$res = $this->common_model->makeRead();
			$html = '';
			foreach ($res as $key => $value) {
				$html .= '<li>'.$value->notification.'</li>';
			}
			if(count($res) == '0'){
				$html .= '<li>No Notification</li>';
			}else{
				$html .='<li id="clear_all">Clear All</li>';
			}
		echo json_encode(['notify'=>$html,'count'=>count($res)]);
	}

	
}
?>
