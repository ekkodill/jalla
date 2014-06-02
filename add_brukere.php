<!--Denne siden er utviklet av Erik Bjørnflaten (html\css) og Kurt A. Aamodt (php), siste gang endret 03.03.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 31.05.2014  !-->
<?php
ini_set('display_errors', 'Off'); error_reporting(0); //Slår av alle php-errors
protected_page();
/******************************************************************************/
/*********Denne siden brukes til å legge til brukere på vis_brukere.php*******/
/******************************************************************************/

if(!empty($_POST['adduser'])) {
	//Sjekker at det er data i alle feltene 
	if(isset($_POST['ePost'], $_POST['fornavn'], $_POST['etternavn'], $_POST['btype'])) {
		$ePost 		= sanitize(trim($_POST['ePost']));
		$etternavn 	= sanitize(trim($_POST['etternavn']));
		$fornavn 	= sanitize(trim($_POST['fornavn']));
		//Setter riktig tall for databasen i forhold til brukertype
		if($_POST['btype'] == "administrator") { 
    	$brukertype = 1; 
    } 
    	else if($_POST['btype'] == "veileder" ) { 
    	$brukertype = 2; 
    }
    	else if($_POST['btype'] == "deltaker") { 
    	$brukertype = 3; 
    }
    	//Sjekker om eposten finnes fra før
	    if(user_exists($ePost) == false) { 	
			$gen_pw = generate_password(); //Generer passord med 8 karakterer
			$passord = passord($gen_pw); //Salter og krypterer passordet
			$mailcheck = spamcheck($ePost); //Sjekker at eposten er en gyldig adresse
			//Registrerer og sender epost med passord informasjon til den nye brukeren
			if ($mailcheck === false) {
				$errors[]  = "Eposten er ikke gyldig"; 		
			} else if(!empty($fornavn) && !empty($etternavn) && !empty($ePost) && !empty($brukertype)) {
				if (addUser($ePost, $etternavn, $fornavn, $passord, $brukertype)) {
					if(sendMail($ePost, $gen_pw, $touchmail, "Bruker opprettet")) {
						$errors[] = "Epost ble sendt til brukeren";
						header("location: vis_brukere.php?registrert");
					} else { $errors[] = "Det oppstod en feil ved utsending av epost, sjekk mailserveren"; }
				} else { $errors[]  = "Det oppstod en feil og brukeren kunne ikke opprettes"; }
			} else { $errors[]  = "Alle boksene må fylles ut"; }
		} else { $errors[]  = "Eposten er registrert fra før"; }
	} else { $errors[]  = "Alle boksene må fylles ut"; }
}

?>

<!--Tabell med elementer for å legge til brukere!-->
<div class="leggtilbruker">
	<center><legend><h4>Legg til bruker</h4></legend></center>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="nybruker">
		<table>
			<tr>
				<th class="tab1">Epost*</th>
				<th class="tab1">Etternavn*</th>
				<th class="tab1">Fornavn*</th>
				<th class="tab1">Brukertype*</th>
			</tr>
			<tr>
				<td><input class="tarea" type="text" name="ePost" id="ePost"></td>
				<td><input class="tarea" type="text" name="etternavn" id="etternavn"></td>
				<td><input class="tarea" type="text" name="fornavn" id="fornavn"></td>
				<td>
					<select  class="tarea" name='btype' id="nytype">
					<option value='velg' selected >Velg brukertype...</option>
				    <option value='administrator' >Administrator</option>
				    <option value='veileder'>Veileder</option>
				    <option value='deltaker'>Deltaker</option>
				    </select>
				</td>	
			</tr>
		</table>
			<h7 class="paakrev">*Må fylles inn.</h7><br>
		<center><input name="adduser" id="leggtilny" type="submit" value="Legg til ny bruker" onclick="return regNy()" ></center>
			<span>
				<?php //Viser feilmeldinger ved oppretting av brukere
						if (empty($errors) === false) {
						echo "<span class='errormsgcolor'>".output_errors($errors)."</span>";
						}
				?>
			</span>
	</form>
</div>