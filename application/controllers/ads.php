<?php

class Ads extends MY_Controller {

	function index(){
		$role = $this->session->userdata('role');
		$title = "AdSync";
		$is_active = $this->session->userdata('is_active');
		
		$where = null;
		$where = "1 = 1";
		$markets  = db_select_markets($where);
		
		$market_options = array();
		$market_options["Select"] = "Select";
		foreach($markets as $market)
		{
			
			$market_options[$market['id']] = $market['name'].", ".$market['state'];
			
		}
		
		$category_options = array(
			'Select' => 'Select',
			'job offered' => 'job offered',
			'gig offered' => 'gig offered',
			'resume / job wanted' => 'resume / job wanted',
			'housing offered' => 'housing offered',
			'housing wanted' => 'housing wanted',
			'for sale by owner' => 'for sale by owner',
			'for sale by dealer' => 'for sale by dealer',
			'wanted by owner' => 'wanted by owner',
			'wanted by dealer' => 'wanted by dealer',
			'service offered' => 'service offered',
			'personal / romance' => 'personal / romance',
			'community' => 'community',
			'event / class' => 'event / class',
		);
		
		$where = null;
		$where = "1 = 1";
		$clients = db_select_clients($where);
		
		$client_options = array();
		$client_options["Select"] = "Select";
		foreach($clients as $client)
		{
			
			$client_options[$client['id']] = $client['name'];
			
		}
		
		$where = null;
		$where = "1 = 1";
		$ad_requests = db_select_ad_requests($where);
		
		$data['client_options'] = $client_options;
		$data['category_options'] = $category_options;
		$data['market_options'] = $market_options;
		$data['title'] = $title;
		
		//echo $role;
		
		if($is_active == "false")
		{
			$data['user_id'] = $this->session->userdata('user_id');
			$this->load->view('ads/inactive_user_view',$data);
		}
		else if($role == "admin" || $role == "manager" || $role == "client" || $role == "affiliate" || $role == "staff")
		{
			$this->load->view('ads_view',$data);
		}
		
	}
	
	function create_ad_request(){
		$client_id = $_POST['client_id'];
		$market_id = $_POST['market_id'];
		$category_name = $_POST['category_name'];
		$sub_category = $_POST['sub_category'];
		$content_description = $_POST['content_description'];
		$price = $_POST['price'];
		$minimum_live_ads = $_POST['minimum_live_ads'];
		
		$stripped_price = preg_replace("/[^0-9,.]/", "", $price);
		
		$ad_request = null;
		$ad_request['client_id'] = $client_id;
		$ad_request['market_id'] = $market_id;
		$ad_request['category'] = $category_name;
		$ad_request['sub_category'] = $sub_category;
		$ad_request['content_desc'] = $content_description;
		$ad_request['price'] = $stripped_price;
		$ad_request['post_expense'] = 10;
		$ad_request['min_count'] = $minimum_live_ads;
		
		db_insert_ad_request($ad_request);
		header("Location: ".base_url('/index.php/ads/'));
		die();
	}
	
	function count_array($array){

		$count = count($array);
		return $count;
	}
	
	function delete_ad_request(){
		$id = $_POST['id'];
		
		$where = null;
		$where['id'] = $id;
		
		$set = array();
		$set['status'] = 'inactive';
		
		db_update_ad_request($set,$where);
	}
	
	function delete_post(){
		$post_id = $_POST['post_id'];
		$ad_request_id = $_POST['ad_request_id'];
		
		if(!empty($post_id))
		{
			
			$where = null;
			$where['id'] = $post_id;
			
			db_delete_post($where);
			
			$where = null;
			$where['ad_request_id'] = $ad_request_id;
			
			$set['post_datetime'] = '';
			
			db_update_ad_spot($set,$where);
			
		}
		
	}
	
	function download_file($file_guid){
		get_secure_ftp_file($file_guid);
	}
	
	function edit_ad_request(){
		$ad_request_id = $_POST['id'];
		$market_name = $_POST['market_name'];
		
		$where = null;
		$where['name'] = $market_name;
		$market = db_select_market($where);
		
		$where = null;
		$where['id'] = $ad_request_id;
		
		$set = array();
		$set['market_id'] = $market['id'];
		$set['category'] = $_POST['category'];
		$set['sub_category'] = $_POST['sub_category'];
		$set['price'] = $_POST['price'];
		
		db_update_ad_request($set,$where);
	}
	
	function edit_user(){
		$user_id = $_POST['user_id'];
		$status = $_POST['status'];
		$where = null;
		$where['id'] = $user_id;
		
		$set = array();
		$set['is_active'] = $status;
		
		db_update_user($set,$where);
	}
	
