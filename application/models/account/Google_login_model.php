<?php
class Google_login_model extends My_model
{
 function Is_already_register($email)
 {

  // $branch_id = $this->session->userdata('branch_id');
  $vendor_id = $this->session->userdata('vendor_id');

  $where = ['email'=>$email,'vendor_id'=>$vendor_id,'status!='=>'9'];

  $this->db->where($where);
  $query = $this->db->get(TABLE_USER);
  if($query->num_rows() > 0)
  {
   return $query->result() ;
  }
  else
  {
   return false;
  }
 }

 function Update_user_data($data, $emial)
 {

  $vendor_id = $this->session->userdata('vendor_id');
  $this->db->where('vendor_id',$vendor_id);
  $this->db->where('email', $emial);
  $this->db->update(TABLE_USER, $data);
 }

 function Insert_user_data($data)
 {
   $result = $this->db->insert(TABLE_USER, $data);
   if($result){
      $last_id = $this->db->insert_id();
      $this->db->select('*');
      $this->db->from(TABLE_USER);
      $this->db->where(['id'=>$last_id]);
      $re = $this->db->get()->result();
      return $re;
   }

  }
  function getUserDetails($facebook_token){
    $data['table'] = TABLE_USER;
    $data['select'] = ['*'];
    $data['where'] = ['facebook_token_id'=>$facebook_token];
    return $this->selectRecords($data);
  }

  function getUsersInfo($gmail_token_id){
    $data['table'] = TABLE_USER;
    $data['select'] = ['*'];
    $data['where'] = ['gmail_token_id'=>$gmail_token_id];
    return $this->selectRecords($data);
  }

 


}
?>