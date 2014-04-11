<?php
// Denne siden er utviklet av Erik Bjørnflaten, sist gang endret 11.04.2014
// Denne siden er kontrollert av Kurt A. Aamodt,siste gang  30.03.2014

//EOT gjør det mulig å bruke html i php
$form = <<< EOT
<form action="nybruker.php" method="POST">
Fornavn: <input type="text" name="fornavn" /><br />
Etternavn: <input type="text" name="etternavn" /><br />
E-post: <input type="text" name="ePost" /><br />
<input type="submit" value="Registrer" name="register">
</form>
EOT;

echo $form;


?>