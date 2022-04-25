<?php 

Class Banners_model extends My_model{

    function __construct(){
     $this->vendor_id = $this->session->userdata('vendor_admin_id');
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

    public function getBanners(){
        $data['table'] = TABLE_BANNERS;
        $data['select'] = ['*'];
        $data['where'] = ['vendor_id'=>$this->vendor_id];
        return $this->selectRecords($data);        
    }


  ## Banner Promotion Add Update ##
    public function addRecord($postData){
        if($_FILES['web_banner_image']['error'] == 0){
            ## Image Upload ##
            $this->load->library('upload');
            $uploadpath = 'public/images/'.$this->folder.'web_banners/';
            $uploadResult = upload_single_image_Byname($_FILES,'web_banner_image',$uploadpath);
            $web_banner_image = $uploadResult['data']['file_name'];
        }else{
            $web_banner_image = $postData['hidden_web_banner_image'];
        }

        if($_FILES['app_banner_image']['error'] == 0){
            ## Image Upload ##
            $this->load->library('upload');
            $uploadpath = 'public/images/'.$this->folder.'banner_promotion/';
            $uploadResult = upload_single_image_Byname($_FILES,'app_banner_image',$uploadpath);
            $app_banner_image = $uploadResult['data']['file_name'];
        }else{
            $app_banner_image = $postData['hidden_app_banner_image'];
        }

        $data = array(
            'vendor_id'=>$this->vendor_id,
            'branch_id' => $postData['branch'],
            'category_id' => (isset($postData['category_id']) ? $postData['category_id'] : ''),
            'product_id' => (isset($postData['product_id']) ? $postData['product_id'] : ''),
            'product_varient_id' => (isset($postData['product_varient_id']) ? $postData['product_varient_id'] : ''),
            'main_title'=>$postData['main_title'],
            'sub_title'=>$postData['sub_title'],
            'type' => $postData['type'],
            'app_banner_image' => $app_banner_image,
            'web_banner_image' => $web_banner_image,
            'dt_created' => DATE_TIME,
            'dt_updated' => DATE_TIME
        );
        $this->db->insert('banners',$data);
        $this->session->set_flashdata('msg', 'Banner have been added successfully.');
        redirect(base_url().'banners');
}


    public function getSectionTwo(){
		  $data['table'] = ABOUT_SECTION_TWO;
    	$data['select'] = ['*'];
      $data['where'] = ['vendor_id'=>$this->vendor_id];
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
        $this->db->where('vendor_id',$this->vendor_id);
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
 
    public function getBranch(){
        $data['table'] = TABLE_BRANCH;
        $data['select'] = ['*'];
        $data['where'] = ['domain_name'=>base_url(),'status'=>'1'];
        return  $this->selectRecords($data);
    }

    public function get_category_list($postData){
        $branch_id = $postData['branch_id'];
        $data['table'] = TABLE_CATEGORY;
        $data['select'] = ['*'];
        $data['where'] = ['branch_id'=>$branch_id];
        return $this->selectRecords($data);
    }

    public function get_product_list($postData){
        $branch_id = $postData['branch_id'];
        $data['table'] = TABLE_PRODUCT;
        $data['select'] = ['*'];
        $data['where'] = ['branch_id'=>$branch_id];
        return $this->selectRecords($data);
    }

    public function getproductVarient($postData){
        $product_id = $postData['product_id'];
        $data['table'] = TABLE_PRODUCT_WEIGHT .' as pw';
        $data['join'] = ['package as pkg'=>['pw.package=pkg.id','LEFT'],TABLE_WEIGHT .' as w' =>['pw.weight_id=w.id','LEFT']];
        $data['select'] = ['pw.id','pw.weight_no','w.name','pkg.package'];
        $data['where'] = ['pw.product_id'=>$product_id];
        return $this->selectFromJoin($data);
    }
   
}

?>