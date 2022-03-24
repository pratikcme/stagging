<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Price_list extends Admin_Controller
{
     function __construct(){

        parent::__construct();
        $vendor_id = $this->session->userdata['id'];
        $this->load->model('price_list_model','this_model');
    }  
    public function index()
    {
        $this->load->view('price_list');
    }
    public function price()
    {
        $data['price_result'] = $this->this_model->getPriceData();
        $data['table_js'] = array('price.js');
        $data['start'] = array('PRICE.table()');
        $this->load->view('price_list',$data);
    }

    public function geAjaxPriceList(){
        if($this->input->post()){
            echo getAjaxPriceList($this->input->post());
        }
    }

    public function price_profile()
    {
        if(isset($_GET['id'])){
             $id = $this->utility->decode($_GET['id']);
        }else{
            $id = '';
            $data['id'] = '';
        }
        if($id != ''){
            $data['result'] = $this->this_model->getPriceById($id);
        }
        // print_r($data['result']);die;
        $this->load->view('price_profile',$data);
    }
    public function price_add_update()
    {
        $id = $this->input->post('id');
        if($id != ''){ 
        /*update*/  
            $this->this_model->price_add_update($this->input->post());
            $this->session->set_flashdata('msg', 'Price has been updated successfully');
                redirect(base_url() . 'price_list/price');
                exit();
        }else{
            //insert
            $this->this_model->price_add_update($this->input->post());
            $this->session->set_flashdata('msg', 'Price has been added successfully');
            redirect(base_url() . 'price_list/price');
        }
        $this->this_model->price_add_update();
    }
    public function single_delete_price()
    {
        if($this->input->get()){
            $this->this_model->single_delete_price($this->input->get());
        }
    }
    public function multi_delete_price()
    {
        $this->this_model->multi_delete_price();
    }

}
?>