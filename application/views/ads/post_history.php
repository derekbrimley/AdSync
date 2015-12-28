<?php
	$row = 0;
	$role = $this->session->userdata('role');
?>
<script>
	$(".post_row:even").css("background-color","#eee");
	$("#post_container").height($(window).height() - 241);
</script>
Post History
<span>
	<img id="loading_icon" style="display:none;float:right;height:20px;" src="<?=base_url('images/loading.gif')?>"/>
</span>
<span>
	<img id="refresh_icon" onClick="load_post_history()" style="float:right;height:20px;cursor:pointer" src="<?=base_url('images/refresh_icon_grey_360.png')?>"/>
</span>
<span style="float:right;margin-right:20px;">
	<?= $count ?>
</span>
<?php if($role=="admin"): ?>
	<span style="float:right;margin-right:20px;">
		<select id="selected_user" onChange="filter_user_post_history()">
			<option>All Users</option>
			<?php foreach($users as $user):?>
				<option value="<?=$user['id']?>"><?=$user['first_name']." ".$user['last_name']?></option>
			<?php endforeach ?>
		</select>
	</span>
<?php endif ?>
<br>
<hr>
<?php if(!empty($posts)): ?>
	<div id="post_board_header">
		<table>
			<tr style="font-weight:bold;color:#0079C1">
				<?php if($role == "admin"): ?>
					<td style="max-width:35px;min-width:35px;">User</td>
				<?php endif ?>
				<td style="max-width:37px;min-width:37px;">Date Posted</td>
				<td style="max-width:40px;min-width:40px;">Market</td>
				<td style="max-width:40px;min-width:40px;">Category</td>
				<td style="max-width:40px;min-width:40px;">Sub-Category</td>
				<td style="max-width:20px;min-width:20px;">Value</td>
				<td style="max-width:30px;min-width:30px;">Result</td>
				<td style="max-width:20px;min-width:20px;">Earned</td>
			</tr>
		</table>
	</div>
	<div id="post_container" class="scrollable_div" style="">
		<?php foreach($posts as $post): ?>
			<?php
				$row++;
			?>
			<div id="tr_<?=$row?>" name="tr_<?=$row?>" class="post_row">
				<?php include("post_history_row.php")?>
			</div>
		<?php endforeach ?>
	</div>
<?php else: ?>
	You have not posted yet. Click on "Post Board" to get started!
<?php endif ?>