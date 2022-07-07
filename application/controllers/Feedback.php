<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends Admin_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('feedback_model','this_model');
	}

	public function index()
	{
		$data['page'] = 'feedback/list';
		$data['js'] = array('feedback.js');
		$data['getFeedBack'] = $this->this_model->get_feedback();
		$this->load->view('feedback/list',$data);
	}

}
?>