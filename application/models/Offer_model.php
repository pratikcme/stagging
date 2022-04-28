<?php 

Class Offer_model extends My_model{

    function __construct(){
     $this->vendor_id = $this->session->userdata('vendor_admin_id');
    }


    public function getOffer($id = ''){
        if($id != ''){
            $data['where']['id'] = $id;
        }
        $data['table'] = TABLE_OFFER.' as of';
        $data['select'] = ['of.*','b.name as branch_name'];
        $data['join'] = [TABLE_BRANCH .' as b'=>['b.id = of.branch_id','LEFT']];
        $data['where']['b.vendor_id'] = $this->vendor_id;
        $data['order'] = 'id desc';
        return $this->selectFromJoin($data);        
    }


  ## Banner Promotion Add Update ##
    public function addRecord($postData){
         $varient_ids = explode(',',$postData['hidden_varient_id']);
        if($_FILES['offer_image']['error'] == 0){
            ## Image Upload ##

            if (!file_exists('public/images/'.$this->folder.'offer_image')) {
                mkdir('public/images/'.$this->folder.'offer_image', 0777, true);
            }
            $this->load->library('upload');
            $uploadpath = 'public/images/'.$this->folder.'offer_image/';
            $uploadResult = upload_single_image($_FILES,'offer',$uploadpath);
            $offer_image = $uploadResult['data']['file_name'];
        }

        $insert = array(
            'branch_id' => $postData['branch_id'],
            'image' => $offer_image,
            'dt_created' => DATE_TIME,
            'dt_updated' => DATE_TIME
        );
        $data['table'] = TABLE_OFFER;
        $data['insert'] = $insert;
        $offer_id = $this->insertRecord($data);
        unset($data);
        if($offer_id){
            foreach ($varient_ids as $key => $id) {
            $offer_details = array(
                'offer_id' => $offer_id,
                'product_varient_id' => $id,
                'dt_created' => DATE_TIME,
                'dt_updated' => DATE_TIME
            );
                $data['table'] = TABLE_OFFER_DETAIL;
                $data['insert'] = $offer_details;
                $this->insertRecord($data);
            }
        }
        $this->session->set_flashdata('msg', 'Offer have been added successfully.');
        redirect(base_url().'offer');
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
    	$path1 = 'public/images/'.$this->folder.'offer_image';
        
        $data['table'] = 'offer_image';
        $data['select'] = ['image'];
        $data['where']['id'] = $id;
        $img = $this->selectRecords($data);
        unset($data);
        if(!empty($img)){
            $offer_image = $img[0]->image;
            $data['table'] = TABLE_OFFER;
            $data['where']['id'] = $id;
            $return =  $this->deleteRecords($data);
            if($return){
                delete_single_image($path1,$offer_image);
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
        $data['table'] = TABLE_BRANCH;
        $data['select'] = ['*'];
        $data['where'] = ['domain_name'=>base_url(),'status'=>'1'];
        return  $this->selectRecords($data);
    }



    public function getproductVarient($branch_id = ''){
        
        if($branch_id != ''){
        	$data['where']['p.branch_id'] = $branch_id;
        }

        $data['table'] = TABLE_PRODUCT_WEIGHT .' as pw';
        $data['join'] = [
        	TABLE_PRODUCT.' as p'=>['p.id=pw.product_id','LEFT'],
            'package as pkg'=>['pw.package=pkg.id','LEFT'],
            TABLE_WEIGHT .' as w' =>['pw.weight_id=w.id','LEFT']
        ];
        $data['select'] = ['pw.*','pw.weight_no','w.name as weight_name','p.name as product_name','pkg.package','pw.discount_per'];
        $data['where']['pw.status!='] = '9';
        return $this->selectFromJoin($data);
    }


public  $order_column_offer_product = array("p.product_name","pw.quantity","pw.discount_price","pw.price","pw.discount_per",'pw.weight_no');  
    function make_query_offer_product($postData){
        // dd($postData);
        $branch_id = $postData['branch_id'];
        $where = [
            'p.branch_id'=>$branch_id,
            'p.status !='=>'9',
        ];
        $this->db->select('pw.*,pk.package,pw.discount_per, p.name as product_name, w.name as weight_name');  
        $this->db->from('product_weight as pw');
        $this->db->join('package as pk','pk.id = pw.package','left');
        $this->db->join('product as p','p.id = pw.product_id','left');
        $this->db->join('weight as w','w.id = pw.weight_id','left');
        $this->db->where($where);
        if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
        $this->db->group_start();
            $this->db->like("p.name", $postData["search"]["value"]);
            $this->db->or_like("pw.quantity", $postData["search"]["value"]);
            $this->db->or_like("pw.discount_price", $postData["search"]["value"]);
            $this->db->or_like("pw.price", $postData["search"]["value"]);
            $this->db->or_like("pw.discount_per", $postData["search"]["value"]);
            $this->db->or_like("pw.weight_no", $postData["search"]["value"]);
            $this->db->or_like("pk.package", $postData["search"]["value"]);
            $this->db->or_like("w.name", $postData["search"]["value"]);
        $this->db->group_end(); 
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_offer_product[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('pw.id', 'DESC');  
           } 
    }   
}


    function make_datatables_offer_product($postData){ 
        $this->make_query_offer_product($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            // echo $this->db->last_query();
        }

    function get_filtered_data_offer_product($postData = false){  
        $this->make_query_offer_product($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }    

    function get_all_data_offer_product($postData = array()){
        $branch_id = $postData['branch_id'];
        $where = [
            'p.branch_id'=>$branch_id,
            'p.status !='=>'9',
        ];
        $this->db->select('pw.*,pk.package,pw.discount_per, p.name as product_name, w.name as weight_name');  
        $this->db->from('product_weight as pw');
        $this->db->join('package as pk','pk.id = pw.package','left');
        $this->db->join('product as p','p.id = pw.product_id','left');
        $this->db->join('weight as w','w.id = pw.weight_id','left');
        $this->db->where($where);
        return $this->db->count_all_results(); 
           // echo $this->db->last_query();
    }   
}

?>