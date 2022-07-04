<?php 

class Vendor_model extends My_model{


	public function branchList($vendorName = []){
		
		$clat = $this->session->userdata('currentlat');
		$clong = $this->session->userdata('currentlong');
		$data['table'] = 'delivery_charge';
		$data['select'] = ['max(end_range) as maxRange'];
		$max = $this->selectRecords($data);	
		$maxRange = $max[0]->maxRange;
		
		if(isset($clat) && $clat != '' && isset($clong) && $clong != ''){
		$data['select'] = ['*',"(3956 * 2 * ASIN(SQRT( POWER(SIN(($clat - latitude) *  pi()/180 / 2), 2) +COS( $clat * pi()/180) * COS(latitude * pi()/180) * POWER(SIN(( $clong - longitude) * pi()/180 / 2), 2) ))) as distance"];
			$data['having'] = ['status' => '1','distance <=' =>$maxRange];
			}else{
			$data['select'] = ['*'];
			$data['where'] = ['status'=>'1'];
			}
		$data['table'] = TABLE_BRANCH;

		if($this->uri->segment(1) != 'vendors' && $this->uri->segment(2) != 'list'){
		
		}
		if(!empty($vendorName) && $vendorName['vendor_name'] != ''){
			$data['like'] = ['name',$vendorName['vendor_name'],true];
		}
		if(!empty($vendorName) && $vendorName['id'] != ''){
			$data['where'] = ['id'=>$vendorName['id']];
		}
		$data['where'] = ['domain_name'=>base_url(),'status'=>'1'];
		
		return  $this->selectRecords($data);
	
	}

	public function venderListAll($id =''){
		if($id != ''){
			$data['where']['id'] = $id;
		}
		$data['table'] = TABLE_VENDOR;
		$data['select'] = ['*'];
		$data['where']['status'] = '1';
		$data['where']['domain_name'] = base_url();
		return $this->selectRecords($data);
	}

	public function ApprovedBranch(){
		$data['table'] = TABLE_BRANCH;
		$data['select'] = ['*'];
		$data['where'] = ['domain_name'=>base_url(),'status'=>'1'];
		return $this->selectRecords($data);
		
	}

	public function ApprovedVendor(){
		$data['table'] = ADMIN;
		$data['select'] = ['*'];
		$data['where'] = ['server_name'=>$_SERVER['SERVER_NAME']];
		return $this->selectRecords($data);
		
	}

	public function branchProductCount($branch_id){
		$data['table'] = TABLE_PRODUCT;
		$data['select'] = ['*'];
		$data['where']['branch_id']= $branch_id;
		$data['where']['status'] = '1';
		return $this->countRecords($data);
	}

	public function MyCartRemove(){
		$data['table'] = TABLE_MY_CART;
		$data['where']['user_id'] = $this->session->userdata('user_id');
		return $this->deleteRecords($data);
	}

	public function getVendorName($vendor_id){
		$data['table'] = TABLE_VENDOR;
		$data['select'] = ['*'];
		$data['where'] = ['id'=>$vendor_id];
		return $this->selectRecords($data);
	}

	public function searchVendor($vendorName){
		// print_r($vendorName);exit;
		if($vendorName['vendor_name'] != ''){
			$data['like'] = ['name',$vendorName['vendor_name'],true];
		}
		if($vendorName['page'] == 'vendor'){
			$data['limit'] = '6';
		}
		$data['table'] = TABLE_VENDOR;
		$data['select'] = ['*']; 
		$data['where'] = ['status'=>'1','server_name'=>$_SERVER['SERVER_NAME']];
		return $this->selectRecords($data);
		// echo $this->db->last_query();
	}
	

}



?>