<?php
	$row = 0
?>
<script>
	$(".post_row:even").css("background-color","#eee");
	$("#money_container").height($(window).height() - 256);
</script>
Transactions
<span>
	<img id="loading_icon" style="display:none;float:right;height:20px;" src="<?=base_url('images/loading.gif')?>"/>
</span>
<span>
	<img id="refresh_icon" onClick="load_money_report()" style="float:right;height:20px;cursor:pointer" src="<?=base_url('images/refresh_icon_grey_360.png')?>"/>
</span>
<span style="float:right;margin-left:20px;margin-right:55px;">
	<?= $balance ?>
</span>
<br>
<hr>
<?php if(!empty($account_entrys)): ?>
	<div id="post_board_header">
		<table>
			<tr style="font-weight:bold;color:#0079C1">
				<td style="max-width:12px;min-width:12px;">Date</td>
				<td style="max-width:80px;min-width:80px;">Description</td>
				<td style="max-width:10px;min-width:10px;">Amount</td>
			</tr>
		</table>
	</div>
	<div id="money_container" class="scrollable_div">
		<?php foreach($account_entrys as $account_entry): ?>
			<?php
				$row++;
			?>
			<div id="tr_<?=$row?>" name="tr_<?=$row?>" class="post_row">
				<?php include("money_report_row.php")?>
			</div>
		<?php endforeach ?>
	</div>
<?php else: ?>
	You don't have any transactions yet.
<?php endif ?>