<?php

	$where = null;
	$where['id'] = $post['ad_request_id'];
	$ad_request = db_select_ad_request($where);

	$where = null;
	$where['ad_request_id'] = $ad_request['id'];
	$ad_spot = db_select_ad_spot($where);
	
	$where = null;
	$where['id'] = $ad_request['market_id'];
	$market = db_select_market($where);
?>

<table>
	<tr>
		<td style="max-width:35px;min-width:35px;">
			<?=date("m/d/Y",strtotime($post['post_datetime']))?>
		</td>
		<td style="max-width:40px;min-width:40px;">
			<?=$market['name']?>
		</td>
		<td style="max-width:40px;min-width:40px;">
			<?=$ad_request['category']?>
		</td>
		<td style="max-width:50px;min-width:50px;">
			<?=$ad_request['sub_category']?>
		</td>
		<td style="max-width:30px;min-width:30px;">
			<a title="<?=$post['link']?>" href="<?=$post['link']?>" target="_blank" >Link</a>
		</td>
		<td style="max-width:20px;min-width:20px;cursor:pointer;" onClick="open_verification_dialog(<?=$post['id']?>)">
			<img title="Click to verify or reject post" src="<?= base_url("images/nextgen_action_item_button_icon.png") ?>" style="display:block;margin:0 auto;height:25px;"/>
		</td>
	</tr>
</table>