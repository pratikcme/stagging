<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Delivery_charge extends Admin_Controller
{

    function __construct()
    {

        parent::__construct();
        $vendor_id = $this->session->userdata['id'];
        $this->load->model('delivery_charge_model', 'this_model');
    }

    public function index()
    {
        $data['city_result'] = $this->this_model->getDeliveryCharegeData();
        $this->load->view('delivery_charge_list',$data) ;
    }

    public function delivery_charge()
    {
         $data['city_result'] = $this->this_model->getDeliveryCharegeData();
        $this->load->view('delivery_charge_list',$data);
    }

    public function delivery_charge_add()
    {
        if ($this->input->post()) {

            $res = $this->this_model->delivery_charge_Add();
            redirect('delivery_charge');

        }
        $this->load->view('delivery_charge');
    }

    public function delete()
    {
        $id = $this->input->get('id');
        $this->this_model->delete($id);

    }
    public function get_valid_start_range()
    {
        $return = $this->this_model->get_valid_start_range();
        echo $return;
    }
    public function get_valid_end_range()
    {
        
        $return = $this->this_model->get_valid_end_range();
        echo $return;
    }

}