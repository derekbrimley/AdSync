<?php
	$row = 0;
?>
<script>
	$(".post_row:even").css("background-color","#eee");
	$("#live_ads_container").height($(window).height() - 256);
</script>
<?php if(!empty($posts)): ?>
	<?php foreach($posts as $post): ?>
		<?php
			$row++;
		?>
		<div id="tr_<?=$row?>" name="tr_<?=$row?>" class="post_row">
			<?php include("live_ads_row.php")?>
		</div>
	<?php endforeach ?>
<?php else: ?>
	<div style="margin-left:300px;">User has no live ads.</div>
<?php endif ?>