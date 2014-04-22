<?php
//Denne siden er utviklet av Kurt A. Aamodt (PHP) og Erik Bjørnflaten (HTML), siste gang endret 19.04.2014
//Denne siden er kontrollert av Mikael Kolstad siste gang 28.04.2014 

include 'includes/init.php';
$db = getDB();


//Publiserer oppgaver som er lagret fra før
if(!empty($_POST['publish'])) {
    $publisert = 1;
    $pubPK = $_POST['oppgPK'];
        $stmt = $db->prepare("UPDATE oppgaver SET erPublisert=? WHERE oppgavePK=? LIMIT 1");
        $stmt->bind_param('ii', $publisert, $pubPK);
        $stmt->execute();
        header('Location: oppgave.php?publisert');
}

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
		$veileder   = $user_data['brukerPK'];
		$erPublisert = 1;
		$melding = "publisert";
		if(isset($_POST['lagre'])) {
				$erPublisert = 0;
				$melding = "lagret";
		}
					if(addOppg($veileder, $tittel, $oppg, $erPublisert, $vansklighetsgrad)) {
						if(isset($_POST['mailpub'])) {
							publishMail($tittel); //Sender mail til alle deltakere
						}
						
					Header('Location: oppgave.php?'.$melding);
					die();
				} else { $errors[] = "En feil oppstod: kunne ikke lagre oppgaven i databasen";} 
		}  
	}

 if(!empty($_POST['oppgaver'])) {
         $_SESSION['oppgave_select'] = $_POST['oppgaver'];
     } else {
     	 $_SESSION['oppgave_select'] =  $_SESSION['oppgave_select'];
     }

 ?>


<!DOCTYPE html>
<html lang="nb-no">
		<?php
		$pgName = 'Oppgaver';
		include('design/head.php');
		//Sjekker valget for listetype. (Alle oppgaver, eller bare besvarte oppgaver)
 		if (isset($_SESSION['oppgave_select'])) { 
 			if($_SESSION['oppgave_select']=='gittoppg') {
 				$tekst = 'Liste over oppgaver';
 			}
 		    if($_SESSION['oppgave_select']=='besvartoppg') {
				$tekst = 'Liste over besvarte oppgaver';
			}
		}
		if (!isset($_SESSION['oppgave_select'])) {
				$tekst = $_SESSION['oppgave_select']; //TODO ENDRE TILBAKE
		} 
		?>
	<body onunload="unloadP('oppgave')" onload="loadP('oppgave')"> 
		<?php include('design/header.php');	?>

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
					<input type="submit" id="publiserKnapp" name="publiser" value="Publiser" onclick="return regNyoppg();" >
					<input type="submit" id="lagreKnapp" name="lagre" value="Lagre" onclick="return regNyoppg();">
					<input type="checkbox" name="mailpub">Send mail om denne publiseringen
			    </form>
				<?php

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
				if (empty($errors) === false) {
								echo output_errors($errors);
							}
							if(!count(sjekkAntall('oppgaver'))) {
							echo "<center><legend>Ingen registrerte oppgaver</legend></center>"; 
					   } else { ?>
				<br><br>
			<center><legend><h4  id="endrelitit"><?php echo $tekst ?></h4></legend><br>
				<form action="oppgave.php" id="endreli" method="POST">
		    		<select name='oppgaver' onchange="this.form.submit();">
			            <option name="gittoppg"     value='gittoppg'   <?php if($_SESSION['oppgave_select']=='gittoppg') {echo 'selected'; } ?>>Alle oppgaver</option>
			            <option name="besvartoppg" value='besvartoppg' <?php if($_SESSION['oppgave_select'] =='besvartoppg') {echo 'selected'; } ?>>Besvarte oppgaver</option>
			        </select></center><br>
			      </form>	
				</center><br>

<?php 	//Inkluderer riktig liste i forhold til valget på nedtrekksmenyen
		if(isset($_SESSION['oppgave_select'])) {
			if($_SESSION['oppgave_select'] == 'gittoppg') {
				include('oppgaveliste.php');
			} elseif($_SESSION['oppgave_select'] == 'besvartoppg') {
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





