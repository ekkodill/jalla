<?php
//Denne siden er utviklet av Erik Bjørnflaten., siste gang endret 27.02.2014
//Denne siden er kontrollert av kurt siste gang 03.03.2014

/****************************************************************************/
/*************Denne siden brukes til å slette brukere fra vis_brukere*********/
/****************************************************************************/
require_once("includes/init.php");
ini_set('display_errors', 'Off'); error_reporting(0); //Slår av alle php-errors
protected_page();
$db = getDB(); //Tilkobling til databasen.
if(isset($_POST['slett'])) {
  $id = sanitize($_POST['slett']);
    $result = $db->prepare("DELETE FROM brukere WHERE brukerPK = ? LIMIT 1");
    $result->bind_param('i', $id);      
   if($result->execute()) {
  		header('Location: vis_brukere.php?deleted');  
   } else {
   		header('vis_brukere.php?deleteerr');
 	}
}

?>