var Pop = 0;
var BdFilmPref = new Array(5);
var Tor;
var ProduitsZ;
var MyWindow;
var SourceURL;
var ListProd;
var Prod;
var Panier = [];
var ProdNameUp = [];
var ProdNameDown = [];
var ProdPriceUp = [];
var ProdPriceDown = [];
var ProdPrices = [];
var ProdNames = [];
var LastRecherchs = "promo";
// création de la liste de films dans le cathalogue
for (var i = 1; i < (ProductData.length); i++) {
   ProdNameUp[0] = "Produit ordre croissant";
   ProdNameDown[0] = "Produit ordre décroissant";
   ProdPriceUp[0] = "Prix ordre croissant";
   ProdPriceDown[0] = "Prix ordre décroissant";
   ProdNames[0] = "Le nom de tous les produits";
   ProdPrices[0] = "Le prix de tous les produits";
DoCreateProduits(i);
}

DoProduitsALL();

function DoProduitsALL(){
  ProduitsZ = (ProductData.length);
  console.log(ProduitsZ);
  console.log("----");
  console.log(ProdNames);
  console.log("-----");
  console.log(ProdPrices);
  DoAddListenerAllbtn();
  Panier[0] = "Liste des produits du panier";
  DoRechercheListe(20);
}


    //$(this).attr('disabled','disabled');


function DoAddListenerAllbtn(){
  var BtnAll = document.getElementsByClassName("btnProd");
  console.log(BtnAll);
  for (i = 0; i < BtnAll.length; i++) {
     BtnAll[i].addEventListener("click", DoAjouter);
   }
}

function DoAjouter(event){
  var Btnz = document.getElementsByClassName("btnProd");
  var ElementSurvole = event.target.parentNode;
  console.log(ElementSurvole);
  var IdProdz = ElementSurvole.id;
  IdProdz = parseInt(IdProdz);
  console.log(IdProdz);
    for (i = 1; i < (Panier.length + 1); i++) {
      var TT = Panier[i];
 if (IdProdz == TT) {
   alertBox(2);
   //alert("déjà dans la liste");
   return;
   }
}
  Panier.push(IdProdz);
  console.log(Panier);
}

function DoCreateProduits(ProduitsZ){
  var cathalogue = document.getElementById('ShowProduit');
  var Produits = document.createElement("div");
  var ProdTitre = document.createElement("p");
  var ProdImg = document.createElement("img");
  var ProdDesc = document.createElement("p");
  var ProdPrice = document.createElement("p");
  var Prodbtn = document.createElement("button");
  Produits.className="row";
  Produits.id = ProduitsZ;
  ProdTitre.className="titleProd";
  ProdTitre.innerText = ProductData[ProduitsZ].nom;
  //ProdTitre.disabled = "true";
  ProdImg.className="imgProd";
  ProdImg.src = ProductData[ProduitsZ].SourceImg;
  ProdDesc.className="descProd";
  ProdDesc.innerText = ProductData[ProduitsZ].Descriptif;
  ProdPrice.className="prixProd";
  ProdPrice.innerText = ProductData[ProduitsZ].Prix + " €";
  Prodbtn.className="btnProd";
  Prodbtn.id = ProduitsZ;
  Prodbtn.innerHTML="Ajouter";
  Produits.appendChild(ProdTitre);
  Produits.appendChild(ProdImg);
  Produits.appendChild(ProdDesc);
  Produits.appendChild(ProdPrice);
  Produits.appendChild(Prodbtn);
  //Produits.addEventListener("mouseover", DoAffiche);
  //Produits.addEventListener("mouseleave", DonotAffiche);
  Produits.addEventListener("dblclick", Clickselection);
  cathalogue.appendChild(Produits);
}


document.getElementById('btn-Recherche').addEventListener("click", DoRecherche2);
document.getElementById('Recherche').addEventListener("dblclick", DoChange);
//document.getElementById('Recherche').addEventListener("keyup", DoChange);
//document.getElementById('Film1').addEventListener("click", Selection1);
//document.getElementById('Film2').addEventListener("click", Selection2);
//document.getElementById('Film3').addEventListener("click", Selection3);
//document.getElementById('FilmPref1').addEventListener("mouseover", Selection1b);
//document.getElementById('FilmPref2').addEventListener("mouseover", Selection2b);
//document.getElementById('FilmPref3').addEventListener("mouseover", Selection3b);


//document.getElementById('Recherche').addEventListener("onchange", DoChange);

function DoRecherche(){
  //DoRecherche2();
  //return;
  var Recherch = document.getElementById('Recherche').value;
  if (Recherch.length < 3) {
    return;
}

Recherch = Recherch.toLowerCase();
console.log(Recherch);
console.log(LastRecherchs);
var Produits;
ListProd = 0;
for (var i = 1; i < ProductData.length; i++) {
  var Seektitre = ProductData[i].categorie;
  Seektitre = Seektitre.toLowerCase();
 Produits = document.getElementById(i);
  if (Seektitre.includes(Recherch) == false) {   // test si inputValue dans chaque titre
          Produits.style.display = "none";
        } else {
          Produits.style.display = "inline-block";
            //console.log(Seektitre);
            ListProd++;
        }
   }
   if (ListProd == 0) {
     alertBox(1);
     //alert("Aucun article trouvé !");
     DoLastRecherche();
     return;
   }
   LastRecherchs = Recherch;
}

