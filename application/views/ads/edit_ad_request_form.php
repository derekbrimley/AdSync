<?php
	$mjs = 'id="market_id" style="width:300px"';
	$cjs = 'id="category" style="width:300px"';
?>
<form id="edit_ad_request_form">
	<table>
		<input type="hidden" id="ad_request_id" name="ad_request_id" value="<?=$ad_request['id']?>" />
		<tr>
			<td>Market</td>
			<td><?=form_dropdown("market_id",$market_options,$ad_request_market['id'],$mjs)?></td>
		</tr>
		<tr>
			<td>Category</td>
			<td><?=form_dropdown("category",$category_options,$ad_request['category'],$cjs)?></td>
		</tr>
		<tr>
			<td>Sub-Category</td>
			<td><input type="text" name="sub_category" id="sub_category" style="width:296px" value="<?=$ad_request['sub_category']?>"/></td>
		</tr>
		<tr>
			<td>Content Description</td>
			<td><textarea name="content_desc" id="content_desc" style="height: 294px;width:527px;"><?=$ad_request['content_desc']?></textarea></td>
		</tr>
		<tr>
			<td>Price</td>
			<td><input type="text" name="price" id="price" style="width:300px" value="<?=$ad_request['price']?>"/></td>
		</tr>
	</table>
</form>