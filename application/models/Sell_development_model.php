<?php

class Sell_development_model extends My_model
{
    function __construct(){
        $this->branch_id = $this->session->userdata('branch_id');
        $this->vendor_id = $this->session->userdata('vendor_id');
    }

    function findProductBykey($postdata){

        $data['table'] = TABLE_PRODUCT . ' as p';
        $data['join'] = [
            TABLE_PRODUCT_WEIGHT. ' as pw'=>['pw.product_id=p.id','LEFT'],
            TABLE_WEIGHT. ' as w'=>['pw.weight_id = w.id','LEFT']
         ];
        $data['select'] = ['w.name as weight_name','p.name','p.id as product_id','p.name','pw.id as pw_id','pw.*'];
        $data['where'] = [
                            'p.branch_id'=>$this->branch_id,
                            'p.status !='=>'9',
                            'pw.status !='=>'9',
                            'w.status !='=>'9'
                        ];
        $data['group']['like'] = ['p.name',$postdata['keyValue'],'match'];
        $data['group']['or_like'] = ['pw.qr_code',$postdata['keyValue'],'match'];
        return $this->selectFromJoin($data);
        echo $this->db->last_query();
    }

    public function addProducttoTempOrder($postdata){
       
        $product_id = $postdata['product_id'];
        $varient_id = $postdata['pw_id'];
        $quantity = 1;
        $varient = $this->checkProductVarient($varient_id);
        $isAvailable = $this->checkProductAvailableInTemporder($varient_id,$this->branch_id);
        if(!empty($isAvailable)){

           if($varient[0]->quantity >= $isAvailable[0]->quantity){

            $updateQuantity = $isAvailable[0]->quantity + $quantity;
            
            $actaul_price = number_format((float)$varient[0]->price,2,'.','');
            $discount_per = $varient[0]->discount_per;
            $discount_price = ($actaul_price * $discount_per)/100;

            $price = number_format((float)$varient[0]->discount_price,2,'.','');       
            $updatePrice = $updateQuantity * $price;

            $update_discount_price = $discount_price * $updateQuantity;

            $updatePrice = number_format((float)$updatePrice,2,'.','');
            
            $updateArray = [
                'quantity'=>$updateQuantity,
                'price'=>$updatePrice,
                'dt_updated'=>strtotime(DATE_TIME),
                'discount_price'=>number_format((float)$update_discount_price,2,'.','')
            ];
            $this->UpdateOrderTemp($varient_id,$updateArray);
           
            $response = 1;
        }else{
            $response = 0;
        }
    }else{

        if($varient[0]->quantity > 0){
            $varient_id = $varient[0]->id;

            $price = number_format((float)$varient[0]->discount_price,2,'.','');
            $discount_percentage = number_format((float)$varient[0]->discount_per,2,'.','');
            $discounInPrice = ($varient[0]->price * $varient[0]->discount_per)/100;
            
            $date = strtotime(DATE_TIME);
            $insertedData = [
                'branch_id'=>$this->branch_id,
                'customer_id'=> 0,
                'product_weight_id'=>$varient_id,
                'quantity'=>$quantity,
                'price'=> $price,
                'status'=>'1',
                'dt_added'=> $date,
                'dt_updated'=> $date,
                'park'=>'0',
                'discount'=>$discount_percentage,
                'discount_price'=> number_format((float)$discounInPrice,2,'.','')
            ];
            $data['table'] = TABLE_ORDER_TEMP;
            $data['insert'] = $insertedData;
            $result = $this->insertRecord($data);
            $response = 1; 
           
        }else{
            $response = 0;
        }
    }
    return $response;
}

