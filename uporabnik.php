<?php

switch($_GET['uporabnik']) {
	
	case 'prijava':
		include('uporabnik-prijava.php');
		break;

	case 'registracija':
		include('uporabnik-registracija.php');
		break;

	default:
		include('uporabnik-prijava.php');

}

?>