<?php
	$where = null;
	$where['id'] = $account_entry['post_id'];
	$post = db_select_post($where);
?>

<table>
	<tr>
		<td class="ellipsis" style="max-width:12px;min-width:12px;">
			<?=date("m/d/Y",strtotime($account_entry['datetime']))?>
		</td>
		<td class="ellipsis" title="<?=$account_entry['description']?>" style="max-width:80px;min-width:80px;">
			<?=$account_entry['description']?>
		</td>
		<?php if($account_entry['amount']<0): ?>
			<td class="ellipsis" style="max-width:10px;min-width:10px;text-align:right;">
				<a style="color:#0079C1;text-decoration:none;" target="_blank" href="<?=base_url('/index.php/ads/download_file').'/'.$account_entry['payment_screenshot_guid']?>"><?= number_format($account_entry['amount'],2) ?></a>
			</td>
		<?php else: ?>
			<td class="ellipsis" style="max-width:10px;min-width:10px;text-align:right;">
				<a style="color:#0079C1;text-decoration:none;" target="_blank" href="<?=base_url('/index.php/ads/download_file').'/'.$post['result_screen_shot_guid']?>"><?= number_format($account_entry['amount'],2) ?></a>
			</td>
		<?php endif ?>
	</tr>
</table>