$(function(){
	
	
	
	$( "#map_container" ).dialog({
		autoOpen:false,
		width: 900,
		height: 550,
		resizeStop: function(event, ui) {google.maps.event.trigger(map, 'resize')  },
		open: function(event, ui) {google.maps.event.trigger(map, 'resize'); }      
	});
	
});

function showMap(lat, long){
	var myLatLng = {lat: lat, lng: long};
	
	$("#map_container").dialog("open");
	var map = new google.maps.Map(document.getElementById('map'), {
	  center: {lat: lat, lng: long},
	  zoom: 6
	});
	
	var marker = new google.maps.Marker({
		position: myLatLng,
		map: map,
		title: 'Driver'
	});
	marker.setMap(map);
	
	
}

function openMap(){
	
}