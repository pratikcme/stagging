<?php 

Class Return_refund_model extends My_model{


    public function addRecord($postData){
     
      // $this->load->model('common_model');
      // $re = $this->common_model->getExistingBranchId();
      // $branch_id = $re[0]->id;
      $data['table'] = RETURN_REFUND;
      $data['insert']['vendor_id'] = $this->session->userdata('vendor_admin_id');
      $data['insert']['title'] = $postData['title'];
      $data['insert']['sub_title'] = $postData['sub_title'];
      $data['insert']['created_at'] = DATE_TIME;
      $data['insert']['updated_at'] = DATE_TIME;
      $result = $this->insertRecord($data);
      if ($result) {
                return ['success', 'Record Added Successfully'];
            } else {
                return ['danger', DEFAULT_MESSAGE];
            }
    }

    public function getRecord(){
      $data['table'] = RETURN_REFUND;
      $data['select'] = ['*'];
      $data['where'] = ['vendor_id'=>$this->session->userdata('vendor_admin_id')];
      $data['order'] = "id DESC";
      return $this->selectRecords($data);     
    }

    public function selectEditRecord($id){
      $data['table'] = RETURN_REFUND;
      $data['select'] = ['*'];
      $data['where']['id'] = $id;
      return $this->selectRecords($data);     
    } 

    public function UpdateRecord($postData,$id){
      $data['table'] = RETURN_REFUND;
      $data['update']['title'] = $postData['title'];
      $data['update']['sub_title'] = $postData['sub_title'];
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
      $data['table'] = RETURN_REFUND;
      $data['where']['id'] = $id;
      return $this->deleteRecords($data);
        
    }

     ## Multi Delete City ##
    public function multipleDelete()
    {

        $id = $_GET['ids'];
      
        $re = '' ;
        foreach ($id as $value) {
                $data['table'] = RETURN_REFUND;
                $data['where']['id'] = $value;  
               $re = $this->deleteRecords($data);

        }
        if($re){
            echo json_encode(['status'=>1]);
        }
        
    }
}

?>