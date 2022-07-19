<?php
class Api_admin_model extends My_model {

    public function check_login($postData) {
      
        $email = $postData['email'];
        $password = md5($postData['password']);
        $result_login = $this->db->query("SELECT * FROM branch WHERE email='$email' AND password='$password'");
        $row_login = $result_login->row_array();
        $branch_id = $row_login['vendor_id'];
        $getDefault = $this->db->query("SELECT value FROM set_default WHERE request_id = '3' AND vendor_id = '$branch_id'");
        $row_default = $getDefault->row_array();
        if($row_login['status'] != '0'){
            if ($result_login->num_rows() > 0) {
                $token = $this->update_token($row_login['id']);
                $this->addAdminDevice($postData,$row_login['id']);
                $status = $row_login['status'];
                if ($status == '1') {
                    $login_data = array(
                        'id' => $row_login['id'],
                        'multiple_lang_type'=>$row_login['multiLanguageType'],
                        'vendor_id'=>$row_login['vendor_id'],
                        'name' => $row_login['owner_name'], 
                        'email' => $row_login['email'], 
                        'phone' => $row_login['phone_no'], 
                        'selfPickUp' => $row_login['selfPickUp'], 
                        'shopName' => $row_login['name'], 
                        'token' => $token, 
                        'gst_number' => $row_login['gst_number'], 
                        'image' => base_url() . 'public/images/'.$this->folder.'vendor_shop/' . $row_login['image'],
                        'currancy'=>$row_default['value'],
                        'address'=>$row_login['address'] ,
                        'logged_in' => TRUE
                    );

                    $login_logs = [
                        'user_id' => $row_login['id'],
                        'vendor_id' =>  $row_login['vendor_id'],
                        'status' => 'login',
                        'type' => 'branch app',
                        'dt_created' => DATE_TIME
                    ];
                    $this->load->model('api_v3/common_model','v2_common_model');
                    $this->v2_common_model->user_login_logout_logs($login_logs);
                    $res = ['status' => 1, 'message' => 'Data get success', 'data' => $login_data];
                } else {
                    $res = ['status' => 0, 'message' => 'User inactivated by admin'];
                }
            } else {
                $res = ['status' => 0, 'message' => 'Invalid email or password'];
            }
        }else{
            $res = ['status' => 0, 'message' => 'Your account has been deactivated .. Contact to Admin'];
        }

        return $res;
    }

    public function addAdminDevice($postData,$branch_id){
        // dd($postData);
        $data['table'] = 'branch_device';
        $data['select'] = ['*'];
        $data['where'] = ['branch_id' =>$branch_id];
        $res = $this->selectRecords($data);
        unset($data);
        if(count($res) > 0){
            if($res[0]->device_id != $postData['device_id']){
                $data['table'] = 'branch_device';
                $data['where'] = ['id' =>$res[0]->id];
                $this->deleteRecords($data);
                unset($data);
                $data['table'] = 'branch_device';
                $data['insert'] = [
                    'branch_id'=>$branch_id,
                    'device_id'=>$postData['device_id'],
                    'token'=>$postData['token'],
                    'type'=>$postData['type'],
                    'dt_created'=>DATE_TIME,
                    'dt_updated'=>DATE_TIME
                ];
                $this->insertRecord($data);
            }
        }else{
            unset($data);
            $data['table'] = 'branch_device';
            $data['insert'] = [
                'branch_id'=>$branch_id,
                'device_id'=>$postData['device_id'],
                'token'=>$postData['token'],
                'type'=>$postData['type'],
                'dt_created'=>DATE_TIME,
                'dt_updated'=>DATE_TIME
            ];
            $this->insertRecord($data);
        }
        return true;
    }


     public function is_authenticate($postData) {
        $branch_id = $postData['branch_id'];
        $result_login = $this->db->query("SELECT * FROM branch WHERE id='$branch_id'");
        $row_login = $result_login->row_array();
        $vendor_id = $row_login['vendor_id'];
        // print_r($row_login);die;
        $getDefault = $this->db->query("SELECT value FROM set_default WHERE request_id = '3' AND vendor_id = '$vendor_id'");
        $row_default = $getDefault->row_array();
        if($row_login['status'] != '0'){
            if ($result_login->num_rows() > 0) {
                // $token = $this->update_token($row_login['id']);
                $status = $row_login['status'];
                if ($status == '1') {
                     $login_data = array('id' => $row_login['id'],'vendor_id'=>$vendor_id, 'name' => $row_login['owner_name'], 'email' => $row_login['email'], 'phone' => $row_login['phone_no'], 'selfPickUp' => $row_login['selfPickUp'], 'shopName' => $row_login['name'], 'token' => $row_login['token'], 'gst_number' => $row_login['gst_number'], 'image' => base_url() . 'public/images/'.$this->folder.'vendor_shop/' . $row_login['image'],'currancy'=>$row_default['value'],'address'=>$row_login['address'] ,'logged_in' => TRUE,'multiple_lang_type'=>$row_login['multiLanguageType']);
                    $res = ['status' => 1, 'message' => 'Data get success', 'data' => $login_data];
                } else {
                    $res = ['status' => 0, 'message' => 'User inactivated by admin'];
                }
            } else {
                $res = ['status' => 0, 'message' => 'Invalid vendor id'];
            }
        }else{
            $res = ['status' => 0, 'message' => 'Your account has been deactivated .. Contact to Admin'];
        }

        return $res;
    }

    public function payment_method($postData) {

        $data['select'] = ['pm.id', 'pm.status', 'pg.name as paymentGateway'];
        $data['where'] = ['pm.branch_id' => $postData['branch_id']];
        $data['table'] = 'payment_method as pm';
        $data['join'] = ['payment_getway as pg' => ['pg.type=pm.payment_opt', 'left']];
        $payment = $this->selectFromJoin($data);
        if (!empty($payment)) {
            $res = ['status' => 1, 'message' => 'Data get success', 'data' => $payment];
        } else {
            $res = ['status' => 0, 'message' => 'No record found'];
        }
        return $res;
    }

