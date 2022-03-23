<?php
class Posapi_model extends My_model{ 
	//vendor_login
	function login($postdata){
		$data['select'] = ['id','name','owner_name','email','phone_no','location','status'];
		$data['where'] =[
						'email'=>$postdata['email'],
						'password'=>md5($postdata['password']),
						'status !=' => '9'
					];
		$data['table'] ='vendor';
		$result = $this->selectRecords($data);
		unset($data);
		$data['select'] = ['value'];
		$data['where'] =[
						'request_id'=>'3',
						];
		$data['table'] ='set_default';
		$currency = $this->selectRecords($data);
		$currency = $currency[0]->value;

		if(count($result)>0){
			$result[0]->org_no = $result[0]->name."00000".$result[0]->id;
			$result[0]->currency = $currency;
			if($result[0]->status=='0'){
				$response = array(
					'success'=>'0',
					'message'=>'User is in-acive, Please contact admin!',					
					);	
			}else{
				$response = array(
					'success'=>'1',
					'message'=>'Login successfull',
					'data'=>$result[0],
					);	
			}
			
		}else{
			$response = array(
					'success'=>'0',
					'message'=>'Invalid email or password',					
					);
		}
		return $response;
	}
	//get all category
	function category_list($postdata){
		date_default_timezone_set('Asia/Kolkata');
		$cuurent_sync = strtotime(date('Y-m-d H:i:s'));
		$vendor_id = $postdata['vendor_id'];
		$data['select'] = ['id','name','status']; 
		$data['where']['vendor_id'] =$vendor_id;
		if(isset($postdata['syncdate']) && $postdata['syncdate'] !=''){
			$data['where']['dt_added >'] = $postdata['syncdate'];
			$data['where_or']['dt_updated >'] = $postdata['syncdate'];
		}
		$data['table'] = 'category';
		$result = $this->selectRecords($data);
        // echo $this->db->last_query();exit;
		if (count($result)>0) {
			foreach ($result as $key => $value) {
				$check = $this->check_variant_from_category($value->id);
				if(count($check)==0){
					unset($result[$key]);
				}
			}
			foreach ($result as $key => $value) {
					$senddata = array('id' => $value->id,
        							'name' => $value->name,
        							'status' => $value->status,
            					);
					$get[] = $senddata;
			}
			// print_r($get);exit;
            $response['success'] = '1';
            $response['message'] = 'category Data';
            $response['sync_date'] =$cuurent_sync;
            $response["data"] = $get;
        
        } else {
            $response['success'] = '0';
            $response['message'] = "No Category found";
        }
		return $response;
	}
	//get all subcategory
	function subcategory_list($postdata){
		$vendor_id = $postdata['vendor_id'];
		$data['select'] = ['id','category_id','name','status']; 
		$data['where']['vendor_id'] = $vendor_id;
		if(isset($postdata['syncdate']) && $postdata['syncdate'] !=''){
			$data['where']['dt_added >'] = $postdata['syncdate'];
			$data['where_or']['dt_updated >'] = $postdata['syncdate'];
		}
		$data['table'] = 'subcategory';
		$result = $this->selectRecords($data);
        
		if (count($result)>0) {
			$cuurent_sync = strtotime(date('Y-m-d H:i:s'));
			
            $response['success'] = '1';
            $response['message'] = 'Sub category Data';
            $response['sync_date'] =$cuurent_sync;
            $response["data"] = $result;
        
        } else {
            $response['success'] = '0';
            $response['message'] = "No subcategory found";
        }
			
		
		return $response;
	}
	//get all product
	function product_list($postdata){
		$vendor_id = $postdata['vendor_id'];
		$data['select'] = ['id AS product_id','name','category_id','subcategory_id','status']; 
		$data['where']['vendor_id']= $vendor_id;
		if(isset($postdata['syncdate']) && $postdata['syncdate'] !=''){
			$data['where']['dt_added >'] = $postdata['syncdate'];
			$data['where_or']['dt_updated >'] = $postdata['syncdate'];
		}
		$data['table'] = 'product';
		$result = $this->selectRecords($data);
       	
		if (count($result)>0) {
			$cuurent_sync = strtotime(date('Y-m-d H:i:s'));
		 	$response['success'] = '1';
            $response['message'] = 'product Data';
            $response['sync_date'] =$cuurent_sync;
            $response["data"] = $result;
        
        } else {
            $response['success'] = '0';
            $response['message'] = "No product found";
        }		
		
		return $response;
	}
	//get all variant
	function product_variant_list($postdata){


//			echo date('Y-m-d H:i:s');exit;
			$vendor_id = $postdata['vendor_id'];
			$data['select'] = ['pw.quantity as quantity','pw.id AS variant_id','pw.weight_no AS weight','w.name','pw.product_id','pw.price','pw.discount_per','discount_price AS final_price','pw.status'];
			$data['where']['pw.vendor_id'] = $vendor_id;
			if(isset($postdata['syncdate']) && $postdata['syncdate'] !=''){
				$data['where']['pw.dt_updated >'] = $postdata['syncdate'];
			} 
			$data['table'] = 'product_weight AS pw';
			$data['join'] = ['weight as w' =>
									['w.id = pw.weight_id',
									'LEFT']
								];
			$result = $this->selectFromJoin($data);
			if (count($result)>0) {
				$cuurent_sync = strtotime(date('Y-m-d H:i:s'));
				 $response['success'] = '1';
	            $response['message'] = 'variant Data';
	            $response['sync_date'] =$cuurent_sync;
	            $response["data"] = $result;

            
	        } else {
	            $response['success'] = '0';
	            $response['message'] = "No product found";
	        }
			
		
		return $response;
	}
	function check_variant_from_category($category_id){
		$data['select'] = ['pw.quantity','pw.id'];
		$data['where'] = ['p.category_id'=>$category_id];
		$data['table'] = 'product AS p';
		$data['join'] = ['product_weight AS pw'=>['p.id=pw.product_id','LEFT']];
		$result = $this->selectFromJoin($data);
		// echo $this->db->last_query();
		if(count($result)>0){
			foreach ($result as $key => $value) {
				if($value->quantity >0){
					// echo $value->quantity;exit;
						return true;
				}
			}
		}
	}
	//checkout with json array
	function checkout($postdata){
		// echo $cuurent_sync = strtotime(date('Y-m-d h:i:s')); exit;
	 	$orderdata = $postdata['order_data'];
		$register_id = $postdata['register_id'];

//	 	echo $register_id;exit;
		$orderdata = json_decode($orderdata);
		$count = 0;

//		print_r($orderdata);exit;

		foreach ($orderdata as $key => $value) {
			for ($i=0; $i < count($value); $i++) {

				$order_number = $value[$i]->order_no;
				$vendor_id = $value[$i]->vendor_id;
				$customer_id = $value[$i]->customer_id;
				$total_discount = $value[$i]->total_discount;
				$total_price = $value[$i]->total_price;
				$payment_type = $value[$i]->payment_type;
				$total_item = $value[$i]->total_item;
				$status = $value[$i]->status;
//				$register_id = $value[$i]->register_id;
				$dt_added = strtotime(date('Y-m-d h:i:s'));
				$dt_updated = strtotime(date('Y-m-d h:i:s'));
				$insertiton = array(
						'order_from' => '0',
						'order_no' =>$order_number,
						'vendor_id'=>$vendor_id,
						'customer_id'=>$customer_id,
						'register_id' => $register_id,
						'total'=>$total_price,
						'order_discount' => $total_discount,
						'payable_amount' => $total_price,
						'payment_type'=>$payment_type,
						'total_item'=>$total_item,
						'status'=>$status,
						'order_status' => 4,
						'dt_added'=>$dt_added,
						'dt_updated'=>$dt_updated
					);
				unset($data);
				$data['insert'] = $insertiton;
				$data['table']= 'order';
				$order_id = $this->insertRecord($data);
				$detail = $value[$i]->detail;
//				print_r($detail);exit;
				foreach ($detail as $detail_key => $detail_value) {				
					$product_id = $detail_value->product_id;
					$product_variant_id = $detail_value->product_variant_id;
					$total_quantity = $detail_value->total_quantity;
					$actual_discount = $detail_value->actual_discount;
					$actual_price = $detail_value->actual_price;
					$total_discount = $detail_value->total_discount;
					$calculation_price = $detail_value->calculation_price;
					$status = $detail_value->status;
					$insertiton = array(
									'order_id' => $order_id,
									'product_id'=>$product_id,
									'product_weight_id'=>$product_variant_id,
									'quantity'=>$total_quantity,
									'actual_discount'=>$actual_discount,
									'actual_price'=> $actual_price,
									'discount'=> $actual_price - $total_discount,
									'calculation_price' =>$total_discount,
									'status'=>1,
									'delevery_status'=>1,
									'dt_added'=>$dt_added,
									'dt_updated'=>$dt_updated
								);
					unset($data);
					$data['insert'] = $insertiton;
					$data['table']= 'order_details';
					$result = $this->insertRecord($data);
				
				}
			}
		$count++;
		}
			if (count($result)>0) {				
			 	$response['success'] = '1';
	            $response['message'] = 'Order Inserted';
            
	        } else {
	            $response['success'] = '0';
	            $response['message'] = "No product found";
	        }
			
		
		return $response;
		
	}
	//get vendor group
	function getCustomerGroupSync($postdata){
		$vendor_id = $postdata['vendor_id'];
		$data['select'] = ['id AS group_id','name','status'];
		$data['where']['vendor_id'] = $vendor_id;
		if(isset($postdata['syncdate']) && $postdata['syncdate'] !=''){
			$data['where']['dt_added >'] = $postdata['syncdate'];
			$data['where_or']['dt_updated >'] = $postdata['syncdate'];
		} 
		$data['table'] = 'customer_group';
		
		$result = $this->selectRecords($data);
       	
		if (count($result)>0) {
			$cuurent_sync = strtotime(date('Y-m-d h:i:s'));
		 	$response['success'] = '1';
            $response['message'] = 'Group Data';
            $response['sync_date'] =$cuurent_sync;
            $response["data"] = $result;
        
        } else {
            $response['success'] = '0';
            $response['message'] = "No Group found";
        }
        return $response;
	}
	//get individual customer
	function getCustomerSync($postdata){

		$vendor_id = $postdata['vendor_id'];
		$sysdate = 0;
		if(isset($postdata['syncdate'])&&$postdata['syncdate']!=''){
			$sysdate = $postdata['syncdate'];
		}
		$result = $this->db->query("SELECT `c`.*, `g`.`name` as customer_group
							FROM (`customer` as c)
							LEFT JOIN `customer_group` as g ON `g`.`id` = `c`.`group_id`
							WHERE c.vendor_id =  '$vendor_id'
							AND (c.dt_added >= $sysdate OR c.dt_updated >= $sysdate)")->result();
	
		
       	// echo $this->db->last_query();exit;
		if (count($result)>0) {
			$cuurent_sync = strtotime(date('Y-m-d h:i:s'));
		 	$response['success'] = '1';
            $response['message'] = 'Customer Data Data';
            $response['sync_date'] =$cuurent_sync;
            $response["data"] = $result;
        
        } else {
            $response['success'] = '0';
            $response['message'] = "No Customer Data found";
        }
        return $response;
	}
	//add customer
	function customer_add($postdata){

        $customer_temp = array(
            'group_id' => $postdata['group_id'],
            'vendor_id' => $postdata['vendor_id'],               
            'customer_name' => $postdata['customer_name'],
            'company' => $postdata['company'],
            'dob' => $postdata['dob'],
            'gender' => $postdata['gender'],
            'phone' => $postdata['phone'],
            'mobile' => $postdata['mobile'],
            'email' => $postdata['email'],
            'street1' => $postdata['street1'],
            'street2' => $postdata['street2'],
            'city' => $postdata['city'],
            'state' => $postdata['state'],
            'country' => $postdata['country'],
            'postcode' => $postdata['postcode'],
            'password' => $postdata['password'],
            'customercode' => $postdata['customercode'],
            'fax' => $postdata['fax'],
            'website' => $postdata['website'],
            'twitter' => $postdata['twitter'],
            'status' => '1',
            'dt_added' => strtotime(date('Y-m-d H:i:s')),
            'dt_updated' => strtotime(date('Y-m-d H:i:s'))
        );
		
		$data['insert'] = $customer_temp;
		$data['table'] = 'customer';
		$result = $this->insertRecord($data);
       	
		if (count($result)>0) {
			$cuurent_sync = strtotime(date('Y-m-d h:i:s'));
		 	$response['success'] = '1';
            $response['message'] = 'Customer added successfull';
        	
        } else {
            $response['success'] = '0';
            $response['message'] = "Error";
        }
        return $response;
	}

	## Currency List ##
    public function currency_list(){

       $data['select'] = ['iso','name'];
       $data['table'] = ['currency'];
       $result = $this->selectRecords($data);

	    if (count($result)>0) {

	        $response['success'] = "1";
	        $response['message'] = "Currency list";
	        $response["data"] = $result;
	       
	    }else{
		 	$response['success'] = '0';
	        $response['message'] = "Error";
	       
	    }
	 	return $response;
    }
    //get last register vendor
    public function last_register($postdata){
    	error_reporting(E_ALL);
        $vendor_id = $postdata['vendor_id'];
        $data['select'] = ['id',
        					'transaction',
							'cash_amount_expected',
							'counted',
							'difference',
							'credit_card_expected',
							'credit_card_counted',
							'credit_card_differences',
							'open_note',
							'closure_note',
							'opening_time',
							'closing_time',
							'type',
							];
       	$data['where']['vendor_id'] = $vendor_id;
		$data['order'] = 'id DESC';
		$data['limit'] = '1';
       	$data['table'] = 'register';	

        $result = $this->selectRecords($data);
        // echo$this->db->last_query();exit;
       	$count = $this->countRecords($data);

	    if (count($result)>0) {
	    	foreach ($result as $key => $value) {
    		  	$value->outlet = 'Main Outlet';
                $value->register = 'Main Register';
                $value->total_register = $count;
                 foreach ($value as $ky => $vl) {                
                	if($vl==NULL || $vl==''){
                		$value->$ky = '';
                	}
                }
	    	}
	        $response['success'] = "1";
	          $response["message"] = 'Register data';
	        $response["data"] = $result;
	       
	    }else{
	    	$dt = strtotime(date('Y-m-d h:i:s'));
		 	$response['success'] = '1';
	        $response['message'] = "Register Data";
	        $response['data'] = [array("id"=> "0",
					            "transaction"=> "0",
					            "cash_amount_expected"=> "000.00",
					            "counted"=> "0",
					            "difference"=> "",
					            "credit_card_expected"=> "",
					            "credit_card_counted"=> "",
					            "credit_card_differences"=> "",
					            "open_note"=> "test",
					            "closure_note"=> "",
					            "opening_time"=> "$dt",
					            "closing_time"=> "",
					            "type"=> "0",
					            "outlet"=> "Main Outlet",
					            "register"=> "Main Register",
					            "total_register"=> '0')];
	       
	    }
	 	return $response;

    } 

    public function open_register($postdata){
    	
        $vendor_id = $postdata['vendor_id'];
        $amount = $postdata['amount'];
        $note = $postdata['open_note'];

        $insert = array(
            'vendor_id' => $vendor_id,
            'transaction' => $amount,
            'cash_amount_expected' => $amount,
            'open_note' => $note,
            'opening_time' => strtotime(date('Y-m-d H:i:s')),
            'type' => '1'
        );
        $data['insert'] = $insert;
        $data['table'] ='register';
        $id = $this->insertRecord($data);

        unset($data);
        $data['select'] = ['id',
							'vendor_id',
							'transaction',
							'cash_amount_expected',
							'counted',
							'difference',
							'credit_card_expected',
							'credit_card_counted',
							'credit_card_differences',
							'open_note',
							'closure_note',
							'opening_time',
							'closing_time',
							'type'];
        $data['where']['id'] = $id;
        $data['table'] ='register';
        $result = $this->selectRecords($data);
        $count = $this->countRecords($data);

	    if (count($result)>0) {
	    	foreach ($result as $key => $value) {
    		  	$value->outlet = 'Main Outlet';
                $value->register = 'Main Register';
                $value->total_register = $count;

                foreach ($value as $ky => $vl) {                
                	if($vl==NULL || $vl==''){
                		$value->$ky = '';
                	}
                }
	    	}
	        $response['success'] = "1";
          	$response["message"] = 'Register data';
	        $response["data"] = $result;
	       
	    }else{
		 	$response['success'] = '0';
	        $response['message'] = "No matching records found";
	       
	    }
	 	return $response;

    }
    public function close_register($postdata){
    	
    	$vendor_id = $postdata['vendor_id'];
      	$id = $postdata['id'];
        

        $update = array(          
            'counted' => $postdata['counted'],
            'difference' => $postdata['difference'],
            'credit_card_expected' => $postdata['credit_card_expected'],
            'credit_card_counted' => $postdata['credit_card_counted'],
            'credit_card_differences' => $postdata['credit_card_differences'],
            'closure_note' => $postdata['closure_note'],
            'closing_time' => strtotime(date("Y-m-d H:i:s")),
            'type' => '0',
        );
        $data['update'] = $update;
        $data['where'] = ['id'=>$id,'vendor_id'=>$vendor_id];
        $data['table'] ='register';
        $updatedata = $this->updateRecords($data);

        unset($data);
        $data['select'] = ['id',
							'vendor_id',
							'transaction',
							'cash_amount_expected',
							'counted',
							'difference',
							'credit_card_expected',
							'credit_card_counted',
							'credit_card_differences',
							'open_note',
							'closure_note',
							'opening_time',
							'closing_time',
							'type'];
        $data['where']['id'] = $id;
        $data['table'] ='register';
        $result = $this->selectRecords($data);
        $count = $this->countRecords($data);

	    if (count($result)>0) {
	    	foreach ($result as $key => $value) {
    		  	$value->outlet = 'Main Outlet';
                $value->register = 'Main Register';
                $value->total_register = $count;
                 foreach ($value as $ky => $vl) {                
                	if($vl==NULL || $vl==''){
                		$value->$ky = '';
                	}
                }
	    	}
	        $response['success'] = "1";
          	$response["message"] = 'Register updated';
	        $response["data"] = $result;
	       
	    }else{
		 	$response['success'] = '0';
	        $response['message'] = "No matching records found";
	       
	    }
	 	return $response;

    }



}
//**Sample Order Checkout
	//* $orderdata = '{

