function textChange(eventID){
  var prixExpotemporaire = 9;
  var prixBase = 300;
  var prixArtdeco = 6;
  var prixDecouverte = 9;
  var prixGrandsite = 6;
  var prixGala = 0;
  var prixTotal = prixBase;

  if (expotemporaire.checked == true || expotemporaire2.checked == true) {
    prixTotal +=  prixExpotemporaire;
  }

  if (artdeco.checked == true || artdeco2.checked == true) {
    prixTotal += prixArtdeco;
  }

  if (decouverte.checked == true){
    prixTotal += prixDecouverte;
  }

  if (grandsite.checked == true){
    prixTotal += prixGrandsite;
  }
  if (gala.checked == true){
    prixTotal += prixGala;
  }

  prixreservation.innerText = prixTotal;
}


var prixreservation = document.getElementById('prixreservation');
var expotemporaire = document.getElementById('appbundle_ticket_optionExpo1');
var expotemporaire2 = document.getElementById('appbundle_ticket_optionExpo2');
var artdeco = document.getElementById('appbundle_ticket_optionArtDeco1');
var artdeco2 = document.getElementById('appbundle_ticket_optionArtDeco2');
var decouverte = document.getElementById('appbundle_ticket_optionDecouverte');
var grandsite = document.getElementById('appbundle_ticket_optionGrandSite');
var gala = document.getElementById('appbundle_ticket_day2Night');
expotemporaire.addEventListener('click', textChange)
expotemporaire2.addEventListener('click', textChange)
artdeco.addEventListener('click', textChange)
artdeco2.addEventListener('click', textChange)
decouverte.addEventListener('click', textChange)
grandsite.addEventListener('click', textChange)
gala.addEventListener('click', textChange)
