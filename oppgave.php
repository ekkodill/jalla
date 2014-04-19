<?php
//Denne siden er utviklet av Kurt A. Aamodt (PHP) og Erik Bjørnflaten (HTML), siste gang endret 19.04.2014
//Denne siden er kontrollert av Mikael Kolstad siste gang 28.04.2014 

include 'includes/init.php';
$db = getDB();


//Registrerer nye opgpaver til databasen
if(!empty($_POST)) {

	if(empty($_POST['tittel'])) {
 		 $errors[] = "Du må skrive inn tittel";
 	} else {
 		$tittel 	= sanitize(trim($_POST['tittel']));
	 	if(empty($_POST['oppg'])) {
	 		$errors[] = "Du må skrive inn oppgavetekst";
	 	} else {
	 		$oppg 		= sanitize(trim($_POST['oppg']));
		 	if (empty($_POST['vansklighetsgrad'])) {
		 		$errors[] = "Du må velge vansklighetsgrad";
		 	} else { $vansklighetsgrad = trim($_POST['vansklighetsgrad']); }
		}
	}
	$veileder   = $user_data['brukerPK'];
	$erPublisert = 1;
		if(isset($_POST['lagre'])) {
				$erPublisert = 0;
		}
 		
		if(!empty($tittel) && !empty($oppg) && !empty($vansklighetsgrad))  {
				$insert = $db->prepare("INSERT INTO oppgaver (veileder, tittelOppgave, tekstOppgave, datoEndret, erPublisert, vanskelighetsgrad) VALUES (?,?,?,now(),?,?)");
				$insert->bind_param('sssii', $veileder, $tittel, $oppg, $erPublisert, $vansklighetsgrad);
		
				if($insert->execute()) {				
					if($erPublisert == 1) {
						$errors[] = "Oppgaven ble publisert";
					} else {
						$errors[] = "Oppgaven ble lagret";
					}
			?>
				<script>$('#nyoppgfrm').submit(function());</script>
			<?php 
					header('Location: oppgave.php');
					die();
				} else { $errors[] = "En feil oppstod: kunne ikke lagre oppgaven i databasen";} 
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
					<input class="stored" name="tittel" type="text" id="oppgtitt" placeholder="Skriv inn tittelen" ><br><br>
					<h5><label>Vanskelighetsgrad:</label> 
					<input class="stored" type="radio" value="3" name="vansklighetsgrad">Vanskelig
					<input class="stored" type="radio" value="2" name="vansklighetsgrad">Medium
					<input class="stored" type="radio" value="1" name="vansklighetsgrad">Lett</h5>
					<textarea class="stored" name="oppg" id="oppgtext" placeholder="Skriv inn oppgaven" ></textarea><br>
					<input type="submit" id="publiserKnapp" name="publiser" value="Publiser" >
					<input type="submit" id="lagreKnapp" name="lagre" value="Lagre">
			    </form>
				<?php	if (empty($errors) === false) {
								echo output_errors($errors);
							}
							if(!count(sjekkAntall('oppgaver'))) {
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
<script type="text/javascript">



//Fyller feltene med data fra localStorage om det er noe der når siden lastes
$(document).ready(function () {
    function init() {
        if (localStorage["tittel"]) {
            $('#oppgtitt').val(localStorage["tittel"]);
        }
        if (localStorage["oppg"]) {
            $('#oppgtext').val(localStorage["oppg"]);
        }
   }
init();
});

//Setter riktig valg på radioknappen i forhold til hva som er i localstorage
$('input[type=radio]').each(function() {
  		var key = $(this).attr('name');
  		var val = localStorage[key];
 	 if ( $(this).attr('name') == key && $(this).attr('value') == val ) {
    		$(this).attr('checked', 'checked');
  	}	
	});


//Lagrer feltenes innhold til localstorage
$('.stored').change(function () {
    localStorage[$(this).attr('name')] = $(this).val();
});

		//Resetter feltene når formen blir sendt uten problemer
		$('#nyoppgfrm').submit(function() {
			localStorage.clear();
		});
		
	

</script>
	</body>
</html>





