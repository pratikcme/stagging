<?php
class Dashboard_model extends My_model{ 
	
	public function __construct(){
		
		$this->branch_id = $this->session->userdata['id'];
	}

	public function total_order_today(){
		$userid = $this->session->userdata('id');
		$vendor_id = $this->session->userdata['id'];
		
 		$today = strtotime(date('Y-m-d 00:00:00')); 

		 if(isset($_SESSION['vendor_admin']) ){
	        $data['table'] = 'vendor as v';
	 		$data['select'] = ['COUNT(*) as total'];
	 		$data['join'] = [
	 			TABLE_BRANCH .' as b'=>[' v.id = b.vendor_id ','LEFT'],
	 			TABLE_ORDER .' as o'=>['b.id = o.branch_id','LEFT']
	 		];
            $data['where']['b.vendor_id'] = $this->session->userdata('vendor_admin_id');
	 		$data['where']['o.dt_added >='] = $today;
	 		$total_order =  $this->selectFromJoin($data,true);
	 		return $total_order[0];
        }else{
        	// echo '1';die;
	        $data['table'] = TABLE_ORDER . ' as o';
	 		$data['select'] = ['count(*) as total'];
	 		$data['where']['dt_added >='] = $today;
	 		$data['where']['branch_id'] = $this->branch_id;
	 		$total_order = $this->selectRecords($data,true);
	 		// echo $this->db->last_query(); exit;
			return $total_order[0];
        }


		

	}

	public function total_order_month(){
	
        $month = strtotime(date('Y-m-01 00:00:00'));

        if(isset($_SESSION['vendor_admin']) ){
	        $data['table'] = 'vendor as v';
	 		$data['select'] = ['COUNT(*) as total'];
	 		$data['join'] = [
	 			TABLE_BRANCH .' as b'=>[' v.id = b.vendor_id ','LEFT'],
	 			TABLE_ORDER .' as o'=>['b.id = o.branch_id','LEFT']
	 		];
            $data['where']['b.vendor_id'] = $this->session->userdata('vendor_admin_id');
	 		$data['where']['o.dt_added >='] = $month;
	 		$total_order_monthly =  $this->selectFromJoin($data,true);
	 		return $total_order_monthly[0];
        }else{
        	
	        $data['table'] = TABLE_ORDER . ' as o';
	 		$data['select'] = ['count(*) as total'];
	 		$data['where']['dt_added >='] = $month;
	 		$data['where']['branch_id'] = $this->branch_id;
	 		$total_order_monthly = $this->selectRecords($data,true);
	 	
			return $total_order_monthly[0];
        }

	}

	public function total_order(){
	

		if(isset($_SESSION['vendor_admin']) ){
	        $data['table'] = 'vendor as v';
	 		$data['select'] = ['COUNT(*) as total'];
	 		$data['join'] = [
	 			TABLE_BRANCH .' as b'=>[' v.id = b.vendor_id ','LEFT'],
	 			TABLE_ORDER .' as o'=>['b.id = o.branch_id','LEFT']
	 		];
            $data['where']['b.vendor_id'] = $this->session->userdata('vendor_admin_id');
	 		$data['where']['o.status !='] = '9';
	 		$return =  $this->selectFromJoin($data,true);
	 		return $return[0];
        }else{
        
	        $data['table'] = TABLE_ORDER . ' as o';
	 		$data['select'] = ['count(*) as total'];
	 		$data['where']['status !='] = '9';
	 		$data['where']['branch_id'] = $this->branch_id;
	 		$return = $this->selectRecords($data,true);
	 	
			return $return[0];
        }




	}

	public function total_product_query(){

		if($this->session->userdata('vendor_admin') == '1'){
            $data['where']['vendor_id'] = $this->vendor_id;
        }
		$data['table'] = 'product'; 
		$data['select'] = ['count(*) as total']; 
		$data['where']['status != '] = '9';
		$total_product_result = $this->selectRecords($data,true);
		return $total_product_result[0]; 
	}

	public function total_category_query(){
		
		$data['table'] = 'category';
		$data['select'] = ['count(*) as total'];
		$data['where'] = ['status !='=> '9','vendor_id' =>$this->vendor_id ];
		$total_category_result = $this->selectRecords($data,true);
		return $total_category_result[0];
	}	

