<?php
class vendor_model extends My_model{

    function __construct(){
      
         $this->vendor_id = $this->session->userdata('vendor_admin_id');
    }

       public function new_vendor_register(){
        
        if(isset($_POST['submit1'])){
                $email = $_POST['email'];
                $password = md5($_POST['password']);

                if(isset($_POST['id']) && $_POST['id'] !=''){

                    $id = $_POST['id'];
                    $files = $_FILES;                  
                    if($_FILES['image_edit']['name'] != ''){
                       

                        $query = $this->db->query("SELECT image FROM branch WHERE id = '$id'");
                        $result = $query->row_array();
                        $old_image = $result['image'];
                        $url = './public/images/vendor_shop/'.$old_image;                    
                        unlink($url);
                        $upload_path = "./public/images/".$this->folder."vendor_shop";
                        $uploadResponse = upload_single_image_ByName($_FILES,'image_edit',$upload_path);
                        // print_r($uploadResponse);exit;  
                        $image = $uploadResponse['data']['file_name'];
                    }else{
                        $query = $this->db->query("SELECT image FROM branch WHERE id = '$id'");
                        $result = $query->row_array();
                        $image = $result['image'];
                    }


                    if($_FILES['logo_image_edit']['name'] != ''){
                       

                        $query = $this->db->query("SELECT logo_image FROM branch WHERE id = '$id'");
                        $result = $query->row_array();
                        $old_image = $result['logo_image'];
                        $url = './public/images/'.$this->folder.'vendor_logo_image/'.$old_image;                    
                        unlink($url);
                        $logo_upload_path = "./public/images/vendor_logo_image";
                        $uploadLogoResponse = upload_single_image_ByName($_FILES,'logo_image_edit',$logo_upload_path);
                        // print_r($uploadResponse);exit;  
                        $logo = $uploadLogoResponse['data']['file_name'];
                    }else{
                        $query = $this->db->query("SELECT logo_image FROM branch WHERE id = '$id'");
                        $res = $query->row_array();
                        $logo = $res['logo_image'];
                    }

                    $dataupdate = array(
                    'image' => $image,
                    'logo_image'=>$logo,
                    'domain_name'=>$_POST['domain_name'],
                    'store_type'=>$_POST['store_type'],
                    'location' => $_POST['location'],
                    'latitude' => $_POST['latitude'],
                    'longitude' => $_POST['longitude'],
                    'name' => $_POST['name'],
                    'address' => $_POST['address'],
                    'owner_name' => $_POST['ownername'],
                    'phone_no' => $_POST['mobile'],
                    'dt_updated' => date('Y-m-d H:i:s'),
                    );
                    $this->db->where('id',$id);
                    $this->db->update('branch', $dataupdate);
                    $this->session->set_flashdata('msg', 'Branch updated successfully');
                }else{
                    $vendor = $this->AvailableVendorAndApprovedBranch(ADMIN,'id',$this->session->userdata['vendor_admin_id']);
                    $branch = $this->AvailableVendorAndApprovedBranch(TABLE_BRANCH,'vendor_id',$this->session->userdata['vendor_admin_id']);
                    // echo "<pre>";
                    // print_r($vendor);die;
                    if(count($branch) == $vendor[0]->approved_branch){
                    $this->utility->setFlashMessage('danger', 'You have already added '.count($vendor).' branches');
                        redirect('vendor/vendor_list');
                    }
                    $image ='';
                    if(isset($_FILES['image'])){
                        $upload_path = "./public/images/".$this->folder."vendor_shop";
                        $uploadResponse = upload_single_image_ByName($_FILES,'image',$upload_path);
                        // print_r($uploadResponse);exit;
                        $image = $uploadResponse['data']['file_name'];
                    }
                    $logo = '';
                    if(isset($_FILES['logo_image']) && $_FILES['logo_image']['error'] == 0){
                        $logo_upload_path = "./public/images/".$this->folder."vendor_logo_image";
                        $uploadLogoImage = upload_single_image_ByName($_FILES,'logo_image',$logo_upload_path);
                        $logo = $uploadLogoImage['data']['file_name'];
                    }

                    $data['table'] = 'branch';
                    $data['where'] = ['vendor_id'=>$this->session->userdata('vendor_admin_id')];
                    $data['select'] = ['*'];
                    $count = $this->countRecords($data);

                    $data = array(
                        'vendor_id' => $this->session->userdata('vendor_admin_id'),
                        'image' => $image,
                        'logo_image'=>$logo,
                        'domain_name'=>$_POST['domain_name'],
                        'store_type'=>$_POST['store_type'],
                        'location' => $_POST['location'],
                        'latitude' => $_POST['latitude'],
                        'longitude' => $_POST['longitude'],
                        'name' => $_POST['name'],
                        'owner_name' => $_POST['ownername'],
                        'address' => $_POST['address'],
                        'email' => $_POST['email'],
                        'password' => md5($_POST['password']),
                        'phone_no' => $_POST['mobile'],
                        'status' => '0',
                        'subscription_plan' => $_POST['subscription_plan'],
                        'inactive_date'=> date('Y-m-d H:i:s'),
                        'dt_added' => date('Y-m-d H:i:s'),
                        'dt_updated' => date('Y-m-d H:i:s'),
                    );
                    // echo "<pre>";
                    // print_r($_POST);die;
                    // print_r($data);die;
                    $this->db->insert('branch', $data);
                    $lastId = $this->db->insert_id();
                    if($lastId != '' && $count == 0){
                        $fire_base_keys = array(
                            'vendor_id'=>$this->session->userdata('vendor_admin_id'),
                            'staff_firebase_key'=>'AAAAYmVu0RM:APA91bGMSKZnWRlSZrDilKghySf-ywPbiyRgT5C0Gnfa4-TQRI-Bz7-RiKL6FbL632rbX7mNIszlDnJ1dAogf4GFOBaSRAi5NcxnRlOdXbAxhDVoVOjXiqfICuHPCpnlGysK4_Ygitx9',
                            'delivery_firebase_key'=>'AAAADd08Ixg:APA91bHiOyFrukeepGZmHSbLAX3F9UFf7XnAg8lejb3XUa_AkU31PJMb0QW3Ys1BSHs0LKHcXr6r85QjkQPWd7lEgtGBPBD2euCzhLwEDPgz01CE65lzDisNqbKV2-adX0xKBGfuKiRJ',
                            'staff_bandle_id'=>'com.cme.launchestorestaff',
                            'delivery_bandle_id'=>'com.cme.launchestoredelivery',
                            'firebase_url'=>'https://launchestoredelivery-default-rtdb.firebaseio.com/',
                            'firebase_token'=>'XylZHjphOd9Ezqor5zVGITOjvI5EOCkO6Hi6kwsT',
                            'firebase_node'=>'LauncheStoreDelivery',
                            'team_id'=>'H4G2PA6K4T',
                            'key_id'=>'QUHR7V9B5Z',
                            'created_at'=>DATE_TIME,
                            'updated_at'=>DATE_TIME,
                        );
                        $this->db->insert('firebase', $fire_base_keys);

                        $this->db->select('*');
                        $this->db->from('set_default');
                        $this->db->where('vendor_id',$this->session->userdata('vendor_admin_id'));
                        $set = $this->db->get()->result();
                        if(!empty($set)){
                            $i = 4;
                            for ($i = 1; $i <= 4 ; $i++) { 
                                $set_default = array( 'vendor_id' => $this->session->userdata('vendor_admin_id'), 'value' => 'Rs', 'request_id' => $i);
                                $this->db->insert('set_default', $set_default);
                            }
                        }

                    }
                    $this->utility->setFlashMessage('success','Branch added successfully');
                    // $this->session->set_flashdata('msg', );
                }
                // echo 1;exit;
              if(isset($_POST['web'])){
                redirect('vendor/vendor_list');

              }else{
                redirect('admin/login');

              }
                exit();
               
            
        }else{
             redirect('admin/login');
        }
    }

