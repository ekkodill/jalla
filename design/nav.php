<!--Denne siden er utviklet av Kurt A. Amodt og Dag-Roger Eriksen,. siste gang endret 02.03.2014
Denne siden er kontrollert av Dag-Roger Eriksen siste gang 26.03.2014  !-->

 <nav>
 	<?php if(logged_in() === true) { echo "<div class='loggetInnSom'><a href='minside.php'>".$user_data['fornavn'] ." ". $user_data['etternavn']."</a></div>"; } ?><br /> 
    
        <a href="default.php">Fremsiden</a>
        <a href="vis_brukere.php">Brukere</a>
		<a href="skriv.php">Tastatur</a>
        <a href="minside.php">Min side</a>
       <?php if($user_data['brukertype'] != 3) { echo "<a href='oppgave.php'>Ny oppgave</a>"; } ?><br />
       <div class="skille"> <div class="knappHoyre"><a href="logout.php">Logg ut</a></div>
        <div class="knappHoyre"><a href="minside.php">Bytt passord</a></div>
        </div>
    </ul>
</nav>       



