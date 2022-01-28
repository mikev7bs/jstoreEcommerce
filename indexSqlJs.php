<!DOCTYPE html>
<html>
    <head>
      <?php
header('content-type: text/html; charset=utf-8');
$areaz ="";
$connect = "none";
$connected = "pas connecté";
$erreur = " pas de connexion";
$BogBoss = 0;
//require('db_base.php');

if(isset($_POST['formconnexion'])){
  session_start();
  require('db_hostbase.php');
$mailconnect=htmlspecialchars($_POST['email']);
$passconnect=$_POST['password'];

$request = $pdo->prepare("SELECT * FROM customers WHERE email = ? AND password = ?");
$request->execute(array($mailconnect, $passconnect));
$userexist = $request->rowCount();
if ($userexist == 1)
{
$userinfo = $request->fetch();
$_SESSION['id'] = $userinfo['id'];
$_SESSION['nom'] = $userinfo['nom'];
$_SESSION['prenom'] = $userinfo['prenom'];
$_SESSION['tel'] = $userinfo['tel'];
$_SESSION['email'] = $userinfo['email'];
$_SESSION['password'] = $userinfo['password'];
//$UsersNom = $userinfo['nom'];
//$UsersPrenom = $userinfo['prenom'];
//$UsersPseudo = $userinfo['pseudo'];
//$UsersTel = $userinfo['tel'];
$UsersEmail = $userinfo['email'];
if ($UsersEmail == "patrice.te.paris12@gmail.com") {
  $BogBoss = 75;
}
//$UsersPassword = $userinfo['password'];
$erreur = "connexion établie !";
$connected = $userinfo['prenom']." connecté !";
$connect = "yes";
}
else
   {
     $connect = "noneconect";
     $erreur = "Mauvais email ou mot de passe !";
  }
}

