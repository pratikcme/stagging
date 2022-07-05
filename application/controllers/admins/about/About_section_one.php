
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_section_one extends Admin_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('admin/about/About_section_one_model','this_model');
	}

	public function index()
	{
		// $data['page'] = 'admin/about/section_one';
		$data['js'] = array('about.js');
		$data['init'] = array('ABOUT.section_one()');
		$data['getData'] = $this->this_model->getAboutSectionOne();
		if($this->input->post()){				
				$data = $this->this_model->editUpdateSectionOne($this->input->post());
				if($data){ 
					$this->utility->setFlashMessage($data[0],$data[1]);
					redirect(base_url().'admins/about/about_section_one');
				}
		}
		$this->load->view('about/section_one',$data);
	}


	// public function deleteRecord()
	// {
	// 	$id = $this->utility->safe_b64decode($this->input->post('id'));
	// 	$data = $this->this_model->deleteRecord($id);
	// 		echo $data;	
	// }

	// public function edit($id)
	// {
	// 	$id = $this->utility->safe_b64decode($id);
	// 	$data['page'] = 'admin/category/edit';
	// 	$data['js'] = array('category.js');
	// 	$data['init'] = array('CATEGORY.edit()');
	// 	$data['category'] = $this->this_model->selectEditRecord($id);
	// 	$this->load->view(ADMIN_LAYOUT,$data);
	// }

	// public function update()
	// {
	//     $id = $this->utility->safe_b64decode($this->input->post('id'));
	//     $cat = $this->this_model->selectCategory($id);
	    
	//     	if($cat[0]->category_name === $this->input->post('add_category')){
	//     		redirect(base_url().'admin/category/category');
	//     	}else{
	//     		$valid = $this->setRules();
	//     		if($valid){
	// 				 $result = $this->this_model->UpdateRecord($this->input->post(),$id);
	// 				 	if($result){
	// 				 		$this->utility->setFlashMessage($result[0],$result[1]);
	//     			 		redirect(base_url().'admin/category/category');
	// 				 	}
	//     		}else{
	//     			$this->utility->setFlashMessage('danger','category name already exist');
	//     			redirect(base_url().'admin/category/category');
	//     		}
	//     	}		
	// }

	


}
