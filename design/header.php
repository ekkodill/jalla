<!--Denne siden er utviklet av Kurt A. Amodt og Dag-Roger Eriksen., siste gang endret 02.03.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 26.03.2014  !-->

<header>
		<?php if(logged_in() === true) { echo "<a href='minside.php'><h3 class='loggetInnSom'>".$user_data['fornavn'] ." ". $user_data['etternavn']."</h3></a>"; } ?> 
        <a href="default.php"><h1 class="header">Touch - Utviklingsoppgave 2014</h1></a>
        <?php   if(logged_in() === true) {include 'design/nav.php';} ?>  
</header>