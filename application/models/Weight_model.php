<?php
class weight_model extends My_model{

    function __construct(){
        $this->load->model('common_model');
        $re = $this->common_model->getExistingBranchId();
        $this->branch_id = $re[0]->id;
        $this->vendor_id = $this->session->userdata('vendor_admin_id');
    }

     public function Weight_add_update($postData){

        $id = $postData['id'];
        $name = $postData['name'];

        if(isset($postData['submit'])) {

            /* Weight Update */
            if ($id != '') {

                $update = array(
                    'name' => $name,
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $data['table'] = 'weight';
                $data['where'] = ['id'=>$id];
                $data['update'] = $update;
                $this->updateRecords($data);
                $this->session->set_flashdata('msg', 'Unit has been updated successfully');
                redirect(base_url() . 'weight/weight_list');
                exit();
            }
            /* Weight Add */
            else {

                $insert = array(
                    'name' => $name,
                    'status' => '1',
                    'vendor_id' => $this->vendor_id,
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $data['table'] = 'weight'; 
                $data['insert'] = $insert;
                $this->insertRecord($data);
                $this->session->set_flashdata('msg', 'Unit has been added successfully');
                redirect(base_url() . 'weight/weight_list');
                exit();
            }
        }
    }

    # Weight Single Delete ##
    public function single_delete_weight($getData)
    {
        $id = $getData['id'];
        $up = array( 'status' => '9','dt_updated' => strtotime(date('Y-m-d H:i:s')));
        $data['table'] = 'weight';
        $data['where'] = ['id'=>$id];
        $data['update'] = $up;
        $this->updateRecords($data);
        
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    ## Weight Multi Delete ##
    public function multi_delete_weight()
    {
        $id = $_GET['ids'];
        $date = strtotime(date('Y-m-d H:i:s'));

        $this->db->query("UPDATE weight SET status = '9', dt_updated = '$date' WHERE id IN ($id)");

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    public function getWeightlist(){

        $data['table'] = 'weight';
        $data['select'] = ['*'];
        $data['where'] = ['status!='=>'9','vendor_id'=>$this->vendor_id];
        $data['order'] = 'id desc';
        return $this->selectRecords($data);
        // echo $this->db->last_query();die;
    }

    public function getDataById($id){
        $data['table'] = 'weight';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$id];
        $return =  $this->selectRecords($data,true);
        return $return[0];
        // echo $this->db->last_query();die;
    }

    public  $order_column_weight = array("start","end"); 
   
    function make_query_weight($postData){
        $where = [
            'vendor_id'=> $this->vendor_id,
            'status !='=>'9',  
        ];
         $this->db->select('*');  
         $this->db->from('weight');
         $this->db->where($where);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
          $this->db->group_start();
            $this->db->like("name", $postData["search"]["value"]); 
            $this->db->group_end(); 
            }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_weight[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('id', 'DESC');  
           } 
    }


    function make_datatables_weight($postData){ 
        $this->make_query_weight($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            echo $this->db->last_query();
        }

    function get_filtered_data_weight($postData = false){  
        $this->make_query_weight($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }       
    
    function get_all_data_weight(){
       $where = [
            'vendor_id'=> $this->vendor_id,
            'status !='=>'9',  
        ];
        $this->db->select("*");  
        $this->db->from('weight');
        $this->db->where($where);
        return $this->db->count_all_results();   
        }
    
}
?>