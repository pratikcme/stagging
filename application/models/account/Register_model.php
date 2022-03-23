<?php


Class Register_model extends My_model{

	public function RegisterData($postData){
				
		$insert = array(

				'name'=> $postData['first_name'],	
				'last_name'=> $postData['last_name'],
				'user_type'=> '2',	
				'status'=> 'active',	
				'email'=> $postData['email'],
				'password'=> md5($postData['password']),
				'created_at' => DATE_TIME,	
				'updated_at' => DATE_TIME	
			);

		$data['table'] = USERS;
		$data['insert'] = $insert;
		return $this->insertRecord($data);
	}

	public function changePassword($postData){
		
		$email = $this->session->userdata('email');
		$data['table'] = USERS;
		$data['select'] = ['*'];
		$data['where'] = ['email' =>$email,'password' =>md5($postData['old_password'])];
		$result=$this->selectRecords($data);
		 $chek_record = $this->countRecords($data);
		 unset($data);
		 if($chek_record){
				$data['table'] = USERS;
				$data['update']['password'] = md5($postData['new_password']);
				$data['where']['id'] =  $result[0]->id;
				$response = $this->updateRecords($data);
		 }else{

			$response = false;	
		 }
		 return  $response;
      
    }	
		


}

?>