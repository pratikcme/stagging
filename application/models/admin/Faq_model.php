<?php 

Class Faq_model extends My_model{

    public function addRecord($postData){
      // print_r($postData);
      // exit;
      $data['table'] = FAQ;
      $data['insert']['question'] = $postData['question'];
      $data['insert']['answer'] = $postData['answer'];
      $data['insert']['created_at'] = DATE_TIME;
      $data['insert']['updated_at'] = DATE_TIME;
      $result = $this->insertRecord($data);
      if ($result) {
                return ['success', 'Record Added Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            }
    }

    public function getCustomerSupportQuestion(){
      $data['table'] = FAQ; 
      $data['select'] = ['*'];
      $data['order'] = "id DESC";
      return $this->selectRecords($data);     
    }

    public function selectEditRecord($id){
    $data['table'] = FAQ;
      $data['select'] = ['*'];
      $data['where']['id'] = $id;
      return $this->selectRecords($data);     
    } 

    public function UpdateRecord($postData,$id){
    $data['table'] = FAQ;
      $data['update']['question'] = $postData['question'];
      $data['update']['answer'] = $postData['answer'];
      $data['update']['updated_at'] = DATE_TIME;
      $data['where']['id'] = $id;
      $result = $this->updateRecords($data); 
        if($result) {
                return ['success', 'Record Edit Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            }   
    }

    public function removeRecord($id){
      $data['table'] = FAQ;
      $data['where']['id'] = $id;
      return $this->deleteRecords($data);
        
    }

    
    public function multipleDelete()
    {

        $id = $_GET['ids'];
      
        $re = '' ;
        foreach ($id as $value) {
                $data['table'] = FAQ;
                $data['where']['id'] = $value;  
               $re = $this->deleteRecords($data);

        }
        if($re){
            echo json_encode(['status'=>1]);
        }
        
    }
}

?>