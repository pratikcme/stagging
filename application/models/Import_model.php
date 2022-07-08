<?php
// error_reporting(E_ALL);
// ini_set("displya_errors", '1');
class Import_model extends My_model {

    function __construct(){
        $this->vendor_id = $this->session->userdata('branch_vendor_id');
    }

    function getCatgory($catgeoryName = NULL) {

        if ($this->branch_id != '') {
            $data['select'] = ['*'];
            if($catgeoryName){
                $data['where'] = ['name' => $catgeoryName,'status!='=>'9'];
            }else{
                $data['where'] = ['branch_id' => $this->branch_id,'status!='=>'9'];
            }

            $data['table'] = 'category';
            $result = $this->selectRecords($data);
            return $result;
        }

    }

    function unit_list($unitName = NULL){
       
        $data['select'] = ['*'];
        if($unitName){
            $data['where']['name'] = $unitName;
        }
        $data['where']['vendor_id'] = $this->vendor_id;
        $data['table'] = 'weight';
        $result = $this->selectRecords($data,true);
        if($unitName){
            return $result;
        }else{
            $unitArray = array();

            for ($i = 0; $i < count($result); $i++) {
                $unitArray[] = $result[$i]['name'];
            }

            return $unitArray;
        }

    }

    function supplier_list($supplierName = NULL){
        if ($this->branch_id != '') {
            $data['select'] = ['*'];
            if($supplierName){
                $data['where'] = ['name' => $supplierName,'branch_id' => $this->branch_id,'status !=' => '9'];
            }else{
                $data['where'] = ['branch_id' => $this->branch_id,'status !=' => '9'];
            }
            $data['table'] = 'supplier';
            $result = $this->selectRecords($data,true);

            if ($supplierName) {
                return $result;
            } else {
                $supplierArray = array();

                for ($i = 0; $i < count($result); $i++) {
                    $supplierArray[] = $result[$i]['name'];
                }

                return $supplierArray;
            }
        }
    }

    function package_list($packageName = NULL){

        $data['select'] = ['*'];
        if ($packageName) {
            $data['where']['package'] = $packageName;
        }
        $data['where']['vendor_id'] = $this->vendor_id;
        $data['table'] = 'package';
        $result = $this->selectRecords($data,true);

        if ($packageName) {
            return $result;
        } else {
            $packageArray = array();

            for ($i = 0; $i < count($result); $i++) {
                $packageArray[] = $result[$i]['package'];
            }

            return $packageArray;
        }
    }

    function subcategory_list($categoryId,$subCategory="") {
            
        if (isset($categoryId) && $categoryId != "" ) {
            $data['select'] = ['*'];
            if($subCategory != ''){
                $data['where'] = ['status !='=>'9','category_id' => $categoryId,'branch_id' => $this->branch_id,'name' => filter_var (trim($subCategory), FILTER_SANITIZE_STRING)];
            }else{
                $data['where'] = ['category_id' => $categoryId, 'branch_id' => $this->branch_id,'status !='=>'9'];
            }
            // unset($data['where']);
            $data['table'] = 'subcategory';
            $result = $this->selectRecords($data,true);
          
            if($subCategory){
                // $this->db->query('truncate table temp_product');
                // $this->db->query('truncate table temp_product_weight');
                // $this->db->query('truncate table temp_product_image');
                return $result;
            }else{
                $subCateArray = array();

                for ($i = 0; $i < count($result); $i++) {
                    $subCateArray[] = $result[$i]['name'];
                }
                return $subCateArray;
            }
        }

    }

    function escapeString($val) {
        $db = get_instance()->db->conn_id;
        $val = mysqli_real_escape_string($db, $val);
        return $val;
    }

    function brand_list($categoryId,$brand = NULL) {

        if (isset($categoryId) && !empty($categoryId)) {

            if($brand){
                $brand = $this->escapeString($brand);
                $brand_query = $this->db->query("SELECT * FROM brand WHERE name = '$brand' AND branch_id = '$this->branch_id' AND status != '9'");
                $result = $brand_query->result_array();
                 // echo $this->db->last_query();die;
            }else{
                // $brand_query = $this->db->query("SELECT * FROM brand WHERE category_id LIKE '%$categoryId%' AND branch_id = '$this->branch_id' AND status != '9'");
                $brand_query = $this->db->query("SELECT * FROM brand WHERE FIND_IN_SET(".$categoryId.",category_id) AND branch_id = '$this->branch_id' AND status != '9'");
                $result = $brand_query->result_array();

            }
                if(empty($result)){
                    // $this->db->query('truncate table temp_product');
                    // $this->db->query('truncate table temp_product_weight');
                    // $this->db->query('truncate table temp_product_image');
                    $this->utility->setFlashMessage('danger',"Brand does not exist.Excel is not uploaded!");
                    redirect(base_url().'import/import_excel');
                    die;
                }
          
            if(!empty($brand)){
                return $result;

            }else{
                $brandArray = array();

                for($i=0; $i<count($result); $i++){
                    $brandArray[] = $result[$i]['name'];
                }
                return $brandArray;
            }

        }

    }

