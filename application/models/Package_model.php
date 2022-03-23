<?php
class Package_model extends My_model{

    function __construct(){
        $this->load->model('common_model');
        $re = $this->common_model->getExistingBranchId();
        $this->branch_id = $re[0]->id;
        $this->vendor_id = $this->session->userdata('vendor_admin_id');
    }

     public function package_add_update($postData){

        $id = $postData['id'];
        $package = $postData['package'];
        if(isset($postData['submit'])) {
            /* package Update */
            if ($id != '') {
                $up = array(
                    'package' => $package,
                    'dt_updated' => date('Y-m-d H:i:s'),
                );
                $data['table'] = 'package';
                $data['where'] = ['id'=>$id];
                $data['update'] = $up;
                return $this->updateRecords($data);
            }
            /* package Add */
            else {

                $insert = array(
                    'package' => $package,
                    'vendor_id'=>$this->vendor_id,                 
                    'dt_created' => date('Y-m-d H:i:s'),
                    'dt_updated' => date('Y-m-d H:i:s'),
                );
                $data['table'] = 'package';
                $data['insert'] = $insert;
                return $this->insertRecord($data); 
            }
        }
    }

    # package Single Delete ##
    public function single_delete_package()
    {
        $id = $_GET['id'];
       
        $data['table'] = 'package';
        $data['where'] = ['id'=>$id];
        $this->deleteRecords($data);
        $this->session->set_flashdata('msg', 'Package has been Deleted successfully');
          
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    ## package Multi Delete ##
    public function multi_delete_package()
    {
        $id = $_GET['ids'];
        $date = strtotime(date('Y-m-d H:i:s'));

        $this->db->query("DELETE FROM package WHERE id IN ($id)");

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    public function getPakage(){
        $data['table'] = 'package';
        $data['select'] = ['*'];
        $data['where'] = ['vendor_id'=>$this->vendor_id];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
    }

    public function getPackageById($id){
        $data['table'] = 'package';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$id];
        $return = $this->selectRecords($data,true);  
        return $return[0];
    }

       public function checkIsPakageAvailable($postData){
        // print_r($postData);die;
        $id =  $postData['id'];
        if($id){
        $data['where']['id !='] = $id;
        }
        $package_name =  trim($postData['package']);
        $data['select'] = ['*'];
        $data['table'] = 'package';
        $data['where']['package'] = $package_name;
        $data['where']['vendor_id'] = $this->vendor_id;
        $res = $this->selectRecords($data);
        if(!empty($res)){
            return 'false';
        }else{
            return 'true';
        }
    }





    public  $order_column_package = array("package"); 

    public function make_query_package($postData){
         $this->db->select('*');
         $this->db->where('vendor_id',$this->vendor_id);
         $this->db->from('package');
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
            $this->db->group_start();
            $this->db->like("package", $postData["search"]["value"]);
            $this->db->group_end(); 
            }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_package[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('id', 'DESC');  
           } 
    }


    public function make_datatables_package($postData){ 
        $this->make_query_package($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            // echo $this->db->last_query();
        }

    public function get_filtered_data_package($postData = false){  
        $this->make_query_package($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }       
    
    public function get_all_data_package(){
        $this->db->select("*");
        $this->db->where('vendor_id',$this->vendor_id);  
        $this->db->from('package');
        return $this->db->count_all_results();   
        }

}
?>