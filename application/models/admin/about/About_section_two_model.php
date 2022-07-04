<?php 

Class About_section_two_model extends My_model{

  function __construct(){
     // $this->load->model('common_model');
     // $re = $this->common_model->getExistingBranchId();
     // $this->branch_id = $re[0]->id;
     $this->vendor_id = $this->session->userdata('vendor_admin_id');
  }

	public function getAboutSectionTwo(){
     $data['table'] = ABOUT_SECTION_TWO;
		 $data['select'] = ['*'];
		 $data['where'] = ['vendor_id'=>$this->vendor_id];
     return $this->selectRecords($data);
	}

	public function editUpdateSectionTwo($postData) {

        $data['select'] = ['id','image'];
        $data['where'] = ['vendor_id'=>$this->vendor_id];
        $data['table'] = ABOUT_SECTION_TWO;
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
            $data['insert']['sub_title'] = $postData['sub_title'];
            $data['insert']['video_link'] = $postData['video_link'];
            $data['insert']['image'] = $image;
            $data['insert']['created_at'] = DATE_TIME;
            $data['insert']['updated_at'] = DATE_TIME;
            $data['table'] = ABOUT_SECTION_TWO;
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

            $data['update']['main_title'] = $postData['main_title'];
            $data['update']['sub_title'] = $postData['sub_title'];
            $data['update']['video_link'] = $postData['video_link'];
            $data['update']['image'] = $image;
            $data['update']['updated_at'] = DATE_TIME;
            $data['where'] = ['id' => $result[0]->id];
            $data['table'] = ABOUT_SECTION_TWO;
            $result = $this->updateRecords($data);

            if ($result) {
                return ['success', 'Record Edit Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            }
        }

    }

    public function addRecord($postData){
      
    	 if($_FILES['image']['error'] == 0){
                    $image = $_FILES['image']['name'];
                    $image = explode('.',$image);
                    $image = $image[0] . time(). '.' . $image[1];
                    $temp_location = $_FILES['image']['tmp_name'];
                    $uploadpath = 'public/uploads/about/'.$image;
                    move_uploaded_file($temp_location, $uploadpath);
            }
                    $data['table'] = ABOUT_SECTION_TWO;
                    $data['insert']['vendor_id'] = $this->vendor_id;
                    $data['insert']['image'] = $image;
                    $data['insert']['name'] = $postData['name'];
                    $data['insert']['designation'] = $postData['designation'];
                    $data['insert']['content'] = $postData['content'];
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
		  $data['table'] = ABOUT_SECTION_TWO;
    	$data['select'] = ['*'];
      $data['where'] = ['vendor_id'=>$this->vendor_id];
    	$data['order'] = "id DESC";
    	return $this->selectRecords($data);    	
    }

    public function selectSectionTwoEditRecord($id){
		$data['table'] = ABOUT_SECTION_TWO;
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
                $uploadpath = 'public/uploads/about/'.$image;
                move_uploaded_file($temp_location, $uploadpath);
                unlink('public/uploads/about/'.$postData['hidden_image']);
                }else{
                    $image = $postData['hidden_image'];
                }

		$data['table'] = ABOUT_SECTION_TWO;
    	  $data['update']['image'] = $image;
        $data['update']['name'] = $postData['name'];
        $data['update']['designation'] = $postData['designation'];
        $data['update']['content'] = $postData['content'];
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
    	$data['table'] = ABOUT_SECTION_TWO;
    	$data['where']['id'] = $id;
    	return $this->deleteRecords($data);
    		
    }

    public function aboutSectionTwo(){
        $this->db->select('*');  
        $this->db->where('vendor_id',$this->vendor_id);
        $this->db->from(ABOUT_SECTION_TWO);
        $query = $this->db->get();  
        return $query->result();  
    }

     public  $order_column = array(null, "main_title");  
      function make_query($postData)  
      {    
           $this->db->select('*');  
           $this->db->from(ABOUT_SECTION_TWO);
           if(isset($postData["search"]["value"]) && $postData["search"]["value"] !='' )  
           {  $this->db->group_start();
                $this->db->like("main_title", $postData["search"]["value"]); 
                $this->db->or_like("sub_title", $postData["search"]["value"]);
              $this->db->group_end();
           }  
           if(isset($postData["order"]))  
           {  
                $this->db->order_by($this->order_column[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('id', 'DESC');  
           }  
      }  
          function make_datatables($postData){

               $this->make_query($postData);  
               if($postData["length"] != -1)  
               {  
                    $this->db->limit($postData['length'], $postData['start']);  
               }  
               $query = $this->db->get();  
               return $query->result();  
          }  
          function get_filtered_data($postData = false){  
               $this->make_query($postData);  
               $query = $this->db->get();  
               return $query->num_rows();  
          }       
          function get_all_data()  
          {  
               $this->db->select("*");  
               $this->db->where('vendor_id',$this->vendor_id);
               $this->db->from(ABOUT_SECTION_TWO);
               return $this->db->count_all_results();  
          }


  ## Multi Delete City ##
    public function multi_delete()
    {

        $id = $_GET['ids'];
        $re = '' ;
        foreach ($id as $value) {
               $data['table'] = ABOUT_SECTION_TWO;
                $data['where']['id'] = $value;  
               $re = $this->deleteRecords($data);

        }
        if($re){
            echo json_encode(['status'=>1]);
        }
        
    }
 

   
}

?>