<?php

Class Usersblog_model extends My_model{

	var $select_column = array("b.id","b.banner_title", "b.created_at","c.category_name");  
      var $order_column = array(null, "banner_title",'category_name');  
      function make_query($postData)  
      {  
           $this->db->select($this->select_column);  
           $this->db->from(BLOG .' as b');
           $this->db->join('category as c', 'c.id = b.category_id');
           if(isset($postData["search"]["value"]))  
           {  
                $this->db->like("b.banner_title", $postData["search"]["value"]);  
                $this->db->or_like("c.category_name", $postData["search"]["value"]);  
           }  
           if(isset($postData["order"]))  
           {  
                $this->db->order_by($this->order_column[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('b.id', 'DESC');  
           }  
      }  
	      function make_datatables($postData){ 
	           $this->make_query($postData);  
	           if($postData["length"] != -1)  
	           {  
	                $this->db->limit($postData['length'], $postData['start']);  
	           }  
	           $query = $this->db->get();  
	           return $query->result();  
	      }  
	      function get_filtered_data($postData = false){  
	           $this->make_query($postData);  
	           $query = $this->db->get();  
	           return $query->num_rows();  
	      }       
	      function get_all_data()  
	      {  
	           $this->db->select("*");  
	           $this->db->from(BLOG);
	           return $this->db->count_all_results();  
	      } 

	      public function categoryblogcount(){
	      	$data['table'] = CATEGORY . ' as c';
	      	$data['select'] = ['c.id','c.category_name','count(b.category_id) as totalblogOfThatCategory'];
	      		$data['join'] = [
	      						BLOG .' as b' => ['b.category_id = c.id','left']
	      					];
	      					$data['groupBy'] = ['b.category_id']; 
	      					$data['order'] = 'count(b.category_id) DESC';
	      					$data['where'] = ['b.category_id !='=>0]; 
	      	return $this->selectFromJoin($data);
	      	
	      }
}

?>