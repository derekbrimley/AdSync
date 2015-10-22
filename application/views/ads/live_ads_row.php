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
		<td class="ellipsis" style="max-width:35px;min-width:35px;">
			<?=date("m/d/Y",strtotime($post['post_datetime']))?>
		</td>
		<td class="ellipsis" style="max-width:40px;min-width:40px;">
			<?=$market['name']?>
		</td>
		<td class="ellipsis" style="max-width:40px;min-width:40px;">
			<?=$ad_request['category']?>
		</td>
		<td class="ellipsis" style="max-width:50px;min-width:50px;">
			<?=$ad_request['sub_category']?>
		</td>
		<td class="ellipsis" style="max-width:30px;min-width:30px;">
			$<?=number_format($ad_spot['value'],2)?>
		</td>
		<td class="ellipsis" style="max-width:40px;min-width:40px;">
			<a target="_blank" href="<?=$post['link']?>"><?= $post['result'] ?></a>
		</td>
	</tr>
</table>