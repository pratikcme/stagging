<?php
class Banner_promotion_model extends My_model{  

    function __construct(){
        
        $this->vendor_id = $this->session->userdata('vendor_admin_id'); 
    }

  private function set_upload_options_banner_promotion()
    {
        $config = array();
        $config['upload_path'] = './public/images/'.$this->folder.'banner_promotion/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = '0';
        $config['overwrite']     = TRUE;

        return $config;
    }

    ## Banner Promotion Add Update ##
    public function banner_promotion_add_update($postData){
       
        $vendor_id = $this->session->userdata('vendor_admin_id');
        $product_id = $postData['product_id'];

        if($_FILES['userfile']['name'][0] != ''){

            $this->load->library('upload');
            if($_FILES['userfile']['name'][0] != ''){

                ## Image Upload ##
                $this->load->library('upload');
                $files = $_FILES;
                $cpt = count($_FILES['userfile']['name']);

                for($i=0; $i<$cpt; $i++)
                {
                    $_FILES['userfile']['name']= time().$files['userfile']['name'][$i];
                    $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                    $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                    $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                    $_FILES['userfile']['size']= $files['userfile']['size'][$i];

                    $image_name = $_FILES['userfile']['name'];
                    $uploadedfile = $_FILES['userfile']['tmp_name'];

                    $explode = explode('.', $image_name);
                    $extension_image = $explode[1];

                    $extension = strtolower($extension_image);

                    if($extension=="jpg" || $extension=="jpeg" )
                    {
                        $uploadedfile = $_FILES['userfile']['tmp_name'];
                        $src = imagecreatefromjpeg($uploadedfile);
                    }
                    else if($extension=="png")
                    {
                        $uploadedfile = $_FILES['userfile']['tmp_name'];
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

                    $filename = "./public/images/".$this->folder."banner_promotion/". $image_name;
                    $filename1 = "./public/images/".$this->folder."banner_promotion_thumb/". $image_name;

                    imagejpeg($tmp,$filename,100);
                    imagejpeg($tmp1,$filename1,100);

                    $this->upload->initialize($this->set_upload_options_banner_promotion());
                    $this->upload->do_upload();
                   
                    $data = array(
                        'vendor_id' => $vendor_id,
                        'product_id' => $product_id,
                        'image_order' => '0',
                        'image' => $_FILES['userfile']['name'],
                        'status' => '1',
                        'dt_added' => strtotime(date('Y-m-d H:i:s')),
                        'dt_updated' => strtotime(date('Y-m-d H:i:s'))
                    );
                    $this->db->insert('banner_promotion',$data);
                }

                $this->session->set_flashdata('msg', 'Banner have been added successfully.');
                redirect(base_url().'banner_promotion/banner_promotion_list');
            }else{
                $this->session->set_flashdata('msg_error', 'Images could not be uploaded.');
                redirect(base_url().'banner_promotion/banner_promotion_list');
            }
        }else{
            $this->session->set_flashdata('msg_error', 'Images could not be uploaded.');
            redirect(base_url().'banner_promotion/banner_promotion_list');
        }
    }

    ## Banner Promotion Single Delete ##
    public function single_delete_banner_promotion()
    {
        // print_r($ids);die;
        $ids = $_GET['ids'];
        $data = array( 'status' => '9', 'dt_updated' => strtotime(date('Y-m-d H:i:s')) );

        $this->db->where('id', $ids);
        $this->db->update('banner_promotion', $data);

        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    public function getBannerImage(){
        $data['table'] = 'banner_promotion';
        $data['select'] = ['*'];
        $data['where'] = ['status!='=>'9','vendor_id'=>$this->vendor_id];
        $data['order'] = 'image_order';
        return $this->selectRecords($data);
        echo $this->db->last_query();die;
    }

    public function vendor_list(){
        $data['table'] = TABLE_BRANCH;
        $data['select'] = ['id','name','vendor_id'];
        $data['where'] = ['status'=>'1','vendor_id'=>$this->vendor_id];
        return $this->selectRecords($data);
    }

    public function getVendorsProduct($postData){
        $branch_id = $postData['branch_id'];
        $data['table'] = TABLE_PRODUCT;
        $data['select'] = ['*'];
        $data['where'] = ['branch_id'=>$branch_id,'status!='=>'9'];
        return $this->selectRecords($data);
    }



}
?>