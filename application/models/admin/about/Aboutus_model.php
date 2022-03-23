<?php
Class Aboutus_model extends My_model{

    function __construct(){
     // $this->load->model('common_model');
     // $re = $this->common_model->getExistingBranchId();
     // $this->branch_id = $re[0]->id;
     $this->vendor_id = $this->session->userdata('vendor_admin_id');
    }

	public function getAboutBanner(){
		$data['table'] = ABOUT_BANNER_IMAGE;
		$data['select'] = ['*'];
        $data['where'] = ['vendor_id'=>$this->vendor_id];
		return $this->selectRecords($data);
	}

	 public function AddAboutBanner($postData) {
        $data['select'] = ['id','image'];
        $data['table'] = ABOUT_BANNER_IMAGE;
        $data['where']['vendor_id'] = $this->vendor_id;
        $result = $this->selectRecords($data);

        if (empty($result)) {

            $image = $_FILES['image']['name'];
            $image = explode('.',$image);
            $image = $image[0] . time(). '.' . $image[1];

            $temp_location = $_FILES['image']['tmp_name'];
             $uploadpath = 'public/uploads/about/'.$image;
            move_uploaded_file($temp_location, $uploadpath);

            $data['insert']['image'] = $image;
            $data['insert']['vendor_id'] = $this->vendor_id;
            $data['insert']['created_at'] = DATE_TIME;
            $data['insert']['updated_at'] = DATE_TIME;
            $data['table'] = ABOUT_BANNER_IMAGE;
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
                    $uploadpath = 'public/uploads/about/'.$image;
                    move_uploaded_file($temp_location, $uploadpath);
                    unlink('public/uploads/about/'.$result[0]->image);
                }else{
                    $image = $postData['hidden_image'];
                }

            $data['update']['image'] = $image;
            $data['update']['vendor_id'] = $this->vendor_id;
            $data['update']['updated_at'] = DATE_TIME;
            $data['where'] = ['id' => $result[0]->id];
            $data['table'] = ABOUT_BANNER_IMAGE;
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