<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?=$title?></title>
		<link type="text/css" href="<?php echo base_url("css/index.css"); ?>" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url("js/jquery-1.11.3.min.js"); ?>" ></script>
		<link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="<?=base_url("/favicon-16x16.png")?>" />
	</head>
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
		</div>
</html>