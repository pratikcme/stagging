<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// ini_set("display_errors", '1');
// error_reporting(E_ALL);
class Google_login extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('account/google_login_model');
        include_once APPPATH . "libraries/vendor/autoload.php";

    }

    function index(){
// die;
// echo '2';die;
        $common = $this->common_keys;
        $google_client_id = $common[0]->google_client_id;
        $google_secret_id = $common[0]->google_secret_id;

        $google_client = new Google_Client();

        $google_client->setClientId($common[0]->google_client_id); //Define your ClientID
        $google_client->setClientSecret($google_secret_id); //Define your Client Secret Key
        $google_client->setRedirectUri(base_url().'users_account/google_login'); //Define your Redirect Uri
        $google_client->addScope('email');

        $google_client->addScope('profile');
        if(isset($_GET["code"])){
            $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
        
            if(!isset($token["error"])){
                $google_client->setAccessToken($token['access_token']);
                $this->session->set_userdata('access_token', $token['access_token']);

                $google_service = new Google_Service_Oauth2($google_client);
                $data = $google_service->userinfo->get();
                $current_datetime = date('Y-m-d H:i:s');
                $this->load->model('account/google_login_model','google_login_model');
                $re = $this->google_login_model->Is_already_register($data['email']);

                if($re){
                //update data
                    $user_data = array(
                        // 'fname' => $data['givenName'],
                        // 'vendor_id'=>$this->session->userdata('vendor_id'),
                        // 'lname'  => $data['family_name'],
                        'gmail_token_id'=>$data['id'],
                        'login_type'=>'2',
                        'dt_updated' => strtotime(DATE_TIME)
                    ); 
                    $this->google_login_model->Update_user_data($user_data, $data['email']);

                }else{

                //insert data
                    $user_data = array(  
                        'gmail_token_id' => $data['id'],
                        'fname' => $data['givenName'],
                        'vendor_id'=>$this->session->userdata('vendor_id'),
                        'lname'  => $data['family_name'],
                        'login_type'  => '2',
                        'email' => $data['email'],
                        'status'=> '1',
                        'dt_added' => strtotime(DATE_TIME),
                        'dt_updated' => strtotime(DATE_TIME)
                    );
                    $re = $this->google_login_model->Insert_user_data($user_data);
                } 

                $login_data = array(
                    'user_id' => $re[0]->id,
                    'user_name' => $data['givenName'],
                    'user_lname' => $data['lname'],
                    'user_email' => $re[0]->email,
                    'user_phone' => $re[0]->phone,
                    'logged_in' => TRUE
                );

                $login_logs = [
                    'user_id' => $re[0]->id,
                    'vendor_id' => $re[0]->vendor_id,
                    'status' => 'facebook login',
                    'type' => 'user',
                    'dt_created' => DATE_TIME
                ];
                $this->load->model('api_v3/common_model','v2_common_model');
                $this->v2_common_model->user_login_logout_logs($login_logs);

                $this->session->set_userdata($login_data);


                if($this->session->userdata('user_id') != ''){
                    $this->load->model($this->myvalues->loginFrontEnd['model'],'that_model');
                    $this->that_model->manageCartItem();
                    if(isset($_SESSION['My_cart'][0]['branch_id'])){
                        $branch_id = $_SESSION['My_cart'][0]['branch_id'];
                        $this->load->model('frontend/vendor_model','vendor');
                        $branch = $this->vendor->getVendorName($vendor_id);
                        $branch_name = $branch[0]->name;
                        $vendor = array(
                            'vendor_id'=>$branch_id,
                            'vendor_name'=>$branch_name,
                        );
                        $this->session->set_userdata($vendor);
                    }
                }
                redirect(base_url());
            }
        }
    }

        public function logout(){
            $google_client = new Google_Client();
            $this->session->unset_userdata('access_token');
            $this->session->unset_userdata('oauth');
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('user_id');
            $this->session->sess_destroy();
            redirect(base_url());
        }
    } 
?>