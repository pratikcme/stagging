<?php
Class About_app_model extends My_model{

    function __construct(){
     // $this->load->model('common_model');
     // $re = $this->common_model->getExistingBranchId();
     // $this->branch_id = $re[0]->id;
     $this->vendor_id = $this->session->userdata('vendor_admin_id');
    }

	public function getAboutApp(){
      
		$data['table'] = TABLE_ABOUT_US;
        $data['select'] = ['*'];
		$data['where'] = ['vendor_id'=>$this->vendor_id];
		return $this->selectRecords($data);
	}

	public function editUpdateAboutApp($postData) {
      
        $data['select'] = ['id'];
        $data['table'] = TABLE_ABOUT_US;
        $data['where']['vendor_id'] = $this->vendor_id;
        $result = $this->selectRecords($data);

        if (empty($result)) {
            $data['insert']['vendor_id'] = $this->vendor_id;
            $data['insert']['about'] = $postData['about'];
            $data['insert']['website'] = $postData['website'];
            $data['insert']['contact_number'] = $postData['contact_number'];
            $data['insert']['email'] = $postData['email'];
            $data['insert']['created_at'] = DATE_TIME;
            $data['insert']['updated_at'] = DATE_TIME;
            $data['table'] = TABLE_ABOUT_US;
            $result = $this->insertRecord($data);

            if ($result) {
                return ['success', 'Record Added Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            }

        } else {
            $data['update']['vendor_id'] = $this->vendor_id;
            $data['update']['about'] = $postData['about'];
            $data['update']['website'] = $postData['website'];
            $data['update']['contact_number'] = $postData['contact_number'];
            $data['update']['email'] = $postData['email'];
            $data['update']['updated_at'] = DATE_TIME;
            $data['where'] = ['id' => $result[0]->id];
            $data['table'] = TABLE_ABOUT_US;
            $result = $this->updateRecords($data);

            if ($result) {
                return ['success', 'Record Edit Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            }
        }

    }
}
?>