if (isset($_POST['forminscription'])) {
  session_start();
  require('db_hostbase.php');
  //if ($_POST['civil'] == "Femme") {
  //  $civilite = "Femme";
  //}  else {
  //  $civilite = "Homme";
//  }
  $civilite = $_POST['civil'];
  $nom = $_POST['nomIns'];
  $prenom = $_POST['prenomIns'];
  $tel = $_POST['telIns'];
  $email = $_POST['emailIns'];
  $password = $_POST['passwordIns'];
  $adresseliv = $_POST['AdresseLiv'];
  $adressefac = $_POST['AdresseFac'];
  $_SESSION['email'] = $_POST['emailIns'];
  $_SESSION['password'] = $_POST['passwordIns'];
  // Envoi d'un mail lors de la création d'un nouveau paasger/Client
  //ini_set('SMTP','smtp.free.fr');     //ini_set("sendmail_from","patrice.te.paris12@gmail.com");
  //ini_set('auth_username','patrice.te.paris12@gmail.com');    //ini_set('auth_password','bestone75');
  $insert = $pdo->prepare("INSERT INTO customers(civilite,nom,prenom,tel,email,password,adresseliv,adressefac) VALUES(?,?,?,?,?,?,?,?)");
  $insert->execute(array($civilite,$nom,$prenom,$tel,$email,$password,$adresseliv,$adressefac));
  $erreur = "Données enregistrées dans la base MysQL !";
  $connected = $_POST['prenom']." connecté !";
  $connect = "yes";
  $headers = 'From: <patrice.te.paris12@gmail.com>' . "\r\n";
  $headers .= 'Cc: patrice.te.paris12@gmail.com' . "\r\n";
  $to = "patrice.te.paris12@gmail.com";
  $subject = "Création d'un nouveau paasger/Client";
  $message = "Nouveau client/passager : ".$_POST['prenomIns'] . "\r\n" .$_POST['emailIns'];

  mail($to,$subject,$message,$headers);
}
if (isset($_POST['formAjouter'])) {
  session_start();
  require('db_hostbase.php');
  $nom = $_POST['AdProdNom'];
  $sourceImg = $_POST['AdProdImage'];
  $prix = $_POST['AdProdPrix'];
  $categ = $_POST['AdProdCat'];
  $decription = $_POST['AdProdDescrip'];
  $insert = $pdo->prepare("INSERT INTO produits(image,nom,prix,description) VALUES(?,?,?,?)");
  $insert->execute(array($sourceImg,$nom,$prix,$decription));
  $erreur = "Nouveu produit ajouté dans la base MysQL !";

  // envoi de mail pour confirmation d'enregistrement dans la base MysQL
  $headers = 'From: <patrice.te.paris12@gmail.com>' . "\r\n";
  $headers .= 'Cc: patrice.te.paris12@gmail.com' . "\r\n";
  $to = "patrice.te.paris12@gmail.com";
  $subject = "Création d'un nouveau produit";
  $message = $nom.'<br>'.$sourceImg.'<br>'.$prix.'<br>'.$decription;
  mail($to,$subject,$message,$headers);
  //$mode_ouverture = "a+";
  $file    = fopen( "NewProduct.txt", "a+" );
  $content = "";
   while(!feof($file)) {
   $content .= fgets($file);
  }
  $Dateday= date('d-m-y h:i:s');
  //$Dateday = date("d/m/Y"); // Affiche la date du jour
  fwrite($file, "\n\n"." --- Créationd'un nouveau produit ! ---");
  fwrite($file, "\n"."   ------------>   ".$Dateday);
  fwrite($file, "\n"."Nom :");
  fwrite($file, "\n".$nom);
  fwrite($file, "\n"."Source image :");
  fwrite($file, "\n".$sourceImg);
  fwrite($file, "\n"."Prix :");
  fwrite($file, "\n".$prix);
  fwrite($file, "\n"."Cathégorie produit :");
  fwrite($file, "\n".$categ);
  fwrite($file, "\n"."Decription :");
  fwrite($file, "\n".$decription);
  fclose($file);
  $areaz= $content;
}
?>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>JSTORE ECOMMERCE V.3</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<style media="screen">
body{
  margin: 0px;
  padding: 0px;
  overflow-y: hidden;
  overflow-x: hidden;
  background-color: grey;
}
#Recherche{
  position: absolute;
  width: 365px;
  height: 46px;
  line-height: 46px;
  top: 28px;
  left: 200px;
  padding: 2px 10px;
  padding-left: 48px;
  text-align: left;
  border-radius: 9px;
  color: darkblue;
  font-size: 16px;
  font-weight: bold;
  box-shadow: 3px 3px 3px silver;
}
#bigBoss{
  position: absolute;
  border: none;
  background-color: transparent;
  font-style: italic;
  top: 62px;
  left: 130px;
  color: white;
  text-shadow: 2px 2px 2px blue;
}
#Boky{
  position: absolute;
  border: none;
  background-color: transparent;
  font-style: italic;
  top: 62px;
  left: 70px;
  color: white;
  text-shadow: 2px 2px 2px green;
}
#Bokz{
  position: absolute;
  border: none;
  background-color: transparent;
  font-style: italic;
  top: 8px;
  left: 1200px;
  color: white;
  text-shadow: 2px 2px 2px green;
}
#Berror{
  position: absolute;
  border: none;
  background-color: transparent;
  font-style: italic;
  top: 71px;
  width: 250px;
  left: 975px;
  color: white;
  text-shadow: 2px 2px 2px red;
  animation: clignote 1.2s linear infinite;
}
@keyframes clignote {
  50% {
    opacity: .2; }
}

