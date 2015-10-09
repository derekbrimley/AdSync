<?php if(!empty($related_markets)): ?>
	<?php foreach($related_markets as $related_market): ?>
		<div><?= $related_market ?></div>
	<?php endforeach ?>
<?php else: ?>
	<div>No Related Markets Added</div>
<?php endif ?>