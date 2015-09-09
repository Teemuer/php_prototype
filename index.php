
<!DOCTYPE HTML>
<html lang="eng">
<head>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
<link rel="stylesheet" href="tyyli.css"/>

<title>pohja</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<header>
<nav class="col-md-12 navbar navbar-default navbar-fixed-top">
<div class="container-fluid">
<div class="navbar-header">
<button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapseNavbar">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar">+</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>

<a class="navbar-brand" href="#">Brand</a>
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

<body>
<div class="container">
<!-- lahetysFormi-->
<h2>Tervetuloa <?php if(isset($_COOKIE["nimikeksi"])){
	print $_COOKIE["nimikeksi"];
}?></h2>

<div>

<ul class="nav-stacked nav-pills">
<li role="presentation"><a href="kaikkiTuotteet.php">Kaikki tuotteet</a></li>
<li role="presentation"><a href="tuoteLisays.php">Lisää tuote</a></li>
<li role="presentation"><a href="asetukset.php">Asetukset</a></li>
</ul>
</div>


		</div><!--end of container-->
		</body>

		<footer class="footer-default divider"> Yhteystiedot</footer>
		</html>