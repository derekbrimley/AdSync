<?php
	$row = 0
?>
<script>
	$(".post_row:even").css("background-color","#eee");
	$("#manage_money_container").height($(window).height() - 256);
</script>
Transactions
<span>
	<img id="loading_icon" style="display:none;float:right;height:20px;" src="<?=base_url('images/loading.gif')?>"/>
</span>
<span>
	<img id="refresh_icon" onClick="load_user_transactions()" style="float:right;height:20px;cursor:pointer" src="<?=base_url('images/refresh_icon_grey_360.png')?>"/>
</span>
<span id="balance" name="balance" style="float:right;margin-left:20px;margin-right:55px;">
	<?= $balance ?>
</span>
<span style="float:right;">
	<form id="user_form" name="user_form">
		<input type="hidden" name="balance_input" id="balance_input" value=""/>
		<select id="user_id" name="user_id" onChange="load_user_transactions()">
			<option>All Users</option>
			<?php foreach($dropdown_users as $dropdown_user): ?>
				<option value="<?= $dropdown_user['id'] ?>">
					<?= $dropdown_user['first_name']." ".$dropdown_user['last_name'] ?>
				</option>
			<?php endforeach ?>
		</select>
	</form>
</span>
<span id="settle_btn" style="display:none;float:right;margin-right:20px;position:relative;bottom:6px;">
	<button onClick="settle_balance()" style="border:0px;background-color:#0079C1;color:white;cursor:pointer;width:100px;height:27px;">Settle</button>
</span>
<br>
<hr>
<div id="transactions_container">
	<?php if(!empty($account_entrys)): ?>
			<div id="post_board_header">
				<table>
					<tr style="font-weight:bold;color:#0079C1">
						<td style="max-width:20px;min-width:20px;">User</td>
						<td style="max-width:14px;min-width:14px;">Date</td>
						<td style="max-width:75px;min-width:75px;">Description</td>
						<td style="max-width:10px;min-width:10px;">Amount</td>
					</tr>
				</table>
			</div>
			<div id="manage_money_container" class="scrollable_div">
				<?php foreach($account_entrys as $account_entry): ?>
					<?php
						$row++;
					?>
					<div id="tr_<?=$row?>" name="tr_<?=$row?>" class="post_row">
						<?php include("manage_money_page_row.php")?>
					</div>
				<?php endforeach ?>
			</div>
	<?php else: ?>
		You don't have any transactions yet.
	<?php endif ?>
</div>