<?php
//Denne siden er utviklet av Kurt A. Aamodt (PHP) og Erik Bjørnflaten (HTML), Mikael Kolstad (JS), siste gang endret 19.04.2014.
//Denne siden er kontrollert av Dag-Roger Eriksen siste gang 04.05.2014.

include 'includes/init.php';
protected_page();
accessrestriction($user_data['brukertype']);
$db = getDB();


//Setter verdier fra en valgt ikke publisert oppgave til variabler som blir brukt i behandlingen av oppgaven
if(!empty($_POST['publish'])) {
    $_SESSION['oldopgPK'] = $_POST['oppgPK'];
    $oppgtittel = $_POST['oppgTittle'];
    $oppgtext = $_POST['oppgText'];
    $oppgvansklighetsgrad = $_POST['vanskelighetsgrad'];
}


$veileder   = $user_data['brukerPK'];
//Registrerer nye opgpaver til databasen
if(isset($_POST['lagre']) && isset($_POST['mailpub'])) {
		$errors[] = "Du kan ikke sende mail om publisering når du skal lagre";
	} else {
	if(!empty($_POST['publiser']) || !empty($_POST['lagre']) ) {

		if(empty($_POST['tittel'])) {
	 		 $errors[] = "Du må skrive inn tittel";
	 	} else {
	 		$tittel 	= sanitize(trim($_POST['tittel']));
		 	if(empty($_POST['oppg'])) {
		 		$errors[] = "Du må skrive inn oppgavetekst";
		 	} else {
		 		$oppg 		= trim($_POST['oppg']);
			 	if (empty($_POST['vansklighetsgrad'])) {
			 		$errors[] = "Du må velge vansklighetsgrad";
			 	} else { $vansklighetsgrad = trim($_POST['vansklighetsgrad']); }
			}
		}	

			if(isset( $_SESSION['oldopgPK'])) {
				$pubPK =  $_SESSION['oldopgPK'];
				$oppgsjekk = hentOppgave($pubPK); //Sjekker om oppgaven finnes i databasen fra før
			} else {
				$pubPK = "";
			}
			
			$erPublisert = 1;
			$melding = "publisert";
			if(isset($_POST['lagre'])) {
					$erPublisert = 0;
					$melding = "lagret";
			}
			
				if(!empty($oppgsjekk)) {
					if(updateOppg($veileder, $tittel, $oppg, $erPublisert, $vansklighetsgrad, $pubPK)){ //Oppdaterer databasen med ny informasjon
						header("Location: oppgave.php?".$melding);
					}
				} else {
						if(addOppg($veileder, $tittel, $oppg, $erPublisert, $vansklighetsgrad)) { //Lagrer oppgaven i databasen
							if(isset($_POST['mailpub'])) {
								publishMail($tittel); //Sender mail til alle deltakere
							}
								Header('Location: oppgave.php?'.$melding);
								die();
						} else { 
							$errors[] = "En feil oppstod: kunne ikke lagre oppgaven i databasen";
						} 
				}  
	}
}



//Setter verdien i nedtrekksmenyen til SESSION variabelen så den holder seg på riktig valg selv om man laster siden på nytt
 if(!empty($_POST['oppgaver'])) {
         $_SESSION['oppgave_select'] = $_POST['oppgaver'];
     } else {
     	if(isset($_SESSION['oppgave_select'])) {
     	 $_SESSION['oppgave_select'] =  $_SESSION['oppgave_select'];
     	} else {
     		$_SESSION['oppgave_select'] = 'gittoppg';
     	}
     }

     //Sjekker valget for listetype. (Alle oppgaver, eller bare besvarte oppgaver) og setter headingen deretter
 		if (isset($_SESSION['oppgave_select'])) { 
 			if($_SESSION['oppgave_select']=='gittoppg') {
 				$tekst = 'Liste over oppgaver';
 			}
 		    if($_SESSION['oppgave_select']=='besvartoppg') {
				$tekst = 'Liste over besvarte oppgaver';
			} 
		} else { 
				$tekst = 'Liste over oppgaver';
		  }



 ?>

 <!--*******************************************************************************************************************************************-->
<!--**********Denne siden er for veiledere\admins til å lager oppgaver \ vise oppgavelister og lister med besvarelser uten respons******-->
<!--*******************************************************************************************************************************************-->

