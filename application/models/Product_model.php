<?php
class product_model extends My_model{
   

public function Product_add_update(){

        if (isset($_POST['submit'])){
            $branch_id = $this->session->userdata['id'];
            $id = $_POST['id'];
            $name = $_POST['name'];
            $category_id = $_POST['category_id'];
            $brand_id = $_POST['brand_id'];
            $subcategory_id = $_POST['subcategory_id'];
            // $image = time().$_FILES['image']['name'];
            $about = $_POST['about'];
            $content = $_POST['content'];
            $supplier_id = $_POST['supplier_id'];
            $gst = $_POST['gst'];
            $tags = $_POST['tags'];
          
            ## Update Product ##
            if($id != ''){
                $image = time().$_FILES['image_edit']['name'];
                /* New Image Upload */
                if($_FILES['image_edit']['name'] != ''){

                    $query = $this->db->query("SELECT image FROM product WHERE id = '$id'");
                    $result = $query->row_array();
                    $old_image = $result['image'];

                    $url = './public/images/'.$this->folder.'product/'.$old_image;
                    $url_thumb = './public/images/'.$this->folder.'product_thumb/'.$old_image;
                    unlink($url);
                    unlink($url_thumb);

                    $product_thumb = "./public/images/".$this->folder."product_thumb";
                    $uploadResponse_thumb = upload_single_image($_FILES,'image_edit',$product_thumb);
                 
                    $upload_path = "./public/images/".$this->folder."product";
                    $uploadResponse = upload_single_image($_FILES,'image_edit',$upload_path);
                   

                    $this->image_resize_product($uploadResponse['data']['full_path'], $uploadResponse['data']['file_name']);

                    // echo "<br>";
                    $img = $uploadResponse['data']['file_name'];
                    $data = array(
                        'category_id' => $category_id,
                        'brand_id' => $brand_id,
                        'subcategory_id' => $subcategory_id,
                        'supplier_id' => $supplier_id,
                        'name' => $name,
                        'image' => $img,
                        'about' => $about,
                        'content' => $content,
                        'gst' => $gst,
                        'dt_updated' => strtotime(date('Y-m-d H:i:s'))
                    );
                    $this->db->where('branch_id',$branch_id);
                    $this->db->where('id',$id);
                    $this->db->update('product',$data);

                    
                    $this->session->set_flashdata('msg', 'Product has been updated successfully');
                    
                }
                /* Old Image */
                else{

                    $data = array(
                        'branch_id'=>$branch_id,
                        'category_id' => $category_id,
                        'brand_id' => $brand_id,
                        'supplier_id' => $supplier_id,
                        'subcategory_id' => $subcategory_id,
                        'name' => $name,
                        'about' => $about,
                        'content' => $content,
                        'gst' => $gst,
                        'dt_updated' => strtotime(date('Y-m-d H:i:s'))
                    );
                    $this->db->where('id',$id);
                    $this->db->where('branch_id',$branch_id);
                    $this->db->update('product',$data);
                    $this->session->set_flashdata('msg', 'Product has been updated successfully');
                    
                }
                $data['where']['product_id'] = $id;
                $data['table'] = 'product_search';
                $this->deleteRecords($data);
                $tags = explode(',',$tags);
                $data['table'] = 'product_search';
                
                foreach($tags as $k => $val){
                   
                    $data['insert'] = [
                                'product_id'=>$id,
                                'name'=>$val,
                                'dt_created' =>date('Y-m-d H:i:s'),
                                'dt_updated' =>date('Y-m-d H:i:s'),

                            ];
                    $this->insertRecord($data);
                }
                redirect(base_url().'product/product_list');
                exit();
            }
            ## Add Product ##
            else{

                if($_FILES['image']['name'] != ''){ $image = time().$_FILES['image']['name']; }else{ $image = ''; }                
                 
                $upload_path = "./public/images/".$this->folder."product";
                $uploadResponse = upload_single_image($_FILES,'images',$upload_path);

               
                $this->image_resize_product($uploadResponse['data']['full_path'], $uploadResponse['data']['file_name']);

                $data = array(
                    'branch_id' => $branch_id,
                    'category_id' => $category_id,
                    'brand_id' => $brand_id,
                    'subcategory_id' => $subcategory_id,
                    'supplier_id' => $supplier_id,
                    'name' => $name,
                    'image' => $uploadResponse['data']['file_name'],
                    'about' => $about,
                    'content' => $content,
                    'status' => '1',
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s'))
                );
                $this->db->insert('product',$data);
                $id = $this->db->insert_id();
                $tags = explode(',',$tags);
                    $data['table'] = 'product_search';
                    foreach($tags as $val){
                        $data['insert'] = [
                                    'product_id'=>$id,
                                    'name'=>$val,
                                    'dt_created' =>date('Y-m-d H:i:s'),
                                    'dt_updated' =>date('Y-m-d H:i:s'),

                                ];  
                        $this->insertRecord($data);
                    }

                $this->session->set_flashdata('msg', 'Product has been added successfully');
                redirect(base_url().'product/product_list');
                exit();
            }
        }else{
            $this->session->set_flashdata('msg_error', 'Product can not be added.');
            redirect(base_url().'product/product_list');
        }
    }

