<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Vendors extends User_Controller {

	function __construct(){

		parent::__construct();
		$this->controller = $this->myvalues->vendorFrontEnd['controller'];
		
		$this->load->model($this->myvalues->vendorFrontEnd['model'],'this_model');
		$this->session->unset_userdata('isSelfPickup');
	}


	public function index(){
		$data['page'] = 'frontend/vendor/vendor';
		$data['js'] = array('vendor.js');
		$data['branch'] = $this->this_model->branchList();
		$branch_id = count($data['branch']);
		foreach ($data['branch'] as $key => $value) {
			$data['branch'][$key]->product_count = $this->this_model->branchProductCount($value->id);
		};

		
		$Approved = $this->this_model->ApprovedVendor();
		// lq();
		if(!empty($Approved)  && ($Approved[0]->approved_branch == '1' || $branch_id == '1')){
			$branch_id = $data['branch'][0]->id;
	 		$branch_name = $data['branch'][0]->name;
			$this->load->model('vendor_model','vendor');

			$branch = array('branch_id'=>$branch_id,
							'branch_name' => $branch_name,
							'vendor_id'=>$data['branch'][0]->vendor_id
							);

		
			$this->session->set_userdata($branch);
	
			if($this->session->userdata('branch_id') !== $branch_id){
				$result = $this->this_model->MyCartRemove();	
				$this->session->unset_userdata('My_cart');
			}
	
			redirect(base_url().'home');
		}

	
		
		if(isset($_SESSION['currentlat']) && $_SESSION['currentlat'] != '' && isset($_SESSION['currentlat']) && $_SESSION['currentlong'] !=''){
			// echo '<pre>';
			// print_r($_SESSION);die;
			$data['is_set'] = '1';
		}else{
			$data['is_set'] = '0';
		}
		$this->loadView(USER_LAYOUT,$data);
		
	}

	public function list()
	{
		$data['page'] = 'vendor/list';
		$data['js'] = array('vendor.js');
		$data['branch'] = $this->this_model->brandList();
		foreach ($data['branch'] as $key => $value) {
		$data['branch'][$key]->product_count = $this->this_model->venderProductCount($value->id);
		};	
		$this->loadView(USER_LAYOUT,$data);
	}

	public function set($id = ''){
		// print_r($_SESSION);
		$vendor_id = $this->input->post('vendor_id');

			if(isset($_SESSION['branch_id'])){
				
			if($this->session->userdata('branch_id') !== $vendor_id){
				$result = $this->this_model->MyCartRemove();
				$this->session->unset_userdata('My_cart');
			}
		}
		$this->load->model('vendor_model','vendor');
		$branch = $this->vendor->getVendorName($vendor_id);
		$branch_id = $branch[0]->id; 
		$branch_name = $branch[0]->name; 

		$branch_info = array('branch_id'=>$branch_id,
						'branch_name' => $branch_name,
						'vendor_id' =>$branch[0]->vendor_id
						);
		$this->session->set_userdata($branch_info);
		$ven_id = $this->session->userdata('branch_id');
		if(isset($ven_id) && $ven_id != ''){
			// echo $d = base_url().'frontend/home';
			echo $d = base_url().'home';
			 // redirect(base_url().'frontend/home');
		}else{
			echo $d = base_url();
			// redirect(base_url());
		}
	}

	public function setCurrentlatLong(){
		if($this->input->post()){
			$lat = $this->input->post('currentlat');
			$long = $this->input->post('currentlong');
			if($lat != '' && $long != ''){
				$this->session->set_userdata('currentlat',$lat);
				$this->session->set_userdata('currentlong',$long);
			};
		}
	}

	function serchByVendorName(){
		
		if($this->input->post()){
			$record = $this->this_model->branchList($this->input->post());
			foreach ($record as $key => $value) {
			$record[$key]->product_count = $this->this_model->branchProductCount($value->id);
			};
			// print_r($record);
			// die;
			$vendor_html = '';
			foreach ($record as $key => $value) {
	$attr = (isset($_SESSION["vendor_id"]) && $value->id == $_SESSION["vendor_id"]) ? "checked" : "";
	$vendor_html .=	'<div class="col-md-6">
          <div class="vendor-loc">
            <div class="vendor-header">
              <div class="address-chk-box '.$attr.' ">
               <label> Defualt
                  <input class="vendor-chk" type="checkbox" ' .$attr.'>
                  <span class="blue"></span>
                </label>
              </div>
            </div>
            <div class="vendor-1">
              <div class="vendor-img">
                <img src='.base_url().'public/images/'.$this->folder.'vendor_shop/'.$value->image .'>
              </div>
              <div class="vendor-detail">
                <a href="javascript:" class="vendor" data-ven_id='.$value->id.'><h5>'.$value->name.'</h5></a>
                <p>'.$value->location.'</p>
                <p>+91-'.$value->phone_no.'</p>
              </div>
            </div>
          </div>
        </div>';
				
	}

			// print_r($vendor_html);
			echo json_encode(['vendor_html'=>$vendor_html]);

		}

	}


}