<!DOCTYPE html>
<html lang="nb-no">
		<?php
		$pgName = 'Oppgaver';
		include('design/head.php');

		?>
	<body onunload="unloadP('oppgave')" onload="loadP('oppgave')" id="oppgave"> 
		<?php include('design/header.php');	?>
		<div id="page">
		    <section>
		    <!--Elementer for å lage nye oppgaver-->
		    <div class="oppgform">
				<legend><h4>Lag ny oppgave</h4></legend>
				<form action="oppgave.php" id="nyoppgfrm"  method="post" >
					<input class="stored" name="tittel" type="text" id="oppgtitt" placeholder="Skriv inn tittelen" value=<?php if(!empty($oppgtittel)) { echo $oppgtittel; }?>><br><br>
					<h5><label>Vanskelighetsgrad:</label> 
					<input class="stored" type="radio" value="3" name="vansklighetsgrad" <?php if(!empty($oppgvansklighetsgrad)) { if($oppgvansklighetsgrad == 3) { echo 'checked'; }}?>>Vanskelig
					<input class="stored" type="radio" value="2" name="vansklighetsgrad" <?php if(!empty($oppgvansklighetsgrad)) { if($oppgvansklighetsgrad == 2) { echo 'checked'; }}?>>Medium
					<input class="stored" type="radio" value="1" name="vansklighetsgrad" <?php if(!empty($oppgvansklighetsgrad)) { if($oppgvansklighetsgrad == 1) { echo 'checked'; }}?>>Lett</h5>
					<textarea class="stored" name="oppg" id="oppgtext" placeholder="Skriv inn oppgaven" style="height:20%; width:60%"><?php if(!empty($oppgtext)) { echo $oppgtext; }?></textarea><br>
					
					<input type="submit" class="buttonStyle" name="publiser" value="Publiser" onclick="return regNyoppg();" >
					<input type="submit" class="buttonStyle" name="lagre" value="Lagre" onclick="return regNyoppg();">
					<input type="checkbox" name="mailpub">Send mail om denne publiseringen
					</div>
		    	</form>
		    	
				<?php

				//Skriver ut statusmeldinger for nye oppgaver som blir opprettet eller responser som blir lagret
				if(isset($_GET['lagretrespons'])) {
					echo "Responsen ble lagret";
				} elseif(isset($_GET['nosaveerror'])) {
					echo "Kunne ikke lagre respons";
				} elseif(isset($_GET['tomerror'])) {
					echo "Kan ikke lagre tom respons";
				}
				if(isset($_GET['publisert']) === true) {
					echo "<p>Oppgaven ble publisert</p>"; 
				} elseif(isset($_GET['lagret']) === true) {
					echo "<p>Oppgaven ble lagret</p>"; 
				}
				//Skriver ut errors som oppstår når man gjør feil ved oppretting av nye oppgaver
				if (empty($errors) === false) {
								echo output_errors($errors);
							}
							if(!count(sjekkAntall('oppgaver'))) {
							echo "<center><legend>Ingen registrerte oppgaver</legend></center>"; 
					   } else { ?>
				<br><br>
				<!--Nedtrekksmeny for å velge lite som skal vises-->
			<center><legend><h4  id="endrelitit"><?php echo $tekst ?></h4></legend><br>
				<form action="oppgave.php" id="endreli" method="POST">
		    		<select name='oppgaver' class="dropned" onchange="this.form.submit();">
			            <option name="gittoppg"     value='gittoppg'   <?php if($_SESSION['oppgave_select']=='gittoppg') {echo 'selected'; } ?>>Alle oppgaver</option>
			            <option name="besvartoppg" value='besvartoppg' <?php if($_SESSION['oppgave_select'] =='besvartoppg') {echo 'selected'; } ?>>Besvarte oppgaver</option>
			        </select>
			    </form>	
			 </center>
<?php 	//Inkluderer riktig liste i forhold til valget på nedtrekksmenyen (ren oppgaveliste eller besvarelser)
		if(isset($_SESSION['oppgave_select'])) {
			if($_SESSION['oppgave_select'] == 'gittoppg') {
				include('oppgaveliste.php');
			} elseif($_SESSION['oppgave_select'] == 'besvartoppg') {
				include('besvartliste.php');
			}
		} else { include('oppgaveliste.php'); }
} ?>		  

			<script type="text/javascript">
				//Fyller feltene med data fra localStorage om det er noe der når siden lastes
				//Koden er hentet fra internett, url: http://www.thomashardy.me.uk/using-html5-localstorage-on-a-form
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
	    		<br class="clear" />
	    	</section>
		</div>
		<?php include('design/footer.php'); ?>
	</body>
</html>





