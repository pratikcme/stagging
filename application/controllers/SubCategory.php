<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class SubCategory extends Vendor_Controller
{
     function __construct(){

        parent::__construct();
        $vendor_id = $this->session->userdata['id'];
        $this->load->model('subcategory_model','this_model');
    }

    public function index(){
        $data['subCategory_result'] = $this->this_model->getSubcategory();
        // print_r($data['subCategory_result']);die;
        $data['table_js'] = array('cat_subcat.js');
        $data['start'] = array('CAT_SUBCAT.table2()');
        $this->load->view('subCategory_list',$data);
    }

    public function getAjaxSubCategory(){
        if($this->input->post()){
            echo getSubcategoryAjax($this->input->post());
        }
    }

    public function subCategory_list(){
        $this->load->view('subCategory_list');
    }

    public function subCategory_profile(){
        @$id = $this->utility->decode($_GET['id']);
        if($id != ''){
            $subcate_byId = $this->this_model->subcategoryByid($id);
            $data['result'] = $subcate_byId[0];
            $category_id = $data['result']['category_id'];
            $cat = $this->this_model->getcatByid($category_id);
            $data['cat_result'] = $cat[0];
        }
        
        $data['category_result'] = $this->this_model->getCategoryList();

        $this->load->view('subCategory_profile',$data);
    }

    public function subCategory_add_update(){
        @$id = $this->utility->decode($_POST['id']);
        if(isset($_POST['submit'])) {
            /* subCategory Update */
            if ($_POST['id'] != '') {
                $this->this_model->updateSubcategory($this->input->post());
                $this->session->set_flashdata('msg', 'Subcategory has been updated successfully');
                redirect(base_url() . 'subCategory');
                exit();
            }
            /* subCategory Add */
            else {
                $this->this_model->insertSubcategory($this->input->post());
                $this->session->set_flashdata('msg', 'Subcategory has been added successfully');
                redirect(base_url() . 'subCategory');
                exit();
                }
            }
        }

    public function single_delete_subCategory(){
        if($this->input->get()){
            $this->this_model->deleteSubcategory($this->input->get());
        };
        die;
        // $this->this_model->single_delete_subCategory();
    }
    public function check_subcategory()
    {
        $this->this_model->check_subcategory();
    }
    public function multi_delete_subCategory()
    {
        $this->this_model->multi_delete_subCategory();
    }
    public function multi_deleted_subCategory(){
        if($this->input->get()){
            $this->this_model->multi_deleted_subCategory($this->input->get());
        };
    }
    public function get_valid_subcate(){
        // print_r($this->input->post());
        if($this->input->post()){
           $this->this_model->get_valid_subcate($this->input->post());
        }
     }
}
?>