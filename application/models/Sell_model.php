<?php

class Sell_model extends My_model
{

    function update_temp_order($postdata)
    {
        $customer_id = $postdata['customer_id'];
        $vendor_id = $this->session->userdata('id');
        $qnt = $postdata['qnt'];
        $price = $postdata['dt_price'];
        $variant_id = $postdata['variant_id'];

        $data['update']['quantity'] = $qnt;
        $data['update']['price'] = $price;
        $data['where'] = ['customer_id' => $customer_id, 'vendor_id' => $vendor_id, 'product_weight_id' => $variant_id];
        $data['table'] = 'order_temp';
        $this->updateRecords($data);

        $this->db->query("UPDATE product_weight SET quantity = quantity - 1,temp_quantity = temp_quantity + 1  WHERE id= '$variant_id'");
        exit;
    }

    function update_same_product($postdata)
    {
        $customer_id = $postdata['customer_id'];
        $vendor_id = $this->session->userdata('id');
        $qnt = $postdata['qnt'];
        $price = $postdata['dt_price'];
        $variant_id = $postdata['variant_id'];
        $order_id = $postdata['order_id'];


        $data['select'] = ['discount_per', 'price'];
        $data['where'] = ['id' => $variant_id];
        $data['table'] = 'product_weight';
        $res = $this->selectRecords($data);

        $disc = $res[0]->discount_per;
        $base_price = $res[0]->price;

        unset($data);

        $disc_price = ($base_price * $qnt) - $price;


        $data['update']['quantity'] = $qnt;
        $data['update']['price'] = $price;
        $data['update']['discount'] = $disc;
        $data['update']['discount_price'] = $disc_price;
        $data['where'] = ['parked_order_id' => $order_id, 'product_weight_id' => $variant_id];
        $data['table'] = 'parked_order_details';
        $this->updateRecords($data);

        unset($data);
        $data['update']['order_discount'] = 0;
        $data['where'] = ['id' => $order_id];
        $data['table'] = 'parked_order';
        $this->updateRecords($data);


        //        $this->db->query("UPDATE parked_order_details SET discount_price =  discount_price + discount_price WHERE parked_order_id= '$order_id'");

        $this->refresh_parked_order($order_id);

        $this->db->query("UPDATE product_weight SET quantity = quantity - 1,park_quantity = park_quantity + 1  WHERE id= '$variant_id'");

        unset($data);


        echo $disc;


        exit;
    }

    function check_quantity($postdata)
    {

        $product_variant_id = $postdata['product_w_id'];
        $vendor_id = $this->session->userdata('id');
        $customer_id = $postdata['customer_id'];
        $data['select'] = ['quantity'];
        $data['where'] = ['id' => $product_variant_id];
        $data['table'] = 'product_weight';
        $result = $this->selectRecords($data, true);
        $quantity = $result[0]['quantity'];
        if ($result[0]['quantity'] > 0) {
            $response = 1;
        } else {
            $response = 0;
        }
        return $response;
    }

    function check_quantity_val($postdata)
    {


        $product_variant_id = $postdata['variant_id'];
        $quantity = $postdata['quantity'];
        $park = $postdata['park'];
        $order_temp_id = $postdata['order_temp_id'];


//        echo $order_temp_id;exit;

        if ($park == "park") {

            $data['select'] = ['quantity'];
            $data['where'] = ['id' => $order_temp_id];
            $data['table'] = 'parked_order_details';
            $result = $this->selectRecords($data);
            $qnt = $result[0]->quantity;

            $this->db->query("UPDATE product_weight SET quantity = quantity + $qnt ,park_quantity=  park_quantity - $qnt WHERE id= '$product_variant_id'");


        } else {
            $this->db->query("UPDATE product_weight SET quantity = quantity + temp_quantity,temp_quantity = 0  WHERE id= '$product_variant_id'");
        }

        unset($data);
        $order_temp_id = $postdata['order_temp_id'];
        $data['select'] = ['quantity'];
        $data['where'] = ['id' => $product_variant_id];
        $data['table'] = 'product_weight';
        $result = $this->selectRecords($data, true);

        if ($result[0]['quantity'] >= $quantity) {

            if ($park == "park") {

                $this->db->query("UPDATE product_weight SET quantity = quantity - $quantity,park_quantity = park_quantity + $quantity  WHERE id= '$product_variant_id'");

            } else {
                $this->db->query("UPDATE product_weight SET quantity = quantity - $quantity,temp_quantity = temp_quantity + $quantity  WHERE id= '$product_variant_id'");

            }
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $response['quantity'] = $result[0]['quantity'];

        }
        return $response;
    }


