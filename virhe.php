
<article>
<h2>Ongelmia</h2>

<?php
if (isset($_GET["virhe"])) {
	$virhe = $_GET["virhe"];
	@$sivu = $_GET["sivu"];
}
else {
	$virhe = "Tuntematon virhe";
	$sivu = "Eu tieto";
}

print("<p><b>$sivu</b>: $virhe</p>");

?>