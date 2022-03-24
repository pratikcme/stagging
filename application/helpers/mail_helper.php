<?php

function sendMail($data) {
    // print_r($data);die;
  $CI = &get_instance();
  
  $config = Array(
   'protocol' => 'smtp',
   'smtp_host' => '162.241.86.206',
   'smtp_port' => '587',
   'smtp_user' => 'test@launchestore.com', 
   'smtp_pass' => 'HhZ~sU(@drk_',
         // 'smtp_secure' => 'ssl',
   'mailtype' => 'html',
   'charset' => 'utf-8',
   'wordwrap' => TRUE
 );

  $CI = &get_instance();

  $CI->load->library('email', $config);
  $CI->email->initialize($config);
  $CI->email->set_newline("\r\n");
  $CI->email->from('test@launchestore.com', $CI->siteTitle);
  $CI->email->to($data['to']); 
  $CI->email->subject($data['subject']);
  $CI->email->message($data['message']);

  if($CI->email->send()){
    return true;
  } else {
    echo $CI->email->print_debugger(); die;
    return FALSE;
  }


}

function getMycartSubtotal(){
  $CI = &get_instance();
  $total = number_format((float)0,2,'.','');
  if($CI->session->userdata('user_id') == '' ){

    if(isset($_SESSION['My_cart'])){
      foreach ($_SESSION['My_cart'] as $key => $value) {
        $total += $value['total'];
      }
    }

  }else{

    $CI->load->model('frontend/product_model','product_model');
    $my_cart = $CI->product_model->getMyCart();
    foreach ($my_cart as $key => $value) {
     $total += $value->calculation_price; 
    }

  }
  $total = number_format((float)$total,2,'.','');
  return $total;
}

function totalSaving(){
  $CI = &get_instance();
  $total = 0;
  $saving = number_format((float)0,2,'.','');
  $totalSaving = 0;
if($CI->session->userdata('user_id') == '' ){
    if(isset($_SESSION['My_cart'])){
      foreach ($_SESSION['My_cart'] as $key => $value) {
        $total += $value['total'];
        $saving += $value['product_price'] * $value['quantity'];
      }
      $totalSaving = $saving-$total; 
    }
  }else{
     $CI->load->model('frontend/product_model','product_model');
     $my_cart = $CI->product_model->getMyCart();
     foreach ($my_cart as $key => $value) {
        $total += $value->calculation_price;
        $saving += $value->actual_price * $value->quantity;
     }
     $totalSaving = $saving-$total;
  }
  $totalSaving = number_format((float)$totalSaving,2,'.','');
  return $totalSaving;
}

function cartItemCount(){
  $CI = &get_instance();
  $count = 0;
  if ($CI->session->userdata('user_id') == '') {
    if(isset($_SESSION['My_cart'])){
      $count = count($_SESSION['My_cart']);
    }
  }else{
       $CI->load->model('frontend/product_model','product_model');
       $my_cart = $CI->product_model->getMyCart();
       $count = count($my_cart);
  }
  return $count;
}

function NavbarDropdown(){

  $html = '';
  $CI = &get_instance();
  $CI->load->model('common_model');
  $default_product_image =$CI->common_model->default_product_image();
  if($CI->session->userdata('user_id') == ''){

    if(isset($_SESSION['My_cart'])){
      foreach ($_SESSION['My_cart'] as $key => $value) {
        $encode_id=  $CI->utility->safe_b64encode($value['product_id']);
        $varient_id =  $CI->utility->safe_b64encode($value['product_weight_id']);
        if(!file_exists('public/images/'.$CI->folder.'product_image/'.$value["image"]) || $value["image"] == '' ){
          if(strpos($value["image"], '%20') === true || $value["image"] == ''){
            $value["image"] = $default_product_image;
          }
        }
      

        $html .= '<li>
        <a href='.base_url().'products/productDetails/'.$encode_id.'/'.$varient_id.'>
        <div class="cart-img-wrap">
        <img src='.base_url().'/public/images/'.$CI->folder.'product_image/'.$value["image"].'>
        </div>
        </a>
        <a href='.base_url().'products/productDetails/'.$encode_id.'/'.$varient_id.'>
        <div class="cart-detail-wrap">
        <h6>'.$value["product_name"].'</h6>
        <p><span>'.$value["quantity"].'</span> X '.number_format((float)$value['discount_price'], 2, '.', '').'</p>
        </div>
        </a>
        <a href="javescript:" class="remove_item" data-product_id='.$value["product_id"].' data-product_weight_id='.$value["product_weight_id"].'>
        <div class="cart-delete">
        <i class="fas fa-times-circle"></i>
        </div>
        </a>
        </li>';
      }
    }
  }else{
     $CI->load->model('frontend/product_model','product_model');
     $my_cart = $CI->product_model->getMyCart();
     foreach ($my_cart as $key => $value) {
        $product_image = $CI->product_model->GetUsersProductInCart($value->product_id,$value->product_weight_id);
        $product_image[0]->image = preg_replace('/\s+/', '%20', $product_image[0]->image);
        if(!file_exists('public/images/'.$CI->folder.'product_image/'.$product_image[0]->image) || $product_image[0]->image == '' ){
          if(strpos($product_image[0]->image, '%20') === true || $product_image[0]->image == ''){
            $product_image[0]->image = $default_product_image;
          }
        }
        
        $value->product_name = $product_image[0]->name;
        $value->image = $product_image[0]->image;
        
        $encode_id =  $CI->utility->safe_b64encode($value->product_id);
        $varient_id =  $CI->utility->safe_b64encode($value->product_weight_id);

        $html .= '<li>
        <a href='.base_url().'products/productDetails/'.$encode_id.'/'.$varient_id.'>
        <div class="cart-img-wrap">
        <img src='.base_url().'public/images/'.$CI->folder.'product_image/'.$value->image.'>
        </div>
        </a>
        <a href='.base_url().'products/productDetails/'.$encode_id.'/'.$varient_id.'>
        <div class="cart-detail-wrap">
        <h6>'.$value->product_name.'</h6>
        <p><span>'.$value->quantity.'</span> X '.number_format((float)$value->discount_price, 2, '.', '').'</p>
        </div>
        </a>
        <a href="javescript:" class="remove_item" data-product_id='.$value->product_id.' data-product_weight_id='.$value->product_weight_id.'>
        <div class="cart-delete">
        <i class="fas fa-times-circle"></i>
        </div>
        </a>
        </li>';
     }
  }
  return $html;
}
    
    function getAllBranch(){
        $CI = &get_instance();
        $CI->load->model('vendor_model');
        return  $CI->vendor_model->getAllVendor(); 
    }

     function sendMailSMTP($data) {
        $CI = &get_instance();
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "162.241.86.206";
        $config['smtp_port'] = '587';
        $config['smtp_user'] = "test@launchestore.com";
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
        $CI->email->from($config['smtp_user'], $CI->siteTitle);
        $CI->email->to($data["to"]);
        if (isset($data["bcc"])) {
            $CI->email->bcc($data["bcc"]);
        }
        $CI->email->reply_to($config['smtp_user'], '<noreply@stagegator.com>');
        $CI->email->subject($data["subject"]);
        $CI->email->message($message);
        $response = $CI->email->send();
        //      echo $this->email->print_debugger();
        // die;
        return true;
    }


 ?>