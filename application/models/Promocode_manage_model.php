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
            'name' => $postData['name'],
            'percentage' => $postData['percentage'],
            'max_use' => $postData['max_use'],
            'min_cart' => $postData['min_cart'],
            'start_date' => date('Y-m-d',strtotime($postData['start_date'])),
            'end_date' => date('Y-m-d',strtotime($postData['end_date'])),
            'dt_created' => DATE_TIME,
            'dt_updated' => DATE_TIME
        );
        $data['table'] = TABLE_PROMOCODE;
        $data['insert'] = $insert;
        $offer_id = $this->insertRecord($data);
    
        $this->session->set_flashdata('msg', 'Promocode has added successfully.');
        redirect(base_url().'offer');
}


    public function updateRecord($postData){
         $update = array(
            'name' => $postData['name'],
            'percentage' => $postData['percentage'],
            'max_use' => $postData['max_use'],
            'min_cart' => $postData['min_cart'],
            'start_date' => date('Y-m-d',strtotime($postData['start_date'])),
            'end_date' => date('Y-m-d',strtotime($postData['end_date'])),
            'dt_created' => DATE_TIME,
            'dt_updated' => DATE_TIME
        );
        $data['table'] = TABLE_PROMOCODE;
        $data['update'] = $update;
        $data['where'] = ['id'=>$this->id];
        $offer_id = $this->insertRecord($data);
      
        $this->session->set_flashdata('msg', 'Promocode has been updated successfully.');
        redirect(base_url().'offer'); 

        
    }

    public function removeRecord($id){
       
        $data['table'] = TABLE_PROMOCODE;
        $data['where']['id'] = $id;
        $return =  $this->deleteRecords($data);
           
        
            
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