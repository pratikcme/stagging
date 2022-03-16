<?php
class City_model extends My_model{ 

    function __construct(){
       $this->load->model('common_model');
       $re = $this->common_model->getExistingBranchId();
       $this->branch_id = $re[0]->id;
       $this->vendor_id = $this->session->userdata('vendor_admin_id');
    }

    public function city_add_update($postData){
            $name = $postData['name'];
            $id = $postData['id'];
            /* City Update */
            if ($id != '') {

                $up = array(
                    'name' => $name,
                    'vendor_id' =>$this->vendor_id,
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $data['table'] = 'city';
                $data['update'] = $up;
                $data['where'] = ['id'=>$id];
                return $this->updateRecords($data);
            }
            /* City Add */
            else {
                $insert = array(
                    'name' => $name,
                    'vendor_id' => $this->vendor_id,
                    'status' => '1',
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                // print_r($insert);die;
                $data['table'] = 'city';
                $data['insert'] = $insert; 
                return $this->insertRecord($data); 
            }
    }

    # Single Delete City ##
    public function single_delete_city($getData)
    {
        $id = $getData['id'];
        $up = array( 'status' => '9','dt_updated' => strtotime(date('Y-m-d H:i:s')));
        $data['table'] = 'city';
        $data['where'] = ['id'=>$id];
        $data['update'] = $up;
        $this->updateRecords($data);
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    ## Multi Delete City ##
    public function multi_delete_city($getData)
    {
        $id = $getData['ids'];
        $date = strtotime(date('Y-m-d H:i:s'));
        $this->db->query("UPDATE city SET status = '9', dt_updated = '$date' WHERE id IN ($id)");

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    public function GetCity(){
        $data['table'] = 'city';
        $data['select'] = ['*'];
        $data['where'] = ['vendor_id'=>$this->vendor_id,'status!='=>'9'];
        $data['order'] = 'id desc';
        return $this->selectRecords($data);
    }

    public function getCityById($id){
        $data['table'] = 'city';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$id,'vendor_id'=>$this->vendor_id,'status!='=> '9'];
        $result = $this->selectRecords($data,true);
        return $result[0];
    }


    public  $order_column_city = array("name"); 
    function make_query_city($postData){
         $this->db->select('*');  
         $this->db->from('city');
         $this->db->where(['vendor_id'=>$this->vendor_id,'status!='=>'9']);
         if(isset($postData["search"]["value"]))  
           {  
                $this->db->like("name", $postData["search"]["value"]); 
           }  
           if(isset($postData["order"]))  
           {  
                $this->db->order_by($this->order_column_city[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('id', 'DESC');  
           } 
    }


    function make_datatables_city($postData){ 
        $this->make_query_city($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
        }

    function get_filtered_data_city($postData = false){  
        $this->make_query_city($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }       
    
    function get_all_data_city(){
        $this->db->select("*");  
        $this->db->from('city');
        $this->db->where(['vendor_id'=>$this->vendor_id,'status!='=>'9']);
        return $this->db->count_all_results();   
        }

}
?>