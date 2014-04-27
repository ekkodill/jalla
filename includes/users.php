<?php
//Denne siden er utviklet av Kurt A. Amodt., siste gang endret 20.04.2014
//Denne siden er kontrollert av Erik Bjørnflaten siste gang 30.03.2014  !-->

//Henter fullstendig oppgaveliste for admin\veiledere og kun ubesvarte oppgaver for deltakere
function oppgListe($liste) {
	$db = getDB();
	if($liste == "besvart") {
		//Liste med besvarelser uten respons
		$query = "
		SELECT oppgaver.*, innleveringer.* 
		FROM oppgaver
		JOIN innleveringer ON (oppgaver.oppgavePK = innleveringer.oppgave)
		LEFT JOIN respons ON (innleveringer.innleveringPK = respons.innlevering) WHERE respons.innlevering is NULL";
	} elseif($liste == "liste") {
		//Liste med oppgaver gruppert på vanskelighetsgrad sortert på dato
		$query = "
		SELECT * FROM (select * from oppgaver ORDER BY datoEndret desc) as sortbydato
		order by vanskelighetsgrad";
	}
	$result = $db->query($query);
	return $result;
}

//Henter kun ubesvarte oppgaver for spesifisert deltaker
function ubesvarteOppg($bPK, $ferdig) {
	$db = getDB();
	if($ferdig == 0) {
		//Liste med innleveringer til angitt bruker som ikke er ferdig (påbegynnte oppgaver)
		$query = "
		SELECT innleveringer.*, oppgaver.* FROM innleveringer
        JOIN oppgaver ON innleveringer.oppgave = oppgaver.oppgavePK AND innleveringer.bruker = $bPK AND innleveringer.ferdig = $ferdig";
	} elseif ($ferdig == 1) {
		//Liste med innleveringer til angitt bruker som er ferdig men uten respons
		$query = "
		SELECT innleveringer.*, oppgaver.* FROM innleveringer
        JOIN oppgaver ON innleveringer.oppgave = oppgaver.oppgavePK AND innleveringer.bruker = $bPK AND innleveringer.ferdig = $ferdig
        LEFT JOIN respons ON (innleveringer.innleveringPK = respons.innlevering) WHERE respons.innlevering is NULL";
	} elseif($ferdig == 2) {
		//Liste med innleveringer til angitt bruker som er ferdig og har fått respons
		$query = "
		SELECT innleveringer.*, oppgaver.*, respons.* FROM innleveringer
        JOIN oppgaver ON innleveringer.oppgave = oppgaver.oppgavePK AND innleveringer.bruker = $bPK AND innleveringer.ferdig = 1
		LEFT JOIN respons ON (innleveringer.innleveringPK = respons.innlevering) WHERE respons.innlevering is not NULL";
	}else {
		//Liste med oppgaver til angitt bruker som er ubesvarte (ubesvarte oppgaver)
		$query = "
		SELECT oppgaver.*
		FROM oppgaver
		LEFT JOIN innleveringer ON (oppgaver.oppgavePK =innleveringer.oppgave AND innleveringer.bruker = $bPK)
		WHERE innleveringer.oppgave IS NULL";
	}
	$result = $db->query($query);
	return $result;
}

//Funksjon for glemt passord, oppretter et nytt og sender det på mail
function glemtPW($epost) {
		$gen_pw = generate_password(); //Generer passord med 8 karakterer
		$passord = passord($gen_pw); //Salter og hasher passordet
		$mailcheck = spamcheck($epost); //Sjekker at eposten er en gyldig adresse
		endrePW($passord, $epost); //Endrer passordet i databasen
		sendMail($epost, $gen_pw); //Sender det nye passordet på mail
		redirect("sendt.php");
}

//Funksjon for å oppdatere endret passord til databasen
function endrePW($passord, $epost){
	$db = getDB();
	$stmt = $db->prepare("UPDATE brukere SET passord=? WHERE ePost=? LIMIT 1");
            $stmt->bind_param('ss', $passord, $epost);
             $stmt->execute();
}

//Funksjon for å endre brukerinformasjon fra "minside" til databasen
function endreBrukerInfo($brukerPK, $fnavn, $enavn, $epost){
	$db = getDB();
      $stmt = $db->prepare("UPDATE brukere SET ePost=?, etternavn=?, fornavn=?  WHERE brukerPK=? LIMIT 1");
            $stmt->bind_param('sssi', $epost,$enavn, $fnavn, $brukerPK );
             if($stmt->execute()) {
             	return true;
             } else { return false; }
}

//Legger nye brukere inn i databasen
function addUser($ePost, $etternavn, $fornavn, $passord, $brukertype) {
	$db = getDB();
	$insert = $db->prepare("INSERT INTO brukere (ePost, etternavn, fornavn, passord, brukertype) VALUES (?,?,?,?,?)");
	$insert->bind_param('ssssi', $ePost, $etternavn, $fornavn, $passord, $brukertype);
	if($insert->execute()) {
		return true;
	} else { 
		return false;
	}
}

