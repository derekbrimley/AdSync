<?php
	$row = 0
?>
<script>
	$(".post_row:even").css("background-color","#eee");
	$("#live_ads_container").height($(window).height() - 256);
</script>
Live Ads
<span>
	<img id="loading_icon" style="display:none;float:right;height:20px;" src="<?=base_url('images/loading.gif')?>"/>
</span>
<span>
	<img id="refresh_icon" onClick="load_live_ads()" style="float:right;height:20px;cursor:pointer" src="<?=base_url('images/refresh_icon_grey_360.png')?>"/>
</span>
<span style="float:right;margin-right:20px;">
	<?= $count ?>
</span>
<br>
<hr>
<?php if(!empty($posts)): ?>
	<div id="post_board_header">
		<table>
			<tr style="font-weight:bold;color:#0079C1">
				<td style="max-width:35px;min-width:35px;">Date Posted</td>
				<td style="max-width:40px;min-width:40px;">Market</td>
				<td style="max-width:40px;min-width:40px;">Category</td>
				<td style="max-width:50px;min-width:50px;">Sub-Category</td>
				<td style="max-width:30px;min-width:30px;">Value</td>
				<td style="max-width:40px;min-width:40px;">Result</td>
			</tr>
		</table>
	</div>
	<div id="live_ads_container" class="scrollable_div">
		<?php foreach($posts as $post): ?>
			<?php
				$row++;
			?>
			<div id="tr_<?=$row?>" name="tr_<?=$row?>" class="post_row">
				<?php include("live_ads_row.php")?>
			</div>
		<?php endforeach ?>
	</div>
<?php else: ?>
	You have not posted yet. Click on "Post Board" to get started!
<?php endif ?>