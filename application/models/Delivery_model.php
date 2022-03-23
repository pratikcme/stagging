<?php
class Delivery_model extends My_model{
    
    function __construct(){
    
     $this->branch_id = $this->session->userdata('id');
    }

    public function getDeliveryUser(){
        $data['table'] = 'delivery_user';
        $data['select'] = ['*'];
        $data['where'] = ['status!='=>'9','branch_id'=>$this->branch_id];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
    }

    public function update_delivery_admin(){
        $name = $this->input->post('fname');
        $phone = $this->input->post('phone');
        $data = array(
                'name' => $name,
                'phone_no' => $phone,
                'dt_updated' => date('Y-m-d H:i:s')
            );
        $this->db->where('type','2');
        $this->db->update('admin', $data);
    }
   public function delivery_user_register(){
     
    if(isset($_POST['submit1'])){
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $id = $_POST['id'];                 
        if(isset($_POST['id']) && $_POST['id']!=''){

        $query = $this->db->query("SELECT image,id_proof_image FROM delivery_user WHERE id = '$id'");
        $result = $query->row_array();

            if($_FILES['image_edit']['name'] != ''){
                $old_image = $result['image'];
                
                $url = './public/images/delivery_profile'.$old_image;
                unlink($url);
                $files = $_FILES;
                
                $profile_upload_path = "./public/images/delivery_profile";
                $uploadResponse = upload_single_image_ByName($_FILES,'image_edit',$profile_upload_path);
                
            // print_r($uploadResponse);exit;
                $profile_image = $uploadResponse['data']['file_name'];  
             
            }else{
              
                $profile_image = $result['image'];
               
            }

            if($_FILES['id_image_edit']['name'] != ''){
                $id_old_image = $result['id_proof_image'];
                $url = './public/images/delivery_id'.$id_old_image;
                unlink($url);
                $id_upload_path = "./public/images/delivery_id";
                $files = $_FILES;
           
                $id_uploadResponse = upload_single_image_ByName($_FILES,'id_image_edit',$id_upload_path);
                $id_image = $id_uploadResponse['data']['file_name']; 
            }else{
                $id_image = $result['id_proof_image'];
            }
            // echo $profile_image;exit;
            $dataupdate = array(
            'image' => $profile_image,
            'id_proof_image' => $id_image,
            'name' => $_POST['name'],
            'vehicle_name' => $_POST['vehicle_name'],
            'vehicle_type' => $_POST['vehicle_type'],
            'vehicle_number' => $_POST['vehicle_number'],
            
            'id_proof_number' => $_POST['id_proof_number'],
            'phone_no' => $_POST['mobile'],
            // 'status' => '1',
            'dt_updated' => date('Y-m-d H:i:s'),
            );
            
            $this->db->where('id',$id);
            $this->db->update('delivery_user', $dataupdate);
            $this->session->set_flashdata('msg', 'Vendor updated successfully');
                }else{
                   
                    $profile_upload_path = "./public/images/delivery_profile";
                    $id_upload_path = "./public/images/delivery_id";
                    $files = $_FILES;
                   
                    $id_uploadResponse = upload_single_image_ByName($_FILES,'id_image',$profile_upload_path);

                   
                    $uploadResponse = upload_single_image_ByName($_FILES,'image',$id_upload_path);
                   
                    $profile_image = $uploadResponse['data']['file_name'];  
                    $id_image = $id_uploadResponse['data']['file_name'];  
                    
                    $data = array(
                    'branch_id' => $this->branch_id,
                    'image' => $profile_image,
                    'id_proof_image' => $id_image,
                    'name' => $_POST['name'],
                    'vehicle_name' => $_POST['vehicle_name'],
                    'vehicle_type' => $_POST['vehicle_type'],
                    'vehicle_number' => $_POST['vehicle_number'],
                    'email' => $_POST['email'],
                    'id_proof_number' => $_POST['id_proof_number'],
                    'password' => md5($_POST['password']),
                    'phone_no' => $_POST['mobile'],
                    'status' => '1',
                    'dt_added' => date('Y-m-d H:i:s'),
                    'dt_updated' => date('Y-m-d H:i:s'),
                    );
                    $this->db->insert('delivery_user', $data);
                    $this->session->set_flashdata('msg', 'Delivery user added successfully');
                }
              redirect('delivery/delivery_list');
               
            
        }else{
             redirect('admin/login');
        }
    }
    

