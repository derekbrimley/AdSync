<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?=$title?></title>
		<link type="text/css" href="<?php echo base_url("css/index.css"); ?>" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url("js/jquery-1.11.3.min.js"); ?>" ></script>
		<link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="<?=base_url("/favicon-16x16.png")?>" />
		<style>
			.login_btn{
				margin-left:80px;
				margin-top:40px;
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
		function resend_email(id){
			console.log(id);
			$.ajax({
				url: "<?=base_url("index.php/login/send_new_email") ?>",
				type: "POST",
				data: {id:id},
				cache: false,
				statusCode: {
					200: function(response){
						$("#resend_email_container").html(response);
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
	</script>
	<body>
		<div style="width:100%;margin:0;color:white;background-color:#0079C1;" class="slide">
			<table>
				<tr style="font-size:30px;">
					<td style="width:20px;">
						<img style="height:35px;padding-top:5px;padding-left:15px;" src="<?=base_url("images/blue_logo.png")?>"/>
					</td>
					<td style="padding-bottom:3px;padding-left:5px;">AdSync</td>
					<td style="float:right;padding-right:15px;margin-top:5px;"><a href="http://nextgenmarketingsolutions.com/" style="color:white;text-decoration:none;">NextGen Marketing Solutions</a></td>
				</tr>
			</table>
		</div>
		<div class="login_form slide" style="margin:0 auto;padding:20px;margin-top:150px;width:400px;">
			<div style="text-align:center;padding-bottom:10px;padding-top:10px;font-size:28px;">
				Please activate your account through the email you received.<br><br>
				<a style="font-size:18px;" href="<?=base_url("/")?>">Click here to go back to the login page.</a>
			</div>
			<div id="resend_email_container">
				<div>
					If you don't receive an email within 10 minutes, click the button below to resend it.
				</div>
				<button id="resend_email_btn" class="login_btn" type="button" onClick="resend_email(<?=$user_id?>)">Resend Email</button>
			</div>
		</div>
</html>