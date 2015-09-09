<!doctype html>
<?php 
require_once 'Tuote.php';
// Katsotaan tultiinko tänne listaus
	if (! isset($_GET["varmistus"])) {
		header ( "location: index.php" );
		exit ();	
	}else if(isset($_SESSION["Stuote"])){
		unset($_SESSION ["Stuote"]);
	}else {
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
              <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                <li role="presentation"><a href="index.php">Etusivu</a></li>
                  <li role="presentation"><a href="tuoteLisays.php">Lomake</a></li>
          <li role="presentation"><a href="tuoteListaus.php">Listaus</a></li>     
          <li role="presentation"><a href="asetukset.php">Asetukset</a></li>
            
    </ul>
    </div> <!--collapseNavbar-->
    </div> <!-- container-fluid-->
      </nav>
  </header>
  
   
    <div class="container">
      <h2>Tuote on tallennettu tiedoilla:</h2>
   
		<p>Sinut uudelleenohjataan etusivulle 5 sekunnin kuluttua...</p>
		<?php
		header ( "refresh:5; url=index.php" );
		exit();
	?>
    </div><!--end of container-->

  <footer class="footer-default">Yhteystiedot</footer>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
   </body>
  </html>