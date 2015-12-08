<?php
	$where = null;
	$where['id'] = $user['referred_by'];
	$referrer = db_select_user($where);
	
	$status_options = [
		"true" => "Active",
		"false" => "Inactive",
	];
	
	$extra_options = 'id="status"';
?>
<form id="user_form_<?=$user['id']?>">
	<table>
		<input id="user_id" name="user_id" type="hidden" value="<?=$user['id']?>" />
		<tr>
			<td class="ellipsis" title="<?=$user['username']?>" style="max-width:35px;min-width:35px;">
				<?=$user['username']?>
			</td>
			<td class="ellipsis" title="<?=$user['first_name']." ".$user['last_name']?>" style="max-width:30px;min-width:30px;">
				<?=$user['first_name']." ".$user['last_name']?>
			</td>
			<td class="ellipsis" title="<?=$user['email']?>" style="max-width:40px;min-width:40px;">
				<?=$user['email']?>
			</td>
			<td class="ellipsis" title="<?=$user['role']?>" style="max-width:20px;min-width:20px;">
				<?=$user['role']?>
			</td>
			<td class="ellipsis" title="<?=$user['date_joined']?>" style="max-width:30px;min-width:30px;">
				<?=$user['date_joined']?>
			</td>
			<td class="ellipsis" title="<?=$referrer['first_name']." ".$referrer['last_name']?>" style="max-width:30px;min-width:30px;">
				<?=$referrer['first_name']." ".$referrer['last_name']?>
			</td>
			<td class="ellipsis" style="max-width:20px;min-width:20px;">
				<?php if($user['is_active']=="true"): ?>
					<div class="non_editable_<?=$user['id']?>">Active</div>
					<div class="editable_<?=$user['id']?>" style="display:none;">
						<?=form_dropdown('status', $status_options,$user['is_active']),$extra_options; ?>
					</div>
				<?php elseif($user['is_active']=="false"): ?>
					<div class="non_editable_<?=$user['id']?>">Inactive</div>
					<div class="editable_<?=$user['id']?>" style="display:none;">
						<?=form_dropdown('status', $status_options,$user['is_active'],$extra_options); ?>
					</div>
				<?php endif ?>
			</td>
			<td style="max-width:20px;min-width:20px;">
				<span id="edit_info_<?=$user['id']?>" onClick="edit_user(<?=$user['id']?>)" style="color:#0079C1;cursor:pointer;margin-left:15px;">
					<img id="edit_icon" style="height:20px;" src="<?=base_url('images/edit.png')?>"/>
				</span>
				<span id="save_edit_<?=$user['id']?>" onClick="save_user(<?=$user['id']?>)" style="display:none;color:#0079C1;cursor:pointer;margin-left:15px;">
					<img id="save_icon" style="height:20px;" src="<?=base_url('images/save_icon_360.png')?>"/>
				</span>
				<span id="loading_icon_<?=$user['id']?>" style="color:#0079C1;display:none;margin-left:15px;">
					<img id="loading_icon" style="height:20px;" src="<?=base_url('images/loading.gif')?>"/>
				</span>
			</td>
		</tr>
	</table>
</form>