	public function total_brand_query(){
		
		$data['table'] = 'brand';
		$data['select'] = ['count(*) as total'];
		$data['where'] = ['status !='=> '9','vendor_id' =>$this->vendor_id ];
		$total_brand_result = $this->selectRecords($data,true);
		return $total_brand_result[0];
	}

	public function total_registered_user_query(){
		
		if(isset($_SESSION['vendor_admin']) ){
			$data['table'] = TABLE_USER.' as u';
			$data['select'] = ['count(*) as total_registered_user'];
		    $data['where']['u.vendor_id'] = $this->session->userdata('vendor_admin_id');
			$data['where']['u.status !='] = '9';
			$total_registered_user =  $this->selectRecords($data,true);
			// dd($total_registered_user);
			return $total_registered_user[0];
        }else{
       
			$data['table'] = 'user';
			$data['select'] = ['count(*) as total_registered_user'];
			$data['where'] = ['status !='=> '9'];
		 	$data['where']['vendor_id'] = $this->session->userdata('branch_vendor_id');
			$total_registered_user = $this->selectRecords($data,true);
			
			return $total_registered_user[0];

        }


	}

	public function total_delivered_query(){

		if(isset($_SESSION['vendor_admin']) ){
			$data['table'] = 'vendor as v';
			$data['select'] = ['count(*) as total_delivered'];
			$data['join'] = [
				TABLE_BRANCH .' as b'=>[' v.id = b.vendor_id ','LEFT'],
				TABLE_ORDER .' as o'=>['b.id = o.branch_id','LEFT']
			];
			$data['where']['b.vendor_id'] = $this->session->userdata('vendor_admin_id');
			$data['where']['o.order_status '] = '8';
			$total_delivered =  $this->selectFromJoin($data,true);
			return $total_delivered[0];
		}else{
        	
			$data['table'] = 'order';
			$data['select'] = ['count(*) as total_delivered'];
			$data['where']['order_status'] = '8';
			$data['where']['branch_id'] = $this->branch_id;
			$total_delivered = $this->selectRecords($data,true);
			return $total_delivered[0];

		}

	

	}

	public function total_sales_query(){

		if(isset($_SESSION['vendor_admin']) ){
			$data['table'] = 'vendor as v';
			$data['select'] = ['SUM(total) as sales'];
			$data['join'] = [
				TABLE_BRANCH .' as b'=>[' v.id = b.vendor_id ','LEFT'],
				TABLE_ORDER .' as o'=>['b.id = o.branch_id','LEFT']
			];
			$data['where']['b.vendor_id'] = $this->session->userdata('vendor_admin_id');
			$data['where']['o.order_status !='] = '9';
			$total_sales =  $this->selectFromJoin($data,true);
			return $total_sales[0];
		}else{
        	
			$data['table'] = 'order';
			$data['select'] = ['SUM(total) as sales'];
			$data['where']['order_status !='] = '9';
			$data['where']['branch_id'] = $this->branch_id;
			$total_sales = $this->selectRecords($data,true);
			return $total_sales[0];

		}

	
	}

	public function total_pending_order_query(){
		
		if(isset($_SESSION['vendor_admin']) ){
			$data['table'] = 'vendor as v';
			$data['select'] = ['count(*) as total'];
			$data['join'] = [
				TABLE_BRANCH .' as b'=>[' v.id = b.vendor_id ','LEFT'],
				TABLE_ORDER .' as o'=>['b.id = o.branch_id','LEFT']
			];
			$data['where']['b.vendor_id'] = $this->session->userdata('vendor_admin_id');
			$data['where']['o.order_status'] = '2';
			$total_pending_order =  $this->selectFromJoin($data,true);
			return $total_pending_order[0];
		}else{
        	// echo '1';die;
			$data['table'] = 'order';
			$data['select'] = ['count(*) as total'];
			$data['where']['order_status'] = '2';
			$data['where']['branch_id'] = $this->branch_id;
			$total_pending_order = $this->selectRecords($data,true);
			return $total_pending_order[0];

		}
		
	}

