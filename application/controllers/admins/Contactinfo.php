<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contactinfo extends Admin_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('admin/contact/Contact_model','this_model');
	}

	public function index()
	{
		$data['page'] = 'admin/contact/add';
		$data['js'] = array('contact.js');
		$data['init'] = array('CONTACT.init()');
		$data['getData'] = $this->this_model->getContactInfo();
		
		if($this->input->post()){	
				$data = $this->this_model->editUpdateContactInfo($this->input->post());
				if($data){ 
					$this->utility->setFlashMessage($data[0],$data[1]);
					redirect(base_url().'admins/contactinfo');
				}
		}
		$this->load->view('contact/add',$data);
	}

}
?>