 		// * 					"order_temp_data": [{
		// * 	 			"order_no": "OD1553936823148",
		// * 	 			"vendor_id": "19",
		// * 	 			"customer_id": "1",
		// * 	 			"total_discount": "0.00",
		// * 	 			"total_price": "448.00",
		// * 	 			"payment_type": "0",
		// * 	 			"total_item": "2",
		// * 	 			"status": "1",
		// * 	 			"dt_added": "1553936823149",
		// * 	 			"dt_updated": "1553936823149",

		// * 		 			"detail": [{
		// * 		 				"product_id": "1",
		// * 		 				"product_variant_id": "1",
		// * 		 				"total_quantity": "1",
		// * 		 				"actual_discount": "0",
		// * 		 				"actual_price": "0",
		// * 		 				"total_discount": "0",
		// * 		 				"calculation_price": "0",
		// * 		 				"status": "1"
				 				
		// * 		 			}, {
		// * 		 				"product_id": "1",
		// * 		 				"product_variant_id": "1",
		// * 		 				"total_quantity": "1",
		// * 		 				"actual_discount": "0",
		// * 		 				"actual_price": "0",
		// * 		 				"total_discount": "0",
		// * 		 				"calculation_price": "0",
		// * 		 				"status": "1"
		// * 		 			}]
			 			
