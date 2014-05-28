<!--Denne siden er utviklet av Kurt A. Amodt., siste gang endret 03.03.2014
Denne siden er kontrollert av Kurt A. Amodt siste gang 03.03.2014 
 !-->

<div class="aside">
	<form method="post" action="login.php" >
		 <fieldset>
			  <h2>Innlogging</h2>
			  <span>Brukernavn:</span><br>
			  	<input type="text" autofocus id="brukernavn" name="brukernavn" tabindex="1" placeholder="Brukernavn" title="Fyll ut brukernavn" autocomplete="off"><br>
			  <span>Passord:</span><br>
			  	<input type="password" id="passord" tabindex="2" name="passord" placeholder="Passord" title="Fyll ut passord" autocomplete="off"><br>
			  	 <input id="loinknappen" type="submit" tabindex="3" value="Logg inn" title="Logg inn" >
			  	<input id="glpwknapp" type="button" itabindex="3"  value="Glemt passord" title="Glemt passord" onclick="show();">
		 </fieldset>
		 </form>
	<form method="post" action="" id="glemtpassord"  style="display:none;">
			<fieldset>
				<h2>Glemt passord</h2>
				 <span>E-post:</span><br>
				  	<input type="text" id="e-post" name="nyttpw" tabindex="4" placeholder="E-post" title="Fyll ut e-post adresse" autocomplete="off"><br>
				    <input class="glemtknapp" type="submit" class="sendnytt"  tabindex="5" value="Send passord" title="Send nytt passord" onclick="show();">
			 </fieldset>
		</form>
      </div>         
 </div>  

<?php
//Sjekker at eposten finnes i databasen

if (isset($_POST['nyttpw'])){
$brukernavn = $_POST['nyttpw'];

	if (testen($brukernavn) === false) {
		echo 'Vi kan ikke finne denne eposten: '.$brukernavn;
	} 
	else {
		header('location: sendt.php');
	} 
} 
?>