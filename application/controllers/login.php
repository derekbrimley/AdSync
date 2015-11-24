<?php		

	
class Login extends CI_Controller 
{

	function index(){
		$data['title'] = "Login";
		$this->load->view('adsync_login_view',$data);
	}
	
	function activate(){
		$email = $_GET['email'];
		$hash = $_GET['hash'];
		
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
	
	function create_new_user(){
		date_default_timezone_set('America/Denver');
		$current_datetime = date("Y-m-d H:i:s");
		
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$secret_code = $_POST['secret_code'];
		
		if(strpos($email,"@")){
			$email = substr($email, 0, strpos($email,"@"));
		}
		
		$full_email = $email."@gmail.com";
		
		$role = "affiliate";
		$home_market_id = $_POST['market_id'];
		$secret_code = $_POST['secret_code'];
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$latitude = $_POST['latitude'];
		$longitude = $_POST['longitude'];
		$geolocation = $latitude.", ".$longitude;
		$hash = md5(rand(0,1000));
		// echo $ip_address;
		// echo $geolocation;
		
		$where = null;
		$where = "1 = 1";
		$current_users = db_select_users($where);
		
		$ip_list = array();
		$geolocation_list = array();
		$username_list = array();
		$email_list = array();
		foreach($current_users as $current_user){
			$ip_list[] = $current_user['ip_address'];
			$geolocation_list[] = $current_user['geolocation'];
			$username_list[] = $current_user['username'];
			$email_list[] = $current_user['email'];
		}
		
		$where = null;
		$where['is_active'] = "true";
		$codes = db_select_secret_codes($where);
		//print_r($codes);
		$code_list = array();
		foreach($codes as $code){
			$code_list[] = $code['secret_code'];
		}
		
		if(in_array($full_email,$email_list)){
			echo "<script>alert('We are sorry. It appears that your email has already been used for an AdSync account. Please try again.');
					window.location.replace('".base_url('/index.php/login/new_user')."');
				</script>";
		}
		// else if(in_array($username,$username_list))
		// {
			// echo "<script>alert('We are sorry. It appears that your username has already been used for an AdSync account. Please try again.');
					// window.location.replace('".base_url('/index.php/login/new_user')."');
				// </script>";
		// }
		// else if(in_array($ip_address,$ip_list) || in_array($geolocation,$geolocation_list))
		// {
			// echo "<script>alert('We are sorry. It appears that your computer has already been used for an AdSync account.');
					// window.location.replace('".base_url('/index.php/login/new_user')."');
				// </script>";
		// }
		// else if(!in_array($secret_code,$code_list))
		// {
			// echo "<script>alert('We are sorry. It appears that the code you entered is incorrect. Please try again.');
					// window.location.replace('".base_url('/index.php/login/new_user')."');
				// </script>";
		// }
		else{
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
			$new_user['email'] = $full_email;
			$new_user['role'] = $role;
			$new_user['home_market'] = $home_market_id;
			$new_user['date_joined'] = $current_datetime;
			$new_user['is_active'] = "false";
			$new_user['ip_address'] = $ip_address;
			$new_user['geolocation'] = $geolocation;
			$new_user['hash'] = $hash;
			
			db_insert_user($new_user);
			
			$user = db_select_user($new_user);
			
			$to = $full_email;
			$subject = "AdSync Confirmation Email";
			$message = "
				Click the link below to confirm your new AdSync Account.
				
				http://www.adsync.nextgenmarketingsolutions.com/index.php/login/activate?email=$full_email&hash=$hash
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
			
			$where = null;
			$where['secret_code'] = $secret_code;
			
			$set = array();
			$set['datetime_used'] = $current_datetime;
			$set['is_active'] = "false";
			
			db_update_secret_code($set,$where);
			
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