<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Add_to_card extends User_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('frontend/product_model','this_model');
		$this->load->library('pagination');
		$this->load->model('common_model');

		// if(!isset($_SESSION['branch_id'])){
		// 	$this->utility->setFlashMessage('danger','Please select branch');
		// 	redirect(base_url());
		// }
		$this->session->unset_userdata('isSelfPickup');
	}

	public function addProducToCart(){
		
		$this->load->model('api_v3/common_model','co_model');
    $isShow = $this->co_model->checkpPriceShowWithGstOrwithoutGst($this->session->userdata('vendor_id'));

		if($this->input->post()){	
			$product_id = $this->input->post('product_id');
			$varient_id = $this->input->post('varient_id');
			$quantity = $this->input->post('qnt');
			$result = $this->this_model->DefaultProductAddInCart($varient_id);
			$getWeight = $this->this_model->getWeightName($result[0]->weight_id);
	 	}
	 	
	 	$this->load->model('common_model');
	 	$default_product_image =$this->common_model->default_product_image();
	 	// dd($default_product_image);
	 	$result[0]->image = preg_replace('/\s+/', '%20', $result[0]->image);
	 	if(!file_exists('public/images/'.$this->folder.'product_image/'.$result[0]->image) || $result[0]->image == '' ){
          if(strpos($result[0]->image, '%20') === true || $result[0]->image == ''){
            $result[0]->image = $default_product_image;
          }else{
          	$result[0]->image = $default_product_image;
          }
        }

	 	if(!empty($result)){
	 			// dd($result);
	 		if(!empty($isShow) && $isShow[0]->display_price_with_gst == '1'){
         $result[0]->discount_price = $result[0]->without_gst_price;
      }


	 		if($result[0]->max_order_qty!='' && $result[0]->max_order_qty!='0' && $quantity > $result[0]->max_order_qty){
				$errormsg = 'Maximum order quantity reached';
			
			}elseif($quantity > $result[0]->quantity){
					
					if($result[0]->quantity == '0'){
					 	$errormsg = 'Product not available';
					}else{
						$errormsg = 'Item Out of Stock';
					}
					// exit();
				}else{

					if($this->session->userdata('user_id') != ''){
						$product_array = array(
									'product_id'=> $this->utility->safe_b64encode($result[0]->id),
									'product_weight_id'=>$result[0]->pw_id,
						);


					$cartTable = $this->this_model->CheckMycard($product_array);

					if(count($cartTable) > 0){
						$update_id = $cartTable[0]->id;
						$update_quantity = $cartTable[0]->quantity + $quantity ;
						$price = 	$cartTable[0]->discount_price * $quantity;
						$this->this_model->update_my_card($update_id,$quantity,$price);
						$itemExist = 'Update successfully';
					}else{

					$my_cart_table_data = array(
							'branch_id'=>$this->session->userdata('branch_id'),
							'vendor_id'=>$this->session->userdata('vendor_id'),
							'user_id'=> $this->session->userdata('user_id'),	
							'product_weight_id'=> $result[0]->pw_id,
							'quantity'=> $quantity,
							'status'=>'1',
							'dt_added' => strtotime(DATE_TIME),
							'dt_updated' => strtotime(DATE_TIME)
						);
						$this->this_model->insertToMyCart($my_cart_table_data);
					}
				}
					
						$cart_item = array(
							'product_id' => $result[0]->id,
							'branch_id' => $result[0]->branch_id,
							'vendor_id' => $this->session->userdata('vendor_id'),
							'weight_id' => $result[0]->weight_id,
							'product_name'=>$result[0]->name,
							'product_price' =>	$result[0]->price,
							'discount_per' =>$result[0]->discount_per,
							'discount_price' => $result[0]->discount_price,
							'quantity'=> $quantity,
							'image'=> $result[0]->image,
							'total'=> $result[0]->discount_price * $quantity,
							'product_weight_id'=> $result[0]->pw_id
						);

							// print_r($cart_item);
							// print_r($_SESSION['My_cart']);
							// exit;
						if(isset($_SESSION['My_cart']) && $this->session->userdata('user_id') == ''){

						$item_array_id = array_column($_SESSION["My_cart"], "product_id");
						$item_weight_id = array_column($_SESSION["My_cart"], "product_weight_id");

								if(in_array($result[0]->id, $item_array_id)){
									if(!in_array($result[0]->pw_id, $item_weight_id)){
									$temp = max(array_keys($_SESSION["My_cart"]));
									$_SESSION["My_cart"][$temp+1] = $cart_item;
									$message = 'success'; 
									}else{

									foreach($_SESSION["My_cart"] as $key => $value){
											$p_id = $_SESSION['My_cart'][$key]['product_id'];
											$w_id = $_SESSION['My_cart'][$key]['weight_id'];
											$p_qunt = $_SESSION['My_cart'][$key]['quantity'];

											if($p_id == $result[0]->id && $w_id == $result[0]->weight_id ){
												if($p_qunt > $result[0]->quantity){
													$errormsg ='stock not available';
												}else{
													$qun = $quantity;
													$price = $value['product_price'] * $qun;
						 							$_SESSION["My_cart"][$key]['quantity'] = $qun;
						 							$_SESSION["My_cart"][$key]['total'] = $price;			 
												}
										}
									}

								// $errormsg = "Item Already Added";
								 // $itemExist = 'Item Already Added';
								 $itemExist = 'Product quantity updated successfully';
								}
						}
						else{
						 $temp = max(array_keys($_SESSION["My_cart"]));
						 $_SESSION["My_cart"][$temp+1] = $cart_item;
						 $message = 'success';
						}
					}else{
						$_SESSION["My_cart"][0] = $cart_item;	
						$message = 'success';
					}
				}

	}else{
			$errormsg ='Currently this product is out of stock';
			
		}
		  if(!isset($message)){
		  	$message = '';
		  }
		  if(!isset($errormsg)){
		  		$errormsg = '';
		  }
		  if(!isset($itemExist)){
		  		$itemExist = '';
		  }
		  	$image= '';
		  	$weight_name = '';
		  if(!empty($result)){
		  	$product_id = $result[0]->id;
		  	$image = (!empty($result[0]->image))?$result[0]->image :'';
		  	$name = $result[0]->name;
		  	$discount_price = $result[0]->discount_price;
		  	$weight_id = $result[0]->weight_id;
		  	$available_quantity = $result[0]->quantity;
		  	$weight_name = $getWeight[0]->name;
		  	$weight_no = $result[0]->weight_no;
		  	$product_variant_id = $result[0]->pw_id;
		  }else{
		  	$product_id = '';
		  	$image = '';
		  	$name = '';
		  	$discount_price = '';
		  	$weight_id = '';
		  	$available_quantity = '';
		  	$weight_name = '';
		  	$weight_no = '';
		  	$product_variant_id = '';
		  }

		$final_total = getMycartSubtotal();

		$response = [
					'product_id'=>$product_id,
					'product_name'=>$name,
					'total'=> $discount_price,
					'weight_id'=> $weight_id,
					'image'=>$image,
					'count'=>cartItemCount(),
					'errormsg'=>$errormsg,
					'itemExist' =>$itemExist,
					'final_total'=>$final_total,
					'available_quantity'=>$available_quantity,
					'weight_no'=>$weight_no,
					'weight_name' => $weight_name,
					'product_variant_id'=>$product_variant_id,
					'enc_prod_id' => $this->utility->safe_b64encode($product_id),
					'enc_product_variant_id'=>$this->utility->safe_b64encode($product_variant_id),
					'updated_list'=>NavbarDropdown(),
					'success'=>$message,
					'pro_weight_id'=> $result[0]->pw_id,
					'cartTotal'=>getMycartSubtotal(),
					];
		echo json_encode($response);

	}

	public function cartIncDec(){

		if($this->input->post()){	
			$result = $this->this_model->CartIncDec($this->input->post());
			// dd($result);die;
	 	}
	 	$prod_id = $this->input->post('product_id');
    	$product_weight_id = $this->input->post('product_weight_id');
	 	$quantity = 1;

	 	
	 	if($this->session->userdata('user_id') == ''){ 
	 	
	 		foreach ($_SESSION['My_cart'] as $key => $value) {

				if($value['product_id'] == $prod_id && $value['product_weight_id'] == $product_weight_id){
					// echo (1);
					// exit;
					$old_qun = $value['quantity'];
					if($this->input->post('action') == 'decrease'){

 						$qun = $value['quantity'] - $quantity;
					}else{
						$qun = $value['quantity'] + $quantity;
					}

					if($result[0]->max_order_qty !='' && $result[0]->max_order_qty!='0' && $qun > $result[0]->max_order_qty){
						$errormsg = 'Maximum order quantity reached';
						$qun = $result[0]->max_order_qty;
					}
					else if($qun > $result[0]->quantity){
						$errormsg = "Item Out Of Stock"; 
					}else{ 

						$price = $value['discount_price'] * $qun;
						$_SESSION["My_cart"][$key]['quantity'] = $qun;
						$_SESSION["My_cart"][$key]['total'] = $price;
						$new_total = $_SESSION["My_cart"][$key]['total'];
						$new_quan = $_SESSION["My_cart"][$key]['quantity'];
					}

				}
			}
		}else{
			$cartTable = $this->this_model->CheckMycard($this->input->post());
			// print_r($this->input->post());die;
			$old_qun = $cartTable[0]->quantity;
			if($this->input->post('action') == 'decrease'){
				$qun = $cartTable[0]->quantity - $quantity;
			}else{	
				$qun = $cartTable[0]->quantity + $quantity;
			}

			if($result[0]->max_order_qty!='' && $result[0]->max_order_qty!='0' && $qun > $result[0]->max_order_qty){
			
				$errormsg = 'Maximum order quantity reached';
				$old_qun = $result[0]->max_order_qty; // max sale quantity per order
			
			}elseif($qun > $result[0]->quantity){

				$errormsg = "Item Out Of Stock"; 
				$old_qun = $result[0]->quantity; // available quantity 
				$update_id = $cartTable[0]->id;
				$this->this_model->update_my_card($update_id,$old_qun);

			}else{ 

				if($this->input->post('action') == 'decrease'){
					$update_quantity = $cartTable[0]->quantity - $quantity;
				}else{
					$update_quantity = $cartTable[0]->quantity + $quantity;
				}
				// $update_calculation_price = $cartTable[0]->discount_price * $update_quantity;
				$update_id = $cartTable[0]->id;
				$this->this_model->update_my_card($update_id,$update_quantity);
				$my_cart = $this->this_model->getMyUpdatedCart($this->input->post());
				$price = $result[0]->discount_price * $qun;
				$new_total = $result[0]->discount_price * $my_cart[0]->quantity;
				$new_quan = $my_cart[0]->quantity;
			
			}

		}



		  if(!isset($errormsg)){
		  		$errormsg = '';
		  }if(!isset($new_quan)){
		  		$new_quan = '';
		  }if(!isset($new_total)){
		  		$new_total = '';
		  }

		$response = [
					 'new_quan'=>$new_quan,
					 'new_total'=>number_format((float)$new_total,2,'.',''),
					 'errormsg'=>$errormsg,
					 'final_total'=> getMycartSubtotal(),
					 'max_qun' =>$old_qun,
					 'updated_list'=>NavbarDropdown(),
					];
		echo json_encode($response);

	}

}
  
 ?>