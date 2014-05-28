<!--Denne siden er utviklet av Kurt A. Aamodt, siste gang endret 03.03.2014
Denne siden er kontrollert av Kurt A. Aamodt siste gang 03.03.2014  !-->
<?php
include_once 'includes/init.php';
$db = getDB();



//Autogenerer passord til alle nyoppretta brukere. ***Bare for testingskyld.***
function passord() {
	$hash = hash('sha1', 'IT2' . hash('sha1', 'ekko'));
	return $hash;
}

$brukere = array();

//Sjekker at ikke noen felt er tomme 
if(!empty($_POST)) {
	if(isset($_POST['ePost'], $_POST['fornavn'], $_POST['etternavn'], $_POST['brukertype'])) {
		$ePost 		= trim($_POST['ePost']);
		$etternavn 	= trim($_POST['etternavn']);
		$fornavn 	= trim($_POST['fornavn']);
		$brukertype = trim($_POST['brukertype']);
		$passord = passord();
		if(!empty($fornavn) && !empty($etternavn) && !empty($ePost) && !empty($brukertype)) {

//binde og sende nyoppretta brukere til databasen
			$insert = $db->prepare("INSERT INTO brukere (ePost, etternavn, fornavn, passord, brukertype) VALUES (?,?,?,?,?)");
				$insert->bind_param('ssssi', $ePost, $etternavn, $fornavn, $passord, $brukertype);

				if($insert->execute()) {
					header('Location: vis_brukere.php');
					die();
				}
		}
	}
}


//skriver ut oppdatert liste med brukere og frigjør resultatet
if($resultat = $db->query("SELECT * FROM brukere")) {
	if($resultat->num_rows) {
		while($row = $resultat->fetch_object()) {
			$brukere[] = $row;
		}
		$resultat->free();
	}
}




?>