	function generate_code(){
		date_default_timezone_set('America/Denver');
		$current_datetime = date("Y-m-d H:i:s");
		
		$referral_id = $_POST['referral_id'];
		
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < 5; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		
		$new_secret_code = array();
		if($referral_id!="Select")
		{
			$new_secret_code['referral_id'] = $referral_id;
		}
		$new_secret_code['secret_code'] = $randomString;
		$new_secret_code['datetime_created'] = $current_datetime;
		$new_secret_code['is_active'] = "true";
		
		db_insert_secret_code($new_secret_code);
		
		echo $randomString;
	}
		
	function get_balance(){
		$user_id = $_POST['id'];
		
		$where = null;
		$where['user_id'] = $user_id;
		$account_entries = db_select_account_entrys($where);

		$balance = 0;
		if(!empty($account_entries))
		{
			foreach($account_entries as $account_entry)
			{
				$balance += $account_entry['amount'];
			}
		}
		
		echo number_format($balance,2);
	}
	
	function load_account_info(){
		$user_id = $this->session->userdata('user_id');
		
		$where = null;
		$where['id'] = $user_id;
		$user = db_select_user($where);
		
		$where = null;
		$where['id'] = $user['home_market'];
		$market = db_select_market($where);
		
		$where = null;
		$where['id'] = $user['referred_by'];
		$referred_by_user = db_select_user($where);
		
		$data['referred_by_user'] = $referred_by_user;
		$data['market'] = $market;
		$data['user'] = $user;
		
		$this->load->view("ads/account_info",$data);
		
	}
	
	function load_accounts_page(){
		$where = null;
		$where = "1 = 1";
		$users = db_select_users($where);
		
		$count = $this->count_array($users);
		
		$data['count'] = $count;
		$data['users'] = $users;
		$this->load->view("ads/accounts",$data);
	}
	
	function load_ad_requests(){
		$where = null;
		$where = "1 = 1";
		$markets  = db_select_markets($where);
		
		$category_options = array(
			'Select' => 'Select',
			'job offered' => 'job offered',
			'gig offered' => 'gig offered',
			'resume / job wanted' => 'resume / job wanted',
			'housing offered' => 'housing offered',
			'housing wanted' => 'housing wanted',
			'for sale by owner' => 'for sale by owner',
			'for sale by dealer' => 'for sale by dealer',
			'wanted by owner' => 'wanted by owner',
			'wanted by dealer' => 'wanted by dealer',
			'service offered' => 'service offered',
			'personal / romance' => 'personal / romance',
			'community' => 'community',
			'event / class' => 'event / class',
		);
		
		$where = null;
		$where['status'] = "active";
		$ad_requests = db_select_ad_requests($where,"id DESC","100");
		
		$where = null;
		$where['status'] = "active";
		$total_ad_requests = db_select_ad_requests($where);
		$count = $this->count_array($total_ad_requests);
		
		$data['count'] = $count;
		$data['category_options'] = $category_options;
		$data['markets'] = $markets;
		$data['ad_requests'] = $ad_requests;
		$this->load->view("ads/ad_requests",$data);
		
	}
	
	function load_faq(){
		$this->load->view("ads/faq_view");
	}
	
	function load_filtered_live_ads(){
		$selected_user_id = $_POST['user_id'];
		$role = $this->session->userdata('role');
		
		$where = null;
		if($selected_user_id=="All Users"){
			
		}else{
			$where['poster_id'] = $selected_user_id;
		}
		$where['result'] = "live";
		$posts = db_select_posts($where,"post_datetime DESC");
		
		$where = null;
		$where = "1 = 1";
		$users = db_select_users($where);
		
		$count = $this->count_array($posts);
		
		$data['role'] = $role;
		$data['users'] = $users;
		$data['count'] = $count;
		$data['posts'] = $posts;
		$this->load->view("ads/filtered_live_ads",$data);
	}
	
	function load_filtered_post_history(){
		$selected_user_id = $_POST['user_id'];
		$role = $this->session->userdata('role');
		
		$where = null;
		if($selected_user_id=="All Users"){
			$where = "1 = 1";
		}else{
			$where['poster_id'] = $selected_user_id;
		}
		$posts = db_select_posts($where,"post_datetime DESC");
		
		$where = null;
		$where = "1 = 1";
		$users = db_select_users($where);
		
		$count = $this->count_array($posts);
		
		$data['role'] = $role;
		$data['users'] = $users;
		$data['count'] = $count;
		$data['posts'] = $posts;
		$this->load->view("ads/filtered_post_history",$data);
	}
	
