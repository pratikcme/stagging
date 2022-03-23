<?php
class subscription_model extends My_model{

    function __construct(){
      $this->load->model('common_model');
      $re = $this->common_model->getExistingBranchId();
      $this->branch_id = $re[0]->id;
    }

    public function getcurrency(){
        $data['table'] = 'set_default';
        $data['select'] = ['*'];
        $data['where'] = ['request_id' =>'3','branch_id'=>$this->branch_id];
        $return =  $this->selectRecords($data,true);
        return $return;
    }

    public function subscription_result(){
        $data['table'] = 'subscription';
        $data['select'] = ['*'];
        $data['where'] = ['branch_id'=>$this->branch_id];
        $data['order'] = 'id DESC';
        $return =  $this->selectRecords($data);
        return $return;
    }



    public function Subscription_add_update()
    {

        date_default_timezone_set('Asia/Kolkata');

//        print_r($_POST);
        $id = $_POST['id'];
        $vendor_id = $_POST['vendor'];
        $s_date = $_POST['date'];
        $month = $_POST['month'];
        $e_date = date('Y-m-d', strtotime("+".$month." months", strtotime($s_date)));
        $total = $_POST['total'];


        if (isset($_POST['submit'])) {

            /* subCategory Update */


                $data = array(
                    'branch_id' => $vendor_id,
                    'start_date' => $s_date,
                    'end_date' => $e_date,
                    'month' => $month,
                    'total_ammount' => $total,
                    'dt_updated' => DATE_TIME,
                    'dt_created' => DATE_TIME,
                );
                $this->db->insert('subscription', $data);
                $this->session->set_flashdata('msg', 'Subscription has been added successfully');
                redirect(base_url() . 'subscription/subscription_list');exit();

        }
    }

    public function checkvendor(){
//        date_default_timezone_set('Asia/Kolkata');
        $vendor_id = $this->input->post('vendor');
        $date = $this->input->post('date');
        $data['select'] = ['*'];
        $data['table'] = 'subscription';
        $data['where'] = ['branch_id ' => $vendor_id];
        $response = $this->selectRecords($data);

        if(count($response)==0){
            echo 1;exit;
        }
        else{
            $e_date = $response[0]->end_date;
            if($date<=$e_date){
                echo 0;exit;
            }
            else{
                echo 1;exit;
            }

        }


    }
    public function get_date(){
//        date_default_timezone_set('Asia/Kolkata');
        $vendor_id = $this->input->post('id');
        $data['select'] = ['active_date'];
        $data['table'] = TABLE_BRANCH;
        $data['where'] = ['id' => $vendor_id];
        $response = $this->selectRecords($data);

        $active_date = $response[0]->active_date;
        $active_date = date('Y-m-d',strtotime($active_date));

        echo $active_date;exit;



    }

    # subCategory Single Delete ##


//    public function check_subcategory(){
//        $id = $_GET['id'];
//        $this->db->select('*');
//        $this->db->where('subcategory_id', $id);
//        $this->db->where('status !=','9');
//        $this->db->from('product');
//        $query = $this->db->get();
//        // echo $this->db->last_query();exit;
//        if ( $query->num_rows() > 0 )
//        {
//            $row = $query->row_array();
//            ob_get_clean();
//            header('Access-Control-Allow-Origin: *');
//            header('Content-Type: application/json');
//            echo json_encode(['status'=>2]);
//            exit;
//        }
//        echo json_encode(['status'=>1]);
//        exit;
//    }
//
//    public function single_delete_subCategory()
//    {
//
//        $id = $_GET['id'];
//        $data = array( 'status' => '9','dt_updated' => strtotime(date('Y-m-d H:i:s')));
//        $this->db->where('id', $id);
//        $this->db->update('subcategory', $data);
//
//        ob_get_clean();
//        header('Access-Control-Allow-Origin: *');
//        header('Content-Type: application/json');
//        echo json_encode(['status'=>1]);
//
//        exit;
//
//    }
//
//    ## subCategory Multi Delete ##
//    public function multi_delete_subCategory()
//    {
//        $id = $_GET['ids'];
//        $id = explode(",", $id);
//        foreach ($id as $key => $value) {
//            $this->db->select('*');
//            $this->db->where('subcategory_id', $value);
//            $this->db->where('status !=','9');
//            $this->db->from('product');
//            $query = $this->db->get();
//            // echo $this->db->last_query();
//            $this->db->select('name');
//            $this->db->where('id =',$value);
//            $this->db->from('subcategory');
//            $rows= $this->db->get();
//            $row1 = $rows->row_array();
//
//
//            if ( $query->num_rows() > 0 )
//            {
//                $row = $query->row_array();
//                ob_get_clean();
//                header('Access-Control-Allow-Origin: *');
//                header('Content-Type: application/json');
//
//
//                $response = array('status'=>2,'names'=>$row1['name']);
//                echo json_encode($response);
//                // echo json_encode(['status'=>2]);
//                exit;
//            }
//        }
//        echo json_encode(['status'=>1]);
//        exit;
//        // ob_get_clean();
//        // header('Access-Control-Allow-Origin: *');
//        // header('Content-Type: application/json');
//        // echo json_encode(['status'=>1]);
//        // exit;
//
//        // $date = strtotime(date('Y-m-d H:i:s'));
//
//        // $this->db->query("UPDATE subcategory SET status = '9', dt_updated = '$date' WHERE id IN ($id)");
//
//        // ob_get_clean();
//        // header('Access-Control-Allow-Origin: *');
//        // header('Content-Type: application/json');
//        // echo json_encode(['status'=>1]);
//        // exit;
//    }
//
//
//    public function multi_deleted_subCategory()
//    {
//        $id = $_GET['ids'];
//        $id = explode(",", $id);
//        $date = strtotime(date('Y-m-d H:i:s'));
//        foreach ($id as $key => $value) {
//
//
//            $this->db->query("UPDATE subcategory SET status = '9', dt_updated = '$date' WHERE id IN ($value)");
//
//        }
//
//        echo json_encode(['status'=>1]);
//        exit;
//    }


}
?>