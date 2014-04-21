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
        } else { $errors[] = 'Alle feltene m&aring; fylles inn'; }
} 
?>


<!doctype html>
<html>
<?php include('design/footer.php'); 
    $pgName = 'Minside';
    include 'design/head.php'; ?>
    <body onunload="unloadP('oppgave')" onload="loadP('oppgave')">
        <?php include 'design/header.php'; ?>
      <script type="text/javascript">
          /*  function jaaa() {
              var a = document.querySelectorAll('.bfred');
                  for(var i = 0; i<a.length; i++) {
                      a[i].style.display="none";  
                  }
              }*/
              function removeRO(id,save){
                var f = document.forms['profil'];
                for(var i=0,fLen=f.length;i<fLen;i++){
                f.elements[i].readOnly = true;
                }
                var a = document.querySelectorAll('.bfred');
                for(var i = 0; i<a.length; i++) {
                  if(a[i].id != save) {
                    a[i].style.display="none";
                  } else {
                      a[i].style.display="inline-block";
                    }
                }
                 document.getElementById(id).removeAttribute("readonly");          
                 document.getElementById(id).focus();
                 return false;
              }
          </script>
        <div id="page">
          <section>
          <div class="msvenstre"><div class="bpbilde"><img src="img/mann.jpg" height:"30%" width="70%"alt="bilde"></div>
          <div class="profinfo">
          <form name="profil" action="minside.php" method="POST">
          <label>Fornavn:</label>
          <input type="text" name="upfnavn" readonly class="minsinputfor" id="fornavn" value="<?php echo $user_data['fornavn'] ?>"/>
          <input type='image' name="savelfnavn" class="bfred" id="lfnavn" hidden src='img/save.jpg' />
          <input type='image'  src='img/edit.jpg' alt='Rediger fornavn' onclick="return removeRO('fornavn', 'lfnavn');"/><br />
          <label>Etternavn:</label>
          <input type="text" name="upenavn" readonly class="minsinputett" id="etternavn" value="<?php echo $user_data['etternavn'] ?>"/>
          <input type='image' name="savelenavn" class="bfred" id="lenavn" hidden src='img/save.jpg'/>
          <input type='image'  src='img/edit.jpg' alt='Rediger fornavn' onclick="return removeRO('etternavn', 'lenavn')"/><br />
          <label>E-post:</label>
          <input type="text" name="upepost" readonly class="minsinputepo" id="epost" value="<?php echo $user_data['ePost'] ?>"/>
          <input type='image' name="savelepost" class="bfred" id="lepost" hidden="true" src='img/save.jpg'/>
          <input type='image' src='img/edit.jpg' alt='Rediger fornavn' onclick="return removeRO('epost', 'lepost')"/><br />
          </form>
            <?php 
            if(isset($_GET['oppdatert'])) {
              echo "Oppdatert";
            } elseif(isset($_GET['error'])) {
              echo "Det oppstod en feil ved lagring";
            } elseif(isset($_GET['tomerr'])) {
              echo "Det oppstod en feil, et eller flere felt er tomme";
            }



           ?>
          </div>
          </div>
          <div class="ikkeferi"><h3>Du har uferdig oppgave(r)</h3><br />
         <form action="minside.php" method="post">
            <select name='minsideoppgli' onchange="this.form.submit();">
            <option name="ubesvoppg"     value='ubesvoppg' <?php if(isset($_POST['minsideoppgli'])) { if($_POST['minsideoppgli'] == 'ubesvoppg') {echo "selected";}}?>>Ubesvarte oppgaver</option>
                <option name="pbegoppg" value='pbegoppg' <?php if(isset($_POST['minsideoppgli'])) { if($_POST['minsideoppgli'] == 'pbegoppg') {echo "selected";}}?>>P&aringbegynte oppgaver</option>
                <option name="besvoppg" value='besvoppg' <?php if(isset($_POST['minsideoppgli'])) { if($_POST['minsideoppgli'] == 'besvoppg') {echo "selected";}}?>>Besvarte oppgaver</option>
                <option name="besvmresp" value='besvmresp' <?php if(isset($_POST['minsideoppgli'])) { if($_POST['minsideoppgli'] == 'besvmresp') {echo "selected";}}?>>Besvarelser med respons</option>
            </select></center><br>
            </form>
              <?php 
              $bPK = $user_data['brukerPK'];
            if(!empty($_POST['minsideoppgli'])) {
                if($_POST['minsideoppgli'] == 'ubesvoppg') {
                  $result = ubesvarteOppg($bPK, 3);
                } elseif( $_POST['minsideoppgli'] =='pbegoppg') {
                  $result = ubesvarteOppg($bPK, 0);
                } elseif($_POST['minsideoppgli'] == 'besvoppg') {
                  $result = ubesvarteOppg($bPK, 1);
                } elseif($_POST['minsideoppgli'] == 'besvmresp') {
                  $result = ubesvarteOppg($bPK, 2);
                }  else {
                    $result = ubesvarteOppg($bPK, 3);
                }
            } else {
                    $result = ubesvarteOppg($bPK, 3);
                }

                include_once("ubesvartliste.php");
               ?>
          </div>
              
            <div id="minside">
                <form id="byttpw" name="reg" method="post" action="minside.php">
                 <h2>Bytt passord</h2>
                    Gammelt passord: 
                    <br><input type="password" id="gammelt" name="oldpassword" placeholder="Gammelt passord"/><br /><br />
                    Nytt passord: 
                    <br><input type="password" id="nytt" name="password" placeholder="8 tegn eller flere"/><br /><br />
                    Bekreft nytt passord: 
                    <br><input type="password" id="bekreft" name="passwordcheck" placeholder="Bekreft nytt passord"/><br /><br />
                    <input type="Submit" id="pwknapp" name="nypw" value="Bekreft">
                    <br><?php 
                    if (empty($errors) === false) {
                        echo output_errors($errors);
                    } ?>
                </form>
               
            </div>
 <div class="minsidemainnede">
              
<div class="venstrenede"></div>

<div class="midtennede"></div>

<div class="hoyrenede"></div>

            </div>
  </section>
    </body>
</html>

