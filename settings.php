<?php 
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

 ?>

<!--Modalvindu for å endre\oppdatere applikasjonsmail -->
<div class='modalDialog' id="settings"> <!-- Contact Message Modal -->
  <div><a href='#close' title='Lukk' class='close'>X</a>
 <form action="" method="POST">
 	   <h3>Oppdater applikasjonsmail</h3>
 	   <p>Dette er eposten som brukes av applikasjonen for utsending av nye passord osv.</p>
           <input type='text' name="nymail" value="<?php echo $touchmail; ?>" />
           <input type='submit' class="buttonStyle"  name="updatemail" value="Oppdater"/><br/><br/>	
 </form>
  </div>
</div>
