<?php 
require_once('includes/init.php');

//Sjekker at ikke noen felt er tomme 
if(isset($_POST['register'])) {
	unset($errors);
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
					header("location: registrer.php?registrert");
				} else { $errors[]  = "Det oppstod en feil og brukeren kunne ikke opprettes"; }
			} else { $errors[]  = "Alle boksene må fylles ut"; }
		} else { $errors[]  = "Eposten er registrert fra før"; }
	} else { $errors[]  = "Alle boksene må fylles ut"; }
} else { $errors[] = "Det oppstod en feil, prøv på nytt"; }
}


 ?>

<!doctype html>
<html>
    <?php 
    $pgName = 'Innlogging';
    include 'design/head.php'; ?>
  	<body>
  	<?php include 'design/header.php'; ?> 
		  <section>
				<div class="midtfelt">
					<?php
					//Viser statusmeldinger for registrering
					if(isset($_GET['registrert'])) {
						echo "<script type='text/javascript'>skjul();</script>"; //Skjuler registreringsfeltene om registreringen var vellykket, og viser innloggingsfeltene
						echo "<h2>Registreringen var vellykket.</h2><p class='okmsgcolor'>Sjekk eposten du registrerte for innloggingsinformasjon.</p>";
					}
						if (empty($errors) === false) {
						?><h2>Registreringen mislyktes...</h2><?php
						echo "<span class='errormsgcolor'>".output_errors($errors)."</span>";
						}?>
				</div>
				<br class="clear" />		
			</section>
		<?php include('design/footer.php'); ?>
	</body>
</html>