    public function change_status($id){
        
        $id = $this->utility->decode($id);

        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('status','1');
        $this->db->from('delivery_user');
        $query = $this->db->get();
       
        if ( $query->num_rows() > 0 )
        {
            $data = array('status'=>'0','dt_updated'=> date('Y-m-d H:i:s'));
           $this->db->where('id',$id);
           $this->db->update('delivery_user',$data);
        }else{
            $data = array('status'=>'1','dt_updated'=> date('Y-m-d H:i:s'));
           $this->db->where('id',$id);
           $this->db->update('delivery_user',$data);
        }
       

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;

    }
    public function staff_add_update(){
       
         if(isset($_POST['submit1'])){
                $vendor_id = $this->session->userdata['id'];
                $email = $_POST['email'];
                $password = md5($_POST['password']);
                if(isset($_POST['id']) && $_POST['id']!=''){
                    $dataupdate = array(
                        'vendor_id' => $vendor_id,                    
                        'name' => $_POST['name'], 
                        'phone_no' => $_POST['mobile'],                        
                        'dt_added' => date('Y-m-d H:i:s'),
                        'dt_updated' => date('Y-m-d H:i:s'),
                    );
                    $id = $_POST['id'];
                    $this->db->where('id',$id);
                    $this->db->update('staff', $dataupdate);
                $this->session->set_flashdata('msg', 'Staff updated successfully');
                }else{
                    $data = array(
                    'vendor_id' => $vendor_id,                    
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'password' => md5($_POST['password']),
                    'phone_no' => $_POST['mobile'],
                    'status' => '0',
                    'dt_added' => date('Y-m-d H:i:s'),
                    'dt_updated' => date('Y-m-d H:i:s'),
                );
                    $this->db->insert('staff', $data);
                $this->session->set_flashdata('msg', 'Staff added successfully');
                }
              
             
                redirect('staff');

             
               
            
        }else{
             redirect('admin/login');
        }
    }
    public function staff_change_status($id){

        $id = $this->utility->decode($id);
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->where('status','1');
        $this->db->from('staff');
        $query = $this->db->get();
       
        if ( $query->num_rows() > 0 )
        {
            $data = array('status'=>'0');
           $this->db->where('id',$id);
           $this->db->update('staff',$data);
        }else{
            $data = array('status'=>'1');
           $this->db->where('id',$id);
           $this->db->update('staff',$data);
        }

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;

    }
    function getChartData(){
    $vendor_id = $this->session->userdata['id'];
      
         $month = strtotime(date('Y-m-01 00:00:00'));  

        $vendor_id = $this->session->userdata['id'];

        $total_order_month = $this->db->query("SELECT o.product_id,COUNT(o.product_id) AS Todal_count,p.name FROM `order_details` AS o  LEFT JOIN product as p on o.product_id = p.id WHERE o.vendor_id='$vendor_id' AND o.dt_added >= '$month' GROUP BY o.product_id order by todal_count DESC limit 10")->result();

        $color = ['red','blue','grey','black','green','pink','yellow','brown','orange','purple'];
        for($i=0;$i<count($total_order_month);$i++){
            $finalArray[] = array(
                'name' => $total_order_month[$i]->name,
                'value' => $total_order_month[$i]->Todal_count,
                'color' =>$color[$i]
            );
        }
       
        return $finalArray;
    }

    public function get_valid_email(){
        $email = $this->input->post('email');
        $data['select'] = ['email'];
        $data['where'] = ['email'=>$email];
        $data['table'] = "delivery_user";
        $result = $this->selectRecords($data);
        
        if($result){
            return "false";
        }else{
            return "true";
        }
    }
    public function get_valid_mobile(){

        if($this->input->post('hidden_m')){
            $id = $this->input->post('hidden_m');
            $mobile = $this->input->post('mobile');
            
            $data['select'] = ['phone_no'];
            $data['where'] = ['id'=>$id];
            $data['table'] = "delivery_user";
            $result = $this->selectRecords($data);

            if($result[0]->phone_no == $mobile){
               return "true";
            }else{
                $mobile = $this->input->post('mobile');
                $data['select'] = ['phone_no'];
                $data['where'] = ['phone_no'=>$mobile];
                $data['table'] = "delivery_user";
                $result = $this->selectRecords($data);

                if($result){
                     return "false";
                }else{
                    return "true";
                 }
            }
            
        }

        $mobile = $this->input->post('mobile');
        $data['select'] = ['phone_no'];
        $data['where'] = ['phone_no'=>$mobile];
        $data['table'] = "delivery_user";
        $result = $this->selectRecords($data);

        if($result){
            return "false";
        }else{
            return "true";
        }
    }

     public function get_valid_emails(){
        $email = $this->input->post('email');
        $data['select'] = ['email'];
        $data['where'] = ['email'=>$email];
        $data['table'] = "staff";
        $result = $this->selectRecords($data);
        
        if($result){
            return "false";
        }else{
            return "true";
        }
    }

        public function get_valid_mobiles(){

        if($this->input->post('hidden_m')){

            $id = $this->input->post('hidden_m');
            $mobile = $this->input->post('mobile');

            $data['select'] = ['phone_no'];
            $data['where'] = ['id'=>$id];
            $data['table'] = "staff";
            $result = $this->selectRecords($data);

            if($result[0]->phone_no == $mobile){
               return "true";
            }else{
                $mobile = $this->input->post('mobile');
                $data['select'] = ['phone_no'];
                $data['where'] = ['phone_no'=>$mobile];
                $data['table'] = "staff";
                $result = $this->selectRecords($data);

                if($result){
                     return "false";
                }else{
                    return "true";
                 }
            }
            
        }

        $mobile = $this->input->post('mobile');
        $data['select'] = ['phone_no'];
        $data['where'] = ['phone_no'=>$mobile];
        $data['table'] = "staff";
        $result = $this->selectRecords($data);

        if($result){
            return "false";
        }else{
            return "true";
        }
    }

    function profit_add($postdata)
    {
        if(isset($postdata['accept_money'])){
            $profit = $postdata['accept_money'];
            $vendor_id = $postdata['id'];
            $date = date('Y-m-d H:i:s');
            $data['insert'] = array(
                                    'vendor_id'=>$vendor_id,
                                    'profit'=>$profit,
                                    'dt_created'=>$date,
                                    'dt_updated' =>$date
                                );
            $data['table'] ='profit_taken';
            $this->insertRecord($data);
            return true;
        }
        return false;
    }

}
?>