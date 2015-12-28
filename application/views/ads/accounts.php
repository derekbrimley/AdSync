<?php
	$row = 0;
	$role = $this->session->userdata('role');
?>
<script>
	$(".post_row:even").css("background-color","#eee");
	$("#accounts_container").height($(window).height() - 241);
</script>
Post History
<span>
	<img id="loading_icon" style="display:none;float:right;height:20px;" src="<?=base_url('images/loading.gif')?>"/>
</span>
<span>
	<img id="refresh_icon" onClick="load_account_page()" style="float:right;height:20px;cursor:pointer" src="<?=base_url('images/refresh_icon_grey_360.png')?>"/>
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
				<td style="max-width:35px;min-width:35px;">Username</td>
				<td style="max-width:30px;min-width:30px;">Full Name</td>
				<td style="max-width:40px;min-width:40px;">Email</td>
				<td style="max-width:20px;min-width:20px;">Role</td>
				<td style="max-width:30px;min-width:30px;">Date Joined</td>
				<td style="max-width:30px;min-width:30px;">Referred By</td>
				<td style="max-width:20px;min-width:20px;">Status</td>
				<td style="max-width:20px;min-width:20px;">Edit</td>
			</tr>
		</table>
	</div>
	<div id="accounts_container" class="scrollable_div" style="">
		<?php foreach($users as $user): ?>
			<?php
				$row++;
			?>
			<div id="tr_<?=$row?>" name="tr_<?=$row?>" class="post_row">
				<?php include("accounts_row.php")?>
			</div>
		<?php endforeach ?>
	</div>
<?php else: ?>
	No users.
<?php endif ?>