    public function addProducttoParkedOrder($postdata){
       
        $product_id = $postdata['product_id'];
        $varient_id = $postdata['pw_id'];
        $parked_id = $postdata['isParked'];
        $quantity = 1;
        $varient = $this->checkProductVarient($varient_id);
        $isAvailable = $this->checkOrderIdParked($parked_id,$varient_id,$this->branch_id); 
       
        if(!empty($isAvailable)){
            // update
            $updateQuantity = $isAvailable[0]->quantity + $quantity;
            
            $actaul_price = number_format((float)$varient[0]->price,2,'.','');
            $discount_per = $varient[0]->discount_per;
            $discount_price = ($actaul_price * $discount_per)/100;

            $price = number_format((float)$varient[0]->discount_price,2,'.','');       
            $updatePrice = $updateQuantity * $price;

            $update_discount_price = $discount_price * $updateQuantity;

            $updatePrice = number_format((float)$updatePrice,2,'.','');
            
            $updateArray = [
                'quantity'=>$updateQuantity,
                'price'=>$updatePrice,
                'discount_price'=>number_format((float)$update_discount_price,2,'.',''),
                'dt_updated'=>strtotime(DATE_TIME),
            ];
            $data['table'] = 'parked_order_details';
            $data['update'] = $updateArray;
            $data['where'] = ['id'=>$isAvailable[0]->id];
            $r = $this->updateRecords($data);
            $response = 1;
        }else{
            // insert
            $varient_id = $varient[0]->id;

            $price = number_format((float)$varient[0]->discount_price,2,'.','');
            $discount_percentage = number_format((float)$varient[0]->discount_per,2,'.','');
            $discounInPrice = ($varient[0]->price * $varient[0]->discount_per)/100;
           
            $date = strtotime(DATE_TIME);
            $insertedData = [
                'branch_id'=>$this->branch_id,
                'parked_order_id'=> $parked_id,
                'product_id' => $product_id,
                'product_weight_id'=>$varient_id,
                'weight_id'=>$varient[0]->weight_id,
                'quantity'=>$quantity,
                'actual_price'=>$varient[0]->price,
                'actual_discount'=>$varient[0]->discount_per,
                'discount'=>$discount_percentage,
                'discount_price'=> number_format((float)$varient[0]->discounInPrice,2,'.',''),
                'price'=> $price,
                'status'=>'1',
                'dt_added'=> $date,
                'dt_updated'=> $date,
            ];
            $data['table'] = 'parked_order_details';
            $data['insert'] = $insertedData;
            $result = $this->insertRecord($data);
            $response = 1; 
        }
        
        $this->getUpdatedParkedOrder($parked_id); // update table parked_order
        return $response;
    }

    public function getUpdatedParkedOrder($parked_id){  
        $data['table'] = 'parked_order as po';
        $data['select'] = ['po.order_discount','pow.price'];
        $data['join'] = ['parked_order_details as pow'=>['po.id = pow.parked_order_id','LEFT']];
        $data['where'] = [
            'po.branch_id'=>$this->branch_id,'pow.parked_order_id'=>$parked_id,'po.status'=>'1'
        ];
        $ParkOrder = $this->selectFromJoin($data);
        $total = 0;
        foreach ($ParkOrder as $key => $value) {
            $total += $value->price;
        }
        $total_saving =  ($total * $ParkOrder[0]->order_discount)/100;

        $payable_amount =  $total - $total_saving;
        unset($data);
        $data['table'] = 'parked_order';
        $data['where'] = ['id'=>$parked_id];
        $data['update'] = [
            'total_saving'=>number_format((float)$total_saving,2,'.',''),
            'payable_amount'=>number_format((float)$payable_amount,2,'.',''),
            'total'=>number_format((float)$total,2,'.','')
        ];
        $this->updateRecords($data);
        return true;
    }

    public function checkOrderIdParked($parked_id,$varient_id,$branch_id){
        $data['table'] = 'parked_order_details';
        $data['select'] = ['*'];
        $data['where'] = [
            'branch_id'=>$branch_id,'parked_order_id'=>$parked_id,'product_weight_id'=>$varient_id
        ];
        return $this->selectRecords($data);
    }