    public function getCategorys(){
        $data['table'] = 'category'; 
        $data['select'] = ['*']; 
        $data['where'] = ['status!='=>'9','branch_id'=>$this->branch_id];
        return $this->selectRecords($data); 
    }


    function importExcel(){
        // echo '1';die;
            // print_r($_POST);die;
        $this->load->library('excel');
        if (isset($_FILES["file"]["name"])) {
            $path = $_FILES["file"]["tmp_name"];
            $name = explode('.',$_FILES["file"]["name"]);
            // $getCategory = $this->getCatgory($name[0]);
            // $categoryId = $getCategory[0]->id;
            $categoryId = $this->input->post('catgeory');

            $object = PHPExcel_IOFactory::load($path);
            $lastInsertedId = '';
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                // print_r($highestRow);die;
                for ($row = 2; $row <= $highestRow; $row++) {
                    // if($row == '3'){
                    //     die;
                    // }
                    $type = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    
                    $subCategory = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                    $brandName = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $productName = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $productContent = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $productAbout = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    // $supplier = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $varient = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $unit = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    
                    $package = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $qty = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $purchasePrice = $worksheet->getCellByColumnAndRow(11, $row)->getValue();

                    $retailPrice = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    $dicount = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    $image = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    $gst = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                    $max_order_qty = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
            // print_r($type);
            // echo "<br>";
            // print_r($subCategory);
            // echo "<br>";
            // print_r($brandName);
            // echo "<br>";
            // print_r($productContent);
            // echo "<br>";
            // print_r($productAbout);
            // echo "<br>";
            // print_r($varient);
            // echo "<br>";
            // print_r($unit);
            // echo "<br>";
            // print_r($package);
            // echo "<br>";
            // print_r($qty);
            // echo "<br>";
            // print_r($purchasePrice);
            // echo "<br>";
            // print_r($retailPrice);
            // echo "<br>";

            // print_r($dicount);
            // echo "<br>";
            // print_r($image);
            // echo "<br>";
            // print_r($gst);
            // echo "<br>";
            // print_r($max_order_qty);
            // echo "<br>";
            // die;

                    if($subCategory != ''){
                        $getSub = $this->subcategory_list($categoryId, $subCategory);
                        $subCategoryId = $getSub[0]['id'];
                    }

                    if($brandName != ''){
                        $getBrand = $this->brand_list($categoryId, $brandName);
                        // echo $this->db->last_query();die;
                        // print_r($getBrand);die;
                        $brandId = $getBrand[0]['id'];
                        // $brandId = '10';
                    }

                 
                    if($package != ''){
                        $getPackage = $this->package_list($package);
                        $packageId = $getPackage[0]['id'];
                    }

                    if($unit != ''){
                        $getUnit = $this->unit_list($unit);
                        $unitId = $getUnit[0]['id'];
                    }
                    if($image != ''){
                        $image = $image;
                        $images = explode(',', $image);
                    }
                    if($gst == ''){
                        $gst = 0 ;
                    }

                    if($type != ''){
                        if ($type == 'New') {
                            // echo 'new';die;
                            $data['insert']['branch_id'] = $this->branch_id;
                            $data['insert']['category_id'] = $categoryId;
                            $data['insert']['subcategory_id'] = $subCategoryId;
                            $data['insert']['brand_id'] = $brandId;
                            // $data['insert']['supplier_id'] = $supplierId;
                            $data['insert']['name'] = $productName;
                            $data['insert']['image'] = NULL;
                            $data['insert']['about'] = $productAbout;
                            $data['insert']['content'] = $productContent;
                            $data['insert']['gst'] = $gst;
                            $data['insert']['status'] = '1';
                            $data['insert']['dt_added'] = strtotime(date('Y-m-d H:i:s'));
                            $data['insert']['dt_updated'] = strtotime(date('Y-m-d H:i:s'));
                            $data['table'] = 'temp_product';
                            $lastId = $this->insertRecord($data);
                            $lastInsertedId = $lastId;
                            unset($data);
                            goto a;
                        }

                        if ($type == 'Old') {

                            a:
                            $final_discount_price = '';

                            if ($dicount != '0' && $dicount != '') {
                                $discount_price_cal = (($retailPrice * $dicount) / 100);
                                $discount_price = number_format((float) $discount_price_cal, 2, '.', '');
                                $final_discount_price = number_format((float) $retailPrice - $discount_price, 2, '.', '');
                            } else {
                                $dicount = 0;
                                $final_discount_price = $retailPrice;
                            }
                            
                            $gst = ($final_discount_price * $gst) /100;
                            $without_gst_price = $final_discount_price - $gst;


                            // echo $unitId .'/'.$packageId .'/'. $varient .'/'. $purchasePrice .'/'.$purchasePrice .'/'. $retailPrice .'/'. $qty ; die; 
                            if($unitId !='' && ($packageId !='') && ($varient !='') && ($purchasePrice == 0 || $purchasePrice != '') && ($retailPrice !='') && ($qty !='') ) {
                                $data['insert']['branch_id'] = $this->branch_id;
                                $data['insert']['product_id'] = ($lastId != '') ? $lastId : $lastInsertedId;
                                $data['insert']['weight_id'] = $unitId;
                                $data['insert']['package'] = $packageId;
                                $data['insert']['weight_no'] = $varient;
                                $data['insert']['purchase_price'] = $purchasePrice;
                                $data['insert']['price'] = $retailPrice;
                                $data['insert']['quantity'] = $qty;
                                $data['insert']['temp_quantity'] = $qty;
                                $data['insert']['discount_per'] = $dicount;
                                $data['insert']['without_gst_price'] = $without_gst_price;
                                $data['insert']['discount_price'] = $final_discount_price;
                                $data['insert']['discount_allow'] = '1';
                                if(isset($max_order_qty) && $max_order_qty!='' && $max_order_qty!=0){
                                    $data['insert']['max_order_qty'] = $max_order_qty;                                    
                                }
                                $data['insert']['status'] = '1';
                                $data['insert']['dt_added'] = strtotime(date('Y-m-d H:i:s'));
                                $data['insert']['dt_updated'] = strtotime(date('Y-m-d H:i:s'));
                                $data['table'] = 'temp_product_weight';
                                $result = $this->insertRecord($data);
                               // lq();

                                unset($data);
                                foreach ($images as $key => $value) {
                                    $data['insert']['product_variant_id'] = $result;
                                    $data['insert']['branch_id'] = $this->branch_id;
                                    $data['insert']['product_id'] = ($lastId != '') ? $lastId : $lastInsertedId;
                                    $data['insert']['image'] = $value;
                                    $data['insert']['status'] = '1';
                                    $data['insert']['image_order'] = '0';
                                    $data['insert']['dt_added'] = strtotime(date('Y-m-d H:i:s'));
                                    $data['insert']['dt_updated'] = strtotime(date('Y-m-d H:i:s'));
                                    $data['table'] = 'temp_product_image';
                                    $res = $this->insertRecord($data);
                                    // lq();
                                }
                                unset($data);
                            }
                        }
                    }

                }
               
            }
        }
        return true;
    } 

    public function getProductOfCategory($postData){
        $data['table'] = TABLE_CATEGORY;
        $data['select'] = ['*'];
        $data['where'] = [
            'name'=>$postData['catgory_name'],
            'status!='=>'9'
        ];
        $result = $this->selectRecords($data);
        // echo $this->db->last_query();die;
        $category_id = $result[0]->id;
        unset($data);
        $data['table'] = TABLE_PRODUCT;
        $data['select'] = ['id','name as product_name'];
        $data['where'] = [
            'category_id'=>$category_id,
            'status!='=>'9'
        ];
        return $this->selectRecords($data);
    }

    public function getVarientOfProduct($product_id,$branch_id){
       

        $data['table'] = TABLE_PRODUCT_WEIGHT . ' as pw';
        $data['join'] = [
            TABLE_WEIGHT . ' as w'=>['pw.weight_id=w.id','LEFT'], 
            'package as pkg'=>['pw.package=pkg.id','LEFT'], 
        ];
        $data['where'] = [
            'pw.branch_id' =>$branch_id,
            'pw.product_id'=>$product_id,
            'pw.status !='=>'9',
        ];
        $data['select'] = ['pw.weight_no','pw.quantity','w.name','pkg.package','pw.discount_per','pw.price'];
       
        return $return = $this->selectFromJoin($data);
     
    }

    public function UpdateProductQuantity(){
        if (isset($_FILES["file"]["name"])) {
            $path = $_FILES["file"]["tmp_name"];
            $name = explode('.',$_FILES["file"]["name"]);
           
            $categoryId = $this->input->post('catgeory');

            $object = PHPExcel_IOFactory::load($path);
            $lastInsertedId = '';
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
              
                $i = 0;
                for ($row = 2; $row <= $highestRow; $row++) {

                    $type = $worksheet->getCellByColumnAndRow(1, $row)->getValue();                    
                    $productName = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $varient = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $unit = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $package = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $qty = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $price = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $discount = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $max_order_qty = $worksheet->getCellByColumnAndRow(9, $row)->getValue();

                  

                    $discount_price = ($price * $discount)/100; 

                  
                    $Varient = $this->ProductVarient($productName);
                    // dd($Varient);
                    
                    if($type != ''){

                        if ($type == 'New') {
                            $i = 0 ;
                            $firstVarient_id = $Varient[$i]->id;
                            $data['update']['quantity'] = $qty;
                            $data['update']['price'] = $price;
                            $data['update']['discount_per'] = $discount;
                            $data['update']['discount_price'] = $price - $discount_price;
                            if(isset($max_order_qty) && $max_order_qty!='' && $max_order_qty!=0){
                                $data['update']['max_order_qty'] = $max_order_qty;                                    
                            }
                            $data['table'] = 'product_weight';
                            $data['where']['id'] =  $firstVarient_id;
                        }
                        if ($type == 'Old') {   
                            
                            $Varient_id = $Varient[$i]->id;  
                            $data['update']['quantity'] = $qty;
                            $data['update']['price'] = $price;
                            $data['update']['discount_per'] = $discount;
                            $data['update']['discount_price'] = $price - $discount_price;
                            if(isset($max_order_qty) && $max_order_qty!='' && $max_order_qty!=0){
                                $data['update']['max_order_qty'] = $max_order_qty;                                    
                            }
                            $data['table'] = 'product_weight';
                            $data['where']['id'] =  $Varient_id;

                        }

                      
                        $data['update']['dt_updated'] = strtotime(DATE_TIME);
                        $lastId = $this->updateRecords($data);
                       
                        $lastInsertedId = $lastId;

                    }else{
                        return false;
                    }
                    $i++;
                }
                // retrun 
            }
            return true;
        }else{
            return false;
        }
    }

    public function ProductVarient($productName){
        $data['table'] = TABLE_PRODUCT;
        $data['select'] = ['*'];
        $data['where'] = [
            'branch_id'=>$this->branch_id,
            'name'=>$productName,
            'status!='=>'9'
        ];
        $res = $this->selectRecords($data);
        $product_id = $res[0]->id;
        unset($data);

        $data['table'] = TABLE_PRODUCT_WEIGHT;
        $data['select'] = ['*'];
        $data['where'] = ['product_id'=>$product_id,'status!='=>'9'];
        return $this->selectRecords($data);
    }

    public function getTemopRecord(){
        $data['table'] = 'temp_product_weight as pw';
        $data['join'] = [
            'temp_product as p'=>['p.id=pw.product_id','LEFT'],
            'temp_product_image as pi'=>['pw.id=pi.product_variant_id','LEFT'],
            TABLE_WEIGHT . ' as w' =>['w.id=pw.weight_id','LEFT'],
            'package as pk'=>['pk.id=pw.package','LEFT']
        ];
        $data['select'] = ['p.name','pw.weight_no','w.name as weight_name','pw.price','pw.quantity','pw.discount_price','pw.discount_per','pk.package as package_name',];
        $data['where'] = ['p.branch_id'=>$this->session->userdata('id')];
        $result = $this->selectFromJoin($data);
        return $result;
    }

    public function insertExcelRecordParmanent(){
        $check = ''; 
        $tempRecords = $this->tempTableRecords('temp_product');
        foreach ($tempRecords as $key => $records) {
            $temp_product_id = $tempRecords[$key]->id;
            unset($tempRecords[$key]->id);
            $this->db->insert(TABLE_PRODUCT,$tempRecords[$key]);
            $product_id = $this->db->insert_id();
            $temp_product_weight = $this->tempTableRecords('temp_product_weight',['product_id'=>$temp_product_id]);
            $check++;
            foreach ($temp_product_weight as $k => $v) {
                $temp_varient_id = $temp_product_weight[$k]->id;
                unset($temp_product_weight[$k]->id);
                unset($temp_product_weight[$k]->$product_id);
                $v->product_id = $product_id;
                $this->db->insert(TABLE_PRODUCT_WEIGHT,$temp_product_weight[$k]);
                $variant_id = $this->db->insert_id();
                $temp_product_image = $this->tempTableRecords('temp_product_image',['product_variant_id'=>$temp_varient_id]);
                $check++;
                foreach ($temp_product_image as $tpik => $image) {
                    unset($temp_product_image[$tpik]->id);
                    unset($temp_product_image[$tpik]->product_variant_id);
                    $image->product_id = $product_id;
                    $image->product_variant_id = $variant_id;
                     $this->db->insert(TABLE_PRODUCT_IMAGE,$temp_product_image[$tpik]);
                    $check++;
                 } 
            }
        }
        return $check;

    }

    public function tempTableRecords($table,$where = ''){
        if(!empty($where) && $where != ''){
            $data['where'] = $where; 
        }
        $data['table'] = $table;
        $data['select'] = ['*'];
        return $this->selectRecords($data);

    }

}

?>