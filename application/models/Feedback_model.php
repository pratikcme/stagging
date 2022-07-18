<?php
Class Feedback_model extends My_model{

    function __construct(){
      $this->vendor_admin_id = $this->session->userdata('vendor_admin_id');
    }

	public function get_feedback(){
		$data['table'] = 'feedback as f';
		$data['select'] = ['f.*','u.fname','u.lname','u.country_code','u.phone' ]  ;
        $data['join'] = ['user as u '=>['u.id=f.user_id','LEFT']];
        $data['where'] = ['f.vendor_id'=> $this->vendor_admin_id ]; 
        $data['orderBy'] = 'f.dt_updated DESC';
        return $this->selectFromJoin($data);
	}

}
?>