input{
  padding: 7px 8px;
  border-radius: 8px;
  width: 340px;
  color: darkblue;
  font-size: 15px;
}
h2{
  margin-left: 30px;
}
img{
  width: 32px;
  height: 32px;
}
nav{
  position: sticky;
  top: 0px;
  left: 0px;
  display: inline-block;
  width: 100%;
  height: 104px;
  background-color: beige;
  box-shadow: 2px 2px GREY;
  overflow-y: hidden;
  overflow-x: hidden;
  z-index: 999;
}
#ImgSearch{
  position: absolute;
  top: 35px;
  left: 208px;
  z-index: 10;
  border-radius: 30%;
}
button{
  border-radius: 10px;
  padding: 1px 8px;
}
#myButtonI{
  position: absolute;
  top: 15px;
  left: 1100px;
  height: 32px;
  color: white;
  border-radius: 10px;
  font-size: 14px;
  padding: 0px 10px;
  padding-top: -4px;
  text-shadow: 2px 2px 2px darkblue;
  background: linear-gradient(to bottom, grey 1%, silver 20%, grey 98%);
}
#myButtonC{
  position: absolute;
  top: 47px;
  left: 920px;
  height: 32px;
  color: white;
  border-radius: 10px;
  font-size: 14px;
  padding: 0px 10px;
  padding-top: -4px;
  text-shadow: 2px 2px 2px darkblue;
  background: linear-gradient(to bottom, grey 1%, silver 20%, grey 98%);
}
.flash2{
  box-shadow: 2px 2px 2px silver;
  height: 28px;
  line-height: 28px;
}
#BoxConnect{
width: 100%;
}
#PassWordMissed{
  position: absolute;
  top: 75px;
  left: 740px;
  color: green;
  text-shadow: 2px 2px 2px grey;
  font-style: italic;
  text-decoration: underline;
}
#EmailBox{
  position: absolute;
  border-radius: 12px;
  padding-left: 10px;
  top: 7px;
  left: 670px;
  width: 330px;
  height: 34px;
}
#PasswordBox{
  position: absolute;
  border-radius: 12px;
  padding-left: 10px;
  top: 45px;
  left: 670px;
  width: 230px;
  height: 34px;
}
#LOGO{
  position: absolute;
  top: 12px;
  left: 23px;
  font-size: 38px;
}
li{
  list-style-type: none;
  display: block;
  padding: 1px 20px;
  width: 200px;
  z-index: 111;
}

#MenuProduit{
  margin: 0;
  height: 45px;
  max-height: 45px;
  width: 805px;
  margin-left: 20px;
  border: 3px solid silver;
  border-radius: 12px;
}
#MenuProduit ul{
  list-style: none;  /** PERMET DE RETIRERE LES POINTS DES LISTES **/
  text-align: center;
  font-weight: bold;
  padding: 0;
  margin: 0;
  color: white;
  text-transform: uppercase;
  display: inline-flex;
  justify-content: center;
  height: 40px;
  font-size: 14px;
  line-height: 38px;
  background-color: cyan;
  border-radius: 12px;
}
#MenuProduit li:nth-child(1){
  background-color: rgb(175, 238, 238);
  border-radius: 10px 0px 0px 10px;
}
#MenuProduit li:nth-child(2){
  background-color: rgb(216, 191, 216);
}
#MenuProduit li:nth-child(3){
  background-color: rgb(175, 238, 238);
}
#MenuProduit li:nth-child(4){
  background-color: rgb(216, 191, 216);
  border-radius: 0px 10px 10px 0px;
}
#MenuProduit ul >li:hover ul li{
  border-radius: 0px;
  background-color: rgba(238, 232, 170, 1);
}
#MenuProduit ul li a{
text-decoration: none;
padding: 0px 35px;
width: 200px;
overflow: hidden;
}

#MenuProduit >ul >li:hover{
  background: linear-gradient(to bottom, orange 1%, yellow 20%, orange 98%);
}

#MenuProduit >ul >li >ul >li:hover{
  background: linear-gradient(to bottom, Violet 1%, Fuchsia 20%, Violet 98%);
}
#MenuProduit >ul >li >ul >li:hover a{
  font-weight: bold;
  color: white;
}
#MenuProduit ul >li:hover ul{
  display: block;
  position: absolute;
  margin-left: -20px;
  top: 152px;
  text-decoration: none;
  width: 200px;
}
#MenuProduit >ul >li >ul{
  display: none;
}
#ShowProduit{
  position: absolute;
  display: flex;
  flex-wrap: wrap;
  padding: 8px;
  top: 170px;
  left: 00px;
  width: 99%;
  height: 500px;
  border-radius: 2px;
  border: 2px solid grey;
  background-color: Lavender;
  overflow: hidden;
  overflow-y: scroll;
  scrollbar-color: DarkViolet cyan;
  scrollbar-width: thin;
}

