<!--Denne siden er utviklet av Dag-Roger Eriksen og Kurt A. Amodt, siste gang endret 15.03.2014
Denne siden er kontrollert av Kurt A. Amodt siste gang 15.03.2014 
 !-->
<?php include_once 'includes/init.php'; 
$style = 'none'; //Setter display stylen for glem passord boksen til skjult når siden laster
//Sjekker at eposten finnes i systemet og sender brukeren videre til en informasjonsside om det stemmer.
if (isset($_POST['nyttpw']) === true && empty($_POST['nyttpw']) === false) {
	if (user_exists($_POST['nyttpw']) === false) {
		$style = 'block';
		$errors[] = 'Vi kan ikke finne denne e-postadressen: '. $_POST['nyttpw'];
	} 
	else {
		$_SESSION['recover'] = $_POST['nyttpw'];
		header('location: sendt.php');
	}
} 

?>
<script type="text/javascript">
	    function show() {
    	document.getElementById("glemtpassord").style.display="block";
    }
</script>

<div class="aside">
	<form method="post" action="login.php" >
		 <fieldset>
			  <h2>Innlogging</h2>
			  <span>Brukernavn:</span><br>
			  	<input type="text" autofocus id="brukernavn" name="brukernavn" tabindex="1" placeholder="Brukernavn" title="Fyll ut brukernavn" autocomplete="off"><br>
			  <span>Passord:</span><br>
			  	<input type="password" id="passord" tabindex="2" name="passord" placeholder="Passord" title="Fyll ut passord" autocomplete="off"><br>
			  	 <input id="loinknappen" type="submit" tabindex="3" value="Logg inn" title="Logg inn" >
			  	<input id="glpwknapp" type="button" itabindex="3"  value="Glemt passord" title="Glemt passord" onclick="show()">
		 </fieldset>
		 </form>
		 <?php
		 ?>	<form method="post" action="default.php" id="glemtpassord"  <?php echo "style=display:$style;" ?>>
			<fieldset>
				<h2>Glemt passord</h2>
				 <span>E-post:</span><br>
				  	<input type="text" id="e-post" name="nyttpw" tabindex="4" placeholder="E-post" title="Fyll ut e-post adresse" autocomplete="off"><br>
				    <input class="glemtknapp" type="submit" class="sendnytt"  tabindex="5" value="Send passord" title="Send nytt passord">
				    <br>
				    <p><?php
						if (empty($errors) === false) {
						?><h2><?php echo output_errors($errors);?></h2>
						<?php } ?></p>
			 </fieldset>
		</form>
      </div>         
 </div>  

