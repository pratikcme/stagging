<?php 

Class Offer_model extends My_model{

    function __construct(){
     $this->vendor_id = $this->session->userdata('vendor_admin_id');
    }


    public function getOffer($id = ''){
        if($id != ''){
            $data['where']['of.id'] = $id;
        }
        $data['table'] = TABLE_OFFER.' as of';
        $data['select'] = ['of.*','b.name as branch_name'];
        $data['join'] = ['branch as b'=>['b.id = of.branch_id','LEFT']];
        $data['where']['b.vendor_id'] = $this->vendor_id;
        $data['order'] = 'id desc';
        return $this->selectFromJoin($data);        
    }

    public function getOfferAndOfferDetails($offer_id = ''){
        $data['table'] = TABLE_OFFER.' as f';
        $data['select'] = ['ofd.product_varient_id'];
        $data['join'] = [TABLE_OFFER_DETAIL .' as ofd'=>['f.id = ofd.offer_id','LEFT']];
        $data['where']['ofd.offer_id'] = $offer_id;
        return $this->selectFromJoin($data);        
    }


    public function getOffer_detail($varient_id){
        $data['table'] = TABLE_OFFER_DETAIL .' as of';
        $data['select'] = ['of.id','pw.weight_no','pkg.package','pw.price','pw.discount_per', 'p.name as product_name',' w.name as weight_name'];
        $data['join']  = [
            TABLE_PRODUCT_WEIGHT .' as pw'=>['pw.id=of.product_varient_id','LEFT'],
            TABLE_PRODUCT.' as p'=>['p.id=pw.product_id','LEFT'],
            'package as pkg'=>['pw.package=pkg.id','LEFT'],
            TABLE_WEIGHT .' as w' =>['pw.weight_id=w.id','LEFT']
        ];
        $data['where'] = ['of.offer_id'=>$varient_id];
        return $this->selectFromJoin($data);
    }


  ## Add Update ##
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
            'offer_title' => $postData['offer_title'],
            'offer_percent' => $postData['offer_percent'],
            'offer_percent' => ($postData['offer_percent'] && $postData['offer_percent'] != '') ? : NULL,
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


    public function updateRecord($postData){
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
            delete_single_image($uploadpath,$postData['hidden_image']);
        }else{
            $offer_image = $postData['hidden_image'];
        }

        $update = array(
            'branch_id' => $postData['branch_id'],
            'image' => $offer_image,
            'offer_title' => $postData['offer_title'],
            'offer_percent' => $postData['offer_percent'],
            'dt_created' => DATE_TIME,
            'dt_updated' => DATE_TIME
        );
        $data['table'] = TABLE_OFFER;
        $data['where'] = ['id'=>$postData['edit_id']];
        $data['update'] = $update;
        $this->updateRecords($data);

        unset($data);

        $data['table'] = TABLE_OFFER_DETAIL;
        $data['where'] = ['offer_id'=>$postData['edit_id']];
        $isDelete = $this->deleteRecords($data);
        unset($data);
        if($isDelete){
            foreach ($varient_ids as $key => $id) {
            $offer_details = array(
                'offer_id' => $postData['edit_id'],
                'product_varient_id' => $id,
                'dt_created' => DATE_TIME,
                'dt_updated' => DATE_TIME
            );
                $data['table'] = TABLE_OFFER_DETAIL;
                $data['insert'] = $offer_details;
                $this->insertRecord($data);
            }
        }
        $this->session->set_flashdata('msg', 'Offer have been update successfully.');
        redirect(base_url().'offer'); 

        
    }

    public function removeRecord($id){
    	$path1 = 'public/images/'.$this->folder.'offer_image';

        $data['table'] = TABLE_OFFER;
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


  ## Multi Delete City ##
    public function multi_delete()
    {
        $id = $_GET['ids'];
        $re = '' ;
        $path1 = 'public/images/'.$this->folder.'offer_image';
        foreach ($id as $value) {
           $data['table'] = TABLE_OFFER;
           $data['select'] = ['image'];
           $data['where']['id'] = $value;
           $img = $this->selectRecords($data);
           $Image = $img[0]->image;
           unset($data);
           $data['table'] = TABLE_OFFER;
           $data['where']['id'] = $value;
           $data['update'] = ['status'=>'9'];
           $re = $this->deleteRecords($data);
           delete_single_image($path1,$Image);
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