<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Category extends Vendor_Controller{
    function __construct(){
        parent::__construct();
        $vendor_id = $this->session->userdata['id'];
        $this->load->model('category_model','this_model');
    }
    
    public function index(){
        $this->load->view('category_list');

    }

    public function category_list(){
        $data['category_result'] = $this->this_model->categoryList();
        // print_r($data['category_result']);die;
        $data['table_js'] = array('cat_subcat.js');
        $data['start'] = array('CAT_SUBCAT.table()');
        $this->load->view('category_list',$data);
    }
    public function getAjaxCategoryList(){
        if($this->input->post()){
            echo getAjaxCategory($this->input->post());
        }
    }
    public function category_profile()
    {    
        @$id = $this->utility->decode($_GET['id']); 
        if( $id != ''){
           $res = $this->this_model->catProfile($id);   
            $data['result'] = $res[0]; 
        }else{
            $data = [];
        }
        $this->load->view('category_profile',$data);
    }
    public function category_add_update()
    {
        $this->this_model->category_add_update();
    }
    public function single_delete_category(){

        $this->this_model->single_delete_category();
    }
    public function isCategoryAvailable(){
        // print_r($this->input->post());die;
        if($this->input->post()){
            echo $this->this_model->checkIsCategoryAvailable($this->input->post());
        }
    }
    public function check_category()
    {   

        $this->this_model->check_category();
    }
    public function multi_delete_category()
    {
        $this->this_model->multi_delete_category();
    }
    public function multi_deleted_category()
    {
    
        $this->this_model->multi_deleted_category();
    }
   
}

?>