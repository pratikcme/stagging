<?php 

class Login_model extends My_model{

	function __construct(){
		$this->branch_id = $this->session->userdata('branch_id');
		$this->vendor_id =$this->session->userdata('vendor_id');
	}

	public function register_user($postData){
		// dd($postData);
		$insertData = array(
				'fname' => $postData['fname'],
				'lname' => $postData['lname'],
				'email' => $postData['email'],
				'password' => md5($postData['password']),
				'phone' => $postData['phone'],
				'country_code' => $postData['country_code'],
				'vendor_id' => $this->vendor_id,
				'login_type' => '0',
				'status' => '1',
				'email_verify'=>'1',
				'notification_status' => '1',
				'dt_added' => strtotime(DATE_TIME),
				'dt_updated' => strtotime(DATE_TIME)
			);

		$data['table'] = TABLE_USER;
		$data['insert'] = $insertData;
		$last_id = $this->insertRecord($data);
		return TRUE;
 		
	}

	public function checkLoginType(){
		$data['table'] = 'vendor';
        $data['select'] = ['login_type'];
        $data['where']['server_name'] = $_SERVER['SERVER_NAME'];
        $r = $this->selectRecords($data);
        if(!empty($r)){
        	return $r[0]->login_type; 
        }
	}

	public function sendOtpLogin($postData){
       $data['table'] = 'user';
       $data['select'] = ['*'];
       $data['where']['phone'] = $postData['phone'];
	   $data['where']['country_code'] = $postData['country_code'];
	   $data['where']['status!='] = '9';
       $data['where']['vendor_id'] = $this->vendor_id;
       $re = $this->selectRecords($data,true);
      
       unset($data);
       if(empty($re)){
            $insertData = array(
                'phone'=>$postData['phone'],
                'country_code'=>$postData['country_code'],                
                'vendor_id'=>$this->vendor_id,
                'login_type'=>'4',
                'email_verify'=>'0',
                'dt_added'=>strtotime(DATE_TIME),
                'dt_updated'=>strtotime(DATE_TIME),
            );
        $data['table'] = 'user';
        $data['insert'] = $insertData;
        $user_id = $this->insertRecord($data); // return last id
        
       }else{         
           $user_id = $re[0]['id'];
       }
        $varify =  $this->api_model->verify_mobile(
                                        [
                                        'user_id'=>$user_id,
                                        'country_code'=>$postData['country_code'],
                                        'vendor_id'=>$this->vendor_id,
                                        'phone'=>$postData['phone']
                                        ]
                                    );
        $response["success"] = 1;
        $response["message"] = "successfully sent otp on your mobile";
        $response['data'] = $varify['otp'];
        // $response['user_id'] = $user_id;
        return $response;
       
    }

