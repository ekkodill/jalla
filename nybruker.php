<!--Denne siden er utviklet av Kurt A. Aamodt, siste gang endret 03.03.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 03.03.2014  !-->

<?php
include_once 'includes/init.php';
$db = getDB();
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
		$passord = passord('ekko');
		if(!empty($fornavn) && !empty($etternavn) && !empty($ePost) && !empty($brukertype)) {

//binder og sende nyoppretta brukere til databasen
			$insert = $db->prepare("INSERT INTO brukere (ePost, etternavn, fornavn, passord, brukertype) VALUES (?,?,?,?,?)");
				$insert->bind_param('ssssi', $ePost, $etternavn, $fornavn, $passord, $brukertype);
				if($insert->execute()) {
					header('Location: vis_brukere.php');
					die();
				} else { echo "NO EXECUTE";}
		} else { echo "EMPTY";} 
	} else { echo print_r($_POST); }
} else { echo "EMPY POST";} 















?>