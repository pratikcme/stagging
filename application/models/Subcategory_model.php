<?php
class Subcategory_model extends My_model{
    function __construct(){
        $this->branch_id = $this->session->userdata['id'];
    }

    public function getSubcategory(){
        $data['table'] = 'subcategory as b';
        $data['select'] = ['b.*','c.name as category_name'];
        $data['join'] = ['category as c'=>['c.id =b.category_id','LEFT']];
        $data['where'] = ['b.status !='=>'9','b.branch_id'=>$this->branch_id];
        $data['order'] = ' b.id DESC';
        return $this->selectFromJoin($data);
    }

    public function getCategoryList(){
        $data['table'] = 'category';
        $data['select'] = ['*'];
        $data['where'] = ['status!='=>'9','branch_id'=>$this->branch_id];
        $data["order"] = 'name ASC';
        return $this->selectRecords($data);
    }

    public function subcategoryByid($id){
        $data['table'] = 'subcategory';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$id,'branch_id'=>$this->branch_id];
        return $this->selectRecords($data,true);
    }

    public function getcatByid($cat_id){
        $data['table'] = 'category';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$cat_id,'branch_id'=>$this->branch_id];
        return $this->selectRecords($data,true);
    }

    public function updateSubcategory($postData){
        $id = $postData['id'];
         $update = array(
                    'name' => trim($postData['name'][0]),
                    'category_id' => $postData['category_id'],
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
        // print_r($update);exit;
        $data['table'] = 'subcategory';
        $data['update'] = $update;
        $data['where'] = ['id'=>$id];
        return $this->updateRecords($data);
    }

    public function insertSubcategory($postData){
        $name = $postData['name'];
          foreach ($name as $key => $value){
                    if($value == ""){
                        continue;
                    }
                    $Insertdata = array(
                    'branch_id' => $this->branch_id,
                    'name' => trim($value),
                    'category_id' => $postData['category_id'],
                    'status' => '1',
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                     );
                    $data['table'] = 'subcategory';
                    $data['insert'] = $Insertdata;
                   $re = $this->insertRecord($data);
                }
                return $re;
    }

    # subCategory Single Delete ##

 public function check_subcategory(){
         $id = $_GET['id'];
        $this->db->select('*');
        $this->db->where('subcategory_id', $id);
        $this->db->where('status !=','9');
        $this->db->from('product');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            ob_get_clean();
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode(['status'=>2]);
            exit;
        }
        echo json_encode(['status'=>1]);
        exit;
 }


 public function get_valid_subcate($postData){
   

     $name = $postData['name'];
     
     $data['select'] = ['name'];
     $data['table'] = "subcategory";
     $data['where']['name'] = $name;
     $data['where']['status !='] = '9';
     $data['where']['branch_id'] = $this->branch_id;
     if($postData['subcatId'] != ''){
        $data['where']['id !='] = $postData['subcatId'];
     }
     if($postData['catId'] != ''){
        $data['where']['category_id'] = $postData['catId'];
     }

     $result = $this->selectRecords($data);
     // echo $this->db->last_query();die;
    // print_r($result);die;
 
      
         if (!empty($result)) {
             echo 1; exit;
         }
     
     echo 0;exit;
 }
    public function deleteSubcategory($getData){
        $id = $getData['id'];
        $update = array( 
            'status' => '9',
            'dt_updated' => strtotime(date('Y-m-d H:i:s'))
        );
        $data['table'] = 'subcategory';
        $data['update'] = $update;
        $data['where'] = ['id'=>$id];
        $this->updateRecords($data);

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    ## subCategory Multi Delete ##
    public function multi_delete_subCategory()
    {
        $id = $_GET['ids'];
        $id = explode(",", $id);
        foreach ($id as $key => $value) {
            $this->db->select('*');
            $this->db->where('subcategory_id', $value);
            $this->db->where('status !=','9');
            $this->db->from('product');
            $query = $this->db->get();
            // echo $this->db->last_query();
            $this->db->select('name');
            $this->db->where('id =',$value);
            $this->db->from('subcategory');
            $rows = $this->db->get();
            $row1 = $rows->row_array();


            if ( $query->num_rows() > 0 )
            {
                $row = $query->row_array();
                ob_get_clean();
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');


                $response = array('status'=>2,'names'=>$row1['name']);
                 echo json_encode($response);
                // echo json_encode(['status'=>2]);  
                exit;
            }
        }
         echo json_encode(['status'=>1]);
         exit;
    }


    public function multi_deleted_subCategory($gatData)
    {   
        // print_r($getData);die;
        $id = $gatData['ids'];
        $id = explode(",", $id);
        $date = strtotime(date('Y-m-d H:i:s'));
        foreach ($id as $key => $value) {
            $data['table'] = 'subcategory';
            $data['update']['status'] = '9';
            $data['update']['dt_updated'] = $date;
            $data['where'] = ['id'=>$value];
            $this->updateRecords($data);

            // $this->db->query("UPDATE subcategory SET status = '9', dt_updated = '$date' WHERE id IN ($value)");
        }
        echo json_encode(['status'=>1]);
        exit;
    }


public  $order_column_subcategory = array("b.name","c.name as category_name"); 

    function make_query_subcategory($postData){
        $where = [
            'b.branch_id'=>$this->branch_id,
            'b.status !='=>'9',  
        ];
         $this->db->select('b.*,c.name as category_name');  
         $this->db->from('subcategory as b');
         $this->db->join('category as c','c.id =b.category_id','LEFT');

         $this->db->where($where);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
        $this->db->group_start();
            $this->db->like("b.name", $postData["search"]["value"]);
            $this->db->or_like("c.name", $postData["search"]["value"]);
        $this->db->group_end(); 
        }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_subcategory[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('b.id', 'DESC');  
           } 
    }


    function make_datatables_subcategory($postData){ 
        $this->make_query_subcategory($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            // echo $this->db->last_query();
        }

    function get_filtered_data_subcategory($postData = false){  
        $this->make_query_subcategory($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }    

    function get_all_data_subcategory(){
       $where = [
            'b.branch_id'=>$this->branch_id,
            'b.status !='=>'9',  
        ];
         $this->db->select('b.*','c.name as category_name');  
         $this->db->from('subcategory as b');
         $this->db->join('category as c','c.id =b.category_id','LEFT');
        $this->db->where($where);
        return $this->db->count_all_results();   
    }

}
?>