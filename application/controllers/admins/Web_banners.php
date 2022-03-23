<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// error_reporting(E_ALL);
// ini_set("display_errors", '1');
class Web_banners extends Vendor_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('admin/web_banners_model','this_model');
	}

	public function index()
	{
		$data['page'] = 'admin/web_banners/list';
		$data['js'] = array('web_banners.js');
		$data['init'] = array('WEBBANNERS.table()','WEBBANNERS.delete()');
		// $data['getData'] = $this->this_model->getWebBannerImage();
		$data['section_two_data'] = $this->this_model->getWebBannerImage();
		$this->load->view('web_banners/list',$data);
	}

	public function add()
	{
		$data['page'] = 'admin/web_banners/add';
		$data['js'] = array('web_banners.js');
		$data['init'] = array('WEBBANNERS.add()');
		$data['FormAction'] = base_url().'admins/web_banners/add';
			if($this->input->post()){
				// echo "string"; die;
				$validation = $this->serRules();
				if($validation){
					$result = $this->this_model->addRecord($this->input->post());
					 if($result){
					 	$this->utility->setFlashMessage($result[0],$result[1]);
						redirect(base_url().'admins/about/about_section_two');
					 }
				}

			}
		$this->load->view('web_banners/add',$data);
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
        $data['page'] = 'admin/web_banners/edit';
        $data['js'] = array('web_banners.js');
        $data['init'] = array('WEBBANNERS.edit()');
        $data['getAboutSectionTwo'] = $this->this_model->selectSectionTwoEditRecord($id);
        
            if($this->input->post()){
                $result = $this->this_model->updateAboutRecord($this->input->post());
                    if($result){
                        $this->utility->setFlashMessage($result[0],$result[1]);
                        redirect(base_url().'admins/web_banners');
                    }
            }
        $this->load->view('web_banners/edit',$data);
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

	 // public function multipleDelete()
  //   {
  //       echo $ids = $_GET['ids'];
  //       $date = DATE_TIME;
  //       // $data = array('status' => '9', 'dt_updated' => strtotime(date('Y-m-d H:i:s')));

  //       $this->db->query("UPDATE web_banners SET status = '9', dt_updated = '$date' WHERE id IN ($ids)");

  //       // $this->db->WHERE_IN('id', $ids);
  //       // $this->db->UPDATE('banner_promotion', $data);

  //       // echo $this->db->last_query(); die;
        
  //       ob_get_clean();
  //       header('Access-Control-Allow-Origin: *');
  //       header('Content-Type: application/json');
  //       echo json_encode(['status'=>1]);
  //       exit;
  //   }


}
?>