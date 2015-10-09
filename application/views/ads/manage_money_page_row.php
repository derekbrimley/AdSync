<?php
	$user_id = $account_entry['user_id'];
	$where = null;
	$where['id'] = $user_id;
	$user = db_select_user($where);
	
	$where = null;
	$where['id'] = $account_entry['post_id'];
	$post = db_select_post($where);
?>
<table>
	<tr>
		<td style="max-width:20px;min-width:20px;">
			<?=$user['first_name']." ".$user['last_name']?>
		</td>
		<td style="max-width:14px;min-width:14px;">
			<?=date("m/d/Y",strtotime($account_entry['datetime']))?>
		</td>
		<td style="max-width:75px;min-width:75px;">
			<?=$account_entry['description']?>
		</td>
		<?php if($account_entry['amount']<0): ?>
			<td style="max-width:10px;min-width:10px;text-align:right;">
				<a style="color:#0079C1;text-decoration:none;" target="_blank" href="<?=base_url('/index.php/ads/download_file').'/'.$account_entry['payment_screenshot_guid']?>"><?= number_format($account_entry['amount'],2) ?></a>
			</td>
		<?php else: ?>
			<td style="max-width:10px;min-width:10px;text-align:right;">
				<a style="color:#0079C1;text-decoration:none;" target="_blank" href="<?=base_url('/index.php/ads/download_file').'/'.$post['result_screen_shot_guid']?>"><?= number_format($account_entry['amount'],2) ?></a>
			</td>
		<?php endif ?>
	</tr>
</table>