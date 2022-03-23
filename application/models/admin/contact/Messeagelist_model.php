<?php

Class Messeagelist_model extends My_model{

	function __construct(){
       $this->vendor_id = $this->session->userdata('vendor_admin_id');
	}

  public function selectMessageList(){
          $this->db->select('*');  
          $this->db->from(TABLE_CONTACT_US);
          $this->db->where('vendor_id',$this->vendor_id);
		      $this->db->order_by("id", "DESC");
          $query = $this->db->get();  
          return $query->result();
  }

}

?>