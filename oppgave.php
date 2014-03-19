<?php
include 'includes/init.php';
$db = getDB(); ?>
<?php 
if(isset($_POST['submit'])) {
	$content = $_POST['content'];

if(isset($_FILES['file'])) {


$allowedExts = array("pdf");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "application/pdf") && in_array($extension, $allowedExts)))  {
  if ($_FILES["file"]["error"] > 0) {
    	echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  	else {
  	  echo "Upload: " . $_FILES["file"]["name"] . "<br>";
  	  echo "Type: " . $_FILES["file"]["type"] . "<br>";
  	  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
  	  echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
  	  if (file_exists("uploads/" . $_FILES["file"]["name"])) {
  	    echo $_FILES["file"]["name"] . " filen finnes allerede. ";
  	    }
  	  else {
  	    move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $_FILES["file"]["name"."1337"]);
  	    echo "Stored in: " . "uploads/" . $_FILES["file"]["name"];
  	  }
  	}
 }
	else {
  		echo "Ugyldig filformat";
  	}
} else {
	echo "Du må velge et vedlegg å laste opp";
}

if (empty($content)) {
		$error = 'Du kan ikke lagre en tom oppgave';
	}
	else {
		$error = 'Oppgaven ble lagret';
	}
}

 ?>


<!doctype html>
<html>
	<body>
	<?php include_once 'design/head.php'; ?>
			<form action="oppgave.php" method="post" enctype="multipart/form-data">
			<input type="text" id="oppgtitt" placeholder="Skriv inn tittelen" name="tittel"><br><br>
			<label>Vanskelighetsgrad:</label> 
			<br>
			<input type="radio" value="3" name="vansklighetsgrad">Hard
			<input type="radio" value="2" name="vansklighetsgrad">Medium
			<input type="radio" value="1" name="vansklighetsgrad">Lett
			<textarea id="oppgtext" placeholder="Skriv inn oppgaven" name="oppg"></textarea><br>
			<input type="submit" name="publiser" value="Publiser">
				<label for="file"></label>
				<input type="file" name="file" id="file"><br>
				<input type="submit" name="submit" value="Last opp vedlegg">
		</form>
	<form id="oppTab">
 <a href="uploads/jalla.pdf">Jalla pdf</a>
	</form>
	</body>
</html>


<?php 
$db = getDB();

//Sjekker at ikke noen felt er tomme 
if(!empty($_POST)) {
	if(isset($_POST['tittel'])) {
		if(isset($_POST['oppg'])) {
			if(!isset($_POST['vanskelighetsgrad'])) {
				echo "<p><strong>Please select Yes or No.</strong></p>";
			}

		$tittel 	= trim($_POST['tittel']);
		$oppg 		= trim($_POST['oppg']);
		$link 		= "<a href='uploads/jalla.pdf'>Jalla pdf</a>";
		$vansklighetsgrad = trim($_POST['vansklighetsgrad']);
		$veileder   = $user_data['brukerPK'];
		$erPublisert = 1;
		date_default_timezone_set('Europe/Oslo');
		$dato = date('m/d/Y h:i:s a', time());
		if(!empty($tittel) && !empty($oppg))  {

				$insert = $db->prepare("INSERT INTO oppgaver (veileder, tittelOppgave, tekstOppgave, datoEndret, erPublisert, linkVedlegg, vanskelighetsgrad) VALUES (?,?,?,now(),?,?,?)");
				$insert->bind_param('sssisi', $veileder, $tittel, $oppg, $erPublisert, $link, $vansklighetsgrad);
				
				if($insert->execute()) {
					header('Location: oppgave.php');
					die();
				} else { echo $insert->errno;}
		} else { echo "EMPTY";} 
	} else { echo print_r($_POST); }
} else { echo "Mangler tittel";} 
} else { echo "Ingen POST";} 







 ?>
