<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Banner_promotion extends Admin_Controller
{
	 function __construct(){
        parent::__construct();
        // $vendor_id = $this->session->userdata['id'];
        $this->load->model('banner_promotion_model','this_model');
    }
    
	 public function index(){ 
        $this->load->view('banner_promotion_list',$data);
    }
    public function banner_promotion_list()
    {
        $data['vendor_list'] = $this->this_model->vendor_list();
        $data['js'] = array('banner_promotion.js');
        // $data['product_list'] = $this->this_model->product_list();
        $data['row'] = $this->this_model->getBannerImage();
        $this->load->view('banner_promotion_list',$data);
    }

    public function getVendorsProduct()
    {
        if($this->input->post()){
            $product_list = '<option value="">Select product</option>';
            $res = $this->this_model->getVendorsProduct($this->input->post());
            foreach ($res as $key => $value) {
                $product_list .= '<option value='.$value->id.'>'.$value->name.'</option>';
            }
            echo json_encode(['product_list'=>$product_list]);
        }
    }



    public function banner_promotion_add_update()
    {
        $this->this_model->banner_promotion_add_update($this->input->post());
    }
    public function single_delete_banner_promotion()
    {
        $this->this_model->single_delete_banner_promotion();
    }

    public function multi_delete_banner()
    {
        $ids = $_GET['ids'];
        $date = strtotime(date('Y-m-d H:i:s'));
        // $data = array('status' => '9', 'dt_updated' => strtotime(date('Y-m-d H:i:s')));

        $this->db->query("UPDATE banner_promotion SET status = '9', dt_updated = '$date' WHERE id IN ($ids)");

        // $this->db->WHERE_IN('id', $ids);
        // $this->db->UPDATE('banner_promotion', $data);

        // echo $this->db->last_query(); die;
        
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit;
    }

    public function bannerimage_drag(){
 
        $imageIdsArray = $_POST['imageIds'];

            $count = 1;
            foreach ($imageIdsArray as $id) {
                // echo "UPDATE banner_promotion SET image_order='$count' WHERE id='$id'";
                $this->db->query("UPDATE banner_promotion SET image_order='$count' WHERE id='$id'");
                
                $count ++;
            }
            echo "successfully";
    }

}
?>