	public function total_pending_payment_query(){


		if(isset($_SESSION['vendor_admin']) ){
			$data['table'] = 'vendor as v';
			$data['select'] = ['SUM(total) as pending_payment'];
			$data['join'] = [
				TABLE_BRANCH .' as b'=>[' v.id = b.vendor_id ','LEFT'],
				TABLE_ORDER .' as o'=>['b.id = o.branch_id','LEFT']
			];
			$data['where']['b.vendor_id'] = $this->session->userdata('vendor_admin_id');
			$data['where']['payment_type'] = '0';
			$data['where']['o.order_status != "8" AND o.order_status !='] ='9';
			$total_pending_order =  $this->selectFromJoin($data,true);
			return $total_pending_order[0];
		}else{
        	
			$data['table'] = 'order';
			$data['select'] = ['SUM(total) as pending_payment'];
			$data['where']['order_status != "8" AND order_status !='] ='9';
			$data['where']['branch_id'] = $this->branch_id;
			$data['where']['payment_type'] = '0';
			$total_pending_order = $this->selectRecords($data,true);
			return $total_pending_order[0];

		}

	}

	public function total_return_order_query(){

		if(isset($_SESSION['vendor_admin']) ){
			$data['table'] = 'vendor as v';
			$data['select'] = ['count(*) as total'];
			$data['join'] = [
				TABLE_BRANCH .' as b'=>[' v.id = b.vendor_id ','LEFT'],
				TABLE_ORDER .' as o'=>['b.id = o.branch_id','LEFT']
			];
			$data['where']['b.vendor_id'] = $this->session->userdata('vendor_admin_id');
			$data['where']['o.order_status'] ='9';
			$total_return_order =  $this->selectFromJoin($data,true);
			return $total_return_order[0];
		}else{
        	// echo '1';die;
			$data['table'] = 'order';
			$data['select'] = ['count(*) as total'];
			$data['where']['order_status'] ='9';
			$data['where']['branch_id'] = $this->branch_id;
			$total_return_order = $this->selectRecords($data,true);
			return $total_return_order[0];

		}

	}

	public function total_return_payment_query(){
		

		if(isset($_SESSION['vendor_admin']) ){
			$data['table'] = 'vendor as v';
			$data['select'] = ['SUM(total) as return_payment'];
			$data['join'] = [
				TABLE_BRANCH .' as b'=>[' v.id = b.vendor_id ','LEFT'],
				TABLE_ORDER .' as o'=>['b.id = o.branch_id','LEFT']
			];
			$data['where']['b.vendor_id'] = $this->session->userdata('vendor_admin_id');
			$data['where']['o.order_status'] ='9';
			$daily_order_Status =  $this->selectFromJoin($data,true);
			return $daily_order_Status[0];
		}else{
        
			$data['table'] = 'order';
			$data['select'] = ['SUM(total) as return_payment'];
			$data['where']['order_status'] ='9';
			$data['where']['branch_id'] = $this->branch_id;
			$daily_order_Status = $this->selectRecords($data,true);

			return $daily_order_Status[0];

		}

	}

	public function daily_order_Status_query(){
        $today = strtotime(date('Y-m-d 00:00:00')); 
		
		if(isset($_SESSION['vendor_admin']) ){
			$data['table'] = 'vendor as v';
			$data['select'] = ['o.*'];
			$data['join'] = [
				TABLE_BRANCH .' as b'=>[' v.id = b.vendor_id ','LEFT'],
				TABLE_ORDER .' as o'=>['b.id = o.branch_id','LEFT']
			];
			$data['where']['b.vendor_id'] = $this->session->userdata('vendor_admin_id');
			$data['where']['o.dt_added >='] = $today;
			$data['where']['o.order_status!='] ='9';
			$data['groupBy'] = 'o.id';
			$daily_order_Status =  $this->selectFromJoin($data);
			return $daily_order_Status;
		}else{
        	// echo '1';die;
			$data['table'] = 'order';
			$data['select'] = ['*'];	
			$data['where']['dt_added >='] = $today;
			$data['where']['order_status!='] ='9';
			$data['where']['branch_id'] = $this->branch_id;
			$daily_order_Status = $this->selectRecords($data);
			return $daily_order_Status;

		}


	}
	
	public function daily_order_Status_user_name_query(){
		$data['table'] = 'order';
		$data['select'] = ['*'];
		$data['where'] = ['branch_id' =>$this->branch_id ];
		$daily_order_Status = $this->selectRecords($data);
		return $daily_order_Status;
	}




}
?>