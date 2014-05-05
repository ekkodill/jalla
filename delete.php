<?php
//Denne siden er utviklet av Erik Bjørnflaten., siste gang endret 27.02.2014
//Denne siden er kontrollert av kurt siste gang 03.03.2014

/****************************************************************************/
/*************Denne siden brukes til å slette brukere fra vis_brukere*********/
/****************************************************************************/
require_once("includes/init.php");
$db = getDB(); //Tilkobling til databasen.
 if(isset($_POST['slett'])) {
 	$id = sanitize($_POST['slett']);
    $result = $db->query("DELETE FROM brukere WHERE brukerPK = '$id' LIMIT 1");      
   if($result) {
   		$_SESSION['delerr'] = "Brukeren ble slettet!";
  		header('Location: vis_brukere.php');  
   } else {
 		$_SESSION['delerr'] = "Det oppstod en feil ved sletting av denne brukeren";
   		redirect('vis_brukere.php');
 	}	

 } 

?>

