<!DOCTYPE html>

<?php
require_once "Tuote.php";
session_start();

 if (isset($_POST["laheta"])){
 	$file = $_FILES['kuva'];
 	$kuva ="";
 	if(isset($file)){

 		 $image_name = $_FILES['kuva']['name'];
 		 $kuva = $image_name;
 	}
 	
    $tuote = new Tuote(
        $_POST["nimi"],
    	$_POST["valmistaja"],
        $_POST["hinta"],
    	$kuva,
        $_POST["kategoria"],
        $_POST["kuvaus"]
      );
    //laitetaan luokka sessioon
    $_SESSION["Stuote"] = $tuote;
    	
    // Tarkastetaan kentät
    $nimiVirhe = $tuote->checkNimi ();
    $valmistajaVirhe = $tuote->checkValmistaja ();
    $hintaVirhe = $tuote->checkHinta ();
    $kategoriaVirhe = $tuote->checkKategoria ();
    $kuvausVirhe = $tuote->checkKuvaus ( false );
    $kuvaVirhe = $tuote->checkKuva( false);
    
    // Tutkitaan, onko viheet nollia eli saadaanko siirtyä näyttösivulle
    if ($nimiVirhe == 0 && $valmistajaVirhe == 0 && $hintaVirhe ==0 && $kategoriaVirhe == 0 && $kuvausVirhe==0 ) {
    	
    	// Suljetaan istunto, koska sitä ei tarvita tällä sivulla
    	session_write_close ();
 	   header("location: tuoteListaus.php?lisays=1");
    	exit();
    }
    
 }elseif(
     isset($_POST["peruuta"])){
 	//poistetaan luokan olio sessiosta
 	unset($_SESSION["Stuote"]);
        header("location: index.php");
        exit ();
     
}else{
	//otetaan olio sessiosta jos sellaista on, muuten luodaan tyhjä olio
	// Katsotaan tultiinko tänne korjaus-linkin kautta
	if ( isset($_GET["korjaa"])) {
		$tuote = $_SESSION["Stuote"]; 
	}else {
		//luodaan tyhjä tuote
		$tuote = new Tuote();	
	}
	// Alustetaan virhemuuttujat
	$nimiVirhe = 0;
	$valmistajaVirhe = 0;
	$hintaVirhe = 0;
	$kuvaVirhe = 0;
	$kategoriaVirhe = 0;
	$kuvausVirhe = 0;
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
      <h2>Tuotteen lisääminen</h2>
      <!-- lahetysFormi-->
      <form  class="form-horizontal" id="lahetysform" action="tuoteLisays.php" method="post" enctype="multipart/form-data">
  
        <div class="form-group">
    <label class="col-sm-1 col-md-2 control-label">Tuotteen nimi</label>
    <div class="col-sm-4 col-md-4">
      <input type="text" class="form-control" name="nimi"  placeholder="Tuotteen nimi" value="<?php print(htmlentities($tuote->getNimi(), ENT_QUOTES, "UTF-8"));?>"/>
    <?php print ("<span class='pun'>") . $tuote->getError ( $nimiVirhe ) . ("</span>") ;?> 
    </div>
  </div>

          <div class="form-group">
    <label class="col-sm-1 col-md-2 control-label">Valmistaja</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="valmistaja"  placeholder="Tuotteen valmistaja" value="<?php print(htmlentities($tuote->getValmistaja(), ENT_QUOTES, "UTF-8"));?>"/>
    <?php print ("<span class='pun'>") . $tuote->getError ( $valmistajaVirhe ) . ("</span>") ;?> 
    </div>
  </div>
  
        <div class="form-group">
    <label class="col-sm-1 col-md-2 control-label">Hinta</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="hinta" placeholder="Hinta &euro;" value="<?php print(htmlentities($tuote->getHinta(), ENT_QUOTES, "UTF-8"));?>"/>
   	<?php print ("<span class='pun'>") . $tuote->getError ($hintaVirhe) . ("</span>") ;?>
    </div>
  </div>
        
       <div class="form-group">
    <label class="col-sm-1 col-md-2 control-label" value="<?php print(htmlentities($tuote->getKuva(), ENT_QUOTES, "UTF-8"));?>">Kuva</label>
    <div class="col-sm-4">
     <input type="file" name="kuva"/> 
     
   <!--   <?php echo "<PRE>" . print_r ($_FILES, true) . "</PRE>";?> -->
   <?php print ("<span class='pun'>") . $tuote->getError ($kuvaVirhe) . ("</span>") ;?>	
    </div>
  </div>


             
        <div class="form-group">
    <label class="col-sm-1 col-md-2 control-label">Kategoria</label>
    <div class="col-sm-4">
      					 <select name="kategoria" class="form-control" multiple="multiple" size="3">
							<option value="1" selected>category1</option>
							<option value="2">category2</option>
							<option value="3">Muu</option>
						</select>
							<?php print ("<span class='pun'>") . $tuote->getError ($kategoriaVirhe) . ("</span>") ;?>
    </div>
  </div>
        
        <div class="form-group">
    <label class="col-sm-1 col-md-2 control-label">Kuvaus</label>
    <div class="col-sm-4">
      <textarea class="form-control" name="kuvaus" rows="3" maxlength="300" placeholder="Kuvaus"><?php print(htmlentities($tuote->getKuvaus(), ENT_QUOTES, "UTF-8"));?></textarea>
       	<?php print ("<span class='pun'>") . $tuote->getError ($kuvausVirhe) . ("</span>") ;?>
    </div>
  </div>
        <!--END OF FORM INPUTS -->
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-12">
           		 <button class="btn btn-primary" type="submit" name="laheta">Lisää</button> 
                  <button class="btn btn-danger" type="submit" name="peruuta">Peruuta</button>
           </div>
        </div>
        
    </form><!--end of lahetysform-->
      
    </div><!--end of container-->

  <footer class="footer-default">Yhteystiedot</footer>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
   </body>
  </html>
  