    public function AvailableVendorAndApprovedBranch($table_name,$field,$id=''){
        $data['table'] = $table_name;
        $data['select'] = ['*'];
        $data['where'] = [$field=>$id];
        return $this->selectRecords($data);

    }    


    public function getAllVendor($postData = ''){
       
        if(!empty($postData)){
            $vendor_id = $postData['vendor_id'];
            $data['where'] = ['id'=>$vendor_id];
        }else{
           
            $data['where'] = ['vendor_id'=>$this->session->userdata('flag')]; 
        }
        $data['table'] = TABLE_BRANCH;
        $data['select'] = ['*'];
        return $this->selectRecords($data);
        echo $this->db->last_query();die;
    }

    public function getCurrency(){
        $data['table'] = 'currency';
        $data['select'] = ['*'];
        return $this->selectRecords($data);
    }

    public function staffTokenseToNull($vendor_id){
        $data['table'] = 'staff';
        $data['update']['token'] = 'jsdf';
        $data['where'] = ['vendor_id'=>$vendor_id];
        return $this->updateRecords($data);
    }

    public function DeleteCartOfVendorsId($vendor_id){
        $data['table'] = TABLE_MY_CART;
        $data['where'] = ['vendor_id'=>$vendor_id];
        return $this->deleteRecords($data);
    }