    function varifyOtpLogin($postData){
      
        $data['select'] = ['*'];
        $data['table'] = 'user';
        $data['where']['vendor_id'] = $this->vendor_id;
        $data['where']['country_code'] = $postData['country_code'];
        $data['where']['phone'] = $postData['phone'];
        $data['where']['status !='] = '9';
        $re = $this->selectRecords($data,true);
        unset($data);
        if(!empty($re)){
           if($re[0]['otp'] == $postData['otp']){

                $data['update'] = [
                            'otp' => '',
                            'is_verify' => '1',
                            'status'=>'1',
                            ];
                $data['where'] = ['id'=>$re[0]['id']];
                $data['table'] = 'user';
                $this->updateRecords($data);
                // lq();
                if($re[0]['fname']!=''){

	            	$login_data = array(
			 			'user_id' => $re[0]['id'],
	                    'user_name' => $re[0]['fname'],
	                    'user_lname' => $re[0]['lname'],
			 			'user_email' => $re[0]['email'],
	                    'user_phone' => $re[0]['phone'],
			 			'logged_in' => TRUE
			 		); 

					$this->session->set_userdata($login_data);
					if($this->session->userdata('user_id') != ''){	
						$this->manageCartItem();
						if(isset($_SESSION['My_cart'][0]['branch_id'])){
							$branch_id = $_SESSION['My_cart'][0]['branch_id'];
							$this->load->model('frontend/vendor_model','vendor');
							$branch = $this->vendor->getVendorName($branch_id);
							$branch_name = $branch[0]->name;
							$vendor = array(
								'branch_id'=>$branch_id,
								'vendor_name'=>$branch_name,
							);
							$this->session->set_userdata($vendor);
						}
						unset($_SESSION['My_cart']);
					}
                }

				$response["success"] = 1;
        		$response["message"] = "OTP varified";
        		$response["user_id"] = $re[0]['id'];
        		$response["fname"] = $re[0]['fname'];
           }else{
                $response["success"] = 0;
                $response["message"] = "Invalid Otp";                
           }
        }else{
            $response["success"] = 0;
            $response["message"] = "Data is not found"; 
        }
        return $response;
    }
    function completeProfile($postData){  
        $data['update'] = [
                            'fname' => $postData['fname'],
                            'lname' => $postData['lname'],
                            'dt_updated'=>strtotime(DATE_TIME),

                            ];
        if(isset($postData['email'])){
            $data['update']['email'] = $postData['email'];
        }
        $data['table'] = 'user';
        $data['where']['vendor_id'] = $this->vendor_id;    
        $data['where']['id'] = $postData['user_id'];
        $this->updateRecords($data);
        $re = $this->selectRecords($data,true);

      
        $login_data = array(
			 			'user_id' => $re[0]['id'],
	                    'user_name' => $re[0]['fname'],
	                    'user_lname' => $re[0]['lname'],
			 			'user_email' => $re[0]['email'],
	                    'user_phone' => $re[0]['phone'],
			 			'logged_in' => TRUE
			 		); 

		$this->session->set_userdata($login_data);
		if($this->session->userdata('user_id') != ''){	
			$this->manageCartItem();
			if(isset($_SESSION['My_cart'][0]['branch_id'])){
				$branch_id = $_SESSION['My_cart'][0]['branch_id'];
				$this->load->model('frontend/vendor_model','vendor');
				$branch = $this->vendor->getVendorName($branch_id);
				$branch_name = $branch[0]->name;
				$vendor = array(
					'branch_id'=>$branch_id,
					'vendor_name'=>$branch_name,
				);
				$this->session->set_userdata($vendor);
			}
			unset($_SESSION['My_cart']);
		}
				


        unset($data);
        if($re){
            $response["success"] = 1;
            $response["message"] = "Profile Updated";  
        }else{
            $response["success"] = 0;
            $response["message"] = "Error to update profile";                
        }
        return $response;
    }


	public function manageCartItem()
	{
		if(isset($_SESSION['My_cart']) && !empty($_SESSION['My_cart'])){
			
			// echo "<pre>";
			// print_r($_SESSION['My_cart']);die;


			$res =  $this->MycartData($data); // user_id cart data;
			// echo '<pre>';
			// print_r($res);die;
			foreach ($_SESSION['My_cart'] as $key => $value) {
					// print_r($_SESSION['My_cart']);die;
					
				$g = $this->checkMyCart($value['product_weight_id']);
				unset($data);
					$cart = $this->UsersCartItem($value['product_weight_id']);
					if(!empty($cart)){

					foreach ($cart as $k => $v) {
						

							if( $value['product_weight_id'] == $v->product_weight_id ){

								$cart_quantity = $value['quantity'];
								$cart_item = array(		
									'product_weight_id'=> $value['product_weight_id'],
									'quantity'=> $value['quantity'],
									'status'=>'1',
									'dt_added' => strtotime(DATE_TIME),
									'dt_updated' => strtotime(DATE_TIME)
							);
								$data['table'] = TABLE_MY_CART;
								$data['where'] = [
									'branch_id'=>$value['branch_id'],
									'vendor_id'=>$value['vendor_id'],
									'user_id'=> $this->session->userdata('user_id'),
									'product_weight_id'=> $value['product_weight_id'],
								];
								$data['update'] = $cart_item;
								$this->updateRecords($data);

							}else{
							unset($data);
							$cart_quantity = $value['quantity'];
							$cart_item = array(
								'vendor_id'=>$value['vendor_id'],
								'branch_id'=>$value['branch_id'],
								'user_id'=> $this->session->userdata('user_id'),	
								'product_weight_id'=> $value['product_weight_id'],
								'quantity'=> $value['quantity'],
								'status'=>'1',
								'dt_added' => strtotime(DATE_TIME),
								'dt_updated' => strtotime(DATE_TIME)
							);
								$data['table'] = TABLE_MY_CART;
								$data['insert'] = $cart_item;
								$this->insertRecord($data);		
							}
					}
				}else{
					unset($data);
						$cart_item = array(
							'vendor_id'=>$value['vendor_id'],
							'branch_id'=>$value['branch_id'],	
							'user_id'=> $this->session->userdata('user_id'),	
							'product_weight_id'=> $value['product_weight_id'],
							'quantity'=> $value['quantity'],
							'status'=>'1',
							'dt_added' => strtotime(DATE_TIME),
							'dt_updated' => strtotime(DATE_TIME)
						);

							$data['table'] = TABLE_MY_CART;
							$data['insert'] = $cart_item;
							$this->insertRecord($data);
					}
			}

			$this->session->unset_userdata('My_cart');
			// $this->setMycartSession();


		}else{
			unset($data);
			$data['table'] = TABLE_MY_CART;
			$data['select'] = ['*'];
			$data['where'] = ['user_id'=>$this->session->userdata('user_id')];
			$result =  $this->selectRecords($data);
			// echo "<pre>";
			// print_r($result);die;

			if($result){
				foreach ($result as $key => $value) {
					$check = $this->checkMyCart($value->product_weight_id);
						// print_r($check);exit;
							$product_name = $check[0]->name;
							$image = $check[0]->image;
							$set_session_cart = array( 
								'vendor_id' => $value->vendor_id,
								'branch_id' => $value->branch_id,
								'product_id' => $value->product_id,
								'weight_id' => $value->weight_id,
								'product_name'=>$product_name,
								'product_price' =>	$value->actual_price,
								'discount_per' => $value->discount_per,
								'discount_price' => $value->discount_price,
								'quantity'=> $value->quantity,
								'image'=> $image,
								'total'=> $value->calculation_price,
								'product_weight_id'=> $value->product_weight_id
						);
						// $_SESSION["My_cart"][$key] = $set_session_cart;
					}

			}

		}

	}
	
