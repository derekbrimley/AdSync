<?php

	date_default_timezone_set('America/Denver');
	$current_datetime = date("Y-m-d H:i:s");

	$where = null;
	$where['id'] = $post['ad_request_id'];
	$ad_request = db_select_ad_request($where);

	$where = null;
	$where['ad_request_id'] = $ad_request['id'];
	$ad_spot = db_select_ad_spot($where);
	
	$where = null;
	$where['id'] = $ad_request['market_id'];
	$market = db_select_market($where);
	
	$where = null;
	$where['id'] = $post['poster_id'];
	$this_user = db_select_user($where);
	
	$next_renewal = date("m/d/y H:i:s",strtotime($post['next_renewal_datetime']));
	// echo strtotime($next_renewal);
	if($current_datetime>=date("Y-m-d H:i:s",strtotime($next_renewal)) && $post['result'] != "Needs verification")
	{
		$color = "color:green;";
	}
	else if($current_datetime>=strtotime($next_renewal.' + 1 days') && $post['result'] != "Needs verification")
	{
		$color = "color:yellow";
	}
	else
	{
		$color = "color:red";
	}
	//echo $current_datetime." ".$next_renewal;
?>
<table>
	<tr style="<?=$color?>">
		<?php if($role == "admin"): ?>
			<td class="ellipsis" title="<?=$this_user['username']?>"style="max-width:35px;min-width:35px;">
				<?=$this_user['username']?>
			</td>
		<?php endif ?>
		<td class="ellipsis" style="max-width:40px;min-width:40px;">
			<?=date("m/d/Y",strtotime($post['post_datetime']))?>
		</td>
		<td class="ellipsis" title="<?=$market['name']?>" style="max-width:35px;min-width:35px;">
			<?=$market['name']?>
		</td>
		<td class="ellipsis" title="<?=$ad_request['category']?>" style="max-width:40px;min-width:40px;">
			<?=$ad_request['category']?>
		</td>
		<td class="ellipsis" title="<?=$ad_request['sub_category']?>" style="max-width:50px;min-width:50px;">
			<?=$ad_request['sub_category']?>
		</td>
		<td class="ellipsis" title="$<?=number_format($ad_spot['value'],2)?>" style="max-width:25px;min-width:25px;">
			$<?=number_format($ad_spot['value'],2)?>
		</td>
		<td class="ellipsis" title="<?= date("m/d/Y",strtotime($next_renewal)) ?>" style="max-width:45px;min-width:45px;">
			<?= date("m/d/Y",strtotime($next_renewal)) ?>
		</td>
		<td class="ellipsis" title="<?= $post['result'] ?>" style="max-width:35px;min-width:35px;">
			<?= $post['result'] ?>
		</td>
		<?php if($role == "affiliate"): ?>
			<td class="ellipsis" style="max-width:20px;min-width:20px;">
				<?php if($current_datetime>=$next_renewal && $post['result']!="Needs verification"): ?>
					<img title="Click to verify renewal" src="<?= base_url("images/renewals_icon.png") ?>" style="margin-left:15px;width:20px;cursor:pointer;" onClick="renew_post(<?=$post['id']?>)"/>
				<?php endif ?>
			</td>
		<?php endif ?>
	</tr>
</table>