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




//Søking for tabellene på oppgave.php
$( document ).ready(function() {
	$("#search").keyup(function() {
	    var value = this.value.toLowerCase().trim();
	    $("table tr").each(function (index) {
	        if (!index) return;
	        $(this).find("td").each(function () {
	            var id = $(this).text().toLowerCase().trim();
	            var not_found = (id.indexOf(value) == -1);
	            $(this).closest('tr').toggle(!not_found);
	            return not_found;
	        });
	    });
	});
});


//Funksjon som returnerer X og Y scrollposisjonen i det aktuelle html dokumentet
function getScrollXY() {
    var x = 0, y = 0;
    if( typeof( window.pageYOffset ) == 'number' ) {
        // Netscape
        x = window.pageXOffset;
        y = window.pageYOffset;
    } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
        // DOM
        x = document.body.scrollLeft;
        y = document.body.scrollTop;
    } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
        // IE6 standards compliant mode
        x = document.documentElement.scrollLeft;
        y = document.documentElement.scrollTop;
    }
    return [x, y];
}
           
//Funksjon som setter x og y scrollposisjon
function setScrollXY(x, y) {
    window.scrollTo(x, y);
}

//Funksjon som oppretter cookies
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

//Leser cookienavnet for siden
function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

//Leser cookie innholdet for siden og setter X og Y scrollposisjonen for denne siden
function loadP(pageref){
	x=readCookie(pageref+'x');
	y=readCookie(pageref+'y');
	setScrollXY(x,y)
}

//Lager en cookie med scrollposisjon for denne siden når den "refreshes"
function unloadP(pageref){
	s=getScrollXY()
	createCookie(pageref+'x',s[0],0.1);
	createCookie(pageref+'y',s[1],0.1);
}