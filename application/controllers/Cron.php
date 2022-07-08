<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('offer_model','this_model');
	}

	public function test(){
		$this->this_model->test();
		
	}

	public function applied_offer_bycron($crone_id=''){
		$res = $this->this_model->getOfferForApplied();
		foreach ($res as $key => $value) {
			$product_varient_id = $value->product_varient_id;
			$new_discount = $value->new_percentage;
			$product_varient = $this->this_model->getProductVarientById($product_varient_id);
			$price = $product_varient[0]->price;
			$discount = ($price/100)*$new_discount;
			$discount_price = $price - $discount;
			$this->this_model->updateProductVarientById($product_varient_id,$new_discount,$discount_price);
			
			echo 'applied';
		}
		if(!empty($res)){
			$this->this_model->deleteCronById($crone_id);
			$this->this_model->setCron();
			
		}
	}

	public function rollback_offer_bycron($crone_id=''){
		$rollback = $this->this_model->getOfferForApplied(true);
		foreach ($rollback as $key => $value) {
			$product_varient_id = $value->product_varient_id;
			$old_discount = $value->old_percentage;
			$product_varient = $this->this_model->getProductVarientById($product_varient_id);
			$price = $product_varient[0]->price;
			$discount = ($price/100)* $old_discount;
			$discount_price = $price - $discount;
			$this->this_model->updateProductVarientById($product_varient_id,$old_discount,$discount_price);
			echo 'rollback';
		}
		if(!empty($rollback)){
		$this->this_model->deleteCronById($crone_id);
		$this->this_model->setCron();
		}
	}

}
?>