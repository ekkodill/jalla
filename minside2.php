<!--Denne siden er utviklet av Mikael Kolstad (JS for bytting av passord), Erik Bjørnflaten (html\css) og Kurt A. Aamodt (php)., siste gang endret 04.05.2014
Denne siden er kontrollert av Dag-Roger Eriksen siste gang 04.05.2014 !-->
<?php include_once 'includes/init.php';
protected_page();
$db = getDB();

$bPK = $user_data['brukerPK'];


//Oppdaterer applikasjonseposten i txt filen.
if(isset($_POST['updatemail'])) {
  if(!empty($_POST['updatemail'])) {
    $data_to_write = $_POST['nymail'];
    $file_path = "appepost.txt";
    $file_handle = fopen($file_path, 'w') or die();
    fwrite($file_handle, $data_to_write);
    fclose($file_handle);
    $touchmail = $_POST['nymail'];
  }
}

//Setter riktig tittel i forhold til hvilken liste brukeren viser med besvarelser
if(empty($_POST['besvarform'])) {
  $listeBeskrivelse = "Besvarte oppgaver med respons";  
} else {
  $listeBeskrivelse = "Besvarte oppgaver uten respons";
}

//Sender mail fra admin\veileders minside
if(isset($_POST['sendmail'])) {
  if(!empty($_POST['frommail']) && !empty($_POST['eposttil']) && !empty($_POST['mailarea']) && !empty($_POST['mailtittel'])) {
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
} 


//Oppdaterer brukerens informasjon på minside
if(!empty($_POST['updateinfo'])) {
  if(isset($_POST['upfnavn'],$_POST['upenavn'], $_POST['upepost'])) {
    if($user_data['ePost'] == $_POST['upepost'] ||  $user_data['ePost'] != $_POST['upepost'] && user_exists($_POST['upepost']) == false) {
  $brukerPK = $user_data['brukerPK'];
  $fnavn = sanitize(trim($_POST['upfnavn']));
  $enavn = sanitize(trim($_POST['upenavn']));
  $epost = sanitize(trim($_POST['upepost']));


      //Sjekker om fornavn, etternavn eller epost i inputfeltet er forskjellig fra det brukeren har etter innlogging, dersom det er forskjellig settes en variabel for oppdateringen
      if($user_data['fornavn'] != $fnavn || $user_data['etternavn'] != $enavn || $user_data['ePost'] != $epost ) {
          if($user_data['fornavn'] != $fnavn && $user_data['ePost'] != $epost || $user_data['etternavn'] != $enavn && $user_data['ePost'] != $epost) {
            $oldnavnogepost = $user_data['fornavn']." ".$user_data['etternavn']." bytta navn til ".$fnavn." ".$enavn. " og bytta epost til ".$epost;
          } else { $oldnavnogepost = ""; }
           if($user_data['fornavn'] != $fnavn && $user_data['ePost'] == $epost || $user_data['etternavn'] != $enavn && $user_data['ePost'] == $epost) {
            $oldnavn = $user_data['fornavn']." ".$user_data['etternavn']." bytta navn til ".$fnavn." ".$enavn;
          } else { $oldnavn = ""; }
          if($user_data['ePost'] != $epost && $user_data['fornavn'] == $fnavn && $user_data['etternavn'] == $enavn) {
            $oldepost = $user_data['fornavn']." ".$user_data['etternavn']." bytta epost til ".$epost;
          } else { $oldepost = ""; }

      $nyinfo = $oldnavnogepost." ". $oldnavn." ".$oldepost;
      $dato = date("Y-m-d H:i:s");


      //Sjekker i txtfila om brukeren har endra info før, og sletter eventuelt den gamle informasjonen, før den nye legges til.
      $mytxt = new MyTXT("userinfo.txt");
      $i=-1;
      $index = "";
        foreach ($mytxt->rows as $row) {
          $i++;
          if ($row['brukerPK'] == $bPK) {
           $index = $i;
             $mytxt->remove_row($index);
          }
        }

        //Legger til informasjon om den nye endringen for brukeren i txtfilen
        $mytxt->add_row(array($bPK, $nyinfo, $dato));
        $mytxt->save("userinfo.txt");
        $mytxt->close();
      }


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
          <!--Elemeneter for å oppdatere brukerens profil!-->
        <div id="page">
          <section>
        

            <div class="profilinformasjon">
            <h3 class="proinffo">Profilformasjon</h3><br>
              <form name="profil" action="minside.php" method="POST">
                  <label class="proinf">Fornavn:</label><input type="text" name="upfnavn" class="minsinputfor" id="fornavn" value="<?php echo $user_data['fornavn'] ?>"/><br><br>
                  <label class="proinf">Etternavn:</label><input type="text" name="upenavn" class="minsinputett" id="etternavn" value="<?php echo $user_data['etternavn'] ?>"/><br><br>
                  <label class="proinf">E-post:</label><input type="text" name="upepost" class="minsinputepo" id="epost" value="<?php echo $user_data['ePost'] ?>"/><br><br><br>
                  <label class="proinf">Nåværende passord:</label><input type="text" name="upfnavn" class="minsinputfor" id="fornavn" value="<?php echo $user_data['fornavn'] ?>"/><br><br>
                  <label class="proinf">Nytt passord:</label><input type="text" name="upenavn" class="minsinputett" id="etternavn" value="<?php echo $user_data['etternavn'] ?>"/><br><br>
                  <label class="proinf">Bekreft passordet:</label><input type="text" name="upepost" class="minsinputepo" id="epost" value="<?php echo $user_data['ePost'] ?>"/><br><br><br>
                  
                  <input type='submit' class="buttonStyle" id="updt" name="updateinfo" value="Oppdater"/><br />
                </form>
</div>

          
       </section>
    </body>
</html>