.row{
  position: relative;
  display: none;
  width: 200px;
  height: 310px;
  border-radius: 10px;
  border: 1px solid grey;
  background-color: white;
  margin: 8px;
}
.titleProd{
  width: 100%;
  height: 40px;
  line-height: 40px;
  color: black;
  border-radius: 10px 10px 0px 0px;
  background-color: cyan;
  text-align: center;
  overflow: hidden;
}
.btnProd{
  position: absolute;
  width: 90px;
  height: 34px;
  bottom: 8px;
  right: 12px;
  cursor: pointer;
  color: #ffffff;
  font-family: Arial;
  font-size: 14px;
  text-align: center;
  border-radius: 15px;
  box-shadow: inset 0px 6px 15px 3px #23395e;
  background: linear-gradient(to bottom, cyan 1%, blue 50%);
}
.btnProd:hover{
  background: linear-gradient(to bottom, orange 1%, yellow 20%, orange 98%);
  text-shadow: 1px 1px blue;
  color: cyan;
}
#btn-Recherche{
  position: absolute;
  width: 60px;
  height: 52px;
  top: 26px;
  left: 578px;
  cursor: pointer;
  color: #ffffff;
  font-family: Arial;
  font-size: 16px;
  font-weight: bold;
  text-align: center;
  border-radius: 18px;
  box-shadow: inset 0px 6px 15px 3px #23395e;
  background: linear-gradient(to bottom, cyan 1%, blue 50%);
}
#btn-Recherche:hover{
  background: linear-gradient(to bottom, orange 1%, yellow 20%, orange 98%);
  text-shadow: 1px 1px blue;
  color: cyan;
}

.descProd{
  position: absolute;
  top: 160px;
  background-color: DarkKhaki;
  width: 100%;
  height: 85px;
  font-size: 14px;
  text-shadow: 1px 1px blue;
  text-align: center;
  overflow: hidden;
  padding: 2px;
  color: white;
}
.imgProd{
  position: absolute;
  padding: 6px;
  top: 40px;
  left: 30px;
  width: 140px;
  height: 120px;
}
.prixProd{
  position: absolute;
  padding: 1px 5px;
  top: 268px;
  left: 10px;
  width: 66px;
  height: 28px;
  color: blue;
  font-size: 14px;
  font-weight: bold;
  border-radius: 6px;
  background-color: pink;
  overflow: hidden;
}
li #menu:hover{
  background-color: orange;
}
#myButtonAj {
position: absolute;
width: 178px;
height: 40px;
left: 900px;
top: 115px;
text-align: center;
box-shadow: inset 0px 6px 15px 3px #23395e;
background: linear-gradient(to bottom, cyan 1%, blue 50%);
background-color: #2e466e;
border-radius: 15px;
border: 1px solid #979b9c;
display: inline-block;
cursor: pointer;
color: #ffffff;
font-family: Arial;
font-size: 14px;
padding: 2px 6px;
text-shadow: 3px 4px 1px #263666;
letter-spacing: 2px;
}
#myButtonS {
position: absolute;
width: 198px;
height: 40px;
left: 1100px;
top: 115px;
text-align: center;
box-shadow: inset 0px 6px 15px 3px #23395e;
background: linear-gradient(to bottom, cyan 1%, blue 50%);
background-color: #2e466e;
border-radius: 15px;
border: 1px solid #979b9c;
display: inline-block;
cursor: pointer;
color: #ffffff;
font-family: Arial;
font-size: 14px;
padding: 2px 6px;
text-shadow: 3px 4px 1px #263666;
letter-spacing: 2px;
}
#myButtonAj:hover, #myButtonS:hover {
background: linear-gradient(to bottom, orange 1%, yellow 20%, orange 98%);
text-shadow: 1px 1px blue;
font-weight: bold;
color: cyan;
}
#AdminProd{
  visibility: hidden;
}

