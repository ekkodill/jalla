<?php
include 'includes/init.php';
$db = getDB();




//Registrerer nye opgpaver til databasen
if(!empty($_POST['publiser'])) {
		$tittel 	= trim($_POST['tittel']);
		$oppg 		= trim($_POST['oppg']);
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
<script type="text/javascript">
	
	//code to refresh the page
var page_y = $( document ).scrollTop();
window.location.href = window.location.href + '?page_y=' + page_y;


//code to handle setting page offset on load
$(function() {
    if ( window.location.href.indexOf( 'page_y' ) != -1 ) {
        //gets the number from end of url
        var match = window.location.href.split['?'][1].match( /\d+$/ );
        var page_y = match[0];

        //sets the page offset 
        $( 'html, body' ).scrollTop( page_y );
    }
});
</script>

<!DOCTYPE html>
<html lang="nb-no">
		<?php
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
				$tekst = "Liste over oppgaver;";
		} 
		?>
	<body onload="doScroll()" onunload="window.name=document.body.scrollTop">
		<div id="page">
			<?php
			include('design/header.php');
			?>
		    <section style="width:94%">
				<center><legend>Lag ny oppgave</legend></center><br>
				<form action="oppgave.php" id="nyoppgfrm"  method="post" >
					<input type="text" id="oppgtitt" placeholder="Skriv inn tittelen" name="tittel"><br><br>
					<label>Vanskelighetsgrad:</label> 
					<br>
					<input type="radio" value="3" name="vansklighetsgrad">Vanskelig
					<input type="radio" value="2" name="vansklighetsgrad">Medium
					<input type="radio" value="1" name="vansklighetsgrad">Lett
					<textarea id="oppgtext" placeholder="Skriv inn oppgaven" name="oppg"></textarea><br>
					<input type="submit" name="publiser" value="Publiser" onclick="return regNyoppg();">
			    </form>			
				<?php if(!count(sjekkAntall('oppgaver'))) {
							echo "<center><legend>Ingen registrerte oppgaver</legend></center>"; 
					   } else { ?>
				<br><br>
			<center><legend><?php echo $tekst ?></legend><br>
				<form action="oppgave.php" id="endreli" method="post">
		    		<select name='oppgaver' onchange="this.form.submit();">
			            <option name="gittoppg"     value='gittoppg'   <?php if (isset($_POST['oppgaver'])) { if($_POST['oppgaver']=='gittoppg')  {echo "selected='selected'"; }} ?>>Alle oppgaver</option>
			            <option name="besvartoppg" value='besvartoppg' <?php if(isset($_POST['oppgaver']))  { if($_POST['oppgaver'] =='besvartoppg') {echo "selected='selected'"; }} ?>>Besvarte oppgaver</option>
			        </select></center><br>
			      </form>	
				</center><br>
	

<?php 	//Inkluderer riktig liste
		if(isset($_POST['oppgaver'])) {
			if($_POST['oppgaver'] == 'gittoppg') {
				include('oppgaveliste.php');
			} elseif($_POST['oppgaver'] == 'besvartoppg') {
				include('besvartliste.php');
			}
		} else { include('oppgaveliste.php'); }
} ?>


<script> //Søkescript for oppgavelisten, leter i første og andre kolonne (veileder og tittel).
$( document ).ready(function() {
	$("#search").keyup(function () {
	    var value = this.value.toLowerCase().trim();
	    $("table tr").each(function (index) {
	        if (!index) return;
	        $(this).find("td").each(function () {
	            var id = $(this).text().toLowerCase().trim();
	            var not_found = (id.indexOf(value) == -1);
	            $(this).closest('tr').toggle(!not_found);
	            return not_found;
	        });
	    });
	});
});
</script>
		</section>
	    	<?php include('design/footer.php'); ?>
       	</div>
	</body>
</html>


