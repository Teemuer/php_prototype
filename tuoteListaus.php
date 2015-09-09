<!DOCTYPE html>
<?php 
require_once 'Tuote.php';

session_start();

if (isset($_POST["korjaa"])){	
	header("location: tuoteLisays.php?korjaa=1");
	//päätetään sessio tältä sivulta
	session_write_close();
	exit();

}elseif (isset($_POST["tallenna"])){
	//otetaan tuote sessiosta tallennusta varten
	$tuote = $_SESSION["Stuote"];
	try {
		require_once "TuotePDO.php";
		 
		$kantakasittely = new TuotePDO ();
		 
		//lisaaTuote palauttaa id:n ->lastinsertid()
		$id = $kantakasittely->tuoteLisays ( $tuote );
		 
		// Muutetaan istunnossa olevan olion id lisäykseltä saaduksi id:ksi
		$_SESSION ["Stuote"]->setId ( $id );
	} catch ( Exception $error ) {
		session_write_close ();
		header ( "location: virhe.php?sivu=" . urlencode ( "Lisäys" ) . "&virhe=" . $error->getMessage () );
		exit ();
	}
	header("location: varmistus.php?varmistus=1");
	exit();

}elseif (isset($_POST["peruuta"])){
	unset($_SESSION ["Stuote"]);
	header("location: index.php");
	exit();
}else{
	// Katsotaan tultiinko tänne lisäyssivulta
	if (! isset($_GET["lisays"])) {
		header ( "location: index.php" );
		exit ();	
	}else if(isset($_SESSION["Stuote"])){
		$tuote = $_SESSION["Stuote"];
	}else {
		$tuote = new Tuote();
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
      <h2>Tarkista tuotteen tiedot!</h2>
		
		<?php 
		print ("<p>Nimi: ".$tuote->getNimi());
		print ("<p>Valmistaja: ".$tuote->getValmistaja());
		print ("<p>Hinta: ".$tuote->getHinta());
		print ("<p>Kategoria: ".$tuote->getKategoria());
		print ("<p>Kuvaus: ".$tuote->getKuvaus());
		?>
<div>
<img src="<?php print  $tuote->getKuva()?>" alt="picture"/>
</div>
<form class="btn-group"  action="tuoteListaus.php" method="post">
<button class="btn btn-primary" type="submit" name="tallenna">tallenna</button>
<button class="btn btn-danger" type="submit" name="peruuta">peruuta</button>
<button class="btn btn-warning" type="submit" name="korjaa">korjaa</button>
</form>
    </div><!--end of container-->

  <footer class="footer-default">Yhteystiedot</footer>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
   </body>
  </html>