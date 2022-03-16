<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Weight extends Admin_Controller
{
     function __construct(){

        parent::__construct();
        $this->load->model('weight_model','this_model');
        // $this->vendor_id = $this->session->userdata['id'];
    }

    public function weight_list(){
        $data['weight_result'] = $this->this_model->getWeightlist();
        $data['table_js'] = array('unit.js');
        $data['start'] = array('UNIT.table()');
        $this->load->view('weight_list',$data);
    }

    public function geAjaxWeightList(){
        if($this->input->post()){
            echo getWeightListAjax($this->input->post());
        }
    }

    public function weight_profile(){
    if(isset($_GET['id'])){
        $id = $this->utility->decode($_GET['id']);
    }else{
        $id = '';
    }    
    if($id != ''){
        $data['result'] = $this->this_model->getDataById($id);
    }else{
        $data =[];
    }
     
        $this->load->view('weight_profile',$data);
    }
    public function weight_add_update(){
        if($this->input->post()){
           $this->this_model->weight_add_update($this->input->post());
        }
    }
    public function single_delete_weight(){
        if($this->input->get()){
           $this->this_model->single_delete_weight($this->input->get());
        }
    }
    public function multi_delete_weight()
    {
        $this->this_model->multi_delete_weight();
    }

}
?>