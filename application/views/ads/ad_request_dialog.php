<?php
	$where = null;
	$where['id'] = $ad_request_id;
	$ad_request = db_select_ad_request($where);
	
	$where = null;
	$where['id'] = $ad_request['market_id'];
	$market = db_select_market($where);
?>
<script>
	function warning(){
		if(true){
			var dataString = $("#ad_submission_form").serialize();
			
			$.ajax({
				url: "<?=base_url("index.php/ads/delete_post") ?>",
				type: "POST",
				data: dataString,
				async: false,
				cache: false,
			})
		}
	}
	window.onbeforeunload = warning;
</script>
<input id="ad_request_id" name="ad_request_id" type="hidden" value="<?=$ad_request['id']?>" />
<input id="post_id" name="post_id" type="hidden" value="<?=$post_id?>" />
<div style="margin:0 auto; width:600px; text-align:center; margin-bottom:10px;">
	You have this ad reserved for the next <span id="minutes">9</span>:<span id="seconds">56</span>.
</div>
<div id="instructions_container">
	<div style="margin:0 auto;width:600px;padding:10px;">
		Post the ad in the following Craigslist section: <a target="_blank" href="<?=$market['link']?>"><?=$market['name']?></a>.<br><br>
		Use the following information to post the ad. Once you have posted the ad, click "Next" to submit your posting for review.
	</div>
	<div id="content_description" style="margin:0 auto; width:600px;height:465px;padding:10px;border-radius:15px;border:2px solid #7f7f7f;">
		<div>Content Description</div>
		<hr>
		<div class="scrollable_div" style="height:430px;">
			<?= $ad_request['content_desc'] ?>
		</div>
	</div>
</div>
<div id="post_form_container">
</div>