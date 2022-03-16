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
            // echo $this->db->last_query();die;
            // echo "<pre>";
            // print_r($result);die;
            if($subCategory){
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
                    $this->utility->setFlashMessage('danger',"Brand does not exist.Excel is not uploaded!");
                    redirect(base_url().'import/import_excel');
                    die;
                }
            // echo 1;die;

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


                    if($subCategory != ''){
                        $getSub = $this->subcategory_list($categoryId, $subCategory);
                        // echo $this->db->last_query();
                        // print_r($getSub);die;
                        $subCategoryId = $getSub[0]['id'];
                    }

                    if($brandName != ''){
                        $getBrand = $this->brand_list($categoryId, $brandName);
                        // echo $this->db->last_query();die;
                        // print_r($getBrand);die;
                        $brandId = $getBrand[0]['id'];
                        // $brandId = '10';
                    }

                    // if($supplier != ''){
                    //     $getSupply = $this->supplier_list($supplier);
                    //     $supplierId = $getSupply[0]['id'];
                    // }

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
                        // print_r($images);die;
                        // ini_set('allow_url_fopen', '1');
            // echo $image;exit;

             // $ext = pathinfo($image, PATHINFO_EXTENSION);
            // print_r(file_get_contents($image),FILE_USE_INCLUDE_PATH);exit;
            // $data_filename = 'user_image_'.time().'.'.$ext;
            // $fileName = 'public/images/product_image_thumb/user_image_'.time().'.'.$ext;
            // $imageFromthird = file_put_contents($fileName,file_get_contents($image));

//                        $imgpath = base_url().'public/images/product_image/user_image_'.time().'.'.$ext;
//
//                        $ch = curl_init($imgpath);
//                        $fp = fopen($image, 'wb');
//                        curl_setopt($ch, CURLOPT_FILE, $fp);
//                        curl_setopt($ch, CURLOPT_HEADER, 0);
//                        curl_exec($ch);
//                        curl_close($ch);
//                        fclose($fp);
                    }
                    // echo $categoryId;die;
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
                            $data['table'] = 'product';
                            // print_r($data);die;
                            $lastId = $this->insertRecord($data);
                            $lastInsertedId = $lastId;
                            // echo $this->db->last_query();die;
                            // print_r($data);die;
                            unset($data);

                            goto a;
                        }

                        if ($type == 'Old') {

                            a:
                            $final_discount_price = '';

                            if ($dicount != '0') {
                                $discount_price_cal = (($retailPrice * $dicount) / 100);
                                $discount_price = number_format((float) $discount_price_cal, 2, '.', '');
                                $final_discount_price = number_format((float) $retailPrice - $discount_price, 2, '.', '');
                            } else {
                                $dicount = 0;
                                $final_discount_price = $retailPrice;
                            }
                            // echo $unitId .'/'.$packageId .'/'.$varient .'/'. $purchasePrice.'/'.$retailPrice.'/'.$qty;die;  
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
                                $data['insert']['discount_price'] = $final_discount_price;
                                $data['insert']['discount_allow'] = '1';
                                if(isset($max_order_qty) && $max_order_qty!='' && $max_order_qty!=0){
                                    $data['insert']['max_order_qty'] = $max_order_qty;                                    
                                }
                                $data['insert']['status'] = '1';
                                $data['insert']['dt_added'] = strtotime(date('Y-m-d H:i:s'));
                                $data['insert']['dt_updated'] = strtotime(date('Y-m-d H:i:s'));
                                $data['table'] = 'product_weight';
                                 // print_r($data);die;
                                $result = $this->insertRecord($data);

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
                                    $data['table'] = 'product_image';
                                    $res = $this->insertRecord($data);
                                }
                                unset($data);
                            }
                        }
                    }

                }
                // retrun 
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
        // $data['table'] = TABLE_CATEGORY;
        // $data['select'] = ['*'];
        // $data['where'] = [
        //     'name'=>$postData['category_name'],'status!='=>'9'
        // ];
        // $result = $this->selectRecords($data);
        // // echo $this->db->last_query();die;
        // $category_id = $result[0]->id;
        // unset($data);

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
        // $data['groupBy'] = 'p.id';
        return $return = $this->selectFromJoin($data);
        // echo $this->db->last_query();die;
    }

    public function UpdateProductQuantity(){
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

                    // echo $price .'/'. $discount;

                    $discount_price = ($price * $discount)/100; 

                    // print_r($discount_price);die;

                    $Varient = $this->ProductVarient($productName);

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
                            // if(($unitId !='') && ($varient !='') && ($qty !='')){
                            // }
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

                        // print_r($data);die;
                        $data['update']['dt_updated'] = strtotime(DATE_TIME);
                        $lastId = $this->updateRecords($data);
                        // if($row == 11){
                        //     echo $this->db->last_query();die;
                        // }
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

}

?>