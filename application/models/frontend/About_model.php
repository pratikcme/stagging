<?php 

Class About_model extends My_model{

	function __construct(){
		$this->vendor_id = $this->session->userdata('vendor_id');
		$this->branch_id = $this->session->userdata('branch_id');
	}

	public function getAboutBanner(){
		$data['table'] = TABLE_ABOUT_BANNER;
		$data['select'] = ['*'];
		$data['where'] = ['vendor_id'=>$this->vendor_id];
		return $this->selectRecords($data);
	}

	public function getAboutSectionOne(){
		$data['table'] = TABLE_ABOUT_SECTION_ONE;
		$data['select'] = ['*'];
		$data['where'] = ['vendor_id'=>$this->vendor_id];
		return $this->selectRecords($data);
		// echo $this->db->last_query();die;
	}

	public function getAboutSectionTwo(){
		$data['table'] = TABLE_ABOUT_SECTION_TWO;
		$data['select'] = ['*'];
		$data['where'] = ['vendor_id'=>$this->vendor_id];
		return $this->selectRecords($data);
	}

	public function totalVendor(){
		$data['table'] = TABLE_BRANCH;
		$data['select'] = ['*'];
		$data['where'] = ['status!='=>'9','domain_name'=>base_url()];
		return $this->countRecords($data);
	}
	
	public function totalCustomber(){
		$data['table'] = TABLE_USER;
		$data['select'] = ['*'];
		$data['where'] = ['status!='=>'9'];
		$data['where'] = ['vendor_id'=>$this->vendor_id];
		return $this->countRecords($data);
	}

	
}

?>