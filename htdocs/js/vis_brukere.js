// Denne siden er utviklet av Erik Bjørnflaten og Kurt A. Aamodt, sist gang endret 03.03.2014
// Denne siden er kontrollert av Kurt A. Aamodt,siste gang  03.03.2014

  
// Sjekker om e-postfeltet er fylt inn, og at brukerype er riktig
//noe som er påkrevd for å registrere. Dersom ikke gir den feilmelding og setter fokus på dette feltet.
function regNy() {
       if (document.getElementById('ePost').value == "") {
           alert("Du må skrive inn en epostadresse");
            return false;
          }
        else if (document.getElementById('nybrukertype').value < 1 || document.getElementById('nybrukertype').value > 3 ) {
            alert("Brukertype kan bare være mellom 1 og 3:\n1. Administrator\n2.Veileder\n3.Deltaker");
              return false;
        }
        else 
        {
          return true;
        }
    }   




//Sjekker om bruker virkelig skal slettes
function slette(fornavn, etternavn, id) {
  if(confirm('Vil du slette: '+id + ' ' +fornavn+ ' '+etternavn+ ' ' + 'fra databasen?')) {
    return submitForm(id, "delete.php");
  } else {
      return false;
  }
}


//For lagring av endret data
function lagre() {
    alert("Lagring funker ikke atm");
  /*if(confirm('Vil du lagre endringer til databasen?')) {
    submitForm("update.php");
    return true;
  } else { */
      return false;
  
}


//Sorterer tabellene når man trykker på headeren
$(document).ready(function() { 
        $("#myTable").tablesorter(); 
    });

  //endrer action til formen som behandler sletting og endring av brukere
   function submitForm(id, action)
    {
        document.getElementById('multiform'+id).action = action;
        document.getElementById('multiform'+id).submit();
    }


var forrigeePost ="";
var forrigefornavn ="";
var forrigeetternavn ="";
var forrigebrukertype ="";
var forrigeNr = "";
var forrigeInput = "";



//Gjør ønsket rad redigerbar
function rediger(btn) {
    var id=btn.id.substr(1);

    if (forrigeePost) {
    document.getElementById("ep"+forrigeNr).innerHTML = forrigeePost;
    document.getElementById("et"+forrigeNr).innerHTML = forrigeetternavn;
    document.getElementById("fo"+forrigeNr).innerHTML = forrigefornavn;
    document.getElementById("bt"+forrigeNr).innerHTML = forrigebrukertype;
    //forrigeInput.value = "Edit";
    }

    forrigeNr = id;
    forrigeInput = btn;

    var ePost = document.getElementById("ep"+id);
    var etternavn = document.getElementById("et"+id);
    var fornavn = document.getElementById("fo"+id);
    var brukertype = document.getElementById("bt"+id);

    forrigeePost      = ePost.innerHTML;
    forrigefornavn    = fornavn.innerHTML;
    forrigeetternavn  = etternavn.innerHTML;
    forrigebrukertype = brukertype.innerHTML;

    ePost.innerHTML     = "<input type='text' class='tarea' name='editepost' value='"+ePost.innerHTML+"'>"
    etternavn.innerHTML = "<input type='text' class='tarea' name='editetternavn' value='"+etternavn.innerHTML+"'>";
    fornavn.innerHTML   = "<input type='text' class='tarea' name='editfornavn' value='"+fornavn.innerHTML+"'>"
    brukertype.innerHTML= "<input type='text' class='tarea' name='editbrukertype' value='"+brukertype.innerHTML+"'>"

    return false;
    }
