<!--Denne siden er utviklet av Erik Bjørnflaten., siste gang endret 27.02.2014
Denne siden er kontrollert av kurt siste gang 03.03.2014  !-->

<?php
require_once("includes/init.php");
$db = getDB(); //får connection med databasen.

 if(isset($_POST['slett'])) {
 	$id = $_POST['slett'];
  	
   $result = mysqli_query($db, "DELETE FROM brukere WHERE brukerPK = '$id'");      
   if($result) {
  		header('Location: vis_brukere.php');  
   } else {
   		echo "<script type='text/javascript'>alert('Det oppstod en feil med ID: ".$id."'); location.href='vis_brukere.php';</script>";   
 	}	
 } 
?>
