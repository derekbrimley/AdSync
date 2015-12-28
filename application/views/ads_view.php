<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?=$title?></title>
		<link type="text/css" href="<?php echo base_url("css/index.css"); ?>" rel="stylesheet" />
		<link type="text/css" href="<?php echo base_url("css/jquery-ui.min.css"); ?>" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url("js/jquery-1.11.3.min.js"); ?>" ></script>
		<script type="text/javascript" src="<?php echo base_url("js/jquery-ui.min.js"); ?>" ></script>
		<link rel="shortcut icon" href="<?=base_url("/favicon-16x16.png")?>" />
		<link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
	</head>
	<?php include("ads/ad_scripts.php"); ?>
	<?php
		$role = $this->session->userdata('role');
	?>
	<script>
		
		function countdown() {
			var m = $('#minutes');
			var s = $('#seconds');  
			if(m.length == 0 && parseInt(s.html()) <= 0) {
				$('.clock').html('Timer Complete.');    
			}
			if(parseInt(s.html()) <= 0) {
				m.html(parseInt(m.html()-1));   
				s.html(60);
			}
			if(parseInt(m.html()) <= 0) {
				$('.clock').html('<span class="sec">59</span> seconds.'); 
			}
			if(parseInt(s.html()) <= 10) {
				s.html("0"+parseInt(s.html()-1));
			}
			else
			{
				s.html(parseInt(s.html()-1));
			}
		}
		setInterval('countdown()',1000);
	</script>
	<body style="background-color: #eee;">
		<div style="display:none;">
			<input type="hidden" id="number_of_visits" value="<?=$user['number_of_visits']?>" />
		</div>
		<div id="header" style="padding:25px 100px;background-color:#0079C1;color:white;font-size:24px;">
			<div id="header_content" style="width:1100px;margin:0 auto;">
				<span>
					<a href="<?= base_url("/index.php/ads/") ?>" style="text-decoration:none;color:white;">AdSync</a>
				</span>
				<span id="logout_btn">
					<a style="text-decoration:none;color:white;" href="<?=base_url('/index.php/login/logout') ?>">Log Out</a>
				</span>
				<span>
					<button style="font-family:'Roboto',sans-serif;" id="help_btn" type="button" onClick="tutorial_open()">Help</button>
				</span>
			</div>
		</div>
		<div id="main_content" style="display:block;margin:0 auto;width:1100px;">
			<div id="left_bar" style="float:left;margin-top:20px;">
				<div id="current_balance" style="text-align:center;padding:20px;width:235px;margin-bottom:20px;height:100px;border-radius:15px;border:1px solid #7f7f7f;background-color:white;">
					Current Balance
					<hr>
					<div id="user_balance" style="margin:0 auto;margin-top:13px;color:green;font-size:50px;font-weight:bold;"></div>
				</div>
				<div id="navigation" style="padding-left:20px; padding-top:20px; padding-bottom:10px; width:255px;height:520px;border-radius:15px;border:1px solid #7f7f7f;background-color:white;">
					Navigation
					<hr>
					<div id="nav_container" class="scrollable_div" style="height:100%; width:255px;">
						<?php if($role == "affiliate" || $role == "admin" || $role == "manager"): ?>
							<div id="post_board_box" class="nav_box" onClick="load_post_board()">
								<div style="height:77px;">
									<img id="post_board_nav_icon" src="<?= base_url("images/post_board_icon.png") ?>" class="nav_box_image" style="height:55px; position:relative; top:12px;"/>
								</div>
								<div class="nav_box_title">Post Board</div>
							</div>
							<div id="post_history_box" class="nav_box" onClick="load_post_history()">
								<div style="height:77px;">
									<img id="post_history_nav_icon" src="<?= base_url("images/hour_glass.png") ?>" class="nav_box_image" style="height:60px; position:relative; top:11px;"/>
								</div>
								<div class="nav_box_title">Post History</div>
							</div>
							<div id="renewals_box" name="renewals_box" class="nav_box" onClick="load_renewals()">
								<div style="height:77px;">
									<img id="renewals_nav_icon" src="<?= base_url("images/renewals_icon.png") ?>" class="nav_box_image" style="height:70px; position:relative; top:5px;"/>
								</div>
								<div id="renewals_box" class="nav_box_title">Renewals</div>
							</div>
							<div id="live_ads_box" class="nav_box" onClick="load_live_ads()">
								<div style="height:77px;">
									<img id="live_ads_nav_icon" src="<?= base_url("images/live_ads_icon.png") ?>" class="nav_box_image" style="height:55px; position:relative; top:12px;"/>
								</div>
								<div class="nav_box_title">Live Ads</div>
							</div>
							<div id="referrals_box" class="nav_box" onClick="load_referrals()">
								<div style="height:77px;">
									<img id="referrals_nav_icon" src="<?= base_url("images/referals_icon.png") ?>" class="nav_box_image" style="height:77px; position:relative; "/>
								</div>
								<div class="nav_box_title">Referrals</div>
							</div>
							<div id="faq_box" class="nav_box" onClick="load_faq()">
								<div style="height:77px;">
									<img id="faq_nav_icon" src="<?= base_url("images/question_mark.png") ?>" class="nav_box_image" style="height:130px; position:relative; right:30px; bottom:40px;"/>
								</div>
								<div class="nav_box_title">FAQ</div>
							</div>
						<?php endif ?>
						<?php if($role == "affiliate"  || $role == "admin"): ?>
							<div id="money_box" class="nav_box" onClick="load_money_report()">
								<div style="height:77px;">
									<img id="money_nav_icon" src="<?= base_url("images/money_icon.png") ?>" class="nav_box_image" style="height:113px; position:relative; right:25px; bottom:29px;"/>
								</div>
								<div class="nav_box_title">Money</div>
							</div>
						<?php endif ?>
						<?php if($role == "admin" || $role == "manager"): ?>
							<div id="manage_money_box" class="nav_box" onClick="load_manage_money_page()">
								<div style="height:77px;">
									<img id="manage_money_nav_icon" src="<?= base_url("images/manage_money_icon.png") ?>" class="nav_box_image" style="height:83px; position:relative; right:5px;bottom:10px;"/>
								</div>
								<div class="nav_box_title">Settle</div>
							</div>
							<div id="generate_code_box" class="nav_box" onClick="load_generate_code_page()">
								<div style="height:77px;">
									<img id="generate_code_nav_icon" src="<?= base_url("images/code.png") ?>" class="nav_box_image" style="height:75px; position:relative; right:5px;"/>
								</div>
								<div class="nav_box_title">Codes</div>
							</div>
							<div id="accounts_box" class="nav_box" onClick="load_accounts_page()">
								<div style="height:77px;">
									<img id="accounts_nav_icon" src="<?= base_url("images/accounts.png") ?>" class="nav_box_image" style="height:75px; position:relative;"/>
								</div>
								<div class="nav_box_title">Accounts</div>
							</div>
						<?php endif ?>
						<?php if($role == "client" || $role == "admin" || $role == "manager"): ?>
							<div id="create_ad_request_box" class="nav_box" onClick="load_ad_requests()">
								<div style="height:77px;">
									<img id="ad_requests_nav_icon" src="<?= base_url("images/ad_request_icon.png") ?>" class="nav_box_image" style="height:70px; position:relative; top:10px; left:5px;"/>
								</div>
								<div class="nav_box_title">Ad Requests</div>
							</div>
						<?php endif ?>
						<?php if($role == "staff" || $role == "admin" || $role == "manager"): ?>
							<div id="verify_posts_box" class="nav_box" onClick="load_post_verification_page()" >
								<div style="height:77px;">
									<img id="verify_posts_nav_icon" src="<?= base_url("images/verify_posts_icon.png") ?>" class="nav_box_image" style="height:77px; position:relative; "/>
								</div>
								<div class="nav_box_title">Verify Posts</div>
							</div>
						<?php endif ?>
						<div id="account_info_box" class="nav_box" onClick="load_account_info()">
							<div style="height:77px;">
								<img id="account_info_nav_icon" src="<?= base_url("images/account_info.png") ?>" class="nav_box_image" style="height:75px; position:relative;"/>
							</div>
							<div class="nav_box_title">Account Info</div>
						</div>
					</div>
				</div>
			</div>
			<div id="report_container" style="padding:20px;margin-top:20px;margin-left:20px;width:757px;height:694px;float:left;border-radius:15px;border:1px solid #7f7f7f;background-color:white;">
				Report
				<hr>
			</div>
		</div>
	</body>
	
	<div id="ad_submission_dialog" title="New Ad Submission" style="font-family: 'Roboto', sans-serif;">
		<div id="ajax_container">
		</div>
	</div>
	<div id="ad_request_dialog" title="New Ad Request" style="font-family: 'Roboto', sans-serif;">
		<div id="ad_request_container">
			<?php include("ads/ad_request_form.php"); ?>
		</div>
	</div>
	<div id="ad_verification_dialog" title="Ad Verification" style="font-family: 'Roboto', sans-serif;">
		<div id="verification_ajax_container">
			
		</div>
	</div>
	<div id="post_renewal_dialog" title="Ad Renewal" style="font-family: 'Roboto', sans-serif;">
		<form id="renewal_form">
			<input id="renewal_post_id" name="renewal_post_id" type="hidden" value="" />
		</form>
		<div id="renewal_ajax_container">
			Click Submit to confirm that you have renewed this posting. The
			post will be re-verified.
		</div>
	</div>
	<div id="settle_balance_dialog" title="Settle Balance" style="font-family: 'Roboto', sans-serif;">
		<div id="settle_balance_ajax_container">
			
		</div>
	</div>
	<div id="tutorial_dialog" style="font-family: 'Roboto', sans-serif;">
		<div>
			<img style="width:450px;" src="<?=base_url('images/negative-space.jpg')?>"/>
		</div>
		<div class="tutorial_text" id="slide_1">
			<div class="tutorial_title">Welcome to AdSync!</div>
			<div class="tutorial_desc">
				AdSync is a marketplace for Craigslist ads. We post "ad requests" from people who need ads posted. When you post an ad for them, you get paid.
			</div>
		</div>
		<div class="tutorial_text" id="slide_2" style="display:none;">
			<div class="tutorial_title">Posting an Ad</div>
			<div class="tutorial_desc">To post an ad, go to the post board, and click on the "Reserve" button next to the ad request you would like to fulfill. From that point, follow the instructions to post the ad on Craigslist. You have the ad reserved for 10 minutes, so no one else can post that ad until your time runs out. Once you have posted the ad, fill out the form with the required information, and click the "Submit" button.</div>
		</div>
		<div class="tutorial_text" id="slide_3" style="display:none;">
			<div class="tutorial_title">Verifying the Ad</div>
			<div class="tutorial_desc">Now that you have posted the ad, we just need to verify that the post is actually there, and fulfills the requirements of the ad request. We generally verify an ad within 24 hours of the posting. As soon as we have checked the ad, we send you an email with the status of the post. You can see the statuses of all of your posts in the "Post History" tab. </div>
		</div>
		<div class="tutorial_text" id="slide_4" style="display:none;">
			<div class="tutorial_title">Renewals</div>
			<div class="tutorial_desc">24 hours after your ad goes live on Craigslist, you can repost it with a click of a button. When you do that, go to the "Renewals" tab to resubmit the ad. We will reverify that the ad was renewed, and add more money into your account. Each renewal is worth $1.00. Easy money!</div>
		</div>
		<div class="tutorial_text" id="slide_5" style="display:none;">
			<div class="tutorial_title">How You Get Paid</div>
			<div class="tutorial_desc">We pay your balance every week via Google Wallet. If you need to set up your Google Wallet account, or have any questions, go to <a href="https://www.google.com/wallet/">this link</a>. If you ever have any problems with getting paid, contact us immediately. We want to get you your money!</div>
		</div>
		<div class="tutorial_text" id="slide_6" style="display:none;">
			<div class="tutorial_title">That's It!</div>
			<div class="tutorial_desc">Simple, huh? Now, go start making some money!</div>
		</div>
		<div>
			<button class="tutorial_btn" id="tutorial_back_btn" onClick="tutorial_back_btn()" type="button" style="display:none;cursor:pointer;"> << </button>
			<button class="tutorial_btn" id="tutorial_next_btn" onClick="tutorial_next_btn()" type="button" style="cursor:pointer;float:right;"> >> </button>
			<button class="tutorial_btn" id="tutorial_close_btn" onClick="tutorial_close_btn()" style="cursor:pointer;display:none;float:right;" type="button">Close</button>
		</div>
	</div>