    public function profile_update($postData) {
        /* New Image Upload */
        // print_r($postData);
        // print_r($_FILES);die;
        $branch_id = $postData['branch_id'];
        $query = $this->db->query("SELECT image,token,gst_number,address,vendor_id,multiLanguageType FROM branch WHERE id = '$branch_id'");
        $result = $query->row_array();
        $image = $result['image'];
        if (isset($_FILES['image_edit']) && $_FILES['image_edit']['name'] != '') {
            $url = '/public/images'.$this->folder.'vendor_shop/' . $old_image;
            unlink($url);
            $upload_path = "public/images/".$this->folder."vendor_shop/";
            $uploadResponse = upload_single_image($_FILES, 'image_edit', $upload_path);
            $uploadResponse['data']['file_name'];
            $image = $uploadResponse['data']['file_name'];
        }
        $data['table'] = 'branch';
        $update_data = array('name' => $postData['shopName'], 'address' => $postData['address'], 'email' => $postData['email'], 'phone_no' => $postData['phone'], 'selfPickUp' => $postData['selfPickUp'], 'owner_name' => $postData['name'], 'gst_number' => $postData['gst_number'], 'image' => $image, 'dt_updated' => strtotime(DATE_TIME));
        $data['where'] = ['id' => $postData['branch_id']];
        $data['update'] = $update_data;
        $this->updateRecords($data);

        $update_data['image'] = base_url() . $upload_path . $update_data['image'];
        $update_data['id'] = $branch_id;
        $update_data['vendor_id'] = $result['vendor_id']; 
        $update_data['shopName'] = $postData['name'];
        $update_data['address'] = $postData['address'];
        $update_data['phone'] = $postData['phone'];
        $update_data['image'] = base_url() . 'public/images/'.$this->folder.'vendor_shop/' . $image;
        $update_data['token'] = $result['token'];
        $update_data['gst_number'] = $postData['gst_number'];
        $update_data['multiple_lang_type'] = $result['multiLanguageType'];
        unset($update_data['phone_no']);
        unset($update_data['owner_name']);
        $res = ['status' => 1, 'message' => 'Profile Updated successfully', 'data' => $update_data];
        return $res;
    }
    public function payment_method_change_status($postData) {
        $branch_id = $postData['branch_id'];
        $update_id = $postData['payment_id'];
        $data['table'] = 'payment_method';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$update_id,'branch_id'=>$branch_id];
        $isAvailable = $this->countRecords($data);
        unset($data);
        if($isAvailable > 0){
            $data = array('status' => '0', 'dt_updated' => DATE_TIME);
            $result = $this->db->update('payment_method', $data, ['branch_id' => $branch_id]);
                $id = $this->utility_apiv2->decode($id);
                $data['table'] = 'payment_method';
                $data['where'] = ['id' => $update_id];
                $data['update'] = ['status' => '1', 'dt_updated' => DATE_TIME ];
                $res = $this->updateRecords($data);
                if($res){
                    $res = ['status' => 1, 'message' => 'change payment option'];
                }else{
                   $res = ['status' => 0, 'message' => 'Somthing Went Wrong'];     
               }
        }else{
            $res = ['status' => 0, 'message' => 'payment_method not available'];
        }
        return $res;
    }
    public function get_code() {
        $data = 'CC' . strtotime(DATE_TIME);
        $return = ['status' => 1, 'message' => 'Data Get Success', 'data' => $data];
        return $return;
    }
    public function get_customer($postData) {
        $data['select'] = ['*'];
        $data['where'] = ['branch_id' => $postData['branch_id'], 'status !=' => '9'];
        $data['table'] = 'customer';
        $data['order'] = 'id DESC';
        $res = $this->selectRecords($data);
        if ($res) {
            $return = ['status' => 1, 'message' => 'Data Get Success', 'data' => $res];
        } else {
            $return = ['status' => 0, 'message' => 'No data Found'];
        }
        return $return;
    }
    public function add_edit_Customer($postData) {
        $branch_id = $postData['branch_id'];
        $email = $postData['email'];
        $check = '';
        if (!isset($postData['customer_id'])) {
            $check = $this->db->get_where('customer', array('email' => $email, 'branch_id' => $branch_id, 'status !=' => '9'))->result();
        }
        if (!empty($check)) {
            $res = ['status' => 0, 'message' => 'You are already Registered'];
            return $res;
        } else {
            $data = array('customer_name' => $postData['CustomerName'], 'company' => $postData['Company'], 'customercode' => $postData['customercode'], 'gender' => $postData['gender'], 'phone' => $postData['phonenumber'], 'mobile' => $postData['mobile'], 'email' => $postData['email'], 'fax' => $postData['fax'], 'dob' => date("Y-m-d", strtotime($postData['dob'])), 'website' => $postData['website'], 'twitter' => $postData['twitter'], 'street1' => $postData['street1'], 'street2' => $postData['street2'], 'city' => $postData['city'], 'state' => $postData['state'], 'country' => $postData['country'], 'postcode' => $postData['postalcode'], 'branch_id' => $postData['branch_id'], 'group_id' => $postData['group_id'], 'status' => '1', 'dt_added' => strtotime(DATE_TIME), 'dt_updated' => strtotime(DATE_TIME));
            if (isset($postData['customer_id']) && $postData['customer_id']) {
                $this->db->where('id', $postData['customer_id']);
                $insert_data = $this->db->update('customer', $data);
                $res = ['status' => 1, 'message' => 'Customer Updated'];
            } else {
                $insert_data = $this->db->insert('customer', $data);
                $res = ['status' => 1, 'message' => 'Customer Added'];
            }
            if ($insert_data) {
                return $res;
            } else {
                $res = ['status' => 0, 'message' => 'Error to add customer'];
                return $res;
            }
        }
    }
    public function delete_customer($postData) {
        $id = $postData['customer_id'];
        $data = array('dt_updated' => strtotime(DATE_TIME), 'status' => '9');
        $this->db->where('id', $id);
        $this->db->update('customer', $data);
        $res = ['status' => 1, 'message' => 'Customer deleted'];
        return $res;
    }
    public function get_group($postData) {
        $data['select'] = ['*'];
        $data['where'] = ['branch_id' => $postData['branch_id'], 'status !=' => '9'];
        $data['table'] = 'customer_group';
        $data['order'] = 'id DESC';
        $res = $this->selectRecords($data);
        if ($res) {
            $return = ['status' => 1, 'message' => 'Data Get Success', 'data' => $res];
        } else {
            $return = ['status' => 0, 'message' => 'No data Found'];
        }
        return $return;
    }
    public function add_group($postData) {
        $branch_id = $postData['branch_id'];
        $name = $postData['name'];
        $type_array = array('name' => $name, 'branch_id' => $branch_id, 'status' => '1', 'dt_added' => strtotime(DATE_TIME), 'dt_updated' => strtotime(DATE_TIME));
        $this->db->insert('customer_group', $type_array);
        $return = ['status' => 1, 'message' => 'Customer group has been added successfully.'];
        return $return;
    }
    public function get_group_customer($postData) {
        $data['select'] = ['*'];
        $data['where'] = ['group_id' => $postData['group_id'], 'branch_id' => $postData['branch_id'], 'status !=' => '9'];
        $data['table'] = 'customer';
        $data['order'] = 'id DESC';
        $res = $this->selectRecords($data);
        if ($res) {
            $return = ['status' => 1, 'message' => 'Data Get Success', 'data' => $res];
        } else {
            $return = ['status' => 0, 'message' => 'No data Found'];
        }
        return $return;
    }
    public function update_group($postData) {
        $id = $postData['group_id'];
        $name = $postData['name'];
        $branch_id = $postData['branch_id'];
        $type_array = array('name' => $name, 'branch_id' => $branch_id, 'status' => '1', 'dt_added' => strtotime(DATE_TIME), 'dt_updated' => strtotime(DATE_TIME));
        $this->db->where('id', $id);
        $this->db->update('customer_group', $type_array);
        $return = ['status' => 1, 'message' => 'Customer group has been updated successfully'];
        return $return;
    }
    public function delete_group($postData) {
        $id = $postData['group_id'];
        $branch_id = $postData['branch_id'];
        $data = array('status' => '9');
        $this->db->where('id', $id);
        $this->db->where('branch_id', $branch_id);
        $this->db->update('customer_group', $data);
        $return = ['status' => 1, 'message' => 'customer group has been deleted successfully'];
        return $return;
    }
    public function get_staff($postData) {
        $limit = '10';
        $offset = $postdata['offset'];
        $cal = $limit * $offset;
        $data['select'] = ['*'];
        $data['where'] = ['branch_id' => $postData['branch_id'], 'status !=' => '9'];
        $data['table'] = 'staff';
        $data['order'] = 'id DESC';
        $data['limit'] = $limit;
        if ($offset != 0) {
            $data['skip'] = $cal;
        }
        if(isset($postData['search']) && $postData['search'] != ''){
            $data['like'] = ['name',$postData['search'],'match'];
        }
        $res = $this->selectRecords($data);
        unset($data);
        if(isset($postData['search']) && $postData['search'] != ''){
            $data['like'] = ['name',$postData['search'],'match'];
            // $data['group']['like'] = ['c.name',$postData['search'],'match'];
        }
        $data['select'] = ['*'];
        $data['where'] = ['branch_id' => $postData['branch_id'], 'status !=' => '9'];
        $data['table'] = 'staff';
        $count = $this->countRecords($data);
        if ($res) {
            $return = ['status' => 1, 'message' => 'Data Get Success','count'=>$count,'data' => $res];
        } else {
            $return = ['status' => 0, 'message' => 'No data Found'];
        }
        return $return;
    }
    public function staff_add_update($postData) {
        $branch_id = $postData['branch_id'];
        $email = $postData['email'];
        $password = md5($postData['password']);
        $data['select'] = ['*'];
        // $data['where'] = ['branch_id' => $postData['branch_id'], 'status !=' => '9', 'email' => $email];
        $data['where'] = ['status !=' => '9', 'email' => $email];
        $data['table'] = 'staff';
        $data['order'] = 'id DESC';
        $res = $this->selectRecords($data);
        if (!empty($res)) {
            $return = ['status' => 0, 'message' => 'Staff already existed in system'];
            return $return;            
        }
            if (isset($postData['staff_id']) && $postData['staff_id'] != '') {
                $dataupdate = array('branch_id' => $branch_id, 'name' => $postData['name'], 'phone_no' => $postData['mobile'], 'vehicle_number' => $postData['vehicle_number'], 'vehicle_name' => $postData['vehicle_name'], 'dt_added' => DATE_TIME, 'dt_updated' => DATE_TIME,);
                $id = $postData['staff_id'];
                $this->db->where('id', $id);
                $this->db->update('staff', $dataupdate);
                $return = ['status' => 1, 'message' => 'Staff updated successfully'];
            } else {
                $token = md5($this->utility_apiv2->encode($postData['email']));
                $data = array(
                    'branch_id' => $branch_id, 
                    'name' => $postData['name'],
                     'email' => $postData['email'], 
                     'password' => md5($postData['password']), 
                     'phone_no' => $postData['mobile'], 
                     'vehicle_number' => $postData['vehicle_number'], 
                     'vehicle_name' => $postData['vehicle_name'], 
                     'status' => '1', 
                     'email_verify'=>'1',
                     'email_token' => $token, 
                     'dt_added' => DATE_TIME, 
                     'dt_updated' => DATE_TIME,
                 );
                $staffInsert['insert'] = $data;
                $staffInsert['table'] = 'staff';
                $staffId = $this->insertRecord($staffInsert);
                if ($staffId) {
                    $staffDetail = ['id' => $staffId, 'token' => $token];
                    $finalStaffdetail = $this->utility_apiv2->encode(json_encode($staffDetail));
                    $datas['name'] = $postData['name'];
                    $datas['link'] = base_url() . "api_admin/verifyAccount/" . $finalStaffdetail;
                    $datas['message'] = $this->load->view('emailTemplate/registration_mail', $datas, true);
                    $datas['subject'] = 'Verify user email address';
                    $datas["to"] = $email;
                    // $res = $this->sendMailSMTP($datas); 
                    $res = 1;
                    if ($res) {
                        // $return = ['status' => 1, 'message' => 'Please check your email and verify'];
                        $return = ['status' => 1, 'message' => 'Staff added successfully.'];
                    }
                }
                // $return = ['status'=>1,'message'=>'Staff added successfully'];
                
            }
        
        return $return;
    }
    public function verifyUserByToken($postData) {
        $staffDetail = $this->utility_apiv2->decode($postData);
        $staffData = json_decode($staffDetail);
        $data['select'] = ['*'];
        $data['where'] = ['id' => $staffData->id, 'email_token' => $staffData->token, 'email_verify' => '2'];
        $data['table'] = 'staff';
        $response = $this->selectRecords($data);
        /* if got token in database then update token as empty and user status is active */
        if (count($response) > 0) {
            $updatedata = array('email_token' => '', 'email_verify' => '1','dt_updated'=>DATE_TIME);
            unset($data);
            $data['update'] = $updatedata;
            $data['where'] = ['id' => $response[0]->id];
            $data['table'] = 'staff';
            $this->updateRecords($data);
            return true;
        } else {
            return false;
        }
    }
    public function staff_change_status($postData) {
        $id = $postData['staff_id'];
        $data = array('status' => $postData['status']);
        $this->db->where('id', $id);
        $this->db->update('staff', $data);
        $return = ['status' => 1, 'message' => 'Staff status change successfully'];
        return $return;
    }
    public function category_add_update($postData) {
        $branch_id = $postData['branch_id'];
        $name = $postData['name'];
        if (isset($postData['category_id']) && $postData['category_id'] != '') {
            // print_r($_POST);die;
            $id = $postData['category_id'];
            $data['table'] = 'category';
            $data['select'] = ['*'];
            $data['where'] = ['branch_id' => $branch_id, 'name' => $name, 'status != ' => '9'];
            $result = $this->selectRecords($data);
            if (empty($result) || $result[0]->id == $id) {
                $image = time() . $_FILES['image_edit']['name'];
                /* New Image Upload */
                if (isset($_FILES['image_edit']) && $_FILES['image_edit']['name'] != '') {
                    $query = $this->db->query("SELECT image FROM category WHERE id = '$id'");
                    $result = $query->row_array();
                    $old_image = $result['image'];
                    $url = './public/images/'.$this->folder.'category/' . $old_image;
                    unlink($url);
                    $url_thumb = './public/images/'.$this->folder.'category_thumb/' . $old_image;
                    unlink($url_thumb);
                    $upload_path_thumb = "./public/images/".$this->folder."category_thumb";
                    $uploadResponse_thumb = upload_single_image($_FILES, 'image_edit', $upload_path_thumb);
                    $upload_path = "./public/images/".$this->folder."category";
                    $uploadResponse = upload_single_image($_FILES, 'image_edit', $upload_path);
                    $uploadResponse['data']['file_name'];
                    $this->image_resize_category($uploadResponse['data']['full_path'], $uploadResponse['data']['file_name']);
                    $da['image'] = $uploadResponse['data']['file_name'];
                }
                $da['name'] = $name;
                $da['dt_updated'] = strtotime(DATE_TIME);
                $this->db->where('id', $id);
                $this->db->where('branch_id', $branch_id);
                $this->db->update('category', $da);
                $return = ['status' => 1, 'message' => 'Category has been updated successfully'];
            } else {
                $return = ['status' => 0, 'message' => 'Category already exist'];
            }
            return $return;
        }
        ## Add Category ##
        else {
            $data['table'] = 'category';
            $data['select'] = ['*'];
            $data['where'] = ['name' => $name, 'branch_id' => $branch_id, 'status !=' => '9'];
            $is_available = $this->countRecords($data);
            if ($is_available > 0) {
                $return = ['status' => 0, 'message' => 'Category name already exists'];
                return $return;
            }
            unset($data);
            if ($_FILES['image']['name'] != '') {
                $image = time() . $_FILES['image']['name'];
            } else {
                $image = '';
            }
            $upload_path = "./public/images/".$this->folder."category";
            $uploadResponse = upload_single_image($_FILES, 'image', $upload_path);
            $uploadResponse['data']['file_name'];
            $this->image_resize_category($uploadResponse['data']['full_path'], $uploadResponse['data']['file_name']);
            $data = array('branch_id' => $branch_id, 'name' => $name, 'image' => $uploadResponse['data']['file_name'], 'status' => '1', 'dt_added' => strtotime(DATE_TIME), 'dt_updated' => strtotime(DATE_TIME));
            $this->db->insert('category', $data);
            $return = ['status' => 1, 'message' => 'Category has been added successfully'];
            return $return;
        }
    }
    public function image_resize_category($path, $file) {
        $config_resize = array();
        $config_resize['image_library'] = 'gd2';
        $config_resize['source_image'] = $path;
        $config_resize['create_thumb'] = FALSE;
        $config_resize['maintian_ratio'] = TRUE;
        $config_resize['width'] = 300;
        $config_resize['height'] = 400;
        $config_resize['new_image'] = "./public/images/".$this->folder."category_thumb/" . $file;
        $this->load->library('image_lib', $config_resize);
        $this->image_lib->resize();
    }
    public function get_category($postData) {
        $limit = '10';
        $offset = $postData['offset'];
        $cal = $limit * $offset;

        $data['select'] = ['*'];
        $data['where'] = ['branch_id' => $postData['branch_id'], 'status !=' => '9'];
        $data['table'] = 'category';
        $data['order'] = 'id DESC';
        if(isset($postData['offset']) && $postData['offset'] != ''){
            $data['limit'] = $limit;
        }
        if(isset($postData['search']) && $postData['search'] != ''){
            $data['like'] = ['name',$postData['search'],'match'];
        }
        if ($offset != 0) {
            $data['skip'] = $cal;
        }
        $res = $this->selectRecords($data);
        // echo $this->db->last_query();die;
        foreach ($res as $key => $value) {
            $result = $this->countSubcategoryOfCategory($value->id);
            $value->image = base_url() . 'public/images/'.$this->folder.'category/' . $value->image;
            $res[$key]->subcategory_count = $result[0]->subcategory_count;
        }
        unset($data);
        if(isset($postData['search']) && $postData['search'] != ''){
            $data['like'] = ['name',$postData['search'],'match'];
        }
        $data['select'] = ['*'];
        $data['where'] = ['branch_id' => $postData['branch_id'], 'status !=' => '9'];
        $data['table'] = 'category';
        $count = $this->countRecords($data);

        if ($res) {
            $return = ['status' => 1, 'message' => 'Data Get Success','count'=>$count,'data' => $res];
        } else {
            $return = ['status' => 0, 'message' => 'No data Found'];
        }
        return $return;
    }
    public function countSubcategoryOfCategory($category_id) {
        $data['table'] = 'subcategory';
        $data['select'] = ['count(id) as subcategory_count'];
        $data['where'] = ['category_id' => $category_id, 'status !=' => '9'];
        return $this->selectRecords($data);
    }
    public function delete_category($postData) {
        $id = $postData['category_id'];
        $branch_id = $postData['branch_id'];
        $update_data = array('category_id' => $id, 'branch_id' => $branch_id);
        $data['table'] = 'order as o';
        $data['select'] = ['p.*'];
        $data['join'] = ['order_details as od' => ['od.order_id=o.id', 'LEFT'], 'product as p' => ['p.id = od.product_id', 'LEFT']];
        $data['where'] = ['o.branch_id' => $branch_id, 'p.category_id' => $id, 'o.order_status <' => '7'];
        // $data['where_or'] = [ 'o.order_status !='=>'9','o.order_status !='=>'8'];
        $re = $this->selectFromJoin($data);
        // echo $this->db->last_query();die;
        if (count($re) > 0) {
            $return = ['status' => 0, 'message' => 'Active order available on the selected category, cannot delete the category'];
            return $return;
        }
        $this->db->select('*');
        $this->db->where_in('category_id', $id);
        $this->db->where('status !=', '9');
        $this->db->from('brand');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = ['status' => 0, 'message' => 'Category is not deleted.. Please delete brand'];
            return $return;
        }
        $this->db->select('*');
        $this->db->where($update_data);
        $this->db->where('status !=', '9');
        $this->db->from('subcategory');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = ['status' => 0, 'message' => 'Category is not deleted.. Please delete subcategory'];
            return $return;
        }
        $this->db->select('*');
        $this->db->where('category_id', $id);
        $this->db->where('status !=', '9');
        $this->db->from('product');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = ['status' => 0, 'message' => 'Category is not deleted.. Please delete product'];
            return $return;
        }
        $data = array('status' => '9');
        $this->db->where('id', $id);
        $this->db->update('category', $data);
        $return = ['status' => 1, 'message' => 'category has been deleted successfully'];
        return $return;
    }
    public function get_subcategory($postData) {
        $limit = '10';
        $offset = $postData['offset'];
        $cal = $limit * $offset;
        $data['select'] = ['s.*', 'c.name as category_name'];
        $data['join'] = [TABLE_CATEGORY.' as c' => ['c.id = s.category_id', 'LEFT']];
        $data['where']['s.branch_id'] = $postData['branch_id'];
        $data['where']['s.status !='] = '9';
        if (isset($postData['category_id']) && $postData['category_id'] != '') {
            $data['where']['s.category_id'] = $postData['category_id'];
        }
        if(isset($postData['search']) && $postData['search'] != ''){
            $data['like'] = ['s.name',$postData['search'],'match'];
            // $data['group']['like'] = ['c.name',$postData['search'],'match'];
        }
        $data['table'] = TABLE_SUBCATEGORY.' as s';
        $data['order'] = 's.id DESC';
        if(isset($postData['offset']) && $postData['offset'] != ''){
            $data['limit'] = $limit;
        }
        if ($offset != 0) {
            $data['skip'] = $cal;
        }
        $res = $this->selectFromJoin($data);
        // echo $this->db->last_query();die;
        unset($data);
        if (isset($postData['category_id']) && $postData['category_id'] != '') {
            $data['where']['s.category_id'] = $postData['category_id'];
        }
        if(isset($postData['search']) && $postData['search'] != ''){
            $data['like'] = ['s.name',$postData['search'],'match'];
            // $data['group']['like'] = ['c.name',$postData['search'],'match'];
        }
        $data['where'] = ['s.branch_id' => $postData['branch_id'], 's.  status !=' => '9'];
        $data['join'] = [TABLE_CATEGORY.' as c' => ['c.id = s.category_id', 'LEFT']];
        $data['order'] = 's.id DESC';
        $data['select'] = ['s.*', 'c.name as category_name'];
        $data['table'] = TABLE_SUBCATEGORY.' as s';
        $count = $this->countRecords($data);

        // echo $this->db->last_query();die;
        if ($res) {
            $return = ['status' => 1, 'message' => 'Data Get Success','count'=>$count,'data' => $res];
        } else {
            $return = ['status' => 0, 'message' => 'No data Found'];
        }
        return $return;
    }
    public function delete_subcategory($postData) {
        $id = $postData['subCategoryid'];
        $branch_id = $postData['branch_id'];
        $data['table'] = 'order as o';
        $data['select'] = ['p.*'];
        $data['join'] = ['order_details as od' => ['od.order_id=o.id', 'LEFT'], 'product as p' => ['p.id = od.product_id', 'LEFT']];
        $data['where'] = ['o.branch_id' => $branch_id, 'p.subcategory_id' => $id, 'o.status !=' => '9', 'o.order_status <' => '7'];
        $re = $this->selectFromJoin($data);
        if (count($re) > 0) {
            $return = ['status' => 0, 'message' => 'Active order available on the selected subcategory, cannot delete the subcategory'];
            return $return;
        }
        $data = array('status' => '9');
        $this->db->select('*');
        $this->db->where('subcategory_id', $id);
        $this->db->where('status !=', '9');
        $this->db->from('product');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $return = ['status' => 0, 'message' => 'subCategory is not deleted.. Please delete product'];
            return $return;
            exit;
        }
        $this->db->where('id', $id);
        $this->db->update('subcategory', $data);
        $return = ['status' => 1, 'message' => 'Subcategory has been deleted successfully'];
        return $return;
    }
    public function subCategory_add_update($postData) {
        $name = $postData['name'];
        $category_id = $postData['category_id'];
        $branch_id = $postData['branch_id'];
        if (isset($postData['subCategory_id']) && $postData['subCategory_id'] != '') {
            $id = $postData['subCategory_id'];
            unset($data);
            $data['table'] = 'subcategory';
            $data['select'] = ['*'];
            $data['where'] = ['name' => $name, 'branch_id' => $branch_id, 'category_id' => $category_id, 'status !=' => '9'];
            $is_available = $this->selectRecords($data);
            if (empty($is_available)) {
                $data = array('name' => $name, 'category_id' => $category_id, 'dt_updated' => strtotime(DATE_TIME),);
                $this->db->where('branch_id', $branch_id);
                $this->db->where('id', $id);
                $this->db->update('subcategory', $data);
                $return = ['status' => 1, 'message' => 'Subcategory has been updated successfully'];
            } else {
                $return = ['status' => 0, 'message' => 'Subcategory has been already added'];
            }
            return $return;
        } else {
            $name = json_decode($name);
            $res = $this->checkDuplicateEntry($name);
            if ($res) {
                return ['status' => 0, 'msg' => "You have entered duplicate data"];
                exit();
            }
            $exists_cate = array();
            foreach ($name as $key => $value) {
                if ($value->name == "") {
                    continue;
                }
                unset($data);
                $data['table'] = 'subcategory';
                $data['select'] = ['*'];
                $data['where'] = ['name' => $value->name, 'branch_id' => $branch_id, 'category_id' => $category_id, 'status !=' => '9'];
                $is_available = $this->countRecords($data);
                $msg = 'error to add';
                if ($is_available > 0) {
                    // array_push($exists_cate,$value->name);
                    // $d = implode(',',$exists_cate);
                    $msg = 'subCategory already exists';
                    $return = ['status' => 0, 'message' => $msg];
                    return $return;
                }
            }
            foreach ($name as $key => $value) {
                $data = array('branch_id' => $branch_id, 'name' => $value->name, 'category_id' => $category_id, 'status' => '1', 'dt_added' => strtotime(DATE_TIME), 'dt_updated' => strtotime(DATE_TIME),);
                $this->db->insert('subcategory', $data);
                $msg = 'Subcategory has been added successfully';
            }
        }
        $return = ['status' => 1, 'message' => $msg];
        return $return;
    }
    public function checkDuplicateEntry($name) {
        $toBeInsertArray = count($name);
        $arr = [];
        foreach ($name as $key => $value) {
            array_push($arr, $value->name);
        }
        $array_uni = array_unique($arr);
        if ($toBeInsertArray != count($array_uni)) {
            return true;
        } else {
            return false;
        }
    }
    public function get_brand($postData) {
         $limit = '10';
        $offset = $postData['offset'];
        $cal = $limit * $offset;
        $data['select'] = ['*'];
        $data['where'] = ['branch_id' => $postData['branch_id'], 'status !=' => '9'];
        if (isset($postData['category_id']) && $postData['category_id'] != '') {
            $ca = explode(',', $postData['category_id']);
            foreach ($ca as $key => $value) {
                $data['where']['FIND_IN_SET ('.$value.',category_id) AND 1='] = '1';
             } 
            // $data['where_in'] = ['category_id',explode(',',$postData['category_id'])];
        }
        if(isset($postData['search']) && $postData['search'] != ''){
            $data['like'] = ['name',$postData['search'],'match'];
            // $data['group']['like'] = ['c.name',$postData['search'],'match'];
        }
        if(isset($postData['offset']) && $postData['offset'] != ''){
            $data['limit'] = $limit;
        }
        $data['table'] = 'brand';
        $data['order'] = 'id DESC';
        if ($offset != 0) {
            $data['skip'] = $cal;
        }
        $res = $this->selectFromJoin($data);
        // echo $this->db->last_query();die;
        unset($data);
        foreach ($res as $key => $value) {
            $category_id = explode(',', $value->category_id);
            $catname = '';
            foreach ($category_id as $k => $v) {
                $data['select'] = ['name as category_name'];
                $data['where'] = ['id' => $v, 'status != ' => '9'];
                $data['table'] = 'category';
                $cat_result = $this->selectFromJoin($data);
                $catname.= $cat_result[0]->category_name . ' , ';
            }
            $value->catname = rtrim($catname, " , ");
        }
        unset($data);
        if (isset($postData['category_id']) && $postData['category_id'] != '') {
            $data['where']['category_id in (' . $postData['category_id'] . ') AND 1 = '] = '1';
        }
        if(isset($postData['search']) && $postData['search'] != ''){
            $data['like'] = ['name',$postData['search'],'match'];
            // $data['group']['like'] = ['c.name',$postData['search'],'match'];
        }
        $data['select'] = ['*'];
        $data['where'] = ['branch_id' => $postData['branch_id'], 'status !=' => '9'];
        $data['table'] = TABLE_BRAND;
        $count = $this->selectFromJoin($data);
        if ($res) {
            $return = ['status' => 1, 'message' => 'Data Get Success','count'=>count($count),'data' => $res];
        } else {
            $return = ['status' => 0, 'message' => 'No data Found'];
        }
        return $return;
    }
    public function brand_add_update($postData) {
        $name = $postData['name'];
        $category_id = json_decode($postData['category_id']);
        $branch_id = $postData['branch_id'];
        foreach ($category_id as $key => $value) {
            $category_aray[] = $value->category_id;
            if ($value == "") {
                continue;
            }
        }
        $cate_id = implode(",", $category_aray);
        /* Brand Update */
        if (isset($postData['brand_id']) && $postData['brand_id'] != '') {
            $data['table'] = 'brand';
            $data['select'] = ['*'];
            $data['where'] = ['name' => $name, 'branch_id' => $branch_id, 'status' => '1'];
            $is_available = $this->selectRecords($data);
            if (empty($is_available) || $is_available[0]->id == $postData['brand_id']) {
                $id = $postData['brand_id'];
                $data = array('name' => $name, 'category_id' => $cate_id, 'dt_updated' => strtotime(DATE_TIME),);
                $this->db->where('branch_id', $branch_id);
                $this->db->where('id', $id);
                $this->db->update('brand', $data);
                // echo $this->db->last_query();exit;
                $return = ['status' => 1, 'message' => 'Brand has been updated successfully'];
            } else {
                $return = ['status' => 0, 'message' => 'Brand already exists'];
            }
            return $return;
        }
        /* Brand Add */
        else {
            $data['table'] = 'brand';
            $data['select'] = ['*'];
            $data['where'] = ['name' => $name, 'branch_id' => $branch_id, 'status' => '1'];
            $is_available = $this->selectRecords($data);
            if (empty($is_available)) {
                $data = array('branch_id' => $branch_id, 'name' => $name, 'category_id' => $cate_id, 'status' => '1', 'dt_added' => strtotime(DATE_TIME), 'dt_updated' => strtotime(DATE_TIME),);
                $this->db->insert('brand', $data);
                $return = ['status' => 1, 'message' => 'Brand has been added successfully'];
            } else {
                $return = ['status' => 0, 'message' => 'Brand already exists'];
            }
            return $return;
        }
    }
    public function delete_brand($postData) {
        $id = $postData['brand_id'];
        $branch_id = $postData['branch_id'];
        $data['table'] = 'order as o';
        $data['select'] = ['p.*'];
        $data['join'] = ['order_details as od' => ['od.order_id=o.id', 'LEFT'], 'product as p' => ['p.id = od.product_id', 'LEFT']];
        $data['where'] = ['o.branch_id' => $branch_id, 'p.brand_id' => $id, 'o.status !=' => '9', 'o.order_status <' => '7'];
        $re = $this->selectFromJoin($data);
        if (count($re) > 0) {
            $return = ['status' => 0, 'message' => 'Active order available on the selected brand, cannot delete the brand'];
            return $return;
        }
        $this->db->select('*');
        $this->db->where('brand_id', $id);
        $this->db->where('status !=', '9');
        $this->db->from('product');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $return = ['status' => 0, 'message' => 'brand not deleted..Please delete the product'];
            return $return;
        }
        $data = array('status' => '9');
        $this->db->where('id', $id);
        $this->db->update('brand', $data);
        $return = ['status' => 1, 'message' => 'Brand has been deleted successfully'];
        return $return;
    }
    public function get_product($postData) {
        $limit = '10';
        $offset = $postData['offset'];
        $cal = $limit * $offset;

        $data['select'] = ['p.*', 'c.name as category_name', 'sc.name as subcategory_name', 'b.name as brand_name'];
        $data['join'] = ['category as c' => ['c.id = p.category_id', 'LEFT'], 'subcategory as sc' => ['sc.id = p.subcategory_id', 'LEFT'], 'brand as b' => ['b.id = p.brand_id', 'LEFT']];
        $data['where'] = ['p.branch_id' => $postData['branch_id'], 'p.status !=' => '9'];
        $data['table'] = 'product as p';
        $data['order'] = 'p.id DESC';
        if(isset($postData['search']) && $postData['search'] != ''){
            $data['like'] = ['p.name',$postData['search'],'match'];
        }
        $data['limit'] = $limit;
        if ($offset != 0) {
            $data['skip'] = $cal;
        }
        $res = $this->selectFromJoin($data);
        foreach ($res as $key => $value) {
            $count = $this->checkVarientCountForProduct($postData['branch_id'], $value->id);
            $res[$key]->varient_count = $count;
        }
         unset($data);
        if(isset($postData['search']) && $postData['search'] != ''){
            $data['like'] = ['name',$postData['search'],'match'];
            // $data['group']['like'] = ['c.name',$postData['search'],'match'];
        }
        $data['select'] = ['*'];
        $data['where'] = ['branch_id' => $postData['branch_id'], 'status !=' => '9'];
        $data['table'] = 'product';
        $count = $this->countRecords($data);
        if ($res) {
            $return = ['status' => 1, 'message' => 'Data Get Success','count'=>$count,'data' => $res];
        } else {
            $return = ['status' => 0, 'message' => 'No Data Found'];
        }
        return $return;
    }
    function checkVarientCountForProduct($branch_id, $product_id) {
        $data['table'] = 'product_weight';
        $data['select'] = ['count("id") as varient_count'];
        $data['where'] = ['branch_id' => $branch_id, 'product_id' => $product_id, 'status !=' => '9'];
        $result = $this->selectRecords($data);
        return $result[0]->varient_count;
    }
    public function get_supplier($postData) {
        $data['select'] = ['*'];
        $data['where'] = ['branch_id' => $postData['branch_id'], 'status !=' => '9'];
        $data['table'] = 'supplier as p';
        $data['order'] = 'id DESC';
        $res = $this->selectFromJoin($data);
        if ($res) {
            $return = ['status' => 1, 'message' => 'Data Get Success', 'data' => $res];
        } else {
            $return = ['status' => 0, 'message' => 'No Data Found'];
        }
        return $return;
    }
    public function get_weight($postData) {
        $branch_id = $postData['branch_id'];
        $vendor_id = $postData['vendor_id'];
        $data['select'] = ['*'];
        $data['where'] = ['vendor_id'=>$vendor_id,'status !=' => '9'];
        $data['table'] = 'weight';
        $data['order'] = 'id DESC';
        $res = $this->selectFromJoin($data);
        if ($res) {
            $return = ['status' => 1, 'message' => 'Data Get Success', 'data' => $res];
        } else {
            $return = ['status' => 0, 'message' => 'No Data Found'];
        }
        return $return;
    }
    public function get_package($postData) {
        $branch_id = $postData['branch_id'];
        $vendor_id = $postData['vendor_id'];

        $data['select'] = ['*'];
        $data['table'] = 'package';
        $data['where'] = ['vendor_id'=>$vendor_id];
        $data['order'] = 'id DESC';
        $res = $this->selectFromJoin($data);
        if ($res) {
            $return = ['status' => 1, 'message' => 'Data Get Success', 'data' => $res];
        } else {
            $return = ['status' => 0, 'message' => 'No Data Found'];
        }
        return $return;
    }
    public function product_add_update($postData) {
        $branch_id = $postData['branch_id'];
        $name = $postData['name'];
        $category_id = $postData['category_id'];
        $brand_id = $postData['brand_id'];
        $subcategory_id = $postData['subcategory_id'];
        // $image = time().$_FILES['image']['name'];
        $about = $postData['about'];
        $content = $postData['content'];
        $supplier_id = $postData['supplier_id'];
        $gst = $postData['gst'];
        $supplier_id = "";
        ## Update Product ##
        if (isset($postData['product_id']) && $postData['product_id'] != '') {
            $id = $postData['product_id'];
            $data = array('category_id' => $category_id, 'brand_id' => $brand_id, 'supplier_id' => $supplier_id, 'subcategory_id' => $subcategory_id, 'name' => $name, 'about' => $about, 'content' => $content, 'gst' => $gst, 'dt_updated' => strtotime(DATE_TIME));
            $this->db->where('id', $id);
            $this->db->where('branch_id', $branch_id);
            $this->db->update('product', $data);
            $return = ['status' => 1, 'message' => 'Product has been updated successfully'];
            return $return;
        }
        ## Add Product ##
        else {
            $data = array('branch_id' => $branch_id, 'category_id' => $category_id, 'brand_id' => $brand_id, 'subcategory_id' => $subcategory_id, 'supplier_id' => $supplier_id, 'name' => $name, 'about' => $about, 'content' => $content, 'status' => '1', 'gst' => $gst, 'dt_added' => strtotime(DATE_TIME), 'dt_updated' => strtotime(DATE_TIME));
            $this->db->insert('product', $data);
            $return = ['status' => 1, 'message' => 'Product has been added successfully'];
            return $return;
        }
    }
    public function delete_product($postData) {
        $id = $postData['product_id'];
        $branch_id = $postData['branch_id'];
        $data['table'] = 'order as o';
        $data['select'] = ['od.*'];
        $data['join'] = ['order_details as od' => ['od.order_id=o.id', 'LEFT']];
        $data['where'] = ['o.branch_id' => $branch_id, 'od.product_id' => $id, 'o.status !=' => '9', 'o.order_status <' => '7'];
        $re = $this->selectFromJoin($data);
        if (count($re) > 0) {
            $return = ['status' => 0, 'message' => 'Active order available on the selected product, cannot delete the product'];
            return $return;
        }
        $data['table'] = 'product';
        $data['select'] = ['*'];
        $data['where'] = ['id' => $id];
        $p = $this->selectRecords($data);
        $data = array('status' => '9');
        $this->db->where('id', $id);
        $status = $this->db->update('product', $data);
        if ($status) {
            $branch_id = $p[0]->vendor_id;
            $where = array('branch_id' => $branch_id, 'product_id' => $id);
            $this->db->where($where);
            $this->db->update('product_weight', $data);
            $return = ['status' => 1, 'message' => 'product has been deleted successfully'];
        }

        unset($data);
        $data['where'] = ['product_id'=>$id];
        $data['table'] = 'my_cart';
        $this->deleteRecords($data);
        return $return;
    }
    public function get_product_weight($postData) {
        $data['select'] = ['pw.*', 'pw.package as package_id', 'pk.package', 'pw.discount_per', 'p.name as product_name', ' w.name as weight_name', 'p.gst'];
        $data['table'] = ['product_weight as pw'];
        $data['join'] = ['package as pk' => ['pk.id = pw.package', 'left'], 'product as p' => ['p.id = pw.product_id', 'left'], 'weight as w' => ['w.id = pw.weight_id', 'left'], ];
        $data['where'] = ['pw.product_id' => $postData['product_id'], 'p.branch_id' => $postData['branch_id'], 'pw.status !=' => '9'];
        $getProduct = $this->selectFromJoin($data);
        // print_r($getProduct);die;
        if ($getProduct) {
            foreach ($getProduct as $key => $value) {
                $getProduct[$key]->gst_amount = (($value->price * $value->gst) / 100);
                unset($data);
                $data['select'] = ['*', "CONCAT('" . base_url() . 'public/images/'.$this->folder.'product_image/' . "',image) AS image"];
                $data['where'] = ['status !=' => '9', 'product_id' => $postData['product_id'], 'branch_id' => $postData['branch_id'], 'product_variant_id' => $value->id];
                $data['table'] = 'product_image';
                $data['order'] = 'image_order';
                $value->product_image_result = $this->selectRecords($data);
            }
            $return = ['status' => 1, 'message' => 'data get suceess', 'data' => $getProduct];
        } else {
            $return = ['status' => 0, 'message' => 'Data not Foundd'];
        }
        return $return;
    }
    public function product_weight_add_update($postData) {
        // print_r($postData);die;
        $branch_id = $postData['branch_id'];
        $product_id = $postData['product_id'];
        $weight_id = $postData['weight_id'];
        // $unit = number_format((float)$postData['unit'], 2, '.', '');
        $unit = $postData['unit'];
        $whole = floor($unit);      
        $fraction = $unit - $whole;
        if($fraction == 0){
            $unit = (int)$unit;   
        }

        $price = number_format((float)$postData['price'], 2, '.', '');
        $quantity = $postData['quantity'];
        $discount_per = $postData['discount_per'];
        $purchase_price = $postData['purchase_price'];
        $package = $postData['package'];
        $discount_price_cal = (($price * $discount_per) / 100);
        $discount_price = number_format((float)$discount_price_cal, 2, '.', '');
        $final_discount_price = number_format((float)$price - $discount_price, 2, '.', '');

        unset($data);
        $data['table'] = 'product';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$product_id];
        $re = $this->selectRecords($data);
        $product_gst = $re[0]->gst;
        unset($data);
         $gst_amount = ($final_discount_price * $product_gst) /100;
         $without_gst_price = $final_discount_price - $gst_amount;
         $without_gst_price = number_format((float)$without_gst_price, 2, '.', '');

        /* Product Weight Update */
        if (isset($postData['variant_id']) && $postData['variant_id'] != '') {
            $id = $postData['variant_id'];
            $data = array('product_id' => $product_id, 'weight_id' => $weight_id, 'weight_no' => $unit, 'package' => $package, 'purchase_price' => $purchase_price, 'price' => $price, 'quantity' => $quantity, 'discount_per' => $discount_per, 'discount_price' => $final_discount_price,'without_gst_price'=>$without_gst_price, 'dt_updated' => strtotime(DATE_TIME),);
            $this->db->where('branch_id', $branch_id);
            $this->db->where('id', $id);
            $this->db->update('product_weight', $data);
            // $this->delete_variant_image($id);
            $this->product_image_add_update($_FILES, $postData, $id);
            $return = ['status' => 1, 'message' => 'Product variant has been updated successfully'];
            return $return;
        }
        /* Product Weight Add */
        else {
            $data = array('branch_id' => $branch_id, 'product_id' => $product_id, 'weight_id' => $weight_id, 'weight_no' => $unit, 'package' => $package, 'purchase_price' => $purchase_price, 'price' => $price, 'quantity' => $quantity, 'discount_per' => $discount_per, 'discount_price' => $final_discount_price, 'without_gst_price'=>$without_gst_price, 'status' => '1', 'dt_added' => strtotime(DATE_TIME), 'dt_updated' => strtotime(DATE_TIME),);
            $this->db->insert('product_weight', $data);
            $variant_id = $this->db->insert_id();
            $this->product_image_add_update($_FILES, $postData, $variant_id);
            $return = ['status' => 1, 'message' => 'Product variant has been added successfully'];
            return $return;
        }
    }
    public function product_image_add_update($file, $postData, $variant_id) {
        $branch_id = $postData['branch_id'];
        if ($file['userfile']['name'][0] != '') {
            $this->load->library('upload');
            if ($file['userfile']['name'][0] != '') {
                ## Image Upload ##
                $this->load->library('upload');
                $files = $file;
                $cpt = count($file['userfile']['name']);
                for ($i = 0;$i < $cpt;$i++) {
                    $file['userfile']['name'] = time() . $files['userfile']['name'][$i];
                    $file['userfile']['type'] = $files['userfile']['type'][$i];
                    $file['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
                    $file['userfile']['error'] = $files['userfile']['error'][$i];
                    $file['userfile']['size'] = $files['userfile']['size'][$i];
                    $image_name = $file['userfile']['name'];
                    $uploadedfile = $file['userfile']['tmp_name'];
                    $explode = explode('.', $image_name);
                    $extension_image = $explode[1];
                    $extension = strtolower($extension_image);
                    if ($extension == "jpg" || $extension == "jpeg") {
                        $uploadedfile = $file['userfile']['tmp_name'];
                        $src = imagecreatefromjpeg($uploadedfile);
                    } else if ($extension == "png") {
                        $uploadedfile = $file['userfile']['tmp_name'];
                        $src = imagecreatefrompng($uploadedfile);
                    } else {
                        $src = imagecreatefromgif($uploadedfile);
                    }
                    list($width, $height) = getimagesize($uploadedfile);
                    $newwidth = 300;
                    $newheight = ($height / $width) * $newwidth;
                    $tmp = imagecreatetruecolor($newwidth, $newheight);
                    $newwidth1 = 400;
                    $newheight1 = ($height / $width) * $newwidth1;
                    $tmp1 = imagecreatetruecolor($newwidth1, $newheight1);
                    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                    imagecopyresampled($tmp1, $src, 0, 0, 0, 0, $newwidth1, $newheight1, $width, $height);
                    $filename = "./public/images/".$this->folder."product_image/" . $image_name;
                    $filename1 = "./public/images/".$this->folder."product_image_thumb/" . $image_name;
                    imagejpeg($tmp, $filename, 100);
                    imagejpeg($tmp1, $filename1, 100);
                    // echo 2;die;
                    $this->upload->initialize($this->set_upload_options_product_image());
                    $this->upload->do_upload();
                    $data = array('image_order' => '0', 'branch_id' => $branch_id, 'image' => $file['userfile']['name'], 'product_id' => $postData['product_id'], 'product_variant_id' => $variant_id, 'status' => '1', 'dt_added' => strtotime(DATE_TIME), 'dt_updated' => strtotime(DATE_TIME));
                    $this->db->insert('product_image', $data);
                    // echo $this->db->last_query();die;
                    // print_r($data);exit;
                    
                }
            } else {
            }
        } else {
        }
    }
    private function set_upload_options_product_image() {
        $config = array();
        $config['upload_path'] = './public/images'.$this->folder.'/product_image/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '0';
        $config['overwrite'] = TRUE;
        return $config;
    }
    function delete_variant_image($postData) {
        $data['where']['id'] = $postData['image_id'];
        $data['table'] = 'product_image';
        $result = $this->deleteRecords($data);
        $return = ['status' => 1, 'message' => 'image has been deleted successfully'];
        return $return;
    }
    public function delete_product_variant($postData) {
        $id = $postData['variant_id'];
        $branch_id = $postData['branch_id'];
        $data['table'] = 'order as o';
        $data['select'] = ['od.*'];
        $data['join'] = ['order_details as od' => ['od.order_id=o.id', 'LEFT']];
        $data['where'] = ['o.branch_id' => $branch_id, 'od.product_weight_id' => $id, 'o.status !=' => '9'];
        $re = $this->selectFromJoin($data);
        if (count($re) > 0) {
            $return = ['status' => 0, 'message' => 'Product is not deleted.. Order available on this Product'];
            return $return;
        }
        unset($data);
        $data = array('status' => '9', 'dt_updated' => strtotime(DATE_TIME));
        $this->db->where('id', $id);
        $this->db->update('product_weight', $data);
        $return = ['status' => 1, 'message' => 'Product variant has been deleted successfully'];

        unset($data);
        $data['where'] = ['product_weight_id'=>$id];
        $data['table'] = 'my_cart';
        $this->deleteRecords($data);
        
        return $return;
    }
    public function getImages($postData) {
        $data['select'] = ['p.name as pname', 'b.name as bname'];
        $data['table'] = 'product as p';
        $data['join'] = ['brand as b' => ['p.brand_id = b.id', 'left']];
        $data['where'] = ['p.status !=' => '9', 'p.vendor_id' => $postData['branch_id'], 'p.id' => $postData['product_id']];
        if (isset($postData['variant_id']) && $postData['variant_id'] != '') {
            $data['where']['product_variant_id'] = $postData['variant_id'];
        }
        $res = $this->selectFromJoin($data);
        unset($data);
        $data['select'] = ['*'];
        $data['table'] = 'product_image';
        $data['where'] = ['status !=' => '9', 'branch_id' => $postData['branch_id'], 'product_id' => $postData['product_id']];
        $data['order'] = 'image_order';
        $imgRes = $this->selectRecords($data);
        foreach ($imgRes as $key => $value) {
            $value->product_name = $res[0]->pname;
            $value->brand_name = $res[0]->bname;
            $value->image = base_url() . 'public/images/'.$this->folder.'product_image/' . $value->image;
        }
        if ($imgRes) {
            $return = ['status' => 1, 'message' => 'data get suceess', 'data' => $imgRes];
        } else {
            $return = ['status' => 0, 'message' => 'Data not Foundd'];
        }
        return $return;
    }

    public function getOrders($postData) {
        $limit = '10';
        $offset = $postData['offset'];
        $cal = $limit * $offset;
        $today = strtotime(date('Y-m-d 00:00:00'));
        $month = strtotime(date('Y-m-01 00:00:00'));
        $data['select'] = ['o.*', 'u.fname', 'u.lname', 'c.customer_name'];
        $data['table'] = 'order as o';
        $data['join'] = ['user as u' => ['u.id = o.user_id', 'left'], 'customer as c' => ['c.id = o.customer_id', 'left'], ];
        $data['where'] = ['o.status !=' => '9', 'o.branch_id' => $postData['branch_id']];
        if (isset($postData['todays_total']) && $postData['todays_total'] != '') {
            $data['where']['o.dt_added >='] = $today;
        }
        if (isset($postData['todays_delivered']) && $postData['todays_delivered'] != '') {
            $data['where']['o.dt_updated >='] = $today;
            $data['where']['o.order_status'] = '8';
        }
        if (isset($postData['total_delivered']) && $postData['total_delivered'] != '') {
            $data['where']['o.order_status'] = '8';
        }
        if (isset($postData['this_month']) && $postData['this_month'] != '') {
            $data['where']['o.dt_added >='] = $month;
        }
        if (isset($postData['search']) && $postData['search'] != '') {
            $data['like'] = ['o.order_no',$postData['search'],'match'];
        }
        $data['limit'] = $limit;
        if ($offset != 0) {
            $data['skip'] = $cal;
        }
        $data['order'] = 'o.dt_updated DESC';
        $result = $this->selectFromJoin($data);
        // echo $this->db->last_query();die;
        foreach ($result as $key => $value) {
            if ($value->order_from == 0) {
                $value->order_from = "POS";
            } else {
                $value->order_from = "Grocery";
            }
            if ($value->payment_type == '0') {
                $value->payment_type = 'COD';
            } else {
                $value->payment_type = 'Credit-card/Debit-card';
            }
            // echo $value->dt_added;die;
            $value->dt_added = date("d-m-Y h:i:sa", $value->dt_added);
            $TotalGstAmount = $this->getGstAmount($value->id);
            $AmountWithoutGst = $value->total - $TotalGstAmount;
            $result[$key]->TotalGstAmount = number_format((float)$TotalGstAmount, '2', '.', '');
            $result[$key]->AmountWithoutGst = number_format((float)$AmountWithoutGst, '2', '.', '');
        }

        //count for data 
        $count = $this->OrdersCount($postData);
        if ($result) {
            $return = ['status' => 1, 'message' => 'data get suceess','count'=>$count, 'data' => $result];
        } else {
            $return = ['status' => 0, 'message' => 'Data not Found'];
        }
        return $return;
    }

    public function OrdersCount($postData){
        $today = strtotime(date('Y-m-d 00:00:00'));
        $month = strtotime(date('Y-m-01 00:00:00'));
        $data['select'] = ['o.*', 'u.fname', 'u.lname', 'c.customer_name'];
        $data['table'] = 'order as o';
        $data['join'] = ['user as u' => ['u.id = o.user_id', 'left'], 'customer as c' => ['c.id = o.customer_id', 'left'], ];
        $data['where'] = ['o.status !=' => '9', 'o.branch_id' => $postData['branch_id']];
        if (isset($postData['todays_total']) && $postData['todays_total'] != '') {
            $data['where']['o.dt_added >='] = $today;
        }
        if (isset($postData['todays_delivered']) && $postData['todays_delivered'] != '') {
            $data['where']['o.dt_updated >='] = $today;
            $data['where']['o.order_status'] = '8';
        }
        if (isset($postData['total_delivered']) && $postData['total_delivered'] != '') {
            $data['where']['o.order_status'] = '8';
        }
        if (isset($postData['this_month']) && $postData['this_month'] != '') {
            $data['where']['o.dt_added >='] = $month;
        }
        if (isset($postData['search']) && $postData['search'] != '') {
            $data['like'] = ['o.order_no',$postData['search'],'match'];
        }
        $data['order'] = 'o.dt_updated DESC';
        $result = $this->selectFromJoin($data);
        return count($result);
    }

    public function getGstAmount($order_id) {
        $data['table'] = TABLE_ORDER_DETAILS;
        $data['select'] = ['*'];
        $data['where'] = ['order_id' => $order_id];
        $result = $this->selectRecords($data);
        $total_gst = 0;
        foreach ($result as $key => $value) {
            $this->load->model('api_v3/api_model');
            $gst = $this->api_model->getProductGst($value->product_id);
            $gst_amount = ($value->discount_price * $gst) / 100;
            $total_gst+= $gst_amount * $value->quantity;
        }
        return $total_gst;
    }
    public function change_order_status($postData) {
        $order_id = $postData['order_id'];

        $data['select'] = ['order_status','branch_id','order_no'];
        $data['where'] = ['id' => $order_id];
        $data['table'] = 'order';
        $results = $this->selectRecords($data);
        $branch_id = $results[0]->branch_id; 
        $order_no = $results[0]->order_no; 

        $this->order_logs($_POST); // insert Order logs;

        if (count($results) > 0) {
            if ($results[0]->order_status == '9') {
                $return = ['status' => 0, 'message' => 'This Order is Cancelled'];
                return $return;
            }
        }
        $status = $postData['status'];
        
        if($status=='9' || $status=='8'){
            if ($status == '8') {
                $send_status = 'Delivered';
                $type = 'order_delivered';
            }
            if ($status == '9') {
                $send_status = 'Cancelled';
                $type = 'order_cancelled';
            }
           $message = $order_no .' is '.$send_status;
           $branchNotification = array(
            'order_id'         =>  $order_id,
            'branch_id'          =>  $branch_id,
            'notification_type'=> $type,
            'message'          => $message,
            'status'           =>'0',
            'dt_created'       => DATE_TIME,
            'dt_updated'       => DATE_TIME
        );
           $this->load->model('api_v3/api_model','api_v3_model');
           $this->api_v3_model->pushAdminNotification($branchNotification);    
       }

        $date = strtotime(DATE_TIME);

        $this->db->query("UPDATE `order` SET order_status = '$status',dt_updated = '$date' WHERE id = '$order_id'");
        if ($status == '4') {
            $this->db->query("UPDATE `order_details` SET delevery_status = '1',dt_updated = '$date' WHERE order_id = '$order_id'");
        }

        $this->send_notificaion($order_id);
        $return = ['status' => 1, 'message' => 'Status Updated'];
        return $return;
    }

     public function order_logs($postData){

            $branch_id = '';
            if (isset($postData['branch_id'])) {
                $branch_id = $postData['branch_id'];
            }
            $data['table'] = 'order_log';
            $insertData = array(
                'order_id' => $postData['order_id'],
                'branch_id'=> $branch_id,
                'order_status'=> $postData['status'],
                'dt_created'=>DATE_TIME
            );
            $data['insert'] = $insertData;
            $this->insertRecord($data);
            return true; 
    }


    public function send_notificaion($order_id) {
        $data['select'] = ['o.user_id', 'd.token', 'd.type', 'd.device_id', 'u.notification_status', 'o.order_status', 'o.order_no','o.branch_id'];
        $data['where'] = ['o.id' => $order_id];
        $data['table'] = 'order AS o';
        $data['join'] = ['device AS d' => ['d.user_id = o.user_id', 'LEFT'], 'user AS u' => ['u.id = o.user_id', 'LEFT'], ];
        $send = $this->selectFromJoin($data);
        $order_status = $send[0]->order_status;
        $branch_id = $send[0]->branch_id;
        // print_r($send);die;

        if ($order_status == '1') {
            $send_status = 'New Order';
        }
        if ($order_status == '2') {
            $send_status = 'Pending for Ready';
        }
        if ($order_status == '3') {
            $send_status = 'Ready For Deliver';
            $this->load->model('api_v3/delivery_api_model');
            $this->delivery_api_model->send_notification($order_id);
        }
        if ($order_status == '4') {
            $send_status = 'Pick up';
        }
        if ($order_status == '5') {
            $send_status = 'On the way';
        }
        if ($order_status == '8') {
            $send_status = 'Delivered';
        }
        if ($order_status == '9') {
            $send_status = 'Cancelled';
        }
        $message = 'Your ' . $send[0]->order_no . ' is ' . $send_status;
        $notification_type = 'order_status';
        $user_id = $send[0]->user_id;
        // echo $this->db->last_query();exit();
        $this->insert_notification($user_id, $message, $notification_type, $order_id);
        unset($data);
        if ($send) {
            if ($send[0]->notification_status == '1') {
                $dataArray = array('device_id' => $send[0]->token, 'type' => $send[0]->type, 'message' => $message,);
                $this->load->model('api_v3/api_model');
                $result = $this->api_model->getNotificationKey($branch_id);
                $this->utility_apiv2->sendNotification($dataArray, $notification_type,$result);
            }
        }
    }
    public function insert_notification($user_id, $message, $notification_type = NULL, $type_id = NULL) {
        $insertion = array('user_id' => $user_id, 'notification_for' => $notification_type, 'for_id' => $type_id, 'notification' => $message, 'dt_created' => DATE_TIME, 'dt_updated' => DATE_TIME,);
        $data['insert'] = $insertion;
        $data['table'] = 'notification';
        $this->insertRecord($data);
        return true;
    }
    public function verify_otp($postData) {
        $id = $postData['order_id'];
        $otp = $postData['otp'];
        $data['update']['otp_verify'] = '1';
        $data['update']['dt_updated'] = DATE_TIME;
        $data['where'] = ['order_id' => $id, 'otp' => $otp];
        $data['table'] = 'delivery_order';
        $res = $this->updateRecords($data);
        if ($res) {
            unset($data);
            $data['update']['order_status'] = '5';
            $data['update']['dt_updated'] = strtotime(DATE_TIME);
            $data['where'] = ['id' => $id];
            $data['table'] = 'order';
            $re = $this->updateRecords($data);
            $return = ['status' => 1, 'message' => 'Otp Varified'];
        } else {
            $return = ['status' => 0, 'message' => 'Invalid Otp'];
        }
        return $return;
    }
    public function order_detail($postData) {
        $branch_id = $postData['branch_id'];
        $order_id = $postData['order_id'];
        $data['select'] = ['od.*', 'u.id as user_id', 'u.fname', 'u.email as user_email', 'u.lname', 'w.name as weight_name', 'p.name'];
        $data['join'] = ['user as u' => ['u.id = od.user_id', 'left'], 'weight as w' => ['w.id = od.weight_id', 'left'], 'product as p' => ['p.id = od.product_id', 'left'], ];
        $data['where'] = ['od.status !=' => '9', 'od.branch_id' => $branch_id, 'od.order_id' => $order_id];
        $data['table'] = 'order_details as od';
        $data['order'] = 'od.id DESC';
        $order_detail_result = $this->selectFromJoin($data);
        $user_id = $order_detail_result[0]->user_id;
        unset($data);
        $data['select'] = ['o.order_no', 'o.dt_added', 'o.name', 'o.mobile', 'o.delivered_address'];
        $data['where'] = ['o.id' => $order_id];
        $data['table'] = 'order as o';
        $order = $this->selectRecords($data);
        // print_r($order);die;
        unset($data);
        $data['select'] = ['ua.address', 'ua.city', 'ua.state', 'ua.country', 'ua.phone'];
        $data['where'] = ['ua.user_id' => $user_id];
        $data['table'] = 'user_address as ua';
        $user_detail = $this->selectRecords($data);
        $user_detail[0]->order_no = $order[0]->order_no;
        $user_detail[0]->email = $order_detail_result[0]->user_email;
        $user_detail[0]->order_date = $order[0]->dt_added;
        $user_detail[0]->full_address = $order[0]->delivered_address;
        $user_detail[0]->delivered_phone = $order[0]->mobile;
        $user_detail[0]->name = $order[0]->name;
        unset($data);
        $data['select'] = ['*'];
        $data['where'] = ['id' => $branch_id];
        $data['table'] = 'branch';
        $vendor_detail = $this->selectRecords($data);
        unset($data);
        $data['select'] = ['order_status', 'dt_added', 'delivery_charge'];
        $data['where'] = ['id' => $order_id];
        $data['table'] = 'order';
        $order_detail = $this->selectRecords($data);
        $order_detail[0]->dt_added = date("Y-m-d h:i:sa", $order_detail[0]->dt_added);
        $image = array();
        $delivery_charge = $order_detail[0]->delivery_charge;
        foreach ($order_detail_result as $k => $result) {
            $total = $result->calculation_price;
            unset($data);
            $data['select'] = ['weight_no'];
            $data['where'] = ['product_id' => $result->product_id, 'weight_id' => $result->weight_id];
            $data['table'] = 'product_weight';
            $weight_result = $this->selectRecords($data);
            $result->gtotal = $total + $gtotal;
            unset($data);
            $data['select'] = ['*'];
            $data['where'] = ['product_id' => $result->product_id, 'product_variant_id' => $result->product_weight_id, 'branch_id' => $branch_id];
            $data['table'] = 'product_image';
            $product_image = $this->selectRecords($data);
            // echo $this->db->last_query();die;
            if (!empty($product_image)) {
                foreach ($product_image as $key => $image) {
                    $pro_image = base_url() . 'public/images/'.$this->folder.'product_image_thumb' . $image->image;
                    $order_detail_result[$k]->image = $pro_image;
                }
            } else {
                $order_detail_result[$k]->image = $product_image;
            }
        }
        $return = ['status' => 1, 'message' => 'data', 'order_detail' => $order_detail_result, 'user_detail' => $user_detail[0], 'vendor_detail' => $vendor_detail, 'order_status' => $order_detail[0]];
        return $return;
    }
    function dashboard($postData) {
        $branch_id = $postData['branch_id'];
        $today = strtotime(date('Y-m-d 00:00:00'));
        $total_order = $this->db->query("SELECT count(*) as total FROM `order` WHERE  branch_id = '$branch_id'");
        $total_order = $total_order->row_array();
        $total_order_today = $this->db->query("SELECT count(*) as total FROM `order` WHERE dt_added  >= '$today'  AND branch_id = '$branch_id'");
        $total_order_today = $total_order_today->row_array();
        // echo $this->db->last_query();die;
        $month = strtotime(date('Y-m-01 00:00:00'));
        $total_order_month = $this->db->query("SELECT count(*) as total FROM `order` WHERE dt_added >= '$month'  AND branch_id = '$branch_id'");
        $total_order_monthly = $total_order_month->row_array();
        $del = strtotime(date('Y-m-d 00:00:00'));
        $total_order_del = $this->db->query("SELECT count(*) as total FROM `order` WHERE dt_updated >= '$today'  AND branch_id = '$branch_id' AND order_status = '8'");
        // echo $this->db->last_query();exit;
        $total_order_delt = $total_order_del->row_array();
        $total_del = $this->db->query("SELECT count(*) as total FROM `order` WHERE  branch_id = '$branch_id' AND order_status = '8'");
        // echo $this->db->last_query();exit;
        $total_delt = $total_del->row_array();
        $res['total_order'] = $total_order['total'];
        $res['total_order_today'] = $total_order_today['total'];
        $res['total_deliverToday'] = $total_order_delt['total'];
        $res['total_order_monthly'] = $total_order_monthly['total'];
        $res['total_delivered'] = $total_delt['total'];
        $return = ['status' => 1, 'message' => 'data', 'order_detail' => $res];
        return $return;
    }
    public function subscription($postData) {
        $branch_id = $postData['branch_id'];
        $query_currency = $this->db->query("SELECT value FROM set_default WHERE request_id = '3' ");
        $getcurrency = $query_currency->row_array();
        $subscription_query = $this->db->query("SELECT  * FROM `subscription` 
                                                WHERE vendor_id = '$branch_id'  ORDER BY id DESC");
        $subscription_result = $subscription_query->result();
        foreach ($subscription_result as $result) {
            $result->total_ammount = $getcurrency['value'] . ' ' . $result->total_ammount;
        }
        if (count($subscription_result) > 0) {
            $return = ['status' => 1, 'message' => 'data', 'subscription_detail' => $subscription_result];
        } else {
            $return = ['status' => 0, 'message' => 'no data'];
        }
        return $return;
    }
    public function sendMailSMTP($data) {
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "162.241.86.206";
        $config['smtp_port'] = '587';
        $config['smtp_user'] = "test@launchestore.com";
        $config['smtp_pass'] = "HhZ~sU(@drk_";
        $config['smtp_timeout'] = 20;
        $config['priority'] = 1;
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['mailtype'] = "html";
        $CI = & get_instance();
        $message = $data["message"];
        $CI->load->library('email', $config);
        $CI->email->initialize($config);
        $CI->email->clear();
        $CI->email->from($config['smtp_user'], $this->siteTitle);
        $CI->email->to($data["to"]);
        if (isset($data["bcc"])) {
            $CI->email->bcc($data["bcc"]);
        }
        $CI->email->reply_to($config['smtp_user'], '<noreply@stagegator.com>');
        $CI->email->subject($data["subject"]);
        $CI->email->message($message);
        $response = $CI->email->send();
        //      echo $this->email->print_debugger();
        // die;
        return true;
    }
    public function update_token($branch_id) {
        // print_r($branch_id);exit;
        $token = md5('user_' . time());
        $token = "1234";
        $data['update']['token'] = $token;
        $data['update']['dt_updated'] = DATE_TIME;
        $data['where'] = ['id' => $branch_id];
        $data['table'] = 'branch';
        $updateRecord = $this->updateRecords($data);
        return $token;
    }
    function token_validate() {
        // print_r($_SERVER);die;
        if ((!isset($_SERVER['HTTP_X_API_TOKEN'])) || (empty($_SERVER['HTTP_X_API_TOKEN']))) {
            return false;
        } else {
            $data['select'] = ['count(0) as count'];
            $data['where'] = ['token' => $_SERVER['HTTP_X_API_TOKEN']];
            $data['table'] = 'branch';
            $response = $this->selectRecords($data);
            // echo $this->db->last_query();
            // print_r($response);die;
            if (@$response[0]->count == 0) {
                return false;
            } else {
                return true;
            }
        }
    }

     public function EmailMessage($postData){
        $vendor_id = $postData['vendor_id'];
        $data['select'] = ['name as storeName','owner_name','email','phone_no'];
        $data['where'] = ['id'=>$vendor_id,'status'=>'1'];
        $data['table'] = 'branch';
        $result = $this->selectRecords($data);
        return $result;


    }
}
?>