    public function getProductName($product_id){
        $data['table'] = TABLE_PRODUCT;
        $data['where'] = ['id'=>$product_id];
        $data['select'] = ['name'];
        return $this->selectRecords($data);

    }

    ## Product Image Resize Function ##
    public function image_resize_product($path, $file){

        $config_resize = array();
        $config_resize['image_library'] = 'gd2';
        $config_resize['source_image'] = $path;
        $config_resize['create_thumb'] = FALSE;
        $config_resize['maintian_ratio'] = TRUE;
        $config_resize['width'] = 300;
        $config_resize['height'] = 400;
        $config_resize['new_image'] = "./public/images/".$this->folder."product_thumb/".$file;
        $this->load->library('image_lib', $config_resize);
        $this->image_lib->resize();
    }

    ## Get Brand List On Select Category ##
    public function get_brand(){
        $branch_id = $this->session->userdata['id'];
        $category_id = $_POST['category_id'];

        $brand_query = $this->db->query("SELECT * FROM brand WHERE category_id LIKE '%$category_id%' AND branch_id = '$branch_id' AND status != '9'");
        $brand_result = $brand_query->result();

        echo '<div class="form-group">';
            echo '<label for="">Brand<span class="required" aria-required="true"> * </span></label>';
            echo '<select name="brand_id" id="brand_id" class="form-control">';
                    echo '<option selected disabled value="">Select Brand</option>';
                    foreach($brand_result as $bra){
                        echo '<option value="'.$bra->id.'">' . $bra->name . '</option>';
                    }
            echo '</select>';
        echo '</div>';
    }
    public function get_subCategory(){
        $branch_id = $this->session->userdata['id'];
        $category_id = $_POST['category_id'];

        $subcategory_query = $this->db->query("SELECT * FROM subcategory WHERE category_id = '$category_id' AND branch_id = '$branch_id' AND status != '9'");
        $subcategory_result = $subcategory_query->result();

        echo '<div class="form-group">';
            echo '<label for="">Subcategory<span class="required" aria-required="true"> * </span></label>';
            echo '<select name="subcategory_id" id="subcategory_id" class="form-control">';
                    echo '<option selected disabled value="">Select subcategory</option>';
                    foreach($subcategory_result as $subcategory){
                        echo '<option value="'.$subcategory->id.'">' . $subcategory->name . '</option>';
                    }
            echo '</select>';
        echo '</div>';
    }

    public function checkProductVarient(){
        $id = $_GET['id'];
        $branch_id = $this->session->userdata('id');
        $data['table'] = 'order as o';
        $data['select'] = ['p.*'];
        $data['join'] = [ 'order_details as od'=>['od.order_id=o.id','LEFT'],
                          'product as p'=>['p.id = od.product_id','LEFT']
                      ];
        $data['where'] = ['o.branch_id'=>$branch_id,'p.id'=>$id,'o.order_status <'=>'7'];
        $re = $this->selectFromJoin($data);
        // print_r($re);die;
        // echo $this->db->last_query();die;
        if(count($re) > 0 ){

            ob_get_clean();
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');

            $response = array('status'=>5,'msg'=>"Product can not disabled,order is available for this product");
            echo json_encode($response);
           exit;
          
        } 
     
        echo json_encode(['status'=>1]);
         exit;
    }

