<head>
		<title>Change Password</title>
		<link type="text/css" href="<?php echo base_url("css/index.css"); ?>" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url("js/jquery-1.11.3.min.js"); ?>" ></script>
		<link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="<?=base_url("/favicon-16x16.png")?>" />
		<style>
			.login_btn{
				margin-left:80px;
				margin-bottom:40px;
				height:50px;
				width:244px;
				background-color:#6295FC;
				color:#FFFFFF;
				border-radius:3px;
				border:0px;
				font-size:18px;
				cursor:pointer;
			}
			.login_btn:hover{
				
				background-color:#4E86FC;
			}
			.login_btn:active{
				
				background-color:#4e78fc;
			}
		</style>
	</head>
<script>
	var report_ajax_call;
	
	function submit_password(){
		var pass1 = $("#password1").val();
		var pass2 = $("#password2").val();
		
		if(pass1==''||pass2==''){
			alert("Please fill in all of the fields.");
		}else if(pass1!=pass2){
			alert("Passwords don't match");
		}else{
			var dataString = $("#new_password_form").serialize();
			//AJAX
			if(!(report_ajax_call===undefined))
			{
				report_ajax_call.abort();
			}
			report_ajax_call = $.ajax({
				
				url: "<?=base_url("index.php/login/update_password") ?>",
				type: "POST",
				data: dataString,
				cache: false,
				statusCode: {
					200: function(){
						alert("Your password has been reset. You can log in with your new credentials.");
						window.location.replace("http://adsync.nextgenmarketingsolutions.com/")
						},
					404: function(){
						alert('Page not found');
					},
					500: function(response){
						alert("500 error! "+response);
					}
				}
			});//END AJAX
		}
	}
</script>
<div class="slide" style="margin:0 auto;padding:20px;margin-top:20px;width:400px;">
	<div style="text-align:center;padding-bottom:10px;padding-top:10px;font-size:53px;">Reset Password</div>
	<form id="new_password_form" name="new_password_form">
		<input type="hidden" id="email" name="email" value="<?=$email?>" />
		Choose your new password: <input id="password1" name="password1" type="password" /><br><br>
		Verify your new password: <input id="password2" name="password2" type="password" /><br><br>
	</form>
	<button type="button" class="login_btn" id="submit_btn" name="submit_btn" onClick="submit_password()">Submit</button>
	<div>
		<a href="http://adsync.nextgenmarketingsolutions.com/">Click here to log in.</a>
	</div>
</div>