<?php
	$where = null;
	$where['id'] = $ad_spot['ad_request_id'];
	$ad_request = db_select_ad_request($where);
	
	$where = null;
	$where['id'] = $ad_request['market_id'];
	$market = db_select_market($where);
	
	$market_name = $market['name'];
?>

<table>
	<tr>
		<td style="max-width:70px;min-width:70px;">
			<?=$market_name?>
		</td>
		<td style="max-width:40px;min-width:40px;">
			<?=$ad_request['category']?>
		</td>
		<td style="max-width:75px;min-width:75px;">
			<?=$ad_request['sub_category']?>
		</td>
		<td style="max-width:30px;min-width:30px;">
			$<?=number_format($ad_spot['value'],2)?>
		</td>
		<td style="max-width:20px;min-width:20px;cursor:pointer;" onClick="reserve_ad_request(<?=$ad_spot['id']?>)">
			<img title="Click to reserve post" src="<?= base_url("images/nextgen_action_item_button_icon.png") ?>" style="display:block;margin:0 auto;height:25px;"/>
		</td>
	</tr>
</table>