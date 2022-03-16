<?php 

class Footer_model extends My_model{

	public function getFooterInfo(){
		$data['table'] = FOOTER;
		$data['select'] = ['*'];
		return $this->selectRecords($data);

	}

	public function editUpdateFooterInfo($postData){

		$data['select'] = ['id'];
        $data['table'] = FOOTER;
        $result = $this->selectRecords($data);

        if (empty($result)) {

            $data['insert']['content'] = $postData['content'];
            $data['insert']['facebook'] = $postData['facebook'];
            $data['insert']['twitter'] = $postData['twitter'];
            $data['insert']['instagram'] = $postData['instagram'];
            $data['insert']['youtube'] = $postData['youtube'];
            $data['insert']['created_at'] = DATE_TIME;
            $data['insert']['updated_at'] = DATE_TIME;
            $data['table'] = FOOTER;
            $result = $this->insertRecord($data);

            if ($result) {
                return ['success', 'Record Added Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            }

        } else {

            $data['update']['content'] = $postData['content'];
            $data['update']['facebook'] = $postData['facebook'];
            $data['update']['twitter'] = $postData['twitter'];
            $data['update']['instagram'] = $postData['instagram'];
            $data['update']['youtube'] = $postData['youtube'];
            $data['update']['updated_at'] = DATE_TIME;
            $data['where'] = ['id' => $result[0]->id];
            $data['table'] = FOOTER;
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