    # Product Single Delete ##
    public function single_delete_product(){
        $id = $_GET['id'];

        $data = array( 'status' => '9','dt_updated' => strtotime(date('Y-m-d H:i:s')));
        $this->db->where('id', $id);
        $this->db->update('product', $data);
        
        $data['table'] = TABLE_PRODUCT_WEIGHT;
        $data['select'] = ['id'];
        $data['where']['product_id'] = $id;
        $varient_ids = $this->selectRecords($data);
        unset($data);
        //Product Delete Form Cart 
        foreach ($varient_ids as $key => $value) {
            $data['where'] = ['product_weight_id'=>$value->id];
            $data['table'] = 'my_cart';
            $this->deleteRecords($data);
        }
        
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }



        ## Product Multi Delete ##
    public function multi_delete_product()
    {
        // dd($_SESSION);
        $ids = $_GET['ids'];
        // print_r($ids);die;
        $id = explode(",", $ids);
        $a = [];
        $branch_id = $this->session->userdata('id');
        foreach ($id as $key => $value) {
            $data['table'] = 'order as o';
            $data['select'] = ['p.*'];
            $data['join'] = [ 
                'order_details as od'=>['od.order_id=o.id','LEFT'],
                'product as p'=>['p.id = od.product_id','LEFT']
            ];
            $data['where'] = ['o.branch_id'=>$branch_id, 'p.id'=>$value,'o.status !='=>'9'];
            $re = $this->selectFromJoin($data);
            if(count($re) > 0 ){

                ob_get_clean();
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');

                $response = array('status'=>5,'msg'=>"Product is not deleted,order is available for this product");
                echo json_encode($response);
                exit;
            } 
        }

        // delete Product from cart
        unset($data);
        foreach ($id as $k => $v) {

            $data['table'] = TABLE_PRODUCT_WEIGHT;
            $data['select'] = ['id'];
            $data['where']['product_id'] = $v;
            $varient_ids = $this->selectRecords($data);
            unset($data);
            
            $data['where'] = ['id'=>$v];
            $data['table'] = 'product';
            $this->deleteRecords($data);
            
            unset($data); 

            //Product Delete Form Cart 
            foreach ($varient_ids as $key => $value) {
                $data['where'] = ['product_weight_id'=>$value->id];
                $data['table'] = 'my_cart';
                $this->deleteRecords($data);
            }

            unset($data);
            
            ob_get_clean();
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode(['status'=>1]);
            exit;
    }
}

    private function set_upload_options_product_image()
    {
        $config = array();
        $config['upload_path'] = './public/images/'.$this->folder.'product_image/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = '0';
        $config['overwrite']     = TRUE;

        return $config;
    }

