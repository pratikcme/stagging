<?php 

class Home_model extends My_model{
	

	public function selectCategory(){
		$branch_id = $this->session->userdata('branch_id');
	    $data['select'] = ['c.*'];
		$data['table'] = TABLE_CATEGORY. ' as c';
	    $data['join'] = [
	    	TABLE_PRODUCT.' as p' =>['p.category_id = c.id','INNER'],
	    	TABLE_PRODUCT_WEIGHT.' as pw' =>['pw.product_id = p.id','INNER']
	];
		$data['where'] = [
							'c.status !=' => '9',
							'c.branch_id'=>$branch_id,
							'p.status' =>'1',
							'pw.status'=>'1', 
						];
		$data['groupBy'] = 'c.id';
		// $data['limit'] = '12'; 
	    return $this->selectFromJoin($data);
	    // echo $this->db->last_query();die;
	}	
 function getWebBannerImage(){
 
		$branch_id = $this->session->userdata('branch_id');
        // $data['table'] = 'web_banners';
        $data['table'] = 'banners';
        $data['select'] = ['*'];
        $data['where'] = ['branch_id'=>$branch_id];
        return $this->selectRecords($data);
        
    }
	public function selectNewArrivel(){
		$branch_id = $this->session->userdata('branch_id');
			$data['table'] = TABLE_PRODUCT . " as p";
			$data['select'] = ['p.*','pw.price','pw.id as pw_id' ,'pw.quantity','pw.discount_per','pw.discount_price','pi.image','pw.weight_id','pw.without_gst_price'];
			$data['join'] = [
				TABLE_PRODUCT_WEIGHT .' as pw'=>['p.id = pw.product_id','LEFT'],
				TABLE_PRODUCT_IMAGE .' as pi'=>['pw.id = pi.product_variant_id','LEFT']
			];
			$data['where'] = [ 
							   'p.status !='=>'9',
							   'pw.status!='=>'9',
							   'p.branch_id'=> $branch_id, 
							   // 'pw.quantity !=' => '' 
							 ];
			$data['order'] = 'id DESC, quantity DESC';
			$data['groupBy'] = 'p.id';
			$data['limit'] = 50;

			$return = $this->selectFromJoin($data);
			// echo $this->db->last_query();die;
			return $return;
	}

	public function selectStarRatting($id){
		$num_rows = $this->db->query("SELECT * FROM  user_product_review  WHERE product_id='$id' ");
		$num = $num_rows->num_rows();
			$result = $this->db->query("SELECT SUM(ratting) as total_rate FROM  user_product_review  WHERE product_id='$id'");
			$res = $result->result();
		
		if($res > 0 && $num !=0){
		 $average =  $res[0]->total_rate/$num;	
		}else{
		 $average = '0';
 		}	
		 return ['no_of_user'=>$num,'rating'=>$average]; 
	}

	// public function selectbanner(){
	// 	$branch_id = $this->session->userdata('branch_id');
	// 		$data['table'] = TABLE_BANNER_PROMOTION;
	// 		$data['select'] = ['*'];
	// 		// $data['where'] = [ 'status'=>'1','vendor_id'=> $branch_id ];
	// 		$data['where'] = [ 'status'=>'1','vendor_id'=>$branch_id];
	// 		$data['order'] = 'id DESC';
	// 		$data['limit'] = 4;
	// 		return  $this->selectRecords($data);
	// }

