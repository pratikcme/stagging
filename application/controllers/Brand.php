<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class brand extends Vendor_Controller
{
     function __construct(){

        parent::__construct();
        $vendor_id = $this->session->userdata['id'];
        $this->load->model('brand_model','this_model');
    }

    public function brand_list(){
        $data['brand_result'] = $this->this_model->getBrandList();
        $data['table_js'] = array('brand.js');
        $data['start'] = array('BRAND.table()');
        $this->load->view('brand_list',$data);
    }

    public function getBrandlistAjax(){
        if($this->input->post()){
            echo getBrandlistAjax($this->input->post());
        }
    }

    public function isBrandAvailable(){
        if($this->input->post()){
            echo $this->this_model->checkIsBrandAvailable($this->input->post());
        }
    }

    public function brand_profile(){
        error_reporting(0); 
        $id = $this->utility->decode($_GET['id']);
       
        $data['category_result'] = $this->this_model->getAllCetegory();
        if($id != ''){
            $data['result'] = $this->this_model->getBrandByid($id);
            $category_id = $data['result']['category_id'];
            $data['set_cat_array'] = explode(",",$category_id);
            
            $data['cat_result'] = $this->this_model->cat_query($category_id);
            }
        $this->load->view('brand_profile',$data);
    }

    public function brand_add_update(){ 

        $id = $this->input->post('id');
        if(isset($_POST['submit'])) {
            if ($id != '') {
            /* Brand Update */
                $this->this_model->updateBrandData($this->input->post());
                $this->session->set_flashdata('msg', 'Brand has been updated successfully');
                redirect(base_url() . 'brand/brand_list');
            
            }else{
            /* Brand Add */
                $this->this_model->insertBrand($this->input->post());
                $this->session->set_flashdata('msg', 'Brand has been added successfully');
                redirect(base_url() . 'brand/brand_list');
                exit();
            }
        }else{
            redirect(base_url() . 'brand/brand_list');
        }
    }

    public function single_delete_brand(){
        if($this->input->get()){
            $getDta = $this->input->get();
            $this->this_model->single_delete_brand($getDta);
        }
    }
    
    public function check_brand(){
        if($this->input->get()){
         $this->this_model->check_brand($this->input->get());
        }   
    }

    public function multi_delete_brand(){
        if($this->input->get()){
           $this->this_model->multi_delete_brand($this->input->get());
        }
    }

    public function multi_deleted_brand(){
      if($this->input->get()){
        $this->this_model->multi_deleted_brand($this->input->get());
      }
    }
}
?>