<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Parked_sell extends CI_Controller
{
    function __construct(){
        // ini_set("display_errors", "1");
        // error_reporting(E_ALL);

        parent::__construct();
        $this->load->model('sell_model','this_model');
    }

    public function index()
    {
        $this->load->view('parked_checkout');
    }

    public function sales_history_view()
    {
        $this->load->view('sales_history_view');
    }

    public function history()
    {
        $this->load->view('sales_history');
    }

    ##  Sell : Update Order Temp ##
    public function update_order_temp()
    {
        
        $product_id = $_REQUEST['product_id']; //order_temp_id
        $quantity = $_REQUEST['quantity'];

        ##Temp Qnt##
        $price = $_REQUEST['price'];
        $current_date = strtotime(date('Y-m-d H:i:s'));

        ##Order##
        $subtotal = $_REQUEST['sub_total'];
        $total = $_REQUEST['total'];
        $order_id = $_REQUEST['order_id'];

        $temp_query = $this->db->query("SELECT Product_id FROM order_temp WHERE id = '$product_id'");
        $result_temp = $temp_query->row_array();
        $true_product_id = $result_temp['Product_id'];// product_id

        $temp_pro_query = $this->db->query("SELECT quantity, temp_quantity FROM product WHERE id = '$true_product_id'");
        $result_pro_temp = $temp_pro_query->row_array();
        $temp_qnt = $result_pro_temp['quantity'];
        //$temp_qnt = $result_pro_temp['temp_quantity'];

        if($temp_qnt >= $quantity){

            echo '1';

            $qty = $_REQUEST['qty'];
            $new_qnt = $temp_qnt - $quantity;

            $discount = $_REQUEST['discount'];
            $discount_price = $_REQUEST['discount_price'];

            $this->db->query("UPDATE order_temp SET quantity = '$qty', price = '$price', discount = '$discount', discount_price = '$discount_price', dt_updated = '$current_date' WHERE id = '$product_id'");
            $this->db->query("UPDATE product SET temp_quantity = '$new_qnt' WHERE id = '$true_product_id'");
            $this->db->query("UPDATE `order` SET subtotal = '$subtotal', total = '$total', dt_updated = '$current_date' WHERE id = '$order_id'");
            //$this->db->query("UPDATE order_detail SET quantity = '$quantity', price = '$price', discount = '$discount', discount_price = '$discount_price', dt_updated = '$current_date' WHERE product_id = '$product_id'");
        }
        else{
            echo 0;
        }

        return;
        exit();
    }

    ##  Sell : Temp Products Div Append ##
    public function temp_order()
    {
        $return = $this->this_model->temp_order($this->input->post());
        echo $return;
        exit();
    }

    ## Sell : Delete Temp Order ##
       public function delete_tmp_order()
    {
        $tmp_price = $_GET['tmp_price'];
        $pos_order_detail_id = $_GET['order_temp_id'];
        $subtotal = $_GET['subtotal'];
        $disc_percentage = $_GET['disc_percentage'];
        $variant_id = $_GET['true_product_id'];
//        $variant_id = $_GET['variant_id'];
        $current_date = strtotime(date('Y-m-d H:i:s'));
        echo $variant_id;
        exit;
        // $query = $this->db->query("SELECT quantity, temp_quantity FROM product_weight WHERE id = '$product_id'");
        // $result = $query->row_array();
        // $temp_qnt = $result['temp_quantity'];
        // $temp_qnt1 = $result['quantity'];
        // $this->db->query("UPDATE product_weight SET temp_quantity = $temp_qnt + $pro_temp_qnt, quantity = $temp_qnt1 + $pro_temp_qnt WHERE id= '$product_id'");

        $select_order_query = $this->db->query("SELECT po.id,po.total_discount FROM pos_order_detail as pod LEFT JOIN pos_order as po ON pod.pos_order_id = po.id  WHERE pod.id = '$pos_order_detail_id'");
        $result = $select_order_query->row_array();
//
//        echo $result['id'].'   '.$result['total_discount'];
//        exit;

        $pos_order_id =  $result['id'] ;

        $discount =  $result['total_discount'];

          $calculation_price =  $tmp_price+($tmp_price * $discount/100);

        $delete_pos_order_details_query = $this->db->query("DELETE * FROM pos_order_detail WHERE id = '$pos_order_detail_id'");
        $result = $delete_pos_order_details_query->row_array();


        $update_pos_order_query =  $this->db->query("UPDATE pos_order SET total_price = total_price - $tmp_price,calculation_price = calculation_price - $calculation_price   WHERE id = '$pos_order_id'");
        $result = $update_pos_order_query->row_array();



        $query = $this->db->query("SELECT quantity  FROM product_weight WHERE id = '$product_id'");
        $result = $query->row_array();

           $query = $this->db->query("UPPDATE product_weight SET quantity = quantity + 1  WHERE id = '$variant_id'");
           $result = $query->row_array();




        $qnt = $result['quantity'];
        $temp_qnt = $result['temp_quantity'];
        $this->db->query("UPDATE product_weight SET quantity = $qnt + $pro_temp_qnt,temp_quantity = $temp_qnt-$pro_temp_qnt WHERE id= '$product_id'");


        
        $price_query = $this->db->query("SELECT pos_order_id, calculation_price from pos_order_detail WHERE product_id = '$product_temp_id'");
        $price_result = $price_query->row_array();
        $price_db = $price_result['price'];
        $order_id = $price_result['pos_order_id'];

        $this->db->query("DELETE FROM order_temp WHERE id = '$product_temp_id'");
        $this->db->query("DELETE FROM pos_order_detail WHERE id = '$product_temp_id'");

        $new_subtotal = $subtotal - $tmp_price;
        $new_discount_total = ($new_subtotal * $disc_percentage) / 100;
        $new_total = $new_subtotal -  $new_discount_total;

        $array = array(
            'new_subtotal' => $new_subtotal,
            'disc_percentage' => $disc_percentage,
            'new_discount_total' => $new_discount_total,
            'new_total' => $new_total
        );

       $this->db->query("UPDATE `pos_order` SET total_price = '$new_subtotal', total_discount = '$disc_percentage', calculation_price = '$new_total', dt_updated = '$current_date' WHERE id = '$order_id'");
       echo $this->db->last_query();
       exit;
        echo json_encode($array);

        return;
        exit();
    }

    ## Sell : New Order ##
    public function order_checkout()
    {


        $response = $this->this_model->pos_order_checkout();
        exit;

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

        //Fetch Email and Name from User Id
        $query_user = $this->db->query("SELECT email, name FROM user WHERE user_id = '$user_id'");
        $query_result = $query_user->row_array();

        //Credit Card - Online Payment
        if ($this->input->post('credit_card') == 'Credit Card') {

            $reg_query = $this->db->query("SELECT credit_card_expected, credit_card_counted, credit_card_differences FROM register WHERE id = $register_id");
            $reg_result = $reg_query->row_array();

            $cash_amount_expected = $reg_result['credit_card_expected'] + $total;
            $counted = $reg_result['credit_card_counted'];
            $difference = $counted - $cash_amount_expected;

            $this->db->query("UPDATE register SET credit_card_expected = '$cash_amount_expected', credit_card_counted = '$counted' WHERE id = $register_id");

            $old_order_id = $_REQUEST['old_order_id'];

            //Delete From Order Delete
            $this->db->where('order_id', $old_order_id);
            $this->db->delete('order_detail');

            //Delete From Order
            $this->db->where('id', $old_order_id);
            $this->db->delete('order');

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
                'order_no' => 'OD'.strtotime(date('Y-m-d H:i:s')),
                'status' => '1',
                'dt_added' => strtotime(date('Y-m-d')),
                'dt_updated' => strtotime(date('Y-m-d'))
                //'park' => '1'
            );
            $this->db->insert('order', $cash_array);
            $last_inserted_order_id = $this->db->insert_id();

            //Order Details
            foreach($_REQUEST as $key=>$value){
                if((count(explode('qnt',$key)) > 1) && (count(explode('discount',$key)) > 0)){

                    //Temp Qnt
                    $example = explode('qnt',$key);
                    $product_temp_id = $example['1'];

                    if($product_temp_id != ''){

                        //Temp Disc
                        $example = explode('discount',$key);

                        $pro_temp_row = $this->db->query("SELECT Product_id, quantity, price, discount, discount_price FROM order_temp WHERE id = '$product_temp_id'");
                        $pro_temp_result = $pro_temp_row->row_array();

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

            if($last_inserted_order_id){
                redirect(base_url() . 'index.php/sell/print_sell?ZqRl='.base64_encode($last_inserted_order_id));
            }
        }
        //Cash on Delivery
        if ($this->input->post('cash') == 'Cash') {

            $reg_query = $this->db->query("SELECT cash_amount_expected, counted, difference FROM register WHERE id = $register_id");
            $reg_result = $reg_query->row_array();

            $cash_amount_expected = $reg_result['cash_amount_expected'] + $total;
            $counted = $reg_result['counted'];
            $difference = $counted - $cash_amount_expected;

            $this->db->query("UPDATE register SET cash_amount_expected = '$cash_amount_expected', counted = '$counted' WHERE id = $register_id");


            $old_order_id = $_REQUEST['old_order_id'];

            //Delete From Order Delete
            $this->db->where('order_id', $old_order_id);
            $this->db->delete('order_detail');

            //Delete From Order
            $this->db->where('id', $old_order_id);
            $this->db->delete('order');

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
                'order_no' => 'OD'.strtotime(date('Y-m-d H:i:s')),
                'status' => '1',
                'dt_added' => strtotime(date('Y-m-d')),
                'dt_updated' => strtotime(date('Y-m-d'))
                //'park' => '1'
            );
            $this->db->insert('order', $cash_array);
            $last_inserted_order_id = $this->db->insert_id();

            //Order Details
            foreach($_REQUEST as $key=>$value){
                if((count(explode('qnt',$key)) > 1) && (count(explode('discount',$key)) > 0)){

                    //Temp Qnt
                    $example = explode('qnt',$key);
                    $product_temp_id = $example['1'];

                    if($product_temp_id != ''){

                        //Temp Disc
                        $example = explode('discount',$key);

                        $pro_temp_row = $this->db->query("SELECT Product_id, quantity, price, discount, discount_price FROM order_temp WHERE id = '$product_temp_id'");
                        $pro_temp_result = $pro_temp_row->row_array();

                        $product_id=  $pro_temp_result["Product_id"];
                        $this->db->query("UPDATE product SET quantity = temp_quantity WHERE id = '$product_id'");

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

            if($last_inserted_order_id){
                redirect(base_url() . 'index.php/sell/print_sell?ZqRl='.base64_encode($last_inserted_order_id));
            }
        }
    }

    ## Single Delete Sales History ##
    public function single_delete_sales_history()
    {
        $ids = $_REQUEST['ids'];
        $data = array('status' => '9');

        $this->db->where('id', $ids);
        $this->db->update('order', $data);

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status' => 1]);
        exit;
    }
    
    ## Search Product ##
    public function ajax_search_product()
    {
        $user_id = $this->session->userdata('id');
        $parent_user_id = $this->session->userdata('parent_id');
        $search = $_REQUEST['search'];

        //Outlet wise User Products
        $outlet_sub_query = $this->db->query("SELECT outlet_id FROM sub_user_outlet WHERE sub_user_id = '$user_id'");
        $outlet_sub_result = $outlet_sub_query->result();

        $array = array();
        foreach ($outlet_sub_result as $imp_res){
            $array[] = $imp_res->outlet_id;
        }
        $implode = implode(',',$array);

        if($outlet_sub_query -> num_rows > 0){

            //For All Outlet
            if($outlet_sub_result[0]->outlet_id == '0'){

                $res = $this->db->query("select p.*, pt.name as tag_name from product as p LEFT JOIN product_tag as pt ON pt.product_id = p.id WHERE (pt.name LIKE '%$search%' OR p.name LIKE '%$search%') AND p.status != '9' AND (p.parent_user_id='$parent_user_id' OR p.parent_user_id ='$user_id' OR p.user_id = '$user_id' OR p.user_id = '$parent_user_id') AND p.name != '' GROUP BY p.name");
                $row_search = $res->result();

                $res_type = $this->db->query("select p.*, pt.name as tag_name from product as p LEFT JOIN product_tag as pt ON pt.product_id = p.id WHERE (pt.name LIKE '%$search%' OR p.name LIKE '%$search%') AND p.status != '9' AND (p.parent_user_id='$parent_user_id' OR p.parent_user_id ='$user_id' OR p.user_id = '$user_id' OR p.user_id = '$parent_user_id') AND pt.name != ''");
                $row_search_type = $res_type->result();
            }else{

                //For Selected Outlet
                $res = $this->db->query("select p.*, pt.name as tag_name from product as p 
                                            LEFT JOIN product_tag as pt ON pt.product_id = p.id
                                            INNER JOIN outlet_product as op ON op.product_id = p.id 
                                            WHERE op.retail_price_tax != '0' AND op.outlet_id IN ($implode) AND (pt.name LIKE '%$search%' OR p.name LIKE '%$search%') AND p.status != '9' AND (p.parent_user_id='$parent_user_id' OR p.parent_user_id ='$user_id' OR p.user_id = '$user_id' OR p.user_id = '$parent_user_id') AND p.name != '' GROUP BY p.name");
                $row_search = $res->result();

                $res_type = $this->db->query("select p.*, pt.name as tag_name from product as p 
                                                LEFT JOIN product_tag as pt ON pt.product_id = p.id
                                                INNER JOIN outlet_product as op ON op.product_id = p.id
                                                WHERE op.retail_price_tax != '0' AND op.outlet_id IN ($implode) AND (pt.name LIKE '%$search%' OR p.name LIKE '%$search%') AND p.status != '9' AND (p.parent_user_id='$parent_user_id' OR p.parent_user_id ='$user_id' OR p.user_id = '$user_id' OR p.user_id = '$parent_user_id') AND pt.name != '' GROUP BY p.name");
                $row_search_type = $res_type->result();
            }

        }else{

            //For All Outlet
            $res = $this->db->query("select p.*, pt.name as tag_name from product as p LEFT JOIN product_tag as pt ON pt.product_id = p.id WHERE (pt.name LIKE '%$search%' OR p.name LIKE '%$search%') AND p.status != '9' AND (p.parent_user_id='$parent_user_id' OR p.parent_user_id ='$user_id' OR p.user_id = '$user_id' OR p.user_id = '$parent_user_id') AND p.name != '' GROUP BY p.name");
            $row_search = $res->result();

            $res_type = $this->db->query("select p.*, pt.name as tag_name from product as p LEFT JOIN product_tag as pt ON pt.product_id = p.id WHERE (pt.name LIKE '%$search%' OR p.name LIKE '%$search%') AND p.status != '9' AND (p.parent_user_id='$parent_user_id' OR p.parent_user_id ='$user_id' OR p.user_id = '$user_id' OR p.user_id = '$parent_user_id') AND pt.name != ''");
            $row_search_type = $res_type->result();
        }

        $output  = '';
        $i = '1';
        $count = 1;

        echo '<div class="sell_tab">';
        echo '<h4>Product Name</h4>';
        echo '<ul>';
        if(count($row_search) > 0) {
            foreach ($row_search as $product) {
                echo '<li>';
                echo '<a name="product_type" id="select_product" onclick="return select_product(' . $product->id . ');">';
                echo '<span>' . $product->name . '</span></a><br>';
                echo '</li>';

                $i++;
            }
        }
        else{
            echo '<li style="background: #dff0d8;"><span class="no_found">'; echo 'No matching record found';  echo '</span></li>';
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
        }
        else{
            echo '<li style="background: #dff0d8;"><span class="no_found">'; echo 'No matching record found';  echo '</span></li>';
            $i++;
        }
        echo '</ul>';
        echo '</div>';

        exit();
    }

    ##Update Product Temp Qnt##
    public function update_same_as_qnt()
    {
        $this->db->query('UPDATE product_weight SET `quantity` = quantity+temp_quantity');
        return;
        exit();
    }

    public function add_product_update()
    {
        $old_order_id = $_REQUEST['old_order_id'];
        $subtotal = $_REQUEST['subtotal'];
        $disc_percentage_new = $_REQUEST['disc_percentage_new'];
        $per_result = $_REQUEST['per_result'];
        $result = $_REQUEST['result'];

        $this->db->query("UPDATE `order` SET subtotal =  '$subtotal', discount_per = '$disc_percentage_new', total_discount = '$per_result', total = '$result' WHERE id = '$old_order_id' ");
        return;
        exit();
    }

    public  function select_subcategory(){

        $type_id = $_GET['type_id'];

        $vendor_id = $this->session->userdata('id');


        $query_subcategory = $this->db->query("SELECT * FROM subcategory WHERE status != '9'  AND vendor_id = '$vendor_id' AND category_id ='$type_id' ORDER BY id DESC ");

        $result = $query_subcategory->result();

        $i = '1';

        if (count($result) > 0) {

            echo '<div class="sel_subcatagory_itm" style="display: block;">';
            foreach ($result as $subcategory) {
                echo '<div class="col-md-3 col-lg-3 col-sm-6 col-xs-6 no_padd" onclick="return select_product_data('.$subcategory->id.')">';
                echo '<div class="subcatg_list text-center" onclick="return select_product_data('.$subcategory->id.')">';
//                        echo '<input type="hidden" id="cat_'.$subcategory->id.'" name="cat_id" value="'.$subcategory->id.'" >';
                echo '<a href="javascript:;"><span> '.$subcategory->name.' </span></a>';
                echo '</div>';
                echo '</div>';
                $i++;
            }
            echo '</div>';

        }
        else{
            echo '<p align="center"><b>There is no subcategory</b></p>';
        }
        exit();
    }

    public  function select_product_data(){

        $type_id = $_GET['type_id'];

        $vendor_id = $this->session->userdata('id');

        $query_product = $this->db->query("SELECT * FROM product WHERE status != '9'  AND vendor_id = '$vendor_id' AND subcategory_id ='$type_id' ORDER BY id DESC ");
        $result = $query_product->result();

        $i = '1';

        if (count($result) > 0) {

            echo '<div class="sel_subcatagory_itm" style="display: block;">';
            foreach ($result as $product) {
                echo '<div class="col-md-3 col-lg-3 col-sm-6 col-xs-6 no_padd" onclick="return select_product_variant('.$product->id.')">';
                echo '<div class="subcatg_list text-center" onclick="return select_product_variant('.$product->id.')">';
                echo '<a href="javascript:;"><span> '.$product->name.' </span></a>';
                echo '</div>';
                echo '</div>';
                $i++;
            }
            echo '</div>';

        }
        else{
            echo '<p align="center"><b>There is no product</b></p>';
        }
        exit();
    }

    public  function select_product_variant(){

        $type_id = $_GET['type_id'];

        $vendor_id = $this->session->userdata('id');

        $query_variant= $this->db->query("SELECT pw.id, pw.weight_id,pw.weight_no,w.name FROM product_weight as pw LEFT JOIN weight as w ON pw.weight_id = w.id  WHERE w.status != '9' AND  pw.status != '9'  AND pw.vendor_id = '$vendor_id' AND product_id ='$type_id' ORDER BY pw.id DESC ");
        $result = $query_variant->result();

        $i = '1';

        if (count($result) > 0) {

            echo '<div class="sell_four_box" style="display: block;">';
            foreach ($result as $product) {
                echo '<div class="col-md-3 col-lg-3 col-sm-6 col-xs-6 no_padd" onclick="return select_product('.$product->id.')">';
                echo '<div class="four_type text-center">';
                echo '<a href="javascript:;"><span> ',$product->weight_no.$product->name.' </span></a>';
                echo '</div>';
                echo '</div>';
                $i++;
            }
            echo '</div>';

        }
        else{
            echo '<p align="center"><b>There is no variant</b></p>';
        }
        exit();
    }


}