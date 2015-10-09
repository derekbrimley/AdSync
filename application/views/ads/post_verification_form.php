<table style="margin:0 auto;width:600px;margin-top:10px;margin-bottom:10px;">
	<tr>
		<td style="width:100px;">Post Title</td>
		<td><a target="_blank" href="<?=$post['link']?>"><?=$post['title']?></a></td>
	</tr>
	<tr>
		<td>Post Content</td>
		<td class="scrollable_div" style="margin:0 auto;width:475px;height:165px;padding:10px;border-radius:15px;border:2px solid #7f7f7f;"><?= $post['content'] ?></td>
	</tr>
	<tr>
		<td style="width:125px;">Market</td>
		<td><?=$market['name']?></td>
	</tr>
</table>
<?php $attributes = array('name'=>'post_verification_form','id'=>'post_verification_form','target'=>'_blank','style'=>'margin:0 auto;width:600px;')?>
<?=form_open_multipart('ads/submit_validation',$attributes);?>
	<input id="post_id" name="post_id" type="hidden" value="<?=$post['id']?>" />
	<table>
		<tr>
			<td style="max-width:125px;min-width:125px;">Post Result</td>
			<td>
				<select id="post_result" name="post_result">
					<option>Select</option>
					<option>Live</option>
					<option>Flagged</option>
					<option>Incorrect Category</option>
					<option>Incorrect Market</option>
					<option>Incorrect Contact Info</option>
					<option>Incorrect Content</option>
					<option>Out of Date</option>
					<option>Removed By Author</option>
					<option>Other Error</option>
				</select>
			</td>
		</tr>
		<tr>
			<td style="max-width:125px;min-width:125px;">Post Screenshot</td>
			<td>
				<input type="file" id="result_screen_shot" name="result_screen_shot" ></textarea>
			</td>
		</tr>
		<tr>
			<td style="max-width:125px;min-width:125px;">Notes</td>
			<td>
				<textarea id="result_notes" name="result_notes" style="width:475px;height:65px;"></textarea>
			</td>
		</tr>
	</table>
</form>