.menu {
  position: absolute;
  padding-left: 20px;
  top: 10px;
  left: 1000px;
  background: #62278d;
  background: -webkit-linear-gradient(top,  #62278d 0%,#2cc09b 100%);
  background: linear-gradient(to bottom,  #62278d 0%,#2cc09b 100%);
  width: 380px;
  height: 540px;
  border-width: 20px 0;
  border-style: solid;
  border-color: #fff;
  border-radius: 10px;
  color: #fff;
  -webkit-transform-style: preserve-3d;
          transform-style: preserve-3d;
  -webkit-transition: all 0.5s ease-in-out;
          transition: all 0.5s ease-in-out;
  -webkit-box-shadow: 0 0 50px 0 #444;
          box-shadow: 0 0 50px 0 #444;
   overflow: hidden;
}
.menu2 {
  position: absolute;
  padding-left: 20px;
  top: 10px;
  left: 1000px;
  background: #62278d;
  background: -webkit-linear-gradient(top,  #62278d 0%,#2cc09b 100%);
  background: linear-gradient(to bottom,  #62278d 0%,#2cc09b 100%);
  width: 340px;
  height: 560px;
  border-width: 20px 0;
  border-style: solid;
  border-color: #fff;
  border-radius: 10px;
  color: #fff;
  -webkit-transform-style: preserve-3d;
          transform-style: preserve-3d;
  -webkit-transition: all 0.5s ease-in-out;
          transition: all 0.5s ease-in-out;
  -webkit-box-shadow: 0 0 50px 0 #444;
          box-shadow: 0 0 50px 0 #444;
   overflow: hidden;
}

.flash{
  box-shadow: 2px 2px 2px 3px cyan;
  height: 32px;
  margin: 10px 0px;
}
.flash2{
  box-shadow: 2px 2px 2px 3px cyan;
  height: 32px;
  margin: 25px 0px;
}
#AdProduits{
  position: absolute;
  top: -200px;
  margin-left: -100px;
  visibility: hidden;
  opacity: .3;
  transition: .8s;
  z-index: 990;
}

#InscriptionProd{
  position: absolute;
  top: -200px;
  visibility: hidden;
  opacity: .3;
  transition: .8s;
  z-index: 990;
}

#InscriptionH3{
  margin-top: -18px;
  text-align: center;
  text-shadow: 1px 1px 5px black, 0 0 5px blue, 0 0 4px darkblue;
  font-size: 20px;
}
#myButtonA, #myButtonInS {
position: absolute;
display: block;
margin-top: 12px;
width: 198px;
height: 40px;
left: 100px;
top: : 220px;
text-align: center;
box-shadow: inset 0px 6px 15px 3px #23395e;
background: linear-gradient(to bottom, cyan 1%, blue 50%);
background-color: #2e466e;
border-radius: 15px;
border: 1px solid #979b9c;
cursor: pointer;
color: #ffffff;
font-family: Arial;
font-size: 16px;
padding: 2px 6px;
text-shadow: 3px 4px 1px #263666;
letter-spacing: 3px;
}
#myButtonA {
margin-top: 22px;
margin-left: 10px;
height: 48px;
}
#myButtonA:hover, #myButtonInS:hover{
background: linear-gradient(to bottom, orange 1%, yellow 20%, orange 98%);
text-shadow: 1px 1px blue;
font-weight: bold;
color: cyan;
}

#CloseIns{
  position: relative;
  left: 318px;
  top: 7px;
}
#CloseAD{
  position: relative;
  left: 280px;
  top: 7px;
}
.closeBord{
  border-radius: 50%;
  display: inline;
}
#civiliteF{
  position: absolute;
  display: block;
  width: 22px;
  height: 22px;
  background-color: beige;
  top: 48px;
  left: 110px;
}
#CivFem{
  position: absolute;
  display: block;
  top: 44px;
  left: 50px;
}
#civiliteH{
  position: absolute;
  display: block;
  width: 22px;
  height: 22px;
  background-color: beige;
  top: 48px;
  left: 248px;
}
#CivHom{
  position: absolute;
  display: block;
  top: 44px;
  left: 280px;
}
#NomIns{
  margin-top: 40px;
}
#AdProdNom, #AdProdImage, #AdProdPrix, #AdProdCat{
  display: grid;
margin-left: 10px;
width: 280px;
height: 48px;
}
#AdProdDescrip{
  margin-left: 10px;
  width: 280px;
  height: 78px;
  border-radius: 10px;
  padding: 5px 8px;
  resize: none;
  font-size: 13px;
  border: 2px solid grey;
  color: darkblue;
  background-color: beige;
  box-shadow: 2px 2px 2px 3px DarkViolet;
}
#Area{
  position: absolute;
  resize: none;
  top: 500px;
  left: 100px;
  padding: 10px 20px;
  border-radius: 10px;
  background-color: cyan;
  color: darkblue;
  visibility: hidden;
  opacity: 0;
  transition: .8s;
  overflow-y: scroll;
}

