<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?=$title?></title>
		<link type="text/css" href="<?php echo base_url("css/index.css"); ?>" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url("js/jquery-1.11.3.min.js"); ?>" ></script>
		<link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="<?php echo base_url('/favicon.ico/');?>" type="image/x-icon">
		<link rel="icon" href="<?php echo base_url('/favicon.ico/');?>" type="image/x-icon">
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
		<script>
			$("username").focus();
		</script>
	</head>
	<body>
		<div style="width:100%;margin:0;color:white;background-color:#0079C1;" class="slide">
			<table>
				<tr style="font-size:30px;">
					<td style="width:20px;">
						<img style="height:35px;padding-top:5px;padding-left:15px;" src="<?=base_url("images/adsync_logo_white.png")?>"/>
					</td>
					<td style="padding-bottom:3px;padding-left:5px;">AdSync</td>
					<td style="float:right;padding-right:15px;margin-top:5px;"><a style="text-decoration:none;color:white" href="http://nextgenmarketingsolutions.com/">NextGen Marketing Solutions</a></td>
				</tr>
			</table>
		</div>
		<div class="login_form slide" style="margin:0 auto;padding:20px;margin-top:150px;width:400px;">
			<div style="text-align:center;padding-bottom:10px;padding-top:10px;font-size:53px;">Request Code</div>
			<?php $attributes = array('name'=>'code_request_form','id'=>'code_request_form','style'=>'margin-bottom:50px;' )?>
			<?=form_open_multipart(base_url('index.php/login/request_code/'),$attributes);?>
				<table>
					<tr>
						<td>
							<input placeholder="Gmail Address" value="<?php echo set_value('email'); ?>" style="margin-left:80px; margin-bottom:15px; width:240px;height:40px; border-radius:3px; border: solid 1px #c9c9c9;" type="text" id="email" name="email"/>
						</td>
					</tr>
					<tr>
						<td>
							<?php echo form_error('email'); ?>
						</td>
					<tr>
					<tr>
						<td><input class="login_btn" id="login_btn" type="submit" value="Request Code"></td>
					</tr>
					<br>
					<br>
				</table>
			</form>
		</div>
		<div style="margin:0 auto;width:400px;padding:20px;text-align:center;">
			<a href="<?=base_url('/index.php/login/new_user/')?>">Create Account</a>
		</div>
	</body>
</html>