	function load_filtered_referrals(){
		$selected_user_id = $_POST['user_id'];
		$role = $this->session->userdata('role');
		
		$where = null;
		$where = "1 = 1";
		$users = db_select_users($where);
		
		$referred_users = array();
		foreach($users as $user){
			if(!empty($user['referred_by'])){
				if($selected_user_id!="All Users"){
					if($user['referred_by'] == $selected_user_id){
						$referred_users[] = $user;
					}
				}else{
					$referred_users[] = $user;
				}
			}
		}
		
		$count = $this->count_array($referred_users);
		
		$data['count'] = $count;
		$data['users'] = $users;
		$data['referred_users'] = $referred_users;
		$this->load->view("ads/filtered_referrals",$data);
	}
	
	function load_filtered_renewals(){
		$selected_user_id = $_POST['user_id'];
		$role = $this->session->userdata('role');
		
		$where = null;
		if($selected_user_id=="All Users"){
			
		}else{
			$where['poster_id'] = $selected_user_id;
		}
		$where['renewal_datetime'] = null;
		$posts = db_select_posts($where,"next_renewal_datetime ASC");
		
		$where = null;
		$where = "1 = 1";
		$users = db_select_users($where);
		
		$count = $this->count_array($posts);
		
		$data['role'] = $role;
		$data['users'] = $users;
		$data['count'] = $count;
		$data['posts'] = $posts;
		$this->load->view("ads/filtered_renewals",$data);
	}
	
	function load_generate_code_page(){
		$where = null;
		$where = "1 = 1";
		$users = db_select_users($where);
		
		$dropdown_users = array();
		$dropdown_users["Select"] = "Select";
		$dropdown_users["No Referrer"] = "No Referrer";
		foreach($users as $user)
		{
			$dropdown_users[$user['id']] = $user['first_name']." ".$user['last_name'];
		}
		
		$data['dropdown_users'] = $dropdown_users;
		$this->load->view("ads/generate_code_view",$data);
	}
	
	function load_manage_money_page(){
		$user_id = $this->session->userdata('user_id');
	
		$where = null;
		$where = "1 = 1";
		$account_entrys = db_select_account_entrys($where,"datetime DESC");
		
		$where = null;
		$where = "1 = 1";
		$users = db_select_users($where,"last_name ASC");
		
		$balance = 0;
		$dropdown_users = array();
		$dropdown_users[] = "All Users";
		foreach($users as $user){
			$user_balance = 0;
			foreach($account_entrys as $account_entry)
			{
				if($account_entry['user_id']==$user['id']){
					$user_balance += $account_entry['amount'];
					$balance += $account_entry['amount'];
				}
			}
			
		$dropdown_users[$user['id']] = $user['first_name']." ".$user['last_name']." - $".number_format($user_balance,2);
		}
		
		$data['balance'] = number_format($balance,2);
		$data['dropdown_users'] = $dropdown_users;
		$data['account_entrys'] = $account_entrys;
		$this->load->view("ads/manage_money_page",$data);
	}
	
	function load_money_report(){
		$user_id = $this->session->userdata('user_id');
		
		$where = null;
		$where['user_id'] = $user_id;
		$account_entrys = db_select_account_entrys($where,"datetime DESC");
		
		$balance = 0;
		if(!empty($account_entrys))
		{
			foreach($account_entrys as $account_entry)
			{
				$balance += $account_entry['amount'];
			}
		}
		
		$data['balance'] = number_format($balance,2);
		$data['account_entrys'] = $account_entrys;
		$this->load->view("ads/money_report",$data);
	}
	
