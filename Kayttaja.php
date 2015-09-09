<?php
class Kayttaja{
	
	private $nimi;
	
	// Konstruktori
	function __construct($nimi = "",  $id = 0) {
		$this->nimi = trim ( $nimi );

		$this->id = $id;
	}
	
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