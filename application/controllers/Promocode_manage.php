<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Promocode_manage extends Vendor_Controller
{
     function __construct(){
        parent::__construct();
        $this->load->model('promocode_manage_model','this_model');
    }

    public function index()
    {
        $data['page'] = 'promocode/list';
        $data['js'] = array('promocode.js');
        $data['promocodes'] = $this->this_model->allData();
        $this->load->view('promocode/list',$data);
    }

    public function add(){
        $data['page'] = 'promocode/add';
        $data['js'] = array('promocode.js');
        $data['FormAction'] = base_url().'Promocode_manage/add';
            if($this->input->post()){          
                $result = $this->this_model->addRecord($this->input->post());
                 if($result){
                    $this->utility->setFlashMessage($response['status'], $response['message']);
                    redirect(base_url().'Promocode_manage');
                 }
            }
        
        $this->load->view('promocode/add',$data);
    }

    public function edit($d_id){
        $this->id = $this->utility->decode($d_id);
        $data['js'] = array('promocode.js');
        $data['FormAction'] = base_url().'Promocode_manage/edit/'.$d_id;
       
        if($this->input->post()){
           
            $result = $this->this_model->updateRecord($this->input->post());
            if($result){
                  $this->utility->setFlashMessage($response['status'], $response['message']);
                redirect(base_url().'Promocode_manage');
             }
            

        }
        $data['editData'] = $this->this_model->allData($this->id);
        $this->load->view('promocode/edit',$data);
    }



    public function removeRecord(){

     if($this->input->post()){
         $response = $this->this_model->removeRecord($this->input->post('id'));
         if($response){
            echo json_encode(['status'=>1]);
         }
        }

    }

    public function multipleDelete()
    {
        $re = $this->this_model->multi_delete();
        
    }   


   
}

?>