    ## Product Images Profile ##
    public function product_image_add_update($file,$product_id,$variant_id){
        $vendor_id = $this->session->userdata['id'];
       

        if($file['userfile']['name'][0] != ''){

            $this->load->library('upload');
            if($file['userfile']['name'][0] != ''){

                ## Image Upload ##
                $this->load->library('upload');
                $files = $file;
                $cpt = count($file['userfile']['name']);

                for($i=0; $i<$cpt; $i++)
                {
                    $file['userfile']['name']= time().$files['userfile']['name'][$i];
                    $file['userfile']['type']= $files['userfile']['type'][$i];
                    $file['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                    $file['userfile']['error']= $files['userfile']['error'][$i];
                    $file['userfile']['size']= $files['userfile']['size'][$i];

                    $image_name = $file['userfile']['name'];
                    $uploadedfile = $file['userfile']['tmp_name'];

                    $explode = explode('.', $image_name);
                    $extension_image = $explode[1];

                    $extension = strtolower($extension_image);

                    if($extension=="jpg" || $extension=="jpeg" )
                    {
                        $uploadedfile = $file['userfile']['tmp_name'];

                        $src = imagecreatefromjpeg($uploadedfile);
                    }
                    else if($extension=="png")
                    {
                        $uploadedfile = $file['userfile']['tmp_name'];
                        $src = imagecreatefrompng($uploadedfile);
                    }
                    else
                    {
                        $src = imagecreatefromgif($uploadedfile);
                    }
                 

                    list($width,$height)=getimagesize($uploadedfile);

                    $newwidth=300;
                    $newheight=($height/$width)*$newwidth;
                    $tmp=imagecreatetruecolor($newwidth,$newheight);

                    $newwidth1=400;
                    $newheight1=($height/$width)*$newwidth1;
                    $tmp1=imagecreatetruecolor($newwidth1,$newheight1);

                    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

                    imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);

                    $filename = "./public/images/".$this->folder."product_image/". $image_name;
                    $filename1 = "./public/images/".$this->folder."product_image_thumb/". $image_name;

                    imagejpeg($tmp,$filename,100);
                    imagejpeg($tmp1,$filename1,100);
                    // if($extension=="png")
                    // {
                    //     imagepng($tmp,$filename,100);
                    //     imagepng($tmp1,$filename1,100);
                    // }

                    $this->upload->initialize($this->set_upload_options_product_image());
                    $this->upload->do_upload();

                    $data = array(
                        'image_order'=>'0',
                        'branch_id' => $this->session->userdata('id'),
                        'image' => $file['userfile']['name'],
                        'product_id' => $product_id,
                        'product_variant_id' => $variant_id,
                        'status' => '1',
                        'dt_added' => strtotime(date('Y-m-d H:i:s')),
                        'dt_updated' => strtotime(date('Y-m-d H:i:s'))
                    );
                    $this->db->insert('product_image',$data);
                    // print_r($data);exit;
                }

               
            }
        }
    }

