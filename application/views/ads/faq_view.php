<script>
	$(function(){
		$(".answer").hide();
	});//ready
</script>

FAQ
<span>
	<img id="loading_icon" style="display:none;float:right;height:20px;margin-left:20px;" src="<?=base_url('images/loading.gif')?>"/>
	<img id="refresh_icon" onClick="load_faq()" style="float:right;height:20px;cursor:pointer;margin-left:20px;" src="<?=base_url('images/refresh_icon_grey_360.png')?>"/>
</span>
<hr>
<div>
	<div id="site_explanation_question" class="question clickable_row" onclick="show_answer(1)">
		What is this?
	</div>
	<div id="site_explanation_answer" class="answer">
		<p>We need your help posting ads on Craigslist to recruit drivers from across the country. 
		Craigslist is the top market for recruiting truck drivers. In an effort to prevent spam, Craigslist 
		limits how much we can post in order to find these drivers. That makes it difficult for us because 
		we’re not spam. We legitimately hire drivers from across the country for our CDL training and 
		driving positions.</p>
		<p>We will pay you for every ad that you post that is still live after 24 hours. 
		Every ad can be renewed every 48 hours through a very simple process and I will pay $1 for 
		each time you renew that ad. That’s roughly $25 per month for each ad that post and keep 
		renewed. You can post as many ads as you would like- we will pay for each ad that stays live. 
		We also have a referral program. If you refer a friend, we will pay YOU $20 for their first live.</p>
	</div>
</div>
<div>
	<div id="ad_post_question" class="question clickable_row" onclick="show_answer(2)">
		How does it work?
	</div>
	<div id="ad_post_answer" class="answer">
		<p>Navigate to the Post Board by clicking on the "Post Board" box on the left. A list of
		available ads will appear. Click on the green button to reserve the ad. A pop-up box will
		appear for you to enter in information about the posting. You have 10 minutes to post the 
		ad on Craigslist in the specified market and category, with the specified content. When you
		are finished posting the ad, fill out the form, and submit the posting.</p>
		<p>After you have posted the ad, we will verify that it was posted. We try and verify every
		post within 24 hours of the posting. If your post is live, we will verify it and you will
		receive credit for it. Reasons the post is not verified include: the post is not there; 
		posted in the wrong market; posted in the wrong category; post doesn't include necessary content;
		etc. If the post is rejected, an explanation will be written, and a screenshot will be taken.</p>
	</div>
</div>
<div>
	<div id="money_question" class="question clickable_row" onclick="show_answer(3)">
		How do I get paid?
	</div>
	<div id="money_answer" class="answer">
		<p>We disperse funds using Google Wallet. If you need help setting up a Google Wallet account,
		visit <a target="_blank" href="https://www.google.com/wallet/">their website</a>. Every Friday, funds are 
		dispersed. Your current balance will be sent to your account. If you have any problems, email or 
		call us.</p>
	</div>
</div>
<div>
	<div id="ad_type_question" class="question clickable_row" onclick="show_answer(4)">
		What kind of ads will I be posting?
	</div>
	<div id="ad_type_answer" class="answer">
		<p>All the ads that you will be asked to post are for individuals or businesses who wish to make 
		job listings available on Craigslist in several different areas or markets. </p>
	</div>
</div>
<div>
	<div id="terms_of_use_question" class="question clickable_row" onclick="show_answer(5)">
		Does this violate the Craigslist terms of use?
	</div>
	<div id="terms_of_use_answer" class="answer">
		<p>We review each ad’s content to make sure it is not in violation of Craigslist 
		Terms of Use. If you are ever asked to post an ad that you feel violates those conditions, 
		please report the content to <a target="_blank" 
		href="mailto:nextgenmarketing.adsync@gmail.com?Subject=Craigslist Terms Of Use Violation">
			nextgenmarketing.adsync@gmail.com
		</a>.</p>
	</div>
</div>
<div>
	<div id="ads_deleted_question" class="question clickable_row" onclick="show_answer(6)">
		Why are my ads getting deleted?
	</div>
	<div id="ads_deleted_answer" class="answer">
		<p>Ads get deleted for a variety of reasons:</p>
			<p>1. The ad content violates the Craigslist Terms of Use</p>
			<p>2. Other Craigslist viewers “flag” the ad as a violation of terms of use</p>
			<p>3. The ad content seems too good to be true</p>
			<p>4. There are already many similar ads and it seems to be a copy of those ads</p>
			<p>5. Your IP address linked to your computer has been posting too frequently</p>
			<p>6. The number of allowable posts on your Craigslist account has been surpassed</p>
			<p>7. Sometimes the ad just gets deleted for no apparent reason</p>
	</div>
</div>
<div>
	<div id="ad_renewal_question" class="question clickable_row" onclick="show_answer(7)">
		Why aren’t my ads able to be renewed?
	</div>
	<div id="ad_renewal_answer" class="answer">
		<p>Ads can be renewed every 48 hours. The ad cannot be renewed until a full 48 hours 
		has passed from the time it was posted. Sometimes ads can’t be renewed because they 
		were marked by Craigslist as violating the Terms of Use, even though they did not.</p>
	</div>
</div>
<div>
	<div id="google_wallet_question" class="question clickable_row" onclick="show_answer(8)">
		What is Google Wallet and how does it work?
	</div>
	<div id="google_wallet_answer" class="answer">
		<p>Google Wallet is a mobile payment system developed by Google that allows its users 
		to store debit cards, credit cards, loyalty cards, and gift cards, among other things, 
		as well as redeeming sales promotions on their mobile phone. More information can be 
		found on <a href="wallet.google.com">wallet.google.com</a></p>
	</div>
</div>
<div>
	<div id="ghosting_question" class="question clickable_row" onclick="show_answer(9)">
		I can see my post when I click the link but I can’t find it in the Craigslist listing. Why is this?
	</div>
	<div id="ghosting_answer" class="answer">
		<p>‘Ghosting’ is the term applied to when you make a post on Craigslist, and the system 
		tells you that your post has been published but your post never appears on the front page 
		of Craigslist. The system gives you a post ID and a URL and you can see your post if you 
		put the post’s URL in your browser, but unfortunately no one else will be able to see it 
		because it will never appear on the front page. Your post becomes like a ghost wandering 
		the back halls of Craigslist aimlessly looking for someone to look at it, but no one can 
		see it. It’s a sneaky way they found to get rid of people they don’t want posting on Craigslist</p>
	</div>
</div>
<div>
	<div id="limit_question" class="question clickable_row" onclick="show_answer(10)">
		Is there a limit to how many ads I can post?
	</div>
	<div id="limit_answer" class="answer">
		<p>You will have more successful posts if you limit the amount of posting you do. You 
		are most likely to be flagged by Craigslist if you are posting over 5 ads a day from 
		your IP address. Instead, if you post under 5 ads per day and no more than 20 or so in 
		a month, you will see that your ads will stay live and you will be able to renew them. </p>
	</div>
</div>
<div>
	<div id="gmail_question" class="question clickable_row" onclick="show_answer(11)">
		Why do I need a Gmail account?
	</div>
	<div id="gmail_answer" class="answer">
		<p>At this time, we are only able to pay by Google Wallet, which requires you to have 
		a Gmail account. You are welcome to post the ads from any email account you desire, 
		so long as you can receive payment through your Gmail account. </p>
	</div>
</div>