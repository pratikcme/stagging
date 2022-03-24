<?php


Class Category_model extends My_model{

      public $order_column = array(null,"category_name");
	 function build_query($postData)  
      {  

           $this->db->select('*');  
           $this->db->from(CATEGORY);  
           if(isset($postData["search"]["value"])) 
           {  
                $this->db->like("category_name", $postData["search"]["value"]);  
           }  
           if(isset($postData["order"]))  
           {  
                $this->db->order_by($this->order_column[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('id', 'DESC');  
           }  
      }  
	      function make_datatables($postData){ 

	           $this->build_query($postData);  
	           if($postData["length"] != -1)  
	           {  
	                $this->db->limit($postData['length'], $postData['start']);  
	           }  
	           $query = $this->db->get();  
	           return $query->result();  
	      }  
	      function get_filtered_data($postData=false){  
	           $this->build_query($postData);  
	           $query = $this->db->get();  
	           return $query->num_rows();  
	      }       
	      function get_all_data()  
	      {  
	           $this->db->select("*");  
	           $this->db->from(CATEGORY);
	           return $this->db->count_all_results();  
	      }

	      public function Addcategory($postData){
	      		$data['table'] = CATEGORY;
	      		$data['insert'] = ['category_name'=>$postData['add_category']];
	      		$data['insert']['created_at'] = DATE_TIME;
	      		$data['insert']['updated_at'] = DATE_TIME;
	      		$result = $this->insertRecord($data);
	      			 if ($result) {
				          return ['success', 'Record Added Successfully'];
				        } else {
				          return ['danger', DEFAULT_MESSAGE];
				        }
	      }

	      public function deleteRecord($id){
	      	$data['table'] = CATEGORY; 
	      	$data['where']['id'] = $id; 
	      	return $this->deleteRecords($data);
	      }

	      public function selectEditRecord($id){
	      	$data['table'] = CATEGORY; 
	      	$data['select'] = ['*']; 
	      	$data['where']['id'] = $id; 
	      	return $this->selectRecords($data);
	      }

	      public function UpdateRecord($postData,$id){
	      	$data['table'] = CATEGORY;
	      	$data['update']['category_name'] = $postData['add_category'];
	      	$data['update']['updated_at'] = DATE_TIME; 
	      	$data['where']['id'] = $id; 
	      	$result = $this->updateRecords($data);
	      		 if ($result) {
				          return ['success', 'Record Update Successfully'];
				        } else {
				          return ['danger', DEFAULT_MESSAGE];
				        }
	      }

	      public function selectCategory(){
	      	$data['table'] = CATEGORY;
	      	$data['select'] = ['*'];
	      	$data['where']['vendor_id'] = $this->session->userdata('vendor_id');
	      	return $this->selectRecords($data);
	      }

}

?>