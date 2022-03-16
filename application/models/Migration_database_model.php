<?php 
// error_reporting(E_ALL);
// ini_set("display_errors",1);
die;
Class Migration_database_model extends My_model{
	public function make_query(){
		// error_reporting(E_ALL);
		// ini_set("display_errors",1);
// 		$q = "admin,vendor,category,brand,subcategory,user,user_address,time_slot,product,product_weight,product_image,order,order_details,order_log,order_reservation,my_cart,about_section_one,about_section_two,about_us,about_us_banner_image,add_stock_order,banner_promotion,city,contact_info,contact_us,country,customer,customer_group,delivery_charge,delivery_notification,delivery_order,delivery_user,delivery_user_device,device,discount,faq,feedback,firebase,home_content,home_content_section_one_background,home_section_one,import_product_images,new_stock,notification,order_temp,package,parked_order,parked_order_details,payment_getway,payment_method,price,privacy_policy,profit,profit_taken,register,return_refund,selfPickup_otp,set_default,setting,staff,staff_device,subscription,supplier,term_conditions,user_product_review,web_banners,weight,wishlist";
		
// 		$q = 'category,brand,subcategory,user,user_address,product,product_weight,product_image,order,order_details,order_log,order_reservation,my_cart,,add_stock_order,banner_promotion,city,contact_info,contact_us,country,customer,customer_group,delivery_charge,delivery_notification,delivery_order,delivery_user,delivery_user_device,device,feedback,import_product_images,new_stock,notification,order_temp,parked_order,parked_order_details,payment_method,price,profit,profit_taken,register,selfPickup_otp,staff,staff_device,subscription,supplier,user_product_review,wishlist';

// 		$array = (explode(',',$q));
// 		foreach ($array as $key => $value) {
// 			if ($this->db->field_exists('vendor_id', "a1630btr_launchstore .".$value))
// 			{
// 				if($value != 'admin' && $value != 'vendor'){
// 					// $this->db->query('ALTER TABLE '."a1630btr_launchstore .".$value.' ADD vendor_id int(11) NOT NULL AFTER id');
// 					$this->db->query('ALTER TABLE '."a1630btr_launchstore .".$value.' CHANGE COLUMN vendor_id branch_id int(11)');
// 				}
// 			}
// 		}	
// die;	
		$db = ['a1630btr_bmart','a1630btr_bigbucket','a1630btr_laxmiraj','a1630btr_magnus','a1630btr_mehta','a1630btr_ogwrold','a1630btr_ori','a1630btr_rready','a1630btr_shukantea','a1630btr_unibest'];
		// dd($db);die;
		$db = ['a1630btr_bmart','a1630btr_shukantea','a1630btr_bigbucket','a1630btr_laxmiraj','a1630btr_magnus','a1630btr_mehta','a1630btr_ogwrold','a1630btr_ori'];

		$db = ['a1630btr_bmart','a1630btr_ori','a1630btr_shukantea','a1630btr_laxmiraj','a1630btr_bigbucket']; /*data already dump */

		$db = ['a1630btr_iwingzy'];
		// $q = "profit,profit_taken,";

		// $notInUserTable = 'add_stock_order,currency,order_reservation,profit,profit_taken';
// die;
		$q = 'vendor,category,subcategory,brand,user,user_address,time_slot,contact_info,return_refund,package,weight,product,product_weight,product_image,discount,delivery_charge,delivery_user,staff,home_content,home_section_one,home_section_one,import_product_images,home_content_section_one_background,faq,term_conditions,privacy_policy,feedback,firebase,payment_method,price,about_section_one,about_section_two,about_us,about_us_banner_image,web_banners,banner_promotion,set_default,setting,order,new_stock,user_product_review,wishlist,delivery_order,delivery_notification,notification,city,order_temp,order_log,contact_us';

		$admin = FALSE;	
		// die;

		// $q = 'admin';	

		// $q = 'admin';	
		// $admin = TRUE;	
// echo 'please remove die';die;
		// $q = 'product_image';
		$array = (explode(',',$q));
		// dd($array);die;
		$server_name = ['iwingzy.in','iwingzy.launchestore.com','shukantea.launchestore.com','laxmiraj.launchestore.com','iwingzy.launchestore.com','ori.launchestore.com','ogworld.launchestore.com','laxmiraj.launchestore.com','bigbucket.launchestore.com','shukantea.launchestore.com','bmart.launchestore.com','ori.launchestore.com','bigbucket.launchestore.com','laxmirajdryfruit.com','shukantea.com','ugiftonline.com','unibest.launchstore.com','rready.launchestore.com','ogworld.launchestore.com','mehta.launchestore.com','magnus.launchestore.com','laxmiraj.launchestore.com','wingzy.launchestore.com','bigbucket.launchestore.com','shukantea.launchestore.com'];
	

		foreach ($db as $key => $database) {
			foreach ($array  as $k => $table) {
					$table_of_db = '';
					$table_of_db = $database.'.'.$table;
					$data['table'] = $table_of_db;
					$data['select'] = ['*'];
					$re = $this->selectRecords($data,true);
					unset($data);
					// echo "<pre>";
					// print_r($re);die;
					// echo $table_of_db ; die;
					foreach ($re as $keys => $value) {
						if($admin == TRUE && $keys == '1'){
							$value['server_name'] = $server_name[$key];
							continue;
						}
						if($table == 'admin' && $keys == 0){
							$value['server_name'] = $server_name[$key];
						}
					
						$data['table'] = 'a1630btr_launchstore.vendor';
						$data['select'] = ['id'];
						$data['order'] = 'id desc';
						$data['limit'] = '1';
						$data['where']['server_name'] = $server_name[$key];
						$ve_id = $this->selectRecords($data);
						unset($data);
						if(!empty($ve_id)){
							$value['vendor_id'] = $ve_id[0]->id;
							$data['where']['vendor_id'] = $ve_id[0]->id; 
						}
						$data['table'] = 'a1630btr_launchstore.branch';
						$data['select'] = ['id'];
						$data['order'] = 'id desc';
						$data['limit'] = '1';
						$branch_id = $this->selectRecords($data);
						unset($data);
						
						if(!empty($branch_id) && $table != 'admin' && $table != 'vendor'){
							if($table != 'currency'){
								$value['branch_id'] = $branch_id[0]->id;
							}  
						}
						

						if(($table == 'subcategory')){
							$name = $this->getTableIdByforignKey('',$database,$value['category_id'],'category','id');
							// echo $this->db->last_query()
							// print_r($name);die;
							// if($name[0]->name == 'Office Uniform'){
							// 	echo $this->db->last_query();
							// 	print_r($name);die;
							// }
							$category_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$name[0]->name,'category','name');
							$value['category_id'] = $category_id;

						}


						if($table == 'brand'){
							$brand = $this->getTableIdByforignKey('',$database,$value['id'],'brand','id');
							$cat = [];
							foreach (explode(',', $brand[0]->category_id) as $b => $v) {
								$r = $this->getTableIdByforignKey('',$database,$v,'category','id');
								if(!empty($r)){
									$catId = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$r[0]->name,'category','name');
								}
								array_push($cat, $catId);
							}
							$value['category_id'] = implode(',', $cat);
						}

						if($table == 'user_address'){
							$record = $this->getTableIdByforignKey('',$database,$value['user_id'],'user','id');
							if(!empty($record)){
								if($record[0]->email != ''){
									$user_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$record[0]->email,'user','email');
								}else{
									$user_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$record[0]->apple_token_id,'user','apple_token_id');
								}
							}else{
								$user_id = 0;
							}
							$value['user_id'] = $user_id;
						}


						if($table == 'device'){
							$record = $this->getTableIdByforignKey('',$database,$value['user_id'],'user','id');
							if(!empty($record)){
								if($record[0]->email != ''){
									$user_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$record[0]->email,'user','email');
								}else{
									$user_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$record[0]->apple_token_id,'user','apple_token_id');
								}
							}else{
								$user_id = 0;
							}
							$value['user_id'] = $user_id;
						}

						

						if($table == 'customer'){
							$customerData = $this->getTableIdByforignKey('',$database,$value['group_id'],'customer_group','id');
							// print_r($productData);die;
							$group_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$customerData[0]->name,'customer_group','name');
							$value['group_id'] = $group_id;

						}

						if($table == 'delivery_user_device'){
							$deliveryData = $this->getTableIdByforignKey('',$database,$value['delivery_user_id'],'delivery_user','id');
							// print_r($productData);die;
					
							$delivery_user_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$deliveryData[0]->email,'delivery_user','email');

							$value['delivery_user_id'] = $delivery_user_id;

						}

						if($table == 'staff_device'){
							$staffData = $this->getTableIdByforignKey('',$database,$value['user_id'],'staff','id');
							// print_r($productData);die;
							$staff_id = $this->getIdByname('','a1630btr_launchstore',$staffData[0]->email,'staff','email');
							// echo $this->db->last_query();die;
							$value['user_id'] = $staff_id;

						}


						if($table == 'banner_promotion'){
							$productData = $this->getTableIdByforignKey('',$database,$value['product_id'],'product','id');
							$product_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$productData[0]->name,'product','name');
							// echo $this->db->last_query();
							// print_r($productData);die;

							$value['product_id'] = $product_id;

						}

						if($table == 'product_weight'){
							$productData = $this->getTableIdByforignKey('',$database,$value['product_id'],'product','id');
							$product_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$productData[0]->name,'product','name');
							// echo $this->db->last_query();die;
							// print_r($product_id);die;

							$weightData = $this->getTableIdByforignKey('',$database,$value['weight_id'],'weight','id');
							$weight_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$weightData[0]->name,'weight','name');
						
							$packageData = $this->getTableIdByforignKey('',$database,$value['package'],'package','id');

							$package_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$packageData[0]->package,'package','package');

							
							$value['product_id'] = $product_id;	
							$value['weight_id'] = $weight_id;	
							$value['package'] = $package_id;	

							
						}

						// if($table == 'product_image'){
							
						// 	$productData = $this->getTableIdByforignKey('',$database,$value['product_id'],'product','id');

						// 	$product_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$productData[0]->name,'product','name');
							
						// 	$varientData = $this->getDataByJoin('',$database,$value['product_variant_id'],'product','product_weight','id');


						// 	$data['table'] = 'a1630btr_launchstore.product as p';
						// 	$data['select'] = ['pw.id','p.name','pw.weight_id','pw.package','pw.weight_no','pw.dt_added'];
						// 	$data['join'] = [
						// 		'a1630btr_launchstore.product_weight as pw'=>['p.id=pw.product_id','LEFT']
						// 	];
						// 	if(isset($value['vendor_id'])) {
						// 		unset($value['vendor_id']);
						// 	}
						// 	// echo '<pre>';
						// 	// print_r($value);die;
						// 	$data['where']['p.id'] = $product_id;
						// 	// $data['where']['pw.id'] = $varientData[0]->id;
						// 	$data['where']['pw.branch_id'] = $value['branch_id'];
						// 	$data['where']['pw.status'] = '1';
						// 	$varient_id = $this->selectFromJoin($data);
						// 	unset($data);
						// 	// echo $this->db->last_query();
						// 	// print_r($varient_id);die;
						// 	// $varient_id = $this->getDataByJoin($value['vendor_id'],'a1630btr_launchstore',$varientData[0]->name,'product','product_weight','name');
						// 	$value['product_id'] = $product_id;	

						// 	unset($value['vendor_id']);
						// 	foreach ($varient_id as $index => $record) {
						// 		$value['product_variant_id'] = $record->id;	
						// 		if(isset($value['id'])){ 
						// 			unset($value['id']);
						// 		}
						// 		// if(isset($value['vendor_id'])) {
						// 		// 	$value['branch_id'] = $value['branch_id'];
						// 		// 	unset($value['vendor_id']);
						// 		// }
						// 		$data['table'] = 'a1630btr_launchstore.'.$table;
						// 		$data['insert'] = $value;
						// 		$this->insertRecord($data);
						// 	}
						// 	continue;

						// }


						if($table == 'product_image'){
							// echo "<pre>";
							$productData = $this->getTableIdByforignKey('',$database,$value['product_id'],'product','id');
							// echo $productData[0]->name;

							$product_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$productData[0]->name,'product','name');
							
							$varientData = $this->getDataByJoin('',$database,$value['product_variant_id'],'product','product_weight','id');

							$weightData = $this->getTableIdByforignKey('',$database,$varientData[0]->weight_id,'weight','id');
							$weight_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$weightData[0]->name,'weight','name');


							$packageData = $this->getTableIdByforignKey('',$database,$varientData[0]->package,'package','id');

							$package_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$packageData[0]->package,'package','package');


							
							$data['select'] = ['*'];
							$data['where'] = ['product_id'=>$product_id,'weight_id'=>$weight_id,'weight_no'=>$varientData[0]->weight_no,'price'=>$varientData[0]->price,'package'=>$package_id];
							$data['table'] = 'a1630btr_launchstore.product_weight';
							$varient_id = $this->selectFromJoin($data);
							if(empty($varient_id)){		
								unset($data['where']['price']);						
								$data['where']['price LIKE "'.$varientData[0]->price.'" AND 1 = '] = 1;
								$varient_id = $this->selectFromJoin($data);
								
							}
							// echo $this->db->last_query();
							// echo "<br>";

							$value['product_variant_id'] = $varient_id[0]->id;	
							if(isset($value['id'])){ 
								unset($value['id']);
							}

							
							if(isset($value['vendor_id'])) {
								unset($value['vendor_id']);
							}
							
							unset($data);
							$value['product_id'] = $product_id;	

							unset($value['vendor_id']);
							$data['table'] = 'a1630btr_launchstore.'.$table;
							$data['insert'] = $value;
							$this->insertRecord($data);
							
							continue;

						}



						if($table == 'product'){

							$cateData = $this->getTableIdByforignKey('',$database,$value['category_id'],'category','id');
							$category_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$cateData[0]->name,'category','name');

							
							$subData = $this->getTableIdByforignKey('',$database,$value['subcategory_id'],'subcategory','id');

							$subcategory_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$subData[0]->name,'subcategory','name');
							
							$value['subcategory_id'] = $subcategory_id;
						
							$brandData = $this->getTableIdByforignKey('',$database,$value['brand_id'],'brand','id');
							$brand_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$brandData[0]->name,'brand','name');


							$value['category_id'] = $category_id;	
							$value['brand_id'] = $brand_id;	

							unset($data);
							if(isset($value['id'])){ unset($value['id']); }
							if (isset($value['vendor_id'])) {
								# code...
								unset($value['vendor_id']);
							}
							// echo '<pre>';
							// echo $table;
							// print_r($value);die;
							$data['table'] = 'a1630btr_launchstore.'.$table;
							$data['insert'] = $value;
							$last_insert_id = $this->insertRecord($data);
							continue;
						}

						if($table == 'my_cart'){

							$userData = $this->getTableIdByforignKey('',$database,$value['user_id'],'user','id');
							if(!empty($userData)){
								if($userData[0]->email != ''){
									$user_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$userData[0]->email,'user','email');
								}else{
									$user_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$userData[0]->apple_token_id,'user','apple_token_id');
								}
							}else{
								$user_id = 0;
							}
							
							$productData = $this->getTableIdByforignKey('',$database,$value['product_id'],'product','id');							

							$product_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$productData[0]->name,'product','name');
							

							$varientData = $this->getDataByJoin('',$database,$value['product_weight_id'],'product','product_weight','id');

							$varient_id = $this->getDataByJoin($value['branch_id'],'a1630btr_launchstore',$varientData[0]->name,'product','product_weight','name');

							$weightData = $this->getTableIdByforignKey('',$database,$value['weight_id'],'weight','id');
							$weight_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$weightData[0]->name,'weight','name');
							// print_r($weight_id);
							// echo $this->db->last_query();die;

							$value['user_id'] = $user_id;
							$value['product_id'] = $product_id;
							$value['product_weight_id'] = $varient_id[0]->id;	
							$value['weight_id'] = $weight_id;	
						}

						

						if($table == 'order'){
							$userData = $this->getTableIdByforignKey('',$database,$value['user_id'],'user','id');
							if(!empty($userData)){
								if($userData[0]->email != ''){
									$user_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$userData[0]->email,'user','email');
								}else{
									$user_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$userData[0]->apple_token_id,'user','apple_token_id');
								}
							}else{
								$user_id = 0;
							}

							// $user_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$userData[0]->email,'user','email');
							

							$customerData = $this->getTableIdByforignKey('',$database,$value['customer_id'],'customer','id');					

							if($value['customer_id'] != 0){
								$customer_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$customerData[0]->customer_name,'customer','customer_name');
							}else{
								$customer_id = '';
							}

							if($value['user_address_id'] != 0){

								$UserAddress = $this->getUserDataByAddressId('',$database,$value['user_address_id'],'user','user_address','id');
								if(empty($UserAddress)){
									$user_address_id = '0';
								}else{
									$user_address_id = $UserAddress[0]->id;
								}
								
							}else{
								$user_address_id = '0';
							}

							if($user_address_id != 0){

							$UserAddress = $this->getUserDataByAddressId('','a1630btr_launchstore',$user_address_id,'user','user_address','id');
							if(empty($UserAddress)){
								$user_address_id = '0';
							}else{
								$user_address_id = $UserAddress[0]->id;
							}
								// echo $this->db->last_query();die;
								// dd($UserAddress);die;
							}else{
								$user_address_id = '0';
							}

							if($value['time_slot_id']!=0){

								$TimeSlot = $this->getTableIdByforignKey('',$database,$value['time_slot_id'],'time_slot','id');
							 	$time_slot_id = $this->getTimeSlotIdByname($value['vendor_id'],'a1630btr_launchstore',$TimeSlot[0]->start_time,$TimeSlot[0]->end_time);
								$value['time_slot_id'] = $time_slot_id[0]->id;
								
							}
							//

							$value['user_id'] = $user_id;

							$value['user_address_id'] = $user_address_id;
							unset($value['vendor_id']);
							//get Order detail from orderId
							unset($data);
							$data['select']=['*'];
							$data['table'] = $database.'.'.'order_details';
							$data['where'] = ['order_id'=>$value['id']];
							$order_details = $this->selectRecords($data,true);	
							
							unset($data);
							if(isset($value['id'])){ unset($value['id']); }

							if(isset($value['branch_id'])) {
								// $value['branch_id'] = $value['branch_id'];
								unset($value['vendor_id']);
							}

							$data['table'] = 'a1630btr_launchstore.'.$table;
							$data['insert'] = $value;
							$new_order_id = $this->insertRecord($data);
							unset($data);


							foreach ($order_details as $order_detail_value) {
								$order_detail_value['order_id'] = $new_order_id;


								$userData = $this->getTableIdByforignKey('',$database,$order_detail_value['user_id'],'user','id');

								$user_id = $this->getIdByname($order_detail_value['vendor_id'],'a1630btr_launchstore',$userData[0]->email,'user','email');

								$productData = $this->getTableIdByforignKey('',$database,$order_detail_value['product_id'],'product','id');

								$product_id = $this->getIdByname($order_detail_value['branch_id'],'a1630btr_launchstore',$productData[0]->name,'product','name');								

								$varientData = $this->getDataByJoin('',$database,$order_detail_value['product_weight_id'],'product','product_weight','id');

								$varient_id = $this->getDataByJoin($order_detail_value['branch_id'],'a1630btr_launchstore',$varientData[0]->name,'product','product_weight','name');

								$weightData = $this->getTableIdByforignKey('',$database,$order_detail_value['weight_id'],'weight','id');
							
								$weight_id = $this->getIdByname($order_detail_value['vendor_id'],'a1630btr_launchstore',$weightData[0]->name,'weight','name');
								
								$order_detail_value['user_id'] = $user_id;
								$order_detail_value['product_id'] = $product_id;
								$order_detail_value['product_weight_id'] = $varient_id[0]->id;	
								$order_detail_value['weight_id'] = $weight_id;	

								if(isset($order_detail_value['id'])){ unset($order_detail_value['id']); }
								
								if(isset($order_detail_value['vendor_id'])) {
									$order_detail_value['branch_id'] = $order_detail_value['vendor_id'];
									unset($order_detail_value['vendor_id']);
								}
								$data['table'] = 'a1630btr_launchstore.order_details';
								$data['insert'] = $order_detail_value;
								// print_r($order_detail_value);die;
								$this->insertRecord($data);

							}

							continue;
						}

						if($table == 'delivery_order'){
							$Data = $this->getTableIdByforignKey('',$database,$value['order_id'],'order','id');
							$order_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$Data[0]->dt_added,'order','dt_added');
							unset($Data);

							$Data = $this->getTableIdByforignKey('',$database,$value['delivery_user_id'],'delivery_user','id');

							$delivery_user_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$Data[0]->dt_added,'delivery_user','dt_added');
							$value['order_id'] = $order_id;
							$value['delivery_user_id'] = $delivery_user_id;
						}

						if($table == 'delivery_notification'){

							$Data = $this->getTableIdByforignKey('',$database,$value['order_id'],'order','id');
							$order_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$Data[0]->dt_added,'order','dt_added');
							unset($Data);

							$Data = $this->getTableIdByforignKey('',$database,$value['delivery_user_id'],'delivery_user','id');
							$delivery_user_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$Data[0]->dt_added,'delivery_user','dt_added');
							
							$value['order_id'] = $order_id;
							$value['delivery_user_id'] = $delivery_user_id;
						}

						if($table == 'notification'){
							$Data = $this->getTableIdByforignKey('',$database,$value['for_id'],'order','id');
							$order_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$Data[0]->dt_added,'order','dt_added');
							unset($Data);

							$Data = $this->getTableIdByforignKey('',$database,$value['user_id'],'user','id');

							$user_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$Data[0]->email,'user','email');
							// echo $this->db->last_query();
							if($order_id != 0){
								$value['for_id'] = $order_id;
							}
							// print_r($Data);die;
							$value['user_id'] = $user_id;
						}

						if($table == 'selfPickup_otp'){
							$Data = $this->getTableIdByforignKey('',$database,$value['order_id'],'order','id');
						
							$order_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$Data[0]->dt_added,'order','dt_added');

							unset($Data);

							$Data = $this->getTableIdByforignKey('',$database,$value['user_id'],'user','id');

							$user_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',trim($Data[0]->email),'user','email');
							if($order_id != 0){
								$value['order_id'] = $order_id;
							}

							$value['user_id'] = $user_id;
						}

						if($table =='order_log'){
							$Data = $this->getTableIdByforignKey('',$database,$value['order_id'],'order','id');
							$order_id = $this->getIdByname($value['branch_id'],'a1630btr_launchstore',$Data[0]->dt_added,'order','dt_added');

							if($order_id != 0){
								$value['order_id'] = $order_id;
							}
						}

						// if($table == 'profit'){

						// 	$Data = $this->getTableIdByforignKey('',$database,$value['order_id'],'order','id');
						// 	if(!empty($Data)){
						// 		$order_id = $this->getIdByname($value['vendor_id'],'a1630btr_launchstore',$Data[0]->dt_added,'order','dt_added');
						// 		$value['order_id'] = $order_id;
						// 	}

						// 	unset($Data);
						// 	$Data = $this->getTableIdByforignKey('',$database,$value['order_detail_id'],'order_details','id');

						// 	if(!empty($Data)){
						// 		$data['table'] = 'a1630btr_launchstore.order_details';
						// 		$data['select'] = ['*'];
						// 		$data['where'] = [
						// 				'vendor_id'=>$value['vendor_id'],
						// 				'dt_added'=>$Data[0]->dt_added,
						// 				'product_id'=>$Data[0]->product_id,
						// 				'product_weight_id'=>$Data[0]->product_weight_id,
						// 				'weight_id'=>$Data[0]->weight_id,
						// 		];
						// 		$result = $this->selectRecords($data);
						// 		$value['order_detail_id'] = $result[0]->id;
						// 	}else{
						// 		$value['order_detail_id'] = 0;
						// 	}

						// }

						if($table =='firebase'){
							$value['delivery_firebase_key'] = 'AAAADd08Ixg:APA91bHiOyFrukeepGZmHSbLAX3F9UFf7XnAg8lejb3XUa_AkU31PJMb0QW3Ys1BSHs0LKHcXr6r85QjkQPWd7lEgtGBPBD2euCzhLwEDPgz01CE65lzDisNqbKV2-adX0xKBGfuKiRJ';

							$value['staff_firebase_key'] = 'AAAAYmVu0RM:APA91bGMSKZnWRlSZrDilKghySf-ywPbiyRgT5C0Gnfa4-TQRI-Bz7-RiKL6FbL632rbX7mNIszlDnJ1dAogf4GFOBaSRAi5NcxnRlOdXbAxhDVoVOjXiqfICuHPCpnlGysK4_Ygitx9';
							
							$value['firebase_node'] = 'LauncheStoreDelivery';
							$value['firebase_url'] = 'https://launchestoredelivery-default-rtdb.firebaseio.com/';
							$value['firebase_token'] = 'XylZHjphOd9Ezqor5zVGITOjvI5EOCkO6Hi6kwsT';
							$value['delivery_bandle_id'] = 'com.cme.launchestoredelivery';
							$value['staff_bandle_id'] = 'com.cme.launchestorestaff';
						}


						unset($data);
						if(isset($value['id'])){ unset($value['id']); }
						// if(isset($value['status']) && $value['status'] == '9'){ continue; }
						 if($table == 'vendor'){
						 	$table = 'branch';
						 }
						 if($table == 'admin'){
						 	$table = 'vendor';
						 }
						 if($table == 'subscription'|| $table == 'faq'|| $table == 'about_section_one' || $table == 'about_section_two' ||  $table == 'about_us' ||  $table == 'about_us_banner_image' ||  $table == 'banner_promotion' ||  $table == 'branch' ||  $table == 'city' ||  $table == 'weight' ||  $table == 'package' ||  $table == 'discount' ||  $table == 'privacy_policy' ||  $table == 'return_refund' ||  $table == 'feedback' ||  $table == 'time_slot' ||  $table == 'term_conditions' ||  $table == 'user' || $table == 'delivery_charge' || $table =='firebase' || $table == 'price' || $table == 'set_default'){

						 		$value['vendor_id'] = $ve_id[0]->id;
						 		unset($value['branch_id']);
						 }

						 if($table == 'currency'){
						 	unset($value['vendor_id']);
						 }

						if($table == 'delivery_notification' || $table == 'delivery_order' ||$table == 'delivery_user_device' || $table =='subcategory' || $table =='brand'|| $table =='category' || $table =='user_address' || $table == 'contact_info' || $table == 'product_weight' || $table == 'device' || $table == 'staff' || $table == 'staff_device' || $table == 'home_content' || $table == 'home_section_one' || $table == 'home_content_section_one_background' || $table == 'faq' || $table == 'payment_method' || $table == 'web_banners' || $table =='customer' || $table == 'customer_group' || $table =='register' || $table == 'setting' || $table == 'notification' || $table == 'selfPickup_otp' || $table == 'order_log' || $table == 'contact_us' || $table == 'delivery_user') {
								
								unset($value['vendor_id']);
						 }

						 if($key > 0 && $table == 'country'){
						 	unset($value['branch_id']);
						 	unset($value['vendor_id']);
						 	continue;
						 }
						 if($table == 'payment_getway'){
						 	unset($value['branch_id']);
						 	unset($value['vendor_id']);
						 }

						  if($table == 'vendor'){
						 	unset($value['vendor_id']);
						 }
						 // echo '<pre>';
						 // echo $table;
						 // print_r($value);die;
						$data['table'] = 'a1630btr_launchstore.'.$table;
						$data['insert'] = $value;
						$last_insert_id = $this->insertRecord($data);
						// echo $this->db->last_query();die;



						// if($table == 'subcategory'){
						// 	echo $this->db->last_query(); die;

						// }

						// die;
					}
			}
		}

	}


	function getTableIdByforignKey($vendor_id = '',$database,$param,$table,$field){








		if($table == 'vendor' && $database == 'a1630btr_launchstore'){
			$table = 'branch';
		}
		if($field == 'vendor_id' && $database == 'a1630btr_launchstore'){
			$field = 'branch_id';
		}
		if( $table == 'about_section_one' || $table == 'about_section_two' || $table == 'about_us' ||
			$table == 'about_us_banner_image' || $table == 'banner_promotion' || $table == 'branch' ||
			$table == 'city' ||  $table == 'my_cart' ||  $table == 'weight' ||  $table == 'package' ||
			$table == 'discount' || $table == 'privacy_policy' ||  $table == 'return_refund' ||
			$table == 'feedback' || $table == ' firebase' || $table == 'time_slot' || $table == ' term_conditions' || 
			$table == 'user' && ($database == 'a1630btr_launchstore')){

			$data['where']['vendor_id'] = $vendor_id;
		}
		if($vendor_id != ''){
			$data['where']['branch_id'] = $vendor_id;
		}else{
			unset($data['where']['vendor_id']);
		}





		// if($table != 'package'){
		// 	$data['where']['status!='] = '9';
		// }
		$data['table'] = $database.'.'.$table;
		$data['select'] = ['*'];
		$data['where'][$field] = $param;
		$re = $this->selectRecords($data);
		return $re;
	}

	function getIdByname($vendor_id ='',$database,$param,$table,$field){
		// if($vendor_id !=''){
		// 	$data['where']['branch_id'] = $vendor_id;
		// }
		if($table == 'vendor' && $database == 'a1630btr_launchstore'){
			$table = 'branch';
		}
		if($field == 'vendor_id' && $database == 'a1630btr_launchstore'){
			$field = 'branch_id';
		}

		if( $table == 'about_section_one' || $table == 'about_section_two' || $table == 'about_us' ||
			$table == 'about_us_banner_image' || $table == 'banner_promotion' || $table == 'branch' ||
			$table == 'city' ||  $table == 'my_cart' ||  $table == 'weight' ||  $table == 'package' ||
			$table == 'discount' || $table == 'privacy_policy' ||  $table == 'return_refund' ||
			$table == 'feedback' || $table == ' firebase' || $table == 'time_slot' || $table == ' term_conditions' || 
			$table == 'user' && ($database == 'a1630btr_launchstore')){

			$data['where']['vendor_id'] = $vendor_id;
		}else{
			
			if($vendor_id !=''){
				$data['where']['branch_id'] = $vendor_id;
			}
		}
		// if($table != 'package'){
		// 	$data['where']['status!='] = '9';
		// }
		$data['table'] = $database.'.'.$table;
		$data['select'] = ['*'];
		$data['where'][$field] = $param;
		$re = $this->selectRecords($data);
		if(!empty($re)){
			return $re[0]->id;
		}
		return 0;
	}

	function getDataByJoin($vendor_id = '',$database,$param,$table1,$table2,$field){
		if($vendor_id !=''){
			$data['where']['pw.branch_id'] = $vendor_id;
		}
		if($table1 == 'vendor' && $database == 'a1630btr_launchstore'){
			$table = $database.'.branch';
		}
		if($field == 'vendor_id' && $database == 'a1630btr_launchstore'){
			$field = 'branch_id';
		}
		// if($table1 != 'package'){
		// 	$data['where']['pw.'.'status!='] = '9';
		// }
		$data['table'] = $database.'.'.$table1 .' as p';
		$data['select'] = ['pw.id','p.name','pw.weight_id','pw.package','pw.price','pw.weight_no','pw.dt_added'];
		$data['join'] = [
			$database.'.'.$table2 .' as pw'=>['p.id=pw.product_id','LEFT']
		];
		if($database=='a1630btr_launchstore'){
			$data['where']['p.'.$field] = $param;
		}else{	
			$data['where']['pw.'.$field] = $param;
		}

		$re = $this->selectFromJoin($data);
		
		return $re; 
	}

	function getOrdreDataByJoin($vendor_id = '',$database,$param,$table1,$table2,$field){
		if($vendor_id !=''){
			$data['where']['pw.branch_id'] = $vendor_id;
		}
		if($table1 == 'vendor' && $database == 'a1630btr_launchstore'){
			$table = $database.'.branch';
		}
		if($field == 'vendor_id' && $database == 'a1630btr_launchstore'){
			$field = 'branch_id';
		}
		// if($table1 != 'package'){
		// 	$data['where']['pw.'.'status!='] = '9';
		// }
		$data['table'] = $database.'.'.$table1 .' as p';
		$data['select'] = ['pw.*'];
		$data['join'] = [
			$database.'.'.$table2 .' as pw'=>['p.id=pw.order_id','LEFT']
		];
		if($database=='a1630btr_launchstore'){
			$data['where']['p.'.$field] = $param;
		}else{	
			$data['where']['pw.'.$field] = $param;
		}

		$re = $this->selectFromJoin($data);
		
		return $re; 
	}

	function getUserDataByAddressId($vendor_id = '',$database,$param,$table1,$table2,$field){
		if($vendor_id !=''){
			$data['where']['pw.branch_id'] = $vendor_id;
		}
		if($table1 == 'vendor' && $database == 'a1630btr_launchstore'){
			$table = $database.'.branch';
		}
		if($field == 'vendor_id' && $database == 'a1630btr_launchstore'){
			$field = 'branch_id';
		}
		// if($table1 != 'package'){
		// 	$data['where']['pw.'.'status!='] = '9';
		// }
		$data['table'] = $database.'.'.$table1 .' as p';
		$data['select'] = ['pw.id','p.email'];
		$data['join'] = [
			$database.'.'.$table2 .' as pw'=>['p.id=pw.user_id','LEFT']
		];
		if($database=='a1630btr_launchstore'){
			$data['where']['p.'.$field] = $param;
		}else{	
			$data['where']['pw.'.$field] = $param;
		}

		$re = $this->selectFromJoin($data);
		
		return $re; 
	}
	function getTimeSlotIdByname($vendor_id,$database,$start_time,$end_time){
		
		$data['where']['t.vendor_id'] = $vendor_id;
	
		
		$data['table'] = $database.'.time_slot as t';
		$data['select'] = ['t.id'];
		$data['where']['t.start_time'] = $start_time;
		$data['where']['t.end_time'] = $end_time;

		$re = $this->selectRecords($data);
		
		return $re; 
	}
}
?>