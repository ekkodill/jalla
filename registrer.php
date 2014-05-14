<!--Denne siden er utviklet av Erik Bjørnflaten (html\css) og Kurt A. Aamodt (php), sist gang endret 11.04.2014
Denne siden er kontrollert av Mikael Kolstad,siste gang  04.05.2014  !-->

<?php
include_once 'includes/init.php';
logged_in_redirect(); //Forhindrer innloggede brukere å gå manuelt til denne siden

//Sjekker at ikke noen felt er tomme 
if(!empty($_POST)) {
	if(empty($_POST['bothoneypot'])) {
	if(isset($_POST['ePost'], $_POST['fornavn'], $_POST['etternavn'])) {
		$ePost 		= trim($_POST['ePost']);
		$etternavn 	= trim($_POST['etternavn']);
		$fornavn 	= trim($_POST['fornavn']);
	   	$brukertype = 3; 
	   	
	    if(user_exists($ePost) == false) { 	
			$gen_pw = generate_password(); //Generer passord med 8 karakterer
			$passord = passord($gen_pw); //Salter og krypterer passordet
			$mailcheck = spamcheck($ePost); //Sjekker at eposten er en gyldig adresse
			if ($mailcheck === false) {
				$errors[]  = "Eposten er ikke gyldig"; 		
			} else if(!empty($fornavn) && !empty($etternavn) && !empty($ePost) && !empty($brukertype)) {
				if (addUser($ePost, $etternavn, $fornavn, $passord, $brukertype)) {
					sendMail($ePost, $gen_pw);
					$errors[] = "Brukeren ble opprettet.\n<a href='default.php'>Trykk her for å logge inn</a>";
				} else { $errors[]  = "Det oppstod en feil og brukeren kunne ikke opprettes"; }
			} else { $errors[]  = "Alle boksene må fylles ut"; }
		} else { $errors[]  = "Eposten er registrert fra før"; }
	} else { $errors[]  = "Alle boksene må fylles ut"; }
} else { $errors[] = "Det oppstod en feil, prøv på nytt"; }
}

?>


<!--**************************************************************-->
<!--**********Denne siden er for registrering av nye brukere******-->
<!--**************************************************************-->

<!DOCTYPE html>
<html lang="nb-no">
		<?php
		$pgName = 'Registrering';
		include('design/head.php');
		?>
		<body>
		<?php include('design/header.php');	?>
			<div id="page">	
		        <section>  
		       	<legend class="regtitbredde"><center><h4>Registrering</h4></center>
					<form class="registrering" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data"><br />
					Fornavn*<br /> <input class="fornavn" type="text" name="fornavn" /><br />
						Etternavn*<br /> <input class="etternavn" type="text" name="etternavn" /><br />
						E-post*<br /> <input class="epostad" type="text" name="ePost" /><br />
						<input type="text" hidden  placeholder="La dette feltet være blankt" name="bothoneypot" alt="La dette feltet være blankt"/>
                         <p>*Må fylles ut</p>
						<input type="submit" class="buttonStyle" value="Registrer" name="register">
						<span class="feilmelding">
					<?php
							if (empty($errors) === false) {
							echo output_errors($errors);
							}
					?>
						</span>
					</form>
					</legend>
				</section>
	    		<?php include('design/footer.php'); ?>
       		</div>
		</body>
</html>
