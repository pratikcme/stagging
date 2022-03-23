<?php
class price_list_model extends My_model{ 

    function __construct(){
        $this->load->model('common_model');
        $re = $this->common_model->getExistingBranchId();
        $this->branch_id = $re[0]->id;
        $this->vendor_id = $this->session->userdata('vendor_admin_id');
    }
     public function Price_add_update($postData){

        $id = $postData['id'];
        $start_price = $postData['start_price'];
        $end_price_ = $postData['end_price'];
        if(isset($postData['submit'])) {

            /* Price Update */
            if ($id != '') {
                if($end_price_ == ''){
                    $end_price =  '9999999999';
                }elseif ($end_price_ == '9999999999'){
                    $end_price =  '9999999999';
                }else{
                    $end_price = $end_price_;
                }

                $up = array(
                    'start_price' => $start_price,
                    'end_price' => $end_price,
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );

                $data['table'] = 'price';
                $data['update'] = $up;
                $data['where'] = ['id'=>$id];
                return $this->updateRecords($data);
            }
            /* Price Add */
            else {

                if($end_price_ == ''){
                    $end_price =  '9999999999';
                }else{
                    $end_price = $end_price_;
                }

                $insert = array(
                    'vendor_id' => $this->vendor_id,
                    'start_price' => $start_price,
                    'end_price' => $end_price,
                    'status' => '1',
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $data['table'] = 'price';
                $data['insert'] = $insert;
                $this->insertRecord($data);
            }
        }
    }

    # Price Single Delete ##
    public function single_delete_price($getData)
    {
        $id = $getData['id'];
        $up = array( 'status' => '9','dt_updated' => strtotime(date('Y-m-d H:i:s')));
        $data['table'] = 'price';
        $data['where'] = ['id'=>$id,'vendor_id'=>$this->vendor_id];
        $data['update'] = $up;
        $this->updateRecords($data);
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    ## Price Multi Delete ##
    public function multi_delete_price()
    {
        $id = $_GET['ids'];
        $date = strtotime(date('Y-m-d H:i:s'));

        $this->db->query("UPDATE price SET status = '9', dt_updated = '$date' WHERE id IN ($id)");

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    public function getPriceData(){
        $data['table'] = 'price';
        $data['select'] = ['*'];
        $data['where'] = ['status != '=>'9','vendor_id'=>$this->vendor_id];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
    }

    public function getPriceById($id){
        $data['table'] = 'price';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$id];
        $result = $this->selectRecords($data,true);
        return $result[0];
    }

        public  $order_column_price = array("start_price","end_price"); 
    function make_query_price($postData){
        $where = [
            'vendor_id'=>$this->vendor_id,
            'status !='=>'9',  
        ];
         $this->db->select('*');  
         $this->db->from('price');
         $this->db->where($where);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
          $this->db->group_start();

            $this->db->like("start_price", $postData["search"]["value"]); 
            $this->db->or_like("end_price", $postData["search"]["value"]); 
            $this->db->group_end(); 
            }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_price[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('id', 'DESC');  
           } 
    }


    function make_datatables_price($postData){ 
        $this->make_query_price($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            // echo $this->db->last_query();
        }

    function get_filtered_data_price($postData = false){  
        $this->make_query_price($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }       
    
    function get_all_data_price(){
       $where = [
            'vendor_id'=>$this->vendor_id,
            'status !='=>'9',  
        ];
        $this->db->select("*");  
        $this->db->from('price');
        $this->db->where($where);
        return $this->db->count_all_results();   
        }



}
?>