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



<?php 


$db = getDB();

//Registrerer nye opgpaver til databasen
if(!empty($_POST)) {
		$tittel 	= trim($_POST['tittel']);
		$oppg 		= trim($_POST['oppg']);
		$fil 		= trim($_POST['file']);
		$link 		= "<a href='uploads/".$fil."'>".$fil."</a>";
		$vansklighetsgrad = trim($_POST['vansklighetsgrad']);
		$veileder   = $user_data['brukerPK'];
		$erPublisert = 1;
		
		if(!empty($tittel) && !empty($oppg))  {
				$insert = $db->prepare("INSERT INTO oppgaver (veileder, tittelOppgave, tekstOppgave, datoEndret, erPublisert, linkVedlegg, vanskelighetsgrad) VALUES (?,?,?,now(),?,?,?)");
				$insert->bind_param('sssisi', $veileder, $tittel, $oppg, $erPublisert, $link, $vansklighetsgrad);
		
				if($insert->execute()) {
					header('Location: oppgave.php');
					die();
				} else { echo $insert->errno;}
		} else { $errors[] = "EMPTY";} 
}

 ?>




<!DOCTYPE html>
<html lang="nb-no">
		<?php
		include('design/head.php');
		?>
		<body>
			<div id="page">
				<?php
				include('design/header.php');
				?>
		    <section style="width:94%">
					<center><legend>Lag ny oppgave</legend></center><br>
				<form action="oppgave.php"  enctype="multipart/form-data" onsubmit="return regNyoppg()" method="post">
					<input type="text" id="oppgtitt" placeholder="Skriv inn tittelen" name="tittel"><br><br>
					<label>Vanskelighetsgrad:</label> 
					<br>
					<input type="radio" value="3" name="vansklighetsgrad">Vanskelig
					<input type="radio" value="2" name="vansklighetsgrad">Medium
					<input type="radio" value="1" name="vansklighetsgrad">Lett
					<textarea id="oppgtext" placeholder="Skriv inn oppgaven" name="oppg"></textarea><br>
					<input type="submit" name="publiser" value="Publiser">
					<label for="file"></label>
					<input type="file" name="file" id="file"><br>
					<input type="submit" name="submit" value="Last opp vedlegg">
				</form>
			<form id="oppTab">
			<center><legend>Liste over oppgaver</legend></center><br>
			<table>
     <thead>
    <tr><th class='tab2'>Veileder</th>
        <th class='tab2'>Tittel</th>
        <th class='tab2'>Dato endret</th>
        <th class='tab2'>Link</th>
        <th class='tab2'>Vanskelighetsgrad</th>
        <th>
        <select id="oppgaver" name='oppgaver'>
            <option name="gittoppg"     value='gittoppg'   selected='selected'>Alle oppgaver</option>
            <option name="besvartoppg" value='besvartoppg'>Besvarte oppgaver</option>
        </select>
        </th>
    </tr>
    </thead>
    <?php
    $result = $db->query("SELECT * FROM oppgaver") ;
    while ($row = $result->fetch_assoc()) {
    $PK = $row['oppgavePK'];
    $vPK = $row['veileder'];
  	$veileder = finnVeileder($vPK);
  	if ($row['vanskelighetsgrad'] === "3") {$vanskelighetsgrad = "Vanskelig"; }
    if ($row['vanskelighetsgrad'] === "2") {$vanskelighetsgrad = "Medium"; }
    if ($row['vanskelighetsgrad'] === "1") {$vanskelighetsgrad = "Lett";}

    echo "<form action='#' method='post' id='multiform'".$PK.">";
    echo "<tr>";
    echo "<td id='veileder".$PK."'      	 name='veileder'       		>"	. $veileder.		      "</td>";
    echo "<td id='tittel".$PK."'        	 name='tittel'   	  		>"  . $row['tittelOppgave'].	  "</td>";
    echo "<td id='datoendret".$PK."'    	 name='datoendret'     		>"	. $row['datoEndret'].		  "</td>";
    echo "<td id='link".$PK."'    			 name='link'     	  		>"	. $row['linkVedlegg'].		  "</td>";
    echo "<td id='vanskelighetsgrad".$PK."'  name='vanskelighetsgrad'   >"   . $vanskelighetsgrad. "</td>";
    echo "<input type='hidden' name='brukerPK' value=$PK></td>";
      
        echo "<td><input type='image' src='img/edit.jpg' name='edit' id=$PK />"; //Knapp for å redigere brukerdata
        echo "<input type='hidden'  name='lagreupdate' />";
        echo "<input type='image' hidden src='img/save.jpg' name='update' id='s".$PK."' />"; //Knapp for å lagre endringer

        echo "<input type='hidden' name='slett' value='$row[oppgavePK]' />"; //Knapp for å slette brukere
        echo "<input type='image' id='d".$PK."' src='img/delete.jpg' name='formDelete' />"; 
 		echo "</td></tr></form>";
    
    }
    echo "</tbody></table></div>"; 
?>
        </form><tbody id='liste'></table>
		</section>
	    		<?php include('design/footer.php'); ?>
       	</div>
	</body>
</html>

