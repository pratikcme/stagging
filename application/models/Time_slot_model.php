<?php
class time_slot_model extends My_model{

    function __construct(){
       $this->load->model('common_model');
       $re = $this->common_model->getExistingBranchId();
       $this->branch_id = $re[0]->id;
       $this->vendor_id = $this->session->userdata('vendor_admin_id');
   }

    public function Time_slot_add_update($postData){

        $id = $postData['id'];
        $start_time = $postData['start_time'];
        $end_time = $postData['end_time'];
        $vendor_id = $this->session->userdata['id'];
        if(isset($postData['submit'])) {
            /* Time Slot Update */
            if ($id != '') {

                $up = array(
                    'vendor_id'=>$this->vendor_id,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'dt_updated' => strtotime(DATE_TIME),

                );
                $data['table'] = 'time_slot';   
                $data['where'] = ['id'=>$id];
                $data['update'] = $up;
                $this->updateRecords($data);
                $this->session->set_flashdata('msg', 'Time slot has been updated successfully');
                redirect(base_url() . 'time_slot/time_slot_list');
                exit();
            }
            /* Time Slot Add */
            else {
                // echo '1';die;
                $insert = array(
                    'vendor_id' => $this->vendor_id,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'status' => '1',
                    'order_limit'=>'0',
                    'dt_added' => strtotime(DATE_TIME),
                    'dt_updated' => strtotime(DATE_TIME),
                );
                $data['table'] = 'time_slot';
                $data['insert'] = $insert;
                $this->insertRecord($data);
                $this->session->set_flashdata('msg', 'Time slot has been added successfully');
                redirect(base_url() . 'time_slot/time_slot_list');
                exit();
            }
        }
    }

    # Time Slot Single Delete ##
    public function single_delete_time_slot($getData)
    {
        $id = $getData['id'];
        $updateData = array( 'status' => '9','dt_updated' => strtotime(date('Y-m-d H:i:s')));

        $data['table'] = 'time_slot';
        $data['update'] = $updateData;
        $data['where'] = ['id'=>$id];
        $this->updateRecords($data);
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    ## Time Slot Multi Delete ##
    public function multi_delete_time_slot()
    {
        $id = $_GET['ids'];
        $date = strtotime(date('Y-m-d H:i:s'));

        $this->db->query("UPDATE time_slot SET status = '9', dt_updated = '$date' WHERE id IN ($id)");

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    public function getTimeSlotData(){
        $data['table'] = 'time_slot';
        $data['select'] = ['*'];
        $data['where'] = [
            'status !='=>'9',
            'vendor_id'=>$this->vendor_id
        ];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
    }

    public function getDataByID($id){
        $data['table'] = 'time_slot';
        $data['select'] = ['*'];
        $data['where'] = [
            'id'=>$id,
            'vendor_id'=>$this->vendor_id
        ];
        $data['order'] = 'id DESC';
        $return = $this->selectRecords($data,true);
        return $return[0];
    }

    public  $order_column_timeslot = array("start_time","end_time"); 
    function make_query_timeslot($postData){
        $vendor_id = $this->session->userdata('id');
        $where = [
            'vendor_id'=>$this->vendor_id,
            'status !='=>'9',  
        ];
         $this->db->select('*');  
         $this->db->from('time_slot');
         $this->db->where($where);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
          $this->db->group_start();

            $this->db->like("start_time", $postData["search"]["value"]); 
            $this->db->or_like("end_time", $postData["search"]["value"]); 
            $this->db->group_end(); 
            }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_timeslot[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('id', 'DESC');  
           } 
    }


    function make_datatables_timeslot($postData){ 
        $this->make_query_timeslot($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            echo $this->db->last_query();
        }

    function get_filtered_data_timeslot($postData = false){  
        $this->make_query_timeslot($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }       
    
    function get_all_data_timeslot(){
       $vendor_id = $this->session->userdata('id');
       $where = [
            'vendor_id'=>$this->vendor_id,
            'status !='=>'9',  
        ];
        $this->db->select("*");  
        $this->db->from('time_slot');
        $this->db->where($where);
        return $this->db->count_all_results();   
        }
}
?>