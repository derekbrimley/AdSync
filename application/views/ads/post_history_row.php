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
		<td style="max-width:20px;min-width:20px;">
			$<?=number_format($ad_spot['value'],2)?>
		</td>
		<td style="max-width:50px;min-width:50px;">
		<?php if(!empty($post["result_screen_shot_guid"])): ?>
			<a target="_blank" href="<?=base_url('/index.php/ads/download_file')."/".$post["result_screen_shot_guid"]?>" onclick=""><?= $post['result'] ?></a>
		<?php else: ?>
			<?= $post['result'] ?>
		<?php endif ?>
		</td>
		<td style="max-width:20px;min-width:20px;">
			$<?= $post['amount_due'] ?>
		</td>
	</tr>
</table>