<?php 

class Report_model extends My_model
{
	public function inventory_reports(){
		$vendor_id = $this->session->userdata('id');
		$data['table'] = 'product AS p';
		$data['select'] = ['p.*','pw.*','w.name as weight'];
		$data['join'] = [
			'product_weight AS pw'=>['pw.product_id = p.id','LEFT'],
			'weight as w' => ['pw.weight_id = w.id','LEFT']
		];
		$data['where'] = ['p.vendor_id'=>$vendor_id,'p.status !='=>'9'];
		$data['order'] = 'p.id DESC';
		return $this->selectFromJoin($data);
	}

	public function registerClosures(){
		$vendor_id = $this->session->userdata('id');
		$data['table'] = 'register';
		$data['select'] = ['*'];
		$data['where'] = ['vendor_id' =>$vendor_id];
		$data['order'] = 'id DESC';
		return $this->selectRecords($data);
		// $query = $this->db->query("SELECT * FROM register WHERE vendor_id = '$vendor_id' ORDER BY id DESC");
		// $result = $query->result(); 
	}

	public function selectYearProduct($month,$payment_type,$select_year_product,$type){
		if($type != ''){
			$data['where']['order_from'] = $type;
		}
		$vendor_id = $this->session->userdata('id');
		$data['table'] = 'order';
		$data['select'] = ['COUNT(*) as total_monthwise','payable_amount'];
		$data['where']['MONTH(FROM_UNIXTIME(dt_added))'] = $month;
		$data['where']['vendor_id'] = $vendor_id;
		$data['where']['status !='] = '9';
		$data['where']['payment_type'] = $payment_type;
		$data['where']['YEAR(FROM_UNIXTIME(dt_added))'] = $select_year_product;
		return $this->selectRecords($data);
			// echo $this->db->last_query();die;
		 // $first_month = $this->db->query("select COUNT(*) as total_monthwise, payable_amount from `order` where MONTH(FROM_UNIXTIME(dt_added)) = '1' and vendor_id='$vendor_id'  and status != '9' and $where and payment_type = '0' and YEAR(FROM_UNIXTIME(dt_added)) = '$select_year_product'");
   // 		 $row_first_month = $first_month->result();
	}

	public function selectMonthDateOrder($month,$payment_type,$from_date,$end_date,$type){

		if($type != ''){
			$data['where']['order_from'] = $type;
		}
		$vendor_id = $this->session->userdata('id');
		$data['table'] = 'order';
		$data['select'] = ['COUNT(*) as total_monthwise','payable_amount'];
		$data['where']['MONTH(FROM_UNIXTIME(dt_added))'] = $month;
		$data['where']['vendor_id'] = $vendor_id;
		$data['where']['status !='] = '9';
		$data['where']['payment_type'] = $payment_type;
		$data['where']['dt_added >='] = $from_date;
		$data['where']['dt_added <='] = $end_date;
		return $this->selectRecords($data);
		// echo $this->db->last_query();die;
	}

	public function selectOrderStatistics($month,$payment_type){

		$vendor_id = $this->session->userdata('id');
		$data['table'] = 'order';
		$data['select'] = ['COUNT(*) as total_monthwise','payable_amount'];
		$data['where']['MONTH(FROM_UNIXTIME(dt_added))'] = $month;
		$data['where']['vendor_id'] = $vendor_id;
		$data['where']['status !='] = '9';
		$data['where']['payment_type'] = $payment_type;
		return $this->selectRecords($data);
	}

	public function totalCod(){
		$vendor_id = $this->session->userdata('id');
		$data['table'] =  'order';
		$data['select'] = ['SUM(payable_amount) as total'];
		$data['where'] = [
						'vendor_id'=>$vendor_id,
						'status !=' =>'9',
						'payment_type' => '0'
					];
		return $this->selectRecords($data);
	}

	public function total_online(){
		$vendor_id = $this->session->userdata('id');
		$data['table'] =  'order';
		$data['select'] = ['SUM(payable_amount) as total'];
		$data['where'] = [
						'vendor_id'=>$vendor_id,
						'status !=' =>'9',
						'payment_type' => '1'
					];
		return $this->selectRecords($data);
	}

