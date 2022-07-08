<?php

function getUsersList($TableData){
	$CI = &get_instance();
    $CI->load->model("Vendor_model",'this_model');  
    $library= $CI->load->library('utility');  
           $fetch_data = $CI->this_model->make_datatables_users($TableData);
           // print_r($fetch_data);
           $data = array();
           foreach($fetch_data as $row){  
                $sub_array = array();  
                $sub_array[] = $row->fname;  
                $sub_array[] = $row->lname;  
                $sub_array[] = $row->email;  
                $sub_array[] = $row->phone; 
                $sub_array[] = date('Y/m/d H:i',$row->dt_added); 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_users(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_users($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);  
     } 


function getCityAjaxDataTable($TableData){
  $CI = &get_instance();
    $CI->load->model('city_model','this_model');  
    $library= $CI->load->library('utility');  
           $fetch_data = $CI->this_model->make_datatables_city($TableData);
           // print_r($fetch_data);
           $data = array();
           foreach($fetch_data as $row){ 
            $checkbox = '<td class="hidden-phone">';
            if($row->id) { 
            $checkbox .= '<input type="checkbox" name="delete[]" id="iId" value='.$row->id.' class="checkbox_user">';
             } 
            $checkbox .= '</td>';



                $sub_array = array();  
                $sub_array[] = $checkbox;  
                $sub_array[] = $row->name;  
                $sub_array[] = '<a href='.base_url().'city/city_profile?id='.$CI->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                </a>
                <a href="javascript:;" onclick="single_delete('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i>
                </a>'; 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_city(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_city($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);  
     } 


function getAjaxPriceList($TableData){
  $CI = &get_instance();
    $CI->load->model('price_list_model','this_model');  
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_price($TableData);
           // print_r($fetch_data);die;

           $data = array();

           foreach($fetch_data as $row){ 

            $checkbox = '<td class="hidden-phone">';
            if($row->id){ 
            $checkbox .= '<input type="checkbox" name="delete[]" id="iId" value='.$row->id.' class="checkbox_user">';
             } 
            $checkbox .= '</td>';

            if($row->end_price == '9999999999'){
                $end_price =  '' ;
              }else{
                $end_price = $row->end_price;
              }


                $sub_array = array();  
                $sub_array[] = $checkbox;  
                $sub_array[] = $row->start_price;  
                $sub_array[] = $end_price;  
                $sub_array[] = '<a href='.base_url().'price_list/price_profile?id=' .$CI->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                </a>
                <a href="javascript:;" onclick="single_delete('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i>
                </a>'; 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_price(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_price($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);  
     } 

  function getPackageList($TableData){
    $CI = &get_instance();
    $CI->load->model('package_model','this_model');  
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_package($TableData);
           // print_r($fetch_data);die;

           $data = array();

           foreach($fetch_data as $row){ 

            $checkbox = '<td class="hidden-phone">';
            if($row->id){ 
            $checkbox .= '<input type="checkbox" name="delete[]" id="iId" value='.$row->id.' class="checkbox_user">';
             } 
            $checkbox .= '</td>';

                $sub_array = array();  
                $sub_array[] = $checkbox;  
                $sub_array[] = $row->package;    
                $sub_array[] = '<a href='.base_url().'package/package_profile?id='.$CI->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                </a>
                <a href="javascript:;" onclick="single_delete('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i>
                </a>'; 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_package(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_package($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);  
     }

  function getAjaxDiscountList($TableData){
    $CI = &get_instance();
    $CI->load->model('Vendor_model','this_model');  
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_discount($TableData);
           // print_r($fetch_data);die;

           $data = array();

           foreach($fetch_data as $row){ 

            $checkbox = '<td class="hidden-phone">';
            if($row->id){ 
            $checkbox .= '<input type="checkbox" name="delete[]" id="iId" value='.$row->id.' class="checkbox_user">';
             } 
            $checkbox .= '</td>';
            if($row->end_discount == '100'){
                $end_discount =  '';
              }else{
                $end_discount = $row->end_discount;
              }
                $sub_array = array();  
                $sub_array[] = $checkbox;  
                $sub_array[] = $row->start_discount;    
                $sub_array[] = $end_discount;    
                $sub_array[] = '<a href='.base_url().'admin/discount_profile?id=' .$CI->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                </a>
                <a href="javascript:;" onclick="single_delete('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i>
                </a>'; 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_discount(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_discount($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);  
     } 


  function getWeightListAjax($TableData){
    $CI = &get_instance();
    $CI->load->model('weight_model','this_model');  
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_weight($TableData);
           // print_r($fetch_data);die;
           $data = array();
           foreach($fetch_data as $row){ 

            $checkbox = '<td class="hidden-phone">';
            if($row->id){ 
            $checkbox .= '<input type="checkbox" name="delete[]" id="iId" value='.$row->id.' class="checkbox_user">';
             } 
            $checkbox .= '</td>';
                $sub_array = array();  
                $sub_array[] = $checkbox;  
                $sub_array[] = $row->name; 
                $sub_array[] = '<a href='.base_url().'weight/weight_profile?id=' . $CI->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                </a>
                <a href="javascript:;" onclick="single_delete('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i>
                </a>'; 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_weight(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_weight($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);  
     }


  function getTimeSlotAjax($TableData){
    $CI = &get_instance();
    $CI->load->model('weight_model','this_model');  
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_timeslot($TableData);
           $data = array();
           foreach($fetch_data as $row){ 

            $checkbox = '<td class="hidden-phone">';
            if($row->id){ 
            $checkbox .= '<input type="checkbox" name="delete[]" id="iId" value='.$row->id.' class="checkbox_user">';
             } 
            $checkbox .= '</td>';
                $sub_array = array();  
                $sub_array[] = $checkbox;  
                $sub_array[] = $row->start_time; 
                $sub_array[] = $row->end_time; 
                $sub_array[] = '<a href='.base_url().'time_slot/time_slot_profile?id='.$CI->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                </a>
                <a href="javascript:;" onclick="single_delete('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i>
                </a>'; 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_timeslot(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_timeslot($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);  
     } 


/*=========VENDOR ADMIN DATATABLES============*/

  function getCustomerlist($TableData){
    $CI = &get_instance();
    $CI->load->model('customer_model','this_model');
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_customer($TableData);
          // print_r($fetch_data);die;
           $data = array();
           foreach($fetch_data as $row){
           $gender = 'Female';
           if ($row->gender == 1) {
             $gender = 'Male';
           }
                $sub_array = array();  
                $sub_array[] = $row->customer_name;  
                $sub_array[] = $row->company; 
                $sub_array[] = $gender; 
                $sub_array[] = $row->phone; 
                $sub_array[] = $row->email; 
                $sub_array[] = $row->city; 
                $sub_array[] = $row->state; 
                $sub_array[] = $row->country; 
                $sub_array[] = $row->postcode; 
                $sub_array[] = '<a href='.base_url().'customer/edit_customer/?customerid=' .$CI->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                </a>
                <a href="javascript:;" onclick="single_delete('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i>
                </a>'; 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_customer(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_customer($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output); 

  }

  function getGrouplist($TableData){
    $CI = &get_instance();
    $CI->load->model('customer_model','this_model');
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_group($TableData);
          // print_r($fetch_data);die;
           $data = array();
           foreach($fetch_data as $row){
                $sub_array = array();  
                $sub_array[] = $row->name;  
                $sub_array[] = $row->dt_updated; 
                // customer/group_customer_view?id='.$group->id
                $sub_array[] = '<a href='.base_url().'customer/group_customer_view?id='.$row->id.' class="btn btn-primary btn-xs">View Customers</a>'; 
                $sub_array[] = '<a href="javascript:" onclick="type_update('.$row->id.')" data-toggle="modal" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                </a>
                <a href="javascript:;" onclick="single_delete('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i>
                </a>'; 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_group(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_group($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output); 

  }

   function getStaffListAjax($TableData){
    $CI = &get_instance();
    $CI->load->model('vendor_model','this_model');  
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_staff($TableData);
          $data = array();
          $start = $TableData['start']+1;
           foreach($fetch_data as $row){ 
            if($row->status == 1){
              $status = '<input type="button" data-val='.$CI->utility->encode($row->id).' class="vendor_status btn btn-primary btn-xs" value="active">';
            }else{
              $status = '<input type="button" data-val='.$CI->utility->encode($row->id).' class="vendor_status btn btn-danger btn-xs" value="In-active">';
            }
                $sub_array = array();  
                $sub_array[] = $start++;  
                $sub_array[] = $row->name; 
                $sub_array[] = $row->phone_no; 
                $sub_array[] = $row->email;
                $sub_array[] =  $status;
                $sub_array[] = '<a href='.base_url().'staff/add_staff?id='.$CI->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                </a>'; 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_staff(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_staff($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);
  }

   function getAjaxCategory($TableData){
    $CI = &get_instance();
    $CI->load->model('category_model','this_model');  
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_category($TableData);
          // print_r($fetch_data);die;
           $data = array();
           foreach($fetch_data as $row){ 
            $checkbox = '<td class="hidden-phone">';
            if($row->id){ 
              $checkbox .= '<input type="checkbox" name="delete[]" id="iId" value='.$row->id.' class="checkbox_user">';
             }
              $checkbox .= '</td>';
            if($row->image != ''){ 
               $image = '<img src='.base_url()."public/images/".$CI->folder."category/".$row->image.' height="70" width="70">';
              }else{
              $image ='<img src='.base_url()."public/images/no_img.png".' height="70" width="70">';
              } 
                $sub_array = array();  
                $sub_array[] = $checkbox;  
                $sub_array[] = $row->name; 
                $sub_array[] = $image;
                $sub_array[] = '<a href='.base_url().'category/category_profile?id=' . $CI->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                </a>
                <a href="javascript:;" onclick="single_delete('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i>
                </a>'; 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_category(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_category($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);
  }

   function getSubcategoryAjax($TableData){
    $CI = &get_instance();
    $CI->load->model('category_model','this_model');  
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_subcategory($TableData);
          // print_r($fetch_data);die;
           $data = array();
           foreach($fetch_data as $row){ 
            $checkbox = '<td class="hidden-phone">';
            if($row->id){ 
              $checkbox .= '<input type="checkbox" name="delete[]" id="iId" value='.$row->id.' class="checkbox_user">';
             }
              $checkbox .= '</td>';
                $sub_array = array();  
                $sub_array[] = $checkbox;  
                $sub_array[] = $row->name; 
                $sub_array[] = $row->category_name; 
                $sub_array[] = '<a href='.base_url().'subCategory/subCategory_profile?id=' . $CI->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                </a>
                <a href="javascript:;" onclick="single_delete('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i>
                </a>'; 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_subcategory(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_subcategory($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);
  }

   function getBrandlistAjax($TableData){
    $CI = &get_instance();
    $CI->load->model('brand_model','this_model');  
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_brand($TableData);
          // print_r($fetch_data);die;
           $data = array();
           foreach($fetch_data as $row){
             $checkbox = '<td class="hidden-phone">';
            if($row->id){ 
              $checkbox .= '<input type="checkbox" name="delete[]" id="iId" value='.$row->id.' class="checkbox_user">';
             }
              $checkbox .= '</td>';
                $sub_array = array();  
                $sub_array[] = $checkbox;  
                $sub_array[] = $row->name; 
                $sub_array[] = $row->category; 
                $sub_array[] = '<a href='.base_url().'brand/brand_profile?id='.$CI->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                </a>
                <a href="javascript:;" onclick="single_delete('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i>
                </a>'; 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_brand(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_brand($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);
  }

   function getProductListAjax_old($TableData){
    $CI = &get_instance();
    $CI->load->model('product_model','this_model');  
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_product($TableData);
          // print_r($fetch_data);die;
           $data = array();
           foreach($fetch_data as $row){
             $checkbox = '<td class="hidden-phone">';
            if($row->id){ 
              $checkbox .= '<input type="checkbox" name="delete[]" id="iId" value='.$row->id.' class="checkbox_user">';
             }
              $checkbox .= '</td>';
                $sub_array = array();  
                $sub_array[] = $checkbox;  
                $sub_array[] = $row->name; 
                $sub_array[] = $row->category_name; 
                $sub_array[] = $row->subcategory_name; 
                $sub_array[] = $row->brand_name;  
                $sub_array[] = '<a style="margin: 10px;" href='.base_url().'product/product_weight_list?product_id='.$CI->utility->encode($row->id).' class="btn btn-success btn-xs">Variants
                </a>
                  <a href='.base_url().'product/product_image_list?product_id='.$CI->utility->encode($row->id).' class="btn btn-info btn-xs">Images
                  </a>
                  <a href='.base_url().'product/product_profile?id='.$CI->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                  </a>
                  <a href="javascript:;" onclick="single_delete_check('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i>
                  </a>';
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_product($TableData),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_product($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);
  }

  function getProductListAjax($TableData){
    $CI = &get_instance();
    $CI->load->model('product_model','this_model');  
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_product($TableData);
          // print_r($fetch_data);die;
           $data = array();
           foreach($fetch_data as $row){
             $checkbox = '<td class="hidden-phone">';
            if($row->id){ 
              $checkbox .= '<input type="checkbox" name="delete[]" id="iId" value='.$row->id.' class="checkbox_user">';
             }
              $checkbox .= '</td>';
                $sub_array = array();  
                $sub_array[] = $checkbox;  
                $sub_array[] = $row->name; 
                $sub_array[] = $row->category_name; 
                $sub_array[] = $row->subcategory_name; 
                $sub_array[] = $row->brand_name;  
                if($row->status != '9'){
                  $sub_array[] = '<a style="margin: 10px;"  href='.base_url().'product/product_weight_list?product_id='.$CI->utility->encode($row->id).' class="btn btn-success btn-xs">Variants
                  </a>
                    <a href='.base_url().'product/product_image_list?product_id='.$CI->utility->encode($row->id).' class="btn btn-info btn-xs">Images
                    </a>
                    <a href='.base_url().'product/product_profile?id='.$CI->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                    </a>
                    <a href="javascript:;" onclick="single_delete_check('.$row->id.')" class="btn btn-danger btn-xs">Disable</a>
                    <a href="javascript:;" onclick="single_hard_delete('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>';

                }else{
                  $sub_array[] = '<a href='.base_url().'product/make_product_active?product_id='.$CI->utility->encode($row->id).' class="btn btn-primary btn-xs">Active
                    </a>';
                }
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_product($TableData),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_product($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);
  }


   function getOrderListAjax($TableData){
    $CI = &get_instance();
    $CI->load->model('order_model','this_model');  
    $library= $CI->load->library('utility');  
    $fetch_data = $CI->this_model->make_datatables_order($TableData);

    $data = array();
        
        foreach($fetch_data as $row){
        $otp_status = $CI->this_model->checkSelfPickUpOtpIsVerified($row->id);
        $otp_status = $otp_status[0]->status;
        // dd($otp_status);
        $otp_status_not_selfpickup = $CI->this_model->checkOtpVerified($row->id);
        // print_r($otp_status);die; 
         $attr1 = '';$attr2 = '';$attr3 = '';$attr4 = '';$attr5 = '';
         $attr8 = '';$attr9 = ''; $otpAttr =""; $otpValue ="VerifyOtp";
         if($otp_status == '1' || $otp_status_not_selfpickup[0]->otp_verify == '1'){
            $otpAttr = 'disabled'; 
            $otpValue = 'Verified';
         }
         // if($row->isSelfPickup =='0'){
         //    $otpAttr = "disabled"; 
         //    $otpValue = 'Verified'; 
         // }
         $isRefunded = ($row->isRefunded == '1' || $row->payment_type == '0' ||  $row->order_status != '9') ? "disabled" : "" ;
         $val = ($row->isRefunded == 1) ? "Refunded" : "Refund" ;


          if($row->order_status=='1'){
              $rowcolor = "style='background-color: #014da2 !important; color: white; font-weight:bold;'";
              $attr1 = 'SELECTED';
          }elseif($row->order_status=='2'){
              $rowcolor = "style='background-color:#440e00 !important; color: white; font-weight:bold;'";
              $attr2 = 'SELECTED';
          }elseif($row->order_status=='3'){
              $rowcolor = "style='background-color:#2ac8ac !important; color: white; font-weight:bold;'";
              $attr3 = 'SELECTED';
          }elseif($row->order_status=='4'){
              $rowcolor = "style='background-color:#ff9626 !important; color: white; font-weight:bold;'";
              $attr4 = 'SELECTED';
          }elseif($row->order_status=='5'){
              $rowcolor = "style='background-color:#8f4ede !important; color: white; font-weight:bold;'";
              $attr5 = 'SELECTED';
          }elseif($row->order_status=='8'){
              $rowcolor = "style='background-color:#3da449 !important; color: white; font-weight:bold;'";
              $attr8 = 'SELECTED';
              // $otpAttr = 'disabled';
              // $otpValue = "verified";
          }else{
              $rowcolor = "style='background-color:#fe4552 !important; color: white; font-weight:bold;'";
              $attr9 = 'SELECTED';
              $otpAttr = 'disabled';
              $otpValue = "verified";
          } 
        ($row->payment_type == '0') ? $payment_type = 'COD' : $payment_type = 'Credit-card';
        ($row->order_from == '0') ? $type = "POS" : $type="Grocery";

    ($row->order_status=="9" || $row->order_status=="8"|| $row->order_status=="4") ? $d = 'disabled' : $d = '';

    $order_status = '<select '.$d. ' '.$rowcolor.' class="form-group order_status" data-id= '.$row->id.'>';
      if($row->order_status!='3'){
          $order_status .= '<option '.$attr1.' value="1">New Order
                </option>
                <option '.$attr2.' value="2">Pending</option>';
        }
        $order_status .= '<option '.$attr3.' value="3">Ready</option>
                <option '.$attr4.' value="4">Pick up</option>
                <option '.$attr5.' value="5">On the way</option>
                <option '.$attr8.' value="8">Delivered</option>
                <option '.$attr9.' value="9">Cancelled</option>
                </select>';
                $sub_array = array();  
                // $sub_array[] = $type;  
                $sub_array[] = ($row->isSelfPickup == "1") ? "Yes" : "No" ; 
                $sub_array[] = '<a target="_blank" href='.base_url().'order/order_detail?id='.$CI->utility->encode($row->id).'>'.$row->order_no.'</a>'; 
                $sub_array[] = date('Y m d H:i A',$row->dt_added); 
                $sub_array[] = $row->fname.' '.$row->lname; 
                $sub_array[] = $row->payable_amount; 
                $sub_array[] = $payment_type;  
                $sub_array[] = $order_status;  
                $sub_array[] = '<input type="button" class="otp btn btn-info btn-xs" '.$otpAttr.' data-is_self_pickup='.$row->isSelfPickup.' data-id='.$row->id.' value='.$otpValue.' >'; 
                $sub_array[] = '<button type="button" class="btn btn-primary order_log btn-xs" data-order_id = '.$row->id.' data-toggle="modal" data-target="#order-status">OrderLog</button>';
                $sub_array[] = '<input type="button" class="btn btn-success refund btn-xs" value='.$val.' '.$isRefunded.' data-payment_method='.$row->paymentMethod.' data-id='.$row->id.'>';  
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_order($TableData),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_order($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);
  }



   function supplierListAjax($TableData){
    $CI = &get_instance();
    $CI->load->model('supplier_model','this_model');  
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_supplier($TableData);
         // print_r($fetch_data); die;
           $data = array();
           foreach($fetch_data as $row){
                $sub_array = array();  
                $sub_array[] = $row->name;  
                $sub_array[] = $row->default_markup; 
                $sub_array[] = $row->fname; 
                $sub_array[] = $row->lname; 
                $sub_array[] = $row->company; 
                $sub_array[] = $row->email;  
                $sub_array[] = $row->phone;  
                $sub_array[] = $row->mobile;  
                $sub_array[] = $row->state;  
                $sub_array[] = '<a href='.base_url().'supplier/profile?id='.base64_encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i>
                </a>
                <a href="javascript:;" onclick="single_delete('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                <a href='.base_url().'product/index?supplier_id='.base64_encode($row->id).' class="btn btn-success btn-xs">View Products</a>'; 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_supplier($TableData),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_supplier($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);
  }


   function getProductWeightListAjax($TableData){
    $CI = &get_instance();
    $CI->load->model('product_model','this_model');  
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_weight_list($TableData);
        $product_id = $TableData['product_id'];
         // print_r($fetch_data); die;
           $data = array();
           foreach($fetch_data as $row){
             $checkbox = '<td class="hidden-phone">';
            if($row->id){ 
              $checkbox .= '<input type="checkbox" name="delete[]" id="iId" value='.$row->id.' class="checkbox_user">';
             }
              $checkbox .= '</td>';
                $sub_array = array();  
                $sub_array[] = $checkbox;  
                $sub_array[] = $row->product_name;  
                $sub_array[] = $row->weight_no.' '.$row->weight_name.' '.$row->package;
                $sub_array[] = $row->purchase_price; 
                $sub_array[] = $row->price; 
                $sub_array[] = $row->discount_per; 
                $sub_array[] = $row->quantity;  
                $sub_array[] = '<a href="javascript:;" onclick="single_delete_check('.$row->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                <a href='.base_url().'product/product_weight_profile?id='.$CI->utility->encode($row->id).'&product_id='.$product_id.' class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>'; 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_weight_list($TableData),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_weight_list($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);
  }


  function getInventoryReport($TableData){
  $CI = &get_instance();
    $CI->load->model('report_model','this_model');  
    $library= $CI->load->library('utility');  
           $fetch_data = $CI->this_model->make_datatables_Inventory_report($TableData);
           $data = array();
           $sno = $TableData['start']+1;
           foreach($fetch_data as $row){  
                $sub_array = array();  
                $sub_array[] = $sno++;  
                $sub_array[] = $row->name;  
                $sub_array[] = $row->weight_no.' '.$row->weight;;  
                $sub_array[] = $row->quantity;  
                $sub_array[] = $row->quantity * $row->discount_price;  
                $sub_array[] = $row->discount_price;  
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_Inventory_report(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_Inventory_report($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);  
     } 



  function GetVendorAccounting($TableData){
    $CI = &get_instance();
    $CI->load->model('vendor_model','this_model');  
    $library= $CI->load->library('utility');  
    $fetch_data = $CI->this_model->make_datatables_accounting($TableData);
          $data['profit_result'] = $CI->this_model->getProfits();
          $get_vendor = array();
        foreach ($data['profit_result'] as $key => $value) {
          $vendor = $value->vendor_id;
          if(isset($set_profit[$vendor]) && $set_profit[$vendor]!=''){
            $profit[$vendor] = $value->total_profit+$profit[$vendor];
          }else{    
            $profit[$vendor] = $value->total_profit;
            $set_profit[$vendor] = $value->total_profit;
          }
           $get_vendor[$vendor] = $profit[$vendor]; 
        }
        $data['profit_take_result'] = $CI->this_model->profit_query_take();
        // print_r($data['profit_take_result']);die;
        $get_vendor_profit = array();

      foreach ($data['profit_take_result'] as $key => $value) {
        $vendor = $value->vendor_id;
        if(isset($set_profit_taken[$vendor]) && $set_profit_taken[$vendor]!=''){
          $profit_taken[$vendor] = $value->profit+$profit_taken[$vendor];
        }else{    
          $profit_taken[$vendor] = $value->profit;
          $set_profit_taken[$vendor] = $value->profit ;
        }
         $get_vendor_profit[$vendor] = $profit_taken[$vendor]; 
      }
        $sno = $TableData['start']+1;
        $d = array();
           foreach($fetch_data as $row){ 
          (isset($get_vendor[$row->id])) ? $t_profits = $get_vendor[$row->id] : $t_profits = '0' ;
          (isset($get_vendor_profit[$row->id])) ? $t_received = $get_vendor_profit[$row->id] : $t_received = '0' ;

                $sub_array = array();  
                $sub_array[] = $sno++;  
                $sub_array[] = $row->name;  
                $sub_array[] = $row->owner_name;  
                $sub_array[] = $t_profits;  
                $sub_array[] = $t_received;  
                $sub_array[] = @$get_vendor[$row->id] - @$get_vendor_profit[$row->id];  
                $sub_array[] = '<a href='.base_url().'vendor/set_profit?id='.$CI->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-credit-card"></i></a>';  
                $d[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_accounting(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_accounting($TableData),  
                "data"                    =>     $d 
           );

           return json_encode($output);  
     } 

     function getSalesHistory($TableData){
        $CI = &get_instance();
        $CI->load->model('sell_development_model','this_model');  
        $library= $CI->load->library('utility');  
        $fetch_data = $CI->this_model->make_datatables_sell($TableData);
        // dd($fetch_data);die;
          $data = array();
           $sno = $TableData['start']+1;
           foreach($fetch_data as $row){
                $name = str_replace(' ', '_', $row->customer_name);
                $sub_array = array();  
                $sub_array[] = '<div><div><h5>'.$sno++.'</h5></div></div>';
                $sub_array[] = '<div>
                     <div>
                        <h5>'.date('d F Y H:m:ia',$row->dt_added).'</h5>
                     </div>
                  </div>'; 
                $sub_array[] = '<ul>
                     <li class="popover-list-item">
                        <a href="#">
                           <div class="customer-wrap">
                              <div class="profile-avatar">
                                 '.ucwords($row->customer_name[0]).'
                              </div>
                              <div class="list-items">
                                 <h4><a href="#">'.$row->customer_name.'</a></h4> 
                                 <p>'.$row->customercode.'</p>
                              </div>
                           </div>
                        </a>
                     </li>
                  </ul> ';
                $sub_array[] = ' <ul>
                     <li class="popover-list-item">
                        <a href="#">
                           <div class="customer-wrap">
                               <div class="profile-avatar">
                               '.ucwords($row->vendor_name[0]).'
                               </div>
                              <div class="list-items">
                                 <h4>'.$row->vendor_name.'</h4> 
                              </div>
                           </div>
                        </a>
                     </li>
                  </ul>';
                $sub_array[] = $row->payable_amount;   
                $sub_array[] = '<span data-toggle="modal" class="orderDetails" data-target="#view" data-order_id='.$CI->utility->safe_b64encode($row->id).' ><i class="fa fa-eye" aria-hidden="true"></i></span>
                  <span class="remove" data-order_id='.$CI->utility->safe_b64encode($row->id).'><i class="fa fa-trash" aria-hidden="true"></i></span>';   
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_sell(),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_sell($TableData),  
                "data"                    =>     $data  
           );

            return json_encode($output);
     } 


  function showProductOnOffer($TableData){
    // print_r($TableData);die;
    $CI = &get_instance();
    $CI->load->model('product_model','this_model');  
    $library= $CI->load->library('utility');  
          $fetch_data = $CI->this_model->make_datatables_offer_product($TableData);
         // print_r($fetch_data); die;
        // $product_id = $TableData['product_id'];
           $data = array();
           foreach($fetch_data as $row){
             $checkbox = '<td class="hidden-phone">';
            if($row->id){ 
              $checkbox .= '<input type="checkbox" name="product_varient_id[]" id="iId" value='.$row->id.' class="checkbox_user">';
             }
              $checkbox .= '</td>';
                $sub_array = array();  
                $sub_array[] = $checkbox;  
                $sub_array[] = $row->product_name;  
                $sub_array[] = $row->price; 
                $sub_array[] = $row->discount_per; 
                $sub_array[] = $row->weight_no; 
                $sub_array[] = $row->weight_name; 
                // $sub_array[] = $row->package; 
                // $sub_array[] = $row->weight_no.' '.$row->weight_name.' '.$row->package;
                // $sub_array[] = $row->purchase_price; 
                // $sub_array[] = $row->quantity;  
                $sub_array[] = '<a href='.base_url().'offer/view/'.$CI->utility->encode($row->id).' class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>'; 
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($TableData["draw"]),  
                "recordsTotal"          =>      $CI->this_model->get_all_data_offer_product($TableData),  
                "recordsFiltered"     =>        $CI->this_model->get_filtered_data_offer_product($TableData),  
                "data"                    =>     $data  
           );

           return json_encode($output);
  }

    function getOrderSummaryListAjax($TableData){
      $CI = &get_instance();
      $CI->load->model('order_model','this_model');  
      $library= $CI->load->library('utility');  
      $fetch_data = $CI->this_model->make_datatables_order_summary($TableData);
      $data = array();
      foreach($fetch_data as $row){
        if($row->order_status=='1'){
              $order_status = "New order";
          }elseif($row->order_status=='2'){
              $order_status = "Pending";
          }elseif($row->order_status=='3'){
              $order_status = "Ready";
          }elseif($row->order_status=='4'){
              $order_status = "Pickup";
          }elseif($row->order_status=='5'){
              $order_status = "On the way";
          }elseif($row->order_status=='8'){
              $order_status = "Delivered";
          }else{
              $order_status = "Cancelled";
          } 
        ($row->payment_type == '0') ? $payment_type = 'COD' : $payment_type = 'Credit-card';
        $sub_array = array();  
        $sub_array[] =  $row->address; 
        $sub_array[] = '<a target="_blank" href='.base_url().'order/order_detail?id='.$CI->utility->encode($row->id).'>'.$row->order_no.'</a>'; 
        $sub_array[] = date('Y m d H:i A',$row->dt_added); 
        $sub_array[] = $row->fname.' '.$row->lname; 
        $sub_array[] = $row->payable_amount; 
        $sub_array[] = $payment_type;  
        $sub_array[] = '<span class="badge badge-warning">'.$order_status.'</span>';    
        $data[] = $sub_array;  
      }  
      $output = array(  
        "draw"                    =>     intval($TableData["draw"]),  
        "recordsTotal"          =>      $CI->this_model->get_all_data_order_summary($TableData),  
        "recordsFiltered"     =>        $CI->this_model->get_filtered_data_order_summary($TableData),  
        "data"                    =>     $data  
      );

      return json_encode($output);
    }

  
?>