    ## Product Images Single Delete ##
    public function single_delete_product_image()
    {
         
         $ids = $_GET['ids'];
       
         $data['table'] = 'product_image';
         $data['select'] = ['image'];
         $data['where'] = ['id'=>$ids];
         $image = $this->selectRecords($data);
         $image = $image[0]->image;
         $img_url = './public/images/'.$this->folder.'product_image/'.$image;
         unlink($img_url);
         unset($data);
         $data['table'] = 'product_image';
         $data['where'] = ['id'=>$ids];
         $image = $this->deleteRecords($data);
           
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    /////////////////////////////////////////////PRODUCT WEIGHT/////////////////////////////////////////////////////////

    ## Product Weight Profile ##
    function delete_variant_image($variant_id){
         $data['table'] = 'product_image';
         $data['select'] = ['image'];
         $data['where']['product_variant_id'] = $variant_id;
         $image = $this->selectRecords($data);
         $image = $image[0]->image;
         $img_url = './public/images/'.$this->folder.'product_image/'.$image;
         unlink($img_url);
         unset($data);
         $data['table'] = 'product_image';
        $data['where']['product_variant_id'] = $variant_id;
        $image = $this->deleteRecords($data);


        return $image;
    }


    public function update_without_gst(){
        $this->load->model('api_v3/api_model','s');
        $data['table'] = TABLE_PRODUCT_WEIGHT;
        $data['select'] = ['*'];
        $re = $this->selectRecords($data);
        foreach ($re as $key => $value) {
            $gst_percent = $this->s->getProductGst($value->product_id);

           $gst_amount = ($value->discount_price * $gst_percent) / 100;
           // echo $gst_amount;die;
           $product_price_without_gst = $value->discount_price - $gst_amount;
           unset($data);

           $data['table'] =  TABLE_PRODUCT_WEIGHT;
           $data['update'] = ['without_gst_price'=>number_format((float)$product_price_without_gst, 2, '.', '') ];
           $data['where'] = ['id'=>$value->id];
           $this->updateRecords($data);
           // if($value->id == '3948'){
           //  echo $gst_amount;
           //  echo $product_price_without_gst;
           //   lq();
           // }
        }
    }   
    
    /*This code is used update database without_gst_price*/ 
    /*End this code is used update database without_gst_price*/

    public function product_weight_add_update(){

        // $this->update_without_gst();

        $vendor_id = $this->session->userdata['id'];
        $ven_id = $this->session->userdata['vendor_id'];
        $id = $_POST['id'];

        $product_id = $_POST['product_id'];

        $this->load->model('api_v3/api_model');
        $gst_percent = $this->api_model->getProductGst($product_id);

        $weight_id = $_POST['weight_id'];
        // $unit = number_format((float)$_POST['unit'], 2, '.', '');
        $unit = $_POST['unit'];
        $price = number_format((float)$_POST['price'], 2, '.', '');
        $quantity = $_POST['quantity'];
        $discount_per = $_POST['discount_per'];
        $purchase_price = $_POST['purchase_price'];
        $package = $_POST['package'];

        $discount_price_cal = (($price * $discount_per) / 100);
        $discount_price = number_format((float)$discount_price_cal, 2, '.', '');
        $final_discount_price = number_format((float)$price - $discount_price, 2, '.', '');
            $whole = floor($unit);      
            $fraction = $unit - $whole;
            if($fraction == 0){
                $unit = (int)$unit;   
            }
           $gst_amount = ($final_discount_price * $gst_percent) / 100;
           $product_price_without_gst = $final_discount_price - $gst_amount;
        
            /* Product Weight Update */
            if ($id != '') {

                $data = array(
                    
                    'product_id' => $product_id,
                    'weight_id' => $weight_id,
                    'weight_no' => $unit,
                    'package' => $package,
                    'purchase_price' => $purchase_price,
                    'price' => $price,
                    'quantity' => $quantity,
                    'discount_per' => $discount_per,
                    'without_gst_price'=>number_format((float)$product_price_without_gst, 2, '.', ''),
                    'discount_price' => $final_discount_price,
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                if(isset($_POST['max_order_qty'])){
                    $data['max_order_qty'] = $_POST['max_order_qty'];

                    $dt['update']['quantity'] = $_POST['max_order_qty'];
                    $dt['where'] = ['product_weight_id'=>$id,'quantity >'=>$_POST['max_order_qty']];
                    $dt['table'] = 'my_cart';
                    $this->updateRecords($dt);
                }
             
                $this->db->where('branch_id',$vendor_id);
                $this->db->where('id', $id);
                $this->db->update('product_weight', $data);
              
                if($_FILES['userfile']['error'][0] == 0){
                    
                    $files = $_FILES;
                    $path = 'public/images/'.$this->folder.'product_image/';
                    foreach ($files['userfile']['name'] as $key => $value) {

                        $_FILES['userfile']['name'] = $files['userfile']['name'][$key];
                        $_FILES['userfile']['type'] = $files['userfile']['type'][$key]; 
                        $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$key]; 
                        $_FILES['userfile']['error'] = $files['userfile']['error'][$key]; 
                        $_FILES['userfile']['size'] = $files['userfile']['size'][$key]; 
                        $imageData = upload_single_image($_FILES,'product_image',$path);
                        $image = $imageData['data']['file_name'];
                        $data['table'] = TABLE_PRODUCT_IMAGE;                     
                        $product_image = array(
                            'branch_id'=>$vendor_id,
                            'product_id'=>$product_id,
                            'image'=>$image,
                            'product_variant_id' =>$id,
                            'status'=>'1',
                            'dt_added'=>DATE_TIME,
                            'dt_updated'=>DATE_TIME,
                        );                      
                        $data['insert'] = $product_image;
                        // print_r($product_image);die;
                        $this->insertRecord($data);                    
                    }

                }

                $this->session->set_flashdata('msg', 'Product variant has been updated successfully');
                redirect(base_url() . 'product/product_weight_list?product_id='.$this->utility->encode($product_id));
               
                exit();
            }
            /* Product Weight Add */
            else {

                $data = array(
                    'branch_id' => $vendor_id,
                    'product_id' => $product_id,
                    'weight_id' => $weight_id,
                    'weight_no' => $unit,
                    'package' => $package,
                    'purchase_price' => $purchase_price,
                    'price' => $price,
                    'quantity' => $quantity,
                    'discount_per' => $discount_per,
                    'discount_price' => $final_discount_price,
                    'without_gst_price'=>number_format((float)$product_price_without_gst, 2, '.', ''),
                    'status' => '1',
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s')),
                );
                 if(isset($_POST['max_order_qty'])){
                    $data['max_order_qty'] = $_POST['max_order_qty'];
                }
                $this->db->insert('product_weight', $data);

                $variant_id = $this->db->insert_id();

                $files = $_FILES;
                    $path = 'public/images/'.$this->folder.'product_image/';
                    foreach ($files['userfile']['name'] as $key => $value) {
                        $_FILES['userfile']['name'] = $files['userfile']['name'][$key]; 
                        $_FILES['userfile']['type'] = $files['userfile']['type'][$key]; 
                        $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$key]; 
                        $_FILES['userfile']['error'] = $files['userfile']['error'][$key]; 
                        $_FILES['userfile']['size'] = $files['userfile']['size'][$key]; 
                        $imageData = upload_single_image($_FILES,'product_image',$path);
                        $image = $imageData['data']['file_name'];
                        $data['table'] = TABLE_PRODUCT_IMAGE;                     
                        $product_image = array(
                            'branch_id'=>$vendor_id,
                            'product_id'=>$product_id,
                            'image'=>$image,
                            'product_variant_id' =>$variant_id,
                            'status'=>'1',
                            'dt_added'=>DATE_TIME,
                            'dt_updated'=>DATE_TIME,
                        );                      
                        $data['insert'] = $product_image;
                        // print_r($product_image);die;
                        $this->insertRecord($data);                    
                    }
                // $this->product_image_add_update($_FILES,$product_id,$variant_id);

                $this->session->set_flashdata('msg', 'Product variant has been added successfully');
                redirect(base_url() . 'product/product_weight_list?product_id='.$this->utility->encode($product_id));
                // redirect(base_url() .'product/product_list');
                exit();
            }
        
    }
     public function check_product_varient_in_order(){

        $id = $_GET['id'];
        $vendor_id = $this->session->userdata('id');
        
        $data['table'] = 'order as o';
        $data['select'] = ['od.*'];
        $data['join'] = [ 'order_details as od'=>['od.order_id=o.id','LEFT']];
        $data['where'] = ['o.branch_id'=>$vendor_id,'od.product_weight_id'=>$id,'o.status !='=>'9','o.order_status <'=>'7'];
        $re = $this->selectFromJoin($data);
        if(count($re) > 0){

            ob_get_clean();
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');

            $response = array('status'=>5,'msg'=>'Product weight is not deleted.. Order available on this Product weight');
            echo json_encode($response);
            exit;
        }
        echo json_encode(['status'=>1]);
        exit;
     }   


