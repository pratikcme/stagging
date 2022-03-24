<?php
class Brand_model extends My_model{    
    function __construct(){
        $this->branch_id = $this->session->userdata['id'];
    }

    public function getBrandList(){
        $data['table'] = 'brand';
        $data['select'] = ['*'];
        $data['where'] = ['status!='=>'9','branch_id'=>$this->branch_id];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data); 
    }

    public function getAllCetegory(){
        $data['table'] = 'category';
        $data['select'] = ['*'];
        $data['where'] = ['status!='=>'9','branch_id'=>$this->branch_id];
        return $this->selectRecords($data); 
    }

    public function getBrandByid($id){
        $data['table'] = 'brand';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$id,'branch_id'=>$this->branch_id];
        $result = $this->selectRecords($data,true);
        return $result[0]; 
    }

    public function checkIsBrandAvailable($postData){
        $brand_name =  trim($postData['name']);
        $id =  $postData['id'];
        if($id != ''){
            $data['where']['id !='] = $id;    
        }

        $data['table'] = TABLE_BRAND;
        $data['where']['name'] = $brand_name;
        $data['where']['branch_id'] = $this->branch_id;
        $data['where']['status!='] = '9';
        $data['select'] = ['name'];
        $res = $this->selectRecords($data);
       
        if(!empty($res)){
            return 'false';
        }else{
            return 'true';
        }
    }

    public function cat_query($cat_array){
        
        $data['table'] = 'category';
        $data['select'] = ['*'];
        $data['where'] = ['branch_id'=>$this->branch_id];
        $data['where_in'] = ['id'=>$cat_array];
        $result = $this->selectRecords($data);
        return $result;
      
    }

    public function InsertBrand($postData){
            $category_id = $postData['category_id'];
            $cate_id = implode(",",$category_id);
           $insert = array(
                'branch_id' => $this->branch_id,
                'name' => trim($postData['name']),
                'category_id' => $cate_id,
                'status' => '1',
                'dt_added' => strtotime(date('Y-m-d H:i:s')),
                'dt_updated' => strtotime(date('Y-m-d H:i:s')),
            );
            $data['table'] = 'brand';
            $data['insert'] = $insert;       
            $this->insertRecord($data);     
    }

    public function updateBrandData($postData){
        $category_id = $postData['category_id'];
        $cate_id = implode(",",$category_id);
        $update = array(
                'name' => trim($postData['name']),
                'category_id' => $cate_id,
                'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
        $data['table'] = 'brand';
        $data['where'] = ['id'=>$postData['id'],
                        'branch_id'=>$this->branch_id ];
        $data['update'] = $update;
        return $this->updateRecords($data);
    }

    public function check_brand($getData){
        $id = $getData['id'];
        $data['table'] = 'product';
        $data['select'] = ['*'];
        $data['where'] = ['status !=' => '9','brand_id'=>$id];
        $result = $this->selectRecords($data,true);
        $count = $this->countRecords($data);
        if ($count > 0 ){
            $row = $result[0];
            ob_get_clean();
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode(['status'=>2]);  
            exit;
            }
         echo json_encode(['status'=>1]);
         exit;
    }

    # Brand Single Delete ##
    public function single_delete_brand($getData){
        $id = $getData['id'];
        $update = array( 
            'status' => '9',
            'dt_updated' => strtotime(date('Y-m-d H:i:s'))
        );
        $data['table'] = 'brand';
        $data['where'] = ['id'=>$id];
        $data['update'] = $update;
        $this->updateRecords($data);

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
        
    }

    ## Brand Multi Delete ##
    public function multi_delete_brand($getData)
    {
        $id = $getData['ids'];
        $id = explode(",", $id);
        foreach ($id as $key => $value) {
            $data['table'] = 'product';
            $data['select'] = ['*'];
            $data['where'] = ['status !='=>'9','brand_id'=>$value];
            $result =$this->selectRecords($data,true);
            $count = $this->countRecords($data);

            
            unset($data);

            $data['table'] = 'brand';
            $data['select'] = ['name'];
            $data['where'] = ['id'=>$value];
            $rows =$this->selectRecords($data,true);
            $row1 = $rows[0];
           
            if ($count > 0){
                $row = $result[0];
                ob_get_clean();
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');
                $response = array('status'=>2,'names'=>$row1['name']);
                echo json_encode($response); 
                exit;
            }
        }
        echo json_encode(['status'=>1]); 
        exit;
    }

     public function multi_deleted_brand($getData){
        $id = $getData['ids'];
        $id = explode(",", $id);
        $date = strtotime(date('Y-m-d H:i:s'));
        foreach ($id as $key => $value) {
            $data['table'] = 'brand';
            $data['update']['status'] = '9'; 
            $data['update']['dt_updated'] = $date;
            $data['where'] = ['id'=>$value]; 
            $this->updateRecords($data);
        }
        echo json_encode(['status'=>1]);
        exit;

    }

   public  $order_column_brand = array("name","category_id"); 
    function make_query_brand($postData){
        $where = [
            'branch_id'=>$this->branch_id,
            'status !='=>'9',  
        ];
         $this->db->select('*');  
         $this->db->from('brand');
         $this->db->where($where);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){
        $this->db->group_start();
            $this->db->like("name", $postData["search"]["value"]);
            $this->db->or_like("category_id", $postData["search"]["value"]);
        $this->db->group_end();       
        }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_brand[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('id', 'DESC');  
           } 
    }


    function make_datatables_brand($postData){ 
        $this->make_query_brand($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            $return =  $query->result();
            // print_r($return);die;
            foreach ($return as $key => $value) {
                $cat_ids = explode(',',$value->category_id);
                $return[$key]->category = $this->catName($cat_ids);
            }
            return $return; 
            // echo $this->db->last_query();
        }

    function get_filtered_data_brand($postData = false){  
        $this->make_query_brand($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }    

    function get_all_data_brand(){
       $where = [
            'branch_id'=> $this->branch_id,
            'status !='=>'9',  
        ];
        $this->db->select("*");  
        $this->db->from('brand');
        $this->db->where($where);
        return $this->db->count_all_results();   
    }

    public function catName($cate_ids){
        $catname = '';
        foreach ($cate_ids as $key => $value) {
            $cat_qu = $this->db->query("SELECT name as category_name FROM category WHERE id IN ('$value')");
            $cat_result = $cat_qu->result();
            $catname .= $cat_result[0]->category_name.',';
        }
        return $catname = rtrim($catname," , ");

    }  

}
?>