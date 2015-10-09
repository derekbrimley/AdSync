Generate Code
<hr>
<div>
	<form id="generate_code_form" style="width:350px;">
		<table>
			<tr>
				<td>
					Referrer
				</td>
				<td>
					<?php echo form_dropdown('referral_id',$dropdown_users,'Select','id="referral_id"')?>
				</td>
			</tr>
			<tr>
				<td>
					<button style="position:fixed;" type="button" onclick="generate_code()" class="request_btn" id="generate_code_btn">Generate Code</button>
					<div style="display:none;position:fixed;font-size:25px;font-weight:bold;text-align:center;height:32px;width:277px;border:3px solid #0079C1" id="code_box">
					</div>
				</td>
			
			</tr>
		</table>
	</form>
</div>