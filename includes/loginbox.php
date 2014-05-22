<!--Denne siden er utviklet av Dag-Roger Eriksen og Kurt A. Amodt, siste gang endret 27.03.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 30.03.2014  !-->
<?php 

//Sjekker at eposten finnes i systemet og sender brukeren videre til en informasjonsside om det stemmer.
if (isset($_POST['nyttpw']) === true && empty($_POST['nyttpw']) === false) {
	unset($errors);
	if (user_exists($_POST['nyttpw']) === false) {
		$_SESSION['style'] = 'block';
		$errors[] = 'Fant ikke følgene e-postadresse: '. $_POST['nyttpw'];
	} 
	else {
		$_SESSION['recover'] = $_POST['nyttpw'];
		$epost = sanitize($_POST['nyttpw']);
		glemtPW($epost);
	}
}


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
					$errors[] = "Brukeren ble opprettet.";
				} else { $errors[]  = "Det oppstod en feil og brukeren kunne ikke opprettes"; }
			} else { $errors[]  = "Alle boksene må fylles ut"; }
		} else { $errors[]  = "Eposten er registrert fra før"; }
	} else { $errors[]  = "Alle boksene må fylles ut"; }
} else { $errors[] = "Det oppstod en feil, prøv på nytt"; }
}

?>
<script type="text/javascript">


function showGp() {
	localStorage.form1style = 'block';
	localStorage.form2style = 'none';
	localStorage.form3style = 'none';
	document.getElementById("loginform").style.display="none";
	document.getElementById("registrer").style.display="none";
	document.getElementById("glemtpassord").style.display="block";
}
function skjul() {
	localStorage.form2style = 'block';
	localStorage.form1style = 'none';
	localStorage.form3style = 'none';
	document.getElementById("registrer").style.display= localStorage.form3style;
    document.getElementById("glemtpassord").style.display=localStorage.form1style;
    document.getElementById("loginform").style.display=localStorage.form2style;
}
function showReg() {
	localStorage.form3style = 'block';
	localStorage.form2style = 'none';
	localStorage.form1style = 'none';
	document.getElementById("registrer").style.display="block";
	document.getElementById("glemtpassord").style.display="none";
	document.getElementById("loginform").style.display="none";
}

function showLogin() {
	localStorage.form2style = 'block';
	localStorage.form1style = 'none';
	localStorage.form3style = 'none';
	document.getElementById("registrer").style.display="none";
	document.getElementById("glemtpassord").style.display="none";
	document.getElementById("loginform").style.display="block";
}
$(document).ready(function() { 
		document.getElementById("registrer").style.display= localStorage.form3style;
    	document.getElementById("glemtpassord").style.display=localStorage.form1style;
    	document.getElementById("loginform").style.display=localStorage.form2style;
 });
</script>



<div class="innloggboksfixed" >
	<form method="post" action="login.php" id="loginform">
		<fieldset>
			<h2>Innlogging</h2>
			<span>Brukernavn:</span><br>
			<input type="text" class="boxinputs" id="brukernavn" tabindex="1" name="brukernavn" title="Fyll ut brukernavn" autofocus autocomplete="off"><br>
			<span>Passord:</span><br>
			<input type="password" class="boxinputs"  tabindex="2" name="passord" title="Fyll ut passord" autocomplete="off"><br>
			<input type="submit" class="test"  tabindex="3" value="Logg inn" title="Logg inn" ><br>
			<input type="button" class="test"  tabindex="4"  value="Glemt passord" title="Glemt passord" onclick="showGp()">
			<input type="button" class="test" id="reg" tabindex="5"  value="Registrer" title="registrer" onclick="showReg()">
		</fieldset>
	</form>
	<?php?>	
	<form method="post" action="default.php" id="glemtpassord" style="display:none;">
		<fieldset>
			<h2>Glemt passord</h2>
			<span>E-post:</span><br>
			<input type="text" class="boxinputs" name="nyttpw" tabindex="5" title="Fyll ut e-post adresse" autocomplete="off"><br>
			<input type="submit" name="sendnypw" class="test" tabindex="6" value="Send passord" title="Send nytt passord">
			<input type="button" class="test" tabindex="7"  value="Skjul" title="skjul glemt passordd" onclick="skjul()">
			<br>

		</fieldset>
	</form>
		<form id="registrer" method="post" action="" style="display:none;">
		<fieldset>
			<h2>Registrering</h2>
			<span>Fornavn*:</span><br>
			<input type="text" class="boxinputs" id="fornavn" tabindex="1" name="fornavn" title="Skriv inn fornavn" autofocus autocomplete="on"><br>
			<span>Etternavn*:</span><br>
			<input type="text" class="boxinputs" id="etternavn" tabindex="2" name="etternavn" title="Fyll inn etternavn" autocomplete="on"><br>
			<span>E-post*:</span><br>
			<input type="text" class="boxinputs" id="epostad" tabindex="3" name="ePost" title="Fyll inn epost" autocomplete="on"><br>
			<input type="text" hidden  placeholder="La dette feltet være blankt" name="bothoneypot" alt="La dette feltet være blankt"/>
			<p>*Må fylles ut</p>
			<input type="submit" class="test" name="register" tabindex="4" value="Registrer" title="registrer"><br>
			<input type="button" class="test"tabindex="5" value="Logg inn" title="Logg inn" onclick="showLogin()" >
			<input type="button" class="test" tabindex="6"  value="Glemt passord" title="Glemt passord" onclick="showGp()">
		</fieldset>
	</form>
				<?php
				if (isset($_POST['register']) && empty($errors) === false || isset($_POST['sendnypw']) && empty($errors) === false) {
				?><?php echo output_errors($errors);?>
			<?php } ?>        
</div> 
<script type="text/javascript">

</script> 