	public function selectTopSelling($product_ids=[]){
		$branch_id = $this->session->userdata('branch_id');
		$product_ids = implode('","',$product_ids);
				$result_count1 = $this->db->query('SELECT  product_id, SUM(quantity) AS TotalQuantity
								FROM order_details WHERE branch_id ="'.$branch_id.'" AND product_id NOT IN ("'.$product_ids.'")
								GROUP BY product_id 
								ORDER BY TotalQuantity DESC ');		
			
			return  $result_count1->result();
	}

	 public function top_selling_product($id){
			$branch_id = $this->session->userdata('branch_id');
			$data['table'] = TABLE_PRODUCT . " as p";
			$data['select'] = ['p.*','pw.price','pw.id as pw_id' ,'pw.quantity','pw.discount_per','pw.discount_price','pi.image','pw.weight_id','without_gst_price'];
			$data['join'] = [
					TABLE_PRODUCT_WEIGHT .' as pw'=>['p.id = pw.product_id','LEFT'],
					TABLE_PRODUCT_IMAGE .' as pi'=>['pw.id = pi.product_variant_id','LEFT']
				];
			$data['where'] = [
							'p.status !='=>'9',
							'pw.status!='=>'9',
							// 'pi.status!='=>'9',
							'p.id'=>$id,
							'p.branch_id'=>$branch_id
						];		

			$data['groupBy'] =['p.id'];
			$data['order'] = 'pw.quantity DESC';
			return  $this->selectFromJoin($data);
			echo $this->db->last_query();die;
			// print_r($re);
			// exit;
	}

	public function most_popullar(){
		$branch_id = $this->session->userdata('branch_id');
		$result = $this->db->query('SELECT product_id, SUM(quantity) As MostSold FROM order_details WHERE branch_id = "'.$branch_id.'" Group By product_id ORDER BY MostSold DESC');

		return $return = $result->result();
	}

	public function selectTopTrending(){
			  $lastmonth =  date("Y-m-d H:i:s",strtotime("-1 month"));
			  $last= strtotime($lastmonth); 
			$branch_id = $this->session->userdata('branch_id');
			$result_count1 = $this->db->query('SELECT  product_id , product_weight_id, sum(quantity) as tot_quantity from order_details 
												WHERE vendor_id ="'.$branch_id.'" AND dt_added >="'.$last.'"   
												GROUP BY product_id  ORDER BY tot_quantity DESC' );		
			
			return $return = $result_count1->result();
	}	

	public function selectRandonProduct(){

		$branch_id = $this->session->userdata('branch_id');
			$data['table'] = TABLE_PRODUCT . " as p";
			$data['select'] = ['p.*','pw.price','pw.id as pw_id' ,'pw.quantity','pw.discount_per','pw.discount_price','pi.image'];
			$data['join'] = [
					TABLE_PRODUCT_WEIGHT .' as pw'=>['p.id = pw.product_id','LEFT'],
					TABLE_PRODUCT_IMAGE .' as pi'=>['pw.id = pi.product_variant_id','LEFT']
				];
			$data['where'] = [
							'p.status !='=>'9',
							'pw.status!='=>'9',
							'pi.status!='=>'9',
							'p.branch_id'=>$branch_id
						];		
			$data['groupBy'] =['p.id'];
			// $data['order'] = 'RAND()';
			$data['limit'] = '50';
 			return  $this->selectFromJoin($data);
			// print_r($re);
			// exit;
 	}	
	
	 public function defualtCurrency(){
	 	$branch_id = $this->session->userdata('branch_id');
 		$data['table'] = 'set_default';
 		$data['select'] = ['*'];
 		$data['where'] = ['request_id'=>'3','vendor_id'=>$this->session->userdata('vendor_id')];
 		return $this->selectRecords($data);
 	}

 	public function checkVarientQuantity($product_id){
		$branch_id = $this->session->userdata('branch_id');
		$data['table'] = TABLE_PRODUCT_WEIGHT;
		$data['select'] = ['quantity'];
		$data['where'] = ['status!='=>'9','product_id'=>$product_id,'branch_id'=>$branch_id,'quantity >='=> '1'];
		$res = $this->selectRecords($data);
		if(empty($res)){
			$res = '0';
		}
		return $res ;
	}

	public function countSubcategory(){
		$branch_id = $this->session->userdata('branch_id');
		$data['table'] = TABLE_SUBCATEGORY;
		$data['select'] = ['*'];
		$data['where'] = ['status !='=>'9','branch_id'=>$branch_id];
		return $this->selectRecords($data);

	}

	 function subcategory_list() {
	 	// error_reporting(E_ALL);
	 	// ini_set("display_errors", '1');

        $branch_id = $this->session->userdata('branch_id');

        if(!isset($postdata['category_id'])){
            $data['table'] = 'category';
            $data['select'] = ['id'];
            $data['where'] = ['status!='=>'9','branch_id'=>$branch_id];
            $category_id = $this->selectRecords($data);
            $postdata['category_id'] = $category_id[0]->id;
            
        }
        // print_r($postdata['category_id']);die;
        if (isset($postdata['category_id']) && $postdata['category_id'] != '') {
            $category_id = $postdata['category_id'];
            $data['select'] = ['s.*','p.id as product_id'];
            $data['where'] = [
            	's.category_id' => $category_id, 's.branch_id' => $branch_id, 's.status !=' => '9','p.status !=' => '9'];
            $data['join'] = [TABLE_PRODUCT.' as p'=>['p.subcategory_id=s.id','INNER']];
            $data['table'] = 'subcategory as s';
            $result = $this->selectFromJoin($data);
            // echo "<pre>";
            // print_r($result);die;
            $subcategory_data = [];
            foreach ($result as $key => $value) {
                unset($data);
                $data['table'] = 'product as p';
                $data['join'] = [
                    'product_weight as pw' => ['p.id=pw.product_id', 'LEFT'],
                    'product_image as pi' => ['pi.product_variant_id = pw.id', 'LEFT']
                ];
                $data['select'] = ['p.subcategory_id' ,'pi.image as product_varient_image'];
                $data['where'] = ['pw.branch_id' => $branch_id, 'pw.status !=' => '9', 'p.subcategory_id' => $value->id,'p.id'=>$value->product_id];
                 $data['groupBy'] = 'pi.product_variant_id';
                // $total_product = $this->checkProductcount($data);
                $r = $this->selectFromJoin($data);
                // print_r($r);die;
                // if($key == '9'){
                // echo $this->db->last_query();die;

                // }
                if(!empty($r)){
	                $result[$key]->image = $r[0]->product_varient_image;
	                $result[$key]->subcategory_id = $value->id; 
                	$subcategory_data[] = $value;
                }else{
                	$result[$key]->image = "";
	                $result[$key]->subcategory_id = "";
                }
                // $result[$key]->total_product = (string)$total_product;
            }
        }
                // print_r($subcategory_data);die;
        return $subcategory_data;
    }

 	//Developer : Shahid Abdul Rahman  
 	
      public function get_offer($branch_id =''){
        $today = date('Y-m-d');
        $time = date('H:i:00');


        $data['table'] = TABLE_OFFER .' as o';
        $data['join'] = [TABLE_OFFER_DETAIL . ' as od'=>['o.id=od.offer_id','LEFT']];
        $data['select'] = ['o.id','o.branch_id','o.offer_title','o.offer_percent','od.product_varient_id','o.image','start_date','end_date','start_time','end_time'];
        $data['where'] = ['o.branch_id'=>$branch_id,'start_date <='=>$today,'end_date >='=>$today];
        $data['having'] = ['start_time <= '=>$time];
        $data['groupBy'] = 'o.id';
        $result = $this->selectFromJoin($data);
        unset($data);
        foreach ($result as $k => $v) {
            if($v->end_date == $today && $v->end_time <= $time){
                unset($result[$k]);
                continue;
            }
            
            $v->image = base_url() . 'public/images/'.$this->folder.'offer_image/' . $v->image;
            $data['select'] = ['c.name as category_name','p.category_id','pw.product_id'];
            $data['table'] = TABLE_PRODUCT_WEIGHT . ' as pw';
            $data['join'] = [
                TABLE_PRODUCT .' as p'=>['p.id=pw.product_id','LEFT'],
                TABLE_CATEGORY . ' as c'=>['c.id = p.category_id','LEFT']
            ];
            $data['where'] = ['pw.id'=>$v->product_varient_id,'pw.status !='=> '9'];
            $res = $this->selectFromJoin($data);
            $v->category_id = $res[0]->category_id;
            $v->category_name = $res[0]->category_name;
            $v->product_id = $res[0]->product_id;
        }
        // dd($result);
        return $result;

    }

    public function get_offer_varient_listing($postData){
        $data['table'] = TABLE_OFFER_DETAIL .' as od';
        $data['join'] = [
            TABLE_PRODUCT_WEIGHT.' as pw'=>['pw.id=od.product_varient_id','LEFT'],
            TABLE_PRODUCT.' as p'=>['p.id=pw.product_id','LEFT'],
            TABLE_WEIGHT.' as w'=>['w.id = pw.weight_id','LEFT'],
            'package as pkg'=>['pkg.id = pw.package','LEFT'],
        ];
        $data['select'] = ['od.*','pw.id as product_varient_id','pw.price','pw.price','pw.discount_price','pw.weight_no','w.name as weight_name','pw.discount_per','pkg.package as package_name','pw.max_order_qty','p.name','pw.product_id','p.branch_id','pw.quantity as available_quantity','pw.price as actual_price','w.id as weight_id'];
        $data['where'] = ['od.offer_id'=>$postData['offer_id']];
        $return =  $this->selectFromJoin($data);
        unset($data);
        $branch_id = $return[0]->branch_id;
        foreach ($return as $k => $v) {
            $product_variant_id = $v->product_varient_id;
            $data['select'] = ['quantity'];
            $data['where']['product_weight_id'] = $product_variant_id;
            $data['where']['status !='] = 9;
            $data['where']['branch_id'] = $branch_id;
            if (isset($postData['user_id']) && $postData['user_id'] != '') {
                $data['where']['user_id'] = $postData['user_id'];
            } else {
                if (isset($postData['device_id'])) {
                    $data['where']['device_id'] = $postData['device_id'];
                    $data['where']['user_id'] = 0;
                }
            }
            $data['table'] = 'my_cart';
            $result_cart = $this->selectRecords($data);
            if (count($result_cart) > 0) {
                $my_cart_quantity = $result_cart[0]->quantity;
            } else {
                $my_cart_quantity = '0';
            }

            $v->my_cart_quantity = $my_cart_quantity;
            $image = $this->getVarient_image($v->product_varient_id);
            $v->image = base_url() . 'public/images/'.$this->folder.'product_image/'.$image[0]->image;
            $v->image = str_replace(' ', '%20', $v->image);
        }
        $response["success"] = 1;
        $response["message"] = "offer details data";  
        $response["data"] = $return;  
        return $return;

    }

    public function getVarient_image($varient_id){
        $data['table'] = TABLE_PRODUCT_IMAGE;
        $data['where'] = ['product_variant_id'=>$varient_id];
        $data['select'] = ['*'];
        return $this->selectRecords($data);

     }



}



?>