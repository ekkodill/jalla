// Denne siden er utviklet av Erik Bjørnflaten og Kurt A. Aamodt, sist gang endret 15.04.2014
// Denne siden er kontrollert av Mikael Kolstad,siste gang  31.05.2014

  
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
      document.getElementById(boksnavn).focus();
      alert(boksnavn + " må fylles ut");
      return false;
    } else if(btype == "Velg brukertype...") {
            liste.focus();
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
     

      //Går gjennom alle input knappene med classen "edituser" for å skjule \ vise knappen kun for en rad om gangen
      var a = document.querySelectorAll('.edituser');
            for(var i = 0; i<a.length; i++) {
                if(a[i].id != "s"+id) {
                  a[i].style.display="none";   
              }
              else{  
                a[i].style.display="inline-block";
              }
            }


      var liste = document.getElementById("typer"+id);
      var btype = liste.options[liste.selectedIndex].text;
      
      //Gir melding til veileder at han ikke har mulighet for å endre disse brukertypene
      if(type == 2 && btype == "Administrator" || type == 2 && btype == "Veileder" && id != pk || type == 3 && id != pk) {
        alert("Du kan ikke endre denne brukeren.")
        return false;
      }
     
      fjernType(type, "typer"+id, pk, brukertype); //Fjerner alternativer fra nedtrekksmenyene om brukertyper i forhold til rettighetene brukeren har.
      
    //Går gjennom alle elementene på formene med navn lol og setter readonly og disabled til true slik at bare en rad er aktiv om gangen
      var f = document.querySelectorAll('.tarea');
            for(var i=0,fLen=f.length;i<fLen;i++){
            if(f[i].id != "ePost"+id && f[i].id != "etternavn"+id && f[i].id != "fornavn"+id && f[i].id != "typer"+id ) {          
                f[i].readOnly = true;
                f[i].disabled = true;
              } else {
                f[i].readOnly = false;
                f[i].disabled = false;
              }
              }

      document.getElementById("ePost"+id).focus();
      return false;
  }
   
//Setter inputboksene til readonly når man lagrer eller fokuserer felt som er tomme
function onSave(btn) {
      var id=btn.id.substr(1);
      if(document.getElementById("ePost"+id).value == "") {
        document.getElementById("ePost"+id).focus();
      }
      if(document.getElementById("etternavn"+id).value == "") {
        document.getElementById("etternavn"+id).focus();
      }
      if(document.getElementById("fornavn"+id).value == "") {
        document.getElementById("fornavn"+id).focus();
      } 
      if(document.getElementById("ePost"+id).value != "" && document.getElementById("etternavn"+id).value != "" && document.getElementById("fornavn"+id).value != "") {
      document.getElementById("ePost"+id).setAttribute("Readonly" , "readonly");
      document.getElementById("etternavn"+id).setAttribute("Readonly" , "readonly");
      document.getElementById("fornavn"+id).setAttribute("Readonly" , "readonly");
      return btn.form.action="update.php";
    }
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