      public function getUpdatedParkedRow($parked_id){
        $data['table'] = 'parked_order_details';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$parked_id,'status'=>'1'];
        return $this->selectRecords($data);
    }

    public function checkProductVarient($varient_id){
        $data['table'] = TABLE_PRODUCT .' p';
        $data['join'] = [TABLE_PRODUCT_WEIGHT.' pw'=>['p.id=pw.product_id','inner']];
        $data['select'] = ['p.gst','pw.*'];
        $data['where'] = ['pw.id'=>$varient_id,'pw.status!='=>'9','p.status!='=>'9'];
        return $this->selectFromJoin($data);
    }

    public function checkProductAvailableInTemporder($varient_id,$branch_id =''){
        if($this->branch_id ==''){
 
        }
        $data['table'] = TABLE_ORDER_TEMP;
        $data['select'] = ['*'];
        $data['where'] = ['product_weight_id'=>$varient_id,'branch_id'=>$branch_id];
        return $this->selectRecords($data);
    }

    public function UpdateOrderTemp($varient_id,$updateArray){
        $this->branch_id = $this->session->userdata('id');
        $data['table'] = TABLE_ORDER_TEMP;
        $data['update'] = $updateArray;
        $data['where'] = ['product_weight_id'=>$varient_id,'branch_id'=>$this->branch_id];
        return $this->updateRecords($data);   
    }

    public function searchCustomber($postdata){
        $this->branch_id = $this->session->userdata('id');

        if(isset($postdata['customber_id'])){
            $data['where'] = ['id'=>$postdata['customber_id'],'branch_id'=>$this->branch_id,'status!='=>'9'];
        }else{
            $data['where'] = ['branch_id'=>$this->branch_id,'status!='=>'9'];
        }
        $data['group']["like"] = ['customer_name',$postdata['customber'],'match'];
        $data['group']["or_like"] = [['customercode',$postdata['customber'],'match']];
        $data['table'] = TABLE_CUSTOMER;
        $data['select'] = ['*'];
        return $this->selectRecords($data);
            echo $this->db->last_query();

    }

    public function remove($postdata){
        $order_temp_id = $postdata['order_tempId'];
        $data['table'] = TABLE_ORDER_TEMP;
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$order_temp_id];
        $r = $this->selectRecords($data);
        $quantity = $r[0]->quantity;
        $product_wieght_id = $r[0]->product_weight_id;
       
        $data['table'] = TABLE_ORDER_TEMP;
        $data['where'] = ['id'=>$order_temp_id];
        return $this->deleteRecords($data);
    }



    public function updateTempQuantity($postdata,$price){
        $this->branch_id = $this->session->userdata('id');
        $temp_id = $postdata['temp_id'];
        $update_quantity = $postdata['qunt'];
        $actual_discount_price = $postdata['actual_discount_price'];
       

        $data['table'] = TABLE_ORDER_TEMP;
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$temp_id];
        $re = $this->selectRecords($data);

        $discount = (($price * $re[0]->discount)/100) * $update_quantity;
        
        $update_price = ($price * $update_quantity) - $discount;
        unset($data);
            
        $updateData = array(
            'quantity'=>$update_quantity,
            'price'=>numberFormat($update_price),
            'discount_price'=> numberFormat($discount)
        );

        $data['table'] = TABLE_ORDER_TEMP;
        $data['update'] = $updateData;
        $data['where'] = ['id'=>$temp_id,'branch_id'=>$this->branch_id];
        return $this->updateRecords($data);

    }

    public function updateParkedQuantity($postdata,$price){
        $this->branch_id = $this->session->userdata('id');
        $temp_id = $postdata['temp_id'];
        $update_quantity = $postdata['qunt'];
        $actual_discount_price = $postdata['actual_discount_price'];
      

        $data['table'] = 'parked_order_details';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$temp_id];
        $re = $this->selectRecords($data);

        $discount = (($price * $re[0]->discount)/100) * $update_quantity;
        
        $update_price = ($price * $update_quantity) - $discount;

        unset($data);
            
        $updateData = array(
            'quantity'=>$update_quantity,
            'price'=>numberFormat($update_price),
            'discount_price'=> numberFormat($discount)
        );

        $data['table'] = 'parked_order_details';
        $data['update'] = $updateData;
        $data['where'] = ['id'=>$temp_id,'branch_id'=>$this->branch_id];
        $this->updateRecords($data);

        $parked_id = $postdata['isParked'];
        $this->getUpdatedParkedOrder($parked_id);


    }

    public function updateDiscount($postdata){
        $isParked = $this->input->post('isParked');
        if($isParked > 0){
            $table_name = 'parked_order_details';            
        }else{
            $table_name = TABLE_ORDER_TEMP;
        }

        $this->branch_id = $this->session->userdata('id');
        $varient_id = $postdata['product_weight_id'];
        $discount =  $postdata['discount'];
        $temp_id =  $postdata['temp_id'];
        $quantity =  $postdata['quantity'];
        $actual_discount_price =  $postdata['actual_discount_price'];
        $result = $this->checkProductVarient($varient_id);
        $product_price = $result[0]->price;

        $disc_price = (($product_price * $discount) / 100) * $quantity;
        $updatprice = $product_price * $quantity;
        $updatprice = $updatprice - $disc_price;  
     

        $updateData = array(
            'quantity'=>$quantity,
            'price'=>numberFormat($updatprice),
            'discount'=>numberFormat($discount),
            'discount_price'=> numberFormat($disc_price)
        );

        $data['table'] = $table_name;
        $data['update'] = $updateData;
        $data['where'] = ['id'=>$temp_id,'branch_id'=>$this->branch_id];
        $this->updateRecords($data);
        if($isParked > 0){
            $this->getUpdatedParkedOrder($isParked);
        }
        return numberFormat($updatprice);
    }

    public function getParkedOrderList(){
        $this->branch_id = $this->session->userdata('id');
        $data['table'] = 'parked_order as po';
        $data['join'] = [
            'branch as v' =>['v.id=po.branch_id','LEFT'],
            'customer as c' => ['c.id=po.customer_id','LEFT']
        ];
        $data['select'] = [' po.*', 'c.customer_name', 'v.name as vendor_name'];
        $data['where'] = ['po.status'=>'1','po.branch_id'=>$this->branch_id];
        $data['orderBy'] = 'po.id DESC';
        return $this->selectFromJoin($data);
     
    }

    public function getProductVarient($postdata){
        $this->branch_id = $this->session->userdata('id');  

        if(isset($postdata['IsPosMostLike'])){
            $data['where'] = ['pw.branch_id'=>$this->branch_id,'pw.IsPosMostLike'=>'1','p.status!='=>'9','pw.status!='=>'9'];
        }else{
            $product_id = $postdata['product_id'];
            $varient_id = $postdata['pw_id'];
            $data['where'] = ['pw.branch_id'=>$this->branch_id,'pw.id'=>$varient_id,'p.status!='=>'9','pw.status!='=>'9'];
        }

        $data['table'] = TABLE_PRODUCT.' as p';
        $data['select'] = ['p.name','w.name as weight_name','pw.*'];
        $data['join'] = [
            TABLE_PRODUCT_WEIGHT.' as pw'=>['p.id=pw.product_id','LEFT'],
            'weight as w' => ['pw.weight_id = w.id', 'LEFT']
        ];
        $return = $this->selectFromJoin($data);
        return $return; 
    }

    public function MakeQuickList($postdata){
        foreach ($postdata as $id) {
            $data['table'] = TABLE_PRODUCT_WEIGHT;
            $data['where'] = ['id'=>$id];
            $data['update'] = ['IsPosMostLike'=>'1'];
            $this->updateRecords($data);
        }
        return true;
    }

    public function RemoveQuickListItem($postdata){
       $data['table'] = TABLE_PRODUCT_WEIGHT;
       $data['where'] = ['id'=>$postdata['pw_id']];
       $data['update'] = ['IsPosMostLike'=>'0'];
       return $this->updateRecords($data);
    }


    function update_temp_order($postdata)
    {
        $customer_id = $postdata['customer_id'];
        $this->branch_id = $this->session->userdata('id');
        $qnt = $postdata['qnt'];
        $price = $postdata['dt_price'];
        $variant_id = $postdata['variant_id'];

        $data['update']['quantity'] = $qnt;
        $data['update']['price'] = $price;
        $data['where'] = ['customer_id' => $customer_id, 'branch_id' => $this->branch_id, 'product_weight_id' => $variant_id];
        $data['table'] = 'order_temp';
        $this->updateRecords($data);

        $this->db->query("UPDATE product_weight SET quantity = quantity - 1,temp_quantity = temp_quantity + 1  WHERE id= '$variant_id'");
        exit;
    }

    public function removeParked($postdata){
        // dd($postdata);die;
      $data['table'] = 'parked_order_details';
      $data['where'] = ['id'=>$postdata['order_tempId'],'parked_order_id'=>$postdata['isParked']];
      $this->deleteRecords($data);

      $parked_id = $postdata['isParked'];
      $this->getUpdatedParkedOrder($parked_id);
        return true;
    }


    function update_same_product($postdata)
    {
        $customer_id = $postdata['customer_id'];
        $this->branch_id = $this->session->userdata('id');
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
        $this->branch_id = $this->session->userdata('id');
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
        

        $product_variant_id = $postdata['product_w_id'];
        $this->branch_id = $this->session->userdata('id');
        $customer_id = $postdata['customer_id'];


        unset($data);
        $data['select'] = ['quantity'];
        $data['where'] = ['id' => $product_variant_id, 'branch_id' => $this->branch_id];
        $data['table'] = 'product_weight';
        $result = $this->selectRecords($data, true);
        $quantity = $result[0]['quantity'] - 1;


      
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
                'branch_id' => $this->branch_id,
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


    function order_checkout($postdata){
      

        $park = $postdata['parked_order'];
        $this->branch_id = $postdata['branch_id'];
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
                'order_no' => 'OD' . strtotime(DATE_TIME),
                'branch_id' => $this->branch_id,
                'customer_id' => $customer_id,
                'register_id' => $register_id,
                'payable_amount' => $hidden_total_pay,
                'total_saving' => $discount_total,
                'total' => $sub_total,
                'order_discount' => $disc_percentage,
                'status' => '1',
                'dt_added' => strtotime(DATE_TIME),
                'dt_updated' => strtotime(DATE_TIME)
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

                        
                        /*27/10/2022*/

                        $product_detail = $this->get_product_from_variant($p_id);



                        $discount_price = ($product_detail->price * $quantity_temp) - $pro_temp_result[0]->price;

                        $insertion = array(
                            'branch_id' => $this->branch_id,
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
                            'dt_added' => strtotime(DATE_TIME),
                            'dt_updated' => strtotime(DATE_TIME),
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
            redirect(base_url() . '	sell_development');
            exit;

        }
        if (isset($postdata['case']) && $postdata['case'] == 'Cash') {
            $payment_type = '0';
        }

        if (isset($postdata['credit_card']) && $postdata['credit_card'] == 'Credit Card') {
            $payment_type = '1';
        }
       
        $insertion = array(
            'order_from' => $order_from,
            'order_no' => 'OD' . strtotime(DATE_TIME),
            'branch_id' => $this->branch_id,
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
            'dt_added' => strtotime(DATE_TIME),
            'dt_updated' => strtotime(DATE_TIME)
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
                
                    $p_id = $pro_temp_result[0]->product_weight_id;
                    $quantity_temp = $pro_temp_result[0]->quantity;
                    $total_item = $total_item + $quantity_temp;
                    unset($data);

                    if ($quantity_temp == '') {
                        $quantity_temp = '0';
                    }

                    $product_detail = $this->get_product_from_variant($p_id);


                    $this->db->query("UPDATE product_weight SET  quantity = quantity - '$quantity_temp',temp_quantity = 0 WHERE id = '$p_id'");

                    $discount_price = ($product_detail->price * $quantity_temp) - $pro_temp_result[0]->price;

                    $insertion = array(
                        'branch_id' => $this->branch_id,
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
                        'dt_added' => strtotime(DATE_TIME),
                        'dt_updated' => strtotime(DATE_TIME),
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
        redirect(base_url() . '	sell_development/index');
        exit;

    }


    function order__checkout($postdata)
    {


        $this->branch_id = $this->session->userdata('id');


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
            'branch_id' => $this->branch_id,
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
                   

                    $order_temp_array = array(
                        'branch_id' => $this->branch_id,
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

        $this->branch_id = $this->session->userdata('id');
        $user_id = $this->input->post('customer');
        $sub_total = $this->input->post('hidden_subtotal');
        $disc_percentage = $this->input->post('disc_percentage');
        $discount_total = $this->input->post('hidden_discount_total');
        $total = $this->input->post('hidden_total');
        $register_id = $this->input->post('register_id');
        // print_r($this->input->post());exit;
        //Fetch Email and Name from User Id
        $query_user = $this->db->query("SELECT email, name FROM vendor WHERE id = '$this->branch_id'");
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

        

        $cash_array = array(
            'user_id' => $user_id,
            'branch_id' => $this->branch_id,
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
        $this->branch_id = $this->session->userdata('id');

        $data['select'] = ['*'];
        $data['where'] = ['status !=' => '9', 'branch_id' => $this->branch_id];
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

        // print_r($postdata);die;
        $id = $postdata['id'];

        $data['select'] = ['product_weight_id', 'quantity'];
        $data['where'] = ['parked_order_id' => $id];
        $data['table'] = 'parked_order_details';
        $result = $this->selectRecords($data);

        foreach ($result as $key) {

            $product_weight_id = $key->product_weight_id;
            $qnt = $key->quantity;

            // $this->db->query("UPDATE product_weight SET quantity = quantity + $qnt , park_quantity = park_quantity - $qnt WHERE id= '$product_weight_id'");
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
        $this->branch_id = $this->session->userdata('id');
        $register_query = $this->db->query("SELECT * FROM `register` WHERE vendor_id = '$this->branch_id' GROUP BY id DESC LIMIT 1");
        return  $register_result = $register_query->result();
     }

     public function customer(){
        $this->branch_id = $this->session->userdata('id');
        $data['table'] = 'customer';
        $data['select'] = ['*']; 
        $data['where'] = ['status!='=>'9','branch_id'=>$this->branch_id];
        return $this->selectRecords($data);

     }

    public function getCategory(){
        $this->branch_id = $this->session->userdata('id');
        $data['table'] = 'category';
        $data['select'] = ['*']; 
        $data['where'] = ['status!='=>'9','branch_id'=>$this->branch_id];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
     }

    public function getCurrencyCode(){
        $this->branch_id = $this->session->userdata('id');
        $data['table'] = 'vendor';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$this->branch_id];
        $re = $this->selectRecords($data);
        return $re[0]->currency_code; 
    } 

    public function getCurrency(){
        $data['table'] = 'set_default';
        $data['select'] = ['*'];
        $data['where'] = ['request_id'=>'3','vendor_id'=>$this->vendor_id];
        return $this->selectRecords($data);
    }

    public function OrderTemp($parked_order_id){
        $this->branch_id = $this->session->userdata('id');
        $data['table'] = 'parked_order_details as ot';
        $data['select'] = [
            'po.order_discount as order_discount',
            'p.name as product_name','pw.price as actual_price',
            'pw.discount_price as product_price','pw.discount_per as product_discount','ot.*',
            'ot.discount_price as discount_per_product','p.gst','po.customer_id'
        ];
        $data['join'] = [
            'product_weight as pw'=>['pw.id = ot.product_weight_id','LEFT'],
            'product as p'=>['p.id = pw.product_id','LEFT'],
            'parked_order as po'=>['po.id = ot.parked_order_id','LEFT']
        ];
        $data['where'] = [
            'ot.branch_id'=>$this->branch_id,
            'ot.parked_order_id' => $parked_order_id
        ];
        $return = $this->selectFromJoin($data);
        foreach ($return as $key => $value) {
            $re = $this->getCustomer($value->customer_id);
            $return[$key]->customer_name = $re[0]->customer_name;
            $return[$key]->customercode = $re[0]->customercode;
        }
        return $return;
    }

    public function getCustomer($id){
        $data['table'] = 'customer';
        $data['select'] = ['*'];
        $data['where'] = ['id'=>$id];
        return $this->selectRecords($data);
    }

    public function OrderTempWithoutPark($order_temp_id=''){
        $this->branch_id = $this->session->userdata('id');
        if($order_temp_id !=''){
            $data['where']['ot.id'] =  $order_temp_id;
        }

        $data['table'] = 'order_temp as ot';
        $data['select'] = [
            'p.name as product_name','pw.price as actual_price',
            'pw.discount_price as product_price','pw.discount_per as product_discount','ot.*','ot.discount_price as discount_per_product','p.gst'
        ];
        $data['join'] = [
            'product_weight as pw'=>['pw.id = ot.product_weight_id','LEFT'],
            'product as p'=>['p.id = pw.product_id','LEFT'],
        ];
        $data['where']['ot.branch_id'] = $this->branch_id;
        $data['where']['ot.park'] = '0';
        return $this->selectFromJoin($data);
    }

    public function orderHistory(){
        $data['table'] = 'order as po';
        $data['select'] = ['po.*','c.customer_name','v.name as vendor_name'];
        $data['join'] = [
            'branch as v'=>['v.id = po.branch_id','LEFT'],
            'customer as c'=>['c.id = po.user_id','LEFT']
        ];
        $data['where'] = [
            'po.status'=>'1','payment_type !='=>'2',
            'po.branch_id'=> $this->branch_id
        ];
        $data['order'] = 'po.id DESC';
        return $this->selectFromJoin($data);
    }

   public function viewOrderDetails($postdata){

        $this->branch_id = $this->session->userdata('id');
        $order_id = $this->utility->safe_b64decode($postdata['order_id']);
        
        $data['table'] =  TABLE_ORDER_DETAILS.' as od';
        $data['select'] = ['od.calculation_price','od.discount','od.quantity', 'od.dt_updated','p.name'];
        $data['join'] = [
            TABLE_PRODUCT.' as p'=>['od.product_id=p.id','LEFT']
        ];
        $data['where'] = ['od.order_id'=>$order_id,'od.status!='=>'9'];
        $result =  $this->selectFromJoin($data);
        unset($data);
            $data['table'] = TABLE_ORDER;
            $data['select'] = ['total','payment_type','order_discount', 'payable_amount','dt_added','total_saving'];
            $data['where'] = ['id'=>$order_id,'branch_id'=>$this->branch_id,'status!='=>'9'];
            $r = $this->selectRecords($data); 
        return ['order_details'=>$result,'orderInfo'=>$r]; 
   } 

  public function addCustomer($postdata) {
        $this->branch_id = $this->session->userdata('id');
        $insertData = array(
            'group_id' => 0,
            'branch_id' => $this->branch_id,
            'customer_name' => $postdata['customer_name'],
            'mobile' => $postdata['mobile'],
            'email' => $postdata['email'],
            'customercode' =>$postdata['customercode'],
            'dt_added' => strtotime(DATE_TIME),
            'dt_updated' => strtotime(DATE_TIME),
        );
        $data['table'] = 'customer';
        $data['insert'] = $insertData ;
        return $this->insertRecord($data); 
  }

  public function removeSaleRecord($postdata){
        $order_id = $this->utility->safe_b64decode($postdata['order_id']);
        $data['table'] = 'order';
        $data['update'] = ['status'=>'9'];
        $data['where'] = ['id'=>$order_id];
        $this->updateRecords($data);
        unset($data);
        $data['table'] = 'order_details';
        $data['update'] = ['status'=>'9'];
        $data['where'] = ['order_id'=>$order_id];
        $this->updateRecords($data);

  }


    public  $order_column_order = array('po.*,c.customer_name,v.name as vendor_name,c.customercode');  
    function make_query_sell($postData){
        $this->branch_id = $this->session->userdata('id');
        $where = [
            'po.status'=>'1','po.payment_type !='=>'2',
            'po.branch_id'=> $this->branch_id
        ];
         $this->db->select('po.*,c.customer_name,v.name as vendor_name,c.customercode');  
         $this->db->from('order as po');
         $this->db->join('vendor as v','v.id = po.branch_id','LEFT');
         $this->db->join('customer as c','c.id = po.customer_id','LEFT');
         $this->db->where($where);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
        $this->db->group_start();
            $this->db->like("v.name", $postData["search"]["value"]);
            $this->db->or_like("c.customer_name", $postData["search"]["value"]);
            $this->db->or_like("c.customercode", $postData["search"]["value"]);
            // $this->db->or_like("po.dt_added as", $postData["search"]["value"]);
            $this->db->or_like("po.payable_amount", $postData["search"]["value"]);
        $this->db->group_end(); 
        }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('po.id', 'DESC');  
           } 
    }


    function make_datatables_sell($postData){ 
        $this->make_query_sell($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
           
            $query = $this->db->get();  
            return $query->result();
            // echo $this->db->last_query();
        }

    function get_filtered_data_sell($postData = false){  
        $this->make_query_sell($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }    

    function get_all_data_sell($postData = array()){
        $this->branch_id = $this->session->userdata('id');
            $where = [
                'po.status'=>'1','po.payment_type !='=>'2',
                'po.branch_id'=> $this->branch_id
            ];
         $this->db->select('po.*,c.customer_name,v.name as vendor_name');  
         $this->db->from('order as po');
         $this->db->join('branch as v','v.id = po.branch_id','LEFT');
         $this->db->join('customer as c','c.id = po.customer_id','LEFT');
         $this->db->where($where);
        return $this->db->count_all_results(); 
           // echo $this->db->last_query();
    }


}

?>