	function load_post_board(){
		$user_id = $this->session->userdata('user_id');
		$role = $this->session->userdata('role');
		
		$where = null;
		$where['id'] = $user_id;
		$user = db_select_user($where);
		
		$home_market_id = $user['home_market'];
		$where = null;
		$where['market_id'] = $home_market_id;
		$related_markets = db_select_market_relationships($where);
		//print_r($related_markets);
		
		$available_markets = array();
		$available_markets[] = $home_market_id;
		$where = null;
		$where = "post_datetime IS NULL AND (market_id = '".$home_market_id."'";
		if(!empty($related_markets))
		{
			foreach($related_markets as $related_market)
			{
				$where = $where." OR market_id = '".$related_market['related_market_id']."'";
			}
		}
		$ad_spots = array();
		if($role=="admin")
		{
			$sql = "SELECT ad_spot.id AS id, ad_spot.ad_request_id AS ad_request_id, ad_spot.value as value, ad_spot.post_datetime as post_datetime, ad_request.market_id AS market_id FROM `ad_spot` LEFT JOIN `ad_request` ON ad_spot.ad_request_id = ad_request.id ORDER BY ad_spot.value ASC, ad_spot.ad_request_id ASC";
		}
		else
		{
			$sql = "SELECT ad_spot.id AS id, ad_spot.ad_request_id AS ad_request_id, ad_spot.value as value, ad_spot.post_datetime as post_datetime, ad_request.market_id AS market_id FROM `ad_spot` LEFT JOIN `ad_request` ON ad_spot.ad_request_id = ad_request.id WHERE ".$where.") ORDER BY ad_spot.value ASC, ad_spot.ad_request_id ASC";
		}
		//echo $sql;
		$query = $this->db->query($sql);
		foreach($query->result() as $row)
		{
			$ad_spot = array();
			$ad_spot['id'] = $row->id;
			$ad_spot['ad_request_id'] = $row->ad_request_id;
			$ad_spot['value'] = $row->value;
			$ad_spot['post_datetime'] = $row->post_datetime;
			$ad_spot['market_id'] = $row->market_id;
			$ad_spots[] = $ad_spot;
		}
		
		
		//$ad_spots  = db_select_ad_spots($where);
		
		$count = $this->count_array($ad_spots);
		
		$data['count'] = $count;
		$data['ad_spots'] = $ad_spots;
		$this->load->view("ads/post_board",$data);
	}
	
	function load_live_ads(){
		$user_id = $this->session->userdata('user_id');
		$role = $this->session->userdata('role');
		
		$where = null;
		if($role!="admin"){
			$where['poster_id'] = $user_id;
		}
		
		$where['result'] = "live";
		$posts = db_select_posts($where,"post_datetime DESC");
		
		$where = null;
		$where = "1 = 1";
		$users = db_select_users($where);
		
		$count = $this->count_array($posts);
		
		$data['users'] = $users;
		$data['count'] = $count;
		$data['posts'] = $posts;
		$this->load->view("ads/live_ads",$data);
	}
	
	function load_post_form(){
		$post_id = $_POST['id'];
		
		$post = null;
		$post['id'] = $post_id;
		
		$post = db_select_post($post);
		
		$data['post_datetime'] = $post['post_datetime'];
		$data['post_id'] = $post['id'];
		$this->load->view("ads/ad_request_post_form",$data);
	}
	
	function load_post_history(){
		$user_id = $this->session->userdata('user_id');
		$role = $this->session->userdata('role');
		
		$where = null;
		if($role!="admin"){
			$where['poster_id'] = $user_id;
		}
		$posts = db_select_posts($where,"post_datetime DESC");
		
		$where = null;
		$where = "1 = 1";
		$users = db_select_users($where);
		
		$count = $this->count_array($posts);
		
		$data['role'] = $role;
		$data['users'] = $users;
		$data['count'] = $count;
		$data['posts'] = $posts;
		$this->load->view("ads/post_history",$data);
	}
	
	function load_post_verification_page(){
		$where = null;
		$where['result'] = "Needs verification";
		$posts = db_select_posts($where);
		
		$count = $this->count_array($posts);
		
		$data['count'] = $count;
		$data['posts'] = $posts;
		$this->load->view("ads/post_verification",$data);
	}
	
	function load_referrals(){
		$user_id = $this->session->userdata('user_id');
		$role = $this->session->userdata('role');
		
		$where = null;
		$where = "1 = 1";
		$users = db_select_users($where);
		
		$referred_users = array();
		foreach($users as $user){
			if(!empty($user['referred_by'])){
				if($role!="admin"){
					if($user['referred_by']==$user_id){
						$referred_users[] = $user;
					}
				}else{
					$referred_users[] = $user;
				}
			}
		}
		
		$count = $this->count_array($referred_users);
		
		$data['count'] = $count;
		$data['users'] = $users;
		$data['referred_users'] = $referred_users;
		$this->load->view("ads/referrals",$data);
	}
	
	function load_renewals(){
		$user_id = $this->session->userdata('user_id');
		$role = $this->session->userdata('role');
		
		$where = null;
		if($role!="admin"){
			$where['poster_id'] = $user_id;
		}
		$where['renewal_datetime'] = null;
		$posts = db_select_posts($where,"next_renewal_datetime ASC");
		
		$where = null;
		$where = "1 = 1";
		$users = db_select_users($where);
		
		$count = $this->count_array($posts);
		
		$data['users'] = $users;
		$data['count'] = $count;
		$data['posts'] = $posts;
		$this->load->view("ads/renewals",$data);
	}
	