	public function UsersCartItem($varient_id){
		$data['table'] = TABLE_MY_CART;
		$data['select'] = ['*'];
		$data['where'] = [
			'user_id'=>$this->session->userdata('user_id'),
			'product_weight_id'=> $varient_id];
		return $this->selectRecords($data);
	}

	public function MycartData(){
		;
		$data['table'] = TABLE_MY_CART;
		$data['select'] = ['*'];
		$data['where'] = [
			'user_id'=>$this->session->userdata('user_id'),
			'branch_id'=>$this->branch_id,
		];
		return $this->selectRecords($data);
	}

	public function login_chek($postData){
		
		// if user login with social login
		$data['table'] = TABLE_USER;
		$data['select'] = ['*'];
		$data['where'] = [
							'vendor_id' =>$this->vendor_id,
							'email'=>$postData['email'],
							'password'=>null,
							'login_type !='=>'0',
							'status !=' => '9'
						];
		$re = $this->selectRecords($data);
		// print_r($re);die;
		if(!empty($re)){
			unset($data);
			$password = $this->generate_password(8,3);

			$update = array(
				"password" => md5($password),
				"email_verify"=>"1",
				"dt_updated" => DATE_TIME
			);

			$data['update'] = $update;
			$data['table'] = TABLE_USER;
			$data['where'] = ['id' => $re[0]->id ];
			$this->updateRecords($data);

				$message = " You had Requested for password login :<br/>
				Please enter this password : ".$password." to login<br/>
				To change your password : You can change your password once you login.";

				$dataa['to'] = $postData['email'];			
				$dataa['subject'] = 'Your requested Password';
				$dataa['message'] = $message;
				// print_r($dataa);die;
				$asd = sendMail($dataa);
			if($asd){
				$this->utility->setFlashMessage('success','You are registered with social account,We had sent password on your email for direct login.');
				redirect(base_url().'login');
				exit();
			}
		}

		unset($data);
		// if user register with social login
		$data['table'] = TABLE_USER;
		$data['select'] = ['*'];
		$data['where'] = [
							'vendor_id' =>$this->vendor_id,
							'email'=>$postData['email'],
							'password'=>md5($postData['password']),
							'status !=' => '9',
						];
		$return = $this->selectRecords($data);
		// echo $this->db->last_query();
		// dd($return[0]->vendor_id);die;
		if($return){
		// $this->updateLoginType($return);

				@$remember = $postData['remember'];
                if (isset($remember) && $remember != '') {
                    delete_cookie("loginemail");
                    delete_cookie("loginpassword");
                    $set_email = array(
                        'name' => 'loginemail',
                        'value' => $postData['email'],
                        'expire' => '86500',
                        'prefix' => '',
                        'secure' => FALSE
                    );
                    $this->input->set_cookie($set_email);
                    $set_password = array(
                        'name' => 'loginpassword',
                        'value' => $postData['password'],
                        'expire' => '86500',
                        'prefix' => '',
                        'secure' => FALSE
                    );
                    $this->input->set_cookie($set_password);
                }else{
                	// echo '1';exit;
                	 delete_cookie("loginemail");
                     delete_cookie("loginpassword");
                }
				// print_r($return);die;
				$login_logs = [
					'user_id' => $return[0]->id,
					'vendor_id' => $return[0]->vendor_id,
					'status' => 'login',
					'type' => 'user',
					'dt_created' => DATE_TIME
		];
		$this->load->model('api_v3/common_model','v2_common_model');
		$this->v2_common_model->user_login_logout_logs($login_logs);
	}
		return $return;

	}
	

