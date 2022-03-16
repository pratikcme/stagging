<?php


Class Admin_model extends My_model{

	public function login_check($postData){
		
		$data['table'] = ADMIN ;
		$data['select'] = ['*'];
        $data['where'] = ['email' =>$postData['email'], 
        				  'password'=>md5($postData['password']),
        				 ];
		return $this->selectRecords($data);
	}

	public function resetPass($PostData){
			exit;
		$data['where'] = ['email'=>trim($PostData['forget_email'])];
        $data['select'] = ['*'];
        $data['table'] = USERS;
		 $chk_num = $this->countRecords($data);
		
        if($chk_num > 0)
        {
           $user_details =  $this->selectRecords($data);
            $user_details = $user_details[0];
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
                    $password = generate_password(8,3);

                    $update = array(
                        "password" => md5($password),
                        "updated_at" => DATE_TIME
                    );
                    
                    $data['update'] = $update;
                    $data['table'] = USERS;
                    $data['where'] = ['id' => $user_details->id];
                    $response = $this->updateRecords($data);
						



						if($response)
						{
							
									  $message = "Congrats!!! Your new login credentials :<br/>
							  Your New password is : ".$password."<br/>
							  To change your password : You can change your password once you login.";
							
									$data['to'] = $PostData['forget_email'];
						
									$data['subject'] = 'Forgot Password';
								
									$data['message'] = $message;

									$asd = sendMail($data);

								if ($asd) {
									return true;
									  // $json_response['status'] = 'success';
									  // $json_response['message'] = 'Your login password has been sent to your registered mail address';
									  // $json_response['redirect'] = SITE_URL;
								}
							
						}
						 // return $json_response;
						   
           }	
	}

}

?>