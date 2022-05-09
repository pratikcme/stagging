<?php
class Category_model extends My_model{
    
    function __construct(){
        $this->branch_id = $this->session->userdata['id'];
    }

    public function categoryList(){
        $data['table'] = 'category';
        $data['select'] = ['*'];
        $data['where'] = [
            'status !=' => '9',
            'branch_id'=>$this->branch_id 
        ];
        $data['order'] = 'id DESC';
        return $this->selectRecords($data);
    }

    public function catProfile($id){
        $data['table'] = 'category';
        $data['select'] = ['*'];
        $data['where'] = [
            'id' => $id,
            'branch_id'=>$this->branch_id 
        ];
        return $this->selectRecords($data,true);   
    }

    public function checkIsCategoryAvailable($postData){
        // print_r($postData);die;
        $category_name =  trim($postData['name']);
        $id =  $postData['id'];
        $data['table'] = TABLE_CATEGORY;
        $data['where'] = ['name'=>$category_name,'id != '=>$id,'status!='=>'9','branch_id'=>$this->branch_id];
        $data['select'] = ['name'];
        $res = $this->selectRecords($data);
        if(!empty($res)){
            return 'false';
        }else{
            return 'true';
        }
    }



    ## Category Profile ##
    public function category_add_update(){
        
        $branch_id = $this->session->userdata['id'];
        
       if (isset($_REQUEST['submit'])){

            $id = $_REQUEST['id'];
            $name = $_REQUEST['name'];           
            if($id != ''){                
                $image = time().$_FILES['image_edit']['name'];
                /* New Image Upload */
                if($_FILES['image']['name'] != '' || $_FILES['image_edit']['name'] != '' ){

                    $query = $this->db->query("SELECT image FROM category WHERE id = '$id'");
                    $result = $query->row_array();
                    $old_image = $result['image'];

                    $url = './public/images/'.$this->folder.'category/'.$old_image;                    
                    unlink($url);
                    $url_thumb = './public/images/'.$this->folder.'category_thumb/'.$old_image;                    
                    unlink($url_thumb);
                    $upload_path_thumb = './public/images/'.$this->folder.'category_thumb';
                    imagepalettetotruecolor($image);
                    $uploadResponse_thumb = upload_single_image($_FILES,'image_edit',$upload_path_thumb);
                    
                    $upload_path = "./public/images/".$this->folder."category";
                    $uploadResponse = upload_single_image($_FILES,'image_edit',$upload_path);
                    $uploadResponse['data']['file_name'];
                    // print_r($uploadResponse['data']['file_name']);die;
                   
                    $this->image_resize_category($uploadResponse['data']['full_path'], $uploadResponse['data']['file_name']);
                  
                    $data = array(
                        'name' => trim($name),
                        'image' => $uploadResponse['data']['file_name'],
                        'dt_updated' => strtotime(date('Y-m-d H:i:s'))
                    );
                    $this->db->where('id',$id);
                    $this->db->where('branch_id',$this->branch_id);                    
                    $this->db->update('category',$data);
                    $this->session->set_flashdata('msg', 'Category has been updated successfully');
                    redirect(base_url().'category/category_list');
                    exit();
                }
                /* Old Image */
                else{

                    $data = array(
                        'name' => trim($name),
                        'dt_updated' => strtotime(date('Y-m-d H:i:s'))
                    );
                    $this->db->where('id',$id);
                    $this->db->where('branch_id',$this->branch_id);
                    $this->db->update('category',$data);
                    $this->session->set_flashdata('msg', 'Category has been updated successfully');
                    redirect(base_url().'category/category_list');
                    exit();
                }
            }
            ## Add Category ##
            else{

                if($_FILES['image']['name'] != ''){
                    $image = time().$_FILES['image']['name'];
                }else{
                    $image = '';
                }
                $upload_path = "./public/images/".$this->folder."category";
                imagepalettetotruecolor($image);
                $uploadResponse = upload_single_image($_FILES,'image',$upload_path);
                $uploadResponse['data']['file_name'];
                $this->image_resize_category($uploadResponse['data']['full_path'], $uploadResponse['data']['file_name']);
                
                
                $data = array(
                    'branch_id' => $this->branch_id,
                    'name' => trim($name),
                    'image' => $uploadResponse['data']['file_name'],
                    'status' => '1',
                    'dt_added' => strtotime(date('Y-m-d H:i:s')),
                    'dt_updated' => strtotime(date('Y-m-d H:i:s'))
                );
                $this->db->insert('category',$data);
                $this->session->set_flashdata('msg', 'Category has been added successfully');
                redirect(base_url().'category/category_list');
                exit();
            }
        }else{
            $this->session->set_flashdata('msg_error', 'Category can not be added.');
            redirect(base_url().'category/category_list');
        }
    }

    ## Category Image Resize Function ##
    public function image_resize_category($path, $file){

        $config_resize = array();
        $config_resize['image_library'] = 'gd2';
        $config_resize['source_image'] = $path;
        $config_resize['create_thumb'] = FALSE;
        $config_resize['maintian_ratio'] = TRUE;
        $config_resize['width'] = 300;
        $config_resize['height'] = 400;
        $config_resize['new_image'] = "./public/images/".$this->folder."category_thumb/".$file;
        $this->load->library('image_lib', $config_resize);
        $this->image_lib->resize();
    }



