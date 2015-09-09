<?php
class Tuote{
	private static $virhelista = array (
			- 1 => "Tuntematon virhe",
			0 => "",
			11 => "Nimi ei voi olla tyhjä",
			12 => "Nimessä tulee olla vain kirjaimia",
			13 => "Nimessä on liian vähän merkkejä",
			14 => "Nimessä on liikaa merkkejä",
			
			21 => "Kategoria ei voi olla tyhjä",
			22 => "Kategoria pitää olla numero",
			
			30 => "Kuva on jo olemassa",
			31 => "Kuvan tulee olla muotoa jpg, png, gif tai jpeg",
			32 => "Kuva on liian suuri.",
			33 => "Kuvan latauksessa sattui jokin virhe",
			34 => "Kuva ladattu onnistuneesti",
			35 => "Tiedosto ei ole kuva",
			
			40 => "Valmistaja ei voi olla tyhjä",
			41 => "Valmistajan nimessä tulee olla vain kirjaimia",
			42 => "Valmistajan nimi on liian lyhyt",
			43=> "Valmistajan nimi on liian pitkä",
			
			
			62 => "Kuvauksessa on liian vähän kirjaimia",
			63 => "Kuvaus on liian pitkä",
			64 => "Kuvauksessa saa käyttää vain numeroita ja kirjaimia",
			
			70 => "Hinta on pakollinen",
			71 => "Hinta on virheellinen, käytä numeroita.",
			72 => "Hinta on liian pieni",
			73 => "Hinta on liian suuri max. 1 000 000&euro;"
	);
    // Attribuutit
private $nimi;
private $valmistaja;
private $hinta;
private $kuva;
private $kategoria;
private $kuvaus;
private $id;

	// Konstruktori
	function __construct($nimi = "", $valmistaja="" , $hinta = "", $kuva = "", $kategoria = null, $kuvaus = "",  $id = 0) {
		$this->nimi = trim ( $nimi );
		$this->valmistaja = trim ($valmistaja);
		$this->setHinta ( $hinta );
		$this->kuva = htmlspecialchars($kuva);
		$this->kategoria = trim ( $kategoria );
		$this->kuvaus = trim ( $kuvaus );
		$this->id = $id;	
	}

	// Metodit 
	
	//nimi
	public function setNimi($nimi) {
		$this->nimi = trim ( $nimi );
	}
	public function getNimi() {
		return $this->nimi;
	}
	public function checkNimi($required = true, $min = 3, $max = 50) {
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->nimi ) == 0) {
			return 0;
		}
	
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->nimi ) == 0) {
			return 11;
		}
	
		// Jos nimen muoto ei ole oikea
		if (preg_match ( "/[^a-zåäöA-ZÅÄÖ\- ]/", $this->nimi )) {
			return 12;
		}
	
		// Jos nimi on liian lyhyt
		if (strlen ( $this->nimi) < $min) {
			return 13;
		}
	
		// Jos nimi on liian pitkä
		if (strlen ( $this->nimi ) > $max) {
			return 14;
		}
	
		// Kentässä ei ole virhettä
		return 0;
	}

	//valmistaja

	public function setValmistaja($valmistaja) {
		$this->valmistaja = trim ( $valmistaja );
	}
	
	public function getValmistaja() {
		return $this->valmistaja;
	}
	
	public function checkValmistaja($required = TRUE, $min = 3, $max = 50){
		
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->valmistaja ) == 0) {
			return 40;
		}
	
		// Jos nimen muoto ei ole oikea
		if (preg_match ( "/[^a-zåäöA-ZÅÄÖ\- ]/", $this->valmistaja )) {
			return 41;
		}
		
		// Jos nimi on liian lyhyt
		if (strlen ( $this->valmistaja) < $min) {
			return 42;
		}
		
		// Jos nimi on liian pitkä
		if (strlen ( $this->valmistaja ) > $max) {
			return 43;
		}
		return 0;
	}
	
	
	// hinta
	public function setHinta($hinta) {
		$this->hinta = trim ( $hinta );
	}
	public function getHinta() {
		return $this->hinta;
	}
	
	// $hintaVirhe = $ilmoitus->checkHinta();
	public function checkHinta($required = true, $min = 0.0, $max = 1000000) {
	
		// Jos saa olla tyhjä ja on tyhjä
		if ($required == false && strlen ( $this->hinta ) == 0) {
			return 0;
		}
	
		// Jos ei saa olla tyhjä ja on tyhjä
		if ($required == true && strlen ( $this->hinta ) == 0) {
			return 70;
		}
	
		// Jos hinnan muoto ei ole oikea
		if (!is_numeric($this->hinta)) {
			return 71;
		}
	
		// Jos hinta on liian pieni
		if ( $this->hinta < $min) {
			return 72;
		}
	
		// Jos hinta on liian suuri
		if ($this->hinta > $max) {
			return 73;
		}
	
		return 0;
	}
	
	// kuva
	public function setKuva($kuva) {
		$this->kuva = ( $kuva );
	}
	public function getKuva() {
		return $this->kuva;
	}
	

