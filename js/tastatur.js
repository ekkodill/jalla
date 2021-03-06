﻿// Denne siden er utviklet av Kurt A. Aamodt, siste gang endret 25.05.2014
// Denne siden er kontrollert av Mikael Kolstad, siste gang 31.05.2014


//Infoboks for data om besvarelse
function visInfo() {
    $("#opgtekst").css("background-image", "none");
    $("#infoboks").css("z-index", "1"); //Flyter boksen med statusmelingen på samme nivå som skjermen.
    $("#infoboks").css("display", "block");
}


//Setter stilen til tastaturet i localstorage
function setStyle(id) {
    var keyboard = document.getElementById(id).style.display;
        if(keyboard == 'none') {
            localStorage.kstyle = 'block';
        } else {
            localStorage.kstyle = 'none';
        }
   document.getElementById(id).style.display = localStorage.kstyle;
}

//Laster inn stilen til tastaturet fra localstorage
function loadStyle() {
   var stored = localStorage.kstyle;
   if(stored) {
    document.getElementById('container').style.display=stored;
   } else {
    document.getElementById('container').style.display='block';
   }
}




//Variabel for capslock on\off. 0 = off
var capslock = "0";


function capsOn() {
        document.getElementById("capslock").hidden=false;
        document.getElementById("capslockoff").hidden=true;
    }

function capsOff() {
        document.getElementById("capslockoff").hidden=false;
        document.getElementById("capslock").hidden=true;
    }



//Funksjon som setter fargene når knappen blir trykket
document.onkeydown = function(event) {
    var key_code =  (event.which);
    var element = document.getElementById(key_code);

//Switch som endrer fargen på "spesial-tastene" når knappen for tastaturet blir trykt ned
switch (key_code) {
    case 91:
            event.preventDefault();
            break;
    case 172:
            document.getElementById("220").style.backgroundColor = "#99CCFF";
            event.preventDefault();
            break;

    case 9:
            document.getElementById("tabb").style.backgroundColor = "#99CCFF";
            event.preventDefault();
            break;
    case 13:
            document.getElementById("entr").style.backgroundColor = "#99CCFF";
            document.getElementById("enter").style.backgroundColor = "#99CCFF";
            document.getElementById("dot").style.backgroundColor = "#99CCFF";
            break;
         
    case 20:
            if(capslock == "0") {
                capslock = "1";
                capsOn();
                document.getElementById("20").style.background = "#1688fa";
            }
            else {
                capslock = "0"
                document.getElementById("20").style.backgroundColor = "white";
                capsOff();
            }
            break;
           
    case 16:
            if (event.location == 1) {
                    document.getElementById("lshift").style.backgroundColor = "#1688fa";
                    capsOn();
            }
            else if(event.location == 2) { 
                    document.getElementById("rshift").style.backgroundColor = "#1688fa";
                    capsOn();
            }
            break;
            
    case 17:
            if (event.location == 1) {
                    document.getElementById("lctrl").style.backgroundColor = "#99CCFF";
            }
            else if(event.location == 2) { 
                     document.getElementById("rctrl").style.backgroundColor = "#99CCFF";
            }
            break;
            
    //Setter farge på "alt" knappene
    case 18:
            if (event.altKey && event.location == 1) {
                document.getElementById("lalt").style.backgroundColor = "#99CCFF";
                event.preventDefault();
            } //Setter farge på AltGr
            if (event.altKey && event.location == 2) {
                document.getElementById("gralt").style.backgroundColor = "#99CCFF";
                document.getElementById("lctrl").style.backgroundColor = "white";
                event.preventDefault();
            }
            break;
           default: 
            if(key_code) {
                document.getElementById(key_code).style.background = "#99CCFF"; //Endrer fargen på de andre knappene
            }                      
    }
     //Stopper kombinasjoner med alt å taster og ctrl + T
            if(event.altKey && key_code == key_code || event.ctrlKey && key_code == 84) {
                event.preventDefault();
            }
    
    
}


//Funksjon som resetter fargene når knappen blir sluppet
document.onkeyup = function(event) {
var element = document.getElementById(event.which);
    
     //Endrer tilbake for "spesial-tastene"
    switch(event.which) {
        case 0: //Endrer fargen til hvit på æøå i firefox
                document.getElementById("222").style.backgroundColor = "white";
                document.getElementById("192").style.backgroundColor = "white";
                document.getElementById("221").style.backgroundColor = "white";
        break;
        case 172:
                    document.getElementById("220").style.backgroundColor = "white";
        break;
        case 9:
                    document.getElementById("tabb").style.backgroundColor = "white";
        break;
        case 13:
                    document.getElementById("entr").style.backgroundColor = "white";
                    document.getElementById("enter").style.backgroundColor = "white";
                    document.getElementById("dot").style.backgroundColor = "white";
        break;
        case 16:
            document.getElementById("rshift").style.backgroundColor = "white";
            document.getElementById("lshift").style.backgroundColor = "white";
            capsOff();

        break;
        case 17:
                    document.getElementById("rctrl").style.backgroundColor = "white";
                    document.getElementById("lctrl").style.backgroundColor = "white";
        break;
        case 18:
                    document.getElementById("lalt").style.backgroundColor = "white";
                    document.getElementById("gralt").style.backgroundColor = "white";
        break;
        case 20:    return;
        break;
        default : 
        if(event.which) {
            document.getElementById(event.which).style.backgroundColor = "white"; //Endrer fargen tilbake til standard
        }
    }
    
}

    //Keypress for å finne æ ø å i firefox som returner 0 med keydown eventen.
    document.onkeypress = function vis_press(evt) {
        switch (evt.which) {
        //Æ
        case 230:
        case 198:
             document.getElementById("222").style.backgroundColor = "#99CCFF";
          break;
        //Ø
        case 248:
        case 216:
            document.getElementById("192").style.backgroundColor = "#99CCFF";
          break;
        //Å
        case 229:
        case 197:
           document.getElementById("221").style.backgroundColor = "#99CCFF";
          break;
        case 45:
            document.getElementById("189").style.backgroundColor = "#99CCFF";
        break;
        }
    }