    public function check_category(){

       

         $id = $_GET['id']; 
        
        $this->db->select('*');
        $this->db->where_in('category_id',$id);
        $this->db->where('status !=','9');
        $this->db->where('branch_id',$this->branch_id);
        $this->db->from('brand');
        $query = $this->db->get();
       
        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            ob_get_clean();
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');

            echo json_encode(['status'=>2]);  
            exit;
        }
        
        $this->db->select('*');
        $this->db->where('category_id', $id);
        $this->db->where('status !=','9');
        $this->db->where('branch_id',$this->branch_id);
        $this->db->from('product');
        $query = $this->db->get();
       
        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            ob_get_clean();
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode(['status'=>3]);  
            exit;
        }

        $this->db->select('*');
        $this->db->where('category_id', $id);
        $this->db->where('status !=','9');
        $this->db->where('branch_id',$this->branch_id);
        $this->db->from('subcategory');
        $query = $this->db->get();
       
        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            ob_get_clean();
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo json_encode(['status'=>4]);  
            exit;
        }
           echo json_encode(['status'=>1]);
           exit; 

    }



    # Category Single Delete ##
   public function single_delete_category()
    {
       
         $id = $_GET['id']; 

        $updateData = array( 'status' => '9','dt_updated' => strtotime(date('Y-m-d H:i:s')));

        $data['table'] = 'category';
        $data['update'] = $updateData;
        $data['where'] = ['id'=>$id];
        $this->updateRecords($data);
        
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);  
       
        
        exit;
    }

    ## Category Multi Delete ##
    public function multi_delete_category()
    {

        $id = $_GET['ids'];
        $id = explode(",", $id);
        foreach ($id as $key => $value) {

            $this->db->select('*');
            $this->db->where_in('category_id',$value);
            $this->db->where('status !=','9');
            $this->db->where('branch_id',$this->branch_id);
            $this->db->from('brand');
            $query = $this->db->get();

           $this->db->select('name');
           $this->db->where('id =',$value);
           $this->db->from('category');
           $rows= $this->db->get();
           $row1 = $rows->row_array();

       // echo $this->db->last_query();exit;
            if ( $query->num_rows() > 0 )
            {
                $row = $query->row_array();
                
                ob_get_clean();
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');
                // echo json_encode(['status'=>2]);  
                $response = array('status'=>2,'names'=>$row1['name']);
                 echo json_encode($response);

                exit;
            }

            $this->db->select('*');
            $this->db->where('category_id', $value);
            $this->db->where('status !=','9');
            $this->db->where('branch_id',$this->branch_id);
            $this->db->from('subcategory');
            $query = $this->db->get();
           
            if ( $query->num_rows() > 0 )
            {
                $row = $query->row_array();
               

                ob_get_clean();
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');

                $response = array('status'=>4,'names'=>$row1['name']);
                 echo json_encode($response);
                // echo json_encode(['status'=>4]);  
                exit;
            }
        
            $this->db->select('*');
            $this->db->where('category_id', $value);
            $this->db->where('status !=','9');
            $this->db->where('branch_id',$this->branch_id);
            $this->db->from('product');
            $query = $this->db->get();
        
            if ( $query->num_rows() > 0 )
            {
                $row = $query->row_array();
                ob_get_clean();
                header('Access-Control-Allow-Origin: *');
                header('Content-Type: application/json');
                // echo json_encode(['status'=>3]); 
                $response = array('status'=>3,'names'=>$row1['name']);
                 echo json_encode($response); 
                exit;
            }

                          
            
        }

        echo json_encode(['status'=>1]);  
    }


     ## Category Multi Delete ##
    public function multi_deleted_category()
    {
        $id = $_GET['ids'];
      
        $id = explode(",", $id);
        foreach ($id as $value) {

             $date = strtotime(date('Y-m-d H:i:s'));

        $this->db->query("UPDATE category SET status = '9', dt_updated = '$date' WHERE id IN ($value)");

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
       

        }
        echo  json_encode(['status'=>1]);  
        exit;
    }


    public  $order_column_category = array("name"); 
    function make_query_category($postData){
   
        $where = [
            'branch_id'=>$this->branch_id,
            'status !='=>'9',  
        ];
         $this->db->select('*');  
         $this->db->from('category');
         $this->db->where($where);
         if(isset($postData["search"]["value"]) && $postData["search"]["value"] != ''){ 
        $this->db->group_start();
            $this->db->like("name", $postData["search"]["value"]);
            $this->db->group_end(); 
        }  
        
        if(isset($postData["order"]) && $postData["order"] != '' ){  
            $this->db->order_by($this->order_column_category[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }else{  
                $this->db->order_by('id', 'DESC');  
           } 
    }


    function make_datatables_category($postData){ 
        $this->make_query_category($postData);
       if($postData["length"] != -1){  
            $this->db->limit($postData['length'], $postData['start']);  
        }  
            $query = $this->db->get();  
            return $query->result();
           
        }

    function get_filtered_data_category($postData = false){  
        $this->make_query_category($postData);  
        $query = $this->db->get();  
        return $query->num_rows();
    }    

    function get_all_data_category(){
       $where = [
            'branch_id'=>$this->branch_id,
            'status !='=>'9',  
        ];
        $this->db->select("*");  
        $this->db->from('category');
        $this->db->where($where);
        return $this->db->count_all_results();   
    }

}
?>