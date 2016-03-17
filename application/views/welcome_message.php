<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Zonar Data</title>
  	<link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/zonar.css"); ?>"/>
	<link type="text/css" href="<?php echo base_url("css/jquery-ui.min.css"); ?>" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo base_url("js/jquery-1.11.3.min.js"); ?>" ></script>
	<script type="text/javascript" src="<?php echo base_url("js/jquery-ui.min.js"); ?>" ></script>
</head>
<body>
	<div id="header">
		<h1>Zonar Data</h1>
		<div id="nav_container">
			<button class="nav_btn" onClick="openMap()">
				<a style="text-decoration:none;color:#FFF;" href="<?=base_url('index.php/ads/load_asset_map')?>">Map</a>
			</button>
		</div>
	</div>
	<div id="container">
		<div id="asset_container">
			<?php foreach($assets as $asset):?>
				<?php if($asset['power']=="Off"): ?>
					<style>
						#asset_<?=$asset['id'] ?>{
							background:#FF5252;
						}
					</style>
				<?php endif ?>
				<div id="asset_<?=$asset['id'] ?>" class="asset" onClick="showMap(<?= $asset['lat'] ?>,<?= $asset['long'] ?>)">
						<div><strong>Truck Number:</strong> <?= $asset['truck_num'] ?></div>
						<div><strong>Last Update:</strong> <?= $asset['last_update'] ?></div>
						<div><strong>Latitude:</strong> <?= $asset['lat'] ?></div>
						<div><strong>Longitude:</strong> <?= $asset['long'] ?></div>
						<div><strong>Heading:</strong> <?= $asset['heading'] ?></div>
						<div><strong>Speed:</strong> <?= $asset['speed'] ?></div>
						<div><strong>Power:</strong> <?= $asset['power'] ?></div>
						<div><strong>Odometer:</strong> <?= $asset['odometer'] ?></div>
				</div>
			<?php endforeach ?>


		</div>
	</div>
	<div id="map_container" title="Location Map">    
		<div id="map"></div>
	</div>
	<script type="text/javascript" src="<?php echo base_url("js/zonar.js"); ?>" ></script>
	<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMJAxjDMr91aIbzuqhdeJ8tnmnx6MqTb4&callback=initMap">
	</script>
</body>
</html>