    public function vendor_change_status($id){
        // $id = $_GET['id']; die;
        $id = $this->utility->decode($id);
        $data['table'] = 'branch';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$id,'status'=>'1'];
        $count = $this->countRecords($data);       
        if ($count > 0 ){
            unset($data);
            $data['table'] = 'staff';
            $data['update']['token'] = '';
            $data['where'] = ['branch_id'=>$id];
            $this->updateRecords($data);
            unset($data);
            $data['table'] = 'my_cart';
            $data['where'] = ['branch_id'=>$id];
            $this->deleteRecords($data); 
            $update = array('status'=>'0','inactive_date'=> date('Y-m-d H:i:s'),'token'=>'');
        }else{
            $update = array('status'=>'1','active_date'=> date('Y-m-d H:i:s'));
        }
        unset($data);
        $data['table'] = 'branch';
        $data['where'] = ['id'=>$id];
        $data['update'] = $update;
        $this->updateRecords($data);

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;

    }
    public function staff_add_update(){
        // echo 1;exit;
         if(isset($_POST['submit1'])){
         
                $branch_id = $this->session->userdata['id'];
                $email = $_POST['email'];
                $password = md5($_POST['password']);
                if(isset($_POST['id']) && $_POST['id']!=''){
                    $dataupdate = array(
                        'branch_id' => $branch_id,                    
                        'name' => $_POST['name'], 
                        'phone_no' => $_POST['mobile'],                        
                        'vehicle_number' => $_POST['vehicle_number'],                        
                        'vehicle_name' => $_POST['vehicle_name'],                        
                        'dt_added' => date('Y-m-d H:i:s'),
                        'dt_updated' => date('Y-m-d H:i:s'),
                    );
                    $id = $_POST['id'];
                    $this->db->where('id',$id);
                    $this->db->update('staff', $dataupdate);
                $this->session->set_flashdata('msg', 'Staff updated successfully');
                }else{
                    $token = md5($this->utility->encode($postData['email']));
                    $data = array(
                    'branch_id' => $branch_id,                    
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'password' => md5($_POST['password']),
                    'phone_no' => $_POST['mobile'],
                    'vehicle_number' => $_POST['vehicle_number'],
                    'vehicle_name' => $_POST['vehicle_name'],
                    'status' => '0',
                    'email_token' => $token,
                    'email_verify'=> '1', 
                    'dt_added' => date('Y-m-d H:i:s'),
                    'dt_updated' => date('Y-m-d H:i:s'),
                );
                $staffId = $this->db->insert('staff', $data);
                 $last_id = $this->db->insert_id();
                // if ($staffId) {
                //     $staffDetail = ['id' => $last_id, 'token' => $token];
                //     $finalStaffdetail = $this->utility->encode(json_encode($staffDetail));
                //     $datas['name'] = $postData['name'];
                //     $datas['link'] = base_url() . "api_admin/verifyAccount/" . $finalStaffdetail;
                //     $datas['message'] = $this->load->view('emailTemplate/registration_mail', $datas, true);
                //     $datas['subject'] = 'Verify user email address';
                //     $datas["to"] = $email;
                //     $res = sendMailSMTP($datas);
                //     if ($res) {
                //         $return = ['status' => 1, 'message' => 'Please check your email and verify'];
                //     }
                // }
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
    
         // echo $se = strtotime(date('Y-m-04 12:01:01'));exit;  
         $month = strtotime(date('Y-m-01 00:00:00'));  
        $vendor_id = $this->session->userdata['id'];
        if($this->session->userdata('vendor_admin') == '1'){
            $data['where']['o.branch_id'] = $vendor_id;
        }
        // if($this->session->userdata['super_admin'] != '' && $this->session->userdata['super_admin'] == '1'){
        
        // }
        $data['table'] = 'order_details AS o';
        $data['select'] = [
            'o.product_id',
            'COUNT(o.product_id) AS Todal_count',
            'p.name'
        ];
        $data['join']=['product as p'=>['o.product_id=p.id','LEFT']];
        $data['where']['o.dt_added>='] = $month;
        $data['groupBy'] = 'o.product_id';
        $data['order'] = 'todal_count DESC';
        $data['limit'] = '10';
        $total_order_month=$this->selectFromJoin($data);
        // echo $this->db->last_query();die;
        
        // $total_order_month = $this->db->query("SELECT o.product_id,COUNT(o.product_id) AS Todal_count,p.name FROM `order_details` AS o  LEFT JOIN product as p on o.product_id = p.id WHERE o.vendor_id='$vendor_id' AND o.dt_added >= '$month' GROUP BY o.product_id order by todal_count DESC limit 10")->result();

//        print_r($total_order_month);exit;
        // echo $this->db->last_query();
        $color = ['red','blue','grey','black','green','pink','yellow','brown','orange','purple'];
        $finalArray = array();
        for($i=0; $i < count($total_order_month) ; $i++){

            $finalArray[] = array(
                'name' => $total_order_month[$i]->name,
                'value' => $total_order_month[$i]->Todal_count,
                'color' =>$color[$i]
            );
        }
        // print_r($finalArray);exit;
        return $finalArray;
    }

    public function get_valid_email(){
        $email = $this->input->post('email');
        $data['select'] = ['email'];
        $data['where'] = ['email'=>$email];
        $data['table'] = "vendor";
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
            $data['table'] = "vendor";
            $result = $this->selectRecords($data);

            if($result[0]->phone_no == $mobile){
               return "true";
            }else{
                $mobile = $this->input->post('mobile');
                $data['select'] = ['phone_no'];
                $data['where'] = ['phone_no'=>$mobile];
                $data['table'] = "vendor";
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
        $data['table'] = "vendor";
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
    public function change_delivery_type(){


        $status = $this->input->post('status');
        $vendor_id = $this->session->userdata['id'];

        $data['update']['delivery_by'] = $status;
        $data['update']['dt_updated'] = strtotime(DATE_TIME);

        $data['where'] = ['id' => $vendor_id];
        $data['table'] = 'vendor';
        $this->updateRecords($data);
        exit;
    }
//  request from staff controller
    public function getStaff(){
        $vendor_id = $this->session->userdata['id'];
        $data['table'] = 'staff';
        $data['select'] = ['*'];
        $data['where'] = [
            'status !='=>'9',
            'branch_id' =>$vendor_id
        ];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
    }


//  request from staff controller
    public function getEditData($id){
        $data['table'] = 'staff';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$id];
        return $this->selectRecords($data,true);
    }

    public function userList(){
        $data['table'] = 'user';
        $data['select'] = ['*'];
        $data['where'] = ['status !='=>'9','vendor_id'=>$this->vendor_id];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
    }
    public function vendorList(){
        $data['table'] = 'branch';
        $data['select'] = ['*'];
        $data['where'] = ['domain_name'=>base_url(),'status !='=>'9'];

        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
    }

    public function getProfits(){
        $data['table'] = 'profit';
        $data['select'] = ['vendor_id','total_profit'];
        return $this->selectRecords($data);
    }

    public function profit_query_take(){
        $data['table'] = 'profit_taken';
        $data['select'] = ['vendor_id','profit'];
        
        return $this->selectRecords($data);
    }

    public function vendorByIdEmail($email){

        $branch_id = $this->session->userdata['id'];
        if($branch_id == 0 ){
            $data['table'] = 'vendor';
            $data['where']['id'] = $this->vendor_id;
        }else{
            $data['table'] = 'branch';
            $data['where']['email'] = $email;
            $data['where']['id'] = $branch_id;
        }
        $data['select'] = ['*'];
        $re = $this->selectRecords($data,true);
        return $re[0]; 

    }

    public function setDefault(){
        $data['table'] = 'set_default';
        $data['select'] = ['*'];
        $data['where'] = ['request_id' => '4'];
        return $this->selectRecords($data);
    }

    public function vendorById($id){
        $data['table'] = 'branch';
        $data['select'] = ['*'];
        $data['where'] = ['id' => $id];
        $return = $this->selectRecords($data,true);
        return $return[0];
    }

    public function setProfitCurrency(){
        $data['table'] = 'set_default';
        $data['select'] = ['*'];
        $data['where'] = ['request_id' => '3'];
        $return = $this->selectRecords($data,true);
        return $return[0];
    }

    public function profitQuery($id){
        $data['table']  = 'profit';
        $data['select'] = ['vendor_id','sum(total_profit) as profit'];
        $data['where']  = ['vendor_id' => $id];
        $data['order'] = 'id DESC';
        $result = $this->selectRecords($data,true);
        return $result[0];
    }

    public function profitQueryTaken($id){
        $data['table']  = 'profit_taken';
        $data['select'] = ['vendor_id','sum(profit) as profit'];
        $data['where']  = ['vendor_id' => $id];
        $data['order'] = 'id DESC';
        $result = $this->selectRecords($data,true);
        return $result[0];
    }

    public function orderDetailQuery($id){
    $order_detail_query = $this->db->query("
        SELECT o.id as order_id,o.dt_added as order_date,
        o.order_no,pr.total_profit,od.*,u.id as user_id,
        u.fname,u.email, u.lname, w.name as weight_name,
        p.name as product_name
        FROM `order_details` as od 
        LEFT JOIN `order` as o ON o.id = od.order_id
        LEFT JOIN user as u ON u.id = od.user_id
        LEFT JOIN profit as pr ON pr.order_id = od.order_id
        LEFT JOIN weight as w ON w.id = od.weight_id
        LEFT JOIN product as p ON p.id = od.product_id
        WHERE  od.status != '9' 
        AND od.vendor_id = '$id' AND pr.vendor_id = '$id' 
        AND pr.order_detail_id = od.id  
        ORDER BY pr.id");
     return  $order_detail_result = $order_detail_query->result();
        // $data['table'] = 'order_details as od';
        // $data['select'] = [
        //     'o.id as order_id','o.dt_added as order_date',
        //     'o.order_no.','pr.total_profit','od.*',
        //     'u.id as user_id','u.fname',
        //     'u.email','u.lname','w.name as weight_name',
        //     'p.name as product_name'
        // ];
        // $data['join'] = [
        //     'order as o'=>['o.id = od.order_id','LEFT'],
        //     'user as u'=>['u.id = od.user_id','LEFT'],
        //     'profit as pr'=>['pr.order_id = od.order_id','LEFT'],
        //     'weight as w'=>['w.id = od.weight_id','LEFT'],
        //     'product as p'=>['p.id = od.product_id','LEFT']
        //      ];
        // $data['where'] = [
        //     'od.status!='=>'9',
        //     'od.vendor_id'=>$id,
        //     'pr.vendor_id'=>$id,
        //     'pr.order_detail_id' => 'od.id'
        //     ];
        //     $data['order'] = 'pr.id';
        //     return $this->selectFromJoin($data);
    }

    public function profit_take_detail($id){
        $data['table'] = 'profit_taken';
        $data['select'] = ['vendor_id','profit','dt_created'];
        $data['where'] = ['vendor_id'=>$id];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
    }

    public function order_result($id){
        $data['table'] = 'order as o';
        $data['select'] = ['o.*','u.fname','u.lname'];
        $data['join'] = ['user as u'=>['u.id=o.user_id','LEFT']];
        $data['where'] = ['o.status !='=>'9','vendor_id'=>$id];
        $data['order'] = 'o.id DESC';
        return $this->selectFromJoin($data);
    }

    public function getDiscount($id){
        $data['table'] = 'discount';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$id];
        $result = $this->selectRecords($data,true);
        return $result[0];
    }

    public function discount_add_update($postData){
        $vendor_id = $this->session->userdata['id'];
        $id = $postData['id'];
        $start_discount = $postData['start_discount'];
        $end_discount_ = ltrim($postData['end_discount'],'0');

        if(isset($postData['submit'])) {
            /* Discount Update */
            if ($id != '') {

                if($end_discount_ == ''){
                    $end_discount =  '100';
                }elseif ($end_discount_ == '100'){
                    $end_discount =  '100';
                }else{
                    $end_discount = $end_discount_;
                }

                $updateData = array(
                    'start_discount' => $start_discount,
                    'end_discount' => $end_discount,
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $data['table'] = 'discount';
                $data['select'] = ['*'];
                $data['where'] = ['id'=>$id];
                $data['update'] = $updateData;
                $this->updateRecords($data);
                $this->session->set_flashdata('msg', 'Discount has been updated successfully');
                redirect(base_url() . 'admin/discount_list');
                exit();
            }
            /* Discount Add */
            else {

                if($end_discount_ == ''){
                    $end_discount =  '100';
                }else{
                    $end_discount = $end_discount_;
                }

                $insert = array(
                    'vendor_id' => $this->vendor_id,
                    'start_discount' => $start_discount,
                    'end_discount' => $end_discount,
                    'status' => '1',
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                $data['table'] = 'discount';
                $data['insert'] = $insert;
                $this->insertRecord($data);
                $this->session->set_flashdata('msg', 'Discount has been added successfully');
                redirect(base_url() . 'admin/discount_list');
                exit();
            }
        }
    }

    public function single_delete_discount($getData){
         $id = $getData['id'];
        $up = array( 'status' => '9','dt_updated' => strtotime(date('Y-m-d H:i:s')));
        $data['table'] = 'discount';
        $data['where'] = ['id'=>$id];
        $data['update'] = $up;
        $this->updateRecords($data);

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    // discount list super admin

    public function getDicount(){
        // print_r($_SESSION);die;
        // $vendor_id = $this->session->userdata['id'];
        $data['table'] = 'discount'; 
        $data['select'] = ['*'];
        $data['where'] = ['status!=' => '9','vendor_id' => $this->vendor_id];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
// echo $this->db->last_query();die;

    }

    public $order_column = array("name","owner_name","phone_no","email");      
    public function make_query($postData){    

            $this->db->select('*');  
            $this->db->where('vendor_id',$this->session->userdata('vendor_admin_id'));  
            $this->db->from(TABLE_BRANCH);
        
        if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){  
            $this->db->group_start();
            $this->db->like("name", $postData["search"]["value"]); 
            $this->db->or_like("owner_name", $postData["search"]["value"]);
            $this->db->or_like("email", $postData["search"]["value"]);
            $this->db->or_like("phone_no", $postData["search"]["value"]);
            $this->db->group_end();
           }  
           if(isset($postData["order"])){  
            $this->db->order_by($this->order_column_users[$postData['order']['0']['column']], $postData['order']['0']['dir']); 
           }else{  
             $this->db->order_by('id', 'DESC'); 
               // $this->db->order_by('id', 'DESC');  
           }
      }  
          function make_datatables($postData){ 
            $this->make_query($postData); 
            if($postData["length"] != -1){  
                $this->db->limit($postData['length'], $postData['start']);
            }  
             $query = $this->db->get();  
             return $query->result();
             // echo $this->db->last_query();die;
          }  
          function get_filtered_data($postData = false){  
            $data = $this->make_query($postData);    
            $query = $this->db->get();  
            return $query->num_rows();
          }       

          function get_all_data(){
            $this->db->select("*");  
            $this->db->where('vendor_id',$this->session->userdata('vendor_admin_id')); 
            $this->db->from(TABLE_BRANCH);
            return $this->db->count_all_results();
          }

    public  $order_column_users = array("fname","lname","email","phone"); 
    function make_query_users($postData){
         $this->db->select('*');  
         $this->db->from('user');
         $this->db->where(['status !='=>'9','vendor_id'=>$this->vendor_id]);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] !='')  
           {  
            $this->db->group_start();
                $this->db->like("fname", $postData["search"]["value"]); 
                $this->db->or_like("lname", $postData["search"]["value"]);
                $this->db->or_like("email", $postData["search"]["value"]);
                $this->db->or_like("phone", $postData["search"]["value"]);
           $this->db->group_end();
           }  
           if(isset($postData["order"]))  
           {  
                $this->db->order_by($this->order_column_users[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('id', 'DESC');  
           } 
    }


    function make_datatables_users($postData){ 
        $this->make_query_users($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            echo $this->db->last_query();
            die;
        }

    function get_filtered_data_users($postData = false){  
        // $this->make_query_users($postData);  
          $this->db->select("*");  
        $this->db->from('user');
        $this->db->where(['status !='=>'9','vendor_id'=>$this->vendor_id]);
        $query = $this->db->get();  
        return $query->num_rows();
    }       
    
    function get_all_data_users(){
        $this->db->select("*");  
        $this->db->from('user');
        $this->db->where(['status !='=>'9','vendor_id'=>$this->vendor_id]);
        return $this->db->count_all_results();    
    }



public  $order_column_discount = array("start_discount","end_discount"); 
    function make_query_discount($postData){

        $where = [
            'vendor_id'=>$this->vendor_id,
            'status !='=>'9',  
        ];
         $this->db->select('*');  
         $this->db->from('discount');
         $this->db->where($where);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
          $this->db->group_start();

            $this->db->like("start_discount", $postData["search"]["value"]); 
            $this->db->or_like("end_discount", $postData["search"]["value"]); 
            $this->db->group_end(); 
            }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_discount[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('id', 'DESC');  
           } 
    }


    function make_datatables_discount($postData){ 
        $this->make_query_discount($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            echo $this->db->last_query();
        }

    function get_filtered_data_discount($postData = false){  
        $this->make_query_discount($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }       
    
    function get_all_data_discount(){
       $vendor_id = $this->session->userdata('id');
       $where = [
            'vendor_id'=>$this->vendor_id,
            'status !='=>'9',  
        ];
        $this->db->select("*");  
        $this->db->from('discount');
        $this->db->where($where);
        return $this->db->count_all_results();   
        }
    

    public  $order_column_staff = array("name","phone_no","email"); 
    function make_query_staff($postData){
        $branch_id = $this->session->userdata('id');
     // $vendor_id = $this->session->userdata('id');
        $where = [
            'branch_id'=>$branch_id,
            'status !='=>'9',  
        ];
         $this->db->select('*');  
         $this->db->from('staff');
         $this->db->where($where);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
            $this->db->group_start();
                $this->db->like("name", $postData["search"]["value"]);
                $this->db->or_like("email", $postData["search"]["value"]); 
                $this->db->or_like("phone_no", $postData["search"]["value"]); 
            $this->db->group_end(); 
        }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_staff[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('id', 'DESC');  
           } 
    }


    function make_datatables_staff($postData){ 
        $this->make_query_staff($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            // echo $this->db->last_query();
        }

    function get_filtered_data_staff($postData = false){  
        $this->make_query_staff($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }       
    
    function get_all_data_staff(){
        $branch_id = $this->session->userdata('id');
       $where = [
            'branch_id'=>$branch_id,
            'status !='=>'9',  
        ];
        $this->db->select("*");  
        $this->db->from('staff');
        $this->db->where($where);
        return $this->db->count_all_results();   
    }

/*=========VENDOR ACCOUNTING=============*/

public  $order_column_accounting = array("name","owner_name",); 
    function make_query_accounting($postData){
     // $vendor_id = $this->session->userdata('id');
         $where = array('status!='=>'9');
         $this->db->select('*');  
         $this->db->from('vendor');
         $this->db->where($where);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
        $this->db->group_start();
            $this->db->like("name", $postData["search"]["value"]);
            $this->db->or_like("owner_name", $postData["search"]["value"]); 
        $this->db->group_end(); 
        }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_accounting[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('id', 'DESC');  
           } 
    }


    function make_datatables_accounting($postData){ 
        $this->make_query_accounting($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            // echo $this->db->last_query();
        }

    function get_filtered_data_accounting($postData = false){  
        $this->make_query_accounting($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }       
    
    function get_all_data_accounting(){
        $vendor_id = $this->session->userdata('id');
       $where = ['status !='=>'9'];
        $this->db->select("*");  
        $this->db->from('vendor');
        $this->db->where($where);
        return $this->db->count_all_results();   
    }

    public function sendEmailMessage(){
        // print_r($_SESSION);die;
        $vendor_id = $this->session->userdata('vendor_admin_id');
        $data['select'] = ['name as storeName','email','phone_no'];
        $data['where'] = ['id'=>$vendor_id,'status'=>'1'];
        $data['table'] = 'vendor';
        $result = $this->selectRecords($data);
        return $result;

    }
    
}
?>