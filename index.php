<?php

$error = 0;

setlocale(LC_ALL, 'sl_SI.utf8');

$dbconn = pg_connect("host=localhost dbname=npb user=postgres password=p4ssw0rd")
    or die('Could not connect: ' . pg_last_error());

if (isset($_POST['registracija_uporabnika'])) {
	if (!pg_num_rows(pg_query("select null from projekt.uporabnik where up_ime = '" . $_POST['up_ime'] . "'"))) {
		if (pg_query("insert into projekt.uporabnik (ime, priimek, email, telefonska, up_ime, geslo) values ('" . $_POST['ime'] . "', '" . $_POST['priimek'] . "', '" . $_POST['email'] . "', '" . $_POST['telefonska'] . "', '" . $_POST['up_ime'] . "', '" . md5($_POST['geslo']) . "')")) {
			header('location: ./?uporabnik=prijava');
		} else {
			header('location: ./?uporabnik=registracija');
		}
	}
}

if (isset($_POST['registracija_najemodajalca'])) {
	if (!pg_num_rows(pg_query("select null from projekt.najemodajalec where up_ime = '" . $_POST['up_ime_n'] . "'"))) {
		if (pg_query("insert into projekt.najemodajalec (ime, priimek, naslov, mesto, telefonska, trr, email, up_ime, geslo) values ('" . $_POST['ime_n'] . "', '" . $_POST['priimek_n'] . "', '" . $_POST['naslov_n'] . "', '" . $_POST['mesto_n'] . "', '" . $_POST['telefonska_n'] . "', '" . $_POST['trr_n'] . "', '" . $_POST['email_n'] . "', '" . $_POST['up_ime_n'] . "', '" . md5($_POST['geslo_n']) . "')")) {
			header('location: ./?najemodajalec=prijava');
		} else {
			header('location: ./?najemodajalec=registracija');
		}
	}
}

if (isset($_POST['dodaj_nastanitev'])) {
	
	if ($_POST['naslov'] != '') {
        $key = "ABQIAAAATJEQGqAEw2umbGiHtsXxEBTo3Edy3m2gscf0wcqYPrU4J3rAURSKP6lAyMnbQbY6_pgdWkBByu-TjA";
        $address = "http://maps.google.com/maps/geo?q=" . urlencode($_POST['naslov']) . ",+" . urlencode($_POST['mesto']) . ",+slovenia&output=xml&key=$key";
        $page = file_get_contents($address);
        $xml = new SimpleXMLElement($page);
        list($lon, $lat, $alt) = explode(",", $xml->Response->Placemark->Point->coordinates);
    }

    pg_query("insert into projekt.nastanitev (n_id, opis, naslov, mesto, cena, tip, velikost, datum_od, datum_do, lat, lon) values ('" . $_POST['n_id'] . "', '" . $_POST['opis'] . "', '" . $_POST['naslov'] . "', '" . $_POST['mesto'] . "', '" . $_POST['cena'] . "', '" . $_POST['tip'] . "', '" . $_POST['velikost'] . "', '" . date('Y-m-d', strtotime($_POST['leto-od'] . '-' . $_POST['mesec-od'] . '-' . $_POST['dan-od'])) . "', '" . date('Y-m-d', strtotime($_POST['leto-do'] . '-' . $_POST['mesec-do'] . '-' . $_POST['dan-do'])) . "', '" . $lat . "', '" . $lon . "')");

    header('location: ./');

}

function get_najemodajalec_name($id) {
	$q = pg_fetch_assoc(pg_query('select ime, priimek from projekt.najemodajalec where n_id = \'' . $id . '\' limit 1'));
	return $q['ime'] . ' ' . $q['priimek'];
}

?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <title>Nastanitve</title>
		<link rel="stylesheet" href="css/normalize.css" />
		<link rel="stylesheet" href="css/foundation.css" />
		<link rel="stylesheet" href="css/presentation.css" />
		<script src="js/vendor/custom.modernizr.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<!--[if lt IE 8]>
    		<link rel="stylesheet" href="css/general_enclosed_foundicons_ie7.css">
  		<![endif]-->
  		<style>
  		.row { max-width: 700px; }
  		.contain-to-grid .top-bar { max-width: 700px; }
  		.top-bar { margin-bottom: 0; }
  		</style>
	</head>
	<body>
		<div class="contain-to-grid sticky">
			<nav class="top-bar">
				<ul class="title-area">
					<li class="name"><h1><a href="./">Nastanitve</a></h1></li>
					<li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
				</ul>
				<section class="top-bar-section">
					<ul class="right">
						<li><a href="./">Iskanje</a></li>
						<li><a href="./?nastanitve=naprednoiskanje">Napredno iskanje</a></li>
						<li><a href="./?nastanitve=dodaj">Dodajanje</a></li>
						<li><a href="./?uporabnik=prijava">Prijava</a></li>
					</ul>
				</section>
			</nav>
		</div>
		<?php
		switch(key($_REQUEST)) {
			
			case 'nastanitve':
				include('nastanitve.php');
				break;

			case 'uporabnik':
				include('uporabnik.php');
				break;

			case 'najemodajalec':
				include('najemodajalec.php');
				break;

			default:
				include('nastanitve-iskanje.php');

		}
		?>

		<script>
			document.write('<script src=' + ('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') + '.js><\/script>');
		</script>
		<script src="js/foundation.min.js"></script>
		<script>
			$(document).foundation();
		</script>
	</body>
</html>
<?
pg_close($dbconn);
?>