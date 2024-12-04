<?php
$error = array();
if (empty($_GET['latitude'])) {
	$error[] = 'ID tidak boleh kosong';
} else {
	$latitude = $_GET['latitude'];
}

if (empty($_GET['longitude'])) {
	$error[] = 'ID tidak boleh kosong';
} else {
	$longitude = $_GET['longitude'];
}

if (empty($_GET['latkantor'])) {
	$error[] = 'ID tidak boleh kosong';
} else {
	$latikantor = $_GET['latkantor'];
}

if (empty($_GET['longkantor'])) {
	$error[] = 'ID tidak boleh kosong';
} else {
	$longikantor = $_GET['longkantor'];
}


if (empty($error)) {
	echo '
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Map</title>
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
		 <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
	
	</head>
	<body>
		<div id="peta" style="height:500px; width: 100%"></div>'; ?>
	<script type="text/javascript">
		var mymap = L.map('peta').setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 19);

		L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYWRpZ3VuYXdhbnhkIiwiYSI6ImNrcWp2Yjg2cDA0ZjAydnJ1YjN0aDNnbm4ifQ.htvHCgSgN0UuV8hhZBfBfQ', {
			maxZoom: 20,
			attribution: '',
			id: 'mapbox/streets-v11',
			tileSize: 512,
			zoomOffset: -1,
			accessToken: 'pk.eyJ1IjoiYWRpZ3VuYXdhbnhkIiwiYSI6ImNrcWp2Yjg2cDA0ZjAydnJ1YjN0aDNnbm4ifQ.htvHCgSgN0UuV8hhZBfBfQ'
		}).addTo(mymap);
		L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>]).addTo(mymap);
		L.circle([<?php echo $latikantor; ?>, <?php echo $longikantor; ?>], 20, {
			color: 'red',
			fillColor: '#f03',
			fillOpacity: 0.5
		}).addTo(mymap);
		// bindPopup("<?php echo $name; ?>").openPopup();
		// var popup = L.popup();

		function onMapClick(e) {
			popup
				.setLatLng(e.latlng)
				.setContent("" + e.latlng.toString())
				.openOn(mymap);
		}
		mymap.on('click', onMapClick);
	</script>

	</body>

	</html>
<?PHP } else {
	echo 'Data tidak ditemukan';
} ?>