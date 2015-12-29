<?php
	$where = null;
	$where['id'] = $ad_request['market_id'];
	$market = db_select_market($where);
	
	$market_name = $market['name'];
	
	if($ad_request['status'] == 'inactive'){
		$text_color = 'red';
	}else{
		$text_color = 'black';
	}
	
?>
<form id="ad_request_form_<?=$ad_request['id']?>">
	<input id="id" name="id" type="hidden" value="<?=$ad_request['id']?>" />
	<table style="color:<?=$text_color?>">
		<tr>
			<td style="max-width:70px;min-width:70px;">
				<div class="non_editable_<?=$ad_request['id']?>" id="name_info_<?=$ad_request['id']?>"><?=$market_name?></div>
			</td>
			<td style="max-width:40px;min-width:40px;">
				<div class="non_editable_<?=$ad_request['id']?>" id="category_info_<?=$ad_request['id']?>"><?=$ad_request['category']?></div>
			</td>
			<td style="max-width:75px;min-width:75px;">
				<div class="non_editable_<?=$ad_request['id']?>" id="sub_info_<?=$ad_request['id']?>"><?=$ad_request['sub_category']?></div>
			</td>
			<td style="max-width:30px;min-width:30px;">
				<div class="non_editable_<?=$ad_request['id']?>" id="price_info_<?=$ad_request['id']?>">$<?=number_format($ad_request['price'],2)?></div>
			</td>
			<td style="max-width:30px;min-width:30px;">
				<?php if($ad_request['status']=='active'): ?>
					<span id="edit_info_<?=$ad_request['id']?>" onClick="edit_request(<?=$ad_request['id']?>)" style="color:#0079C1;cursor:pointer;">
						<img id="edit_icon" style="height:20px;" src="<?=base_url('images/edit.png')?>"/>
					</span>
					<span id="loading_icon_<?=$ad_request['id']?>" style="color:#0079C1;display:none;">
						<img id="loading_icon" style="height:20px;" src="<?=base_url('images/loading.gif')?>"/>
					</span>
					<span onClick="delete_request(<?=$ad_request['id']?>)" style="color:#0079C1;cursor:pointer;">
						<img id="trash_icon" style="height:20px;" src="<?=base_url('images/trash.png')?>"/>
					</span>
				<?php endif ?>
			</td>
		</tr>
	</table>
</form>
