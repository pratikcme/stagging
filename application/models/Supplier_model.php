<?php
class Supplier_model extends My_model{
    
    function __construct(){
        $this->vendor_id = $this->session->userdata['id'];
    }

    public  $order_column_supplier = array("name",'default_markup','fname','lname','company','email','phone','mobile','state'); 
    function make_query_supplier($postData){
     $vendor_id = $this->session->userdata('id');
        $where = [
            'vendor_id'=>$vendor_id,
            'status !='=>'9',  
        ];
         $this->db->select('*');  
         $this->db->from('supplier');
         $this->db->where($where);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
        $this->db->group_start();
            $this->db->like("name", $postData["search"]["value"]);
            $this->db->or_like("default_markup", $postData["search"]["value"]);
            $this->db->or_like("fname", $postData["search"]["value"]);
            $this->db->or_like("lname", $postData["search"]["value"]);
            $this->db->or_like("company", $postData["search"]["value"]);
            $this->db->or_like("email", $postData["search"]["value"]);
            $this->db->or_like("phone", $postData["search"]["value"]);
            $this->db->or_like("mobile", $postData["search"]["value"]);
            $this->db->or_like("state", $postData["search"]["value"]);
        $this->db->group_end(); 
        }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_supplier[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('id', 'DESC');  
           } 
    }


    function make_datatables_supplier($postData){ 
        $this->make_query_supplier($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            // echo $this->db->last_query();
        }

    function get_filtered_data_supplier($postData = false){  
        $this->make_query_supplier($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }    

    function get_all_data_supplier(){
        $vendor_id = $this->session->userdata('id');
       $where = [
            'vendor_id'=>$vendor_id,
            'status !='=>'9',  
        ];
        $this->db->select("*");  
        $this->db->from('supplier');
        $this->db->where($where);
        return $this->db->count_all_results();   
    }

}
?>