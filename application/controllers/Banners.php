<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banners extends Admin_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('banners_model','this_model');
	}

	public function index()
	{
		$data['page'] = 'banners/list';
		$data['js'] = array('banners.js');
		$data['init'] = array('BANNERS.table()','BANNERS.delete()');
		$data['banners'] = $this->this_model->getBanners();
		// dd($data['banners']);
		$this->load->view('banners/list',$data);
	}

	public function add(){
		$data['page'] = 'banners/add';
		$data['js'] = array('banners.js');
		$data['init'] = array('BANNERS.add()');
		$data['FormAction'] = base_url().'banners/add';
			if($this->input->post()){
				$validation = $this->serRules();
				if($validation){
					$result = $this->this_model->addRecord($this->input->post());
					 if($result){
					 	$this->utility->setFlashMessage($result[0],$result[1]);
						redirect(base_url().'banners');
					 }
				}

			}
		// $data['category'] = $this->this_model->CategoryList();
		// $this->load->model('frontend/vendor_model','v_model');
		$data['branchList'] = $this->this_model->getBranch();
		$this->load->view('banners/add',$data);
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
				),array(
					'field'=> 'type',
					'label'=> 'type',
					'rules' => 'trim|required',
					'errors' => [ 
							'required' => "please select type"
						]
				),
            	
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
        $data['page'] = 'banners/edit';
        $data['js'] = array('banners.js');
        $data['init'] = array('BANNERS.edit()');
        $data['FormAction'] = base_url().'banners/edit';
        $data['editRecord'] = $this->this_model->getBanners($id);

            if($this->input->post()){
                $result = $this->this_model->updateRecord($this->input->post());
                    if($result){
                        $this->utility->setFlashMessage($result[0],$result[1]);
                        redirect(base_url().'banners');
                    }
            }
        $branch_id = $data['editRecord'][0]->branch_id;
        $data['category']	= $this->this_model->get_category_list([],$branch_id);
        $data['product'] = $this->this_model->get_product_list([],$branch_id);
        if($data['editRecord'][0]->product_id != ''){
        	$product_id =  $data['editRecord'][0]->product_id;
        	$data['product_varient'] = $this->this_model->getproductVarient([],$product_id);
        } 
        $data['branchList'] = $this->this_model->getBranch();
        $this->load->view('banners/edit',$data);
    }

	public function removeRecord(){

	 if($this->input->post()){
		 $response = $this->this_model->removeRecord($this->input->post('id'));
		 if($response){
		 	echo json_encode(['status'=>1]);
		 }
		}

	}

	public function multipleDelete()
	{
		$re = $this->this_model->multi_delete();
		
	}	



	public function get_category_list(){
		if($this->input->post()){
			$category = $this->this_model->get_category_list($this->input->post());
			$product = $this->this_model->get_product_list($this->input->post());
			$category_list = '<option value="">Select category</option>';
			$product_list = '<option value="">Select product</option>';
			
			foreach ($category as $key => $value) {
				$category_list .='<option value='.$value->id.'>'.$value->name.'</option>';
			}

			foreach ($product as $key => $value) {
				$product_list .='<option value='.$value->id.'>'.$value->name.'</option>';
			}

			echo json_encode(['category_list'=>$category_list,'product_list'=>$product_list]);
		}
	}

	public function getproductVarient(){
		if($this->input->post()){
			$varient = $this->this_model->getproductVarient($this->input->post());
			$varient_list = '<option value="">Select product varient</option>';
			foreach ($varient as $key => $value) {
				$varient_list .='<option value='.$value->id.'>'.$value->weight_no.' '.$value->name.'</option>';
			}

			echo json_encode(['varient_list'=>$varient_list]);
		}
	}
	


}
?>