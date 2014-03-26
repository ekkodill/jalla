<!--Denne siden er utviklet av Kurt A. Amodt., siste gang endret 02.03.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 26.03.2014  !-->

 		<nav>
            <ul>
                <li class="topmeny"><a href="default.php">Fremsiden</a></li>
                <li  class="topmeny"><a href="vis_brukere.php">Brukere</a></li>
                <li  class="topmeny"><a href="skriv.php">Tastatur</a></li>
                <li  class="topmeny"><a href="minside.php">Min side</a></li>
                <li  class="topmeny"><a href="oppgave.php">Ny oppgave</a></li>
                <div class="moveup">Innlogget:<span class="loggetInnSom"><?php echo $user_data['etternavn'];?></span></div>
            </ul>
        </nav>       
<div class="bmenyhead">
<button class="bmenyknapp" onclick="location.href='logout.php'">Logg ut</button>
<button class="bmenyknapp" onclick="location.href='minside.php'">Bytt passord</button>
</div>


