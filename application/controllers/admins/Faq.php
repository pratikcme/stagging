
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends Admin_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('admin/faq_model','this_model');
	}

	public function index()
	{
		$data['page'] = 'admin/faq/list';
		$data['js'] = array('faq.js');
		$data['init'] = array('FAQ.table()');
		$data['faq'] = $this->this_model->getCustomerSupportQuestion();
		$this->load->view('faq/list',$data);
	}


	public function add()
	{
		$data['page'] = 'admin/faq/technical/add';
		$data['js'] = array('faq.js');
		$data['init'] = array('FAQ.add()');
			if($this->input->post()){
				$validation = $this->serRules();
				if($validation){
					$result = $this->this_model->addRecord($this->input->post());
					 if($result){
					 	$this->utility->setFlashMessage($result[0],$result[1]);
						redirect(base_url().'admins/faq');
					 }
				}

			}
		$this->load->view('faq/add',$data);
	}

	function serRules(){

		$config = array(

				array(
					'field'=> 'question',
					'label'=> 'question',
					'rules' => 'trim|required',
					'errors' => [ 
							'required' => "please enter question"
						]
				),
				array(
					'field' => 'answer', 
                  	'label' => 'answer', 
                  	'rules' => 'trim|required',
                   	"errors" => [
                    	    'required' => "please enter answer"
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

	public function edit($id)
	{
		$id = $this->utility->safe_b64decode($id);
		$data['page'] = 'admin/faq/edit';
		$data['js'] = array('faq.js');
		$data['init'] = array('FAQ.edit()');
		$data['faq'] = $this->this_model->selectEditRecord($id);

		$this->load->view('faq/edit',$data);
	}

	public function update()
	{
		if($this->input->post()){
	   	 	$id = $this->utility->safe_b64decode($this->input->post('id'));
		    $result = $this->this_model->UpdateRecord($this->input->post(),$id);
			 if($result){
				$this->utility->setFlashMessage($result[0],$result[1]);
	    			redirect(base_url().'admins/faq');
				}
	    		
	    	}	
		}
	public function removeRecord(){
		 if($this->input->post()){
		   // $id = $this->utility->safe_b64decode($this->input->post('id'));
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