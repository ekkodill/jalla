<!--Denne siden er utviklet av Kurt A. Amodt(php) og Dag-Roger Eriksen(html\css),. siste gang endret 23.05.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 29.05.2014  !-->
<?php 
include_once 'mail.php'; //Inkluderer modal vinduene for epost sending
 ?>

 <nav>
 	<?php if(logged_in() === true) { echo "<div class='loggetInnSom'><a href='profil.php'>".$user_data['fornavn'] ." ". $user_data['etternavn']."</a></div>"; 
 	}
 	//Viser epost innstillinger og epost ikon i menyen for veiledere og administrator
 	if($user_data['brukertype'] != 3) {
 		echo "<a style='float:left;margin-right:20px;' href='#settings'><img src='img/settings.png' alt='Epost innstillinger' title='Epost innstillinger'></a>
 		<a style='width: 32px;float:left;' href='#sendmail'><img src='img/mail.png' alt='Send epost' title='Send epost'></a><br>";
 		echo "<br><a href='oppgave.php' id='nav-oppgave'>Oppgaver</a>"; 	 
 		}
 	if($user_data['brukertype'] != 2 && $user_data['brukertype'] != 1) {
 		echo "<a href='minside.php' id='nav-minside'>Min side</a>"; //Viser "minside" for deltakere i menyen
 	}
 		 ?>
 		
        <a href="vis_brukere.php" id="nav-medlemmer">Medlemsliste</a>
		<a href="skriv.php" id="nav-skriv">Skrivesenter</a>
        <a href="profil.php" id="nav-profil">Min Profil</a><br>
       <div class="skille"> <div class="knappHoyre"><a href="logout.php">Logg ut</a></div>
        </div>
    </ul>
</nav> 





