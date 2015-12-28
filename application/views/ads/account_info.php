Account Information
<span>
	<img id="loading_icon" style="display:none;float:right;height:20px;margin-left:20px;" src="<?=base_url('images/loading.gif')?>"/>
	<img id="refresh_icon" onClick="load_account_info()" style="float:right;height:20px;cursor:pointer;margin-left:20px;" src="<?=base_url('images/refresh_icon_grey_360.png')?>"/>
	<img id="edit_information_btn" onClick="edit_user_information();" src=<?=base_url("images/edit.png")?> style="float:right;cursor:pointer;height:20px;"/>
	<img id="save_information_btn" onClick="save_user_information(<?=$user['id']?>)" src="<?=base_url('images/save_icon_360.png')?>" style="float:right;display:none;height:20px;cursor:pointer;"/>
</span>
<hr>
<div>
	<form id="account_info_form" name="">
		<table>
			<input type="hidden" id="user_id" name="user_id" value="<?=$user['id']?>"/>
			<tr>
				<td>First Name</td>
				<td class="info"><?=$user['first_name']?></td>
				<td class="input" style="display:none;"><input id="first_name" name="first_name" type="text" value="<?=$user['first_name']?>"></td>
			</tr>
			<tr>
				<td>Last Name</td>
				<td class="info"><?=$user['last_name']?></td>
				<td class="input" style="display:none;"><input id="last_name" name="last_name"type="text" value="<?=$user['last_name']?>"></td>
			</tr>
			<tr>
				<td>Username</td>
				<td><?=$user['username']?></td>
			</tr>
			<tr>
				<td>Home Market</td>
				<td><?=$market['name']?></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><?=$user['email']?></td>
			</tr>
			<tr>
				<td>Role</td>
				<td><?=$user['role']?></td>
			</tr>
			<tr>
				<td>Referred By</td>
				<td><?=$referred_by_user['first_name']." ".$referred_by_user['last_name']?></td>
			</tr>
			<tr>
				<td>Active</td>
				<td><?=$user['is_active']?></td>
			</tr>
		</table>
	</form>
</div>