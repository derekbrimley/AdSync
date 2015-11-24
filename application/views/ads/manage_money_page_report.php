<?php
	$row = 0;
?>
<script>
	$(".post_row:even").css("background-color","#eee");
	$("#money_page_container").height($(window).height() - 256);
</script>
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
		<div id="money_page_container" class="scrollable_div">
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