public function checkKuva($empty = true) {

	
	$my_folder = "uploads/";
	$target_file = $my_folder . basename($_FILES["kuva"]["name"]);
	$uploadOk = 1;
	
	$extension = pathinfo($target_file, PATHINFO_EXTENSION);
	$actual_name = pathinfo($target_file,PATHINFO_FILENAME);
	$original_name = $actual_name;
	$i = 1;
	
	// (Ei toimi vielä kunnolla...) Jos tiedosto on olemassa, niin loopataan kaikki tiedostot ja etsitään vapaa nimi kuvalle minkä tallentaa.
if (file_exists($target_file)) {
		while(file_exists('uploads/'.$actual_name.".".$extension))
		{
			$actual_name = (string)$original_name.$i;
			$target_file = $actual_name.".".$extension;
			$i++;
		}
		return 30;
		
	}

	
	//check file size
	if ($_FILES['kuva']['size'] > 5000000) {
		return 32;
		$uploadOk = 0;
	}
	
	// Allow certain file formats
	if($extension != "jpg" && $extension != "png" && $extension != "jpeg"
			&& $extension != "gif" ) {
				return 31;
				$uploadOk = 0;
		}
	
	// check if there is error
	if ($uploadOk == 0) {
		return 33;
	}
	else {
		if (move_uploaded_file($_FILES['kuva']['tmp_name'], $my_folder . $_FILES['kuva']['name'])) {
			echo "Kuvan lisäys onnistui!.. /uploads kansioon";
			return 0;
		} else {
			return 33;
	
			var_dump($_FILES['kuva']['error']);
			}
		}
	
	}
	

	// kategoria
	public function setKategoria($kategoria) {
		$this->kategoria = trim ( $kategoria );
	}
	public function getKategoria() {
		return $this->kategoria;
	}
	
	public function checkKategoria($required = false) {
	
		if ($required == true && strlen ( $this->kategoria ) == 0) {
			return 21;
		}
		
		
		if (!is_numeric($this->kategoria)) {
			return 22;
		}
		return 0;
	}
	
	// Kuvaus
	public function setKuvaus($kuvaus) {
		$this->kuvaus = trim ( $kuvaus );
	}
	public function getKuvaus() {
		return $this->kuvaus;
	}
	public function checkKuvaus($required = true, $min = 3, $max = 1000) {
		if ($required == false && strlen ( $this->kuvaus ) == 0) {
			return 0;
		}
	
	/*	if ($required == true && strlen ( $this->kuvaus ) == 0) {
			return 61;
		}*/ //tämä jos halutaan että kuvaus ei voi olla tyhjä
	
		if (strlen ( $this->kuvaus ) < $min) {
			return 62;
		}
	
		if (strlen ( $this->kuvaus ) > $max) {
			return 63;
		}
		
		// Jos kuvauks sisältää vääriä merkkejä
		if (preg_match ( "/[^1-9a-zåäöA-ZÅÄÖ\- ]/", $this->kuvaus )) {
			return 64;
		}
	
		return 0;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}
	
	// Metodilla n�ytet��n virhekoodia vastaava teksti
	public static function getError($virhekoodi) {
		if (isset ( self::$virhelista [$virhekoodi] ))
			return self::$virhelista [$virhekoodi];
		
		return self::$virhelista [- 1];
	}
}
?>