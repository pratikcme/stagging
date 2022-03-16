<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends Vendor_Controller {
      function __construct(){
        parent::__construct();
        $this->load->model('Report_model','this_model');
    }
    public function index()
    {
    $vendor_id = $this->session->userdata('id');
if(isset($_POST['select_year_product']) && !isset($_POST['btn_date']) ) {
    $select_year_product = $_REQUEST['select_year_product'];
    @$type = $_REQUEST['type'];
    $data['type'] = @$type;
   // echo $type;exit;
    if($type == 9 || !isset($type)){
        $where = "1=1";
        $type = "";
    }elseif ($type == 0){
        $where = "order_from ='0'";
        $type = "0";
    }else{
        $where= "order_from ='1'";
        $type = "1";
    }
    $data['select_year_product'] = $select_year_product;
    // echo $this->db->last_query(); die;

    ##Cash On Delivery : Start##
   $data['row_first_month'] = $this->this_model->selectYearProduct('1','0',$select_year_product,$type);
 // exit;
   $data['row_second_month'] = $this->this_model->selectYearProduct('2','0',$select_year_product,$type);

   $data['row_third_month'] = $this->this_model->selectYearProduct('3','0',$select_year_product,$type);

   $data['row_fourth_month'] = $this->this_model->selectYearProduct('4','0',$select_year_product,$type);

   $data['row_fifth_month'] = $this->this_model->selectYearProduct('5','0',$select_year_product,$type);

   $data['row_six_month'] = $this->this_model->selectYearProduct('6','0',$select_year_product,$type);

   $data['row_seven_month'] = $this->this_model->selectYearProduct('7','0',$select_year_product,$type);

   $data['row_eight_month'] = $this->this_model->selectYearProduct('8','0',$select_year_product,$type);

   $data['row_nine_month'] = $this->this_model->selectYearProduct('9','0',$select_year_product,$type);

   $data['row_ten_month'] = $this->this_model->selectYearProduct('10','0',$select_year_product,$type);

   $data['row_eleven_month'] = $this->this_model->selectYearProduct('11','0',$select_year_product,$type);

   $data['row_twelve_month'] = $this->this_model->selectYearProduct('12','0',$select_year_product,$type);
    ##Cash On Delivery : End##

    ##Online : Start##
   $data['row_first_month1'] = $this->this_model->selectYearProduct('1','1',$select_year_product,$type);
 // exit;
   $data['row_second_month1'] = $this->this_model->selectYearProduct('2','1',$select_year_product,$type);

   $data['row_third_month1'] = $this->this_model->selectYearProduct('3','1',$select_year_product,$type);

   $data['row_fourth_month1'] = $this->this_model->selectYearProduct('4','1',$select_year_product,$type);

   $data['row_fifth_month1'] = $this->this_model->selectYearProduct('5','1',$select_year_product,$type);

   $data['row_six_month1'] = $this->this_model->selectYearProduct('6','1',$select_year_product,$type);

   $data['row_seven_month1'] = $this->this_model->selectYearProduct('7','1',$select_year_product,$type);

   $data['row_eight_month1'] = $this->this_model->selectYearProduct('8','1',$select_year_product,$type);

   $data['row_nine_month1'] = $this->this_model->selectYearProduct('9','1',$select_year_product,$type);

   $data['row_ten_month1'] = $this->this_model->selectYearProduct('10','1',$select_year_product,$type);

   $data['row_eleven_month1'] = $this->this_model->selectYearProduct('11','1',$select_year_product,$type);

   $data['row_twelve_month1'] = $this->this_model->selectYearProduct('12','1',$select_year_product,$type);
    ##Online : End##

}
else if(isset($_POST['btn_date']) && $_POST['btn_date'] == 'Search'){

    date_default_timezone_set('Asia/Kolkata');

    $from_var = $_REQUEST['from_date'];
    $data['from_var'] = $_REQUEST['from_date'];
    $from_date = str_replace('-', '/', $from_var);
    $from_date = strtotime(date('Y-m-d', strtotime($from_date)));

    /*$from_d = $_REQUEST['from_date'];
    $from_con = date("d-m-Y", strtotime($from_d));
    $from_date = strtotime($from_con);*/

    $var = $_REQUEST['end_date'];
     $data['var'] = $_REQUEST['end_date'];
    $date = str_replace('-', '/', $var);
    $end_date = strtotime(date('Y-m-d', strtotime($date)));


    @$type = $_REQUEST['type'];
    $data['type'] = @$type;
    if($type == 9 || !isset($type)){
        $where = "1=1";
        $type = '';
    }elseif ($type == 0){
        $where = "order_from ='0'";
        $type = '0';
    }else{
        $where= "order_from ='1'";
        $type = '1';
    }
    ##Cash On Delivery : Start##
    $data['row_first_month_date'] = $this->this_model->selectMonthDateOrder('1','0',$from_date,$end_date,$type);

    $data['row_second_month_date'] = $this->this_model->selectMonthDateOrder('2','0',$from_date,$end_date,$type);


    $data['row_third_month_date'] = $this->this_model->selectMonthDateOrder('3','0',$from_date,$end_date,$type);

    $data['row_fourth_month_date'] = $this->this_model->selectMonthDateOrder('4','0',$from_date,$end_date,$type);

    $data['row_fifth_month_date'] = $this->this_model->selectMonthDateOrder('5','0',$from_date,$end_date,$type);

    $data['row_six_month_date'] = $this->this_model->selectMonthDateOrder('6','0',$from_date,$end_date,$type);

    $data['row_seven_month_date'] = $this->this_model->selectMonthDateOrder('7','0',$from_date,$end_date,$type);

    $data['row_eight_month_date'] = $this->this_model->selectMonthDateOrder('8','0',$from_date,$end_date,$type);

    $data['row_ten_month_date'] = $this->this_model->selectMonthDateOrder('10','0',$from_date,$end_date,$type);

    $data['row_eleven_month_date'] = $this->this_model->selectMonthDateOrder('11','0',$from_date,$end_date,$type);

    $data['row_twelve_month_date'] = $this->this_model->selectMonthDateOrder('12','0',$from_date,$end_date,$type);
                                                                                                                    
    ##Cash On Delivery : End##

    ##Online : Start##
    $data['row_first_month1_date'] = $this->this_model->selectMonthDateOrder('1','1',$from_date,$end_date,$type);

    $data['row_twelve_month1_date'] = $this->this_model->selectMonthDateOrder('2','1',$from_date,$end_date,$type);

    $data['row_twelve_month1_date'] = $this->this_model->selectMonthDateOrder('3','1',$from_date,$end_date,$type);

    $data['row_twelve_month1_date'] = $this->this_model->selectMonthDateOrder('4','1',$from_date,$end_date,$type);

    $data['row_twelve_month1_date'] = $this->this_model->selectMonthDateOrder('5','1',$from_date,$end_date,$type);

    $data['row_twelve_month1_date'] = $this->this_model->selectMonthDateOrder('6','1',$from_date,$end_date,$type);

    $data['row_twelve_month1_date'] = $this->this_model->selectMonthDateOrder('7','1',$from_date,$end_date,$type);

    $data['row_twelve_month1_date'] = $this->this_model->selectMonthDateOrder('8','1',$from_date,$end_date,$type);

    $data['row_twelve_month1_date'] = $this->this_model->selectMonthDateOrder('9','1',$from_date,$end_date,$type);

    $data['row_twelve_month1_date'] = $this->this_model->selectMonthDateOrder('10','1',$from_date,$end_date,$type);

    $data['row_twelve_month1_date'] = $this->this_model->selectMonthDateOrder('11','1',$from_date,$end_date,$type);

    $data['row_twelve_month1_date'] = $this->this_model->selectMonthDateOrder('12','1',$from_date,$end_date,$type);
    ##Online : End##

}
else{


    ##Cash On Delivery : Start##
    $data['row_first_month'] = $this->this_model->selectOrderStatistics('1','0'); // (month,payment_type)

    $data['row_second_month'] = $this->this_model->selectOrderStatistics('2','0');

    $data['row_third_month'] = $this->this_model->selectOrderStatistics('3','0');

    $data['row_fourth_month'] = $this->this_model->selectOrderStatistics('4','0');

    $data['row_fifth_month'] = $this->this_model->selectOrderStatistics('5','0');

    $data['row_six_month'] = $this->this_model->selectOrderStatistics('6','0');

    $data['row_seven_month'] = $this->this_model->selectOrderStatistics('7','0');

    $data['row_eight_month'] = $this->this_model->selectOrderStatistics('8','0');

    $data['row_nine_month'] = $this->this_model->selectOrderStatistics('9','0');

    $data['row_ten_month'] = $this->this_model->selectOrderStatistics('10','0');

    $data['row_eleven_month'] = $this->this_model->selectOrderStatistics('11','0');

    $data['row_twelve_month'] = $this->this_model->selectOrderStatistics('12','0');
    ##Cash On Delivery : End##

    
    ##Online : Start##
    $data['row_first_month1'] = $this->this_model->selectOrderStatistics('1','1'); // (month1,payment_type)

    $data['row_second_month1'] = $this->this_model->selectOrderStatistics('2','1');

    $data['row_third_month1'] = $this->this_model->selectOrderStatistics('3','1');

    $data['row_fourth_month1'] = $this->this_model->selectOrderStatistics('4','1');

    $data['row_fifth_month1'] = $this->this_model->selectOrderStatistics('5','1');

    $data['row_six_month1'] = $this->this_model->selectOrderStatistics('6','1');

    $data['row_seven_month1'] = $this->this_model->selectOrderStatistics('7','1');

    $data['row_eight_month1'] = $this->this_model->selectOrderStatistics('8','1');

    $data['row_nine_month1'] = $this->this_model->selectOrderStatistics('9','1');

    $data['row_ten_month1'] = $this->this_model->selectOrderStatistics('10','1');

    $data['row_eleven_month1'] = $this->this_model->selectOrderStatistics('11','1');

    $data['row_twelve_month1'] = $this->this_model->selectOrderStatistics('12','1');
    ##Online : End##
    }

    ##Cash On Delivery : Total Earnings##
    $data['row_total_cod'] = $this->this_model->totalCod();

    ##Online : Total Earnings##
    $data['row_total_online'] = $this->this_model->total_online();

    $this->load->view('payment_report',$data);
    }

    public function register_closures()
    {
        $data['result'] = $this->this_model->registerClosures();
        $this->load->view('register_closures_list',$data);
    }

    public function inventory_reports()
    {
        $data['result'] = $this->this_model->inventory_reports();
        $data['table_js'] = array('report.js');
        $data['start'] = array('REPORT.table()');
        $this->load->view('inventory_reports',$data);
    }

    public function getInventoryReport(){
        if($this->input->post()){
            echo getInventoryReport($this->input->post());
        }
    }
    
}
