var eventTable = [
  {
    "dayName": "Jour 1",
    "eventName": "Visite 1"
  },
  {
    "dayName": "Jour 1",
    "eventName": "Visite 2"
  },
  {
    "dayName": "Jour 1",
    "eventName": "Visite 3"
  },
  {
    "dayName": "Jour 1",
    "eventName": "Repas 1"
  },
  {
    "dayName": "Jour 1",
    "eventName": "Repas 2"
  },
  {
    "dayName": "Jour 1",
    "eventName": "Repas 3"
  },
  {
    "dayName": "Jour 1",
    "eventName": "Transport SNCF"
  },
  {
    "dayName": "Jour 1",
    "eventName": "Transport Hebergement"
  },
  {
    "dayName": "Jour 1",
    "eventName": "Soirée Louvre"
  },
  {
    "dayName": "Jour 1",
    "eventName": "Soirée Transport Hebergement"
  },
  {
    "dayName": "Jour 2",
    "eventName": "Visite 1"
  },
  {
    "dayName": "Jour 2",
    "eventName": "Visite 2"
  },
  {
    "dayName": "Jour 2",
    "eventName": "Visite 3"
  },
  {
    "dayName": "Jour 2",
    "eventName": "Repas 1"
  },
  {
    "dayName": "Jour 2",
    "eventName": "Repas 2"
  },
  {
    "dayName": "Jour 2",
    "eventName": "Repas 3"
  },
  {
    "dayName": "Jour 2",
    "eventName": "Transport SNCF"
  },
  {
    "dayName": "Jour 2",
    "eventName": "Transport Hebergement"
  },
  {
    "dayName": "Option",
    "eventName": "Visite 1"
  },
  {
    "dayName": "Option",
    "eventName": "Visite 2"
  },
  {
    "dayName": "Option",
    "eventName": "Visite 3"
  },
  {
    "dayName": "Option",
    "eventName": "Exposition 8 JUIN"
  },
  {
    "dayName": "Option",
    "eventName": "Exposition 9 JUIN"
  },
  {
    "dayName": "Option",
    "eventName": "Visite Art Déco 8 Juin"
  },
  {
    "dayName": "Option",
    "eventName": "Visite Art Déco 9 Juin"
  },
  {
    "dayName": "Option",
    "eventName": "Visite Découverte"
  },
  {
    "dayName": "Option",
    "eventName": "Visite Notre-Dame"
  },
  {
    "dayName": "Toutes les réservations",
    "eventName": ""
  },
  {
    "dayName": "Jour 1",
    "eventName": ""
  },
  {
    "dayName": "Jour 2",
    "eventName": ""
  },
  {
    "dayName": "Options",
    "eventName": ""
  },


];

function textChange(eventID){

  var dayID = eventID.target.value;

  jour.innerText = eventTable[dayID].dayName;
  evenement.innerText = eventTable[dayID].eventName;

}

var inputradio = document.querySelectorAll('.form-check-input');
var evenement = document.getElementById("evenement");
var jour = document.getElementById('jour');
for(i = 0; i < inputradio.length; i++){
  inputradio[i].addEventListener('click', textChange);
}

var buttonallday1 = document.getElementById('buttonallday1');
var buttonallday2 = document.getElementById('buttonallday2');
var buttonalloption = document.getElementById('buttonalloption');
var buttonall = document.getElementById('buttonall');

buttonall.addEventListener('click', textChange)
buttonallday1.addEventListener('click', textChange)
buttonallday2.addEventListener('click', textChange)
buttonalloption.addEventListener('click', textChange)