    # Product Weight Single Delete ##
    public function single_delete_product_weight()
    {
        $id = $_GET['id'];
        $data = array( 'status' => '9','dt_updated' => strtotime(date('Y-m-d H:i:s')));

        $this->db->where('id', $id);
        $this->db->update('product_weight', $data);
        //variant delete 
        $data['where'] = ['product_weight_id'=>$id];
        $data['table'] = 'my_cart';
        $this->deleteRecords($data);
        lq();
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    ## Product Weight Multi Delete ##
    public function multi_delete_product_weight()
    {
        $id = $_GET['ids'];
        $ids = explode(",", $id);
        $date = strtotime(date('Y-m-d H:i:s'));
        $vendor_id = $this->session->userdata('id');
        $a = [];
        foreach ($ids as $key => $value) {
            $data['table'] = 'order as o';
            $data['select'] = ['p.name','od.*'];
            $data['join'] = [
                                'order_details as od'=>['od.order_id=o.id','LEFT'],
                                'product as p'=>['p.id = od.product_id','LEFT'],
                            ];
            $data['where'] = ['o.vendor_id'=>$vendor_id,'od.product_weight_id'=>$value];
            $re = $this->selectFromJoin($data);
            array_push($a, $re[0]->name);
                if(count($re) > 0){
                    ob_get_clean();
                    header('Access-Control-Allow-Origin: *');
                    header('Content-Type: application/json');
                    echo json_encode(['status'=> 5,'names'=>$a]);
                    exit;
                }
            }
            $this->db->query("UPDATE product_weight SET status = '9', dt_updated = '$date' WHERE id IN ($id)");
            
            //variant delete
            foreach ($ids as $k => $v) {
                $data['where'] = ['product_weight_id'=>$v];
                $data['table'] = 'my_cart';
                $this->deleteRecords($data);
             } 

            ob_get_clean();
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode(['status'=>1]);
            exit;
    
    }
   
    public  $order_column_product = array("name","c.name","sc.name","b.name");  
    function make_query_product($postData){
         $vendor_id = $this->session->userdata('id');
        if(!isset($postData["status"])){
            
            if(isset($postData['supplier_id'])){
              $supplier=$this->utility->decode($postData['supplier_id']);
                $where = [
                    'p.branch_id'=>$vendor_id,
                    'p.status !='=>'9',
                    'p.supplier_id' => $supplier  
                ];
            }else{
                $where = [
                    'p.branch_id'=>$vendor_id,
                    'p.status !='=>'9',
                ];
            }

        }else{
            $where = [

                    'p.branch_id'=>$vendor_id,
                    'p.status'=>$postData["status"],
                ];
        }
         $this->db->select('p.*,c.name as category_name,sc.name as subcategory_name,b.name as brand_name');  
         $this->db->from('product as p ');
         $this->db->join('category as c','c.id = p.category_id','left');
         $this->db->join('subcategory as sc','sc.id = p.subcategory_id','left');
         $this->db->join('brand as b','b.id = p.brand_id','left');
         $this->db->where($where);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
        $this->db->group_start();
            $this->db->like("p.name", $postData["search"]["value"]);
            $this->db->or_like("sc.name", $postData["search"]["value"]);
            $this->db->or_like("c.name", $postData["search"]["value"]);
            $this->db->or_like("b.name", $postData["search"]["value"]);
        $this->db->group_end(); 
        }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_product[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('p.id', 'DESC');  
           } 
    }


