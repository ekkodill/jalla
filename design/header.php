<!--Denne siden er utviklet av Kurt A. Amodt og Dag-Roger Eriksen., siste gang endret 02.03.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 30.03.2014  !-->
<a href="default.php">
<header>
<div class="sitetitle"><img src="img/logotm.png"> </div>
        <a href="default.php"></a>
        <?php   if(logged_in() === false) {include 'includes/loginbox.php';} ?>
        <?php   if(logged_in() === true) {include 'design/nav.php';} ?>     
</header>
</a>