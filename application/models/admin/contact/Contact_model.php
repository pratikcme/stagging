<?php 

class Contact_model extends My_model{

	public function getContactInfo(){
		$data['table'] = CONTACT_INFO;
		$data['select'] = ['*'];
		return $this->selectRecords($data);

	}

	public function editUpdateContactInfo($postData){

        $data['table'] = CONTACT_INFO;
        $result = $this->selectRecords($data);

        if (empty($result)) {

            $data['insert']['location'] = $postData['location'];
            $data['insert']['email'] = $postData['email'];
            $data['insert']['phone_no'] = $postData['phone_no'];
            $data['insert']['created_at'] = DATE_TIME;
            $data['insert']['updated_at'] = DATE_TIME;
            $data['table'] = CONTACT_INFO;
            $result = $this->insertRecord($data);

            if ($result) {
                return ['success', 'Record Added Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            }

        } else {                

            $data['update']['location'] = $postData['location'];
            $data['update']['email'] = $postData['email'];
            $data['update']['phone_no'] = $postData['phone_no'];
            $data['update']['updated_at'] = DATE_TIME;
            $data['where'] = ['id' => $result[0]->id];
            $data['table'] = CONTACT_INFO;
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