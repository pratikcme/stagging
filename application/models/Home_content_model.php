<?php 

Class Home_content_model extends My_model{

    function __construct(){
        $this->branch_id = $this->session->userdata('branch_id');
    }

	public function getAboutSectionTwo(){
		$data['table'] = TABLE_HOME_CONTENT;
		$data['select'] = ['*'];
        $data['where'] = ['branch_id' =>$this->branch_id];
		return $this->selectRecords($data);
	}
    
 function getWebBannerImage(){
 
        $data['table'] = 'web_banners';
        $data['select'] = ['*'];
        $data['where'] = ['status!='=>'9','branch_id'=>$this->branch_id];
        return $this->selectRecords($data);
        
    }
    public function addRecord($postData){
      
	   if($_FILES['image']['error'] == 0){
            $image = $_FILES['image']['name'];
            $image = explode('.',$image);
            $image = $image[0] . time(). '.' . $image[1];
            $temp_location = $_FILES['image']['tmp_name'];
            $uploadpath = 'public/uploads/home_content/'.$image;
            move_uploaded_file($temp_location, $uploadpath);
        }
        $data['table'] = TABLE_HOME_CONTENT;
        $data['insert']['image'] = $image;
        $data['insert']['main_title'] = $postData['main_title'];
        $data['insert']['sub_title'] = $postData['sub_title'];
        $data['insert']['created_at'] = DATE_TIME;
        $data['insert']['updated_at'] = DATE_TIME;
        $result = $this->insertRecord($data);
        if($result){
            return ['success','Record Added Successfully'];
        }else{
            return ['danger', DEFAULT_MESSAGE];
        }
    }

    public function getSectionTwo(){
		$data['table'] = TABLE_HOME_CONTENT;
    	$data['select'] = ['*'];
    	$data['order'] = "id DESC";
    	return $this->selectRecords($data);    	
    }

    public function selectSectionTwoEditRecord($id){
		$data['table'] = TABLE_HOME_CONTENT;
    	$data['select'] = ['*'];
    	$data['where']['id'] = $id;
    	return $this->selectRecords($data);    	
    } 

    public function updateAboutRecord($postData){
         $id = $this->utility->safe_b64decode($postData['update_id']);
         if($_FILES['image']['error'] == 0){
            $image = $_FILES['image']['name'];
            $image = explode('.',$image);
            $image = $image[0] . time(). '.' . $image[1];
            $temp_location = $_FILES['image']['tmp_name'];
            $uploadpath = 'public/uploads/home_content/'.$image;
            move_uploaded_file($temp_location, $uploadpath);
            unlink('public/uploads/home_content/'.$postData['hidden_image']);
        }else{
            $image = $postData['hidden_image'];
        }

        $data['table'] = TABLE_HOME_CONTENT;
        $data['update']['image'] = $image;
        $data['update']['main_title'] = $postData['main_title'];
        $data['update']['sub_title'] = $postData['sub_title'];
        $data['update']['updated_at'] = DATE_TIME;
        $data['where']['id'] = $id;
	    $result = $this->updateRecords($data); 
		if($result) {
            return ['success', 'Record Edit Successfully'];
        } else {
            return ['danger', DEFAULT_MESSAGE];
        } 	
    }

    public function removeRecord($id){
    	$data['table'] = TABLE_HOME_CONTENT;
    	$data['where']['id'] = $id;
    	return $this->deleteRecords($data);
    		
    }

    public function aboutSectionTwo(){
        $this->db->select('*');  
        $this->db->from(TABLE_HOME_CONTENT);
        $this->db->where('branch_id',$this->branch_id);
        $query = $this->db->get();  
        return $query->result();  
    }


  ## Multi Delete City ##
    public function multi_delete()
    {

        $id = $_GET['ids'];
        $re = '' ;
        foreach ($id as $value) {
               $data['table'] = TABLE_HOME_CONTENT;
                $data['where']['id'] = $value;  
               $re = $this->deleteRecords($data);

        }
        if($re){
            echo json_encode(['status'=>1]);
        }
        
    }

    public function getSectionOne(){
        $data['table'] = TABLE_HOME_SECTION_ONE;
        $data['select'] = ['*'];
        return $this->selectRecords($data);

    }

    public function getHomeSection_one(){
        $data['table'] = TABLE_HOME_SECTION_ONE;
        $data['select'] = ['*'];
        $data['where'] = ['branch_id' =>$this->branch_id];
        return $this->selectRecords($data);
    }

    public function addEditSectionOne($postData) {
        // print_r($_FILES);die;
        $data['select'] = ['id','image1','image2','image3','image4'];
        $data['table'] = TABLE_HOME_SECTION_ONE;
        $result = $this->selectRecords($data);
        
        if (empty($result)) {

            $image1 = $_FILES['image1']['name'];
            $image1 = explode('.',$image1);
            $image1 = $image[0] . time(). '.' . $image1[1];

            $temp_location1 = $_FILES['image1']['tmp_name'];
             $uploadpath1 = 'public/uploads/home_content/'.$image1;
            move_uploaded_file($temp_location1, $uploadpath1);

            $image2 = $_FILES['image2']['name'];
            $image2 = explode('.',$image2);
            $image2 = $image[0] . time(). '.' . $image2[2];

            $temp_location2 = $_FILES['image2']['tmp_name'];
             $uploadpath2 = 'public/uploads/home_content/'.$image2;
            move_uploaded_file($temp_location2, $uploadpath2);

            $image3 = $_FILES['image3']['name'];
            $image3 = explode('.',$image3);
            $image3 = $image[0] . time(). '.' . $image3[3];

            $temp_location3 = $_FILES['image3']['tmp_name'];
             $uploadpath3 = 'public/uploads/home_content/'.$image3;
            move_uploaded_file($temp_location3, $uploadpath3);

            $image4 = $_FILES['image4']['name'];
            $image4 = explode('.',$image4);
            $image4 = $image[0] . time(). '.' . $image4[4];

            $temp_location4 = $_FILES['image4']['tmp_name'];
             $uploadpath4 = 'public/uploads/home_content/'.$image4;
            move_uploaded_file($temp_location4, $uploadpath4);


            $data['insert']['main_title1'] = $postData['main_title1'];
            $data['insert']['number1'] = $postData['number1'];
            $data['insert']['image1'] = $image1;

            $data['insert']['main_title2'] = $postData['main_title2'];
            $data['insert']['number2'] = $postData['number2'];
            $data['insert']['image2'] = $image2;

            $data['insert']['main_title3'] = $postData['main_title3'];
            $data['insert']['number3'] = $postData['number3'];
            $data['insert']['image3'] = $image3;

            $data['insert']['main_title4'] = $postData['main_title4'];
            $data['insert']['number4'] = $postData['number4'];
            $data['insert']['image4'] = $image4;

            $data['insert']['dt_created'] = DATE_TIME;
            $data['insert']['dt_updated'] = DATE_TIME;
            $data['table'] = TABLE_HOME_SECTION_ONE;
            $result = $this->insertRecord($data);

            if ($result) {
                return ['success', 'Record Added Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            }

        } else {

            if($_FILES['image1']['error'] == 0){
                    $image1 = $_FILES['image1']['name'];
                    $image1 = explode('.',$image1);
                    $image1 = $image1[0] . time(). '.' . $image1[1];
                    $temp_location1 = $_FILES['image1']['tmp_name'];
                    $uploadpath1 = 'public/uploads/home_content/'.$image1;
                    move_uploaded_file($temp_location1, $uploadpath1);
                    unlink('public/uploads/home_content/'.$result[0]->image1);
                }else{
                    $image1 = $postData['hidden_image1'];
                }

                 if($_FILES['image2']['error'] == 0){
                    $image2 = $_FILES['image2']['name'];
                    $image2 = explode('.',$image2);
                    $image2 = $image2[0] . time(). '.' . $image2[1];
                    $temp_location2 = $_FILES['image2']['tmp_name'];
                    $uploadpath2 = 'public/uploads/home_content/'.$image2;
                    move_uploaded_file($temp_location2, $uploadpath2);
                    unlink('public/uploads/home_content/'.$result[0]->image2);
                }else{
                    $image2 = $postData['hidden_image2'];
                }

                 if($_FILES['image3']['error'] == 0){
                    $image3 = $_FILES['image3']['name'];
                    $image3 = explode('.',$image3);
                    $image3 = $image3[0] . time(). '.' . $image3[1];
                    $temp_location3 = $_FILES['image3']['tmp_name'];
                    $uploadpath3 = 'public/uploads/home_content/'.$image3;
                    move_uploaded_file($temp_location3, $uploadpath3);
                    unlink('public/uploads/home_content/'.$result[0]->image3);
                }else{
                    $image3 = $postData['hidden_image3'];
                }

                 if($_FILES['image4']['error'] == 0){
                    $image4 = $_FILES['image4']['name'];
                    $image4 = explode('.',$image4);
                    $image4 = $image4[0] . time(). '.' . $image4[1];
                    $temp_location4 = $_FILES['image4']['tmp_name'];
                    $uploadpath4 = 'public/uploads/home_content/'.$image4;
                    move_uploaded_file($temp_location4, $uploadpath4);
                    unlink('public/uploads/home_content/'.$result[0]->image4);
                }else{
                    $image4 = $postData['hidden_image4'];
                }

                
                $data['update']['main_title1'] = $postData['main_title1'];
                $data['update']['number1'] = $postData['number1'];
                $data['update']['image1'] = $image1;

                $data['update']['main_title2'] = $postData['main_title2'];
                $data['update']['number2'] = $postData['number2'];
                $data['update']['image2'] = $image2;

                $data['update']['main_title3'] = $postData['main_title3'];
                $data['update']['number3'] = $postData['number3'];
                $data['update']['image3'] = $image3;

                $data['update']['main_title4'] = $postData['main_title4'];
                $data['update']['number4'] = $postData['number4'];
                $data['update']['image4'] = $image4;

                $data['update']['dt_updated'] = DATE_TIME;
                // echo "<pre>";
                // print_r($data);die;


                $data['where'] = ['id' => $result[0]->id];
                $data['table'] = TABLE_HOME_SECTION_ONE;
                $result = $this->updateRecords($data);

            if ($result) {
                return ['success', 'Record Edit Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            }
        }

    }

 
    public function getSectionOneBackground(){
        $data['table'] = TABLE_HOME_SECTION_ONE_BACKGROUND;
        $data['select'] = ['*'];
         $data['where'] = ['branch_id' =>$this->branch_id];
        return $this->selectRecords($data);
    }

    public function addEditSectionOneBackground($postData) {
        $data['select'] = ['id','image'];
        $data['table'] = TABLE_HOME_SECTION_ONE_BACKGROUND;
        $result = $this->selectRecords($data);

        if (empty($result)) {

            $image = $_FILES['image']['name'];
            $image = explode('.',$image);
            $image = $image[0] . time(). '.' . $image[1];

            $temp_location = $_FILES['image']['tmp_name'];
            $uploadpath = 'public/uploads/home_content/'.$image;
            move_uploaded_file($temp_location, $uploadpath);

            $data['insert']['image'] = $image;
            $data['insert']['created_at'] = DATE_TIME;
            $data['insert']['updated_at'] = DATE_TIME;
            $data['table'] = TABLE_HOME_SECTION_ONE_BACKGROUND;
            $result = $this->insertRecord($data);

            if ($result) {
                return ['success', 'Record Added Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            }

        } else {

                if($_FILES['image']['error'] == 0){
                    $image = $_FILES['image']['name'];
                    $image = explode('.',$image);
                    $image = $image[0] . time(). '.' . $image[1];
                    $temp_location = $_FILES['image']['tmp_name'];
                    $uploadpath = 'public/uploads/home_content/'.$image;
                    move_uploaded_file($temp_location, $uploadpath);
                    unlink('public/uploads/home_content/'.$result[0]->image);
                }else{
                    $image = $postData['hidden_image'];
                }

            $data['update']['image'] = $image;
            $data['update']['updated_at'] = DATE_TIME;
            $data['where'] = ['id' => $result[0]->id];
            $data['table'] = TABLE_HOME_SECTION_ONE_BACKGROUND;
            $result = $this->updateRecords($data);

            if ($result) {
                return ['success', 'Record Edit Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            }
        }

    }

   
}

?>