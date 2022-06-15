<?php
Class Firebase_model extends My_model{

    function __construct(){
      $this->load->model('common_model');
      $re = $this->common_model->getExistingBranchId();
      $this->branch_id = $re[0]->id;
      $this->vendor_admin_id = $this->session->userdata('vendor_admin_id');
    }

	public function getFireBase(){
		$data['table'] = TABLE_FIREBASE;
		$data['select'] = ['*'];
        $data['where'] = ['vendor_id'=> $this->vendor_admin_id ]; 
		// print_r($this->selectRecords($data));exit;
        return $this->selectRecords($data);

	}

	public function editUpdateFireBase($postData) {
        // print_r($postData);die;

        // $data['select'] = ['id'];
        // $data['table'] = TABLE_VENDOR;
        // $branch_id = $this->selectRecords($data);
        // $branch_id = $branch_id[0]->id;
        $data['select'] = ['id'];
        $data['table'] = TABLE_FIREBASE;
        $data['where'] = ['vendor_id'=>$this->vendor_admin_id]; 
        // $data['where'] = ['branch_id'=>$branch_id];
        $result = $this->selectRecords($data);
        if (empty($result)) {
            $data['insert']['vendor_id'] = $this->vendor_admin_id;
            $data['insert']['user_firebase_key'] = trim($postData['user_firebase_key']);
            $data['insert']['staff_firebase_key'] = trim($postData['staff_firebase_key']);
            $data['insert']['delivery_firebase_key'] = trim($postData['delivery_firebase_key']);
            $data['insert']['key_id'] = $postData['key_id'];
            $data['insert']['team_id'] = $postData['team_id'];
            $data['insert']['user_bandle_id'] = $postData['user_bandle_id'];
            $data['insert']['admin_bandle_id'] = trim($postData['admin_bandle_id']);
            $data['insert']['staff_bandle_id'] = $postData['staff_bandle_id'];
            $data['insert']['delivery_bandle_id'] = $postData['delivery_bandle_id'];
            $data['insert']['facebook_client_id'] = $postData['facebook_client_id'];
            $data['insert']['facebook_secret_id'] = $postData['facebook_secret_id'];
            $data['insert']['google_client_id'] = $postData['google_client_id'];
            $data['insert']['google_secret_id'] = $postData['google_secret_id'];
            $data['insert']['android_app_link'] = $postData['android_app_link'];
            $data['insert']['ios_app_link'] = $postData['ios_app_link'];
            $data['insert']['contact_number'] = $postData['contact_number'];
            $data['insert']['contact_email'] = $postData['contact_email'];
            $data['insert']['contact_us_address'] = $postData['contact_us_address'];
            $data['insert']['facebook_link'] = $postData['facebook_link'];
            $data['insert']['instagram_link'] = $postData['instagram_link'];
            $data['insert']['twitter_link'] = $postData['twitter_link'];
            $data['insert']['google_plus_link'] = $postData['google_plus_link'];
            $data['insert']['p8_file'] = $postData['p8_file'];
            $data['insert']['firebase_url'] = trim($postData['firebase_url']);
            $data['insert']['firebase_token'] = trim($postData['firebase_token']);
            $data['insert']['firebase_node'] = trim($postData['firebase_node']);
            $data['insert']['created_at'] = DATE_TIME;
            $data['insert']['updated_at'] = DATE_TIME;
            $data['table'] = TABLE_FIREBASE;
            $result = $this->insertRecord($data);

            if ($result) {
                return ['success', 'Record Added Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            }

        } else {
            // print_r($postData);die;
            // $data['update']['branch_id'] = $branch_id;
            $data['update']['user_firebase_key'] = trim($postData['user_firebase_key']);
            $data['update']['staff_firebase_key'] = trim($postData['staff_firebase_key']);
            $data['update']['delivery_firebase_key'] = trim($postData['delivery_firebase_key']);
            $data['update']['key_id'] = $postData['key_id'];
            $data['update']['team_id'] = $postData['team_id'];
            $data['update']['user_bandle_id'] = $postData['user_bandle_id'];
            $data['update']['staff_bandle_id'] = $postData['staff_bandle_id'];
            $data['update']['admin_bandle_id'] = trim($postData['admin_bandle_id']);
            $data['update']['delivery_bandle_id'] = $postData['delivery_bandle_id'];
            $data['update']['facebook_client_id'] = $postData['facebook_client_id'];
            $data['update']['facebook_secret_id'] = $postData['facebook_secret_id'];
            $data['update']['google_client_id'] = $postData['google_client_id'];
            $data['update']['google_secret_id'] = $postData['google_secret_id'];
            $data['update']['android_app_link'] = $postData['android_app_link'];
            $data['update']['ios_app_link'] = $postData['ios_app_link'];
            $data['update']['contact_number'] = $postData['contact_number'];
            $data['update']['contact_email'] = $postData['contact_email'];
            $data['update']['contact_us_address'] = $postData['contact_us_address'];
            $data['update']['facebook_link'] = $postData['facebook_link'];
            $data['update']['instagram_link'] = $postData['instagram_link'];
            $data['update']['twitter_link'] = $postData['twitter_link'];
            $data['update']['google_plus_link'] = $postData['google_plus_link'];
            $data['update']['p8_file'] = $postData['p8_file'];
            $data['update']['firebase_url'] = trim($postData['firebase_url']);
            $data['update']['firebase_token'] = trim($postData['firebase_token']);
            $data['update']['firebase_node'] = trim($postData['firebase_node']);
            $data['update']['updated_at'] = DATE_TIME;
            $data['where'] = ['id' => $result[0]->id];
            $data['table'] = TABLE_FIREBASE;
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