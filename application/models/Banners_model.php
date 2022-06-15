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

    public function getBanners($id = ''){
        if($id != ''){
            $data['where']['id'] = $id;
        }
        $data['table'] = TABLE_BANNERS;
        $data['select'] = ['*'];
        $data['where']['vendor_id'] = $this->vendor_id;
        $data['order'] = 'id desc';
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

    public function updateRecord($postData){
        $id = $postData['update_id'];
        if($_FILES['web_banner_image']['error'] == 0){
            ## Image Upload ##
            $this->load->library('upload');
            $uploadpath = 'public/images/'.$this->folder.'web_banners/';
            $uploadResult = upload_single_image_Byname($_FILES,'web_banner_image',$uploadpath);
            $web_banner_image = $uploadResult['data']['file_name'];
            delete_single_image($uploadpath,$postData['hidden_web_banner_image']);
        }else{
            $web_banner_image = $postData['hidden_web_banner_image'];
        }


        if($_FILES['app_banner_image']['error'] == 0){
            ## Image Upload ##
            $this->load->library('upload');
            $uploadpath = 'public/images/'.$this->folder.'banner_promotion/';
            $uploadResult = upload_single_image_Byname($_FILES,'app_banner_image',$uploadpath);
            $app_banner_image = $uploadResult['data']['file_name'];
            delete_single_image($uploadpath,$postData['hidden_app_banner_image']);
        }else{
            $app_banner_image = $postData['hidden_app_banner_image'];
        }

        if($web_banner_image == '' || $app_banner_image == ''){
            return ['danger', 'Image not uploaded'];
        }

		$data['table'] = 'banners';
         $updateData = array(
            'branch_id' => $postData['branch'],
            'category_id' => (isset($postData['category_id']) && $postData['category_id'] != '' ) ? $postData['category_id'] : '',
            'product_id' => (isset($postData['product_id']) && $postData['product_id'] != '') ? $postData['product_id'] : '',
            'product_varient_id' => (isset($postData['product_varient_id']) ? $postData['product_varient_id'] : ''),
            'main_title'=>$postData['main_title'],
            'sub_title'=>$postData['sub_title'],
            'type' => $postData['type'],
            'app_banner_image' => $app_banner_image,
            'web_banner_image' => $web_banner_image,
            'dt_updated' => DATE_TIME
        );
        // dd($updateData);
        $data['update'] = $updateData;
    	$data['where']['id'] = $id;
    	$result = $this->updateRecords($data); 
    	   if($result) {
                return ['success', 'Record Edit Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            } 	
    }

    public function removeRecord($id){
    	$path1 = 'public/images/'.$this->folder.'web_banners';
        $path2 = 'public/images/'.$this->folder.'banner_promotion';
        
        $data['table'] = 'banners';
        $data['select'] = ['web_banner_image','app_banner_image'];
        $data['where']['id'] = $id;
        $img = $this->selectRecords($data);
        unset($data);
        if(!empty($img)){
            $webBanner = $img[0]->web_banner_image;
            $appBanner = $img[0]->app_banner_image;
            $data['table'] = 'banners';
            $data['where']['id'] = $id;
            $return =  $this->deleteRecords($data);
            if($return){
                delete_single_image($path1,$webBanner);
                delete_single_image($path2,$appBanner);
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
        $path1 = 'public/images/'.$this->folder.'web_banners';
        $path2 = 'public/images/'.$this->folder.'banner_promotion';
        foreach ($id as $value) {
           $data['table'] = 'banners';
           $data['select'] = ['web_banner_image','app_banner_image'];
           $data['where']['id'] = $value;
           $img = $this->selectRecords($data);
           $webImage = $img[0]->web_banner_image;
           $appImage = $img[0]->app_banner_image;
           unset($data);
           $data['table'] = 'banners';
           $data['where']['id'] = $value;
           $data['update'] = ['status'=>'9'];
           $re = $this->deleteRecords($data);
           delete_single_image($path1,$webImage);
           delete_single_image($path2,$appImage);
       }
       if($re){
        echo json_encode(['status'=>1]);
    }
        
    }
 
    public function getBranch(){
        $data['table'] = 'branch';
        $data['select'] = ['*'];
        $data['where'] = ['vendor_id'=>$this->vendor_id,'status'=>'1'];
        return  $this->selectRecords($data);
    }

    public function get_category_list($postData=[],$branch_id=''){
         
        if($branch_id == ''){
            $branch_id = $postData['branch_id'];
        }

        $data['table'] = TABLE_CATEGORY;
        $data['select'] = ['*'];
        $data['where'] = ['branch_id'=>$branch_id,'status!='=>'9'];
        return $this->selectRecords($data);
    }

    public function get_product_list($postData = [],$branch_id=''){
        if($branch_id == ''){
            $branch_id = $postData['branch_id'];
        }
        $data['table'] = TABLE_PRODUCT;
        $data['select'] = ['*'];
        $data['where'] = ['branch_id'=>$branch_id,'status!='=>'9'];
        return $this->selectRecords($data);
    }

    public function getproductVarient($postData=[],$product_id =''){
        
        if($product_id == ''){
            $product_id = $postData['product_id'];
        }

        $data['table'] = TABLE_PRODUCT_WEIGHT .' as pw';
        $data['join'] = [
            'package as pkg'=>['pw.package=pkg.id','LEFT'],
            TABLE_WEIGHT .' as w' =>['pw.weight_id=w.id','LEFT']
        ];
        $data['select'] = ['pw.id','pw.weight_no','w.name','pkg.package','pw.product_id'];
        $data['where'] = ['pw.product_id'=>$product_id,'pw.status!='=>'9'];
        return $this->selectFromJoin($data);
    }
   
}

?>