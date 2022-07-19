<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends User_Controller {

	function __construct(){
		parent::__construct();
		$this->controller = $this->myvalues->orderFrontEnd['controller'];
		// $this->url = SITE_URL . 'frontend/'. $this->controller;
		$this->load->model($this->myvalues->orderFrontEnd['model'],'this_model');
		$user_id = $this->session->userdata('user_id');
		if(!isset($user_id)){
			redirect(base_url().'login');
		}
	}


	public function index(){
		$data['page'] = 'frontend/order';
		$data['order'] = $this->this_model->selectOrders();
		$this->loadView(USER_LAYOUT,$data);
	}


	public function view($id){
		error_reporting(0);
		$id = $this->utility->safe_b64decode($id);
		$data['page'] = 'frontend/order_detail';
		$data['order'] = $this->this_model->selectOrdersfor($id);
		$address_id = $data['order'][0]->user_address_id;
		$data['user_address'] = $this->this_model->user_address($address_id);
		$useremail = $this->this_model->getUserEmail();
		$data['user_address'][0]->email = $useremail[0]->email; 
		$data['view_detail'] = $this->this_model->selectOrderDetails($id);

		foreach ($data['view_detail'] as $key => $value) {
		$pr = $this->this_model->selectproductname($value->product_id);
		$pr_img = $this->this_model->select_product_image($value->product_weight_id);
		$data['view_detail'][$key]->prouduct_name =  $pr[0]->name;
		 $data['view_detail'][$key]->prouduct_image =  $pr_img[0]->image;
		}

		// echo '<pre>';
		// print_r($data['view_detail']);
		// exit;	
		$this->loadView(USER_LAYOUT,$data);


}
	public function makeorder(){

		$user_id = $this->session->userdata('user_id');
		if($this->input->post()){
			// echo $this->session->userdata('user_id'); die;
			$re = $this->this_model->checkProductQuantityAvailabale();
			// echo $this->db->last_query();
			if($re==false){
				$this->utility->setFlashMessage('danger','Product out of the stock');
				echo json_encode(['status'=>0]);
				exit();
			}
			
			$payment = $this->input->post('paymentOption');
			if($payment == 0 ){
				// print_r($this->input->post());die;
				$this->load->model('frontend/checkout_model','checkout_model');
				$re = $this->checkout_model->unreserve_product_userwise($user_id);
				$result = $this->this_model->makeOrder();
				$message = json_decode($result);
				if($message->responsedata->success){
					$this->utility->setFlashMessage('success',$message->responsedata->message);
					$this->session->unset_userdata('My_cart');
					$redirect = base_url().'home';
					$status = $message->responsedata->success;
					$order_number = $message->responsedata->order_number;
				}else{
					$this->utility->setFlashMessage('danger',$message->responsedata->message);
					$redirect = base_url().'home';
					$status = 0;
					$order_number = '';
				}
			}else{
				$this->utility->setFlashMessage('danger','This is Under implementation');
				$redirect = base_url().'checkout';
				$status = 0;
				$order_number = '';
			}
			// print_r($redirect);die;
			echo json_encode(['status'=>$status,'url'=>$redirect,'order_number'=>$order_number]);
		}
	}

	public function success($id){
		// echo '1';die;
		$data['page'] = 'frontend/order_success';
		$data['order_number'] = $id;
		$this->load->view(USER_LAYOUT,$data);
	}

	public function check(){
		$re = $this->this_model->checkProductQuantityAvailabale();
			// echo $this->db->last_query();
			if($re==false){
				$this->utility->setFlashMessage('danger','Product out of the stock');
				echo json_encode(['status'=>0]);
				exit();
			}
		echo json_encode(['status'=>1]);
	}

	// public function stripepayment(){
	// 		$data['page'] = 'frontend/stripe_payment';
	// 		$data['js'] = array('payment_stripe.js');
		
 //            if(isset($_SESSION['My_cart'])){
 //                  $total = 0;
 //                foreach ($_SESSION['My_cart'] as $key => $value) {
 //                  $total += $value['total'];
 //                  }  

	//         }else{
	//           $total = '';
	//        } 
	// 		$this->load->model($this->myvalues->productFrontEnd['model'],'product_model'); 
	// 		$result = $this->this_model->getUserAddressLatLong();
	// 		$userLat = $result[0]->latitude; 
	// 		$userLong = $result[0]->longitude; 
	// 		$calc_shiping = $this->this_model->getDeliveryCharge($userLat,$userLong,$this->session->userdata('vendor_id'));
	// 		$data['total_payment'] =  $calc_shiping + $total;
	// 		$this->load->view('frontend/stripe',$data);
	// 	}

		// public function stripepost(){
		// 	// print_r($this->input->post());die;
			
		// 	$token = $this->input->post('stripeToken');
		// 	if(isset($token)){
		// 		require_once('application/libraries/stripe/init.php');
		    
		//     \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
		     
		//     $data=\Stripe\Charge::create ([
		//                 "amount" => $this->input->post('paying_amount') * 100,
		//                 "currency" => "inr",
		//                 "source" => $this->input->post('stripeToken'),
		//                 "description" => "payment from grocermart" 
		//         ]);
            
		// 	}
		// 	echo '<pre>';
		// 	print_r($data);
		// 	printf($data->id);
		// 	die;
		// 	if($data->status == 'succeeded'){
				
		// 		if($message->responsedata->success){
		// 			$this->utility->setFlashMessage('success',$message->responsedata->message);
		// 			$this->session->unset_userdata('My_cart');
		// 			redirect(base_url().'frontend/order');
		// 		}else{
		// 			$this->utility->setFlashMessage('danger','Somthing went Wrong');
		// 			// $this->session->unset_userdata('My_cart');
		// 			redirect(base_url().'frontend/checkout');
		// 		}
		// 	}
       
  //   }

	public function cancle_order($id){
		$postdata['order_id'] = $this->utility->safe_b64decode($id);
        if (isset($postdata['order_id'])) {
            $cancle = $this->this_model->cancle_order($postdata);
            
            $this->load->model('api_v3/api_admin_model','api_v3_api_admin_model');
            $order_log_data = array('order_id' =>$postdata['order_id'],'status'=>'9');
            $this->api_v3_api_admin_model->order_logs($order_log_data);

            if(!$cancle){
            	$this->utility->setFlashMessage('danger','Order can not cancle');
                redirect(base_url().'/users_account/users/account?name=order');
                die;
            }
            $this->load->model('api_v3/staff_api_model','api_v3_staff_api_model');
            $order_id = $postdata['order_id'];
            $this->api_v3_staff_api_model->send_notificaion($order_id);
            $this->utility->setFlashMessage('success','Order is cancelled');
            redirect(base_url().'/users_account/users/account?name=order');
            die;
        } else {
        	$this->utility->setFlashMessage('danger','Invalid data');
            redirect(base_url().'/users_account/users/account?name=order');
            die;
        }
    }
    
	// public function cancel($id){
	// 	$id = $this->utility->safe_b64decode($id);
	// 	$r =$this->this_model->cancelOrder($id);
	// 	if($r){
	// 		redirect(base_url().'frontend/order');
	// 	}

	// }
}