	function load_user_transactions(){
		$user_id = $_POST['user_id'];
		
		if($user_id == "All Users"){
			$where = null;
			$where = "1 = 1";
			$account_entrys = db_select_account_entrys($where,"datetime DESC");
		}else if($user_id == "Users with balance"){
			
		}else{
			$where = null;
			$where['user_id'] = $user_id;
			$account_entrys = db_select_account_entrys($where,"datetime DESC");
		}
		
		
		$where = null;
		$where['id'] = $user_id;
		$user = db_select_user($where);
		
		$where = null;
		$where = "1 = 1";
		$dropdown_users = db_select_users($where);
		
		$data['user'] = $user;
		$data['dropdown_users'] = $dropdown_users;
		$data['account_entrys'] = $account_entrys;
		$this->load->view("ads/manage_money_page_report",$data);
	}
	
	function open_post_verification_dialog(){
		$post_id = $_POST['post_id'];
		
		$where = null;
		$where['id'] = $post_id;
		$post = db_select_post($where);
		
		$where = null;
		$where['id'] = $post['ad_request_id'];
		$ad_request = db_select_ad_request($where);
		
		$where = null;
		$where['id'] = $ad_request['market_id'];
		$market = db_select_market($where);
		
		$data['ad_request'] = $ad_request;
		$data['market'] = $market;
		$data['post'] = $post;
		$this->load->view("ads/post_verification_form",$data);
	}
	
	function renew_post(){
		date_default_timezone_set('America/Denver');
		$current_datetime = strtotime(date("Y-m-d H:i:s"));
		$post_datetime = date("Y-m-d H:i:s",$current_datetime);
		
		$renewal_post_id = $_POST['renewal_post_id'];
		
		$where = null;
		$where['id'] = $renewal_post_id;
		$post = db_select_post($where);
		
		$set = array();
		$set['renewal_datetime'] = $post_datetime;
		
		db_update_post($set,$where);
		
		$new_post = array();
		$new_post['post_datetime'] = $post_datetime;
		$new_post['poster_id'] = $this->session->userdata('user_id');
		$new_post['ad_request_id'] = $post['ad_request_id'];
		$new_post['post_exp_datetime'] = date("Y-m-d H:i:s",strtotime($post_datetime . " +48 hours"));
		$new_post['link'] = $post['link'];
		$new_post['title'] = $post['title'];
		$new_post['content'] = $post['content'];
		$new_post['phone_number'] = $post['phone_number'];
		$new_post['is_renewal'] = "true";
		$new_post['next_renewal_datetime'] = date("Y-m-d H:i:s",strtotime($post_datetime . " +48 hours"));
		$new_post['result'] = "Needs verification";
		$new_post['amount_due'] = 1;
		
		db_insert_post($new_post);
	}
	
	//OPENS NEW AD SUBMISSION DIALOG
	function reserve_ad_request(){
		date_default_timezone_set('America/Denver');
		$current_datetime = strtotime(date("Y-m-d H:i:s"));
		$post_datetime = date("Y-m-d H:i:s",$current_datetime);
		
		$user_id = $this->session->userdata('user_id');
		
		$where = null;
		$where['id'] = $user_id;
		$user = db_select_user($where);
		
		$where = null;
		$where['poster_id'] = $user_id;
		$where['is_renewal'] = "false";
		$where['result'] = "Live";
		$total_posts = db_select_posts($where);
		
		$sql = "SELECT * FROM `post` WHERE poster_id = ".$user_id." AND post_datetime > '".date("Y-m-d H:i:s",strtotime($post_datetime) - (24*3600*45))."' AND is_renewal = 'false' AND result = 'Live'";
		$query = $this->db->query($sql);
		$posts = array();
		
		foreach($query->result() as $row){
			$post = array();
			$post['id'] = $row->id;
			$posts[] = $post;
		}
		
		$count = count($posts);
		
		$sql = "SELECT * FROM `post` WHERE poster_id = ".$user_id." AND post_datetime > '".date("Y-m-d H:i:s",strtotime($post_datetime) - (24*3600))."' AND is_renewal = 'false' AND result = 'Live'";
		$query = $this->db->query($sql);
		$day_posts = array();
		
		foreach($query->result() as $row){
			$day_post = array();
			$day_post['id'] = $row->id;
			$day_posts[] = $day_post;
		}
		$day_count = count($day_posts);
		
		if($count > 20){
			echo "<script>alert('Sorry! Craigslist limits the number of ads one person can post. You have reached the limit. Don't worry, after 45 days, the post is deleted. For now, just focus on renewing your current ads. Thanks!');</script>";
		}else if($day_count > 5){
			echo "<script>alert('Sorry! Craigslist limits the number of ads one person can post per day to five. You have reached the limit. For now, just focus on renewing your current ads. Come back tomorrow to post some new ads! Thanks!');</script>";
		}else{
			$id = $_POST['id'];
			
			$where = null;
			$where['id'] = $id;
			$ad_spot = db_select_ad_spot($where);
			
			$set = null;
			$set['post_datetime'] = $post_datetime;
			
			db_update_ad_spot($set,$where);
			
			//CREATE POST
			$ad_request_id = $ad_spot['ad_request_id'];
			
			$post = null;
			$post['ad_request_id'] = $ad_request_id;
			$post['post_datetime'] = $post_datetime;
			
			db_insert_post($post);
			
			$post = db_select_post($post);
			
			$data['post_id'] = $post['id'];
			$data['ad_request_id'] = $ad_request_id;
			$this->load->view("ads/ad_request_dialog",$data);
		}
	}
	
