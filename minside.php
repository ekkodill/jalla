<!--Denne siden er utviklet av Mikael og Erik., siste gang endret 30.03.2014
Denne siden er kontrollert av Kurt A. Amodt siste gang 30.03.2014 !-->
<?php include_once 'includes/init.php';
protected_page();
$db = getDB();

$bPK = $user_data['brukerPK'];


//Setter riktig tittel i forhold til hvilken liste brukeren viser med besvarelser
if(empty($_POST['besvarform'])) {
  $listeBeskrivelse = "Besvarte oppgaver med respons";  
} else {
  $listeBeskrivelse = "Besvarte oppgaver uten respons";
}

//Sender mail fra admin\veileders minside
if(isset($_POST['sendmail'])) {
  if(!empty($_POST['frommail']) && !empty($_POST['eposttil']) && !empty($_POST['mailarea']) && !empty($_POST['mailtittel']))
            $tittel = $_POST['mailtittel'];
            $fra = $_POST['frommail'];
            $til = $_POST['eposttil'];
            $melding = $_POST['mailarea'];
            if(mailUsers($tittel, $melding, $fra, $til)) {
              header("location: minside.php?mailsendt");
            } else {
          header("location: minside.php?mailerror");
         }
         } 


//Oppdaterer brukerens informasjon på minside

if(!empty($_POST['updateinfo'])) {
  if(isset($_POST['upfnavn'],$_POST['upenavn'], $_POST['upepost'])) {
    if($user_data['ePost'] == $_POST['upepost'] ||  $user_data['ePost'] != $_POST['upepost'] && user_exists($_POST['upepost']) == false) {
  $brukerPK = $user_data['brukerPK'];
  $fnavn = sanitize(trim($_POST['upfnavn']));
  $enavn = sanitize(trim($_POST['upenavn']));
  $epost = sanitize(trim($_POST['upepost']));


/****************Kode for eventuelt bruk senere i forbindelse med å la veiledere se brukerendringer*******************
  if($fnavn =!  $user_data['fornavn'] || $enavn !=  $user_data['etternavn'] || $epost !=  $user_data['ePost'] ) {
    if($fnavn =!  $user_data['fornavn'] || $enavn !=  $user_data['etternavn']) {
      $oldnavn = $user_data['fornavn']." bytta navn til: ". $user_data['fornavn']. " ".$user_data['etternavn'];
    }
    if($epost !=  $user_data['ePost']) {
      $oldepost =  $user_data['fornavn']." bytta epost til: ". $user_data['ePost'];
    }
     $_SESSION['endretbinfo'] = "";
     if(!empty($oldnavn)) {
      $_SESSION['endretbinfo'] = $oldnavn;
     }
     if(!empty($oldepost)) {
      $_SESSION['endretbinfo'] = $oldepost;
     }
     if(!empty($oldnavn) && !empty($oldepost)) {
      $_SESSION['endretbinfo'] = $oldnavn." og ".$oldepost;
     }
  }*/
      if(!empty($fnavn) && !empty($enavn) && !empty($epost)) {      
          if(endreBrukerInfo($brukerPK, $fnavn, $enavn, $epost)) {
                header('Location: minside.php?oppdatert');
          } else { header('Location: minside.php?error'); }
      } else { header('Location: minside.php?tomerror'); }
    } else { header('Location: minside.php?eposterror'); }
  }
}

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
              function updateClick() {
                document.getElementById('updt').click();
              }
          </script>
          <!--Elemeneter for å oppdatere brukerens profil!-->
        <div id="page">
          <section>
            <div class="msvenstre"><div class="bpbilde"><img src="img/mann.jpg" height:"30%" width="70%"alt="bilde"></div>
              <div class="profinfo">
                <form name="profil" action="minside.php" method="POST">
                  <label>Fornavn:</label><input type="text" name="upfnavn" class="minsinputfor" id="fornavn" value="<?php echo $user_data['fornavn'] ?>"/><br>
                  <label>Etternavn:</label><input type="text" name="upenavn" class="minsinputett" id="etternavn" value="<?php echo $user_data['etternavn'] ?>"/><br>
                  <label>E-post:</label><input type="text" name="upepost" class="minsinputepo" id="epost" value="<?php echo $user_data['ePost'] ?>"/><br><br />
                  <input type='submit' class="buttonStyle" id="updt" name="updateinfo" value="Oppdater"/><br />
                </form>
                <?php 
  
            //Utskrift for statusmeldinger når brukeren oppdaterer informasjonen sin
            if(isset($_GET['oppdatert'])) {
              echo "Oppdatert";
            } elseif(isset($_GET['error'])) {
              echo "Det oppstod en feil ved lagring";
            } elseif(isset($_GET['tomerror'])) {
              echo "Det oppstod en feil, et eller flere felt kan ikke være tomme";
            } elseif(isset($_GET['eposterror'])) {
              echo "Eposten er allerede i bruk";
            }
                 ?>
              </div>
            </div>


 <!--Elementer for utsending av epost til brukere av nettsiden. Aktiv på admins og veilederes "min side" !-->
