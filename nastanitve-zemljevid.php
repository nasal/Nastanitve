<?php
/*
if (isset($_GET["radius"])) { $radius = $_GET['radius']; } else { $radius = '20'; }
if ($_GET['iskanje'] == 'kraj') {
    $key = "ABQIAAAATJEQGqAEw2umbGiHtsXxEBTo3Edy3m2gscf0wcqYPrU4J3rAURSKP6lAyMnbQbY6_pgdWkBByu-TjA";
    $address = "http://maps.googleapis.com/maps/api/geocode/xml?address=" . urlencode($_GET['naslov']) . ",+slovenia&sensor=false";
    $page = file_get_contents($address);
    $xml = new SimpleXMLElement($page);
    
    if ($xml->status == "OK") {
      $latitude = $xml->result->geometry->location->lat;
      $longitude = $xml->result->geometry->location->lng;
    } else {
      $latitude = '45.50';
      $longitude = '13.40';
    }
    $query = "SELECT id, naslov, ime, lat, lng, kontakt, tip, ( 3959 * acos( cos( radians($latitude) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( lat ) ) ) ) AS distance FROM kafici where tip not in ('h', 'b', 'be', 'dkk', 'kl', 'l', 'm', 'po', 'z', 'zd') group by ime HAVING distance < $radius ORDER BY distance limit 0, 30";
  } else {
    // Get parameters from URL
    $latitude = $_GET["lat"];
    $longitude = $_GET["lng"];
    $query = sprintf("SELECT id, naslov, ime, lat, lng, tip, kontakt, ( 3959 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM kafici group by ime HAVING distance < $radius ORDER BY distance LIMIT 0, 30",
    mysql_real_escape_string($latitude),
    mysql_real_escape_string($longitude),
    mysql_real_escape_string($latitude),
    mysql_real_escape_string($radius));
  }
$result = mysql_query($query);
*/
$latitude = '46.246891';
$longitude = '14.892925';
$query = pg_query("select * from projekt.nastanitev where lat is not null and lon is not null");
?>
<style>
	#map { position:absolute; top:0; bottom:0; width:100%; height: 500px;}
	div.marker-title { font: bold 12px arial; }
	div.marker-description { font: normal 12px arial; }
</style>
<script src='http://api.tiles.mapbox.com/mapbox.js/v1.0.2/mapbox.js'></script>
<link href='http://api.tiles.mapbox.com/mapbox.js/v1.0.2/mapbox.css' rel='stylesheet' />
<header>
	<div class="row">
        <div class="small-12 large-12 columns">
            <h3>Zemljevid</h3>
        </div>
	</div>
</header>
<div class="row">
	<div class="small-12 large-12 columns">
		<div id="map"></div>
		<script>
		var geoJson = {
		    type: 'FeatureCollection',
		    features: [
		    <?php
		    $i = 0;
		    while ($row = @pg_fetch_assoc($query)) {
		      echo 
		      ($i >= 1 ? ',' : '') .
		      '{
		      	type: \'Feature\',
		        geometry: { 
		        	type: \'Point\',
		          	coordinates: [' . $row['lon'] . ', ' . $row['lat'] . ']
		        },
		        properties: { 
		          \'marker-color\': \'#c2000d\',
		          \'marker-symbol\': \'lodging\',
		          title: \'' . addslashes(ucwords(strtolower($row['naslov'] . ', ' . $row['mesto']))) . '\',
		          description: \'' . $row['velikost'] . 'm<sup>2</sup>' . ($row['cena'] != '' ? ' / ' . $row['cena'] . '&euro;' : '') . '<br>' . strftime('%e. %B %Y', strtotime($row['datum_od'])) . ' - ' . strftime('%e. %B %Y', strtotime($row['datum_do'])) . '\'
		        }
		      }';
		      $i++;
		    }
		    ?>
		    ]
		};

		var map = L.mapbox.map('map', 'examples.map-vyofok3q').setView([<?= $latitude; ?>,<?= $longitude; ?>], 8);
		map.markerLayer.setGeoJSON(geoJson);
		map.addControl(L.mapbox.geocoderControl('examples.map-vyofok3q'));
		/*map.markerLayer.on('click', function(e) {
		    e.layer.unbindPopup();
		    window.open(e.layer.feature.properties.url);
		});*/
		</script>
	</div>
</div>