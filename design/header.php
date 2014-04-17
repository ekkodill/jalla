<!--Denne siden er utviklet av Kurt A. Amodt og Dag-Roger Eriksen., siste gang endret 02.03.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 30.03.2014  !-->

<header>
		<?php if(logged_in() === true) { echo "<h3 class='loggetInnSom'><a href='minside.php'>".$user_data['fornavn'] ." ". $user_data['etternavn']."</a><a href='brukerforside.php'>(".ubesvarteOppg($user_data['brukerPK'],3)->num_rows.")</a></h3>"; } ?> 
        <a href="default.php"><h1 class="header">Touch - Utviklingsoppgave 2014</h1></a>
        <?php   if(logged_in() === true) {include 'design/nav.php';} ?>  
</header>


<!--Til Dr.E. Viser antall ubesvarte oppgaver for den innloggde brukeren
 <li><a href='brukerforside.php'>Du har ".ubesvarteOppg($user_data['brukerPK'])->num_rows."ubesvarte oppgaver</a></li>
 !-->