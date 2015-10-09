<script>
	$("#client_id").focus();
</script>
New Ad Request Form<hr><br><br>
<form id="create_ad_request_form" name="create_ad_request_form" style="width:500px;">
	<table>
		<tr>
			<td>Client</td>
			<td><?php echo form_dropdown('client_id',$client_options,'Select',' id="client_id" class="request_form_input" style="width:280px"')?></td>
		</tr>
		<tr>
			<td>Market</td>
			<td><?php echo form_dropdown('market_id',$market_options,'Select',' id="market_id" class="request_form_input" style="width:280px"')?></td>
		</tr>
		<tr>
			<td>Category</td>
			<td><?php echo form_dropdown('category_name',$category_options,'Select',' id="category_name" class="request_form_input" style="width:280px"')?></td>
		</tr>
		<tr>
			<td>Sub-Category</td>
			<td><input id="sub_category" name="sub_category" class="request_form_input" type="text"/></td>
		</tr>
		<tr>
			<td>Content Description</td>
			<td><textarea id="content_description" name="content_description" style="height:100px;" class="request_form_input" type="text"/></textarea>
		</tr>
		<tr>
			<td>Price</td>
			<td><input id="price" name="price" class="request_form_input" type="text"/></td>
		</tr>
		<tr>
			<td>Minimum Live Ads</td>
			<td><input id="minimum_live_ads" name="minimum_live_ads" class="request_form_input" type="text"/></td>
		</tr>
		<tr>
			<td></td>
			<td><button type="button" class="request_btn" value="Submit" onClick="submit_ad_request()">Submit</button>
		</tr>
	</table>
	
</form>