#AlertRow{
  position: relative;
  width: 400px;
  height: 200px;
  top: 200px;
  left: 30%;
  margin-left: 50px;
  border-radius: 10px;
  border: 1px solid grey;
  background-color: beige;
}

#AlertTitre{
  position: aboslute;
  text-align: center;
  color: white;
  width: 100%;
  height: 50px;
  margin-top: 0px;
  line-height: 50px;
  border-radius: 10px 10px 0px 0px;
  background-color: DarkOrchid;
}

#AlertMsg{
  position: aboslute;
  text-align: center;
  width: 100%;
  height: 120px;
  line-height: 110px;
  top: 80px;
  left: 600px;
  background-color: beige;
}

#Alertbtn{
position: absolute;
display: block;
width: 60px;
height: 40px;
left: 160px;
top: 150px;
text-align: center;
box-shadow: inset 0px 6px 15px 3px #23395e;
background: linear-gradient(to bottom, cyan 1%, blue 50%);
background-color: #2e466e;
border-radius: 15px;
border: 1px solid #979b9c;
cursor: pointer;
color: #ffffff;
font-family: Arial;
font-size: 16px;
padding: 2px 6px;
text-shadow: 3px 4px 1px #263666;
letter-spacing: 3px;
}
#Alertbtn:hover{
background: linear-gradient(to bottom, orange 1%, yellow 20%, orange 98%);
text-shadow: 1px 1px blue;
font-weight: bold;
color: cyan;
}
#boxAlert{
position: fixed;
top: 0px;
left: 0px;
width: 100%;
height: 100vh;
background-color: rgba(0,0,0,.2);
visibility: hidden;
}

</style>
</head>
 <body>
   <nav>
     <div id="LOGO">JSTORE</div>
     <i id="OpenBar" class="fa fa-bars" onClick='ShowBox()'></i>
     <img id="ImgSearch" src="TransportPlus\images\search.png" alt="">
     <input id="Recherche" type="text" placeholder="Chercher un article ...">
     <button id="btn-Recherche" class="bouton" type="button" name="">OK</button>
    <div id="ConnexionID">
     <button id="myButtonI" class="bouton" type="button" name="inscription" onclick='DoInscription()'>inscription</button>
     <!-- la fenetre de connexion -->
        <form action="" method="post">
          <input id="EmailBox" type="email" name="email"  placeholder="Entrez votre Email :" ondblclick='eraseFill(5)' required>
          <input id="PasswordBox" type="password" name="password"  placeholder="Entrez votre mot de passe :" ondblclick='eraseFill(6)' required><br>
          <a id="PassWordMissed" href="" onclick="EnvoiMail()">Mot de passe oublié ?</a>
          <button id="myButtonC" class="bouton" type="submit" name="formconnexion">connexion</button>
        </form>
    </div>
    <div id="boxAlert">
    <div id="AlertRow">
      <div id="AlertTitre">ALERT BOX</div>
      <div id="AlertMsg">Création d'un nouveau produit</div>
      <button id="Alertbtn" class="" type="button" name="" onclick='closeBox()'>OK</button>
    </div>
   </div>
        <input id="Boky" name="lname" type="text" disabled value="<?php echo( htmlspecialchars( $connect ) ); ?>" />
        <input id="Bokz" name="lname" type="text" disabled value="<?php echo( htmlspecialchars( $connected ) ); ?>" />
          <div class="">
           <input id="Berror" name="lname" type="text" disabled value="<?php echo( htmlspecialchars( $erreur ) ); ?>" />
          </div>
        <input id="bigBoss" name="lname" type="text" disabled value="<?php echo( htmlspecialchars( $BogBoss ) ); ?>" />
   </nav>

   <div id="MenuProduit">
     <ul>
       <li id="menu"><a href="#MenuAccueil" onclick='DoRechercheListe(20)' class="">Accueil</a></li>
       <li id="menu"><a href="#MenuFemme" class="">Femme</a>
         <ul>
           <li id="sous-menu"><a href="javascript:DoRechercheListe(1);" class="">Bottes</a></li>
           <li id="sous-menu"><a href="javascript:DoRechercheListe(2);" class="">Vetêments</a></li>
           <li id="sous-menu"><a href="javascript:DoRechercheListe(3);" class="">Accessoires</a></li>
           <li id="sous-menu"><a href="javascript:DoRechercheListe(8);" class="">Sac à main</a></li>
         </ul>
       </li>
       <li id="menu"><a href="#" class="">Homme</a>
       <ul>
         <li id="sous-menu"><a href="javascript:DoRechercheListe(4);" class="">Bottes</a></li>
         <li id="sous-menu"><a href="javascript:DoRechercheListe(5);" class="">Vetêments</a></li>
         <li id="sous-menu"><a href="javascript:DoRechercheListe(6);" class="">Accessoires</a></li>
       </ul>
     </li>
       <li id="menu"><a href="#" onclick='DoRechercheListe(9)' class="">Accessoires</a></li>
     </ul>
   </div>

