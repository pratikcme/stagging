<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messagelist extends Admin_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model("admin/contact/Messeagelist_model",'this_model');
	}

	public function index()
	{
		
		$data['js'] = array('contact.js');
		$data['init'] = array('CONTACT.messagelist()');	
		$data['meassagelist'] = $this->this_model->selectMessageList();	
		// print_r($data['meassagelist']);die;
		$this->load->view('contact/contactusform',$data);
	}

	public function getusersMessage()
	{	
		$datatable = UsersContactMessageDataTable($this->input->post());
	}

}
?>