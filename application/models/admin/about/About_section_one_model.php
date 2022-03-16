<?php
Class About_section_one_model extends My_model{

    function __construct(){
        $this->vendor_id = $this->session->userdata('vendor_admin_id');
    }

	public function getAboutSectionOne(){ 

		$data['table'] = ABOUT_SECTION_ONE;
		$data['select'] = ['*'];
        $data['where'] = ['vendor_id'=>$this->vendor_id ];
		return $this->selectRecords($data);
	}

	public function editUpdateSectionOne($postData) {
        
        $data['select'] = ['id','image'];
        $data['where'] = ['vendor_id'=>$this->vendor_id ];
        $data['table'] = ABOUT_SECTION_ONE;
        $result = $this->selectRecords($data);
        
        if (empty($result)) {
            $image = $_FILES['image']['name'];
            $image = explode('.',$image);
            $image = $image[0] . time(). '.' . $image[1];

            $temp_location = $_FILES['image']['tmp_name'];
            $uploadpath = 'public/uploads/about/'.$image;
            move_uploaded_file($temp_location, $uploadpath);

            $data['insert']['vendor_id'] = $this->vendor_id;
            $data['insert']['main_title'] = $postData['main_title'];
            $data['insert']['content'] = $postData['content'];
            $data['insert']['image'] = $image;
            $data['insert']['created_at'] = DATE_TIME;
            $data['insert']['updated_at'] = DATE_TIME;
            $data['table'] = ABOUT_SECTION_ONE;
            $result = $this->insertRecord($data);

            if ($result) {
                return ['success', 'Record Added Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            }

        } else {

             // print_r($postData);exit;
                if($_FILES['image']['error'] == 0){
                    $image = $_FILES['image']['name'];
                    $image = explode('.',$image);
                    $image = $image[0] . time(). '.' . $image[1];
                    $temp_location = $_FILES['image']['tmp_name'];
                    $uploadpath = 'public/uploads/about/'.$image;
                     move_uploaded_file($temp_location, $uploadpath);
                    // unlink('public/uploads/about/'.$result[0]->image);
                }else{
                    $image = $postData['hidden_image'];
                }


            $data['update']['main_title'] = $postData['main_title'];
            $data['update']['content'] = $postData['content'];
            $data['update']['image'] = $image;
            $data['update']['updated_at'] = DATE_TIME;
            $data['where'] = ['id' => $result[0]->id];
            $data['table'] = ABOUT_SECTION_ONE;
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