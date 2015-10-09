<!-- http://www.avenueh.com/ -->
<!DOCTYPE html>
<head>
	<link type="text/css" href="<?php echo base_url("css/nextgen.css")?>" rel="stylesheet" />
	<link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="<?php echo base_url("js/jquery-1.11.3.min.js"); ?>" ></script>
</head>
<script>
	$(function(){
		$('#primary_market_name').focus();
	});
	function primary_market_selected()
	{
		var id = $("#primary_market_name").val();
		console.log("ID: "+id);
		
		
		$.ajax({
			url: "<?= base_url("index.php/leads/get_cl_link") ?>",
			type: "POST",
			data:{id: id},
			cache: false,
			statusCode: {
				200: function(response){
					$("#link_div").html(response);
				},
				404: function(){
					alert('Page not found');
				},
				500: function(){
					alert("500 error! "+response);
				},
			}
		})//ajax
		
		$.ajax({
			url: "<?= base_url("index.php/leads/get_related_markets") ?>",
			type: "POST",
			data:{id: id},
			cache: false,
			statusCode: {
				200: function(response){
					$("#related_markets").html(response);
				},
				404: function(){
					alert('Page not found');
				},
				500: function(){
					alert("500 error! "+response);
				},
			}
		})//ajax
	}
	function related_market_selected()
	{
		var id = $("#related_market_name").val();
		console.log("ID: "+id);
		
		
		$.ajax({
			url: "<?= base_url("index.php/leads/get_cl_link") ?>",
			type: "POST",
			data:{id: id},
			cache: false,
			statusCode: {
				200: function(response){
					$("#related_link_div").html(response);
				},
				404: function(){
					alert('Page not found');
				},
				500: function(){
					alert("500 error! "+response);
				},
			}
		})//ajax
	}
</script>
<html lang="en">
	<div style="margin:200px 500px;">
		<a style="float:left;margin-right:50px;" href="http://www.craigslist.org/about/sites" target="_blank">Craigslist</a>
		<span style="float:left">
			<?php $attributes = array('name'=>'market_relation_form','id'=>'market_relation_form','style'=>'margin-bottom:50px;' )?>
			<?=form_open_multipart(base_url('index.php/leads/market_relation_form/'),$attributes);?>
				Primary Market: <?php echo form_dropdown('primary_market_name',$market_options,'Select',' id="primary_market_name" onChange="primary_market_selected();"')?><br><br>
				Related Market: <?php echo form_dropdown('related_market_name',$market_options,'Select',' id="related_market_name" onChange="related_market_selected();"')?><br><br>
				<input type="submit" />
			</form>
		</span>
		<span id="related_markets" style="float:right">
			
		</span>
		<br><br>
		<div style="clear:both;"></div>
		Primary:
		<div id="link_div">
		</div>
		Related:
		<div id="related_link_div">
		</div>
	</div>
</html>