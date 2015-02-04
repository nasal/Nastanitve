<?php

switch($_GET['najemodajalec']) {
	
	case 'prijava':
		include('najemodajalec-prijava.php');
		break;

	case 'registracija':
		include('najemodajalec-registracija.php');
		break;

	default:
		include('najemodajalec-prijava.php');

}

?>