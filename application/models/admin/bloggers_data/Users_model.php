<?php

class Users_model extends My_model{
  
	   public  $order_column = array(null, "fullname","email",'mobile');  
      function make_query($postData)  
      {    	
           $this->db->select('*');  
           $this->db->from(USERS);
           $this->db->having('user_type','2');  
           if(isset($postData["search"]["value"]))  
           {  
                $this->db->like("first_name", $postData["search"]["value"]); 
                $this->db->or_like("email", $postData["search"]["value"]); 
                $this->db->or_like("created_at", $postData["search"]["value"]); 
           }  
           if(isset($postData["order"]))  
           {  
                $this->db->order_by($this->order_column[$postData['order']['0']['column']], $postData['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('id', 'DESC');  
           }  
      }  
	      function make_datatables($postData){ 
	           $this->make_query($postData);  
	           if($postData["length"] != -1)  
	           {  
	                $this->db->limit($postData['length'], $postData['start']);  
	           }  
	           $query = $this->db->get();  
	           return $query->result();  
	      }  
	      function get_filtered_data($postData = false){  
	           $this->make_query($postData);  
	           $query = $this->db->get();  
	           return $query->num_rows();  
	      }       
	      function get_all_data()  
	      {  
	           $this->db->select("*");  
	           $this->db->from(USERS);
	           $this->db->where('user_type','2');    
	           return $this->db->count_all_results();  
	      } 

	      public function setStatus($id){
	      	$data['table'] = USERS; 
	      	$data['select'] = ['status','email'];
	      	$data['where']['id'] = $id;
	      	$res = $this->selectRecords($data);
	      	if($res[0]->status == "active"){
	      		$data['update']['status'] = 'inactive'; 
	      		$message = "Sorry!!! Your Account on blogcme is 
									temporarily Blocked for 15 days because you post a unnecessary content <br>Thanks<br>";
									$subject = 'Blocked';
	      	}else{
	      		$data['update']['status'] = 'active';
	      		$message = "congrats!!! Your Account on blogcme is 
									 Unblocked,Now You can continue with your post.<br>Thanks<br>";
									 $subject = 'Unblocekd';
	      	}
	      	  $data['update']['updated_at'] = DATE_TIME;
	      	  $result = $this->updateRecords($data);
	      	  unset($data);
	    //   	  if($result){
	    //   	  			$data['to'] = "sahid.cmexpertise@gmail.com";
					// 	$data['subject'] = $subject;
					// 	$data['message'] = $message;
					// 	$asd = sendMail($data);	
					// if ($asd) {
					// 	return ['success','Email send to the users registered email address'];
					// }
	    //   	  }
	      	  return $result;
	      }

	      	public function autoActiveDeactive(){

	      	$data['table'] = USERS; 
	      	$data['select'] = ['status','email','updated_at'];
	      	$data['where']['id'] = $id;
	      	$res = $this->selectRecords($data);

	      	}
	      public function bloggersBlogDetails($id){

		      echo 	$id = $this->utility->safe_b64decode($id);
		      $data['table'] = BLOG. ' as b'; 
		      $data['select'] =  ['b.created_at','b.id','b.banner_title','c.category_name'];
		      $data['join'] = [
		      					USERS .' as u' => ['b.user_id = u.id','left'],
		      					CATEGORY .' as c' => ['c.id = b.category_id','left']
		      				 ];
		      	$data['where'] =  ['b.user_id'=>$id];
	      		return $this->selectFromJoin($data);

	      }

	      public function singleBlogDetails($id){

		      $id = $this->utility->safe_b64decode($id);
		      $data['table'] = COMMENTS. ' as c'; 
		      $data['select'] =  ['c.created_at','c.id','c.comments', 'c.reference','u.first_name'];
		      $data['join'] = [
		      					USERS .' as u' => ['c.user_id = u.id','left'],
		      					];
		      	$data['where'] =  ['c.blog_id'=>$id,'c.reference='=>'0'];
	      		return $this->selectFromJoin($data);

	      }

	      public function singleBlogLikes($id){

		      $id = $this->utility->safe_b64decode($id);
		      $data['table'] = BLOG_LIKE. ' as bl'; 
		      $data['select'] =  ['bl.created_at','bl.id','bl.rating', 'u.first_name','u.email'];
		      $data['join'] = [
		      					USERS .' as u' => ['bl.user_id = u.id','left'],
		      					];
		      	$data['where'] =  ['bl.blog_id'=>$id];
	      		return $this->selectFromJoin($data);

	      }

	      public function singleBlogCountLikes($id){

	      	  $id = $this->utility->safe_b64decode($id);
		      $data['table'] = BLOG_LIKE; 
		      $data['select'] =  ['*'];
		      $data['where'] =  ['blog_id'=>$id,'rating'=>'1'];
	      	  return $this->selectRecords($data);
	      }

	      public function singleBlogCountDislikes($id){

	      	  $id = $this->utility->safe_b64decode($id);
		      $data['table'] = BLOG_LIKE; 
		      $data['select'] =  ['*'];
		      $data['where'] =  ['blog_id'=>$id,'rating'=>'0'];
	      	  return $this->selectRecords($data);
	      }

	      public function singleBlogMultipleReply($id){

		      $id = $this->utility->safe_b64decode($id);
		      $data['table'] = COMMENTS. ' as c'; 
		      $data['select'] =  ['c.created_at','c.id','c.comments', 'c.reference','u.first_name'];
		      $data['join'] = [
		      					USERS .' as u' => ['c.user_id = u.id','left'],
		      					];
		      	$data['where'] =  ['c.reference='=>$id];
	      		return $this->selectFromJoin($data);
	      }

	      public function mostLikedBlog(){
	      	$data['table'] = BLOG_LIKE . ' as bl';
	      	$data['select'] = ['b.id','u.first_name','b.banner_title','count(bl.blog_id)  as likes','b.created_at'];
	      	$data['join'] = [
	      						BLOG .' as b' => ['b.id = bl.blog_id','left'],
	      						USERS . ' as u ' =>['u.id=b.user_id','left']
	      					];
	      	$data['groupBy'] = ['bl.blog_id']; 
	      	$data['where'] = ['bl.rating'=>'1','u.status'=>'active']; 
	      	$data['order'] = 'count(bl.blog_id)  DESC';
	      	$data['limit'] = '10';
	      	return $this->selectFromJoin($data);
	      }

	      public function mostCommentsBlog(){
	      	$data['table'] = COMMENTS . ' as c';
	      	$data['select'] = ['b.id','u.first_name','b.banner_title','count(c.blog_id)  as comments','b.created_at'];
	      	$data['join'] = [
	      						BLOG .' as b' => ['b.id = c.blog_id','left'],
	      						USERS . ' as u ' =>['u.id=b.user_id','left']
	      					];
	      	$data['groupBy'] = ['c.blog_id']; 
	      	$data['where'] = ['c.reference'=>'0','u.status'=>'active']; 
	      	$data['order'] = 'count(c.blog_id)  DESC';
	      	$data['limit'] = '10';
	      	return $this->selectFromJoin($data);
	      }

	       public function mostTrendingBlog(){
	      	$data['table'] = BLOG . ' as b';
	      	$data['select'] = ['b.id','u.first_name','b.hits','b.banner_title','b.created_at'];
	      	$data['join'] = [
	      						USERS . ' as u ' =>['u.id=b.user_id','left']
	      					];
	      	 
	      	$data['where'] = ['b.hits >='=>'5','u.status'=>'active']; 
	      	$data['order'] = 'b.hits DESC';
	      	$data['limit'] = '10';
	      	return $this->selectFromJoin($data);
	      }

}

?>