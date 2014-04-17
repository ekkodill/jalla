<!--Denne siden er utviklet av Mikael og Erik., siste gang endret 30.03.2014
Denne siden er kontrollert av Kurt A. Amodt siste gang 30.03.2014 !-->
<?php include_once 'includes/init.php';
$db = getDB();

//Sjekker at boksene er utfyllt og at informasjonen stemmer for så å oppdatere til det nye passordet.
if(isset($_POST['nypw'])) {
    $gammeltpw = passord(sanitize($_POST['oldpassword']));
    $nyttpassord = passord(sanitize($_POST['password']));

if (isset($_POST['password']) === true && isset($_POST['oldpassword']) === true && empty($_POST['passwordcheck']) === false) {
if($user_data['passord'] != $gammeltpw) {
    $errors[] = 'Gammelt passord stemmer ikke';
} else if($_POST['password'] === $_POST['passwordcheck']) {
            $epost = $user_data['ePost'];
            endrePW($nyttpassord, $epost);
            $errors[] = 'Passordet ble endret';
            }   else { 
                  $errors[] = 'De nye passordene er ikke like'; 
                }
        } else { $errors[] = 'Alle feltene må fylles inn'; }
} 
?>


<!doctype html>
<html>
    <?php 
    $pgName = 'Minside';
    include 'design/head.php'; ?>
    <body onunload="unloadP('oppgave')" onload="loadP('oppgave')">
        <div id="page">
          <?php include 'design/header.php'; ?>
          <section>
          <div class="msvenstre"><div class="bpbilde"><img src="img/mann.jpg" height:"67%" width="85%"alt="bilde"></div>
          <div class="profinfo">
Fornavn: Erik<input type='image' id="bfred" src='img/edit.jpg' alt='Rediger fornavn'><br />
Etternavn: Bjørnflaten<input type='image' id="bfred" src='img/edit.jpg' alt='Rediger etternavn'><br />
E-post: valpeforum@gmail.com<input type='image' id="bfred" src='img/edit.jpg' alt='Rediger e-post'><br />
</div>
          </div>
          <div class="ikkeferi"><h3>Du har <?php if(logged_in() === true) { echo "".ubesvarteOppg($user_data['brukerPK'])->num_rows.""; } ?> 
        <a href="default.php"> uferdig oppgave(r)</h3><br /><?php include_once 'ubesvartliste.php'; ?></div>

            <div id="minside">
                <form id="byttpw" name="reg" method="post" action="minside.php">
                 <h2>Bytt passord</h2>
                    Gammelt passord: 
                    <br><input type="password" id="gammelt" name="oldpassword" placeholder="Gammelt passord"><br /><br />
                    Nytt passord: 
                    <br><input type="password" id="nytt" name="password" placeholder="8 tegn eller flere"><br /><br />
                    Bekreft nytt passord: 
                    <br><input type="password" id="bekreft" name="passwordcheck" placeholder="Bekreft nytt passord"><br /><br />
                    <input type="Submit" id="pwknapp" name="nypw" value="Bekreft">
                    <br><?php 
                    if (empty($errors) === false) {
                        echo output_errors($errors);
                    } ?>
                </form>
            </div>
         </section>
     <?php include('design/footer.php'); ?>    
    </body>
</html>

