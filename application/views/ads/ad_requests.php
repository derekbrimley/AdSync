<?php
	$row = 0
?>
<script>
	$(".post_row:even").css("background-color","#eee");
	$("#ad_container").height($(window).height() - 256);
</script>
Ad Requests
<span>
	<button id="new_ad_request_btn" name="new_ad_request_btn" onClick="open_ad_request_dialog();" type="button" style="position:relative;bottom:4px;left:330px;padding:8px;cursor:pointer;color:white;background-color:#0079C1;border:0px;font-size:16px;">New Ad Request</button>
	<button id="refresh_ads_btn" onClick="refresh_ad_spots()" type="button" style="position:relative;bottom:4px;left:340px;padding:8px;cursor:pointer;color:white;background-color:#0079C1;border:0px;font-size:16px;margin-right:20px;">Refresh Ads</button>
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
<?php if(!empty($ad_requests)): ?>
	<div id="post_board_header">
		<table>
			<tr style="font-weight:bold;color:#0079C1">
				<td style="max-width:70px;min-width:70px;">Market</td>
				<td style="max-width:40px;min-width:40px;">Category</td>
				<td style="max-width:75px;min-width:75px;">Sub-Category</td>
				<td style="max-width:30px;min-width:30px;">Price</td>
				<td style="max-width:30px;min-width:30spx;">Action</td>
			</tr>
		</table>
	</div>
	<div id="ad_container" class="scrollable_div">
		<?php foreach($ad_requests as $ad_request): ?>
			<?php
				$row++;
			?>
			<div id="tr_<?=$row?>" name="tr_<?=$row?>" class="post_row">
				<?php include("ad_request_row.php")?>
			</div>
		<?php endforeach ?>
	</div>
<?php else: ?>
	No available posts. Try again later.
<?php endif ?>