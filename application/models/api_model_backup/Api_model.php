<?php
require_once ('application/libraries/vendor/autoload.php');
class Api_model extends My_model {
    public function order_status($postdata) {
        $order_id = $postdata['order_id'];
        $data['select'] = ['v.delivery_by'];
        $data['join'] = ['order as o' => ['o.vendor_id = v.id', 'LEFT'], ];
        $data['where'] = ['o.id' => $order_id];
        $data['table'] = 'vendor as v';
        $re = $this->selectFromJoin($data, true);
        $status = $re[0]['delivery_by'];
        if ($status == '1') {
            $data['select'] = ['u.image', 'u.name', 'u.phone_no', 'u.vehicle_name', 'DATE_FORMAT(do.dt_created, \'%d-%M\') as update_date', 'u.vehicle_number', 'o.order_status'];
            $data['join'] = ['order as o' => ['o.id = do.order_id', 'LEFT'], 'delivery_user as u' => ['u.id = do.delivery_user_id', 'LEFT']];
            $data['where'] = ['o.id' => $order_id];
            $data['table'] = 'delivery_order as do';
            $res = $this->selectFromJoin($data, true);
            if ($res) {
                $res = $res[0];
                $res['image'] = base_url() . 'public/images/delivery_profile/' . $res['image'];
            }
            // $this->db->last_query();
            
        } else {
            $data['select'] = ['v.image', 's.name', 's.phone_no', 's.vehicle_number', 's.vehicle_name', 'o.order_status', 'o.dt_added as update_date'];
            $data['join'] = ['order as o ' => ['s.id = o.staff_id', 'LEFT'], 'vendor as v ' => ['s.vendor_id = v.id', 'LEFT'], ];
            $data['where'] = ['o.id' => $order_id];
            $data['table'] = 'staff as s';
            $res = $this->selectFromJoin($data, true);
            if ($res) {
                $res = $res[0];
                $res['image'] = base_url() . 'public/images/vendor_shop/' . $res['image'];
                $res['update_date'] = date('d-M', strtotime($res['update_date']));
            }
        }
        if ($res) {
            $response = array('success' => '1', 'message' => 'success', 'data' => $res);
        } else {
            $data['select'] = ['o.user_id', 'd.token', 'd.type', 'd.device_id', 'u.notification_status', 'o.order_status', 'o.order_no'];
            $data['where'] = ['o.id' => $order_id];
            $data['table'] = 'order AS o';
            $data['join'] = ['device AS d' => ['d.user_id = o.user_id', 'LEFT'], 'user AS u' => ['u.id = o.user_id', 'LEFT'], ];
            $send = $this->selectFromJoin($data);
            $order_status = $send[0]->order_status;
            if ($order_status == '1') {
                $send_status = 'New Order';
            }
            if ($order_status == '2') {
                $send_status = 'Pending for Ready';
            }
            if ($order_status == '3') {
                $send_status = 'Ready For Deliver';
                $this->load->model('delivery_api_model');
                $this->delivery_api_model->send_notification($order_id);
            }
            if ($order_status == '4') {
                $send_status = 'Pick Up';
            }
            if ($order_status == '5') {
                $send_status = 'On the way';
            }
            $response = array('success' => '1', 'message' => 'Your order ' . $send_status);
        }
        return $response;
    }
    public function sendMailToSuperAdmin($postdata) {
    }
    public function check_branch() {
        $data['table'] = 'admin';
        $data['select'] = ['*'];
        $data['where'] = ['id' => '2'];
        $result = $this->selectRecords($data);
        return (int)$result[0]->approved_branch;
    }
    public function revokeFb($facebookToken) {
        $data['table'] = 'user';
        $data['select'] = ['*'];
        $data['where'] = ['facebook_token_id' => $facebookToken];
        $res = $this->selectRecords($data);
        // print_r($res);die;
        unset($data);
        if (!empty($res)) {
            $data['table'] = 'user';
            $data['update'] = ['status' => '0'];
            $data['where'] = ['facebook_token_id' => $facebookToken];
            $this->updateRecords($data);
            return true;
        } else {
            return false;
        }
    }
    public function vendor_list() {
        if (isset($_POST['latitude']) && $_POST['latitude'] != '' && $_POST['longitude'] != '') {
            $latitude = $_POST['latitude'];
            $longitude = $_POST['longitude'];
            $find = "( 3959 * acos( cos( radians(" . $latitude . ") ) * cos( radians(latitude ) ) * cos( radians(longitude ) - radians(" . $longitude . ") ) + sin( radians(" . $latitude . ") ) * sin( radians(latitude ) ) ) ) as distance";
            $data['order'] = "distance DESC";
            $data['having'] = 'distance < "1000"';
        } else {
            $find = "";
        }
        $data['select'] = ['id', 'name', 'email', 'phone_no', 'location', 'latitude', 'longitude', 'image', $find];
       
        $data['where'] = ['status' => '1'];
        $data['table'] = 'vendor';
        $result = $this->selectRecords($data);
        $cu['select'] = ['*', $find];
        $cu['where'] = ['status' => '1'];
        $cu['table'] = 'vendor';
        $total_count = $this->selectRecords($cu);
        unset($data);
        $data['select'] = ['value'];
        $data['where'] = ['request_id' => 1];
        $data['table'] = 'set_default';
        $min_value = $this->selectRecords($data);
        unset($data);
        $data['select'] = ['value'];
        $data['where'] = ['request_id' => 3];
        $data['table'] = 'set_default';
        $cur_value = $this->selectRecords($data);
        foreach ($result as $key => $value) {
            $value->image = base_url() . 'public/images/vendor_shop/' . $value->image;
            $value->total_products = $this->total_shop_product_if_varient_exists($value->id);
        }
        if ($result) {
            $response['success'] = 1;
            $response['message'] = 'Vendor Data';
            $response['total_count'] = count($total_count);
            $response['cart_minimum_value'] = $min_value[0]->value;
            $response['currency'] = $cur_value[0]->value;
            $response["data"] = $result;
        } else {
            $response['success'] = 0;
            $response['message'] = "No Match found";
        }
        return $response;
    }
    public function get_vendor($postdata) {
        $data['select'] = ['id', 'name', 'email', 'phone_no', 'location', 'latitude', 'longitude', 'image'];
        $data['where'] = ['id' => $postdata['id']];
        $data['table'] = 'vendor';
        $result = $this->selectRecords($data);
        foreach ($result as $key => $value) {
            $value->image = base_url() . 'public/images/vendor_shop/' . $value->image;
            $value->total_products = $this->total_shop_product($value->id);
        }
        if ($result) {
            $response['success'] = 1;
            $response['message'] = 'Vendor Data';
            $response["data"] = $result;
        } else {
            $response['success'] = 0;
            $response['message'] = "No Match found";
        }
        return $response;
    }
    function total_shop_product_if_varient_exists($id = NULL, $category_id = NULL) {
        // $data['select'] = ['COUNT(p.id) as total_product'];
        $data['select'] = ['*'];
        if (isset($id) && $id != '') {
            $data['where']['p.vendor_id'] = $id;
        }
        if ($category_id != '') {
            $data['where']['p.category_id'] = $category_id;
        }
        $data['where']['p.status !='] = '9';
        
        $data['table'] = 'product AS p';
        $result = $this->selectRecords($data);
        foreach ($result as $key => $value) {
            unset($data);
            $data['table'] = 'product_weight';
            $data['select'] = ["*"];
            $data['where'] = ['product_id' => $value->id, 'status !=' => '9'];
            $pw = $this->selectRecords($data);
            if (empty($pw)) {
                unset($result[$key]);
            }
        }
        foreach ($result as $key => $value) {
            unset($data);
            $data['table'] = 'category';
            $data['select'] = ["*"];
            $data['where'] = ['id' => $value->category_id, 'status !=' => '9'];
            $pw = $this->selectRecords($data);
            if (empty($pw)) {
                unset($result[$key]);
            }
        }
        // echo   $this->db->last_query();exit;
        $count = count($result);
        return (string)$count;
        // return $result[0]->total_product;
        
    }
    function total_shop_product($id = NULL, $category_id = NULL) {
        $data['select'] = ['COUNT(p.id) as total_product'];
        if (isset($id) && $id != '') {
            $data['where']['p.vendor_id'] = $id;
        }
        if ($category_id != '' && $category_id != '') {
            $data['where']['p.category_id'] = $category_id;
        }
        $data['where']['p.status !='] = '9';
        // $data['join'] = [
        //     'product_weight  AS w' => [
        //         'w.product_id = p.id',
        //         'inner'
        //     ]
        // ];
        // $data['where']['w.quantity >'] = '0';
        // $data['groupBy'] = 'p.id';
        $data['table'] = 'product AS p';
        $result = $this->selectRecords($data);
        // echo   $this->db->last_query();exit;
        return $result[0]->total_product;
    }
    function category_list($postdata) {
        if (isset($postdata['vendor_id']) && $postdata['vendor_id'] != '') {
            $vendor_id = $postdata['vendor_id'];
            $data['select'] = ['*'];
            $data['where'] = ['vendor_id' => $vendor_id, 'status !=' => '9'];
            $data['table'] = 'category';
            $result = $this->selectRecords($data);
            foreach ($result as $row) {
                $check = $this->check_variant_from_category($row->id);
                // print_r($check);die;
                if (count($check) == 0) {
                    // unset($row->id);
                    
                }
                $total_product = $this->total_shop_product_if_varient_exists($vendor_id, $row->id);
                $row->image = base_url() . 'public/images/category/' . $row->image;
                $row->total_product = $total_product;
            }
            $total_product = [];
            foreach ($result as $key => $row) {
                $total_product[$key] = $row->total_product;
            }
            array_multisort($total_product, SORT_DESC, $result);
            // print_r($result);die;
            // $result = ksort(array)
            if ($result) {
                $response['success'] = 1;
                $response['message'] = 'category Data';
                $response["data"] = $result;
                unset($data);
                $data['select'] = ['value'];
                $data['where'] = ['request_id' => 1];
                $data['table'] = 'set_default';
                $min_value = $this->selectRecords($data);
                unset($data);
                $data['select'] = ['value'];
                $data['where'] = ['request_id' => 3];
                $data['table'] = 'set_default';
                $cur_value = $this->selectRecords($data);
                $response['cart_minimum_value'] = $min_value[0]->value;
                $response['currency'] = $cur_value[0]->value;
                // $response["vendor_details"] = $result;
                
            } else {
                $response['success'] = 1;
                $response['message'] = "No Match found";
            }
        } else {
            $response['success'] = 0;
            $response['message'] = "No Vednor";
        }
        return $response;
    }
    function check_variant_from_category($category_id) {
        $data['select'] = ['pw.quantity', 'pw.id'];
        $data['where'] = ['p.category_id' => $category_id, 'p.status !=' => '9'];
        $data['table'] = 'product AS p';
        $data['join'] = ['product_weight AS pw' => ['p.id=pw.product_id', 'LEFT']];
        $result = $this->selectFromJoin($data);
        // echo $this->db->last_query();
        if (count($result) > 0) {
            foreach ($result as $key => $value) {
                if ($value->quantity > 0) {
                    // echo $value->quantity;exit;
                    return true;
                }
            }
        }
    }
    function subcategory_list($postdata) {
        if (isset($postdata['category_id']) && $postdata['category_id'] != '') {
            $category_id = $postdata['category_id'];
            $vendor_id = $postdata['vendor_id'];
            $data['select'] = ['*'];
            $data['where'] = ['category_id' => $category_id, 'vendor_id' => $vendor_id, 'status !=' => '9'];
            $data['table'] = 'subcategory';
            $result = $this->selectRecords($data);
            foreach ($result as $key => $value) {
                unset($data);
                $data['table'] = 'product as p';
                $data['join'] = ['product_weight as pw' => ['p.id=pw.product_id', 'LEFT']];
                $data['select'] = ['*'];
                $data['where'] = ['pw.vendor_id' => $vendor_id, 'pw.status !=' => '9', 'p.subcategory_id' => $value->id];
                $r = $this->selectFromJoin($data);
                $result[$key]->count = count($r);
            }
            $total_product = [];
            foreach ($result as $key => $row) {
                $total_product[$key] = $row->count;
            }
            array_multisort($total_product, SORT_DESC, $result);
            if ($result) {
                $response['success'] = 1;
                $response['message'] = 'subcategory Data';
                $response["data"] = $result;
            } else {
                $response['success'] = 1;
                $response['message'] = "No Match found";
            }
        } else {
            $response['success'] = 0;
            $response['message'] = "No Vednor";
        }
        return $response;
    }
    function brand_list($postdata) {
        if (isset($postdata['category_id']) && $postdata['category_id'] != '') {
            $category_id = $postdata['category_id'];
            $data['select'] = ['*'];
            $data['where'] = ['category_id  IN (' . $category_id . ') AND status !=' => '9'];
            $data['table'] = 'brand';
            $result = $this->selectRecords($data);
            if ($result) {
                $response['success'] = 1;
                $response['message'] = 'subcategory Data';
                $response["data"] = $result;
            } else {
                $response['success'] = 1;
                $response['message'] = "No Match found";
            }
        } else {
            $response['success'] = 0;
            $response['message'] = "No Vednor";
        }
        return $response;
    }
    //check register
    function check_register($email) {
        $data['select'] = ['*'];
        $data['where'] = ['email' => $email];
        $data['table'] = 'user';
        $result = $this->selectRecords($data);
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
    function update_device($userdata, $postData) {
        $user_id = $userdata['id'];
        if(!isset($postData['device_token'])&&$postData['device_token']==''){
            return false;
        }
        $this->delete_token($user_id, $postData['device_token']);
        // $tokenData = $this->tokenGenrate($userdata, $postData['login_type']);
        $chekcDevice = $this->checkDevice($postData['device_id']);
        if (!empty($chekcDevice)) {
            $data['update']['user_id'] = $user_id;
            $data['update']['device_id'] = $postData['device_id'];
            $data['update']['token'] = $postData['device_token'];
            $data['update']['type'] = $postData['device_type'];
            $data['update']['dt_updated'] = date('Y-m-d h:i:s');
            $data['where'] = ['device_id' => $postData['device_id']];
            $data['table'] = "device";
            $re = $this->updateRecords($data);
        } else {
            $data['insert']['user_id'] = $user_id;
            $data['insert']['device_id'] = $postData['device_id'];
            $data['insert']['token'] = $postData['device_token'];
            $data['insert']['type'] = $postData['device_type'];
            $data['insert']['dt_created'] = date('Y-m-d h:i:s');
            $data['table'] = "device";
            $re = $this->insertRecord($data);
        }
        return true;
    }
    function checkDevice($postData) {
        $data['select'] = ['id'];
        $data['where'] = ['device_id' => $postData];
        $data['table'] = "device";
        $result = $this->countRecords($data);
        return $result;
    }
    function tokenGenrate($result, $loginType) {
        //      $token = md5('user_' . time());
        //      $data['update']['token'] = $token;
        //      $data['where'] = ['id' => $user_id];
        //      $data['table'] = "user";
        //      $updateRecord = $this->updateRecords($data);
        // return $data;
        
    }
    function delete_token($user_id, $device_id = null) {
        $data['where']['user_id'] = $user_id;
        $data['table'] = "device";
        $this->deleteRecords($data);
        unset($data);
        $data['where']['device_id'] = $device_id;
        $data['table'] = "device";
        $this->deleteRecords($data);
        return true;
    }
    function get_total($postdata) {
        if (isset($postdata['user_id']) && $postdata['user_id'] != '') {
            $user_id = $postdata['user_id'];
        } else {
            if (isset($postdata['device_id'])) {
                $device_id = $postdata['device_id'];
            }
        }
        $data['select'] = ['sum(calculation_price) AS total', 'count(id) AS cart_items'];
        if (isset($user_id) && $user_id != 0 && $user_id != '') {
            $data['where'] = ['user_id' => $user_id];
        } else {
            if (isset($device_id)) {
                $data['where'] = ['device_id' => $device_id, 'user_id' => 0];
            }
        }
        $data['table'] = 'my_cart';
        $result = $this->selectRecords($data);
        return $result;
    }
    function get_actual_total($postdata) {
        if (isset($postdata['user_id']) && $postdata['user_id'] != '') {
            $user_id = $postdata['user_id'];
        } else {
            if (isset($postdata['device_id'])) {
                $device_id = $postdata['device_id'];
            }
        }
        $data['select'] = ['*'];
        if (isset($user_id) && $user_id != 0 && $user_id != '') {
            $data['where'] = ['user_id' => $user_id];
        } else {
            if (isset($device_id)) {
                $data['where'] = ['device_id' => $device_id, 'user_id' => 0];
            }
        }
        $data['table'] = 'my_cart';
        $result = $this->selectRecords($data);
        $gettotal = 0;
        foreach ($result as $key => $value) {
            $quantity = $value->quantity;
            $actual_price = $value->actual_price;
            $total = $quantity * $actual_price;
            $gettotal = $total + $gettotal;
        }
        return $gettotal;
    }
    public function gstCalculation($postData) {
        $user_id = $postData['user_id'];
        $data['table'] = 'my_cart';
        $data['select'] = ['*'];
        $data['where'] = ['user_id' => $user_id];
        $result = $this->selectRecords($data);
        $total_gst = 0;
        foreach ($result as $key => $value) {
            $gst = $this->getProductGst($value->product_id);
            $gst_amount = ($value->discount_price * $gst) / 100;
            $total_gst+= $gst_amount * $value->quantity;
        }
        return $total_gst;
    }
    function filter($postdata) {
        $vendor_id = $postdata['vendor_id'];
        $sort = $postdata['filter_search'];
        if (isset($postdata['offset'])) {
            $offset = $postdata['offset'];
        }
        if (isset($postdata['category_id'])) {
            $category_id = $postdata['category_id'];
        }
        if (isset($postdata['user_id'])) {
            $user_id = $postdata['user_id'];
        }
        if (isset($postdata['discount_id'])) {
            $discount_id = $postdata['discount_id'];
        }
        if (isset($postdata['brand_id'])) {
            $brand_id = $postdata['brand_id'];
        }
        if (isset($postdata['price_id'])) {
            $price_id = $postdata['price_id'];
        }
        if (isset($postdata['device_id'])) {
            $device_id = $postdata['device_id'];
        }
        if (isset($postdata['subcategory_id'])) {
            $subcategory_id = $postdata['subcategory_id'];
        }
        $data_where = array();
        $data_pwwhere = array();
        if (isset($price_id) && $price_id != '') {
            $price_id = explode(',', $price_id);
            $data['select'] = ['*'];
            $data['where'] = ['status !=' => '9'];
            $data['where_in'] = ['id' => $price_id, ];
            $data['table'] = 'price';
            $data['order'] = 'id DESC';
            $price_result = $this->selectRecords($data);
            // print_r($price_result[0]->start_price);exit;
            // echo $this->db->last_query();
            // $start_price = array();
            // $end_price = array();
            $pricewhere = '(';
            $pwwhere = '(';
            foreach ($price_result as $key => $row) {
                // $start_price[$key] = $row->start_price;
                // $end_price[$key] = $row->end_price;
                $pricewhere.= "(w.discount_price >='" . $row->start_price . "' AND w.discount_price <= '" . $row->end_price . "') OR";
                $pwwhere.= "(discount_price >='" . $row->start_price . "' AND discount_price <= '" . $row->end_price . "') OR";
            }
            if (in_array("999", $price_id)) {
                unset($data);
                $data['select'] = ['max(end_price) as end_price'];
                $data['table'] = 'price';
                $data['where'] = ['status !=' => '9'];
                $data['order'] = 'id DESC';
                $selectmax = $this->selectRecords($data);
                // echo $this->db->last_query();
                $pricewhere.= "(w.discount_price >='" . $selectmax[0]->end_price . "') OR";
                $pwwhere.= "(discount_price >='" . $selectmax[0]->end_price . "') OR";
                // echo $pwwhere;die;
                
            }
            $pricewhere = rtrim($pricewhere, 'OR');
            $pricewhere.= ') AND';
            $data_where[$pricewhere] = "1=1";
            $pwwhere = rtrim($pwwhere, 'OR');
            $pwwhere.= ') AND';
            $data_pwwhere[$pwwhere] = "1=1";
            // array_multisort($start_price, SORT_ASC, $price_result);
            // array_multisort($end_price, SORT_DESC, $price_result);
            //             $data_where['w.discount_price >='] =  $start_price[0];
            //             $data_where['w.discount_price <='] =  $end_price[0];
            
        }
        if (isset($discount_id) && $discount_id != '') {
            $discount_id = explode(',', $discount_id);
            $data['select'] = ['*'];
            $data['where'] = ['status !=' => '9'];
            $data['where_in'] = ['id' => $discount_id, ];
            $data['table'] = 'discount';
            $data['order'] = 'id DESC';
            $discount_result = $this->selectRecords($data);
            // echo $this->db->last_query();
            //      print_r($discount_result);exit;
            $start_discount = array();
            $end_discount = array();
            $diswhere = '(';
            $dwwhere = '(';
            foreach ($discount_result as $key => $row) {
                // $start_discount[$key] = $row->start_discount;
                // $end_discount[$key] = $row->end_discount;
                $diswhere.= "(w.discount_per >='" . $row->start_discount . "' AND w.discount_per <= '" . $row->end_discount . "') OR";
                $dwwhere.= "(discount_per >='" . $row->start_discount . "' AND discount_per <= '" . $row->end_discount . "') OR";
            }
            $diswhere = rtrim($diswhere, 'OR');
            $diswhere.= ') AND';
            $data_where[$diswhere] = "1=1";
            $dwwhere = rtrim($dwwhere, 'OR');
            $dwwhere.= ') AND';
            $data_pwwhere[$dwwhere] = "1=1";
            // print_r($data_where);exit;
            // array_multisort($start_discount, SORT_ASC, $discount_result);
            // array_multisort($end_discount, SORT_DESC, $discount_result);
            // $data_where['w.discount_per >='] =  $start_discount[0];
            //   $data_where['w.discount_per <='] =  $end_discount[0];
            // print_r(expression)
            
        }
        $data_where_in = array();
        if (isset($brand_id) && $brand_id != '') {
            $brand_id = explode(",", $brand_id);
            $data_where_in['p.brand_id'] = $brand_id;
            // $data['where'] = ['category_id  IN ('.$category_id.') AND status !=' => '9'];
            
        }
        unset($data);
        $data['select'] = ['p.*', 'max(w.discount_price) AS maxdis', 'min(w.discount_price) AS mindis'];
        $data['table'] = 'product AS p';
        $data['join'] = ['product_weight  AS w' => ['w.product_id = p.id', 'LEFT']];
        $data_where['p.status !='] = '9';
        $data_where['p.vendor_id'] = $vendor_id;
        $data_where['w.discount_price !='] = '';
        $data_where['w.status !='] = '9';
        if (isset($category_id)) {
            $data_where['p.category_id'] = $category_id;
        }
        if (isset($subcategory_id)) {
            $data_where['p.subcategory_id'] = $subcategory_id;
        }
        $data['where'] = $data_where;
        // print_r($data);exit;
        $data['where_in'] = $data_where_in;
        $data['groupBy'] = 'id';
        if ($sort == 'low_high') {
            $data["order"] = 'min(w.discount_price) * 1 ASC';
        }
        if ($sort == 'high_low') {
            $data["order"] = 'max(w.discount_price) * 1 DESC';
        }
        $cal = 1;
        if ($offset >= 1) {
            $data['limit'] = "10";
            if ($offset != 1) {
                $cal = $offset - 1;
            }
            $data['skip'] = $cal * 10;
        } else {
            $data['limit'] = "10";
        }
        // print_r($data);exit;
        $result = $this->selectFromJoin($data);
        // echo $this->db->last_query();exit;
        // print_r($result);exit;
        unset($data['limit']);
        unset($data['skip']);
        $count = $this->selectFromJoin($data, true);
        $total_count = count($count);
        if (count($result) > 0) {
            $counter = 0;
            foreach ($result as $row) {
                // print_r($data_pwwhere);exit;
                $product_id = $row->id;
                unset($data);
                $data['select'] = ['*'];
                $data_pwwhere['status !='] = '9';
                $data_pwwhere['product_id'] = $product_id;
                $data_pwwhere['vendor_id'] = $vendor_id;
                $data['where'] = $data_pwwhere;
                $data['table'] = 'product_weight';
                if ($sort == 'low_high') {
                    $data["order"] = 'discount_price ASC';
                } else if ($sort == 'high_low') {
                    $data["order"] = 'discount_price DESC';
                } else {
                    $data['order'] = 'id DESC';
                }
                $product_weight_result = $this->selectRecords($data);
                // echo $this->db->last_query();exit;
                if ($counter == 3) {
                }
                // print_r($product_image_result);exit;
                $new_array_product_weight = array();
                foreach ($product_weight_result as $pro_weight) {
                    $package_id = $pro_weight->package;
                    $package_name = $this->get_package($package_id);
                    $weight_id = $pro_weight->weight_id;
                    $product_weight_id = $pro_weight->id;
                    unset($data);
                    $data['select'] = ['*'];
                    $data['where'] = ['status !=' => '9', 'product_id' => $product_id, 'vendor_id' => $vendor_id, 'product_variant_id' => $product_weight_id];
                    $data['table'] = 'product_image';
                    $data['order'] = 'id DESC';
                    $product_image_result = $this->selectRecords($data);
                    unset($data);
                    $data['select'] = ['name'];
                    $data['where'] = ['id' => $weight_id, ];
                    $data['table'] = 'weight';
                    $weight_result = $this->selectRecords($data, true);
                    // print_r($weight_id);exit;
                    $weight_name = $weight_result[0]['name'];
                    $data['select'] = ['quantity'];
                    if (isset($user_id) && isset($device_id)) {
                        $data['where'] = ['product_id' => $product_id, 'weight_id' => $weight_id, 'user_id' => $user_id, 'device_id' => $device_id];
                    } else if (isset($user_id) || isset($device_id)) {
                        $data['where'] = ['product_id' => $product_id, 'weight_id' => $weight_id, ];
                        $data['where_or'] = ['user_id' => $user_id, 'device_id' => $device_id];
                    }
                    $data['table'] = 'my_cart';
                    $my_cart_result = $this->selectRecords($data, true);
                    if (count($my_cart_result) <= 0) {
                        $my_cart_result = array();
                        $my_cart_quantity = '0';
                    } else {
                        $my_cart_quantity = $my_cart_result[0]['quantity'];
                    }
                    $data = array('id' => $pro_weight->id, 'product_id' => $pro_weight->product_id, 'weight_id' => $pro_weight->weight_id, 'unit' => $pro_weight->weight_no . ' ' . $weight_name, 'actual_price' => $pro_weight->price, 'quantity' => $pro_weight->quantity, 'package_name' => $package_name, 'discount_per' => $pro_weight->discount_per, 'discount_price' => $pro_weight->discount_price, 'my_cart_quantity' => $my_cart_quantity, 'variant_image' => base_url() . 'public/images/product_image/' . $product_image_result[0]->image,);
                    array_push($new_array_product_weight, $data);
                }
                $product_weight_array = $new_array_product_weight;
                $new_array_product_image = array();
                foreach ($product_image_result as $pro_image) {
                    $data = array('id' => $pro_image->id, 'product_id' => $pro_image->product_id, 'image' => base_url() . 'public/images/product_image/' . $pro_image->image, 'thumb_image' => base_url() . 'public/images/product_image_thumb/' . $pro_image->image,);
                    array_push($new_array_product_image, $data);
                }
                $product_image_array = $new_array_product_image;
                $proimg = $product_image_result[0]->image;
                $prothimg = $product_image_result[0]->image;
                // echo $row->id;exit;
                $set_data = array();
                $set_data['id'] = $row->id;
                $set_data['category_id'] = $row->category_id;
                $set_data['brand_id'] = $row->brand_id;
                $set_data['name'] = $row->name;
                $set_data['image'] = base_url() . 'public/images/product_image/' . $proimg;
                $set_data['image_thumb'] = base_url() . 'public/images/product_image_thumb/' . $prothimg;
                $set_data['about'] = $row->about;
                $set_data['content'] = $row->content;
                $set_data['status'] = $row->status;
                $set_data['dt_added'] = $row->dt_added;
                $set_data['dt_updated'] = $row->dt_updated;
                $set_data['product_weight'] = $product_weight_array;
                $set_data['product_image'] = $product_image_array;
                $getdata[] = $set_data;
                $counter++;
                // print_r($set_data);exit;
                
            }
            $response['success'] = "1";
            $response['message'] = "Product list";
            $response["count"] = $total_count;
            $response["data"] = $getdata;
            echo $output = json_encode(array('responsedata' => $response));
        } else {
            $response = array();
            $response["success"] = 0;
            $response["message"] = "No record found";
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
    }
    function add_to_cart($postdata) {
        $product_id = $postdata['product_id'];
        $weight_id = $postdata['weight_id'];
        $quantity = $postdata['quantity'];
        $product_weight_id = $postdata['product_weight_id'];
        $vendor_id = $postdata['vendor_id'];
        if (isset($postdata['user_id']) && $postdata['user_id'] != ''&& $postdata['user_id'] != 0) {
            $user_id = $postdata['user_id'];
        } else {
            $user_id = 0;
        }
        
        $device_id = $postdata['device_id'];
        $cart_count = 0;
        $product_actual_price = 0;
        $my_cal = 0;
        $product_calculation_price = 0;
        $discount_price_total = 0;
        $data['select'] = ['*'];
        if (isset($user_id) && $user_id != '' && $user_id != 0) {
            $data['where']['user_id'] = $user_id;
        }
        if ((!isset($user_id) || $user_id == ''|| $user_id == 0) && isset($postdata['device_id'])) {
            $data['where']['device_id'] = $device_id;
            $data['where']['user_id'] = 0;
        }
        $data['where']['product_id'] = $product_id;
        $data['where']['vendor_id'] = $vendor_id;
        $data['where']['product_weight_id'] = $product_weight_id;
        $data['where']['weight_id'] = $weight_id;
        $data['table'] = 'my_cart';
        $pro_available_query = $this->selectRecords($data);
        // ECHO $this->db->last_query();exit;
        unset($data);
        $data['select'] = ['*'];
        $data['where']['id'] = $product_weight_id;
        $data['where']['status !='] = '9';
        $data['where']['vendor_id'] = $vendor_id;
        $data['table'] = 'product_weight';
        $product_weight_result = $this->selectRecords($data, true);
        $actual_price = $product_weight_result[0]['price'];
        $actual_quantity = $product_weight_result[0]['quantity'];
        $discount_per = $product_weight_result[0]['discount_per'];
        $discount_price = $product_weight_result[0]['discount_price'];
        $calculation_price_ = $quantity * $discount_price;
        $calculation_price = number_format((float)$calculation_price_, 2, '.', '');
        $dt_updated = strtotime(date('Y-m-d H:i:s'));
        if (count($pro_available_query) > 0) {
            unset($data);
            $update = array('device_id' => $device_id, 'user_id' => $user_id, 'product_id' => $product_id, 'weight_id' => $weight_id, 'quantity' => $quantity, 'calculation_price' => $calculation_price, 'dt_updated' => $dt_updated);
            $data['update'] = $update;
            $data['where']['product_id'] = $product_id;
            $data['where']['vendor_id'] = $vendor_id;
            $data['where']['product_weight_id'] = $product_weight_id;
            $data['where']['weight_id'] = $weight_id;
            if (isset($user_id) && $user_id != '' && $user_id != 0) {
                $data['where']['user_id'] = $user_id;
            }
            if ((!isset($user_id) || $user_id == ''|| $user_id == 0) && isset($postdata['device_id'])) {
                $data['where']['device_id'] = $device_id;
                $data['where']['user_id'] = 0;
            }
            $data['table'] = 'my_cart';
            $updatecart = $this->updateRecords($data);
        } else {
            $insertion = array('vendor_id' => $vendor_id, 'device_id' => $device_id, 'product_weight_id' => $product_weight_id, 'user_id' => $user_id, 'product_id' => $product_id, 'weight_id' => $weight_id, 'quantity' => $quantity, 'actual_price' => $actual_price, 'actual_quantity' => $actual_quantity, 'discount_per' => $discount_per, 'discount_price' => $discount_price, 'calculation_price' => $calculation_price, 'status' => '1', 'dt_added' => strtotime(date('Y-m-d H:i:s')), 'dt_updated' => strtotime(date('Y-m-d H:i:s')),);
            $data['insert'] = $insertion;
            $data['table'] = 'my_cart';
            $insertcart = $this->insertRecord($data);
        }
        unset($data);
        $data['update']['temp_quantity'] = $quantity;
        $data['where']['id'] = $product_weight_id;
        $data['table'] = 'product_weight';
        $this->updateRecords($data);
        // echo$this->db->last_query();exit;
        return true;
    }
    function get_package($id) {
        $package_name = "";
        if (count($id) > 0) {
            $data['select'] = ['*'];
            $data['where'] = ['id' => $id];
            $data['table'] = 'package';
            $package = $this->selectRecords($data);
            if (count($package) > 0) {
                $package_name = $package[0]->package;
            }
        }
        return $package_name;
    }
    function update_my_cart($arr) {
        foreach ($arr as $row) {
            //            print_r($row);exit;
            $id = $row->id;
            $p_id = $row->product_weight_id;
            $quantity = $row->quantity;
            $data['select'] = ['price', 'discount_price', 'discount_per'];
            $data['where'] = ['id' => $p_id];
            $data['table'] = 'product_weight';
            $res = $this->selectRecords($data, true);
            $actual_price = $res[0]['price'];
            $discount_price = $res[0]['discount_price'];
            $discount_per = $res[0]['discount_per'];
            $calculation_price = $discount_price * $quantity;
            //            print_r($res);exit;
            unset($data);
            $data['update']['actual_price'] = $actual_price;
            $data['update']['discount_per'] = $discount_per;
            $data['update']['discount_price'] = $discount_price;
            $data['update']['calculation_price'] = $calculation_price;
            $data['where'] = ['id' => $id];
            $data['table'] = 'my_cart';
            $this->updateRecords($data);
            //            echo $this->db->last_query();
            //            exit;
            
        }
    }

    function check_udpate_quantity($variant_id,$cart_qty){
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$variant_id];
        $data['table'] = 'product_weight';
        $get_variant = $this->selectRecords($data);
        if(count($get_variant) >0){
            $quantity = (int)$get_variant[0]->quantity;
            if((int)$cart_qty>$quantity){
                return false;
            }
            $updatedQTY = $quantity - $cart_qty;
            if($updatedQTY <= 0){
                unset($data);
                $data['where'] = ['product_weight_id'=>$variant_id];
                $data['table'] = 'my_cart';
                $this->deleteRecords($data);
            }
            return $updatedQTY;
        }
        return false;        
    }
    //user cart
    function my_cart($postdata) {
        $i = 0;
        hd:
            $actual_price_total = 0;
            $discount_price_total = 0;
            if (isset($postdata['user_id']) && $postdata['user_id'] != ''&& $postdata['user_id'] != 0) {
                $user_id = $postdata['user_id'];
            } else {
                $user_id = 0;
            }
            if (isset($postdata['device_id'])) {
                $device_id = $postdata['device_id'];
            }
            $data['select'] = ['*'];
            if (isset($user_id) && $user_id != '') {
                $data['where']['user_id'] = $user_id;
            }
            if ((!isset($user_id) || $user_id == ''|| $user_id == 0) && isset($device_id)) {
                $data['where']['device_id'] = $device_id;
                $data['where']['user_id'] = 0;
            }
            $data['table'] = 'my_cart';
            $my_cart_result = $this->selectRecords($data);
            if ($i == 0) {
                $this->update_my_cart($my_cart_result);
            }
            $i++;
            if ($i == 1) {
                goto hd;
            }
            //        print_r($my_cart_result);exit;
            // print_r($postdata);
            // echo $this->db->last_query();exit;
            $counter = 0;
            $total_gst = 0;
            if (count($my_cart_result) > 0) {
                foreach ($my_cart_result as $row) {
                    $product_weight_id = $row->product_weight_id;
                    $product_id = $row->product_id;
                    $weight_id = $row->weight_id;
                    unset($data);
                    $data['select'] = ['*'];
                    $data['where'] = ['status !=' => '9', 'product_id' => $product_id, 'product_variant_id' => $product_weight_id];
                    $data['table'] = 'product_image';
                    $data['order'] = 'id DESC';
                    $product_image_result = $this->selectRecords($data);
                    $proimg = base_url() . 'public/images/product_image/' . $product_image_result[0]->image;
                    $prothimg = base_url() . 'public/images/product_image_thumb/' . $product_image_result[0]->image;
                    unset($data);
                    $data['select'] = ['pw.*', 'p.name as product_name', 'p.image as product_image', 'w.name as product_weight_name', 'p.gst'];
                    $data['where'] = ['pw.id' => $product_weight_id, 'pw.status !=' => '9'];
                    $data['table'] = 'product_weight as pw';
                    $data['join'] = ['product  AS p' => ['p.id = pw.product_id', 'LEFT'], 'weight  AS w' => ['w.id = pw.weight_id', 'LEFT'], ];
                    $product_weight_result = $this->selectFromJoin($data, true);
                    $package_id = $product_weight_result[0]['package'];
                    $package_name = $this->get_package($package_id);
                    $product_unit = $product_weight_result[0]['weight_no'];
                    $product_name = $product_weight_result[0]['product_name'];
                    $product_image = $product_weight_result[0]['product_image'];
                    $product_weight_name = $product_weight_result[0]['product_weight_name'];
                    $product_actual_price = $product_weight_result[0]['price'];
                    $product_discount_price = $product_weight_result[0]['discount_price'];
                    $gst = $product_weight_result[0]['gst'];
                    $gst_amount = ($product_discount_price * $gst) / 100;
                    $total_gst+= $gst_amount * $row->quantity;
                    $discount_price_total = ($product_actual_price * $row->quantity) - $row->calculation_price + $discount_price_total;
                    unset($data);
                    $data = array();
                    $data['id'] = $row->id;
                    $data['device_id'] = $row->device_id;
                    $data['user_id'] = $row->user_id;
                    $data['vendor_id'] = $row->vendor_id;
                    $data['product_weight_id'] = $row->product_weight_id;
                    $data['product_unit'] = $product_unit . ' ' . $product_weight_name;
                    $data['product_name'] = $product_name;
                    $data['product_actual_price'] = $product_actual_price;
                    $data['product_discount_price'] = $product_discount_price;
                    $data['discount_per'] = $row->discount_per;
                    $data['product_image'] = $proimg;
                    $data['package_name'] = $package_name;
                    $data['product_image_thumb'] = $prothimg;
                    $data['product_id'] = $row->product_id;
                    $data['weight_id'] = $row->weight_id;
                    $data['quantity'] = $row->quantity;
                    $data['status'] = $row->status;
                    $data['dt_added'] = $row->dt_added;
                    $data['dt_updated'] = $row->dt_updated;
                    $data['gst_amount_per_product'] = number_format((float)$gst_amount, '2', '.', '');
                    $getdata[] = $data;
                    $counter++;
                    $actual_price_total = $row->quantity * $product_actual_price + $actual_price_total;
                }
                $gettotal = $this->get_total($postdata);
                $getactual = $this->get_actual_total($postdata);
                $my_cal = $gettotal[0]->total;
                if ($my_cal === null || $my_cal == "<null>") {
                    $my_cal = 0.0;
                }
                if ($getactual === null || $getactual == "<null>") {
                    $getactual = 0.0;
                }
                $response['success'] = "1";
                $response['message'] = "My cart item list";
                $response["count"] = $gettotal[0]->cart_items;
                $response["actual_price_total"] = $getactual;
                $response["discount_price_total"] = number_format((float)$getactual - $my_cal, '2', '.', '');
                $response["total_price"] = $my_cal;
                $response["TotalGstAmount"] = number_format((float)$total_gst, '2', '.', '');
                $response["amountWithoutGst"] = number_format((float)$my_cal - $total_gst, '2', '.', '');
                $response["data"] = $getdata;
                echo $output = json_encode(array('responsedata' => $response));
                exit;
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "No record found";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
        }
        public function getProductGst($id) {
            $data['table'] = TABLE_PRODUCT;
            $data['select'] = ['gst'];
            $data['where'] = ['status!=' => '9', 'id' => $id];
            $result = $this->selectRecords($data);
            return $result[0]->gst;
        }
        //set cart to user from device
        function set_user_cart($postdata) {
            $user_id = $postdata['user_id'];
            $device_id = $postdata['device_id'];
            $data['select'] = ['vendor_id'];
            $data['where'] = ['user_id' => $user_id];
            $data['table'] = 'my_cart';
            $get_cart_user = $this->selectRecords($data);
            //delete when user add from different vendor
            $data['select'] = ['vendor_id'];
            $data['where'] = ['device_id' => $device_id, 'user_id' => 0];
            $data['table'] = 'my_cart';
            $get_cart_device = $this->selectRecords($data);
            if (count($get_cart_device) > 0 && count($get_cart_user) > 0) {
                if ($get_cart_device[0]->vendor_id != $get_cart_user[0]->vendor_id) {
                    unset($data);
                    $data['where'] = ['user_id' => $user_id];
                    $data['table'] = 'my_cart';
                    $this->deleteRecords($data);
                }
            }
            unset($data);
            $data['update'] = ['user_id' => $user_id];
            $data['where'] = ['device_id' => $device_id, 'user_id' => 0];
            $data['table'] = 'my_cart';
            $result = $this->updateRecords($data);
            $data['select'] = ['*'];
            $data['where'] = ['user_id' => $user_id];
            $data['table'] = 'my_cart';
            $select = $this->selectRecords($data);
            foreach ($select as $key => $value) {
                $set = array($value->id, $value->product_weight_id, $value->quantity,);
                $get[] = $set;
            }
            if (isset($get)) {
                $colors = $materials = array();
                foreach ($get as $a) {
                    $materials[] = $a[1];
                }
                $materials = array_count_values($materials);
                foreach ($materials as $duplicate => $value) {
                    if ($value > 1) {
                        unset($data);
                        $data['select'] = ['count(quantity) AS total', 'id', 'sum(calculation_price) AS calculation_price', 'count(discount_price) AS discount_price'];
                        $data['where'] = ['user_id' => $user_id, 'product_weight_id' => $duplicate];
                        $data['table'] = 'my_cart';
                        $gettotal = $this->selectRecords($data);
                        $gettotalqu = $gettotal[0]->total;
                        $updateid = $gettotal[0]->id;
                        unset($data);
                        $data['update'] = ['quantity' => $gettotalqu, 'calculation_price' => $gettotal[0]->calculation_price, ];
                        $data['where'] = ['id' => $updateid, 'user_id' => $user_id];
                        $data['table'] = 'my_cart';
                        $result = $this->updateRecords($data);
                        unset($data);
                        $data['where'] = ['user_id' => $user_id, 'product_weight_id' => $duplicate, 'id !=' => $updateid];
                        $data['table'] = 'my_cart';
                        $this->deleteRecords($data);
                    }
                }
            }
            return true;
        }
        function get_filter($postdata) {
            $data['select'] = ['id', 'start_price', 'end_price', 'status', 'dt_added', 'dt_updated'];
            $data['table'] = 'price';
            $data['where'] = ['status !=' => '9'];
            $data['order'] = 'start_price ASC,end_price DESC';
            $result = $this->selectRecords($data, true);
            // $price_array = ['-1'=>$result[0]->start_price .' and Less'];
            $lv = count($result);
            foreach ($result as $key => $value) {
                if ($value['start_price'] == '0') {
                    $result[$key]['start_price'] = $result[$key]['end_price'];
                    $result[$key]['end_price'] = 'Below';
                }
            }
            $result[$lv] = ["id" => "999", "start_price" => $result[$lv - 1]['end_price'], "end_price" => "Above", "status" => "1", "dt_added" => "1626157746", "dt_updated" => "1626157746"];
            // print_r($lv);die;
            $total_count = $this->countRecords($data);
            //        $return= array();
            if (count($result) > 0) {
                // $return[]["price_count"] = $total_count;
                $return[0]["filter_name"] = 'Price';
                $return[0]["data"] = $result;
            }
            unset($data);
            unset($getdata);
            $data['select'] = ['id', 'start_discount', 'end_discount', 'status', 'dt_added', 'dt_updated'];
            $data['table'] = 'discount';
            $data['where'] = ['status !=' => '9'];
            $result = $this->selectRecords($data);
            $total_count = $this->countRecords($data);
            if (count($result) > 0) {
                // $return[]["discount_count"] = $total_count;
                $return[1]["filter_name"] = 'Discount';
                $return[1]["data"] = $result;
            }
            if (isset($postdata['category_id']) && $postdata['category_id'] != '') {
                $category_id = $postdata['category_id'];
                unset($data);
                $data['select'] = ['id', 'name', 'dt_added', 'dt_updated'];
                $data['where'] = ['category_id  IN (' . $category_id . ') AND status !=' => '9'];
                $data['table'] = 'brand';
                $result = $this->selectRecords($data);
                // echo $this->db->last_query();exit;
                $total_count = $this->countRecords($data);
                //            if(count($result) > 0){
                $counter = 0;
                unset($data);
                unset($getdata);
                // $return[]["brand_count"] = $total_count;
                $return[2]["filter_name"] = 'Brand';
                $return[2]["data"] = $result;
                //            }
                
            }
            // print_r($return);exit;
            $return[3]["filter_name"] = 'Sort By';
            $data_sort[] = ['title' => 'Price High To Low', 'name' => 'high_low'];
            $data_sort[] = ['title' => 'Price Low To High', 'name' => 'low_high'];
            $return[3]['data'] = $data_sort;
            $return = array_values($return);
            return $return;
        }
        function delete_cart($postdata) {
            if (isset($postdata['user_id']) && $postdata['user_id'] != '') {
                $user_id = $postdata['user_id'];
            } else {
                $user_id = '';
            }
            if (isset($postdata['device_id'])) {
                $device_id = $postdata['device_id'];
            }
            $product_weight_id = $_REQUEST['product_weight_id'];
            if (isset($user_id) && $user_id != '') {
                $data['where']['user_id'] = $user_id;
                $data['where']['product_weight_id'] = $product_weight_id;
                $data['table'] = 'my_cart';
                $my_cart_result = $this->deleteRecords($data);
            }
            if ((!isset($user_id) || $user_id == '') && isset($device_id)) {
                $data['where']['device_id'] = $device_id;
                $data['where']['user_id'] = 0;
                $data['where']['product_weight_id'] = $product_weight_id;
                $data['table'] = 'my_cart';
                $my_cart_result = $this->deleteRecords($data);
            }
            return true;
        }
        //update quantity when checkout
        function update_quantity($product_weight_id, $quantity) {
            $data['update'] = ['quantity' => $quantity, 'temp_quantity' => '0'];
            $data['where']['id'] = $product_weight_id;
            $data['table'] = 'product_weight';
            $this->updateRecords($data);
            return true;
        }
        //check profit persentage %%
        function get_profit_per() {
            $data['select'] = ['value'];
            $data['where'] = ['request_id' => '2'];
            $data['table'] = 'set_default';
            $result = $this->selectRecords($data);
            if (count($result) > 0) {
                return $result[0]->value;
            }
        }
        //insert profit after checkout
        function insert_profit($order_id, $order_d_id, $vendor_id, $total_profit) {
            $date = date('Y-m-d H:i:s');
            $data['insert'] = array('order_id' => $order_id, 'order_detail_id' => $order_d_id, 'vendor_id' => $vendor_id, 'total_profit' => $total_profit, 'dt_created' => $date, 'dt_updated' => $date);
            $data['table'] = 'profit';
            $this->insertRecord($data);
        }
        function get_delivery_charge($lat, $long, $vendor_id) {
            $data['select'] = ['latitude', 'longitude'];
            $data['table'] = 'vendor';
            $data['where'] = ['id' => $vendor_id];
            $get_vandor_address = $this->selectRecords($data);
            $getkm = $this->circle_distance($lat, $long, $get_vandor_address[0]->latitude, $get_vandor_address[0]->longitude);
            $getkm = round($getkm);
            unset($data);
            $data['select'] = ['price'];
            $data['table'] = 'delivery_charge';
            $data['where'] = ['start_range <=' => $getkm, 'end_range >=' => $getkm];
            $get_range = $this->selectRecords($data);
            // echo $this->db->last_query();exit;
            if (count($get_range)) {
                return $get_range[0]->price;
            } else {
                return 'N';
            }
        }
        function circle_distance($lat1, $lon1, $lat2, $lon2) {
            $rad = 3.14 / 180;
            return acos(sin($lat2 * ($rad)) * sin($lat1 * $rad) + cos($lat2 * $rad) * cos($lat1 * $rad) * cos($lon2 * $rad - $lon1 * $rad)) * 6371;
        }
        //update notification status
        //update notification status
        function notification_status($id) {
            $data['select'] = ['notification_status'];
            $data['where'] = ['id' => $id];
            $data['table'] = "user";
            $response = $this->selectRecords($data, true);
            return $response[0]['notification_status'];
        }
        function push_notify($postData) {
            if (isset($postData['status'])) {
                if ($postData['status'] == '') {
                    $data['select'] = ['notification_status'];
                    $data['where'] = ['id' => $postData['user_id']];
                    $data['table'] = "user";
                    $response = $this->selectRecords($data, true);
                } else {
                    $data['select'] = ['notification_status'];
                    $data['where'] = ['id' => $postData['user_id']];
                    $data['table'] = "user";
                    $result = $this->selectRecords($data, true);
                    unset($data);
                    $notification = $result[0]['notification_status'];
                    if ($notification != $postData['status']) {
                        unset($result);
                        $data['update']['notification_status'] = $postData['status'];
                        $data['where'] = ['id' => $postData['user_id']];
                        $data['table'] = "user";
                        $result = $this->updateRecords($data);
                        if ($result) {
                            $response['success'] = 1;
                            $response['message'] = 'Notification Status Updated';
                        } else {
                            $response['success'] = 1;
                            $response['message'] = 'Notification Status Is Not Updated';
                        }
                    } else {
                        $response['success'] = 1;
                        $response['message'] = 'Please Update status';
                    }
                    return $response;
                }
            } else {
                $response = array('status' => '0', 'message' => 'invalid parameters  ');
            }
            return $response;
        }
        public function verify_mobile($postData) {
            $user_id = $postData['user_id'];
            $country_code = $postData['country_code'];
            $mobile = $postData['phone'];
            $mobile_number = $country_code . $mobile;
            $generator = "135792468";
            $otp = "";
            for ($i = 1;$i <= 4;$i++) {
                $otp.= substr($generator, (rand() % (strlen($generator))), 1);
            }
            $data = array('otp' => $otp, 'dt_updated' => strtotime(date('Y-m-d H:i:s')),);
            $res = $this->db->update("user", $data, array("id" => $postData['user_id']));;
            // $this->sendOtp($mobile_number,$otp);
            if ($res) {
                $response = array();
                $response["success"] = 1;
                $response["message"] = "Your otp is successfully sent";
                $response["otp"] = $otp;
                return $response;
            }
        }
        public function sendOtp($mobile_number, $otp) {
            // print_r($mobile_number);die;
            $apiKey = urlencode(TEXT_MESSAGE_API_KEY);
            // Message details
            $numbers = array($mobile_number);
            $sender = urlencode('TXTLCL');
            $message = rawurlencode('Your OTP for mobile verification is : ' . $otp . ' Thanks');
            $numbers = implode(',', $numbers);
            // Prepare data for POST request
            $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
            // Send the POST request with cURL
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            // Process your response here
            // echo $response;
            print_r($response);
            die;
        }
        public function verify_mobile_verification_code($postData) {
            $verifyOtp = $this->db->get_where('user', array('id' => $postData['user_id'], 'otp' => $postData['otp']))->result();
            if (count($verifyOtp) > 0) {
                $this->db->update('user', array('phone' => $postData['phone'], 'country_code' => $postData['country_code'], 'otp' => NULL, 'is_verify' => '1'), array('id' => $postData['user_id']));
                $userData['select'] = ['*'];
                $userData['table'] = 'user';
                $userData['where'] = ['id' => $postData['user_id']];
                $userDetail = $this->selectRecords($userData);
                $postdata = array('user_id' => $postData['user_id'], 'device_id' => $postData['device_id'],);
                $this->set_user_cart($postdata);
                $total_count = $this->get_total($postdata);
                $notification_status = $this->notification_status($postData['user_id']);
                $datass = array('id' => $userDetail[0]->id, 'fname' => $userDetail[0]->fname, 'lname' => $userDetail[0]->lname, 'email' => $userDetail[0]->email, 'phone' => $userDetail[0]->phone, 'user_gst_number' => ($userDetail[0]->user_gst_number == null) ? "" : $userDetail[0]->user_gst_number, 'login_type' => $userDetail[0]->login_type, 'cart_item' => $total_count[0]->cart_items, 'notification_status' => $notification_status, 'mobile_verify' => $userDetail[0]->is_verify);
                $response["success"] = 1;
                $response["message"] = "otp is verifired";
                $response["user_data"] = $datass;
                return $response;
            } else {
                $response["success"] = 0;
                $response["message"] = "Code is unvalid";
                return $response;
            }
        }
        function logout($postdata) {
            $user_id = $postdata['user_id'];
            $device_id = $postdata['device_id'];
            $data['where']['user_id'] = $user_id;
            $data['table'] = "device";
            $this->deleteRecords($data);
            unset($data);
            $data['where']['device_id'] = $device_id;
            $data['table'] = "device";
            $this->deleteRecords($data);
            return true;
        }
        function cancle_order($postdata) {
            $order_id = $postdata['order_id'];
            $data['select'] = ['order_status'];
            $data['where'] = ['id' => $order_id];
            $data['table'] = 'order';
            $get = $this->selectRecords($data);
            if(count($get)>0){
                if($get[0]->order_status=='8'){
                    return false;
                }

                unset($data);
                $date = strtotime(date('Y-m-d h:i:s'));
                $data['update'] = ['order_status' => '9', 'dt_updated' => $date];
                $data['where'] = ['id' => $order_id];
                $data['table'] = 'order';
                $this->updateRecords($data);
                unset($data);
                $data['where'] = ['order_id' => $order_id];
                $data['table'] = 'delivery_order';
                $this->deleteRecords($data);
                $data['table'] = 'selfPickup_otp';
                $this->deleteRecords($data);
                return true;
            }else{
                return false;
            }
        }
        function check_quantity($qnt, $variant_id) {
            $data['select'] = ['quantity'];
            $data['where'] = ['id' => $variant_id];
            $data['table'] = 'product_weight';
            $res = $this->selectRecords($data);
            $stock_qnt = $res[0]->quantity;
            if ($stock_qnt < $qnt) {
                $response = array();
                $response["success"] = 6;
                $response["message"] = "Item is out of stock";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
                exit;
            }
            return true;
        }
        function check_qnt($id) {
            $data['select'] = ['quantity'];
            $data['where'] = ['id' => $id];
            $data['table'] = 'product_weight';
            $res = $this->selectRecords($data);
            $stock_qnt = $res[0]->quantity;
            if ($stock_qnt <= 0 || $stock_qnt == '') {
                return 1;
            } else {
                return 0;
            }
        }
        function get_product_list($postdata) {
            $device_id = $postdata['device_id'];
            $vendor_id = $postdata['vendor_id'];
            $category_id = $postdata['category_id'];
            $subcategory_id = $postdata['subcategory_id'];
            if (isset($category_id) && isset($vendor_id)) {
                $limit = '10';
                $offset = $postdata['offset'];
                $cal = $limit * $offset;
                //            $data['select'] = ['p.*'];
                $data['where'] = ['p.status !=' => '9', 'p.subcategory_id' => $subcategory_id, 'p.category_id' => $category_id];
                $data['join'] = ['product_weight  AS pw' => ['pw.product_id = p.id', 'INNER']];
                $data['groupBy'] = 'p.id';
                $data['table'] = 'product as p';
                $results = $this->countRecords($data);
                $total_count = $results;
                // print_r($total_count);die;
                unset($data);
                $data['select'] = ['p.*'];
                $data['where'] = ['p.status !=' => '9', 'pw.quantity >=' => '0', 'p.subcategory_id' => $subcategory_id, 'p.category_id' => $category_id];
                $data['join'] = ['product_weight  AS pw' => ['pw.product_id = p.id', 'LEFT']];
                $data['order'] = 'min(pw.discount_price) * 1 ASC';
                $data['limit'] = $limit;
                if ($offset != 0) {
                    $data['skip'] = $cal;
                }
                $data['groupBy'] = 'p.id';
                $data['table'] = 'product as p';
                $result = $this->selectFromJoin($data);
                // print_r($result);exit;
                // echo $this->db->last_query();exit;
                unset($data);
                if (count($result) > 0) {
                    foreach ($result as $row => $p_row) {
                        $product_id = $p_row->id;
                        $data['select'] = ['pw.*', 'w.name as weighname'];
                        $data['where'] = ['pw.status !=' => '9', 'pw.product_id' => $product_id];
                        $data['join'] = ['weight  AS w' => ['pw.weight_id = w.id', 'LEFT'], 'product AS p' => ['pw.product_id = p.id', 'LEFT'], ];
                        // $data['order'] = 'pw.discount_price * 1 '.''.' ASC';
                        $data['order'] = 'pw.discount_price ASC';
                        $data['table'] = 'product_weight as pw';
                        $product_query = $this->selectFromJoin($data);
                        //echo                    $this->db->last_query();exit;
                        unset($data);
                        unset($getdata);
                        foreach ($product_query as $r => $product_variant) {
                            //                        print_r($product_query);exit;
                            $product_variant_id = $product_variant->id;
                            //                        exit;
                            $package_id = $product_variant->package;
                            $package_name = $this->get_package($package_id);
                            unset($data);
                            $data['select'] = ['*'];
                            $data['where'] = ['status !=' => '9', 'product_id' => $product_id, 'product_variant_id' => $product_variant_id];
                            $data['table'] = 'product_image ';
                            $product_image = $this->selectRecords($data);
                            // print_r($product_image);die;
                            if (count($product_image) <= 0) {
                                $image = '';
                            } else {
                                $image = base_url() . 'public/images/product_image/' . $product_image[0]->image;
                            }
                            unset($data);
                            $data['select'] = ['quantity'];
                            $data['where']['product_id'] = $product_id;
                            $data['where']['product_weight_id'] = $product_variant_id;
                            $data['where']['status !='] = 9;
                            $data['where']['vendor_id'] = $vendor_id;
                            if (isset($postdata['user_id']) && $postdata['user_id'] != '') {
                                $data['where']['user_id'] = $postdata['user_id'];
                            } else {
                                if (isset($postdata['device_id'])) {
                                    $data['where']['device_id'] = $postdata['device_id'];
                                    $data['where']['user_id'] = 0;
                                }
                            }
                            $data['table'] = 'my_cart';
                            $result_cart = $this->selectRecords($data);
                            if (count($result_cart) > 0) {
                                $my_cart_quantity = $result_cart[0]->quantity;
                            } else {
                                $my_cart_quantity = '0';
                            }
                            $weight_name = $product_query[$r]->weighname;
                            $data = array('id' => $product_variant->id, 'product_id' => $product_variant->product_id, 'weight_id' => $product_variant->weight_id, 'unit' => ($product_variant->weight_no) . ' ' . $weight_name, 'actual_price' => $product_variant->price, 'quantity' => $product_variant->quantity, 'discount_per' => $product_variant->discount_per, 'discount_price' => $product_variant->discount_price, 'package_name' => $package_name, 'my_cart_quantity' => $my_cart_quantity, 'variant_image' => $image,);
                            $getdata[] = $data;
                        }
                        $product_weight_array = $getdata;
                        $proimg = $image;
                        $prothimg = $image;
                        $getimage = [];
                        foreach ($product_image as $pro_image) {
                            $imagedata = array('id' => $pro_image->id, 'product_id' => $pro_image->product_id, 'image' => base_url() . 'public/images/product_image/' . $pro_image->image, 'thumb_image' => base_url() . 'public/images/product_image_thumb/' . $pro_image->image,);
                            $getimage[] = $imagedata;
                        }
                        $product_image_array = $getimage;
                        $datas = array();
                        $datas['id'] = $p_row->id;
                        $datas['category_id'] = $p_row->category_id;
                        $datas['brand_id'] = $p_row->brand_id;
                        $datas['name'] = $p_row->name;
                        $datas['image'] = $proimg;
                        $datas['image_thumb'] = $prothimg;
                        $datas['about'] = $p_row->about;
                        $datas['content'] = $p_row->content;
                        $datas['status'] = $p_row->status;
                        $datas['dt_added'] = $p_row->dt_added;
                        $datas['dt_updated'] = $p_row->dt_updated;
                        $datas['product_weight'] = $product_weight_array;
                        $datas['product_image'] = $product_image_array;
                        $setdata[] = $datas;
                    }
                    $offset = $offset + 1;
                    $response['offset'] = $offset;
                    $response['success'] = "1";
                    $response['message'] = "Product list";
                    $response["data"] = $setdata;
                    $response['count'] = $total_count;
                    echo $output = json_encode(array('responsedata' => $response));
                } else {
                    $response = array();
                    $response["success"] = 0;
                    $response["message"] = "No record found";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Invalid data";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
            exit;
        }
        function send_staff_notification($vendor_id, $message) {
            $data['select'] = ['d.*'];
            $data['where'] = ['s.vendor_id' => $vendor_id];
            $data['join'] = ['staff_device as d' => ['d.user_id = s.id', 'INNER']];
            $data['table'] = 'staff as s';
            $select = $this->selectFromJoin($data);
            // echo
            // print_r($select);die;
            foreach ($select as $key => $value) {
                $notification_type = 'new_order';
                $dataArray = array('device_id' => $value->token, 'type' => $value->type, 'message' => $message, 'for_staff' => true);
                $key = "AAAAiEVdA8M:APA91bHLObncewgHcuCHN1vlK8KON4pyixZ3MpBXG0PRfr6Fh3qMUe7ZF66t7TGv5Bzfz-zr4MGP93SBwELaDFtFDfSnMxmtKcU2lrGth6TVGfrVodrp-WOLgAeRGMf0ESD1pJc0e_En";
                $this->utility->sendNotification($dataArray, $notification_type, NULL, $key);
            }
        }
        public function notification_list($postData) {
            $data['select'] = ['notification', 'dt_created'];
            $data['table'] = 'notification';
            $data['where'] = ['user_id' => $postData['user_id']];
            $data['order'] = 'id desc';
            return $this->selectRecords($data);
        }
        public function getUserAddressDetails($address_id) {
            $data['table'] = 'user_address';
            $data['select'] = ['*'];
            $data['where'] = ['id' => $address_id];
            return $this->selectRecords($data);
        }
        public function getRandomTimeSlot() {
            $data['table'] = 'time_slot';
            $data['select'] = ['id'];
            $data['where'] = ['status !=' => '9'];
            $data['order'] = 'rand()';
            $data['limit'] = '1';
            $r = $this->selectRecords($data);
            return $time_slot_id = $r[0]->id;
        }
        public function getVendorAddress($id) {
            $data['table'] = 'vendor';
            $data['select'] = ['name', 'location'];
            $data['where'] = ['id' => $id, 'status !=' => '9'];
            $r = $this->selectRecords($data);
            return $r;
        }
        public function insertUsersFeedback($postdata) {
            if (isset($postdata['user_id']) && $postdata['user_id'] != '') {
                $this->isUserFeedbackExists($postdata);
                $data['table'] = 'feedback';
                $data['insert']['user_id'] = $postdata['user_id'];
                $data['insert']['like_dislike'] = $postdata['islike'];
                $data['insert']['dt_created'] = date('Y-m-d H:i:s');
                $data['insert']['dt_updated'] = date('Y-m-d H:i:s');
                $res = $this->insertRecord($data);
                if ($res) {
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Feedback Inserted";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                } else {
                    $response = array();
                    $response["success"] = 0;
                    $response["message"] = "Somthing went wrong";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                }
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Invalid data";
                $output = json_encode(array('responsedata' => $response));
                echo $output;
            }
            die;
        }
        public function isUserFeedbackExists($postdata) {
            $user_id = $postdata['user_id'];
            $data['table'] = 'feedback';
            $data['where']['user_id'] = $user_id;
            $res = $this->selectRecords($data);
            if (!empty($res)) {
                unset($data);
                $date = date('Y-m-d H:i:s');
                $data['table'] = 'feedback';
                $data['where']['user_id'] = $user_id;
                $data['update']['like_dislike'] = $postdata['isLike'];
                $data['update']['dt_updated'] = $date;
                $res = $this->updateRecords($data);
                if ($res) {
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Feedback Updated successfully";
                    $output = json_encode(array('responsedata' => $response));
                    echo $output;
                    exit;
                }
            }
        }
        
        public function make_payment_new($postData) {
            require_once APPPATH . 'libraries/stripe/init.php';
            // print_r($postData);die;
            header('Content-Type: application/json');
            $json_str = file_get_contents('php://input');
            $json_obj = json_decode($json_str);
            $amts = "";
            $currs = "";
            $amts = $json_obj->amount;
            $currs = $json_obj->currency;
            $vendor_id = $json_obj->vendor_id;
            $this->db->select('*');
            $this->db->where('vendor_id', $vendor_id);
            $this->db->where('payment_opt', '2');
            $get_seceret_key = $this->db->get('payment_method')->result();
            // print_r($get_seceret_key);die;
            if ($get_seceret_key[0]->IsTestOrLive == '0') {
                $get_seceret_key[0]->secret_key = $get_seceret_key[0]->test_secret_key;
            }
            \Stripe\Stripe::setApiKey($get_seceret_key[0]->secret_key);
            // Use an existing Customer ID if this is a returning customer.
            $customer = \Stripe\Customer::create();
            $ephemeralKey = \Stripe\EphemeralKey::create(['customer' => $customer->id], ['stripe_version' => '2020-08-27']);
            $paymentIntent = \Stripe\PaymentIntent::create(['amount' => $amts, 'currency' => $currs, 'customer' => $customer->id, ]);
            $output = ['paymentIntent' => $paymentIntent->client_secret, 'ephemeralKey' => $ephemeralKey->secret, 'customer' => $customer->id, 'transaction_id' => $paymentIntent->id];
            echo json_encode($output);
            // return $response->withJson([
            //   'paymentIntent' => $paymentIntent->client_secret,
            //   'ephemeralKey' => $ephemeralKey->secret,
            //   'customer' => $customer->id
            // ])->withStatus(200);
            
        }
        /* testing purpose paytm  integration */
        public function paytm_payment($customer = '') {
            header('Content-Type: application/json');
            if ($customer == '') {
                $customer_detail = file_get_contents('php://input');
            } else {
                $customer_detail = $customer;
            }
            $json_obj = json_decode($customer_detail);
            $orderId = $json_obj->orderId;
            $callbackUrl = $json_obj->callbackUrl;
            $value = $json_obj->value;
            $currency = $json_obj->currency;
            $cust_id = "CUST_" . time();
            $vendor_id = $json_obj->vendor_id;
            $this->db->select('*');
            $this->db->where('vendor_id', $vendor_id);
            $this->db->where('payment_opt', '3');
            $getPaytmCreditial = $this->db->get('payment_method')->result();
            // print_r($getPaytmCreditial);die;
            if ($getPaytmCreditial[0]->IsTestOrLive == '0') {
                $getPaytmCreditial[0]->publish_key = $getPaytmCreditial[0]->test_publish_key;
            }
            // print_r($getPaytmCreditial);die;
            $paytmParams = array();
            $paytmParams["body"] = array("requestType" => "Payment", "mid" => $getPaytmCreditial[0]->publish_key, "websiteName" => "GROCERY", "orderId" => $orderId, "callbackUrl" => $callbackUrl, "txnAmount" => array("value" => $value, "currency" => $currency,), "userInfo" => array("custId" => $cust_id,),);
            // print_r($paytmParams);die;
            /*
             * Generate checksum by parameters we have in body
             * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
            */
            $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $getPaytmCreditial[0]->secret_key);
            $paytmParams["head"] = array("signature" => $checksum);
            $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
            /* for Staging */
            $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=" . $getPaytmCreditial[0]->publish_key . "&orderId=" . $orderId;
            /* for Production */
            // $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=YOUR_MID_HERE&orderId=ORDERID_98765";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            $response = curl_exec($ch);
            print_r($response);
        }
        public function paytm_payment_checksum_only() {
            header('Content-Type: application/json');
            $customer_detail = file_get_contents('php://input');
            $json_obj = json_decode($customer_detail);
            $orderId = $json_obj->orderId;
            $callbackUrl = $json_obj->callbackUrl;
            $value = $json_obj->value;
            $currency = $json_obj->currency;
            $cust_id = $json_obj->cust_id;
            $paytmParams = array();
            $paytmParams["body"] = array("requestType" => "Payment", "mid" => "oxzjXy66674454941399", "websiteName" => "GROCERY", "orderId" => $orderId, "callbackUrl" => $callbackUrl, "txnAmount" => array("value" => $value, "currency" => $currency,), "userInfo" => array("custId" => $cust_id,),);
            /*
             * Generate checksum by parameters we have in body
             * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
            */
            $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "IysGgZ_ro05LoFIo");
            $paytmParams["head"] = array("signature" => $checksum);
            $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
            echo $post_data;
            // /* for Staging */
            // $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=oxzjXy66674454941399&orderId=".$orderId;
            // /* for Production */
            // // $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=YOUR_MID_HERE&orderId=ORDERID_98765";
            // $ch = curl_init($url);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            // $response = curl_exec($ch);
            // print_r($response);
            
        }
        public function paytmStatus($orderId) {
            $data['table'] = TABLE_ORDER_DETAILS;
            $data['select'] = ['*'];
            $data['where'] = ['order_id' => $orderId];
            $res = $this->selectRecords($data);
            $vendor_id = $res[0]->vendor_id;
            $this->db->select('*');
            $this->db->where('vendor_id', $vendor_id);
            $this->db->where('payment_opt', '3');
            $getPaytmCreditial = $this->db->get('payment_method')->result();
            if ($getPaytmCreditial[0]->IsTestOrLive == '0') {
                $getPaytmCreditial[0]->publish_key = $getPaytmCreditial[0]->test_publish_key;
                $getPaytmCreditial[0]->secret_key = $getPaytmCreditial[0]->test_secret_key;
            }
            $paytmParams = array();
            /* body parameters */
            $paytmParams["body"] = array(
            /* Find your MID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
            "mid" => $getPaytmCreditial[0]->publish_key,
            /* Enter your order id which needs to be check status for */
            "orderId" => $orderId,);
            /**
             * Generate checksum by parameters we have in body
             * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
             */
            $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $getPaytmCreditial[0]->secret_key);
            /* head parameters */
            $paytmParams["head"] = array(
            /* put generated checksum value here */
            "signature" => $checksum);
            /* prepare JSON string for request */
            $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
            /* for Staging */
            $url = "https://securegw-stage.paytm.in/v3/order/status";
            /* for Production */
            // $url = "https://securegw.paytm.in/v3/order/status";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $response = curl_exec($ch);
            // json_decode($response);
            $customerData = json_decode($response);
            if ($customerData->body->resultInfo->resultCode == 01) {
                $response_message['type'] = "success";
                $response_message['message'] = "Your transation is successfully";
            } elseif ($customerData->body->resultInfo->resultCode == 400) {
                $response_message['type'] = "danger";
                $response_message['message'] = "Transaction status not confirmed yet.";
            } elseif ($customerData->body->resultInfo->resultCode == 402) {
                $response_message['type'] = "danger";
                $response_message['message'] = "Looks like the payment is not complete. Please wait while we confirm the status with your bank.";
            } elseif ($customerData->body->resultInfo->resultCode == 810) {
                $response_message['type'] = "danger";
                $response_message['message'] = "Your transation is faild";
            } elseif ($customerData->body->resultInfo->resultCode == 501) {
                $response_message['type'] = "danger";
                $response_message['message'] = "Server is down";
            } elseif ($customerData->body->resultInfo->resultCode == 335) {
                $response_message['type'] = "danger";
                $response_message['message'] = "Mid is invalid";
            } elseif ($customerData->body->resultInfo->resultCode == 334) {
                $response_message['type'] = "danger";
                $response_message['message'] = "Invalid Order ID";
            } elseif ($customerData->body->resultInfo->resultCode == 295) {
                $response_message['type'] = "danger";
                $response_message['message'] = "Your payment failed as the UPI ID entered is incorrect. Please try again by entering a valid VPA or use a different method to complete the payment.";
            } elseif ($customerData->body->resultInfo->resultCode == 235) {
                $response_message['type'] = "danger";
                $response_message['message'] = "Wallet balance Insufficient, bankName=WALLET";
            } elseif ($customerData->body->resultInfo->resultCode == 227) {
                $response_message['type'] = "danger";
                $response_message['message'] = "Your payment has been declined by your bank. Please contact your bank for any queries. If money has been deducted from your account, your bank will inform us within 48 hrs and we will refund the same.";
            } elseif ($customerData->body->resultInfo->resultCode == 401) {
                $response_message['type'] = "danger";
                $response_message['message'] = "Your payment has been declined by your bank. Please contact your bank for any queries. If money has been deducted from your account, your bank will inform us within 48 hrs and we will refund the same.";
            }
            return $response_message;
        }
        /* testing purpose paytm  integration */
        public function verifyUserEmailByToken($postData) {
            $userDetail = $this->utility->decode($postData);
            $userData = json_decode($userDetail);
            $check_token = $this->db->query("SELECT id FROM user where id = '$userData->id' AND email_token = '$userData->token'  AND email_verify='2'");
            $response = $check_token->result();
            // print_r($response);die;
            /* if got token in database then update token as empty and user status is active */
            if (count($response) > 0) {
                unset($data);
                $updatedata = array('email_token' => '', 'email_verify' => '1',);
                $this->db->update('user', $updatedata, array('id' => $response[0]->id));
                return true;
            } else {
                return false;
            }
        }
        public function getUserDetails($user_id) {
            $data['table'] = 'user';
            $data['where'] = ['id' => $user_id];
            $data['select'] = ['*'];
            return $this->selectRecords($data);
        }
        public function selfPickUp_otp($order_id, $user_id, $otp) {
            $date = date('Y-m-d H:i:s');
            $insert = array('order_id' => $order_id, 'user_id' => $user_id, 'otp' => $otp, 'dt_created' => $date);
            $data['table'] = 'selfPickup_otp';
            $data['insert'] = $insert;
            return $this->insertRecord($data);
        }
        public function contactus($postData) {
            if (!empty($postData)) {
                $insertContactDetail = ["fname" => $postData['name'], "email" => $postData['email'], "mobile_no" => $postData['mobile'], "message" => $postData['message']];
                $data['insert'] = $insertContactDetail;
                $data['table'] = TABLE_CONTACT_US;
                $contacusId = $this->insertRecord($data);
                if (!empty($contacusId)) {
                    $userDetail["name"] = $postData['name'];
                    $userDetail["email"] = $postData['email'];
                    $userDetail["mobile_no"] = $postData['mobile'];
                    $userDetail["messages"] = $postData['message'];
                    $datas['message'] = $this->load->view('contact_us_template', $userDetail, true);
                    $datas['subject'] = 'Contact Us';
                    $datas["to"] = "maulik.cmexpertise@gmail.com";
                    $res = $this->sendMailSMTP($datas);
                    if ($res) {
                        $response["success"] = 1;
                        $response["message"] = "successfully sent your detail to admin";
                    }
                }
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "something went wrong";
            }
            $output = json_encode(array('responsedata' => $response));
            echo $output;
        }
        public function sendMailSMTP($data) {
            // print_r($data ["message"]);die;
            $config['protocol'] = "smtp";
            $config['smtp_host'] = "162.241.86.206";
            $config['smtp_port'] = '587';
            $config['smtp_user'] = "test@launchestore.com";
            // $config ['smtp_user'] = "sahid.cmexpertise@gmail.com";
            $config['smtp_pass'] = "HhZ~sU(@drk_";
            $config['smtp_timeout'] = 20;
            $config['priority'] = 1;
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = TRUE;
            $config['crlf'] = "\r\n";
            $config['newline'] = "\r\n";
            $config['mailtype'] = "html";
            $CI = & get_instance();
            $message = $data["message"];
            $CI->load->library('email', $config);
            $CI->email->initialize($config);
            $CI->email->clear();
            $CI->email->from($config['smtp_user'], $this->siteTitle);
            $CI->email->to($data["to"]);
            if (isset($data["bcc"])) {
                $CI->email->bcc($data["bcc"]);
            }
            $CI->email->reply_to($config['smtp_user'], '<noreply@stagegator.com>');
            $CI->email->subject($data["subject"]);
            $CI->email->message($message);
            $response = $CI->email->send();
            return true;
        }
        public function get_about_app() {
            $data['table'] = TABLE_ABOUT_US;
            $data['select'] = ['about', 'website', 'contact_number', 'email'];
            return $this->selectRecords($data);
        }
        public function emailTemplate($user_id, $vendor_id, $o_id) {
            $data['table'] = TABLE_ORDER;
            $data['select'] = ['id', 'vendor_id', 'user_id', 'user_address_id', 'order_no', 'isSelfPickup', 'delivery_date', 'payment_transaction_id', 'name', 'mobile', 'delivered_address', 'delivery_charge', 'total', 'dt_added', 'delivery_charge', 'order_no', 'delivery_date'];
            // $data['join'] = [TABLE_ORDER_DETAILS .' as od'=>['o.id=od.order_id','LEFT']];
            $data['where'] = ['status !=' => '9', 'id' => $o_id];
            $re = $this->selectRecords($data);
            $order_id = $re[0]->id;
            unset($data);
            $data['table'] = TABLE_ORDER_DETAILS . ' as od';
            $data['select'] = ['od.id', 'od.product_id', 'od.product_weight_id', 'od.quantity', 'od.actual_price', 'od.discount_price', 'od.calculation_price', 'p.name'];
            $data['join'] = [TABLE_PRODUCT . ' as p' => ['od.product_id=p.id', 'LEFT'], ];
            $data['where'] = ['od.status !=' => '9', 'od.order_id' => $order_id];
            $result = $this->selectFromJoin($data);
            $re[0]->order_details = $result;
            $total_gst = 0;
            foreach ($result as $key => $value) {
                $gst = $this->getProductGst($value->product_id);
                $gst_amount = ($value->discount_price * $gst) / 100;
                $total_gst+= $gst_amount * $value->quantity;
            }
            $re[0]->TotalGstAmount = number_format((float)$total_gst, 2, '.', '');
            unset($data);
            $user_email = $this->getUserEmail($user_id);
            $u_email = $user_email[0]->email;
            $u_name = $user_email[0]->fname;
            $vendor = $this->getVendoremail($vendor_id);
            $vendor_email = $vendor[0]->email;
            $vendor_name = $vendor[0]->owner_name;
            // print_r($vendor);die;
            $data['order_details'] = $re;
            $user_address_id = $re[0]->user_address_id;
            if ($user_address_id != 0) {
                $data['user_address'] = $this->getUserAddress($user_address_id);
            }
            for ($i = 0;$i < 2;$i++) {
                if ($i == 0) {
                    $data['email_to'] = $u_name;
                    $sendTo = $u_email;
                    $data['for_vendor'] = 'user';
                } else {
                    $data['email_to'] = $vendor_name;
                    $sendTo = $vendor_email;
                    $data['for_vendor'] = 'vendor';
                }
                // print_r($data['for_vendor']);
                // die;
                $datas['message'] = $this->load->view('emailTemplate/customer_template', $data, true);
                $datas['subject'] = 'Your Order';
                $datas["to"] = $sendTo;
                // $datas["to"] = 'sahid.cmexpertise@gmail.com';
                $res = $this->sendMailSMTP($datas);
            }
        }
        public function getUserAddress($address_id) {
            $data['table'] = TABLE_USER_ADDRESS;
            $data['select'] = ['*'];
            $data['where'] = ['id' => $address_id];
            return $this->selectRecords($data);
        }
        public function getUserEmail($user_id) {
            $data['table'] = TABLE_USER;
            $data['select'] = ['fname', 'email'];
            $data['where'] = ['id' => $user_id];
            return $this->selectRecords($data);
        }
        public function getVendoremail($vendor_id) {
            $data['table'] = TABLE_VENDOR;
            $data['select'] = ['email', 'owner_name'];
            $data['where'] = ['id' => $vendor_id];
            return $this->selectRecords($data);
        }
    }
?>