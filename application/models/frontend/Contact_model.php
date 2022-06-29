<?php 

Class Contact_model extends My_model{

	function __construct(){
		$this->branch_id = $this->session->userdata('branch_id'); 
		$this->vendor_id = $this->session->userdata('vendor_id'); 
	}

	public function insertContactUs($postData){
		$insertContactDetail = [
			"vendor_id" => $this->vendor_id,
			"fname" => $postData['fname'], 
			"email" => $postData['email'], 
			"mobile_no" => $postData['mobile_no'], 
			"message" => $postData['message'],
			'created_at'=> DATE_TIME,
			'updated_at'=> DATE_TIME,
		];
		// dd($insertContactDetail);die;
        $data['insert'] = $insertContactDetail;
        $data['table'] = TABLE_CONTACT_US;
        $contacusId = $this->insertRecord($data);
        $contact = $this->getCommonKeysAndLink();
		$contact_email = $contact[0]->contact_email;
		// print_r($contact_email);die;
        if(!empty($contacusId)) {
        	$userDetail["name"] = $postData['fname'];
        	$userDetail["email"] = $postData['email'];
        	$userDetail["mobile_no"] = $postData['mobile_no'];
        	$userDetail["messages"] = $postData['message'];
        	$datas['message'] = $this->load->view('contact_us_template', $userDetail, true);
        	$datas['subject'] = 'Contact Us';
        	$datas["to"] = $contact_email;
        	$this->load->model('api_model');
        	$this->api_model->sendMailSMTP($datas);
        }
        return $contacusId;
    }

    public function getCommonKeysAndLink(){ 
		$data['table'] = 'firebase';
		$data['select'] = ['*'];
		// $data['where'] = ['vendor_id'=>$]
		$return =  $this->selectRecords($data);
		return $return;
	}

	public function getContact(){
		$data['table'] = CONTACT_INFO;
		$data['select'] = ['*'];
		$data['where'] = ['branch_id'=>$this->branch_id];
		return $this->selectRecords($data);
		// print_r($postdata);
		// exit;
	}
}

?>