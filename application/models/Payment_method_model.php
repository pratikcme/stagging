<?php 

class Payment_method_model extends My_model
{
	
	public function get_payment_method(){

		$branch_id = $this->session->userdata['id'];

		$data['select'] = ['pm.*','pg.name as getway_name'];
		$data['table'] = 'payment_method as pm';
		$data['join'] = [
			'payment_getway as pg'=>['pg.type = pm.payment_opt','left']
		];
		$data['where'] = ['pm.branch_id' => $branch_id];
        $data['groupBy'] = 'pm.id';
		return $this->selectFromJoin($data);
		// echo $this->db->last_query();die;
	}

	public function getPaymentGetway(){
        // if($id != ''){
        //     $data['where'] = ['id'=>]
        // }
		$data['select'] = ['*'];
		$data['table'] = 'payment_getway';
		return $this->selectRecords($data);
	}

	public function add_update_payment_method($postData){
		// print_r($postData);die;
		
		$branch_id = $this->session->userdata['id'];
		if(!empty($postData['id'])){

			$updatePayment_Config = [
                'payment_opt' => $postData['payment_opt'],
				'publish_key' => trim($postData['publish_key']),
				'test_publish_key' => trim($postData['test_publish_key']),
				'secret_key' => trim($postData['secret_key']),
				'test_secret_key' => trim($postData['test_secret_key']),
				'dt_updated' => date('Y-m-d h:i:s'),
			];
			$data['update'] = $updatePayment_Config;
			$data['table'] = 'payment_method';
			$data['where'] = ['id' => $postData['id']];
			$this->updateRecords($data);
			 $this->session->set_flashdata('msg', 'payment method has been updated successfully');
                redirect(base_url() . 'payment_method');
                exit();

		}else{
			$insertPayment_Config = [
                'branch_id' => $branch_id,
				'payment_opt' => $postData['payment_opt'],
				'publish_key' => trim($postData['publish_key']),
				'test_publish_key' => trim($postData['test_publish_key']),
				'secret_key' => trim($postData['secret_key']),
				'test_secret_key' => trim($postData['test_secret_key']),
				'dt_added' => date('Y-m-d h:i:s'),
			];

			// print_r($insertPayment_Config);die;
			$data['insert'] = $insertPayment_Config;
			$data['table'] = 'payment_method';
			$this->insertRecord($data);
			 $this->session->set_flashdata('msg', 'payment method has been added successfully');
                redirect(base_url() . 'payment_method');
                exit();
		}
		
	}

	 public function check_publish_key($postData){
	 	// print_r($postData);exit;
        $branch_id = $this->session->userdata['id'];
        $publish_key = trim($postData['publish_key']);
        $payment_methodId = $postData['payment_methodId'];
       	 
       	if($payment_methodId != ''){
			$data['where']['id !='] = $payment_methodId;       		
       	}
        $data['table'] = 'payment_method';
        $data['select'] = ['*'];
        $data['where']['publish_key'] = $publish_key;
        $data['where']['branch_id'] = $branch_id; 
        return $this->selectRecords($data);
       
    } 
    public function check_secret_key($postData){
	 	// print_r($postData);exit;
         $branch_id = $this->session->userdata['id'];
        $secret_key = trim($postData['secret_key']);
        $payment_methodId = $postData['payment_methodId'];
       
      	if($payment_methodId != ''){
			$data['where']['id !='] = $payment_methodId;       		
       	}
        $data['table'] = 'payment_method';
        $data['select'] = ['*'];
        $data['where']['secret_key'] = $secret_key;
        $data['where']['branch_id'] = $branch_id;

        return $this->selectRecords($data);
      
    }

    public function payment_method_change_status($id){
        
    	 $branch_id = $this->session->userdata('id');
    	 $data = array('status'=>'0','dt_updated'=> date('Y-m-d H:i:s'));
         $this->db->update('payment_method',$data,['branch_id' => $branch_id]);
    	 

        $id = $this->utility->decode($id);
        $data = array('status'=>'1','dt_updated'=> date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $res = $this->db->update('payment_method',$data);
        // echo $this->db->last_query();die;
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    public function delete_payment_method()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('payment_method');

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    public function changeTestOrLive($postData){
    		$branch_id = $this->session->userdata('id');
		 	$value = $postData['keyStatus'];
    		if($value== 1){
    			$value = '0';
    		}else{
    			$value = '1';
    		}
    	$data['table'] = 'payment_method';
    	$data['update'] = ['IsTestOrLive'=>$value];
    	$data['where'] = ['branch_id'=>$branch_id];
    	$update = $this->updateRecords($data);
    	if($update ){
    		return $value;
    	}else{
    		return false;
    	}
    }
}
?>