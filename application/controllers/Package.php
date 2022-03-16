<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Package extends Admin_Controller
{
     function __construct(){

        parent::__construct();
        $vendor_id = $this->session->userdata['id'];
        $this->load->model('package_model','this_model');
    }
    public function index()
    {
        $data['package_results'] = $this->this_model->getPakage();
        $data['table_js'] = array('package.js');
        $data['start'] = array('PACKAGE.table()');
        $this->load->view('package_list',$data);
    }

    public function geAjaxPackageList(){
        if($this->input->post()){
            echo getPackageList($this->input->post());
        }
    }

    public function package_list()
    {
        $data['package_results'] = $this->this_model->getPakage();
        $this->load->view('package_list',$data);
    }

    public function package_profile()
    {
        if(isset($_GET['id'])){
            $id = $this->utility->decode($_GET['id']);
        }else{
            $id = '';
            $data['id'] = '';
        }
        if($id != ''){
            $data['result'] = $this->this_model->getPackageById($id);
         }
        $this->load->view('package_profile',$data);
    }
    public function package_add_update()
    {
        $id = $this->input->post('id');
        if($id != ''){
        $this->this_model->package_add_update($this->input->post());
        $this->session->set_flashdata('msg', 'Package has been updated successfully');
                redirect(base_url() . 'package');
        }else{
        $this->this_model->package_add_update($this->input->post());
        $this->session->set_flashdata('msg', 'Package has been added successfully');
                redirect(base_url() . 'package');
        }
        // $this->this_model->package_add_update();
    }
    public function single_delete_package(){
        if($this->input->get()){
           $this->this_model->single_delete_package($this->input->get());
        }
    }
    public function multi_delete_package()
    {
        $this->this_model->multi_delete_package();
    }

    public function isPakageAvailable(){
        if($this->input->post()){
            echo $this->this_model->checkIsPakageAvailable($this->input->post());
        }
    }


}
?>