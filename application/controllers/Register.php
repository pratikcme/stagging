<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Calcutta');

$date=date('Y-m-d H:i:s');
//echo $date;exit;
class Register extends Vendor_Controller {

    public function open_register()
    {
        $this->load->view('registeropen');
    }

    public function close_register()
    {
        $this->load->view('registerclosure');
    }

    public function closure_summary()
    {
        $this->load->view('closure_summary');
    }

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

    public function register_closures_export()
    {
        $vendor_id = $this->session->userdata('id');
        $query = $this->db->query("SELECT * FROM register WHERE vendor_id = '$vendor_id' ORDER BY id DESC");
        $allData = $query->result_array();

        $dataToExports = [];

        $count = 1;
        foreach ($allData as $data) {

            if($data['type'] == 1){
                $type = 'Open';
            }elseif($data['type'] == 0){
                $type = 'Close';
            }

            $opening_time = date("Y-m-d H:i:s", $data['opening_time']);
            $closing_time = date("Y-m-d H:i:s", $data['closing_time']);

            $arrangeData['Register No.'] = $count++;
            $arrangeData['Cash Amount'] = $data['cash_amount_expected'];
            $arrangeData['Cash Amount Counted'] = $data['counted'];
            $arrangeData['Credit Card Amount'] = $data['credit_card_expected'];
            $arrangeData['Credit Card Counted'] = $data['credit_card_counted'];
            $arrangeData['Store Credit Amount'] = $data['store_credit_expected'];
            $arrangeData['Store Credit Counted'] = $data['store_credit_counted'];
            $arrangeData['Opening Time'] = $opening_time;
            $arrangeData['closing_time'] = $closing_time;
            $arrangeData['type'] =  $type;

            $dataToExports[] = $arrangeData;
        }

        // set header
        $filename = "Register Closures.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $this->exportExcelData($dataToExports);

    }

    public function opening_cash()
    {
        $vendor_id = $this->session->userdata('id');
        $opening_amount = $_REQUEST['amount'];
        $opening_note = $_REQUEST['note'];

        $array = array(
            'vendor_id' => $vendor_id,
            'cash_amount_expected' => $opening_amount,
            'transaction' => $opening_amount,
            'open_note' => $opening_note,
            'opening_time' => strtotime(date('Y-m-d H:i:s')),
            'type' => '1'
        );
        $this->db->insert('register', $array);
        redirect(base_url() . 'sell/index');
    }

    public function update_cash_summary()
    {
        $id = $_REQUEST['id'];
        $expected_value = $_REQUEST['expected_value'];
        $counted = $_REQUEST['counted'];
        $cash_dif = $_REQUEST['cash_dif'];

        $array = array(
            'cash_amount_expected' => $expected_value,
            'counted' => $counted,
            'difference' => $cash_dif
        );

        $this->db->where('id', $id);
        $this->db->update('register', $array);

        $return_array = array(
            'cash_counted' => $counted,
            'cash_difference' => $cash_dif
        );

        echo json_encode($return_array);
        return;
        exit();
    }

    public function update_cc_summary()
    {

        $id = $_REQUEST['id'];
        $expected_value = $_REQUEST['expected_value'];
        $counted = $_REQUEST['counted'];
        $cash_dif = $_REQUEST['cash_dif'];

        $array = array(
            'credit_card_expected' => $expected_value,
            'credit_card_counted' => $counted,
            'credit_card_differences' => $cash_dif
        );

        $this->db->where('id', $id);
        $this->db->update('register', $array);

        $return_array = array(
            'credit_card_counted' => $counted,
            'credit_card_differences' => $cash_dif
        );

        echo json_encode($return_array);
        return;
        exit();
    }

    public function update_sc_summary()
    {

        $id = $_REQUEST['id'];
        $expected_value = $_REQUEST['expected_value'];
        $counted = $_REQUEST['counted'];
        $cash_dif = $_REQUEST['cash_dif'];

        $array = array(
            'store_credit_expected' => $expected_value,
            'store_credit_counted' => $counted,
            'store_credit_differences' => $cash_dif
        );

        $this->db->where('id', $id);
        $this->db->update('register', $array);

        $return_array = array(
            'store_credit_counted' => $counted,
            'store_credit_differences' => $cash_dif
        );

        echo json_encode($return_array);
        return;
        exit();
    }

    public  function close_register_button(){
        $id = $_REQUEST['id'];
        $closure_note = $_REQUEST['closure_note'];

        $array = array(
            'type' => '0',
            'closure_note' => $closure_note,
            'closing_time' => strtotime(date('Y-m-d H:i:s'))
        );
        $this->db->where('id', $id);
        $this->db->update('register', $array);
        redirect(base_url() . 'register/open_register');
        exit();
    }
}