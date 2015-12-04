<?php
	$row = 0;
?>
<script>
	$(".post_row:even").css("background-color","#eee");
	$("#referral_container").height($(window).height() - 256);
</script>
<?php if(!empty($referred_users)): ?>
	<?php foreach($referred_users as $referred_user): ?>
		<?php
			$row++;
		?>
		<div id="tr_<?=$row?>" name="tr_<?=$row?>" class="post_row">
			<?php include("referrals_row.php")?>
		</div>
	<?php endforeach ?>
<?php else: ?>
	<div style="margin-left:300px;">User has no referrals.</div>
<?php endif ?>