<?php
class Setting_model extends My_model{

     function __construct(){
      $this->load->model('common_model');
      $re = $this->common_model->getExistingBranchId();
      $this->branch_id = $re[0]->id;
      $this->vendor_id = $this->session->userdata['vendor_admin_id'];
    }

    public function cart_add(){
    	$cart_min_value = $this->input->post('cart_min_value');
    	$id = $this->input->post('id');
    	if($id==''){
    		$insertion = array('vendor_id'=>$this->vendor_id,'value'=>$cart_min_value,'request_id'=>1);
    		$data['insert'] = $insertion;
    		$data['table'] = 'set_default';
    		$result = $this->insertRecord($data);
    		$this->session->set_flashdata('msg', 'Minimum cart value has been set successfully');
    	}else{
    		$insertion = array('value'=>$cart_min_value);
    		$data['update'] = $insertion;
    		$data['where']['id'] = $id;
    		$data['table'] = 'set_default';
    		$result = $this->updateRecords($data);
    	$this->session->set_flashdata('msg', 'Minimum cart value has been updated successfully');
    	}
        redirect(base_url() . 'setting/cart_value');
        exit();
    }

     public function currency_add(){
        $currency = $this->input->post('currency');
        $id = $this->input->post('id');
        if($id==''){
            $insertion = array('value'=>$currency,'request_id'=>3,'vendor_id'=>$this->vendor_id);
            $data['insert'] = $insertion;
            $data['table'] = 'set_default';
            $result = $this->insertRecord($data);
            $this->session->set_flashdata('msg', 'Currency has been set successfully');
        }else{
            $insertion = array('value'=>$currency,'vendor_id'=>$this->vendor_id);
            $data['update'] = $insertion;
            $data['where']['id'] = $id;
            $data['table'] = 'set_default';
            $result = $this->updateRecords($data);
        $this->session->set_flashdata('msg', 'Currency has been updated successfully');
        }
        redirect(base_url() . 'setting/currency');
        exit();
    }
    public function profit_add(){
        $profit = $this->input->post('profit');
        $id = $this->input->post('id');
        if($id==''){
            $insertion = array('value'=>$profit,'request_id'=>2,'vendor_id'=>$this->vendor_id);
            $data['insert'] = $insertion;
            $data['table'] = 'set_default';
            $result = $this->insertRecord($data);
            $this->session->set_flashdata('msg', 'Profit Percentage has been set successfully');
        }else{
            $insertion = array('value'=>$profit,'request_id'=>2);
            $data['update'] = $insertion;
            $data['where']['id'] = $id;
            $data['table'] = 'set_default';
            $result = $this->updateRecords($data);
        $this->session->set_flashdata('msg', 'Profit Percentage has been updated successfully');
        }
        redirect(base_url() . 'setting/profit_percent');
        exit();
    }
    public function subscription_add(){
        $subscription_value = $this->input->post('subscription_value');
        $id = $this->input->post('id');
        if($id==''){
            $insertion = array('value'=>$subscription_value,'request_id'=>4,'vendor_id'=>$this->vendor_id);
            $data['insert'] = $insertion;
            $data['insert'] = ['branch_id'=>$this->branch_id];
            $data['table'] = 'set_default';
            $result = $this->insertRecord($data);
            $this->session->set_flashdata('msg', 'Subscrption pack value has been set successfully');
        }else{
            $insertion = array('value'=>$subscription_value);
            $data['update'] = $insertion;
            $data['where']['id'] = $id;
            $data['table'] = 'set_default';
            $result = $this->updateRecords($data);
            $this->session->set_flashdata('msg', 'Subscrption pack value has been updated successfully');
        }
        redirect(base_url() . 'setting/subscription');
        exit();
    }

    public function getDefaultCurrency(){
        $data['table'] = 'set_default';
        $data['select'] = ['*'];
        $data['where'] = ['request_id'=>'3','vendor_id'=>$this->vendor_id];
        $result = $this->selectRecords($data,true);
        return $result[0];
    }

    public function getCartValue(){
        $data['table'] = 'set_default';
        $data['select'] = ['*'];
        $data['where'] = ['request_id'=>'1','vendor_id'=>$this->vendor_id];
        $result = $this->selectRecords($data,true);
        return $result[0];   
    }

    public function getDefaultPercentage(){
        $data['table'] = 'set_default';
        $data['select'] = ['*'];
        $data['where'] = ['request_id'=>'2','vendor_id'=>$this->vendor_id];
        $result = $this->selectRecords($data,true);
        return $result[0]; 
    }
}
 ?>