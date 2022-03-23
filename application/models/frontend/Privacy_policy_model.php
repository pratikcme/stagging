<?php 

Class Privacy_policy_model extends My_model{


	public function getData(){
		$data['table'] = PRIVACY_POLICY;
		$data['select'] = ['*'];
		$data['where'] = ['vendor_id'=>$this->session->userdata('vendor_id')];
		return $this->selectRecords($data); 
	}
	
}

?>