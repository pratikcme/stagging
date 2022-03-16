<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends Vendor_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->model('customer_model','this_model');
    }

    public function customer1(){ 
        $data['group_result'] = $this->this_model->customerOne();
        $this->load->view('customer',$data);
    }

    public function customer_list(){
        $data['row_client'] = $this->this_model->result_client();
        // echo '<pre>';
        // print_r($data['row_client']);die;
        $data['table_js'] = array('customer.js');
        $data['start'] = array('CUSTOMER.table()');
        $this->load->view('customer_list',$data);
    }

    public function getAjaxCustomerlist(){
        if($this->input->post()){
            echo getCustomerlist($this->input->post());
        }
    }

    public function customer_group_list(){
        $data['result'] = $this->this_model->query();
        $data['table_js'] = array('customer.js');
        $data['start'] = array('CUSTOMER.grouptable()');
        $this->load->view('customer_group_list',$data);
    }

    public function getAjaxGroupTablelist(){
        if($this->input->post()){
            echo getGrouplist($this->input->post());
        }
    }


    public function group_customer_view(){
        $id = $_GET['id'];
        $data['row'] = $this->this_model->GroupView($id);
        // print_r($data['row']);die;   
        $this->load->view('group_customer_view',$data);
    }

    public function insert_customer(){
        $vendor_id = $this->session->userdata('id');
        $email = $this->input->post('txtEmail');
        $check = $this->this_model->checkAvailability($email);
        if (!empty($check)){
            $this->session->set_flashdata('msg', 'User already registered');
            redirect(base_url() . 'customer/customer_list');
        }else{
            $insert_data = $this->this_model->insertData($this->input->post());

            if ($insert_data) {
                $this->session->set_flashdata('msg', 'Customer has been added successfully');
                redirect(base_url() . 'customer/customer_list');
            } else {
                $this->session->set_flashdata('msg', 'Error');
                redirect(base_url() . 'customer/customer_list');
            }
        }
    }

    public function edit_customer(){
        $customerid = $this->utility->decode($_GET['customerid']);
        $data['row_result'] = $this->this_model->getEditRecord($customerid);
        $data['group_result'] = $this->this_model->getGroupRecord();
        $this->load->view('edit_customer',$data);
    }

    public function edit_customer_form(){
       
        if($this->input->post()){
            $insert_data=$this->this_model->UpdateData($this->input->post());
            if($insert_data){
                $this->session->set_flashdata('msg','Customer has been updated successfully');
                redirect(base_url() . 'customer/customer_list');
            }else{
                $this->session->set_flashdata('msg', 'Error');
                redirect(base_url() . 'customer/customer_list');
            }
        }

    }


    ## Single Delete Customer ##
    public function single_delete_customer()
    {
        $ids = $_GET['id'];
        $this->this_model->deleteEntry($ids);
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status' => 1]);
        exit;
    }


    // Export code for customer starts Here

    public function exportExcelData($records)

    {

        $heading = false;

        if (!empty($records))

            foreach ($records as $row) {

                if (!$heading) {

                    // display field/column names as a first row

                    echo implode("\t", array_keys($row)) . "\n";

                    $heading = true;

                }

                echo implode("\t", ($row)) . "\n";

            }

    }


    public function fetchDataFromTable_customer()

    {

        $vendor_id = $this->session->userdata('id');
        $parent_vendor_id = $this->session->userdata('parent_id');

        $query = $this->db->query("select * from customer where status != '9' AND parent_vendor_id='$parent_vendor_id' OR parent_vendor_id ='$vendor_id' OR vendor_id = '$vendor_id' OR vendor_id = '$parent_vendor_id'");

        $allData = $query->result_array();  // this will return all data into array

        $dataToExports = [];

        foreach ($allData as $data) {

            $arrangeData['Customer Name'] = $data['customer_name'];

            $arrangeData['Company'] = $data['company'];

            $arrangeData['Date of Birth'] = $data['dob'];

            $arrangeData['Gender'] = $data['gender'];

            $arrangeData['Phone Number'] = $data['phone'];

            $arrangeData['Mobile Number'] = $data['mobile'];

            $arrangeData['Email Address'] = $data['email'];

            $arrangeData['Street1'] = $data['street1'];

            $arrangeData['Street2'] = $data['street2'];

            $arrangeData['State'] = $data['state'];

            $arrangeData['City'] = $data['city'];

            $arrangeData['Country'] = $data['country'];

            $arrangeData['Post Code'] = $data['postcode'];

            $arrangeData['User Id'] = $data['vendor_id'];

            $dataToExports[] = $arrangeData;

        }

        // set header

        $filename = "Customer_list.xls";

        header("Content-Type: application/vnd.ms-excel");

        header("Content-Disposition: attachment; filename=\"$filename\"");

        $this->exportExcelData($dataToExports);

    }
    // Export code Ends Here for customer

    //Import/ Download CSV File
    public function import()
    {

        if (isset($_POST['submit']) && $_POST['submit'] == 'Import Customer') {

            $filename = $_FILES["import_file"]["tmp_name"];
            if ($_FILES["import_file"]["size"] > 0) {
                $file = fopen($filename, "r");
                $i = 0;
                while (($emapData = fgetcsv($file, 10000000, ",")) !== FALSE) {
                    $i++;
                    if ($i == 1) continue;

                    if ($parent_id == '0') {
                        $parent_insert_id = '1';
                    } else {
                        $parent_insert_id = $this->session->userdata('parent_id');
                    }

                    $data = array(
                        'vendor_id' => $this->session->userdata('id'),

                        'customer_name' => $emapData[0],
                        'company' => $emapData[1],
                        'customercode' => $emapData[2],
                        'gender' => $emapData[3],
                        'password' => $emapData[4],
                        'email' => $emapData[5],
                        'phone' => $emapData[6],
                        'mobile' => $emapData[7],
                        'fax' => $emapData[8],
                        'website' => $emapData[9],
                        'twitter' => $emapData[10],
                        'street1' => $emapData[11],
                        'street2' => $emapData[12],
                        'city' => $emapData[13],
                        'state' => $emapData[14],
                        'country' => $emapData[15],
                        'postcode' => $emapData[16],
                        'status' => '1'
                    );

                    $this->db->insert('customer', $data);
                }

                $this->session->set_flashdata('msg', 'Customer file has been imported successfully');
                redirect(base_url() . 'customer/customer_list');
            }
        }

    }

    public function downloadCSV()
    {

        $this->load->helper('download');
        $pth = file_get_contents(base_url() . '/public/attach_file/customer.csv');
        $nme = "customer.csv";
        force_download($nme, $pth);

        $this->session->set_flashdata('msg', 'Customer file has been downloaded successfully');
        redirect(base_url() . 'customer/customer_list');
    }

    ## Add new sales tax ##
    public function add_group()
    {
        $vendor_id = $this->session->userdata('id');
        $this->this_model->addGroup($this->input->post());
        $this->session->set_flashdata('msg', 'Customer group has been added successfully.');
        redirect(base_url() . 'customer/customer_group_list');
    }

    ## Select data ##
    public function select_type()
    {
        $ids = $_GET['ids'];

        $query = $this->db->query("SELECT * FROM customer_group WHERE id = '$ids'");
        $row_query = $query->result();
        $name = $row_query['0']->name;

        $array = array(
            'name' => $name
        );

        echo json_encode($array);
        exit;
    }

    ## Update sales tax ##
    public function update_group()
    {
        $id = $this->input->post('id');
        $this->this_model->update_group($id);
        $this->session->set_flashdata('msg', 'Customer group has been updated successfully.');
        redirect(base_url() . 'customer/customer_group_list');
    }

    ## Single Delete ##
    public function single_delete_group()
    {
        $ids = $_GET['ids'];
        $this->this_model->deleteSingleGroup($ids);
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status' => 1]);
        exit;
    }
}

