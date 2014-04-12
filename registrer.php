<!--Denne siden er utviklet av Erik Bjørnflaten, sist gang endret 11.04.2014
Denne siden er kontrollert av Kurt A. Aamodt,siste gang  30.03.2014  !-->

<?php
include_once 'includes/init.php';
logged_in_redirect();

//Sjekker at ikke noen felt er tomme 
if(!empty($_POST)) {
	if(isset($_POST['ePost'], $_POST['fornavn'], $_POST['etternavn'], $_POST['btype'])) {
		$ePost 		= trim($_POST['ePost']);
		$etternavn 	= trim($_POST['etternavn']);
		$fornavn 	= trim($_POST['fornavn']);
		if($_POST['btype'] == "administrator") { 
    	$brukertype = 1; 
    } 
    	else if($_POST['btype'] == "veileder" ) { 
    	$brukertype = 2; 
    }
    	else if($_POST['btype'] == "deltaker") { 
    	$brukertype = 3; 
    }
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
}

?>




<!DOCTYPE html>
<html lang="nb-no">
		<?php
		$pgName = 'Registrering';
		include('design/head.php');
		?>
		<body>
			<div id="page">
				<?php
				include('design/header.php');
				?>
		        <section>
		       	<center><legend><h4>Registrering</h4></legend></center>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
						Fornavn: <input type="text" name="fornavn" /><br />
						Etternavn: <input type="text" name="etternavn" /><br />
						E-post: <input type="text" name="ePost" /><br />
						<input type="hidden" name="btype" value="deltaker">

						<input type="submit" value="Registrer" name="register">
					</form>
				<span>
					<?php
							if (empty($errors) === false) {
							echo output_errors($errors);
							}
					?>
				</span>
				</section>
	    		<?php include('design/footer.php'); ?>
       		</div>
		</body>
</html>