<div id="AdminProd">
  <button id="myButtonAj" class="bouton" type="button" name="" onclick='createFileNewProd()'>Ajouter un article</button>
  <button id="myButtonS" class="bouton" type="button" name="" onclick='DoAjouter()'>Supprimer un article</button>
</div>
<div id="InscriptionProd">
             <div id="menus" class="menu">
               <div id="CloseIns">
              <a href="javascript:CloseMenu(1);"><img class="closeBord" src="TransportPlus\images\close-green.jpg"></a></div>
               <div id="InscriptionH3">I  N  S  C  R  I  P  T  I  O  N</div>
        <form action="" method="post">
          <input type="radio" id="civiliteF" name="civil" value="Femme" checked>
          <label id="CivFem" for="civiliteF">Femme</label>
          <input type="radio" id="civiliteH" name="civil" value="Homme">
          <label id="CivHom" for="civiliteH">Homme</label>
           <input id="NomIns" class="flash" type="text" name="nomIns"  placeholder="Entrez votre Nom :" ondblclick='eraseFill(1)' required>
           <input id="PrenomIns" class="flash" type="text" name="prenomIns"  placeholder="Entrez votre Prénom :" ondblclick='eraseFill(2)' required>
           <input id="TelBox" class="flash" type="tel" name="telIns"  placeholder="Entrez votre Téléphone :" ondblclick='eraseFill(3)' required>
           <input id="EmailIns" class="flash" type="email" name="emailIns"  placeholder="Entrez votre Email :" ondblclick='eraseFill(4)' required>
           <input id="PasswordIns" class="flash" type="password" name="passwordIns"  placeholder="Entrez votre mot de passe :" ondblclick='eraseFill(5)' required>
           <input id="AdresseLiv" class="flash" type="text" name="AdresseLiv"  placeholder="Entrez votre adresse de livraison :" ondblclick='eraseFill(6)' required>
           <input id="AdresseFac" class="flash" type="text" name="AdresseFac"  placeholder="Entrez votre adresse de facturation :" ondblclick='eraseFill(7)' required>
          <button id="myButtonInS" class="bouton" type="submit" name="forminscription">INSCRIPTION</button>
        </form>
      </div>
 </div>
 <div id="AdProduits">
      <div id="menus" class="menu2">
                <div id="CloseAD">
               <a href="javascript:CloseMenu(2);"><img class="closeBord" src="TransportPlus\images\close-green.jpg"></a></div>
                <div id="InscriptionH3">Ajout produit</div>
         <form action="" method="post">
            <input id="AdProdNom" class="flash2" type="text" name="AdProdNom"  placeholder="Nom du produit:" ondblclick='eraseFill(1)' required>
            <input id="AdProdImage" class="flash2" type="text" name="AdProdImage"  placeholder="Source du produit :" ondblclick='eraseFill(2)' required>
            <input id="AdProdPrix" class="flash2" type="tel" name="AdProdPrix"  placeholder="Prix du produit :" ondblclick='eraseFill(3)' required>
            <input id="AdProdCat" class="flash2" type="tel" name="AdProdCat"  placeholder="Cathégorie du produit :" ondblclick='eraseFill(4)' required>
            <textarea id="AdProdDescrip" name="AdProdDescrip" rows="8" cols="80" placeholder="Description :" ondblclick='eraseFill(5)' required></textarea>
            <button id="myButtonA" class="bouton" type="submit" name="formAjouter" ondblclick='createFileNewProd()'>AJOUTER</button>
         </form>
       </div>
  </div>
   <div id="ShowProduit"></div>
   <textarea id="Area" name="Area" rows="5" cols="80"><?php echo( htmlspecialchars( $areaz ) ); ?></textarea>

