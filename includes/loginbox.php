<!--Denne siden er utviklet av Dag-Roger Eriksen(html\css), Mikael Kolstad(JS) og Kurt A. Amodt(php), siste gang endret 27.05.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 29.05.2014  !-->
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
		glemtPW($epost,$touchmail);
	}
} 

?>
<script type="text/javascript">

//Setter localstorage og skjuler \ viser element for glemt passord
function showGp() {
	//Setter eposten fra innloggingsboksen brukernavn til epost feltet for glemt passord
	if(document.getElementById("brukernavn").value != "") {
		document.getElementById("glemtpw").value = document.getElementById("brukernavn").value;
	}
	localStorage.form1style = 'block';
	localStorage.form2style = 'none';
	localStorage.form3style = 'none';
	document.getElementById("loginform").style.display="none";
	document.getElementById("registrer").style.display="none";
	document.getElementById("glemtpassord").style.display="block";
	document.getElementById("glemtpw").focus();
}
//Setter localstorage og skjuler glemt passord \ viser login elemementer
function skjul() {
	localStorage.form2style = 'block';
	localStorage.form1style = 'none';
	localStorage.form3style = 'none';
	document.getElementById("registrer").style.display= localStorage.form3style;
    document.getElementById("glemtpassord").style.display=localStorage.form1style;
    document.getElementById("loginform").style.display=localStorage.form2style;
    document.getElementById("brukernavn").focus();
}

//Setter localstorage og skjuler \ viser element for registrering
function showReg() {
	localStorage.form3style = 'block';
	localStorage.form2style = 'none';
	localStorage.form1style = 'none';
	document.getElementById("registrer").style.display="block";
	document.getElementById("glemtpassord").style.display="none";
	document.getElementById("loginform").style.display="none";
	document.getElementById("fornavn").focus();
}

//Setter localstorage og skjuler \ viser element for login
function showLogin() {
	localStorage.form2style = 'block';
	localStorage.form1style = 'none';
	localStorage.form3style = 'none';
	document.getElementById("registrer").style.display="none";
	document.getElementById("glemtpassord").style.display="none";
	document.getElementById("loginform").style.display="block";
	document.getElementById("brukernavn").focus();
}

//Laster localstorage verdier når siden er lastes
$(document).ready(function() { 
		document.getElementById("registrer").style.display= localStorage.form3style;
    	document.getElementById("glemtpassord").style.display=localStorage.form1style;
    	document.getElementById("loginform").style.display=localStorage.form2style;
 });
</script>


<!--Element for innlogging -->
<div class="innloggboksfixed" >
	<form method="post" action="login.php" id="loginform">
		<fieldset>
			<h2>Innlogging</h2>
			<span>Brukernavn:</span><br>
			<input type="text" class="boxinputs" id="brukernavn" tabindex="1" name="brukernavn" title="Fyll ut brukernavn" autofocus autocomplete="off"><br>
			<span>Passord:</span><br>
			<input type="password" class="boxinputs"  tabindex="2" name="passord" title="Fyll ut passord" autocomplete="off"><br>
			<input type="submit" class="loginboxknapper"  tabindex="3" value="Logg inn" title="Logg inn" ><br>
			<input type="button" class="loginboxknapper"  tabindex="4"  value="Glemt passord" title="Glemt passord" onclick="showGp()">
			<input type="button" class="loginboxknapper" id="reg" tabindex="5"  value="Registrer" title="registrer" onclick="showReg()">
		</fieldset>
	</form>
	<?php?>	
	<!--Element for glemt passord -->
	<form method="post" action="default.php" id="glemtpassord" style="display:none;">
		<fieldset>
			<h2>Glemt passord</h2>
			<span>E-post:</span><br>
			<input type="text" class="boxinputs" id="glemtpw" name="nyttpw" tabindex="1" title="Fyll ut e-post adresse"  autocomplete="off"><br>
			<input type="submit" name="sendnypw" class="loginboxknapper" tabindex="2" value="Send passord" title="Send nytt passord">
			<input type="button" class="loginboxknapper" tabindex="7"  value="Skjul" title="skjul glemt passordd" onclick="skjul()">
			<br>

		</fieldset>
	</form>
	<!--Element for registrering -->
		<form id="registrer" method="post" action="registrer.php" style="display:none;">
		<fieldset>
			<h2>Registrering</h2>
			<span>Fornavn*:</span><br>
			<input type="text" class="boxinputs" id="fornavn" tabindex="1" name="fornavn" title="Skriv inn fornavn" autocomplete="on"><br>
			<span>Etternavn*:</span><br>
			<input type="text" class="boxinputs" id="etternavn" tabindex="2" name="etternavn" title="Fyll inn etternavn" autocomplete="on"><br>
			<span>E-post*:</span><br>
			<input type="text" class="boxinputs" id="epostad" tabindex="3" name="ePost" title="Fyll inn epost" autocomplete="on"><br>
			<input type="text" hidden  placeholder="La dette feltet være blankt" name="bothoneypot" alt="La dette feltet være blankt"/>
			<p>*Må fylles ut</p>
			<input type="submit" class="loginboxknapper" name="register" tabindex="4" value="Registrer" title="registrer"><br>
			<input type="button" class="loginboxknapper"tabindex="5" value="Logg inn" title="Logg inn" onclick="showLogin()" >
			<input type="button" class="loginboxknapper" tabindex="6"  value="Glemt passord" title="Glemt passord" onclick="showGp()">
		</fieldset>
	</form>
			<?php //Statusmeldinger for glemt epost
				if (isset($_POST['sendnypw']) && empty($errors) === false) {
				?><?php echo output_errors($errors);?>
			<?php } ?>        
</div> 


