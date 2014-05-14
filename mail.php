<?php 
//Denne siden er utviklet av Mikael Kolstad, siste gang endret 14.05.2014
//Denne siden er kontrollert av Kurt A. Aamodt siste gang 31.05.2014 

/***********************************************************************************************************************************************************************/
/**************Denne filen viser modalvindu for å sende epost. For Administratorer og veiledere. Denne filen er inkludert i nav.php da den er en del av menyen**********/
/*************************************************************************************************************************************************************************/

//Sender mail fra admin\veileder
if(isset($_POST['sendmail'])) {
  if(!empty($_POST['frommail']) && !empty($_POST['eposttil']) && !empty($_POST['mailarea']) && !empty($_POST['mailtittel'])) {
            $tittel = $_POST['mailtittel'];
            $fra = $_POST['frommail'];
            $til = $_POST['eposttil'];
            $melding = $_POST['mailarea'];
            $url = $_POST['url'];
            if(mailUsers($tittel, $melding, $fra, $til)) {
           $_SESSION['msg'] = "Eposten ble sendt";
          		header('Location:'.$url.'#message');
         } else { 
         	$_SESSION['msg'] = "En feil oppstod, meldingen ble ikke sendt. Sjekk epostserveren eller mottakerlisten.";
         	header("Location:".$url."#message");  }
         } else { 
			$_SESSION['msg'] = "En feil oppstod, meldingen ble ikke send. Ingen felt kan være tomme.";
         	header("Location:".$url."#message"); }
  }  


 ?>


  <style type="text/css">
  /*Styling for epost tekstfeltene*/
.tekstfelt {
  width:25%;
  height:auto;
  margin-left:1%;
  float:left;
}
 </style>

<!--Modalvindu med elementer for sending av epost, bare for veiledere\admins -->
 <div id='sendmail' class='modalDialog'>
  <div><a href='#close' title='Close' class='close'>X</a>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method='POST'>
    <?php $id = substr( $_SERVER['SCRIPT_NAME'], strrpos( $_SERVER['SCRIPT_NAME'], '/' )+1 ); ?>
           <h2>Send epost</h2>
              <label class="tekstfelt">Velg mottakere:</label>
                <select name='eposttil' class='dropned'>
                  <option name='tilalle'>Til alle</option>
                  <option name='tildeltakere'>Til deltakere</option>
                  <option name='tilveiledere'>Til veiledere</option>
                  <option name='tiladmins'>Til administratorer</option>
                </select><br><br>
          <div class='formfield'>
              <label  class="tekstfelt">Avsender:</label>
                <input type='text' name='frommail' value="<?php echo $touchmail; ?>" /><br><br>
              <label class="tekstfelt">Tittel:</label>
                <input type='text' name='mailtittel'/><br><br>
              <label class="tekstfelt">Melding:</label>
                <textarea name='mailarea'></textarea>
              </div><br><br>
                <input type='hidden' name='url' value="<?php echo $id; ?>" />
                <input type='submit' class='buttonStyle' value='Send epost' name='sendmail'/>
      </form>
  </div>
</div>

<!--Modalvindu med statusmelding om epost ble sendt eller ikke -->
<div class='modalDialog' id="message"> <!-- Contact Message Modal -->
  <div><a href='#close' title='Close' class='close'>X</a>
     <h3>Melding</h3>
       <span><?php if(isset($_SESSION['msg'])){echo $_SESSION['msg'];}?></span>
  </div>
</div>
