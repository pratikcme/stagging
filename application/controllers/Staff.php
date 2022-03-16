<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Staff extends Vendor_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->model('vendor_model','this_model');

  }
  public function index()
  {
    $data['user_result'] = $this->this_model->getStaff();
    $data['table_js'] = array('staff.js');
    $data['start'] = array('STAFF.table()');
    $this->load->view("staff_list",$data);
  }

  public function getAjaxStaffList(){
    if($this->input->post()){
      echo getStaffListAjax($this->input->post());
    }
  }

  // validation

  public function get_valid_emails()
  {
      $return = $this->this_model->get_valid_emails();
      echo $return;
  }
  public function get_valid_mobiles()
  {
      $return = $this->this_model->get_valid_mobiles();
      echo $return;
  }

  public function add_staff()
  {
    @$id = $this->utility->decode($_GET['id']);
   if($id != ''){
      $record = $this->this_model->getEditData($id);
      $data['result'] = $record[0]; 
   }else{
      $data = [];
   }
    $this->load->view("add_staff",$data);
  }
  public function status_change()
  {
      $id = $_GET['id'];
      $this->this_model->staff_change_status($id);
  }
  public function staff_add_update(){
      $validate = $this->setRulesStaff($_POST);
      if($validate){
          $this->this_model->staff_add_update();        
        }else{     
          $this->load->view("add_staff");            
        }
    }
    function setRulesStaff($postdata){
    if(isset($postdata['id'])){
    @$email = $postdata['email'];
    $orignalemail = $postdata['hidden_email'];
    $mobile = $postdata['mobile'];
    $orignalphone = $postdata['hidden_mobile'];
     if($email != $orignalemail){
            $is_unique_mail =  '|is_unique[staff.email]';
        }else{
            $is_unique_mail =  '';
        }
      if($mobile != $orignalphone){
            $is_unique_mobile =  '|is_unique[staff.phone_no]';
        }else{
            $is_unique_mobile =  '';
        }
      
    }else{
      $is_unique_mobile =  '|is_unique[staff.phone_no]';
      $is_unique =  '|is_unique[staff.email]';
    }
        $config = array(
         
             array('field' => 'mobile', 
                  'label' => 'mobile', 
                  'rules' => 'trim|required'.$is_unique_mobile,
                   "errors" => [
                        'required' => "please select phone_no name",
                        'is_unique' => 'This mobile number is already registered',
                    ] 
                ),
        
             array('field' => 'name', 
                  'label' => 'name', 
                  'rules' => 'trim|required',
                   "errors" => [
                        'required' => "please select phone_no name",
                       
                    ] 
                ), 
             array('field' => 'password', 
                  'label' => 'password', 
                  'rules' => 'trim|required',
                   "errors" => [
                        'required' => "please select phone_no name",
                        
                    ] 
                ),
         
            
        );

        $this->form_validation->set_rules($config);
        $het =  $this->form_validation->run();
       
         if( $het == FALSE){
            // echo validation_errors(); exit();
       

         }
         else{
            return true;
        }
    }

}
?>