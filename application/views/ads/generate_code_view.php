Code Manager
<hr>
<div style="float:left;">
	<b>Code Generator</b>
	<hr align="left" style="width:300px;">
	<form id="generate_code_form" style="width:350px;">
		<table>
			<tr>
				<td>
					Referrer
				</td>
				<td>
					<?php echo form_dropdown('referral_id',$dropdown_users,'Select','id="referral_id" onChange="referrer_selected()"')?>
				</td>
			</tr>
			<tr>
				<td>
					<button style="display:none;position:fixed;top:200px;" type="button" onclick="generate_code()" class="request_btn" id="generate_code_btn">Generate Code</button>
					<div style="display:none;position:fixed;top:200px;font-size:25px;font-weight:bold;text-align:center;height:32px;width:277px;border:3px solid #0079C1" id="code_box">
					</div>
					<div>
						<button id="refresh_btn" onClick="load_generate_code_page()" type="button" class="request_btn" style="display:none;position:fixed;top:250px;">Refresh
						</button>
					</div>
				</td>
			</tr>
		</table>
	</form>
</div>
<div style="margin-left:350px;">
	<b>Code Requests</b>
	<hr align="left" style="width:400px;">
	<table style="width:400px;">
		<tr>
			<td style="min-width:150px;max-width:150px;font-weight:bold;">Email</td>
			<td style="min-width:50px;max-width:50px;font-weight:bold;">Send Code</td>
		</tr>
		<?php if(!empty($codes)):?>
			<?php foreach($codes as $code): ?>
				<tr>
					<td style="min-width:150px;max-width:150px;">
						<?=$code['email_requested']?>
					</td>
					<td onClick="send_code(<?=$code['id']?>)" style="cursor:pointer;text-align:center;min-width:50px;max-width:50px;">
						<img style="height:20px;" src="<?=base_url('images/email.png')?>"/>
					</td>
				<tr>
			<?php endforeach?>
		<?php endif?>
	</table>
</div>