// Denne siden er utviklet av Erik Bjørnflaten og Kurt A. Aamodt, sist gang endret 30.03.2014
// Denne siden er kontrollert av Kurt A. Aamodt,siste gang  30.03.2014

  

  
// Sjekker om e-postfeltet er fylt inn, og at brukerype er riktig
//noe som er påkrevd for å registrere. Dersom ikke gir den feilmelding og setter fokus på dette feltet.
function regNy() {
  var liste = document.getElementById("nytype");
  var btype = liste.options[liste.selectedIndex].text;
  var boks = ["ePost", "fornavn", "etternavn"]
  var i, l = boks.length;
  var boksnavn;
  for (i = 0; i <  l; i++) {
    boksnavn = boks[i];
    if(document.getElementById(boksnavn).value === "") {
      alert(boksnavn + " må fylles ut");
      return false;
    } else if(btype == "Velg brukertype...") {
            alert("Du må velge en brukertype.");
            return false;
      }     
  } return true;
}
 
//Sjekker om bruker virkelig skal slettes
function slette(fornavn, etternavn, id, denne, type) {
    var liste = document.getElementById("typer"+id);
    var btype = liste.options[liste.selectedIndex].text;
    if(type == 2 && btype == "Administrator" || type == 2 && btype == "Veileder" || type == 3) {
        alert("Du kan ikke slette denne brukeren.")
        return false;
      }
  if(confirm("Vil du slette: " +fornavn+ " "+etternavn+ " " + "fra databasen?")) {
    return denne.form.action="delete.php";
  } else {
      return false;
  }
}


//Tar bort readonly fra inputboksene når man trykker på "blyant"-ikonet for å endre brukerdata
  function onEdit(btn, type, pk, brukertype) {
      var id=btn.id;
      var liste = document.getElementById("typer"+id);
      var btype = liste.options[liste.selectedIndex].text;
      
      //Gir melding til veileder at han ikke har mulighet for å endre disse brukertypene
      if(type == 2 && btype == "Administrator" || type == 2 && btype == "Veileder" && id != pk || type == 3 && id != pk) {
        alert("Du kan ikke endre denne brukeren.")
        return false;
      }
     
      fjernType(type, "typer"+id, pk, brukertype); //Fjerner alternativer fra nedtrekksmenyene om brukertyper i forhold til rettighetene brukeren har.
      
      document.getElementById("ePost"+id).removeAttribute("Readonly");
      document.getElementById("etternavn"+id).removeAttribute("Readonly");
      document.getElementById("fornavn"+id).removeAttribute("Readonly");
      document.getElementById("typer"+id).removeAttribute("disabled");
      document.getElementById("s"+id).removeAttribute("hidden");
      return false;
  }
   
//Setter inputboksene til readonly når man lagrer
function onSave(btn) {
      var id=btn.id.substr(1);
      document.getElementById("ePost"+id).setAttribute("Readonly" , "readonly");
      document.getElementById("etternavn"+id).setAttribute("Readonly" , "readonly")
      document.getElementById("fornavn"+id).setAttribute("Readonly" , "readonly");
      document.getElementById("typer"+id).setAttribute("disabled" , true);
      return false;
}



//Funksjon som fjerner alternativer i nedtrekksmenyer i forhold til angitt spesifikasjon
function fjernType(type, id, pk, brukertype) {
  var brukerPK = id.substr(5);
  var selectobject=document.getElementById(id);
    //Fjerner alternativene for veiledere og deltakere til å endre brukertype på deltakere
    if(type == 2 || type == 3) {
      for (var i=0; i<selectobject.length; i++) {
        if (selectobject.options[i].value == "administrator") 
           selectobject.remove(i);
        if(pk != brukerPK && type == 2 || type == 3) { //Sørger for at veileder kan endre på data om seg selv uten å miste veileder statusen.
            if ( selectobject.options[i].value == "veileder") 
                selectobject.remove(i); 
        }
      }
    }

    //Fjerner muligheten for administrator til å endre brukertype på andre administratorer
    if(type == 1 && brukertype == 1) {
      for (var i=0; i<selectobject.length; i++) {
        if (selectobject.options[i].value == "veileder") 
          selectobject.remove(i); 
        if (selectobject.options[i].value == "deltaker") 
          selectobject.remove(i); 
      } 
    }
  }



