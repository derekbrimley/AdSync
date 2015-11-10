<?php
	$row = 0
?>
<script>
	$(".post_row:even").css("background-color","#eee");
	$("#ad_container").height($(window).height() - 241);
</script>
Post Board
<span>
	<img id="loading_icon" style="display:none;float:right;height:20px;" src="<?=base_url('images/loading.gif')?>"/>
</span>
<span>
	<img id="refresh_icon" onClick="load_post_board()" style="float:right;height:20px;cursor:pointer" src="<?=base_url('images/refresh_icon_grey_360.png')?>"/>
</span>
<span style="float:right;margin-right:20px;">
	<?= $count ?>
</span>
<br>
<hr>
<?php if(!empty($ad_spots)): ?>
	<div id="post_board_header">
		<table>
			<tr style="font-weight:bold;color:#0079C1">
				<td style="max-width:70px;min-width:70px;">Market</td>
				<td style="max-width:40px;min-width:40px;">Category</td>
				<td style="max-width:75px;min-width:75px;">Sub-Category</td>
				<td style="max-width:30px;min-width:30px;">Value</td>
				<td style="max-width:20px;min-width:320px;">Reserve</td>
			</tr>
		</table>
	</div>
	<div id="ad_container" class="scrollable_div">
		<?php foreach($ad_spots as $ad_spot): ?>
			<?php
				$row++;
			?>
			<div id="tr_<?=$row?>" name="tr_<?=$row?>" class="post_row">
				<?php include("ad_row.php")?>
			</div>
		<?php endforeach ?>
	</div>
<?php else: ?>
	No available posts. Try again later.
<?php endif ?>