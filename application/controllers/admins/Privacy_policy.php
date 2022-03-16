
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacy_policy extends Admin_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('admin/privacy_policy_model','this_model');
	}

	public function index()
	{
		// echo "<pre>";
		// print_r($_SESSION);die;
		$data['js'] = array('privacy.js');
		$data['init'] = array('PRIVACY.table()');
		$data['getPrivacy'] = $this->this_model->getPrivacyRecord();
		$this->load->view('privacy/list',$data);
	}


	public function add(){

		$data['js'] = array('privacy.js');
		$data['init'] = array('PRIVACY.add()');
			if($this->input->post()){
				$validation = $this->serRules();
				if($validation){
					$result = $this->this_model->addRecord($this->input->post());
					 if($result){
					 	$this->utility->setFlashMessage($result[0],$result[1]);
						redirect(base_url().'admins/privacy_policy');
					 }
				}

			}
		$this->load->view('privacy/add',$data);
	}

	function serRules(){

		$config = array(

				array(
					'field'=> 'title',
					'label'=> 'title',
					'rules' => 'trim|required',
					'errors' => [ 
							'required' => "please enter title"
						]
				),
				array(
					'field' => 'sub_title', 
                  	'label' => 'sub_title', 
                  	'rules' => 'trim|required',
                   	"errors" => [
                    	    'required' => "please enter sub title"
                    ] 
                )
            	
		);


        $this->form_validation->set_rules($config);
         if($this->form_validation->run() == FALSE){
            // echo validation_errors(); exit();
         }
         else{
            return true;
        }
	}

	public function edit($id ='')
	{
		$id = $this->utility->safe_b64decode($id);
		$data['js'] = array('privacy.js');
		$data['init'] = array('	PRIVACY.edit()');
		$data['editRecord'] = $this->this_model->selectEditRecord($id);

		$this->load->view('privacy/edit',$data);
	}

	public function update()
	{
		if($this->input->post()){
	   	 	$id = $this->utility->safe_b64decode($this->input->post('id'));
		    $result = $this->this_model->UpdateRecord($this->input->post(),$id);
			 if($result){
				$this->utility->setFlashMessage($result[0],$result[1]);
	    			redirect(base_url().'admins/privacy_policy');
				}
	    		
	    	}	
		}
		
	public function removeRecord(){
		 if($this->input->post()){
		   $id = $this->input->post('id');
		   $response = $this->this_model->removeRecord($id);
		 }
		 if($response){
		 	echo json_encode(['status'=>1]);
		 }

	}

		public function multi_delete()
	{
		 $this->this_model->multipleDelete();
		
	}		
}
?>