<script type="text/javascript" src="ProductData.js"></script>
<script type="text/javascript" src="Jstore.js"></script>
  <script type="text/javascript">
  window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  $('nav').css('top', '0px');
}

  $(document).ready(function(){

    $('#myButtonI').click(function(){
      $('#InscriptionProd').css('visibility', 'visible');
      $('#InscriptionProd').css('opacity', '1');
      $('#InscriptionProd').css('top', '120px');
    });
    $('#myButtonAj').click(function(){
      $('#AdProduits').css('visibility', 'visible');
      $('#AdProduits').css('opacity', '1');
      $('#AdProduits').css('top', '100px');
    });
    $('#CloseIns').click(function(){
      $('#InscriptionProd').css('visibility', 'hidden');
      $('#InscriptionProd').css('opacity', '.3');
      $('#InscriptionProd').css('top', '-200px');
    });
    $('#CloseAD').click(function(){
      $('#AdProduits').css('visibility', 'hidden');
      $('#AdProduits').css('opacity', '.3');
      $('#AdProduits').css('top', '-200px');
    });

    $("#Recherche").dblclick(function(){
      $('#Recherche').val("");
      //document.getElementById('Recherche').value = "";
    });
    $('nav').dblclick(function(){
      $('#bigBoss').val(0);
      $('#AdminProd').css('visibility', 'hidden');
    });
    $('nav').click(function(){
      var RTL = $('#bigBoss').val();
      if (RTL == 75) {
        $('#AdminProd').css('visibility', 'visible');
      }
    });
});

  function doSomething(){
    $('#ShowProduit').empty();
  }

 function DoPanier(){
  var monTableau = ["Pierre", "Paul", "Jean"];
  console.log(monTableau);
  monTableau[1] = monTableau[2];
  monTableau.pop();  // effacer le dernier élément du tableau
  console.log(monTableau);
  }

  function ShowConnect(){
    var dbConnect = document.getElementById("Boky").value;
    if (dbConnect == "yes") {
      alertBox(3);
      //alert("Déjà connecté !");
      CloseBox();
      return;
    }
    ConectPlus = "YES";
    //document.getElementById("UsersConnection").innerText="none";
    document.getElementById("Boky").value="";
    document.getElementById("EmailBox").value="";
    document.getElementById("EmailBox").innerText="";
    document.getElementById("PasswordBox").value="";
    document.getElementById("PasswordBox").innerText="";
    document.getElementById('BoxConnexion').style.top = "10px";
    document.getElementById('BoxConnexion').style.opacity = "0";
    document.getElementById('BoxConnexion').style.visibility = "hidden";
    document.getElementById('BoxConnect').style.opacity = "1";
    document.getElementById('BoxConnect').style.visibility = "visible";
  }
  function CloseBox(){
    document.getElementById('BoxConnexion').style.top = "10px";
    document.getElementById('BoxConnexion').style.opacity = "0";
    document.getElementById('BoxConnexion').style.visibility = "hidden";
    document.getElementById('OpenBar').style.opacity = "1";
    document.getElementById('OpenBar').style.visibility = "visible";
  }
  function CloseConnect(){
    document.getElementById('BoxConnect').style.opacity = "0";
    document.getElementById('BoxConnect').style.visibility = "hidden";
    document.getElementById('OpenBar').style.opacity = "1";
    document.getElementById('OpenBar').style.visibility = "visible";
  }

  function EnvoiMail(){

  }

  </script>

  </body>
  </html>
