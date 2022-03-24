<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Time_slot extends Admin_Controller
{
     function __construct(){

        parent::__construct();
        $vendor_id = $this->session->userdata['id'];
        $this->load->model('time_slot_model','this_model');
    }

    public function index(){
        $this->load->view('time_slot_list');
    }
    public function time_slot_list(){
        $data['time_slot_result'] = $this->this_model->getTimeSlotData();
        $data['table_js'] = array('time_slot.js');
        $data['start'] = array('TIMESLOT.table()');
        $this->load->view('time_slot_list',$data);
    }

    public function getAjaxTimeSlot(){
        if($this->input->post()){
            echo getTimeSlotAjax($this->input->post());
        }
    }

    public function time_slot_profile(){
        if(isset($_GET['id'])){
            $id = $this->utility->decode($_GET['id']); 
            $data['result'] = $this->this_model->getDataByID($id);
        }else{
            $data = [];
        }
        $this->load->view('time_slot_profile',$data);
    }

    public function time_slot_add_update()
    {
        if($this->input->post()){
           $this->this_model->time_slot_add_update($this->input->post());
        }
    }

    public function single_delete_time_slot()
    {
        if($this->input->get()){
           $this->this_model->single_delete_time_slot($this->input->get());
        }
    }
    public function multi_delete_time_slot()
    {
        $this->this_model->multi_delete_time_slot();
    }


}
?>