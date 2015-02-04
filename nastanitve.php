<?php

switch($_GET['nastanitve']) {
	
	case 'dodaj':
		include('nastanitve-dodaj.php');
		break;

	case 'naprednoiskanje':
		include('nastanitve-naprednoiskanje.php');
		break;

	case 'zemljevid':
		include('nastanitve-zemljevid.php');
		break;

	default:
		include('nastanitve-iskanje.php');

}

?>