    function make_datatables_product($postData){ 
        $this->make_query_product($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            // echo $this->db->last_query();
        }

    function get_filtered_data_product($postData = false){  
        $this->make_query_product($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }    

    function get_all_data_product($postData = array()){
        $vendor_id = $this->session->userdata('id');
     if(!isset($postData["status"])){
            
            if(isset($postData['supplier_id'])){
              $supplier=$this->utility->decode($postData['supplier_id']);
                $where = [
                    'p.branch_id'=>$vendor_id,
                    'p.status !='=>'9',
                    'p.supplier_id' => $supplier  
                ];
            }else{
                $where = [
                    'p.branch_id'=>$vendor_id,
                    'p.status !='=>'9',
                ];
            }

        }else{
            $where = [

                    'p.branch_id'=>$vendor_id,
                    'p.status'=>$postData["status"],
                ];
        }
        $this->db->select('p.*,c.name as category_name,sc.name as subcategory_name,b.name as brand_name');  
         $this->db->from('product as p ');
         $this->db->join('category as c','c.id = p.category_id','left');
         $this->db->join('subcategory as sc','sc.id = p.subcategory_id','left');
         $this->db->join('brand as b','b.id = p.brand_id','left');
        $this->db->where($where);
        return $this->db->count_all_results(); 
           // echo $this->db->last_query();
    }


    


public  $order_column_weight_list = array("p.product_name","pw.quantity","pw.discount_price","pw.price","pw.discount_per",'pw.weight_no');  
    function make_query_weight_list($postData){
         $branch_id = $this->session->userdata('id');
        if(isset($postData['product_id'])){
          $product_id=$this->utility->decode($postData['product_id']);
            $where = [
                'p.branch_id'=>$branch_id,
                'pw.status !='=>'9',
                'pw.product_id' => $product_id  
            ];
        }else{
            $where = [
                'p.branch_id'=>$branch_id,
                'p.status !='=>'9',
            ];
        }
        $this->db->select('pw.*,pk.package,pw.discount_per, p.name as product_name, w.name as weight_name');  
        $this->db->from('product_weight as pw');
        $this->db->join('package as pk','pk.id = pw.package','left');
        $this->db->join('product as p','p.id = pw.product_id','left');
        $this->db->join('weight as w','w.id = pw.weight_id','left');
        $this->db->where($where);
        if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
        $this->db->group_start();
            $this->db->like("p.name", $postData["search"]["value"]);
            $this->db->or_like("pw.quantity", $postData["search"]["value"]);
            $this->db->or_like("pw.discount_price", $postData["search"]["value"]);
            $this->db->or_like("pw.price", $postData["search"]["value"]);
            $this->db->or_like("pw.discount_per", $postData["search"]["value"]);
            $this->db->or_like("pw.weight_no", $postData["search"]["value"]);
            $this->db->or_like("pk.package", $postData["search"]["value"]);
            $this->db->or_like("w.name", $postData["search"]["value"]);
        $this->db->group_end(); 
        }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_weight_list[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('pw.id', 'DESC');  
           } 
    }


    function make_datatables_weight_list($postData){ 
        $this->make_query_weight_list($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
            // echo $this->db->last_query();
        }

    function get_filtered_data_weight_list($postData = false){  
        $this->make_query_weight_list($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }    

    function get_all_data_weight_list($postData = array()){
        $branch_id = $this->session->userdata('id');
      if(isset($postData['product_id'])){
        $product_id=$this->utility->decode($postData['product_id']);
            $where = [
                'p.branch_id'=>$branch_id,
                'pw.status !='=>'9',
                'pw.product_id' => $product_id  
            ];
        }else{
            $where = [
                'p.branch_id'=>$branch_id,
                'p.status !='=>'9',
            ];
        }
        $this->db->select('pw.*,pk.package,pw.discount_per, p.name as product_name, w.name as weight_name');  
        $this->db->from('product_weight as pw');
        $this->db->join('package as pk','pk.id = pw.package','left');
        $this->db->join('product as p','p.id = pw.product_id','left');
        $this->db->join('weight as w','w.id = pw.weight_id','left');
        $this->db->where($where);
        return $this->db->count_all_results(); 
           // echo $this->db->last_query();
    }

     public function make_product_active($product_id){
        $data['table'] = TABLE_PRODUCT;
        $data['update'] = ['status'=>'1'];
        $data['where'] = ['id'=>$product_id];
        return $this->updateRecords($data);
    }

    public function checkForHardDelete(){
        $id = $_GET['id'];
        $branch_id = $this->session->userdata('id');
        $data['table'] = 'order as o';
        $data['select'] = ['p.*'];
        $data['join'] = [ 'order_details as od'=>['od.order_id=o.id','LEFT'],
                          'product as p'=>['p.id = od.product_id','LEFT']
                      ];
        $data['where'] = ['o.branch_id'=>$branch_id,'p.id'=>$id,'o.status !='=>'9'];
        $re = $this->selectFromJoin($data);
       
        if(count($re) > 0 ){

            ob_get_clean();
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');

            $response = array('status'=>5,'msg'=>"Product is not deleted,order is available for this product");
            echo json_encode($response);
            exit;
        } 
        echo json_encode(['status'=>1]);
         exit;
    }

    public function parmanentDeleteProduct(){
        $id = $_GET['id'];
        $data['table'] = TABLE_PRODUCT_WEIGHT;
        $data['select'] = ['id'];
        $data['where']['product_id'] = $id;
        $varient_ids = $this->selectRecords($data);
        
        unset($data);

        $data['where'] = ['id'=>$id];
        $data['table'] = 'product';
        $this->deleteRecords($data);

        unset($data);
        
        //Product Delete Form Cart 
        foreach ($varient_ids as $key => $value) {
            $data['where'] = ['product_weight_id'=>$value->id];
            $data['table'] = 'my_cart';
            $this->deleteRecords($data);
        }
        
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }
}
?>