		// * 	 			},
		// * 	 			{
		// * 	 			"order_no": "OD1553936823148",
		// * 	 			"vendor_id": "19",
		// * 	 			"customer_id": "1",
		// * 	 			"total_discount": "0.00",
		// * 	 			"total_price": "448.00",
		// * 	 			"payment_type": "0",
		// * 	 			"total_item": "2",
		// * 	 			"status": "1",
		// * 	 			"dt_added": "1553936823149",
		// * 	 			"dt_updated": "1553936823149",

		// * 		 			"detail": [{
		// * 		 				"product_id": "1",
		// * 		 				"product_variant_id": "1",
		// * 		 				"total_quantity": "1",
		// * 		 				"actual_discount": "0",
		// * 		 				"actual_price": "0",
		// * 		 				"total_discount": "0",
		// * 		 				"calculation_price": "0",
		// * 		 				"status": "1"
				 				
		// * 		 			}, {
		// * 		 				"product_id": "1",
		// * 		 				"product_variant_id": "1",
		// * 		 				"total_quantity": "1",
		// * 		 				"actual_discount": "0",
		// * 		 				"actual_price": "0",
		// * 		 				"total_discount": "0",
		// * 		 				"calculation_price": "0",
		// * 		 				"status": "1"
		// * 		 			}]
		 			
		// *  				}]
 	
 		// * 				}';
		// *
	//**
?>
