<?php include_once 'includes/init.php'; ?>
<!--Denne siden er utviklet av Kurt A. Aamodt, siste gang endret 03.03.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 29.05.2014  !-->

 <!--************************************************************************************************-->
 <!--Denne siden er for å stoppe brukere som ikke er innlogget i å få tilgang til sider de ikke skal-->
 <!--************************************************************************************************-->

<!doctype html>
<html>
    <?php 
	$pgName = 'Forbudt område';
    include 'design/head.php'; ?>
<body>
<?php include 'design/header.php'; ?>
<div id="page">
  <section style="height:100%;">
  	  <h3 style="margin-top:200px;">Beklager, du må være innlogget for å se denne siden.</h3> 
    <p>Registrer deg med å trykke på "Registrer" knappen i menyen til venstre, eller logg inn.</p>
  </section>
</div>
<?php include('design/footer.php'); ?>
</body>
</html>
