
<?php
//Denne siden er utviklet av Kurt A. Amodt., siste gang endret 03.05.2014 
//Denne siden er kontrollert av Erik Bjørnflaten siste gang 29.05.2014!

ini_set('display_errors', 'Off');
error_reporting(0);
//Denne filen brukes for å initiere diverse. Session, samling av filer som brukes ofte etc.
session_start();

require 'includes/connect.php';
require 'includes/users.php';
require 'includes/MyTXT.php';


//Får tak i brukerdata fra sessionen som kan brukes til de som er innlogget.
if(logged_in() === true) {
	$session_user_id = $_SESSION['brukerPK'];
	$user_data = user_data($session_user_id, 'brukerPK','brukertype', 'ePost', 'etternavn', 'fornavn', 'passord');
	
}


//Error samling for diverse. Brukes for feilmeldinger i applikasjonen.
$errors = array(); 


//Leser inn applikasjonsepostadressen fra fil
$file_path = "appepost.txt";
if(file_exists($file_path)) {
	$file_handle = fopen($file_path, 'rb');
} else {
	$ourFileHandle = fopen($file_path, 'w') or die("can't open file");
	fclose($ourFileHandle);
}
if(filesize($file_path) != 0) {
	$touchmail = fread($file_handle, filesize($file_path));	
	fclose($file_handle);
} else { $touchmail = ""; }


?>