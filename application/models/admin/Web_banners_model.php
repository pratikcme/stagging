<?php 

Class Web_banners_model extends My_model{

    function __construct(){
     // $this->load->model('common_model');
     // $re = $this->common_model->getExistingVendorId();
     // $this->branch_id = $re[0]->id;
     $this->branch_id = $this->session->userdata('id');
    }

    private function set_upload_options_banner_promotion()
    {
        $config = array();
        $config['upload_path'] = './public/images/'.$this->folder.'web_banners/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = '0';
        $config['overwrite']     = TRUE;

        return $config;
    }

    public function getWebBannerImage(){
        $data['table'] = 'web_banners';
        $data['select'] = ['*'];
        $data['where'] = ['status !='=>'9','branch_id'=>$this->branch_id];
        return $this->selectRecords($data);        
    }


  ## Banner Promotion Add Update ##
    public function addRecord($postData){
        // print_r($_FILES);die;
        // $vendor_id = $postData['branch_id'];
        if($_FILES['image']['name']!= ''){

            $this->load->library('upload');
            if($_FILES['image']['name'] != ''){

                ## Image Upload ##
               $uploadpath = 'public/images/'.$this->folder.'web_banners/'.$image;
               $uploadResult = upload_single_image($_FILES,'add',$uploadpath);
               $image = $uploadResult['data']['file_name'];
               $data = array(
                'branch_id'=>$this->branch_id,
                'image' => $image,
                'main_title'=>$postData['main_title'],
                'sub_title'=>$postData['sub_title'],
                'status' => '1',
                'dt_created' => DATE_TIME,
                'dt_updated' => DATE_TIME
            );
               $this->db->insert('web_banners',$data);

               $this->session->set_flashdata('msg', 'Banner have been added successfully.');
               redirect(base_url().'admins/web_banners');
           }else{
            $this->session->set_flashdata('msg_error', 'Images could not be uploaded.');
            redirect(base_url().'admins/web_banners');
        }
    }else{
        $this->session->set_flashdata('msg_error', 'Images could not be uploaded.');
        redirect(base_url().'admins/web_banners');
    }
}


    public function getSectionTwo(){
		  $data['table'] = ABOUT_SECTION_TWO;
    	$data['select'] = ['*'];
      $data['where'] = ['branch_id'=>$this->branch_id];
    	$data['order'] = "id DESC";
    	return $this->selectRecords($data);    	
    }

    public function selectSectionTwoEditRecord($id){
		$data['table'] = 'web_banners';
    	$data['select'] = ['*'];
    	$data['where']['id'] = $id;
    	return $this->selectRecords($data);    	
    } 

    public function updateAboutRecord($postData){
         $id = $this->utility->safe_b64decode($postData['update_id']);
         if($_FILES['image']['error'] == 0){
                $uploadpath = 'public/images/'.$this->folder.'web_banners/'.$image;
                $uploadResult = upload_single_image($_FILES,'web_banner_edited',$uploadpath);
                $image = $uploadResult['data']['file_name'];
                unlink('public/images/'.$this->folder.'web_banners/'.$postData['hidden_image']);
                }else{
                    $image = $postData['hidden_image'];
                }

		    $data['table'] = 'web_banners';
    	  $data['update']['image'] = $image;
        $data['update']['main_title'] = $postData['main_title'];
        $data['update']['sub_title'] = $postData['sub_title'];
    	  $data['update']['dt_updated'] = DATE_TIME;
    	  $data['where']['id'] = $id;
    	  $result = $this->updateRecords($data); 
    		if($result) {
                return ['success', 'Record Edit Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            } 	
    }

    public function removeRecord($id){
    	$path = 'public/images/'.$this->folder.'web_banners';
        $data['table'] = 'web_banners';
        $data['select'] = ['image'];
        $data['where']['id'] = $id;
        $img = $this->selectRecords($data);
        unset($data);
        if(!empty($img)){
            $deletedImage = $img[0]->image;
            $data['table'] = 'web_banners';
            $data['where']['id'] = $id;
            $return =  $this->deleteRecords($data);
            if($return){
                delete_single_image($path,$deletedImage);
               return true; 
            }
        }
    		
    }

    public function aboutSectionTwo(){
        $this->db->select('*');  
        $this->db->from(ABOUT_SECTION_TWO);
        $this->db->where('branch_id',$this->branch_id);
        $query = $this->db->get();  
        return $query->result();  
    }



  ## Multi Delete City ##
    public function multi_delete()
    {

        $id = $_GET['ids'];
        $re = '' ;
        $path = 'public/images/'.$this->folder.'web_banners';
        foreach ($id as $value) {
           $data['table'] = 'web_banners';
           $data['select'] = ['image'];
           $data['where']['id'] = $value;
           $img = $this->selectRecords($data);
           $deletedImage = $img[0]->image;
           unset($data);
           $data['table'] = 'web_banners';
           $data['where']['id'] = $value;
           $data['update'] = ['status'=>'9'];
           $re = $this->deleteRecords($data);
           delete_single_image($path,$deletedImage);
       }
       if($re){
        echo json_encode(['status'=>1]);
    }
        
    }
 

   
}

?>