	private function updateLoginType($return){
		$data['table'] = TABLE_USER;
		$data['update'] = ['login_type'=>'0'];
		$data['where'] = [
			'id' => $return[0]->id
		];
		$this->updateRecords($data);
	}

	public function loginchekFromEmail($postData){
		$data['table'] = TABLE_USER;
		$data['select'] = ['*'];
		$data['where'] = [
							'email'=>$postData->email,
							'password'=>md5($postData->password),

						];
		$return = $this->selectRecords($data);
		unset($data);
		if($return){
			$data['table'] = TABLE_USER;
			$data['where'] = ['id'=>$return[0]->id];
			$data['update'] = ['email_verify'=>'1'];
			$this->updateRecords($data);
		}
		return $return;
	}

	public function checkMyCart($id){
				$data['table'] = TABLE_PRODUCT . " as p";
				$data['select'] = ['pw.*','p.name','pi.image'];
				$data['join'] = [
					TABLE_PRODUCT_WEIGHT .' as pw'=>['p.id = pw.product_id','LEFT'],
					TABLE_PRODUCT_IMAGE .' as pi'=>['pw.id = pi.product_variant_id','LEFT']
			];
				$data['where'] = [
						'p.status !=' => 9,
						'pw.id'=>$id
					];
				$data['groupBy'] = 'p.id';		
			return $this->selectFromJoin($data);

	}

	public function checkIsUserExist($postdata){
		$data['table'] = TABLE_USER;
		$data['select'] = ['*'];
		$data['where'] = [
							'email'=>$postdata['email'],
							'login_type'=>'0'
						];
		return $this->countRecords($data);
	}

	public function ForgetPassword($postdata){
		$data['table'] = TABLE_USER;
		$data['select'] = ['*'];
		$data['where'] = [
							'email'=>$postdata['email'],
							'status!=' =>'9',
							'vendor_id'=>$this->session->userdata('vendor_id') 
						];
		$chk_num = $this->countRecords($data);
		// dd($chk_num);
        if($chk_num > 0)
        {
           $user_details =  $this->selectRecords($data);
            $user_details = $user_details[0];
                  
                    $password = $this->generate_password(8,3);

                    $update = array(
                        "password" => md5($password),
                        "dt_updated" => DATE_TIME
                    );
                    
                    $data['update'] = $update;
                    $data['table'] = TABLE_USER;
                    $data['where'] = ['id' => $user_details->id];
                    $response = $this->updateRecords($data);
						if($response)
						{	
							$message = "Congrats!!! Your new login credentials :<br/>
							  Your New password is : ".$password."<br/>
							  To change your password : You can change your password once you login.";
							
							$data['to'] = $postdata['email'];			
							$data['subject'] = 'Forgot Password';
							$data['message'] = $message;
							$asd = sendMail($data);
								if ($asd) {
									return true;
								}
							
						}
           			}else{
           				return false;
           			}

			}
			
			function generate_password($length, $complex) 
                    {
                        $min = "abcdefghijklmnopqrstuvwxyz";
                        $num = "0123456789";
                        $maj = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                        $symb = "!@#$%^&*()_-=+;:,.?";
                        $chars = $min;
                        if ($complex >= 2) { $chars .= $num; }
                        if ($complex >= 3) { $chars .= $maj; }
                        if ($complex >= 4) { $chars .= $symb; }
                        $password = substr( str_shuffle( $chars ), 0, $length );
                        return $password;
                    }

       public function emailVerification($email){
          	$data['table'] = TABLE_USER;
          	$data['select'] = ['*'];
          	$data['where'] = ['email'=>$email,'vendor_id'=>$this->vendor_id];  	
          	$count = $this->countRecords($data);
          	if($count > 0){
          		return "false";
          	}else{
          		return "true";
          	}
          }

      public function mobileVerification_register($postData){
      		$mobile = $postData['phone'];
      		if(isset($postData['country_code'])){
      			$country_code = $postData['country_code'];
      		}
          	$data['table'] = TABLE_USER;
          	$data['select'] = ['*'];
          	$data['where']['phone'] = $mobile;
          	$data['vendor_id'] = $this->vendor_id;  	
          	$count = $this->countRecords($data);
          	if($count > 0){
          		return "false";
          	}else{
          		return "true";
          	}
          }


	}
?>