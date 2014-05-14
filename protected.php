<!--Denne siden er utviklet av Kurt A. Aamodt, siste gang endret 03.03.2014
Denne siden er kontrollert av Erik Bjørnflaten siste gang 03.03.2014  !-->

<?php 
include_once 'includes/init.php'; ?>

 <!--************************************************************************************************-->
 <!--Denne siden er for å stoppe brukere som ikke er innlogget i å få tilgang til sider de ikke skal-->
 <!--************************************************************************************************-->

<!doctype html>
<html>
<?php include('design/footer.php'); ?>
    <?php 
	$pgName = 'Forbudt område';
    include 'design/head.php'; ?>
<body>
<?php include 'design/header.php'; ?>
<div id="page">
  <section style="height:100%;">
  	  <h3 style="margin-top:200px;">Beklager, du må være innlogget for å se denne siden.</h3> 
    <p><a href="registrer.php">Registrer her</a>, eller logg inn.</p>
  </section>
</div>
</body>
</html>
