<?php
//Denne siden er utviklet av Kurt A. Aamodt og Erik Bjørnflaten, siste gang endret 30.03.2014
//Denne siden er kontrollert av Mikael Kolstad siste gang 30.03.2014 

include 'includes/init.php';
$db = getDB();


//Registrerer nye opgpaver til databasen
if(!empty($_POST['publiser'])) {
		$tittel 	= sanitize(trim($_POST['tittel']));
		$oppg 		= sanitize(trim($_POST['oppg']));
		$vansklighetsgrad = trim($_POST['vansklighetsgrad']);
		$veileder   = $user_data['brukerPK'];
		$erPublisert = 1;
			
		if(!empty($tittel) && !empty($oppg))  {
				$insert = $db->prepare("INSERT INTO oppgaver (veileder, tittelOppgave, tekstOppgave, datoEndret, erPublisert, vanskelighetsgrad) VALUES (?,?,?,now(),?,?)");
				$insert->bind_param('sssii', $veileder, $tittel, $oppg, $erPublisert, $vansklighetsgrad);
		
				if($insert->execute()) {
					header('Location: oppgave.php');
					die();
				}
		} 
}

 ?>


<!DOCTYPE html>
<html lang="nb-no">
		<?php
		$pgName = 'Oppgaver';
		include('design/head.php');

		//Sjekker valget for listetype. (Alle oppgaver, eller bare besvarte oppgaver)
 		if (isset($_POST['oppgaver'])) { 
 			if($_POST['oppgaver']=='gittoppg') {
 				$tekst = 'Liste over oppgaver';
 			}
 		    if($_POST['oppgaver']=='besvartoppg') {
				$tekst = 'Liste over besvarte oppgaver';
			}
		}
		if (!isset($_POST['oppgaver'])) {
				$tekst = "Liste over oppgaver";
		} 
		?>



	<body onunload="unloadP('oppgave')" onload="loadP('oppgave')"> 
		<?php
			include('design/header.php');
			?>
		<div id="page">
			
		    <section>
				<center><legend><h4>Lag ny oppgave</h4></legend></center>
				<form action="oppgave.php" id="nyoppgfrm"  method="post" >
					<input type="text" id="oppgtitt" placeholder="Skriv inn tittelen" name="tittel"><br><br>
					<h5><label>Vanskelighetsgrad:</label> 
					<input type="radio" value="3" name="vansklighetsgrad">Vanskelig
					<input type="radio" value="2" name="vansklighetsgrad">Medium
					<input type="radio" value="1" name="vansklighetsgrad">Lett</h5>
					<textarea id="oppgtext" placeholder="Skriv inn oppgaven" name="oppg"></textarea><br>
					<input type="submit" id="publiserKnapp" name="publiser" value="Publiser" onclick="return regNyoppg();">
			    </form>			
				<?php if(!count(sjekkAntall('oppgaver'))) {
							echo "<center><legend>Ingen registrerte oppgaver</legend></center>"; 
					   } else { ?>
				<br><br>
			<center><legend><h4><?php echo $tekst ?></h4></legend><br>
				<form action="oppgave.php" id="endreli" method="post">
		    		<select name='oppgaver' onchange="this.form.submit();">
			            <option name="gittoppg"     value='gittoppg'   <?php if (isset($_POST['oppgaver'])) { if($_POST['oppgaver']=='gittoppg')  {echo "selected='selected'"; }} ?>>Alle oppgaver</option>
			            <option name="besvartoppg" value='besvartoppg' <?php if(isset($_POST['oppgaver']))  { if($_POST['oppgaver'] =='besvartoppg') {echo "selected='selected'"; }} ?>>Besvarte oppgaver</option>
			        </select></center><br>
			      </form>	
				</center><br>
	

<?php 	//Inkluderer riktig liste i forhold til valget på nedtrekksmenyen
		if(isset($_POST['oppgaver'])) {
			if($_POST['oppgaver'] == 'gittoppg') {
				include('oppgaveliste.php');
			} elseif($_POST['oppgaver'] == 'besvartoppg') {
				include('besvartliste.php');
			}
		} else { include('oppgaveliste.php'); }
} ?>
		</section>
	    	<?php include('design/footer.php'); ?>
       	</div>
	</body>
</html>


