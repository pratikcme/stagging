<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends User_Controller {

	function __construct(){
		parent::__construct();
	}


	public function index()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}

	public function user_logout(){
		// print_r($_SESSION);die;
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('user_name');
		$this->session->unset_userdata('user_lname');
		$this->session->unset_userdata('user_email');
		$this->session->unset_userdata('user_phone');
		$this->session->unset_userdata('logged_in');
		// $this->session->sess_destroy();
		$this->session->unset_userdata('My_cart');
	}
}