    function temp_order($postdata)
    {
        // echo 1;exit;
        // print_r($postdata);exit;

        $product_variant_id = $postdata['product_w_id'];
        $vendor_id = $this->session->userdata('id');
        $customer_id = $postdata['customer_id'];


        unset($data);
        $data['select'] = ['quantity'];
        $data['where'] = ['id' => $product_variant_id, 'vendor_id' => $vendor_id];
        $data['table'] = 'product_weight';
        $result = $this->selectRecords($data, true);
        $quantity = $result[0]['quantity'] - 1;


        // print_r($result);exit;
        if ($result[0]['quantity'] > 0) {

            $data['select'] = ['temp_quantity'];
            $data['where'] = ['id' => $product_variant_id];
            $data['table'] = 'product_weight';
            $get = $this->selectRecords($data, true);
            $temp_quantity = $get[0]['temp_quantity'] + 1;

            unset($data);
            $data['update'] = ['quantity' => $quantity, 'temp_quantity' => $temp_quantity];
            $data['table'] = 'product_weight';
            $data['where'] = ['id' => $product_variant_id];
            $this->updateRecords($data);


            unset($data);
            $data['select'] = ['pw.*'];
            $data['where'] = ['pw.id' => $product_variant_id];
            $data['table'] = 'product_weight AS pw';
            $getdata = $this->selectRecords($data, true);

            $product_price = $getdata[0]['discount_price'];

            $discount = $getdata[0]['discount_per'];
            $product_id = $getdata[0]['product_id'];
            $actual_price = $getdata[0]['price'];

            $product_array = array(
                'vendor_id' => $vendor_id,
                'customer_id' => $customer_id,
                'product_weight_id' => $product_variant_id,
                'quantity' => '1',
                'discount' => $discount,
                'discount_price' => '0',
                'price' => $product_price,
                'park' => '0',
                'status' => '1',
                'dt_added' => strtotime(date('Y-m-d H:i:s')),
                'dt_updated' => strtotime(date('Y-m-d H:i:s'))
            );
            $data['insert'] = $product_array;
            $data['table'] = 'order_temp';
            $last_id = $this->insertRecord($data);

            unset($data);
            $data['select'] = ['name'];
            $data['where'] = ['id' => $product_id];
            $data['table'] = 'product';
            $product_name = $this->selectRecords($data);


            unset($data);
            $data['select'] = ['name'];
            $data['where'] = ['id' => $product_id];
            $data['table'] = 'product';
            $product_name = $this->selectRecords($data);
            $product_name = $product_name[0]->name;

            unset($data);
            $data['select'] = ['*'];
            $data['where'] = ['request_id' => '3'];
            $data['table'] = 'set_default';
            $currency = $this->selectRecords($data);
            $currency = $currency[0]->value;

            $html = '<ul id="temp_product_list" class="temp_product_list' . $last_id . '">
					<li>
						<h5 class="event_name"> ' . $product_name . ' </h5>
						<p class="event_quantity">
							<input type="number" min="1" max="1" style="margin-left: -9%;"   data-price="' . $product_price . '" data-val="' . $product_variant_id . '" class="showid_qnt" name="qnt' . $last_id . '" id="qnt' . $last_id . '" value="1" onkeyup="showId(' . $last_id . ', ' . $product_price . ',' . $last_id . ' ,' . $product_variant_id . ', ' . $discount . ')"</p>
						<input type="hidden" class="var_id' . $product_variant_id . '" name="weight_id" value="' . $product_variant_id . '">
						<p class="event_quantity">
     						<input type="number" min="0" class="disc" max="' . $discount . '" name="discount' . $last_id . '" id="discount' . $last_id . '" placeholder = "Discount (%)" value="' . $discount . '" onkeyup="discount_temp_order(' . $last_id . ', ' . $product_price . ', ' . $last_id . ', ' . $product_price . ', ' . $discount . ',' . $actual_price . ')" style="width: 100%;"/>In(%)
						 <label style="color: red;" id="error' . $last_id . '"></label>
						</p>
                        <a href="javascript:;" onclick="delete_tmp_order(' . $last_id . ',' . $product_variant_id . ')" class="event_del"><i class="fa fa-trash-o "></i></a>
                                                                                                       

						<div class="ruppers_txt"><span>' . $currency . '</span><div class="event_rupee tmp_price' . $last_id . '">' . $product_price . '</div></div>
					</li>
				</ul>';

            return $html;
        } else {
            $response = 0;
            return $response;
        }

    }


