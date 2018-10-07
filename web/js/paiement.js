function test (event){
   buttonpayer.style.display = 'block';
   buttonsuivant.style.display = 'none';
 }

 function test2 (event){

   buttonsuivant.style.display = 'block';
   if(cb = true)
    buttonpayer.style.display = 'none';
  }

var cb = document.getElementById("paiement_carte");
var cheque = document.getElementById("paiement_cheque");
var mandat = document.getElementById("paiement_mandat");
var buttonpayer = document.getElementById("payer");
var buttonsuivant = document.getElementById("suivant");
var codepromo = document.getElementById("paiement_codepromo");

cb.addEventListener("click" , test)
cheque.addEventListener("click" , test2)
mandat.addEventListener("click" , test2)
codepromo.addEventListener("click" , test2)
