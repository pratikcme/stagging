<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_content extends Vendor_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('home_content_model','this_model');
	}

	public function index()
	{
		$data['page'] = 'home_content/list';
		$data['js'] = array('home_content.js');
		$data['init'] = array('HOME_CONTENT.table()');
		$data['getData'] = $this->this_model->getAboutSectionTwo();
		$data['section_two_data'] = $this->this_model->aboutSectionTwo();
		
		if($this->input->post()){				
				$data = $this->this_model->editUpdateSectionTwo($this->input->post());
				if($data){ 
					$this->utility->setFlashMessage($data[0],$data[1]);
					redirect(base_url().'home_content/about_section_two');
				}
		}
		$this->load->view('home_content/list',$data);
	}

	public function getTable(){
		echo $dataTable = getAboutSectionTable($this->input->post());
	}


	public function add()
	{
		$data['page'] = 'home_content/add';
		$data['js'] = array('home_content.js');
		$data['init'] = array('HOME_CONTENT.add()');
			if($this->input->post()){
				$validation = $this->serRules();
				if($validation){
					$result = $this->this_model->addRecord($this->input->post());
					 if($result){
					 	$this->utility->setFlashMessage($result[0],$result[1]);
						redirect(base_url().'home_content');
					 }
				}

			}
		$this->load->view('home_content/add',$data);
	}

	function serRules(){

		$config = array(

				array(
					'field'=> 'main_title',
					'label'=> 'main_title',
					'rules' => 'trim|required',
					'errors' => [ 
							'required' => "please enter main title"
						]
				),
				array(
					'field'=> 'sub_title',
					'label'=> 'sub_title',
					'rules' => 'trim|required',
					'errors' => [ 
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

	 public function edit($id=''){

        $id = $this->utility->safe_b64decode($id);
        $data['js'] = array('home_content.js');
        $data['init'] = array('HOME_CONTENT.edit()');
        $data['getAboutSectionTwo'] = $this->this_model->selectSectionTwoEditRecord($id);
        
            if($this->input->post()){
            	// print_r($this->input->post());die;
                $result = $this->this_model->updateAboutRecord($this->input->post());
                    if($result){
                        $this->utility->setFlashMessage($result[0],$result[1]);
                        redirect(base_url().'home_content');
                    }
            }
        $this->load->view('home_content/edit',$data);
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

	public function multipleDelete(){
		$re = $this->this_model->multi_delete();
	}	

	public function home_section_one(){
		$data['js'] = array('home_content.js');
		$data['init'] = array('HOME_CONTENT.content_one()');
		$data['getData'] = $this->this_model->getSectionOne();
		// print_r($data['getData']);die;
		if($this->input->post()){	
			// echo "<pre>";
			// print_r($this->input->post());
			// print_r($_FILES);
			// die;
				$data = $this->this_model->addEditSectionOne($this->input->post());
				if($data){ 
					$this->utility->setFlashMessage($data[0],$data[1]);
					redirect(base_url().'home_content/home_section_one');
				}
		}
		$this->load->view('home_content/section_one',$data);

	}


	public function home_section_one_background(){
		$data['getData'] = $this->this_model->getSectionOneBackground();

		$data['js'] = array('home_content.js');
		$data['init'] = array('HOME_CONTENT.content_one()');
		if($this->input->post()){	
			// echo "<pre>";
			// print_r($_FILES);
			// die;
				$data = $this->this_model->addEditSectionOneBackground($this->input->post());
				if($data){ 
					$this->utility->setFlashMessage($data[0],$data[1]);
					redirect(base_url().'home_content/home_section_one_background');
				}
		}
		$this->load->view('home_content/section_one_background',$data);

	}
}
?>