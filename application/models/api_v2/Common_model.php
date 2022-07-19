<?php

Class Common_model extends My_model{

	public function setVendor(){
		$data['table'] = 'vendor';
		$data['select'] = ['id'];
		$data['where'] = ['server_name'=>$_SERVER['SERVER_NAME']];
		$return =  $this->selectRecords($data);
		$a  = array('vendor_id' => $return[0]->id);
		$this->session->set_userdata($a);
		return true;
	}

	public function getNotificationKey(){
		// $re = $this->getExistingBranchId();
		if(isset($_SESSION['vendor_id'])){
			$vendor_id = $_SESSION['vendor_id'];
		}elseif(isset($_SESSION['vendor_admin_id'])){
			$vendor_id = $_SESSION['vendor_admin_id'];
		}else{
			$vendor_id = 0;
		}
		
		$data['table'] = 'firebase';
		$data['select'] = ['*'];
		$data['where'] = ['vendor_id'=>$vendor_id]; 
		return $this->selectRecords($data);
	}

	public function getLogo(){
			// error_reporting(E_ALL);
			// ini_set('display_errors', 1);
		//i f($this->session->userdata('logo') != '' && $this->session->userdata('webTitle') != ''){
		// 	$return = ['logo'=>$this->session->userdata('logo'),'webTitle'=>$this->session->userdata('webTitle')];
		// 	return $return;
 	// 	}	
		// echo '<pre>';
		// print_r($_SERVER);
		// die;	
		$vendor_id = 0;
		if(isset($_SESSION['branch_id'])){
			$data['select'] = ['*'];
			$data['table'] = 'branch';
			$data['select'] = ['*'];
			$data['where'] = ['id'=>$_SESSION['branch_id']];
			$get = $this->selectRecords($data);
			$vendor_id = $get[0]->vendor_id;
			unset($data);
		}else
		if(isset($_POST['branch_id'])){
			$data['select'] = ['*'];
			$data['table'] = 'branch';
			$data['select'] = ['*'];
			$data['where'] = ['id'=>$_POST['branch_id']];
			$get = $this->selectRecords($data);
			$vendor_id = $get[0]->vendor_id;
			unset($data);
		}elseif(isset($_SESSION['vendor_admin_id'])){
			// echo '1';die;
			$vendor_id = $this->session->userdata('vendor_admin_id');
		}else{

				if (strpos($_SERVER['SERVER_NAME'], 'www') !== false){ 
	   				 $str = explode('.', $_SERVER['SERVER_NAME']); 
	   				 $_SERVER['SERVER_NAME'] =  $str[1].'.'.$str[2];
				}
			$data['where_or'] = ['server_name'=>$_SERVER['SERVER_NAME']];
		}

		$data['select'] = ['webLogo','webTitle','img_folder','favicon_image','id'];
		$data['table'] = 'vendor';
		$data['select'] = ['*'];
		$data['where'] = ['id'=>$vendor_id];
		$get = $this->selectRecords($data);
		// echo $this->db->last_query();
		if(!empty($get)){
			$return = [
				'logo'=>base_url().'public/client_logo/'.$get[0]->webLogo,
				'webTitle'=>$get[0]->webTitle,
				'folder'=>($get[0]->img_folder != '') ? $get[0]->img_folder.'/'  : "",
				'favicon_image'=>base_url().'public/client_logo/'.$get[0]->favicon_image,
				'id'=> $get[0]->id
			];
			$this->session->set_userdata($return);
			return $return;

		}else{
			$return = [
				'logo'=>base_url().'public/client_logo/commonlogo.png',
				'webTitle'=>"launchestore",
				'folder'=> '/',
				'favicon_image'=>'',
			];
			$this->session->set_userdata($return);
			return $return;
			return base_url().'public/client_logo/commonlogo.png';
		}
	}

	public function getDefaultCurrency($branch_id = ''){
		// $re = $this->getExistingBranchId();
		if(isset($_SESSION['vendor_id'])){
			$vendor_id = $_SESSION['vendor_id'];
		$data['where']['vendor_id'] = $vendor_id;

		}elseif(isset($_SESSION['vendor_admin_id'])){
			$vendor_id = $_SESSION['vendor_admin_id'];
		$data['where']['vendor_id'] = $vendor_id;
			
		}elseif(isset($_POST['branch_id'])){
			$branch_id = $_POST['branch_id'];
			$dt['table'] = 'branch';
			$dt['select'] = ['*'];
			$dt['where']['id'] = $branch_id;
			$get = $this->selectRecords($dt);
			$data['where']['vendor_id'] = $get[0]->vendor_id;
		}elseif(isset($_POST['vendor_id'])){
			$vendor_id = $_POST['vendor_id'];
			$data['where']['vendor_id'] = $vendor_id;
		}else{
			
		}
		// if($vendor_id != 0){
		// 	$data['where']['vendor_id'] = $vendor_id;
		// }
		
		// print_r($_SESSION);die;
		$data['table'] = 'set_default';
		$data['select'] = ['*'];
		$data['where']['request_id'] = '3';

		
		$return =  $this->selectRecords($data);
		// echo $this->db->last_query();die;
		if(!empty($return)){
			return $return[0]->value;
		}else{
			return 0;
		}
	}

	// this function used in user view
	public function getCommonKeysAndLink(){ 

		if(isset($_SESSION['vendor_id'])){
			$vendor_id = $_SESSION['vendor_id'];
		}elseif(isset($_SESSION['vendor_admin_id'])){
			$vendor_id = $_SESSION['vendor_admin_id'];
		}else{
			$vendor_id = 0;
		}

		$data['table'] = 'firebase';
		$data['select'] = ['*'];
		$data['where'] = ['vendor_id'=>$vendor_id];
		$return =  $this->selectRecords($data);
		return $return;
	}

	public function CountCategory(){
		$data['table'] = TABLE_CATEGORY;
		$data['select'] = ['count(*) as categoryCount'];
		$data['where'] = ['branch_id'=>$this->session->userdata('branch_id'),'status!='=>'9'];
		$CountCategory =$this->selectRecords($data);
		return $CountCategory[0]->categoryCount;
	}

	public function CountSubCategory(){
		$data['table'] = TABLE_SUBCATEGORY;
		$data['select'] = ['count(*) as subcategoryCount'];
		$data['where'] = ['branch_id'=>$this->session->userdata('vendor_id'),'status!='=>'9'];
		$subcategoryCount = $this->selectRecords($data);	
		return $subcategoryCount;
	}

	public function getExistingVendorId(){
		$data['table'] = 'branch';
		$data['select'] = ['*'];
		$data['where'] = ['domain_name'=>base_url(),'status!='=>'9'];
		return $this->selectRecords($data);
		 
	}

	public function getVendorIdFromBranch(){
		$data['table'] = 'branch';
		$data['select'] = ['*'];
		$data['where'] = ['id'=>$_POST['branch_id']];
		return $this->selectRecords($data);
		 
	}

	/* Used In vendor admin */
	public function getExistingBranchId(){
		// print_r($_SESSION);die;
		if(isset($_SESSION['vendor_admin'])){
			$vendor_admin = $this->session->userdata('vendor_admin_id');
			$data['table'] = 'vendor as a'; // vendor
			$data['select'] = ['b.id'];
			$data['join'] = ['branch as b'=>['a.id=b.vendor_id','LEFT']];
			$data['where'] = ['a.id'=>$vendor_admin,'b.status!='=>'9'];
			return $this->selectFromJoin($data);
			echo $this->db->last_query();die;
		}
		return [];
		 // echo $this->db->last_query();die;
	}

	public function default_product_image(){
		// die;
		$branch_id = $this->session->userdata('branch_id');
		$data['select'] = ['product_default_image'];
		$data['table'] = 'branch '; // vendor
		$data['where'] = ['id'=>$branch_id,'status!='=>'9'];
		$return =  $this->selectRecords($data);
		if($return[0]->product_default_image != ''){
			$image =  $return[0]->product_default_image;
		}else{
			$image =  'defualt.png';
		}
		return $image; 
	}

	


}



 ?>