	public function res_yearwise($select_year_product,$type){
	$vendor_id = $this->session->userdata('vendor_id');
		if($type != ''){
			$data['where']['o.order_from'] = $type;
		}

		$data['table'] = 'product_weight as p';
		$data['select'] = [	
			'p.weight_no','w.name as variant',
			'pro.name','p.*','od.*',
			'sum(od.calculation_price) as product_price'
			];
		$data['join'] = [
			'weight as w'=>['w.id = p.product_id','INNER'],
			'product as pro' =>['pro.id = p.product_id','INNER'],
			'order_details as od'=>['od.product_weight_id = p.id','INNER'],
			'order as o'=> ['o.id=od.order_id','INNER']
			];

		$data['where']['YEAR(FROM_UNIXTIME(od.dt_added))'] = $select_year_product;
		$data['where']['p.vendor_id'] = $vendor_id;
		$data['groupBy'] = 'p.id';
		return $this->selectFromJoin($data);
	}

	public function res_remaining_quantity($select_year_product){

		$vendor_id = $this->session->userdata('vendor_id');

		$data['table'] = 'product_weight as p';
		$data['select'] = [	
			'p.weight_no','w.name as variant',
			'pro.name','p.*','od.*',
			'sum(od.calculation_price) as product_price'
			];
		$data['join'] = [
			'weight as w'=>['w.id = p.product_id','INNER'],
			'product as pro' =>['pro.id = p.product_id','INNER'],
			'order_details as od'=>['od.product_weight_id = p.id','INNER']
			];

		$data['where']['YEAR(FROM_UNIXTIME(od.dt_added))'] = $select_year_product;
		$data['where']['p.vendor_id'] = $vendor_id;
		$data['groupBy'] = 'p.id';
		return $this->selectFromJoin($data);
	}

	public function Else_res_yearwise($year){
	
		$vendor_id = $this->session->userdata('vendor_id');
		$data['table'] = 'product_weight as p';
		$data['select'] = [	
			'pro.name','p.*','od.*',
			'sum(od.calculation_price) as product_price'
			];
		$data['join'] = [
			'product as pro' =>['pro.id = p.product_id','INNER'],
			'order_details as od'=>['od.product_weight_id = p.id','INNER']
			];

		$data['where']['YEAR(FROM_UNIXTIME(od.dt_added))'] = $year;
		$data['where']['p.vendor_id'] = $vendor_id;
		$data['groupBy'] = 'p.id';
		return $this->selectFromJoin($data);
	}

	public function Else_res_remaining_quantity($year){
		
		$vendor_id = $this->session->userdata('vendor_id');
		$data['table'] = 'product_weight as p';
		$data['select'] = [	
			'pro.name','p.*','od.*',
			'sum(od.calculation_price) as product_price'
			];
		$data['join'] = [
			'product as pro' =>['pro.id = p.product_id','INNER'],
			'order_details as od'=>['od.product_weight_id = p.id','INNER']
			];

		$data['where']['YEAR(FROM_UNIXTIME(od.dt_added))'] = $year;
		$data['where']['p.vendor_id'] = $vendor_id;
		$data['groupBy'] = 'p.id';
		return $this->selectFromJoin($data);

	}


public  $order_column_Inventory_report = array("p.name","pw.quantity","pw.discount_price",'pw.discount_price','p.weight_no'); 
    function make_query_Inventory_report($postData){
     $vendor_id = $this->session->userdata('id');
        $where = [
            'p.vendor_id'=>$vendor_id,
            'p.status !='=>'9',  
        ];
        $this->db->select('p.*,pw.*,w.name as weight');  
        $this->db->from('product AS p');
        $this->db->join('product_weight as pw','pw.product_id = p.id','left');
        $this->db->join('weight as w','pw.weight_id = w.id','left');
        $this->db->where($where);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
        $this->db->group_start();
            $this->db->like("p.name", $postData["search"]["value"]);
            $this->db->or_like("pw.weight_no", $postData["search"]["value"]); 
            $this->db->or_like("pw.discount_price", $postData["search"]["value"]); 
            $this->db->or_like("w.name", $postData["search"]["value"]); 
        $this->db->group_end(); 
        }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_Inventory_report[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('p.id', 'DESC');  
           } 
    }


    function make_datatables_Inventory_report($postData){ 
        $this->make_query_Inventory_report($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            // echo $this->db->last_query();
        }

    function get_filtered_data_Inventory_report($postData = false){  
        $this->make_query_Inventory_report($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }       
    
    function get_all_data_Inventory_report(){
        $vendor_id = $this->session->userdata('id');
       $where = [
            'p.vendor_id'=>$vendor_id,
            'p.status !='=>'9',  
        ];
       $this->db->select('*');  
       $this->db->from('product AS p');
       $this->db->join('product_weight as pw','pw.product_id = p.id','LEFT');
       $this->db->join('weight as w','pw.weight_id = w.id','LEFT');
		$this->db->where($where);
        return $this->db->count_all_results();   
    }

}
?>