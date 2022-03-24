    <?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subscription extends MY_Controller    
{
    function __construct(){

        parent::__construct();
        $vendor_id = $this->session->userdata['id'];
        $this->load->model('subscription_model','this_model');
    }

    public function index(){
        if(!isset($_SESSION['super_admin']) && $this->session->userdata('super_admin') != '1'){
            redirect(base_url().'subscription/vendor_detail');
        }
        $this->load->view('subscription_list');
    }
    public function subscription_list()
    {
        $this->load->view('subscription_list');
    }


    public function subscription_profile()
    {
        $this->load->view('subscription_profile');
    }

    public function subscription_add_update()
    {
        $this->this_model->subscription_add_update();
    }
    public function subscription_detail()
    {
        $this->load->view('subscription_detail');
    }
    public function checkvendor()
    {

        $this->this_model->checkvendor();
    }
    public function vendor_detail(){
        if(isset($_SESSION['super_admin']) && $this->session->userdata('id') != ''){
            redirect(base_url().'subscription');
        }
        $data['getcurrency'] = $this->this_model->getcurrency();
        $data['subscription_result'] = $this->this_model->subscription_result();
        $this->load->view('vendor_subcription_detail');

    }
    public function get_date()
    {

        $this->this_model->get_date();
    }

//    public function single_delete_subCategory()
//    {
//
//        $this->this_model->single_delete_subCategory();
//    }
//    public function check_subcategory()
//    {
//        $this->this_model->check_subcategory();
//    }
//    public function multi_delete_subCategory()
//    {
//        $this->this_model->multi_delete_subCategory();
//    }
//    public function multi_deleted_subCategory()
//    {
//        $this->this_model->multi_deleted_subCategory();
//    }
}
?>