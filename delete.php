<!--Denne siden er utviklet av Erik Bjørnflaten., siste gang endret 27.02.2014
Denne siden er kontrollert av kurt siste gang 03.03.2014  !-->

<?php
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
   		//echo "<script type='text/javascript'>alert('Det oppstod en feil med ID: ".$id."'); location.href='vis_brukere.php';</script>";   
 	}	

 } 

?>

