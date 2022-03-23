<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_section_two extends Admin_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('admin/about/About_section_two_model','this_model');
	}

	public function index()
	{
		$data['page'] = 'admin/about/section_two';
		$data['js'] = array('about.js');
		$data['init'] = array('ABOUT.table()','ABOUT.delete()');
		$data['getData'] = $this->this_model->getAboutSectionTwo();
		// echo $this->db->last_query();die;
		$data['section_two_data'] = $this->this_model->aboutSectionTwo();

		if($this->input->post()){				
				$data = $this->this_model->editUpdateSectionTwo($this->input->post());
				if($data){ 
					$this->utility->setFlashMessage($data[0],$data[1]);
					redirect(base_url().'admin/about/about_section_two');
				}
		}
		$this->load->view('about/section_two',$data);
	}

	public function getTable(){
		echo $dataTable = getAboutSectionTable($this->input->post());
	}


	public function add()
	{
		$data['page'] = 'home_content/add';
		$data['js'] = array('about.js');
		$data['init'] = array('ABOUT.add()');
			if($this->input->post()){
				$validation = $this->serRules();
				if($validation){
					$result = $this->this_model->addRecord($this->input->post());
					 if($result){
					 	$this->utility->setFlashMessage($result[0],$result[1]);
						redirect(base_url().'admins/about/about_section_two');
					 }
				}

			}
		$this->load->view('about/add_section_two',$data);
	}

	function serRules(){

		$config = array(

				array(
					'field'=> 'name',
					'label'=> 'name',
					'rules' => 'trim|required',
					'errors' => [ 
							'required' => "please enter name"
						]
				),
				array(
					'field'=> 'designation',
					'label'=> 'designation',
					'rules' => 'trim|required',
					'errors' => [ 
							'required' => "please enter designation"
						]
				),
				array(
					'field' => 'content', 
                  	'label' => 'content', 
                  	'rules' => 'trim|required',
                   	"errors" => [
                    	    'required' => "please enter content"
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

	 public function edit($id=''){

        $id = $this->utility->safe_b64decode($id);
        $data['page'] = 'admin/about/edit_section_two';
        $data['js'] = array('about.js');
        $data['init'] = array('ABOUT.edit()');
        $data['getAboutSectionTwo'] = $this->this_model->selectSectionTwoEditRecord($id);
        
            if($this->input->post()){

                $result = $this->this_model->updateAboutRecord($this->input->post());
                    if($result){
                        $this->utility->setFlashMessage($result[0],$result[1]);
                        redirect(base_url().'admins/about/about_section_two');
                    }
            }
        $this->load->view('about/edit_section_two',$data);
    }

	public function removeRecord(){

	 if($this->input->post()){
		   // $id = $this->utility->safe_b64decode($this->input->post('id'));
		   $response = $this->this_model->removeRecord($this->input->post('id'));

		 }
		 if($response){
		 	echo json_encode(['status'=>1]);
		 }

	}

	public function multipleDelete()
	{
		$re = $this->this_model->multi_delete();
		
	}	
}
?>