    function order_checkout($postdata)
    {
        $park = $postdata['parked_order'];


        $vendor_id = $postdata['vendor_id'];
        $sub_total = $postdata['hidden_subtotal'];
        $disc_percentage = $postdata['disc_percentage'];
        $discount_total = $postdata['hidden_discount_total'];
        $total = $postdata['hidden_total'];
        $register_id = $postdata['register_id'];
        $hidden_total_pay = $postdata['hidden_total_pay'];
        if (isset($postdata['customer'])) {
            $customer_id = $postdata['customer'];
        }
        $order_from = '0';
        if (isset($postdata['parked_sell']) && $postdata['parked_sell'] == 'Park Sale') {


            $insertion = array(
                'order_no' => 'OD' . strtotime(date('Y-m-d H:i:s')),
                'vendor_id' => $vendor_id,
                'customer_id' => $customer_id,
                'register_id' => $register_id,
                'payable_amount' => $hidden_total_pay,
                'total_saving' => $discount_total,
                'total' => $sub_total,
                'order_discount' => $disc_percentage,
                'status' => '1',
                'dt_added' => strtotime(date('Y-m-d H:i:s')),
                'dt_updated' => strtotime(date('Y-m-d H:i:s'))
            );
            $data['insert'] = $insertion;
            $data['table'] = 'parked_order';
            $last_id = $this->insertRecord($data);

            foreach ($postdata as $key => $value) {

                unset($data);
                if (count(explode('qnt', $key)) > 1) {
                    $example = explode('qnt', $key);

                    $product_temp_id = $example['1'];

                    if ($product_temp_id != '') {


//                        $pro_temp_row = $this->db->query("SELECT product_weight_id, quantity, price, discount, discount_price FROM order_temp WHERE id = '$product_temp_id'");
//                        $pro_temp_result = $pro_temp_row->row_array();


                        $data['select'] = ['product_weight_id', 'quantity', 'price', 'discount', 'discount_price'];
                        $data['where'] = ['id' => $product_temp_id];
                        $data['table'] = 'order_temp';
                        $pro_temp_result = $this->selectRecords($data);
                        // print_r($pro_temp_result);exit;

                        $p_id = $pro_temp_result[0]->product_weight_id;
                        $quantity_temp = $pro_temp_result[0]->quantity;

                        unset($data);

                        if ($quantity_temp == '') {
                            $quantity_temp = '0';
                        }

                        $this->db->query("UPDATE product_weight SET  temp_quantity = temp_quantity - $quantity_temp ,  park_quantity = park_quantity + $quantity_temp WHERE id= '$p_id'");


                        $product_detail = $this->get_product_from_variant($p_id);


//                        $this->db->query("UPDATE product_weight SET  temp_quantity = 0 WHERE id= '$p_id'");

                        $discount_price = ($product_detail->price * $quantity_temp) - $pro_temp_result[0]->price;

                        $insertion = array(
                            'vendor_id' => $vendor_id,
                            'parked_order_id' => $last_id,
                            'product_id' => $product_detail->product_id,
                            'product_weight_id' => $p_id,
                            'weight_id' => $product_detail->package_id,
                            'quantity' => $pro_temp_result[0]->quantity,
                            'actual_price' => $product_detail->price,
                            'actual_discount' => $product_detail->discount_per,
                            'discount' => $pro_temp_result[0]->discount,
                            'discount_price' => $discount_price,
                            'price' => $pro_temp_result[0]->price,
                            'status' => '1',
                            'dt_added' => strtotime(date('Y-m-d H:i:s')),
                            'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                        );
                        $data['insert'] = $insertion;
                        $data['table'] = 'parked_order_details';
                        $result = $this->insertRecord($data);

                    }
                    $data['where'] = ['id' => $product_temp_id];
                    $data['table'] = 'order_temp';
                    $this->deleteRecords($data);
                }
            }


            $this->session->set_flashdata("msg", "Order parked successfully.");
            redirect(base_url() . '	sell/index');
            exit;

        }
        if (isset($postdata['cash']) && $postdata['cash'] == 'Cash') {
            $payment_type = '0';
        }

        if (isset($postdata['credit_card']) && $postdata['credit_card'] == 'Credit Card') {
            $payment_type = '1';
        }
        $insertion = array(
            'order_from' => $order_from,
            'order_no' => 'OD' . strtotime(date('Y-m-d H:i:s')),
            'vendor_id' => $vendor_id,
            'customer_id' => $customer_id,
            'register_id' => $register_id,
            'payable_amount' => $hidden_total_pay,
            'total_saving' => $discount_total,
            'total' => $sub_total,
            'sub_total' => $sub_total,
            'order_discount' => $disc_percentage,
            'payment_type' => $payment_type,
            'status' => '1',
            'order_status' => '4',
            'dt_added' => strtotime(date('Y-m-d H:i:s')),
            'dt_updated' => strtotime(date('Y-m-d H:i:s'))
        );
        $data['insert'] = $insertion;
        $data['table'] = 'order';
        $last_id = $this->insertRecord($data);
        $total_item = 0;
        foreach ($postdata as $key => $value) {

            unset($data);
            if (count(explode('qnt', $key)) > 1) {
                $example = explode('qnt', $key);

                $product_temp_id = $example['1'];
                if ($product_temp_id != '') {


//                        $pro_temp_row = $this->db->query("SELECT product_weight_id, quantity, price, discount, discount_price FROM order_temp WHERE id = '$product_temp_id'");
//                        $pro_temp_result = $pro_temp_row->row_array();
                    if ($park == "park") {

                        $data['select'] = ['parked_order_id', 'product_weight_id', 'quantity', 'price', 'discount', 'discount_price'];
                        $data['where'] = ['id' => $product_temp_id];
                        $data['table'] = 'parked_order_details';
                        $pro_temp_result = $this->selectRecords($data);

                        $parked_order_id = $pro_temp_result[0]->parked_order_id;

                    } else {


                        $data['select'] = ['product_weight_id', 'quantity', 'price', 'discount', 'discount_price'];
                        $data['where'] = ['id' => $product_temp_id];
                        $data['table'] = 'order_temp';
                        $pro_temp_result = $this->selectRecords($data);

                        $parked_order_id = 0;
                    }
                    // print_r($pro_temp_result);exit;

                    $p_id = $pro_temp_result[0]->product_weight_id;
                    $quantity_temp = $pro_temp_result[0]->quantity;
                    $total_item = $total_item + $quantity_temp;
                    unset($data);

                    if ($quantity_temp == '') {
                        $quantity_temp = '0';
                    }

                    $product_detail = $this->get_product_from_variant($p_id);


                    $this->db->query("UPDATE product_weight SET  temp_quantity = 0 WHERE id= '$p_id'");

                    $discount_price = ($product_detail->price * $quantity_temp) - $pro_temp_result[0]->price;

                    $insertion = array(
                        'vendor_id' => $vendor_id,
                        'order_id' => $last_id,
                        'product_id' => $product_detail->product_id,
                        'product_weight_id' => $p_id,
                        'weight_id' => $product_detail->package_id,
                        'quantity' => $pro_temp_result[0]->quantity,
                        'actual_price' => $product_detail->price,
                        'actual_discount' => $product_detail->discount_per,
                        'discount' => $pro_temp_result[0]->discount,
                        'discount_price' => $discount_price,
                        'calculation_price' => $pro_temp_result[0]->price,
                        'status' => '1',
                        'delevery_status' => '1',
                        'dt_added' => strtotime(date('Y-m-d H:i:s')),
                        'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                    );
                    $data['insert'] = $insertion;
                    $data['table'] = 'order_details';
                    $result = $this->insertRecord($data);

                }
                $data['where'] = ['id' => $product_temp_id];
                $data['table'] = 'order_temp';
                $this->deleteRecords($data);
            }
        }
        unset($data);

        $data['update']['total_item'] = $total_item;
        $data['where'] = ['id' => $last_id];
        $data['table'] = 'order';
        $this->updateRecords($data);

        unset($data);
        $data['where'] = ['parked_order_id' => $parked_order_id];
        $data['table'] = 'parked_order_details';
        $this->deleteRecords($data);

        unset($data);
        $data['where'] = ['id' => $parked_order_id];
        $data['table'] = 'parked_order';
        $this->deleteRecords($data);


        $this->session->set_flashdata("msg", "Order created successfully.");
        redirect(base_url() . '	sell/index');
        exit;

    }


    function order__checkout($postdata)
    {


        $vendor_id = $this->session->userdata('id');


        if (isset($postdata['customer'])) {
            $user_id = $postdata['customer'];
        }

        $sub_total = $postdata['hidden_subtotal'];
        $disc_percentage = $postdata['disc_percentage'];
        $discount_total = $postdata['hidden_discount_total'];
        $total = $postdata['hidden_total'];
        $register_id = $postdata['register_id'];
        $hidden_total_pay = $postdata['hidden_total_pay'];


        if (isset($postdata['parked_sell']) && $postdata['parked_sell'] == 'Park Sale') {

            $payment_type = '2';

        } else {


            if (isset($postdata['cash']) && $postdata['cash'] == 'Cash') {
                $payment_type = '0';
                $reg_query = $this->db->query("SELECT cash_amount_expected, counted, difference FROM register WHERE id = $register_id");
                $reg_result = $reg_query->row_array();

                $cash_amount_expected = $reg_result['cash_amount_expected'] + $total;
                $counted = $reg_result['counted'];
                $difference = $counted - $cash_amount_expected;

                $this->db->query("UPDATE register SET cash_amount_expected = '$cash_amount_expected', counted = '$counted' WHERE id = $register_id");

            }

            if (isset($postdata['credit_card']) && $postdata['credit_card'] == 'Credit Card') {
                $payment_type = '1';
                $reg_query = $this->db->query("SELECT credit_card_expected, credit_card_counted, credit_card_differences FROM register WHERE id = $register_id");
                $reg_result = $reg_query->row_array();

                $cash_amount_expected = $reg_result['credit_card_expected'] + $total;
                $counted = $reg_result['credit_card_counted'];
                $difference = $counted - $cash_amount_expected;

                $this->db->query("UPDATE register SET credit_card_expected = '$cash_amount_expected', credit_card_counted = '$counted' WHERE id = $register_id");


            }
        }

        $order_array = array(
            'order_number' => 'OD' . strtotime(date('Y-m-d H:i:s')),
            'vendor_id' => $vendor_id,
            'user_id' => $user_id,
            'register_id' => $register_id,
            'total_price' => $sub_total,
            'total_discount' => $disc_percentage,
            'calculation_price' => $hidden_total_pay,
            'payment_type' => $payment_type,
            'status' => '1',
            'dt_added' => strtotime(date('Y-m-d H:i:s')),
            'dt_updated' => strtotime(date('Y-m-d H:i:s'))
        );
        $this->db->insert('pos_order', $order_array);
        $last_inserted_order_id = $this->db->insert_id();

        //Order Details
        foreach ($postdata as $key => $value) {
            if (count(explode('qnt', $key)) > 1) {
                $example = explode('qnt', $key);

                $product_temp_id = $example['1'];

                if ($product_temp_id != '') {

                    $pro_temp_row = $this->db->query("SELECT Product_id, quantity, price, discount, discount_price FROM order_temp WHERE id = '$product_temp_id'");
                    $pro_temp_result = $pro_temp_row->row_array();
                    // print_r($pro_temp_result);exit;
                    $this->db->query("UPDATE order_temp SET park = '1' WHERE id = '$product_temp_id'");

                    $p_id = $pro_temp_result['Product_id'];
                    $quantity_temp = $pro_temp_result['quantity'];

                    $query = $this->db->query("SELECT quantity FROM product_weight WHERE id = '$p_id'");
                    $result = $query->row_array();
                    $temp_qnt = $result['quantity'];

                    if ($quantity_temp == '') {
                        $quantity_temp = '0';
                    }
                    $product_detail = $this->get_product_from_variant($p_id);
                    // $this->db->query("UPDATE product_weight SET quantity = $temp_qnt - $quantity_temp, temp_quantity = $temp_qnt - $quantity_temp WHERE id= '$p_id'");

                    $order_temp_array = array(
                        'vendor_id' => $vendor_id,
                        'parked_order_id' => $last_id,
                        'product_id' => $product_detail->product_id,
                        'product_variant_id' => $p_id,
                        'order_temp_id' => $product_temp_id,
                        'quantity' => $pro_temp_result['quantity'],
                        'actual_discount' => $product_detail->discount_per,
                        'actual_price' => $product_detail->price,
                        'total_discount' => $pro_temp_result['discount'],
                        'calculation_price' => $pro_temp_result['price'],
                        'status' => '1',
                        'dt_added' => strtotime(date('Y-m-d H:i:s')),
                        'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                    );
                    $this->db->insert('pos_order_detail', $order_temp_array);
                }
            }
        }
        if ($payment_type != '2') {
            $this->db->query("DELETE FROM order_temp WHERE id = '$product_temp_id'");
        }
        $this->session->set_flashdata("msg", "Order created successfully.");
        redirect(base_url() . '	sell/index');


    }

    function get_product_from_variant($variant_id)
    {
        $data['select'] = ['p.*', 'pw.discount_per', 'pw.price', 'pw.product_id', 'w.id as package_id'];
        $data['where'] = ['pw.id' => $variant_id];
        $data['join'] = ['product as p ' => ['pw.product_id = p.id', 'LEFT'],
            'weight as w' => ['pw.weight_id = w.id', 'LEFT']
        ];
        $data['table'] = 'product_weight AS pw';
        $result = $this->selectFromJoin($data);
        return $result[0];
    }


    public function pos_order_checkout()
    {
        $vendor_id = $this->session->userdata('id');
        $user_id = $this->input->post('customer');
        $sub_total = $this->input->post('hidden_subtotal');
        $disc_percentage = $this->input->post('disc_percentage');
        $discount_total = $this->input->post('hidden_discount_total');
        $total = $this->input->post('hidden_total');
        $register_id = $this->input->post('register_id');
        // print_r($this->input->post());exit;
        //Fetch Email and Name from User Id
        $query_user = $this->db->query("SELECT email, name FROM vendor WHERE id = '$vendor_id'");
        $query_result = $query_user->row_array();

        $card = $this->input->post('credit_card');
        if ($card == 'Credit Card') {
            $type = "1";
            $reg_query = $this->db->query("SELECT credit_card_expected, credit_card_counted, credit_card_differences FROM register WHERE id = $register_id");
            $reg_result = $reg_query->row_array();

            $cash_amount_expected = $reg_result['credit_card_expected'] + $total;
            $counted = $reg_result['credit_card_counted'];
            $difference = $counted - $cash_amount_expected;

            $this->db->query("UPDATE register SET credit_card_expected = '$cash_amount_expected', credit_card_counted = '$counted' WHERE id = $register_id");
        } else {
            $type = "0";
            $reg_query = $this->db->query("SELECT cash_amount_expected, counted, difference FROM register WHERE id = $register_id");
            $reg_result = $reg_query->row_array();

            $cash_amount_expected = $reg_result['cash_amount_expected'] + $total;
            $counted = $reg_result['counted'];
            $difference = $counted - $cash_amount_expected;

            $this->db->query("UPDATE register SET cash_amount_expected = '$cash_amount_expected', counted = '$counted' WHERE id = $register_id");


        }

        $old_order_id = $_POST['old_order_id'];

        //Delete From Order Delete
        // $this->db->where('pos_order_id', $old_order_id);
        // $this->db->delete('pos_order_detail');

        // //Delete From Order
        // $this->db->where('id', $old_order_id);
        // $this->db->delete('pos_order');

        $cash_array = array(
            'user_id' => $user_id,
            'vendor_id' => $vendor_id,
            'register_id' => $register_id,
            'order_number' => 'OD' . strtotime(date('Y-m-d H:i:s')),
            'total_price' => $sub_total,
            'total_discount' => $disc_percentage,
            'calculation_price' => $total,
            'payment_type' => $type,
            'status' => '1',
            'dt_added' => strtotime(date('Y-m-d H:i:s')),
            'dt_updated' => strtotime(date('Y-m-d H:i:s'))
        );
        $this->db->insert('pos_order', $cash_array);
        $last_inserted_order_id = $this->db->insert_id();

        //Order Details

        foreach ($_REQUEST as $key => $value) {

//                print_r($_REQUEST);exit;

            if ((count(explode('qnt', $key)) > 1) && (count(explode('discount', $key)) > 0)) {

                //Temp Qnt
                $example = explode('qnt', $key);
                $product_temp_id = $example['1'];


                if ($product_temp_id != '') {

                    //Temp Disc
                    $example = explode('discount', $key);

                    $pro_temp_row = $this->db->query("SELECT Product_id, quantity, price, discount, discount_price FROM order_temp WHERE id = '$product_temp_id'");

                    $pro_temp_result = $pro_temp_row->row_array();
                    if (count($pro_temp_result) > 0) {
                        $p_id = $pro_temp_result['Product_id'];
                        $product_detail = $this->get_product_from_variant($p_id);
                        $this->db->where('pos_order_id', $old_order_id);
                        $this->db->delete('pos_order_detail');

                        //Delete From Order
                        $this->db->where('id', $old_order_id);
                        $this->db->delete('pos_order');


                        $order_temp_array = array(
                            'pos_order_id' => $last_inserted_order_id,
                            'product_id' => $product_detail->product_id,
                            'product_variant_id' => $p_id,
                            'quantity' => $pro_temp_result['quantity'],
                            'actual_discount' => $product_detail->discount_per,
                            'actual_price' => $product_detail->price,
                            'total_discount' => $pro_temp_result['discount'],
                            'calculation_price' => $pro_temp_result['price'],
                            'status' => '1',
                            'dt_added' => strtotime(date('Y-m-d H:i:s')),
                            'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                        );
                        $this->db->insert('pos_order_detail', $order_temp_array);

                    } else {
                        $pro_temp_row = $this->db->query("SELECT product_id,product_variant_id, quantity, actual_discount,actual_price, total_discount, calculation_price FROM pos_order_detail WHERE id = '$product_temp_id'");
                        $pro_temp_result = $pro_temp_row->row_array();

                        $old_order_id = $_REQUEST['old_order_id'];

                        // print_r($pro_temp_result);exit;

                        $product_detail = $this->get_product_from_variant($pro_temp_result['Product_id']);

                        $order_temp_array = array(
                            'pos_order_id' => $last_inserted_order_id,
                            'product_id' => $pro_temp_result['product_id'],
                            'product_variant_id' => $pro_temp_result['product_variant_id'],
                            'quantity' => $pro_temp_result['quantity'],
                            'actual_discount' => $pro_temp_result['actual_discount'],
                            'actual_price' => $pro_temp_result['actual_price'],
                            'total_discount' => $pro_temp_result['total_discount'],
                            'calculation_price' => $pro_temp_result['calculation_price'],
                            'status' => '1',
                            'dt_added' => strtotime(date('Y-m-d H:i:s')),
                            'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                        );
                        $this->db->insert('pos_order_detail', $order_temp_array);

                    }
                }
            }
        }
        // $this->db->query("DELETE FROM order_temp WHERE id = '$product_temp_id'");
        $this->db->where('pos_order_id', $old_order_id);
        $this->db->delete('pos_order_detail');
        $this->db->where('id', $old_order_id);
        $this->db->delete('pos_order');
        if ($last_inserted_order_id) {
            redirect(base_url() . 'sell/print_sell?ZqRl=' . base64_encode($last_inserted_order_id));
        }
    }


    public function select_category()
    {
        $vendor_id = $this->session->userdata('id');

        $data['select'] = ['*'];
        $data['where'] = ['status !=' => '9', 'vendor_id' => $vendor_id];
        $data['order'] = 'id';
        $data['table'] = 'category';
        @$res = $this->selectRecords($data);

        
            $html = '';
        foreach ($res as $type) { ?>
            <div class="catg_list" id="catg_list"
                 onclick="return select_subcategory('<?php echo $type->id; ?>','<?php echo $type->name; ?>');">
                <a href="javascript:;"><span><?php echo @$type->name; ?></span></a>
            </div>
        <?php }
        echo $html;

        exit;

    }


    public function set_qnt($postdata)
    {

        $id = $postdata['product_id'];
        $park = $postdata['park'];

        if ($park == "park") {
            $response = $this->db->query("UPDATE product_weight SET quantity = quantity - 1,park_quantity = park_quantity + 1  WHERE id= '$id'");

        } else {
            $response = $this->db->query("UPDATE product_weight SET quantity = quantity - 1,temp_quantity = temp_quantity + 1  WHERE id= '$id'");

        }
        if ($response) {
            exit;
        }


    }

    public function delete_parked_order($postdata)
    {

        $product_temp_id = $postdata['product_id'];
//        echo $product_temp_id;exit;
        $product_id = $postdata['true_product_id'];
//        echo $product_id;exit;

        $pro_temp_qnt = $postdata['pro_temp_qnt'];


        if ($pro_temp_qnt == '' || $pro_temp_qnt == null) {
            $pro_temp_qnt = '0';
        }
//        echo $pro_temp_qnt;exit;

        $this->db->query("UPDATE product_weight SET quantity = quantity + $pro_temp_qnt,park_quantity = park_quantity - $pro_temp_qnt     WHERE id= '$product_id'");


//        $query = $this->db->query("SELECT quantity,temp_quantity FROM product_weight WHERE id = '$product_id'");
//        $result = $query->row_array();
//
//        $qnt = $result['quantity'];
//        $temp_qnt = $result['temp_quantity'];
//        $this->db->query("UPDATE product_weight SET quantity = $qnt + $pro_temp_qnt,temp_quantity = $temp_qnt-$pro_temp_qnt WHERE id= '$product_id'");

        $subtotal = $postdata['subtotal'];
        $disc_percentage = $postdata['disc_percentage'];


        $data['select'] = ['price', 'parked_order_id'];
        $data['where'] = ['id' => $product_temp_id];
        $data['table'] = 'parked_order_details';
        $price_result = $this->selectRecords($data);
        $price_db = $price_result[0]->price;
        $parked_order_id = $price_result[0]->parked_order_id;

        unset($data);
        $data['where'] = ['id' => $product_temp_id];
        $data['table'] = 'parked_order_details';
        $this->deleteRecords($data);
//        echo $this->db->last_query();


        $data['select'] = ['*'];
        $data['where'] = ['parked_order_id' => $parked_order_id];
        $data['table'] = 'parked_order_details';
        $result = $this->selectRecords($data);

        if (count($result) == 0) {

            $data['where'] = ['id' => $parked_order_id];
            $data['table'] = 'parked_order';
            $this->deleteRecords($data);
        }


        $this->refresh_parked_order($parked_order_id);


//        echo $this->db->last_query();exit;
//        print_r($arr);exit;
//        $price_query = $this->db->query("SELECT price from order_temp WHERE id = '$product_temp_id'");
//        $price_result = $price_query->row_array();
//        $price_db = $price_result['price'];

//        $this->db->query("DELETE FROM order_temp WHERE id = '$product_temp_id'");

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

    public function discard_parked_order($postdata)
    {

        $id = $postdata['id'];

        $data['select'] = ['product_weight_id', 'quantity'];
        $data['where'] = ['parked_order_id' => $id];
        $data['table'] = 'parked_order_details';
        $result = $this->selectRecords($data);

        foreach ($result as $key) {

            $product_weight_id = $key->product_weight_id;
            $qnt = $key->quantity;

            $this->db->query("UPDATE product_weight SET quantity = quantity + $qnt , park_quantity = park_quantity - $qnt WHERE id= '$product_weight_id'");
        }

        unset($data);

        $data['where'] = ['parked_order_id' => $id];
        $data['table'] = 'parked_order_details';
        $this->deleteRecords($data);


        unset($data);

        $data['where'] = ['id' => $id];
        $data['table'] = 'parked_order';
        $this->deleteRecords($data);


        echo 1;
        exit;
    }

    public function update_discount_parked_order($postdata)
    {

        $product_id = $postdata['product_id'];
        $quantity = $postdata['quantity'];
        $price = $postdata['price'];
        $discount = $postdata['discount'];
        $discount_price = $postdata['discount_price'];


        $current_date = strtotime(date('Y-m-d H:i:s'));


        $temp_query = $this->db->query("SELECT product_weight_id FROM parked_order_details WHERE id = '$product_id'");
        $result_temp = $temp_query->row_array();
        $true_product_id = $result_temp['product_weight_id'];

        $temp_price = $this->db->query("SELECT price FROM product_weight WHERE id = '$true_product_id'");
        $result_pro_temp = $temp_price->row_array();
        $base_price = $result_pro_temp['price'];

        $price = ($quantity * $base_price) - $discount_price;

        $this->db->query("UPDATE parked_order_details SET quantity = '$quantity', price = '$price', discount = '$discount', discount_price = '$discount_price', dt_updated = '$current_date'  WHERE id = '$product_id'");


//        $this->db->query("UPDATE product_weight SET quantity = quantity - 1 WHERE id= '$true_product_id'");

        $temp_pro_query = $this->db->query("SELECT quantity FROM product_weight WHERE id = '$true_product_id'");
        $result_pro_temp = $temp_pro_query->row_array();
        $temp_qnt = $result_pro_temp['quantity'];


        $data['select'] = ['parked_order_id'];
        $data['where'] = ['id' => $product_id];
        $data['table'] = 'parked_order_details';
        $res = $this->selectRecords($data);
        $parked_order_id = $res[0]->parked_order_id;

        unset($data);

        $data['update']['order_discount'] = 0;
        $data['where'] = ['id' => $parked_order_id];
        $data['table'] = 'parked_order';
        $this->updateRecords($data);
        unset($data);

        $this->refresh_parked_order($parked_order_id);

        echo json_encode($temp_qnt);
        exit();

    }

    public function update_parked_order($postdata)
    {
//exit;
        $product_id = $postdata['product_id'];
        $quantity = $postdata['quantity'];
        $price = $postdata['price'];
        $discount = $postdata['discount'];
        $discount_price = $postdata['discount_price'];
//        echo $product_id;exit;


//
//        $data['select'] = ['quantity'];
//        $data['where'] = ['id' => $product_id];
//        $data['table'] = 'parked_order_details';
//        $qnt_arr = $this->selectRecords($data);
//        $qnt = $qnt_arr[0]->quantity;
//
//        echo $qnt;


        $temp_query = $this->db->query("SELECT product_weight_id FROM parked_order_details WHERE id = '$product_id'");
        $result_temp = $temp_query->row_array();
        $true_product_id = $result_temp['product_weight_id'];


//        $this->db->query("UPDATE product_weight SET quantity = quantity - $quantity,park_quantity = park_quantity + $quantity  WHERE id= '$product_variant_id'");

//        $this->db->query("UPDATE product_weight SET quantity = quantity + $qnt WHERE id= '$true_product_id'");

        $current_date = strtotime(date('Y-m-d H:i:s'));

        $this->db->query("UPDATE parked_order_details SET quantity = '$quantity', price = '$price', discount = '$discount', discount_price = '$discount_price', dt_updated = '$current_date'  WHERE id = '$product_id'");


//        $this->db->query("UPDATE product_weight SET quantity = quantity - $quantity WHERE id= '$true_product_id'");

//        $this->db->query("UPDATE product_weight SET quantity = quantity - 1 WHERE id= '$true_product_id'");

        $temp_pro_query = $this->db->query("SELECT quantity FROM product_weight WHERE id = '$true_product_id'");
        $result_pro_temp = $temp_pro_query->row_array();
        $temp_qnt = $result_pro_temp['quantity'];


        $data['select'] = ['parked_order_id'];
        $data['where'] = ['id' => $product_id];
        $data['table'] = 'parked_order_details';
        $res = $this->selectRecords($data);
        $parked_order_id = $res[0]->parked_order_id;

        unset ($data);

        $data['update']['order_discount'] = 0;
        $data['where'] = ['id' => $parked_order_id];
        $data['table'] = 'parked_order';
        $this->updateRecords($data);
        unset($data);



        $this->refresh_parked_order($parked_order_id);
//echo 1;exit;
        echo json_encode($temp_qnt);
        exit();

    }


    public function refresh_parked_order($id)
    {
        unset($data);
//        echo 2;exit;
//echo $id;exit;
        $data['select'] = ['sum(price) as total'];
        $data['where'] = ['parked_order_id' => $id];
        $data['table'] = 'parked_order_details';
        $res = $this->selectRecords($data);
//        echo $this->db->last_query();exit;
//        print_r($res);
        $total = $res[0]->total;

        unset($data);
        $data['select'] = ['order_discount'];
        $data['where'] = ['id' => $id];
        $data['table'] = 'parked_order';
        $result = $this->selectRecords($data);

        $discount = $result[0]->order_discount;


        $pay = $total - ($total * $discount / 100);


        unset($data);

        $data['update']['payable_amount'] = $pay;
        $data['update']['total'] = $total;
        $data['update']['order_discount'] = $discount;
        $data['where'] = ['id' => $id];
        $data['table'] = 'parked_order';
        $response = $this->updateRecords($data);
        if ($response) {
            return 1;
        }

    }
    public function single_delete_sales_history($id){

        unset($data);

        $data['select'] = ['quantity','product_weight_id'];
        $data['where'] = ['parked_order_id'=> $id];
        $data['table'] = 'parked_order_details';
        $res = $this->selectRecords($data);
        unset($data);

        foreach ($res as $row){
            $qnt = $row->quantity;
            $ids = $row->product_weight_id;

            $this->db->query("UPDATE product_weight SET quantity = quantity + $qnt , park_quantity = park_quantity - $qnt WHERE id= '$ids'");
        }

        $data = array('status' => '9');

        $this->db->where('id', $id);
        $this->db->update('parked_order', $data);

        $this->db->where('parked_order_id', $id);
        $this->db->update('parked_order_details', $data);

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status' => 1]);
        exit;
    }


    public function single_delete_sell_sales_history($id){

        $data = array('status' => '9');

        $this->db->where('id', $id);
        $this->db->update('order', $data);

        $this->db->where('order_id', $id);
        $this->db->update('order_details', $data);

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status' => 1]);
        exit;
    }

    public function update_order_temp($getData){
        $product_id = $_GET['product_id'];
        $quantity = $_GET['quantity'];
        // $qty = $_GET['qty'];
        $price = $_GET['price'];
        // $product_descount = $_GET['product_descount'];
        $discount = $_GET['discount'];
        $discount_price = $_GET['discount_price'];
        // $park = $_GET['park'];
        $current_date = strtotime(date('Y-m-d H:i:s'));
        $update = array(
            'quantity'=>$quantity,
            'price'=>$price,
            'discount'=>$discount,
            'discount_price'=>$discount_price,
            'dt_updated'=>$current_date
        );
        $data['table'] = 'order_temp';
        $data['where'] = ['id'=>$product_id];
        $data['update'] = $update;
        $this->updateRecords($data);
        unset($data);
        $data['table'] = 'order_temp';
        $data['select'] = ['product_weight_id'];
        $data['where'] = ['id'=>$product_id];
        $result_temp = $this->selectRecords($data,true);
        $true_product_id = $result_temp[0]['product_weight_id'];
        unset($data);
        $data['table'] = 'product_weight';
        $data['select'] = ['quantity','temp_quantity'];
        $data['where'] = ['id'=>$true_product_id];
        $result_pro_temp = $this->selectRecords($data,true);
        $temp_qnt = $result_pro_temp[0]['quantity'];
        return $temp_qnt;
    }

     public function getRegister(){
        $branch_id = $this->session->userdata('id');
        $register_query = $this->db->query("SELECT * FROM `register` WHERE branch_id = '$branch_id' GROUP BY id DESC LIMIT 1");
        return  $register_result = $register_query->result();
     }

     public function customer(){
        $branch_id = $this->session->userdata('id');
        $data['table'] = 'customer';
        $data['select'] = ['*']; 
        $data['where'] = ['status!='=>'9','branch_id'=>$branch_id];
        return $this->selectRecords($data);

     }

    public function getCategory(){
        $branch_id = $this->session->userdata('id');
        $data['table'] = 'category';
        $data['select'] = ['*']; 
        $data['where'] = ['status!='=>'9','branch_id'=>$branch_id];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
     }

    public function getCurrency(){
        $data['table'] = 'set_default';
        $data['select'] = ['*'];
        $data['where'] = ['request_id'=>'3'];
        return $this->selectRecords($data);
    }

    public function OrderTemp($parked_order_id){
        $vendor_id = $this->session->userdata('id');
        $data['table'] = 'parked_order_details as ot';
        $data['select'] = [
            'po.order_discount as order_discount',
            'p.name as product_name','pw.price as actual_price',
            'pw.discount_price as product_price','pw.discount_per as product_discount','ot.*'
        ];
        $data['join'] = [
            'product_weight as pw'=>['pw.id = ot.product_weight_id','LEFT'],
            'product as p'=>['p.id = pw.product_id','LEFT'],
            'parked_order as po'=>['po.id = ot.parked_order_id','LEFT']
        ];
        $data['where'] = [
            'ot.branch_id'=>$vendor_id,
            'ot.parked_order_id' => $parked_order_id
        ];
        return $this->selectFromJoin($data);
    }

    public function OrderTempWithoutPark(){
        $vendor_id = $this->session->userdata('id');
        $data['table'] = 'order_temp as ot';
        $data['select'] = [
            'p.name as product_name','pw.price as actual_price',
            'pw.discount_price as product_price','pw.discount_per as product_discount','ot.*'
        ];
        $data['join'] = [
            'product_weight as pw'=>['pw.id = ot.product_weight_id','LEFT'],
            'product as p'=>['p.id = pw.product_id','LEFT'],
        ];
        $data['where'] = ['ot.branch_id'=>$vendor_id,'park'=>'0'];
        return $this->selectFromJoin($data);
    }

    public function orderHistory(){
        $vendor_id = $this->session->userdata('id');
        $data['table'] = 'order as po';
        $data['select'] = ['po.*','c.customer_name','v.name as vendor_name'];
        $data['join'] = [
            'vendor as v'=>['v.id = po.vendor_id','LEFT'],
            'customer as c'=>['c.id = po.user_id','LEFT']
        ];
        $data['where'] = [
            'po.status'=>'1','payment_type !='=>'2',
            'po.vendor_id'=> $vendor_id
        ];
        $data['order'] = 'po.id DESC';
        return $this->selectFromJoin($data);
    }

}

?>