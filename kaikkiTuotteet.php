<!DOCTYPE html>
<?php
require_once "TuotePDO.php";
require_once 'Tuote.php';

if (isset($_POST["id"])){
	if (isset($_POST["nayta"])){
			//lisätään id osoiteriviin
			$id = $_POST["id"];			
			 header("location: naytaTuote.php?id=".$id);
			 exit();
			 
	}elseif (isset($_POST["poista"]) ){
		$id = $_POST["id"];
		$tuotepdo = new TuotePDO();
		//poista tuote
		$tuotepdo->poistaTuote($id);
		
	}
}

   ?>
<html>
  <head>
  <meta  charset="utf-8">
  <title>Tuotesofta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
 <link rel="stylesheet" href="tyyli.css"/>
  </head> 
   
<body>
  <header>
    <nav class="col-md-12 navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
         <div class="navbar-header">
      <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapseNavbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Brand</a>
    </div>    
      <div class="collapse navbar-collapse" id="collapseNavbar">
      <ul class="nav navbar-nav">
<!--  <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li> -->	

<li role="presentation"><a href="index.php">Etusivu</a></li>
<li role="presentation"><a href="kaikkiTuotteet.php">Kaikki tuotteet</a></li>
<li role="presentation"><a href="tuoteLisays.php">Lisää tuote</a></li>
<li role="presentation"><a href="asetukset.php">Asetukset</a></li>
            
    </ul>
    </div> <!--collapseNavbar-->
    </div> <!-- container-fluid-->
      </nav>
  </header>
  
   
    <div class="container">
<h2>Kaikki tuotteet</h2>
<?php
try
{
   require_once "TuotePDO.php";

   $kantakasittely = new TuotePDO();
   $rivit = $kantakasittely->kaikkiTuotteet();

   foreach ($rivit as $tuote) {
   	$tuotekuva = $tuote->getKuva();
   	$id = $tuote->getId();
   	
   	print ("<form class='col-md-3 thumbnail' action='kaikkiTuotteet.php' method='POST' >");
   	print("<p>Nimi: " . $tuote->getNimi());
   	print("<br>Valmistaja: " . $tuote->getValmistaja());
   	print("<br>Hinta: " . $tuote->getHinta());
	print("<br>Kuvaus: " . $tuote->getKuvaus() . "</p>\n");
	//haetaan kuvan osoite (path)
	print ("<img class=\"thumbnail\" src=\"$tuotekuva\" width=\"100px\" height=\"100px\"\/>");
	
	print ("  <input type='hidden' name='id' value='$id'>
			  <input class='btn btn-primary' type='submit' name='nayta' value='Näytä'>
			  <input class='btn btn-danger' type='submit' name='poista' value='Poista'>
				</form>");
   }
} catch (Exception $error) {
	 header("location: virhe.php?sivu=Listaus&virhe=" . $error->getMessage());
	 exit;
}

?>

    </div><!--end of container-->

  <footer class="footer-default">Yhteystiedot</footer>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
   </body>
  </html>