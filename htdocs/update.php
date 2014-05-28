<?php
// Denne siden er utviklet av Erik Bjørnflaten og Kurt A. Aamodt., siste gang endret 03.03.2014
// Denne siden er kontrollert av Kurt A. Aamodt, iste gang endret 03.03.2014

require_once("includes/connect.php");
$db = getDB();

print_r($_POST);
printf($_POST);
var_dump($_POST);

if(!empty($_POST)) {
	if(isset($_POST['editepost'], $_POST['editetternavn'], $_POST['editfornavn'], $_POST['editbrukertype'])) {
		$ePost     = trim($_POST['editepost']);
		$etternavn = trim($_POST['editetternavn']);
		$fornavn   = trim($_POST['editfornavn']);
		$brukertype   = trim($_POST['editbrukertype']);
		
		
			$insert = $db->prepare("UPDATE brukere SET ePost=?, etternavn=?, fornavn=?, brukertype=? WHERE ePost=?");
			$insert->bind_param('sssis', $ePost, $etternavn, $fornavn, $brukertype, $ePost);

				if($insert->execute()) {
					header('Location: vis_brukere.php');
					die("FEIL");
				} else { var_dump($insert); }
		}
	} else {
		var_dump($_POST);
	}

			

?>
