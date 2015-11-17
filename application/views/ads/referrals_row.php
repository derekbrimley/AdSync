<table>
	<tr>
		<?php if($role == "admin"): ?>
			<td style="max-width:35px;min-width:35px;">
				<?=$this_user['username'];?>
			</td>
		<?php endif ?>
		<td style="max-width:35px;min-width:35px;">
			<?=$user['first_name']." ".$user['last_name']?>
		</td>
		<td style="max-width:40px;min-width:40px;">
			<?= date("m/d/Y",strtotime($user['date_joined'])) ?>
		</td>
		<td style="max-width:30px;min-width:30px;">
			$10
		</td>
	</tr>
</table>