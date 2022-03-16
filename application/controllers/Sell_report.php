<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sell_report extends Vendor_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Report_model','this_model');
	}
	public function index()
	{
		
	// 	if (isset($_POST['select_year_product'])) {

	// 	    $select_year_product = $_POST['select_year_product'];
	// 	    $data['select_year_product'] = $select_year_product; 
		    
	// 	    @$type = $_POST['type'];
	// 	    $data['type'] = $type;
		    
	// 	    if ($type == 9 || !isset($type)) {
	// 	        $where = "1=1";
	// 	        $type = '';
	// 	    } elseif ($type == 0) {
	// 	        $where = "o.order_from ='0'";
	// 	        $type = '0';
	// 	    } else {
	// 	        $where = "o.order_from ='1'";
	// 	    	$type = '1';
	// 	    }

	// 	   $data['row_yearwise'] = $this->this_model->res_yearwise($select_year_product,$type);
	// 	   // print_r($data['row_yearwise']);die;
	// 	   $data['row_remaining_quantity'] = $this->this_model->res_remaining_quantity($select_year_product);
	   
	// 	}else{
	//      $year = date('Y');
	//     $data['row_yearwise'] = $this->this_model->Else_res_yearwise($year);
	    

	//     $data['row_remaining_quantity'] = $this->this_model->Else_res_remaining_quantity($year);
	// 	}	
	//     print_r($data['row_remaining_quantity']);
	// // print_r($data['row_yearwise']);
	// $data['year'] = date('Y');
	$this->load->view('sell_report');
	
	}

	public function select_data_yearwise()
	{
		$res_yearwise = $this->db->query("select * from product");
		$row_yearwise = $res_yearwise->result();
		print_r($row_yearwise);
		exit();
	}
	public function select_yearwise_earning()
	{
		$vendor_id = $this->session->userdata('id');
		$selected_year = $_GET['select_year'];
		$type = $_GET['type'];
        if($type == 9 || !isset($type)){
            $where = "1=1";
        }elseif ($type == 0){
            $where = "order_from ='0'";
        }else{
            $where= "order_from ='1'";
        }

		$res_total_earning = $this->db->query("SELECT sum(payable_amount) as total_earning FROM `order` where vendor_id='$vendor_id' and $where and status != '9' and YEAR(FROM_UNIXTIME(dt_added)) = '$selected_year'");
//		 echo $this->db->last_query();exit;
		$row_total_earning = $res_total_earning->result();
		if($row_total_earning['0']->total_earning != '')
		{
			echo $row_total_earning['0']->total_earning;
		}
		else
		{
			echo '0';
		}
		
	}
	public function select_two_date_earning()
	{

		if(($_GET['from_date']  != '') && $_GET['to_date']  != ''){

			$from_date = $_GET['from_date'];
			$parts_from = explode('-', $from_date);
			$from_con = $parts_from[1] . '-' . $parts_from[0] . '-' . $parts_from[2];
			$from_date1 = strtotime($from_con);
            $user = $_GET['user'];
			$to_date = $_GET['to_date'];
			$parts_to = explode('-', $to_date);
			$to_con = $parts_to[1] . '-' . $parts_to[0] . '-' . $parts_to[2];
			$to_date1 = strtotime($to_con);

            $type = $_GET['type'];
            if($type == 9 || !isset($type)){
                $where = "1=1";
            }elseif ($type == 0){
                $where = "order_from ='0'";
            }else{
                $where= "order_from ='1'";
            }

			$res_two_earning = $this->db->query("select sum(payable_amount) as total_earning from `order` where  vendor_id='$user' and $where and status != '9' and (dt_added BETWEEN '$from_date1' AND '$to_date1')");

			$row_two_earning = $res_two_earning->result();

            if($row_two_earning['0']->total_earning != '')
			{
				echo $row_two_earning['0']->total_earning;
				exit();
			}
			else
			{
				echo '0';
				exit();
			}
		}else{
			echo '0';
			exit();
		}
	}
	public function select_date_earning()
	{

		if($_GET['date']  != '') {
			$to_date = $_GET['date'];

			$user = $_GET['user'];
			$parts_to = explode('-', $to_date);
			$date1 = $parts_to[1] . '-' . $parts_to[0] . '-' . $parts_to[2];

            $type = $_GET['type'];
            if($type == 9 || !isset($type)){
                $where = "1=1";
            }elseif ($type == 0){
                $where = "order_from ='0'";
            }else{
                $where= "order_from ='1'";
            }

			$res_two_earning = $this->db->query("select DATE_FORMAT(FROM_UNIXTIME(`dt_added`), '%d-%m-%Y') AS 'date_formatted',sum(payable_amount) as total_earning from `order` where vendor_id='$user' and status != '9' and $where and DATE_FORMAT(FROM_UNIXTIME(`dt_added`), '%d-%m-%Y') ='$date1'");
			$row_two_earning = $res_two_earning->result();
//			echo $this->db->last_query();
			if($row_two_earning['0']->total_earning != '')
			{
				echo $row_two_earning['0']->total_earning;
			}
			else
			{
				echo '0';
			}
		}else{
			echo '0';
		}
	}
	// public function select_year
}