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

}
?>