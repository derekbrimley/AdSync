<?php
?>
<div style="margin:0 auto;width:600px;">
	Enter the information that you used in your ad below, then click "Submit." Your ad will be reviewed, and within 24 hours, the result will be sent to your account.
</div>
<form id="ad_submission_form" style="margin:0 auto;width:623px;margin-top:10px;">
	<input id="post_id" name="post_id" type="hidden" value="<?= $post_id ?>"/>
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