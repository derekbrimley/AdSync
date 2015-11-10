<?php
	$where = null;
	$where['id'] = $ad_request['market_id'];
	$market = db_select_market($where);
	
	$market_name = $market['name'];
?>
<form id="ad_request_form_<?=$ad_request['id']?>">
	<input id="id" name="id" type="hidden" value="<?=$ad_request['id']?>" />
	<table>
		<tr>
			<td style="max-width:70px;min-width:70px;">
				<div id="name_info_<?=$ad_request['id']?>"><?=$market_name?></div>
				<div id="name_edit_<?=$ad_request['id']?>" style="display:none">
					<?php echo form_dropdown('market_id', $market_options,$market['id'],"id='market_id' style='width:100%'"); ?>
				</div>
			</td>
			<td style="max-width:40px;min-width:40px;">
				<div id="category_info_<?=$ad_request['id']?>"><?=$ad_request['category']?></div>
				<div id="category_edit_<?=$ad_request['id']?>" style="display:none">
					<?php echo form_dropdown('category', $category_options,$ad_request['category'],"id='category' style='width:100%'"); ?>
				</div>
			</td>
			<td style="max-width:75px;min-width:75px;">
				<div id="sub_info_<?=$ad_request['id']?>"><?=$ad_request['sub_category']?></div>
				<div id="sub_edit_<?=$ad_request['id']?>" style="display:none">
					<input name="sub_category" id="sub_category" style="width:100%" type="text" value="<?=$ad_request['sub_category']?>"/>
				</div>
			</td>
			<td style="max-width:30px;min-width:30px;">
				<div id="price_info_<?=$ad_request['id']?>">$<?=number_format($ad_request['price'],2)?></div>
				<div id="price_edit_<?=$ad_request['id']?>" style="display:none">
					<input name="price" id="price" style="width:100%" type="text" value="<?=$ad_request['price']?>"/>
				</div>
			</td>
			<td style="max-width:30px;min-width:30px;">
				<span id="edit_info_<?=$ad_request['id']?>" onClick="edit_request(<?=$ad_request['id']?>)" style="color:#0079C1;cursor:pointer;">
					<img id="edit_icon" style="height:20px;" src="<?=base_url('images/edit.png')?>"/>
				</span>
				<span id="save_edit_<?=$ad_request['id']?>" onClick="save_request(<?=$ad_request['id']?>)" style="display:none;color:#0079C1;cursor:pointer;">
					<img id="save_icon" style="height:20px;" src="<?=base_url('images/save_icon_360.png')?>"/>
				</span>
				<span id="loading_icon_<?=$ad_request['id']?>" style="color:#0079C1;display:none;">
					<img id="loading_icon" style="height:20px;" src="<?=base_url('images/loading.gif')?>"/>
				</span>
				<span onClick="delete_request(<?=$ad_request['id']?>)" style="color:#0079C1;cursor:pointer;">
					<img id="trash_icon" style="height:20px;" src="<?=base_url('images/trash.png')?>"/>
				</span>
			</td>
		</tr>
	</table>
</form>