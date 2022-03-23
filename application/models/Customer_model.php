<?php 

Class Customer_model extends My_model{

    function __construct(){
        $this->vendor_id = $this->session->userdata('id');
    }

    public function customerOne(){
        $data['table'] = 'customer_group';
        $data['select'] = ['*'];
        $data['where'] = ['status !=' =>'9', 'vendor_id'=>$this->vendor_id];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
    }

    public function result_client(){
        $data['table'] = 'customer';
        $data['select'] = ['*'];
        $data['where'] = ['status != ' =>'9', 'vendor_id'=>$this->vendor_id];
        return $this->selectRecords($data);
    }

    public function query(){
        $data['table'] = 'customer_group';
        $data['select'] = ['*'];
        $data['where'] = ['status != ' =>'9', 'vendor_id'=>$this->vendor_id,];
        return $this->selectRecords($data);
    }

    public function checkAvailability($email){
        $data['table'] = 'customer';
        $data['select'] = ['*'];
        $data['where'] = [  'email'=> $email,
                            'status != ' =>'9', 
                            'vendor_id'=>$this->vendor_id
                        ];
        return $this->selectRecords($data);
    }

    public function insertData($postData)
    {
        
            $customername = $postData['txtCustomerName'];
            $dob = $postData['txtDOB'];
            $email = $postData['txtEmail'];
            $group_id = $postData['customer_group'];
            $companyname = $postData['txtCompany'];
            $customercode = $postData['txtCustomerCode'];
            $gender = $postData['txtGender'];
            $phonenumber = $postData['txtPhoneNumber'];
            $mobile = $postData['txtMobile'];
            $formatted_date = date("Y-m-d", strtotime($dob));
            //        $formatted_date = date('Y-m-d', strtotime($dob];
            $fax = $postData['txtFax'];
            $website = $postData['txtWebsite'];
            $twitter = $postData['txtTwitter'];
            $street1 = $postData['txtStreet1'];
            $street2 = $postData['txtStreet2'];
            $city = $postData['txtCity'];
            $state = $postData['txtState'];
            $country = $postData['txtCountry'];
            $postalcode = $postData['txtPostalCode'];


            $record = array(
                'customer_name' => $customername,
                'company' => $companyname,
                'customercode' => $customercode,
                'gender' => $gender,
                'phone' => $phonenumber,
                'mobile' => $mobile,
                'email' => $email,
                'fax' => $fax,
                'dob' => $formatted_date,
                'website' => $website,
                'twitter' => $twitter,
                'street1' => $street1,
                'street2' => $street2,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'postcode' => $postalcode,
                'vendor_id' => $this->vendor_id,
                'group_id' => $group_id,
                'status' => '1',
                'dt_added' => strtotime(date('Y-m-d H:i:s')),
                'dt_updated' => strtotime(date('Y-m-d H:i:s'))
            );
           $data['table'] = 'customer';
           $data['insert'] = $record;
          return  $this->insertRecord($data);
    }

    public function getEditRecord($customerid){
        $data['table'] = 'customer';
        $data['select'] = ['*']; 
        $data['where'] = ['id'=>$customerid];
        return $this->selectRecords($data);
    }

    public function getGroupRecord(){
        $data['table'] = 'customer_group';
        $data['select'] = ['*']; 
        $data['where'] = ['status != ' => '9','vendor_id'=>$this->vendor_id];
        return $this->selectRecords($data);
    }

    public function UpdateData($postData){
        $group_id = $postData['group'];
        $email = $postData['txtEmail'];
        $customerid = $postData['txtCustomerid'];
        $customername = $postData['txtCustomerName'];
        $companyname = $postData['txtCompany'];
        $customercode = $postData['txtCustomerCode'];
        $gender = $postData['txtGender'];
        $phonenumber = $postData['txtPhoneNumber'];
        $mobile = $postData['txtMobile'];
        $dob = $postData['txtDOB'];
        $formatted_date = date("Y-m-d", strtotime($dob));
        $fax = $postData['txtFax'];
        $website = $postData['txtWebsite'];
        $twitter = $postData['txtTwitter'];
        $street1 = $postData['txtStreet1'];
        $street2 = $postData['txtStreet2'];
        $city = $postData['txtCity'];
        $state = $postData['txtState'];
        $country = $postData['txtCountry'];
        $postalcode = $postData['txtPostalCode'];
        $vendor_id = $this->vendor_id;


        $UpdateData = array(
            'customer_name' => $customername,
            'company' => $companyname,
            'customercode' => $customercode,
            'gender' => $gender,
            'phone' => $phonenumber,
            'mobile' => $mobile,
            'email' => $email,
            'fax' => $fax,
            'dob' => $formatted_date,
            'website' => $website,
            'twitter' => $twitter,
            'street1' => $street1,
            'street2' => $street2,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'postcode' => $postalcode,
            'vendor_id' => $vendor_id,
            'group_id' => $group_id,

        );

        $data['table'] = 'customer';
        $data['update'] = $UpdateData;
        $data['where'] = ['id'=>$customerid];
        return $this->updateRecords($data);
    }

    public function deleteEntry($ids){
         $update = array(
            'dt_updated' => strtotime(date('Y-m-d H:i:s')),
            'status' => '9'
        );
         $data['table'] = 'customer';
         $data['update'] = $update;
         $data['where'] = ['id'=>$ids];
         return $this->updateRecords($data);
    }

    public function GroupView($id){
        $data['table'] = 'customer';
        $data['select'] = ['*'];
        $data['where'] = [
            'group_id'=>$id,
            'vendor_id'=>$this->vendor_id,
            'status!=' => '9'
        ];
        return $this->selectRecords($data);
    }

    public function addGroup($postData){

        $type_array = array(
            'name' => $postData['name'],
            'vendor_id' => $this->vendor_id,
            'status' => '1',
            'dt_added' => strtotime(date('Y-m-d H:i:s')),
            'dt_updated' => strtotime(date('Y-m-d H:i:s'))
        );
        $data['table'] = 'customer_group';
        $data['insert'] =  $type_array;
        return $this->insertRecord($data);
    }

    public function update_group($id){
        $name = $this->input->post('name');
        $vendor_id = $this->session->userdata('id');
        $type_array = array(
            'name' => $name,
            'vendor_id' => $vendor_id,

            'status' => '1',
            'dt_added' => strtotime(date('Y-m-d H:i:s')),
            'dt_updated' => strtotime(date('Y-m-d H:i:s'))
        );
        $data['table'] = 'customer_group';
        $data['update'] = $type_array;
        $data['where'] = ['id'=>$id];
        return $this->updateRecords($data);
    }

    public function deleteSingleGroup($id){
        $da = array('status' => '9');
        $data['table'] = 'customer_group';
        $data['update'] = $da;
        $data['where'] = ['id'=>$id];
        return $this->updateRecords($data);
    } 

    public  $order_column_customer = array("customer_name","company","gender","phone","email","city","state","country","postcode"); 
    function make_query_customer($postData){
        $where = [
            'vendor_id'=>$this->vendor_id,
            'status !='=>'9',  
        ];
         $this->db->select('*');  
         $this->db->from('customer');
         $this->db->where($where);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
          $this->db->group_start();

            $this->db->like("customer_name", $postData["search"]["value"]); 
            $this->db->or_like("company", $postData["search"]["value"]); 
            $this->db->or_like("gender", $postData["search"]["value"]); 
            $this->db->or_like("phone", $postData["search"]["value"]); 
            $this->db->or_like("email", $postData["search"]["value"]); 
            $this->db->or_like("city", $postData["search"]["value"]); 
            $this->db->or_like("state", $postData["search"]["value"]); 
            $this->db->or_like("country", $postData["search"]["value"]); 
            $this->db->or_like("postcode", $postData["search"]["value"]); 
            $this->db->group_end(); 
            }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_customer[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('id', 'DESC');  
           } 
    }


    function make_datatables_customer($postData){ 
        $this->make_query_customer($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            // echo $this->db->last_query();
        }

    function get_filtered_data_customer($postData = false){  
        $this->make_query_customer($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }       
    
    function get_all_data_customer(){
       $where = [
            'vendor_id'=>$this->vendor_id,
            'status !='=>'9',  
        ];
        $this->db->select("*");  
        $this->db->from('customer');
        $this->db->where($where);
        return $this->db->count_all_results();   
    }

    public  $order_column_group = array("name","dt_updated"); 
    function make_query_group($postData){
        $where = [
            'vendor_id'=>$this->vendor_id,
            'status !='=>'9',  
        ];
         $this->db->select('*');  
         $this->db->from('customer_group');
         $this->db->where($where);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
        $this->db->group_start();
            $this->db->like("name", $postData["search"]["value"]); 
            $this->db->or_like("dt_updated", $postData["search"]["value"]); 
        $this->db->group_end(); 
        }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_group[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('id', 'DESC');  
           } 
    }


    function make_datatables_group($postData){ 
        $this->make_query_group($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            // echo $this->db->last_query();
        }

    function get_filtered_data_group($postData = false){  
        $this->make_query_group($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }       
    
    function get_all_data_group(){
       $where = [
            'vendor_id'=>$this->vendor_id,
            'status !='=>'9',  
        ];
        $this->db->select("*");  
        $this->db->from('customer_group');
        $this->db->where($where);
        return $this->db->count_all_results();   
    }

}

?>