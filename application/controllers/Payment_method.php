<?php 
class Payment_method extends Vendor_Controller
{
	
	function __construct(){
		parent::__construct();
		$vendor_id = $this->session->userdata['id'];
		$this->load->model('payment_method_model','this_model');
	}

	public function index(){

		$data['paymentMethods'] = $this->this_model->get_payment_method();
		$this->load->view('payment_method',$data);
	}

	public function add_payment_method(){
		
		$data['paymentGetwayData'] = $this->this_model->getPaymentGetway();
		$this->load->view('add_payment_method',$data);
	}

	public function add_update_payment_method()
	{
		$this->this_model->add_update_payment_method($this->input->post());
	}

	public function check_publish_key(){
		if($this->input->post()){
			$result = $this->this_model->check_publish_key($this->input->post());
			if(count($result) > 0){
				echo "false";
			}else{
				echo "true";
			}
		}
	}

	public function check_secret_key(){
		if($this->input->post()){
			$result = $this->this_model->check_secret_key($this->input->post());
			if(count($result) > 0){
				echo "false";
			}else{
				echo "true";
			}
		}
	}

	public function status_change()
	{
		$id = $_GET['id'];
		$this->this_model->payment_method_change_status($id);
	}

	public function delete_payment_method()
	{
		$this->this_model->delete_payment_method();
	}

	public function IsTestOrLive(){
		if($this->input->post()){
			$result = $this->this_model->changeTestOrLive($this->input->post());
			echo json_encode(['status'=>$result]);
		}
	}
}
?>