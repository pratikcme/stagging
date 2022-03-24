<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends My_model {

	public function varifiy_password($postData)
	{
        // print_r($postData);die;
			$data['table'] = TABLE_USER;
            $data['update']['fname'] = $postData['fname'];
            $data['update']['lname'] = $postData['lname'];
            $data['update']['phone'] = $postData['phone'];
            $data['update']['user_gst_number'] =  $postData['user_gst_number'];
			$data['where']['id'] =  $this->session->userdata('user_id');
				/*$response =*/ $this->updateRecords($data);
            $_SESSION['user_name'] = $postData['fname'];
            $_SESSION['user_lname'] = $postData['lname'];
            $_SESSION['user_phone'] = $postData['phone'];
		    return  true;

	}

    public function update_password($postData) {
              $data['table'] = TABLE_USER;
              $data['select'] = ['id','password'];
              $data['where'] = [
                                'email' => $this->session->userdata('user_email'),
                                'password'=>md5($postData['old_pass']),
                                'vendor_id'=>$this->session->userdata('vendor_id')
                            ];
              $result = $this->selectRecords($data);
              // echo $this->db->last_query();die;
              if(!empty($result)){
                    unset($data);
                    $data['table'] = TABLE_USER;
                    $data['update']['password'] = md5($postData['new_pass']);
                    $data['where'] = ['id'=>$result[0]->id];
                    $this->updateRecords($data);
                    return true;
              }else{
                return false;
              }
    }

    public function getSelfPickupOtp($order_id){
        $data['select'] = ['*'];
        $data['table'] = 'selfPickup_otp';
        $data['where']['user_id'] = $this->session->userdata('user_id');
        $data['where']['order_id'] = $order_id;
        return $result = $this->selectRecords($data);
    }

	public function selectUserDetail(){
		$data['select'] = ['*'];
        $data['table'] = TABLE_USER;
        $data['where']['id'] = $this->session->userdata('user_id');
        return $result = $this->selectRecords($data);
	}
	
	public function updateUserDetail($postData){
		$data['table'] = TABLE_USER; 
		$data['update']['fname'] = $postData['fname'];
        $data['update']['email'] = $postData['email'];
        $data['update']['phone'] = $postData['phone'];
        $data['where']['id'] = $this->session->userdata('user_id');
        $result = $this->updateRecords($data);
        return true;	
	}

	public function getUserAddress(){
		$data['select'] = ['*'];
        $data['table'] = TABLE_USER_ADDRESS;
        $data['where'] = ['user_id'=>$this->session->userdata('user_id'),'status !=' => '9'];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
	}

    public function getFaq(){
        $data['select'] = ['*'];
        $data['table'] = FAQ;
        return $this->selectRecords($data);
    }

	public function AddUserAddress($postData){

        $data['table'] = TABLE_USER_ADDRESS;
        $data['select'] = ['*'];
        $data['where'] = [
            'user_id'=>$this->session->userdata('user_id'),
            'status' =>'1'
        ];
        $ua = $this->selectRecords($data);
        if(empty($ua)){
            $status = '1';
        }else{
            $status = '0';
        }
        unset($data);
        $data['table'] = TABLE_USER_ADDRESS;
        $data['insert'] = [
                            'branch_id'=>$this->session->userdata('branch_id'),
        					'user_id' => $this->session->userdata('user_id'),
        					'name'=>$postData['fname'],
        					'phone'=>$postData['phone'],
        					'country'=>$postData['country'],
        					'state'=>$postData['state'],
        					'city'=>$postData['city'],
                            'google_location'=>$postData['location'],
        					'pincode'=>$postData['pincode'],
        					'address'=>$postData['address'],
        					'latitude'=>$postData['latitude'],
        					'longitude'=>$postData['longitude'],
                            'landmark' => $postData['landmark'],
        					'status'=>$status,
        					'dt_added'=>strtotime(DATE_TIME),
        					'dt_updated'=>strtotime(DATE_TIME),
        				  ];
        // echo '2';
        // print_r($data['insert']);
        // exit();
        return $this->insertRecord($data);
	}

	public function setDefaultAddress_old($id){
        $data['table'] = TABLE_USER_ADDRESS;
        $data['where']= [
            'id' => $id,
        ];
        $data['update']['status'] = '1';
        $this->updateRecords($data);
        unset($data);
		$data['select'] = ['*'];
        $data['table'] = TABLE_USER_ADDRESS;
        $data['where']= [
                    'user_id' => $this->session->userdata('user_id'),
                    'status' => '1',
                    ];
        $re = $this->selectRecords($data);
        unset($data);
            if($re){
                $data['table'] = TABLE_USER_ADDRESS;
                $data['where']= [
                            'user_id' => $this->session->userdata('user_id'),
                            'status' => '1',
                            ];
                $data['update']['status'] = '0';
                $res = $this->updateRecords($data);
            }
        unset($data);
            if($res){
                $data['table'] = TABLE_USER_ADDRESS;
                $data['where']= [
                            'id' => $id,
                            ];
                $data['update']['status'] = '1';
                $resl = $this->updateRecords($data);

            return $resl;
        }
        // unset($data);
        // foreach ($re as $key => $value) {
        // 	if($value->id == $id){
        // 		if($value->status == '0'){
        // 			$data['update']['status'] = '1';
       	// 			$data['where']['id'] = $id;
        // 		}else{
        // 			$data['update']['status'] = '0';
       	// 			$data['where']['id'] = $id;
        // 		}
        // 	$data['table'] = TABLE_USER_ADDRESS;
        // 	return $this->updateRecords($data);
        // 	}
        // 	// else{
        // 	// 	if($value->status == '1')
        // 	// 		$data['update']['status'] = '0';
       	// 	// 		$data['where']['user_id'] = $this->session->userdata('user_id');	
        // 	// }
        // }

	}

    function setDefaultAddress($id){
       $data['table'] = TABLE_USER_ADDRESS;
       $data['where']= [
        'user_id' => $this->session->userdata('user_id'),
    ];
        $data['update']['status'] = '0';
        $res = $this->updateRecords($data);
        unset($data);
        $data['table'] = TABLE_USER_ADDRESS;
        $data['where']= [
            'id' => $id,
        ];
        $data['update']['status'] = '1';
        $resl = $this->updateRecords($data);

    }

	public function getEditAddress($id){
		$data['select'] = ['*'];
        $data['table'] = TABLE_USER_ADDRESS;
        $data['where']['id'] = $id;
        return $this->selectRecords($data);
        
	}

	public function updateAddress($postData){
        // print_r($postData);die;
		$id = $postData['update_id'];
		 // $data['update'] = [
   //      					'user_id' => $this->session->userdata('user_id'),
   //      					'name'=>$postData['name'],
   //      					'phone'=>$postData['phone'],
   //      					'country'=>$postData['country'],
   //      					'state'=>$postData['state'],
   //      					'city'=>$postData['city'],
   //      					'pincode'=>$postData['pincode'],
   //      					'address'=>$postData['address'],
                            
   //      					'dt_updated'=>strtotime(DATE_TIME),
   //      				  ];
         $data['update']['user_id'] = $this->session->userdata('user_id');
         $data['update']['name'] = $postData['fname'];
         $data['update']['phone'] = $postData['phone'];
         $data['update']['country'] = $postData['country'];
         $data['update']['state'] = $postData['state'];
         $data['update']['city'] = $postData['city'];
         $data['update']['google_location'] = $postData['location'];
         $data['update']['pincode'] = $postData['pincode'];
         $data['update']['address'] = $postData['address'];
         $data['update']['landmark'] = $postData['landmark'];
    
    if(isset($postData['latitude'])){
         $data['update']['latitude'] = $postData['latitude'];
    }
    if(isset($postData['longitude']) && $postData['longitude'] != ''){
         $data['update']['longitude'] = $postData['longitude'];
    }
         $data['update']['dt_updated'] = strtotime(DATE_TIME);
        // print_r($data['update']);exit;
		 $data['table'] = TABLE_USER_ADDRESS;
         $data['where']['id'] = $id;
           
        return $this->updateRecords($data);
	}

	public function removeRecord($id){
		 $data['table'] = TABLE_USER_ADDRESS;
         $data['where']['id'] = $id;
         $return = $this->deleteRecords($data);
         unset($data);
         if($return){
            $data['table'] = TABLE_USER_ADDRESS;
            $data['select'] = ['*'];
            $data['where'] = ['user_id'=>$this->session->userdata('user_id')];
            $result = $this->selectRecords($data);
            unset($data);
            $data['table'] = TABLE_USER_ADDRESS;
            $data['where'] = ['id'=>$result[0]->id];
            $data['update'] = ['status'=>'1'];
            $result = $this->updateRecords($data);
         }
            $data['table'] = TABLE_USER_ADDRESS;
            $data['select'] = ['*'];
            $data['where'] = ['user_id'=>$this->session->userdata('user_id'),'status'=>'1'];
            $r = $this->selectRecords($data);
         return $r;
	}

    public function getWishlist(){
        $data['table'] = TABLE_WISHLIST;
        $data['select'] = ['*'];
        $data['where'] = [
            'user_id'=>$this->session->userdata('user_id'),
            'branch_id'=>$this->session->userdata('branch_id'),
        ];
        return $this->selectRecords($data);
    }

    public function defaultProduct($id){

            $vendor_id = $this->session->userdata('branch_id');
            $data['table'] = TABLE_PRODUCT . " as p";
            $data['select'] = ['pw.discount_price'];
            $data['join'] = [
                TABLE_PRODUCT_WEIGHT .' as pw'=>['p.id = pw.product_id','LEFT']
            ];
            $data['where'] = ['p.status !=' => '9','p.id'=>$id,'p.branch_id'=>$vendor_id];      
            $data['groupBy'] =['p.id'];
            return  $this->selectFromJoin($data);
    }

    public function removeItemFromWishlist($postData){
        $id = $this->utility->safe_b64decode($postData['product_id']);
        $data['table'] = TABLE_WISHLIST;
        $data['where'] = [
            'product_id'=>$id,
            'branch_id'=>$this->session->userdata('branch_id'),
            'user_id'=>$this->session->userdata('user_id'),
        ];
        return $this->deleteRecords($data);
    }

    public function checkCurrentUserLoginType(){
        $user_id = $this->session->userdata('user_id');
        $data['table'] =  TABLE_USER;
        $data['select'] = ['login_type'];
        $data['where'] = ['id'=>$user_id];
        $res = $this->selectRecords($data);
        return $res[0]->login_type;
    }

     public function getDetails($varient_id){
        $data['table'] =  TABLE_PRODUCT_WEIGHT.' pw';
        $data['select'] = ['pw.weight_no','w.name','pkg.package'];
        $data['join'] = [
            TABLE_WEIGHT .' w'=>['pw.weight_id=w.id','LEFT'],
            'package as pkg' =>['pw.package=pkg.id','LEFT']
        ];
        $data['where'] = [
            'pw.id'=>$varient_id,'pw.status!='=>'9',
            'w.status!='=>'9',
            'pw.branch_id'=>$this->session->userdata('branch_id'),
        ];
        return $this->selectFromJoin($data);
    }
    
    public function selectOrders(){
           
        $data['table'] = TABLE_ORDER; 
        $data['select'] = ['*'];
        $data['where'] = [
                        'user_id'=> $this->session->userdata('user_id'),
                        'status !=' => '9',
                        'branch_id' => $this->session->userdata('branch_id')
                     ];
        $data['order'] = 'dt_updated DESC';
        return $this->selectRecords($data);
    }

    public function getVendorDetails($branch_id){
        $data['table'] = TABLE_VENDOR; 
        $data['select'] = ['name','address','location'];
        $data['where'] = [
                        'id'=>$branch_id ,
                        'status' => '1',
                     ];
        return $this->selectRecords($data);   
    }

    public function getUserDetails(){
        $data['table'] = TABLE_USER; 
        $data['select'] = ['fname','lname','phone'];
        $data['where'] = [
                        'id'=> $this->session->userdata('user_id'),
                        'status !=' => '9',
                     ];
        return $this->selectRecords($data); 
    }
}
?>