<?php 
            if($user_data['brukertype'] != 3) {
?>
        <form class="fasplas" action="" method="POST">
           <h3>Send epost</h3>
           <label>Velg mottakere:</label>
             <select name="eposttil" class="dropned" action="minside.php" method="POST">
              <option name="tilalle">Til alle</option>
              <option name="tildeltakere">Til deltakere</option>
              <option name="tilveiledere">Til veiledere</option>
              <option name="tiladmins">Til administratorer</option>
            </select>
            <br>
            <br>
            <label>Avsender:</label>
            <input type="mail"  name="frommail" value="<?php echo $touchmail; ?>"/><br/><br/>
            <label>Tittel:</label>
            <input type="text"  name="mailtittel" /><br/><br/>
            <?php //<input type='submit' class="buttonStyle"  name="updatemail" value="Oppdater"/><br/><br/> ?>
            <label>Melding:</label>
            <textarea name="mailarea"></textarea>
            <input type="submit" class="buttonStyle" value="Send epost" name="sendmail"/>
          </form>
          <?php 
          if(isset($_GET['mailsendt'])) {
            echo "Eposten ble sendt";
          } elseif(isset($_GET['mailerror'])) {
            echo "En feil oppstod, epost ble ikke sendt";
          }
       }
 
          if($user_data['brukertype'] == 3 && count(sjekkAntall("oppgaver 
            LEFT JOIN innleveringer ON (oppgaver.oppgavePK =innleveringer.oppgave AND innleveringer.bruker = $bPK) WHERE innleveringer.oppgave IS NULL"))) { ?>
           <!--Nedtrekksmeny for å bytte mellom de forskjellige oppgavelistene på brukerens profil !-->
           <form class="fasplas"action="minside.php" method="post">
              <select class="dropned" name='minsideoppgli' onchange="this.form.submit();">
                  <option class="dropned" name="ubesvoppg" value='ubesvoppg' <?php if(isset($_POST['minsideoppgli'])) { if($_POST['minsideoppgli'] == 'ubesvoppg') {echo "selected";}}?>>Ubesvarte oppgaver</option>
                  <option class="dropned"  name="pbegoppg" value='pbegoppg' <?php if(isset($_POST['minsideoppgli'])) { if($_POST['minsideoppgli'] == 'pbegoppg') {echo "selected";}}?>>P&aringbegynte oppgaver</option>
              </select></center><br>
            </form>
    <?php } ?>


             <!--Felter for å bytte passord på brukerens profil !-->
            <div id="minside">
                <form id="byttpw" name="reg" method="post" action="minside.php">
                 <h2>Bytt passord</h2>
                    Gammelt passord: 
                    <br><input type="password" id="gammelt" name="oldpassword" placeholder="Gammelt passord"/><br /><br />
                    Nytt passord: 
                    <br><input type="password" id="nytt" name="password" placeholder="8 tegn eller flere"/><br /><br />
                    Bekreft nytt passord: 
                    <br><input type="password" id="bekreft" name="passwordcheck" placeholder="Bekreft nytt passord"/><br /><br />
                    <input type="Submit" class="buttonStyle" id="pwknapp" name="nypw" value="Bekreft">
                    <br>
                    <?php 
                    //Skriver ut statusmeldiner i forbindelse med passordbytte
                    if (empty($errors) === false) {
                        echo output_errors($errors);
                    } ?>
                </form>
            </div>
             <div class="ubesform2">
              <?php 
        if($user_data['brukertype'] == 3) {
              //Setter paramterene for riktig liste som skal vises basert på valget i nedtrekksmenyen, og viser oppgavelisten
              
            if(!empty($_POST['minsideoppgli'])) {
                if($_POST['minsideoppgli'] == 'ubesvoppg') {
                  $result = ubesvarteOppg($bPK, 3);
                } elseif( $_POST['minsideoppgli'] =='pbegoppg') {
                  $result = ubesvarteOppg($bPK, 0);
                } 
            } else {
                    $result = ubesvarteOppg($bPK, 3);
                }
                if(!count(sjekkAntall("oppgaver 
            LEFT JOIN innleveringer ON (oppgaver.oppgavePK =innleveringer.oppgave AND innleveringer.bruker = $bPK) WHERE innleveringer.oppgave IS NULL"))) {
                    echo "<legend>Ingen registrerte oppgaver</legend>"; 
              } else {
                include_once("ubesvartliste.php");
              }
              
               ?>
              
          </div>
           <!--Liste over besvarte oppgaver med eller uten respons basert på valget i avkryssinga, på brukerens profil !-->
          <div class="minsidemainnede">
          <?php 
              if(!count(sjekkAntall("innleveringer WHERE ferdig = 1 AND bruker =".$bPK))) {
                echo "<legend>Ingen registrerte besvarelser</legend>"; 
              } else {  ?>
          <h3><?php echo $listeBeskrivelse ?></h3>
          <form method="POST" action="">
            <input type="checkbox" name="besvarform" onchange="this.form.submit()" <?php if(isset($_POST['besvarform'])) echo "checked='checked'"; ?>>Vis besvarelser uten respons
          </form>
            <?php if(isset($_POST['besvarform'])) {
                $result = ubesvarteOppg($bPK, 1);
              } else {
                $result = ubesvarteOppg($bPK, 2);
              }
              
                  include_once("besvart.php"); 
              }
      }
              ?>
          </div>
       </section>
    </body>
</html>

