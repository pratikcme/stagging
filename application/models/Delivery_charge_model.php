<?php

class Delivery_charge_model extends My_model
{
     function __construct(){
        $this->load->model('common_model');
        $re = $this->common_model->getExistingBranchId();
        $this->branch_id = $re[0]->id;
        $this->vendor_id = $this->session->userdata('vendor_admin_id');
    }

    public function getDeliveryCharegeData(){
        $data['table'] = 'delivery_charge';
        $data['select'] = ['*'];
        $data['where'] = ['vendor_id'=>$this->vendor_id];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
    }


    public function delivery_charge_Add(){

        $date = DATE_TIME;
            // print_r($_POST);exit;
        $id = $_POST['id'];
        if (isset($_POST['submit'])) {
            /* Delivery charge Update */
            if ($id != '') {
            // echo 1;exit;

                $start = $_POST['start_range'];
                $end = $_POST['end_range'];
                $price = $_POST['price'];
                $data = array(
                    'vendor_id'=>$this->vendor_id,
                    'start_range' => $start,
                    'end_range' => $end,
                    'price' => $price,

                    'dt_updated' => $date,
                );
                $this->db->where('id', $id);
                $this->db->update('delivery_charge', $data);
                $this->session->set_flashdata('msg', 'Delivery charge has been updated successfully');
                redirect(base_url() . 'delivery_charge/delivery_charge');
                exit();
            } else {
                // echo 2;
                $a = $this->input->post('price');
                $b = $this->input->post('start_range');
                $c = $this->input->post('end_range');
                $i = 0;
                // exit;   
                // foreach ($a as $val) {
                    // echo $val;
                    $end = $c;
                    $start = $b;
                    if ($end != '') {
                        $insertion = array(
                            'vendor_id'=>$this->vendor_id,
                            'start_range' => $start,
                            'end_range' => $end,
                            'price' => $a,
                            'dt_updated' => $date,
                            'dt_added' => $date
                        );
                        $data['insert'] = $insertion;
                        $data['table'] = 'delivery_charge';
                        $response = $this->insertRecord($data);
                        $this->session->set_flashdata('msg', 'Delivery charge has been added successfully');
                    }
                    $i++;
                // }
                // exit;
                return $response;
            }
        }
    }


    public function delete($id)
    {
        $data["where"]["id"] = $id;
        $data["table"] = 'delivery_charge';
        $res = $this->deleteRecords($data);
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status' => 1]);
        exit;
    }

    public function get_valid_start_range()
    {
//        echo "harsh";exit;
        $start_range = $this->input->post('start_range');
        $id = $this->input->post('id');
        if($id != ''){
            $data['where']['id != '] = $id;
        }
        $data['select'] = ['*'];
        $data['where']['vendor_id'] = $this->vendor_id;
        $data['table'] = "delivery_charge";
        $result = $this->selectRecords($data);

        foreach ($result as $row) {

            $s_range = $row->start_range;
            $e_range = $row->end_range;

            if ($s_range <= $start_range && $start_range <= $e_range) {

                return "false";

            }

        }
        return "true";

    }

    public function get_valid_end_range()
    {
        $end_range = $this->input->post('end_range');
        $id = $this->input->post('id');
        if($id != ''){
            $data['where']['id != '] = $id;
        }
        $data['select'] = ['*'];
        $data['where']['vendor_id'] = $this->vendor_id;
        $data['table'] = "delivery_charge";
        $result = $this->selectRecords($data);

        foreach ($result as $row) {

            $s_range = $row->start_range;
            $e_range = $row->end_range;

            if ($s_range <= $end_range && $end_range <= $e_range) {

                return "false";

            }

        }
        return "true";
    }

}
