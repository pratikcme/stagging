<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_database extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Migration_database_new_model','this_model');
	}


	public function index(){
 		$this->this_model->make_query();
	}

}
  
 ?>