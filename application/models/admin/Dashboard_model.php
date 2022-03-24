<?php


Class Dashboard_model extends My_model{

	public function blogData($postData){
		
		if(!empty($_FILES)){
			if($_FILES['image']['error'] == 0){

			$image_name = $_FILES['image']['name'];
			$tmp = $_FILES['image']['tmp_name'];
			$path = 'public/'.$image_name;
			move_uploaded_file($tmp, $path);
			$data['table'] = 'blog_image';
			$data['insert']['image'] = $image_name;			
			$data['insert']['user_id'] = $this->session->userdata('user_id');
			 $last_id =  $this->insertRecord($data);
			 unset($data);
			}
		}		

		$data['table'] = 'blog';
		$data['insert']['blog_content'] = $postData['heading'];
		$data['insert']['created_at'] = DATE_TIME;
		$data['insert']['updated_at'] = DATE_TIME;
		return $this->insertRecord($data);
	}
	public function GetblogData(){
		
		$data['table'] = 'blog';
		$data['select'] = ['*'];

		return $this->selectRecords($data);
	}
	public function GetblogImage(){
		
		$data['table'] = 'blog_image';
		$data['select'] = ['*'];
		return $this->selectRecords($data);
	}
}

?>