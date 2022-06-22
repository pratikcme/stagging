<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Vendor extends CI_Controller
{
    function __construct(){

        parent::__construct();
        $this->load->model('vendor_model','this_model');
        $this->load->model('common_model');
        $siteDetail = $this->common_model->getLogo();
        $this->siteLogo = $siteDetail['logo']; 
        $this->siteTitle = $siteDetail['webTitle'];
        $this->folder = $siteDetail['folder'];
        require_once APPPATH . 'config/tablenames_constants.php';
    }

    private function Authenticate(){
      if($this->session->userdata('vendor_admin') != '1' ){
          if ($this->session->userdata('branch_admin') != '') {
            redirect(base_url().'admin/dashboard');
          }
            redirect(base_url().'admin/login');
        }
        return true;
    }

    public function vendor_list()
    {
        $this->authenticate();
        $data['user_result'] = $this->this_model->vendorList();
        $data['table_js'] = array('vendor.js');
        $data['start'] = array('VENDOR.table()');
        $this->load->view('vendor_list',$data);
    }

    public function ajax_vendor_list(){
      // print_r($this->input->post());die;
      $fetch_data =  $this->this_model->make_datatables($this->input->post());
      $data = array();
           $count = $this->input->post('start')+1;
           foreach($fetch_data as $row)  
           {

          if ($row->status == 1) { 
              $status = '<input type="button" data-val='.$this->utility->encode($row->id).' class="vendor_status btn btn-primary btn-xs" value="active">';
             } else { 
            $status = '<input type="button" data-val='.$this->utility->encode($row->id).' class="vendor_status btn btn-danger btn-xs" value="In-active">';
         } 


                $sub_array = array();  
                $sub_array[] = $count++;  
                $sub_array[] = $row->name;  
                $sub_array[] = $row->owner_name;  
                $sub_array[] = $row->phone_no;  
                $sub_array[] = $row->email;  
                $sub_array[] = $status;  
                $sub_array[] = '<a href='.base_url().'vendor/vendor_profile?id='.$this->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>';  
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($this->input->post('draw')),  
                "recordsTotal"          =>      $this->this_model->get_all_data(),  
                "recordsFiltered"     =>        $this->this_model->get_filtered_data($this->input->post()),  
                "data"                    =>     $data  
           );

        echo  json_encode($output); 
    }

    public function add_vendor()
    {
        $this->load->view("add_vendor");
    }

    public function vendor_profile()
    {
      $this->authenticate();
      @$id = $this->utility->decode($_GET['id']);
       if($id != ''){
          $data['result'] = $this->this_model->vendorById($id);
          // dd($data['result']);die;
      }else{
       $vendor = $this->this_model->AvailableVendorAndApprovedBranch(ADMIN,'id',$this->session->userdata['vendor_admin_id']);
       $branch = $this->this_model->AvailableVendorAndApprovedBranch(TABLE_BRANCH,'vendor_id',$this->session->userdata['vendor_admin_id']);
        if($vendor[0]->approved_branch  == count($branch) ){
          $this->utility->setFlashMessage('danger', 'You have already added '.$vendor[0]->approved_branch.' branches');
          redirect('vendor/vendor_list');
          exit;
        }

      }
      $data['subs_charge'] = $this->this_model->setDefault();
      $this->load->view("vendor_profile",$data);
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
      // echo '<pre>';
      // print_r($_SESSION);die;
       if(isset($_POST['id']) && $_POST['id']!=''){
          $re = $this->this_model->new_vendor_register();        
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
    public function  vendor_accounting(){
      $this->authenticate();
        $data['user_result'] = $this->this_model->vendorList();
        $data['profit_result'] = $this->this_model->getProfits();
        $get_vendor = array();
        foreach ($data['profit_result'] as $key => $value) {
          $vendor = $value->vendor_id;
          if(isset($set_profit[$vendor]) && $set_profit[$vendor]!=''){
            $profit[$vendor] = $value->total_profit+$profit[$vendor];
          }else{    
            $profit[$vendor] = $value->total_profit;
            $set_profit[$vendor] = $value->total_profit;
          }
           $get_vendor[$vendor] = $profit[$vendor]; 
        }
        $data['profit_take_result'] = $this->this_model->profit_query_take();
        // print_r($data['profit_take_result']);die;
        $get_vendor_profit = array();

      foreach ($data['profit_take_result'] as $key => $value) {
        $vendor = $value->vendor_id;
        if(isset($set_profit_taken[$vendor]) && $set_profit_taken[$vendor]!=''){
          $profit_taken[$vendor] = $value->profit+$profit_taken[$vendor];
        }else{    
          $profit_taken[$vendor] = $value->profit;
          $set_profit_taken[$vendor] = $value->profit ;
        }
         $get_vendor_profit[$vendor] = $profit_taken[$vendor]; 
      }
      
        $data['get_vendor_profit'] = $get_vendor_profit;
        $data['get_vendor'] = $get_vendor;
        $data['table_js'] = array('vendor.js');
        $data['start'] = array('VENDOR.table2()');
        $this->load->view('vendor_accounting',$data);
    }

    public function GetVendorAccounting(){
      $this->authenticate();
      if($this->input->post()){
        echo GetVendorAccounting($this->input->post());
      }
    }



    public function  set_profit(){
      error_reporting(0);
       if($this->input->post('submit1')){
          $id = $this->input->post('id');
           $id = $this->utility->encode($id);
          $result = $this->this_model->profit_add($this->input->post());
          if($result==1){
             $this->session->set_flashdata('msg', 'Profit added successfully');
          }else{
            $this->session->set_flashdata('msg-error', 'Error to add profit');
          } 
            redirect('vendor/set_profit?id='.$id);
       }
       if(isset($_GET['id']) && $_GET['id'] != ''){
        $id = $this->utility->decode($_GET['id']);
        $data['result'] = $this->this_model->vendorById($id);
        $data['store_name'] = $result['result']['name'];
        $data['owner_name'] = $result['result']['owner_name'];
        $data['profit_result'] = $this->this_model->profitQuery($id);
        $data['profit_take_result'] = $this->this_model->profitQueryTaken($id);
        $data['order_detail_result'] = $this->this_model->orderDetailQuery($id);
        $data['profit_result_detail'] = $this->this_model->profit_take_detail($id);

        $data['order_result'] = $this->this_model->order_result($id);
        $data['order_id'] = $data['order_result'][0]->id;
        // print_r($data['order_detail_result']);die;
       }else{
        redirect(base_url().'vendor/vendor_accounting');
       }
       $data['getcurrency'] = $this->this_model->setProfitCurrency();
       // print_r($data['getcurrency']);die;
       $this->load->view('set_profit',$data);
    }

  public function vendor_status_change($id=''){
    $this->authenticate();
    if($this->input->post()){
      $id = $_POST['id'];
      $this->this_model->vendor_change_status($id);
    }
  }
  
  function setRulesVendor($postdata){
    if(isset($postdata['id'])){
    $email = $postdata['email'];
    $orignalemail = $postdata['hidden_email'];
    $mobile = $postdata['mobile'];
    $orignalphone = $postdata['hidden_mobile'];
     if($email != $orignalemail){
            $is_unique_mail =  '|is_unique[vendor.email]';
        }else{
            $is_unique_mail =  '';
        }
      if($mobile != $orignalphone){
            $is_unique_mobile =  '|is_unique[vendor.phone_no]';
        }else{
            $is_unique_mobile =  '';
        }
      
    }else{
      $is_unique_mobile =  '|is_unique[vendor.phone_no]';
      $is_unique_mail =  '|is_unique[vendor.email]';
    }

        $config = array(
            array('field' => 'email', 
                  'label' => 'email', 
                  'rules' => 'trim|required|valid_email'.$is_unique_mail,
                   "errors" => [
                        'required' => "please select email name",
                        'valid_email' => "please enter a valid email address",
                        'is_unique' => 'This email is already exist',
                    ] 
                ),
             array('field' => 'mobile', 
                  'label' => 'mobile', 
                  'rules' => 'trim|required'.$is_unique_mobile,
                   "errors" => [
                        'required' => "please enter mobile number",
                        'is_unique' => 'This mobile number is already registered',
                    ] 
                ),
             array('field' => 'latitude', 
                  'label' => 'latitude', 
                  'rules' => 'trim|required',
                   "errors" => [
                        'required' => "please latitude is not found",
                       
                    ] 
                ),
             array('field' => 'longitude', 
                  'label' => 'longitude', 
                  'rules' => 'trim|required',
                   "errors" => [
                        'required' => "please longitude is not found",
                       
                    ] 
                ),
             array('field' => 'name', 
                  'label' => 'name', 
                  'rules' => 'trim|required',
                   "errors" => [
                        'required' => "please enter name",
                       
                    ] 
                ), 
             array('field' => 'ownername', 
                  'label' => 'ownername', 
                  'rules' => 'trim|required',
                   "errors" => [
                        'required' => "please enter owner name",
                       
                    ] 
                ), 
             array('field' => 'password', 
                  'label' => 'password', 
                  'rules' => 'trim|required',
                   "errors" => [
                        'required' => "please enter password ",
                        
                    ] 
                ),
              array('field' => 'address', 
                  'label' => 'address', 
                  'rules' => 'trim|required',
                   "errors" => [
                        'required' => "please enter address ",
                        
                    ] 
                ),
             array('field' => 'location', 
                  'label' => 'location', 
                  'rules' => 'trim|required',
                   "errors" => [
                        'required' => "Location in not found",
                        
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