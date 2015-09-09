<?php

require_once 'Tuote.php';

class TuotePDO{
	
	private $db;
	private $lkm;
	
	function __construct($dsn = "mysql:host=localhost;dbname=a1300796", $user = "root", $password = "salainen") {
		// Ota yhteys kantaan
		$this->db = new PDO ( $dsn, $user, $password );
	
		// Virheiden jäljitys kehitysaikana
		$this->db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	
		// MySQL injection estoon (paramerit sidotaan PHP:ssä ennen SQL-palvelimelle lähettämistä)
		$this->db->setAttribute ( PDO::ATTR_EMULATE_PREPARES, false );
	
		// Tulosrivien määrä
		$this->lkm = 0;
	}
	
	// Metodi palauttaa tulosrivien määrän
	function getLkm() {
		return $this->lkm;
	}
	
	public function kaikkiTuotteet() {
		$sql = "SELECT id, nimi, kuvaus, hinta, kuva, kategoria, valmistaja
		        FROM tuote";
		

		// Valmistellaan lause
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
				
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
	
		// Ajetaan lauseke
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
				
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
	
		// Käsittellään hakulausekkeen tulos
		$tulos = array ();
	
		// Pyydetään haun tuloksista kukin rivi kerrallaan
		while ( $row = $stmt->fetchObject () ) {
			// Tehdään tietokannasta haetusta rivistä tuote-luokan olio
			$tuote = new Tuote();
				
			$tuote->setId ( $row->id );
			$tuote->setNimi ( utf8_encode ( $row->nimi ) );
			$tuote->setKuvaus( utf8_encode ( $row->kuvaus ) );
			$tuote->setHinta( $row->hinta );
			$tuote->setKategoria( $row->kategoria );
			$tuote->setKuva ( utf8_encode ( $row->kuva ) );
			$tuote->setValmistaja(utf8_encode($row->valmistaja));
			
			// Laitetaan olio tulos taulukkoon (olio-taulukkoon)
			$tulos [] = $tuote;
		}
	
		$this->lkm = $stmt->rowCount ();
	
		return $tulos;
	}
	
	function tuoteLisays($tuote){
		//tehdään sql insertti lause
		$sql = "INSERT INTO `tuote` (`nimi`, `kuvaus`, `hinta`, `kuva`, `kategoria`, `valmistaja`) VALUES
									(:nimi, :kuvaus, :hinta, :kuva, :kategoria ,:valmistaja)";
		
			// Valmistellaan lause
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();

			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		//sidotaan parametrit 
		
		$stmt->bindValue(":nimi", utf8_decode ($tuote->getNimi () ), PDO::PARAM_STR );
		$stmt->bindValue(":kuvaus", utf8_decode($tuote->getKuvaus() ), PDO::PARAM_STR );
		$stmt->bindValue(":hinta", ($tuote->getHinta() ), PDO::PARAM_INT );
		$stmt->bindValue(":kategoria", ($tuote->getKategoria() ), PDO::PARAM_INT );
		$stmt->bindValue(":kuva", ($tuote->getKuva() ), PDO::PARAM_STR );
		$stmt->bindValue(":valmistaja", utf8_decode($tuote->getValmistaja() ), PDO::PARAM_STR );
	

		// Jotta id:n saa lisäyksestä, täytyy laittaa tapahtumankäsittely päälle
		$this->db->beginTransaction();
				
		// Ajetaan lauseke
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			// Perutaan tapahtuma
			$this->db->rollBack();
				
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		//otetaan id talteen ennen tapahtuman päättymistä. lastInsertId.
		$id = $this->db->lastInsertId();
		
		//lisätään muutokset kantaan
		$this->db->commit();
		//palautetaan id
		return $id;
	}
	
	function tuoteHaku($id){
		
		$sql = "SELECT * FROM tuote WHERE id like :id";
		
		//valmistellaan lause
		if (!$stmt = $this->db->prepare($sql)){
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
			}
			
		//sidotaan parametrit
		$idd = "%" .utf8_decode ($id) . "%";
		$stmt->bindValue(":id", $idd, PDO::PARAM_INT);
		
		//ajetaan lause
		if (!$stmt->execute()){
			$virhe = $stmt->errorInfo();
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		//käsitellään haun tulokset
		
		$haettuTuote = array();
		
		while ($row = $stmt->fetchObject() ){
			// Tehdään tietokannasta haetusta rivistä tuote-luokan olio
			$tuote = new Tuote();
			
			$tuote->setId ( $row->id );
			$tuote->setNimi ( utf8_encode ( $row->nimi ) );
			$tuote->setKuvaus( utf8_encode ( $row->kuvaus ) );
			$tuote->setHinta( $row->hinta );
			$tuote->setKategoria( $row->kategoria );
			$tuote->setKuva ( utf8_encode ( $row->kuva ) );
			$tuote->setValmistaja(utf8_encode($row->valmistaja));
				
			// Laitetaan olio tulos taulukkoon (olio-taulukkoon)
			$haettuTuote[] = $tuote;
		}
		$this->lkm = $stmt->rowCount();
		return $haettuTuote;
	}
	
	function poistaTuote($id){
		$sql = "DELETE FROM tuote WHERE id like :id";
		
		//valmistellaan lause
		if (!$stmt = $this->db->prepare($sql)){
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
			
		//sidotaan parametrit
		$idd = "%" .utf8_decode ($id) . "%";
		$stmt->bindValue(":id", $idd, PDO::PARAM_INT);
		
		//ajetaan lause
		if (!$stmt->execute()){
			$virhe = $stmt->errorInfo();
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
				
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
	}
}

?>