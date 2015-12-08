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
	
	$where = null;
	$where['id'] = $post['poster_id'];
	$user = db_select_user($where);
?>

<table>
	<tr>
		<?php if($role=="admin"): ?>
			<td class="ellipsis" title="<?=$user['username'] ?>" style="max-width:35px;min-width:35px;">
				<?=$user['username'] ?>
			</td>
		<?php endif ?>
		<td class="ellipsis" title="<?=date("m/d/y",strtotime($post['post_datetime']))?>" style="max-width:37px;min-width:37px;">
			<?=date("m/d/y",strtotime($post['post_datetime']))?>
		</td>
		<td class="ellipsis" title="<?=$market['name']?>" style="max-width:40px;min-width:40px;">
			<?=$market['name']?>
		</td>
		<td class="ellipsis" title="<?=$ad_request['category']?>" style="max-width:40px;min-width:40px;">
			<?=$ad_request['category']?>
		</td>
		<td class="ellipsis" title="<?=$ad_request['sub_category']?>" style="max-width:40px;min-width:40px;">
			<?=$ad_request['sub_category']?>
		</td>
		<td class="ellipsis" title="" style="max-width:20px;min-width:20px;">
			$<?=number_format($ad_spot['value'],2)?>
		</td>
		<td class="ellipsis" title="<?= $post['result'] ?>" style="max-width:30px;min-width:30px;">
			<?php if(!empty($post["result_screen_shot_guid"])): ?>
				<a target="_blank" href="<?=base_url('/index.php/ads/download_file')."/".$post["result_screen_shot_guid"]?>"><?= $post['result'] ?></a>
			<?php else: ?>
				<?= $post['result'] ?>
			<?php endif ?>
		</td>
		<td class="ellipsis" style="max-width:20px;min-width:20px;">
			$<?= $post['amount_due'] ?>
		</td>
	</tr>
</table>