function DoLastRecherche(){
console.log(LastRecherchs);
  var Produits;
  ListProd = 0;
  for (var i = 1; i < ProductData.length; i++) {
    var Seektitre = ProductData[i].categorie;
    Seektitre = Seektitre.toLowerCase();
    Produits = document.getElementById(i);
    if (Seektitre.includes(LastRecherchs) == false) {   // test si inputValue dans chaque titre
            Produits.style.display = "none";
          } else {
            Produits.style.display = "inline-block";
              //console.log(Seektitre);
              ListProd++;
          }
     }
}

function DoChange(){

}
function DoInscription(){

}

function DoAffiche(event){
 var Descriptos = document.getElementById('Recherche');
 var ElementSurvole = event.target.parentNode;
 var Idfilms = ElementSurvole.id;
 if (Idfilms == "cathalogue") {
   console.log("error pas cathalogue !");
   return;
 }
 Descriptos.innerText = ProductData[Idfilms].Descriptif
}

function DonotAffiche(event){
  var Descriptos = document.getElementById('Recherche').innerText = "";
}


function Clickselection(event){    // permet de retirer un film du Top 2
  var ElementSurvole = event.target.parentNode;
  var Idfilms = ElementSurvole.id;
  SourceURL = ProductData[Idfilms].SourceVid;
  if (SourceURL) {
    //$("#boxMovie").show();
    $('#Recherche').css('visibility', 'visible');
    $('#Recherche').attr('src', SourceURL);
    //MyWindow = window.open(SourceURL, "myWindow","width=800, height=630");
    //resizeWin();
    FilmEnCours = ProductData[Idfilms].nom;
    Movies = 10;
  }
} // fin function Clickselection

function DoReset(){
  for (var i = 1; i < ProductData.length; i++) {
    document.getElementById(i).style.display = "none";
//     $('#cathalogue').empty();
//   $('#Recherche').remove();
  }
}

function CloseBox(){
  if (Movies == 10) {
  //$('iframe').attr('src', $('iframe').attr('src'));
  }
//$("#boxMovie").hide();
$('#boxMovie').css('visibility', 'hidden');
//document.getElementById("boxMovie").style.visibility = "hidden";
}

function DoRecherche2(){
  var Recherch = document.getElementById('Recherche').value;
  if (Recherch.length < 3) {
    return;
}

Recherch = Recherch.toLowerCase();
//Recherch = Recherch.toString();
console.log(Recherch);
var Produits;
var Seektitre;
var regex;
var FindOut;

for (var i = 1; i < ProductData.length; i++) {
 Seektitre = ProductData[i].categorie;
 //Seektitre = Seektitre.toString();

  Seektitre = Seektitre.toLowerCase();
 Produits = document.getElementById(i);

regex = new RegExp(Recherch);
 FindOut = regex.test(Seektitre);
 console.log(FindOut);

   if (FindOut == false) {   // test si inputValue dans chaque titre
          Produits.style.display = "none";
        } else {
          Produits.style.display = "inline-block";
            console.log(Seektitre);
        }
   }
}

function DoRechercheListe(Prod){
  switch (Prod) {
    case 1:
    Recherch = "bottes femme";
    break;
    case 2:
    Recherch = "vetements femme";
    break;
    case 3:
    Recherch = "accessoires femme";
    break;
    case 4:
    Recherch = "bottes homme";
    break;
    case 5:
    Recherch = "vetements homme";
    break;
    case 6:
    Recherch = "accessoires homme";
    break;
    case 7:
    Recherch = "bazard";
    break;
    case 8:
    Recherch = "sac à main";
    break;
    case 9:
    Recherch = "accessoire";
    break;
    case 20:
    Recherch = "promo";
    break;
  }
Recherch = Recherch.toLowerCase();
var Produits;
ListProd = 0;
for (var i = 1; i < ProductData.length; i++) {
  var Seektitre = ProductData[i].categorie;
  Seektitre = Seektitre.toLowerCase();
 Produits = document.getElementById(i);
 if (Seektitre.includes(Recherch) == false) {   // test si inputValue dans chaque titre
         Produits.style.display = "none";
       } else {
         Produits.style.display = "inline-block";
           ListProd++;
        console.log(Seektitre);
       }
   }
   if (ListProd == 0) {
     alertBox(1);
     //alert("Aucun article trouvé !");
     DoLastRecherche();
     return;
   }
   LastRecherchs = Recherch;
}

function alertBox(Pop){
  switch (Pop) {
    case 1:
    $("#AlertMsg").html("Aucun article trouvé !");
    break;
    case 2:
    $("#AlertMsg").html("déjà dans la liste !");
    break;
	case 3:
    $("#AlertMsg").html("Déjà connecté !");
    //$('#AlertMsg').text('Hello world');
    break;
   }
   $('#boxAlert').css('visibility', 'visible');
   //$('#boxAlert').show();
}
function closeBox(){
//$('#boxAlert').hide();
$('#boxAlert').css('visibility', 'hidden');
 }
