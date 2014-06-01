<!--Denne siden er utviklet av Kurt A. Aamodt, siste gang endret 14.05.2014
Denne siden er kontrollert av Mikael Kolstad siste gang 31.05.2014-->   
<?php include_once 'includes/init.php';
protected_page();
$db = getDB();

$bPK = $user_data['brukerPK'];

//Setter riktig tittel i forhold til hvilken liste brukeren viser med besvarelser
if(empty($_POST['besvarform'])) {
  $listeBeskrivelse = "Besvarte oppgaver med respons";  
} else {
  $listeBeskrivelse = "Besvarte oppgaver uten respons";
}
?>
<!--
***********************************************************************************************************************************************************************/
**************Dette er "startsiden" for deltakere. Denne siden viser liste over besvarte oppgaver og liste med oppgaver som er påbegynt eller nye oppgaver*************/
*************************************************************************************************************************************************************************/
 -->   

<!DOCTYPE html>
<html>
    <?php 
    $pgName = 'Min side';
    include 'design/head.php'; ?>
    <style type="text/css">
/*Justeringer for ubesvart oppgliste*/    
.msoppli {
	overflow: auto;
	height:75%;
	padding-bottom: 80px ;
}
    </style>
    <body onunload="unloadP('minside')" onload="loadP('minside')" id="sidenmin">
    <?php include 'design/header.php'; ?>
    <script type="text/javascript">

    //Viser oppgavelisten og skjuler besvartlisten etter man har endra valg på nedtrekksmenyen for valg av oppgaveliste. Setter også riktig fokus på knappene.
    $(document).ready(function() {
    		<?php 
    			if(isset($_POST['minsideoppgli'])) {
    				if($_POST['minsideoppgli'] == 'ubesvoppg' || $_POST['minsideoppgli'] == 'pbegoppg') {
				$oppg = 'block'; 
				$bliste = 'none';
				}  else { 
					$oppg = 'none'; 
					$bliste = 'block'; 
				}
			} else {
					$oppg = 'none'; 
					$bliste = 'block'; 
			}
			if($oppg == 'block') {
			?>
			document.getElementById('hideshowoppg').focus();
			<?php 
			} else {
			?>
			document.getElementById('hideshowbesvart').focus();
			<?php 
			}
			?>
			document.getElementById('oppgaveliste').style.display = "<?php echo $oppg; ?>"; 
			document.getElementById('besvartoppgliste').style.display = "<?php echo $bliste;?>";
 	});


    </script>    
        <section>  
        <!--Knapper for å velge hvilken liste man vil se-->     
		<input type='button' id='hideshowbesvart' value='Liste over besvarte oppgaver'><input type='button' id='hideshowoppg' value='Oppgaveliste'>
			<!--Div med liste for besvarte oppgaver -->  
			<div  id="besvartoppgliste" > 
	          <?php 
	            if(!count(sjekkAntall("innleveringer WHERE ferdig = 1 AND bruker =".$bPK))) {
	                echo "<legend>Ingen registrerte besvarelser</legend>"; 
	            } else { 
	              
	                ?>
	          <h3><?php echo $listeBeskrivelse ?></h3>
	          <form method="POST" action="">
	            <input type="checkbox" name="besvarform" onchange="this.form.submit();" <?php if(isset($_POST['besvarform'])) echo "checked='checked'"; ?>>Vis besvarelser uten respons
	          </form>
	            <?php 
		            //Viser tabellliste med besvarelser med eller uten respons dersom det er noen, ellers skrives beskjed om at det ikke finnes
		            if(isset($_POST['besvarform'])) {
						if(!count(sjekkAntall("innleveringer
	        								JOIN oppgaver ON innleveringer.oppgave = oppgaver.oppgavePK AND innleveringer.bruker = $bPK AND innleveringer.ferdig = 1
	        								LEFT JOIN respons ON (innleveringer.innleveringPK = respons.innlevering) WHERE respons.innlevering is NULL"))) {
		              						echo "<legend>Ingen registrerte besvarelser uten respons</legend>"; 
		              			} else {
		                  			$result = ubesvarteOppg($bPK, 1);
		                  			include_once("besvart.php");  
		              			}   
		    		} else {
		              		if(!count(sjekkAntall("innleveringer
	        								JOIN oppgaver ON innleveringer.oppgave = oppgaver.oppgavePK AND innleveringer.bruker = $bPK AND innleveringer.ferdig = 1
	        								LEFT JOIN respons ON (innleveringer.innleveringPK = respons.innlevering) WHERE respons.innlevering is NOT NULL"))) {
		              						echo "<legend>Ingen registrerte besvarelser med respons</legend>"; 
		              			} else {
		                  			$result = ubesvarteOppg($bPK, 2);
		                  			include_once("besvart.php");  
		              			}
		              }  
	            } 
	              
	              ?>
			</div><!--Slutt på div for besvartoppggliste -->
				<!--Div for liste med ubesvarte oppgaver -->   
				<div id='oppgaveliste'  style="display:none;height:100%">   
				<h3>Oppgaveliste med ubesvarte oppgaver</h3>	
			 	<?php 
		          	  //Sjekker at brukertypen er deltaker og om deltakeren har ubesvarte oppgaver
			          if(count(sjekkAntall("oppgaver 
			            LEFT JOIN innleveringer ON (oppgaver.oppgavePK =innleveringer.oppgave AND innleveringer.bruker = $bPK) WHERE innleveringer.oppgave IS NULL OR innleveringer.ferdig = 0"))) { ?>
			           <!--Nedtrekksmeny for å bytte mellom de forskjellige oppgavelistene på brukerens profil !-->
			           <form action="minside.php" method="post">
			              <select class="dropned" name='minsideoppgli' onchange="this.form.submit();visoppg();">
			                  <option name="ubesvoppg" value='ubesvoppg' <?php if(isset($_POST['minsideoppgli'])) { if($_POST['minsideoppgli'] == 'ubesvoppg') {echo "selected";}}?>>Ubesvarte oppgaver</option>
			                  <option name="pbegoppg" value='pbegoppg' <?php if(isset($_POST['minsideoppgli'])) { if($_POST['minsideoppgli'] == 'pbegoppg') {echo "selected";}}?>>Påbegynte oppgaver</option>
			              </select></center><br>
			            </form>
			    <?php } 

			 //Setter paramterene for riktig liste som skal vises basert på valget i nedtrekksmenyen, og viser oppgavelisten             
			            if(!empty($_POST['minsideoppgli'])) {
			                if($_POST['minsideoppgli'] == 'ubesvoppg') {
			                  $result = ubesvarteOppg($bPK, 3);
			                } elseif( $_POST['minsideoppgli'] =='pbegoppg') {
			                  $result = ubesvarteOppg($bPK, 0);
			                } 
			            } else {
			                    $result = ubesvarteOppg($bPK, 3);
			                }

			              if(!count(sjekkAntall("oppgaver 
			                                 LEFT JOIN innleveringer ON (oppgaver.oppgavePK =innleveringer.oppgave AND innleveringer.bruker = $bPK) 
			                                 WHERE innleveringer.oppgave IS NULL OR innleveringer.ferdig = 0"))) {
			              	echo "<legend>Ingen registrerte oppgaver</legend>";
			                    
			              }
			              if($_POST['minsideoppgli'] == 'pbegoppg'  && !count(sjekkAntall("innleveringer WHERE innleveringer.bruker = $bPK AND innleveringer.ferdig = 0"))) {
			              	echo "<legend>Ingen påbegynte oppgaver</legend>";
			             } 
			             else {
			               	echo  " <div class='msoppli'><table ><tbody>";
			                include_once("ubesvartliste.php");
			                echo "</tbody></table><div>";
			              } ?>
					</div><!--Slutt på div for oppgaveliste -->  
				<br class="clear" />
			</section>
 <script type="text/javascript">
	var button = document.getElementById('hideshowoppg'); //Knapp for å skjule oppgaveliste\vise besvartliste 
	var button2 = document.getElementById('hideshowbesvart'); //Knapp for å skjule besvartliste\vise oppgaveliste


	//Brukes for å skjule besvartlisten og viser oppgavelisten, også når man bytter liste fra nedtrekksmenyen for oppgaver
	function visoppg() {
			document.getElementById('oppgaveliste').style.display = 'block';    
			document.getElementById('besvartoppgliste').style.display = 'none';
		}

		//Viser oppgavelisten og skjuler besvartlisten når man trykker på knappen for å velge oppgavelisten
		button.onclick = function() {
			 visoppg();
		};

		//Viser besvartlisten og skjuler oppgavelisten når man trykker på knappen for å velge besvartlisten
		button2.onclick = function() {
			  document.getElementById('oppgaveliste').style.display = 'none';    
			   document.getElementById('besvartoppgliste').style.display = 'block';
		};
</script>
        <?php include('design/footer.php'); ?>
    </body>
</html>

