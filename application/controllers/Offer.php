
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends Admin_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('offer_model','this_model');
	}

	public function index()
	{
		
		$data['page'] = 'offer/list';
		$data['js'] = array('offer.js');
		$data['init'] = array('OFFER.table()','OFFER.delete()');
		$data['offer'] = $this->this_model->getOffer();
		$this->load->view('offer/list',$data);
	}

	public function add($branch_id=''){
		$data['page'] = 'offer/add';
		$data['js'] = array('offer.js');
		$data['init'] = array('OFFER.add()','OFFER.table()');

		$data['FormAction'] = base_url().'offer/add';
			if($this->input->post()){
				$validation = $this->serRules();
				if($validation){
					$result = $this->this_model->addRecord($this->input->post());
					 if($result){
					 	$this->utility->setFlashMessage($result[0],$result[1]);
						redirect(base_url().'offer');
					 }
				}

			}
		$this->load->model('banners_model');
		$data['branchList'] = $this->banners_model->getBranch();
		$data['producList'] = [];
		if($branch_id != ''){
			$data['producList'] = $this->this_model->getproductVarient($branch_id);
		}
		$this->load->view('offer/add',$data);
	}

	public function edit($branch_id=''){

		$data['js'] = array('offer.js');
		$data['init'] = array('OFFER.table()','OFFER.edit()');

		$data['FormAction'] = base_url().'offer/edit';
			if($this->input->post()){
				$validation = $this->serRules();
				if($validation){
					$result = $this->this_model->updateRecord($this->input->post());
					 if($result){
					 	$this->utility->setFlashMessage($result[0],$result[1]);
						redirect(base_url().'offer');
					 }
				}

			}
		$this->load->model('banners_model');
		$data['branchList'] = $this->banners_model->getBranch();
		$data['editRecord'] = $this->this_model->getOffer($this->uri->segment(4)); 
		// print_r($data['editRecord']);die;

		$data['producList'] = [];
		if($branch_id != ''){
			$data['producList'] = $this->this_model->getproductVarient($branch_id);
			$offerAndDetails = $this->this_model->getOfferAndOfferDetails($this->uri->segment(4));
			$offerDetails = [];
			foreach ($offerAndDetails as $key => $value) {
				$offerDetails[] = $value->product_varient_id;
			}
		}
		$data['offerDetails'] = $offerDetails;
		$this->load->view('offer/edit',$data);
	}


	function serRules(){

		$config = array(

				array(
					'field'=> 'offer_title',
					'label'=> 'offer_title',
					'rules' => 'trim|required',
					'errors' => [ 
							'required' => "please enter main title"
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

	public function view($id){
		$id = $this->utility->decode($id);
		$data['offer_detail'] = $this->this_model->getOffer_detail($id);
		// dd($data['offer_detail']);die;
		$this->load->view('offer/view',$data);
	}






	public function showProduct(){
		echo showProductOnOffer($this->input->post());
	}

	public function edit_old($id=''){

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
	public function getselectedVarient(){
		if($this->input->post()){
			// dd($this->input->post('varient_ids'));
			$branch_id = $this->input->post('branch_id');
			$variant_ids = $this->input->post('varient_ids');
			$productVarientList = $this->this_model->getproductVarient($branch_id);

			$html = '';
			foreach ($productVarientList as $key => $value) {
				if(in_array($value->id,$variant_ids)){
				$html .= ' <tr><td>'.$value->product_name.'</td><td><input type="text" name="update_discount[]" value="'.$value->discount_per.'" class="form-control discount_per">
				<div><label class"error_sp text-danger" style="color:red;font-size: 11px;float: left;"> </label></div>
				</td><td>'.$value->price.'</td><td>'.$value->weight_no.' '.$value->weight_name.' '.$value->package.'</td></tr>';
				$html .= '<input type="hidden" name="exiting_discount_per[]" value="'.$value->discount_per.'"';
				}
			}

			$html .= '<tr ><td colspan="4" class="last-td"><button type="submit" id="btnSubmit" class="btn btn-danger">Add</button></td></tr>';
		}
		echo json_encode(['html'=>$html]);
	}

	public function test(){
		$this->this_model->test();
		
	}


	


}
?>