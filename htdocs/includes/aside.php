<!--Denne siden er utviklet av Kurt A. Amodt., siste gang endret 02.03.2014
Denne siden er kontrollert av kurt siste gang 03.03.2014  !-->

<?php
//Sjekker at brukeren er innlogget og inkluderer\eksluderer login boksen på default.php
	if(logged_in() === true) {
		 require 'includes/loggedin.php';
	} else {
		 require 'includes/loginbox.php';
	}

?>

