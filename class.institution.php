<?php
require_once 'class.photo_institution.php';

class Institution
{
	/**
	 * @var int
	 */
	public $id;

	/**
	 * @var string
	 */
	public $nom_institution;

	/**
	 * @var string
	 */
	public $departement;

	/**
	 * @var string
	 */
	public $arrondissement;

	/**
	 * @var string
	 */
	public $commune;

	/**
	 * @var string
	 */
	public $section_rurale;

	/**
	 * @var string
	 */
	public $adresse;

	/**
	 * @var string
	 */
	public $adresse_detail;

	/**
	 * @var string
	 */
	public $telephone;

	/**
	 * @var string
	 */
	public $trouvee;

	/**
	 * @var string
	 */
	public $systeme;

	/**
	 * @var string
	 */
	public $infoBancaire;

	public function __construct($id, $nom_institution, $departement, $arrondissement, $commune, $section_rurale, $adresse, $adresse_detail, $telephone, $trouvee, $systeme, $infoBancaire) {
		$this->id = $id;
		$this->nom_institution = $nom_institution;
		$this->departement = $departement;
		$this->arrondissement = $arrondissement;
		$this->commune = $commune;
		$this->section_rurale = $section_rurale;
		$this->adresse = $adresse;
		$this->adresse_detail = $adresse_detail;
		$this->telephone = $telephone;
		$this->trouvee = $trouvee;
		$this->systeme = $systeme;
		$this->infoBancaire = $infoBancaire;
	}
}



class Institutions extends ArrayObject
{
	public function __construct()
	{
		parent::__construct(array());
	}
	public function offsetSet($index, $newval) {
		if (!($newval instanceof Institution)) {
			throw new InvalidArgumentException('You can only add values of type Institution.');
		}
		parent::offsetSet($index, $newval);
	}
}

?>