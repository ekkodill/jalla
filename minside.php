<!--Denne siden er utviklet av Mikael og Erik., siste gang endret 03.03.2014
Denne siden er kontrollert av Kurt A. Amodt siste gang 03.03.2014 !-->
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
            $brukerPK = $user_data['brukerPK'];
            $stmt = $db->prepare("UPDATE brukere SET passord=? WHERE brukerPK=? LIMIT 1");
            $stmt->bind_param('si', $nyttpassord, $brukerPK);
            try {
                    $stmt->execute();
                    $errors[] = 'Passordet ble endret';
                }
                catch (exception $e) {
                    throw new exception("Det oppstod en feil", 0, $e);
                }
            }   else { 
                  $errors[] = 'De nye passordene er ikke like'; 
                }
        } else { $errors[] = 'Alle feltene må fylles inn'; }
} else { $errors[] = 'Fyll inn informasjon for å bytte passord'; }
?>


<!doctype html>
<html>
    <?php 
    $pgName = 'Minside';
    include 'design/head.php'; ?>
    <body>
        <div id="page">
          <?php include 'design/header.php'; ?>
          <main>
            <div id="minside">
                <form id="byttpw" name="reg" method="post" action="minside.php">
                 <h2>Bytt passord</h2>
                    Gammelt passord: 
                    <br><input type="password" id="gammelt" name="oldpassword" placeholder="Gammelt passord"><br>
                    Nytt passord: 
                    <br><input type="password" id="nytt" name="password" placeholder="8 tegn eller flere"><br>
                    Bekreft nytt passord: 
                    <br><input type="password" id="bekreft" name="passwordcheck" placeholder="Bekreft nytt passord"><br>
                    <input type="Submit" id="pwknapp" name="nypw" value="Bekreft">
                    <br><?php 
                    if (empty($errors) === false) {
                        echo output_errors($errors);
                    } ?>
                </form>
            </div>
         </main>
     <?php include('design/footer.php'); ?>    
    </body>
</html>