//Legger til nye oppgaver i databasen
function addOppg($veileder, $tittel, $oppg, $erPublisert, $vansklighetsgrad) {
	$db = getDB();
	$insert = $db->prepare("INSERT INTO oppgaver (veileder, tittelOppgave, tekstOppgave, datoEndret, erPublisert, vanskelighetsgrad) VALUES (?,?,?,now(),?,?)");
	$insert->bind_param('sssii', $veileder, $tittel, $oppg, $erPublisert, $vansklighetsgrad);
	if($insert->execute()) {
		return true;
	} else { 
		return false;
	}
}

//Sender epost til brukere med nytt passord
function sendMail($epost, $passord) {
		   $til = $epost;
		   $fra = "tocuhdill@gmail.com";
		   $tittel = "Bruker opprettet";
		   $melding = "Velkommen til touchdill!\nHer er innloggingsinformasjonen din. \nBrukernavn: ".$epost." \nPassord: ".$passord." 
		   \nDette er et tilfeldig generert passord, men det oppfordres til at du bytter dette.";
		   //PHP-regel sier at en linje i beskjeden ikke skal overstige 70 karakterer, så den må "wrappes".
		   $melding = wordwrap($melding, 70);
		   //Sender mail
		  if(mail($til,$tittel,$melding,"From: $fra\n")) {
    		return true;
    	} else {
    	return false;
    	}
}


//Sender epost til brukere med melding om at det er publisert en ny oppgave
function publishMail($tittel) {
	$db = getDB();
	$query = $db->query("
	SELECT ePost FROM brukere WHERE brukertype = 3");
	$fra = "tocuhdill@gmail.com";
	$tittel = "Ny oppgave publisert: ".$tittel;
	$melding = "Hei!\nDet er nå publisert en ny oppgave.
		   \nDu finner den i listen over ubesvarte oppgaver på siden din eller direkte på skrivesenteret.
		   \nLykke til!
		   \n\nMvh Touchmetoden";
	$melding = wordwrap($melding, 70);
	while($epostRow = $query->fetch_assoc()) {
	//Sender mail
	mail($epostRow['ePost'],$tittel,$melding,"From: $fra\n");
	
	}
}

//Sender mail kompliert fra minside av administrator\veiledere til spesifiserte brukere
function mailUsers($tittel, $melding, $fra, $til) {
	$db = getDB();
echo $tittel." ".$melding." ".$fra." ".$til;
	if($til == "Til alle") {
		$query = "SELECT ePost FROM brukere";
	} else {
		if($til == "Til deltakere") {
			$type = 3;
		} elseif($til == "Til veiledere") {
			$type = 2;	
		} elseif($til == "Til administratorer") {
			$type = 1;
		}	
			$query = "SELECT ePost FROM brukere WHERE brukertype = $type";
			echo $query;
	}
	$result = $db->query($query);
	$melding = wordwrap($melding, 70);
	while($epostRow = $result->fetch_assoc()) {
	//Sender mail
	mail($epostRow['ePost'],$tittel,$melding,"From: $fra\n");
	}
}


//Saniterer og validerer epostadressen
function spamcheck($field) {
  //Saniterer eposten så det ikke er noen ulovlige karakterer i den
  $field=filter_var($field, FILTER_SANITIZE_EMAIL); 
  //Sjekker at adressen er en gyldig epostadresse
  if(filter_var($field, FILTER_VALIDATE_EMAIL)) { 
  	return TRUE;
  } else {
    return FALSE;
  }
}

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

//Oppdaterer databasen med endringer som blir gjort på en oppgave som ikke har blitt publisert enda
function updateOppg($veileder, $tittel, $oppg, $erPublisert, $vansklighetsgrad, $pubPK) {
	$db = getDB();
    $stmt = $db->prepare("UPDATE oppgaver SET veileder=?, tittelOppgave=?, tekstOppgave=?, datoEndret=now(), erPublisert=?, vanskelighetsgrad=? WHERE oppgavePK=? LIMIT 1");
            $stmt->bind_param('issiii', $veileder,$tittel, $oppg, $erPublisert, $vansklighetsgrad, $pubPK);
             if($stmt->execute()) {
             	return true;
             } else { return false; }
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

function redirect($location) {
	header("Location: $location");
}



//Funksjon som regulerer access til sider basert på om man er innlogget
function protected_page() {
	if (logged_in() === false) {
		header('Location: protected.php');
		exit();
	}
}





//Generell funksjon som henter og splitter opp brukerdata basert på brukerID fra session variabel
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
	$brukerID = $result->fetch_assoc();
	return $brukerID['brukerPK'];
}




//Sjekker databasen om passordet og brukernavnet hører sammen
function login($brukernavn, $passord) {
	$db = getDB();
	$brukerID = brukerID_fra_brukernavn($brukernavn);
	$query = "SELECT passord FROM brukere WHERE ePost = '$brukernavn';";
	$result = $db->query($query);
	$userData = $result->fetch_assoc();
	
	$hash = passord($passord);
	if($hash != $userData['passord']) //Feil passord, redirecter til default.php.
    {
    	return false;
    }

    else { //Dersom riktig blir brukerID returnert for å brukes til session variabelen, og man blir redirecta til index.php
    	return $brukerID;
    }
}



//Hasher passord og returner det
function passord($pw) {
	$hash = hash('sha1', 'IT2'.$pw);
	return $hash;
}

//Autogenerer et nytt passord som default er på 8 karakterer
function generate_password($length = 8) {
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
$password = substr( str_shuffle( $chars ), 0, $length );
return $password;
}

?>