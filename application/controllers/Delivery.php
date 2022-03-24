<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Delivery extends MY_Controller
{
    function __construct(){

        parent::__construct();
        $vendor_id = $this->session->userdata['id'];
        $this->load->model('delivery_model','this_model');
        // $this->load->model('common_model');
        // $siteDetail = $this->common_model->getLogo();
        // $this->siteLogo = $siteDetail['logo'];
        // $this->siteTitle = $siteDetail['webTitle'];
        // $this->siteFevicon = $siteDetail['favicon_image'];
        // $this->folder = $siteDetail['folder'];
    }
    public function delivery_admin(){
      
        $this->load->view("delivery_admin");
    }
    public function delivery_user(){

      if(isset($_POST['submit1'])){
        $this->this_model->delivery_user_register();  
      }
        $this->load->view("delivery_user");
    }
    public function update_delivery()
    {
      $this->this_model->update_delivery_admin();
      $this->load->view("delivery_admin");
    }
    public function delivery_list()
    {
      $data['user_result'] = $this->this_model->getDeliveryUser();
        $this->load->view('delivery_list',$data);
    }

    public function get_valid_email()
    {
        $return = $this->this_model->get_valid_email();
        echo $return;
    }
    public function get_valid_mobile()
    {
        $return = $this->this_model->get_valid_mobile();
        echo $return;
    }
    public function new_vendor_register()
    { 
       if(isset($_POST['id']) && $_POST['id']!=''){
          $re = $this->this_model->new_vendor_register(); 
        exit;

          if($re){
           if(isset($_POST['web'])){          
                $this->load->view('vendor_profile');
              }else{
                $this->load->view("add_vendor");
              }       
              
          }

        }else{
            $validate = $this->setRulesVendor($_POST);
            if($validate){
              $this->this_model->new_vendor_register();       
            }else{     
              if(isset($_POST['web'])){          
                $this->load->view('vendor_profile');
              }else{
                $this->load->view("add_vendor");
              }            
            }            
        }



    }

  public function status_change($id=''){
    
    if($this->input->post()){
      $id = $_POST['id'];
      $this->this_model->change_status($id);
    }

  }
  

}
?>