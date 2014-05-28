<!--Denne siden er utviklet av Kurt A. Amodt., siste gang endret 02.03.2014
Denne siden er kontrollert av kurt siste gang 03.03.2014  !-->

<?php
include_once 'includes/init.php';


//Funksjon som forhindrer innloggede brukere i å gå til login siden.
function logged_in_redirect() {
	if (logged_in() === true) {
		header('Location: index.php');
		exit();
	}
}


//Funksjon som regulerer access til sider basert på om man er innlogget
function protected_page() {
	if (logged_in() === false) {
		header('Location: protected.php');
		exit();
	}
}


//Generell funksjon som henter brukerdata basert på session
function user_data($brukerPK) {
	$db = getDB();
	$data = array();
	$brukerPK = (int)$brukerPK; 

	$func_num_args = func_num_args();
	$func_get_args = func_get_args();

	if($func_num_args > 1){
		unset($func_get_args[0]);
		
		$fields = '`'. implode('`, `', $func_get_args) . '`';
		$data = mysqli_fetch_assoc(mysqli_query($db, "SELECT $fields FROM `brukere` WHERE `brukerPK` = $brukerPK"));
		
	
		return $data;
	}


}


//Sjekker at en SESSION med brukerPK er i gang.
function logged_in() {
		return (isset($_SESSION['bruker_PK'])) ? true : false;
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
function testen($brukernavn) {
	$db = getDB();
 	$bnavn = $db->real_escape_string($brukernavn);
    $query = "SELECT passord FROM brukere WHERE ePost = '$brukernavn';";
     
    $result = mysqli_query($db, $query);
     
    if(mysqli_num_rows($result) == 0) //Bruker finnes ikke og blir redirecta til default.php.
     {
    return false;
    }
}

//Henter brukerID fra databasen basert på epost
function brukerID_fra_brukernavn($brukernavn) {
	$db = getDB();
	$brukernavn = sanitize($brukernavn);
	$brukernavn = mysqli_real_escape_string($db, $brukernavn);
	$query = "SELECT brukerPK FROM brukere WHERE ePost = '$brukernavn';";
	$result = mysqli_query($db, $query);
	
	$brukerID = mysqli_fetch_array($result, MYSQL_ASSOC);
	return $brukerID['brukerPK'];
}


//Sjekker databasen om passordet og brukernavnet hører sammen
function login($brukernavn, $passord) {
	$db = getDB();
	$brukerID = brukerID_fra_brukernavn($brukernavn);
	$brukernavn = mysqli_real_escape_string($db, $brukernavn);
	$query = "SELECT passord FROM brukere WHERE ePost = '$brukernavn';";
	$result = mysqli_query($db, $query);
	$userData = mysqli_fetch_array($result, MYSQL_ASSOC);

	$hash = hash('sha256', 'IT2' . hash('sha256', $passord));
	
	if($hash != $userData['passord']) //Feil passord, redirecter til default.php.
    {
    	return false;
    }
    else { //Dersom riktig blir brukerID returnert og man blir redirecta til index.php
    	return $brukerID;
    }
}

?>