<?php
	$where = null;
	$where['id'] = $ad_request_id;
	$ad_request = db_select_ad_request($where);
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
<div style="margin:0 auto; width:600px; text-align:center; margin-bottom:10px;">
	You have this ad reserved for the next <span id="minutes">9</span>:<span id="seconds">56</span>.
</div>
<div id="content_description" style="margin:0 auto; width:600px;height:300px;padding:10px;border-radius:15px;border:2px solid #7f7f7f;">
	<div>Content Description</div>
	<hr>
	<div class="scrollable_div" style="height:260px;">
		<?= $ad_request['content_desc'] ?>
	</div>
</div>
<form id="ad_submission_form" style="margin:0 auto;width:623px;margin-top:10px;">
	<input id="post_id" name="post_id" type="hidden" value="<?= $post_id ?>"/>
	<input id="ad_request_id" name="ad_request_id" type="hidden" value="<?= $ad_request['id'] ?>"/>
	<table>
		<tr>
			<td>Ad Link</td>
			<td>
				<input id="post_link" name="post_link" type="text" style="width:546px;" />
			</td>
		</tr>
		<tr>
			<td>Ad Title</td>
			<td>
				<input id="post_title" name="post_title" type="text" style="width:546px;"/>
			</td>
		</tr>
		<tr>
			<td>Ad Content</td>
			<td>
				<textarea id="post_content" name="post_content" style="width:544px;height:130px;"></textarea>
			</td>
		</tr>
		<tr>
			<td>Phone Number</td>
			<td>
				<input id="post_phone_number" name="post_phone_number" type="text" style="width:546px;"/>
			</td>
		</tr>
	</table>
</form>