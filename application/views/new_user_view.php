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
			.error{
				color:red;
				margin-left:80px;
			}
		</style>
	</head>
	<script>
		$(function(){
			if(navigator.geolocation)
			{
				navigator.geolocation.getCurrentPosition(
					function(position)
					{
						$("#latitude").val(position.coords.latitude);
						$("#longitude").val(position.coords.longitude);
					}
				);
			}
			var ip = "<?php echo $_SERVER['REMOTE_ADDR']?>";
			console.log(ip);
			$("#ip_address").val(ip);
		})
		function validate_new_user_form()
		{
			var first_name = $("#first_name").val();
			var last_name = $("#last_name").val();
			var username = $("#username").val();
			var password = $("#password").val();
			var email = $("#email").val();
			var market_id = $("#market_id").val();
			var secret_code = $("#secret_code").val();
			
			var is_valid = true;
			
			if(first_name == '')
			{
				is_valid = false;
				alert("Please enter your first name.");
			}
			else if(last_name == '')
			{
				is_valid = false;
				alert("Please enter your last name.");
			}
			else if(username == '')
			{
				is_valid = false;
				alert("Please enter a username.");
			}
			else if(password == '')
			{
				is_valid = false;
				alert("Please enter your password.");
			}
			else if(email == '')
			{
				is_valid = false;
				alert("Please enter your email address.");
			}
			else if(secret_code.match(/[^0-9]/))
			{
				is_valid = false;
				alert("Please enter a valid code.");
			}
			else if(market_id == 'Select')
			{
				is_valid = false;
				alert("Please enter your Craigslist market.");
			}
			if(is_valid)
			{
				var dataString = $("#new_user_form").serialize();
				$.ajax({
					url: "<?=base_url("index.php/login/create_new_user") ?>",
					type: "POST",
					data: dataString,
					cache: false,
					statusCode: {
						200: function(){
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
		<div class="login_form slide" style="margin:0 auto;padding:20px;margin-top:20px;width:400px;">
			<div style="text-align:center;padding-bottom:10px;padding-top:10px;font-size:53px;">Create Account</div>
			<?php $attributes = array('name'=>'new_user_form','id'=>'new_user_form','style'=>'margin-bottom:50px;' )?>
			<?=form_open_multipart(base_url('index.php/login/create_new_user/'),$attributes);?>
				<input id="latitude" name="latitude" type="hidden" value="" />
				<input id="longitude" name="longitude" type="hidden" value="" />
				<input id="ip_address" name="ip_address" type="hidden" value="" />
				<table>
					<tr> 	 	
						<td><input placeholder="First Name" value="<?php echo set_value('first_name'); ?>" style="margin-left:80px;width:240px;height:40px;border-radius:3px;border: solid 1px #c9c9c9;" type="text" id="first_name" name="first_name"/></td>
					</tr>
					<tr>
						<td>
							<?php echo form_error('first_name'); ?>
						</td>
					<tr>
					</tr>
					<tr>
						<td><input placeholder="Last Name" value="<?php echo set_value('last_name'); ?>" style="margin-left:80px;width:240px;height:40px;border-radius:3px;border: solid 1px #c9c9c9;" type="text" id="last_name" name="last_name"/></td>
					</tr>
					<tr>
						<td>
							<?php echo form_error('last_name'); ?>
						</td>
					<tr>
					<tr>	
						<td><input placeholder="Username" value="<?php echo set_value('username'); ?>" style="margin-left:80px;width:240px;height:40px;border-radius:3px;border:solid 1px #c9c9c9;" type="text" id="username" name="username"/></td>
					</tr>
					<tr>
						<td>
							<?php echo form_error('username'); ?>
						</td>
					<tr>
					<tr>
						<td><input placeholder="Password" value="<?php echo set_value('password'); ?>" style="margin-left:80px;width:240px;height:40px;border-radius:3px;border:solid 1px #c9c9c9;" type="password" id="password" name="password"/></td>
					</tr>
					<tr>
						<td>
							<?php echo form_error('password'); ?>
						</td>
					<tr>
					<tr>
						<td><input placeholder="Confirm Password" value="<?php echo set_value('passconf'); ?>" style="margin-left:80px;width:240px;height:40px;border-radius:3px;border:solid 1px #c9c9c9;" type="password" id="passconf" name="passconf"/></td>
					</tr>
					<tr>
						<td>
							<?php echo form_error('passconf'); ?>
						</td>
					<tr>
					<tr>
						<td><input placeholder="Gmail Address" value="<?php echo set_value('email'); ?>" style="margin-left:80px;width:232px;height:40px;border-radius:3px;border:solid 1px #c9c9c9;" type="text" id="email" name="email"/>
						<span style="color:red;cursor:pointer" onClick="alert('Must be Gmail account. If you do not have a Gmail account, go to http://gmail.com/ to get one.')"> ?</span></td>
					</tr>
					<tr>
						<td>
							<?php echo form_error('email'); ?>
						</td>
					<tr>
					<tr>
						<td>
							<select id="market_id" name="market_id" style="margin-left:80px;width:232px;height:40px;border-radius:3px;border:solid 1px #c9c9c9;">
								<option>Select Craigslist Market</option>
								<?php foreach($markets as $market): ?>
									<option <?php echo set_select('market_id', $market['id']); ?> value="<?=$market['id']?>"><?=$market['name']?>, <?=$market['state']?></option>
								<?php endforeach ?>
							</select>
							<span style="color:red;cursor:pointer;" onClick="alert('To find your market, go to http://www.craigslist.com/')"> ?</span>
					</tr>
					<tr>
						<td>
							<?php echo form_error('market_id'); ?>
						</td>
					<tr>
					<tr>
						<td><input placeholder="Code" value="<?php echo set_value('secret_code'); ?>" style="margin-left:80px;width:230px;height:40px;border-radius:3px;border:solid 1px #c9c9c9;" type="text" id="secret_code" name="secret_code"/>
						<span style="color:red;cursor:pointer;" onClick="alert('Enter the code that was given to you by us. If you have not received a code, send us an email at ryguy.msioo@gmail.com.')"> ?</span></td>
					</tr>
					<tr>
						<td>
							<?php echo form_error('secret_code'); ?>
						</td>
					<tr>
					<tr>
						<td>
							<input class="login_btn" id="next_btn" type="submit" value="Next" />
						</td>
					</tr>
					<br>
					<br>
				</table>
			</form>
		</div>
	</body>
</html>