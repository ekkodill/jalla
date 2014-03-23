// Denne siden er utviklet av Kurt A. Aamodt, siste gang endret 22.03.2014
// Denne siden er kontrollert av Mikael Kolstad, siste gang 22.03.2014

//Funksjon som registrerer nye oppgaver
function regNyoppg() {
	if (document.getElementById('oppgtitt').value === "") {
			alert("Tittel må fylles inn");
            return false;
		}
		if (document.getElementById('oppgtext').value === "") {
			alert("Oppgavetekst må fylles inn");
            return false;
		}
		var radiobtn = document.getElementsByName('vansklighetsgrad');
		for(var i = 0; i < radiobtn.length; i++) {
			if(radiobtn[i].type === 'radio' && radiobtn[i].checked) {
				return true;	
			}
		} alert("Du må velge vanskelighetsgrad");
			return false;

      }    


//Funksjon for å klikke på den skjulte fil-dialog knappen
function doClick(pk)
{
	document.getElementById("file-input"+pk).click();
}

//Funksjon som "klikker" på lagre vedlegg når et vedlegg blir valgt
function lagre(pk) {
document.getElementById("s"+pk).click();
}

//Gir beskjed om responsfeltet er tomt eller om den ble lagret
function errorRespons(pk) {
		if (document.getElementById('responstext').value === "") {
		alert("Du må skrive inn en respons");
		} else {
			alert("Responen ble lagret");
			document.getElementById("responsid"+pk).click();
		}
}

	//Scroll posisjon for IE
    function detectScrollbar() {
        if (navigator.appName == "Microsoft Internet Explorer") {
            window.name=document.body.scrollTop;
        }
        else {
            window.name=window.pageYOffset;
        }
    }

    //Scroll posisjon
    function doScroll() {
      if (window.name) window.scrollTo(0, window.name);
    }
