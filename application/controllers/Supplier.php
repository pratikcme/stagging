<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends CI_Controller {

     function __construct(){
        parent::__construct();
        $this->load->model('supplier_model','this_model');
    }

    public function index(){
        $data['table_js'] = array('supplier.js');
        $data['start'] = array('SUPPLIER.table()');
        $this->load->view('supplier_list',$data);
    }

    public function supplierListAjax(){
        if($this->input->post()){
            echo supplierListAjax($this->input->post());
        }
    }

    public function profile()
    {
        $this->load->view('supplier_profile');
    }

    ## Supplier Profile ##
    public function add_supplier()
    {
        $supplier_id = $this->input->post('id');
        $name = $this->input->post('name');
        $markup = $this->input->post('markup');
        $description = $this->input->post('description');
        $fname = $this->input->post('fname');
        $company = $this->input->post('company');
        $phone = $this->input->post('phone');
        $fax = $this->input->post('fax');
        $twitter = $this->input->post('twitter');
        $lname = $this->input->post('lname');
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $website = $this->input->post('website');
        $street1 = $this->input->post('street1');
        $state = $this->input->post('state');
        $street2 = $this->input->post('street2');
        $country_id = $this->input->post('country');
        $vendor_id = $this->session->userdata('id');
       

        ## Update supplier ##
        if($supplier_id != ''){

            $array = array(
                'name' => $name,
                'default_markup' => $markup,
                'description' => $description,
                'fname' => $fname,
                'lname' => $lname,
                'company' => $company,
                'email' => $email,
                'phone' => $phone,
                'mobile' => $mobile,
                'fax' => $fax,
                'website' => $website,
                'twitter' => $twitter,
                'street_1' => $street1,
                'street_2' => $street2,
                'state' => $state,
                'country_id' => $country_id,
                'status' => '1',
                'dt_added' => strtotime(date('Y-m-d H:i:s')),
                'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                'vendor_id' => $vendor_id                
            );

            $this->session->set_flashdata('msg', 'Supplier has been updated successfully.');
            $this->db->where('id', $supplier_id);
            $this->db->update('supplier', $array);
        }
        ## Add Supplier ##
        else{

            $array = array(
                'name' => $name,
                'default_markup' => $markup,
                'description' => $description,
                'fname' => $fname,
                'lname' => $lname,
                'company' => $company,
                'email' => $email,
                'phone' => $phone,
                'mobile' => $mobile,
                'fax' => $fax,
                'website' => $website,
                'twitter' => $twitter,
                'street_1' => $street1,
                'street_2' => $street2,
                'state' => $state,
                'country_id' => $country_id,
                'status' => '1',
                'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                'vendor_id' => $vendor_id,
                
            );

            $this->session->set_flashdata('msg', 'Supplier has been added successfully.');
            $this->db->insert('supplier', $array);
        }
        redirect(base_url().'supplier/index');
    }

    ## Single Delete ##
    public function single_delete_supplier()
    {
        echo $ids = $_REQUEST['ids'];

        $data = array(
            'status' => '9'
        );

        $this->db->where('id', $ids);
        $this->db->update('supplier', $data);

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }
}