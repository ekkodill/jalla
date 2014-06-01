<!--Denne siden er utviklet av Kurt A. Amodt og Dag-Roger Eriksen., siste gang endret 02.03.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 29.05.2014  !-->

<header>
<div class="sitetitle"><a href="default.php"><img src="img/logotm.png" ></a></div>
        <?php   if(logged_in() === false) {include 'includes/loginbox.php';} ?>
        <?php   if(logged_in() === true) {include 'design/nav.php';} ?>     
</header>
<div style="clear: both; height: 40px;"></div>
