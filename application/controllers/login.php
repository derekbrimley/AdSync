<?php		

	
class Login extends CI_Controller 
{

	function index(){
		$data['title'] = "Login";
		$this->load->view('adsync_login_view',$data);
	}
	
	function activate(){
		date_default_timezone_set('America/Denver');
		$current_datetime = date("Y-m-d H:i:s");
			
		$email = $_GET['email'];
		$hash = $_GET['hash'];
		$secret_code = $GET['code'];
		
		//GET USER WITH THAT EMAIL
		$where = null;
		$where['email'] = $email;
		$user = db_select_user($where);
		
		// echo trim($hash)."<br>";
		// echo trim($user['hash']);
		//echo "Hash: ".$hash." User hash: ".$user['hash'];
		if(trim($hash) == trim($user['hash'])){
			//echo "Hash: ".$hash." User hash: ".$user['hash'];
			$set = array();
			$set['is_active'] = "true";
			
			$where = null;
			$where['email'] = $email;
			$where['hash'] = $hash;
			
			db_update_user($set,$where);
			
			$where = null;
			$where['secret_code'] = $secret_code;
			
			$set = array();
			$set['datetime_used'] = $current_datetime;
			$set['is_active'] = "false";
			
			db_update_secret_code($set,$where);
			
			$code = db_select_secret_code($where);
			
			$referral_id = $code['referral_id'];
			
			$account_entry = null;
			$account_entry['user_id'] = $referral_id;
			$account_entry['description'] = "Payment for referring user $user['first_name'] $user['last_name'] ($user['id']) on $current_datetime.";
			$account_entry['amount'] = 10;
			$account_entry['datetime'] = $current_datetime;
			
			db_insert_account_entry($account_entry);
			
			redirect("login");
			//$this->load->view("adsync_login_view.php",$data);
		}
	}
	
	function change_password(){
		$email = $_GET['email'];
		$token = $_GET['token'];
		
		$where = null;
		$where['email'] = $email;
		$user = db_select_user($where);
		
		$user_token = $user['reset_token'];
		
		if($token==$user_token){
			$data['email'] = $email;
			$this->load->view("change_password.php",$data);
		}else{
			$this->load->view("password_error.php");
		}
	}
	
