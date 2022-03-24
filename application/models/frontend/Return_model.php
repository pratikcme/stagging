<?php 

Class Return_model extends My_model{


	public function getAllData(){
		$data['table'] = RETURN_REFUND;
		$data['select'] = ['*'];
		$data['where'] = ['vendor_id'=>$this->session->userdata('vendor_id')];
		return $this->selectRecords($data); 
	}

	public function getTermData(){
		$data['table'] = TERM;
		$data['select'] = ['*'];
		$data['where'] = ['vendor_id'=>$this->session->userdata('vendor_id')];
		return $this->selectRecords($data); 
	}
	
}

?>