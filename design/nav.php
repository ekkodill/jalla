<!--Denne siden er utviklet av Kurt A. Amodt og Dag-Roger Eriksen,. siste gang endret 02.03.2014
Denne siden er kontrollert av Dag-Roger Eriksen siste gang 26.03.2014  !-->

 <nav>
     <ul>
        <li><a href="default.php">Fremsiden</a></li>
        <li><a href="vis_brukere.php">Brukere</a></li>
		<li><a href="skriv.php">Tastatur</a></li>
        <li><a href="minside.php">Min side</a></li>
       <?php if($user_data['brukertype'] != 3) { echo "<li><a href='oppgave.php'>Ny oppgave</a></li>"; } ?>
        <li class="knappHoyre"><a href="logout.php">Logg ut</a></li>
        <li class="knappHoyre"><a href="minside.php">Bytt passord</a></li>
    </ul>
</nav>       



