<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class City extends Admin_Controller
{
     function __construct(){
        parent::__construct();
        $vendor_id = $this->session->userdata['id'];
        $this->load->model('city_model','this_model');
    }  
     public function city_list()
    {
        $data['city_result'] = $this->this_model->GetCity();
        
        $data['table_js'] = array('city.js');
        $data['start'] = array('CITY.table()');
        $this->load->view('city_list',$data);
    }

    public function getCityDataTable(){
        if($this->input->post()){
            echo getCityAjaxDataTable($this->input->post());
        }
    }

    public function city_profile()
    {
        if(isset($_GET['id'])){
            $id = $this->utility->decode($_GET['id']);
        }else{
            $id = '';
            $data['id'] = '';
        }
        if($id != ''){
            $data['result'] = $this->this_model->getCityById($id);
         }
        $this->load->view('city_profile',$data);
    }
    public function city_add_update(){
            $id = $this->input->post('id');
            if($id != ''){
                $this->this_model->city_add_update($this->input->post());
                $this->session->set_flashdata('msg', 'City has been updated successfully');
                redirect(base_url() . 'city/city_list');
            }else{
            $this->this_model->city_add_update($this->input->post());
            $this->session->set_flashdata('msg', 'City has been added successfully');
                    redirect(base_url() . 'city/city_list');
            }
    }
    public function single_delete_city(){
        if($this->input->get()){
           $this->this_model->single_delete_city($this->input->get());
        }
    }
    public function multi_delete_city(){
        if($this->input->get()){
                $this->this_model->multi_delete_city($this->input->get());
        }
    }

}
?>