	public function username_check($str){
		$where = null;
		$where = "1 = 1";
		$users = db_select_users($where);
		$username_list = array();
		foreach($users as $user){
			$username_list[] = $user['username'];
		}
		if (in_array($str,$username_list)){
			$this->form_validation->set_message('username_check', "The username $str is not available.");
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function location_check($str){
		
	}
	
	public function request_email_check($str){
		$where = null;
		$where['is_active'] = "true";
		$codes = db_select_secret_codes($where);
		
		$code_request_list = array();
		foreach($codes as $code){
			$code_request_list[] = $code['email_requested'];
		}
		
		if (in_array($str,$code_request_list)){
			$this->form_validation->set_message('request_email_check', "The email $str has already requested a code. Please provide another Gmail address.");
			return FALSE;
		}else{
			list($user, $domain) = explode('@', $str);

			if ($domain == 'gmail.com') {
				return TRUE;
				// use gmail
			}else{
				$this->form_validation->set_message('request_email_check', "The email $str is not a Gmail address. Please provide a valid Gmail address.");
				return FALSE;
			}
		}
	}
	
	public function email_check($str){
		$where = null;
		$where = "1 = 1";
		$users = db_select_users($where);
		$email_list = array();
		foreach($users as $user){
			$email_list[] = $user['email'];
		}
		if (in_array($str,$email_list)){
			$this->form_validation->set_message('email_check', "The email $str is already associated with an account. Please provide another Gmail address.");
			return FALSE;
		}else{
			list($user, $domain) = explode('@', $str);

			if ($domain == 'gmail.com') {
				return TRUE;
				// use gmail
			}else{
				$this->form_validation->set_message('email_check', "The email $str is not a Gmail address. Please provide a valid Gmail address.");
				return FALSE;
			}
		}
	}
	
	public function market_id_check($str){
		if ($str=="Select Craigslist Market"){
			$this->form_validation->set_message('market_id_check', "Please select your Craigslist market. If you are unsure of your market, go to http://www.craigslist.com/");
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function create_new_user(){
		
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('latitude', 'Latitude', 'trim|callback_location_check|xss_clean');
		$this->form_validation->set_rules('longitude', 'Longitude', 'trim|callback_location_check|xss_clean');
		$this->form_validation->set_rules('ip_address', 'IP Address', 'trim|callback_ip_check|xss_clean');
		
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|ucfirst|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|ucfirst|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]|xss_clean');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check|xss_clean');
		$this->form_validation->set_rules('market_id', 'Market', 'trim|required|callback_market_id_check|xss_clean');
		$this->form_validation->set_rules('secret_code', 'Code', 'trim|required|integer|xss_clean');
		
		if ($this->form_validation->run() == FALSE){
			$where = null;
			$where = "1 = 1";
			$markets = db_select_markets($where,"name ASC");
			
			$data['markets'] = $markets;
			$data['title'] = "New User";
			$this->load->view('new_user_view',$data);
		}
		else{
			
			date_default_timezone_set('America/Denver');
			$current_datetime = date("Y-m-d H:i:s");
		
			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$email = $_POST['email'];
			$secret_code = $_POST['secret_code'];
			$role = "affiliate";
			$home_market_id = $_POST['market_id'];
			$ip_address = $_SERVER['REMOTE_ADDR'];
			$latitude = $_POST['latitude'];
			$longitude = $_POST['longitude'];
			$geolocation = $latitude.", ".$longitude;
			$hash = md5(rand(0,1000));
			
			$where = null;
			$where['secret_code'] = $secret_code;
			$referral_code = db_select_secret_code($where);
			if($referral_code['referral_id']){
				$referred_by_user_id = $referral_code['referral_id'];
			}
			
			$new_user['referred_by'] = $referred_by_user_id;
			
			$hashed_password = password_hash($password,PASSWORD_BCRYPT );
			
			$new_user['first_name'] = $first_name;
			$new_user['last_name'] = $last_name;
			$new_user['username'] = $username;
			$new_user['password'] = $hashed_password;
			$new_user['email'] = $email;
			$new_user['role'] = $role;
			$new_user['home_market'] = $home_market_id;
			$new_user['date_joined'] = $current_datetime;
			$new_user['is_active'] = "false";
			$new_user['ip_address'] = $ip_address;
			$new_user['geolocation'] = $geolocation;
			$new_user['hash'] = $hash;
			
			db_insert_user($new_user);
			
			$user = db_select_user($new_user);
			
			$to = $email;
			$subject = "AdSync Confirmation Email";
			$message = "
				Click the link below to confirm your new AdSync Account.
				
				http://www.adsync.nextgenmarketingsolutions.com/index.php/login/activate?email=$email&hash=$hash&code=$secret_code
			";
			$headers = 'From: admin@nextgenmarketingsolutions.com';
			
			mail($to,$subject,$message,$headers);
			
			$this->session->set_userdata('user_id', $user['id']);
			$this->session->set_userdata('first_name', $user["first_name"]);
			$this->session->set_userdata('last_name', $user["last_name"]);
			$this->session->set_userdata('username', $username);
			$this->session->set_userdata('role', $user['role']);
			$this->session->set_userdata('is_active', $user['is_active']);
			$this->session->set_userdata('referral_id', $user['referral_id']);
			
			redirect("ads");
		}
	}
	
	function leadsync_login(){
		$data['title'] = "LeadSync Login";
		$this->load->view('leadsync_login_view',$data);
	}
	
	function adsync_login(){
		$data['title'] = "AdSync Login";
		$this->load->view('adsync_login_view',$data);
	}
	
	function adsync_authenticate(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$user_where['username'] = $username;
		@$user = db_select_user($user_where);
		
		$role = $user['role'];
		//echo $role;
		if (empty($user['password'])){
			echo "Invalid credentials";
		}
		elseif (password_verify($password,$user['password'])){
			$this->session->set_userdata('user_id', $user['id']);
			$this->session->set_userdata('first_name', $user["first_name"]);
			$this->session->set_userdata('last_name', $user["last_name"]);
			$this->session->set_userdata('username', $username);
			$this->session->set_userdata('role', $user['role']);
			$this->session->set_userdata('is_active', $user['is_active']);
			$this->session->set_userdata('referral_id', $user['referral_id']);
			$this->session->set_userdata('email', $user['email']);
			
			if($role == "admin" || $role == "affiliate" || $role == "manager"){
				redirect("ads");
			}else{
				redirect("leads");
			}
		}else{
			echo "Invalid credentials";
		}
	}
	
	function logout(){
		$this->session->sess_destroy();
        redirect(base_url("index.php/login"));
	}
	
	function new_user(){
		$where = null;
		$where = "1 = 1";
		$markets = db_select_markets($where,"name ASC");
		
		$data['markets'] = $markets;
		$data['title'] = "New User";
		$this->load->view('new_user_view',$data);
	}
	
	function load_reset_password_view(){
		$data['title'] = "Reset Password";
		$this->load->view('reset_password_view',$data);
	}
	
	function load_request_code_view(){
		$data['title'] = "Request Code";
		$this->load->view('request_code_view',$data);
	}
	
	function reset_password(){
		date_default_timezone_set('America/Denver');
		$timestamp = date("Y-m-d H:i:s");
		
		$username = $_POST['username'];
		
		$where = null;
		$where['username'] = $username;
		$user = db_select_user($where);
		
		if(!empty($user)){
			$user_email = $user['email'];
			
			$token = md5($timestamp);
			
			$where = null;
			$where['id'] = $user['id'];
			
			$set = null;
			$set['reset_token'] = $token;
			
			db_update_user($set,$where);
			
			$to = $user_email;
			$subject = "AdSync Password Reset";
			$message = "
				You're receiving this email because you requested a password reset. 
				Please follow the following link to choose a new password:
				http://www.adsync.nextgenmarketingsolutions.com/index.php/login/change_password?email=$user_email&token=$token
			";
			$headers = 'From: admin@nextgenmarketingsolutions.com';
			
			mail($to,$subject,$message,$headers);
			
		}
		
		$this->load->view("sent_email_view");
	}
	
	function request_code(){
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_request_email_check|xss_clean');
		
		if ($this->form_validation->run() == FALSE){
			$this->load_request_code_view();
		}else{
			date_default_timezone_set('America/Denver');
			$current_datetime = date("Y-m-d H:i:s");
			
			$email = $_POST['email'];
			
			$characters = '0123456789';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < 5; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			
			$secret_code = array();
			$secret_code['secret_code'] = $randomString;
			$secret_code['datetime_created'] = $current_datetime;
			$secret_code['is_active'] = 'true';
			$secret_code['email_requested'] = $email;
			$secret_code['is_email_sent'] = "false";
			
			db_insert_secret_code($secret_code);
			
			$data['title'] = "Code Requested";
			
			$this->load->view('request_code_success',$data);
		}
		
		
	}
	
	function send_new_email(){
		$user_id = $_POST['id'];
		
		$where = null;
		$where['id'] = $user_id;
		$user = db_select_user($where);
		
		$email = $user['email'];
		$hash = $user['hash'];

		$to = $email;
		$subject = "AdSync Confirmation Email";
		$message = "
			Click the link below to confirm your new AdSync Account.
			http://www.adsync.nextgenmarketingsolutions.com/index.php/login/activate?email=$email&hash=$hash
		";
		$headers = 'From: admin@nextgenmarketingsolutions.com';
		
		mail($to,$subject,$message,$headers);
		
		echo "An email has been sent to $email";
	}
	
	function update_password(){
		$new_password = $_POST['password1'];
		$email = $_POST['email'];
		
		$hashed_password = password_hash($new_password,PASSWORD_BCRYPT);
		
		$where = null;
		$where['email'] = $email;
		$user = db_select_user($where);
		if(!empty($user)){
			$set = null;
			$set['password'] = $hashed_password;
			
			db_update_user($set,$where);
			
			$set = null;
			$set['reset_token'] = 0;
			
			db_update_user($set,$where);
		}
	}
}
?>