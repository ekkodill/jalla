<?php
//Denne siden er utviklet av Kurt A. Amodt., siste gang endret 26.03.2014
//Denne siden er kontrollert av Erik Bjørnflaten siste gang 30.03.2014  !-->


include_once 'includes/init.php';


//Henter oppgavetittel fra databasen
function hentOppgt($oPK) {
	$db = getDB();

	$oppgave = $db->query("SELECT tittelOppgave FROM oppgaver WHERE oppgavePK = $oPK")->fetch_object()->tittelOppgave;
	return $oppgave;
}

//Henter ønsket brukers etternavn fra databasen
function finnBruker($brukerPK) {
	$db = getDB();

	$bruker = $db->query("SELECT etternavn FROM brukere WHERE brukerPK = $brukerPK")->fetch_object()->etternavn;
	return $bruker;
}

//Henter oppgaveteksten fra databasen
function hentOppgave($oppgPK) {
	$db = getDB();

	$oppgave = $db->query("SELECT tekstOppgave FROM oppgaver WHERE oppgavePK = $oppgPK")->fetch_object()->tekstOppgave;
	return $oppgave;
}


//Sjekker at det finnes i databasen
function sjekkAntall($type) {
	$db = getDB();
	$brukere = array();
	//skriver ut oppdatert liste med brukere og frigjør resultatet
if($resultat = $db->query("SELECT * FROM $type")) {
	if($resultat->num_rows) {
		while($row = $resultat->fetch_object()) {
			$brukere[] = $row;
		}
		$resultat->free();
	}
} return $brukere;
}

//Henter data fra databasen
function getQuery($type, $sorter) {
	  $db = getDB();
	  $type = sanitize($type);
	  $sorter = sanitize($sorter);
	  if($type == 1) {
	  	return $result = $db->query("SELECT * FROM brukere ORDER BY $sorter");
	  } else {
	  		return $result = $db->query("SELECT * FROM brukere WHERE brukertype >= $type ORDER BY $sorter");
		}
	}



//Funksjon som forhindrer innloggede brukere i å gå til login siden.
function logged_in_redirect() {
	if (logged_in() === true) {
		header('Location: default.php');
		exit();
	}
}

function redirect() {
	header('Location: default.php');
}



//Funksjon som regulerer access til sider basert på om man er innlogget
function protected_page() {
	if (logged_in() === false) {
		header('Location: protected.php');
		exit();
	}
}





//Generell funksjon som henter brukerdata basert på session
function user_data($user_id) {
	$db = getDB();
	$data = array();
	$user_id = (int)$user_id;
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();

	if ($func_num_args > 1) {
		unset($func_get_args[0]);
		$fields = '`' . implode('`, `', $func_get_args) . '`';
		$result = $db->query("SELECT $fields FROM `brukere` WHERE `brukerPK` = $user_id");
		$data = $result->fetch_assoc();
		return $data;
	}

}


//Sjekker at en SESSION med brukerPK er i gang.
function logged_in() {
		return (isset($_SESSION['brukerPK'])) ? true : false;
}



//Generell funksjon for å sanitere data mot injeksjoner og xss.
function sanitize($data) {
	$db = getDB();
	return $sanitert = $db->real_escape_string($data);
}	



//Lister ut innloggingsfeil for brukeren
function output_errors($errors) {
	return '<ul><li>' . implode('<ul><li>', $errors) . '</li></ul>';
}




//Tester om brukernavnet(eposten) finnes i databasen
function user_exists($username) {
	$db = getDB();
	$username = sanitize($username);
	$result =  $db->query("SELECT COUNT(`brukerPK`) FROM `brukere` WHERE `ePost` = '$username'");
	return (mysqli_result($result, 0) == 1) ? true : false;
}



//Returnerer et resultat fra databasen, som erstatning for den gamle "mysql_result".
function mysqli_result($res, $row, $field=0) {
    $res->data_seek($row);
    $datarow = $res->fetch_array();
    return $datarow[$field];
} 





//Henter brukerID fra databasen basert på epost
function brukerID_fra_brukernavn($brukernavn) {
	$db = getDB();
	$brukernavn = sanitize($brukernavn);
	$query = "SELECT brukerPK FROM brukere WHERE ePost = '$brukernavn';";
	$result = $db->query($query);
	$brukerID = mysqli_fetch_array($result, MYSQL_ASSOC);
	return $brukerID['brukerPK'];
}




//Sjekker databasen om passordet og brukernavnet hører sammen
function login($brukernavn, $passord) {
	$db = getDB();
	$brukerID = brukerID_fra_brukernavn($brukernavn);
	$query = "SELECT passord FROM brukere WHERE ePost = '$brukernavn';";
	$result = $db->query($query);
	$userData = mysqli_fetch_array($result, MYSQL_ASSOC);
	
	$hash = hash('sha1', 'IT2'.$passord);
	if($hash != $userData['passord']) //Feil passord, redirecter til default.php.
    {
    	return false;
    }

    else { //Dersom riktig blir brukerID returnert og man blir redirecta til index.php
    	return $brukerID;
    }
}



//Autogenerer passord til alle nyoppretta brukere. ***Bare for testingskyld.***
function passord($pw) {
	$hash = hash('sha1', 'IT2'.$pw);
	return $hash;
}

?>