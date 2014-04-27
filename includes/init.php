<!--Denne siden er utviklet av Kurt A. Amodt., siste gang endret 02.03.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 26.03.2014  !-->

<?php
//Denne filen brukes for å initiere diverse. Session, samling av filer som brukes ofte etc.
session_start();
//error_reporting(0);
require 'includes/connect.php';
require 'includes/users.php';
//Får tak i brukerdata fra sessionen som kan brukes til de som er innlogget.
if(logged_in() === true) {
	$session_user_id = $_SESSION['brukerPK'];
	$user_data = user_data($session_user_id, 'brukerPK',  'ePost', 'etternavn', 'fornavn', 'passord', 'brukertype');
	
}


//Error samling for diverse. Brukes foreløpig til å gi beskjed om feilmeldinger for innloggingsforsøk.
$errors = array(); 
$touchmail = "touchdill@gmail.com";


?>