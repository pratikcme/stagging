<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Firebase extends Admin_Controller{
	function __construct(){
	// echo '1';die;
		parent::__construct();
		$this->load->model('firebase_model','this_model');
	}

	public function index(){
		// print_r($_SESSION);die;
		$data['js'] = array('firebase.js');
		$data['init'] = array('FIREBASE.init()');
		$data['getData'] = $this->this_model->getFireBase();
		// print_r($data['getData']);die;
		if($this->input->post()){		
				$data = $this->this_model->editUpdateFireBase($this->input->post());
				if($data){ 
					$this->utility->setFlashMessage($data[0],$data[1]);
					redirect(base_url().'firebase');
				}
		}
		$this->load->view('firebase_add_update',$data);
	}


}
