<?php
	$row = 0;
	
	$where = null;
	$where['id'] = $this->session->userdata('user_id');
	$this_user = db_select_user($where);
	
	$role = $this->session->userdata('role');
?>
<script>
	$(".post_row:even").css("background-color","#eee");
	$("#referral_container").height($(window).height() - 241);
</script>
Referrals
<span>
	<img id="loading_icon" style="display:none;float:right;height:20px;" src="<?=base_url('images/loading.gif')?>"/>
</span>
<span>
	<img id="refresh_icon" onClick="load_referrals()" style="float:right;height:20px;cursor:pointer" src="<?=base_url('images/refresh_icon_grey_360.png')?>"/>
</span>
<span id="count" style="float:right;margin-right:20px;">
	<?= $count ?>
</span>
<?php if($role=="admin"): ?>
	<span style="float:right;margin-right:20px;">
		<select id="selected_user" onChange="filter_user_referrals()">
			<option>All Users</option>
			<?php foreach($users as $user):?>
				<option value="<?=$user['id']?>"><?=$user['first_name']." ".$user['last_name']?></option>
			<?php endforeach ?>
		</select>
	</span>
<?php endif ?>
<br>
<hr>
<?php if(!empty($referred_users)): ?>
	<div id="post_board_header">
		<table>
			<tr style="font-weight:bold;color:#0079C1">
				<?php if($role == "admin"): ?>
					<td style="max-width:35px;min-width:35px;">User</td>
				<?php endif ?>
				<td style="max-width:35px;min-width:35px;">Referred User</td>
				<td style="max-width:40px;min-width:40px;">Date Joined</td>
				<td style="max-width:30px;min-width:30px;">Value</td>
			</tr>
		</table>
	</div>
	<div id="referral_container" name="referral_container" class="scrollable_div">
		<?php foreach($referred_users as $referred_user): ?>
			<?php
				$row++;
			?>
			<div id="tr_<?=$row?>" name="tr_<?=$row?>" class="post_row">
				<?php include("referrals_row.php")?>
			</div>
		<?php endforeach ?>
	</div>
<?php else: ?>
	You haven't referred anyone yet.
<?php endif ?>