<?php
class Promocode_manage_model extends My_model{

    function __construct(){
     $this->vendor_id = $this->session->userdata('vendor_admin_id');
     $this->branch_id = $this->session->userdata('id');
    }


    public function allData($id = ''){
        if($id != ''){
            $data['where']['id'] = $id;
        }
        $data['table'] = TABLE_PROMOCODE;
        $data['select'] = ['*'];
        $data['where']['branch_id'] = $this->branch_id;
        $data['order'] = 'id desc';
        return $this->selectRecords($data);        
    }

 


  ## Add Update ##
    public function addRecord($postData){

        $insert = array(
            'branch_id'=>$this->branch_id,
            'name' => $postData['name'],
            'percentage' => $postData['percentage'],
            'max_use' => $postData['max_use'],
            'max_cart' => $postData['max_cart'],
            'min_cart' => $postData['min_cart'],
            'start_date' => date('Y-m-d',strtotime($postData['start_date'])),
            'end_date' => date('Y-m-d',strtotime($postData['end_date'])),
            'dt_created' => DATE_TIME,
            'dt_updated' => DATE_TIME
        );
        $data['table'] = TABLE_PROMOCODE;
        $data['insert'] = $insert;
        
    
        $res = $this->insertRecord($data); 
        if($res){
            $jsone_response['status'] = 'success';
            $jsone_response['message'] = 'Data added success!!!';
        }else{
            $jsone_response['status'] = 'danger';
            $jsone_response['message'] = DEFAULT_MESSAGE;
        }   
    
         return $jsone_response;
    }


    public function updateRecord($postData){
         $update = array(
            'name' => $postData['name'],
            'percentage' => $postData['percentage'],
            'max_use' => $postData['max_use'],
            'max_cart' => $postData['max_cart'],
            'min_cart' => $postData['min_cart'],
            'start_date' => date('Y-m-d',strtotime($postData['start_date'])),
            'end_date' => date('Y-m-d',strtotime($postData['end_date'])),
            'dt_updated' => DATE_TIME
        );
        $data['table'] = TABLE_PROMOCODE;
        $data['update'] = $update;
        $data['where'] = ['id'=>$this->id];
        $res = $this->updateRecords($data);
        
        if($res){
            $jsone_response['status'] = 'success';
            $jsone_response['message'] = 'Data updated success!!!';
        }else{
            $jsone_response['status'] = 'danger';
            $jsone_response['message'] = DEFAULT_MESSAGE;
        }   
    
         return $jsone_response;

        
    }

    public function removeRecord($id){
       
        $data['table'] = TABLE_PROMOCODE;
        $data['where']['id'] = $id;
        $return =  $this->deleteRecords($data);
           
        $jsone_response['status'] = 'success';
        $jsone_response['message'] = 'Data updated success!!!';
        return $jsone_response;
            
    }


  ## Multi Delete City ##
    public function multi_delete()
    {
        $id = $_GET['ids'];
        $re = '' ;
        $path1 = 'public/images/'.$this->folder.'offer_image';
        foreach ($id as $value) {
       
           $data['table'] = TABLE_PROMOCODE;
           $data['where']['id'] = $value;
           $re = $this->deleteRecords($data);
           
       }
       if($re){
        echo json_encode(['status'=>1]);
    }
        
    }
 
}

?>