	function reset_password(){
		$user_id = $_POST['user_id'];
		
		
	}
	
	function save_user_information(){
		$user_id = $_POST['user_id'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		
		$where = null;
		$where['id'] = $user_id;
		
		$set = null;
		$set['first_name'] = $first_name;
		$set['last_name'] = $last_name;
		
		db_update_user($set,$where);
		
		$this->load_account_info();
	}
	
	function settle_balance(){
		$user_id = $_POST['user_id'];
		
		$where = null;
		$where['id'] = $user_id;
		$user = db_select_user($where);
		
		$where = null;
		$where['poster_id'] = $user_id;
		$posts = db_select_posts($where);
		
		$balance = $_POST['balance_input'];
		
		$data['balance'] = $balance;
		$data['user'] = $user;
		$this->load->view('ads/settle_balance_ajax',$data);
		
	}
	
	function submit_payment(){
		date_default_timezone_set('America/Denver');
		$current_datetime = strtotime(date("Y-m-d H:i:s"));
		$transaction_datetime = date("Y-m-d H:i:s",$current_datetime);
		
		$user_id = $_POST['user_id'];
		$amount_paid = $_POST['amount_paid'];
		$transaction_amount = $amount_paid * -1;
		
		$where = null;
		$where['id'] = $user_id;
		$user = db_select_user($where);
		
		$account_entry = array();
		$account_entry['user_id'] = $user_id;
		$account_entry['description'] = $transaction_datetime." Payment to ".$user['first_name']." ".$user['last_name']." for $".$amount_paid;
		$account_entry['amount'] = $transaction_amount;
		$account_entry['datetime'] = $transaction_datetime;
		
		db_insert_account_entry($account_entry);
		
		$new_entry = db_select_account_entry($account_entry);
		
		$payment_name = 'payment_screenshot';
        $file = $_FILES[$payment_name];
        $name = str_replace(' ','_',$file["name"]);
        $type = $file["type"];
        $title = "screen_shot_post_".$new_entry['id'];
        $category = "Payment Screen Shot";
        $local_path = $file["tmp_name"];
        $server_path = '/file_uploads/';
        $permission = 'All';
        $secure_file = store_secure_ftp_file($payment_name,$name,$type,$title,$category,$local_path,$server_path,$permission);
		
		$guid = $secure_file['file_guid'];
		
		$set = array();
		$set['payment_screenshot_guid'] = $guid;
		
		$where = null;
		$where['id'] = $new_entry['id'];
		
		db_update_account_entry($set,$where);
		
		//DISPLAY UPLOAD SUCCESS MESSAGE
		load_upload_success_view();
	}
	
	function submit_validation(){
		date_default_timezone_set('America/Denver');
		$current_datetime = strtotime(date("Y-m-d H:i:s"));
		$post_datetime = date("Y-m-d H:i:s",$current_datetime);
		
		$post_id = $_POST['post_id'];
		$post_result = $_POST['post_result'];
		
		$post_name = 'result_screen_shot';
        $file = $_FILES[$post_name];
        $name = str_replace(' ','_',$file["name"]);
        $type = $file["type"];
        $title = "screen_shot_post_".$post_id;
        $category = "Post Screen Shot";
        $local_path = $file["tmp_name"];
        $server_path = '/file_uploads/';
        $permission = 'All';
        $secure_file = store_secure_ftp_file($post_name,$name,$type,$title,$category,$local_path,$server_path,$permission);
		
		$where = null;
		$where['id'] = $post_id;
		
		$set = array();
		$set['result_datetime'] = $post_datetime;
		$set['result'] = $post_result;
		$set['result_screen_shot_guid'] = $secure_file['file_guid'];
		
		if($post_result != "Live"){
			$set['amount_due'] = 0;
		}
		
		db_update_post($set,$where);
		
		$where = null;
		$where['id'] = $post_id;
		$post = db_select_post($where);
		
		$where = null;
		$where['id'] = $post['poster_id'];
		$user = db_select_user($where);
		
		$new_account_entry = array();
		$new_account_entry['user_id'] = $post['poster_id'];
		$new_account_entry['post_id'] = $post['id'];
		$new_account_entry['amount'] = $post['amount_due'];
		$new_account_entry['datetime'] = $post_datetime;
		if($post_result == "Live"){
			$new_account_entry['description'] = "Post ".$post['id']." verified on ".date("m/d/Y",strtotime($post_datetime)).". User ".$user['first_name']." ".$user['last_name']." earned ".$post['amount_due'].".";
		}else{
			$new_account_entry['description'] = "Post ".$post['id']." rejected on ".date("m/d/Y",strtotime($post_datetime)).". User ".$user['first_name']." ".$user['last_name']." earned no money for this post.";
		}
		
		db_insert_account_entry($new_account_entry);
		
		//DISPLAY UPLOAD SUCCESS MESSAGE
		load_upload_success_view();
		
	}
	
	//USER SUBMITS NEW POST INFO INTO THE NEW AD SUBMISSION DIALOG
	function update_post(){
		date_default_timezone_set('America/Denver');
		$current_datetime = strtotime(date("Y-m-d H:i:s"));
		$post_datetime = date("Y-m-d H:i:s",$current_datetime);
		
		$user_id = $this->session->userdata('user_id');
		
		$post_id = $_POST['post_id'];
		$ad_request_id = $_POST['ad_request_id'];
		$post_link = $_POST['post_link'];
		$post_title = $_POST['post_title'];
		$post_content = $_POST['post_content'];
		$phone_number = $_POST['post_phone_number'];
		
		$where = null;
		$where['ad_request_id'] = $ad_request_id;
		$ad_spot = db_select_ad_spot($where);
		$amount_due = number_format(round($ad_spot['value'],2),2);
		
		$where = null;
		$where['poster_id'] = $user_id;
		$posts = db_select_posts($where);
		
		if(empty($posts)){
			$set = array();
			$set['first_post_datetime'] = $post_datetime;
			
			$where = null;
			$where['id'] = $user_id;
			
			db_update_user($set,$where);
		}
		
		$where = null;
		$where = "1 = 1";
		$old_posts = db_select_posts($where);
		
		$unique_link = '';
		$old_links = array();
		foreach($old_posts as $old_post){
			$old_links[] = $old_post['link'];
		}
		
		if(in_array($post_link,$old_links)){
			$unique_link = false;
		}else{
			$unique_link = true;
		}
		
		if($unique_link){
			$set = array();
			$set['poster_id'] = $user_id;
			$set['post_datetime'] = $post_datetime;
			$set['post_exp_datetime'] = date("Y-m-d H:i:s",strtotime($post_datetime . " +48 hours"));
			$set['link'] = $post_link;
			$set['title'] = $post_title;
			$set['content'] = $post_content;
			$set['phone_number'] = $phone_number;
			$set['is_renewal'] = "false";
			$set['next_renewal_datetime'] = date("Y-m-d H:i:s",strtotime($post_datetime . " +48 hours"));
			$set['result'] = "Needs verification";
			$set['amount_due'] = $amount_due;
			
			$where = null;
			$where['id'] = $post_id;
			
			db_update_post($set,$where);
			
			echo "Your submission has been received. In the next 24 hours, we will verify the posting. Thank you!";
		}else{

			$where = null;
			$where['id'] = $post_id;
			db_delete_post($where);
			
			echo "Link not unique. Post has been deleted. Please provide a unique link.";
		}
	}
	
	function update_balance(){
		$user_id = $this->session->userdata('user_id');
		$user_role = $this->session->userdata('role');
		

		if($user_role != "admin"){
			$where = null;
			$where['id'] = $user_id;
			$user = db_select_user($where);

			$where = null;
			$where['user_id'] = $user_id;
			$account_entries = db_select_account_entrys($where);
			
			$balance = 0;
			if(!empty($account_entries)){
				foreach($account_entries as $account_entry)
				{
					$balance += $account_entry['amount'];
				}
			}
			
		}
		else{
			$where = null;
			$where = "1 = 1";
			$account_entries = db_select_account_entrys($where);
			
			$balance = 0;
			if(!empty($account_entries))
			{
				foreach($account_entries as $account_entry)
				{
					$balance += $account_entry['amount'];
				}
			}
		}
		
		echo number_format($balance,2);
		
	}
	
	
	function test(){
		$this->load->view('test_view');
	}
	
	

	
	
	//ONE TIME SCRIPTS
	
	// function hash_passwords(){
		// $where = null;
		// $where = "1 = 1";
		// $users = db_select_users($where);
		
		// foreach($users as $user){
			// $password = $user['password'];
			
			// $hashed_password = password_hash($password,PASSWORD_BCRYPT);
			
			// $where = null;
			// $where['id'] = $user['id'];
			
			// $set = null;
			// $set['password'] = $hashed_password;
			
			// db_update_user($set,$where);
			
		// }
		
		
	// }
	
	// function create_initial_ad_requests(){
		// $where = null;
		// $where = "1 = 1";
		// $markets = db_select_markets($where);
		
		// foreach($markets as $market){
			// $ad_request = array();
			// $ad_request['client_id'] = 1;
			// $ad_request['market_id'] = $market['id'];
			// $ad_request['category'] = "job offered";
			// $ad_request['sub_category'] = "transportation";
			// $ad_request['content_desc'] = "Explain that we have a driving program that is currently enrolling. We are searching for students from across the nation who are ready for a new career. Our training program offers individuals an opportunity to get their Commercial Drivers License with no up-front payment and receive paid on-the-road training. <br><br>The training consists of two parts: <br><br>(1) In-class Training: During this period, they will be brought to our training facility and we will provide them with a place to stay as well as all of their food. They will first undergo training to get their drivers permit for a Class A commercial drivers license. Then they will receive training in a truck to help them pass a skills test. After passing the skills test through the DOT, they will receive a paper copy of their license. In whole, this process typically takes 2-3 weeks. <br><br>(2) On the Road training: We then set them up with a trainer who will teach them the ins and outs of the trucking industry. They will haul loads, learn to fill out all paperwork, and gain the know-how to succeed as a truck driver. This portion takes 12 weeks in which the goal is to get the driver 60,000 miles of training experience. During this portion, they will receive a living stipend of $300/wk with bonuses up to an additional $300/wk. <br><br>After the training, our best trainees receive in-house offers to continue driving. Otherwise, we set them up with one of our partner carriers to drive. <br><br>Use one of the following phone numbers for the contact information: <br><br>(224) 212-9254 <br>(208) 963-5639 <br>(216) 930-4089 <br>(952) 222-3893 <br>(512) 593-7271";
			// $ad_request['price'] = 10;
			// $ad_request['post_expense'] = 10;
			// $ad_request['min_count'] = 1;
			
			// db_insert_ad_request($ad_request);
			// echo "inserted school ad request for market ".$market['name']."<br>";
			
			// $ad_request = array();
			// $ad_request['client_id'] = 1;
			// $ad_request['market_id'] = $market['id'];
			// $ad_request['category'] = "job offered";
			// $ad_request['sub_category'] = "transportation";
			// $ad_request['content_desc'] = "Make the following clear in the ad: <br><br>We have openings for dedicated routes, local routes, regional position, over-the-road long haul (2-6 weeks Over-the-Road), team or solo. All of these positions are for hauling dry van and refer loads. <br><br>Requirements for the job include: <br><br>current Class A CDL, no recent accidents, no recent tickets, must have recent experience driving 53' trailers, cannot currently be on parole, and must be over 21 years to be able to haul interstate loads. <br><br>Pay is weekly and most of our drivers make a minimum $800-$900 dollars per week but paychecks often exceed $1,300 for our experienced drivers. <br><br>The best way to get a hold of the company is to call the number listed in the 'Reply' section of this ad. If that's not possible, shoot the company a resume and be sure to include a call back number so we can get in touch. <br><br>Use one of the following phone numbers for the contact information: <br><br>(224) 212-9254 <br>(208) 963-5639 <br>(216) 930-4089 <br>(952) 222-3893 <br>(512) 593-7271";
			// $ad_request['price'] = 10;
			// $ad_request['post_expense'] = 10;
			// $ad_request['min_count'] = 1;
			
			// db_insert_ad_request($ad_request);
			// echo "inserted cdl ad request for market ".$market['name']."<br>";
			
		// }
		
	// }
	
	// function add_status_ad_requests(){
		// $where = null;
		// $where = "1 = 1";
		// $ad_requests = db_select_ad_requests($where);
		
		// foreach($ad_requests as $ad_request){
			// $where = null;
			// $where['id'] = $ad_request['id'];
			
			// $set = null;
			// $set['status'] = 'active';
			
			// db_update_ad_request($set,$where);
		// }
	// }
}