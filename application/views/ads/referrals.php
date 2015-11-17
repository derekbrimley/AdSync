<?php
	$row = 0;
	
	$where = null;
	$where['id'] = $this->session->userdata('user_id');
	$this_user = db_select_user($where);
	
	$role = $this->session->userdata('role');
?>
<script>
	$(".post_row:even").css("background-color","#eee");
</script>
Referrals
<span>
	<img id="loading_icon" style="display:none;margin-right:20px;float:right;height:20px;" src="<?=base_url('images/loading.gif')?>"/>
</span>
<span>
	<img id="refresh_icon" onClick="load_referrals()" style="float:right;height:20px;cursor:pointer" src="<?=base_url('images/refresh_icon_grey_360.png')?>"/>
</span>
<span style="float:right;margin-right:20px;">
	<?= $count ?>
</span>
<br>
<hr>
<?php if(!empty($users)): ?>
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
	<?php foreach($users as $user): ?>
		<?php
			$row++;
		?>
		<div id="tr_<?=$row?>" name="tr_<?=$row?>" class="post_row">
			<?php include("referrals_row.php")?>
		</div>
	<?php endforeach ?>
<?php else: ?>
	You haven't referred anyone yet.
<?php endif ?>