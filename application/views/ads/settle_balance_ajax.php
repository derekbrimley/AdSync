<div>
	Settle Balance Form
	<hr>
	<table style="width:300px;">
		<tr>
			<td style="max-width:172px;min-width:172px;">User</td>
			<td><?=$user['first_name']." ".$user['last_name']?></td>
		</tr>
		<tr>
			<td style="max-width:172px;min-width:172px;"S>Current Balance</td>
			<td>$<?=$balance?></td>
		</tr>
	</table>
	<form id="settle_balance_form" style="width:300px;">
		<input id="user_id" name="user_id" type="hidden" value="<?=$user['id']?>" />
		<table>
			<tr>
				<td style="max-width:172px;min-width:172px;">Amount Paid</td>
				<td>$<input id="amount_paid" name="amount_paid" /></td>
			</tr>
			<tr>
				<td style="max-width:172px;min-width:172px;">Screenshot</td>
				<td>
					<input type="file" id="payment_screenshot" name="payment_screenshot" />
				</td>
			</tr>
		</table>
	</form>
</div>