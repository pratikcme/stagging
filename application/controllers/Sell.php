<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sell extends Vendor_Controller
{
    function __construct(){

        parent::__construct();
        $this->load->model('sell_model', 'this_model');
    }

    public function index(){
    	error_reporting(0);
    	$data['register_result'] = $this->this_model->getRegister();
       	$data['cust_row'] =  $this->this_model->customer();
       	$data['category'] =  $this->this_model->getCategory();
       	$currency = $this->this_model->getCurrency();
       	$data['currency'] = $currency[0]->value; 
   if (isset($_GET['parkedId']) && !empty($_GET['parkedId'])) {
   
       $data['var'] = "park";
       $parked_order_id = base64_decode($_GET['parkedId']);
   		$data['order_temp_result'] = $this->this_model->OrderTemp($parked_order_id);
       $data['parked_order_id'] = base64_decode($_GET['parkedId']);
   	}else{  
   
   	$data['order_temp_result'] = $this->this_model->OrderTempWithoutPark($parked_order_id);
   } 
        $this->load->view('checkout_old',$data);
    }

    public function history()
    {
        error_reporting(0);
        $data['order_row'] = $this->this_model->orderHistory();
        // echo '<pre>';
        // print_r($data['order_row']);
        $this->load->view('sales_history',$data);
    }

    public function print_sell()
    {
        $this->load->view('print');
    }

    public function print_sell_html()
    {
        $this->load->view('print_html');
    }

    public function parked_sell()
    {
        $this->load->view('parked_sell');
    }

    public function parked_sell_list()
    {
        $this->load->view('parked_sell_list');
    }

    public function update_temp_order()
    {
        $return = $this->this_model->update_temp_order($_POST);
    	print_r($return);exit;
    }
    public function update_same_product()
    {
        $return = $this->this_model->update_same_product($_POST);
    }

    public function check_quantity()
    {


        $return = $this->this_model->check_quantity($_POST);
        echo $return;
        exit();
    }

    public function set_qnt()
    {
        $this->this_model->set_qnt($_POST);
    }

    public function check_quantity_val()
    {
        $return = $this->this_model->check_quantity_val($_POST);
        echo json_encode($return);
        exit();
    }

    public function update_parked_order(){
        $this->this_model->update_parked_order($this->input->post());
    }
    public function update_discount_parked_order(){
        $this->this_model->update_discount_parked_order($this->input->post());
    }

    ##  Sell : Update Order Temp ##
    public function update_order_temp(){
        if($this->input->get()){
            $temp_qnt = $this->this_model->update_order_temp($this->input->get());
            echo json_encode($temp_qnt);
        }
    }

    ##  Sell : Temp Products Div Append ##
    public function temp_order()
    {


        $return = $this->this_model->temp_order($this->input->post());
        echo $return;
        exit();
    }

    ## Sell : Delete Temp Order ##
    public function delete_parked_order()
    {
        $this->this_model->delete_parked_order($this->input->post());
        exit;
    }

    public function delete_tmp_order()
    {
        error_reporting(0);
        // print_r($this->input->get());
        // exit;
        $product_temp_id = $_GET['product_id'];
        $product_id = $_GET['true_product_id'];
        $pro_temp_qnt = $_GET['pro_temp_qnt'];

        if ($pro_temp_qnt == '' || $pro_temp_qnt == null) {
            $pro_temp_qnt = '0';
        }

        $query = $this->db->query("SELECT quantity,temp_quantity FROM product_weight WHERE id = '$product_id'");
        $result = $query->row_array();

        $qnt = $result['quantity'];
        $temp_qnt = $result['temp_quantity'];
        $this->db->query("UPDATE product_weight SET quantity = $qnt + $pro_temp_qnt,temp_quantity = $temp_qnt-$pro_temp_qnt WHERE id= '$product_id'");

        $subtotal = $_GET['subtotal'];
        $disc_percentage = $_GET['disc_percentage'];

        $price_query = $this->db->query("SELECT price from order_temp WHERE id = '$product_temp_id'");
        $price_result = $price_query->row_array();
        $price_db = $price_result['price'];

        $this->db->query("DELETE FROM order_temp WHERE id = '$product_temp_id'");

        $new_subtotal = $subtotal - $price_db;
        $new_discount_total = ($new_subtotal * $disc_percentage) / 100;
        $new_total = $new_subtotal - $new_discount_total;

        $array = array(
            'new_subtotal' => $new_subtotal,
            'disc_percentage' => $disc_percentage,
            'new_discount_total' => $new_discount_total,
            'new_total' => $new_total
        );

        echo json_encode($array);
        exit();
    }

    ## Sell : New Order ##
    public function order_checkout()
    {
        // print_r($this->input->post());exit;
        $response = $this->this_model->order_checkout($this->input->post());
        exit;

        //Parked Sale : Just store in database
        if (isset($_REQUEST['parked_sell']) && $_REQUEST['parked_sell'] == 'Park Sale') {

            $vendor_id = $this->session->userdata('id');
            $user_id = $this->input->post('customer');
            $sub_total = $this->input->post('hidden_subtotal');
            $disc_percentage = $this->input->post('disc_percentage');
            $discount_total = $this->input->post('hidden_discount_total');
            $total = $this->input->post('hidden_total');
            $register_id = $this->input->post('register_id');
            /*$parent_id = $this->session->userdata('parent_id');
            if($parent_id == '0')
            {
                $parent_insert_id = '1';
            }
            else
            {
                $parent_insert_id = $this->session->userdata('parent_id');
            }*/

            $park_array = array(
                'vendor_id' => $vendor_id,
                /*'parent_user_id' => $parent_insert_id,*/
                'user_id' => $user_id,
                'register_id' => $register_id,
                'subtotal' => $sub_total,
                'discount_per' => $disc_percentage,
                'total_discount' => $discount_total,
                'total' => $total,
                'payment_type' => '2',
                'order_no' => 'OD' . strtotime(date('Y-m-d H:i:s')),
                'status' => '1',
                'dt_added' => strtotime(date('Y-m-d H:i:s')),
                'dt_updated' => strtotime(date('Y-m-d H:i:s'))
            );
            $this->db->insert('pos_order', $park_array);
            $last_inserted_order_id = $this->db->insert_id();

            //Order Details
            foreach ($_REQUEST as $key => $value) {
                if (count(explode('qnt', $key)) > 1) {
                    $example = explode('qnt', $key);

                    $product_temp_id = $example['1'];

                    if ($product_temp_id != '') {

                        $pro_temp_row = $this->db->query("SELECT Product_id, quantity, price, discount, discount_price FROM order_temp WHERE id = '$product_temp_id'");
                        $pro_temp_result = $pro_temp_row->row_array();

                        $this->db->query("UPDATE order_temp SET park = '1' WHERE id = '$product_temp_id'");

                        $p_id = $pro_temp_result['Product_id'];
                        $quantity_temp = $pro_temp_result['quantity'];

                        $query = $this->db->query("SELECT quantity, temp_quantity FROM product WHERE id = '$p_id'");
                        $result = $query->row_array();
                        $temp_qnt = $result['quantity'];

                        if ($quantity_temp == '') {
                            $quantity_temp = '0';
                        }

                        $this->db->query("UPDATE product SET quantity = $temp_qnt - $quantity_temp, temp_quantity = $temp_qnt - $quantity_temp WHERE id= '$p_id'");

                        $order_temp_array = array(
                            'order_id' => $last_inserted_order_id,
                            'user_id' => $user_id,
                            'pid' => $pro_temp_result['Product_id'],
                            'customer_id' => $customer_id,
                            'product_id' => $product_temp_id,
                            'quantity' => $pro_temp_result['quantity'],
                            'price' => $pro_temp_result['price'],
                            'discount' => $pro_temp_result['discount'],
                            'discount_price' => $pro_temp_result['discount_price'],
                            'status' => '1',
                            'dt_added' => strtotime(date('Y-m-d H:i:s')),
                            'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                        );
                        $this->db->insert('order_detail', $order_temp_array);
                    }
                }
            }

            $this->session->set_flashdata("msg", "Park created successfully.");
            redirect(base_url() . 'index.php/sell/index');

        } else {

            $user_id = $this->session->userdata('id');
            $customer_id = $this->input->post('customer');
            $sub_total = $this->input->post('hidden_subtotal');
            $disc_percentage = $this->input->post('disc_percentage');
            $discount_total = $this->input->post('hidden_discount_total');
            $total = $this->input->post('hidden_total');
            $register_id = $this->input->post('register_id');
            /*$parent_id = $this->session->userdata('parent_id');
            if($parent_id == '0')
            {
                $parent_insert_id = '1';
            }
            else
            {
                $parent_insert_id = $this->session->userdata('parent_id');
            }*/

            if (isset($_REQUEST['cash']) && $_REQUEST['cash'] == 'Cash') {

                $reg_query = $this->db->query("SELECT cash_amount_expected, counted, difference FROM register WHERE id = $register_id");
                $reg_result = $reg_query->row_array();

                $cash_amount_expected = $reg_result['cash_amount_expected'] + $total;
                $counted = $reg_result['counted'];
                $difference = $counted - $cash_amount_expected;

                $this->db->query("UPDATE register SET cash_amount_expected = '$cash_amount_expected', counted = '$counted' WHERE id = $register_id");

                $cash_array = array(
                    'user_id' => $user_id,
                    /*'parent_user_id' => $parent_insert_id,*/
                    'customer_id' => $customer_id,
                    'register_id' => $register_id,
                    'subtotal' => $sub_total,
                    'discount_per' => $disc_percentage,
                    'total_discount' => $discount_total,
                    'total' => $total,
                    'payment_type' => '0',
                    'order_no' => 'OD' . strtotime(date('Y-m-d H:i:s')),
                    'status' => '1',
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s'))
                    //'park' => '1'
                );
                $this->db->insert('order', $cash_array);
                $last_inserted_order_id = $this->db->insert_id();

                //Order Details
                foreach ($_REQUEST as $key => $value) {

                    if ((count(explode('qnt', $key)) > 1) && (count(explode('discount', $key)) > 0)) {

                        //Temp Qnt
                        $example = explode('qnt', $key);
                        $product_temp_id = $example['1'];

                        //Temp Disc
                        $example = explode('discount', $key);

                        if ($product_temp_id != '') {

                            $pro_temp_row = $this->db->query("SELECT Product_id, quantity, price, discount, discount_price FROM order_temp WHERE id = '$product_temp_id'");
                            $pro_temp_result = $pro_temp_row->row_array();

                            //$this->db->query("UPDATE order_temp SET park = '2' WHERE id = '$product_temp_id'");

                            $p_id = $pro_temp_result['Product_id'];
                            $quantity_temp = $pro_temp_result['quantity'];

                            $query = $this->db->query("SELECT quantity, temp_quantity FROM product WHERE id = '$p_id'");
                            $result = $query->row_array();
                            $temp_qnt = $result['quantity'];

                            $temp_qnt_new = $temp_qnt - $quantity_temp;

                            if ($temp_qnt_new == '') {
                                $temp_qnt_new = '0';
                            }

                            $this->db->query("UPDATE product SET quantity = $temp_qnt_new, temp_quantity = $temp_qnt_new WHERE id= '$p_id'");

                            $order_temp_array = array(
                                'order_id' => $last_inserted_order_id,
                                'user_id' => $user_id,
                                'pid' => $pro_temp_result['Product_id'],
                                'customer_id' => $customer_id,
                                'product_id' => $product_temp_id,
                                'quantity' => $pro_temp_result['quantity'],
                                'price' => $pro_temp_result['price'],
                                'discount' => $pro_temp_result['discount'],
                                'discount_price' => $pro_temp_result['discount_price'],
                                'status' => '1',
                                'dt_added' => strtotime(date('Y-m-d H:i:s')),
                                'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                            );
                            $this->db->insert('order_detail', $order_temp_array);
                            $this->db->query("DELETE FROM order_temp WHERE id = '$product_temp_id'");
                        }
                    }
                }

                if ($last_inserted_order_id) {
                    redirect(base_url() . 'index.php/sell/print_sell?ZqRl=' . base64_encode($last_inserted_order_id));
                }
            }

            if (isset($_REQUEST['credit_card']) && $_REQUEST['credit_card'] == 'Credit Card') {

                $reg_query = $this->db->query("SELECT credit_card_expected, credit_card_counted, credit_card_differences FROM register WHERE id = $register_id");
                $reg_result = $reg_query->row_array();

                $cash_amount_expected = $reg_result['credit_card_expected'] + $total;
                $counted = $reg_result['credit_card_counted'];
                $difference = $counted - $cash_amount_expected;

                $this->db->query("UPDATE register SET credit_card_expected = '$cash_amount_expected', credit_card_counted = '$counted' WHERE id = $register_id");

                $cash_array = array(
                    'user_id' => $user_id,
                    /*'parent_user_id' => $parent_insert_id,*/
                    'customer_id' => $customer_id,
                    'register_id' => $register_id,
                    'subtotal' => $sub_total,
                    'discount_per' => $disc_percentage,
                    'total_discount' => $discount_total,
                    'total' => $total,
                    'payment_type' => '1',
                    'order_no' => 'OD' . strtotime(date('Y-m-d H:i:s')),
                    'status' => '1',
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s'))
                    //'park' => '1'
                );
                $this->db->insert('order', $cash_array);
                $last_inserted_order_id = $this->db->insert_id();

                //Order Details
                foreach ($_REQUEST as $key => $value) {

                    if ((count(explode('qnt', $key)) > 1) && (count(explode('discount', $key)) > 0)) {

                        //Temp Qnt
                        $example = explode('qnt', $key);
                        $product_temp_id = $example['1'];

//                        //Temp Disc
//                        $example = explode('discount', $key);

                        if ($product_temp_id != '') {

                            $pro_temp_row = $this->db->query("SELECT Product_id, quantity, price, discount, discount_price FROM order_temp WHERE id = '$product_temp_id'");
                            $pro_temp_result = $pro_temp_row->row_array();

                            //$this->db->query("UPDATE order_temp SET park = '2' WHERE id = '$product_temp_id'");

                            $p_id = $pro_temp_result['Product_id'];
                            $quantity_temp = $pro_temp_result['quantity'];

                            $query = $this->db->query("SELECT quantity, temp_quantity FROM product WHERE id = '$p_id'");
                            $result = $query->row_array();
                            $temp_qnt = $result['quantity'];

                            $temp_qnt_new = $temp_qnt - $quantity_temp;

                            if ($temp_qnt_new == '') {
                                $temp_qnt_new = '0';
                            }

                            $this->db->query("UPDATE product SET quantity = $temp_qnt_new, temp_quantity = $temp_qnt_new WHERE id= '$p_id'");

                            $order_temp_array = array(
                                'order_id' => $last_inserted_order_id,
                                'user_id' => $user_id,
                                'pid' => $pro_temp_result['Product_id'],
                                'customer_id' => $customer_id,
                                'product_id' => $product_temp_id,
                                'quantity' => $pro_temp_result['quantity'],
                                'price' => $pro_temp_result['price'],
                                'discount' => $pro_temp_result['discount'],
                                'discount_price' => $pro_temp_result['discount_price'],
                                'status' => '1',
                                'dt_added' => strtotime(date('Y-m-d H:i:s')),
                                'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                            );
                            $this->db->insert('order_detail', $order_temp_array);
                            $this->db->query("DELETE FROM order_temp WHERE id = '$product_temp_id'");
                        }
                    }
                }

                if ($last_inserted_order_id) {
                    redirect(base_url() . 'index.php/sell/print_sell?ZqRl=' . base64_encode($last_inserted_order_id));
                }
            }
        }
    }

    public function single_delete_sales_history()
    {

        $ids = $_REQUEST['ids'];
        $this->this_model->single_delete_sales_history($ids);
        exit;

    }
    public function single_delete_sell_sales_history()
    {

        $ids = $_REQUEST['ids'];
        $this->this_model->single_delete_sell_sales_history($ids);
        exit;

    }

    ##Search Product##
    public function ajax_search_product()
    {
        $vendor_id = $this->session->userdata('id');
        $search = $_GET['search'];
        $query_product = $this->db->query("SELECT p.* FROM product as p 
                                                    INNER JOIN category as c on p.category_id = c.id
                                                    INNER JOIN subcategory as s on p.subcategory_id = s.id
                                                    WHERE p.status != '9' AND (p.name LIKE '%$search%'
                                                    OR c.name LIKE '%$search%'
                                                    OR s.name LIKE '%$search%')  
                                                    AND p.vendor_id = '$vendor_id'  ORDER BY id DESC ");
        $result = $query_product->result();

        $i = '1';

        if (count($result) > 0) {

            echo '<div class="sel_subcatagory_itm" style="display: block;">';
            foreach ($result as $product) {
                echo '<div class="col-md-3 col-lg-3 col-sm-6 col-xs-6 no_padd" onclick="return select_product_variant(' . $product->id . ',0)">';
                echo '<div class="subcatg_list text-center" onclick="return select_product_variant(' . $product->id . ',0)">';
                echo '<a href="javascript:;"><span> ' . $product->name . ' </span></a>';
                echo '</div>';
                echo '</div>';
                $i++;
            }
            echo '</div>';

        } else {
            echo '<p align="center"><b>There is no product</b></p>';
        }
        exit();
    }

    public function ajax_search_product_old()
    {

        $user_id = $this->session->userdata('id');
        $parent_user_id = $this->session->userdata('parent_id');
        $search = $_REQUEST['search'];

        //Outlet wise User Products
        $outlet_sub_query = $this->db->query("SELECT outlet_id FROM sub_user_outlet WHERE sub_user_id = '$user_id'");
        $outlet_sub_result = $outlet_sub_query->result();

        $array = array();
        foreach ($outlet_sub_result as $imp_res) {
            $array[] = $imp_res->outlet_id;
        }
        $implode = implode(',', $array);

        if ($outlet_sub_query->num_rows > 0) {

            //For All Outlet
            if ($outlet_sub_result[0]->outlet_id == '0') {

                $res = $this->db->query("SELECT p.*, pt.name as tag_name FROM product as p LEFT JOIN product_tag as pt ON pt.product_id = p.id WHERE (pt.name LIKE '%$search%' OR p.name LIKE '%$search%') AND p.status != '9' AND (p.parent_user_id='$parent_user_id' OR p.parent_user_id ='$user_id' OR p.user_id = '$user_id' OR p.user_id = '$parent_user_id') AND p.name != '' GROUP BY p.name");
                $row_search = $res->result();

                $res_type = $this->db->query("SELECT p.*, pt.name as tag_name FROM product as p LEFT JOIN product_tag as pt ON pt.product_id = p.id WHERE (pt.name LIKE '%$search%' OR p.name LIKE '%$search%') AND p.status != '9' AND (p.parent_user_id='$parent_user_id' OR p.parent_user_id ='$user_id' OR p.user_id = '$user_id' OR p.user_id = '$parent_user_id') AND pt.name != '' GROUP BY p.name");
                $row_search_type = $res_type->result();
            } else {

                //For Selected Outlet
                $res = $this->db->query("SELECT p.*, pt.name as tag_name, op.outlet_id FROM product as p 
                                            INNER JOIN outlet_product as op ON op.product_id = p.id
                                            LEFT JOIN product_tag as pt ON pt.product_id = p.id 
                                            WHERE op.retail_price_tax != '0' AND op.outlet_id IN ($implode) AND (pt.name LIKE '%$search%' OR p.name LIKE '%$search%') AND p.status != '9' AND (p.parent_user_id='$parent_user_id' OR p.parent_user_id ='$user_id' OR p.user_id = '$user_id' OR p.user_id = '$parent_user_id') AND p.name != '' GROUP BY p.name");
                $row_search = $res->result();


                $res_type = $this->db->query("SELECT p.*, pt.name as tag_name FROM product as p
                                                INNER JOIN outlet_product as op ON op.product_id = p.id
                                                LEFT JOIN product_tag as pt ON pt.product_id = p.id AND op.outlet_id IN ($implode) 
                                                WHERE op.retail_price_tax != '0' AND op.outlet_id IN ($implode) AND (pt.name LIKE '%$search%' OR p.name LIKE '%$search%') AND p.status != '9' AND (p.parent_user_id='$parent_user_id' OR p.parent_user_id ='$user_id' OR p.user_id = '$user_id' OR p.user_id = '$parent_user_id') AND pt.name != '' GROUP BY p.name, pt.id");
                $row_search_type = $res_type->result();
            }

        } else {

            //For All Outlet
            $res = $this->db->query("select p.*, pt.name as tag_name from product as p LEFT JOIN product_tag as pt ON pt.product_id = p.id WHERE (pt.name LIKE '%$search%' OR p.name LIKE '%$search%') AND p.status != '9' AND (p.parent_user_id='$parent_user_id' OR p.parent_user_id ='$user_id' OR p.user_id = '$user_id' OR p.user_id = '$parent_user_id') AND p.name != '' GROUP BY p.name");
            $row_search = $res->result();

            $res_type = $this->db->query("select p.*, pt.name as tag_name from product as p LEFT JOIN product_tag as pt ON pt.product_id = p.id WHERE (pt.name LIKE '%$search%' OR p.name LIKE '%$search%') AND p.status != '9' AND (p.parent_user_id='$parent_user_id' OR p.parent_user_id ='$user_id' OR p.user_id = '$user_id' OR p.user_id = '$parent_user_id') AND pt.name != ''");
            $row_search_type = $res_type->result();
        }

        $output = '';
        $i = '1';
        $count = 1;

        echo '<div class="sell_tab">';
        echo '<h4>Product Name</h4>';
        echo '<ul>';
        if (count($row_search) > 0) {
            foreach ($row_search as $product) {
                echo '<li>';
                echo '<a name="product_type" id="select_product" onclick="return select_product(' . $product->id . ');">';
                echo '<span>' . $product->name . '</span></a><br>';
                echo '</li>';

                $i++;
            }
        } else {
            echo '<li style="background: #dff0d8;"><span class="no_found">';
            echo 'No matching record found';
            echo '</span></li>';
            $i++;
        }
        echo '</ul>';
        echo '</div>';

        echo '<div class="sell_tab">';
        echo '<h4>Product Tag</h4>';
        echo '<ul>';
        if (count($row_search_type) > 0) {
            foreach ($row_search_type as $tag) {
                echo '<li>';
                echo '<a name="product_type" id="select_product" onclick="return select_product(' . $tag->id . ');">';
                echo '<span>' . $tag->tag_name . '</span></a><br>';
                echo '</li>';

                $i++;
            }
        } else {
            echo '<li style="background: #dff0d8;"><span class="no_found">';
            echo 'No matching record found';
            echo '</span></li>';
            $i++;
        }
        echo '</ul>';
        echo '</div>';

        exit();
    }

    ##Update Product Temp Qnt##
    public function update_same_as_qnt()
    {
        $user_id = $this->session->userdata('id');

        $this->db->query('UPDATE product_weight SET `quantity` = quantity+temp_quantity,temp_quantity = "0"');
        // $this->db->query('UPDATE product SET `temp_quantity` = `quantity`');
        $this->db->query("DELETE FROM order_temp WHERE vendor_id = '$user_id' AND park = '0' ");

        return;
        exit();
    }

    ##Update Product Temp Qnt##
    public function test()
    {
        /*$user_id = $_REQUEST['user_id'];
        $this->db->query("DELETE FROM `order_temp` WHERE `user_id` = '$user_id'");
        $this->db->query('UPDATE product SET `temp_quantity` = `quantity`');
        return;
        exit();*/
        echo '1';

        exit();

    }

    ##Send Mail In Print##
    public function send_email()
    {
        $order_id = $_POST['order_id'];
        $vendor_id = $this->session->userdata('id');

        $order_query = $this->db->query("SELECT od.calculation_price AS price, od.actual_discount AS discount, od.quantity, od.dt_updated, p.name, pw.discount_price AS final_price FROM pos_order_detail as od
            LEFT JOIN product as p ON p.id = od.product_id
            LEFT JOIN product_weight as pw ON pw.id = od.product_variant_id
             WHERE od.pos_order_id = '$order_id' AND p.vendor_id = '$vendor_id' AND od.status != '9'");
        $order_row = $order_query->result();

        $order_query_ = $this->db->query("SELECT total_price AS subtotal, total_discount,calculation_price AS total FROM `pos_order` WHERE id = '$order_id' AND vendor_id = '$vendor_id' AND status != '9'");
        $order_row_ = $order_query_->row_array();

        $this->load->library('email');

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'test.cmexpertise@gmail.com',
            'smtp_pass' => 'cm@@123#',
            'mailtype' => 'text',
            'charset' => 'utf-8'
        );

        $html = '<html>
                    <head></head>
                    <body  style="width: 50%; border: 1px solid black; ">
                        <div>
                        
                            <br>
                            <div style="text-align: center"><b>Point of Sale</b></div><br>
                            <div style="text-align: center"><b>CMExpertise</b></div><br>
                            <div style="text-align: center"><b>Receipt / Tax Invoice</b></div><br>
                            <div style="text-align: center"><b>Invoice:</b></div>
                            <div style="text-align: center"><b> ' . date("jS \of F Y h:i:s A") . ' </b></div>
                            <div style="text-align: center"><b> Served by: CM Expertise on Main Register </b></div><br>';


        $html .= '
                    <table border="1" style="width: 100%; border: 1px solid" cellpadding="5" >
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Product Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>';

        foreach ($order_row as $order) {

            $html .= ' 
                                    <tr>
                                        <td style="text-align: center"> ' . $order->name . ' </td>
                                        <td style="text-align: center"> ' . $order->quantity . ' </td>
                                        <td style="text-align: center"> $' . $order->final_price . '.00 </td>
                                        <td style="text-align: center"> $' . $order->price . ' </td>
                                    </tr>
                                ';
        }

        $html .= '</tbody>';
        $html .= '</table>';

        $html .= '

                  <br><br>
                  <div>
                  
                      <hr>  
                      <label style="float: left;"> <b>Subtotal</b> </label> <label style="float: right;"> $' . $order_row_["subtotal"] . ' </label><br><br><hr>
                      <label style="float: left;"> <b>Discount(%)</b> </label> <label style="float: right;"> $' . $order_row_["discount_per"] . ' </label><br><br><hr>
                      <label style="float: left;"> <b>Discount Price</b> </label> <label style="float: right;"> $' . $order_row_["total_discount"] . ' </label><br><br><hr>
                      <label style="float: left;"> <b>Total</b> </label> <label style="float: right;"> $' . $order_row_["total"] . ' </label><br><hr>
                      
                      <br><br>
                      <div><span style="text-align: center"><b>Customer Copy</b></span></div>
                  </div>
        ';


        $html .= '        </div>
                    </body>
                </html>';


        $sub_total = $_REQUEST['sub_total'];
        $disc_percentage = $_REQUEST['discount_per'];
        $discount_total = $_REQUEST['discount_price'];
        $total = $_REQUEST['total'];
        $to_email = $this->input->post('rec_email');

        //Fetch Email and Name from User Id
        $query_user = $this->db->query("SELECT email, name FROM vendor WHERE id = '$vendor_id'");
        $query_result = $query_user->row_array();

        $from_email = $query_result['email'];
        $subject = 'Order';

        $receipt = "
					Sub-Total = $sub_total 
					Discount(%) = $disc_percentage
					Discount Price = $discount_total
					Total = $total
							
					";

        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");

        $this->email->from($from_email);
        $this->email->to($to_email);
        $this->email->subject($subject);
        $this->email->message($html);

        if ($this->email->send()) {

            $this->session->set_flashdata("msg", "Mail sent successfully.");
        } else {

            $this->session->set_flashdata("msg", "Error in sent mail.");
        }

        redirect(base_url() . 'sell/print_sell?ZqRl=' . base64_encode($order_id));
    }

    public function select_category()
    {
        $this->this_model->select_category();
    }


    public function select_subcategory()
    {

        $type_id = $_GET['type_id'];

        $vendor_id = $this->session->userdata('id');


        $query_subcategory = $this->db->query("SELECT * FROM subcategory WHERE status != '9'  AND vendor_id = '$vendor_id' AND category_id ='$type_id' ORDER BY id DESC ");

        $result = $query_subcategory->result();

        $i = '1';

        if (count($result) > 0) {

            $html = '';
            $html .= '<div class="sel_subcatagory_itm" style="display: block;">';
            foreach ($result as $subcategory) { ?>

                <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6 no_padd" onclick="return select_product_data('<?php echo $subcategory->id; ?>','<?php echo $subcategory->name; ?>' )">
                <div class="subcatg_list text-center">
                <?php
//                        echo '<input type="hidden" id="cat_'.$subcategory->id.'" name="cat_id" value="'.$subcategory->id.'" >';

                echo '<a href="javascript:;"><span> ' . $subcategory->name . ' </span></a>';
                echo '</div>';
                echo '</div>';
                $i++;
            }
            echo '</div>';

        } else {
            echo '<p align="center"><b>There is no subcategory</b></p>';
        }
        exit();
    }

public function select_product_data()
{

    $type_id = $_GET['type_id'];

    $vendor_id = $this->session->userdata('id');

    $query_product = $this->db->query("SELECT * FROM product WHERE status != '9'  AND vendor_id = '$vendor_id' AND subcategory_id ='$type_id' ORDER BY id DESC ");
    $result = $query_product->result();

    $i = '1';

if (count($result) > 0)
{

    echo '<div class="sel_subcatagory_itm" style="display: block;">';
foreach ($result as $product)
{ ?>
    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6 no_padd"
         onclick="return select_product_variant('<?php echo $product->id; ?>','<?php echo $product->name; ?>')">
    <div class="subcatg_list text-center">
    <?php
    echo '<a href="javascript:;"><span> ' . $product->name . ' </span></a>';
    echo '</div>';
    echo '</div>';
    $i++;
}
    echo '</div>';

}
else {
    echo '<p align="center"><b>There is no product</b></p>';
}
    exit();
}

    public function select_product_variant()
    {


        $type_id = $_GET['type_id'];

        $vendor_id = $this->session->userdata('id');

        $query_variant = $this->db->query("SELECT pw.id, pw.weight_id,pw.weight_no,w.name FROM product_weight as pw LEFT JOIN weight as w ON pw.weight_id = w.id  WHERE w.status != '9' AND  pw.status != '9'  AND pw.vendor_id = '$vendor_id' AND product_id ='$type_id' ORDER BY pw.id DESC ");
        $result = $query_variant->result();

        $i = '1';

        if (count($result) > 0) {

            echo '<div class="sell_four_box" style="display: block;">';
            foreach ($result as $product) {
                ?>
            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6 no_padd"
                 onclick="return select_product('<?php echo $product->id; ?>','<?php echo $product->name; ?>')">
                <?php
                echo '<div class="four_type text-center">';
                echo '<a href="javascript:;"><span> ', $product->weight_no . $product->name . ' </span></a>';
                echo '</div>';
                echo '</div>';
                $i++;
            }
            echo '</div>';

        } else {
            echo '<p align="center"><b>There is no variant</b></p>';
        }
        exit();
    }

    public function discard_parked_order()
    {
        $this->this_model->discard_parked_order($this->input->post());

    }

}