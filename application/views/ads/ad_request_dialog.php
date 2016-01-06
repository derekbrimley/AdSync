<?php
	$where = null;
	$where['id'] = $ad_request_id;
	$ad_request = db_select_ad_request($where);
	
	$where = null;
	$where['id'] = $ad_request['market_id'];
	$market = db_select_market($where);

	$where = null;
	$where['id'] = $post_id;
	$post = db_select_post($where);
?>
<script>
	$(window).on('beforeunload', function() {
		var dataString = $("#ad_submission_form").serialize();
		console.log("Datastring: "+dataString);
		$.ajax({
			url: "<?=base_url("index.php/ads/delete_post") ?>",
			type: "POST",
			data: dataString,
			async: false,
			cache: false,
		});
	});
</script>
<div id="getting-started"></div>
<script type="text/javascript">
    var tenMinutes = new Date();
    tenMinutes.setMinutes(tenMinutes.getMinutes() + 10);
    $("#countdown").countdown(tenMinutes, function(event){
        $(this).text(
            event.strftime('%M:%S')
        );
    });
</script>
<form id="ad_request_form">
	<input id="ad_request_id" name="ad_request_id" type="hidden" value="<?=$ad_request['id']?>" />
	<input id="post_id" name="post_id" type="hidden" value="<?=$post_id?>" />
</form>
<div style="margin:0 auto; width:600px; text-align:center; margin-bottom:10px;">
	You have this ad reserved for the next <span id="countdown"></span>.
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
<div id="post_form_container" style="display:none;">
	<div style="margin:0 auto;width:600px;">
		Enter the information that you used in your ad below, then click "Submit." Your ad will be reviewed, and within 24 hours, the result will be sent to your account.
	</div>
	<form id="ad_submission_form" style="margin:0 auto;width:623px;margin-top:10px;">
		<table>
			<input id="post_id" name="post_id" type="hidden" value="<?= $post_id ?>"/>
			<input id="ad_request_id" name="ad_request_id" type="hidden" value="<?= $post['ad_request_id'] ?>"/>
			<tr>
				<td>Ad Link</td>
				<td>
					<input id="post_link" name="post_link" type="text" style="width:546px;" />
				</td>
			</tr>
			<tr>
				<td>Ad Title</td>
				<td>
					<input id="post_title" name="post_title" type="text" style="width:546px;" />
				</td>
			</tr>
			<tr>
				<td>Ad Content</td>
				<td>
					<textarea id="post_content" name="post_content" style="width:544px;height:130px;" ></textarea>
				</td>
			</tr>
			<tr>
				<td>Phone Number</td>
				<td>
					<input id="post_phone_number" name="post_phone_number" type="text" style="width:546px;" />
				</td>
			</tr>
		</table>
	</form>
</div>